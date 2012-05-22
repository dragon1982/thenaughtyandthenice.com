var cls,current;
var output;
jQuery(function($){
	var t;
	showPreview = function(obj){
		$("." + obj + " > div.girl_photo").append('<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="150" height="116"><param name="movie" value="assets/swf/thumbn.swf"><param name="quality" value="high"><param value="'+$("." + obj + " > input").val()+ '" name="flashvars"><param value="transparent" name="wmode"><embed  wmode="transparent"  src="assets/swf/thumbn.swf" flashvars="'+$("." + obj + " > input").val()+ '" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash"  width="150" height="116"></embed></object>');
		$("." + obj + " > div.girl_photo").css('background-position','1000px 1000px');
		$("." + obj + " > div.girl_photo > a").hide();
		$("." + obj + " > div.performer_bg > object").show();		
	}
	
	hidePreview = function (obj){
		$("." + obj + " > div.girl_photo > object").remove();
		$("." + obj + " > div.girl_photo > a").show();
		$("." + obj + " > div.girl_photo").css('background-position','0px 0px');		
		cls = undefined;
	}
	
	thumbClosed = function(){
		hidePreview(cls);
	};
	
	$('.preview > div.girl_photo').hover(
		function(){
			current =  String($(this).parent().attr('class').split(' ').slice(-1));
			if(current == cls){
				return false;
			} 						
			if(t){
				clearTimeout(t);
				hidePreview(current);
			}			
			cls = current;
			t = setTimeout("showPreview(cls)",300);
		},
		function(){
			if(t){
				clearTimeout(t);
			}
			
			if(cls){
				hidePreview(cls);
			}
		}
			
	);
});