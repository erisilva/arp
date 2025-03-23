@extends('layouts.app')

@section('title', 'Setores')

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="{{ route('setors.index') }}">
          Setores
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
      {{'Sigla : ' . $setor->sigla }}
    </li>
    <li class="list-group-item">
      {{ 'Descrição : ' . $setor->descricao }}
    </li>
  </ul>
</x-card>

@can('setor-delete')
<x-btn-trash />
@endcan

<x-btn-back route="setors.index" />

@can('setor-delete')
<x-modal-trash class="modal-sm">
  <form method="post" action="{{route('setors.destroy', $setor->id)}}">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">
      <x-icon icon='trash' /> {{ __('Delete this record?') }}
    </button>
  </form>
</x-modal-trash>
@endcan

@endsection
