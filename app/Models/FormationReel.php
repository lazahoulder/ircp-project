<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormationReel extends Model
{
    use HasFactory;

    protected $fillable = [
        'formation_id',
        'date_debut',
        'date_fin',
        'participants_file',
    ];

    public function formation(): BelongsTo
    {
        return $this->belongsTo(Formation::class, 'formation_id');
    }
}
