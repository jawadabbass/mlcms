@extends('front.layout.app')
@section('content')
    <!--<div class="breadcrumb-wrap">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="inner-title pull-left"> Dashboard</div>
                        <div class="inner-breadcrumb pull-right">
                            <a href="{{ base_url() }}">Home</a> &nbsp; &raquo; &nbsp; <span> Dashboard </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>-->
    <!-- Start Breadcrumb
        ============================================= -->
    <div class="breadcrumb-area shadow dark bg-fixed text-center text-light"
        style="background-image: url(<?php echo base_url(); ?>front/images/banner/22.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <h1>Edit Profile</h1>
                    <ul class="breadcrumb">
                        <li><a href="#"><i class="fas fa-home"></i> Home</a></li>
                        <li class="active">Dashboard</li>
                    </ul>
                </div>
            </div>
        </div>
    </div><br />
    <!-- End Breadcrumb -->
    <!--about page-->
    <div class="inner-wrap default-padding-40">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1 white-popup-block default-padding-40">
                    <div class="col-md-3">
                        @include('front.common_views.loggedin_left')
                    </div>
                    <div class="col-md-9">
                        <!--<div class="dashboardTopEdit">
                            <div class="username">{{ $member->name }}</div>
                        </div>-->
                        <div class="dashboardInt member_forms">
                            <h3>Account Information</h3>
                            <form action="{{ route('dashboard.update', Auth::user()->id) }}" method="post"
                                enctype="multipart/form-data" id="validatethis">
                                @csrf
                                <div class="input-group">
                                    <input type="text"
                                        class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="name"
                                        value="{{ ' ' }}" placeholder="Full Name" id="uname" required
                                        autofocus>
                                    <br>
                                </div>
                                <!--<div class="input-group">
                                    
                                    <input type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                           name="name" value="{{ ' ' }}" placeholder="Full Name" id="uname"
                                           required autofocus>
                                    <br>
                                </div>-->
                                {{-- $member->name --}}
                                <div class="formbtn">
                                    <button type="submit" class="fbutn btn btn-primary" value="Login">
                                        {{ 'Update' }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
