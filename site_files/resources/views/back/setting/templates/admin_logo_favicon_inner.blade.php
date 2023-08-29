<section class="content" id="admin_logo_favicon-setting">
    <div class="box">
        <h2 class="box-title">
            <i class="fas fa-arrow-circle-o-down" aria-hidden="true"></i> Logo and Favicon Settings
            @php echo helptooltip('admin_logo_favicon') @endphp
        </h2>
        <br>
        <form name="logo_favicon_frm" id="logo_favicon_frm" method="post"
            action="{{ base_url() . 'adminmedia/setting/admin_logo_favicon' }}" enctype="multipart/form-data">
            @csrf
            <div id="g_analy" style="margin-left: -15px;">
                <div class="row">
                    <div class="col-md-12">
                        <img src="{!! getImage('admin_logo_favicon', $setting_result->admin_login_page_logo, 'main') !!}" />
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="mb-2">
                            <label class="form-label">Admin Login Page Logo</label>
                            <input type="file" name="admin_login_page_logo"
                                class="form-control basic_setting_height">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <img src="{!! getImage('admin_logo_favicon', $setting_result->admin_header_logo, 'main') !!}" />
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="mb-2">
                            <label class="form-label">Admin Header Logo</label>
                            <input type="file" name="admin_header_logo"
                                class="form-control basic_setting_height">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <img src="{!! getImage('admin_logo_favicon', $setting_result->admin_favicon, 'main') !!}" />
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="mb-2">
                            <label class="form-label">Admin Favicon</label>
                            <input type="file" name="admin_favicon" class="form-control basic_setting_height">
                        </div>
                    </div>
                </div>
                <br><br>
                <input type="submit" name="logo_favicon_btn" value="Update" class="sitebtn" />
            </div>
        </form>
    </div>
</section>