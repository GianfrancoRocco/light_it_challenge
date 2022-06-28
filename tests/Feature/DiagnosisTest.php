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
    private array $diagnosis;
    private $symptoms;

    public function setUp(): void
    {
        parent::setUp();

        $this->apiMedicService = new ApiMedicService();
        $this->symptoms = [];
        $this->diagnosis = [];

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

        $this->getSymptomsResultingInSuccessfulDiagnosis();

        $response = $this->actingAs($user)
        ->post(route('diagnosis.diagnose', [
            'symptoms' => $this->symptoms->pluck('ID')->toArray()
        ]));

        $response->assertOk()
        ->assertViewIs('diagnosis.result')
        ->assertViewHasAll([
            'selectedSymptoms' => $this->symptoms->toArray(),
            'diagnoses' => $this->diagnosis
        ]);

        $this->assertDatabaseHas('user_diagnosis', [
            'selected_symptoms' => json_encode($this->symptoms),
            'diagnosis' => json_encode($this->diagnosis),
            'user_id' => $user->id
        ]);
    }

    public function test_unsuccessful_diagnosis()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $this->getSymptomsResultingInUnsuccessfulDiagnosis();

        $response = $this->actingAs($user)
        ->post(route('diagnosis.diagnose', [
            'symptoms' => $this->symptoms->pluck('ID')->toArray()
        ]));

        $response->assertRedirect(route('diagnosis.index'))
        ->assertSessionHasErrors();

        $this->assertDatabaseMissing('user_diagnosis', [
            'selected_symptoms' => json_encode($this->symptoms),
            'diagnosis' => json_encode($this->diagnosis),
            'user_id' => $user->id
        ]);
    }

    public function test_can_render_previous_diagnoses_view_when_having_a_previous_diagnoses()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $this->getSymptomsResultingInSuccessfulDiagnosis();

        $this->post(route('diagnosis.diagnose', [
            'symptoms' => $this->symptoms->pluck('ID')->toArray()
        ]));

        $this->assertDatabaseHas('user_diagnosis', [
            'selected_symptoms' => json_encode($this->symptoms),
            'diagnosis' => json_encode($this->diagnosis),
            'user_id' => $user->id
        ]);

        $response = $this->get(route('previous-diagnoses.index'));

        $response->assertOk()
        ->assertViewIs('previous-diagnoses.index')
        ->assertViewHas('diagnoses');
    }

    public function test_can_render_previous_diagnoses_view_but_doesnt_have_previous_diagnoses()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get(route('previous-diagnoses.index'));

        $response->assertOk()
        ->assertViewIs('previous-diagnoses.index')
        ->assertSee('No previous diagnoses found');
    }

    private function getSymptomsResultingInSuccessfulDiagnosis(): void
    {
        /**
         * Since some combination of symptoms result in an empty diagnosis, we perform a while loop
         * to search for a combination of symptoms that does result in a non empty diagnosis
         */
        do {
            $this->symptoms = collect($this->apiMedicService->getSymptoms())->random(2);

            $this->diagnosis = $this->apiMedicService->getDiagnosis($this->symptoms->pluck('ID')->toArray());
        } while (!count($this->diagnosis));
    }

    private function getSymptomsResultingInUnsuccessfulDiagnosis(): void
    {
        /**
         * Contrary to getSymptomsResultingInSuccessfulDiagnosis method, in this case we loop for a 
         * combination of symptoms that does NOT result in a diagnosis so that way we get an error
         * when making a post request to get a diagnosis
         */
        do {
            $this->symptoms = collect($this->apiMedicService->getSymptoms())->random(2);

            $this->diagnosis = $this->apiMedicService->getDiagnosis($this->symptoms->pluck('ID')->toArray());
        } while (count($this->diagnosis));
    }
}
