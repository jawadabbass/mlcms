@extends('back.layouts.app', ['title' => $title])
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
                        <li class="active"><a href="{{ base_url() . 'adminmedia/careers' }}">
                                Careers Management
                            </a></li>
                    </ol>
                </div>
                <div class="col-md-7 col-sm-12">
                    @include('back.common_views.quicklinks')
                </div>
            </div>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="card p-2">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3>Edit Career</h3>
                                </div>
                                <div class="col-md-6 text-right">
                                    <a href="{{ url('adminmedia/record-update-history/Career/' . $careerObj->id) }}"
                                        target="_blank" class=""><i class="fas fa-bars" aria-hidden="true"></i>
                                        History
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
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
                            <form action="{{ route('career.update', ['careerObj' => $careerObj->id]) }}" method="POST"
                                class="form-horizontal" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-body">
                                    <div class="row">
                                        @include('back.careers.form')
                                        <div class="col-12 mb-4">
                                            <button type="submit" class="btn btn-success">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.box -->
                    <!-- /.box -->
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>

@endsection
