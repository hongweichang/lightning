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
	};
	Mask.prototype.resize = function(mask){
		$(mask).css({
			left: ($(window).width() - $(mask).outerWidth())/2,
			top: ($(window).height()- $(mask).outerHeight())/2 + $(document).scrollTop()
		});
	}
	Mask.prototype.show = function(mask){
		$(mask).fadeIn();
	};
	new Mask(".bankcard-op","#m-bankcard");
	$(".fakeCheck,label[for='keepSignIn'],label[for='protocal']").toggle(function(){
		$(this).parent().find("span").css({display: "none"});
		$(this).siblings("input").removeAttr('checked');
	},function(){
		$(this).parent().find("span").css({display: "block"});
		$(this).siblings("input").attr("checked","checked");
	});
});