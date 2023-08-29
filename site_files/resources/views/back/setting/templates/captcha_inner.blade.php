<section class="content" id="google-captcha">
    <div class="box">
        <h2 class="box-title"><i class="fas fa-arrow-circle-o-down" aria-hidden="true"></i> ContactUs Captcha
        </h2>
        <form name="emp_network_detail" method="post" action="{{ admin_url() . 'setting/captcha' }}">
            @csrf
            <div class="mb-2">
                <br><br>
                <span style="font-size:12px">
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            </button>
                        Google reCAPTCHA is a free service that protects your website from spam and abuse.
                        reCAPTCHA uses an advanced risk analysis engine and adaptive CAPTCHAs to keep automated
                        software
                        from submittting your forms. It does this while letting your valid users pass through
                        with ease.
                        You can get the Keys for reCapcha from here
                        <a href="https://www.google.com/recaptcha/admin"
                            target="_blank">https://www.google.com/recaptcha/admin</a>
                    </div>
                </span>
                <div id="d_web">
                    <p></p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label class="form-label">reCAPTCHA SITE KEY</label>
                                <input type="text" class="form-control" name="siteKey" placeholder="Site Key"
                                    value="{{ $metaArray['recaptcha_site_key'] }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label class="form-label">reCAPTCHA SECRET KEY</label>
                                <input type="text" class="form-control" name="secretKey" placeholder="Secret Key"
                                    value="{{ $metaArray['recaptcha_secret_key'] }}">
                            </div>
                        </div>
                    </div>
                    <input type="submit" name="change_network_details" value="update" class="sitebtn" />
                </div>
            </div>
        </form>
    </div>
</section>