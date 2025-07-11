<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Mapa extends Model
{
    protected $casts = [
        'created_at' => 'date',
        'updated_at' => 'date',
        'vigenciaInicio' => 'date',
        'vigenciaFim' => 'date',
    ];


    public function scopeFilter($query, array $filters)
    {
        // mostrando somente os setores que o usuario logado possui acesso
        $query->whereIn('setor_id', auth()->user()->setors->pluck('id'));

        // start session values if not yet initialized
        if (!session()->exists('mapa_arp')){
            session(['mapa_arp' => '']);
        }

        if (!session()->exists('mapa_pac')){
            session(['mapa_pac' => '']);
        }

        if (!session()->exists('mapa_pe')){
            session(['mapa_pe' => '']);
        }

        if (!session()->exists('mapa_vigencia_inicio')){
            session(['mapa_vigencia_inicio' => '']);
        }

        if (!session()->exists('mapa_vigencia_fim')){
            session(['mapa_vigencia_fim' => '']);
        }

        if (!session()->exists('mapa_vigencia')){
            session(['mapa_vigencia' => '']);
        }

        if (!session()->exists('mapa_sigma')){
            session(['mapa_sigma' => '']);
        }

        if (!session()->exists('mapa_objeto')){
            session(['mapa_objeto' => '']);
        }

        if (!session()->exists('mapa_setor')){
            session(['mapa_setor' => '']);
        }

        // update session values if the request has a value

        if (Arr::exists($filters, 'arp')) {
            session(['mapa_arp' => $filters['arp'] ?? '']);
        }

        if (Arr::exists($filters, 'pac')) {
            session(['mapa_pac' => $filters['pac'] ?? '']);
        }

        if (Arr::exists($filters, 'pe')) {
            session(['mapa_pe' => $filters['pe'] ?? '']);
        }

        if (Arr::exists($filters, 'vigencia_inicio')) {
            session(['mapa_vigencia_inicio' => $filters['vigencia_inicio'] ?? '']);
        }

        if (Arr::exists($filters, 'vigencia_fim')) {
            session(['mapa_vigencia_fim' => $filters['vigencia_fim'] ?? '']);
        }

        if (Arr::exists($filters, 'vigencia')) {
            session(['mapa_vigencia' => $filters['vigencia'] ?? '']);
        }

        if (Arr::exists($filters, 'sigma')) {
            session(['mapa_sigma' => $filters['sigma'] ?? '']);
        }

        if (Arr::exists($filters, 'objeto')) {
            session(['mapa_objeto' => $filters['objeto'] ?? '']);
        }

        if (Arr::exists($filters, 'setor')) {
            session(['mapa_setor' => $filters['setor'] ?? '']);
        }

        // filter the query

        if (trim(session()->get('mapa_arp')) !== '') {
            $query->where('arp', 'like', '%' . session()->get('mapa_arp') . '%');
        }

        if (trim(session()->get('mapa_pac')) !== '') {
            $query->where('pac', 'like', '%' . session()->get('mapa_pac') . '%');
        }

        if (trim(session()->get('mapa_pe')) !== '') {
            $query->where('pe', 'like', '%' . session()->get('mapa_pe') . '%');
        }

        # the filter has to have both dates for overlaping
        if (trim(session()->get('mapa_vigencia_inicio')) !== '' && trim(session()->get('mapa_vigencia_fim')) !== '') {
            //dd(trim(session()->get('licenca_data_inicio')));
            $query->where(function ($query) {
                $query->where(function ($query) {
                    $query->where('vigenciaInicio', '>=',  date('Y-m-d', strtotime(str_replace('/', '-', session()->get('mapa_vigencia_inicio')))))
                          ->where('vigenciaInicio', '<=',  date('Y-m-d', strtotime(str_replace('/', '-', session()->get('mapa_vigencia_fim')))));
                })
                ->orWhere(function ($query) {
                    $query->where('vigenciaFim', '>=',  date('Y-m-d', strtotime(str_replace('/', '-', session()->get('mapa_vigencia_inicio')))))
                          ->where('vigenciaFim', '<=',  date('Y-m-d', strtotime(str_replace('/', '-', session()->get('mapa_vigencia_fim')))));
                })
                ->orWhere(function ($query) {
                    $query->where('vigenciaInicio', '<=',  date('Y-m-d', strtotime(str_replace('/', '-', session()->get('mapa_vigencia_inicio')))))
                          ->where('vigenciaFim', '>=',  date('Y-m-d', strtotime(str_replace('/', '-', session()->get('mapa_vigencia_fim')))));
                });
            });
        }

        if (trim(session()->get('mapa_vigencia')) !== '') {
            $query->where('vigente', session()->get('mapa_vigencia'));
        }

        if (trim(session()->get('mapa_sigma')) !== '') {
            $query->where('sigma', 'like', '%' . session()->get('mapa_sigma') . '%');
        }

        if (trim(session()->get('mapa_objeto')) !== '') {
            $query->where('objeto', 'like', '%' . session()->get('mapa_objeto') . '%');
        }

        if (trim(session()->get('mapa_setor')) !== '') {
            $query->where('setor', 'like', '%' . session()->get('mapa_setor') . '%');
        }

    }
}
