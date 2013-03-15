

//Java script added by the hide time plugin to make sure that the time is hidden
$().ready(
	function(){ 
		var timeStr = $('span.r_date' ).html();
		var index = timeStr.indexOf(':');
		timeStr = timeStr.substring(0,index-2) + timeStr.substring(index+3);



		$('span.r_date' ).html(timeStr);
		
		$('#datenotime' ).css("display", "none");
	});
	
