<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Arr;

class Objeto extends Model
{
    protected $fillable = [
        'sigma', 'descricao',
    ];

    public function items() : HasMany
    {
        return $this->hasMany(Item::class);
    }

    /**
     * Filter users by name or email
     *
     */
    public function scopeFilter($query, array $filters) : void
    {
        // start session values if not yet initialized
        if (!session()->exists('permission_sigma')){
            session(['objeto_sigma' => '']);
        }
        if (!session()->exists('permission_descricao')){
            session(['objeto_descricao' => '']);
        }

        // update session values if the request has a value
        if (Arr::exists($filters, 'sigma')) {
            session(['objeto_sigma' => $filters['sigma'] ?? '']);
        }

        if (Arr::exists($filters, 'descricao')) {
            session(['objeto_descricao' => $filters['descricao'] ?? '']);
        }

        // query if session filters are not empty
        if (trim(session()->get('objeto_sigma')) !== '') {
            $query->where('sigma', 'like', '%' . session()->get('objeto_sigma') . '%');
        }

        if (trim(session()->get('objeto_descricao')) !== '') {
            $query->where('descricao', 'like', '%' . session()->get('objeto_descricao') . '%');
        }
    }
}
