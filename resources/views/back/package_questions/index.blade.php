@extends('back.layouts.app', ['title' => $title])
@section('content')
    <aside class="right-side {{ session('leftSideBar') == 1 ? 'strech' : '' }}">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="row">
                <div class="col-md-8 col-sm-6">
                    <ol class="breadcrumb">
                        <li>
                            <a href="{{ base_url() . 'adminmedia' }}">
                                <i class="fa-solid fa-dashboard"></i> Home
                            </a>
                        </li>
                        <li class="active">Packages Question's Management</li>
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
                                    <h3 class="box-title">Search Question by Package

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

                                    <button type="submit" class="btn">
                                        <li class="fa-solid fa-search"></li>
                                    </button>
                                </div>
                            </div>
                        </form>
                        <div class="box-body table-responsive">
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
                                                @php
                                                    if ($product->sts == 'active') {
                                                        $class_label = 'success';
                                                    } else {
                                                        $class_label = 'danger';
                                                    }
                                                @endphp
                                                <a onClick="update_product_sts({{ $product->id }});" href="javascript:;"
                                                    id="sts_{{ $product->id }}">
                                                    <div class="label label-{{ $class_label }}">{{ $product->sts }}
                                                    </div>
                                                </a>
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

                        <!-- /.box-body -->
                    </div>
                    {!! $products->links() !!}
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
    
    <!-- Filer -->
    
    
    <script>
        var uploadUrl = "{{ admin_url() }}module_image/upload_image";
        var deleteUrl = "{{ admin_url() }}module_image/remove_image";
        var folder = "products";
        var maxSize = {{ getMaxUploadSize() }};
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var show_cropper = false;
    </script>
    <script type="text/javascript" src="{{ base_url() . 'back/js/fileUploader.js' }}"></script>
    @include('back.package_questions.question_js')
@endsection
