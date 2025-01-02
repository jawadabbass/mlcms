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
                    <h1>User Dashboard</h1>
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
                    <div class="col-md-3 login-social">
                        @include('front.common_views.loggedin_left')
                    </div>
                    <div class="col-md-9 login-custom">
                        <!--<div class="dashboardTop">
                            <div class="username">{{ $member->name }}</div>
                            <a href="{{ base_url() . 'member/updateprofile' }}" class="edit" title="Edit Profile"><i
                                        class="fa fa-pencil"></i></a>
                        </div>-->
                        <div class="dashboardInt">
                            <h3>Account Information</h3>
                            <ul class="profileList">
                                <li>
                                    <div class="row">
                                        <div class="col-sm-4"><label>First Name :</label></div>
                                        <div class="col-sm-8">{{ $member->name }}</div>
                                    </div>
                                </li>
                                <li>
                                    <div class="row">
                                        <div class="col-sm-4"><label>Email Address (username) :</label></div>
                                        <div class="col-sm-8">{{ $member->email }}</div>
                                    </div>
                                </li>
                                <li>
                                    <div class="row">
                                        <div class="col-sm-4"><label>Password:</label></div>
                                        <div class="col-sm-8">*********
                                            <a class="std_link" href="{{ base_url() . 'member/change_password' }}">
                                                Change Password</a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
