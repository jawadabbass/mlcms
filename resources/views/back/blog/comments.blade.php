@extends('back.layouts.app', ['title' => 'Blog Admin Media'])
@section('beforeHeadClose')
    @php $module = "blog" @endphp
    <link href="{{ base_url() . 'module/blog/admin/css/' . $module . '.css' }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="content-wrapper pl-3 pr-2">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="row">
                <div class="col-md-5 col-sm-12">
                    <ol class="breadcrumb">
                        <li>
                            <a href="{{ admin_url() }}">
                                <i class="fas fa-gauge"></i> Home
                            </a>
                        </li>
                        <li class="active">Blog Post</li>
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
                    <div class="box">
                        <div class="row">
                            <div class="col-sm-8">
                                <h3 class="box-title">Comments</h3>
                                <ul class="nav nav-pills blog-nav">
                                    <li role="presentation" class="active">
                                        <a href="{{ admin_url() . 'blog' }}" style="padding: 10px;">Blog</a>
                                    </li>
                                    <li role="presentation">
                                        <a href="{{ admin_url() . 'blog_categories' }}"
                                            style="padding: 10px;">Categories</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="box-body table-responsive" style="padding: 15px 0;">
                            <div class="text-end" style="padding-bottom:2px;"></div>
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>User Name</th>
                                        <th>Email</th>
                                        <th>Description</th>
                                        <th>Added Date</th>
                                        <th>Comments Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($blogComments)
                                        @foreach ($blogComments as $row)
                                            <tr id="row_{{ $row->ID }}">
                                                <td>{{ $row->user_name }}</td>
                                                <td>{{ $row->user_emails }}</td>
                                                <td>{{ substr($row->description, 0, 200) }}</td>
                                                <td>{{ date_formats($row->dated, 'm/d/Y') }}</td>
                                                <td>@php
                                                    if ($row->reviewed_status == 'reviewed') {
                                                        $class_label = 'success';
                                                    } else {
                                                        $class_label = 'danger';
                                                    }
                                                @endphp
                                                    <a onClick="update_unrevised_comment_status({{ $row->ID }});"
                                                        href="javascript:;" id="sts_{{ $row->ID }}">
                                                        <span
                                                            class="label label-{{ $class_label }}">{{ $row->reviewed_status }}</span>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="javascript:delete_blog_comments({{ $row->ID }});"
                                                        class="btn btn-danger btn-sm">Delete</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" align="center" class="text-red">No Record found!</td>
                                        </tr>
                                    @endif
                                </tbody>
                                <tfoot>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('beforeBodyClose')
    <script type="text/javascript" src="{{ base_url() . 'module/blog/admin/js/blog.js' }}"></script>
@endsection
