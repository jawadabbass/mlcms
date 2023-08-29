<section class="content" id="google-analytics">
    <div class="box">
        <h2 class="box-title">
            <i class="fas fa-arrow-circle-o-down" aria-hidden="true"></i> Google Analytics Code
            @php echo helptooltip('google_analytics_content') @endphp
        </h2>
        <form name="emp_network_detail" method="post" action="{{ route('settings.store') }}">
            @csrf
            <div class="mb-2">
                <div id="g_analy">
                    <div class="myfldrow">
                        <textarea class="form-control" name="google_analytics">{{ $setting_result->google_analytics }}</textarea>
                        <p>Copy google analytics code with "script" tag and paste above</p>
                        <p><a href="https://www.google.com/analytics" target="_blank">Sign Up or Manage
                                Analytics </a> by clicking this link</p>
                    </div>
                    <input type="submit" name="change_network_details" value="update" class="sitebtn" />
                </div>
            </div>
        </form>
    </div>
</section>