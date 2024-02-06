$(document).ready(function () {
    bind_filer();
    var success = true;

    function bind_filer() {
        $('#fea_img').find('#file-field').html('<input type="file"  name="module_img" id="module_img" class="form-control"><div id="attached_files_div"></div>');
        $("#module_img").filer({
            limit: 1,
            maxSize: maxSize,
            extensions: ['gif', 'jpg', 'png', 'jpeg','svg'],
            showThumbs: true,
            templates: {
                box: '<ul class="jFiler-items-list jFiler-items-grid"></ul>',
                item: '<li class="jFiler-item">\
                <div class="jFiler-item-container">\
                        <div class="jFiler-item-inner">\
                                <div class="jFiler-item-thumb">\
                                        <div class="jFiler-item-status"></div>\
                                        <div class="jFiler-item-thumb-overlay">\
                                                <div class="jFiler-item-info">\
                                                        <div style="display:table-cell;vertical-align: middle;">\
                                                                <span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name}}</b></span>\
                                                                <span class="jFiler-item-others">{{fi-size2}}</span>\
                                                        </div>\
                                                </div>\
                                        </div>\
                                        {{fi-image}}\
                                </div>\
                                <div class="jFiler-item-assets jFiler-row">\
                                        <ul class="list-inline pull-left">\
                                                <li>{{fi-progressBar}}</li>\
                                        </ul>\
                                        <ul class="list-inline pull-right">\
                                                <li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
                                        </ul>\
                                </div>\
                        </div>\
                </div>\
        </li>',
                itemAppend: '<li class="jFiler-item">\
                        <div class="jFiler-item-container">\
                                <div class="jFiler-item-inner">\
                                        <div class="jFiler-item-thumb">\
                                                <div class="jFiler-item-status"></div>\
                                                <div class="jFiler-item-thumb-overlay">\
                                                        <div class="jFiler-item-info">\
                                                                <div style="display:table-cell;vertical-align: middle;">\
                                                                        <span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name}}</b></span>\
                                                                        <span class="jFiler-item-others">{{fi-size2}}</span>\
                                                                </div>\
                                                        </div>\
                                                </div>\
                                                {{fi-image}}\
                                        </div>\
                                        <div class="jFiler-item-assets jFiler-row">\
                                                <ul class="list-inline pull-left">\
                                                        <li><span class="jFiler-item-others">{{fi-icon}}</span></li>\
                                                </ul>\
                                                <ul class="list-inline pull-right">\
                                                        <li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
                                                </ul>\
                                        </div>\
                                </div>\
                        </div>\
                </li>',
                progressBar: '<div class="bar"></div>',
                itemAppendToEnd: false,
                canvasImage: true,
                removeConfirmation: true,
                _selectors: {
                    list: '.jFiler-items-list',
                    item: '.jFiler-item',
                    progressBar: '.bar',
                    remove: '.jFiler-item-trash-action'
                }
            },
            dragDrop: {
                dragEnter: null,
                dragLeave: null,
                drop: null,
                dragContainer: null,
            },
            uploadFile: {
                url: uploadUrl,
                data: {folder: folder, 'X-CSRF-TOKEN': csrfToken,'_token': csrfToken},
                type: 'POST',
                enctype: 'multipart/form-data',
                synchron: true,
                beforeSend: function () {},
                success: function (data, el, itemEl, listEl, boxEl, newInputEl, inputEl, id) {
                    console.log("Success = " + data);
                    if (data === "error") {
                        success = false;
                        var parent = el.find(".jFiler-jProgressBar").parent();
                        el.find(".jFiler-jProgressBar").fadeOut("slow", function () {
                            $("<div class=\"jFiler-item-others text-error\"><i class=\"icon-jfi-minus-circle\"></i>Error: Image Size is too big</div>").hide().appendTo(parent).fadeIn("slow");
                        });
                        $('#btnSave').attr('disabled', false);
                    }else {
                        success = true;
                        $('#attached_files_div').append('<input type="hidden" class="uploaded-pictures" id="featured_img" name="featured_img" value="' + data + '" />');
                        $('#source_image').val(data);
                        $('#large_image').html('<img id="image" src="' + asset_uploads + folder + '/' + data + '" alt="Crop Picture">');

                        var parent = el.find(".jFiler-jProgressBar").parent();
                        el.find(".jFiler-jProgressBar").fadeOut("slow", function () {
                            $("<div class=\"jFiler-item-others text-success\"><i class=\"icon-jfi-minus-circle\"></i> Success</div>").hide().appendTo(parent).fadeIn("slow");
                        });
                        $('#btnSave').attr('disabled', false);
                        if (show_cropper) {
                            $('#cropper_form').modal('show');
                            bind_cropper_preview();
                        }
                    }
                },
                error: function (data,el) {
                    success = false;
                    var parent = el.find(".jFiler-jProgressBar").parent();
                    el.find(".jFiler-jProgressBar").fadeOut("slow", function () {
                        $("<div class=\"jFiler-item-others text-error\"><i class=\"icon-jfi-minus-circle\"></i> Error</div>").hide().appendTo(parent).fadeIn("slow");
                    });
                    $('#btnSave').attr('disabled', false);
                },
                statusCode: null,
                onProgress: null,
                onComplete: null
            },
            files: null,
            addMore: false,
            allowDuplicates: true,
            clipBoardPaste: true,
            excludeName: null,
            beforeRender: null,
            afterRender: null,
            beforeShow: null,
            beforeSelect: null,
            onSelect: null,
            afterShow: null,
            onRemove: function (itemEl, file, id, listEl, boxEl, newInputEl, inputEl) {
                delete_pic($('#featured_img').val(),success);
            },
            onEmpty: null,
            options: null,
            dialogs: {
                alert: function (text) {
                    return alert(text);
                },
                confirm: function (text, callback) {
                    confirm(text) ? callback() : null;
                }
            },
            captions: {
                button: "Choose File",
                feedback: "Choose file To Upload",
                feedback2: "files were chosen",
                drop: "Drop file here to Upload",
                removeConfirmation: "Are you sure you want to remove this file?",
                errors: {
                    filesLimit: "Only on file is allowed to be uploaded.",
                    filesType: "Only Images are allowed to be uploaded.",
                    filesSize: " is too large! Please upload file up to " + maxSize + "  MB.",
                    filesSizeAll: "Files you've choosed are too large! Please upload files up to  MB."
                }
            }
        });
    }
});

function delete_pic(file_name, success,obj) {
    if (success) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post(deleteUrl, {
            file_name: file_name,
            folder: folder
        });
    }
    $('.uploaded-pictures').each(function () {
        if ($(this).val() === file_name) {
            $(this).remove();
        }
    });
    $(obj).closest('li').hide('slow', function () {
        $(obj).closest('li').remove();
    });
}
