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
