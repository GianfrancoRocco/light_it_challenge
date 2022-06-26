<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserDiagnosis;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ApiMedicService 
{
    private int $authTokenValidThrough;
    private array $apiMedicConfig;

    public function __construct()
    {
        $this->apiMedicConfig = config('api-medic');
        $this->authTokenValidThrough = 7200;
    }

    private function getAuthToken(): string
    {
        return Cache::remember('authToken', $this->authTokenValidThrough, function () {
            $loginUrl = $this->apiMedicConfig['authUrl']."login";

            $apiKey = $this->apiMedicConfig['authApiKey'];
            $hashedCredentials = base64_encode(hash_hmac('md5', $loginUrl, $this->apiMedicConfig['authSecretKey'], true));

            $response = Http::withToken("{$apiKey}:{$hashedCredentials}")->post($loginUrl)->throw()->json();

            $this->authTokenValidThrough = $response['ValidThrough'];

            return $response['Token'];
        });
    }

    public function getSymptoms(): mixed
    {
        return Cache::remember('symptoms', 60 * 60 * 12, function () {
            return $this->httpRequest('get', 'symptoms');
        });
    }

    public function getDiagnosis(array $symptoms, User $user): mixed
    {
        $implodedSymptoms = implode(',', $symptoms);
        
        $params = [
            'symptoms' => "[{$implodedSymptoms}]",
            'gender' => $user->gender->description,
            'year_of_birth' => $user->birthdate->format('Y')
        ];

        $response = $this->httpRequest('get', 'diagnosis', $params);

        UserDiagnosis::create(['diagnosis' => $response]);

        return $response;
    }

    private function getEndpointURL(string $endpoint): string
    {
        return "{$this->apiMedicConfig['sandboxUrl']}{$endpoint}";
    }

    private function httpRequest(string $requestType, string $endpoint, array $params = [])
    {
        $defaultParams = [
            'token' => $this->getAuthToken(),
            'language' => $this->apiMedicConfig['lang'],
            'format' => $this->apiMedicConfig['format'],
        ];

        return Http::$requestType($this->getEndpointURL($endpoint), $defaultParams + $params)->throw()->json();
    }
}