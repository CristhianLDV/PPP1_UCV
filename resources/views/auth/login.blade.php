@extends('layouts.master-blank')
 
@section('content')

    <div class="wrapper-page">
        <div class="card overflow-hidden account-card mx-3">
            <!-- Encabezado superior con logo + texto -->
       <!-- Encabezado superior con logo + texto -->
            <div class="bg-primary p-5 text-white d-flex align-items-center justify-content-center">
                <div style="margin-right: 20px;">
                    <a href="{{ route('welcome') }}" style="display: inline-block;">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height: 70px;">
                    </a>
                </div>
                <div class="text-left">
                    <h5 class="mb-0 font-weight-bold">Bienvenido nuevamente</h5>
                    <small>Iniciar sesión como Administrador</small>
                </div>
            </div>

             <!-- Cuerpo del login -->
            <div class="account-card-content">
                <form class="form-horizontal m-t-30" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="email" class="col-form-label ">{{ __('Email Address') }}</label>

                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-form-label ">{{ __('Password') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" required autocomplete="current-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                   
                    <div class="form-group row m-t-20">
                        <div class=" col-sm-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-6 text-right">
                            <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Log In</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end wrapper-page -->
@endsection
@section('script')
@endsection


