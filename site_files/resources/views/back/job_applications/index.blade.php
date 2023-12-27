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
                            <a href="{{ base_url() . 'adminmedia/job-applications' }}">
                                Job Applications Management
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
                    <div class="box">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="box-header">
                                    <h3 class="box-title">All Job Applications</h3>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table-responsive">
                            <form method="post" id="jobApplication-search-form">
                                <div class="row mb-3" id="filterForm">
                                    <div class="col-md-3 form-group">
                                        <label>Job Title</label>
                                        <input id="title" name="title" type="text" placeholder="Title"
                                            value="{{ request('title', '') }}" class="form-control">
                                    </div>
                                </div>
                                <table class="table table-striped table-bordered" style="width: 100%"
                                    id="jobApplicationsDatatableAjax">
                                    <thead>
                                        <tr>
                                            <th>Date Applied</th>
                                            <th>Job Title</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </form>
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
    @include('back.common_views.spinner')
@endsection
@section('beforeBodyClose')
    <div class="modal" tabindex="-1" role="dialog" id="jobApplicationSHowModel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Job Application Details</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body" id="jobApplicationSHowModelBody">Wait...</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function() {
            var oTable = $('#jobApplicationsDatatableAjax').DataTable({
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
                    url: '{!! route('fetchJobApplicationsAjax') !!}',
                    data: function(d) {
                        d.title = $('#title').val();
                    }
                },
                columns: [{
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'career_id',
                        name: 'career_id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
            $('#jobApplication-search-form').on('submit', function(e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#title').on('keyup', function(e) {
                oTable.draw();
                e.preventDefault();
            });
        });

        function deleteJobApplication(id) {
            var msg = 'Are you sure?';
            var url = '{{ url('adminmedia/job-application/') }}/' + id;
            if (confirm(msg)) {
                $.post(url, {
                        id: id,
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    })
                    .done(function(response) {
                        if (response.includes('ok')) {
                            var table = $('#jobApplicationsDatatableAjax').DataTable();
                            table.row('jobApplicationDtRow' + id).remove().draw(false);
                        } else {
                            alert('Request Failed!');
                        }
                    });
            }
        }

        function showJobApplication(id) {
            var url = `{{ url('adminmedia/job-application') }}/${id}`;
            $.ajax({
                url: url,
                type: 'GET',
                processData: false,
                contentType: false,
                cache: false,
                success: function(response) {
                    $('#jobApplicationSHowModelBody').html(response);
                    $('#jobApplicationSHowModel').modal('show');
                }
            });
        }
    </script>
    <!-- Filer -->
@endsection
