$(document).ready(function(){
	var Mask = function(target,mask){
		this.parentEle = $(target).parent();
		this.clickEleName = $(target).attr("class");
		this.wd = $(mask).width();
		var _this = this;
		this.parentEle.bind('click',function(e){
			var t = $(e.target);
			e.preventDefault();
			if(t.hasClass(_this.clickEleName)){
				_this.resize(mask);
				_this.show(mask);
			}
		});
		$(mask).bind("click",function(e){
			var t = $(e.target);
			if(t.hasClass('mask-close')){
				_this.close(mask);
			}
		});
		$(".wrapMask").bind("click",function(){
			_this.close(mask);
		})
	};
	Mask.prototype.resize = function(mask){
		$(mask).css({
			left: ($(window).width() - $(mask).outerWidth())/2,
			top: ($(window).height()- $(mask).outerHeight())/2 + $(document).scrollTop()
		});
	};
	Mask.prototype.show = function(mask){
		$(".wrapMask").fadeIn();
		$(mask).fadeIn();
	};
	Mask.prototype.close = function(mask){
		$(".wrapMask").fadeOut();
		$(mask).fadeOut();
	};
	new Mask(".bankcard-op","#m-bankcard");
	$(".fakeCheck,label[for='keepSignIn'],label[for='protocal']").toggle(function(){
		$(this).parent().find("span").css({display: "none"});
		$(this).siblings("input").removeAttr('checked');
	},function(){
		$(this).parent().find("span").css({display: "block"});
		$(this).siblings("input").attr("checked","checked");
	});

	$("#query-button").on("click",function(){
		var type = $("select[name='query_type']").val(),
			date = $("select[name='query_date']").val(),
			ehref = $("#export-record").attr("href");
		$("#export-record").attr({
			href: ehref+"/type/"+type+"/date/"+date
		});
		$.ajax({
			type : "GET",
			url : "value",
			data : "query_type="+type+"&query_date="+date,
			dataType: "json",
			success: function(){

			}
		});
	});
	$("#withdraw-num").on("change",function(){
		var w_num = $(this).val();
		$.ajax({
			url: 'PayBackMoney',
			type: 'POST',
			dataType: 'json',
			data: "getSum="+w_num,
			success: function(data){
				var data = data.data;
				$("#getSum").text(data.GetSum);
				$("#userPaySum").text(data.userPaySum);

			}
		})
		
	});
});