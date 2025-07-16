@extends('layouts.app')

@section('title', __('About'))

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <h1 style="font-size:4rem; font-weight:bold;">
                {{ env('APP_NAME', 'Sistema') }}
            </h1>
            <h2 style="font-size:2rem; margin-top:1rem;">Versão 0.1 - Beta</h2>

            <br><br><br>

            <p style="font-size:1.25rem;">
                Erivelton da Silva<br>
                Analista de Sistemas<br>
                Departamento de Desenvolvimento de Sistemas<br>
                Secretária Municipal de Saúde de Contagem<br>
                erivelton.silva@contagem.mg.gov.br<br>
                Ramal: (31) 3472-6298
            </p>

        </div>
    </div>
</div>
@endsection
