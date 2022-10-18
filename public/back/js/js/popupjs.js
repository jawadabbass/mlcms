/************************************************/
/// isscroll value should be 1 or yes if dont want to scroll the div the you can set it empty or no.
/// popupHeight depend on isscroll value if isscroll value is 1 or yes and popupHeight value is empty then it will return an error.
/// if backgroundOverlay is 1 or yes thenm it will show background overlay, if value is empty, 0 or no then it will not show background Overlay
/// Through CSS important layout settings of Popup can be changed like Popup position, color of Text, Heading style, Heading background color and Popup outer border    color.
/// By default Popup will set itself in center according to screen resolution.


/************************************************/
var ScrollBackToX = '';
var ScrollBackToY = '';

function loadNewPopup(headingText,content,popupWidth,popupHeight,isscroll,backgroundOverlay,jqSelector,selectorName,topPosition,topPositionUnit,popUpPosition)
{
		
		if(arguments.length > 11) {
			
			for (var x = 11; x < arguments.length; x++) {
				
				var getValueArr = arguments[x].split(':');
				
				var varType = getValueArr[0];
				var varValue = getValueArr[1];
				
				if(varType == 'windowScroll') {
					
					if(varValue == '1' || varValue == 'yes') {
						
						varType = getValueArr[2];
						varValue = getValueArr[3];
						
						if(varType == 'windowScrollToX') {
							
							var setX = varValue;
							
						}
						
						varType = getValueArr[4];
						varValue = getValueArr[5];
						
						
						if(varType == 'windowScrollToY') {
							
							var setY = varValue;
							
						}
						
						window.scroll(parseInt(setX),parseInt(setY));
						
						varType = getValueArr[6];
						varValue = getValueArr[7];
					
						if(varType == 'windowScrollBack') {
							
							
							if(varValue == '1' || varValue == 'yes') {
								
								varType = getValueArr[8];
								varValue = getValueArr[9];
								
								if(varType == 'windowSrollBackSelector') {
									
									var position = $(varValue).position();
									ScrollBackToX = position.left;
									ScrollBackToY = position.top;
									//alert("X"+" "+ScrollToX+" Y"+" "+ScrollToY);
									
								}
								
								
							
							}
								
																
						}	
						
					}
					
				} else {
					
					alert("Unknown Parameter");
					return false;
					
				}
				
			};
			
		}
		
		if(backgroundOverlay == '1' || backgroundOverlay == 'yes') {
			
			var createMainDivs = '<div id="backgroundPopup"></div><div class="content_main"><div class="content_popup"></div></div>';
			
		} else {
		
			var createMainDivs = '<div class="content_main"><div class="content_popup"></div></div>';
		
		}
		
		var headingDivWidth = parseInt(popupWidth) - 52;
		var headingHtml = '<div class="heading_popup"><div></div><a href="javascript:;" onclick="closePopup()">Close (X)</a></div>';
		
		if(jqSelector != "") {
		
			if(jqSelector == 'id' || jqSelector == 'class' || jqSelector == 'tag') {
				
				if(jqSelector == 'id') {
					var selector = "#";
				} else if(jqSelector == 'class') {
					var selector = ".";
				} else if(jqSelector == 'tag') {
					var selector = "";
				}
				
			} else {
				
				alert('Select the Valid Selector');
				return false;
			}
			
		} else {
			
			alert('Select the Valid Selector. Possible Values are id, class and tag.');
			return false;
			
		}
		
		
		if(selectorName == "") {
			
			alert("Please Define Selector. Possible values are id name, class name and Tag name");
			return false;
			
		} else {
			
			var jQobject = selector+selectorName;
			
		}
		
		
		if($('.content_main').length > 0) {
			
			$('#backgroundPopup').remove();
			$('.content_main').remove();
			
			$(jQobject).append(createMainDivs);
		} else {
			
			$(jQobject).append(createMainDivs);
			
		}
		
		if(isscroll=='yes' || isscroll=='1') {
			var scrollDiv = '<div class="scroll-divPopup">&nbsp;</div>';
		}
		
		$("#backgroundPopup").css({
			"opacity": "0.7"
		});
		
		
		if(popUpPosition != "") {
			
			if(popUpPosition != "fixed" && popUpPosition !="absolute") {
				
				alert("Possible values of popUpPosition should be fixed and absolute");
				return false;
			}
			
			$('.content_main').css({
				"position":popUpPosition
			});
		}
		
		
		if(topPosition!='') {
			
			if(topPositionUnit == "") {
				
				alert("You Define topPositionValue. Possible values are px and %");
				return false;
			}
			
			setTop = topPosition+topPositionUnit;
			
			$('.content_main').css({
				"top":setTop
			});
			
		}
		
		$('.content_popup').css({
			"width":popupWidth+"px"
		});
		
		$('.content_popup').html(headingHtml);

		$('.heading_popup div').css({
			"float": "left",
			"width": headingDivWidth+"px"
		});

		$('.heading_popup div').html(unescape(headingText));
		
		if(isscroll == 'yes' || isscroll=='1') {
			if(popupHeight == '') {
				alert('Variable "popupHeight" value is missing.');
				return false;
			} else {
					$('.content_popup').append(scrollDiv);
					
					$('.scroll-divPopup').css({
						"height" : popupHeight+"px"
					});
	
					$('.scroll-divPopup').html(unescape(content));
			}
		}
		else {
				$('.content_popup').append(unescape(content));
		}
		
		$("#backgroundPopup").fadeIn("slow");
		$('.content_main').fadeIn("slow");
}

