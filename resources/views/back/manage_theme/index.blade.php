@extends('back.layouts.app', ['title' => $title])
@section('content')
    <div class="content-wrapper pl-3 pr-2">
        <section class="content-header">
            <div class="row">
                <div class="col-md-8 col-sm-6">
                    <ol class="breadcrumb">
                        <li><a href="{{ admin_url() }}"> <i class="fas fa-gauge"></i> Home </a></li>
                        <li class="active">Manage Theme</li>
                    </ol>
                </div>
                <div class="col-md-4 col-sm-6"> @include('back.common_views.quicklinks') </div>
            </div>
        </section>
        <section class="content">

            @if (\Session::has('update_action'))
                <div class="message-container">
                    <div class="callout callout-success">
                        <h4>Theme has been updated successfully.</h4>
                    </div>
                </div>
            @endif
            <form method="post" action="{{ admin_url() }}manage-theme/update">
                @csrf
                <div class="row">
                    <div class="col-md-2 text-end">Before Head Close</div>
                    <div class="col-md-10">
                        <textarea name="beforeHeadClose" id="beforeHeadClose" rows="10" class="form-control"></textarea>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-2 text-end">Header Section:</div>
                    <div class="col-md-10">
                        <textarea name="headerSection" id="headerSection" rows="10" class="form-control"></textarea>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-2 text-end">Main Content Section:</div>
                    <div class="col-md-10">
                        <textarea name="mainContentSection" id="mainContentSection" rows="10" class="form-control"></textarea>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-2 text-end">Footer Section:</div>
                    <div class="col-md-10">
                        <textarea name="footerSection" id="footerSection" rows="10" class="form-control"></textarea>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-2 text-end">Before Body Close:</div>
                    <div class="col-md-10">
                        <textarea name="beforeBodyClose" id="beforeBodyClose" rows="10" class="form-control"></textarea>
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-md-2 text-end"></div>
                    <div class="col-md-8">
                        <button id="submit" type="submit" class="btn btn-info"
                            onClick="document.getElementsById('submit').display='none'"> Update</button>
                    </div>
                </div>
            </form>


        </section>
    </div>
@endsection
@section('beforeBodyClose')
@endsection
