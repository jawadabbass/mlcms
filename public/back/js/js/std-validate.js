// JavaScript Document
var bgProperty='1px solid red';
function isEmpty(Field, Msg)
{
	if(Field.value == ""){
		alert(Msg)
		Field.focus()
		Field.style.border=bgProperty;
		//border: 
		return true
	}
	return false
}
function isNotSame(Field1, Field2, Msg)
{
	if(Field1.value != Field2.value)
	{
		alert(Msg)
		Field1.focus()
		return true
	}
	return false
}
function isNotValidEmail(Email, Msg)
{
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
   	if(reg.test(Email.value) == false) 
	{
      	alert(Msg)
		Email.focus()
		Email.style.border=bgProperty;
      	return true
	}
	return false
}

function isNotNo(Field, Msg)
{
	if(isNaN(Field.value))
	{
		alert(Msg)
		Field.focus()
		return true
	}
	return false
}
function isInvalidLength(Field, Length, Msg)
{
	if(eval(Field.value.length) > eval(Length))
	{
			alert(Msg)
			Field.focus()
			return true
	}
	return false
}

 function isNumberKey(evt)
      {
		   
		 
           var ctrl = (document.all) ? event.ctrlKey: evt.ctrlKey;
   var charCode = (evt.which) ? evt.which : event.keyCode;

  //For Paste
  if (ctrl && (charCode==86 || charCode==118))
	  return false;
	  
  //For Numerics
   if (charCode == 32 || charCode == 8 || (charCode < 91 && charCode > 64) || (charCode < 123 && charCode > 96))
	  return true;

   return false;
     }
	  
function Clear(Form)
{
	Form.reset
	return false
}
function isNotValidCharacters(Sec,MSG)
{
	var Spn = document.getElementById('spn').value;
	
	if(Spn=='1')
	{
		if(! ( Sec.value == "JK904" || Sec.value == "jk904" || Sec.value == "Jk904" || Sec.value == "jK904") ) 
		{
			alert(MSG)
			Sec.value=''
			Sec.focus()
			insertSpam()
			return true 
		}
		else
		{
			return false;
		}
	}
	if(Spn=='2')
	{
		if(! ( Sec.value == "WS506" || Sec.value == "Ws506" || Sec.value == "wS506" || Sec.value == "ws506") ) 
		{
			alert(MSG)
			Sec.value=''
			Sec.focus()
			insertSpam()
			return true 
		}
		else
		{
			return false;
		}
	}
	if(Spn=='3')
	{
		if(! ( Sec.value == "JE496" || Sec.value == "Je496" || Sec.value == "jE496" || Sec.value == "je496") ) 
		{
			alert(MSG)
			Sec.value=''
			Sec.focus()
			insertSpam()
			return true 
		}
		else
		{
			return false;
		}
	}
	if(Spn=='4')
	{
		if(! ( Sec.value == "ER453" || Sec.value == "Er453" || Sec.value == "eR453" || Sec.value == "er453") ) 
		{
			alert(MSG)
			Sec.value=''
			Sec.focus()
			insertSpam()
			return true 
		}
		else
		{
			return false;
		}
	}
	if(Spn=='5')
	{
		if(! ( Sec.value == "CY561" || Sec.value == "Cy561" || Sec.value == "cY561" || Sec.value == "cy561") ) 
		{
			alert(MSG)
			Sec.value=''
			Sec.focus()
			insertSpam()
			return true 
			
		}
		else
		{
			return false;
		}
	}
	if(Spn=='6')
	{
		if(! ( Sec.value == "hi421" || Sec.value == "Hi421" || Sec.value == "hI421" || Sec.value == "HI421") ) 
		{
			alert(MSG)
			Sec.value=''
			Sec.focus()
			insertSpam()
			return true 
		}
		else
		{
			return false;
		}
	}
	if(Spn=='7')
	{
		if(! ( Sec.value == "LP590" || Sec.value == "Lp590" || Sec.value == "lP590" || Sec.value == "lp590") ) 
		{
			alert(MSG)
			Sec.value=''
			Sec.focus()
			insertSpam()
			return true 
		}
		else
		{
			return false;
		}
	}
}

