@extends('back.layouts.app', ['title' => $title ?? ''])
@section('content')
    <div class="content-wrapper pl-3 pr-2">
        <!-- Block Header (Page header) -->
        <section class="content-header">
            <div class="row">
                <div class="col-md-5 col-sm-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ admin_url() . '' }}"><i class="fas fa-gauge"></i> Home</a></li>
                        <li class="active">Widgets Management</li>
                    </ol>
                </div>
                <div class="col-md-7 col-sm-12"> @include('back.common_views.quicklinks') </div>
            </div>
        </section>
        <section class="content">
            @if (\Session::has('added_action'))
                <div class="message-container">
                    <div class="callout callout-success">
                        <h4>New Widgets has been created successfully.</h4>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-sm-8">
                    <h3 class="box-title">Add Widget</h3>
                </div>
                <div class="col-sm-4">
                    <div class="text-end" style="padding-bottom:2px;">
                        {{-- <input type="button" class="sitebtn" value="Add New Widgets"
                  onClick="load_widgets_add_form();"/> --}}
                        <a href="{{ route('widgets.index') }}" class="sitebtn">Go Back</a>
                    </div>
                </div>
            </div>
            <form enctype="multipart/form-data" role="form" method="post" action="{{ route('widgets.store') }}">
                @csrf
                <div class="mb-2">
                    <label class="form-label">Heading</label>
                    <input type="text" class="form-control" id="heading" name="heading" value="{{ old('heading') }}"
                        placeholder="Heading">
                </div>
                <div class="mb-2">
                    <input type="hidden" class="form-control" name="page_slug" id="page_slug"
                        value="{{ old('page_slug') }}" placeholder="Page Link">
                </div>
                <div class="mb-2">
                    <label class="form-label">Widget Content</label>
                    <textarea id="editor1" name="editor1" rows="8" cols="80" placeholder="Widget Content...">{{ old('editor1') }}</textarea>
                </div>
                <div id="fea_img">
                    <label class="form-label"> Add Widgets Image <span style="font-size: 12px;color: red"> max size:
                            {{ getMaxUploadSize() }}MB </span> @php echo helptooltip('max_image_size') @endphp </label>
                    <div id="file-field">
                        <input type="file" name="module_img" id="module_img" class="form-control module_img">
                        <div id="attached_files_div" class="attached_files_div"></div>
                    </div>
                    <span id="featured_image" style="padding-left:2px;" class="err featured_img"></span>
                    <div id="featured_img" class="featured_img"></div>
                    <div class="clear"></div>
                    <div class="mt-3 mb-3">
                        <label class="btn btn-primary img_alt_title_label">Image Title/Alt</label>
                        <div class="mt-3 mb-3" style="display:none;">
                            <label class="form-label">Image Title</label>
                            <input type="text" name="featured_image_title" id="featured_image_title"
                                class="form-control" placeholder="Featured Image Title" value="">
                            <label class="mt-3">Image Alt</label>
                            <input type="text" name="featured_image_alt" id="featured_image_alt"
                                class="form-control" placeholder="Featured Image Alt" value="">
                        </div>
                    </div>
                </div>
                <div class="mb-2">
                    <label class="form-label">Additional Fields (Optional)</label>
                    <select class="form-control" id="additional_fields" name="additional_fields"
                        onchange="additional_fields_show_hide();">
                        <option value="0">Select Option</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                    </select>
                </div>
                <div class="mb-2" id="edit_field1">
                    <label class="form-label">Additional Field Title 1</label>
                    <input type="text" class="form-control" id="edit_additional_field_title_1" name="additional_field_1"
                        placeholder="Additional Field Title 1">
                </div>
                <div class="mb-2" id="edit_field2">
                    <label class="form-label">Additional Field Title 2</label>
                    <input type="text" class="form-control" id="edit_additional_field_title_2" name="additional_field_2"
                        placeholder="Additional Field Title 2">
                </div>
                <div class="mb-2" id="edit_field3">
                    <label class="form-label">Additional Field Title 3</label>
                    <input type="text" class="form-control" id="edit_additional_field_title_3" name="additional_field_3"
                        placeholder="Additional Field Title 3">
                </div>
                <div class="mb-2" id="edit_field4">
                    <label class="form-label">Additional Field Title 4</label>
                    <input type="text" class="form-control" id="edit_additional_field_title_4" name="additional_field_4"
                        placeholder="Additional Field Title 4">
                </div>
                <div class="mb-2" id="edit_field5">
                    <label class="form-label">Additional Field Title 5</label>
                    <input type="text" class="form-control" id="edit_additional_field_title_5" name="additional_field_5"
                        placeholder="Additional Field Title 5">
                </div>
                <div class="mb-2" id="edit_field6">
                    <label class="form-label">Additional Field Title 6</label>
                    <input type="text" class="form-control" id="edit_additional_field_title_6" name="additional_field_6"
                        placeholder="Additional Field Title 6">
                </div>
                <div class="mb-2" id="edit_field7">
                    <label class="form-label">Additional Field Title 7</label>
                    <input type="text" class="form-control" id="edit_additional_field_title_7" name="additional_field_7"
                        placeholder="Additional Field Title 7">
                </div>
                <div class="mb-2" id="edit_field8">
                    <label class="form-label">Additional Field Title 8</label>
                    <input type="text" class="form-control" id="edit_additional_field_title_8" name="additional_field_8"
                        placeholder="Additional Field Title 8">
                </div>
                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button> --}}
                    <button type="submit" name="submitter" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </section>
    </div>
@endsection
@section('beforeBodyClose')
    <script type="text/javascript">
        $(document).ready(function(e) {
            $("#heading").change(function() {
                string_to_slug('heading', 'page_slug');
            });

        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            var field_value = $("#additional_fields").val();
            for (var count = 1; count <= 8; count++) {
                $("#edit_field" + count).hide();
            }
            for (var count = 1; count <= field_value; count++) {
                $("#edit_field" + count).show();
            }
            $("#additional_fields").on('change', function() {
                var field_value = $("#additional_fields").val();
                for (var count = 1; count <= 8; count++) {
                    $("#edit_field" + count).hide();
                }
                for (var count = 1; count <= field_value; count++) {
                    $("#edit_field" + count).show();
                }
            });
        });
    </script>
    <!-- Filer -->
    <script>
        var uploadUrl = "{{ admin_url() }}module_image/upload_image";
        var deleteUrl = "{{ admin_url() }}module_image/remove_image";
        var baseUrl = '{{ base_url() }}';
        var folder = "widgets";
        var maxSize = {{ getMaxUploadSize() }};
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var show_cropper = false;
    </script>
    <script type="text/javascript" src="{{ public_path_to_storage('back/js/fileUploader2.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(e) {
            $("#heading").change(function() {
                string_to_slug('heading', 'page_slug');
            });
        });
    </script>
@endsection
