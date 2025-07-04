<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Model;

class Empenho extends Model
{
    protected $fillable = [
        'quantidade',
        'user_id',
        'cota_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'quantidade' => 'integer',
        'user_id' => 'integer',
        'cota_id' => 'integer',
    ];

    /**
     * The users that belong to the empenho.
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The cota that belongs to the empenho.
     */
    public function cota() : BelongsTo
    {
        return $this->belongsTo(Cota::class);
    }

}
