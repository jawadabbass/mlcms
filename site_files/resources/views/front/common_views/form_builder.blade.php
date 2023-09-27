<h5><?php $formError = validation_errors();
	$msg = $this->session->userdata('msg');
	if ($msg != '') {
		echo myform_msg($msg, 's');
	}
	if ($formError != '') {
		?>
    <?php echo myform_getmsg($formError, 'e');
	}?></h5>
<form method="post" name="frmProfile" action="" id="frmProfile" onSubmit="return StdValidation();">
    <ul class="profileList">
        <?php
		foreach($fields as $key=>$formOptions) {?>
        <?php if($formOptions['type'] == 'heading' && $key == 0){?>
        <h3><?php echo $formOptions['label']; ?></h3>
        <?php }
		else if($formOptions['type'] == 'heading'){
			echo '</li></ul><h3>' . $formOptions['label'] . '</h3><ul class="profileList">';
		}
		else{?>
        <?php if($formOptions['type'] == 'captcha'){?>
        <li>
            <div class="row">
                <div class="col-sm-12">
                    Please type the following characters in the box below: <?php echo $capImage; ?>
                </div>
            </div>
        </li>
        <li>
            <div class="row">
                <div class="col-sm-4 text-right">in box</div>
                <div class="col-sm-8"><input type="text" size="10" class="form-control" id="cpt_code"
                        value="" name="cpt_code" style="width:30%;">
                    <?php echo form_error('cpt_code'); ?>
                    <?php echo form_error('validate_code'); ?>
                </div>
            </div>
        </li>
        <?php }else{?>
        <li>
            <div class="row">
                <div class="col-sm-4"><label><?php echo $formOptions['label']; ?>
                        : <?php myform_error_span('err_' . $formOptions['name']); ?></label></div>
                <div class="col-sm-8">
                    <?php
					if($formOptions['type'] == 'text'){
						if ($formError != '') {
							$member->$formOptions['name'] = set_value($formOptions['name']);
						}
						$dataArr = array(
							'name' => $formOptions['name'],
							'id' => $formOptions['name'],
							'value' => $member->$formOptions['name'],
							'class' => 'form-control',);
						if (stristr($formOptions['validation'][0], 'integer')) {
							$dataArr['onkeypress'] = 'return OnlyNumber(event,\'err_' . $formOptions['name'] . '\');';
						}
						//			$otherData = 'onkeypress=""';
						echo form_input($dataArr);
					}
					else if($formOptions['type'] == 'date'){?>
                    <input type="text" name="<?php echo $formOptions['name']; ?>" id="<?php echo $formOptions['name']; ?>"
                        value="<?php echo date_formats($member->$formOptions['name']); ?>" class="form-control mldate" autocomplete="off">
                    <?php
					}
					else if ($formOptions['type'] == 'rb') {
						$arrVals = Get_DB_Name($formOptions['multi_key'], '', 'arr');
						//echo '<pre>';print_r($arrVals);echo '</pre>';exit;
						foreach ($arrVals as $keyy => $vall) {
							$selected = false;
							if ($member->$formOptions['name'] == $keyy) {
								$selected = true;
							}
							echo form_radio($formOptions['name'], $keyy, $selected, '') . ' <span style="padding-right:20px;">' . $vall . '</span>';
						}
					} else if ($formOptions['type'] == 'dd') {
						$arrVals = Get_DB_Name($formOptions['multi_key'], '', 'arr');
						$dataArr = array(
							'name' => $formOptions['name'],
							'id' => $formOptions['name'],
							'value' => $member->$formOptions['name'],
							'class' => 'form-control'
						);
						echo form_dropdown($formOptions['name'], $arrVals, $member->$formOptions['name'], $dataArr);
					} else if ($formOptions['type'] == 'dd_state') {
						echo drawDropDown($formOptions['name'], "SELECT * FROM `states` where fk_country_id=244;", 'state_name', 'state_name', $member->$formOptions['name'], 'class="form-control"');
					} else if ($formOptions['type'] == 'ta') {
						$data = array(
							'name' => $formOptions['name'],
							'id' => $formOptions['name'],
							'value' => $member->$formOptions['name'],
							'class' => 'form-control',
						);
						echo form_textarea($data);
					}
					echo form_error($formOptions['name']);?>
                </div>
            </div>
        </li>
        <?php }}//
		}?>
        <li>
            <div class="row">
                <div class="col-sm-4"><label></label></div>
                <div class="col-sm-8">
                    <span style="display:none"><img src="<?php echo public_path_to_storage('images/common/loader.gif'); ?>" /></span>
                    <?php
                    if (!isset($formButtonText)) {
                        $formButtonText = 'Update';
                    }
                    echo form_submit('submit', $formButtonText, 'class="fbutn" onClick="return loadprocess(this);"'); ?>
                </div>
            </div>
        </li>
    </ul>
</form>
