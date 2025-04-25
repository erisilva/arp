<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class ArpView extends Model
{
    protected $casts = [
        'created_at' => 'date',
        'updated_at' => 'date',
        'vigenciaInicio' => 'date',
        'vigenciaFim' => 'date',
    ];


    public function scopeFilter($query, array $filters)
    {
        // start session values if not yet initialized
        if (!session()->exists('arp_arp')){
            session(['arp_arp' => '']);
        }

        if (!session()->exists('arp_pac')){
            session(['arp_pac' => '']);
        }

        if (!session()->exists('arp_pe')){
            session(['arp_pe' => '']);
        }

        if (!session()->exists('arp_vigencia_inicio')){
            session(['arp_vigencia_inicio' => '']);
        }

        if (!session()->exists('arp_vigencia_fim')){
            session(['arp_vigencia_fim' => '']);
        }

        if (!session()->exists('arp_vigencia')){
            session(['arp_vigencia' => '']);
        }

        if (!session()->exists('arp_sigma')){
            session(['arp_sigma' => '']);
        }

        if (!session()->exists('arp_objeto')){
            session(['arp_objeto' => '']);
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

        if (Arr::exists($filters, 'vigencia_inicio')) {
            session(['arp_vigencia_inicio' => $filters['vigencia_inicio'] ?? '']);
        }

        if (Arr::exists($filters, 'vigencia_fim')) {
            session(['arp_vigencia_fim' => $filters['vigencia_fim'] ?? '']);
        }

        if (Arr::exists($filters, 'vigencia')) {
            session(['arp_vigencia' => $filters['vigencia'] ?? '']);
        }

        if (Arr::exists($filters, 'sigma')) {
            session(['arp_sigma' => $filters['sigma'] ?? '']);
        }

        if (Arr::exists($filters, 'objeto')) {
            session(['arp_objeto' => $filters['objeto'] ?? '']);
        }


        // filter the query

        if (trim(session()->get('arp_arp')) !== '') {
            $query->where('arp', 'like', '%' . session()->get('arp_arp') . '%');
        }

        if (trim(session()->get('arp_pac')) !== '') {
            $query->where('pac', 'like', '%' . session()->get('arp_pac') . '%');
        }

        if (trim(session()->get('arp_pe')) !== '') {
            $query->where('pe', 'like', '%' . session()->get('arp_pe') . '%');
        }

        # the filter has to have both dates for overlaping
        if (trim(session()->get('arp_vigencia_inicio')) !== '' && trim(session()->get('arp_vigencia_fim')) !== '') {
            //dd(trim(session()->get('licenca_data_inicio')));
            $query->where(function ($query) {
                $query->where(function ($query) {
                    $query->where('vigenciaInicio', '>=',  date('Y-m-d', strtotime(str_replace('/', '-', session()->get('arp_vigencia_inicio')))))
                          ->where('vigenciaInicio', '<=',  date('Y-m-d', strtotime(str_replace('/', '-', session()->get('arp_vigencia_fim')))));
                })
                ->orWhere(function ($query) {
                    $query->where('vigenciaFim', '>=',  date('Y-m-d', strtotime(str_replace('/', '-', session()->get('arp_vigencia_inicio')))))
                          ->where('vigenciaFim', '<=',  date('Y-m-d', strtotime(str_replace('/', '-', session()->get('arp_vigencia_fim')))));
                })
                ->orWhere(function ($query) {
                    $query->where('vigenciaInicio', '<=',  date('Y-m-d', strtotime(str_replace('/', '-', session()->get('arp_vigencia_inicio')))))
                          ->where('vigenciaFim', '>=',  date('Y-m-d', strtotime(str_replace('/', '-', session()->get('arp_vigencia_fim')))));
                });
            });
        }

        if (trim(session()->get('arp_vigencia')) !== '') {
            $query->where('vigente', session()->get('arp_vigencia'));
        }

        if (trim(session()->get('arp_sigma')) !== '') {
            $query->where('sigma', 'like', '%' . session()->get('arp_sigma') . '%');
        }

        if (trim(session()->get('arp_objeto')) !== '') {
            $query->where('objeto', 'like', '%' . session()->get('arp_objeto') . '%');
        }



    }
}
