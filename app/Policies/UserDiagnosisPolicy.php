<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserDiagnosis;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserDiagnosisPolicy
{
    use HandlesAuthorization;

    public function view(User $user, UserDiagnosis $userDiagnosis)
    {
        return $userDiagnosis->user_id == $user->id;
    }

    public function update(User $user, UserDiagnosis $userDiagnosis)
    {
        return $userDiagnosis->user_id == $user->id;
    }
}
