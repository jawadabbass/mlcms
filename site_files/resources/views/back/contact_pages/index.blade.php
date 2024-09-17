@extends('back.layouts.app',['title' => $title ])
@section('beforeHeadCloase')
    <link href="{{ asset_storage('') . 'module/settings/admin/css/settings.css' }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="content-wrapper pl-3 pr-2">
        <section class="content-header">
            <div class="row">
                <div class="col-md-5 col-sm-12">
                    <ol class="breadcrumb">
                        <li><a href=" {{ admin_url() }}"><i class="fas fa-gauge"></i> Home</a></li>
                        <li class="active">Manage Contact Page</li>
                    </ol>
                </div>
                <div class="col-md-7 col-sm-12"> @include('back.common_views.quicklinks') </div>
            </div>
        </section>
        <div class="alert alert-warning">
            <h5> If you would like to manage IP addresses BLOCKED or spam words from the Contact Form, <a
                    href=" {{ base_url() . 'adminmedia/contact_form_settings' }}">Click here</a></h5>
        </div>
        <section class="content">
            @if ($errors->any())
                <div class="message-container">
                    <div class="callout callout-danger">
                        <h4>Please correct the These error.</h4>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </div>
                </div>
            @endif
            <div class="card p-2">
                <div class="row">
                    <div class="col-md-8 col-sm-8">
                        <h2>Office
                            Address @php echo helptooltip('office_address') @endphp</h2>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <div class="text-end"><a data-bs-toggle="modal" id="add_new_address" class="sitebtn"
                                data-bs-target="#myModal" href="javascript:;"><i class="fas fa-plus"></i>
                                Add New Office Address</a></div>
                    </div>
                </div>
                <div class="panel-group"> @php
                    
                    $cnt = 0;
                    
                @endphp
                    @foreach ($setting_result as $val)
                        @php $cnt++; @endphp
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title"><a data-bs-toggle="collapse" class="collapsed"
                                        id="office_link_{{ $val->ID }}" href="{{ '#collapse' . $cnt }}"> Office
                                        {{ $cnt }} Address
                                        @if ($val->type == 'main')
                                            {{ '(Main Office)' }} @php echo helptooltip('main_office'); @endphp
                                        @endif
                                    </a></h4>
                                @if ($val->type != 'main')
                                    <div class="remove"><a onClick="deleteAddress({{ $val->ID }})" href="#"> <i
                                                class="fas fa-times" title="Delete"></i> </a></div>
                                @endif
                            </div>
                            <div id="{{ 'collapse' . $cnt }}" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class=" card-body box box-solid"><span style="padding-right:20px;">
                                            <form name="emp_network_detail_ {{ $val->ID }}" method="post"
                                                id="frm_ {{ $val->ID }}"
                                                action=" {{ route('manage_contact.update', $val->ID) }}">
                                                @csrf
                                                <input type="hidden" name="_method" value="PUT">
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-6">
                                                        <div class="mb-2">
                                                            <label for="email">Name of Business </label>
                                                            <input type="text" class="form-control"
                                                                id="business_name" name="business_name"
                                                                value=" {{ old('business_name') ? old('business_name') : $val->business_name }}">
                                                            @if ($errors->has('business_name'))
                                                                {{ $errors->first('business_name') }}
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6">
                                                        <div class="mb-2">
                                                            <label for="email">Email </label>
                                                            <input type="email" class="form-control"
                                                                id="email_ {{ $val->ID }}" name="email"
                                                                value=" {{ old('email') ? old('email') : $val->email }}">
                                                            @if ($errors->has('email'))
                                                                {{ $errors->first('email') }}
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 col-sm-4">
                                                        <div class="mb-2">
                                                            <label for="telephone">Telephone</label>
                                                            <input type="text" class="form-control" id="telephone"
                                                                name="telephone"
                                                                value=" {{ old('telephone') ? old('telephone') : $val->telephone }}">
                                                            @if ($errors->has('telephone'))
                                                                {{ $errors->first('telephone') }}
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-sm-4">
                                                        <div class="mb-2">
                                                            <label for="telephone">Mobile</label>
                                                            <input type="text" class="form-control" id="mobile"
                                                                name="mobile"
                                                                value=" {{ old('mobile') ? old('mobile') : $val->mobile }}">
                                                            @if ($errors->has('mobile'))
                                                                {{ $errors->first('mobile') }}
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-sm-4">
                                                        <div class="mb-2">
                                                            <label for="telephone">Fax</label>
                                                            <input type="text" class="form-control" id="fax" name="fax"
                                                                value=" {{ old('fax') ? old('fax') : $val->fax }}">
                                                            @if ($errors->has('fax'))
                                                                {{ $errors->first('fax') }}
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 col-sm-12">
                                                        <div class="mb-2">
                                                            <label for="address">Address</label>
                                                            <textarea type="text" class="form-control myeditor22" id="address_ {{ $val->ID }}"
                                                                name="address"> {{ old('address') ? old('address') : $val->address }}</textarea>
                                                            @if ($errors->has('address'))
                                                                {{ $errors->first('address') }}
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6">
                                                        <div class="mb-2">
                                                            <label class="form-label">Working Days</label>
                                                            <input type="text" class="form-control" name="working_days"
                                                                placeholder="Working Days"
                                                                value="{{ $val->working_days }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6">
                                                        <div class="mb-2">
                                                            <label class="form-label">Working Hours</label>
                                                            <input type="text" class="form-control" name="working_hours"
                                                                placeholder="Working Hours"
                                                                value="{{ $val->working_hours }}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <br>
                                                <input type="submit"  name="change_network_details" value="Update"
                                                    class="sitebtn" />
                                                <input type="hidden" id="office_id" name="office_id"
                                                    value=" {{ $val->ID }}">
                                            </form>
                                        </span></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        <section class="content">
            <h3 class=" card-title">Contact email recipients </h2>
                <div class="row">
                    <div class="col-md-4">
                        <div class="myfromrow">
                            <div class="mb-2">
                                <label for="to_email">To Email @php echo helptooltip('setting_email') @endphp</label>
                                <input type="hidden" class="form-control" id="to_email"
                                    value=" {{ $contact_email_result->ID }}">
                                <input type="email" class="form-control" id="to_email_tb">
                                <p id="append_to_email"> @php
                                    
                                    if (!empty($contact_email_result->to_email)) {
                                        $cc_emails = explode(',', $contact_email_result->to_email);
                                    
                                        if (count($cc_emails) > 0) {
                                            for ($i = 0; $i < count($cc_emails); $i++) {
                                                echo '<span  class="cc_email_display">' . $cc_emails[$i] . '<i onclick="remove_to_emails(this, \'to_email\');" class="fas fa-times" aria-hidden="true"></i></span>';
                                            }
                                        }
                                    }
                                    
                                @endphp </p>
                                <p class="to_email_err"></p>
                                <input type="button" value="Add Email" id="add_to_contact_email" class="sitebtn" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="myfromrow">
                            <div class="mb-2">
                                <label for="cc_email">CC Email @php echo  helptooltip('setting_cc')@endphp</label>
                                <input type="hidden" class="form-control" id="cc_id"
                                    value=" {{ $contact_email_result->ID }}">
                                <input type="email" class="form-control" id="cc_email">
                                <p id="append_cc_email"> @php
                                    
                                    if (!empty($contact_email_result->cc_email)) {
                                        $cc_emails = explode(',', $contact_email_result->cc_email);
                                    
                                        if (count($cc_emails) > 0) {
                                            for ($i = 0; $i < count($cc_emails); $i++) {
                                                echo '<span  class="cc_email_display">' . $cc_emails[$i] . '<i onclick="remove_cc_emails(this, \'cc_email\');" class="fas fa-times" aria-hidden="true"></i></span>';
                                            }
                                        }
                                    }
                                    
                                @endphp </p>
                                <p class="cc_email_err"></p>
                                <input type="button" value="Add Email" id="add_cc_email" class="sitebtn" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="myfromrow">
                            <div class="mb-2">
                                <label for="bcc_email"> BCC Email @php echo  helptooltip('setting_bcc') @endphp</label>
                                <input type="email" class="form-control" id="bcc_email" name="bcc_email">
                                <p id="append_bcc_email"> @php
                                    
                                    if (!empty($contact_email_result->bcc_email)) {
                                        $bcc_email = explode(',', $contact_email_result->bcc_email);
                                    
                                        if (count($bcc_email) > 0) {
                                            for ($i = 0; $i < count($bcc_email); $i++) {
                                                echo '<span class="bcc_email_display">' . $bcc_email[$i] . '<i onclick="remove_bcc_emails(this, \'bcc_email\');" class="fas fa-times" aria-hidden="true"></i></span>';
                                            }
                                        }
                                    }
                                    
                                @endphp </p>
                                <p class="bcc_email_err"></p>
                                <input type="button" value="Add Email" id="add_bcc_email" class="sitebtn" />
                            </div>
                        </div>
                    </div>
                </div>
        </section>
        <section class="content">
            <h3 class=" card-title">Show following Google Map on your contact us
                Form @php echo  helptooltip('google_map') @endphp</h2>
                <div class="gmapbox">
                    <div class=" card-body box box-solid">
                        <form name="emp_network_detail" method="get"
                            action=" {{ route('manage_contact.edit', $contact_email_result->ID) }}">
                            <div class="mb-2">
                                <div class="mb-2">
                                    <iframe width="100%" height="250" frameborder="0" scrolling="no" marginheight="0"
                                        marginwidth="0"
                                        src="https://maps.google.it/maps?q= {{ strip_tags($contact_email_result->address) }}&output=embed"></iframe>
                                </div>
                                <div class="mb-2">
                                    <label for="telephone">Status @php helptooltip('google_map_status') @endphp</label>
                                    @php $statusVal = $contact_email_result->google_map_status; @endphp
                                    <select class="form-control" name="google_map_status" id="google_map_status">
                                        <option value="1" {{ $statusVal == 1 ? 'selected' : '' }}> On</option>
                                        <option value="0" {{ $statusVal == 0 ? 'selected' : '' }}>Off</option>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <input type="submit"  name="change_network_details" value="update" class="updatebtn" />
                        </form>
                    </div>
                </div>
        </section>
    </div>
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Office Address</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class=" card-body table-responsive box box-solid"><span style="padding-right:20px;">
                            <form name="emp_network_detail" method="post" action=" {{ route('manage_contact.store') }}">
                                @csrf
                                <div class="mb-2">
                                    <label for="email">Email </label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value=" {{ old('email') }}" required>
                                    @if ($errors->has('email'))
                                        {{ $errors->first('email') }}
                                    @endif
                                </div>
                                <div class="mb-2">
                                    <label for="telephone">Telephone</label>
                                    <input type="text" class="form-control" id="telephone" name="telephone"
                                        value=" {{ old('telephone') }}" required>
                                    @if ($errors->has('telephone'))
                                        {{ $errors->first('telephone') }}
                                    @endif
                                </div>
                                <div class="mb-2">
                                    <label for="telephone">Mobile</label>
                                    <input type="text" class="form-control" id="mobile" name="mobile"
                                        value=" {{ old('mobile') }}" required>
                                    @if ($errors->has('mobile'))
                                        {{ $errors->first('mobile') }}
                                    @endif
                                </div>
                                <div class="mb-2">
                                    <label for="telephone">Fax</label>
                                    <input type="text" class="form-control" id="fax" name="fax"
                                        value=" {{ old('fax') }}" required>
                                    @if ($errors->has('fax'))
                                        {{ $errors->first('fax') }}
                                    @endif
                                </div>
                                <div class="mb-2">
                                    <label for="address">Address</label>
                                    <textarea type="text" class="form-control myeditor22" id="address" name="address"
                                        required> {{ old('address') }}</textarea>
                                    @if ($errors->has('address'))
                                        {{ $errors->first('address') }}
                                    @endif
                                </div>
                                <div class="mb-2">
                                    <label for="working_days">Working Days</label>
                                    <textarea type="text" class="form-control myeditor22" id="working_days" name="working_days"
                                        required> {{ old('working_days') }}</textarea>
                                    @if ($errors->has('working_days'))
                                        {{ $errors->first('working_days') }}
                                    @endif
                                </div>
                                <div class="mb-2">
                                    <label for="working_hours">Working Hours</label>
                                    <textarea type="text" class="form-control myeditor22" id="working_hours" name="working_hours"
                                        required> {{ old('working_hours') }}</textarea>
                                    @if ($errors->has('working_hours'))
                                        {{ $errors->first('working_hours') }}
                                    @endif
                                </div>
                                <br>
                                <input type="submit"  name="change_network_details" value="update" class="updatebtn" />
                            </form>
                        </span></div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('beforeBodyClose')
    <script type="text/javascript" src="{{ asset_storage('') . 'module/settings/admin/js/settings.js' }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            table = $('#populate-cms-data').DataTable();
        });
    </script>
@endsection
