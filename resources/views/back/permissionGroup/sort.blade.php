@extends('back.layouts.app')
@section('content')
    <div class="content-wrapper pl-3 pr-2">
        <!--begin::Subheader-->
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
                            <a href="{{ base_url() . 'adminmedia/permissionGroup' }}">
                                Permission Groups
                            </a>
                        </li>
                    </ol>
                </div>
                <div class="col-md-7 col-sm-12">
                    @include('back.common_views.quicklinks')
                </div>
            </div>
        </section>
        <!--end::Subheader-->
        <!--begin::Entry-->
        <div class="container">
            <!--begin::Notice-->
            @include('back.common_views.alert')
            <!--end::Notice-->
            <!--begin::Card-->
            <div class="card card-info">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">Drag and Drop to Sort Permission Groups</h3>
                    </div>
                </div>
                <div class="card-body" id="permissionGroupSortDataDiv"></div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Entry-->
    </div>
@endsection
@section('beforeBodyClose')
    <script>
        $(document).ready(function() {
            refreshPermissionGroupSortData();
        });

        function refreshPermissionGroupSortData() {
            $.ajax({
                type: "GET",
                url: "{{ route('permissionGroup.sort.data') }}",
                success: function(responseData) {
                    $("#permissionGroupSortDataDiv").html('');
                    $("#permissionGroupSortDataDiv").html(responseData);
                    /**************************/
                    $('#sortable').sortable({
                        placeholder: "ui-state-highlight",
                        update: function(event, ui) {
                            var permissionGroupOrder = $(this).sortable('toArray').toString();
                            $.post("{{ route('permissionGroup.sort.update') }}", {
                                permissionGroupOrder: permissionGroupOrder,
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
