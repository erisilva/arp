<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Setor extends Model
{
    protected $fillable = [
        'sigla', 'descricao',
    ];

    public function cotas() : HasMany
    {
        return $this->hasMany(Cota::class);
    }

    /**
     * The users that belong to the setor.
     *
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
