//JavaScript added by the Hide Time plugin to toggle time on and off when editing reports.

function toggleHideTime(url, report_id)
{
	
	if(report_id != "")
	{
		$("#hidetime_wait").html('<img id="hidetime_wait_img" src="'+url+'media/img/loading_g.gif"/>');
	}

	if( $('#datetime_edit > .time').css("display") == "none")
	{
		$('#datetime_edit > .time').css("display", "block");
		if(report_id != "")
		{			
			$.get(url+"admin/hidetime/hidetime/"+report_id+"/false", function(data){
					$("#hidetime_wait").html('');
			});
		}
	}
	else
	{		
		$('#datetime_edit > .time').css("display", "none");
		if(report_id != "")
		{
			$.get(url+"admin/hidetime/hidetime/"+report_id+"/true", function(data){
					$("#hidetime_wait").html('');
			});
		}
	}
}