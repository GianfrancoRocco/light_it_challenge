<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Diagnosis extends Component
{
    public array $diagnosis;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(array $diagnosis)
    {
        $this->diagnosis = $diagnosis;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.diagnosis');
    }
}
