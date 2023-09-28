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
                        <li class="active">Cities Management</li>
                    </ol>
                </div>
                <div class="col-md-7 col-sm-12">
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
                                    <h3 class="box-title">Sort Cities</h3>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="text-end" style="padding-bottom:2px;">
                                    <a href="{{ route('cities.index') }}" class="sitebtn">Cities</a>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table-responsive">
                            <h3>Drag and Drop to Sort</h3>
                            <div class="row mt-2">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>State</label>
                                        <select class="form-control select2" name="state_id" id="state_id"
                                            onchange="filterCountiesAjax();">
                                            {!! generateStatesDropDown(request('state_id', ''), true) !!}
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group" id="counties_dd_div">
                                        <label>County</label>
                                        <select class="form-control select2" name="county_id" id="county_id">
                                            {!! generateCountiesDropDown(request('county_id', ''), request('state_id', ''), true) !!}
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12" id="citiesSortDataDiv"></div>
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

        .ui-city-highlight {
            height: 2.0em;
            line-height: 1.0em;
        }

        .ui-city-default {
            border: 1px solid #0bb783;
            background: #0bb783;
            font-weight: bold;
            color: #fff;
        }

    </style>
@endsection
@section('beforeBodyClose')
    <script>
        $(document).on('change', '#county_id', function() {
            refreshCitySortData();
        });

        function refreshCitySortData() {
            let county_id = $('#county_id').val();
            $.ajax({
                type: "GET",
                url: "{{ route('cities.sort.data') }}",
                data: {
                    lang: 'en',
                    county_id: county_id
                },
                success: function(responseData) {
                    $("#citiesSortDataDiv").html('');
                    $("#citiesSortDataDiv").html(responseData);
                    /**************************/
                    $('#sortable').sortable({
                        placeholder: "ui-city-highlight",
                        update: function(event, ui) {
                            var citiesOrder = $(this).sortable('toArray').toString();
                            $.post("{{ route('cities.sort.update') }}", {
                                citiesOrder: citiesOrder,
                                _method: 'PUT',
                                _token: '{{ csrf_token() }}'
                            })
                        }
                    });
                    $("#sortable").disableSelection();
                    /***************************/
                }
            });
        }
    </script>
@endsection
