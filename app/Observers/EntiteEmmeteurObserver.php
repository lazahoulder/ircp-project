<?php

namespace App\Observers;

use App\Constant\EntiteEmmeteursConstant;
use App\Models\EntiteEmmeteurs;

class EntiteEmmeteurObserver
{
    /**
     * Handle the EntiteEmmeteur "created" event.
     */
    public function creating(EntiteEmmeteurs $entiteEmmeteur): void
    {
        $entiteEmmeteur->setupStatus();
    }

    /**
     * Handle the EntiteEmmeteur "updated" event.
     */
    public function updating(EntiteEmmeteurs $entiteEmmeteur): void
    {
        $entiteEmmeteur->setupStatus();
    }

    /**
     * Handle the EntiteEmmeteur "deleted" event.
     */
    public function deleted(EntiteEmmeteur $entiteEmmeteur): void
    {
        //
    }

    /**
     * Handle the EntiteEmmeteur "restored" event.
     */
    public function restored(EntiteEmmeteur $entiteEmmeteur): void
    {
        //
    }

    /**
     * Handle the EntiteEmmeteur "force deleted" event.
     */
    public function forceDeleted(EntiteEmmeteur $entiteEmmeteur): void
    {
        //
    }
}
