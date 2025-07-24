<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\Component;

class ParticipantList extends Component
{
    public array $additionalHeaders = [];

    /**
     * Create a new component instance.
     */
    public function __construct(public LengthAwarePaginator $participants)
    {
        $firtsParticipant = $this->participants->first();
        if ($firtsParticipant) {
            $this->additionalHeaders = array_keys($firtsParticipant->formation_data);
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.participant-list');
    }
}
