<script type="text/javascript">
function delete_product(id) {
        $('.message-container').fadeOut(3000);
        if (confirm('Are you sure delete this data?')) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('delete_assesment_question', '') }}" + "/" + id,
                type: "get",
                success: function (data) {
                    //if success reload ajax table
                    location.reload();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error adding / update data');
                }
            });
        }
    }


    $(function () {
        $('#sortable').sortable({
            axis: 'y',
            opacity: 0.7,
            handle: 'span',
            update: function (event, ui) {
                var list_sortable = $(this).sortable('toArray').toString();
                // change order in the database using Ajax
                console.log(list_sortable);
                $.ajax({
                    url: base_url + 'adminmedia/assesment_question/create',
                    type: 'GET',
                    data: {list_order: list_sortable},
                    success: function (data) {
                        //finished
                        console.log(data);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert('Error adding / update data');
                        console.log(jqXHR);
                        console.log(textStatus);
                        console.log(errorThrown);
                    }
                });
            }
        }); // fin sortable
    });
    function update_product_sts(id) {
        var current_status = $("#sts_" + id + " div").html();
        console.log(current_status);
        var myurl = base_url + 'adminmedia/assesment_question/' + id + '?status=' + current_status;
        $.get(myurl, function (sts) {
            var class_label = 'success';
            if (sts != 'active')
                var class_label = 'danger';
            $("#sts_" + id).html('<div class="label label-' + class_label + '">' + sts + '</div>');
        });
    }
</script>
