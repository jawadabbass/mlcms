<section class="content" id="google-paypal">
    <div class="box">
        <h2 class="box-title"><i class="fa-solid fa-arrow-circle-o-down" aria-hidden="true"></i> PayPal Settings
        </h2>
        <form name="emp_network_detail" method="post" action="{{ admin_url() . 'setting/paypal' }}">
            @csrf
            <div class="mb-2">
                <div id="d_web">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-2">
                                <label class="form-label"><strong>Paypal live client id</strong></label>
                                <input type="text" class="form-control" name="paypal_live_client_id"
                                    placeholder="Paypal live client id"
                                    value="{{ $metaArray['paypal_live_client_id'] }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-2">
                                <label class="form-label"><strong>Paypal live secret</strong></label>
                                <input type="text" class="form-control" name="paypal_live_secret"
                                    placeholder="Paypal live secret" value="{{ $metaArray['paypal_live_secret'] }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <hr class="text-danger m-4" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-2">
                                <label class="form-label"><strong>Paypal sandbox client id</strong></label>
                                <input type="text" class="form-control" name="paypal_sandbox_client_id"
                                    placeholder="Paypal sandbox client id"
                                    value="{{ $metaArray['paypal_sandbox_client_id'] }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-2">
                                <label class="form-label"><strong>Paypal sandbox secret</strong></label>
                                <input type="text" class="form-control" name="paypal_sandbox_secret"
                                    placeholder="Paypal sandbox secret"
                                    value="{{ $metaArray['paypal_sandbox_secret'] }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <hr class="text-danger m-4" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-2">
                                <label class="form-label"><strong>Paypal mode</strong></label>
                                <select name="paypal_mode" class="form-control">
                                    <option value="live" {{ $metaArray['paypal_mode'] == 'live' ? 'Selected' : '' }}>
                                        Live
                                    </option>
                                    <option value="sandbox"
                                        {{ $metaArray['paypal_mode'] == 'sandbox' ? 'Selected' : '' }}>
                                        Sandbox</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <hr class="text-danger m-4" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-2">
                                <label class="form-label"><strong>Usage</strong></label>
                                <code>
                                    <br />config('paypal.client_id') // "Live Client ID" if "MODE" is "live" otherwise "Sandbox Client ID"
                                    <br />config('paypal.secret') // "Live Secret" if "MODE" is "live" otherwise "Sandbox Secret"
                                    <br />config('paypal.settings.mode') // live/sandbox
                                </code>
                            </div>
                        </div>
                    </div>

                    <input type="submit" name="change_network_details" value="update" class="sitebtn" />
                </div>
            </div>
        </form>
    </div>
</section>
