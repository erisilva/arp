@extends('layouts.app')

@section('title', 'ARP')

@section('css-header')
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
@endsection

@section('content')
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="{{ route('arps.index') }}">ARP</a>
                </li>
            </ol>
        </nav>

        <x-flash-message status='success' message='message' />

        <x-btn-group label='MenuPrincipal' class="py-1">

            @can('arp-create')
                <a class="btn btn-primary" href="{{ route('arps.create') }}" role="button"><x-icon icon='file-earmark' />
                    {{ __('New') }}</a>
            @endcan

            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalFilter"><x-icon
                    icon='funnel' /> {{ __('Filters') }}</button>

            @can('arp-export')
                <x-dropdown-menu title='Reports' icon='printer'>

                    <li>
                        <a class="dropdown-item"
                            href="{{route('arps.export.csv', ['arp' => request()->input('arp'), 'pac' => request()->input('pac'), 'pe' => request()->input('pe'), 'vigenciaInicio' => request()->input('vigenciaInicio'), 'vigenciaFim' => request()->input('vigenciaFim')])}}"><x-icon
                                icon='file-earmark-spreadsheet-fill' /> {{ __('Export') . ' CSV' }}</a>
                    </li>

                    <li>
                        <a class="dropdown-item"
                            href="{{route('arps.export.pdf', ['arp' => request()->input('arp'), 'pac' => request()->input('pac'), 'pe' => request()->input('pe'), 'vigenciaInicio' => request()->input('vigenciaInicio'), 'vigenciaFim' => request()->input('vigenciaFim')])}}"><x-icon
                                icon='file-pdf-fill' /> {{ __('Export') . ' PDF' }}</a>
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
                        <th class="text-end">Cotado</th>
                        <th class="text-end">Empenhado</th>
                        <th class="text-end">Saldo</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($arps as $arp)
                        <tr>
                            <td class="text-nowrap">
                                {{ $arp->arp }}
                            </td>
                            <td class="text-nowrap">
                                {{ $arp->pac }}
                            </td>
                            <td class="text-nowrap">
                                {{ $arp->pe }}
                            </td>
                            <td>
                                {{ $arp->vigenciaInicio->format('d/m/Y') . ' a ' . $arp->vigenciaFim->format('d/m/Y') }}
                            </td>


                            <td class="text-center">
                                @if ($arp->vigente == 1)
                                    <span class="badge text-bg-success">Vigente</span>
                                @else
                                    <span class="badge text-bg-danger">Vencido</span>
                                @endif
                            </td>

                            <td class="text-nowrap">
                                {{ $arp->sigma }}
                            </td>

                            <td>
                                {{ $arp->objeto }}
                            </td>

                            <td class="text-end">
                                {{ 'R$ ' . number_format($arp->valor, 2, ',', '.') }}
                            </td>

                            <td class="text-end">
                                {{ $arp->cota_total }}
                            </td>

                            <td class="text-end">
                                {{ $arp->empenho_total }}
                            </td>

                            <td class="text-end">
                                {{ $arp->cota_total - $arp->empenho_total }}
                            </td>

                            <td>
                                <x-btn-group label='Opções'>

                                    @can('arp-edit')
                                        <a href="{{route('arps.edit', $arp->id)}}" class="btn btn-primary btn-sm"
                                            role="button"><x-icon icon='pencil-square' /></a>
                                    @endcan

                                    @can('arp-show')
                                        <a href="{{route('arps.show', $arp->id)}}" class="btn btn-info btn-sm" role="button"><x-icon
                                                icon='eye' /></a>
                                    @endcan

                                </x-btn-group>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <x-pagination :query="$arps" />

    </div>

    <x-modal-filter class="modal-lg" :perpages="$perpages" icon='funnel' title='Filters'>


        <div class="container">
            <form method="GET" action="{{ route('arps.index') }}">

                <div class="row g-3">

                    <div class="col-md-4">
                        <label for="arp" class="form-label">ARP</label>
                        <input type="text" class="form-control" id="arp" name="arp" value="{{ session()->get('arp_arp') }}">
                    </div>

                    <div class="col-md-4">
                        <label for="pac" class="form-label">PAC</label>
                        <input type="text" class="form-control" id="pac" name="pac" value="{{ session()->get('arp_pac') }}">
                    </div>

                    <div class="col-md-4">
                        <label for="pe" class="form-label">PE</label>
                        <input type="text" class="form-control" id="pe" name="pe" value="{{ session()->get('arp_pe') }}">
                    </div>

                    <div class="col-md-4">
                        <label for="vigencia_inicio" class="form-label">Vigência inicial</label>
                        <input type="text" class="form-control" id="vigencia_inicio" name="vigencia_inicio"
                            value="{{ session()->get('arp_vigencia_inicio') }}" autocomplete="off">
                    </div>

                    <div class="col-md-4">
                        <label for="vigencia_fim" class="form-label">Vigência final</label>
                        <input type="text" class="form-control" id="vigencia_fim" name="vigencia_fim"
                            value="{{ session()->get('arp_vigencia_fim') }}" autocomplete="off">
                    </div>

                    <div class="col-md-4">
                        <label for="vigencia" class="form-label">Vigência</label>
                        <select class="form-select" id="vigencia" name="vigencia">
                            <option value="" selected>Exibir Todos</option>

                            <option value="1" {{ (session()->get('arp_vigencia') ?? '') == 1 ? 'selected' : '' }}>Somente Vigentes</option>

                            <option value="0" {{ (session()->get('arp_vigencia') ?? '') == 0 ? 'selected' : '' }}>Somente Vencidos</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="sigma" class="form-label">SIGMA</label>
                        <input type="text" class="form-control" id="sigma" name="sigma" value="{{ session()->get('arp_sigma') }}">
                    </div>

                    <div class="col-md-8">
                        <label for="objeto" class="form-label">Objeto</label>
                        <input type="text" class="form-control" id="objeto" name="objeto"
                            value="{{ session()->get('arp_objeto') }}">
                    </div>


                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-sm"><x-icon icon='search' />
                            {{ __('Search') }}</button>

                        <a href="{{ route('arps.index', ['arp' => '', 'pac' => '', 'pe' => '', 'vigencia_inicio' => '', 'vigencia_fim' => '', 'vigencia' => '', 'sigma' => '', 'objeto' => '']) }}"
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
                window.open("{{ route('arps.index') }}" + "?perpage=" + perpage, "_self");
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
