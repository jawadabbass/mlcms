@extends('back.layouts.app',['title'=>$title])
@section('beforeHeadClose')
    <link href="{{ base_url() . 'back/css/datatables/jquery.dataTables.css' }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <aside class="right-side {{ session('leftSideBar') == 1 ? 'strech' : '' }}">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="row">
                <div class="col-md-8 col-sm-6">
                    <ol class="breadcrumb">
                        <li>
                            <a href="{{ base_url() . 'adminmedia' }}">
                                <i class="fa-solid fa-dashboard"></i> Home
                            </a>
                        </li>
                        <li class="active">States Management</li>
                    </ol>
                </div>
                <div class="col-md-4 col-sm-6">
                    @include('back.common_views.quicklinks')
                </div>
            </div>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="message-container" id="add_action" style="display: none">
                <div class="callout callout-success">
                    <h4>New Wish has been created successfully.</h4>
                </div>
            </div>
            <div class="message-container" id="update_action" style="display: none;">
                <div class="callout callout-success">
                    <h4>Wish has been updated successfully.</h4>
                </div>
            </div>
            <div class="message-container" id="delete_action" style="display: none">
                <div class="callout callout-danger">
                    <h4>Wish has been deleted successfully.</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="box">
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="box-header">
                                    <h3 class="box-title">Sort States</h3>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="text-end" style="padding-bottom:2px;">
                                    <a href="{{ route('states.index') }}" class="sitebtn">States</a>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table-responsive">
                                <h3>Drag and Drop to Sort</h3>
                                <div id="statesSortDataDiv"></div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                    <!-- /.box -->
                </div>
            </div>
        </section>
        <!-- /.content -->
    </aside>
    @include('back.common_views.spinner')
@endsection
@section('beforeHeadClose')
<style>
    #sortable {
        list-style-type: none;
        margin: 0;
        padding: 0;
        width: 100%;
    }

    #sortable li {
        margin: 0 5px 5px 5px;
        padding: 5px;
        font-size: 1.2em;
        height: 2.0em;
        line-height: 1.0em;
    }

    .ui-state-highlight {
        height: 2.0em;
        line-height: 1.0em;
    }

    .ui-state-default {
        border: 1px solid #0bb783;
        background: #0bb783;
        font-weight: bold;
        color: #fff;
    }

</style>
@endsection
@section('beforeBodyClose')
<script>
    $(document).ready(function () {
        refreshStateSortData();
    });
    function refreshStateSortData() {
        $.ajax({
            type: "GET",
            url: "{{ route('states.sort.data') }}",
            data: {lang: 'en'},
            success: function (responseData) {
                $("#statesSortDataDiv").html('');
                $("#statesSortDataDiv").html(responseData);
                /**************************/
                $('#sortable').sortable({
                    placeholder: "ui-state-highlight",
                    update: function (event, ui) {
                        var statesOrder = $(this).sortable('toArray').toString();
                        $.post("{{ route('states.sort.update') }}", {statesOrder: statesOrder, _method: 'PUT', _token: '{{ csrf_token() }}'})
                    }
                });
                $("#sortable").disableSelection();
                /***************************/
            }
        });
    }
</script>
@endsection
