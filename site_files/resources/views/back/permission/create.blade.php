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
                    <h3 class="card-label">Permissions Management</h3>
                </div>
                <div class="card-toolbar">
                    <!--begin::Button-->
                    <!--end::Button-->
                </div>
            </div>
            <div class="card-body">
                    @include('back.common_views.validation_errors')
                <!--begin: Datatable-->
                <form name="store_permission" id="store_permission" method="POST"
                            action="{{ route('permissions.store') }}" class="form">
                            <div class="form-body">
                                @include('back.permission.forms.form')

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-success font-weight-bold mr-2">Submit</button>
                                </div>
                            </div>
                        </form>
                <!--end: Datatable-->
            </div>
        </div>
        <!--end::Card-->
    </div>
</div>
@endsection
