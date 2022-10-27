@extends('back.layouts.app', ['title' => $title, 'heading' => $heading])
@section('bc')
    <?php echo ModBC('Detail', [$settingArr['contr_name'] => $settingArr['mainPageTitle']]); ?>
@endsection
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="box">
                    <div class="box-body table-responsive">
                        <div class="text-end">
                        </div>
                        <div class="col-sm-12">
                            <form action="{{ admin_url() }}mod/step/1" enctype="multipart/form-data" id="validatethis1"
                                method="post" name="myForm" onsubmit="return formSubmit();">
                                @csrf
                                <div class="row" id="row_table_name">
                                    <div class="col-sm-4 text-end">
                                        <span id="title_table_name">
                                            Table name
                                        </span>
                                        :
                                    </div>
                                    <div class="col-sm-8">
                                        <input class="form-control" id="table_name" name="table_name" placeholder=""
                                            type="text" value="">
                                        <p class="text-danger">
                                        </p>
                                        </input>
                                    </div>
                                </div>
                                <div class="row" id="row_mod_name">
                                    <div class="col-sm-4 text-end">
                                        <span id="title_mod_name">
                                            Module name
                                        </span>
                                        :
                                    </div>
                                    <div class="col-sm-8">
                                        <input class="form-control" id="mod_name" name="mod_name" placeholder=""
                                            type="text" value="">
                                        <p class="text-danger">
                                        </p>
                                        </input>
                                    </div>
                                </div>
                                <div class="row" id="row_mod_url">
                                    <div class="col-sm-4 text-end">
                                        <span id="title_mod_url">
                                            Module url
                                        </span>
                                        :
                                    </div>
                                    <div class="col-sm-8">
                                        <input class="form-control" id="mod_url" name="mod_url" placeholder=""
                                            type="text" value="">
                                        <p class="text-danger">
                                        </p>
                                        </input>
                                    </div>
                                </div>
                                <div class="row" id="row_page_size">
                                    <div class="col-sm-4 text-end">
                                        <span id="title_page_size">
                                            Page size
                                        </span>
                                        :
                                    </div>
                                    <div class="col-sm-8">
                                        <input class="form-control" id="page_size" name="page_size" placeholder=""
                                            type="text" value="">
                                        <p class="text-danger">
                                        </p>
                                        </input>
                                    </div>
                                </div>
                                <div class="row" id="row_img_url">
                                    <div class="col-sm-4 text-end">
                                        <span id="title_img_url">
                                            Img url
                                        </span>
                                        :
                                    </div>
                                    <div class="col-sm-8">
                                        <input class="form-control" id="img_url" name="img_url" placeholder=""
                                            type="text" value="">
                                        <p class="text-danger">
                                        </p>
                                        </input>
                                    </div>
                                </div>
                                <div class="row" id="row_templ_type">
                                    <div class="col-sm-4 text-end">
                                        <span id="title_templ_type">
                                            Template type
                                        </span>
                                        :
                                    </div>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="templ_type" name="templ_type">
                                            <option selected="" value="">
                                                -Select-
                                            </option>
                                            @foreach ($ModTemplate as $key => $val)
                                                <option value="{{ $val->ID }}">{{ $val->title }}</option>
                                            @endforeach
                                        </select>
                                        <p class="text-danger">
                                        </p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                    </div>
                                    <div class="col-sm-6">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                    </div>
                                    <div class="col-sm-3 text-start">
                                    </div>
                                    <div class="col-sm-5 text-start">
                                        <input name="idd" type="hidden" value="0">
                                        <button class="btn btn-success" type="submit">
                                            Next
                                            <i aria-hidden="true" class="fa-solid fa-angle-double-right">
                                            </i>
                                        </button>
                                        </input>
                                    </div>
                                </div>
                            </form>
                            <!-- /.box -->
                            <!-- /.box -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('beforeBodyClose')
    <script type="text/javascript">
        $("#table_name").on("blur", function() {
            var modnamee = $(this).val();
            $("#mod_name").val(modnamee.toLowerCase());
            $("#mod_url").val(modnamee.toLowerCase());
            $("#templ_type").val(7);
            $("#page_size").val('20');
        });
        $("#is_virtual").on("click", function() {
            if (this.checked) {
                $("#row_address_virtual").show();
            } else {
                $("#row_address_virtual").hide();
            }
        });
        $(document).ready(function(e) {
            if ($("#is_virtual").prop("checked")) {
                $("#row_address_virtual").show();
            } else {
                $("#row_address_virtual").hide();
            }
        });
    </script>
@endsection
