var Filter = function(){
	var choice = $(".filter-choice");
	return{
		checked: function(o){
			var switcher = $("#filter-switch").hasClass("active"),
					input =$("input",o),
					siblings = o.siblings(choice),
					input_v = input.val(),
					input_f = input.attr("checked"),
					flag = 0;
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
			var node = $('<li class="loan-list"><div class="loan-avatar"><img src="'+(list.avatarSrc || "../images/intro-pic_1.png")+'" /><span>信</span></div><div class="loan-title"><a href="'+list.titleHref+'">'+list.title+'</a></div><div class="loan-rate loan-num">'+list.rate+'</div><div class="loan-rank"><div class="rank'+list.rank+'">'+list.rank+'</div></div><div class="loan-amount loan-num">'+list.amount+'</div><div class="loan-time loan-num">'+list.time+'</div><div class="loan-progress"><div class="bar-out"><div class="bar-in"><span class="bar-complete" style="width:'+list.progress+'"></span><span class="bar-num">'+list.progress+'</span></div></div></div></li>')
			return node;
		},
		insertList: function(list){
			loan.append(list);
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