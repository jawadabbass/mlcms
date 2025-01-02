const tinymce_image_upload_handler = (blobInfo, progress) => new Promise((resolve, reject) => {
    const xhr = new XMLHttpRequest();
    xhr.withCredentials = false;
    xhr.open('POST', uploadTinyMceImage);
    xhr.upload.onprogress = (e) => {
        progress(e.loaded / e.total * 100);
    };
    xhr.onload = () => {
        if (xhr.status === 403) {
            reject({
                message: 'HTTP Error: ' + xhr.status,
                remove: true
            });
            return;
        }
        if (xhr.status < 200 || xhr.status >= 300) {
            reject('HTTP Error: ' + xhr.status);
            return;
        }
        const json = JSON.parse(xhr.responseText);
        if (!json || typeof json.location != 'string') {
            reject('Invalid JSON: ' + xhr.responseText);
            return;
        }
        resolve(json.location);
    };
    xhr.onerror = () => {
        reject('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
    };
    formData = new FormData();
    formData.append('image', blobInfo.blob(), blobInfo.filename());
    formData.append('_token', csrf_token);
    xhr.send(formData);
});

function initCKeditor(selector){
    tinymce.init({
        selector: selector,
        force_br_newlines: true,
        images_upload_url: uploadTinyMceImage,
        images_upload_handler: tinymce_image_upload_handler,
        content_css: tinymce_front_css_file,
        relative_urls: false,
        remove_script_host: false,
        document_base_url: base_url,
        menubar: false,
        plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons accordion autoresize',
        toolbar: "undo redo | fontfamily fontsize | bold italic underline strikethrough | align numlist bullist | link image | table media | lineheight outdent indent| forecolor backcolor removeformat | charmap emoticons | code fullscreen preview | save print | pagebreak anchor codesample | ltr rtl | accordion accordionremove | blocks",
        image_advtab: true,
        importcss_append: true,
        min_height: 300,
        max_height: 500
    });
}
function bindCKeditorByClass(cls) {
    var selector = '.'+cls;
    initCKeditor(selector);
}
function bindCKeditor(id) {
    var selector = '#'+id;
    initCKeditor(selector);
}
function insertIntoCkeditor(editor, str) {
    tinyMCE.get(editor).execCommand('mceInsertContent', false, str);
}
function insertImageIntoCkeditor(editor, str) {
    tinyMCE.get(editor).execCommand('mceInsertContent', false, '<img src="' + str + '">');
}
$(function () {
    if ($('#edit_editor1').length) {
        bindCKeditor('edit_editor1');
    }
    if ($('#editor1').length) {
        bindCKeditor('editor1');
    }
    if ($('#user_body').length) {
        bindCKeditor('user_body');
    }
    if ($('#details').length) {
        bindCKeditor('details');
    }
    if ($('#web_down_msg').length) {
        bindCKeditor('web_down_msg');
    }
    if ($('#description').length) {
        bindCKeditor('description');
    }
    if ($('#body').length) {
        bindCKeditor('body');
    }
    if ($('#text_content').length) {
        bindCKeditor('text_content');
    }
    if ($('#edit_content').length) {
        bindCKeditor('edit_content');
    }
});