@extends('back.layouts.app',['title'=>$title])
@section('content')
    <div class="content-wrapper pl-3 pr-2">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="row">
                <div class="col-md-5 col-sm-12">
                    <ol class="breadcrumb">
                        <li>
                            <a href="{{ base_url() . 'adminmedia' }}">
                                <i class="fas fa-tachometer-alt"></i> Home
                            </a>
                        </li>
                        <li class="active">
                            <a href="{{ base_url() . 'adminmedia/performances' }}">
                                Performances Management
                            </a>
                        </li>
                    </ol>
                </div>
                <div class="col-md-7 col-sm-12">
                    @include('back.common_views.quicklinks')
                </div>
            </div>
        </section>
        <!-- Main content -->
        <section class="content">
            @if(\Session::has('message'))
                <div class="message-container">
                    <div class="callout callout-success">
                        <h4>{{ session('message') }}</h4>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="box">
                        @include('flash::message')
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('performances.store') }}" method="POST" class="form-horizontal"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-body">
                                <div class="row">
                                    @include('back.performances.form')
                                    <div class="col-12 mb-4">
                                        <button type="submit" class="btn btn-success">Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.box -->
                    <!-- /.box -->
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    @include('back.common_views.spinner')
@endsection