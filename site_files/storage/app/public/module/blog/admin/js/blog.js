function update_unrevised_comment_status(id) {
    var current_status = $("#sts_" + id + " span").html();
    var myurl = base_url + 'adminmedia/blog/create?id=' + id + '&&status=' + current_status;
    console.log(myurl);
    $.get(myurl, function (sts) {
        var class_label = 'success';
        if (sts != 'reviewed')
            var class_label = 'danger';
        $("#sts_" + id).html('<span class="label label-' + class_label + '">' + sts + '</span>');
    });
}

function delete_blog_comments(id) {
    var myurl = base_url + 'adminmedia/blog_comments?id=' + id;
    var is_confirm = confirm("Are you sure you want to delete this Comment?");
    if (is_confirm) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post(myurl, function (sts) {
            console.log(sts);
            if (sts == 'done')
                $("#row_" + id).fadeOut();
            else
                alert('OOps! Something went wrong.');
        });
    }

}