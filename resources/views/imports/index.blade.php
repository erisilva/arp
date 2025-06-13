@extends('layouts.app')

@section('title', 'Importações')

@section('content')
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="{{ route('imports.index') }}">
                        Importações
                    </a>
                </li>
            </ol>
        </nav>

        <x-flash-message status='success' message='message' />

        <x-btn-group label='MenuPrincipal' class="py-1">

            @can('import-create')
                <a class="btn btn-primary" href="{{ route('imports.create') }}" role="button"><x-icon icon='file-earmark' />
                    {{ __('New') }}</a>
            @endcan

            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalFilter"><x-icon
                    icon='funnel' /> {{ __('Filters') }}
            </button>

        </x-btn-group>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Data e Hora</th>
                        <th>{{ __('Description') }}</th>
                        <th class="text-nowrap">Usuário</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($imports as $import)
                        <tr>
                            <td class="text-nowrap">
                                {{ $import->created_at->format('d/m/Y H:i:s') }}
                            </td>
                            <td class="text-nowrap">
                                {{$import->descricao}}
                            </td>
                            <td class="text-nowrap">
                                @if($import->user)
                                    {{ $import->user->name }}
                                @else
                                    <span class="text-muted
                                        text-nowrap">{{ __('Unknown') }}</span>
                                @endif
                            </td>
                            <td>
                                <x-btn-group label='Opções'>

                                    @can('import-show')
                                        <a href="{{route('imports.show', $import->id)}}" class="btn btn-info btn-sm"
                                            role="button"><x-icon icon='eye' /></a>
                                    @endcan

                                </x-btn-group>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <x-pagination :query="$imports" />

    </div>

    <x-modal-filter class="modal-lg" :perpages="$perpages" icon='funnel' title='Filters'>

        <form method="GET" action="{{ route('imports.index') }}">

            <div class="mb-3">
                <label for="name" class="form-label">{{ __('Name') }}</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ session()->get('import_name') }}">
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">{{ __('Description') }}</label>
                <input type="text" class="form-control" id="description" name="description"
                    value="{{ session()->get('import_description') }}">
            </div>

            <button type="submit" class="btn btn-primary btn-sm"><x-icon icon='search' /> {{ __('Search') }}</button>

            <a href="{{ route('imports.index', ['name' => '', 'description' => '']) }}" class="btn btn-secondary btn-sm"
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
                window.open("{{ route('imports.index') }}" + "?perpage=" + perpage, "_self");
            });
        });
    </script>
@endsection
