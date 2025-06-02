<?php

namespace App\Listeners;

use App\Events\RegisterProceced;
use App\Models\EntiteEmmeteurs;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class RegisterProcecedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(RegisterProceced $event): void
    {
        $entite = $event->data;
        if ($entite instanceof EntiteEmmeteurs) {
            $user = Auth::user();
            $user->entiteEmmeteur()->associate($entite);
            $user->save();
        }
    }
}
