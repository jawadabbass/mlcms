@extends('back.layouts.app', ['title' => $title ?? ''])
{{-- <link href="{{asset('front/css/auto_complete.css')}}" rel="stylesheet"> --}}
@section('content')
    <div class="emailmoduletemplate">
        <div class="content-wrapper pl-3 pr-2">
            <section class="content-header">
                <div class="row">
                    <div class="col-md-5 col-sm-12">
                        <ol class="breadcrumb">
                            <li><a href="{{ admin_url() }}"><i class="fas fa-tachometer-alt"></i> Home</a></li>
                            <li class="active">Manage Admin Users</li>
                        </ol>
                    </div>
                    <div class="col-md-7 col-sm-12">
                        @include('back.common_views.quicklinks')
                    </div>
                </div>
            </section>
            <section class="content">
                <div class="box">
                    <div class="alert alert-success" role="alert">
                        <h4 class="alert-heading">Email queued successfully!</h4>
                        <p>All emails were queued successfully, and will be dispatched accordingly.</p>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
