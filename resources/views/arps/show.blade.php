@extends('layouts.app')

@section('title', 'ARP' . ' - ' . __('Show'))

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
                    {{ __('Show') }}
                </li>
            </ol>
        </nav>
    </div>

    <div class="container">

        <form>

            <div class="row g-3">

                <div class="col-md-4">
                    <label for="arp" class="form-label">ARP</label>
                    <input type="text" class="form-control" name="arp" value="{{ $arp->arp }}" readonly>

                </div>

                <div class="col-md-4">
                    <label for="pac" class="form-label">PAC</label>
                    <input type="text" class="form-control" name="pac" value="{{$arp->pac }}" readonly>

                </div>

                <div class="col-md-4">
                    <label for="pe" class="form-label">PE</label>
                    <input type="text" class="form-control" name="pe" value="{{$arp->pe }}" readonly>

                </div>

                <div class="col-md-6">
                    <label for="vigenciaInicio" class="form-label">Vigência Inicial</label>
                    <input type="text" class="form-control" name="vigenciaInicio" id="vigenciaInicio"
                        value="{{ date('d/m/Y', strtotime($arp->vigenciaInicio)) }}" readonly>

                </div>

                <div class="col-md-6">
                    <label for="vigenciaFim" class="form-label">Vigência Final</label>
                    <input type="text" class="form-control" name="vigenciaFim" id="vigenciaFim"
                        value="{{ date('d/m/Y', strtotime($arp->vigenciaFim)) }}" readonly>

                </div>

                <div class="col-12">
                    <label for="notas">Anotações</label>
                    <textarea class="form-control" name="notas" rows="3" readonly>{{ old('notas') ?? $arp->notas }}</textarea>
                </div>

            </div>
        </form>
    </div>

    <div class="container py-3">

        <div class="container bg-warning text-dark">
            <p class="text-center"><strong>Objetos</strong></p>
        </div>

    </div>



    <div class="container py-2">

        @if (count($items) > 0)
            @foreach($items->sortBy(fn($item) => $item->objeto->descricao) as $item)

                <div class="container py-2 text-center">


                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h5 class="text-start"><strong>Objeto: </strong> {{ $item->objeto->descricao }} - <strong>Sigma:
                                    </strong> <span class="text-primary">{{ $item->objeto->sigma }}</span></h5>
                                <h5 class="text-end"><strong>Valor: R$ </strong> {{ number_format($item->valor, 2, ',', '.') }}</h5>
                            </div>
                        </div>
                        <div class="card-body">

                            <h5 class="card-title">Cotas</h5>

                            @if (count($item->cotas) > 0)
                            <div class="container py-3">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-start">Setor</th>
                                                <th class="text-start"></th>
                                                <th class="text-end">Quantidade</th>
                                                <th class="text-end">Empenho</th>
                                                <th class="text-end">Saldo</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($item->cotas->sortBy(fn($cota) => $cota->setor->descricao) as $cota)
                                                <tr>
                                                    <td class="text-start">
                                                        <strong>{{$cota->setor->sigla}}</strong>
                                                    </td>
                                                    <td class="text-start">
                                                        {{$cota->setor->descricao}}
                                                    </td>
                                                    <td class="text-end">
                                                        {{$cota->quantidade}}
                                                    </td>
                                                    <td class="text-end">
                                                        {{$cota->empenho}}
                                                    </td>
                                                    <td class="text-end">
                                                        @php
                                                            $saldo = $cota->quantidade - $cota->empenho;
                                                        @endphp
                                                        <strong @if($saldo < 0) class="text-danger" @endif>
                                                            {{ $saldo }}
                                                        </strong>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="2" class="text-end"><strong>Total:</strong></td>
                                                <td class="text-end"><strong>{{ $item->cotas->sum('quantidade') }}</strong></td>
                                                <td class="text-end"><strong>{{ $item->cotas->sum('empenho') }}</strong></td>
                                                <td class="text-end"><strong>{{ $item->cotas->sum('quantidade') - $item->cotas->sum('empenho') }}</strong></td>
                                            </tr>
                                        </tfoot>

                                    </table>
                                </div>
                            </div>
                        @else
                            <p class="card-text">.:Nenhuma cota cadastrada:.</p>
                        @endif

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

    @can('arp-delete')
        <x-btn-trash />
    @endcan

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

    @can('arp-delete')
        <x-modal-trash class="modal-sm">
            <form method="post" action="{{route('arps.destroy', $arp->id)}}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <x-icon icon='trash' /> {{ __('Delete this record?') }}
                </button>
            </form>
        </x-modal-trash>
    @endcan

@endsection
