@extends('back.layouts.app', ['title' => $title])
@section('content')
    <div class="content-wrapper pl-3 pr-2">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="row">
                <div class="col-md-5 col-sm-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ admin_url() }}"> <i class="fas fa-gauge"></i> Home </a></li>
                        <li><a href="{{ admin_url() }}payment_options">Payment Options</a></li>
                        <li class="active">Update Payment Option</li>
                    </ol>
                </div>
                <div class="col-md-7 col-sm-12"> @include('back.common_views.quicklinks') </div>
            </div>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="card p-2">
                        <div class=" card-body">
                            <h2> <i class="fas fa-plus-circle" aria-hidden="true"></i> Update Payment Option</h2>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form method="post" name="frm" id="frm"
                                action="{{ admin_url() }}payment_options/{{ $clientObj->id }}"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="_method" value="PUT" />
                                <br>
                                <div class="row" style="margin-bottom: 10px;">
                                    <div class="col-lg-3 text-end">Title</div>
                                    <div class="col-lg-6"><input type="text" name="title" id="title"
                                            class="form-control" value="{{ old('title') ?? $clientObj->title }}"
                                            placeholder=""></div>
                                    <div class="col-lg-3 text-start"></div>
                                </div>
                                <div class="row" style="margin-bottom: 10px;">
                                    <div class="col-lg-3 text-end">Description</div>
                                    <div class="col-lg-9">
                                        <textarea name="details" id="details" class="form-control">{{ old('details') ?? $clientObj->details }}</textarea>
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom: 10px;">
                                    <div class="col-lg-3 text-end"></div>
                                    <div class="col-lg-6 text-end">
                                        <button type="submit"  class="btn btn-success">Update</button>
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
                    url: "{{ admin_url() }}payment_options/" + id,
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
