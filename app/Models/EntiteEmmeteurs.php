<?php

namespace App\Models;

use App\Models\Trait\HasInitialsTrait;
use Database\Factories\EntiteEmmeteursFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EntiteEmmeteurs extends Model
{
    /** @use HasFactory<EntiteEmmeteursFactory> */
    use HasFactory;

    use HasInitialsTrait;

    protected $fillable = [
        'nomination',
        'adresse',
        'date_creation',
        'nif',
        'stat',
        'status'
    ];

    public function personneCertifies(): HasMany
    {
        return $this->hasMany(PersonneCertifies::class);
    }

    public function getNames(): string
    {
        return $this->nomination;
    }

    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class, 'image_id');
    }

    public function formations(): HasMany
    {
        return $this->hasMany(Formation::class, 'entite_emmeteur_id');
    }
}
