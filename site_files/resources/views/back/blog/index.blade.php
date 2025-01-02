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
                            <a href="{{ base_url() . 'adminmedia/blog' }}">
                                Blog Management
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
                    <div class="p-2 card">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="box-header">
                                    <h3 class=" card-title">Blog Posts</h3>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class=" card-body table-responsive">
                            <form method="post" id="blog-search-form">
                                <div class="mb-3 row">
                                    <div class="col-lg-4">

                                        <button type="button" class="btn btn-sm btn btn-info" onclick="showFilters();"
                                            id="showFilterbtn btn-sm">Show
                                            Filters</button>
                                        <button type="button" class="btn btn-sm btn btn-warning" onclick="hideFilters();"
                                            id="hideFilterbtn btn-sm" style="display: none;">Hide Filters</button><br><br>
                                    </div>

                                    <div class="col-sm-8 text-end">
                                        <div class="text-end" style="padding-bottom:2px;">
                                            <a href="{{ admin_url() . 'blog_categories' }}" class="btn btn-sm btn btn-warning">Categories</a>
                                            <a href="{{ route('blog.post.create') }}" class="btn btn-sm btn btn-success">Add Blog Post</a>
                                        </div>
                                    </div>

                                </div>

                                <div class="mb-3 row" id="filterForm" style="display: none;">
                                    <div class="col-md-3 form-group">
                                        <label>Search</label>
                                        <input id="search" name="search" type="text" placeholder="Search"
                                            value="{{ request('search', '') }}" class="form-control">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="sts">Status:</label>
                                        <select class="form-control" name="sts" id="sts">
                                            {!! generateBlogPostStatusDropDown(request('sts', '')) !!}
                                        </select>
                                    </div>
                                </div>
                                <table class="table table-striped table-bordered" style="width: 100%"
                                    id="blogDatatableAjax">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Image</th>
                                            <th>Title</th>
                                            <th>Comments</th>
                                            <th>Preview</th>
                                            <th>Is Featured?</th>
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
            var oTable = $('#blogDatatableAjax').DataTable({
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
                    url: '{!! route('fetchBlogPostsAjax') !!}',
                    data: function(d) {
                        d.search = $('#search').val();
                        d.sts = $('#sts').val();
                    }
                },
                "drawCallback": function(settings) {
                    setToggles();
                },
                columns: [{
                        data: 'dated',
                        name: 'dated'
                    },
                    {
                        data: 'featured_img',
                        name: 'featured_img'
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'total_unrevised_comments',
                        name: 'total_unrevised_comments'
                    },
                    {
                        data: 'preview',
                        name: 'preview'
                    },
                    {
                        data: 'is_featured',
                        name: 'is_featured'
                    },
                    {
                        data: 'sts',
                        name: 'sts'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('#blog-search-form').on('submit', function(e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#search').on('keyup', function(e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#sts').on('change', function(e) {
                oTable.draw();
                e.preventDefault();
            });
        });

        function showFilters() {
            $('#filterForm').show('slow');
            $('#showFilterbtn btn-sm').hide('slow');
            $('#hideFilterbtn btn-sm').show('slow');
        }

        function hideFilters() {
            $('#filterForm').hide('slow');
            $('#showFilterbtn btn-sm').show('slow');
            $('#hideFilterbtn btn-sm').hide('slow');
        }

        function deleteBlogPost(id) {
            var msg = 'Are you sure?';
            var url = '{{ url('adminmedia/blog-post/') }}/' + id;
            if (confirm(msg)) {
                $.post(url, {
                        id: id,
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    })
                    .done(function(response) {
                        if (response.includes('ok')) {
                            var table = $('#blogDatatableAjax').DataTable();
                            table.row('blogPostDtRow' + id).remove().draw(false);
                            Toast.fire({
                                icon: "success",
                                title: "Blog Post Deleted Successfully"
                            });
                        } else {
                            alert('Request Failed!');
                        }
                    });
            }
        }

        function updateBlogPostIsFeatured(id) {
            var old_is_featured = 1;
            var new_is_featured = 0;
            if ($('#is_featured_' + id).val() == 0) {
                old_is_featured = 0;
                new_is_featured = 1;
            }
            var url = base_url + 'adminmedia/updateBlogPostIsFeatured';
            $.post(url, {
                    id: id,
                    is_featured: new_is_featured,
                    _token: '{{ csrf_token() }}'
                })
                .done(function(sts) {
                    if (sts == 'Done Successfully!') {
                        $('#is_featured_' + id).val(new_is_featured);
                        alertme('<i class="fas fa-check" aria-hidden="true"></i> ' + sts, 'success', true, 1500);
                    } else {
                        $('#is_featured_' + id).val(old_is_featured);
                        if (old_is_featured == 0) {
                            $('#is_featured_' + id).bootstrapToggle('off', true)
                        } else {
                            $('#is_featured_' + id).bootstrapToggle('on', true)
                        }
                        alertme('<i class="fas fa-check" aria-hidden="true"></i> ' + sts, 'danger', true, 1500);
                    }
                });

        }
        
        function updateBlogPostStatus(id) {
            var old_sts = 1;
            var new_sts = 0;
            if ($('#sts_' + id).val() == 0) {
                old_sts = 0;
                new_sts = 1;
            }
            var url = base_url + 'adminmedia/updateBlogPostStatus';
            $.post(url, {
                    id: id,
                    sts: new_sts,
                    _token: '{{ csrf_token() }}'
                })
                .done(function(sts) {
                    if (sts == 'Done Successfully!') {
                        $('#sts_' + id).val(new_sts);
                        alertme('<i class="fas fa-check" aria-hidden="true"></i> ' + sts, 'success', true, 1500);
                    } else {
                        $('#sts_' + id).val(old_sts);
                        if (old_sts == 0) {
                            $('#sts_' + id).bootstrapToggle('off', true)
                        } else {
                            $('#sts_' + id).bootstrapToggle('on', true)
                        }
                        alertme('<i class="fas fa-check" aria-hidden="true"></i> ' + sts, 'danger', true, 1500);
                    }
                });

        }

        function setToggles() {
            $('input[data-toggle="toggle_is_featured"]').bootstrapToggle();
            $('input[data-toggle="toggle_sts"]').bootstrapToggle();
        }
        $(document).on('change', 'input[data-toggle="toggle_is_featured"]', function() {
            let id = $(this).attr('data-id');
            updateBlogPostIsFeatured(id);
        });
        $(document).on('change', 'input[data-toggle="toggle_sts"]', function() {
            let id = $(this).attr('data-id');
            updateBlogPostStatus(id);
        });
    </script>
    <!-- Filer -->
@endsection
