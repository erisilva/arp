@extends('layouts.clear')

@section('title', __('Login'))

@section('content')

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <p class="display-1 text-center"><x-icon icon='boxes' /> {{ config('app.name', 'Laravel') }}</p>

            </div>
        </div>
    </div>

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Login') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="captcha_img" class="col-sm-4 col-form-label"></label>
                                <div class="col-md-6">
                                    <div class="captcha_img">
                                        <span>{!! captcha_img() !!}</span>
                                        <button type="button" class="btn btn-danger reload" id="reload"
                                            onclick="location.reload();">
                                            <span><x-icon icon='arrow-clockwise' /></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="captcha" class="col-sm-4 col-form-label text-end">Captcha</label>
                                <div class="col-md-6">
                                    <input id="captcha" type="text"
                                        class="form-control @error('captcha') is-invalid @enderror" name="captcha" required
                                        autocomplete="captcha" placeholder="Digite o código da imagem acima">
                                    @error('captcha')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Login') }}
                                    </button>

                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
