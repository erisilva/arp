@props(['route'])
<div class="container py-4">
  <div class="float-sm-end">
    <a href="{{ route($route) }}" class="btn btn-primary btn-lg" role="button">
       <x-icon icon='file-earmark' />
       {{ __('Back') }}
    </a>
  </div>      
</div>