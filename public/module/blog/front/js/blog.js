/*
Author: sadiq noor
Date: 16/02/16
Version: 1.0
*/
//=======end blog front Module=======
function open_form(){
              $('#Interested-info').css('display','block')
            }
 
$('#post_comments').click(function() {   
    //alert('sadha');
        var form= $("#comments_form");
        $.ajax({
                type:"POST",
                 url:base_url+'blog/post_comments',
                data:form.serialize(),//only input
                dataType : "json",
                success: function(response){                     
                    console.log(response);
                    $('.msg').html('');
                   if(typeof response.user_name != 'undefined'){
                       $('#user_name').html(response.user_name);
                   }else if(typeof response.email != 'undefined'){
                       $('#email').html(response.email);
                   }else if(typeof response.comment != 'undefined'){
                       $('#comment').html(response.comment);
                     //  $("#contact_form").trigger('reset');
                   }else if(typeof response.success != 'undefined'){
                     
                       $('#success').html(response.success);
                       $("#comments_form").trigger('reset');
                   } 
                   
                }
            });
    });
    
    
//=======end blog front Module=======


