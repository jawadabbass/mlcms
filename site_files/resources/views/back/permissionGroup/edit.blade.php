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
                        <a href="{{ base_url() . 'adminmedia/permissionGroup' }}">
                            Permission Groups
                        </a>
                    </li>
                </ol>
            </div>
            <div class="col-md-7 col-sm-12">
                @include('back.common_views.quicklinks')
            </div>
        </div>
    </section>
    <!--end::Subheader-->
    <!--begin::Entry-->
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
                    <h3 class="card-label">Permission Groups Management</h3>
                </div>
                <div class="card-toolbar">
                    <!--begin::Button-->
                    <!--end::Button-->
                </div>
            </div>
            <div class="card-body">
                    @include('back.common_views.validation_errors')
                <!--begin: Datatable-->
                <form name="store_permissionGroup" id="store_permissionGroup" method="POST"
                                action="{{ route('permissionGroup.update', [$permissionGroup->id]) }}" class="form">
                                <input type="hidden" name="_method" value="PUT" />
                            <div class="form-body">
                                @include('back.permissionGroup.forms.form')

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-success mr-2">Update</button>
                                </div>
                            </div>
                        </form>
                <!--end: Datatable-->
            </div>
        </div>
        <!--end::Card-->
    </div>
    <!--end::Entry-->
</div>
@endsection