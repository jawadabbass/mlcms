<section class="content" id="disable-website">
    <div class="box">
        <h2 class="box-title"><i class="fas fa-arrow-circle-o-down" aria-hidden="true"></i> Disable Website </h2>
        <form name="emp_network_detail" action="{{ route('settings.edit', 0) }}">
            <div class="mb-2">
                <span style="color:red; font-size:12px">
                    @php
                        if ($setting_result->web_down_status == 1) {
                            echo '<div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            </button>
                            <strong>Warning</strong>: (Currenly Website is down!!!). </div>';
                        }
                    @endphp
                </span>
                <br />
                <div class="mb-2">
                    <label class="form-label">
                        @php
                            $statusVal = old('web_down_status') ? old('web_down_status') : $setting_result->web_down_status;
                            $checked = $statusVal == 1 ? 'checked' : '';
                        @endphp
                        <input id="web_down_status" name="web_down_status" type="checkbox" {{ $checked }}
                            data-toggle="toggle" data-on="On" data-off="Off" data-onstyle="danger"
                            data-offstyle="success">
                        Disable Status
                    </label>
                    @php echo helptooltip('web_down_status') @endphp
                </div>
                <div id="d_web">
                    <textarea class="form-control" id="web_down_msg" name="web_down_msg">
                        {{ old('web_down_msg') ? old('down_msg') : $setting_result->web_down_msg }}
                    </textarea>

                    <br>
                    <input type="submit" name="change_network_details" value="update" class="sitebtn" />
                </div>
            </div>
        </form>
    </div>
</section>
@push('beforeBodyClose')
    <script type="text/javascript">
        $(function() {
            $('#web_down_status').bootstrapToggle();
        });
    </script>
@endpush
