@extends('layouts.app')

@section('title', 'ARP' . ' - ' . __('Edit'))

@section('css-header')
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
    <style>
        .twitter-typeahead,
        .tt-hint,
        .tt-input,
        .tt-menu {
            width: 100%;
        }

        .tt-query,
        .tt-hint {
            outline: none;
        }

        .tt-query {
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
        }

        .tt-hint {
            color: #999;
        }

        .tt-menu {
            width: 100%;
            margin-top: 12px;
            padding: 8px 0;
            background-color: #fff;
            border: 1px solid #ccc;
            border: 1px solid rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, .2);
        }

        .tt-suggestion {
            padding: 3px 20px;
        }

        .tt-suggestion.tt-is-under-cursor {
            color: #fff;
        }

        .tt-suggestion p {
            margin: 0;
        }
    </style>
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


    <div class="container py-3">
        <div class="container bg-warning text-dark">
            <p class="text-center"><strong>Objetos</strong></p>
        </div>

        @can('item-create')

            <div class="container py-2 text-center">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNovoObjeto">
                    <i class="bi bi-plus-circle"></i> Incluir Objeto
                </button>
            </div>

        @endcan

    </div>

    <div class="container py-2">

        @if (count($items) > 0)
            @foreach($items as $item)

                <div class="container py-2 text-center">


                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h5 class="text-start"><strong>Objeto: </strong> {{ $item->objeto->descricao }}</h5>
                                <h5 class="text-end"><strong>Sigma: </strong> {{ $item->objeto->sigma }}</h5>
                            </div>
                        </div>
                        <div class="card-body">

                            <h5 class="card-title">Cotas</h5>

                            @if (count($item->cotas) > 0)
                                <div class="container py-3">
                                    <div class="row g-3">

                                        @foreach ($item->cotas as $cota)

                                            <div class="col-md-3">
                                                <div class="card">
                                                    <ul class="list-group list-group-flush">
                                                        <li class="list-group-item">
                                                            {{ $cota->setor->descricao }}
                                                        </li>
                                                        <li class="list-group-item">
                                                            {{ $cota->quantidade }}
                                                        </li>
                                                        <li class="list-group-item">
                                                            <div class="container">
                                                                <div class="float-sm-end">

                                                                    <a href="#" class="btn btn-primary btn-sm" role="button">
                                                                        <x-icon icon='pencil-square' />
                                                                    </a>

                                                                    @can('cota-delete')

                                                                        <a href="#" class="btn btn-danger btn-sm" role="button"
                                                                            data-bs-toggle="modal" data-bs-target="#modalExcluirCota"
                                                                            data-cota-id={{ $cota->id }} data-arp-id={{ $item->arp_id }}>
                                                                            <x-icon icon='trash' />
                                                                        </a>

                                                                    @endcan

                                                                </div>
                                                            </div>

                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>

                                        @endforeach

                                    </div>

                                </div>
                            @else
                                <p class="card-text">.:Nenhuma cota cadastrada:.</p>
                            @endif


                            @can('cota-create')
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNovaCota"
                                    data-item-id={{ $item->id }}>
                                    <i class="bi bi-plus-circle"></i> Incluir Cota
                                </button>
                            @endcan

                        </div>
                    </div>

                </div>


            @endforeach
        @else
            <div class="container py-2 text-center">
                .:Nenhum Objeto Cadastrado:.
            </div>
        @endif



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

    @can('item-create')
        <!-- Janela para incluir novo objeto -->
        <div class="modal fade" id="modalNovoObjeto" tabindex="-1" aria-labelledby="Incluir novo objeto" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5"><i class="bi bi-plus-circle"></i> Incluir Novo Objeto</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('items.store') }}">
                            @csrf
                            <input type="hidden" name="arp_id" value="{{ $arp->id }}">
                            <div class="row g-3">
                                <div class="col-8">
                                    <label for="objeto" class="form-label">Objeto</label>
                                    <input type="text" class="form-control" name="objeto" id="objeto"
                                        value="{{ old('objeto') ?? '' }}" autocomplete="off" required>
                                </div>
                                <div class="col-4">
                                    <label for="sigma" class="form-label">Sigma</label>
                                    <input type="text" class="form-control" name="sigma" id="sigma" value="" autocomplete="off"
                                        required readonly tabindex="-1">
                                </div>
                                <input type="hidden" id="objeto_id" name="objeto_id" value="">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-plus-circle"></i>
                                        Incluir Objeto
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                                class="fas fa-window-close"></i>
                            Fechar</button>
                    </div>
                </div>
            </div>
        </div>
    @endcan

    @can('cota-create')
        <!-- Janela para incluir nova cota -->
        <div class="modal fade" id="modalNovaCota" tabindex="-1" aria-labelledby="Incluir nova cota" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5"><i class="bi bi-plus-circle"></i> Incluir Nova Cota</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('cotas.store') }}">
                            @csrf
                            <input type="hidden" name="item_id" id="item_id" value="">
                            <div class="row g-3">
                                <div class="col-8">
                                    <label for="setor" class="form-label">Setor</label>
                                    <input type="text" class="form-control" name="setor" id="setor"
                                        value="{{ old('setor') ?? '' }}" autocomplete="off" required>
                                </div>
                                <div class="col-4">
                                    <label for="quantidade" class="form-label">Quantidade</label>
                                    <input type="number" class="form-control" name="quantidade" id="quantidade" value=""
                                        autocomplete="off" required>
                                </div>
                                <input type="hidden" id="setor_id" name="setor_id" value="">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-plus-circle"></i>
                                        Incluir Cota
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                                class="fas fa-window-close"></i>
                            Fechar</button>
                    </div>
                </div>
            </div>
        </div>
    @endcan

    @can('cota-delete')
        <!-- Janela para excluir cota -->
        <div class="modal fade" id="modalExcluirCota" tabindex="-1" aria-labelledby="Excluir nova cota" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5"><x-icon icon='trash' /> Excluir Cota?</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('cotas.destroy', 1) }}">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="arp_id" id="arp_id" value="">
                            <input type="hidden" name="cota_id" id="cota_id" value="">
                            <div class="row g-3">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-danger btn-lg"><x-icon icon='plus-circle' />
                                        Confirmar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                                class="fas fa-window-close"></i>
                            Fechar</button>
                    </div>
                </div>
            </div>
        </div>
    @endcan


