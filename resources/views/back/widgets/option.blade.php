@extends('back.layouts.app', ['title' => $title ?? ''])
@section('content')
    <aside class="right-side {{ session('leftSideBar') == 1 ? 'strech' : '' }}">
        <!-- Block Header (Page header) -->
        <section class="content-header">
            <div class="row">
                <div class="col-md-8 col-sm-6">
                    <ol class="breadcrumb">
                        <li><a href="{{ admin_url() . '' }}"><i class="fa-solid fa-gauge"></i> Home</a></li>
                        <li class="active">Widgets Management</li>
                    </ol>
                </div>
                <div class="col-md-4 col-sm-6"> @include('back.common_views.quicklinks') </div>
            </div>
        </section>
        <section class="content">
            @if (\Session::has('update_action'))
                <div class="message-container">
                    <div class="callout callout-success">
                        <h4>Record has been updated successfully.</h4>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-sm-8">
                    <h3 class="box-title">Create Setting</h3>
                </div>
                <div class="col-sm-4">
                    <div class="text-end" style="padding-bottom:2px;">
                        <a href="{{ route('widgets.index') }}" class="btn btn-success"><i class="fa-solid fa-angle-double-left">Go
                                Back</i></a>
                    </div>
                </div>
            </div>
            <form enctype="multipart/form-data" role="form" method="post"
                action="{{ route('widget.option.update', $widget->ID) }}">
                @csrf
                <div class="mb-2">
                    <label class="form-label">Pages Id</label>
                    <input type="text" class="form-control" id="heading" name="pages_id"
                        value="{{ $widget->pages_id }}" placeholder="1,2,3,4">
                </div>
                @if (!empty($admin_data))
                    <div class="mb-2">
                        <label class="form-label">Show Heading</label>
                        <select class="form-control" id="page_menu_option" name="show_heading">
                            <option value="1" @if ($admin_data->show_heading == 1) selected @endif>Yes</option>
                            <option value="0" @if ($admin_data->show_heading == 0) selected @endif>No</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Show content</label>
                        <select class="form-control" id="page_content" name="show_content">
                            <option value="1" @if ($admin_data->show_content == 1) selected @endif>Yes</option>
                            <option value="0" @if ($admin_data->show_content == 0) selected @endif>No</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Show Featured Image</label>
                        <select class="form-control" id="page_featured_img" name="show_featured_img">
                            <option value="1" @if ($admin_data->show_featured_img == 1) selected @endif>Yes</option>
                            <option value="0" @if ($admin_data->show_featured_img == 0) selected @endif>No</option>
                        </select>
                    </div>
                @else
                    <div class="mb-2">
                        <label class="form-label">Show Heading</label>
                        <select class="form-control" id="page_menu_option" name="show_heading">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Show content</label>
                        <select class="form-control" id="page_content" name="show_content">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Show Featured Image</label>
                        <select class="form-control" id="page_featured_img" name="show_featured_img">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                @endif

                <div class="mb-2">
                    <label class="form-label">Additional Field 1</label>
                    <input type="text" name="additional_field_1" class="form-control"
                        value="{{ $widget->additional_field_1 }}">

                </div>
                <div class="mb-2">
                    <label class="form-label">Additional Field 2</label>
                    <input type="text" name="additional_field_2" class="form-control"
                        value="{{ $widget->additional_field_2 }}">

                </div>
                <div class="mb-2">
                    <label class="form-label">Additional Field 3</label>
                    <input type="text" name="additional_field_3" class="form-control"
                        value="{{ $widget->additional_field_3 }}">

                </div>
                <div class="mb-2">
                    <label class="form-label">Additional Field 4</label>
                    <input type="text" name="additional_field_4" class="form-control"
                        value="{{ $widget->additional_field_4 }}">

                </div>
                <div class="mb-2">
                    <label class="form-label">Additional Field 5</label>
                    <input type="text" name="additional_field_5" class="form-control"
                        value="{{ $widget->additional_field_5 }}">

                </div>
                <div class="mb-2">
                    <label class="form-label">Additional Field 6</label>
                    <input type="text" name="additional_field_6" class="form-control"
                        value="{{ $widget->additional_field_6 }}">

                </div>
                <div class="mb-2">
                    <label class="form-label">Additional Field 7</label>
                    <input type="text" name="additional_field_7" class="form-control"
                        value="{{ $widget->additional_field_7 }}">

                </div>
                <div class="mb-2">
                    <label class="form-label">Additional Field 8</label>
                    <input type="text" name="additional_field_8" class="form-control"
                        value="{{ $widget->additional_field_8 }}">

                </div>
                <div class="row">
                    <div class="col-sm-6 text-start"><a href="{{ route('widgets.index') }}" class="btn btn-success">
                            <i class="fa-solid fa-angle-double-left">Go Back</i></a>

                    </div>
                    <div class="col-sm-6 text-end">
                        <button type="submit" name="submitter" class="btn btn-info"
                            style="text-align: right;">Update</button>
                    </div>
                </div>
            </form>
        </section>
    </aside>
@endsection
@section('beforeBodyClose')
    <script type="text/javascript">
        $(document).ready(function(e) {
            $("#heading").change(function() {
                string_to_slug('heading', 'page_slug');
            });

        });
    </script>
    <!-- Filer -->
    <script>
        var uploadUrl = "{{ admin_url() }}module_image/upload_image";
        var deleteUrl = "{{ admin_url() }}module_image/remove_image";
        var baseUrl = '{{ base_url() }}';
        var folder = "widgets";
        var maxSize = {{ session('max_image_size') }};
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var show_cropper = false;
    </script>
@endsection
