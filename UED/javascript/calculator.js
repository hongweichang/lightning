var calculator = function(){
	var a = [],   //月收本金
		b = [],   //月收利息
		c;         //月收本息
	return{
		month: function(month,capital,rate){ //月收本息
			var rate = rate/100,
				result = capital*rate*Math.pow((1+rate),month)/(Math.pow((1+rate),month)-1);
				c = result.toFixed(2);
			return c;
		},
		detail: function(capital,rate,n,month){
			var rate = rate/100, 
				result = capital*rate*Math.pow((1+rate),(n-1))/(Math.pow((1+rate),month)-1);
				a.push(result.toFixed(2));
				result = c - a[month-n];
				b.push(result.toFixed(2));
				if(n>1){
					arguments.callee(capital,rate*100,n-1,month);
				}
		},
		getDetail: function(){
			return {
				a: a,
				b: b,
				c: c
			}
		},
		clearinfo: function(){
			a = [],
			b = [],
			c = 0
		}
	};
}();
$("#cal-form").validate({
	rules:{
		"loan-amount":{
			required: true,
			range: [1,1000000000],
			digits: true
		},
		"annual-rate":{
			required: true,
			range: [8,24],
			digits: true
		},
		"loan-deadline":{
			required: true,
			range: [1,36],
			digits: true
		}
	},
	messages:{
		"loan-amount":{
			required:"不能为空",
			range: "请输入正整数",
			digits: "请输入整数"
		},
		"annual-rate":{
			required:"不能为空",
			range: "利率范围8%-24%",
			digits: "请输入整数"
		},
		"loan-deadline":{
			required: "不能为空",
			range: "期限可为1-36个月",
			digits: "请输入整数"
		}
	}
});

$("#cal-form").on("click",function(e){
	var info = $(this).serializeArray();
	if($(e.target).attr("type")=="submit" && $(this).valid()){
		e.preventDefault();
		calculate(info);
		incomeInfo(info);
	}
});

function calculate(o){
	var capital = o[0].value,
		rate = o[1].value/12,
		month = o[2].value;
	calculator.month(month,capital,rate); //月收本息
	calculator.detail(capital,rate,month,month);
}
function incomeInfo(o){
	var info = calculator.getDetail(),
		capital = o[0].value,
		month = o[2].value,
		m_income,
		desc = $("#calc-desc td"),
		detail = $("#calc-detail .calc-detail-title");

	desc.eq(1).text(capital+"元");
	desc.eq(3).text((info.c*month-capital).toFixed(2)+"元");
	desc.eq(5).text(info.c+"元");
	desc.eq(6).text("您将在"+month+"个月后收回/还清全部本息");
	$(".calc-result").eq(0).show();
	$(".calc-result").eq(1).show();
	if(o[3].value === "open"){
		detail.siblings('tr').remove();
		for(var i = month; i > 0; i--){
			var dom = createTd(month-i+1+"月");
				dom += createTd(info.c);
				dom += createTd(info.a[i-1]);
				dom += createTd(info.b[i-1]);
				dom += createTd((info.c*(i-1)).toFixed(2));
			detail.parent().append("<tr>"+dom+"</tr>");
		}
		$(".calc-result").eq(2).show();
		function createTd(text){
			var dom = "<td>"+text+"</td>";
			return dom;
		}
	}
}