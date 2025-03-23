<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Support\Arr;


class Arp extends Model
{
    protected $fillable = [
        'arp',
        'pac',
        'pe',
        'vigenciaInicio',
        'vigenciaFim',
        'notas',
    ];

    protected $casts = [
        'created_at' => 'date',
        'updated_at' => 'date',
        'vigenciaInicio' => 'date',
        'vigenciaFim' => 'date',
    ];

    public function items() : HasMany
    {
        return $this->hasMany(Item::class);
    }

    public function scopeFilter($query, array $filters): void
    {
        // start session values if not yet initialized
        if (!session()->exists('arp_arp')) {
            session(['arp_arp' => '']);
        }
        if (!session()->exists('arp_pac')) {
            session(['arp_pac' => '']);
        }
        if (!session()->exists('arp_pe')) {
            session(['arp_pe' => '']);
        }
        if (!session()->exists('arp_vigenciaInicio')) {
            session(['arp_vigenciaInicio' => '']);
        }
        if (!session()->exists('arp_vigenciaFim')) {
            session(['arp_vigenciaFim' => '']);
        }

        // update session values if the request has a value
        if (Arr::exists($filters, 'arp')) {
            session(['arp_arp' => $filters['arp'] ?? '']);
        }

        if (Arr::exists($filters, 'pac')) {
            session(['arp_pac' => $filters['pac'] ?? '']);
        }

        if (Arr::exists($filters, 'pe')) {
            session(['arp_pe' => $filters['pe'] ?? '']);
        }

        if (Arr::exists($filters, 'vigenciaInicio')) {
            session(['arp_vigenciaInicio' => $filters['vigenciaInicio'] ?? '']);
        }

        if (Arr::exists($filters, 'vigenciaFim')) {
            session(['arp_vigenciaFim' => $filters['vigenciaFim'] ?? '']);
        }

        // query if session filters are not empty
        if (trim(session()->get('arp_arp')) !== '') {
            $query->where('arp', 'like', '%' . session()->get('arp_arp') . '%');
        }

        if (trim(session()->get('arp_pac')) !== '') {
            $query->where('pac', 'like', '%' . session()->get('arp_pac') . '%');
        }

        if (trim(session()->get('arp_pe')) !== '') {
            $query->where
            ('pe', 'like', '%' . session()->get('arp_pe') . '%');
        }

        if (trim(session()->get('arp_vigenciaInicio')) !== '') {
            $query->where('vigenciaInicio', 'like', '%' . session()->get('arp_vigenciaInicio') . '%');
        }

        if (trim(session()->get('arp_vigenciaFim')) !== '') {
            $query->where('vigenciaFim', 'like', '%' . session()->get('arp_vigenciaFim') . '%');
        }


        // the filter has to have both dates for overlaping
        if (trim(session()->get('arp_vigenciaInicio')) !== '' && trim(session()->get('arp_vigenciaFim')) !== '') {
            //dd(trim(session()->get('arp_vigenciaInicio')));
            $query->where(function ($query) {
                $query->where(function ($query) {
                    $query->where('vigenciaInicio', '>=', date('Y-m-d', strtotime(str_replace('/', '-', session()->get('arp_vigenciaInicio')))))
                        ->where('vigenciaInicio', '<=', date('Y-m-d', strtotime(str_replace('/', '-', session()->get('arp_vigenciaFim')))));
                })
                    ->orWhere(function ($query) {
                        $query->where('vigenciaFim', '>=', date('Y-m-d', strtotime(str_replace('/', '-', session()->get('arp_vigenciaInicio')))))
                            ->where('vigenciaFim', '<=', date('Y-m-d', strtotime(str_replace('/', '-', session()->get('arp_vigenciaFim')))));
                    })
                    ->orWhere(function ($query) {
                        $query->where('vigenciaInicio', '<=', date('Y-m-d', strtotime(str_replace('/', '-', session()->get('arp_vigenciaInicio')))))
                            ->where('vigenciaFim', '>=', date('Y-m-d', strtotime(str_replace('/', '-', session()->get('arp_vigenciaFim')))));
                    });
            });
        }

    }
}
