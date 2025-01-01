@extends('back.layouts.app', ['title' => $title])
@section('content')
    <div class="pl-3 pr-2 content-wrapper">
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
                        <li class="active"><a href="{{ base_url() . 'adminmedia/blog-posts' }}">
                                Blog Management
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
                    <div class="p-3 card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3>Edit Blog Post</h3>
                                </div>
                                <div class="text-right col-md-6">
                                    <a href="{{ url('adminmedia/record-update-history/BlogPost/' . $blogPostObj->id) }}"
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
                            <form action="{{ route('blog.post.update', ['blogPostObj' => $blogPostObj->id]) }}" method="POST"
                                class="form-horizontal" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-body">
                                    <div class="row">
                                        @include('back.blog.form')
                                        <div class="mb-4 col-12">
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
