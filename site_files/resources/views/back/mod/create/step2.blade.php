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
                        <div class="text-end"></div>

                        <div class="col-sm-12">
                            <form id="validatethis1" name="myForm" method="post"
                                action="{{ admin_url() }}mod/step/2/{{ $mod }}" onSubmit="return formSubmit();"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row" style="padding: ">
                                    <div class="col-sm-4"><code>Database field</code> </div>
                                    <div class="col-sm-4"><code>Field Name to Display in <strong>Form</code></strong></div>
                                    <div class="col-sm-4"><code>Field Type</code></div>
                                </div>
                                <?php 
if(is_array($oldData) && !empty($oldData)){
	
$cnt=0;
foreach($oldData as $row){?>
                                <div class="row" style="margin-top:">
                                    <div class="col-sm-4"><?php echo $row->db_name; ?>
                                        <input type="hidden" name="fname_arr[]" value="<?php echo $row->db_name; ?>"
                                            class="form-control">
                                    </div>
                                    <div class="col-sm-4"><input type="text" name="title_arr[]"
                                            value="<?php echo $row->title; ?>" class="form-control"></div>
                                    <div class="col-sm-4"><?php
                                    echo ab_gen_drawDropDown($row->type);
                                    
                                    ?>

                                    </div>
                                </div>
                                <?php
$cnt++;
    //echo "{$row->Field} - {$row->Type}\n";
}	
	
	
	
}else{
$cnt=0;
foreach($q as $row){?>
                                <div class="row rowm">
                                    <div class="col-sm-4"><?php echo $row->Field; ?>
                                        <input type="hidden" name="fname_arr[]" value="<?php echo $row->Field; ?>"
                                            class="form-control">
                                    </div>
                                    <div class="col-sm-4"><input type="text" name="title_arr[]"
                                            value="<?php echo Mod_auto_name_to_Key($row->Field); ?>" class="form-control"></div>
                                    <div class="col-sm-4"><?php
                                    if ($cnt == 0) {
                                        echo ab_gen_drawDropDown('dbId');
                                    } else {
                                        echo ab_gen_drawDropDown($row->Field);
                                    }
                                    ?>

                                    </div>
                                </div>
                                <?php
$cnt++;
    //echo "{$row->Field} - {$row->Type}\n";
}}
?>






                                <div class="row">
                                    <div class="col-sm-6">-</div>
                                    <div class="col-sm-6"></div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-3 text-start"><a class="btn btn-info"
                                            href="{{ admin_url() }}mod/step/1/{{ $mod }}"><i
                                                class="fas fa-angle-double-left" aria-hidden="true"></i> Back</a></div>
                                    <div class="col-sm-5 text-start">
                                        <input type="hidden" name="idd" value="0" />
                                        <button type="submit" class="btn btn-success">Next <i
                                                class="fas fa-angle-double-right" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </div>
@endsection
