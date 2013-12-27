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
			
			if (!isFilter){
				send_str+= "&page="+page;
				page++;
			}/*else {
				alert("isFilter: "+isFilter);
			}*/
			
			
			return send_str;
		},
		send: function(str){
			$.ajax({
				url: baseUrl + 'tender/purchase/ajaxBids?'+str,
				type: "GET",
				dataType: "json",
				success: function(listData){
					var page_html = listData.data.pageHtml,
						list = listData.data.content,
						page_size = listData.data.pageSize;
					List.removeList();
					$("#page").remove();
					$("#viewMore").append(page_html);
					for(var i = 0 ;i < page_size; i++ ){
						var li = list[i];
						List.insertList(List.createList(li));
					}

				}
			});
		}
	};
}(),
List = function(){
	var loan = $(".loan ul");
	return{
		showMore: function(str){
			$.ajax({
				url:ajaxBids,
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
						alert("没有更多");
					}
				}
			});
		},
		removeList:function(){
			$(".loan-list",loan).remove();
		},
		createList: function(list){
			var node = $('<li class="loan-list"><div class="loan-avatar"><img src="'+(list.avatar)+'" /><span>信</span></div><div class="loan-title"><a href="'+list.titleHref+'">'+list.title+'</a></div><div class="loan-rate loan-num"><span class="val">'+list.month_rate+'</span>%</div><div class="loan-rank"><div class="rank'+list.authGrade+'">'+list.authGrade+'</div></div><div class="loan-amount loan-num"><span class="val">￥'+list.sum+'</span>元</div><div class="loan-time loan-num"><span class="val">'+list.deadline+'</span>个月</div><div class="loan-progress"><div class="bar-out"><div class="bar-in"><span class="bar-complete '+list.processClass+'" style="width:'+list.progress+'%"></span><span class="bar-num">'+list.progress+'%</span></div></div></div><a href="'+list.titleHref+'" class="invest">投标</a></li>');
			return node;
		},
		insertList: function(list){
			loan.append(list);
		}
	}
}(),
Page = function(){
	var page = 1;
	return{
		initial: function(o){
			$(o).live("click",function(e){
				var ev = e.target,
					str = $(ev).attr("href");
				e.preventDefault();
				$.ajax({
					url: str,
					type: "GET",
					dataType: "json",
					success: function(listData){
						var page_html = listData.data.pageHtml,
							list = listData.data.content,
							page_size = listData.data.pageSize;
						List.removeList();
						$("#page").remove();
						$("#viewMore").append(page_html);
						for(var i = 0 ;i < page_size; i++ ){
							var li = list[i];
							List.insertList(List.createList(li));
						}

					}
				});
			});
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
			o.bind("click",function(){
				var time;
				var text;
				if(!$(this).hasClass("disabled")){
					$(this).addClass("disabled");
					$.ajax({
						url: baseUrl + 'tender/platform/sendVerify/mobile/' + o.attr('data-mobile'),
						type: "GET",
						dataType: "json",
						success: function(){
							o.siblings('.paycenter-hint').show();
						}
					});
					time = 30;
					text = $(this).text();
					changeVal();
				}
				function changeVal(){
					if(time>0){
						o.text(time+"秒重新获取");
						setTimeout(changeVal,1000);
						--time;
					}else{
						o.removeClass("disabled").text(text);
					}
				}
				return false;
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

var isFilter = false;
$(".filter-choice").bind("click",function(){
	isFilter = true;
	var str = Filter.checked($(this));
	Filter.send(str);
});
//lend-pay
$("#view-detail").toggle(
	function(){
		Lend.viewDetails($("#borrow-brief"),$("#borrow-details"));
		$("#view-detail").css({background:"url('"+baseUrl+"UED/images/viewBrief.png')"});
	},
	function(){
		Lend.viewDetails($("#borrow-details"),$("#borrow-brief"));
		$("#view-detail").css({background:"url('"+baseUrl+"UED/images/viewDetail.png')"})
	}
);
Lend.placeholder($("#pay-verify-button"));
Page.initial("#page");
//lend-details
$(".fakeCheck,label[for='keepSignIn'],label[for='protocal']").toggle(function(){
	$(this).parent().find("span").css({display: "none"});
    $("#lend-confirm").css("background","#cbcbcd");
	$(this).siblings("input").removeAttr('checked');
},function(){
	$(this).parent().find("span").css({display: "block"});
    $("#lend-confirm").css("background","#2da9ac");
	$(this).siblings("input").attr("checked","checked");
});
$(".details-tab li").bind("click",function(){
	var i = $(this).index();
	$(this).addClass("tab-on").siblings().removeClass("tab-on");
	$(".tab-content").eq(i).addClass("tab-show").siblings().removeClass("tab-show");
});
(function(){
	var info = $("#lend-num").data("info");
	info = info.split(";");
	var total = parseInt(info[0])/100;
		month = info[1];
		rate = info[2]/100/12;
		progress = parseInt(info[3])/100;
	$("#lend-form").validate({
		success: function(){
			var capital = $("#lend-num").val(),
				income;
			income = month*calculator.month(month,capital,rate);
			$("#lend-income").text((income-capital).toFixed(2));
		},
		rules:{
			sum:{
				required: true,
				range: true,
			}
		},
		messages:{
			sum:{
				required: "不能为空",
				range: "请输入0到"+(total-progress).toFixed(2)+"的数字,最多两位小数"
			}
		}
	});
	$.validator.addMethod("range",function(value,element){
		var range = /^(?!0+(?:\.0+)?$)\d+(?:\.\d{1,2})?$/;
		var len = value.length;
		return this.optional(element) || (range.test(value) && value > 0 && value <= (total-progress));
	});
})();
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


