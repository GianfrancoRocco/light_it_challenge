<?php

namespace App\Observers;

use App\Models\UserDiagnosis;

class UserDiagnosisObserver
{
    public function creating(UserDiagnosis $userDiagnosis): void
    {
        $userDiagnosis->user_id = auth()->id();
    }
}
