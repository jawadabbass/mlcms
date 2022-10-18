<form action="<?php echo base_url($settingArr['contr_name']); ?>/action_edit" enctype="multipart/form-data" id="validatethis" method="post" name="myForm"
    onsubmit="return formSubmit();">
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
                <?php echo $val[0]; ?>
                :
            </div>
            <div class="col-sm-8">
                <?php echo ModFBuild($val, $key, '', 'add'); ?>
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
                <input name="idd" type="hidden" value="" />
                <button class="btn btn-success subm"
                    onclick="return mod_add_page(myForm,'<?php echo $settingArr['contr_name']; ?>','',true);" type="button">
                    {!! the_icon('subm') !!} Submit
                </button>
            </div>
        </div>
    </div>
</form>
