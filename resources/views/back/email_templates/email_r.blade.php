<form action="<?php echo base_url($settingArr['contr_name']);?>/action_edit" enctype="multipart/form-data" id="validatethis" method="post" name="myForm" onsubmit="return formSubmit();">
    {{ csrf_field() }}
    <div class="modalpadding">
    
        <div class="row" style="margin-top:10px;">
            <div class="col-sm-4 text-end">
               Email Recipients
                :
            </div>
            <div class="col-sm-8">
                @foreach($adminusers as $key=>$val)
                <input @if($val->on_notification_email=='Yes') checked="" @endif type="checkbox" name="recp[]" id="{{$val->id}}" value="{{$val->id}}"> {{$val->name}} ({{$val->email}}) <br/>
                @endforeach
            </div>
        </div>

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
                <button class="btn btn-success" onclick="return mod_add_page(myForm,'<?php echo $settingArr['contr_name'];?>/update_email_r','',false);" type="button">Submit </button>
            </div>
        </div>
    </div>
</form>