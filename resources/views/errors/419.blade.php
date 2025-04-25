@extends('layouts.clear')

@section('title', 'Erro 419: ' . __('Page Expired'))

@section('content')
<div class="container py-6">
    <div class="row">
        <div class="col-md-4 offset-md-4">
			<div class="card bg-warning text-white">
			  <div class="card-body">
			  	<h5 class="card-title"><i class="bi bi-exclamation-triangle"></i> Erro 419: {{ __('Page Expired') }}</h5>
    			<p class="card-text">{{ $exception->getMessage() }}</p>
    			<a href="{{ url('/') }}" class="btn btn-primary"><i class="bi bi-arrow-clockwise"></i> {{ __('Reload Page') }}</a>
			  </div>
			</div>
        </div>
    </div>
</div>
@endsection
