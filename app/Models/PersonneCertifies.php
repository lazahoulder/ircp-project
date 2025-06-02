<?php

namespace App\Models;

use App\Models\Trait\HasInitialsTrait;
use Database\Factories\PersonneCertifiesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PersonneCertifies extends Model
{
    /** @use HasFactory<PersonneCertifiesFactory> */
    use HasFactory;
    use HasInitialsTrait;

    protected $fillable = [
        'nom',
        'prenom',
        'date_naissance',
        'adresse',
        'image_id',
    ];

    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class, 'image_id');
    }

    public function getNames(): string
    {
        return $this->nom.' '.$this->prenom;
    }
}
