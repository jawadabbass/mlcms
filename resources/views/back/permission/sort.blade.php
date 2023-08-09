@extends('back.layouts.app')
@section('content')
    <div class="content-wrapper pl-3 pr-2">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-6 subheader-transparent" id="kt_subheader">
            <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <!--begin::Page Heading-->
                    <div class="d-flex align-items-baseline flex-wrap mr-5">
                        <!--begin::Page Title-->
                        <h5 class="text-dark font-weight-bold my-1 mr-5">Manage Permissions</h5>
                        <!--end::Page Title-->
                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ url('adminmedia/') }}" class="text-muted">Home</a>
                            </li>
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('permissions.index') }}" class="text-muted">Permissions</a>
                            </li>
                        </ul>
                        <!--end::Breadcrumb-->
                    </div>
                    <!--end::Page Heading-->
                </div>
                <!--end::Info-->
            </div>
        </div>
        <!--end::Subheader-->
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                <!--begin::Notice-->
                @include('back.common_views.alert')
                <!--end::Notice-->
                <!--begin::Card-->
                <div class="card card-custom">
                    <div class="card-header">
                        <div class="card-title">
                            <span class="card-icon">
                                <i class="flaticon2-layers text-primary"></i>
                            </span>
                            <h3 class="card-label">Drag and Drop to Sort Permissions</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="permission_group_id">Permissions Group</label>
                                    <select name="permission_group_id" id="permission_group_id" class="form-control" onchange="refreshPermissionSortData();">
                                        {!! generatePermissionGroupsDropDown('', false) !!}
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div id="permissionSortDataDiv"></div>
                    </div>
                </div>
                <!--end::Card-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>
@endsection
@section('beforeBodyClose')
<script>
    $(document).ready(function () {
        refreshPermissionSortData();
    });
    function refreshPermissionSortData() {
        var permission_group_id = $('#permission_group_id').val();
        if(permission_group_id != ''){
        $.ajax({
            type: "GET",
            url: "{{ route('permissions.sort.data') }}",
            data: {permission_group_id: permission_group_id},
            success: function (responseData) {
                $("#permissionSortDataDiv").html('');
                $("#permissionSortDataDiv").html(responseData);
                /**************************/
                $('#sortable').sortable({
                    placeholder: "ui-state-highlight",
                    update: function (event, ui) {
                        var permissionOrder = $(this).sortable('toArray').toString();
                        $.post("{{ route('permissions.sort.update') }}", {permissionOrder: permissionOrder, _method: 'PUT', _token: '{{ csrf_token() }}'})
                    }
                });
                $("#sortable").disableSelection();
                /***************************/
            }
        });
    }

    }
</script>
@endsection
