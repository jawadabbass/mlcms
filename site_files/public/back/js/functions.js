
$(document).on('click', '.delete_row_div', function(){
	$(this).parent('div').parent('div').remove();
});




$(document).ready(function(e) {
	$('#send_test_email').click(function(e){
		var subject=$("#subject").val();
		var sender_name=$("#sender_name").val();
		var test_email=$("#test_email").val();
		var sender_email=$("#sender_email").val();
		var path=$("#path").val();
		var editor1= tinyMCE.get('editor1').getContent(); 
		$('#form_body').val(editor1);
		editor1 = editor1.replace(/&nbsp;/g, ' ');
		
		$("#returnmsg").text('Loading...');
		var dataString = 'subject='+subject+'&test_email='+test_email+'&sender_name='+sender_name+'&sender_email='+sender_email+'&body='+editor1;
		$.ajax({
			type: "POST",
			url: path,
			data: $('#email_form').serialize(),
			cache: false,
			success: function(html){
				$("#returnmsg").text(html);
				function explode(){
					$("#returnmsg").text('');
					$("#returnmsg").hide();
				}
				setTimeout(explode, 5000);
				
			}
			});
			
	});




});



function show_this(idd){
	
		$('#'+idd).show();
}

function show_hide(divv,true_false){
	alert('great');
	if(true_false){
		$(divv).show()
	}
	else{
		$(divv).hide()	
	}

}
$(document).ready(function(e) {
    
	//you have to use keyup, because keydown will not catch the currently entered value
	$('.user_pass').keyup(function() {
		validate_pass_strength();
	}).focus(function() {
		validate_pass_strength();
		$('#pswd_info').show();
	}).change(function() {
		validate_pass_strength();
		$('#pswd_info').show();
	}).blur(function() {
		$('#pswd_info').hide();
	});
	$('.user_pass2').keyup(function() {
		match_password();
	}).focus(function() {
		match_password();
		$('#pswd_info2').show();
	}).change(function() {
		validate_pass_strength();
		$('#pswd_info2').show();
	}).blur(function() {
		$('#pswd_info2').hide();
	});
	
	
	//Date Picker

	if($('.mldate').hasClass('mldate')){
	$('.mldate').datepicker({ changeMonth: true,format: 'mm-dd-yyyy',changeYear: true,viewMode:2}).on('changeDate', function(ev){
			$(this).css('background-color','');	
	});
	}
	
	if($('.ccdate').hasClass('ccdate')){	
	$('.ccdate').datepicker({ changeMonth: true,format: 'mm-dd-yyyy',changeYear: true}).on('changeDate', function(ev){$(this).css('background-color','');});}
	
});


function match_password(){
	var pswd = $('.user_pass').val();
	var pswd2 = $('.user_pass2').val();
	if(pswd != pswd2){
		$('#match').removeClass('valid').addClass('invalid');
		$('#match').text('Password does not match!');
		
	} else {
		$('#match').removeClass('invalid').addClass('valid');
		$('#match').text('Password Match!');
	}
	
}



//var entery = 0;
function validate_pass_strength()
{ 
		
	// set password variable
	var pswd = $('.user_pass').val();
	
	//validate the length
	if ( pswd.length < 8 ) {
		$('#length').removeClass('valid').addClass('invalid');
	} else {
		$('#length').removeClass('invalid').addClass('valid');
	}
	
	//validate letter
	if ( pswd.match(/[a-z]/) ) {
		$('#letter').removeClass('invalid').addClass('valid');
	} else {
		$('#letter').removeClass('valid').addClass('invalid');
	}
	
	//validate uppercase letter
	if ( pswd.match(/[A-Z]/) ) {
		$('#capital').removeClass('invalid').addClass('valid');
	} else {
		$('#capital').removeClass('valid').addClass('invalid');
	}
	
	//validate number
	console.log(pswd.replace(/[^0-9]/g,"").length);
	if ( pswd.match(/\d/) ) {
		if(pswd.replace(/[^0-9]/g,"").length >=3){
			$('#number').removeClass('invalid').addClass('valid');
		}else {
			$('#number').removeClass('valid').addClass('invalid');
		}
	} else {
		$('#number').removeClass('valid').addClass('invalid');
	}
}


function validate_payment_bank(frm){
	validate_data=false;
	 $("form#validatethis.frm_bank input[type=text],form#validatethis.frm_bank select").each(function(){
				if($(this).val()==''){
					validate_data=true;
					$(this).css('background-color','#ebccd1');		
				}
				
			});
			
			if(validate_data==true){
					alert('Please Fill Fields Correctly.');
					return false;	
			}		
	

	
	
}



function check_empty(idd,namee){//TB,DD
	if(document.getElementById(idd)!=null){
	if(document.getElementById(idd).value==''){
		alert(''+namee+' is empty');
		$("#"+idd).css('background-color','#ebccd1');
		$("#"+idd).focus();
		return true;
			
	}
	}
	else{//COMMENT AFTER TESTING....
	alert("NOT FOUND ID "+idd);
	return true;
		
	}
	
	return false;
}


function check_empty_m(idd,namee){//TB,DD
	if(document.getElementById(idd)!=null){
	if(document.getElementById(idd).value==''){
		alert(namee);
		$("#"+idd).css('background-color','#ebccd1');
		$("#"+idd).focus();
		return true;
			
	}
	}
	else{//COMMENT AFTER TESTING....
	alert("NOT FOUND ID "+idd);
	return true;
		
	}
	
	return false;
}


function check_rb(rbname,display_namee){
if (!$("input[name='"+rbname+"']:checked").val()) {
			alert('Please Select '+display_namee);
			$("input[name="+rbname+"]").focus();
			return true;
}

return false;
}

function chek_ssn(idd,msgg)  
{  
      var phoneno = /^\(?([0-9]{3})\)?[-. ]?([0-9]{2})[-. ]?([0-9]{4})$/;  
      if(document.getElementById(idd).value.match(phoneno)) {  
          return false;  
          }  
          else  
         { 
		 	alert(msgg);
			$("#"+idd).css('background-color','#ebccd1');
			$("#"+idd).focus(); 
		 	return true;  
      	}  
} 




    

/*DEMOO*/


