<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\ApiMedicService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class DiagnosisTest extends TestCase
{
    use RefreshDatabase;

    private ApiMedicService $apiMedicService;

    public function setUp(): void
    {
        parent::setUp();

        $this->apiMedicService = new ApiMedicService();
        Artisan::call('db:seed', [
            'class' => 'GendersSeeder'
        ]);
    }

    public function test_can_render_diagnosis_view()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
        ->get(route('diagnosis.index'));

        $response->assertOk()
        ->assertViewIs('diagnosis.index')
        ->assertViewHas('symptoms', $this->apiMedicService->getSymptoms());
    }

    public function test_successful_diagnosis()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $symptoms = [];

        $diagnosis = [];

        /**
         * Since some combination of symptoms result in an empty diagnosis, we perform a while loop
         * to search for a combination of symptoms that does result in a non empty diagnosis
         */
        do {
            $symptoms = collect($this->apiMedicService->getSymptoms())->random(2);

            $diagnosis = $this->apiMedicService->getDiagnosis($symptoms->pluck('ID')->toArray());
        } while (!count($diagnosis));

        $response = $this->actingAs($user)
        ->post(route('diagnosis.diagnose', [
            'symptoms' => $symptoms->pluck('ID')->toArray()
        ]));

        $response->assertOk()
        ->assertViewIs('diagnosis.result')
        ->assertViewHasAll([
            'selectedSymptoms' => $symptoms->toArray(),
            'diagnoses' => $diagnosis
        ]);

        $this->assertDatabaseHas('user_diagnosis', [
            'selected_symptoms' => json_encode($symptoms),
            'diagnosis' => json_encode($diagnosis),
            'user_id' => $user->id
        ]);
    }

    public function test_unsuccessful_diagnosis()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $symptoms = [];

        $diagnosis = [];

        /**
         * Contrary to the successful diagnosis test, in this case we loop for a combination of symptoms that
         * does NOT result in a diagnosis so that way we can, on purpuse, get an error
         */
        do {
            $symptoms = collect($this->apiMedicService->getSymptoms())->random(5);

            $diagnosis = $this->apiMedicService->getDiagnosis($symptoms->pluck('ID')->toArray());
        } while (count($diagnosis));

        $response = $this->actingAs($user)
        ->post(route('diagnosis.diagnose', [
            'symptoms' => $symptoms->pluck('ID')->toArray()
        ]));

        $response->assertRedirect(route('diagnosis.index'))
        ->assertSessionHasErrors();

        $this->assertDatabaseMissing('user_diagnosis', [
            'selected_symptoms' => json_encode($symptoms),
            'diagnosis' => json_encode($diagnosis),
            'user_id' => $user->id
        ]);
    }
}
