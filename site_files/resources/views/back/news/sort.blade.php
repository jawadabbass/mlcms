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
                        <li class="active">
                            <a href="{{ base_url() . 'adminmedia/news' }}">
                                News Management
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
                    <div class="card p-2">
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="box-header">
                                    <h3 class=" card-title">Sort News</h3>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="text-end" style="padding-bottom:2px;">
                                    <a href="{{ route('news.index') }}" class="sitebtn">News</a>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class=" card-body table-responsive">
                                <h3 class="mb-3">Drag and Drop to Sort</h3>
                                <div id="newsSortDataDiv"></div>
                        </div>
                        <!-- /. card-body -->
                    </div>
                    <!-- /.box -->
                    <!-- /.box -->
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    
@endsection
@section('beforeBodyClose')
<script>
    $(document).ready(function () {
        refreshNewsSortData();
    });
    function refreshNewsSortData() {
        $.ajax({
            type: "GET",
            url: "{{ route('news.sort.data') }}",
            data: {lang: 'en'},
            success: function (responseData) {
                $("#newsSortDataDiv").html('');
                $("#newsSortDataDiv").html(responseData);
                /**************************/
                $('#sortable').sortable({
                    placeholder: "ui-state-highlight",
                    update: function (event, ui) {
                        var newsOrder = $(this).sortable('toArray').toString();
                        $.post("{{ route('news.sort.update') }}", {newsOrder: newsOrder, _method: 'PUT', _token: '{{ csrf_token() }}'})
                    }
                });
                $("#sortable").disableSelection();
                /***************************/
            }
        });
    }
</script>
@endsection
