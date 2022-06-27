<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\ApiMedicService;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class ApiMedicServiceTest extends TestCase
{
    private ApiMedicService $apiMedicService;

    public function setUp(): void
    {
        parent::setUp();

        $this->apiMedicService = new ApiMedicService();
        Artisan::call('migrate --seed');
    }

    public function test_get_symptoms()
    {
        $symptoms = $this->apiMedicService->getSymptoms();
        $this->assertIsArray($symptoms);
        $this->assertNotEmpty($symptoms);
    }

    public function test_get_diagnosis()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $symptoms = [];

        do {
            $symptoms = collect($this->apiMedicService->getSymptoms())->random(2);

            $diagnosis = $this->apiMedicService->getDiagnosis($symptoms->pluck('ID')->toArray());
        } while (!count($diagnosis));

        $this->assertIsArray($diagnosis);
        $this->assertNotEmpty($diagnosis);
        $this->assertDatabaseHas('user_diagnosis', [
            'selected_symptoms' => json_encode($symptoms),
            'diagnosis' => json_encode($diagnosis),
            'user_id' => $user->id
        ]);
    }
}
