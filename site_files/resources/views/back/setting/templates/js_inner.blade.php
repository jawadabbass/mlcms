<section class="content" id="google-analytics">
    <div class="box">
        <h2 class="box-title">
            <i class="fas fa-arrow-circle-o-down" aria-hidden="true"></i> Javascript Code to include in your site
            {{-- @php echo helptooltip('js_code') @endphp --}}
        </h2>
        <form name="emp_network_detail" method="post" action="{{ admin_url() . 'setting/js' }}">
            @csrf
            <div class="mb-2">
                <div id="g_analy">
                    <div class="myfldrow">
                        <p>Copy js Code that you want ot put in your {{ '<head></head>' }} here</p>
                        <textarea class="form-control" name="head_js">{{ $setting_result->head_js }}</textarea>
                    </div>
                    <div class="myfldrow">
                        <p>Copy js Code that you want ot put in bottom of {{ '<body>' }} here</p>
                        <textarea class="form-control" name="body_js">{{ $setting_result->body_js }}</textarea>
                    </div>
                    <input type="submit" name="change_network_details" value="update" class="sitebtn" />
                </div>
            </div>
        </form>
    </div>
</section>