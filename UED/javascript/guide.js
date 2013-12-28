$(document).ready(function(){
	var index = 1;
	$("#register").show();
	$("#step1").show();

	$(".step").on('click', function(event) {
		var e = event.target;
		event.preventDefault();
		switch($(e).attr("class")){
			case "step-next":
				$(e).parents(".step").hide();
				index++;
				$("#step"+index).show();
				break;
			case "step-last":
				$(e).parents(".step").hide();
				index++;
				$("#step"+index).show();
				$(e).parents(".mask").hide().next(".mask").show();
		}
	});
});