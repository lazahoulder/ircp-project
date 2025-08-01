<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\Component;

class Certificate extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public LengthAwarePaginator $certificates)
    {
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.certificate');
    }
}
