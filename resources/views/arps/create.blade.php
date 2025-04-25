@extends('layouts.app')

@section('title', 'ARP' . ' - ' . __('New'))

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
                    {{ __('New') }}
                </li>
            </ol>
        </nav>
    </div>

    <div class="container">
        <form method="POST" action="{{ route('arps.store') }}">
            @csrf
            <div class="row g-3">

                <div class="col-md-4">
                    <label for="arp" class="form-label">ARP <strong class="text-danger">(*)</strong></label>
                    <input type="text" class="form-control @error('arp') is-invalid @enderror" name="arp"
                        value="{{ old('arp') ?? '' }}">
                    @error('arp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="pac" class="form-label">PAC <strong class="text-danger">(*)</strong></label>
                    <input type="text" class="form-control @error('pac') is-invalid @enderror" name="pac"
                        value="{{ old('pac') ?? '' }}">
                    @error('pac')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="pe" class="form-label">PE <strong class="text-danger">(*)</strong></label>
                    <input type="text" class="form-control @error('pe') is-invalid @enderror" name="pe"
                        value="{{ old('pe') ?? '' }}">
                    @error('pe')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="vigenciaInicio" class="form-label">Vigência Inicial <strong
                            class="text-danger">(*)</strong></label>
                    <input type="text" class="form-control @error('vigenciaInicio') is-invalid @enderror"
                        name="vigenciaInicio" id="vigenciaInicio" value="{{ old('vigenciaInicio') ?? '' }}"
                        autocomplete="off">
                    @error('vigenciaInicio')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="vigenciaFim" class="form-label">Vigência Final <strong
                            class="text-danger">(*)</strong></label>
                    <input type="text" class="form-control @error('vigenciaFim') is-invalid @enderror" name="vigenciaFim"
                        id="vigenciaFim" value="{{ old('vigenciaFim') ?? '' }}" autocomplete="off">
                    @error('vigenciaFim')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label for="notas">Anotações</label>
                    <textarea class="form-control" name="notas" rows="3">{{ old('notas') ?? '' }}</textarea>
                </div>

                <div class="col-md-3">
                    <label for="sigma" class="form-label">SIGMA (Objeto) <strong class="text-danger">(*)</strong></label>
                    <input type="text" class="form-control @error('sigma') is-invalid @enderror" name="sigma"
                        value="{{ old('sigma') ?? '' }}">
                    @error('sigma')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="objeto" class="form-label">Objeto (Descrição) <strong
                            class="text-danger">(*)</strong></label>
                    <input type="text" class="form-control @error('objeto') is-invalid @enderror" name="objeto"
                        value="{{ old('objeto') ?? '' }}">
                    @error('objeto')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label for="valor" class="form-label">Valor R$ (Objeto) <strong class="text-danger">(*)</strong></label>
                    <input type="text" class="form-control @error('valor') is-invalid @enderror" name="valor"
                        value="{{ old('valor') ?? '' }}" id="valor">
                    @error('valor')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                <div class="col-12">
                    <button type="submit" class="btn btn-primary"><x-icon icon='plus-circle' /> {{ __('Save') }}</button>
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
    <script src="{{ asset('js/jquery.inputmask.min.js') }}"></script>
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

        $("#valor").inputmask('decimal', {
            'alias': 'numeric',
            'groupSeparator': '.',
            'autoGroup': true,
            'digits': 2,
            'radixPoint': ",",
            'digitsOptional': false,
            'allowMinus': false,
            'placeholder': ''
        });
    </script>
@endsection
