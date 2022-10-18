@extends('back.layouts.app', ['title' => $title])
@section('content')
    <aside class="right-side {{ session('leftSideBar') == 1 ? 'strech' : '' }}">
        <section class="content-header">
            <div class="row">
                <div class="col-md-8 col-sm-6">
                    <ol class="breadcrumb">
                        <li><a href="{{ admin_url() }}"><i class="fa-solid fa-gauge"></i> Home</a></li>
                        <li class="active">Social Media</li>
                    </ol>
                </div>
                <div class="col-md-4 col-sm-6"> @include('back.common_views.quicklinks') </div>
            </div>
        </section>
        <section class="content">
            @if (\Session::has('added_action'))
                <div class="message-container">
                    <div class="callout callout-success">
                        <h4>New Social Media has been Created successfully.</h4>
                    </div>
                </div>
            @endif
            @if (\Session::has('update_action'))
                <div class="message-container">
                    <div class="callout callout-success">
                        <h4>Social Media has been updated successfully.</h4>
                    </div>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <h4>* {{ $error }}</h4>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (\Session::has('delete_action'))
                <div class="message-container">
                    <div class="callout callout-success">
                        <h4>Social Media has been Deleted successfully.</h4>
                    </div>
                </div>
            @endif
            <div class="message-container" id="sortedMessage" style="display: none;">
                <div class="callout callout-success">
                    <h4>Order Has been Sorted.</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="box">
                        <div class="row">
                            <div class="col-sm-8">
                                <h3 class="box-title">Social Media</h3>
                            </div>
                            <div class="col-sm-4">
                                <div class="text-end" style="padding-bottom:2px;">
                                    <input type="button" class="sitebtn" value="Add Social Media"
                                        onClick="load_social_media_add_form();" />
                                </div>
                            </div>
                        </div>
                        <div class="box-body table-responsive">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Icons</th>
                                        <th>Name</th>
                                        <th>Link</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="sortable">
                                    @if ($result)
                                        @foreach ($result as $row)
                                            <tr id="row_{{ $row->ID }}">
                                                <td style="font-size:36px;"><i class="fa-solid {{ $row->i_class }}"></i></td>
                                                <td>{{ $row->name }}</td>
                                                <td>{{ $row->link }}</td>
                                                <td> @php
                                                    if ($row->sts == 'active') {
                                                        $class_label = 'success';
                                                    } else {
                                                        $class_label = 'danger';
                                                    }
                                                @endphp <a
                                                        onClick="update_social_media_status({{ $row->ID }});"
                                                        href="javascript:;" id="sts_{{ $row->ID }}"> <i
                                                            class="label label-{{ $class_label }}">{{ $row->sts }}</i>
                                                    </a></td>
                                                <td><a href="javascript:;"
                                                        onClick="load_social_media_edit_form({{ $row->ID }});"
                                                        class="btn btn-success btn-sm">Edit</a> <a
                                                        href="javascript:delete_social_media({{ $row->ID }});"
                                                        class="btn btn-danger btn-sm">Delete</a> <span></span></td>
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
    <div class="modal fade" id="add_page_form" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <form name="frm_cms" id="frm_cms" enctype="multipart/form-data" role="form" method="post"
                action="{{ route('social_media.store') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add New Social Media</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          
        </button>
                    </div>
                    <div class="modal-body">
                        <div class="box-body">
                            <div class="mb-2">
                                <label class="form-label">Name </label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name') }}" placeholder="Like: e.g Facebook">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Alt Tag </label>
                                <input type="text" class="form-control" name="alt_tag" id="alt_tag"
                                    value="{{ old('alt_tag') }}" placeholder="Like: Facebook Page of YOUR BUSINESS NAME">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Social Media URL </label>
                                <input type="text" class="form-control" name="link" id="link"
                                    value="{{ old('link') }}"
                                    placeholder="Link To Your Social Media Page Like facebook.com/abcCompany">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Social Media Icon </label>
                                <input class="form-control icp icp-auto" name="i_class" id="i_classs" value="" type="text" autocomplete="off" data-placement="topRight" placeholder="fontawsome: fa-youtube"/>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Open in new tab</label>
                                <input type="checkbox" name="open_in_new_tab" id="open_in_new_tab" checked="">
                            </div>
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
    <div class="modal fade" id="edit_page_form" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <form name="frm_cms" id="frm_cms" enctype="multipart/form-data" role="form" method="post"
                action="{{ route('social_media.update', 0) }}" onSubmit="return validate_edit_social_media_form(this)">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Social Media</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          
        </button>
                    </div>
                    <div class="modal-body">
                        <div class="box-body">
                            <div class="mb-2">
                                <label class="form-label">Name </label>
                                <input type="text" class="form-control" id="edit_name" name="edit_name"
                                    value="{{ old('edit_name') }}" placeholder="Banner Title">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Alt Tag </label>
                                <input type="text" class="form-control" name="edit_alt_tag" id="edit_alt_tag"
                                    value="{{ old('edit_alt_tag') }}" placeholder="Alt Tag">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Social Media URL </label>
                                <input type="text" class="form-control" name="edit_link" id="edit_link"
                                    value="{{ old('edit_link') }}" placeholder="Social Media URL">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Social Media Icon </label>
                                <input class="form-control icp icp-auto" name="edit_i_class" id="i_class" value="{{ old('edit_i_class', '') }}" type="text" autocomplete="off" data-placement="topRight" placeholder="fontawsome: fa-youtube"/>
                            </div>
                            <div class="mb-2">
                                <input type="hidden" name="socail_media_id" id="socail_media_id" />
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Open in new tab</label>
                                <input type="checkbox" name="edit_open_in_new_tab" id="edit_open_in_new_tab"
                                    <?php if(old('edit_open_in_new_tab')=='Yes') {?>checked=""<?php } ?>>
                            </div>
                            <div style="clear:both"></div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                                <button type="submit" name="submitter" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('beforeBodyClose')
    <script>
        $(function() {
            $('#sortable').sortable({
                axis: 'y',
                opacity: 0.7,
                handle: 'span',
                update: function(event, ui) {
                    var list_sortable = $(this).sortable('toArray').toString();
                    // change order in the database using Ajax
                    console.log(list_sortable);
                    $.ajax({
                        url: base_url + 'adminmedia/social_media/create',
                        type: 'GET',
                        data: {
                            list_order: list_sortable
                        },
                        success: function(data) {
                            //finished
                            console.log(data);
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            alert('Error adding / update data');
                            console.log(jqXHR);
                            console.log(textStatus);
                            console.log(errorThrown);
                        }
                    });
                }
            }); // fin sortable
        });
    </script>
@endsection
