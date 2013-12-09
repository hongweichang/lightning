$(function(){
	$("table#tree tr.line").live('click',function(){
		id = $(this).attr('id');
		selector = 'table#tree tr.child-of-'+id;
		if ( $(selector).html() != null ){
			$(selector).toggle();
		}else{
			$.ajax({
				type:'post',
				url:
			});
		}
	});	
});