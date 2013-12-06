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
				b: b
			}
		}
	};
}();