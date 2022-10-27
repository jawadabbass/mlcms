@extends('back.layouts.app', ['title' => $title])
@section('content')
    <aside class="right-side {{ session('leftSideBar') == 1 ? 'strech' : '' }}">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="row">
                <div class="col-md-8 col-sm-6">
                    <ol class="breadcrumb">
                        <li><a href="{{ admin_url() }}"> <i class="fa-solid fa-gauge"></i> Home </a></li>
                        <li><a href="{{ admin_url() }}invoice">Payment Options</a></li>
                        <li class="active">Add Payment Option</li>
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
                        <div class="box-body">
                            <h2> <i class="fa-solid fa-plus-circle" aria-hidden="true"></i> Add Payment Option</h2>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form method="post" name="frm" id="frm" action="{{ route('invoice.store') }}"
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
    </aside>
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
                    url: "{{ admin_url() }}invoice/" + id,
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
