<form action="<?php echo base_url($settingArr['contr_name']);?>/action_edit" enctype="multipart/form-data" id="validatethis" method="post" name="myForm" onsubmit="return formSubmit();">text-endtext-end
    {{ csrf_field() }}
    <div class="modalpadding">
        <?php foreach($dataArr as $key=>
        $val){
      $textType='text';
      if($val[1]!='')
      $textType=$val[1];
      
      ?>
        <div class="row" style="margin-top:10px;">
            <div class="col-sm-4 text-end">
                <?php echo $val[0]?>
                :
            </div>
            <div class="col-sm-8">
                <?php 
                $def_val='';
                if($key=='SenderName'){$def_val='Admin';}
                if($key=='Sender'){$def_val='admin@almondpay.com';}
                if($key=='icon'){$def_val='fa-solid fa-plus-circle';}
                if($key=='icon_class'){$def_val='text-success';}
                echo ModFBuild($val,$key,$def_val,'add');
                ?>
            </div>
        </div>
        <?php }?>
        <div class="row">
            <div class="col-sm-6">
            </div>
            <div class="col-sm-6">
            </div>
        </div>
        <div class="row">
            <div class="col-md-7">
                <button class="btn btn-danger" data-bs-dismiss="modal" type="button">
                    Cancel
                </button>
            </div>
            <div class="col-md-5 text-end">
                <input name="idd" type="hidden" value=""/>
                <button class="btn btn-success" onclick="return mod_add_page(myForm,'<?php echo $settingArr['contr_name'];?>','',true);" type="button">
                    Submit
                </button>
            </div>
        </div>
    </div>
</form>