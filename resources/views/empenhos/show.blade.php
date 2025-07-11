@extends('layouts.app')

@section('title', 'Mapa - Empenho' . ' - ' . __('Show'))

@section('content')
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('mapas.index') }}">
                        Mapa
                    </a>
                </li>
                <li class="breadcrumb-item">
                    Empenho
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ __('Show') }}
                </li>
            </ol>
        </nav>
    </div>

    <div class="container">

        <x-flash-message status='success' message='message' />

        @if ($errors->any())
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form>

            <div class="row g-3">

                <div class="col-md-4">
                    <label for="arp" class="form-label">ARP</label>
                    <input type="text" class="form-control" name="arp" value="{{ $cota->arp }}" readonly>
                </div>

                <div class="col-md-4">
                    <label for="pac" class="form-label">PAC</label>
                    <input type="text" class="form-control" name="pac" value="{{ $cota->pac }}" readonly>
                </div>

                <div class="col-md-4">
                    <label for="pe" class="form-label">PE</label>
                    <input type="text" class="form-control" name="pe" value="{{ $cota->pe }}" readonly>

                </div>

                <div class="col-md-6">
                    <label for="vigenciaInicio" class="form-label">Vigência Inicial</label>
                    <input type="text" class="form-control" name="vigenciaInicio" id="vigenciaInicio"
                        value="{{ date('d/m/Y', strtotime($cota->vigenciaInicio)) }}" readonly>

                </div>

                <div class="col-md-6">
                    <label for="vigenciaFim" class="form-label">Vigência Final</label>
                    <input type="text" class="form-control" name="vigenciaFim" id="vigenciaFim"
                        value="{{ date('d/m/Y', strtotime($cota->vigenciaFim)) }}" readonly>

                </div>

                <div class="col-12">
                    <label for="notas">Anotações</label>
                    <textarea class="form-control" name="notas" rows="3" readonly>{{ $cota->notas }}</textarea>
                </div>

                <div class="col-md-4">
                    <label for="arp" class="form-label">Setor (Sigla)</label>
                    <input type="text" class="form-control" name="arp" value="{{ $cota->sigla }}" readonly>
                </div>

                <div class="col-md-8">
                    <label for="arp" class="form-label">Setor</label>
                    <input type="text" class="form-control" name="arp" value="{{ $cota->setor }}" readonly>
                </div>

                <div class="col-md-3">
                    <label for="arp" class="form-label">SIGMA</label>
                    <input type="text" class="form-control" name="arp" value="{{ $cota->sigma }}" readonly>
                </div>

                <div class="col-md-6">
                    <label for="arp" class="form-label">Objeto</label>
                    <input type="text" class="form-control" name="arp" value="{{ $cota->objeto }}" readonly>
                </div>

                <div class="col-md-3">
                    <label for="arp" class="form-label">Valor (R$)</label>
                    <input type="text" class="form-control" name="arp"
                        value="{{ number_format($cota->valor, 2, ',', '.') }}" readonly>
                </div>

            </div>
        </form>
    </div>

    <div class="container py-3">

        <div class="container bg-warning text-dark">
            <p class="text-center"><strong>Empenhos</strong></p>
        </div>

    </div>



    <div class="container py-2">
        <div class="row">
            <div class="col-10">
                <form>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="quantidade" class="form-label">Cota</label>
                            <input type="text" class="form-control" name="quantidade" value="{{ $cota->quantidade_cota }}" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="empenho" class="form-label">Total de Empenhos</label>
                            <input type="text" class="form-control" name="empenho" value="{{ $cota->empenho_cota }}" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="saldo" class="form-label">Saldo</label>
                            <input type="text" class="form-control" name="saldo"
                                value="{{ $cota->saldo_cota }}" readonly>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-2 d-flex flex-column justify-content-end align-items-end">
                @can('empenho-create')
                    <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal"
                        data-bs-target="#modalNovoEmpenho">
                        <i class="bi bi-plus-circle"></i> Incluir Empenho
                    </button>
                @endcan
            </div>
        </div>
    </div>


    <div class="container py-3">

        @if ($empenhos->isEmpty())
            <div class="alert alert-warning" role="alert">
                Nenhum empenho encontrado para esta cota.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Data</th>
                            <th scope="col">Usuário</th>
                            <th scope="col">Quantidade</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($empenhos as $empenho)
                            <tr>
                                <td>{{ date('d/m/Y', strtotime($empenho->created_at)) }}</td>
                                <td>{{ $empenho->user->name }}</td>
                                <td>{{ $empenho->quantidade }}</td>
                                <td>
                                    <x-btn-group label='Opções'>

                                        @can('cota-edit')
                                            <a href="#" class="btn btn-primary btn-sm" role="button" data-bs-toggle="modal"
                                                data-bs-target="#modalEditarEmpenho"
                                                data-cota-id={{ $empenho->cota_id }}
                                                data-quantidade={{ $empenho->quantidade }}>
                                                <x-icon icon='pencil-square' />
                                            </a>
                                        @endcan

                                        @can('cota-delete')
                                            <a href="#" class="btn btn-danger btn-sm" role="button" data-bs-toggle="modal"
                                                data-bs-target="#modalExcluirEmpenho" data-cota-id={{ $empenho->cota_id }}>
                                                <x-icon icon='trash' />
                                            </a>
                                        @endcan

                                    </x-btn-group>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" class="text-end"><strong>Total:</strong></td>
                            <td>{{ $empenhos->sum('quantidade') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @endif

    </div>



    <div class="container py-4">
        <div class="float-sm-end">

            <a href="{{ route('mapas.index') }}" class="btn btn-secondary btn-lg" role="button">
                <x-icon icon='arrow-left-square' />
                Mapa
            </a>

        </div>
    </div>



    @can('empenho-create')
        <!-- Janela para incluir nova cota -->
        <div class="modal fade" id="modalNovoEmpenho" tabindex="-1" aria-labelledby="Incluir novo empenho" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5"><x-icon icon='plus-circle' /> Incluir Novo Empenho</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('empenhos.store') }}">
                            @csrf
                            <input type="hidden" name="cota_id" id="cota_id" value="{{ $cota->cota_id }}">
                            <div class="row g-3">

                                <div class="col-12">
                                    <label for="quantidade" class="form-label">Quantidade</label>
                                    <input type="number" class="form-control" name="quantidade" id="quantidade" value=""
                                        autocomplete="off" required>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-sm"><x-icon icon='plus-circle' />
                                        Incluir Empenho
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <x-icon icon='x' />
                            Fechar</button>
                    </div>
                </div>
            </div>
        </div>
    @endcan


@endsection
