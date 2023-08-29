@extends('back.layouts.app', ['title' => $title])
@section('content')
    <div class="content-wrapper pl-3 pr-2">
        <section class="content-header">
            <div class="row">
                <div class="col-md-5 col-sm-12">
                    <ol class="breadcrumb">
                        <li>
                            <a href="{{ admin_url() }}"><i class="fas fa-gauge"></i> Home</a>
                        </li>
                        <li class="active"> Site Settings</li>
                    </ol>
                </div>
                <div class="col-md-7 col-sm-12">
                    @include('back.common_views.quicklinks')
                </div>
            </div>
        </section>
        @if (\Session::has('updated_action'))
            <div class="message-container">
                <div class="callout callout-success">
                    <h4>{{ \Session::get('updated_action') }}</h4>
                </div>
            </div>
        @endif
        @if (\Session::has('error'))
            <div class="message-container">
                <div class="callout callout-danger">
                    <h4>{{ \Session::get('error') }}</h4>
                </div>
            </div>
        @endif
        @include('back.setting.templates.restriction_inner')
    </div>
@endsection
