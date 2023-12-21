function confirmDel() {
	if (confirm("Are you sure you want to delete?")) {
		return true;
	}
	else {
		return false;
	}
}

function confirmMsg(msg) {
	if (confirm(msg)) {
		return true;
	}
	else {
		return false;
	}
}

function limit_text(idd, text_max, limitid) {
	$('#' + limitid).html(text_max + ' characters remaining');
	var strr = $('#' + idd).val();
	var text_length = $('#' + idd).val().length;
	var text_remaining = text_max - text_length;
	if (text_remaining > 0) {
		$('#' + limitid).html(text_remaining + ' characters remaining');
	}
	else {
		var res = strr.substring(0, text_max);
		$('#' + idd).val(res);
		$('#' + limitid).html('0 characters remaining');
	}
}

function OnlyNumber(evt, error_div) {
	if (error_div != '') {
		document.getElementById(error_div).innerHTML = "";
	}
	var ctrl = (document.all) ? event.ctrlKey : evt.ctrlKey;
	var charCode = (evt.which) ? evt.which : event.keyCode;
	//For Paste
	if (ctrl && (charCode == 86 || charCode == 118)) {
		if (error_div != '') {
			document.getElementById(error_div).innerHTML = "Only Interger Allowed";
		}
		return false;
	}
	//For Numerics
	if (charCode == 8 || (charCode < 58 && charCode > 47))
		return true;
	if (error_div != '') {
		document.getElementById(error_div).innerHTML = "Only Interger Allowed";
	}
	return false;
}
function next(Val, Field) {
	Len = Val.length;
	if (Len > 1 && Field == 'ssn3') {
		document.getElementById(Field).focus();
		document.getElementById(Field).focus()
	}
	if (Len > 2) {
		document.getElementById(Field).focus();
		document.getElementById(Field).focus()
	}
}
function loadprocess(thisobj) {
	$(thisobj).hide();
	$(thisobj).after('<span><img alt="Processing..." src="' + asset_storage + 'images/common/loader.gif"></span>');
}
/*   New Functions from Module JS */
function additional_fields(field_value) {
	for (var count = 1; count <= 8; count++) {
		$("#field" + count).hide();
	}
	for (var count = 1; count <= field_value; count++) {
		$("#field" + count).show();
	}
}
function string_to_product_slug(titleId, slugId) {
	var str = $('[name="' + titleId + '"]').val();
	var eventSlug = $('[name="' + slugId + '"]').val();
	if (eventSlug.length == "") {
		str = str.replace(/^\s+|\s+$/g, ''); // trim
		str = str.toLowerCase();
		// remove accents, swap ñ for n, etc
		var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
		var to = "aaaaeeeeiiiioooouuuunc------";
		for (var i = 0, l = from.length; i < l; i++) {
			str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
		}
		str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
			.replace(/\s+/g, '-') // collapse whitespace and replace by -
			.replace(/-+/g, '-'); // collapse dashes
		//return str;
		$('[name="' + slugId + '"]').val(str);
	}
}
function reset_model() {
	$('#form')[0].reset(); // reset form on modals
	$('.err').html('');
	$('.message-container').fadeOut(3000);
	$('#product_img_div').hide();
	$('#modal_form').modal('show'); // show bootstrap modal
	$('#seo-edit-modul').removeClass('seo-edit-modul-sow').addClass('seo-edit-modul-hide');
	bind_filer();
}
function reload_table() {
	table.ajax.reload(null, false); //reload datatable ajax
}