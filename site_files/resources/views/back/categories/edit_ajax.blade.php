<form id="validatethis" name="myForm" method="post" action="<?php echo base_url($settingArr['contr_name']); ?>/action_edit"
    onSubmit="return formSubmit();" enctype="multipart/form-data">
    <div class="row">
        <div class="col-sm-4 text-end">Title:</div>
        <div class="col-sm-8"><input type="text" class="form-control" name="title" id="title"
                value="<?php echo $row['title']; ?>" />
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">&nbsp;</div>
        <div class="col-sm-6"></div>
    </div>
    <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-4 text-end">
            <button type="button" class="btn btn-info" data-bs-dismiss="modal">Cancel</button>
        </div>
        <div class="col-sm-4 text-end">
            <input type="hidden" name="idd" value="<?php echo $row[$settingArr['dbId']]; ?>" />
            <button type="button" onclick="return editForm_cat(myForm,'<?php echo $settingArr['contr_name']; ?>','<?php echo $row[$settingArr['dbId']]; ?>');"
                class="btn btn-success">Submit
            </button>
        </div>
    </div>
</form>
