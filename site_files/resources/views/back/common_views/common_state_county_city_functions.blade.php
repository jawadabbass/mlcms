<script>
    $(document).ready(function() {
        $('.select2').select2();
        $('.select2').css('width', '100%');
    });

    function searchZipCodeAjax(firstEmpty = true) {
        let zipcode = 0;
        if ($('#zipcode').length > 0) {
            zipcode = $('#zipcode').val();
        }
        if ($('#shipping_zipcode').length > 0) {
            zipcode = $('#shipping_zipcode').val();
        }

        let url = '{{ url('searchZipCodeAjax/') }}';
        $.post(url, {
                zipcode: zipcode,
                firstEmpty: firstEmpty,
                _token: '{{ csrf_token() }}'
            })
            .done(function(response) {
                console.log(response);
                response = JSON.parse(response);
                if (response.stateDD != '') {
                    let stateStr =
                        '<label>State:*</label><select class="form-control select2" name="state_id" id="state_id" onchange="filterCitiesAjax();">' +
                        response.stateDD + '</select>';
                    $('#states_dd_div').html(stateStr);
                }

                if (response.cityDD != '') {
                    let cityStr =
                        '<label>City:*</label><select class="form-control select2" name="city_id" id="city_id">' +
                        response.cityDD + '</select>';
                    $('#cities_dd_div').html(cityStr);
                }

                $('.select2').select2();
                $('.select2').css('width', '100%');
            });
    }

    function filterCitiesAjax(firstEmpty = true) {
        let state_id = 0;
        if ($('#state_id').length > 0) {
            state_id = $('#state_id').val();
        }

        let url = '{{ url('filterCitiesAjax/') }}';
        $.post(url, {
                state_id: state_id,
                firstEmpty: firstEmpty,
                _token: '{{ csrf_token() }}'
            })
            .done(function(response) {
                let str = '<select class="form-control select2" name="city_id" id="city_id">' +
                    response + '</select>';
                $('#cities_dd_div').html(str);
                $('.select2').select2();
                $('.select2').css('width', '100%');
            });
    }
</script>