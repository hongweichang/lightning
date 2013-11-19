var options;
options={
	width:"100%",
	height:"400px",
	auto: true
}

function slide(){
	var obj = $("#banner");
	var slideUl = $("ul",obj);
	var len = $("li",obj).length; //图片数量
	var end_index = len-1;
	var start_index = 0;
	var index = 0;

	obj.css({
		width: options.width,
		height: options.height,
		position: "relative",
		overflow: "hidden"
	})
	$("ul",obj).css({
		width: options.width,
		height: options.height
	});
	$("li",obj).css({
		width: "100%",
		height: "100%",
		position: "absolute",
		display: "none"
	});
	$("li:first-child",obj).css({
		display: "list-item"
	});

	$("img",obj).css({
		width: "100%",
		height: "100%"
	});
	obj.append('<span class="sliderBtn" id="preBtn"></span>' // 添加按钮
		+'<span class="sliderBtn" id="nextBtn"></span>'
		+'<div id="btnList"></div>'
	);
	var btnLen = len;
	for( ; btnLen>0;btnLen--){
		$("#btnList",obj).append('<li>'+btnLen+'</li>');
	}
	$("#btnList li",obj).addClass("btnClass");
	$(".btnClass:last-child").addClass("btnAct");

	function picShow(index){
		$("li",obj).eq(index).stop().fadeIn().siblings().fadeOut();
		$("#btnList li",obj).eq(len-1-index).addClass("btnAct").siblings().removeClass("btnAct");
	}
	$("#btnList li",obj).bind("click",function(){
		index = len - 1 -$("#btnList li").index($(this));
		picShow(index);
	});
	$("#nextBtn",obj).bind("click",function(){
		if(index ==len-1){
			index = 0;
			picShow(0);
		}else
			picShow(++index);
	});
	$("#preBtn",obj).bind("click",function(){
		if(index ==0){
			index = len-1;
			picShow(index);
		}else
			picShow(--index);
	});

	if(options.auto){
		var picTimer;
		var autoIndex;
		obj.hover(function(){
			if(picTimer)
				clearInterval(picTimer);
		},function(){
			picTimer = setInterval(function(){
				picShow(index);
				index++;
				if(index == len){index = 0};
			},4000);
		});
	}

}

(function($){
	slide(options);
})(jQuery);