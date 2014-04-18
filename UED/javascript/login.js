$(document).ready(function(){
	$(".form-item input").each(function(){
		if($(this).val())
			$(this).siblings('p').css({display: "none"});
	});
	$(".form-item").bind("click",function(){
		$(this).children("p").css({display:"none"});
		$(this).children('.form-input').focus();
	});
	$(".form-item input").bind("focus",function(){
		$(this).siblings("p").css({display: "none"});
	});
	$(".form-item input").bind("blur",function(){
		if(!$(this).val())
			$(this).siblings("p").css({display: "block"});
		else
			$(this).siblings("p").css({display: "none"});
	});
	$(".fakeCheck,label[for='keepSignIn'],label[for='protocal']").toggle(function(){
		$(this).parent().find("span").css({display: "none"});
		$(this).siblings("input").removeAttr('checked');
	},function(){
		$(this).parent().find("span").css({display: "block"});
		$(this).siblings("input").attr("checked","checked");
	});
	$("#login").validate({
		rules:{
			"Login[account]": {
				required: true,
				phoneOrMail: true
			}
		},
		messages:{
			"Login[account]":{
				required: "用户名不能为空",
				phoneOrMail: "请输入正确的手机号或邮箱"
			}
		}
	});
	$("#signup").validate({
		rules:{
			"Register[nickname]":{
				required: true,
				uname: true
			},
			"Register[email]":{
				required: true,
				email: true
			},
			"Register[mobile]":{
				required: true,
				phone: true
			},
			"Register[password]":{
				required: true,
				minlength: 6
			},
			"Register[confirm]":{
				required: true,
				equalTo: "#signup-password"
			},
			"Register[code]":{
				required: true,
				length4: true
			}
		},
		messages:{
			"Register[nickname]":{
				required: "用户名不能为空",
				uname: "可由4-16个中英文、数字、下划线字符构成"
			},
			"Register[email]":{
				required: "请输入邮箱",
				email: "请输入正确的邮箱格式"
			},
			"Register[mobile]":{
				required: "手机号不能为空",
				phone: "请输入11位手机号码"
			},
			"Register[password]":{
				required: "请输入密码",
				minlength: "密码至少为六位"
			},
			"Register[confirm]":{
				required: "请重复密码",
				equalTo: "您输入的密码不一致"
			},
			"Register[code]":{
				required: "验证码不能为空",
				length4: "验证码长度为4位"
			},
		}
	});
	$.validator.addMethod("phoneOrMail",function(value,element){
		var tel = /^13\d{9}|14[57]\d{8}|15[012356789]\d{8}|18[01256789]\d{8}$/;
		var len = value.length;
		var mail = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/;
		return this.optional(element) || (tel.test(value) && len == 11) || mail.test(value);
	});
	$.validator.addMethod("uname",function(value,element){
		var uname =  /^[\u4E00-\u9FA5\uf900-\ufa2d\w]{4,16}$/ ;
		return this.optional(element) ||  uname.test(value);
	});
	$.validator.addMethod("phone",function(value,element){
		var tel = /^13\d{9}|14[57]\d{8}|15[012356789]\d{8}|18[01256789]\d{8}$/;
		var len = value.length;
		return this.optional(element) || (tel.test(value) && len == 11);
	});
	$.validator.addMethod("length4",function(value,element){
		var len = value.length;
		return this.optional(element) || (len == 4);
	});
	
	$("#getVerifycode").bind("click",function(){
		var time;
		var text;
		if(!$(this).hasClass("disabled")){
			$(this).addClass("disabled");
			$.ajax({
				url: baseUrl + 'user/account/SendregisterVerify?mobile=' + $('#signup-phone').val(),
				type: 'GET',
			});
			time = 60;
			text = $("#getVerifycode").text();
			changeVal();
		}
		function changeVal(){
			if(time>0){
				$("#getVerifycode").text(time+"秒重新获取");
				setTimeout(changeVal,1000);
				time--;
			}else
				$("#getVerifycode").removeClass("disabled").text(text);
		}
	});
	function check(){
		$(this).siblings("p").css({display: "none"});
	}
	
	$("#getVerifyCodeButton").bind("click",function(){
		var time;
		var text;
		if(!$(this).hasClass("disabled")){
			$(this).addClass("disabled");
			$.ajax({
				url: $(this).attr('data-url') + '?mobile=' + $('#verify-mobile').val() + '&reset=' + reset,
				type: 'GET',
			});
			time = 60;
			text = $(this).text();
			changeVal();
		}
		function changeVal(){
			if(time>0){
				$("#getVerifyCodeButton").text(time+"秒重新获取");
				setTimeout(changeVal,1000);
				time--;
			}else
				$("#getVerifyCodeButton").removeClass("disabled").text(text);
		}
		return false;
	});
});