function loadNewPopup_BS(headingText,content,popupWidth,popupHeight,isscroll,backgroundOverlay,jqSelector,selectorName,topPosition,topPositionUnit,popUpPosition)
{
			var createMainDivs = '<div class="modal fade" id="myModal" role="dialog"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h4 class="modal-title">'+unescape(headingText)+'</h4><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body">'+content+'</div><div class="modal-footer"><button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button></div></div></div></div>';
			
		$('#myModal').html(createMainDivs);
		 $('#myModal').modal('show');
		
}


function loadNewPopup_BS_Add(headingText,content)
{
			var createMainDivs = '<div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h4 class="modal-title">'+unescape(headingText)+'</h4><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body">'+content+'</div><div class="modal-footer"></div></div></div>';
			
		$('#myModal').html(createMainDivs);
		 $('#myModal').modal('show');
		
}



function loadNewPopup_Loading(headingText,content,popupWidth,popupHeight,isscroll,backgroundOverlay,jqSelector,selectorName,topPosition,topPositionUnit,popUpPosition)
{
		
		if(arguments.length > 11) {
			
			for (var x = 11; x < arguments.length; x++) {
				
				var getValueArr = arguments[x].split(':');
				
				var varType = getValueArr[0];
				var varValue = getValueArr[1];
				
				if(varType == 'windowScroll') {
					
					if(varValue == '1' || varValue == 'yes') {
						
						varType = getValueArr[2];
						varValue = getValueArr[3];
						
						if(varType == 'windowScrollToX') {
							
							var setX = varValue;
							
						}
						
						varType = getValueArr[4];
						varValue = getValueArr[5];
						
						
						if(varType == 'windowScrollToY') {
							
							var setY = varValue;
							
						}
						
						window.scroll(parseInt(setX),parseInt(setY));
						
						varType = getValueArr[6];
						varValue = getValueArr[7];
					
						if(varType == 'windowScrollBack') {
							
							
							if(varValue == '1' || varValue == 'yes') {
								
								varType = getValueArr[8];
								varValue = getValueArr[9];
								
								if(varType == 'windowSrollBackSelector') {
									
									var position = $(varValue).position();
									ScrollBackToX = position.left;
									ScrollBackToY = position.top;
									//alert("X"+" "+ScrollToX+" Y"+" "+ScrollToY);
									
								}
								
								
							
							}
								
																
						}	
						
					}
					
				} else {
					
					alert("Unknown Parameter");
					return false;
					
				}
				
			};
			
		}
		
		if(backgroundOverlay == '1' || backgroundOverlay == 'yes') {
			
			var createMainDivs = '<div id="backgroundPopup"></div><div class="content_main"><div class="content_popup"></div></div>';
			
		} else {
		
			var createMainDivs = '<div class="content_main"><div class="content_popup"></div></div>';
		
		}
		
		var headingDivWidth = parseInt(popupWidth) - 52;
		var headingHtml = '';
		
		if(jqSelector != "") {
		
			if(jqSelector == 'id' || jqSelector == 'class' || jqSelector == 'tag') {
				
				if(jqSelector == 'id') {
					var selector = "#";
				} else if(jqSelector == 'class') {
					var selector = ".";
				} else if(jqSelector == 'tag') {
					var selector = "";
				}
				
			} else {
				
				alert('Select the Valid Selector');
				return false;
			}
			
		} else {
			
			alert('Select the Valid Selector. Possible Values are id, class and tag.');
			return false;
			
		}
		
		
		if(selectorName == "") {
			
			alert("Please Define Selector. Possible values are id name, class name and Tag name");
			return false;
			
		} else {
			
			var jQobject = selector+selectorName;
			
		}
		
		
		if($('.content_main').length > 0) {
			
			$('#backgroundPopup').remove();
			$('.content_main').remove();
			
			$(jQobject).append(createMainDivs);
		} else {
			
			$(jQobject).append(createMainDivs);
			
		}
		
		if(isscroll=='yes' || isscroll=='1') {
			var scrollDiv = '<div class="scroll-divPopup">&nbsp;</div>';
		}
		
		$("#backgroundPopup").css({
			"opacity": "0.7"
		});
		
		
		if(popUpPosition != "") {
			
			if(popUpPosition != "fixed" && popUpPosition !="absolute") {
				
				alert("Possible values of popUpPosition should be fixed and absolute");
				return false;
			}
			
			$('.content_main').css({
				"position":popUpPosition
			});
		}
		
		
		if(topPosition!='') {
			
			if(topPositionUnit == "") {
				
				alert("You Define topPositionValue. Possible values are px and %");
				return false;
			}
			
			setTop = topPosition+topPositionUnit;
			
			$('.content_main').css({
				"top":setTop
			});
			
		}
		
		$('.content_popup').css({
			"width":popupWidth+"px"
		});
		
		$('.content_popup').html(headingHtml);

		$('.heading_popup div').css({
			"float": "left",
			"width": headingDivWidth+"px"
		});

		$('.heading_popup div').html(unescape(headingText));
		
		if(isscroll == 'yes' || isscroll=='1') {
			if(popupHeight == '') {
				alert('Variable "popupHeight" value is missing.');
				return false;
			} else {
					$('.content_popup').append(scrollDiv);
					
					$('.scroll-divPopup').css({
						"height" : popupHeight+"px"
					});
	
					$('.scroll-divPopup').html(unescape(content));
			}
		}
		else {
				$('.content_popup').append(unescape(content));
		}
		
		$("#backgroundPopup").fadeIn("slow");
		$('.content_main').fadeIn("slow");
}



