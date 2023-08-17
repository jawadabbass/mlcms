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
                            <a href="{{ base_url() . 'adminmedia/admin-users' }}">
                                Admin Users
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
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-label"> Admin Users Management</h3>
                </div>
                <div class="card-body">
                    @include('back.common_views.validation_errors')
                    <form name="store_users" id="store_users" method="POST" action="{{ route('admin.user.update', [$user->id]) }}">
                        <input type="hidden" name="_method" value="PUT" />
                        <ul class="nav nav-tabs" id="user_roles" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="user_details-tab" data-bs-toggle="tab"
                                    data-bs-target="#user_details-tab-pane" type="button" role="tab"
                                    aria-controls="user_details-tab-pane" aria-selected="true">Admin User Details</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="user_roles-tab" data-bs-toggle="tab"
                                    data-bs-target="#user_roles-tab-pane" type="button" role="tab"
                                    aria-controls="user_roles-tab-pane" aria-selected="true">User Roles</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="user_rolesContent">
                            <div class="tab-pane fade show active mt-3" id="user_details-tab-pane" role="tabpanel"
                                aria-labelledby="user_details-tab" tabindex="0">@include('back.admin_users.forms.form')</div>
                            <div class="tab-pane fade mt-3" id="user_roles-tab-pane" role="tabpanel"
                                aria-labelledby="user_roles-tab" tabindex="0">
                                <div class="form-group">
                                    <label class="text-success">Admin User has following Roles!</label>
                                    <br />
                                    <label class="text-default"><input type="checkbox" id="selectAllRoles" value="1"
                                            onclick="selectAllCheckBoxes();">&nbsp;&nbsp;&nbsp;Select All</label>
                                    <div class="@error('role_ids') is-invalid @enderror">
                                        {!! generateRolesCheckBoxes($user) !!}
                                    </div>
                                    @error('role_ids')
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
            let selectAll = $('#selectAllRoles').prop('checked');
            console.log(selectAll);
            if (selectAll) {
                $('.role_ids_checkbox').prop('checked', true);
            } else {
                $('.role_ids_checkbox').prop('checked', false);
            }
        }
    </script>
@endsection