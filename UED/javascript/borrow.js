$(document).ready(function(){
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
				range: [5,20]
			},
			deadline:{
				required: true,
				digits: true,
				range: [1,36]
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
				range: "年利率介于5到12%之间"
			},
			deadline:{
				required: "不能为空",
				digits: "请输入整数",
				range: "期限介于1到36个月"
			}
		}
	});
});