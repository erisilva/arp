@extends('layouts.app')

@section('title', 'Mapa')

@section('css-header')
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
@endsection

@section('content')
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="{{ route('mapas.index') }}">Mapa</a>
                </li>
            </ol>
        </nav>

        <x-flash-message status='success' message='message' />

        <x-btn-group label='MenuPrincipal' class="py-1">

            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalFilter"><x-icon
                    icon='funnel' /> {{ __('Filters') }}</button>

            @can('mapa-export')
                <x-dropdown-menu title='Reports' icon='printer'>

                    <li>
                        <a class="dropdown-item" href="#"><x-icon icon='file-earmark-spreadsheet-fill' />
                            {{ __('Export') . ' CSV' }}</a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="#"><x-icon icon='file-pdf-fill' /> {{ __('Export') . ' PDF' }}</a>
                    </li>

                </x-dropdown-menu>
            @endcan

        </x-btn-group>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ARP</th>
                        <th>PAC</th>
                        <th>PE</th>
                        <th>Vigência</th>
                        <th></th>
                        <th>SIGMA</th>
                        <th>Objeto</th>
                        <th class="text-end">Valor</th>
                        <th>Setor</th>
                        <th class="text-end">Cotado</th>
                        <th class="text-end">Empenhado</th>
                        <th class="text-end">Saldo</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mapas as $mapa)
                        <tr>
                            <td class="text-nowrap">
                                {{ $mapa->arp }}
                            </td>
                            <td class="text-nowrap">
                                {{ $mapa->pac }}
                            </td>
                            <td class="text-nowrap">
                                {{ $mapa->pe }}
                            </td>
                            <td>
                                {{ $mapa->vigenciaInicio->format('d/m/Y') . ' a ' . $mapa->vigenciaFim->format('d/m/Y') }}
                            </td>


                            <td class="text-center">
                                @if ($mapa->vigente == 1)
                                    <span class="badge text-bg-success">Vigente</span>
                                @else
                                    <span class="badge text-bg-danger">Vencido</span>
                                @endif
                            </td>

                            <td class="text-nowrap">
                                {{ $mapa->sigma }}
                            </td>

                            <td>
                                {{ $mapa->objeto }}
                            </td>

                            <td class="text-end">
                                {{ 'R$ ' . number_format($mapa->valor, 2, ',', '.') }}
                            </td>

                            <td>
                                {{ $mapa->sigla }}
                            </td>

                            <td class="text-end">
                                {{ $mapa->quantidade_cota }}
                            </td>

                            <td class="text-end">
                                {{ $mapa->empenho_cota }}
                            </td>

                            <td class="text-end">
                                {{ $mapa->saldo_cota }}
                            </td>

                            <td>
                                <x-btn-group label='Opções'>

                                    @can('mapa-show')
                                        <a href="{{route('mapas.show', $mapa->id)}}" class="btn btn-info btn-sm"
                                            role="button"><x-icon icon='eye' /></a>
                                    @endcan

                                </x-btn-group>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <x-pagination :query="$mapas" />

    </div>

    <x-modal-filter class="modal-lg" :perpages="$perpages" icon='funnel' title='Filters'>


        <div class="container">
            <form method="GET" action="{{ route('mapas.index') }}">

                <div class="row g-3">

                    <div class="col-md-4">
                        <label for="arp" class="form-label">ARP</label>
                        <input type="text" class="form-control" id="arp" name="arp"
                            value="{{ session()->get('mapa_arp') }}">
                    </div>

                    <div class="col-md-4">
                        <label for="pac" class="form-label">PAC</label>
                        <input type="text" class="form-control" id="pac" name="pac"
                            value="{{ session()->get('mapa_pac') }}">
                    </div>

                    <div class="col-md-4">
                        <label for="pe" class="form-label">PE</label>
                        <input type="text" class="form-control" id="pe" name="pe" value="{{ session()->get('mapa_pe') }}">
                    </div>

                    <div class="col-md-4">
                        <label for="vigencia_inicio" class="form-label">Vigência inicial</label>
                        <input type="text" class="form-control" id="vigencia_inicio" name="vigencia_inicio"
                            value="{{ session()->get('mapa_vigencia_inicio') }}" autocomplete="off">
                    </div>

                    <div class="col-md-4">
                        <label for="vigencia_fim" class="form-label">Vigência final</label>
                        <input type="text" class="form-control" id="vigencia_fim" name="vigencia_fim"
                            value="{{ session()->get('mapa_vigencia_fim') }}" autocomplete="off">
                    </div>

                    <div class="col-md-4">
                        <label for="vigencia" class="form-label">Vigência</label>
                        <select class="form-select" id="vigencia" name="vigencia">
                            <option value="" selected>Exibir Todos</option>

                            <option value="1" {{ (session()->get('mapa_vigencia') ?? '') == 1 ? 'selected' : '' }}>Somente
                                Vigentes</option>

                            <option value="0" {{ (session()->get('mapa_vigencia') ?? '') == 0 ? 'selected' : '' }}>Somente
                                Vencidos</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="sigma" class="form-label">SIGMA</label>
                        <input type="text" class="form-control" id="sigma" name="sigma"
                            value="{{ session()->get('mapa_sigma') }}">
                    </div>

                    <div class="col-md-8">
                        <label for="objeto" class="form-label">Objeto</label>
                        <input type="text" class="form-control" id="objeto" name="objeto"
                            value="{{ session()->get('mapa_objeto') }}">
                    </div>

                    <div class="col-12">
                        <label for="setor" class="form-label">Setor</label>
                        <input type="text" class="form-control" id="setor" name="setor"
                            value="{{ session()->get('mapa_setor') }}">
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-sm"><x-icon icon='search' />
                            {{ __('Search') }}</button>

                        <a href="{{ route('mapas.index', ['mapa' => '', 'pac' => '', 'pe' => '', 'vigencia_inicio' => '', 'vigencia_fim' => '', 'vigencia' => '', 'sigma' => '', 'objeto' => '', 'setor' => '']) }}"
                            class="btn btn-secondary btn-sm" role="button"><x-icon icon='stars' /> {{ __('Reset') }}</a>
                    </div>


                </div>

            </form>
        </div>

    </x-modal-filter>

@endsection
@section('script-footer')
    <script src="{{ asset('js/jquery-3.6.4.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('locales/bootstrap-datepicker.pt-BR.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var perpage = document.getElementById('perpage');
            perpage.addEventListener('change', function () {
                perpage = this.options[this.selectedIndex].value;
                window.open("{{ route('mapas.index') }}" + "?perpage=" + perpage, "_self");
            });
        });

        $('#vigencia_inicio').datepicker({
            format: "dd/mm/yyyy",
            todayBtn: "linked",
            clearBtn: true,
            language: "pt-BR",
            autoclose: true,
            todayHighlight: true
        });

        $('#vigencia_fim').datepicker({
            format: "dd/mm/yyyy",
            todayBtn: "linked",
            clearBtn: true,
            language: "pt-BR",
            autoclose: true,
            todayHighlight: true
        });
    </script>
@endsection
