<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Certificate extends Model
{
    /** @uses HasFactory<CertificateFactory> */
    use HasFactory;

    protected $fillable = [
        'numero_certificat',
        'formation_reel_id',
        'personne_certifies_id',
        'date_certification',
        'formation_data',
        'qrcode_url',
        'image_id',
    ];

    protected $casts = [
        'formation_data' => 'array',
    ];

    public function formationReel(): BelongsTo
    {
        return $this->belongsTo(FormationReel::class, 'formation_reel_id');
    }

    public function personneCertifies(): BelongsTo
    {
        return $this->belongsTo(PersonneCertifies::class, 'personne_certifies_id');
    }

    public function certificatRenew(): HasMany
    {
        return $this->hasMany(CertificatRenew::class, 'certificat_id');
    }

    public function getNomAttribute()
    {
        return $this->personneCertifies->nom;
    }

    public function getPrenomAttribute()
    {
        return $this->personneCertifies->prenom;
    }

    public function getEntiteEmmeteurs()
    {
        return $this->formationReel->formation->entiteEmmeteurs;
    }

    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class, 'image_id');
    }

    public function getImage(): ?Image
    {
        return $this->image ?? $this->personneCertifies->image;
    }
}
