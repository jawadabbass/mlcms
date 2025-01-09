<div class="modal fade" id="leadStatUrlEditModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit URL</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="leadStatUrlEditModalBody"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    function loadEditLeadStatUrlModal(id) {
        var url = '{{ url('adminmedia/loadEditLeadStatUrlModal/') }}';
        var request = $.ajax({
            url: url,
            method: "POST",
            data: {
                id: id,
                _token: '{{ csrf_token() }}'
            },
            dataType: "json"
        });
        request.done(function(response) {
            $('#leadStatUrlEditModalBody').html(response.html);
            $('#leadStatUrlEditModal').modal('show');
        });
        request.fail(function(jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });
    }

    function updateLeadStatUrl(id) {
        var url = "{{ route('updateLeadStatUrl') }}";
        var form = $('#updateLeadStatUrlFrm');
        form = form[0];
        var formData = new FormData(form);
        for (const [key, value] of formData) {
            console.log(`${key}: ${value}`);
        }
        var request = $.ajax({
            url: url,
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json"
        });
        request.done(function(response) {
            $('#leadStatUrlEditModalBody').html(response.html);
            if (response.closeModal == 'y') {
                setTimeout(() => {
                    $('#leadStatUrlEditModal').modal('hide');
                }, 1000);
            }
            if ($('#leadStatUrlDatatableAjax').length > 0) {
                var table = $('#leadStatUrlDatatableAjax').DataTable();
                table.row('leadStatUrlDtRow' + id).remove().draw(false);
            }
        });
        request.fail(function(jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });
    }

    function adjust_URL_Keyword(val) {
        var REF_URL = '{{ config('Constants.REF_URL') }}';
        var url_internal = `
        <div class="row">
            <div class="col-md-12">
                <label class="form-label">URL:*</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            ${REF_URL}
                        </span>
                    </div>
                    <input id="url" name="url" value="" type="text"
                        class="form-control" placeholder="URL" aria-describedby="url">
                </div>
            </div>
            <div class="col-md-12">
                <label class="form-label">Final Destination:*</label>
                    <input id="final_destination" name="final_destination" value="" type="text"
                        class="form-control" placeholder="Final Destination" aria-describedby="final_destination">
            </div>
        </div>`;
        var url_external = `<label class="form-label">Keyword:*</label>
            <input id="url" name="url" value="" type="text"
                class="form-control " placeholder="Keyword" aria-describedby="url">
        `;
        var url_keyword = $("#url").val();
        if (val == 'internal') {
            $('#url_div').html(url_internal);
        } else {
            $('#url_div').html(url_external);
        }
        $("#url").val(url_keyword);
    }
</script>
