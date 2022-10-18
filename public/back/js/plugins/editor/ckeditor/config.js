/**
 * @license Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function (config) {
    // Define changes to default configuration here. For example:
    // config.language = 'fr';
    // config.uiColor = '#AADC6E';

    config.toolbar = 'MyToolbar';

    config.toolbarGroups = [
        {name: 'document', groups: ['mode', 'document', 'doctools']},
        {name: 'clipboard', groups: ['clipboard', 'undo']},
        {name: 'editing', groups: ['find', 'selection', 'spellchecker', 'editing']},
        {name: 'forms', groups: ['forms']},
        {name: 'basicstyles', groups: ['basicstyles', 'cleanup']},
        {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi', 'paragraph']},
        {name: 'links', groups: ['links']},
        {name: 'insert', groups: ['insert']},
        {name: 'styles', groups: ['styles']},
        {name: 'colors', groups: ['colors']},
        {name: 'tools', groups: ['tools']},
        {name: 'others', groups: ['others']},
    ];

    config.removeButtons = 'Form,Radio,Checkbox,TextField,Textarea,Select,Button,ImageButton,HiddenField,Language,Flash';

    // config.toolbar_MyToolbar =
    //     [
    //         ['Source', '-', 'NewPage', 'Preview', '-', 'Templates', 'Maximize'],
    //         ['Cut', 'Copy', 'Paste', 'SpellChecker', '-', 'Scayt'],
    //         ['Undo', 'Redo', '-', 'Find', 'Replace'],
    //         ['Image', 'Table', 'HorizontalRule', 'SpecialChar', 'PageBreak'],
    //         '/',
    //         ['Bold', 'Italic', 'Underline', 'Strike', '-', 'Subscript', 'Superscript'],
    //         ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', 'Blockquote', 'SelectAll', 'RemoveFormat'],
    //         ['Link', 'Unlink', 'Anchor'],
    //         ['Styles', 'Format', 'Font', 'FontSize'],
    //         ['TextColor', 'BGColor']
    //     ];

    config.filebrowserBrowseUrl = base_url + 'adminmedia/file_manager';
    config.filebrowserImageBrowseUrl = base_url + 'adminmedia/file_manager?type=Images';
    config.filebrowserFlashBrowseUrl = base_url + 'adminmedia/file_manager?type=Flash';
    config.filebrowserUploadUrl = base_url + 'back/js/plugins/editor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
    config.filebrowserImageUploadUrl = base_url + 'back/js/plugins/editor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
    config.filebrowserFlashUploadUrl = base_url + 'back/js/plugins/editor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
};
