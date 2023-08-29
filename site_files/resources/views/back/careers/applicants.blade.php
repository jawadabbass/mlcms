@extends('back.layouts.app', ['title' => $title])

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
                        <li class="active">Jobs Applicants</li>
                    </ol>
                </div>
                <div class="col-md-7 col-sm-12">
                    @include('back.common_views.quicklinks')
                </div>
            </div>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="message-container" id="delete_action" style="display: none">
                <div class="callout callout-danger">
                    <h4>Product has been deleted successfully.</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="box">
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="box-header">
                                    <h3 class="box-title">Jobs Applicants</h3>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="text-end" style="padding-bottom:2px;">
                                    {{-- <input type="button" class="sitebtn" value="Add Product" onclick="add_product()"/> --}}
                                </div>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table-responsive">
                            <table id="table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        {{-- <th>City</th>
                                    <th>Province</th>
                                    <th>Country</th>
                                    <th>Address</th> --}}
                                        {{-- <th>Cover Letter</th> --}}
                                        <th>Attachment</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="sortable">
                                    @forelse($data as $record)
                                        <tr id="{{ $record->ID }}">
                                            <td>{{ $record->fname . ' ' . $record->lname }}</td>
                                            <td>{{ $record->email }}</td>
                                            <td>{{ $record->phone }}</td>
                                            {{-- <td>{{$record->country}}</td>
                                        <td>{{$record->province}}</td>
                                        <td>{{$record->city}}</td>
                                        <td>{{$record->address}}</td> --}}
                                            {{-- <td>{{$record->cover_letter}}</td> --}}
                                            <td><a target="_blank"
                                                    href="{{ asset('uploads/jobs_apply/' . $record->attachment) }}">{{ $record->attachment }}</a>
                                            </td>
                                            <td>
                                                {{-- <a class="btn btn-sm btn-danger" href="javascript:void(0);" title="Delete"
                                               onclick="delete_record({{$record->ID}})">
                                                <i class="glyphicon glyphicon-trash"></i> Delete</a> --}}
                                                <a class="btn btn-sm btn-success" href="<?php echo admin_url() . 'jobs_applicants_details/' . $record->id; ?>"><i
                                                        class="fas fa-eye"></i> View Details</a>
                                                <a class="btn btn-sm btn-info" href="mailto:{{ $record->email }}"><i
                                                        class="fas fa-reply"></i> Reply</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" align="center" class="text-red">No Record found!</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot></tfoot>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                    <!-- /.box -->
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection
@section('beforeBodyClose')
@endsection
