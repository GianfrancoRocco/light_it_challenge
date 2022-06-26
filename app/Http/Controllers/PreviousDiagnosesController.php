<?php

namespace App\Http\Controllers;

use App\Models\UserDiagnosis;
use Illuminate\Http\Request;
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
            'diagnoses' => auth()->user()->diagnosesOrderedBy('id', 'desc')
        ]);
    }

    public function edit(UserDiagnosis $userDiagnosis)
    {
        //
    }

    public function update(Request $request, UserDiagnosis $userDiagnosis)
    {
        //
    }
}
