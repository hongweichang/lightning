var args = (function(){
	var sc = document.getElementsByTagName('script'); 
	var paramsArr = sc[sc.length-1].src.split('?')[1].split('&'); 
	var args = {}, param, name, value; 
	for(var i = 0, len = paramsArr.length;i < len;i++){ 
		param = paramsArr[i].split('='); 
		name = param[0], value = param[1]; 
		if(typeof args[name] == 'undefined'){
			args[name] = value; 
		}else if(typeof args[name] == 'string'){
			args[name] = [args[name]] 
			args[name].push(value); 
		}else{
			args[name].push(value); 
		}
	}
	return args;
})();

