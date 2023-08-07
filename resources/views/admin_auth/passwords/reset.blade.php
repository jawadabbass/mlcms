@extends('layouts.backend.guest')

@section('content')
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">{{ __('Reset Password') }}</p>

            <form method="POST" action="{{ route('admin.password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="input-group mb-3">
                    <input id="email" type="email" class="form-control {{ hasError($errors, 'email') }}" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus placeholder="Email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    {!! showErrors($errors, 'email') !!}
                </div>
                <div class="input-group mb-3">
                    <input id="password" type="password" class="form-control {{ hasError($errors, 'password') }}"
                        name="password" required autocomplete="current-password"  placeholder="New Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-eye-slash mr-1" onclick="showHidePassword('password', 'eye_icon');" id="eye_icon"></span>
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    {!! showErrors($errors, 'password') !!}
                </div>
                <div class="input-group mb-3">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password"  placeholder="Confirm New password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-eye-slash mr-1" onclick="showHidePassword('password-confirm', 'eye_icon_confirm');" id="eye_icon_confirm"></span>
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">{{ __('Reset Password') }}</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
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