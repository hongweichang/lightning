$(document).ready(function(){
	$('.input-daterange').datepicker({
	    startDate: "today",
	    language: "zh-CN",    
	    todayHighlight: true
	});
	$("#borrow-message").validate({
		rules:{
			borrow_title:{
				required: true
			},
			borrow_num:{
				required: true,
				digits: true,
				range: [5000,10000000]
			},
			borrow_rate:{
				required: true,
				digits: true,
				range: [5,20]
			},
			borrow_month:{
				required: true,
				digits: true,
				range: [1,36]
			}
		},
		messages:{
			borrow_title:{
				required: "不能为空"
			},
			borrow_num:{
				required: "不能为空",
				digits: "请输入整数",
				range: "请输入不低于5000的整数"
			},
			borrow_rate:{
				required: "不能为空",
				digits: "请输入整数",
				range: "年利率介于5到12%之间"
			},
			borrow_month:{
				required: "不能为空",
				digits: "请输入整数",
				range: "期限介于1到36个月"
			}
		}
	});
});