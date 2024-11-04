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
                            <a href="{{ base_url() . 'adminmedia/news' }}">
                                News Management
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
                    <div class="card p-2">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="box-header">
                                    <h3 class=" card-title">All News</h3>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class=" card-body table-responsive">
                            <form method="post" id="news-search-form">
                                <div class="row mb-3">
                                    <div class="col-lg-4">

                                        <button type="button" class="btn btn-info" onclick="showFilters();"
                                            id="showFilterBtn">Show
                                            Filters</button>
                                        <button type="button" class="btn btn-warning" onclick="hideFilters();"
                                            id="hideFilterBtn" style="display: none;">Hide Filters</button><br><br>
                                    </div>

                                    <div class="col-sm-8 text-end">
                                        <div class="text-end" style="padding-bottom:2px;">
                                            <a href="{{ route('news.create') }}" class="sitebtn">Add News</a>
                                        </div>
                                        <a href="{{ route('news.sort') }}" class="btn btn-warning">
                                            <i class="la la-bars"></i>Sort News
                                        </a>
                                    </div>

                                </div>

                                <div class="row mb-3" id="filterForm" style="display: none;">
                                    <div class="col-md-3 form-group">
                                        <label>Title</label>
                                        <input id="title" name="title" type="text" placeholder="Title"
                                            value="{{ request('title', '') }}" class="form-control">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>Description</label>
                                        <input id="description_search" name="description" type="text"
                                            placeholder="Description" value="{{ request('description', '') }}"
                                            class="form-control">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="status">Status:</label>
                                        <select class="form-control" name="status" id="status">
                                            {!! generateNewsStatusDropDown(request('status', '')) !!}
                                        </select>
                                    </div>
                                </div>
                                <table class="table table-striped table-bordered" style="width: 100%"
                                    id="newsDatatableAjax">
                                    <thead>
                                        <tr>
                                            <th>News<br />Date</th>
                                            <th>Image</th>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                        <!-- /. card-body -->
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
    <script>
        $(function() {
            var oTable = $('#newsDatatableAjax').DataTable({
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
                    url: '{!! route('fetchNewsAjax') !!}',
                    data: function(d) {
                        d.title = $('#title').val();
                        d.description = $('#description_search').val();
                        d.status = $('#status').val();
                    }
                },
                "drawCallback": function(settings) {
                    setToggles();
                },
                columns: [{
                        data: 'news_date_time',
                        name: 'news_date_time'
                    },
                    {
                        data: 'image',
                        name: 'image'
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('#news-search-form').on('submit', function(e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#title').on('keyup', function(e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#description_search').on('keyup', function(e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#status').on('change', function(e) {
                oTable.draw();
                e.preventDefault();
            });
        });

        function showFilters() {
            $('#filterForm').show('slow');
            $('#showFilterBtn').hide('slow');
            $('#hideFilterBtn').show('slow');
        }

        function hideFilters() {
            $('#filterForm').hide('slow');
            $('#showFilterBtn').show('slow');
            $('#hideFilterBtn').hide('slow');
        }

        function deleteNews(id) {
            var msg = 'Are you sure?';
            var url = '{{ url('adminmedia/news/') }}/' + id;
            if (confirm(msg)) {
                $.post(url, {
                        id: id,
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    })
                    .done(function(response) {
                        if (response.includes('ok')) {
                            var table = $('#newsDatatableAjax').DataTable();
                            table.row('newsDtRow' + id).remove().draw(false);
                        } else {
                            alert('Request Failed!');
                        }
                    });
            }
        }

        function updateNewsStatus(id) {
            var old_status = 1;
            var new_status = 0;
            if ($('#status_' + id).val() == 0) {
                old_status = 0;
                new_status = 1;
            }
            var url = base_url + 'adminmedia/updateNewsStatus';
            $.post(url, {
                    id: id,
                    status: new_status,
                    _token: '{{ csrf_token() }}'
                })
                .done(function(sts) {
                    if (sts == 'Done Successfully!') {
                        $('#status_' + id).val(new_status);
                        alertme('<i class="fas fa-check" aria-hidden="true"></i> ' + sts, 'success', true, 1500);
                    } else {
                        $('#status_' + id).val(old_status);
                        if (old_status == 0) {
                            $('#status_' + id).bootstrapToggle('off', true)
                        } else {
                            $('#status_' + id).bootstrapToggle('on', true)
                        }
                        alertme('<i class="fas fa-check" aria-hidden="true"></i> ' + sts, 'danger', true, 1500);
                    }
                });

        }

        function setToggles() {
            $('input[data-toggle="toggle_status"]').bootstrapToggle();
        }
        $(document).on('change', 'input[data-toggle="toggle_status"]', function() {
            let id = $(this).attr('data-id');
            updateNewsStatus(id);
        });
    </script>
    <!-- Filer -->
@endsection
