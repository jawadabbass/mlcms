@extends('back.layouts.app', ['title' => $title])
@section('beforeHeadClose')
    @include('back.common_views.switch_css')
@endsection
@section('content')
    <div class="pl-3 pr-2 content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="row">
                <div class="col-md-5 col-sm-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ admin_url() }}"> <i class="fas fa-gauge"></i> Home </a></li>
                        <li class="active">Modules Management</li>
                    </ol>
                </div>
                <div class="col-md-7 col-sm-12"> @include('back.common_views.quicklinks') </div>
            </div>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <a href="{{ base_url() . 'adminmedia/manage-theme' }}">Manage Themes</a>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="p-2 card">
                        <div class="row">
                            <div class="col-sm-8">
                                <h3 class=" card-title">All CMS Modules</h3>
                            </div>
                            <div class="col-sm-4">
                                <div class="text-end" style="padding-bottom:10px;">
                                    <input type="button" class="sitebtn" value="Add CMS Module"
                                        onClick="load_cmsmodule_add_form();" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class=" card-body table-responsive">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Term</th>
                                        <th>Type</th>
                                        <th>Show In Admin Menu</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($modules as $module)
                                        <tr id="row_{{ $module->id }}">
                                            <td> {{ $module->title }} </td>
                                            <td> {{ $module->term }} </td>
                                            <td> {{ $module->type }} </td>
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" name="{{ 'sts_' . $module->id }}"
                                                        id="{{ 'sts_' . $module->id }}" <?php echo $module->show_in_admin_menu == 1 ? ' checked' : ''; ?>
                                                        value="<?php echo $module->show_in_admin_menu; ?>"
                                                        onClick="update_cmsmodule_status_toggle({{ $module->id }})">
                                                    <div class="slider round">
                                                        <strong class="on">Yes</strong>
                                                        <strong class="off">No</strong>
                                                    </div>
                                                </label>
                                            </td>
                                            <td>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#PageOptionsModal"
                                                    class="btn-sm btn btn-info EditPageOptions"
                                                    data-id="{{ $module->id }}">Page Options</a>
                                                <a href="javascript:;"
                                                    onClick="load_cmsmodule_edit_form({{ $module->id }});"
                                                    class="btn btn-success btn-sm">Edit</a>
                                                <a href="{{ url(admin_url() . 'module/' . $module->type) }}"
                                                    class="btn btn-success btn-sm">View</a>
                                                @if ($module->id != 1)
                                                    <a href="javascript:delete_cmsmodule({{ $module->id }});"
                                                        class="btn btn-danger btn-sm">Delete</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" align="center" class="text-red">No Record found!</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div> {{ $modules->links() }} </div>
        </section>
    </div>
    <div class="modal fade" id="add_page_form" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <form name="frm_cmsmodule" id="frm_cmsmodule" enctype="multipart/form-data" role="form" method="post"
                action="{{ route('modules.store') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add New CMS Module</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class=" card-body">
                            <div class="mb-2">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Title"
                                    required>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Term</label>
                                <input type="text" class="form-control" id="term" name="term" placeholder="Term"
                                    required>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Type</label>
                                <input type="text" class="form-control" id="type" name="type" placeholder="Type">
                            </div>
                            <div class="mb-2" style="display:none;">
                                <label class="form-label">Description</label>
                                <textarea id="editor1" name="editor1" class="form-control" rows="8" cols="80"
                                    placeholder="Description"></textarea>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Additional Fields (Optional)</label>
                                <select class="form-control" id="additional_fields" name="additional_fields">
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
                            <div class="mb-2" id="field1" style="display:none;">
                                <label class="form-label">Additional Field Title 1</label>
                                <input type="text" class="form-control" id="additional_field_title_1"
                                    name="additional_field_title_1" placeholder="Additional Field Title 1">
                            </div>
                            <div class="mb-2" id="field2" style="display:none;">
                                <label class="form-label">Additional Field Title 2</label>
                                <input type="text" class="form-control" id="additional_field_title_2"
                                    name="additional_field_title_2" placeholder="Additional Field Title 2">
                            </div>
                            <div class="mb-2" id="field3" style="display:none;">
                                <label class="form-label">Additional Field Title 3</label>
                                <input type="text" class="form-control" id="additional_field_title_3"
                                    name="additional_field_title_3" placeholder="Additional Field Title 3">
                            </div>
                            <div class="mb-2" id="field4" style="display:none;">
                                <label class="form-label">Additional Field Title 4</label>
                                <input type="text" class="form-control" id="additional_field_title_4"
                                    name="additional_field_title_4" placeholder="Additional Field Title 4">
                            </div>
                            <div class="mb-2" id="field5" style="display:none;">
                                <label class="form-label">Additional Field Title 5</label>
                                <input type="text" class="form-control" id="additional_field_title_5"
                                    name="additional_field_title_5" placeholder="Additional Field Title 5">
                            </div>
                            <div class="mb-2" id="field6" style="display:none;">
                                <label class="form-label">Additional Field Title 6</label>
                                <input type="text" class="form-control" id="additional_field_title_6"
                                    name="additional_field_title_6" placeholder="Additional Field Title 6">
                            </div>
                            <div class="mb-2" id="field7" style="display:none;">
                                <label class="form-label">Additional Field Title 7</label>
                                <input type="text" class="form-control" id="additional_field_title_7"
                                    name="additional_field_title_7" placeholder="Additional Field Title 7">
                            </div>
                            <div class="mb-2" id="field8" style="display:none;">
                                <label class="form-label">Additional Field Title 8</label>
                                <input type="text" class="form-control" id="additional_field_title_8"
                                    name="additional_field_title_8" placeholder="Additional Field Title 8">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Have Category </label>
                                <select class="form-control" id="have_category" name="have_category">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Show Page Slug Field </label>
                                <select class="form-control" id="show_page_slug_field" name="show_page_slug_field">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Show Ordering Option</label>
                                <select class="form-control" id="show_ordering_field" name="show_ordering_field">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Show Menu Field </label>
                                <select class="form-control" id="show_menu_field" name="show_menu_field">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Show Featured Image Field </label>
                                <select class="form-control" id="show_feature_img_field" name="show_feature_img_field">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Show SEO Field </label>
                                <select class="form-control" id="show_seo_field" name="show_seo_field">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Show Preview Link on Listing Page </label>
                                <select class="form-control" id="show_preview_link_on_listing_page"
                                    name="show_preview_link_on_listing_page">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Show Description </label>
                                <select class="form-control" id="show_descp" name="show_descp">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Show Follow Checkbox </label>
                                <select class="form-control" id="show_follow" name="show_follow">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Show Index Checkbox </label>
                                <select class="form-control" id="show_index" name="show_index">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">
                                    <input onchange="toggle_crop_height(this)" type="checkbox" name="crop_image"
                                        id="crop_image" value="Yes" />
                                    Crop featured Image (If Yes, then Need to add Width and Height) </label>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Thumb Image width(Must If featured Image used) </label>
                                <input class="form-control" type="text" name="feature_img_thmb_width"
                                    id="feature_img_thmb_width" value="">
                            </div>
                            <div id="feature_img_thmb_height_div" class="mb-2" style="display: none">
                                <label class="form-label">Thumb Image height(Must If featured Image cropper is used)
                                </label>
                                <input class="form-control" type="text" name="feature_img_thmb_height"
                                    id="feature_img_thmb_height" value="">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Show Featured image on Listing Page </label>
                                <select class="form-control" id="show_featured_image" name="show_featured_image">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Show Is Featured </label>
                                <select class="form-control" id="show_is_featured" name="show_is_featured">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">How Many Featured?</label>
                                <input type="text" class="form-control" id="how_many_featured"
                                    name="how_many_featured" value="0" placeholder="How many featured?">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Fontawesome Icon:</label>
                                <input class="form-control icp icp-auto" name="module_fontawesome_icon"
                                    id="module_fontawesome_icon" value="" type="text" autocomplete="off"
                                    data-placement="topRight" placeholder="fontawsome: fa-youtube" />
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Access Level:</label><br />
                                <label class="form-label"><input type="checkbox" name="access_level[]"
                                        value="super-admin" checked> Super Admin</label><br />
                                <label class="form-label"><input type="checkbox" name="access_level[]"
                                        value="normal-admin" checked> Normal Admin</label><br />
                                <label class="form-label"><input type="checkbox" name="access_level[]" value="reps">
                                    Reps</label><br />
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Show Icon:</label><br />
                                <label class="form-label"><input type="checkbox" name="show_icon_in[]"
                                        value="show_icon_in_left" checked> Left Side</label><br />
                                <label class="form-label"><input type="checkbox" name="show_icon_in[]"
                                        value="show_icon_in_dashboard" checked> Dashboard</label><br />
                            </div>
                            <div style="clear:both"></div>
                        </div>
                    </div>
                    <div style="clear:both"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="submitter" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!---- New Modal Form for Page options ------->
    <div class="modal fade" id="PageOptionsModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <form action="<?php echo base_url() . 'adminmedia/modules/updatePageOptions'; ?>" method="post">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Page Options</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" value="" name="module_id" id="edit_page_module_id">
                        <div class="mb-2">
                            <label class="form-label">Page Link</label>
                            <select class="form-control" id="page_link" name="page_link">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Menu Options</label>
                            <select class="form-control" id="page_menu_option" name="page_menu_option">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Page content</label>
                            <select class="form-control" id="page_content" name="page_content">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Featured Image</label>
                            <select class="form-control" id="page_featured_img" name="page_featured_img">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Follow / No Follow / Index / No Index</label>
                            <select class="form-control" id="page_follow_index" name="page_follow_index">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">SEO Options</label>
                            <select class="form-control" id="page_seo_option" name="page_seo_option">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!---- New Modal Form for Page options ------->
    <div class="modal fade" id="edit_page_form" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <form name="frm_cmsmodule" id="edit_frm_cmsmodule" enctype="multipart/form-data" role="form"
                method="post" action="{{ route('modules.update', 0) }}">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit CMS Module</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class=" card-body">
                            <div class="mb-2">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" id="edit_title" name="title"
                                    placeholder="Title">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Term</label>
                                <input type="text" class="form-control" id="edit_term" name="term"
                                    placeholder="Term">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Type</label>
                                <input type="text" class="form-control" id="edit_type" name="type"
                                    placeholder="Type">
                            </div>
                            <div class="mb-2" style="display: none;">
                                <label class="form-label">Description</label>
                                <textarea id="edit_editor1" class="form-control" name="edit_editor1" rows="8" cols="80"></textarea>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Additional Fields (Optional)</label>
                                <select class="form-control" id="edit_additional_fields" name="additional_fields"
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
                                <input type="text" class="form-control" id="edit_additional_field_title_1"
                                    name="additional_field_title_1" placeholder="Additional Field Title 1">
                            </div>
                            <div class="mb-2" id="edit_field2">
                                <label class="form-label">Additional Field Title 2</label>
                                <input type="text" class="form-control" id="edit_additional_field_title_2"
                                    name="additional_field_title_2" placeholder="Additional Field Title 2">
                            </div>
                            <div class="mb-2" id="edit_field3">
                                <label class="form-label">Additional Field Title 3</label>
                                <input type="text" class="form-control" id="edit_additional_field_title_3"
                                    name="additional_field_title_3" placeholder="Additional Field Title 3">
                            </div>
                            <div class="mb-2" id="edit_field4">
                                <label class="form-label">Additional Field Title 4</label>
                                <input type="text" class="form-control" id="edit_additional_field_title_4"
                                    name="additional_field_title_4" placeholder="Additional Field Title 4">
                            </div>
                            <div class="mb-2" id="edit_field5">
                                <label class="form-label">Additional Field Title 5</label>
                                <input type="text" class="form-control" id="edit_additional_field_title_5"
                                    name="additional_field_title_5" placeholder="Additional Field Title 5">
                            </div>
                            <div class="mb-2" id="edit_field6">
                                <label class="form-label">Additional Field Title 6</label>
                                <input type="text" class="form-control" id="edit_additional_field_title_6"
                                    name="additional_field_title_6" placeholder="Additional Field Title 6">
                            </div>
                            <div class="mb-2" id="edit_field7">
                                <label class="form-label">Additional Field Title 7</label>
                                <input type="text" class="form-control" id="edit_additional_field_title_7"
                                    name="additional_field_title_7" placeholder="Additional Field Title 7">
                            </div>
                            <div class="mb-2" id="edit_field8">
                                <label class="form-label">Additional Field Title 7</label>
                                <input type="text" class="form-control" id="edit_additional_field_title_8"
                                    name="additional_field_title_8" placeholder="Additional Field Title 8">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Have Category </label>
                                <select class="form-control" id="edit_have_category" name="have_category">
                                    <option value="">Select Option</option>
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Show Page Slug Field </label>
                                <select class="form-control" id="edit_show_page_slug_field" name="show_page_slug_field">
                                    <option value="">Select Option</option>
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Show Ordering Option</label>
                                <select class="form-control" id="edit_ordering_field" name="edit_ordering_field">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Show Menu Field </label>
                                <select class="form-control" id="edit_show_menu_field" name="show_menu_field">
                                    <option value="">Select Option</option>
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Show Featured Image Field </label>
                                <select class="form-control" id="edit_show_feature_img_field"
                                    name="show_feature_img_field">
                                    <option value="">Select Option</option>
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Show SEO Field </label>
                                <select class="form-control" id="edit_show_seo_field" name="show_seo_field">
                                    <option value="">Select Option</option>
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Show Preview Link on Listing Page </label>
                                <select class="form-control" id="edit_show_preview_link_on_listing_page"
                                    name="show_preview_link_on_listing_page">
                                    <option value="">Select Option</option>
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Show Description</label>
                                <select class="form-control" id="edit_show_descp" name="show_descp">
                                    <option value="">Select Option</option>
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Show Follow Checkbox </label>
                                <select class="form-control" id="edit_show_follow" name="show_follow">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Show Index Checkbox </label>
                                <select class="form-control" id="edit_show_index" name="show_index">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">
                                    <input onchange="toggle_crop_edit_height(this)" type="checkbox" name="crop_image"
                                        id="edit_crop_image" value="Yes" />
                                    Crop featured Image (If Yes, then Need to add Width and Height) </label>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Thumb Image width(If featured Image used) </label>
                                <input class="form-control" type="text" name="feature_img_thmb_width"
                                    id="edit_feature_img_thmb_width" value="">
                            </div>
                            <div id="edit_feature_img_thmb_height_div" class="mb-2" style="display: none">
                                <label class="form-label">Thumb Image height(If featured Image cropper is used) </label>
                                <input class="form-control" type="text" name="feature_img_thmb_height"
                                    id="edit_feature_img_thmb_height" value="">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Show Featured image on Listing Page </label>
                                <select class="form-control" id="edit_show_featured_image" name="show_featured_image">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Show Is Featured </label>
                                <select class="form-control" id="edit_show_is_featured" name="show_is_featured">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">How Many Featured?</label>
                                <input type="text" class="form-control" id="edit_how_many_featured"
                                    name="how_many_featured" value="0" placeholder="How many featured?">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Fontawesome Icon:</label>
                                <input class="form-control icp icp-auto" name="module_fontawesome_icon"
                                    id="edit_module_fontawesome_icon" value="" type="text" autocomplete="off"
                                    data-placement="topRight" placeholder="fontawsome: fa-youtube" />
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Access Level:</label><br />
                                <label class="form-label"><input type="checkbox" name="access_level[]" id="super-admin"
                                        value="super-admin"> Super Admin</label><br />
                                <label class="form-label"><input type="checkbox" name="access_level[]" id="normal-admin"
                                        value="normal-admin"> Normal Admin</label><br />
                                <label class="form-label"><input type="checkbox" name="access_level[]" id="reps"
                                        value="reps"> Reps</label><br />
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Show Icon:</label><br />
                                <label class="form-label"><input type="checkbox" name="show_icon_in[]"
                                        id="show_icon_in_left" value="show_icon_in_left"> Left Side</label><br />
                                <label class="form-label"><input type="checkbox" name="show_icon_in[]"
                                        id="show_icon_in_dashboard" value="show_icon_in_dashboard">
                                    Dashboard</label><br />
                            </div>
                            <input type="hidden" name="cmsmodule_id" id="cmsmodule_id" />
                            <div style="clear:both"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="submitter" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('beforeBodyClose')
    <script type="text/javascript">
        $(document).ready(function(e) {
            $("#term").change(function() {
                string_to_slug('term', 'type');
            });
            $("#type").change(function() {
                check_slug('type');
            });
            $("#additional_fields").change(function() {
                var field_value = $("#additional_fields").val();
                for (var count = 1; count <= 8; count++) {
                    $("#field" + count).hide();
                }
                for (var count = 1; count <= field_value; count++) {
                    $("#field" + count).show();
                }
            });
        });
        $(".EditPageOptions").click(function() {
            var pid = $(this).attr('data-id');
            $("#edit_page_module_id").val(pid);
            $.getJSON(base_url + 'adminmedia/modules/' + pid, function(data) {
                $("#page_heading").val(data.page_heading);
                $("#page_link").val(data.page_link);
                $("#page_menu_option").val(data.page_menu_option);
                $("#page_content").val(data.page_content);
                $("#page_featured_img").val(data.page_featured_img);
                $("#page_follow_index").val(data.page_follow_index);
                $("#page_seo_option").val(data.page_seo_option);
                $("#page_seo_option").val(data.page_seo_option);
            });
        });
    </script>
    <script type="text/javascript" src="{{ asset_storage('') . 'module/cmsmodules/admin/js/cmsmodules.js' }}"></script>
@endsection
