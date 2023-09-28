@extends('back.layouts.app', ['title' => $title])
@section('content')
    <div class="content-wrapper pl-3 pr-2">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="row">
                <div class="col-md-5 col-sm-12">
                    <ol class="breadcrumb">
                        <li>
                            <a href="{{ admin_url() }}"> <i class="fas fa-gauge"></i> Home </a>
                        </li>
                        <li>
                            <a href="{{ admin_url() . 'module/' . $module->type }}">{{ ucwords($module->term) }}</a>
                        </li>
                        <li class="active">Edit {{ ucwords($module->term) }}</li>
                    </ol>
                </div>
                <div class="col-md-7 col-sm-12"> @include('back.common_views.quicklinks') </div>
            </div>
        </section>
        <section class="content p-0">
            <form action="{{ admin_url() . 'module/' . $module->id . '/' . $moduleData->id }}" id="form_edit_1"
                method="post" class="form-horizontal" enctype="multipart/form-data">
                @csrf
                @php $style_hide="style='dispaly:none'"; @endphp
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="modal_form_title" class="modal-title"> Edit {{ ucwords($module->term) }}
                        </h4>
                        <a href="{{ admin_url() . 'module/' . $module->type }}" class="go-back"><i
                                class="fas fa-angle-double-left" aria-hidden="true"></i> Back </a>
                    </div>
                    <div class="modal-body form">
                        <div class="box-body">
                            <input type="hidden" value="" name="id" />
                            <div class="form-body">
                                <div id="form-errors"></div>
                                <div id="page_heading">
                                    <label class="form-label">Heading</label>
                                    <input onchange="string_to_product_slug('module_heading', 'module_slug');"
                                        name="module_heading" placeholder="Heading" class="form-control" type="text"
                                        value="{{ $moduleData->heading }}">
                                    <span id="module_heading" style="padding-left:2px;" class="err"></span>
                                </div>
                                <div id="page_link"
                                    style=" display:{{ $module->show_page_slug_field == 1 ? 'block' : 'none' }}">
                                    <label for="basic-url">{{ ucwords($module->term) }}
                                        Link
                                        @php helptooltip('page_link') @endphp </label>
                                    <div class="mb-2"> <span class="mb-2-addon"
                                            id="basic-addon3">{{ base_url() }}@php echo ($module->term=='Page')?"":$module->term."/"; @endphp </span>
                                        @php
                                            $pslug = $moduleData->post_slug;
                                            $pslug = str_replace($module->term . '/', '', $pslug);
                                        @endphp
                                        <input type="text" class="form-control slug-field" name="module_slug"
                                            id="slug_field" value="{{ $pslug }}"
                                            placeholder="{{ ucwords($module->term) }} Link">
                                    </div>
                                    <span id="page_slug" style="padding-left:2px;" class="err"></span>
                                </div>
                                <div id="menu_type_div"
                                    style="display: {{ $module->show_menu_field == 1 ? 'block' : 'none' }}">
                                    <label class="form-label">Show this page in</label>
                                    <br>
                                    @if ($menu_types)
                                        <?php
                                        $selected_menus = [];
                                        foreach ($menu as $men) {
                                            $selected_menus[] = $men['menu_types'];
                                        }
                                        ?>
                                        @foreach ($menu_types as $meny_type)
                                            <label class="form-label">
                                                <input name="menu_type[]" value="{{ $meny_type->id }}"
                                                    id="menu_{{ $meny_type->id }}" type="checkbox" <?php echo in_array($meny_type->id, $selected_menus) ? 'checked' : ''; ?> />
                                                {{ ucfirst($meny_type->menu_type) }} Menu</label>
                                        @endforeach
                                    @endif <br />
                                    <span id="menu_type" style="padding-left:2px;" class="err"></span>
                                    <p>Note: if you want to update further menu settings then please <a
                                            href="{{ route('menus.index') }}" target="_blank">click here</a></p>
                                </div>
                                <div id="page_content" @if ($module->show_descp == '0') style="display: none" @endif>
                                    <label class="form-label">{{ ucwords($module->term) }} Description</label>
                                    <label for="">
                                        <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#media_image"
                                            class="btn btn-info"> <i class="fas fa-cloud-download"
                                                aria-hidden="true"></i>
                                            Insert Image from Media</a>
                                        <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#media_files"
                                            class="btn btn-warning"> <i class="fas fa-cloud-download"
                                                aria-hidden="true"></i>
                                            Insert Document from Media</a>
                                    </label>
                                    <textarea name="editor1" id="editor1" placeholder="{{ ucwords($module->term) }} Description" class="form-control"
                                        type="text">{{ $moduleData->content }}</textarea>
                                    <textarea name="module_description" id="module_description1" style="display: none;"></textarea>
                                    <span id="module_description" style="padding-left:2px;" class="err"></span>
                                </div>
                                {{-- @if ($module->have_category == '1')
            <div id="have_category">
               <label class="form-label">Page Template</label>
               <select name="cat" id="cat" onchange="ChangeCat(this.value)" class="form-control">
                  <option> Main Template</option>
                  @foreach ($allParentCategory as $catGroup)
                  @if ($catGroup['cat'] == 0)
                  <option data-id="{{$moduleData->cat_id}}" {!!selectVal($catGroup['id'],$moduleData->cat_id)!!}>{{$catGroup['title']}} </option>
                  @php $childCategories=childCategories($catGroup['id']);
                  foreach($childCategories as $subk=>$subv){
                  @endphp
                  <option {!!selectVal($subv['id'],'')!!}>&nbsp;&nbsp;--{{$subv['title']}} </option>
                  @php }@endphp
                  @endif
                  @endforeach
               </select>
               @endif --}}
                                @if ($module->id == 36)
                                    <div class="row">
                                        <div class="col-sm-12 mb-2">
                                            <label class="form-label">Page Template</label>
                                            <select class="form-control">
                                                <option>Select Page Template</option>
                                                @foreach ($templates as $temp)
                                                    <option value="{{ $temp->id }}">{{ $temp->template }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif
                                @if ($module->id == 36)
                                    <div class="row">
                                        <div class="col-sm-12 mb-2">
                                            <label class="form-label">Click On Widget For Update</label>
                                            @if (is_array($widget) || is_object($widget))
                                                <ul>
                                                    @foreach ($widget as $wid)
                                                        <li><a
                                                                href="{{ route('widgets.show', $wid->ID) }}">{{ $wid->heading }}</a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </div>
                                @endif
                            </div>
                            <div id="field1" style="display:none;">
                                <label class="form-label">{{ ucwords($module->additional_field_title_1) }}</label>
                                <input type="text" class="form-control" id="additional_field_1"
                                    name="additional_field_1" value="{{ $moduleData->additional_field_1 }}"
                                    placeholder="{{ ucwords($module->additional_field_title_1) }} ">
                                <span id="additional_field1" style="padding-left:2px;" class="err"></span>
                            </div>
                            @if ($module->id == 36)
                                <div id="field2" style="display:none;">
                                    <div class="row">
                                        <div class="col-md-4">{{ ucwords($module->additional_field_title_2) }}</div>
                                        <div class="col-md-8"><a href="javascript:;" data-bs-toggle="modal"
                                                data-bs-target="#media_image_addition" class="btn btn-info"> <i
                                                    class="fas fa-cloud-download" aria-hidden="true"></i> Insert
                                                Image from
                                                Media</a></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8"><input type="text" class="form-control"
                                                id="additional_field_2" name="additional_field_2"
                                                value="{{ $moduleData->additional_field_2 }}"
                                                placeholder="{{ ucwords($module->additional_field_title_2) }} "></div>
                                        <div class="col-md-4"><img width="200" id="edit_portfolio_img"
                                                src="{{ $moduleData->additional_field_2 }}" alt=""></div>
                                    </div>
                                    <span id="additional_field2" style="padding-left:2px;" class="err"></span>
                                </div>
                            @else
                                <div id="field2" style="display:none;">
                                    <label class="form-label">{{ ucwords($module->additional_field_title_2) }}</label>
                                    <input type="text" class="form-control" id="additional_field_2"
                                        name="additional_field_2" value="{{ $moduleData->additional_field_2 }}"
                                        placeholder="{{ ucwords($module->additional_field_title_2) }} ">
                                    <span id="additional_field2" style="padding-left:2px;" class="err"></span>
                                </div>
                            @endif
                            <div id="field3" style="display:none;">
                                <label class="form-label">{{ ucwords($module->additional_field_title_3) }}</label>
                                <input type="text" class="form-control" id="additional_field_3"
                                    name="additional_field_3" value="{{ $moduleData->additional_field_3 }}"
                                    placeholder="{{ ucwords($module->additional_field_title_3) }} ">
                                <span id="additional_field3" style="padding-left:2px;" class="err"></span>
                            </div>
                            <div id="field4" style="display:none;">
                                <label class="form-label">{{ ucwords($module->additional_field_title_4) }}</label>
                                <input type="text" class="form-control" id="additional_field_4"
                                    name="additional_field_4" value="{{ $moduleData->additional_field_4 }}"
                                    placeholder="{{ ucwords($module->additional_field_title_4) }} ">
                                <span id="additional_field4" style="padding-left:2px;" class="err"></span>
                            </div>
                            <div id="field5" style="display:none;">
                                <label class="form-label">{{ ucwords($module->additional_field_title_5) }}</label>
                                <input type="text" class="form-control" id="additional_field_5"
                                    name="additional_field_5" value="{{ $moduleData->additional_field_5 }}"
                                    placeholder="{{ ucwords($module->additional_field_title_5) }} ">
                                <span id="additional_field5" style="padding-left:2px;" class="err"></span>
                            </div>
                            <div id="field6" style="display:none;">
                                <label class="form-label">{{ ucwords($module->additional_field_title_6) }}</label>
                                <input type="text" class="form-control" id="additional_field_6"
                                    name="additional_field_6" value="{{ $moduleData->additional_field_6 }}"
                                    placeholder="{{ ucwords($module->additional_field_title_6) }} ">
                                <span id="additional_field6" style="padding-left:2px;" class="err"></span>
                            </div>
                            <div id="field7" style="display:none;">
                                <label class="form-label">{{ ucwords($module->additional_field_title_7) }}</label>
                                <input type="text" class="form-control" id="additional_field_7"
                                    name="additional_field_7" value="{{ $moduleData->additional_field_7 }}"
                                    placeholder="{{ ucwords($module->additional_field_title_7) }} ">
                                <span id="additional_field7" style="padding-left:2px;" class="err"></span>
                            </div>
                            <div id="field8" style="display:none;">
                                <label class="form-label">{{ ucwords($module->additional_field_title_8) }}</label>
                                <input type="text" class="form-control" id="additional_field_8"
                                    name="additional_field_8" value="{{ $moduleData->additional_field_8 }}"
                                    placeholder="{{ ucwords($module->additional_field_title_8) }} ">
                                <span id="additional_field8" style="padding-left:2px;" class="err"></span>
                            </div>
                            <div class="row" id="page_featured_img">
                                <div id="fea_img"
                                    style="display:{{ $module->show_feature_img_field == 1 ? 'block' : 'none' }}">
                                    <label class="form-label">Update {{ ucwords($module->term) }} Image <span
                                            style="color: #ff0000;font-size: 12px">(max size:
                                            {{ getMaxUploadSize() }}
                                            MB)</span> @php echo helptooltip('max_image_size') @endphp </label>
                                    <div id="file-field">
                                        <input type="file" name="module_img" id="module_img" class="form-control">
                                        <div id="attached_files_div"></div>
                                    </div>
                                    @if ($moduleData->featured_img)
                                        <span id="featured_img" style="padding-left:2px;" class="err">
                                            <div class="featured-images-main" id="products_img_undefined"><img
                                                    style="width:100px" src="<?php echo asset_uploads('') . 'module/' . $module->type . '/' . $moduleData->featured_img; ?>"><i
                                                    onclick="remove_featured_img({{ $moduleData->id }});"
                                                    class="deleteIcon"></i></div>
                                        </span>
                                        <!--<span id="featured_img" style="padding-left:2px;" class="err"></span>-->
                                        <div id="featured_img"></div>
                                    @endif
                                    <div class="clear"></div>
                                    <div class="mt-3 mb-3">
                                        <label class="btn btn-primary img_alt_title_label">Image Title/Alt</label>
                                        <div class="mt-3 mb-3" style="display:none;">
                                            <label class="form-label">Image Title</label>
                                            <input type="text" name="featured_img_title" id="featured_img_title"
                                                class="form-control" placeholder="Featured Image Title"
                                                value="{{ $moduleData->featured_img_title }}">
                                            <label class="mt-3">Image Alt</label>
                                            <input type="text" name="featured_img_alt" id="featured_img_alt"
                                                class="form-control" placeholder="Featured Image Alt"
                                                value="{{ $moduleData->featured_img_alt }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @include('back.module.module_data_images.module_data_images_html')
                            <div id="page_follow" style="display: {{ $module->show_follow == 1 ? 'block' : 'none' }}">
                                <label class="form-label">Make Follow</label>
                                <input name="show_follow" id="show_follow_rel_1" value="1" type="radio"
                                    <?php echo $moduleData->show_follow == 1 ? 'checked' : ''; ?> />
                                @php echo helptooltip('follow') @endphp
                                <br />
                                <label class="form-label">Make No Follow</label>
                                <input name="show_follow" id="show_follow_rel_0" value="0" type="radio"
                                    <?php echo $moduleData->show_follow == 0 ? 'checked' : ''; ?> />
                            </div>
                            <br>
                            <div id="page_index" style="display: {{ $module->show_index == 1 ? 'block' : 'none' }}">
                                <label class="form-label">Indexing</label>
                                <input name="show_index" id="show_index_rel_1" value="1" type="radio"
                                    <?php echo $moduleData->show_index == 1 ? 'checked' : ''; ?> />
                                @php echo helptooltip('indexing') @endphp
                                <br />
                                <label class="form-label">No Indexing</label>
                                <input name="show_index" id="show_index_rel_0" value="0" type="radio"
                                    <?php echo $moduleData->show_index == 0 ? 'checked' : ''; ?> />
                            </div>
                            <br>
                            <div id="page_seo_option"
                                style="display: {{ $module->show_seo_field == 1 ? 'block' : 'none' }}">
                                <div>
                                    <a onclick="showme_seo('#seo-edit-modul',this);" href="javascript:;">Manage SEO <i
                                            class="fas fa-angle-double-down" aria-hidden="true"></i></a>
                                </div>
                                <div id="seo-edit-modul" class="seo-edit-modul-hide">
                                    <div>
                                        <label class="form-label">Meta Title (<i>Max:</i>
                                            <span id="edit_char_countdown">70 characters</span>)
                                            <?php echo helptooltip('seo_title'); ?>
                                        </label>
                                        <input type="text" name="meta_title" id="edit_meta_title"
                                            value="{{ $moduleData->meta_title }}" class="form-control"
                                            onKeyUp="limit_text('edit_meta_title', 70, 'edit_char_countdown');"
                                            placeholder="Meta Title">
                                        <span id="meta_title" style="padding-left:2px;" class="err"></span>
                                    </div>
                                    <div>
                                        <label class="form-label">Meta Keywords <?php echo helptooltip('seo_keywords'); ?></label>
                                        <textarea class="form-control" name="meta_keywords" rows="3">{{ $moduleData->meta_keywords }}</textarea>
                                        <span id="meta_keywords" style="padding-left:2px;" class="err"></span>
                                    </div>
                                    <div>
                                        <label class="form-label">Meta Description <?php echo helptooltip('seo_descp'); ?></label>
                                        <textarea name="meta_description" class="form-control" rows="3">{{ $moduleData->meta_description }}</textarea>
                                        <span id="meta_description" style="padding-left:2px;" class="err"></span>
                                    </div>
                                    <div>
                                        <label class="form-label">Canonical URL @php echo helptooltip('canonical_url')@endphp</label>
                                        <textarea name="canonical_url" class="form-control" rows="3" cols="70">{{ $moduleData->canonical_url }}</textarea>
                                        <span id="canonical_url" style="padding-left:2px;" class="err"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bottom-btns">
                    <input type="hidden" name="module_id" id="module_id" value="{{ ucwords($module->id) }}">
                    <input type="hidden" name="from_page_update" id="from_page_update" value="yess">
                    <button type="button" id="btnSave" class="btn btn-primary pull-right"
                        onclick="updatePageContent()">Save</button>
                    <a href="{{ admin_url() . 'module/' . $module->type }}" class="go-back"><button type="button"
                            class="btn btn-danger" data-bs-dismiss="modal"><i class="fas fa-angle-double-left"
                                aria-hidden="true"></i> Back </button></a>
                </div>
                </div>
            </form>
        </section>
    </div>
    <!-- /.modal -->
    <div class="modal fade" id="cropper_form" role="dialog">
        <div class="modal-dialog modal-lg">
            <form action="#" id="crop_form" class="form-horizontal" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="cropper_form_title" class="modal-title">Image Cropper Form</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-8" id="large_image"><img id="image" src=""
                                        alt="Crop Picture"></div>
                                <div class="col-md-4">
                                    <div class="preview"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="source_image" id="source_image" value="" />
                        <input type="hidden" name="crop_x" id="crop_x" value="" />
                        <input type="hidden" name="crop_y" id="crop_y" value="" />
                        <input type="hidden" name="crop_height" id="crop_height" value="" />
                        <input type="hidden" name="crop_width" id="crop_width" value="" />
                        <input type="hidden" name="crop_rotate" id="crop_rotate" value="" />
                        <input type="hidden" name="module_id" value="{{ ucwords($module->id) }}">
                        <button type="button" id="btnCrop" onclick="save_cropped_img()" class="btn btn-primary">Crop
                            Image
                        </button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </form>
        </div>
    </div>
    @include('back.module.media_popup')
    @include('back.module.files_popup')
    @include('back.module.module_data_images.module_data_images_popups')
@endsection
@section('beforeBodyClose')
    <script type="text/javascript" src="{{ asset_storage('') . 'module/module/admin/js/module.js' }}"></script>
    <!-- Filer -->
    <link rel="stylesheet" href="{{ asset_storage('') . 'module/module/admin/crop-avatar/cropper.css' }}">
    <style>
        img {
            max-width: 100%;
        }
    </style>
    <script src="{{ asset_storage('') . 'module/module/admin/crop-avatar/cropper.js' }}"></script>
    <script type="text/javascript" src="{{ asset_storage('') . 'back/js/std_functions.js' }}"></script>
    @include('back.module.module_data_images.module_data_images_js')
    <!------------ Module JS Functions ---------------------->
    <script type="text/javascript">
        var save_method; //for save method string
        var table;
        $(document).ready(function() {
            additional_fields({{ ucwords($module->additional_fields) }});
            $("#dated").click(function(event) {
                //event.preventDefault();
                $(this).attr("type", 'date').trigger('click');
            });
        });
        function bind_cropper_preview() {
            var $previews = $('.preview');
            var $image = $('#image');
            var cropBoxData;
            var canvasData;
            $('#cropper_form').on('shown.bs.modal', function() {
                $image.cropper({
                    autoCropArea: 0.5,
                    viewMode: 1,
                    dragMode: 'move',
                    guides: false,
                    restore: false,
                    highlight: false,
                    cropBoxMovable: true,
                    cropBoxResizable: false,
                    aspectRatio: {{ $module->feature_img_thmb_width }} /
                        {{ $module->feature_img_thmb_height }},
                    minCropBoxWidth: {{ $module->feature_img_thmb_width }},
                    minCropBoxHeight: {{ $module->feature_img_thmb_height }},
                    ready: function() {
                        var $clone = $(this).clone().removeClass('cropper-hidden');
                        $clone.css({
                            display: 'block',
                            width: '100%',
                            minWidth: 0,
                            minHeight: 0,
                            maxWidth: 'none',
                            maxHeight: 'none'
                        });
                        $previews.css({
                            width: '100%',
                            overflow: 'hidden'
                        }).html($clone);
                        $image.cropper('setCanvasData', canvasData);
                        $image.cropper('setCropBoxData', cropBoxData);
                    },
                    crop: function(e) {
                        var imageData = $(this).cropper('getImageData');
                        var previewAspectRatio = e.width / e.height;
                        $('#crop_x').val(e.x);
                        $('#crop_y').val(e.y);
                        $('#crop_height').val(e.height);
                        $('#crop_width').val(e.width);
                        $('#crop_rotate').val(e.rotate);
                        $previews.each(function() {
                            var $preview = $(this);
                            var previewWidth = $preview.width();
                            var previewHeight = previewWidth / previewAspectRatio;
                            var imageScaledRatio = e.width / previewWidth;
                            $preview.height(previewHeight).find('img').css({
                                width: imageData.naturalWidth / imageScaledRatio,
                                height: imageData.naturalHeight / imageScaledRatio,
                                marginLeft: -e.x / imageScaledRatio,
                                marginTop: -e.y / imageScaledRatio
                            });
                        });
                    }
                });
            });
        }
        function save_cropped_img() {
            var json = [
                '{"x":' + $('#crop_x').val(),
                '"y":' + $('#crop_y').val(),
                '"height":' + $('#crop_height').val(),
                '"width":' + $('#crop_width').val(),
                '"rotate":' + $('#crop_rotate').val() + '}'
            ].join();
            $.ajax({
                url: "{{ admin_url() . 'modul/crop_image' }}",
                type: "POST",
                dataType: "JSON",
                data: $('#crop_form').serialize(),
                success: function(data) {
                    console.log(data.cropped_image);
                    $('#featured_img').val(data.cropped_image);
                    $('.jFiler-item-thumb-image').find('img').attr('src', asset_uploads +
                        'module/{{ $module->type }}/thumb/' + data.cropped_image);
                    $('#cropper_form').modal('hide');
                },
                error: function(jqXHR, textStatus, errorThrown) {}
            });
        }
        function add_content() {
            reset_model();
            save_method = 'add';
            $('#modal_form_title').text('Add {{ ucwords($module->term) }}'); // Set Title to Bootstrap modal title
            var my_editor_id = 'editor1';
            ckeditors['editor1'].setData('');
        }
        function save() {
            var url;
            var content = ckeditors['editor1'].getData();
            $('#module_description1').val(content);
            if (save_method == 'add') {
                url = "{{ admin_url() . 'module/' . $module->type }}";
            } else {
                var id = $('[name="id"]').val();
                mId = $('#module_id').val();
                url = "{{ admin_url() . 'module/' }}" + mId + "/" + id;
                console.log(id);
                console.log(url);
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                type: "POST",
                data: $("#form").serialize(),
                success: function(data, status) {
                    console.log(data);
                    if ($.isEmptyObject(data.error)) {
                        $('#modal_form').modal('hide');
                        $('#' + save_method + '_action').show();
                        if ($("#from_page_update").val() == "yess") {
                            redirect_url = "{{ admin_url() . 'module/' . $module->type }}";
                            window.location.href = redirect_url;
                        } else {
                            location.reload();
                        }
                    } else {
                        errorsHtml = '<div class="alert alert-danger"><ul>';
                        $.each(data, function(key, value) {
                            errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.
                        });
                        errorsHtml += '</ul></di>';
                        $('#form-errors').html(errorsHtml);
                    }
                    $('#loading').hide();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('#loading').hide();
                    console.log(jqXHR);
                    console.log(textStatus);
                    console.log(errorThrown);
                    alert('Error adding / update data');
                }
            });
        }
        function delete_content(id) {
            $('.message-container').fadeOut(3000);
            var mess_alert = '';
            mess_alert = 'Are you sure you want to delete this';
            if (confirm(mess_alert)) {
                // ajax delete data to database
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                console.log(id);
                $.ajax({
                    url: "{{ base_url() . 'adminmedia/module/delete' }}/" + id,
                    type: "DELETE",
                    success: function(data) {
                        //if success reload ajax table
                        $('#modal_form').modal('hide');
                        $('#item_' + id).hide();
                        $('#delete_action').show();
                        location.reload();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR);
                        console.log(textStatus);
                        console.log(errorThrown);
                        alert('Error adding / update data');
                    }
                });
            }
        }
        function remove_featured_img(id) {
            if (confirm("Are you sure you want to delete this {{ ucwords($module->term) }} Image?")) {
                url = "{{ base_url() }}adminmedia/modul/remove_image?id=" + id + '&&type={{ $module->type }}';
                $.ajax({
                    url: url,
                    type: "GET",
                    success: function(data) {
                        $('#featured_img').hide();
                        $('#featured_img').html("");
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR);
                        console.log(textStatus);
                        console.log(errorThrown);
                        alert('Error adding / update data');
                    }
                });
            }
        }
    </script>
    <!----------- END Module JS functions -------------------->
    <script>
        var uploadUrl = "{{ admin_url() }}module_image/upload_image";
        var deleteUrl = "{{ admin_url() }}module_image/remove_image";
        var folder = "{{ 'module/' . $module->type }}";
        var maxSize = {{ getMaxUploadSize() }};
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var show_cropper = {{ $module->crop_image == 'Yes' ? 1 : 0 }};
        var module_id = "{{ $module->type }}";
    </script>
    <script type="text/javascript" src="{{ asset_storage('') . 'back/js/fileUploader.js' }}"></script>
    <!-- Bootstrap modal -->
    <div id="loading" class="loadinggif" style="display: none;"></div>
    <!-- End Bootstrap modal -->
    <script type="text/javascript">
        function updatePageContent() {
            var content = ckeditors['editor1'].getData();
            $('#module_description1').val(content);
            $('#form_edit_1').submit();
        }
    </script>
    @include('back.module.media_js')
@endsection
