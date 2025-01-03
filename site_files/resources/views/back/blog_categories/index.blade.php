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
                    <div class="p-2 card">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="box-header">
                                    <h3 class=" card-title">Blog Categories</h3>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class=" card-body table-responsive">
                            <form method="post" id="blog-search-form">
                                <div class="mb-3 row">
                                    <div class="col-lg-4">

                                        <button type="button" class="btn btn-sm btn-info" onclick="showFilters();"
                                            id="showFilterbtn btn-sm">Show
                                            Filters</button>
                                        <button type="button" class="btn btn-sm btn-warning" onclick="hideFilters();"
                                            id="hideFilterbtn btn-sm" style="display: none;">Hide Filters</button><br><br>
                                    </div>

                                    <div class="col-sm-8 text-end">
                                        <div class="text-end" style="padding-bottom:2px;">
                                            <a href="{{ admin_url() . 'blog-posts' }}" class="btn btn-sm btn-warning">Blog Posts</a>
                                            <a href="{{ route('blog.category.create') }}" class="btn btn-sm btn-success">Add Blog Category</a>
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
                                        <label for="is_featured">Is Featured?:</label>
                                        <select class="form-control" name="is_featured" id="is_featured">
                                            {!! generateBlogCategoryIsFeaturedDropDown(request('is_featured', '')) !!}
                                        </select>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="show_in_header">Show In Header?:</label>
                                        <select class="form-control" name="show_in_header" id="show_in_header">
                                            {!! generateBlogCategoryShowInHeaderDropDown(request('show_in_header', '')) !!}
                                        </select>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="sts">Status:</label>
                                        <select class="form-control" name="sts" id="sts">
                                            {!! generateBlogCategoryStatusDropDown(request('sts', '')) !!}
                                        </select>
                                    </div>
                                </div>
                                <table class="table table-striped table-bordered" style="width: 100%"
                                    id="blogDatatableAjax">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Title</th>        
                                            <th>Preview</th>
                                            <th>Is Featured?</th>
                                            <th>Show In Header?</th>
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
                    [1, "asc"]
                ],
                paging: true,
                info: true,
                ajax: {
                    url: '{!! route('fetchBlogCategoriesAjax') !!}',
                    data: function(d) {
                        d.search = $('#search').val();
                        d.is_featured = $('#is_featured').val();
                        d.show_in_header = $('#show_in_header').val();
                        d.sts = $('#sts').val();
                    }
                },
                "drawCallback": function(settings) {
                    setToggles();
                },
                columns: [
                    {
                        data: 'featured_img',
                        name: 'featured_img'
                    },
                    {
                        data: 'cate_title',
                        name: 'cate_title'
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
                        data: 'show_in_header',
                        name: 'show_in_header'
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
            $('#is_featured').on('change', function(e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#show_in_header').on('change', function(e) {
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

        function deleteBlogCategory(id) {
            var msg = 'Are you sure?';
            var url = '{{ url('adminmedia/blog-category/') }}/' + id;
            if (confirm(msg)) {
                $.post(url, {
                        id: id,
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    })
                    .done(function(response) {
                        if (response.includes('ok')) {
                            var table = $('#blogDatatableAjax').DataTable();
                            table.row('blogCategoryDtRow' + id).remove().draw(false);
                            Toast.fire({
                                icon: "success",
                                title: "Blog Category Deleted Successfully"
                            });
                        } else {
                            alert('Request Failed!');
                        }
                    });
            }
        }

        function updateBlogCategoryIsFeatured(id) {
            var old_is_featured = 1;
            var new_is_featured = 0;
            if ($('#is_featured_' + id).val() == 0) {
                old_is_featured = 0;
                new_is_featured = 1;
            }
            var url = base_url + 'adminmedia/updateBlogCategoryIsFeatured';
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
                    var table = $('#blogDatatableAjax').DataTable();
                    table.draw();
                });

        }
        function updateBlogCategoryShowInHeader(id) {
            var old_show_in_header = 1;
            var new_show_in_header = 0;
            if ($('#show_in_header_' + id).val() == 0) {
                old_show_in_header = 0;
                new_show_in_header = 1;
            }
            var url = base_url + 'adminmedia/updateBlogCategoryShowInHeader';
            $.post(url, {
                    id: id,
                    show_in_header: new_show_in_header,
                    _token: '{{ csrf_token() }}'
                })
                .done(function(sts) {
                    if (sts == 'Done Successfully!') {
                        $('#show_in_header_' + id).val(new_show_in_header);
                        alertme('<i class="fas fa-check" aria-hidden="true"></i> ' + sts, 'success', true, 1500);
                    } else {
                        $('#show_in_header_' + id).val(old_show_in_header);
                        if (old_show_in_header == 0) {
                            $('#show_in_header_' + id).bootstrapToggle('off', true)
                        } else {
                            $('#show_in_header_' + id).bootstrapToggle('on', true)
                        }
                        alertme('<i class="fas fa-check" aria-hidden="true"></i> ' + sts, 'danger', true, 1500);
                    }
                });

        }
        
        function updateBlogCategoryStatus(id) {
            var old_sts = 1;
            var new_sts = 0;
            if ($('#sts_' + id).val() == 0) {
                old_sts = 0;
                new_sts = 1;
            }
            var url = base_url + 'adminmedia/updateBlogCategoryStatus';
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
            $('input[data-toggle="toggle_show_in_header"]').bootstrapToggle();
            $('input[data-toggle="toggle_sts"]').bootstrapToggle();
        }
        $(document).on('change', 'input[data-toggle="toggle_is_featured"]', function() {
            let id = $(this).attr('data-id');
            updateBlogCategoryIsFeatured(id);
        });
        $(document).on('change', 'input[data-toggle="toggle_show_in_header"]', function() {
            let id = $(this).attr('data-id');
            updateBlogCategoryShowInHeader(id);
        });
        $(document).on('change', 'input[data-toggle="toggle_sts"]', function() {
            let id = $(this).attr('data-id');
            updateBlogCategoryStatus(id);
        });
    </script>
    <!-- Filer -->
@endsection