/************************************************************/
/************************************************************/
function ValidateEmpty(Field, ID)
{
	//alert('test');
	var Msg = document.getElementById(ID)
	if(Field.value == "")
	{
		Msg.className = "ShowError4EmptyTextField"
		
		return true
	}
	else
	{
		Msg.className = "HideError4EmptyTextField"
		return false
	}
}
function ValidateSponsorCode(Field, ID)
{
	var Msg = 'cod2';
	if(Field.value == "")
	{
		Msg.className = "ShowError4EmptyTextField"
		Msg.value = ID;
		return false
	}
	else
	{
		Msg.className = "HideError4EmptyTextField"
		return true
	}
}
function ValidateDuplicateEmail(Field, ID)
{
	var Msg = document.getElementById('peml');
	if(Field.value == "")
	{
		Msg.className = "ShowError4EmptyTextField"
		Msg.innerHTML = "Email address already exist.";
		return false
	}
	else
	{
		Msg.className = "HideError4EmptyTextField"
		return true
	}
}
function ValidateEmail(Email, ID)
{
	var Msg = document.getElementById(ID)
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
   	if(reg.test(Email.value) == false) 
	{
	    Msg.className = "ShowError4EmptyTextField"
		Msg.innerHTML = "Please Enter a Valid Email Address";
	
      	return true
	}
	else
	{
		Msg.className = "HideError4EmptyTextField"
		return false
	}
}

function MatchPasswords(Pass1, Pass2, ID)
{
	var Msg = document.getElementById(ID)
	if(Pass2.value == "")
	{
		Msg.innerHTML = "Please Enter Confirm Password";
		Msg.className = "ShowError4EmptyTextField"
		
		return false
	}
	if(Pass1.value != Pass2.value)
	{
		Msg.innerHTML = "Password and Confirm Password are not same";
		Msg.className = "ShowError4EmptyTextField"
		return false
	}
	else
	{
		Msg.className = "HideError4EmptyTextField"
		return true
	}
}

function MatchEmails(Email1, Email2, ID)
{
	var Msg = document.getElementById(ID)
	if(Email2.value == "")
	{
		Msg.innerHTML = "Please Enter a Valid Confirm Email Address";
		Msg.className = "ShowError4EmptyTextField"
		
		return false	
	}
	else if(Email1.value != Email2.value)
	{
		Msg.innerHTML = "Email and Confirm Email are not Same";
		
		Msg.className = "ShowError4EmptyTextField"
		return false
	}
	else
	{
		Msg.className = "HideError4EmptyTextField"
		return true
	}
}
function ValidateRadio(RadioFields, ID)
{
	//var Msg = document.getElementById(ID)
	var nRadios = RadioFields.length
	var Marked = 0;
	for(i=0; i<nRadios; i++)
	{
		if(RadioFields[i].checked)
			Marked++;
	}
	
	if(Marked == 0)
	{
		alert(ID);
		//RadioFields.focus();
		return true
	}
	else
	{
		return false
	}
}
function ValidateZipCode(Zip, ID)
{
	var Msg = document.getElementById(ID)
	var reg =  /^\d{5}([\-]\d{4})?$/;
	
   	if(reg.test(Zip.value) == false) 
	{
	    Msg.className = "ShowError4EmptyTextField"
		Msg.innerHTML = "Please Enter a Valid Zipcode";
	
      	return false
	}
	else
	{
		Msg.className = "HideError4EmptyTextField"
		return true
	}
}
function MatchFields(Field1, Field2, ID)
{
	var Msg = document.getElementById(ID)
	if(Field1.value != Field2.value)
	{
		Msg.className = "ShowError4EmptyTextField"
		return false
	}
	else
	{
		Msg.className = "HideError4EmptyTextField"
		return true
	}
}
function isNotNo2(Field, Msg)
{
	var Msg = document.getElementById(ID)
	if(isNaN(Msg.value))
	{
		Msg.className = "ShowError4EmptyTextField"
		return false
	}
	else
	{
	Msg.className = "HideError4EmptyTextField"
		return true
	}
}
function ValidateCheckboxes(CheckBoxFields, ID, nChecks)
{  

	var Msg = document.getElementById(ID)
	var Marked = 0;
	
	if(nChecks == 1){
		if(CheckBoxFields.checked)
			Marked++;
	}
	else if(nChecks > 1)
	{
		for(i=0; i < nChecks; i++){
			if(CheckBoxFields[i].checked)
				Marked++;
		}
	}
	if(Marked == 0){
		Msg.className = "ShowError4EmptyTextField"
		return false
	}else{
		Msg.className = "HideError4EmptyTextField"
		return true
	}
}
function ValidateCheckBox(CheckBox, ID)
{
	var Msg = document.getElementById(ID)
	if(CheckBox.checked)
	{
		Msg.className = "HideError4EmptyTextField"
		return true
		
	}
	else
	{	Msg.className = "ShowError4EmptyTextField"
	
		return false
	}
}
function valid(form)
	{
	 if(form.code.value == "" || isNaN(form.code.value))
	
		{
		alert("Please provide 3 digit (numerics) comapny code");
		form.code.focus();
		return false;
	   }
	   return true;
	}
