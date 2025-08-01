<?php

namespace App\Models;

use App\Constant\CertificateConstant;
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
        'status',
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

    /**
     * @param EntiteEmmeteurs $entiteEmmeteur
     * @return void
     */
    public function setupStatus(): void
    {
        if (in_array($this->status, [CertificateConstant::STATUS_EN_ATTENTE, CertificateConstant::STATUS_INCOMPLET])) {
            $this->status = CertificateConstant::STATUS_EN_ATTENTE;
            if (!$this->getImage()) {
                $this->status = CertificateConstant::STATUS_INCOMPLET;
            }
        } else {
            $this->status = CertificateConstant::STATUS_VALID;
        }
    }

    public function getStatusTextColor()
    {
        if (CertificateConstant::STATUS_VALID === $this->status) {
            return 'text-green-500';
        }

        if (CertificateConstant::STATUS_EN_ATTENTE === $this->status) {
            return 'text-yellow-500';
        }

        return 'text-red-500';
    }
}
