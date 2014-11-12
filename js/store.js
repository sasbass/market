/**
 * Store
 */

var fullW = $( window ).width();
var fullH = $( window ).height();
$(document).ajaxStart(function() {
    $("div#loading").css({
        width: fullW + 'px',
        height: fullH + 'px' 
    });
    $('html').css('overflow','hidden');
    $("div#loading").show();
});

$(document).ajaxStop(function() {
    $("div#loading").hide();
});

$(document).ready(function(){
    $("#message-item").dialog({
        modal: true,
        buttons: {
            "Ок": function() {
                $( this ).dialog( "close" );
            }
        }
    });
    
    $("#form-item").dialog({
        modal: true,
        width: 500,
        buttons: {
            "Продължи": function() {
                $.ajax({
                    type: "POST",
                    url: base_url + 'store/sales/setFlashData/',
                    data: $("#form").serialize()
                }).done(function( data ) {
                    var result = jQuery.parseJSON(data);
                    if(result.type == 1){                        
                        $("#form-item").dialog("close");
                        location.href = base_url + 'store/sales/';
                    } else {
                        console.log(result.msg);
                        if(result.msg != ''){
                            messageDialog = $( "#dialog-message" );
                            messageDialog.attr('title',result.msg.title);
                            messageDialog.html(result.msg.body);
                            messageDialog.dialog({
                                width: 400
                            });
                        }
                    }
                });
            },
            "Откажи": function() {
                $( this ).dialog( "close" );
            }
        }
    });
});

function deleteItem(url){
    $("#dialog-confirm").dialog({
        resizable: false,
        height:180,
        modal: true,
        buttons: {
            "Да": function() {
                $( this ).dialog("close");
                location.href = url;
            },
            "Не" : function() {
                $( this ).dialog("close");
            }
        }
    });
}

var animateTime= 500;

/**
 * Message function
 * @param int set_time
 * @returns show and hide #message
 */
function animateMessage(set_time){
	if(set_time != '') {
		set_time=set_time;
	} else {
		set_time = notificationTime;
	}
	$("#message,.error_message").css("display","block");
	$("#message,.error_message").animate({
		opacity: 1
	}, animateTime);
    
	setTimeout(function(){
		$('#message,.error_message').fadeOut();
	}, set_time);
}