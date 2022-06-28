<?php

namespace App\Services;

use App\Exceptions\ApiMedicException;
use App\Models\UserDiagnosis;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ApiMedicService 
{
    private int $authTokenValidThrough;
    private array $apiMedicConfig, $selectedSymptoms;

    public function __construct()
    {
        $this->apiMedicConfig = config('api-medic');
        $this->authTokenValidThrough = 7200;
        $this->selectedSymptoms = [];
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
        /**
         * We cache the symptoms only for 12hs just in case new symptoms get added in the
         * span of time that goes by from when the symptoms are cached to 12hs later.
         */

        return Cache::remember('symptoms', 60 * 60 * 12, function () {
            return $this->httpRequest('get', 'symptoms');
        });
    }

    public function getDiagnosis(array $symptoms): mixed
    {
        $user = auth()->user();

        $implodedSymptoms = implode(',', $symptoms);
        
        $params = [
            'symptoms' => "[{$implodedSymptoms}]",
            'gender' => $user->gender->description,
            'year_of_birth' => $user->birthdate->format('Y')
        ];

        $response = $this->httpRequest('get', 'diagnosis', $params);

        if (count($response)) {
            $this->selectedSymptoms = collect($this->getSymptoms())
            ->filter(fn ($symptom) => in_array($symptom['ID'], $symptoms))
            ->values()
            ->toArray();

            UserDiagnosis::create([
                'selected_symptoms' => $this->selectedSymptoms,
                'diagnosis' => $response,
            ]);
        }

        return $response;
    }

    public function getSelectedSymptoms(): array
    {
        return $this->selectedSymptoms;
    }

    private function getEndpointURL(string $endpoint): string
    {
        return "{$this->apiMedicConfig['sandboxUrl']}{$endpoint}";
    }

    private function httpRequest(string $requestType, string $endpoint, array $params = [])
    {
        $this->checkIfConfigIsSet();

        $defaultParams = [
            'token' => $this->getAuthToken(),
            'language' => $this->apiMedicConfig['lang'],
            'format' => $this->apiMedicConfig['format'],
        ];

        return Http::$requestType($this->getEndpointURL($endpoint), $defaultParams + $params)->throw()->json();
    }

    private function checkIfConfigIsSet()
    {
        if (
            empty($this->apiMedicConfig['authUrl'])
            || empty($this->apiMedicConfig['authApiKey'])
            || empty($this->apiMedicConfig['authSecretKey'])
            || empty($this->apiMedicConfig['sandboxUrl'])
            || empty($this->apiMedicConfig['format'])
            || empty($this->apiMedicConfig['lang'])
        ) {
            throw new ApiMedicException("There's missing data in config file");
        }
    }
}