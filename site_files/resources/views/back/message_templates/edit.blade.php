@extends('back.layouts.app', ['title' => $title])

@section('content')
    <div class="content-wrapper pl-3 pr-2">

        <section class="content-header">
            <div class="row">
                <div class="col-md-5 col-sm-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ admin_url() }}"> <i class="fas fa-tachometer-alt"></i> Home </a></li>

                        <li><a href="{{ route('message.index') }}"> <i class="fas fa-tachometer-alt"></i>Manage Message Templates
                            </a></li>

                        <li class="active">Edit Message Templates</li>
                    </ol>
                </div>
                <div class="col-md-7 col-sm-12"> @include('back.common_views.quicklinks') </div>
            </div>
        </section>
        <section class="content">
            @if (\Session::has('success'))
                <div class="alert alert-success alert-dismissible mb-2" role="alert">
                    <button type="button" class="btn close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <strong>Success!</strong> {{ session('success') }}

                </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-8">
                        <div class="card-body">
                            <div class="card-title mb-3">Edit Message</div>
                            <form method="post" action="{{ route('custom_msg_update', $data->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="email_content" <?php if ($data->status == 'No') {
                                            echo "style='display:none;'";
                                        } ?>>
                                            <div class="col-md-12 form-group mb-3">
                                                <label for="firstName1">
                                                    <strong>Title (Only used for your internal reminder and reference. Not
                                                        part of Message Content)</strong>
                                                </label>
                                                <input type="text" value="{{ $data->title }}" name="title"
                                                    class="form-control" id="firstName1"
                                                    placeholder="Enter your first name">
                                            </div>
                                            <div class="col-md-12 form-group mb-3">
                                                <label class="email_cb_label" for="picker2">Message Body</label>
                                                <textarea name="editor1" id="email_body" class="form-control">{{ $data->body }}</textarea>
                                            </div>



                                        </div>

                                        <div class="col-md-12">
                                            <button class="btn btn-primary">Submit</button>
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
@section('page_scripts')
    <script src="//cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
    <script>
        $(document).ready(function() {
            $(document).on('change', '#email_checkbox', function(e) {
                var $box = $(this);
                if ($box.is(":checked")) {
                    $('.email_content').show();
                    $('#email_checkbox').val(1);
                } else {
                    $('.email_content').hide();
                    $('#email_checkbox').val(0);
                }
            });
        });

        $('.emailvariables').click(function() {
            var myValue = $(this).text();
            myValue = myValue.trim();
            ckeditors.email_body.insertText(myValue);
        });
    </script>
@endsection
