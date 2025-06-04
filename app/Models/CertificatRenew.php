<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CertificatRenew extends Model
{
    public function certificates(): BelongsTo
    {
        return $this->belongsTo(Certificate::class, 'certificat_id');
    }
}
