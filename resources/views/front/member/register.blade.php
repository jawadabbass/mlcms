@extends('front.layout.app')
@section('content')
    <!--<div class="breadcrumb-wrap">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="inner-title pull-left">Registration Form</div>
                        <div class="inner-breadcrumb pull-right">
                            <a href="{{ base_url() }}">Home</a> &nbsp; &raquo; &nbsp; <span> Registration Form</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>-->
    <!-- Start Breadcrumb
        ============================================= -->
    <div class="breadcrumb-area shadow dark bg-fixed text-center text-light"
        style="background-image: url(<?php echo base_url(); ?>front/img/banner/22.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <h1>User Register</h1>
                    <ul class="breadcrumb">
                        <li><a href="#"><i class="fas fa-home"></i> Home</a></li>
                        <li class="active">login</li>
                    </ul>
                </div>
            </div>
        </div>
    </div><br />
    <!-- End Breadcrumb -->
    <!--about page-->
    <div class="inner-wrap">
        <div class="container">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    @if (\Session::get('added_action') == 'success')
                        <div class="message-container">
                            <div class="alert alert-success">
                                You've been enrolled successfully!
                            </div>
                        </div>
                    @elseif (\Session::get('added_action') == 'error')
                        <div class="message-container">
                            <div class="alert alert-danger">
                                Please check these error(s).
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @elseif (\Session::get('added_action') == 'not_exist')
                        <div class="message-container">
                            <div class="alert alert-danger">
                                Please signup from here.
                            </div>
                        </div>
                    @endif
                    <div class="regForm member_forms login-area">
                        <form action="{{ route('register') }}" method="post" enctype="multipart/form-data"
                            id="validatethis" class="white-popup-block">
                            @csrf
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="">Full Name <span
                                                class="required_sign form_error">*</span></label>
                                        <input id="name" type="text"
                                            class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                            name="name" value="{{ old('name') }}" placeholder="Full Name" required
                                            autofocus>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="">User Name (Email)
                                            <span class="form_error" id="userEN">*</span>
                                        </label>
                                        <input id="Email" type="email" placeholder="User Name (Email)"
                                            class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                            name="email" value="{{ old('email') }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="">Create Password
                                            <span class="required_sign form_error">*</span>
                                        </label>
                                        <input id="password" type="password"
                                            class="user_pass form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                            name="password" required>
                                        <div id="pswd_info" style="display:none">
                                            <h4>The Password field must meet the following requirements:</h4>
                                            <ul>
                                                <li id="letter" class="invalid">At least <strong>one small
                                                        letter</strong></li>
                                                <li id="capital" class="invalid">At least <strong>one capital
                                                        letter</strong></li>
                                                <li id="number" class="invalid">At least <strong>three(3)
                                                        numbers</strong></li>
                                                <li id="length" class="invalid">Be at least <strong>8
                                                        characters</strong></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="">Confirm Password <span
                                                class="required_sign form_error">*</span></label>
                                        <input id="password-confirm" type="password" class="form-control"
                                            name="password_confirmation" required>
                                        <div id="pswd_info2" style="display:none">
                                            <ul>
                                                <li id="match" class="invalid"><strong>Password does not match!</strong>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr />
                            <div class="row">
                                <div class="col-sm-12">
                                    <button type="submit" class="sbutn btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-2"></div>
            </div>
        </div>
    </div><br />
@endsection
