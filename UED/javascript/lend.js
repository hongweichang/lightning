var Filter = function(){
	var choice = $(".filter-choice");
	var page = 2;
	return{
		checked: function(o){
			var switcher = $("#filter-switch").hasClass("active"),
					input =$("input",o),
					siblings = o.siblings(choice),
					input_v = input.val(),
					input_f = input.attr("checked"),
					flag = 0;
			if(o.hasClass('filter-choice')){
				page = 2;
			}
			o.addClass("active").children('input').attr({checked: 'checked'});
			if(!switcher || input_v=="all"){ //单选
				siblings.removeClass("active").children('input').removeAttr('checked');
			}else{
				$("input[value='all']",siblings).removeAttr('checked').parent("li").removeClass('active');
				siblings.children('input').each(function(){
					if($(this).attr("checked")){
						flag++;
					}
				});
				if(input_f=="checked" && flag>=1){
					o.removeClass('active').children('input').removeAttr('checked');
				}
			}
			var checked_input = $("input[checked='checked']");
			var send_str = "";
			var i = true;
			checked_input.each(function(){
				if(i === true){
					i = false;
					send_str += $(this).attr("name")+"=";
				}else
					send_str += "&"+$(this).attr("name")+"=";
				send_str += $(this).val();
			});
			send_str+= "&page="+page;
			page++;
			return send_str;
		},
		send: function(str){
			$.ajax({
				url: "test.php",
				type: 'GET',
				data: str,
				dataType: 'json',
				success: function(listData){
					List.removeList();
					for(var i = 0,length = listData.data.length ;i < length; i++ ){
						var list = listData.data[i];
						List.insertList(List.createList(list));
					}
				}
			});
		}
	};
}(),
List = function(){
	var loan = $(".loan>ul");
	return{
		showMore: function(str){
			$.ajax({
				url:'test.php',
				type:'GET',
				data: str,
				dataType:'json',
				success: function(listData){
					if(listData.state){
						for(var i = 0,length = listData.data.length ;i < length; i++ ){
							var list = listData.data[i];
							List.insertList(List.createList(list));
						}

					}else{
						//没有更多了
					}
				}
			});
		},
		removeList:function(){
			$(".loan-list",loan).remove();
		},
		createList: function(list){
			var node = $('<li class="loan-list"><div class="loan-avatar"><img src="'+(list.avatarSrc || "../images/intro-pic_1.png")+'" /><span>信</span></div><div class="loan-title"><a href="'+list.titleHref+'">'+list.title+'</a></div><div class="loan-rate loan-num">'+list.rate+'</div><div class="loan-rank"><div class="rank'+list.rank+'">'+list.rank+'</div></div><div class="loan-amount loan-num">'+list.amount+'</div><div class="loan-time loan-num">'+list.time+'</div><div class="loan-progress"><div class="bar-out"><div class="bar-in"><span class="bar-complete" style="width:'+list.progress+'"></span><span class="bar-num">'+list.progress+'</span></div></div></div></li>');
			return node;
		},
		insertList: function(list){
			loan.append(list);
		}
	}
}(),
Lend = function(){
	return{
		viewDetails: function(hide,show){
			var newH = show.height()+90;
			$("#borrow-info").height(newH);
			hide.hide();
			show.show();
		},
		placeholder: function(o){
			var defaultV = o.val();
			o.bind("focus",function(){
				o.val("");
				o.css({color:"#000"});
				//ajax
				o.siblings('.paycenter-hint').show();
			});
			o.bind("blur",function(){
				if(!$(this).val())
					$(this).val(defaultV).css({color:"#ccc"});
			});
		}
	}
}();

$("#filter-switch").toggle(
	function(){
		$(this).addClass("active");
	},
	function(){
		$(this).removeClass("active");
	}
);
$(".filter-choice").bind("click",function(){
	var str = Filter.checked($(this));
	Filter.send(str);
});
$(".loan-list").live("hover",function(e){
	if(e.type == "mouseenter"){
		var href = $(".loan-title a",$(this)).attr("href");
		$(this).append("<a href='"+href+"' class='lend-mask'></a>");
	}else{
		$(this).children(".lend-mask").remove();		
	}
});
$("#viewMore").bind("click",function(){
	var str = Filter.checked($(this));
	List.showMore(str);
});
//lend-pay
$("#view-detail").toggle(
	function(){
		Lend.viewDetails($("#borrow-brief"),$("#borrow-details"));
		$("#view-detail").css({background:"url('../images/viewBrief.png')"});
	},
	function(){
		Lend.viewDetails($("#borrow-details"),$("#borrow-brief"));
		$("#view-detail").css({background:"url('../images/viewDetail.png')"})
	}
);
Lend.placeholder($("#pay-verify"));

//lend-details
$(".fakeCheck,label[for='keepSignIn'],label[for='protocal']").toggle(function(){
	$(this).parent().find("span").css({display: "none"});
	$(this).siblings("input").removeAttr('checked');
},function(){
	$(this).parent().find("span").css({display: "block"});
	$(this).siblings("input").attr("checked","checked");
});
$(".details-tab li").bind("click",function(){
	var i = $(this).index();
	$(this).addClass("tab-on").siblings().removeClass("tab-on");
	$(".tab-content").eq(i).addClass("tab-show").siblings().removeClass("tab-show");
})

$("#lend-form").validate({
	rules:{
		lend_num:{
			required: true
		}
	},
	messages:{
		lend_num:{
			required: "不能为空"
		}
	}
});
$(".placeholder").bind("click",function(){
	$(this).siblings("#lend-num").focus();
});
$("#lend-num").bind("focus",function(){
	$(this).siblings(".placeholder").hide();
});
$("#lend-num").bind("blur",function(){
	if(!$(this).val())
		$(this).siblings('.placeholder').show();
});
$("#lend-num").bind("change",function(){
	alert("a");
});