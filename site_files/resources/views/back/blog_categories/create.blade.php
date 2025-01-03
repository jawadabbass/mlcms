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
                        <li class="active">
                            <a href="{{ base_url() . 'adminmedia/blog-categories' }}">
                                Blog Category Management
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
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="p-3 card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3>Add Blog Category</h3>
                                </div>
                                <div class="text-right col-md-6">
                                    
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
                            <form  id="blog_category_form" action="{{ route('blog.category.store') }}" method="POST" class="form-horizontal"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        @include('back.blog_categories.form')
                                        <div class="mb-4 col-12">
                                            <button type="submit" class="btn btn-sm btn-success">Save</button>
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
