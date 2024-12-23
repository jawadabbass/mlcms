@extends('back.layouts.app', ['title' => $title])
@section('beforeHeadClose')
    @include('back.common_views.switch_css')
@endsection
@section('content')
    <div class="pl-3 pr-2 content-wrapper">
        <!-- Block Header (Page header) -->
        <section class="content-header">
            <div class="row">
                <div class="col-md-5 col-sm-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ admin_url() . '' }}"><i class="fas fa-gauge"></i> Home</a></li>
                        <li class="active">Widgets Management</li>
                    </ol>
                </div>
                <div class="col-md-7 col-sm-12"> @include('back.common_views.quicklinks') </div>
            </div>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="p-2 card">
                        <div class="row">
                            <div class="col-sm-8">
                                <h3 class=" card-title">All Widgets</h3>
                            </div>
                            <div class="col-sm-4">
                                <div class="text-end" style="padding-bottom:2px;">
                                    {{-- <input type="button" class="sitebtn" value="Add New Widgets"
                                           onClick="load_widgets_add_form();"/> --}}
                                    <a href="{{ route('widgets.create') }}" class="sitebtn">Add New Widgets</a>

                                </div>
                            </div>
                        </div>
                        <div class=" card-body table-responsive">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th width="15%">Image</th>
                                        <th>Heading</th>
                                        <th>Added Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($result)
                                        @foreach ($result as $row)
                                            <tr id="row_{{ $row->id }}">
                                                <td>
                                                    @if ($row->featured_image)
                                                        <img src="{{ asset_uploads('widgets/' . $row->featured_image) }}"
                                                            style="width:150px;height:80px;">
                                                    @endif
                                                </td>
                                                <td>{{ substr($row->heading, 0, 36) }}</td>
                                                <td>{{ format_date($row->dated, 'date') }}</td>
                                                <td>
                                                    <label class="switch">
                                                        <input type="checkbox" name="{{ 'sts_' . $row->id }}"
                                                            id="{{ 'sts_' . $row->id }}" <?php echo $row->sts == 1 ? ' checked' : ''; ?>
                                                            value="<?php echo $row->sts; ?>"
                                                            onClick="update_widgets_status({{ $row->id }})">
                                                        <div class="slider round">
                                                            <strong class="on">Active</strong>
                                                            <strong class="off">Inactive</strong>
                                                        </div>
                                                    </label>
                                                </td>
                                                <td>
                                                    <a href="{{ route('widgets.show', $row->id) }}"
                                                        class="btn btn-success btn-sm">Edit</a>

                                                    <a href="{{ route('widget.option', $row->id) }}"
                                                        class="btn btn-warning btn-sm">option</a>
                                                    <a href="javascript:;"
                                                        onClick="delete_widget({{ $row->id }});"class="btn btn-danger btn-sm">Delete</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" align="center" class="text-red">No Record found!</td>
                                        </tr>
                                    @endif
                                </tbody>
                                <tfoot>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


@endsection
@section('beforeBodyClose')
    <script type="text/javascript">
        $(document).ready(function(e) {
            $("#heading").change(function() {
                string_to_slug('heading', 'page_slug');
            });
            $("#page_slug").change(function() {
                check_slug('page_slug');
            });
        });
    </script>
    <!-- Filer -->
@endsection
