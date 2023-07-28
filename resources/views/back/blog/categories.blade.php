@extends('back.layouts.app', ['title' => $title])
@section('beforeHeadClose')
    @include('back.common_views.switch_css')
    @php $module = "blog" @endphp
    <link href="{{ base_url() . 'module/blog/admin/css/' . $module . '.css' }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="content-wrapper pl-3 pr-2">
        <!-- Block Header (Page header) -->
        <section class="content-header">
            <div class="row">
                <div class="col-md-8 col-sm-6">
                    <ol class="breadcrumb">
                        <li><a href="{{ admin_url() }}">
                                <i class="fas fa-gauge"></i> Home</a></li>
                        <li class="active">Mangage Category</li>
                    </ol>
                </div>
                <div class="col-md-4 col-sm-6"> @include('back.common_views.quicklinks') </div>
            </div>
        </section>
        <!-- Main content -->
        <section class="content">
            @if (\Session::has('added_action') == true)
                <div class="message-container">
                    <div class="callout callout-success">
                        <h4>New Category has been created successfully.</h4>
                    </div>
                </div>
            @endif
            @if (\Session::has('update_action') == true)
                <div class="message-container">
                    <div class="callout callout-success">
                        <h4>Record has been updated successfully.</h4>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="box">
                        <div class="row">
                            <div class="col-sm-8">
                                <h3 class="box-title">All Blog Categories</h3>
                                <ul class="nav nav-pills blog-nav">
                                    <li role="presentation">
                                        <a href="{{ admin_url() . 'blog' }}" style="padding: 10px;">Blog</a>
                                    </li>
                                    <li role="presentation" class="active">
                                        <a href="{{ admin_url() . 'blog_categories' }}"
                                            style="padding: 10px;">Categories</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-sm-4">
                                <div class="text-end" style="padding-bottom:2px;">
                                    <input type="button" class="sitebtn" value="Add New Category"
                                        onClick="load_categories_add_form();" />
                                </div>
                            </div>
                        </div>
                        <div class="box-body table-responsive" style="padding: 15px 0;">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Added Date</th>
                                        <th>Status</th>
                                        <th>Preview</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($result)
                                        @foreach ($result as $row)
                                            <tr id="row_{{ $row->ID }}">
                                                <td>{{ substr($row->cate_title, 0, 40) }}</td>
                                                <td>@php echo substr($row->cate_description, 0, 60) @endphp</td>
                                                <td>{{ format_date($row->dated, 'date') }}</td>
                                                <td>
                                                    <label class="switch">
                                                        <input type="checkbox" name="{{ 'sts_' . $row->ID }}"
                                                            id="{{ 'cat_sts_' . $row->ID }}" <?php echo $row->sts == 'active' ? ' checked' : ''; ?>
                                                            value="<?php echo $row->sts; ?>"
                                                            onClick="update_category_status({{ $row->ID }})">
                                                        <div class="slider round">
                                                            <strong class="on">Active</strong>
                                                            <strong class="off">Inactive</strong>
                                                        </div>
                                                    </label>
                                                </td>
                                                <td><a href="{{ 'blog/category/' . $row->cate_slug }}.html"
                                                        target="_bank">Preview</a></td>
                                                <td><a href="javascript:;"
                                                        onClick="load_category_edit_form({{ $row->ID }});"
                                                        class="btn btn-success btn-sm">Edit</a> <a
                                                        href="javascript:delete_category({{ $row->ID }});"
                                                        class="btn btn-danger btn-sm">Delete</a></td>
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
    <div class="modal fade" id="add_blog_category_form" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <form name="frm_block" id="blog_category" enctype="multipart/form-data" role="form" method="post"
                action="{{ route('blog_categories.store') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add New Category</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="box-body">
                            <div class="mb-2">
                                <label class="form-label">Category Title</label>
                                <input type="text" class="form-control" id="title" name="title"
                                    value="{{ old('title') }}" placeholder="Title">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Category Slug</label>
                                <input type="text" class="form-control" name="cate_slug" id="cate_slug"
                                    value="{{ old('cate_slug') }}" placeholder="Category Slug">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Post Description</label>
                                <textarea id="edit_editor1" name="editor1" rows="8" cols="80" placeholder="Description...">
                                            {{ old('editor1') }}
                                        </textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="submitter" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="edit_frm_blog_cat" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <form name="frm_block" id="edit_form_blog_cate" enctype="multipart/form-data" role="form" method="post"
                action="{{ route('blog_categories.update', 0) }}" onSubmit="return validate_edit_widgets_form(this)">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Category</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="box-body">
                            <div class="mb-2">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" id="edit_title" name="title"
                                    value="{{ old('title') }}" placeholder="Edit Title">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Slug</label>
                                <input type="text" class="form-control" name="cate_slug" id="edit_cate_slug"
                                    value="{{ old('cate_slug') }}" placeholder="Category Slug">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Page Content</label>
                                <textarea id="editor1" name="editor1" rows="8" cols="80">
                                            {{ old('editor1') }}
                                        </textarea>
                            </div>
                        </div>
                        <input type="hidden" name="category_id" id="category_id" />
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="submitter" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('beforeBodyClose')
    <script type="text/javascript">
        $(document).ready(function(e) {
            $("#title").change(function() {
                string_to_slug('title', 'cate_slug');
            });
            table = $('#example2').DataTable();
        });
    </script>
    @if ($errors->any())
        <script type="text/javascript">
            @php $updateId = old('category_id') @endphp
            @if (!empty($updateId))
                load_category_edit_form({{ old('category_id') }});
            @else
                $('#add_blog_category_form').modal('show');
            @endif
        </script>
    @endif
    <script type="text/javascript" src="{{ base_url() . 'module/blog/admin/js/' . $module . '.js' }}"></script>
@endsection
