$(document).ready(function(){
	var allShow = true;                //true表示未展开
	$(".sec-update a").each(function(){
		$(this).click(function(){
			var c = $(this).hasClass('unfold');
			if(c == false && allShow == true){
				$(this).addClass('unfold').text(function(index,text){
					return "取消"+text;
				});
				$(this).parents('.sec-fold').siblings('.sec-unfold').slideDown();
				allShow = false;
			}else if(c){   //再次点击展开项
				$(this).removeClass('unfold').text(function(index,text){
					return text.slice(2);
				});
				$(this).parents('.sec-fold').siblings('.sec-unfold').slideUp();
				allShow = true;
			}else if(c == false && allShow == false){  //点击不同项
				$('.sec-update a').text(function(index,text){
					return text.replace('取消','');
				}).removeClass('unfold');
				$('.sec-unfold').hide();
				$(this).addClass('unfold').text(function(index,text){
					return "取消"+text;
				});
				$(this).parents('.sec-fold').siblings('.sec-unfold').slideDown();
			}
		});
	});
	
	$("#pleaseFill").click(function(){
		$("#creditTab").trigger("click");
	});

	var personal = function(){
		return{
			change: function(o){
				var f = $(o).siblings("form");
				f.each(function(){
					if($(this).hasClass('hidden')){
						$(this).removeClass('hidden').addClass('show');
					}else{
						$(this).addClass('hidden').removeClass('show');
					}
				});
			}
		}
	}();
	$("#personal-modify").toggle(
		function(){
			$(this).text("取消修改");
			personal.change($(this));
		},
		function(){
			$(this).text("修改信息");
			personal.change($(this));
		}
	);
});