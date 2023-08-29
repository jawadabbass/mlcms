@extends('back.layouts.app')
@section('content')
    <div class="content-wrapper pl-3 pr-2">
        <!--begin::Subheader-->
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
            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">Drag and Drop to Sort Roles</h3>
                    </div>
                </div>
                <div class="card-body" id="rolesSortDataDiv"></div>
            </div>
            <!--end::Card-->
        </div>
    </div>
@endsection
@section('beforeBodyClose')
<script>
    $(document).ready(function () {
        refreshRoleSortData();
    });
    function refreshRoleSortData() {
        $.ajax({
            type: "GET",
            url: "{{ route('roles.sort.data') }}",
            data: {lang: 'en'},
            success: function (responseData) {
                $("#rolesSortDataDiv").html('');
                $("#rolesSortDataDiv").html(responseData);
                /**************************/
                $('#sortable').sortable({
                    placeholder: "ui-state-highlight",
                    update: function (event, ui) {
                        var rolesOrder = $(this).sortable('toArray').toString();
                        $.post("{{ route('roles.sort.update') }}", {rolesOrder: rolesOrder, _method: 'PUT', _token: '{{ csrf_token() }}'})
                    }
                });
                $("#sortable").disableSelection();
                /***************************/
            }
        });
    }
</script>
@endsection
