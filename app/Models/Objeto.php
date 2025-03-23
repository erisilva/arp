<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Objeto extends Model
{
    protected $fillable = [
        'sigma', 'descricao',
    ];

    public function items() : HasMany
    {
        return $this->hasMany(Item::class);
    }
}
