@extends('back.layouts.app', ['title' => $title, 'heading' => $settingArr['mainPageTitle']])

@section('bc')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ admin_url() }}"><i class="fas fa-gauge"></i> Home</a></li>
        <li class="breadcrumb-item active">{{ $settingArr['mainPageTitle'] }}</li>
    </ol>
@endsection
@section('content')
    <div class="content-wrapper pl-3 pr-2">

        <section class="content">
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="box">
                        <div class="row">


                            <div class="col-sm-4 text-start"></div>
                            <div class="col-sm-8 text-end top_action_btn">
                                <?php if($settingArr['add_func']==true){?>
                                <a class="btn btn-md btn-info" title="Edit" href="javascript:;"
                                    onClick="getPop('Add','<?php echo $settingArr['contr_name']; ?>','','add');">{!! the_icon('add') !!} Add</a>
                                <?php }?>

                                <?php if($settingArr['order_func']==true){?>
                                <a class="btn btn-md btn-info" title="Edit"
                                    href="<?php echo admin_url() . $settingArr['contr_name'] . '/set_order'; ?>">{!! the_icon('sort') !!} Order</a>
                                <?php }?>



                            </div>
                        </div>


                        {{-- Search Area --}}

                        <?php 
if($settingArr['search_func']==true && !empty($arrSearch)){?>
                        <form action="<?php echo admin_url() . $settingArr['contr_name'] . '/'; ?>" method="get" id="search_frm">

                            <div class="row">

                                <?php 
foreach($arrSearch as $key=>$val){?>
                                <div class="col-sm-2">
                                    <?php
                                    echo ModFBuild($val, $key, viewtxt($key, $searchDataArr), 'search');
                                    ?>


                                </div>
                                <?php }?>
                                <div class="col-sm-2">
                                    <a href="<?php echo admin_url(); ?><?php echo $settingArr['contr_name']; ?>"><i class="fas fa-sync"
                                            aria-hidden="true"></i> Reset search</a>
                                    <input type="hidden" name="sr" value="y">
                                    <button type="submit" class="btn btn-sm btn-success">{!! the_icon('search') !!}
                                        Search</button>
                                </div>
                            </div>


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

                        {{-- end Search Area --}}



                        <div class="box-body table-responsive">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <?php 
foreach($dataArr as $key=>$val){?>
                                        <th><?php echo $val[0]; ?></th>
                                        <?php }?>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($result)
                                        @foreach ($result as $row)
                                            <tr id="row_{{ $row->$idf }}">
                                                @foreach ($dataArr as $key => $val)
                                                    <td>
                                                        {{-- Data DIV --}}
                                                        <?php if(stristr($val[1],'slide_flag__')){
      $tstArr=explode('__',$val[1]);
      ?>
                                                        <input type="checkbox"
                                                            <?php if($row->$key=='Yes'){?>checked<?php }?>
                                                            data-toggle="toggle" data-onstyle="success"
                                                            data-offstyle="danger" data-on="<?php echo $tstArr[1]; ?>"
                                                            data-off="<?php echo $tstArr[2]; ?>" name="<?php echo $key; ?>"
                                                            data-size="mini" id="<?php echo $key; ?>"
                                                            onChange="updatePageStatus(this.checked,'<?php echo $row->$idf; ?>','<?php echo $key; ?>')">


                                                        <?php }
else{?>
                                                        {!! ModTBuild($row->$key, $val[1], $settingArr['baseImg']) !!}
                                                        <?php }?>


                                                    </td>
                                                @endforeach
                                                <td>
                                                    @if ($settingArr['edit_func'] == true)
                                                        <a class="btn btn-sm btn-info" title="Edit" href="javascript:;"
                                                            onClick="getEditDiv_page('Edit','{{ $settingArr['contr_name'] }}','{{ $row->$idf }}');">{!! the_icon('edit') !!}
                                                            Quick Edit</a>
                                                    @endif


                                                    @if ($settingArr['delete_func'] == true)
                                                        <a class="btn btn-sm btn-danger" href="javascript:;"
                                                            onclick="delete_this_record({{ $row->$idf }},'{{ $settingArr['contr_name'] }}');"
                                                            title="Delete">{!! the_icon('del') !!} Delete</a>
                                                    @endif

                                                    @if ($settingArr['detail_func'] == true)
                                                        <a class="btn btn-sm btn-info"
                                                            href="<?php echo admin_url() . $settingArr['contr_name'] . '/' . $row->$idf; ?>">{!! the_icon('info-circle') !!} Details</a>
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
@endsection
@section('beforeBodyClose')
    <script>
        var contr = '{{ $settingArr['contr_name'] }}';
    </script>

    <link href="{{ asset_storage('') }}back/mod/mod_css.css" rel="stylesheet">
    <link href="{{ asset_storage('') }}back/mod/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="{{ asset_storage('') }}back/mod/bootstrap-toggle.min.js"></script>
    <script src="{{ asset_storage('') }}back/mod/mod_js.js"></script>
@endsection
