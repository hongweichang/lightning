$(document).ready(function(){
	$("#hc-content li .hc-title").bind('click',function(event) {
		$(this).siblings(".hc-hidden").toggle();
		if($(this).hasClass("on")){
			$(this).removeClass("on");
		}else{
			$(this).addClass("on");
		}
	});
	$("#hc-content .show").parent(".hc-hidden").css({display: 'block'});
});
