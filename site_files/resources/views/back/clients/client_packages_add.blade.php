@extends('back.layouts.app', ['title' => $title])
@section('content')
    <div class="content-wrapper pl-3 pr-2">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="row">
                <div class="col-md-5 col-sm-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ admin_url() }}"> <i class="fas fa-tachometer-alt"></i> Home </a></li>
                        <li><a href="{{ admin_url() }}manage_clients">Clients</a></li>
                        <li class="active">Add New Client Package</li>
                    </ol>
                </div>
                <div class="col-md-7 col-sm-12"> @include('back.common_views.quicklinks') </div>
            </div>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="box">
                        <div class="box-body">

                            <h2> <i class="fas fa-plus-circle" aria-hidden="true"></i> Add New Client Package</h2>
                            <br>

                            <form role="form" method="POST" id="register_action"
                                action="{{ route('client-package-store') }}">
                                {{ csrf_field() }}
                                <div class="row">

                                    <input type="hidden" name="client_id" value="{{$client->id}}"/>
                                    <div class="col-lg-12">

                                        <div class="form-group">
                                            <label>Select Package For Pre-Qualified Questions</label>
                                            <select name="package_id" id="package-list" class="form-control state_select2"
                                                onChange="getQuestions(this.value);">

                                                @foreach ($get_all_packages as $package)
                                                    <option value="{{ $package->id }}">{{ $package->heading }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <span class="text-danger">{{ $errors->first('package_id') }}</span>
                                    </div>

                                    <div class="col-lg-12" id="questions-list"></div>
                                    <div class="col-lg-12">
                                        <div class="form-group">

                                            <button type="submit"  id="btnSave" class="btn btn-primary">Submit
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('beforeBodyClose')
    <script type="text/javascript">
        $(document).ready(function() {
          var val=$("#package-list").val();
          $.ajax({
                type: "GET",
                url: "{{ route('get_client_prequalified_questions', '') }}" + "/" + val,
                success: function(data) {
                    $("#questions-list").html(data);

                }
            });
        });

        function getQuestions(val) {
            $.ajax({
                type: "GET",
                url: "{{ route('get_client_prequalified_questions', '') }}" + "/" + val,
                success: function(data) {
                    $("#questions-list").html(data);

                }
            });
        }
    </script>
@endsection
