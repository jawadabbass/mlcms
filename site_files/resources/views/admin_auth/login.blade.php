@extends('layouts.backend.guest')

@section('content')
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">{{ __('Login') }}</p>

            <form method="POST" action="{{ route('admin.login') }}">
                @csrf
                <div class="input-group mb-3">
                    <input id="email" type="email" class="form-control {{ hasError($errors, 'email') }}" name="email"
                        value="{{ old('email') }}" required autocomplete="email" autofocus>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    {!! showErrors($errors, 'email') !!}
                </div>
                <div class="input-group mb-3">
                    <input id="password" type="password" class="form-control {{ hasError($errors, 'password') }}"
                        name="password" required autocomplete="current-password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-eye-slash mr-1" onclick="showHidePassword('password', 'eye_icon');" id="eye_icon"></span>
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    {!! showErrors($errors, 'password') !!}
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">{{ __('Login') }}</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
            @if (Route::has('password.request'))
                <p class="mb-1">
                    <a href="{{ route('admin.password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                </p>
            @endif
        </div>
        <!-- /.login-card-body -->
    </div>
@endsection
@section('beforeBodyClose')
<script>
    function showHidePassword(fieldId, eyeId){
        if($('#'+fieldId).attr('type') == 'password'){
            $('#'+fieldId).attr('type', 'text');
            $('#'+eyeId).removeClass('fa-eye-slash');
            $('#'+eyeId).addClass('fa-eye');
        }else{
            $('#'+fieldId).attr('type', 'password');
            $('#'+eyeId).removeClass('fa-eye');
            $('#'+eyeId).addClass('fa-eye-slash');
        }
    }
</script>
@endsection