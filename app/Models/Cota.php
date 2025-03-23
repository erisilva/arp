<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cota extends Model
{
    protected $fillable = [
        'quantidade',
        'setor_id',
        'item_id',
    ];

    protected $casts = [
        'created_at'=> 'date'
        ];

    public function setor() : BelongsTo
    {
        return $this->belongsTo(Setor::class);
    }

    public function item() : BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
