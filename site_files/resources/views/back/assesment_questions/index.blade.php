@extends('back.layouts.app', ['title' => $title])
@section('beforeHeadClose')
    @include('back.common_views.switch_css')
@endsection
@section('content')
    <div class="content-wrapper pl-3 pr-2">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="row">
                <div class="col-md-5 col-sm-12">
                    <ol class="breadcrumb">
                        <li>
                            <a href="{{ base_url() . 'adminmedia' }}">
                                <i class="fas fa-tachometer-alt"></i> Home
                            </a>
                        </li>
                        <li class="active">Assessment Question's Management</li>
                    </ol>
                </div>
                <div class="col-md-7 col-sm-12">
                    @include('back.common_views.quicklinks')
                </div>
            </div>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="box">
                        <div class="row">
                            <div class="col-sm-4">
                            </div>
                            <div class="col-sm-5">
                                <div class="text-end" style="padding-bottom:2px;">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#exampleNumber">
                                        Recipient's Emails
                                    </button>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="text-end" style="padding-bottom:2px;">
                                    <a href="{{ route('assesment_question.addView') }}" class="btn btn-primary">Add New
                                        Assessment
                                        Question</a>
                                </div>
                            </div>
                        </div>
                        <div class="box-body table-responsive">
                            <table id="table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Question</th>
                                        <th>Status</th>
                                        <th width="18%">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="sortable">
                                    @forelse($products as $product)
                                        <tr id="{{ $product->id }}">
                                            <td>{{ $product->question }}</td>
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" name="{{ 'sts_' . $product->id }}"
                                                        id="{{ 'sts_' . $product->id }}" <?php echo $product->sts == 'active' ? ' checked' : ''; ?>
                                                        value="<?php echo !empty($product->sts) ? $product->sts : 'blocked'; ?>"
                                                        onClick="update_assesment_question_sts_toggle({{ $product->id }})">
                                                    <div class="slider round">
                                                        <strong class="on">Active</strong>
                                                        <strong class="off">Inactive</strong>
                                                    </div>
                                                </label>
                                            </td>
                                            <td>
                                                <a class="btn btn-sm btn-primary"
                                                    href="{{ route('assesment_question.edit', $product->id) }}"
                                                    title="Edit">
                                                    <i class="glyphicon glyphicon-pencil"></i> Edit</a>
                                                <a class="btn btn-sm btn-danger" href="javascript:void(0);" title="Delete"
                                                    onclick="delete_product({{ $product->id }})">
                                                    <i class="glyphicon glyphicon-trash"></i> Delete</a>
                                                <span></span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" align="center" class="text-red">No Record found!</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot></tfoot>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    {!! $products->links() !!}
                    <!-- /.box -->
                    <!-- /.box -->
                </div>
            </div>
        </section>
        <!-- /.content -->
        <div class="modal fade" id="exampleNumber" tabindex="-1" role="dialog" aria-labelledby="exampleNumberLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleNumberLabel">Recepients Email</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <form name="numberForm" id="numberForm" class="numberForm">
                        @csrf
                        <div class="modal-body">
                            <div class="Recepients_item">
                                @if (is_array(json_decode($number->data_key)) || is_object(json_decode($number->data_key)))
                                    @foreach (json_decode($number->data_key) as $key => $names)
                                        <div class="form-group row new_Recepients">
                                            <div class="col-md-10">
                                                <label for=""><strong>Enter The Email:</strong></label>
                                                <div class="input-group">
                                                    <input type="email" placeholder="Enter Email" name="email[]"
                                                        class="form-control" value="{{ $names }}">
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <label for=""><strong></strong></label>
                                                <br>
                                                <br>
                                                <button class="btn btn-danger remove_item_Recepients"
                                                    style="margin-top:-10px"><i class="fas fa-remove"></i></button>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-md-11">
                                </div>
                                <div class="col-md-1">
                                    <a href="javascript:void(0)" class="btn-sm btn-success add_Recepients_button"><i
                                            class="fas fa-plus"></i></a>
                                </div>
                            </div>
                            <br>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick="update_phone_number()">
                                Recepients Email Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
@endsection
@section('beforeBodyClose')
    <script src="{{ asset_storage('') . 'module/products/admin/js/products.js' }}" type="text/javascript"></script>
    <!-- Filer -->
    <script>
        var uploadUrl = "{{ admin_url() }}module_image/upload_image";
        var deleteUrl = "{{ admin_url() }}module_image/remove_image";
        var folder = "products";
        var maxSize = {{ getMaxUploadSize() }};
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var show_cropper = false;
    </script>
    <script src="{{ asset_storage('lib/sweetalert/sweetalert2.js') }}"></script>
    <script type="text/javascript" src="{{ asset_storage('') . 'back/js/fileUploader.js' }}"></script>
    @include('back.assesment_questions.question_js')
    <script type="text/javascript">
        //custom work append functionality
        $(document).on('click', '.add_Recepients_button', function(e) {
            e.preventDefault();
            var html =
                `<div class="form-group row new_Recepients">
         <div class="col-md-10">
             <label for=""><strong>Enter The Email:</strong></label>
             <div class="input-group">
                 <input type="email"
                     name="email[]"  class="form-control" placeholder="Enter The Email">
             </div>
         </div>
         <div class="col-md-1">
         <label for=""><strong></strong></label>
         <br>
         <br>
         <button class="btn btn-danger remove_item_Recepients" style="margin-top:-10px"><i class="fas fa-remove"></i></button>
         </div>
         </div>`;
            $('.Recepients_item').append(html);
        });
        $(document).on('click', '.remove_item_Recepients', function(e) {
            e.preventDefault();
            $(this).closest('.new_Recepients').hide();
            $(this).closest('.new_Recepients').html('');
        });
        function update_phone_number() {
            $('#btnSave').css('display', 'none');
            $('#loader').css('display', 'block');
            url = "{{ route('assesment_update_receipts_email') }}";
            method = 'POST';
            header = '';
            let formData = new FormData($('#numberForm')[0]);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                type: method,
                data: formData,
                headers: header,
                async: true,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    console.log(data);
                    //data = JSON.parse(data);
                    $('#btnSave').css('display', 'block');
                    $('#loader').css('display', 'none');
                    if (data.status) {
                        $("#numberForm").trigger('reset');
                        $('#exampleNumber').modal('hide');
                        swal(
                            'Thank you!',
                            'Assessment Questions Answered Recepients Has Been Updated Successfully',
                            'success'
                        );
                        location.reload();
                    } else {
                        swal(
                            'Sorry!',
                            data.error,
                            'error'
                        );
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error sending your request');
                    console.log(jqXHR);
                    console.log(textStatus);
                    console.log(errorThrown);
                }
            });
        }
    </script>
@endsection
