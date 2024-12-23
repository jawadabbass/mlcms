@extends('back.layouts.app', ['title' => $title, 'heading' => $heading])
@section('bc')
    <?php echo ModBC('Detail', [$settingArr['contr_name'] => $settingArr['mainPageTitle']]); ?>
@endsection
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="card p-2">
                    <div class=" card-body table-responsive">
                        <div class="text-end"></div>

                        <div class="col-sm-12">
                            <form id="validatethis1" name="myForm" method="post"
                                action="<?php echo admin_url(); ?>mod/step/<?php echo $step; ?>/<?php echo $mod; ?>"
                                onSubmit="return formSubmit();" enctype="multipart/form-data">
                                @csrf
                                <?php 
$actionAllowed=explode(',',$tblArr['action_allowed']);
$actionArrD=array();
$action2Arr=array();
foreach($actionDataArr as $key=>$val){
  $action2Arr[$val['t_id'].'_'.$val['action_id'].'_'.$val['db_name']]=$val;     
        
}
//cp($action2Arr,'c');
//$action2Arr
foreach($RSA as $vvv2){
$atitle=$vvv2['action_name'];
$vvv='a'.$vvv2['id'];?>
                                <h2><input type="checkbox" name="ok[]" value="<?php echo $vvv2['id']; ?>" <?php if (in_array($vvv2['id'], $actionAllowed)) {
                                    echo 'checked';
                                } ?>
                                        onclick="checkallcat(this.value,'<?php echo $vvv2['id']; ?>')">
                                    <?php echo $vvv2['fa_class']; ?><?php echo $atitle; ?></h2>
                                <?php
if($vvv2['id']!=3 && $vvv2['id']!=4){
foreach($fArr as $row){
  $keyy=$mod.'_'.$vvv2['id'].'_'.$row['db_name'];
  $filedOk=true;
  if($vvv2['id']==1 || $vvv2['id']==2){if($row['type']=='dbId'){$filedOk=false;}}
  if($row['type']=='auto'){$filedOk=false;}
  if($filedOk){
  ?>
                                <div class="row" style="margin-top:10px;">
                                    <div class="col-sm-1">
                                        <?php
                                        
                                        ?>
                                        <select class="form-control" name="<?php echo $vvv; ?>_active[]">
                                            <option value="Yes" <?php if (isset($action2Arr[$keyy])) {
                                                echo 'selected';
                                            } ?>>Yes</option>
                                            <option value="No" <?php if (!isset($action2Arr[$keyy])) {
                                                echo 'selected';
                                            } ?>>No</option>
                                        </select>
                                    </div>

                                    <div class="col-sm-2"><?php echo $row['db_name']; ?>
                                        <input type="hidden" name="<?php echo $vvv; ?>_fname_arr[]"
                                            value="<?php echo $row['db_name']; ?>" class="form-control">
                                    </div>
                                    <div class="col-sm-3"><input type="text" name="<?php echo $vvv; ?>_title_arr[]"
                                            value="<?php
                                            if (isset($action2Arr[$keyy])) {
                                                echo $action2Arr[$keyy]['field_title'];
                                            } else {
                                                echo $row['title'];
                                            } ?>" class="form-control"></div>
                                    <div class="col-sm-2">
                                        <input type="checkbox" name="vald[]" value="required"> Required <br>
                                        <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#modal_validation">Other
                                            Validations</a>

                                    </div>
                                    <div class="col-sm-4"><?php
                                    if (isset($action2Arr[$keyy])) {
                                        echo ab_gen_drawDropDown($action2Arr[$keyy]['field_type'], $vvv . '_type_arr[]');
                                    } else {
                                        echo ab_gen_drawDropDown($row['type'], $vvv . '_type_arr[]');
                                    }
                                    ?>

                                    </div>
                                </div>
                                <?php
  }//$filedOk=true;
}//foreach
}//if
}
?>






                                <div class="row">
                                    <div class="col-sm-6"></div>
                                    <div class="col-sm-6"></div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-3 text-start"><a class="btn btn-info"
                                            href="<?php echo base_url($settingArr['contr_name']); ?>/add_loc/<?php echo $step - 1; ?>/<?php echo $mod; ?>"><i
                                                class="fas fa-angle-double-left" aria-hidden="true"></i> Back</a></div>
                                    <div class="col-sm-5 text-start">
                                        <input type="hidden" name="idd" value="0" />
                                        <button type="submit"  class="btn btn-success">Next <i
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
    <div class="modal fade" id="modal_validation">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    
                    <h4 class="modal-title">Validation</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        
                        <span class="sr-only">Close</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6"><input type="checkbox" name="vald[]" value="email">email</div>
                        <div class="col-md-6"><input type="checkbox" name="vald[]" value="date">date</div>
                        <div class="col-md-6"><input type="checkbox" name="vald[]" value="digits">digits</div>
                        <div class="col-md-6"><input type="checkbox" name="vald[]" value="integer">integer</div>
                        <div class="col-md-6"><input type="checkbox" name="vald[]" value="ip">ip</div>
                        <div class="col-md-6"><input type="checkbox" name="vald[]" value="lt"><input type="number"
                                name="val_lt" id="val_lt" class="form-control" value=""
                                placeholder="Less than"></div>
                        <div class="col-md-6"><input type="checkbox" name="vald[]" value="min"><input
                                type="number" name="val_min" id="val_min" class="form-control" value=""
                                placeholder="Min"></div>
                        <div class="col-md-6"><input type="checkbox" name="vald[]" value="max"><input
                                type="number" name="val_max" id="val_max" class="form-control" value=""
                                placeholder="Max"></div>
                        {{-- <div class="col-md-6"><input type="checkbox" name="vald[]" value="not_in">not_in:foo,bar</div> --}}<div class="col-md-6"><input type="checkbox" name="vald[]"
                                value="numeric">numeric</div>
                        <div class="col-md-6"><input type="checkbox" name="vald[]" value="same"><input
                                type="text" name="val_same" id="val_same" class="form-control" value=""
                                placeholder="Enter Same Field"></div>
                        <div class="col-md-6"><input type="checkbox" name="vald[]" value="unique">
                            <input type="text" name="unique" id="unique" class="form-control"
                                value="users,email_address" placeholder="Unique">
                        </div>
                        <div class="col-md-6"><input type="checkbox" name="vald[]" id="vald[]">string</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection
@section('beforeBodyClose')
    <script>
        function checkallcat(sts, catID) {
            if (sts) {
                $("select[name='a" + catID + "_active[]']").val('Yes');
            } else {
                $("select[name='a" + catID + "_active[]']").val('No');
            }
        }
    </script>
@endsection
