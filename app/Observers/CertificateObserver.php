<?php

namespace App\Observers;

use App\Constant\CertificateConstant;
use App\Models\Certificate;

class CertificateObserver
{
    public function creating(Certificate $certificates)
    {
        if ($certificates->status === null) {
            $certificates->status = CertificateConstant::STATUS_INCOMPLET;
        }
        $certificates->setupStatus();
    }

    /**
     * Handle the Certificates "updating" event.
     */
    public function updating(Certificate $certificates): void
    {
        $certificates->setupStatus();
    }

    /**
     * Handle the Certificates "updated" event.
     */
    public function updated(Certificate $certificates): void
    {
        //
    }

    /**
     * Handle the Certificates "deleted" event.
     */
    public function deleted(Certificate $certificates): void
    {
        //
    }

    /**
     * Handle the Certificates "restored" event.
     */
    public function restored(Certificate $certificates): void
    {
        //
    }

    /**
     * Handle the Certificates "force deleted" event.
     */
    public function forceDeleted(Certificate $certificates): void
    {
        //
    }
}
