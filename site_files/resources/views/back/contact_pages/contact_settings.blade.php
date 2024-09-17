@extends('back.layouts.app',['title' => $title])
@section('beforeHeadClose')
    <script src="{{ asset_storage('') . 'module/contact_form_settings/admin/js/my_js.js' }}" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="{{asset_storage('') . 'module/contact_form_settings/admin/css/css.css' }}">
@endsection
@section('content')
    <div class="content-wrapper pl-3 pr-2">
        <section class="content-header">
            <div class="row">
                <div class="col-md-5 col-sm-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ admin_url() }}"> <i class="fas fa-gauge"></i> Home </a></li>
                        <li class="active">Contact Form Settings</li>
                    </ol>
                </div>
                <div class="col-md-7 col-sm-12"> @include('back.common_views.quicklinks') </div>
            </div>
        </section>

        <!-- Main content -->

        <section class="content">
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="card p-2">
                        <div class="box-header">
                            <h3 class=" card-title">All Blocked IP addresses</h3>
                        </div>
                        <div class="how_this_work"><a href="javascript:;" onClick="$('#mod_info').slideToggle();">How

                                does it work?</a></div>
                        <div id="mod_info" style="display:none;" role="alert"
                             class=" description alert alert-warning alert-dismissible "><strong>You can block exact IP
                                or a range of IP addresses from submitting your Contact Form.

                                If you put 0 it will be taken as full range.</strong> <br/>
                            for example<br>
                            (1). If you type <strong>165.139.149.169</strong> then this exact IP will be blocked. <br>
                            (2). If you type <strong>165.139.149.0</strong> then all IPs in the last set will be blocked

                            like 165.139.149.1, 165.139.149.102, 165.139.149.169 etc<br>
                            (3). If you type <strong>165.139.0.0</strong> then all IPs starting 165.139. onwards will be

                            blocked like 165.139.149.169, 165.139.100.102, 165.139.35.169 etc<br>
                            <br>
                            <strong>Your are not allowed to type 165.0.0.0 OR 0.0.0.0</strong> <br>
                            Your own IP at this time is: <strong>{{ $_SERVER['REMOTE_ADDR']}}</strong>. Make

                            sure you don't block it. If by any chance you block your own IP address, please contact

                            MediaLinkers Support.
                        </div>

                        <!-- /.box-header -->

                        <div class=" card-body table-responsive">
                            <div class="text-end" style="padding-bottom:2px;">
                                <input type="button" class="btn btn-primary btn-sm" value="Add IP"
                                       onClick="load_my_add_form();"/>
                                <input type="button" class="btn btn-primary btn-sm" value="Blocked Keywords"
                                       onClick="load_spam_words();"/>
                            </div>
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>IP</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                @if ($result)

                                    @foreach ($result as $row)
                                        <tr id="row_{{ $row->ID }}">
                                            <td> {{ $row->ip_list }} </td>
                                            <td> @php

                                                    if ($row->sts == 'active')

                                                    $class_label = 'success';

                                                    else

                                                    $class_label = 'danger';

                                                @endphp <a onClick="update_my_status({{ $row->ID }});"
                                                           href="javascript:;"
                                                           id="sts_{{ $row->ID }}"> <span
                                                            class="label label-{{ $class_label }}">{{ $row->sts }}</span>
                                                </a></td>
                                            <td><a href="javascript:;" onClick="load_my_edit_form({{ $row->ID }});"
                                                   class="btn btn-success btn-sm">Edit</a> <a
                                                        href="javascript:delete_my({{ $row->ID }});"
                                                        class="btn btn-danger btn-sm">Delete</a></td>
                                        </tr>
                                    @endforeach

                                @else
                                    <tr>
                                        <td colspan="5" align="center" class="text-red">No Record found!</td>
                                    </tr>
                                @endif
                                </tbody>

                                <tfoot>
                                </tfoot>
                            </table>
                        </div>
                        <div class="paginationWrap"> {{ $result->links() }} </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="modal fade" id="add_page_form" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <form name="frm_my" id="frm_faq" enctype="multipart/form-data" role="form" method="post"
                  action="{{ route('contact_form_settings.store') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add IP</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          
        </button>
                    </div>
                    <div class="modal-body">
                        <div class=" card-body">
                            <div class="mb-2">
                                <label class="form-label">IP @php echo helptooltip('add_ip'); @endphp</label>
                                <input type="text" class="form-control" id="question" name="question"
                                       value="{{ old('question') }}" placeholder="IP">
                                @if ($errors->has('question'))
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif </div>
                            <div style="clear:both"></div>
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
    <!-- Edit Model-->
    <div class="modal fade" id="edit_page_form" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <form name="frm_faq" id="edit_frm_faq" enctype="multipart/form-data" role="form" method="post"
                  action="{{ route('contact_form_settings.update',0) }}">
                @csrf

                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit IP</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          
        </button>
                    </div>
                    <div class="modal-body">
                        <div class=" card-body">
                            <div class="mb-2">
                                <label class="form-label">Edit IP</label>
                                <input type="text" class="form-control" id="edit_question" name="edit_question"
                                       value="{{ old('edit_question') }}" placeholder="Question">
                                @if ($errors->has('edit_question'))
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif </div>
                            <input type="hidden" name="faq_id" id="faq_id" value="{{ old('faq_id') }}"/>
                            <div style="clear:both"></div>
                            <div style="clear:both"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                        <button type="submit"  name="submitter" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="edit_spam_area" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <form name="frm_faq" id="edit_frm_faq" enctype="multipart/form-data" role="form" method="post"
                  action="{{ base_url() .'adminmedia/contact_form_settings/spam' }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">

                        <h4 class="modal-title">Blocked

                            Keywords @php echo helptooltip('spam_words'); @endphp</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          
        </button>
                    </div>
                    <div class="modal-body">

                        <!-- /.box-header -->

                        <!-- form start -->

                        <div class=" card-body">
                            <div class="mb-2">
                                <label class="form-label">Add Blocked Keywords <em>Comma(,) separated</em></label>
                                <textarea name="spam_words" id="spam_words"
                                          class="form-control">{{ old('spam_words') }}</textarea>
                                @if ($errors->has('spam_words'))
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif </div>
                            <div style="clear:both"></div>
                            <div style="clear:both"></div>
                        </div>
                    </div>

                    <!-- /. card-body -->

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                        <button type="submit"  name="submitter" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('beforeBodyClose')
    <script type="text/javascript">
        $(document).ready(function (e) {
            $("#heading").change(function () {
                string_to_slug('heading', 'page_slug');
            });
        });
    </script>
    @if ($errors->any())
        <script type="text/javascript">
            @php
                $updateId = old('faq_id');
            @endphp
                    @if(!empty($updateId))
                window.onload = function () {
                load_my_edit_form({{ old('faq_id')}});
            }
            @else
            load_my_add_form();
            @endif
        </script>
    @endif
@endsection