@extends('layouts.backend.guest')

@section('content')
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">{{ __('Reset Password') }}</p>

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.password.email') }}">
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
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">{{ __('Send Password Reset Link') }}</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
        </div>
        <!-- /.login-card-body -->
    </div>
@endsection
