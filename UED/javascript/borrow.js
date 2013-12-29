$(document).ready(function(){
	$("#borrow-message textarea").on('focus', function(event) {
		$("#borrow-message .placeholder").hide();
	});
	$("#borrow-message textarea").on('blur', function(event) {
		$("#borrow-message .placeholder").show();
	});
	$("#borrow-message .placeholder").on('click', function(event) {
		$(this).hide();
	});

	$('.input-daterange').datepicker({
	    startDate: "today",
	    language: "zh-CN",    
	    todayHighlight: true
	});
	$("#borrow-message").validate({
		rules:{
			title:{
				required: true
			},
			sum:{
				required: true,
				digits: true,
				range: [5000,10000000]
			},
			rate:{
				required: true,
				digits: true,
				range: [8,24]
			},
			deadline:{
				required: true,
				digits: true,
				range: [1,36]
			},
			start:{
				required: true
			},
			end:{
				required: true
			},
			desc:{
				required: true
			}
		},
		messages:{
			title:{
				required: "不能为空"
			},
			sum:{
				required: "不能为空",
				digits: "请输入整数",
				range: "请输入不低于5000的整数"
			},
			rate:{
				required: "不能为空",
				digits: "请输入整数",
				range: "年利率介于8到24%之间"
			},
			deadline:{
				required: "不能为空",
				digits: "请输入整数",
				range: "期限介于1到36个月"
			},
			start:{
				required:"请选择开始时间"
			},
			end:{
				required:"请选择结束时间"
			},
			desc:{
				required:"请填写描述信息"
			}
		}
	});

	var calculator = function(){
		var a = [],   //月收本金
			b = [],   //月收利息
			c,		  //月收本息
			d = [],   //月管理费
			rank,     //会员级别 
			service;  //服务费
		return{
			month: function(month,capital,rate){ //月收本息
				var rate = rate/100,
					result = capital*rate*Math.pow((1+rate),month)/(Math.pow((1+rate),month)-1);
					c = result.toFixed(2);
				return c;
			},
			detail: function(capital,rate,n,month,s){
				var rate = rate/100, 
					result = capital*rate*Math.pow((1+rate),(n-1))/(Math.pow((1+rate),month)-1);
					a.push(result.toFixed(2));
					result = c - a[month-n];
					b.push(result.toFixed(2));
					result = result*parseInt(s)/100;
					d.push(result.toFixed(2));
					if(n>1){
						arguments.callee(capital,rate*100,n-1,month,s);
					}
			},
			getDetail: function(){
				return {
					a: a,
					b: b,
					c: c,
					d: d,
					rank: rank,
					service: service
				}
			},
			service: function(capital,month,s){	//服务费
				if(month<6){
					service = capital*parseInt(s)/100;
				}else{
					service = capital*parseInt(s)/100;
				}
			},
			clearinfo: function(){
				a = [],
				b = [],
				c = 0,
				d = [],
				rank = "",
				service = 0;
			}
		};
	}();
	var rank_rate = $("#message-next").data("info").split(";");
	$("#borrow-message").on("change",function(e){
		var info = $(this).serializeArray(),
			capital = info[1].value,
			month = info[3].value,
			rate = info[2].value,
			month_num,
			detail,
			lend_service = 0;

		if(month <= 6){
			r_rate = rank_rate[0];
		}else
			r_rate = rank_rate[1];
		if(capital && month && rate){
			month_num = calculator.month(month,capital,rate/12);
			calculator.detail(capital, rate, month, month, r_rate);
			calculator.service(capital, month, r_rate);
			lend_service = calculator.getDetail().service;
			$("#calc-borrow-month").text(month_num);
			$("#calc-borrow-service").text(lend_service);
		}
	});
});