<?php

namespace App\Observers;

use App\Models\Gender;
use Illuminate\Support\Facades\Cache;

class GenderObserver
{
    public function created(Gender $gender)
    {
        $this->forgetCached();
    }

    public function updated(Gender $gender)
    {
        $this->forgetCached();
    }
    
    public function deleted(Gender $gender)
    {
        $this->forgetCached();
    }

    private function forgetCached(): void
    {
        Cache::forget('genders');
    }
}