function checkUncheckAll(theElement) {
     var theForm = theElement.form, z = 0;
	 for(z=0; z<theForm.length;z++){
      if(theForm[z].type == 'checkbox' && theForm[z].name != 'checkall'){
	  theForm[z].checked = theElement.checked;
	  }
     }
    }
function ValidateList(List, ID)
{
	
	var Msg = document.getElementById(ID)
	if(List.value == '') {
		
		Msg.className = "ShowError4EmptyTextField"
		return false;
	}
	else {
		Msg.className = "HideError4EmptyTextField"
		return true;
	}
}
// validate three digits phone number
function Lengthphone1(Field, ID)
{
	var Msg = document.getElementById(ID)
	var reg =  /^\d{3}([\-]\d{4})?$/;
	
   	if(reg.test(Field.value) == false) 
	{
	    Msg.className = "ShowError4EmptyTextField"
		Msg.innerHTML = "Please Enter a Valid Phone Number";
	
      	return false
	}
	else
	{
		Msg.className = "HideError4EmptyTextField"
		return true
	}
}
// Validate 4 digits phone number
function Lengthphone2(Field, ID)
{
	var Msg = document.getElementById(ID)
	var reg =  /^\d{4}([\-]\d{4})?$/;
	
   	if(reg.test(Field.value) == false) 
	{
	    Msg.className = "ShowError4EmptyTextField"
		Msg.innerHTML = "Please Enter a Valid Phone Number";
	
      	return false
	}
	else
	{
		Msg.className = "HideError4EmptyTextField"
		return true
	}
}
//////////////////////////////////////////////////////
/*function setvalues(id)
{
	var str = "?id="+id; 
	
	var strURL="setvalues.php"+str;
	alert(strURL)
	var xmlhttp = getNewHTTPObject();

   if (xmlhttp)
   {

     xmlhttp.onreadystatechange = function()
     {
      if (xmlhttp.readyState == 4)
      {
	
	 if (xmlhttp.status == 200)
         {
		
	   document.getElementById('progad').innerHTML=xmlhttp.responseText;
		
		
	 } else {
   	   alert("There was a problem while using XMLHTTP:\n" + xmlhttp1.statusText);
	 }
       }
      }
   xmlhttp.open("POST", strURL, true);
   xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8"); 

	xmlhttp.send(str);


  
   }
}*/

function insertSpam()
{
var randomnumber=Math.floor(Math.random()*6)
randomnumber++;
document.getElementById('spam2').value=randomnumber;
if(randomnumber=='1')
	{
		
		document.getElementById('code').innerHTML='<img src="images/spam1.jpg" width="50" height="21" border="0"><input type="hidden" value="1" name="spn" id="spn">';
	}
if(randomnumber=='2')
	{
		
		document.getElementById('code').innerHTML='<img src="images/spam2.jpg" width="50" height="21" border="0"><input type="hidden" value="2" name="spn"  id="spn">';
	}
	if(randomnumber=='3')
	{
		
		document.getElementById('code').innerHTML='<img src="images/spam3.jpg" width="50" height="21" border="0"><input type="hidden" value="3" name="spn" id="spn">';
	}
	if(randomnumber=='4')
	{
		
		document.getElementById('code').innerHTML='<img src="images/spam4.jpg" width="50" height="21" border="0"><input type="hidden" value="4" name="spn" id="spn">';
	}
	if(randomnumber=='5')
	{
		
		document.getElementById('code').innerHTML='<img src="images/spam5.jpg" width="50" height="21" border="0"><input type="hidden" value="5" name="spn" id="spn">';
	}
	if(randomnumber=='6')
	{
		
		document.getElementById('code').innerHTML='<img src="images/spam6.jpg" width="50" height="21" border="0"><input type="hidden" value="6" name="spn" id="spn">';
	}
	if(randomnumber=='7')
	{
		
		document.getElementById('code').innerHTML='<img src="images/spam7.jpg" width="50" height="21" border="0"><input type="hidden" value="7" name="spn" id="spn">';
	}
}