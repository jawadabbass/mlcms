@extends('back.layouts.app', ['title' => $title])
@section('beforeHeadClose')
@include('back.common_views.switch_css')
@endsection
@section('content')
    <div class="pl-3 pr-2 content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="row">
                <div class="col-md-5 col-sm-12">
                    <ol class="breadcrumb">
                        <li>
                            <a href="{{ admin_url() }}">
                                <i class="fas fa-gauge"></i> Home
                            </a>
                        </li>
                        <li class="active">Product's Management</li>
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
                    <div class="p-2 card">
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="box-header">
                                    <h3 class=" card-title">All Products</h3>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="text-end" style="padding-bottom:2px;">
                                    <input type="button" class="sitebtn" value="Add Product" onclick="add_product()" />
                                </div>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class=" card-body table-responsive">
                            <table id="table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Product Name</th>
                                        <th>Price</th>
                                        <th>Sell Product</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="sortable">
                                    @forelse($products as $product)
                                        <tr id="{{ $product->id }}">
                                            <td>{{ format_date($product->dated, 'date') }}</td>
                                            <td>{{ $product->product_name }}</td>
                                            <td>{{ '$' . currency_format($product->price) }}</td>
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" id="togBtn" <?php echo $product->sell_status == '1' ? ' checked' : ''; ?>
                                                        class="website_product_sell" value="<?php echo $product->sell_status . ',' . $product->id; ?>">
                                                    <div class="slider round">

                                                        <strong class="on">YES</strong>

                                                        <strong class="off">NO</strong>

                                                        <!--END-->
                                                    </div>
                                                </label>
                                            </td>

                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" name="{{ 'pro_sts_' . $product->id }}"
                                                        id="{{ 'pro_sts_' . $product->id }}" <?php echo $product->sts == 1 ? ' checked' : ''; ?>
                                                        value="<?php echo !empty($product->sts)? $product->sts:'blocked' ; ?>"
                                                        onClick="update_product_sts_toggle({{ $product->id }})">
                                                    <div class="slider round">
                                                        <strong class="on">Active</strong>
                                                        <strong class="off">Inactive</strong>
                                                    </div>
                                                </label>
                                            </td>

                                            <td>
                                                <a class="btn btn-sm btn-primary" href="javascript:void(0);" title="Edit"
                                                    onclick="edit_product({{ $product->id }})">
                                                    <i class="glyphicon glyphicon-pencil"></i> Edit</a>
                                                <a class="btn btn-sm btn-danger" href="javascript:void(0);" title="Delete"
                                                    onclick="delete_product({{ $product->id }})">
                                                    <i class="glyphicon glyphicon-trash"></i> Delete</a>
                                                
                                            </td>
                                            <td align="center">
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
                        <!-- /. card-body -->
                    </div>
                    <!-- /.box -->
                    <!-- /.box -->
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    
@endsection
@section('beforeBodyClose')
    <script src="{{ asset_storage('') . 'module/products/admin/js/products.js' }}" type="text/javascript"></script>
    <script>
        var uploadUrl = "{{ admin_url() }}module_image/upload_image";
        var deleteUrl = "{{ admin_url() }}module_image/remove_image";
        var folder = "products";
        var maxSize = {{ getMaxUploadSize() }};
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var show_cropper = false;
    </script>
    <script type="text/javascript" src="{{ asset_storage('') . 'back/js/fileUploader.js' }}"></script>
    <script type="text/javascript" src="{{ asset_storage('') . 'module/settings/admin/js/settings.js' }}"></script>
    <script type="text/javascript" src="{{ asset_storage('') }}back/mod/mod_js.js"></script>
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
                    alertme('<i class="fas fa-check" aria-hidden="true"></i> Done Successfully ',
                        'success', true, 1500);
                }
            });
        });
    </script>
@endsection
