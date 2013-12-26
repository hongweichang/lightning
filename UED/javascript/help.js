$(document).ready(function(){
	$("#hc-content li").bind('click',function(event) {
		var title = $(this).children(".hc-title");
		$(this).children(".hc-hidden").toggle();
		if(title.hasClass("on")){
			title.removeClass("on");
		}else{
			title.addClass("on");
		}
	});
	$("#hc-content .show").parent(".hc-hidden").css({display: 'block'});
});
