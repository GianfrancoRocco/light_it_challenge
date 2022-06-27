<?php

namespace App\Http\Controllers;

use App\Http\Requests\DiagnoseRequest;
use App\Services\ApiMedicService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DiagnosisController extends Controller
{
    private ApiMedicService $apiMedicService;

    public function __construct(ApiMedicService $apiMedicService)
    {
        $this->apiMedicService = $apiMedicService;
    }

    public function index(): View
    {
        return view('diagnosis.index', [
            'symptoms' => $this->apiMedicService->getSymptoms()
        ]);
    }

    public function diagnose(DiagnoseRequest $request): View|RedirectResponse
    {
        $diagnoses = $this->apiMedicService->getDiagnosis($request->get('symptoms'));

        if (!count($diagnoses)) {
            return redirect()->route('diagnosis.index')->withErrors('No diagnoses found based on the selected symptoms');
        }

        return view('diagnosis.result', [
            'diagnoses' => $diagnoses,
            'selectedSymptoms' => $this->apiMedicService->getSelectedSymptoms()
        ]);
    }
}
