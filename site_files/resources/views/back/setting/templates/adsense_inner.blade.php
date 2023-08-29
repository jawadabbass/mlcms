<section class="content" id="google-adsense">
    <div class="box">
        <h2 class="box-title">
            <i class="fas fa-arrow-circle-o-down" aria-hidden="true"></i> Google adsense code
            @php echo helptooltip('google_adsense_content') @endphp
        </h2>
        <form name="emp_network_detail" method="post" action="{{ route('settings.update', 0) }}">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <div class="mb-2">
                <div id="g_adsense" class="row">
                    <div class="col-md-4">
                        <div class="myfldrow">
                            <strong>Footer Adsense code</strong>
                            <textarea type="text" class="form-control" name="google_adsense_footer" placeholder="Footer Adsense code"
                                rows="7">{{ $setting_result->google_adsense_footer }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="myfldrow">
                            <strong>Left Adsense code</strong>
                            <textarea class="form-control" name="google_adsense_left" placeholder="Left Adsense code" rows="7">{{ $setting_result->google_adsense_left }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="myfldrow">
                            <strong>Right Adsense code</strong>
                            <textarea class="form-control" name="google_adsense_right" placeholder="Right Adsense code" rows="7">{{ $setting_result->google_adsense_right }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <p><a href="https://www.google.com/adsense/" target="_blank">Sign Up or Manage
                                Adsense</a> by clicking this link</p>
                    </div>
                    <div class="col-md-12">
                        <br />
                        <input type="submit" name="change_network_details" value="update" class="sitebtn" />
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>