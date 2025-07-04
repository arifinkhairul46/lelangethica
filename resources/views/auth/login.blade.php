@extends('layouts.app')

@section('content')
    <div class="container" style="min-height: 100vh">
        <div class="login text-white">
            <div class="container text-center">
                <a class="brand-image" href="#">
                    <img src="{{ asset('assets/images/ethica_logo.png') }}" width="50%" />
                </a>
                <h6 class="mt-3 text-white"><strong> Selamat Datang di Lelang Fashion Groups Ethica</strong></h6>
            </div>
            <div class="card mt-3">
                <div class="card-body">
                    <form role="form" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group{{ $errors->has('username') ? ' has-danger' : '' }}">
                            <div class="input-group my-3">
                                <input class="form-control form-control-login"
                                    placeholder="{{ __('username') }}" type="username" name="username"
                                    value="{{ old('username') }}" required>
                            </div>
                            @if ($errors->has('username'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('username') }}</strong>
                                </span>
                            @endif
                        </div>
                       
                        <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                            <div class="input-group">
                                <input class="form-control form-control-login"
                                    placeholder="{{ __('password') }}" type="password" name="password" required>
                            </div>
                            @if ($errors->has('password'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                       
                        <div class="text-center mb-3">
                            <button type="submit" class="btn btn-cream mt-4">Login </button>
                        </div>
                    </form>
                   
                </div>
                <!-- /.login-card-body -->
            </div>          
        </div>
    </div>
@endsection


