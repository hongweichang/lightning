$(document).ready(function(){
	$(".login-tab li").bind("click",function(){
		var i = $(this).index();
		$(this).addClass("tab-on").siblings().removeClass("tab-on");
		$(".tab-content").eq(i).addClass("tab-show").siblings().removeClass("tab-show");
	});
	$(".form-item").bind("click",function(){
		$(this).children("p").css({display:"none"});
		$(this).children('.form-input').focus();
	});
	$(".form-item input").bind("blur",function(){
		if(!$(this).val())
			$(this).siblings("p").css({display: "block"});
	});
	$(".fakeCheck,label[for='keepSignIn'],label[for='protocal']").toggle(function(){
		$(this).parent().find("span").css({display: "none"});
	},function(){
		$(this).parent().find("span").css({display: "block"});
	});
	$("#login").validate({
		rules:{
			username: {
				required: true,
				phoneOrMail: true
			}
		},
		messages:{
			username:{
				required: "用户名不能为空",
				phoneOrMail: "请输入正确的手机号或邮箱"
			}
		}
	});
	$("#signup").validate({
		rules:{
			username:{
				required: true,
				uname: true
			},
			signup_phone:{
				required: true,
				phone: true
			},
			signup_password:{
				required: true,
				minlength: 6
			},
			signup_password_confirm:{
				required: true,
				equalTo: "#signup-password"
			}
		},
		messages:{
			username:{
				required: "用户名不能为空",
				uname: "可由4-16个中英文、数字、下划线字符构成"
			},
			signup_phone:{
				required: "手机号不能为空",
				phone: "请输入11位手机号码"
			},
			signup_password:{
				required: "请输入密码",
				minlength: "密码至少为六位"
			},
			signup_password_confirm:{
				required: "请重复密码",
				equalTo: "您输入的密码不一致"
			}
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
	
});