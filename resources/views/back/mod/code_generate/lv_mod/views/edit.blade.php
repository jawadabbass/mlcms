<form id="validatethis" name="myForm" method="post" action="<?php echo base_url($settingArr['contr_name']); ?>/action_edit"
    onSubmit="return formSubmit();" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="modalpadding">
        <?php foreach($dataArr as $key=>$val){
      $textType='text';
      if($val[1]!='')
      $textType=$val[1];
      
      ?>
        <div class="row" style="margin-top:10px;">
            <div class="col-sm-4 text-end"><?php echo $val[0]; ?>:</div>
            <div class="col-sm-8">
                <?php echo ModFBuild($val, $key, $row->$key, 'edit'); ?>
            </div>
        </div>

        <?php }?>







        <div class="row">

            <div class="col-sm-6">&nbsp;</div>

            <div class="col-sm-6"> </div>

        </div>

        <div class="row">

            <div class="col-md-7"><button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
            </div>



            <div class="col-md-5 text-end">

                <input type="hidden" name="idd" value="<?php echo $row->$idf; ?>" />

                <button type="button"
                    onclick="return mod_edit_page(myForm,'<?php echo $settingArr['contr_name']; ?>','<?php echo $row->$idf; ?>',true);"
                    class="btn btn-success subm">{!! the_icon('subm') !!} Submit</button>
            </div>

        </div>

    </div>

</form>
