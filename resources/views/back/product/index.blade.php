@extends('back.layouts.app', ['title' => $title])
@section('beforeHeadClose')
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 90px;
            height: 34px;
        }

        .switch input {
            display: none;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ca2222;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #2ab934;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(55px);
            -ms-transform: translateX(55px);
            transform: translateX(55px);
        }

        /*------ ADDED CSS ---------*/
        .on {
            display: none;
        }

        .on,
        .off {
            color: white;
            position: absolute;
            transform: translate(-50%, -50%);
            top: 50%;
            left: 50%;
            font-size: 10px;
            font-family: Verdana, sans-serif;
        }

        input:checked+.slider .on {
            display: block;
        }

        input:checked+.slider .off {
            display: none;
        }

        /*--------- END --------*/
        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>
@endsection
@section('content')
    <aside class="right-side {{ session('leftSideBar') == 1 ? 'strech' : '' }}">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="row">
                <div class="col-md-8 col-sm-6">
                    <ol class="breadcrumb">
                        <li>
                            <a href="{{ admin_url() }}">
                                <i class="fa-solid fa-gauge"></i> Home
                            </a>
                        </li>
                        <li class="active">Product's Management</li>
                    </ol>
                </div>
                <div class="col-md-4 col-sm-6">
                    @include('back.common_views.quicklinks')
                </div>
            </div>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="message-container" id="add_action" style="display: none">
                <div class="callout callout-success">
                    <h4>New Product has been created successfully.</h4>
                </div>
            </div>
            <div class="message-container" id="update_action" style="display: none;">
                <div class="callout callout-success">
                    <h4>Product has been updated successfully.</h4>
                </div>
            </div>
            <div class="message-container" id="delete_action" style="display: none">
                <div class="callout callout-danger">
                    <h4>Product has been deleted successfully.</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="box">
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="box-header">
                                    <h3 class="box-title">All Products</h3>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="text-end" style="padding-bottom:2px;">
                                    <input type="button" class="sitebtn" value="Add Product" onclick="add_product()" />
                                </div>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table-responsive">
                            <table id="table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Product Name</th>
                                        <th>Price</th>
                                        <th>Sell Product</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="sortable">
                                    @forelse($products as $product)
                                        <tr id="{{ $product->ID }}">
                                            <td>{{ format_date($product->dated, 'date') }}</td>
                                            <td>{{ $product->product_name }}</td>
                                            <td>{{ '$' . currency_format($product->price) }}</td>
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" id="togBtn" <?php echo $product->sell_status == '1' ? ' checked' : ''; ?>
                                                        class="website_product_sell" value="<?php echo $product->sell_status . ',' . $product->ID; ?>">
                                                    <div class="slider round">

                                                        <strong class="on">YES</strong>

                                                        <strong class="off">NO</strong>

                                                        <!--END-->
                                                    </div>
                                                </label>
                                            </td>

                                            <td>
                                                @php
                                                    if ($product->sts == 'active') {
                                                        $class_label = 'success';
                                                    } else {
                                                        $class_label = 'danger';
                                                    }
                                                @endphp
                                                <a onClick="update_product_sts({{ $product->ID }});" href="javascript:;"
                                                    id="sts_{{ $product->ID }}">
                                                    <div class="label label-{{ $class_label }}">{{ $product->sts }}</div>
                                                </a>
                                            </td>

                                            <td>
                                                <a class="btn btn-sm btn-primary" href="javascript:void(0);" title="Edit"
                                                    onclick="edit_product({{ $product->ID }})">
                                                    <i class="glyphicon glyphicon-pencil"></i> Edit</a>
                                                <a class="btn btn-sm btn-danger" href="javascript:void(0);" title="Delete"
                                                    onclick="delete_product({{ $product->ID }})">
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
                    <!-- /.box -->
                    <!-- /.box -->
                </div>
            </div>
        </section>
        <!-- /.content -->
    </aside>
    @include('back.common_views.spinner')
@endsection
@section('beforeBodyClose')
    <script src="{{ base_url() . 'module/products/admin/js/products.js' }}" type="text/javascript"></script>
    <script>
        var uploadUrl = "{{ admin_url() }}module_image/upload_image";
        var deleteUrl = "{{ admin_url() }}module_image/remove_image";
        var folder = "products";
        var maxSize = {{ getMaxUploadSize() }};
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var show_cropper = false;
    </script>
    <script type="text/javascript" src="{{ base_url() . 'back/js/fileUploader.js' }}"></script>
    <script type="text/javascript" src="{{ base_url() . 'module/settings/admin/js/settings.js' }}"></script>
    <script type="text/javascript" src="{{ base_url() }}back/mod/mod_js.js"></script>
    @include('back.product.product_js')
    @include('back.product.add_edit_view')
    <script type="text/javascript">
        $('.website_product_sell').click(function() {
            var product_Sale_Status = $(this).val();
            $.ajax({
                url: '{{ route('product.sell.status') }}',
                method: 'get',
                data: {
                    "_token": "{{ csrf_token() }}",
                    " product_Sale_Status": product_Sale_Status
                },
                success: function(response) {
                    alertme('<i class="fa-solid fa-check" aria-hidden="true"></i> Done Successfully ',
                        'success', true, 1500);
                }
            });
        });
    </script>
@endsection
