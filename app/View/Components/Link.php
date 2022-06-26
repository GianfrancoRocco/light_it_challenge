<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Link extends Component
{
    public string $href;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $href)
    {
        $this->href = $href;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.link');
    }
}
