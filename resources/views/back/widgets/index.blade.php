@extends('back.layouts.app', ['title' => $title])
@section('content')
    <div class="content-wrapper pl-3 pr-2">
        <!-- Block Header (Page header) -->
        <section class="content-header">
            <div class="row">
                <div class="col-md-8 col-sm-6">
                    <ol class="breadcrumb">
                        <li><a href="{{ admin_url() . '' }}"><i class="fas fa-gauge"></i> Home</a></li>
                        <li class="active">Widgets Management</li>
                    </ol>
                </div>
                <div class="col-md-4 col-sm-6"> @include('back.common_views.quicklinks') </div>
            </div>
        </section>
        <section class="content">
            @if (\Session::has('added_action'))
                <div class="message-container">
                    <div class="callout callout-success">
                        <h4>New Widgets has been created successfully.</h4>
                    </div>
                </div>
            @endif
            @if (\Session::has('update_action'))
                <div class="message-container">
                    <div class="callout callout-success">
                        <h4>Record has been updated successfully.</h4>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="box">
                        <div class="row">
                            <div class="col-sm-8">
                                <h3 class="box-title">All Widgets</h3>
                            </div>
                            <div class="col-sm-4">
                                <div class="text-end" style="padding-bottom:2px;">
                                    {{-- <input type="button" class="sitebtn" value="Add New Widgets"
                                           onClick="load_widgets_add_form();"/> --}}
                                    @if (dev_ips())
                                        <a href="{{ route('widgets.create') }}" class="sitebtn">Add New Widgets</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="box-body table-responsive">
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
                                            <tr id="row_{{ $row->ID }}">
                                                <td>
                                                    @if ($row->featured_image)
                                                        <img src="{{ asset('uploads/widgets/' . $row->featured_image) }}"
                                                            style="width:150px;height:80px;">
                                                    @endif
                                                </td>
                                                <td>{{ substr($row->heading, 0, 36) }}</td>
                                                <td>{{ format_date($row->dated, 'date') }}</td>
                                                <td> @php
                                                    if ($row->sts == 'active') {
                                                        $class_label = 'success';
                                                    } else {
                                                        $class_label = 'danger';
                                                    }
                                                @endphp <a
                                                        onClick="update_widgets_status({{ $row->ID }});"
                                                        href="javascript:;" id="sts_{{ $row->ID }}"> <span
                                                            class="label label-{{ $class_label }}">{{ $row->sts }}</span>
                                                    </a></td>
                                                <td>
                                                    <a href="{{ route('widgets.show', $row->ID) }}"
                                                        class="btn btn-success btn-sm">Edit</a>
                                                    @if (dev_ips())
                                                        <a href="{{ route('widget.option', $row->ID) }}"
                                                            class="btn btn-warning btn-sm">option</a>
                                                    @endif
                                                    @if (dev_ips())
                                                        <a href="javascript:;"
                                                            onClick="delete_widget({{ $row->ID }});"class="btn btn-danger btn-sm">Delete</a>
                                                    @endif
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
        });
    </script>
    <!-- Filer -->
@endsection
