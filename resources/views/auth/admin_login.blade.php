@extends('layouts.app')
@section('content')
    <div class="loginwrap">
        <div class="loginfrm">
            <h1>Please Login</h1>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="formwrp">
                    <div class="loginrow">
                        <input id="email" type="email"
                            class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                            value="{{ old('email') }}" placeholder="User Name" required autofocus>
                        <i class="fa fa-user" aria-hidden="true"></i>
                    </div>
                    @if ($errors->has('email'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                    <div class="loginrow">
                        <input id="password" type="password"
                            class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"
                            placeholder="Password" required>
                        <i class="fa fa-lock" aria-hidden="true"></i>
                    </div>
                    @if ($errors->has('password'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                    <div class="form-group">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-lg-8 offset-lg-2">
                            <button type="submit" class="btn">
                                {{ __('Login') }}
                            </button>
                            <div class="forgotlink"><a class="btn-link"
                                    href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a></div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="clear"></div>
    </div>
@endsection
