<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    protected $fillable = ['arp_id', 'objeto_id'];

    public function arp() : BelongsTo
    {
        return $this->belongsTo(Arp::class);
    }

    public function objeto() : BelongsTo
    {
        return $this->belongsTo(Objeto::class);
    }

    public function cotas() : HasMany
    {
        return $this->hasMany(Cota::class);
    }


}
