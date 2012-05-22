jQuery(function($){
	var isInIFrame = (window.location != window.parent.location) ? true : false;
		
	var warpper_min_height = $(document).height()-115;
	$('#warpper').css('min-height', warpper_min_height)
	$('.black_box .content').css('min-height',warpper_min_height - $('#header').height()-55)
	
	//menu hover script
	var src = '';
	$('#menu .item').hover(function(){
		$(this).find('span').addClass('hover')
	}, function(){
		$(this).find('span').removeClass('hover')
	});
	
	
	if(!isInIFrame){
		
		if($(document).width() < 1200){
			$("#background_img_wrap").hide();
		}
		
		//random body background
		  /*this function sets height to background image wrapper so that unnecessary background image part is hidden.*/
		$("#background_img_wrap").height($(document).height());

		/*function which updates background image wrapper height upon window resize*/
		$(window).resize(function () {
			$("#background_img_wrap").height($(document).height());
			if($(document).width() < 1200){
				$("#background_img_wrap").hide();
			}else{
				$("#background_img_wrap").show();
			}
		});
		
	}
	
	//Input style
	$('input[type=text], input[type=password]').after('<span class="input_r"></span>');
	$('input[type=submit].red, button.red').after('<span class="submit_r"></span>');
	$('input[type=submit].black, button.black').after('<span class="submit_b_r"></span>');
	$('span.big_b_btn, button.big_b_btn').after('<span class="big_b_btn_r"></span>');
	
	
	//PROFILE MENU
	$('#profile .menu .menu_item').hover(function(){
		$(this).find('span.btn').addClass('hover');
		$(this).find('span.r').css('display', 'inline-block');
	}, function(){
		$(this).find('span.btn').removeClass('hover');
		$(this).find('span.r').css('display', 'none');
	});
	
	$('#user_account .menu .menu_item').hover(function(){
		$(this).find('span.btn').addClass('hover');
		$(this).find('span.r').css('display', 'inline-block');
	}, function(){
		$(this).find('span.btn').removeClass('hover');
		$(this).find('span.r').css('display', 'none');
	});
	

});


function two(x) {return ((x>9)?"":"0")+x}
function three(x) {return ((x>99)?"":"0")+((x>9)?"":"0")+x}

function time(ms) {
var sec = Math.floor(ms/1000)
ms = ms % 1000
//t = three(ms)

var t = '';
var min = Math.floor(sec/60)
sec = sec % 60
t = two(sec)

var hr = Math.floor(min/60)
min = min % 60
t = two(min) + ":" + t

var day = Math.floor(hr/60)
hr = hr % 60
t = two(hr) + ":" + t
//t = day + ":" + t
//console.log(t);
return t
}