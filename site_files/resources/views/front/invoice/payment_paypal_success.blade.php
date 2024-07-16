@extends('front.layout.app')
@section('beforeHeadClose')
@endsection
@section('content')
    @php $settingArr = settingArr(); @endphp
    {!! cms_page_heading('Pay') !!}
    <div class="innerpagewrap">
        <div class="container">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa fa-check" aria-hidden="true"></i> Thank you for your payment. Your transaction has been
                completed.
            </div>
        </div>
    </div>
@endsection
@section('beforeBodyClose')
    <script src="{{ asset_storage('lib/sweetalert/sweetalert2.js') }}"></script>
    <script src="https://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
    <script>
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
                            // $('#msgSuccess').text(data.error);
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
@endsection
