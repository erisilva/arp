<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Theme extends Model
{
    protected $fillable = [
        'name',
        'description',
        'filename',
    ];

    public function users() : HasMany
    {
        return $this->HasMany(User::class);
    } 

}
