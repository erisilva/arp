@extends('layouts.app')

@section('title', 'Objetos')

@section('content')
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">
                    <a href="{{ route('objetos.index') }}">
                        Objetos
                    </a>
                </li>
            </ol>
        </nav>

        <x-flash-message status='success' message='message' />

        <x-btn-group label='MenuPrincipal' class="py-1">

            @can('objeto-create')
                <a class="btn btn-primary" href="{{ route('objetos.create') }}" role="button"><x-icon icon='file-earmark' />
                    {{ __('New') }}</a>
            @endcan

            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalFilter"><x-icon
                    icon='funnel' /> {{ __('Filters') }}</button>

            @can('objeto-export')
                <x-dropdown-menu title='Reports' icon='printer'>

                    <li>
                        <a class="dropdown-item" href="{{route('objetos.export.xls', ['descricao' => request()->input('descricao'), 'sigma' => request()->input('sigma')])}}"><x-icon
                                icon='file-earmark-excel-fill' /> {{ __('Export') . ' XLS' }}</a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="{{route('objetos.export.csv', ['descricao' => request()->input('descricao'), 'sigma' => request()->input('sigma')])}}"><x-icon
                                icon='file-earmark-spreadsheet-fill' /> {{ __('Export') . ' CSV' }}</a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="{{route('objetos.export.pdf', ['descricao' => request()->input('descricao'), 'sigma' => request()->input('sigma')])}}"><x-icon icon='file-pdf-fill' />
                            {{ __('Export') . ' PDF' }}</a>
                    </li>

                </x-dropdown-menu>
            @endcan

        </x-btn-group>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>SIGMA</th>
                        <th>Descrição</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($objetos as $objeto)
                        <tr>
                            <td class="text-nowrap">
                                {{$objeto->sigma}}
                            </td>
                            <td>
                                {{$objeto->descricao}}
                            </td>
                            <td>
                                <x-btn-group label='Opções'>

                                    @can('objeto-edit')
                                        <a href="{{route('objetos.edit', $objeto->id)}}" class="btn btn-primary btn-sm"
                                            role="button"><x-icon icon='pencil-square' /></a>
                                    @endcan

                                    @can('objeto-show')
                                        <a href="{{route('objetos.show', $objeto->id)}}" class="btn btn-info btn-sm"
                                            role="button"><x-icon icon='eye' /></a>
                                    @endcan

                                </x-btn-group>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <x-pagination :query="$objetos" />

    </div>

    <x-modal-filter class="modal-sm" :perpages="$perpages" icon='funnel' title='Filters'>

        <form method="GET" action="{{ route('objetos.index') }}">

            <div class="mb-3">
                <label for="sigma" class="form-label">SIGMA</label>
                <input type="text" class="form-control" id="sigma" name="sigma"
                    value="{{ session()->get('objeto_sigma') }}">
            </div>

            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <input type="text" class="form-control" id="descricao" name="descricao"
                    value="{{ session()->get('objeto_descricao') }}">
            </div>

            <button type="submit" class="btn btn-primary btn-sm"><x-icon icon='search' /> {{ __('Search') }}</button>

            <a href="{{ route('objetos.index', ['sigma' => '', 'descricao' => '']) }}" class="btn btn-secondary btn-sm"
                role="button"><x-icon icon='stars' /> {{ __('Reset') }}</a>

        </form>

    </x-modal-filter>

@endsection
@section('script-footer')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var perpage = document.getElementById('perpage');
            perpage.addEventListener('change', function () {
                perpage = this.options[this.selectedIndex].value;
                window.open("{{ route('objetos.index') }}" + "?perpage=" + perpage, "_self");
            });
        });
    </script>
@endsection
