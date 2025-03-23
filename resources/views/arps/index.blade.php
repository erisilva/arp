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
                        <th>Vigência (Inicio)</th>
                        <th>Vigência (Fim)</th>
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
                                {{ $arp->vigenciaInicio->format('d/m/Y') }}
                            </td>
                            <td>
                                {{ $arp->vigenciaFim->format('d/m/Y') }}
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

        <form method="GET" action="{{ route('arps.index') }}">

            <div class="mb-3">
                <label for="arp" class="form-label">ARP</label>
                <input type="text" class="form-control" id="arp" name="arp" value="{{ session()->get('arp_arp') }}">
            </div>

            <div class="mb-3">
                <label for="pac" class="form-label">PAC</label>
                <input type="text" class="form-control" id="pac" name="pac" value="{{ session()->get('arp_pac') }}">
            </div>

            <button type="submit" class="btn btn-primary btn-sm"><x-icon icon='search' /> {{ __('Search') }}</button>

            <a href="{{ route('arps.index', ['arp' => '', 'pac' => '', 'pe' => '', 'vigenciaInicio' => '', 'vigenciaFim' => '']) }}"
                class="btn btn-secondary btn-sm" role="button"><x-icon icon='stars' /> {{ __('Reset') }}</a>

        </form>

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

        $('#vigenciaInicio').datepicker({
            format: "dd/mm/yyyy",
            todayBtn: "linked",
            clearBtn: true,
            language: "pt-BR",
            autoclose: true,
            todayHighlight: true
        });

        $('#vigenciaFim').datepicker({
            format: "dd/mm/yyyy",
            todayBtn: "linked",
            clearBtn: true,
            language: "pt-BR",
            autoclose: true,
            todayHighlight: true
        });
    </script>
@endsection
