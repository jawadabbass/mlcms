@extends('back.layouts.app', ['title' => $title])
@section('beforeHeadClose')
@include('back.common_views.switch_css')
@endsection
@section('content')
    <div class="content-wrapper pl-3 pr-2">
        <section class="content-header">
            <div class="row">
                <div class="col-md-5 col-sm-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ admin_url() }}"> <i class="fas fa-gauge"></i> Home </a></li>
                        <li class="active">{{ ucwords($module->term) }}</li>
                    </ol>
                </div>
                <div class="col-md-7 col-sm-12"> @include('back.common_views.quicklinks') </div>
            </div>
        </section>
        <section class="content">
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
                                            <i class="fas fa-sort" aria-hidden="true"></i> Set Ordering
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
                                        @if ($module->id == 37)
                                            <th> Package Detail </th>
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
                                                            src="{{ asset_uploads('') . 'module/' . $module->type . '/' . $moduleMember->featured_img }}">
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
                                                    <label class="switch">
                                                        <input type="checkbox" name="{{ 'sts_' . $moduleMember->id }}"
                                                            id="{{ 'sts_' . $moduleMember->id }}" <?php echo $moduleMember->sts == 'active' ? ' checked' : ''; ?>
                                                            value="<?php echo $moduleMember->sts; ?>"
                                                            onClick="update_module_status_toggle({{ $moduleMember->id }})">
                                                        <div class="slider round">
                                                            <strong class="on">Active</strong>
                                                            <strong class="off">Inactive</strong>
                                                        </div>
                                                    </label>
                                                </td>
                                            @endif
                                            @if ($moduleMember->cms_module_id == 37)
                                                <td>{!! substr_replace(adjustUrl($moduleMember->content), '...', 195) !!}</td>
                                                <td>@php echo package_use_member($moduleMember->id) @endphp </td>
                                            @endif
                                            <td>
                                                @if ($moduleMember->permanent_page == '1')
                                                    @if ($moduleMember->content_type == 'module')
                                                        <a class="btn btn-sm btn-primary"
                                                            href="{{ base_url() . 'adminmedia/module/' . $module->type . '/edit/' . $moduleMember->id }}"
                                                            title="Edit"><i class="fas fa-edit"></i> Edit</a>
                                                        <a target="_blank" class="btn btn-sm btn-primary"
                                                            href="{{ base_url() . 'adminmedia/module/' . $moduleMember->belongsToModule($moduleMember, 'type', $moduleMember->post_slug) }}"
                                                            title="Edit"><i class="fas fa-wrench"></i> Manage</a>
                                                    @else
                                                        <a class="btn btn-sm btn-primary"
                                                            href="{{ base_url() . 'adminmedia/module/' . $module->type . '/edit/' . $moduleMember->id }}"
                                                            title="Edit"><i class="fas fa-edit"></i> Edit</a>
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
                                                        title="Edit"><i class="fas fa-edit"></i> Edit</a>
                                                    <a class="btn btn-sm btn-danger" href="javascript:void(0)"
                                                        title="Delete"
                                                        onclick="delete_content({{ $moduleMember->id }})"><i
                                                            class="fas fa-trash"></i> Delete</a>
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
                                                    <br />
                                                    <a href="{{ route('package_content_index', $moduleMember->id) }}"
                                                        class="btn btn-primary" style="margin-top:5px;">Manage Package
                                                        Content</a>
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
        </section>
    </div>
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
    @include('back.module.module_js')
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
    <div id="loading" class="loadinggif" style="display: none;"></div>
    <!-- End Bootstrap modal -->
    @php
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            echo '<script>
                $(document).ready(function() {
                    edit_module('.$_GET['
                        id '].')
                });
            </script>';
        }
    @endphp
@endsection
