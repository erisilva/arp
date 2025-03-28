<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Setor extends Model
{
    protected $fillable = [
        'sigla', 'descricao',
    ];

    public function cotas() : HasMany
    {
        return $this->hasMany(Cota::class);
    }
}
