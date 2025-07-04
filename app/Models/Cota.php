<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cota extends Model
{
    protected $fillable = [
        'quantidade',
        'empenho',
        'setor_id',
        'item_id',
    ];

    protected $casts = [
        'created_at' => 'date'
    ];

    public function setor(): BelongsTo
    {
        return $this->belongsTo(Setor::class);
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * Get the cota empenhos.
     *
     */
    public function empenhos() : HasMany
    {
        return $this->hasMany(Empenho::class);
    }

}
