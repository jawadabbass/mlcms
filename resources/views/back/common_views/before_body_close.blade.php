<script src="{{ asset('back/js/jquery.min.js') }}"></script>
<script src="{{ asset('back/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('back/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('back/js/js/effects.js') }}"></script>
<script type="text/javascript" src="{{ asset('back/js/js/popupjs.js') }}"></script>
<script type="text/javascript" src="{{ asset('back/js/js/get_auto.js') }}"></script>
<script src="{{ asset('back/fontawesome-iconpicker/dist/js/fontawesome-iconpicker.min.js') }}"></script>
<script src="{{ asset('back/js/plugins/timepicker/bootstrap-timepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('back/js/functions.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('back/js/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('module/module/admin/filer/js/jquery.filer.min.js') }}"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/super-build/ckeditor.js"></script>
<script src="{{ asset('back/js/admin_functions.js?v=22') }}" type="text/javascript"></script>
<script src="{{ asset('select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('back/datetimepicker/build/jquery.datetimepicker.full.min.js') }}" type="text/javascript">
</script>
<script src="{{ asset('back/js/AdminLTE/dist/js/adminlte.min.js') }}"></script>
@include('back.common_views.common_state_county_city_functions')
<script>
    $('#selected_image').on('change', function(event) {
        var selected_image_preview = document.getElementById('selected_image_preview');
        selected_image_preview.src = URL.createObjectURL(event.target.files[0]);
    });
    $('#selected_layout_image').on('change', function(event) {
        var selected_layout_image_preview = document.getElementById('selected_layout_image_preview');
        selected_layout_image_preview.src = URL.createObjectURL(event.target.files[0]);
    });
    $('#selected_images').on('change', function(event) {
        $('#selected_images_preview').html('');
        for (let index = 0; index < event.target.files.length; index++) {
            const src = URL.createObjectURL(event.target.files[index]);
            $('#selected_images_preview').append(
                '<div class="col-2 m-1"><img style="border-radius: 0px;" src="' + src +
                '" /></div>');
        }
    });

    function loadStorage() {
        console.log("Load Getting Executed");
        var preference = localStorage.getItem('collapsed');
        if (1 == preference) {
            $('.left-side').toggleClass("collapse-left");
            $(".right-side").toggleClass("strech");
        }
    }
</script>
<script>
    $(function() {
        $('.icp-auto').on('click', function() {
            $('.icp-auto').iconpicker();
        }).trigger('click');
    });
    $(function() {
        $('.iconpicker-item').on('click', function() {
            //alert("test" );
            $('.iconpicker-popover').hide();
        });
    });
</script>
<script>
    $(document).on('focusin', function(e) {
        if ($(e.target).closest(".mce-window").length) {
            e.stopImmediatePropagation();
        }
    });
    $(document).ready(function() {
        $('.img_alt_title_label').on('click', function(e) {
            $(this).siblings('div').toggle();
        });
    });

    function alertme(text, type, autoClose, closeAfterSec) {
        var type = type || 'success';
        var autoClose = autoClose || true;
        var closeAfterSec = closeAfterSec || 3000;
        $(".alertme").hide();
        var mhtml =
            '<div class="alertme" id="div_alert" style="margin:5px;top:3%;position:fixed;z-index:9999;width:100%">' +
            '<div style="max-width: 700px;margin: 0 auto;" class="alert alert-' + type +
            ' alert-dismissible"> <button type="button" class="btn-close" data-bs-dismiss="alert"></button> ' + text +
            '</div></div>';
        $("body").append(mhtml);
        if (autoClose) {
            setTimeout(function() {
                $(".alertme").hide();
            }, closeAfterSec);
        }
    }
