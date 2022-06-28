<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiMedicException;
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
        $errorMessage = '';

        try {
            return view('diagnosis.index', [
                'symptoms' => $this->apiMedicService->getSymptoms()
            ]);
        } catch (ApiMedicException $e) {
            $errorMessage = $e->getMessage();
        } catch (\Throwable $e) {
            $errorMessage = 'An error occured while fetching the symptoms';
        }

        return view('diagnosis.index')->withErrors($errorMessage);
    }

    public function diagnose(DiagnoseRequest $request): View|RedirectResponse
    {
        $errorMessage = '';

        try {
            $diagnosis = $this->apiMedicService->getDiagnosis($request->get('symptoms'));
    
            if (!count($diagnosis)) {
                throw new ApiMedicException('No diagnosis found based on the selected symptoms');
            }

            return view('diagnosis.result', [
                'diagnosis' => $diagnosis,
                'selectedSymptoms' => $this->apiMedicService->getSelectedSymptoms()
            ]);
        } catch (ApiMedicException $e) {
            $errorMessage = $e->getMessage();
        } catch (\Throwable $e) {
            $errorMessage = 'An error occured while getting the diagnosis';
        }

        return redirect()->route('diagnosis.index')->withErrors($errorMessage);
    }
}
