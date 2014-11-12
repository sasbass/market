/**
 * Sales
 */
var barcode='';
var quantity='';
$(document).ready(function(){
	clLive();
	$("input#barcode").focus().addClass("tab");
});

$(window).on('keyup', function(event){
    if(event.keyCode == '9'){
    	clLive();
    	checkTabIndex = $(event.target).attr("tabindex");
    	$("input").removeClass("tab");
    	$(event.target).addClass("tab");
    	if(isNaN(checkTabIndex)){
    		$("input#barcode").focus().addClass("tab");
    		$("input#barcode").val(" ");
    	}
    }
});

function clLive(){
	$(window).on('keydown', function(event){
		if($("#num-"+event.keyCode).length >0) {    	
	    	$("a").removeClass("number-tabs");
	    	$("#num-"+event.keyCode).addClass("number-tabs");
	    }
	});

	$(window).on('keyup', function(event){
		if($("#num-"+event.keyCode).length >0) {    	
	    	$("a").removeClass("number-tabs");
	    }
	});
}

function payMent(obj){
	var pm = parseFloat($(obj).val());
	var total = parseFloat($("#total").val());
	var changes = parseFloat(pm-total);
	if(isNaN(changes))changes = 0;
	$("#change-span").val(number_format(changes,2));
	$("#change").val(number_format(changes,2));
}

function addWrite(obj)
{
	$("input").removeClass("write");
	$(obj).addClass("write");
	entNumber(obj);
}

function entNumber(obj){
	var getID = $(".write").attr("id");
	if(getID == 'quantity'){
		NumberQuantity(obj);
	} else {
		NumberBarcode(obj);
	}
}

function NumberBarcode(obj)
{	
	if($(obj).attr('rel') && $(obj).attr('rel') == 'delete') {
		if(barcode != undefined) {
			barcode = barcode.slice(0,barcode.length -1);
			$(".write").val(barcode);
		}
	} else {
		if(obj == 1) {
			//$(".write").val("");
		} else {
			var newText = $(obj).text();
			barcode = barcode+newText;
			$(".write").val(barcode);
		}
		
		return false;
	}
}

function NumberQuantity(obj)
{	
	if($(obj).attr('rel') && $(obj).attr('rel') == 'delete') {
		if(quantity != undefined) {
			quantity = quantity.slice(0,quantity.length -1);
			$(".write").val(quantity);
		}
	} else {
		if(obj == 1) {
			//$(".write").val("");
		} else {
			var newText = $(obj).text();
			quantity = (isNaN(quantity+newText) ? 0 : quantity + newText);
			$(".write").val(quantity);
		}
		
		return false;
	}
}

function number_format(number, decimals, dec_point, thousands_sep) {
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}

function animateMessage(/*top,left,*/set_time){
	$("#message").css("display","block");
	$("#message").animate({
		opacity: 1
	}, 1000);
	setTimeout(function(){
		$('#message').fadeOut();
	}, set_time);
}