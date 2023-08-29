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
                            <a href="{{ base_url() . 'adminmedia/permissions' }}">
                                Permission
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
