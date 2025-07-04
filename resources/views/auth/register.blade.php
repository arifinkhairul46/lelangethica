@extends('layouts.app')

@section('content')
    <div class="container" style="min-height: 100vh">
        <div class="login text-white">
            <div class="container text-center">
                <a class="brand-image" href="#">
                    <img src="{{ asset('assets/images/ethica_logo.png') }}" width="100px" />
                </a>
                <h6 class="mt-3 text-white"><strong> Selamat Datang di Lelang Fashion Ethica Groups</strong></h6>
            </div>
            <div class="card mt-3">
                <div class="card-body">
                    <form role="form" method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                            <div class="input-group my-3">
                                <input class="form-control form-control-login"
                                    placeholder="{{ __('name') }}" type="name" name="name"
                                    value="{{ old('name') }}" required>
                            </div>
                            @if ($errors->has('name'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('username') ? ' has-danger' : '' }}">
                            <div class="input-group mb-3">
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
                        <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                            <div class="input-group mb-3">
                                <input class="form-control form-control-login"
                                    placeholder="{{ __('email') }}" type="email" name="email"
                                    value="{{ old('email') }}" required>
                            </div>
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
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
                        <div class="form-group mt-3">
                            <select name="role" id="role" class="form-control text-white" required>
                                <option class="text-white" value="" disabled selected>-- Pilih Role --</option>
                                @foreach ($role as $item)
                                    <option class="text-white" value="{{ $item->id }}">{{ $item->role }}</option>
                                @endforeach
                            </select>
                        </div>

                         <div class="form-group{{ $errors->has('nama_toko') ? ' has-danger' : '' }}">
                            <div class="input-group my-3">
                                <input class="form-control form-control-login"
                                    placeholder="{{ __('nama toko') }}" type="text" name="nama_toko"
                                    value="{{ old('nama_toko') }}" required>
                            </div>
                            @if ($errors->has('nama_toko'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('nama_toko') }}</strong>
                                </span>
                            @endif
                        </div>

                         <div class="form-group{{ $errors->has('no_hp') ? ' has-danger' : '' }}">
                            <div class="input-group my-3">
                                <input class="form-control form-control-login"
                                    placeholder="{{ __('no_hp') }}" type="text" name="no_hp"
                                    value="{{ old('no_hp') }}" required>
                            </div>
                            @if ($errors->has('no_hp'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('no_hp') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="text-center mb-3">
                            <button type="submit" class="btn btn-cream mt-4">{{ __('Create account') }}</button>
                        </div>
                    </form>
                    <p class="my-3 text-center">
                        <a href="{{route('login')}}" class="text-center"  style="color: #FF9F00">I already have an account</a>
                    </p>
                </div>
                <!-- /.login-card-body -->
            </div>          
        </div>
    </div>
@endsection


