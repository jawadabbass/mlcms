@extends('back.layouts.app',['title' => $title ])
@section('content')
    <div class="content-wrapper pl-3 pr-2">
        <section class="content-header">
            <div class="row">
                <div class="col-md-5 col-sm-12">
                    <ol class="breadcrumb">
                        <li><a href="{{base_url() . 'adminmedia'}}"><i class="fas fa-tachometer-alt"></i> Home</a></li>
                        <li class="active">Admin Users Log</li>
                    </ol>
                </div>
                <div class="col-md-7 col-sm-12">
                    @include('back.common_views.quicklinks')
                </div>
            </div>
        </section>
        <section class="content">
            @if (\Session::has('added_action'))
                <div class="message-container">
                    <div class="callout callout-success">
                        <h4>New admin user has been created successfully.</h4>
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
                                <div class="box-header">
                                    <h3 class="box-title">All Admin Users Logs</h3>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="text-end" style="padding-bottom:2px;">
                                    <a type="button" class="sitebtn" href="javascript:;" onClick="empty_admin_log()">Empty
                                        Log</a></div>
                            </div>
                        </div>
                        <div class="box-body table-responsive">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Admin Name</th>
                                    <th>Session Start Date/Time</th>
                                    <th>Session End Date/Time</th>
                                    {{--<th>Duration</th>--}}
                                    <th>IP Address</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($usersData)
                                    @php $i = 1; @endphp
                                    @foreach($usersData as $row)
                                        <tr id="row_{{ $row->ID}}">
                                            <td>{{ $i++}}</td>
                                            <td>{{ $row->user->name ?? '-'}}</td>
                                            <td>{{ format_date($row->session_start,'date_time')}}</td>
                                            <td>
                                                @if ($row->session_end == NULL)
                                                    {{"Did not logout"}}
                                                @else
                                                    {{ format_date($row->session_end,'date_time') }}
                                                @endif
                                            </td>
                                            <td>{{ $row->ip_address}}
                                                <a target="_blank"
                                                   href="http://whois.domaintools.com/{{ $row->ip_address}}">
                                                    <span title="{{ $row->ip_address}}"
                                                          class="label label-success label-circled">IP</span>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7">No record found!</td>
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
            <div>
                {{ $usersData->links() }}
            </div>
        </section>
    </div>
@endsection
@section('beforeBodyClose')
    <script>
        function empty_admin_log() {
            if (confirm('Are you sure delete this data?')) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ base_url() }}adminmedia/user/admin_log/0",
                    type: "DELETE",
                    success: function (data) {
                        location.reload();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert('Error adding / update data');
                        console.log(jqXHR);
                        console.log(textStatus);
                        console.log(errorThrown);
                    }
                });
            }
        }
    </script>
@endsection
