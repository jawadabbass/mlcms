@extends('back.layouts.app', ['title' => $title])
@section('beforeHeadClose')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet"
        type="text/css" />
    @php $module = "blog" @endphp
    <link href="{{ base_url() . 'module/blog/admin/css/' . $module . '.css' }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <aside class="right-side {{ session('leftSideBar') == 1 ? 'strech' : '' }}">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="row">
                <div class="col-md-8 col-sm-6">
                    <ol class="breadcrumb">
                        <li><a href="{{ admin_url() }}"> <i class="fa-solid fa-gauge"></i> Home </a></li>
                        <li class="active">Blog Post</li>
                    </ol>
                </div>
                <div class="col-md-4 col-sm-6"> @include('back.common_views.quicklinks') </div>
            </div>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="message-container" style="display: none;" id="action_container">
                <div class="callout callout-success">
                    <h4 id="post_action"></h4>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="box">
                        <div class="row">
                            <div class="col-sm-8">
                                <h3 class="box-title">All Blog Posts</h3>
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
                            <div class="col-sm-4">
                                <div class="text-end" style="padding-bottom:2px;">
                                    <input type="button" class="sitebtn" value="Add New Post" onClick="add_blog_post();" />
                                </div>
                            </div>
                        </div>
                        <div class="box-body table-responsive" style="padding: 15px 0;">
                            <table id="populate-cms-data" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Added Date</th>
                                        <th>All Comment</th>
                                        <th>Preview</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($result)
                                        @foreach ($result as $row)
                                            <tr id="row_{{ $row->ID }}">
                                                <td>
                                                    @if (!empty($row->featured_img))
                                                        <img width="80"
                                                            src="{{ base_url() . 'uploads/blog/' . $row->featured_img }}"
                                                            title="{{ $row->featured_img_title }}"
                                                            alt="{{ $row->featured_img_alt }}">
                                                    @else
                                                        <img width="80"
                                                            src="{{ base_url() . 'back/images/no_image.jpg' }}"
                                                            title="{{ $row->featured_img_title }}"
                                                            alt="{{ $row->featured_img_alt }}">
                                                    @endif
                                                </td>
                                                <td> {{ $row->title }} </td>
                                                <td> @php echo substr(strip_tags($row->description),0,36) @endphp </td>
                                                <td> {{ format_date($row->dated, 'date') }} </td>
                                                <td><a href="{{ admin_url() . 'blog_comments?id=' . $row->ID }}">View
                                                        All <br>
                                                        @if ($row->total_unrevised_comments > 0)
                                                            ({{ 'Unreviewed ' . $row->total_unrevised_comments }})
                                                        @endif
                                                    </a></td>
                                                <td><a href="{{ base_url() . 'blog/' . $row->post_slug }}"
                                                        target="_bank">Preview</a>
                                                </td>
                                                <td> @php
                                                    if ($row->sts == 'active') {
                                                        $class_label = 'success';
                                                    } else {
                                                        $class_label = 'danger';
                                                    }
                                                @endphp
                                                    <a onClick="update_blog_post_status({{ $row->ID }});"
                                                        href="javascript:;" id="sts_{{ $row->ID }}"> <span
                                                            class="label label-{{ $class_label }}">{{ $row->sts }}</span>
                                                    </a>
                                                </td>
                                                <td><a href="javascript:;"
                                                        onClick="load_blog_post_edit_form({{ $row->ID }});"
                                                        class="btn btn-success btn-sm">Edit</a> <a
                                                        href="javascript:delete_blog_post({{ $row->ID }});"
                                                        class="btn btn-danger btn-sm">Delete</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7" align="center" class="text-red">No Record found!</td>
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
    </aside>
    <!-- Add Edit Model-->
    <div class="modal fade" id="blog_post_form_modal" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <form name="blog_post_form" id="blog_post_form" enctype="multipart/form-data" role="form" method="post"
                action="#">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Blog Post</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="box-body">
                            <div class="mb-2">
                                <label for="parent_page">Categories</label>
                                <select id="blog_cat" class="form-control" multiple="multiple" name="blog_cat[]">
                                    @foreach ($all_categories as $all_category)
                                        <option value="{{ $all_category->ID }}">{{ $all_category->cate_title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-2" id="form-errors"></div>
                            <div class="mb-2">
                                <label class="form-label">Heading</label>
                                <input type="text" class="form-control" id="heading" name="heading"
                                    placeholder="Heading">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Post Slug</label>
                                <input type="text" class="form-control" name="post_slug" id="post_slug"
                                    placeholder="Post Slug">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Page Content</label>
                                <textarea id="editor1" name="editor1" rows="8" cols="80"></textarea>
                            </div>
                            <input type="hidden" name="cms_id" id="cms_id" />
                            <div class="mb-2">
                                <label class="form-label">Date Posted:</label>
                                <div id="datepicker" class="mb-2 date">
                                    <input class="form-control" type="date" id="date" name="datepicker" />
                                    <span class="mb-2-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                </div>
                            </div>
                            <div id="fea_img">
                                <label class="form-label"> Upload Featured Image <span style="font-size: 12px;color: red"> max size:
                                        {{ getMaxUploadSize() }}
                                        MB </span> @php echo helptooltip('max_image_size') @endphp </label>
                                <div id="file-field">
                                    <input type="file" name="product_img" id="module_img" class="form-control">
                                    <div id="attached_files_div"></div>
                                </div>
                                <span id="featured_img" style="padding-left:2px;" class="err"></span>
                                <div id="featured_img"></div>
                                <div class="clear"></div>
                                <div class="mt-3 mb-3">
                                    <label class="btn btn-primary img_alt_title_label">Image Title/Alt</label>
                                    <div class="mt-3 mb-3" style="display:none;">
                                        <label class="form-label">Image Title</label>
                                        <input type="text" name="featured_img_title" id="featured_img_title"
                                            class="form-control" placeholder="Featured Image Title" value="">
                                        <label class="mt-3">Image Alt</label>
                                        <input type="text" name="featured_img_alt" id="featured_img_alt"
                                            class="form-control" placeholder="Featured Image Alt" value="">
                                    </div>
                                </div>
                            </div>
                            <div style="clear:both"></div>
                            @include('back.common_views.seo_add')
                            <div style="clear:both"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                        <button type="button" name="submitter" onclick="save_blog_post()" class="btn btn-primary">
                            Update
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('beforeBodyClose')
    <!-- Filer -->
    <script>
        var uploadUrl = "{{ admin_url() }}module_image/upload_image";
        var deleteUrl = "{{ admin_url() }}module_image/remove_image";
        var folder = "blog";
        var maxSize = {{ getMaxUploadSize() }};
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var show_cropper = false;
        var save_method = "POST";
    </script>
    <script type="text/javascript" src="{{ base_url() . 'back/js/fileUploader.js' }}"></script>
    <script type="text/javascript">
        $(document).ready(function(e) {
            $("#heading").change(function() {
                string_to_slug('heading', 'post_slug');
            });
        });
    </script>
    <!----- data table include library and script ----->
    
    <script type="text/javascript" src="{{ base_url() . 'back/js/bootstrap-multiselect.js' }}"></script>
    <script type="text/javascript" src="{{ base_url() . 'module/blog/admin/js/blog.js' }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            @if ($errors->any())
                load_blog_add_form();
            @endif
            table = $('#populate-cms-data').DataTable();
        });
    </script>
    @if (isset($_GET['id']))
        <script>
            $(document).ready(function() {
                load_blog_post_edit_form({{ $_GET['id'] }})
            });
        </script>
    @endif
@endsection