</script>
<script>
    const ckeditors = {};
    class MyUploadAdapter {
        constructor(loader) {
            // The file loader instance to use during the upload. It sounds scary but do not
            // worry — the loader will be passed into the adapter later on in this guide.
            this.loader = loader;
        }
        // Starts the upload process.
        upload() {
            return this.loader.file
                .then(file => new Promise((resolve, reject) => {
                    this._initRequest();
                    this._initListeners(resolve, reject, file);
                    this._sendRequest(file);
                }));
        }
        // Aborts the upload process.
        abort() {
            if (this.xhr) {
                this.xhr.abort();
            }
        }
        // Initializes the XMLHttpRequest object using the URL passed to the constructor.
        _initRequest() {
            const xhr = this.xhr = new XMLHttpRequest();
            // Note that your request may look different. It is up to you and your editor
            // integration to choose the right communication channel. This example uses
            // a POST request with JSON as a data structure but your configuration
            // could be different.
            xhr.open('POST', '{{ route('uploadCkeditorImage') }}', true);
            xhr.setRequestHeader('x-csrf-token', '{{ csrf_token() }}');
            xhr.responseType = 'json';
        }
        // Initializes XMLHttpRequest listeners.
        _initListeners(resolve, reject, file) {
            const xhr = this.xhr;
            const loader = this.loader;
            const genericErrorText = `Couldn't upload file: ${ file.name }.`;
            xhr.addEventListener('error', () => reject(genericErrorText));
            xhr.addEventListener('abort', () => reject());
            xhr.addEventListener('load', () => {
                const response = xhr.response;
                // This example assumes the XHR server's "response" object will come with
                // an "error" which has its own "message" that can be passed to reject()
                // in the upload promise.
                //
                // Your integration may handle upload errors in a different way so make sure
                // it is done properly. The reject() function must be called when the upload fails.
                if (!response || response.error) {
                    return reject(response && response.error ? response.error.message : genericErrorText);
                }
                // If the upload is successful, resolve the upload promise with an object containing
                // at least the "default" URL, pointing to the image on the server.
                // This URL will be used to display the image in the content. Learn more in the
                // UploadAdapter#upload documentation.
                resolve({
                    default: response.url
                });
            });
            // Upload progress when it is supported. The file loader has the #uploadTotal and #uploaded
            // properties which are used e.g. to display the upload progress bar in the editor
            // user interface.
            if (xhr.upload) {
                xhr.upload.addEventListener('progress', evt => {
                    if (evt.lengthComputable) {
                        loader.uploadTotal = evt.total;
                        loader.uploaded = evt.loaded;
                    }
                });
            }
        }
        // Prepares the data and sends the request.
        _sendRequest(file) {
            // Prepare the form data.
            const data = new FormData();
            data.append('image', file);
            data.append('_token', '{{ csrf_token() }}');
            this.xhr.send(data);
        }
        // ...
    }

    function SimpleUploadAdapterPlugin(editor) {
        editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
            // Configure the URL to the upload script in your back-end here!
            return new MyUploadAdapter(loader);
        };
    }

    function bindCKeditor(id) {
        // This sample still does not showcase all CKEditor 5 features (!)
        // Visit https://ckeditor.com/docs/ckeditor5/latest/features/index.html to browse all the features.
        CKEDITOR.ClassicEditor.create(document.getElementById(id), {
                // https://ckeditor.com/docs/ckeditor5/latest/features/toolbar/toolbar.html#extended-toolbar-configuration-format
                toolbar: {
                    items: [
                        'findAndReplace', 'selectAll', '|',
                        'heading', '|',
                        'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript',
                        'removeFormat', '|',
                        'bulletedList', 'numberedList', 'todoList', '|',
                        'outdent', 'indent', '|',
                        'undo', 'redo',
                        '-',
                        'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                        'alignment', '|',
                        'link', 'insertImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock',
                        //'htmlEmbed', '|',
                        'specialCharacters', 'horizontalLine', 'pageBreak', '|',
                        'textPartLanguage', '|',
                        'sourceEditing'
                    ],
                    shouldNotGroupWhenFull: true
                },
                // Changing the language of the interface requires loading the language file using the <script> tag.
                // language: 'es',
                list: {
                    properties: {
                        styles: true,
                        startIndex: true,
                        reversed: true
                    }
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/headings.html#configuration
                heading: {
                    options: [{
                            model: 'paragraph',
                            title: 'Paragraph',
                            class: 'ck-heading_paragraph'
                        },
                        {
                            model: 'heading1',
                            view: 'h1',
                            title: 'Heading 1',
                            class: 'ck-heading_heading1'
                        },
                        {
                            model: 'heading2',
                            view: 'h2',
                            title: 'Heading 2',
                            class: 'ck-heading_heading2'
                        },
                        {
                            model: 'heading3',
                            view: 'h3',
                            title: 'Heading 3',
                            class: 'ck-heading_heading3'
                        },
                        {
                            model: 'heading4',
                            view: 'h4',
                            title: 'Heading 4',
                            class: 'ck-heading_heading4'
                        },
                        {
                            model: 'heading5',
                            view: 'h5',
                            title: 'Heading 5',
                            class: 'ck-heading_heading5'
                        },
                        {
                            model: 'heading6',
                            view: 'h6',
                            title: 'Heading 6',
                            class: 'ck-heading_heading6'
                        }
                    ]
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/editor-placeholder.html#using-the-editor-configuration
                placeholder: '',
                // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-family-feature
                fontFamily: {
                    options: [
                        'default',
                        'Arial, Helvetica, sans-serif',
                        'Courier New, Courier, monospace',
                        'Georgia, serif',
                        'Lucida Sans Unicode, Lucida Grande, sans-serif',
                        'Tahoma, Geneva, sans-serif',
                        'Times New Roman, Times, serif',
                        'Trebuchet MS, Helvetica, sans-serif',
                        'Verdana, Geneva, sans-serif'
                    ],
                    supportAllValues: true
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-size-feature
                fontSize: {
                    options: [10, 12, 14, 'default', 18, 20, 22],
                    supportAllValues: true
                },
                // Be careful with the setting below. It instructs CKEditor to accept ALL HTML markup.
                // https://ckeditor.com/docs/ckeditor5/latest/features/general-html-support.html#enabling-all-html-features
                htmlSupport: {
                    allow: [{
                        name: /.*/,
                        attributes: true,
                        classes: true,
                        styles: true
                    }]
                },
                // Be careful with enabling previews
                // https://ckeditor.com/docs/ckeditor5/latest/features/html-embed.html#content-previews
                htmlEmbed: {
                    showPreviews: true,
                    /* sanitizeHtml: (inputHtml) => {
                        // Strip unsafe elements and attributes, e.g.:
                        // the `<script>` elements and `on*` attributes.
                        const outputHtml = sanitize(inputHtml);

                        return {
                            html: outputHtml,
                            // true or false depending on whether the sanitizer stripped anything.
                            hasChanged: true
                        };
                    } */
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/link.html#custom-link-attributes-decorators
                link: {
                    decorators: {
                        addTargetToExternalLinks: true,
                        defaultProtocol: 'https://',
                        toggleDownloadable: {
                            mode: 'manual',
                            label: 'Downloadable',
                            attributes: {
                                download: 'file'
                            }
                        }
                    }
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/mentions.html#configuration
                mention: {
                    feeds: [{
                        marker: '@',
                        feed: [
                            '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes',
                            '@chocolate', '@cookie', '@cotton', '@cream',
                            '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread',
                            '@gummi', '@ice', '@jelly-o',
                            '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding',
                            '@sesame', '@snaps', '@soufflé',
                            '@sugar', '@sweet', '@topping', '@wafer'
                        ],
                        minimumCharacters: 1
                    }]
                },
                // The "super-build" contains more premium features that require additional configuration, disable them below.
                // Do not turn them on unless you read the documentation and know how to configure them and setup the editor.
                removePlugins: [
                    // These two are commercial, but you can try them out without registering to a trial.
                    'ExportPdf',
                    'ExportWord',
                    'CKBox',
                    'CKFinder',
                    'EasyImage',
                    // This sample uses the Base64UploadAdapter to handle image uploads as it requires no configuration.
                    // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/base64-upload-adapter.html
                    // Storing images as Base64 is usually a very bad idea.
                    // Replace it on production website with other solutions:
                    // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/image-upload.html
                    'Base64UploadAdapter',
                    'RealTimeCollaborativeComments',
                    'RealTimeCollaborativeTrackChanges',
                    'RealTimeCollaborativeRevisionHistory',
                    'PresenceList',
                    'Comments',
                    'TrackChanges',
                    'TrackChangesData',
                    'RevisionHistory',
                    'Pagination',
                    'WProofreader',
                    // Careful, with the Mathtype plugin CKEditor will not load when loading this sample
                    // from a local file system (file://) - load this site via HTTP server if you enable MathType
                    'MathType'
                ],
                extraPlugins: [SimpleUploadAdapterPlugin]
            })
            .then(editor => {
                ckeditors[id] = editor;
                // Simulate label behavior if textarea had a label
                if (editor.sourceElement.labels.length > 0) {
                    editor.sourceElement.labels[0].addEventListener('click', e => editor.editing.view.focus());
                }

                /*
                editor.editing.view.document.on(
                    'enter',
                    (evt, data) => {
                        editor.execute('shiftEnter');
                        //Cancel existing event
                        data.preventDefault();
                        evt.stop();
                    }, {
                        priority: 'high'
                    });
                */
            })
            .catch(err => console.error(err.stack));
    }

    function insertIntoCkeditor(editor, str) {
        ckeditors[editor].model.change(writer => {
            const insertPosition = ckeditors[editor].model.document.selection.getFirstPosition();
            writer.insertText(str, insertPosition);
        });
    }

    function insertImageIntoCkeditor(editor, str) {
        ckeditors[editor].execute('insertImage', {
            source: str
        });
    }

    function insertIntoTextArea(str) {
        insertAtCaret('Body', str);
    }

    function insertAtCaret(areaId, text) {
        var txtarea = document.getElementById(areaId);
        var scrollPos = txtarea.scrollTop;
        var strPos = 0;
        var br = ((txtarea.selectionStart || txtarea.selectionStart == '0') ?
            "ff" : (document.selection ? "ie" : false));
        if (br == "ie") {
            txtarea.focus();
            var range = document.selection.createRange();
            range.moveStart('character', -txtarea.value.length);
            strPos = range.text.length;
        } else if (br == "ff") strPos = txtarea.selectionStart;
        var front = (txtarea.value).substring(0, strPos);
        var back = (txtarea.value).substring(strPos, txtarea.value.length);
        txtarea.value = front + text + back;
        strPos = strPos + text.length;
        if (br == "ie") {
            txtarea.focus();
            var range = document.selection.createRange();
            range.moveStart('character', -txtarea.value.length);
            range.moveStart('character', strPos);
            range.moveEnd('character', 0);
            range.select();
        } else if (br == "ff") {
            txtarea.selectionStart = strPos;
            txtarea.selectionEnd = strPos;
            txtarea.focus();
        }
        txtarea.scrollTop = scrollPos;
    }
    $(function() {
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
        if ($('#fleet_plane_details').length) {
            bindCKeditor('fleet_plane_details');
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

    function uploaded_files_show() {
        $('#image_preview').html("");
        var total_file = document.getElementById("uploadFile").files.length;
        for (var i = 0; i < total_file; i++) {
            $('#image_preview').append("<div class=\"col-md-1\"><img src='" + URL.createObjectURL(event.target.files[
                i]) + "'></div>");
        }
    }
</script>
