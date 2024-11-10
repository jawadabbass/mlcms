@extends('back.layouts.app', ['title' => $title])

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
                        <li class="active">
                            <a href="{{ base_url() . 'adminmedia/site-map' }}">
                                Site Map Management
                            </a>

                        </li>
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
                    <div class="card">
                        <div class="row card-header">
                            <div class="col-sm-8">
                                <h3 class="card-title">Sort Site Map</h3>
                            </div>
                            <div class="col-sm-4 text-end">
                                <a href="{{ base_url() . 'adminmedia/site-map' }}" class="btn btn-warning">Site Map</a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <div class="row">
                                <div class="col-md-12 mt-3 mb-3">
                                    <h3>Drag and Drop to Sort</h3>
                                    <label>Parent Category</label>
                                    <select class="form-control" name="parent_id" id="parent_id"
                                        onchange="refreshSiteMapSortData();">
                                        {!! generateParentSiteMapsDropDown(request('parent_id', 0)) !!}
                                    </select>
                                </div>
                                <div class="col-md-12 mt-1">
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <button type="button" class="btn btn-success m-3"
                                                onclick="sortSiteMapsByTitle();">Sort Site Map By Title</button>                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-1">
                                    <div id="siteMapSortDataDiv"></div>
                                </div>
                            </div>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    <!-- /.card -->
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    @include('back.common_views.spinner')
@endsection
@section('beforeBodyClose')
    <script>
        $(document).ready(function() {
            refreshSiteMapSortData();
        });

        function refreshSiteMapSortData() {
            let parent_id = $('#parent_id').val();
            $.ajax({
                type: "GET",
                url: "{{ route('site.map.sort.data') }}",
                data: {
                    lang: 'en',
                    parent_id: parent_id
                },
                success: function(responseData) {
                    $("#siteMapSortDataDiv").html('');
                    $("#siteMapSortDataDiv").html(responseData);
                    /**************************/
                    $('#sortable').sortable({
                        placeholder: "ui-state-highlight",
                        update: function(event, ui) {
                            var siteMapOrder = $(this).sortable('toArray').toString();
                            $.post("{{ route('site.map.sort.update') }}", {
                                siteMapOrder: siteMapOrder,
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

        function sortSiteMapsByTitle() {
            let parent_id = $('#parent_id').val();
            $.ajax({
                type: "GET",
                url: "{{ route('sort.site.map.by.title') }}",
                data: {
                    parent_id: parent_id
                },
                success: function(responseData) {
                    refreshSiteMapSortData();
                }
            });
        }
    </script>
@endsection
