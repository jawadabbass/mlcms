@extends('back.layouts.app', ['title' => $title])

@section('loader_div')
    <div class="loadscreen" id="preloader">
        <div class="loader spinner-bubble spinner-bubble-primary">
        </div>
    </div>
@endsection
@section('content')
    <div class="content-wrapper pl-3 pr-2">
        <section class="content-header">
            <div class="row">
                <div class="col-md-5 col-sm-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ admin_url() }}"> <i class="fas fa-tachometer-alt"></i> Home </a></li>
                        <li class="active">Manage Email Templates</li>
                    </ol>
                </div>
                <div class="col-md-7 col-sm-12"> @include('back.common_views.quicklinks') </div>
            </div>
        </section>
        <section class="content">
            @if (\Session::has('added_action'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="btn close" data-bs-dismiss="alert">x</button>
                    <h4>Email Template has been created successfully.</h4>
                </div>
            @endif
            @if (\Session::has('update_action'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="btn close" data-bs-dismiss="alert">x</button>
                    <h4>Email Template has been Updated successfully.</h4>
                </div>
            @endif
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="box">
                        <div class="row">
                            <div class="col-sm-6 text-start">
                                <h3 class="box-title">{{ $settingArr['mainPageTitle'] }}</h3>
                            </div>
                            <div class="col-sm-6 text-end">

                                <?php if($settingArr['order_func']==true){?>
                                <a class="btn btn-md btn-info" title="Edit" href="<?php echo admin_url() . $settingArr['contr_name'] . '/set_order'; ?>"><i
                                        class="fas fa-sort" aria-hidden="true"></i> Order</a>
                                <?php }?>

                                <a class="btn btn-md btn-info" title="Edit" href="{{ route('email_templates.create') }}"
                                    style="margin-bottom: 10px;"><span class="glyphicon glyphicon-plus"></span> Add</a>

                            </div>
                        </div>

                        <?php
               if($settingArr['search_func']==true && !empty($arrSearch)){?>
                        <form action="<?php echo base_url($settingArr['contr_name'] . '/search/'); ?>" method="post" id="search_frm">
                            <div class="row">
                                <?php
                     foreach($arrSearch as $key=>$val){?>
                                <div class="col-sm-2">
                                    <?php
                                    echo ModFBuild($val, $key, viewtxt($key, $settingArr['contr_name']), 'search');

                                    ?>
                                </div>
                                <?php }?>
                                <div class="col-sm-2">
                                    <a href="<?php echo base_url(); ?><?php echo $settingArr['contr_name']; ?>/unset_search"><i class="fas fa-sync"
                                            aria-hidden="true"></i> Reset search</a> <input type="submit"
                                        class="btn btn-success" value="Search">
                                </div>
                            </div>
                            <div class="row">
                                <div class="row">
                                    <div class="col-sm-2"></div>
                                    <div class="col-sm-2"></div>
                                    <div class="col-sm-2"></div>
                                    <div class="col-sm-2"></div>
                                    <div class="col-sm-2"></div>
                                    <div class="col-sm-2"> </div>
                                </div>
                        </form>
                        <?php }?>

                        <div class="box-body table-responsive">
                            <table id="" class="table table-bordered table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <?php
               foreach($dataArr as $key=>$val){?>
                                        <th><?php echo $val[0]; ?></th>
                                        <?php }?>
                                        <th>Icon</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($result)
                                        @foreach ($result as $row)
                                            <tr id="row_{{ $row->$idf }}">
                                                @foreach ($dataArr as $key => $val)
                                                    <td>
                                                        <?php if(stristr($val[1],'slide_flag__')){
               if($key=='Status' || ($row->user_email_active=='Yes' && $key=='user_status')){
                   $tstArr=explode('__',$val[1]);
                   ?>
                                                        <input type="checkbox"
                                                            <?php if($row->$key=='Yes'){?>checked<?php }?>
                                                            data-toggle="toggle" data-onstyle="success"
                                                            data-offstyle="danger" data-on="<?php echo $tstArr[1]; ?>"
                                                            data-off="<?php echo $tstArr[2]; ?>" name="<?php echo $key; ?>"
                                                            data-size="mini" id="<?php echo $key; ?>"
                                                            onChange="update_status(this.checked,'<?php echo $row->$idf; ?>','<?php echo $key; ?>')">
                                                        <?php }}

               else{?>
                                                        {!! ModTBuild($row->$key, $val[1], $settingArr['baseImg']) !!}
                                                        @if ($key == 'Template Of Status')
                                                            @foreach ($status as $sts)
                                                                @if ($sts->id == $row->template_off)
                                                                    <em style="color: #aea4a4;">{{ $sts->heading }}</em>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                        <?php }?>
                                                    </td>
                                                @endforeach
                                                <td>
                                                    <li class="fas {{ $row->icon_sign_email }}"></li>
                                                </td>
                                                <td>

                                                    @if ($settingArr['edit_func'] == true)
                                                        <a class="btn btn-sm btn-info" data-bs-toggle="tooltip" title="Edit"
                                                            href="{{ route('email_templates.edit', $row->$idf) }}"><span
                                                                class="glyphicon glyphicon-edit"></span> <i
                                                                class="fas fa-edit" aria-hidden="true"></i></a>
                                                    @endif


                                                    @if ($settingArr['delete_func'] == true)
                                                        @if ($row->$idf > 24)
                                                            <a class="btn btn-sm btn-danger" href="javascript:;"
                                                                onclick="delete_email_template({{ $row->$idf }},'{{ $settingArr['contr_name'] }}');"
                                                                data-bs-toggle="tooltip" title="Delete"> <i
                                                                    class="fas fa-trash" aria-hidden="true"></i></a>
                                                        @endif
                                                    @endif


                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="8">No record found!</td>
                                        </tr>
                                    @endif
                                </tbody>
                                <tfoot>
                                </tfoot>
                            </table>
                            {{ $result->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="modal fade" id="modal_1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn close" data-bs-dismiss="modal" aria-label="Close">
                        
                        <span class="sr-only">Close</span>
                    </button>
                    <h4 class="modal-title"><i class="fas fa-caret-square-o-down" aria-hidden="true"></i> Add Status</h4>
                </div>
                <div class="modal-body">
                    <form method="post" name="frm" id="frm"
                        action="{{ admin_url() }}email_templates/add_status" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">Status</div>
                            <div class="col-md-8"><input type="text" name="status" id="status"
                                    class="form-control" value="" placeholder="" required=""></div>
                        </div>
                        <br />
                        <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-8"><button type="submit" class="btn btn-success">Submit</button></div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
@endsection
@section('beforeBodyClose')
    <script>
        var contr = '{{ $settingArr['contr_name'] }}';
    </script>
    <link href="{{ public_path_to_storage('back/mod/mod_css.css') }}" rel="stylesheet">
    <link href="{{ public_path_to_storage('back/mod/bootstrap-toggle.min.css') }}" rel="stylesheet">
    <script src="{{ public_path_to_storage('back/mod/bootstrap-toggle.min.js') }}"></script>
    <script src="{{ public_path_to_storage('back/mod/mod_js.js') }}"></script>
    <script>
        function update_status(checked, cid, sts) {


            $.ajax({
                url: '{{ route('email_template_update_status_templates') }}',
                method: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "idds": cid,
                    'sts': sts


                },
                success: function(response) {
                    var data = JSON.parse(response);

                    location.reload();
                    alertme('<i class="fas fa-check" aria-hidden="true"></i> Done Successfully ', 'success',
                        true, 1500);



                }
            });
        }

        function delete_email_template(cid) {


            $.ajax({
                url: '{{ route('email_template_delete_record') }}',
                method: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "idds": cid

                },
                success: function(response) {
                    var data = JSON.parse(response);

                    location.reload();
                    alertme('<i class="fas fa-check" aria-hidden="true"></i> Done Successfully ', 'success',
                        true, 1500);



                }
            });
        }
    </script>
@endsection
