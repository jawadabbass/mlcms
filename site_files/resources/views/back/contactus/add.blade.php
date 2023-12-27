@extends('back.layouts.app', ['title' => $title])
@section('content')
    <div class="content-wrapper pl-3 pr-2">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="row">
                <div class="col-md-5 col-sm-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ admin_url() }}"> <i class="fas fa-tachometer-alt"></i> Home </a></li>
                        <li><a href="{{ admin_url() }}contact_request">Contact Leads</a></li>
                        <li class="active">Add Lead</li>
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
                            <h2> <i class="fas fa-plus-circle" aria-hidden="true"></i> Add Contact Lead</h2>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form method="post" name="frm" id="frm" action="{{ route('contact_request.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <br>
                                <div class="row" style="margin-bottom: 10px;">
                                    <div class="col-lg-3 text-end">Name</div>
                                    <div class="col-lg-6"><input type="text" name="name" id="name"
                                            class="form-control" value="{{ old('name') }}" placeholder=""></div>
                                    <div class="col-lg-3 text-start"></div>
                                </div>
                                <div class="row" style="margin-bottom: 10px;">
                                    <div class="col-lg-3 text-end">Email</div>
                                    <div class="col-lg-6"><input type="text" name="email" id="email"
                                            class="form-control" value="{{ old('email') }}" placeholder=""></div>
                                    <div class="col-lg-3 text-start"></div>
                                </div>
                                <div class="row" style="margin-bottom: 10px;">
                                    <div class="col-lg-3 text-end">Phone</div>
                                    <div class="col-lg-6"><input type="text" name="phone" id="phone"
                                            class="form-control" value="{{ old('phone') }}" placeholder=""></div>
                                    <div class="col-lg-3 text-start"></div>
                                </div>
                                <div class="row" style="margin-bottom: 10px;">
                                    <div class="col-lg-3 text-end">Service</div>
                                    <div class="col-lg-6">
                                        <select id="service" name="service" class="form-select">
                                            <option selected disabled>Choose Service</option>
                                            @if (count($services_for_dd) > 0)
                                                @foreach ($services_for_dd as $services)
                                                <option value="{{ $services->heading }}" {{ ($services->heading == old('service'))? 'selected':'' }}>{{ $services->heading }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-lg-3 text-start"></div>
                                </div>
                                <div class="row" style="margin-bottom: 10px;">
                                    <div class="col-lg-3 text-end">Comments</div>
                                    <div class="col-lg-6">
                                        <textarea name="comments" id="comments" class="form-control">{{ old('comments') }}</textarea>
                                    </div>
                                    <div class="col-lg-3 text-start"></div>
                                </div>
                                <div class="row" style="margin-bottom: 10px;">
                                    <div class="col-lg-3 text-end">Date</div>
                                    <div class="col-lg-6">
                                        <input type="date" name="dated" id="dated" class="form-control"
                                            value="{{ old('dated') ?? date('Y-m-d') }}" placeholder="">
                                    </div>
                                    <div class="col-lg-3 text-start"></div>
                                </div>
                                <div class="row" style="margin-bottom: 10px;">
                                    <div class="col-lg-3 text-end"></div>
                                    <div class="col-lg-6 text-end">
                                        <button type="submit" class="btn btn-success">Add</button>
                                    </div>
                                    <div class="col-lg-3 text-start"></div>
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
        function del_recrod(id) {
            if (confirmDel()) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "DELETE",
                    url: "{{ admin_url() }}contact_request/" + id,
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        if (JSON.parse(data).status) {
                            $("#trr" + id).fadeOut(1000);
                            $("#subtrr" + id).hide(1000);
                            var tolrec = $("#total_rec").html();
                            var tolrec = $("#total_rec").html(parseInt(tolrec) - 1);
                            // location.reload();
                        } else {
                            alert('ERROR: Deleting');
                            console.log(data);
                        }
                    },
                });
            }
        }
    </script>
@endsection