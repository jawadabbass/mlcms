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
                        <h3 class="card-label">Permissions Management</h3>
                    </div>
                </div>
                <div class="card-body">
                        @include('back.common_views.validation_errors')
                    <!--begin: Datatable-->
                    <form name="store_permission" id="store_permission" method="POST"
                                action="{{ route('permissions.update', [$permission->id]) }}" class="form">
                                <input type="hidden" name="_method" value="PUT" />
                                <div class="form-body">
                                    @include('permission.forms.form')

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-success font-weight-bold mr-2">Update</button>
                                    </div>
                                </div>
                            </form>
                    <!--end: Datatable-->
                </div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>
@endsection
