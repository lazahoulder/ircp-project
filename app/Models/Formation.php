<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Formation extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'description',
        'entite_emmeteur_id',
        'expiration_year',
        'modele_certificat',
    ];
    public function entiteEmmeteurs(): BelongsTo
    {
        return $this->belongsTo(EntiteEmmeteurs::class, 'entite_emmeteur_id');
    }

    public function formationReels(): HasMany
    {
        return $this->hasMany(FormationReel::class, 'formation_id');
    }
}
