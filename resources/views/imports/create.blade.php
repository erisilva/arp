@extends('layouts.app')

@section('title', 'Importações - ' . __('New'))

@section('content')
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('imports.index') }}">Importações</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ __('New') }}
                </li>
            </ol>
        </nav>
    </div>

    <div class="container">

        {{-- Display any validation errors from arquivo --}}
        @if ($errors->has('arquivo'))
            <div class="alert alert-danger">
                <strong>{{ $errors->first('arquivo') }}</strong>
            </div>
        @endif

        <form method="POST" action="{{ route('imports.store') }}"  enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="descricao" class="form-label">{{ __('Description') }} (Opcional)</label>
                    <input type="text" class="form-control @error('descricao') is-invalid @enderror" name="descricao"
                        value="{{ old('descricao') ?? '' }}">
                    @error('descricao')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="import_type" class="form-label">Selecione o tipo de importação</label>
                    <select class="form-select  @error('descricao') is-invalid @enderror" id="import_type" name="import_type" required>
                        <option value=''>Selecione o tipo de importação</option>
                        <option value='1'>Modelo 1 - Importar Somente Cotas</option>
                    </select>
                    @error('import_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="arquivo" class="form-label">Somente são aceitos os seguintes formatos para o arquivo: xls ou xlsx. Cada arquivo
                        não pode ter mais de 5Mb. Você pode adicionar apenas um único arquivos por vez.</label>
                    <input type="file" class="form-control-file" id="arquivo" name="arquivo" data-show-upload="true"
                        data-show-caption="true" accept=".xls,.xlsx" required>
                    @error('arquivo')
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

            @can('import-create')
                <a href="{{ route('imports.create') }}" class="btn btn-primary btn-lg" role="button">
                    <x-icon icon='file-earmark' />
                    {{ __('New') }}
                </a>
            @endcan

            <a href="{{ route('imports.index') }}" class="btn btn-secondary btn-lg" role="button">
                <x-icon icon='arrow-left-square' />
                {{ __('imports') }}
            </a>

        </div>
    </div>
@endsection
