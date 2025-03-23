@extends('layouts.app')

@section('title', 'ARP' . ' - ' . __('Edit'))

@section('css-header')
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
@endsection

@section('content')
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('arps.index') }}">
                        ARP
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ __('Edit') }}
                </li>
            </ol>
        </nav>
    </div>

    <div class="container">
        <x-flash-message status='success' message='message' />

        <form method="POST" action="{{ route('arps.update', $arp->id) }}">
            @csrf
            @method('PUT')
            <div class="row g-3">

                <div class="col-md-4">
                    <label for="arp" class="form-label">ARP <strong class="text-danger">(*)</strong></label>
                    <input type="text" class="form-control @error('arp') is-invalid @enderror" name="arp"
                        value="{{ old('arp') ?? $arp->arp }}">
                    @error('arp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="pac" class="form-label">PAC <strong class="text-danger">(*)</strong></label>
                    <input type="text" class="form-control @error('pac') is-invalid @enderror" name="pac"
                        value="{{ old('pac') ?? $arp->pac }}">
                    @error('pac')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="pe" class="form-label">PE <strong class="text-danger">(*)</strong></label>
                    <input type="text" class="form-control @error('pe') is-invalid @enderror" name="pe"
                        value="{{ old('pe') ?? $arp->pe }}">
                    @error('pe')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="vigenciaInicio" class="form-label">Vigência Inicial <strong
                            class="text-danger">(*)</strong></label>
                    <input type="text" class="form-control @error('vigenciaInicio') is-invalid @enderror"
                        name="vigenciaInicio" id="vigenciaInicio"
                        value="{{ old('vigenciaInicio') ?? date('d/m/Y', strtotime($arp->vigenciaInicio)) }}">
                    @error('vigenciaInicio')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="vigenciaFim" class="form-label">Vigência Final <strong
                            class="text-danger">(*)</strong></label>
                    <input type="text" class="form-control @error('vigenciaFim') is-invalid @enderror" name="vigenciaFim"
                        id="vigenciaFim" value="{{ old('vigenciaFim') ?? date('d/m/Y', strtotime($arp->vigenciaFim)) }}">
                    @error('vigenciaFim')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label for="notas">Anotações</label>
                    <textarea class="form-control" name="notas" rows="3">{{ old('notas') ?? $arp->notas }}</textarea>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <x-icon icon='pencil-square' />{{ __('Edit') }}
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="container py-4">
        <div class="float-sm-end">

            @can('arp-create')
                <a href="{{ route('arps.create') }}" class="btn btn-primary btn-lg" role="button">
                    <x-icon icon='file-earmark' />
                    {{ __('New') }}
                </a>
            @endcan

            <a href="{{ route('arps.index') }}" class="btn btn-secondary btn-lg" role="button">
                <x-icon icon='arrow-left-square' />
                ARP
            </a>

        </div>
    </div>
@endsection
@section('script-footer')
    <script src="{{ asset('js/jquery-3.6.4.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('locales/bootstrap-datepicker.pt-BR.min.js') }}"></script>
    <script>

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
