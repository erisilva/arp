<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    protected $fillable = [
        'descricao',
        'resultado',
        'data', // vou converter o excel para json e salvar aqui, não vou salvar o arquivo excel
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
