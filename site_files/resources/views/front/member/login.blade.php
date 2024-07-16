@extends('front.layout.app')
@section('content')
    <!-- Start Breadcrumb
        ============================================= -->
    <div class="breadcrumb-area shadow dark bg-fixed text-center text-light"
        style="background-image: url(<?php echo base_url(); ?>front/img/banner/22.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <h1>User Login</h1>
                    <ul class="breadcrumb">
                        <li><a href="#"><i class="fas fa-home"></i> Home</a></li>
                        <li><a href="#">Pages</a></li>
                        <li class="active">login</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumb -->
    <!--about page-->
    <div class="inner-wrap">
        <!-- Start Login
        ============================================= -->
        <div class="login-area default-padding">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        @if (\Session::get('added_action') == 'success')
                            <div class="message-container">
                                <div class="alert alert-success">
                                    You've been enrolled successfully!
                                </div>
                            </div>
                        @elseif (\Session::get('added_action') == 'not_exist')
                            <div class="message-container">
                                <div class="alert alert-danger">
                                    Please signup from here.
                                </div>
                            </div>
                        @elseif (\Session::get('logout') == 'success')
                            <div class="message-container">
                                <div class="alert alert-success">
                                    Dear member, you sre logged out successfully!.
                                </div>
                            </div>
                        @elseif (\Session::get('pass_changed') == true)
                            <div class="message-container">
                                <div class="alert alert-success">
                                    Dear member, your password has been changed. Please login using the new credentials.
                                </div>
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="message-container">
                                <div class="alert alert-danger">
                                    Please check these error(s).
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if (isset($msg))
                            <div class="message-container">
                                <div class="alert alert-danger">
                                    {{ $msg }}
                                </div>
                            </div>
                        @endif
                        <form action="{{ route('login') }}" method="post" enctype="multipart/form-data" id="validatethis"
                            class="white-popup-block">
                            @csrf
                            <div class="login-custom">
                                <h4>Login to your registered account!</h4>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="form-group">
                                            <input id="email" type="email"
                                                class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                                name="email" value="{{ old('email') }}" placeholder="User Name"
                                                id="uname" required autofocus>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="form-group">
                                            <input id="pass" type="password"
                                                class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                                name="password" placeholder="Password" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <!--<label for="login-remember"><input type="checkbox" id="login-remember">Remember Me</label>-->
                                        <label>
                                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                            {{ __('Remember Me') }}
                                        </label>
                                        <a title="Lost Password" class="forgotpass member_links lost-pass-link"
                                            href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <button type="submit" class="fbutn btn btn-primary" value="Login"> Login </button>
                                    </div>
                                </div>
                                <p class="link-bottom">Not a member yet? <a href="{{ base_url() . 'member/register' }}"
                                        class="member_links pull-center">Sign Up Now!</a></p>
                            </div>
                        </form>
                        <form action="{{ route('login') }}" method="post" enctype="multipart/form-data" id="validatethis">

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Login Area -->
    </div>
@endsection
