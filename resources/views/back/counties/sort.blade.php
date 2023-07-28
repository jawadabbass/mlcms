@extends('back.layouts.app',['title'=>$title])

@section('content')
    <div class="content-wrapper pl-3 pr-2">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="row">
                <div class="col-md-8 col-sm-6">
                    <ol class="breadcrumb">
                        <li>
                            <a href="{{ base_url() . 'adminmedia' }}">
                                <i class="fas fa-tachometer-alt"></i> Home
                            </a>
                        </li>
                        <li class="active">Counties Management</li>
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
                                    <h3 class="box-title">Sort Counties</h3>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="text-end" style="padding-bottom:2px;">
                                    <a href="{{ route('counties.index') }}" class="sitebtn">Counties</a>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table-responsive">
                                <h3>Drag and Drop to Sort</h3>
                                <div class="row mt-2">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label>Select State To Sort Its Counties</label>
                                            <select class="form-control select2" name="state_id" id="state_id">
                                                {!! generateStatesDropDown(request('state_id', ''), true) !!}
                                            </select>
                                        </div>
                                    </div>    
                                    <div class="col-md-12" id="countiesSortDataDiv"></div>    
                                </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                    <!-- /.box -->
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
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

    .ui-county-highlight {
        height: 2.0em;
        line-height: 1.0em;
    }

    .ui-county-default {
        border: 1px solid #0bb783;
        background: #0bb783;
        font-weight: bold;
        color: #fff;
    }

</style>
@endsection
@section('beforeBodyClose')
<script>
    $('#state_id').on('change', function () {
        refreshCountySortData();
    });
    function refreshCountySortData() {
        let state_id = $('#state_id').val();
        $.ajax({
            type: "GET",
            url: "{{ route('counties.sort.data') }}",
            data: {lang: 'en', state_id:state_id},
            success: function (responseData) {
                $("#countiesSortDataDiv").html('');
                $("#countiesSortDataDiv").html(responseData);
                /**************************/
                $('#sortable').sortable({
                    placeholder: "ui-county-highlight",
                    update: function (event, ui) {
                        var countiesOrder = $(this).sortable('toArray').toString();
                        $.post("{{ route('counties.sort.update') }}", {countiesOrder: countiesOrder, _method: 'PUT', _token: '{{ csrf_token() }}'})
                    }
                });
                $("#sortable").disableSelection();
                /***************************/
            }
        });
    }
</script>
@endsection
