@extends('back.layouts.app',['title'=>$title])

@section('content')
    <div class="content-wrapper pl-3 pr-2">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="row">
                <div class="col-md-5 col-sm-12">
                    <ol class="breadcrumb">
                        <li>
                            <a href="{{ base_url() . 'adminmedia' }}">
                                <i class="fas fa-tachometer-alt"></i> Home
                            </a>
                        </li>
                        <li class="active">Counties Management</li>
                    </ol>
                </div>
                <div class="col-md-7 col-sm-12">
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
                    placeholder: "ui-state-highlight",
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
