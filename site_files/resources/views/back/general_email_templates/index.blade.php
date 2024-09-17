@extends('back.layouts.app', ['title' => $title])

@section('content')
<div class="content-wrapper pl-3 pr-2">
    <section class="content-header">
        <div class="row">
            <div class="col-md-5 col-sm-12">
                <ol class="breadcrumb">
                    <li><a href="{{ admin_url() }}"><i class="fas fa-tachometer-alt"></i> Home</a></li>
                    <li class="active">Manage Email Templates</li>
                </ol>
            </div>
            <div class="col-md-7 col-sm-12">
                @include('back.common_views.quicklinks')
            </div>
        </div>
    </section>
        <!-- Main content -->
        <section class="content">
            @include('flash::message')
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="card">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-header">
                                    <h3 class="card-title">All Email Templates</h3>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <form method="post" id="generalEmailTemplate-search-form">
                                <div class="row">
                                    <div class="col-md-3 form-group">
                                        <label>Template Name</label>
                                        <input id="template_name" name="template_name" type="text"
                                            placeholder="Template Name" value="{{ request('template_name', '') }}"
                                            class="form-control">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>Subject</label>
                                        <input id="subject" name="subject" type="text" placeholder="Subject"
                                            value="{{ request('subject', '') }}" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 text-right">
                                        <a class="btn btn-success" href="{{ route('generalEmailTemplates.create') }}">Add
                                            New Mail Template</a>
                                    </div>
                                </div>
                                <table class="table table-striped table-bordered" style="width: 100%"
                                    id="generalEmailTemplateDatatableAjax">
                                    <thead>
                                        <tr>
                                            <th>Template<br />Name</th>
                                            <th>Subject</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    <!-- /.card -->
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    @include('back.common_views.spinner')
@endsection
@section('beforeBodyClose')
    <script>
        $(function() {
            var oTable = $('#generalEmailTemplateDatatableAjax').DataTable({
                "autoWidth": true,
                processing: true,
                serverSide: true,
                stateSave: true,
                searching: false,
                "order": [
                    [0, "asc"]
                ],
                paging: true,
                info: true,
                ajax: {
                    url: '{!! route('fetchGeneralEmailTemplatesAjax') !!}',
                    data: function(d) {
                        d.template_name = $('#template_name').val();
                        d.subject = $('#subject').val();
                    }
                },
                columns: [{
                        data: 'template_name',
                        name: 'template_name'
                    },
                    {
                        data: 'subject',
                        name: 'subject'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('#generalEmailTemplate-search-form').on('submit', function(e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#template_name').on('keyup', function(e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#subject').on('keyup', function(e) {
                oTable.draw();
                e.preventDefault();
            });
        });
    </script>
    <!-- Filer -->
@endsection
