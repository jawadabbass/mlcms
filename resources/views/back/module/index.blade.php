@extends('back.layouts.app', ['title' => $title])
@section('content')
    <aside class="right-side {{ session('leftSideBar') == 1 ? 'strech' : '' }}">
        <section class="content-header">
            <div class="row">
                <div class="col-md-8 col-sm-6">
                    <ol class="breadcrumb">
                        <li><a href="{{ admin_url() }}"> <i class="fa-solid fa-gauge"></i> Home </a></li>
                        <li class="active">{{ ucwords($module->term) }}</li>
                    </ol>
                </div>
                <div class="col-md-4 col-sm-6"> @include('back.common_views.quicklinks') </div>
            </div>
        </section>
        <section class="content">
            <div class="message-container" id="add_action" style="display: none">
                <div class="callout callout-success">
                    <h4>New {{ ucwords($module->term) }} has been created successfully.</h4>
                </div>
            </div>
            <div class="message-container" id="update_action" style="display:none;">
                <div class="callout callout-success">
                    <h4>{{ ucwords($module->term) }} has been updated successfully.</h4>
                </div>
            </div>
            <div class="message-container" id="delete_action" style="display: none">
                <div class="callout callout-danger">
                    <h4>{{ ucwords($module->term) }} has been deleted successfully.</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="box">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="box-header">
                                    <h3 class="box-title">{{ ucwords($module->title) }}</h3>
                                </div>
                            </div>
                            <div class="col-sm-6" style="text-align: right">
                                @if ($module->show_ordering_options)
                                    <div class="text-end" style="padding-bottom:2px; display: inline;">
                                        <a class="sitebtn" href="{{ admin_url() . 'module/ordering/' . $module->type }}">
                                            <i class="fa-solid fa-sort" aria-hidden="true"></i> Set Ordering
                                        </a>
                                    </div>
                                @endif
                                <div class="text-end" style="padding-bottom:2px; display: inline;">
                                    <!--<input type="button" class="sitebtn"
        value="Add New {{ ucwords($module->term) == 'CMS' ? 'Page' : ucwords($module->term) }}"
        onclick="add_content()"/>-->
                                    <a class="sitebtn" href="{{ admin_url() . 'module/' . $module->type . '/add' }} "> Add
                                        New
                                        {{ ucwords($module->term) == 'CMS' ? 'Page' : ucwords($module->term) }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="box-body table-responsive">
                            <table id="table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        @if (isset($module->show_featured_image) && $module->show_featured_image == 1)
                                            <th>Image</th>
                                        @endif
                                        <th>{{ ucwords($module->term) }} Heading</th>
                                        <th> Date</th>
                                        @if ($module->show_preview_link_on_listing_page == '1')
                                            <th>Preview</th>
                                        @endif
                                        @if (strcmp($module->type, 'cms'))
                                            <th>{{ ucwords($module->type) }} Status</th>
                                        @endif
                                        @if($module->id == 37)<th> Package Detail  </th>
                                        <th> No. Of Users</th>
                                        @endif
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($moduleMembers as $moduleMember)
                                        <tr>
                                            @if ($module->show_featured_image == 1)
                                                <td>
                                                    @if (!empty($moduleMember->featured_img))
                                                        <img width="100"
                                                            src="{{ base_url() . 'uploads/module/' . $module->type . '/' . $moduleMember->featured_img }}">
                                                    @endif
                                                </td>
                                            @endif
                                            <td>{{ $moduleMember->heading }}</td>
                                            <td> @php echo format_date($moduleMember->dated,'date_time'); @endphp</td>
                                            @if ($module->show_preview_link_on_listing_page == '1')
                                                <td>
                                                    @if ($module->type === 'cms')
                                                        @if ($moduleMember->is_pages == 1)
                                                            <a target="_blank"
                                                                href="{{ base_url() . ($moduleMember->permanent_page == 1 ? '' : '') . $moduleMember->post_slug }}">Preview</a>
                                                        @else
                                                            {{ ' ' }}
                                                        @endif
                                                    @else
                                                        <a target="_blank"
                                                            href="{{ base_url() . $moduleMember->post_slug }}">Preview</a>
                                                    @endif
                                                </td>
                                            @endif
                                            @if (strcmp($module->type, 'cms'))
                                                <td>
                                                    @php
                                                        if ($moduleMember->sts == 'active') {
                                                            $class_label = 'success';
                                                        } else {
                                                            $class_label = 'danger';
                                                        }
                                                    @endphp
                                                    <a onClick="update_module_status({{ $moduleMember->id }})"
                                                        href="javascript:" id="{{ 'sts_' . $moduleMember->id }}">
                                                        <span class="label {{ 'label-' . $class_label }}">
                                                            {{ $moduleMember->sts }} </span>
                                                    </a>
                                                </td>
                                            @endif
                                            @if ($moduleMember->cms_module_id == 37)
                                            <td>{!! substr_replace($moduleMember->content, "...", 195)  !!}</td>
                                            <td>@php echo package_use_member($moduleMember->id) @endphp </td>
                                            @endif
                                            <td>
                                                @if ($moduleMember->permanent_page == '1')
                                                    @if ($moduleMember->content_type == 'module')
                                                        <a class="btn btn-sm btn-primary"
                                                            href="{{ base_url() . 'adminmedia/module/' . $module->type . '/edit/' . $moduleMember->id }}"
                                                            title="Edit"><i class="fa-solid fa-pencil"></i> Edit</a>
                                                        <a target="_blank" class="btn btn-sm btn-primary"
                                                            href="{{ base_url() . 'adminmedia/module/' . $moduleMember->post_slug }}"
                                                            title="Edit"><i class="fa-solid fa-wrench"></i> Manage</a>
                                                    @else
                                                        <a class="btn btn-sm btn-primary"
                                                            href="{{ base_url() . 'adminmedia/module/' . $module->type . '/edit/' . $moduleMember->id }}"
                                                            title="Edit"><i class="fa-solid fa-pencil"></i> Edit</a>
                                                        @if ($moduleMember->id == 118)
                                                            <a target="_blank" class="btn btn-sm btn-primary"
                                                                href="{{ base_url() . 'adminmedia/manage_contact' }}"
                                                                title="Manage">Manage</a>
                                                        @endif
                                                        @if ($moduleMember->id == 175)
                                                            <a target="_blank" class="btn btn-sm btn-primary"
                                                                href="{{ base_url() . 'adminmedia/gallery' }}"
                                                                title="Edit"> Manage</a>
                                                        @endif
                                                    @endif
                                                @else
                                                    <a class="btn btn-sm btn-primary"
                                                        href="{{ base_url() . 'adminmedia/module/' . $module->type . '/edit/' . $moduleMember->id }}"
                                                        title="Edit"><i class="fa-solid fa-pencil"></i> Edit</a>
                                                    <a class="btn btn-sm btn-danger" href="javascript:void(0)"
                                                        title="Delete" onclick="delete_content({{ $moduleMember->id }})"><i
                                                            class="fa-solid fa-trash"></i> Delete</a>
                                                @endif
                                                @if ($module->term == 'Classes')
                                                    <a href="{{ route('class.show', $moduleMember->id) }}"
                                                        class="btn btn-success btn-sm">View Registered
                                                        User</a>
                                                @elseif($module->term == 'Camps')
                                                    <a href="{{ route('camp.show', $moduleMember->id) }}"
                                                        class="btn btn-success btn-Sm">View Registered User</a>
                                                @endif
                                                @if ($moduleMember->cms_module_id == 37)
                                                <br/>
                                                <a href="{{route('package_content_index',$moduleMember->id)}}" class="btn btn-primary" style="margin-top:5px;">Manage Package Content</a>
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
            <div> {{ $moduleMembers->links() }} </div>
        </section>
    </aside>
@endsection
@section('beforeBodyClose')
    <script type="text/javascript" src="{{ base_url() . 'module/module/admin/js/module.js' }}"></script>
    <script type="text/javascript" src="{{ base_url() . 'back/js/plugins/datatables/jquery.dataTables.js' }}"></script>
    <!-- Filer -->
    <link rel="stylesheet" href="{{ base_url() . 'module/module/admin/filer/css/jquery.filer.css' }}">
    <script src="{{ base_url() . 'module/module/admin/filer/js/jquery.filer.min.js' }}"></script>
    <link rel="stylesheet" href="{{ base_url() . 'module/module/admin/crop-avatar/cropper.css' }}">
    <style>
        img {
            max-width: 100%;
        }
    </style>
    <script src="{{ base_url() . 'module/module/admin/crop-avatar/cropper.js' }}"></script>
    @include('back.module.module_js')
    <script type="text/javascript" src="{{ base_url() . 'back/js/std_functions.js' }}"></script>
    <script>
        var uploadUrl = "{{ admin_url() }}module_image/upload_image";
        var deleteUrl = "{{ admin_url() }}module_image/remove_image";
        var folder = "{{ 'module/' . $module->type }}";
        var maxSize = {{ session('max_image_size') }};
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var show_cropper = {{ $module->crop_image == 'Yes' ? 1 : 0 }};
        var module_id = "{{ $module->type }}";
    </script>
    <script type="text/javascript" src="{{ base_url() . 'back/js/fileUploader.js' }}"></script>
    <div id="loading" class="loadinggif" style="display: none;"></div>
    <!-- End Bootstrap modal -->
    
    @if (isset($_GET['id'])) {
        <script>
            $(document).ready(function() {
                edit_module({{ $_GET['id'] }})
            });
        </script>
    @endif
@endsection
