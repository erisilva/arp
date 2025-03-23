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
        {{ __('Edit') }}
      </li>
    </ol>
  </nav>
</div>

<div class="container">
    <x-flash-message status='success'  message='message' />

    <form method="POST" action="{{ route('setors.update', $setor->id) }}">
    @csrf
    @method('PUT')
    <div class="row g-3">
      <div class="col-md-3">
        <label for="sigla" class="form-label">Sigla</label>
        <input type="text" class="form-control @error('sigla') is-invalid @enderror" name="sigla" value="{{ old('sigla') ?? $setor->sigla }}">
        @error('sigla')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
      <div class="col-md-9">
        <label for="descricao" class="form-label">{{ __('Description') }}</label>
        <input type="text" class="form-control @error('descricao') is-invalid @enderror" name="descricao" value="{{ old('descricao') ?? $setor->descricao }}">
        @error('descricao')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
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

        @can('setor-create')
            <a href="{{ route('setors.create') }}" class="btn btn-primary btn-lg" role="button">
                <x-icon icon='file-earmark' />
                {{ __('New') }}
            </a>
        @endcan

        <a href="{{ route('setors.index') }}" class="btn btn-secondary btn-lg" role="button">
            <x-icon icon='arrow-left-square' />
            Setores
        </a>

    </div>
</div>
@endsection