@endsection
@section('script-footer')
    <script src="{{ asset('js/jquery-3.6.4.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('js/typeahead.bundle.min.js') }}"></script>
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

        var objetos = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace("text"),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: "{{route('objetos.autocomplete')}}?query=%QUERY",
                wildcard: '%QUERY'
            }

        });
        objetos.initialize();

        $("#objeto").typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        },
            {
                name: "objetos",
                displayKey: "text",
                limit: 10,

                source: objetos.ttAdapter(),
                templates: {
                    empty: [
                        '<div class="empty-message">',
                        '<p class="text-center font-weight-bold text-warning">Não foi encontrado nenhum objeto com o texto digitado.</p>',
                        '</div>'
                    ].join('\n'),
                    suggestion: function (data) {
                        return '<div class="text-bg-primary py-1">' + data.text + '<strong> - SIGMA: ' + data.sigma + '</strong>' + '</div>';
                    }
                }
            }).on("typeahead:selected", function (obj, datum, name) {
                console.log(datum);
                $(this).data("seletectedId", datum.value);
                $('#objeto_id').val(datum.value);
                $('#sigma').val(datum.sigma);
            }).on('typeahead:autocompleted', function (e, datum) {
                console.log(datum);
                $(this).data("seletectedId", datum.value);
                $('#objeto_id').val(datum.value);
                $('#sigma').val(datum.sigma);
            });

        $('#modalNovaCota').on('show.bs.modal', function (e) {
            $('#item_id').val($(e.relatedTarget).data('item-id'));
        });

        $('#modalExcluirCota').on('show.bs.modal', function (e) {
            $('#arp_id').val($(e.relatedTarget).data('arp-id'));
            $('#cota_id').val($(e.relatedTarget).data('cota-id'));
        });


        var setors = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace("text"),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: "{{route('setors.autocomplete')}}?query=%QUERY",
                wildcard: '%QUERY'
            }

        });
        setors.initialize();

        $("#setor").typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        },
            {
                name: "setors",
                displayKey: "text",
                limit: 10,

                source: setors.ttAdapter(),
                templates: {
                    empty: [
                        '<div class="empty-message">',
                        '<p class="text-center font-weight-bold text-warning">Não foi encontrado nenhum setor com o texto digitado.</p>',
                        '</div>'
                    ].join('\n'),
                    suggestion: function (data) {
                        return '<div class="text-bg-primary py-1">' + data.text + '</div>';
                    }
                }
            }).on("typeahead:selected", function (obj, datum, name) {
                console.log(datum);
                $(this).data("seletectedId", datum.value);
                $('#setor_id').val(datum.value);
                $('#setor').val(datum.distrito);

            }).on('typeahead:autocompleted', function (e, datum) {
                console.log(datum);
                $(this).data("seletectedId", datum.value);
                $('#setor_id').val(datum.value);
                $('#setor').val(datum.distrito);

            });
    </script>
@endsection
