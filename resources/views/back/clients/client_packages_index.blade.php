@extends('back.layouts.app', ['title' => $title])
@section('content')
    <aside class="right-side {{ session('leftSideBar') == 1 ? 'strech' : '' }}">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="row">
                <div class="col-md-8 col-sm-6">
                    <ol class="breadcrumb">
                        <li><a href="{{ admin_url() }}"> <i class="fa-solid fa-dashboard"></i> Home </a></li>
                        <li><a href="{{ admin_url() }}manage_clients">Clients</a></li>
                        <li class="active">Manage Client Packages</li>
                    </ol>
                </div>
                <div class="col-md-4 col-sm-6"> @include('back.common_views.quicklinks') </div>
            </div>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="box">
                        <div class="box-body table-responsive">
                            @if (session('success'))
                                <div style="padding-top:5px;" class="alert alert-success">{{ session('success') }}
                                </div>
                            @endif
                            @if (session('error'))
                                <div style="padding-top:5px;" class="alert alert-danger">{{ session('error') }}
                                </div>
                            @endif
                            @if (Session::has('msg'))
                                <p class="alert alert-success">{{ Session::get('msg') }}</p>
                            @endif
                            <div class="text-end"><a href="{{ route('manage_client_add_new_packages', $client->id) }}"
                                    class="btn btn-info">
                                    <i class="fa-solid fa-plus-circle" aria-hidden="true"></i> Add New
                                    Package</a></div>
                            <br>

                            <table class="table table-bordered table-inverse table-hover">
                                <thead>
                                    <tr>
                                        <th>
                                        </th>
                                        <th>ID</th>
                                        <th>Package Name</th>
                                        <th>Package Price</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $Bstatus = '';
                                        $BGcolor = '';

                                        $stsArr = ['active', 'blocked'];
                                    @endphp
                                    @if (count($result) > 0)
                                        @foreach ($result as $row)
                                            @php
                                                $bgColor = isset($bgColor) && $bgColor == '#f9f9f9' ? '#FFFFFF' : '#f9f9f9';
                                            @endphp
                                            <tr id="trr{{ $row->id }}">
                                                <td><a style="font-size: 24px;" data-toggle="tooltip" title=""
                                                        href="javascript:;"
                                                        onclick="showme_page('#subtrr{{ $row->id }}',this)"
                                                        data-original-title="Show more"><i class="fa-solid fa-angle-double-down"
                                                            aria-hidden="true"></i></a></td>
                                                <td>{{ $row->id }}</td>
                                                <td>{{ $row->clientPackage->heading }}</td>
                                                <td>${{ $row->clientPackage->additional_field_1 }}</td>


                                                <td><code>{{ format_date($row->created_at, 'date_time') }}</code></td>
                                                <td>
                                                    <select class="form-control"
                                                        onchange="update_status('{{ $row->id }}',this.value)">
                                                        <option value="">-Select-</option>
                                                        @foreach ($stsArr as $kk)
                                                            <option value="{{ $kk }}"
                                                                @if ($row->sts == $kk) selected="" @endif>
                                                                {{ $kk }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr style="display: none;" id="subtrr{{ $row->id }}">

                                                <td colspan="5">
                                                    <div class="row">
                                                        <div class="col-lg-2"><a class="btn btn-sm btn-info"
                                                                href="javascript:" data-toggle="modal"
                                                                data-target="#largeShoes-<?php echo $row->id; ?>"><i
                                                                    class="fa-solid fa-eye"></i>View Pre Qualified
                                                                Questions filled of this Package</a>
                                                        </div>
                                                    </div>
                                                </td>


                                                <td>
                                                    <div class="modal" id="largeShoes-<?php echo $row->id; ?>" tabindex="-1"
                                                        role="dialog" aria-labelledby="modalLabelLarge" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title" id="modalLabelLarge">Questions
                                                                        Of Package
                                                                        {{ $row->clientPackage->heading }}</h4>
                                                                    <button type="button" class="close"
                                                                        data-bs-dismiss="modal" aria-label="Close">
                                                                        
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-striped">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th scope="col">Question(s)</th>
                                                                                    <th scope="col">Answer(s)</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>

                                                                                @if (!$row->clientPackageQuestions == null)
                                                                                    @foreach ($row->clientPackageQuestions as $p_question)
                                                                                        <tr>
                                                                                            <td>{{ $p_question->question->question }}
                                                                                            </td>
                                                                                            <td>

                                                                                                @if (is_array(json_decode($p_question->answer)) || is_object(json_decode($p_question->answer)))
                                                                                                    @foreach (json_decode($p_question->answer) as $key => $ans)
                                                                                                        {{ $key }}<br>
                                                                                                    @endforeach
                                                                                                @else
                                                                                                    {{ $p_question->answer }}
                                                                                                @endif

                                                                                            </td>

                                                                                        </tr>
                                                                                    @endforeach
                                                                                @endif
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                        </div>
                    </div>

                    </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td> No Record found!</td>
                    </tr>
                    @endif
                    </tbody>
                    </table>
                </div>
            </div>
            </div>
            </div>
            <div> {{ $result->links() }} </div>
        </section>
    </aside>
@endsection
@section('beforeBodyClose')
    <script type="text/javascript" src="{{ base_url() }}back/mod/mod_js.js"></script>
    <script>
        $(document).ready(function() {
            $('[data-bs-toggle="popover"]').popover();
        });
        $('html').on('mouseup', function(e) {
            if (!$(e.target).closest('.popover').length) {
                $('.popover').each(function() {
                    $(this.previousSibling).popover('hide');
                });
            }
        });

        function update_status(cid, sts) {

            $.ajax({
                type: "GET",
                url: "{{ route('manage_client_change_package_status') }}",
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),

                    'id': cid,
                    'status': sts
                },
                success: function(data) {
                    alertme('<i class="fa-solid fa-check" aria-hidden="true"></i> Status Updated ', 'success', true,
                        1500);
                },
            });

        }
    </script>
@endsection
