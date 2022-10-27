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
                    <h3 class="box-title">Edit Widget</h3>
                </div>
                <div class="col-sm-4">
                    <div class="text-end" style="padding-bottom:2px;">
                        {{-- <input type="button" class="sitebtn" value="Add New Widgets"
                  onClick="load_widgets_add_form();"/> --}}
                        <a href="{{ route('widgets.index') }}" class="btn btn-success"><i class="fa-solid fa-angle-double-left">Go
                                Back</i></a>
                    </div>
                </div>
            </div>
            <form enctype="multipart/form-data" role="form" method="post"
                action="{{ route('widget.update', $widget->ID) }}">
                @csrf
                @if (!$admin_data == null)
                    @if ($admin_data->show_heading == 1)
                        <div class="mb-2">
                            <label class="form-label">Heading</label>
                            <input type="text" class="form-control" id="heading" name="heading"
                                value="{{ $widget->heading }}" placeholder="Heading">
                        </div>
                    @endif
                    @if ($admin_data->show_content == 1)
                        <div class="mb-2">
                            <label class="form-label">Widget Content</label>
                            <textarea id="editor1" name="editor1" rows="8" cols="80" placeholder="Describe yourself with 4 words...">{{ $widget->content }}</textarea>
                        </div>
                    @endif

                    @if ($admin_data->show_featured_img == 1)
                        <div id="fea_img">
                            <label class="form-label"> Add Widgets Image <span style="font-size: 12px;color: red"> max size:
                                    {{ session('max_image_size') }}MB </span> @php echo helptooltip('max_image_size') @endphp </label>
                            <div id="file-field">
                                <input type="file" name="module_img" id="module_img" class="form-control module_img">
                                <div id="attached_files_div" class="attached_files_div"></div>
                            </div>
                            <span id="featured_img" style="padding-left:2px;" class="err featured_img"></span>
                            <div id="featured_img" class="featured_img"></div>
                            <div class="clear"></div>
                            <div class="mt-3 mb-3">
                                <label class="btn btn-primary img_alt_title_label">Image Title/Alt</label>
                                <div class="mt-3 mb-3" style="display:none;">
                                    <label class="form-label">Image Title</label>
                                    <input type="text" name="featured_image_title" id="featured_image_title"
                                        class="form-control" placeholder="Featured Image Title" value="{{ $widget->featured_image_title }}">
                                    <label class="mt-3">Image Alt</label>
                                    <input type="text" name="featured_image_alt" id="featured_image_alt"
                                        class="form-control" placeholder="Featured Image Alt" value="{{ $widget->featured_image_alt }}">
                                </div>
                            </div>
                        </div>
                    @endif
                @endif


                @if (!empty($widget->additional_field_1))
                    <div class="mb-2" id="edit_field1">
                        <label class="form-label">{{ $widget->additional_field_1 }}</label>
                        <input type="text" class="form-control" id="edit_additional_field_title_1"
                            name="additional_field_1" value="{{ $additional_field_data->additional_field_1 }}">
                    </div>
                @endif


                @if (!empty($widget->additional_field_2))
                    <div class="mb-2" id="edit_field2">
                        <label class="form-label">{{ $widget->additional_field_2 }}</label>
                        <input type="text" class="form-control" id="edit_additional_field_title_2"
                            name="additional_field_2" value="{{ $additional_field_data->additional_field_2 }}">
                    </div>
                @endif


                @if (!empty($widget->additional_field_3))
                    <div class="mb-2" id="edit_field3">
                        <label class="form-label">{{ $widget->additional_field_3 }}</label>
                        <input type="text" class="form-control" id="edit_additional_field_title_3"
                            name="additional_field_3" value="{{ $additional_field_data->additional_field_3 }}">
                    </div>
                @endif
                @if (!empty($widget->additional_field_4))
                    <div class="mb-2" id="edit_field4">
                        <label class="form-label">{{ $widget->additional_field_4 }}</label>
                        <input type="text" class="form-control" id="edit_additional_field_title_4"
                            name="additional_field_4" value="{{ $additional_field_data->additional_field_4 }}">
                    </div>
                @endif
                @if (!empty($widget->additional_field_5))
                    <div class="mb-2" id="edit_field5">
                        <label class="form-label">{{ $widget->additional_field_5 }}</label>
                        <input type="text" class="form-control" id="edit_additional_field_title_5"
                            name="additional_field_5" value="{{ $additional_field_data->additional_field_5 }}">
                    </div>
                @endif
                @if (!empty($widget->additional_field_6))
                    <div class="mb-2" id="edit_field6">
                        <label class="form-label">{{ $widget->additional_field_6 }}</label>
                        <input type="text" class="form-control" id="edit_additional_field_title_6"
                            name="additional_field_6" value="{{ $additional_field_data->additional_field_6 }}">
                    </div>
                @endif
                @if (!empty($widget->additional_field_7))
                    <div class="mb-2" id="edit_field7">
                        <label class="form-label">{{ $widget->additional_field_7 }}</label>
                        <input type="text" class="form-control" id="edit_additional_field_title_7"
                            name="additional_field_7" value="{{ $additional_field_data->additional_field_7 }}">
                    </div>
                @endif
                @if (!empty($widget->additional_field_8))
                    <div class="mb-2" id="edit_field8">
                        <label class="form-label">{{ $widget->additional_field_8 }}</label>
                        <input type="text" class="form-control" id="edit_additional_field_title_8"
                            name="additional_field_8" value="{{ $additional_field_data->additional_field_8 }}">
                    </div>
                @endif

                <div class="row">
                    {{-- <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button> --}}
                    <div class="col-sm-6 text-start">
                        <a href="{{ route('widgets.index') }}" class="btn btn-success"><i
                                class="fa-solid fa-angle-double-left">Go Back</i></a>
                    </div>
                    <div class="col-sm-6 text-end">
                        <button type="submit" name="submitter" class="btn btn-info">Update</button>
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
