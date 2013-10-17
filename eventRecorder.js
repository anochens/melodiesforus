function logEvent(subject_name, event_name, async) {
	page_name = location.pathname.substring(location.pathname.lastIndexOf("/") + 1);
   if(!page_name) page_name='index.php';

	current_time = getCurrentTime();

	$.ajax({url: "recordEvent.php", 
			  data: {"current_time":current_time,
			 			"page_name":page_name, 
			  			"subject_name":subject_name, 
			  			"event_name":event_name
					  },
				'async': async
		    });
}

function getCurrentTime() {
	a=new Date();
	formatted = a.getFullYear()+" "+(a.getMonth()+1)+"/"+a.getDate()+" "+a.getHours() + ":" + a.getMinutes() + ":" + a.getSeconds() + ":" + a.getMilliseconds();
	return formatted;
}

//stuff to do when the page loads
$(document).ready(function() {
	logEvent('page','load');

	$('a, button').bind("click",function(e) {
		async = true;
      if($(this).attr('href') != '#' || $(this).attr('type') == 'submit') {
			async = false;
		}

		logEvent($(this).attr('id'),'click', async);
	});
}); 
