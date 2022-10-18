@extends('back.layouts.app',['title'=>$title])
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
                        <li class="active">
                            <a href="{{ base_url() . 'adminmedia/cabinDimensions' }}">
                                Cabin Dimensions Management
                            </a>
                            </li>
                    </ol>
                </div>
                <div class="col-md-4 col-sm-6">
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
                                    <h3 class="box-title">Sort Cabin Dimensions</h3>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="text-end" style="padding-bottom:2px;">
                                    <a href="{{ route('cabinDimensions.index') }}" class="sitebtn">Cabin Dimensions</a>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table-responsive">
                                <h3 class="mb-3">Drag and Drop to Sort</h3>
                                <div id="cabinDimensionsSortDataDiv"></div>
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
@section('beforeBodyClose')
<script>
    $(document).ready(function () {
        refreshCabinDimensionSortData();
    });
    function refreshCabinDimensionSortData() {
        $.ajax({
            type: "GET",
            url: "{{ route('cabinDimensions.sort.data') }}",
            data: {lang: 'en'},
            success: function (responseData) {
                $("#cabinDimensionsSortDataDiv").html('');
                $("#cabinDimensionsSortDataDiv").html(responseData);
                /**************************/
                $('#sortable').sortable({
                    placeholder: "ui-state-highlight",
                    update: function (event, ui) {
                        var cabinDimensionsOrder = $(this).sortable('toArray').toString();
                        $.post("{{ route('cabinDimensions.sort.update') }}", {cabinDimensionsOrder: cabinDimensionsOrder, _method: 'PUT', _token: '{{ csrf_token() }}'})
                    }
                });
                $("#sortable").disableSelection();
                /***************************/
            }
        });
    }
</script>
@endsection