function closePopup(){
	
	if(ScrollBackToX != "" && ScrollBackToY != "") {
		
		window.scroll(parseInt(ScrollBackToX),parseInt(ScrollBackToY));
		$('.content_main').fadeOut('slow');	
		$("#backgroundPopup").fadeOut('slow');
		
	}
	
	$("#backgroundPopup").fadeOut('slow');
	$('.content_main').fadeOut('slow');
	
	ScrollBackToX = '';
	ScrollBackToY = '';
}


function showpopwithUpdatedText() {
	
	var eml3=document.getElementById('email').value;

	var content2 = escape('<div style="padding-left:5px;">If you would like to  send it to '+eml3+', please click YES. If that is  not your email address and you would like to change your email address, please  click NO <table width="100%"><tr><td align="right"><img onclick="formSubmit();" src="images/yes-btn.png" /></td><td width="5%"></td><td><img onclick="edit_email();" src="images/no-btn.png" /></td></tr></table></div>');
	
	 loadNewPopup(escape('Resend confirmation email'),content2,'400','','','1','tag','body','','','fixed');
}

function testExtraArgus()
{
	content = escape('<table width="100%" border="0" cellspacing="3" cellpadding="3"><tr><td width="100%" colspan="3">Looks like either your email address or PIN is entered incorrectly. Please review both and fix the issue.</td></tr></table>');
	
	loadNewPopup(escape('Incorrect'),content,'400','','','1','tag','body','','','fixed', 'windowScroll:1:windowScrollToX:0:windowScrollToY:0:windowScrollBack:1:windowSrollBackSelector:#fourthimage');
}