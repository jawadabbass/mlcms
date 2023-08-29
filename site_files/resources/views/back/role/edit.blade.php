@extends('back.layouts.app')
@section('content')
    <div class="content-wrapper pl-3 pr-2">
        <section class="content-header">
            <div class="row">
                <div class="col-md-5 col-sm-12">
                    <ol class="breadcrumb">
                        <li>
                            <a href="{{ base_url() . 'adminmedia' }}">
                                <i class="fas fa-tachometer-alt"></i> Home
                            </a>
                        </li>
                        <li class="active">
                            <a href="{{ base_url() . 'adminmedia/roles' }}">
                                Roles
                            </a>
                        </li>
                    </ol>
                </div>
                <div class="col-md-7 col-sm-12">
                    @include('back.common_views.quicklinks')
                </div>
            </div>
        </section>
        <div class="container">
            <!--begin::Notice-->
            @include('back.common_views.alert')
            <!--end::Notice-->
            <!--begin::Card-->

            <div class="card">
                <div class="card-header">
                    <h3 class="card-label"> Roles Management</h3>
                </div>
                <div class="card-body">
                    @include('back.common_views.validation_errors')
                    <form name="store_roles" id="store_roles" method="POST"
                        action="{{ route('roles.update', [$role->id]) }}">
                        <input type="hidden" name="_method" value="PUT" />
                        <ul class="nav nav-tabs" id="role_permissions" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="role_details-tab" data-bs-toggle="tab"
                                    data-bs-target="#role_details-tab-pane" type="button" role="tab"
                                    aria-controls="role_details-tab-pane" aria-selected="true">Role Details</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="role_permissions-tab" data-bs-toggle="tab"
                                    data-bs-target="#role_permissions-tab-pane" type="button" role="tab"
                                    aria-controls="role_permissions-tab-pane" aria-selected="true">Role Permissions</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="role_permissionsContent">
                            <div class="tab-pane fade show active mt-3" id="role_details-tab-pane" role="tabpanel"
                                aria-labelledby="role_details-tab" tabindex="0">@include('back.role.forms.form')</div>
                            <div class="tab-pane fade mt-3" id="role_permissions-tab-pane" role="tabpanel"
                                aria-labelledby="role_permissions-tab" tabindex="0">
                                <div class="form-group">
                                    <label class="text-success">Role has following permissions!</label>
                                    <br/><label class="text-default"><input type="checkbox" id="selectAllPermissions" value="1"
                                        onclick="selectAllCheckBoxes();">&nbsp;&nbsp;&nbsp;Select All</label>
                                    <div class="@error('permission_ids') is-invalid @enderror">
                                        {!! generatePermissionsCheckBoxes($role) !!}
                                    </div>
                                    @error('permission_ids')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success mr-2">Update</button>
                        </div>
                    </form>
                </div>
            </div>
            <!--end::Card-->
        </div>
    </div>
@endsection
@section('beforeBodyClose')
    <script>
        function selectAllCheckBoxes() {
            let selectAll = $('#selectAllPermissions').prop('checked');
            console.log(selectAll);
            if(selectAll){
                $('.permission_ids_checkbox').prop('checked', true);
            }else{
                $('.permission_ids_checkbox').prop('checked', false);
            }
        }
    </script>
@endsection