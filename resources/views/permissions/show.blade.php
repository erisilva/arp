@extends('layouts.app')

@section('title', __('Users') . ' - ' . __('Permissions') . ' - ' . __('Show'))

@section('content')
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('users.index') }}">
                        {{ __('Users') }}
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('permissions.index') }}">
                        {{ __('Permissions') }}
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ __('Show') }}
                </li>
            </ol>
        </nav>
    </div>

    <x-card title="{{ __('Permission') }}">
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                {{ __('Name') . ' : ' . $permission->name }}
            </li>
            <li class="list-group-item">
                {{ __('Description') . ' : ' . $permission->description }}
            </li>
        </ul>
    </x-card>

    @can('permission-delete')
        <x-btn-trash />
    @endcan

    <div class="container py-4">
        <div class="float-sm-end">

            @can('permission-create')
                <a href="{{ route('permissions.create') }}" class="btn btn-primary btn-lg" role="button">
                    <x-icon icon='file-earmark' />
                    {{ __('New') }}
                </a>
            @endcan

            <a href="{{ route('permissions.index') }}" class="btn btn-secondary btn-lg" role="button">
                <x-icon icon='arrow-left-square' />
                {{ __('Permissions') }}
            </a>

        </div>
    </div>

    @can('permission-delete')
        <x-modal-trash class="modal-sm">
            <form method="post" action="{{route('permissions.destroy', $permission->id)}}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <x-icon icon='trash' /> {{ __('Delete this record?') }}
                </button>
            </form>
        </x-modal-trash>
    @endcan

@endsection
