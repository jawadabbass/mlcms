<!DOCTYPE html>
<html>

<head>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
        integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <title>PAY</title>
    <style type="text/css">
        .mainc {
            border: 20px solid #eee;
            padding: 15px;
            margin-top: 30px;
            border-radius: 30px;
            box-shadow: 5px 5px 5px 5px #c6c0c0;
        }

        .rowd {
            margin-top: 15px;
        }

        label {
            color: #999;
        }

        .loader {
            color: red;
            animation-name: loader;
            animation-duration: 1s;
            animation-iteration-count: infinite;
        }

        @keyframes loader {
            0% {
                color: green;
            }

            25% {
                letter-spacing: 3px;
            }

            50% {
                letter-spacing: 6px;
            }

            75% {
                color: red;
            }
        }
    </style>
</head>

<body>
    <div class="innerpagewrap">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="contact-form">
                        <form action="#" method="POST" name="contactForm" id="contactForm" class="contact-form">
                            @csrf
                            <div class="row">
                                <div class="col-lg-3"></div>
                                <div class="col-lg-6 mainc">
                                    <div class="col-lg-12 rowd">
                                        <label>Credit Card (XXXXXXXXXXXXXXXX)</label>
                                        <div>
                                            <input type="text" name="creditCardNo" id="creditCard"
                                                class="form-control" placeholder="Number"
                                                onkeypress="return checkDigit(event)" maxlength="16">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 rowd">
                                        <label>Expiry Date</label>
                                        <div>
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-xs-6">
                                                    <select name="expMonth" class="form-control">
                                                        <option>01</option>
                                                        <option>02</option>
                                                        <option>03</option>
                                                        <option>04</option>
                                                        <option>05</option>
                                                        <option>06</option>
                                                        <option>07</option>
                                                        <option>08</option>
                                                        <option>09</option>
                                                        <option>10</option>
                                                        <option>11</option>
                                                        <option>12</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-xs-6">
                                                    <select name="expYear" class="form-control">
                                                        @for ($i = 2018; $i < 2028; $i++)
                                                            <option>{{ $i }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 rowd">
                                        <label>CVV Number</label>
                                        <div>
                                            <input type="text" name="cvvNumber" id="cvvNumber" class="form-control"
                                                placeholder="CVV Number" onkeypress="return checkDigit(event)"
                                                maxlength="4">
                                        </div>
                                    </div>
                                    <input type="hidden" name="invoice_id" value="{{ $slug }}" />
                                    <div class="col-lg-12 rowd">
                                        <h4>Price: <code>${{ $invoiceObj->amount }}</code></h4>
                                    </div>
                                    @if ($invoiceObj->status == 'Paid')
                                        <br>
                                        <br>
                                        <div class="col-lg-12">
                                            <h4>Payment Status: <span class="text-success"> <i class="fa fa-check"
                                                        aria-hidden="true"></i> Paid</span>
                                            </h4>
                                        </div>
                                    @else
                                        <div class="col-lg-12 rowd" style="margin-left: 15px;">
                                            <div class="row">
                                                <div class="loader" id="loader" style="display: none;">
                                                    <h1> <i class="fa refresh fa-spin" aria-hidden="true"></i>
                                                        Processing ...</h1>
                                                </div>
                                                <button type="button" id="btnSave" onclick="save()"
                                                    class="btn btn-success btn-lg sub_btn"
                                                    style="margin-bottom: 11px;margin-top: 5px;">Pay <i
                                                        class="fa fa-paper-plane"></i> </button>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-lg-3"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script src="{{ asset_storage('lib/sweetalert/sweetalert2.js') }}"></script>
    <script src="https://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
    <script>
        var base_url = "{{ base_url() }}";

        function refreshCaptcha() {
            console.log("Refresh");
            var myurl = base_url + 'refresh';
            $.get(myurl, function(sts) {
                console.log(sts);
                $("#Imageid").attr("src", base_url + "captcha/images/" + sts.slice(1, -1));
            });
        }
        function refreshCaptcha() {
            console.log("Refresh");
            var myurl = base_url + 'refresh';
            $.get(myurl, function(sts) {
                console.log(sts);
                $("#Imageid").attr("src", base_url + "captcha/images/" + sts.slice(1, -1));
            });
        }

        function save() {
            if (validateForm()) {
                $('#btnSave').css('display', 'none');
                $('#loader').css('display', 'block');
                url = "{{ base_url() }}invoice/pay/post";
                method = 'POST';
                header = '';
                let formData = new FormData($('#contactForm')[0]);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: url,
                    type: method,
                    data: formData,
                    headers: header,
                    async: true,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        console.log(data);
                        data = JSON.parse(data);
                        $('#btnSave').css('display', 'block');
                        $('#loader').css('display', 'none');
                        if (data.status) {
                            $("#reservationForm").trigger('reset');
                            swal(
                                'Thank you!',
                                data.error,
                                'success'
                            );
                        } else {
                            swal(
                                'Sorry!',
                                data.error,
                                'error'
                            );
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        $('#btnSave').css('display', 'block');
                        $('#loader').css('display', 'none');
                        alert('Error sending your request');
                        console.log(jqXHR);
                        console.log(textStatus);
                        console.log(errorThrown);
                    }
                });
            }
        }

        function validateForm() {
            var text = '';
            valid = true;
            var crCard = $("#creditCard").val();
            if (crCard.length < 11) {
                text += "Credit Card must be valid <br>";
                valid = false;
            }
            var cvv = $("#cvvNumber").val();
            if (cvv.length < 2) {
                text += "CVV must be valid <br>";
                valid = false;
            }
            if (!valid) {
                swal(
                    'Sorry!',
                    text,
                    'error'
                );
                return false;
            }
            return true;
        }
    </script>
</body>

</html>
