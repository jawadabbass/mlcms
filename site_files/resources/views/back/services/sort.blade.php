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
                            <a href="{{ base_url() . 'adminmedia/services' }}">
                                Services Management
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
                                <h3 class="card-title">Sort Services</h3>
                            </div>
                            <div class="col-sm-4 text-end">
                                <a href="{{ base_url() . 'adminmedia/services' }}" class="btn btn-warning">Services</a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <h3>Drag and Drop to Sort</h3>
                            <div class="row">
                                <div class="col-md-12 mt-3 mb-3">
                                    <label>Parent Category</label>
                                    <select class="form-control" name="parent_id" id="parent_id"
                                        onchange="refreshServiceSortData();">
                                        {!! generateParentServicesDropDown(request('parent_id', 0)) !!}                                        
                                    </select>
                                </div>
                                <div class="col-md-12 mt-1">
                                    <div id="servicesSortDataDiv"></div>
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
            refreshServiceSortData();
        });

        function refreshServiceSortData() {
            let parent_id = $('#parent_id').val();
            $.ajax({
                type: "GET",
                url: "{{ route('services.sort.data') }}",
                data: {
                    lang: 'en',
                    parent_id: parent_id
                },
                success: function(responseData) {
                    $("#servicesSortDataDiv").html('');
                    $("#servicesSortDataDiv").html(responseData);
                    /**************************/
                    $('#sortable').sortable({
                        placeholder: "ui-state-highlight",
                        update: function(event, ui) {
                            var servicesOrder = $(this).sortable('toArray').toString();
                            $.post("{{ route('services.sort.update') }}", {
                                servicesOrder: servicesOrder,
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
