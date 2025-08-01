<?php

namespace App\Models;

use App\Constant\EntiteEmmeteursConstant;
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

    public function getStatusTextColor()
    {
        if (EntiteEmmeteursConstant::STATUS_VALID === $this->status) {
            return 'text-green-500';
        }

        if (EntiteEmmeteursConstant::STATUS_EN_ATTENTE === $this->status) {
            return 'text-yellow-500';
        }

        return 'text-red-500';
    }

    /**
     * @return void
     */
    public function setupStatus(): void
    {
        if (!$this->status) {
            $this->status = EntiteEmmeteursConstant::STATUS_INCOMPLET;
        } elseif (in_array($this->status, [EntiteEmmeteursConstant::STATUS_EN_ATTENTE, EntiteEmmeteursConstant::STATUS_INCOMPLET])) {
            $this->status = EntiteEmmeteursConstant::STATUS_EN_ATTENTE;
            if (!$this->adresse) {
                $this->status = EntiteEmmeteursConstant::STATUS_INCOMPLET;
            }

            if (!$this->date_creation) {
                $this->status = EntiteEmmeteursConstant::STATUS_INCOMPLET;
            }

            if (!$this->nif) {
                $this->status = EntiteEmmeteursConstant::STATUS_INCOMPLET;
            }

            if (!$this->stat) {
                $this->status = EntiteEmmeteursConstant::STATUS_INCOMPLET;
            }

            return;
        } else {
            $this->status = EntiteEmmeteursConstant::STATUS_VALID;
        }
    }
}
