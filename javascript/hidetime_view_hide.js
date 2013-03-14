

//Java script added by the hide time plugin to make sure that the time is hidden
$().ready(
	function(){ 
		var timeStr = $('span.r_date' ).html();
		console.log(timeStr);
		$('span.r_date' ).html(timeStr.substring(5));
		
		$('#datenotime' ).css("display", "none");
	});
	
