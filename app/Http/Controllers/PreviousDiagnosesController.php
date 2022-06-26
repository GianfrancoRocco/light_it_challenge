<?php

namespace App\Http\Controllers;

use App\Models\UserDiagnosis;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PreviousDiagnosesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        return view('previous-diagnoses.index', [
            'diagnoses' => auth()->user()->diagnosesOrderedBy('id', 'desc')->paginate()
        ]);
    }

    public function show(UserDiagnosis $userDiagnosis): View
    {
        $this->authorize('view', $userDiagnosis);

        return view('previous-diagnoses.show', [
            'userDiagnosis' => $userDiagnosis
        ]);
    }

    public function markAsCorrect(UserDiagnosis $userDiagnosis): RedirectResponse
    {
        $this->authorize('update', $userDiagnosis);

        $userDiagnosis->update(['marked_as_correct' => true]);

        return redirect()->back();
    }
}
