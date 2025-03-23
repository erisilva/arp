@extends('layouts.app')

@section('title', __('Logs'))

@section('css-header')
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
@endsection

@section('content')
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="{{ route('logs.index') }}">{{ __('Logs') }}</a>
                </li>
            </ol>
        </nav>

        <x-flash-message status='success' message='message' />

        <x-btn-group label='MenuPrincipal' class="py-1">

            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalFilter"><x-icon
                    icon='funnel' /> {{ __('Filters') }}</button>

        </x-btn-group>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>
                            {{ __('Date') }}
                        </th>
                        <th>
                            {{ __('Hour') }}
                        </th>
                        <th>
                            {{ __('When') }}
                        </th>
                        <th>
                            {{ __('User') }}
                        </th>
                        <th>
                            {{ __('Model') }}
                        </th>
                        <th>
                            {{ __('Action') }}
                        </th>
                        <th>
                            {{ __('ID (Model)') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $log)
                        <tr>
                            <td>
                                {{ $log->created_at->format('d/m/Y') }}
                            </td>
                            <td>
                                {{ $log->created_at->format('H:i:s') }}
                            </td>
                            <td>
                                {{ $log->created_at->diffForHumans() }}
                            </td>
                            <td>
                                {{ $log->user->name }}
                            </td>
                            <td>
                                {{ $log->model }}
                            </td>
                            <td>
                                {{ $log->action }}
                            </td>
                            <td>
                                {{ $log->model_id }}
                            </td>
                            <td>
                                <x-btn-group label='Opções'>

                                    <a href="{{route('logs.show', $log->id)}}" class="btn btn-info btn-sm" role="button"><x-icon
                                            icon='eye' /></a>

                                </x-btn-group>
                            </td>
                        </tr>
                    @endforeach                  </tbody>
            </table>
        </div>

        <x-pagination :query="$logs" />

    </div>

    <x-modal-filter class="modal-lg" :perpages="$perpages" icon='funnel' title='Filters'>

        <form method="GET" action="{{ route('logs.index') }}">

            <div class="row g-3">

                <div class="col-md-3">
                    <label for="data_inicio" class="form-label">Data Inicial</label>
                    <input type="text" class="form-control" id="data_inicio" name="data_inicio"
                        value="{{ session()->get('log_view_data_inicio') }}" autocomplete="off">
                </div>

                <div class="col-md-3">
                    <label for="data_fim" class="form-label">Data Final</label>
                    <input type="text" class="form-control" id="data_fim" name="data_fim"
                        value="{{ session()->get('log_view_data_fim') }}" autocomplete="off">
                </div>

                <div class="col-md-6">
                    <label for="user" class="form-label">{{__('User')}}</label>
                    <input type="text" class="form-control" id="user" name="user"
                        value="{{ session()->get('log_view_user') }}">
                </div>

                <div class="col-md-4">
                    <label for="model" class="form-label">{{__('Model')}}</label>
                    <input type="text" class="form-control" id="model" name="model"
                        value="{{ session()->get('log_view_model') }}">
                </div>

                <div class="col-md-4">
                    <label for="action" class="form-label">{{__('Action')}}</label>
                    <input type="text" class="form-control" id="action" name="action"
                        value="{{ session()->get('log_view_action') }}">
                </div>

                <div class="col-md-4">
                    <label for="id" class="form-label">{{__('ID')}}</label>
                    <input type="text" class="form-control" id="id" name="id" value="{{ session()->get('log_view_id') }}">
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-sm"><x-icon icon='search' />
                        {{ __('Search') }}</button>

                    {{-- Reset the Filter --}}
                    <a href="{{ route('logs.index', ['data_inicio' => '', 'data_fim' => '', 'user' => '', 'model' => '', 'action' => '', 'id' => '']) }}"
                        class="btn btn-secondary btn-sm" role="button"><x-icon icon='stars' /> {{ __('Reset') }}</a>
                </div>

            </div>

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
                window.open("{{ route('logs.index') }}" + "?perpage=" + perpage, "_self");
            });
        });

        $('#data_fim').datepicker({
            format: "dd/mm/yyyy",
            todayBtn: "linked",
            clearBtn: true,
            language: "pt-BR",
            autoclose: true,
            todayHighlight: true
        });

        $('#data_inicio').datepicker({
            format: "dd/mm/yyyy",
            todayBtn: "linked",
            clearBtn: true,
            language: "pt-BR",
            autoclose: true,
            todayHighlight: true
        });
    </script>
@endsection
