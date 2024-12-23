@extends('back.layouts.app', ['title' => $title])
@section('content')
    <div class="pl-3 pr-2 content-wrapper">
        <section class="content-header">
            <div class="row">
                <div class="col-md-5 col-sm-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ admin_url() }}"><i class="fas fa-gauge"></i> Home</a></li>
                        <li class="active">Social Media</li>
                    </ol>
                </div>
                <div class="col-md-7 col-sm-12"> @include('back.common_views.quicklinks') </div>
            </div>
        </section>
        <section class="content">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <h4>* {{ $error }}</h4>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="message-container" id="sortedMessage" style="display: none;">
                <div class="callout callout-success">
                    <h4>Order Has been Sorted.</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="p-2 card">
                        <div class="row">
                            <div class="col-sm-8">
                                <h3 class=" card-title">Social Media</h3>
                            </div>
                            <div class="col-sm-4">
                                <div class="text-end" style="padding-bottom:2px;">
                                    <input type="button" class="sitebtn" value="Add Social Media"
                                        onClick="load_social_media_add_form();" />
                                </div>
                            </div>
                        </div>
                        <div class=" card-body table-responsive">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Icons</th>
                                        <th>Name</th>
                                        <th>Link</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="sortable">
                                    @if ($result)
                                        @foreach ($result as $row)
                                            <tr id="row_{{ $row->id }}">
                                                <td style="font-size:36px;"><i class="fas {{ $row->i_class }}"></i></td>
                                                <td>{{ $row->name }}</td>
                                                <td>{{ $row->link }}</td>
                                                <td> 
                                                    <label class="switch">
                                                        <input type="checkbox" name="{{ 'sts_' . $row->id }}"
                                                            id="{{ 'sts_' . $row->id }}" <?php echo $row->sts == 1 ? ' checked' : ''; ?>
                                                            value="<?php echo $row->sts; ?>"
                                                            onClick="update_social_media_status({{ $row->id }})">
                                                        <div class="slider round">
                                                            <strong class="on">Active</strong>
                                                            <strong class="off">Inactive</strong>
                                                        </div>
                                                    </label>
                                                </td>
                                                <td><a href="javascript:;"
                                                        onClick="load_social_media_edit_form({{ $row->id }});"
                                                        class="btn btn-success btn-sm">Edit</a> <a
                                                        href="javascript:delete_social_media({{ $row->id }});"
                                                        class="btn btn-danger btn-sm">Delete</a></td>
                                                        <td align="center">
                                                            <span></span>
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
    </div>
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
                        <div class=" card-body">
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
                        <button type="submit"  name="submitter" class="btn btn-primary">Submit</button>
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
                        <div class=" card-body">
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
                                <button type="submit"  name="submitter" class="btn btn-primary">Update</button>
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
                            alert('Error adding / update data ' + ' ' + textStatus + ' ' + errorThrown);
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
