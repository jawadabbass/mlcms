@extends('back.layouts.app',['title'=>$title])
@section('content')
    <div class="content-wrapper pl-3 pr-2">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="row">
                <div class="col-md-5 col-sm-12 jawadcls">
                    <ol class="breadcrumb">
                        <li>
                            <a href="{{ base_url() . 'adminmedia' }}">
                                <i class="fas fa-tachometer-alt"></i> Home
                            </a>
                        </li>
                        <li class="active">Fleet Planes Management</li>
                    </ol>
                </div>
                <div class="col-md-7 col-sm-12 jawadcls">
                    @include('back.common_views.quicklinks')
                </div>
            </div>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="box">
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="box-header">
                                    <h3 class="box-title">Sort Fleet Planes</h3>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="text-end" style="padding-bottom:2px;">
                                    <a href="{{ route('fleetPlanes.index') }}" class="sitebtn">Fleet Planes</a>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table-responsive">
                                <h3>Drag and Drop to Sort</h3>
                                <div class="row m-3">
                                    <div class="col-lg-12 mb-3">
                                        <label class="form-label">Fleet Category:</label>
                                        <select class="form-control" name="fleet_category_id" id="fleet_category_id">
                                            {!! generateFleetCategoriesDropDown(0, false) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="row m-3">
                                    <div class="col-lg-12 mb-3">
                                        <div id="fleetPlanesSortDataDiv"></div>
                                    </div>
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
@section('beforeBodyClose')
<script>
    $(document).ready(function () {
        refreshFleetPlaneSortData();
    });
    $('#fleet_category_id').on('change', function () {
        refreshFleetPlaneSortData();
    });
    function refreshFleetPlaneSortData() {
        let fleet_category_id = $('#fleet_category_id').val();
        $.ajax({
            type: "GET",
            url: "{{ route('fleetPlanes.sort.data') }}",
            data: {fleet_category_id: fleet_category_id},
            success: function (responseData) {
                $("#fleetPlanesSortDataDiv").html('');
                $("#fleetPlanesSortDataDiv").html(responseData);
                /**************************/
                $('#sortable').sortable({
                    placeholder: "ui-state-highlight",
                    update: function (event, ui) {
                        var fleetPlanesOrder = $(this).sortable('toArray').toString();
                        $.post("{{ route('fleetPlanes.sort.update') }}", {fleetPlanesOrder: fleetPlanesOrder, _method: 'PUT', _token: '{{ csrf_token() }}'})
                    }
                });
                $("#sortable").disableSelection();
                /***************************/
            }
        });
    }
</script>
@endsection
