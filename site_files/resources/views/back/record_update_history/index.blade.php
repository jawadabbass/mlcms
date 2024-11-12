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
                        <li class="active">
                            <a href="{{ url()->full() }}">
                                Record Update History Management
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
                    <div class="card">
                        <div class="row card-header">
                            <div class="col-sm-8">
                                <h3 class="card-title">All Record Update History</h3>
                            </div>
                            <div class="col-sm-4 text-end">

                            </div>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body p-2 table-responsive">
                            <form method="post" id="record-update-history-search-form">
                                <input id="record_id" name="record_id" type="hidden"
                                    value="{{ $record_id }}">
                                <input id="model_or_table" name="model_or_table" type="hidden"
                                    value="{{ $model_or_table }}">

                                <table class="table table-striped table-bordered" style="width: 100%"
                                    id="recordUpdateHistoryDatatableAjax">
                                    <thead>
                                        <tr>
                                            <th>Created at</th>
                                            <th>IP</th>
                                            <th>Admin</th>
                                            <th>Record Title</th>
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
            var oTable = $('#recordUpdateHistoryDatatableAjax').DataTable({
                "autoWidth": true,
                processing: true,
                serverSide: true,
                stateSave: true,
                searching: false,
                "order": [
                    [0, "desc"]
                ],
                paging: true,
                info: true,
                ajax: {
                    url: '{!! route('fetch.record.update.history.ajax') !!}',
                    data: function(d) {
                        d.record_id = $('#record_id').val();
                        d.record_title = $('#record_title').val();
                        d.model_or_table = $('#model_or_table').val();
                    }
                },
                columns: [{
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'ip',
                        name: 'ip'
                    },
                    {
                        data: 'admin_id',
                        name: 'admin_id'
                    },
                    {
                        data: 'record_title',
                        name: 'record_title'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>
    <!-- Filer -->
@endsection
