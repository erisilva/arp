@extends('layouts.app')

@section('title', 'Objetos')

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="{{ route('objetos.index') }}">
          Objetos
        </a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
        {{ __('Show') }}
      </li>
    </ol>
  </nav>
</div>

<x-card title="Setor">
  <ul class="list-group list-group-flush">
    <li class="list-group-item">
      {{'SIGMA : ' . $objeto->sigma }}
    </li>
    <li class="list-group-item">
      {{ 'Descrição : ' . $objeto->descricao }}
    </li>
  </ul>
</x-card>

@can('objeto-delete')
<x-btn-trash />
@endcan

<x-btn-back route="objetos.index" />

@can('objeto-delete')
<x-modal-trash class="modal-sm">
  <form method="post" action="{{route('objetos.destroy', $objeto->id)}}">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">
      <x-icon icon='trash' /> {{ __('Delete this record?') }}
    </button>
  </form>
</x-modal-trash>
@endcan

@endsection
