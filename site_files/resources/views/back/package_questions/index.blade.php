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
                        <li class="active">Packages Question's Management</li>
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
                    <div class="card p-2">
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="box-header">
                                    <h3 class=" card-title">Search Question by Package

                                    </h3>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="text-end" style="padding-bottom:2px;">
                                    <a href="{{ route('question.addView') }}" class="btn btn-primary">Add New Question In Package</a>
                                </div>
                            </div>
                        </div>

                        <form method="get" action="{{ route('question.index') }}">
                            <div class="row">

                                <div class="col-sm-10 form-group">
                                    <select name="package_id" class="form-control">
                                        <option>All</option>
                                        @foreach ($get_all_packages as $p_question)
                                            <option value="{{ $p_question->id }}" <?php if (isset($_GET['package_id']) && $_GET['package_id'] == $p_question->id) {
                                                echo 'selected';
                                            } ?>>{{ $p_question->heading }}
                                            </option>
                                        @endforeach

                                    </select>
                                </div>

                                <div class="col-sm-1 form-group">

                                    <button type="submit"  class="btn">
                                        <li class="fas fa-search"></li>
                                    </button>
                                </div>
                            </div>
                        </form>
                        <div class=" card-body table-responsive">
                            <table id="table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>

                                        <th>Question</th>
                                        <th>Package</th>
                                        <th>Status</th>
                                        <th width="18%">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="sortable">
                                    @forelse($products as $product)
                                        <tr id="{{ $product->id }}">
                                            <td>{{ $product->question }}</td>
                                            <td>{{ $product->package->heading }}</td>
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" name="{{ 'sts_' . $product->id }}"
                                                        id="{{ 'sts_' . $product->id }}" <?php echo $product->sts == 1 ? ' checked' : ''; ?>
                                                        value="<?php echo !empty($product->sts)? $product->sts:'blocked' ; ?>"
                                                        onClick="update_package_question_sts_toggle({{ $product->id }})">
                                                    <div class="slider round">
                                                        <strong class="on">Active</strong>
                                                        <strong class="off">Inactive</strong>
                                                    </div>
                                                </label>
                                            </td>
                                            <td>
                                                <a class="btn btn-sm btn-primary"
                                                    href="{{ route('question.edit', $product->id) }}" title="Edit">
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

                        <!-- /. card-body -->
                    </div>
                    {!! $products->links() !!}
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
    
    <!-- Filer -->
    
    
    <script>
        var uploadUrl = "{{ admin_url() }}module_image/upload_image";
        var deleteUrl = "{{ admin_url() }}module_image/remove_image";
        var folder = "products";
        var maxSize = {{ getMaxUploadSize() }};
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var show_cropper = false;
    </script>
    <script type="text/javascript" src="{{ asset_storage('') . 'back/js/fileUploader.js' }}"></script>
    @include('back.package_questions.question_js')
@endsection
