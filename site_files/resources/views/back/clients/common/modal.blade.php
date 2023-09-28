<!-- Send Email By Email Template -->
<div class="modal fade" id="sendEmailTemplate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Email Template</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    
                </button>
            </div>
            <form id="emailTemplateForm">
                @csrf


                <div class="modal-body">
                    <input type="hidden" name="receiver_user_id" id="receiver_user_id">
                    <input type="hidden" name="receiver_type" id="receiver_type">
                    <input type="hidden" name="value_send" id="value_send">



                    <div class="form-group">
                        <label for="">Select Email Template</label>
                        <select class="form-control" name="template_id" id="template_id">
                            @foreach ($email_template as $temp)
                                <option value="{{ $temp->ID }}">{{ $temp->Title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Subject Of Email</label>
                        <input name="subject" id="subject" class="form-control">

                    </div>
                    <div class="form-group">
                        <div id="user_email_area">
                            <div class="row" style="margin-top:10px;">
                                <div class="col-sm-12">
                                    <label for="User Email Body:">User Email Body:</label>
                                    @php
                                        $arr1 = explode(',', '{CLIENT_NAME}');
                                        $arr2 = explode(',', '{NAME}');
                                        // $arr3=explode(',','{TITLE}');
                                        $arr4 = explode(',', '{COMPANY E-MAIL}');
                                        $arr = array_merge($arr1, $arr2, $arr4);
                                        foreach ($arr as $kk => $vv) {
                                            echo '<code style="cursor: pointer;"  data-toggle="tooltip" title="Click to insert ' . $vv . '" onclick="insertIntoCkeditor(\'user_body\', \'' . $vv . '\')">' . $vv . '</code>, ';
                                        }
                                    @endphp
                                    <textarea name="user_body" id="user_body" class="form-control" required="">
                                </textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="combine_send" style="display: none;">


                        <div class="form-group">
                            <label style="margin-top: 10px;font-size:18px;">Do You Want Send This Email To Client's</label>


                            <input type="checkbox" name="send_to_client" id="send_to_client_id">
                        </div>
                        
                        <div class="col-sm-12" id="client_packages_id" style="display:none;">
                         <p>Please Select Package</p>     
                        <div class="row">
                            
                        @foreach( $get_all_packages as $package)    
                        <div class="col-sm-3">
                        <div class="form-group">
                            <label style="margin-top: 10px;font-size:18px;">{{$package->heading}}</label>


                            <input type="checkbox" name="client_package[{{$package->id}}]">
                        </div>        
                            
                        </div>
                        @endforeach
                        </div>    
                        </div>
                        
                        <div class="form-group">
                            <label style="margin-top: 10px;font-size:18px;">Do You Want Send This Email To Leads's</label>


                            <input type="checkbox" name="send_to_leads" id="send_to_leads">
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <label style="margin-top: 10px;">Save Changes In Selected Template</label>
                        <input type="checkbox" name="new_temp">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="save_email_record_send()">Send
                            Email</button>
                    </div>
            </form>
        </div>
    </div>
</div>
