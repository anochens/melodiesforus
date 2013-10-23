<script src="//code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<p><script>
 function turkGetParam( name ) { // This function gets URL parameters
    name = name.replace(/[\[]/,"\\[").replace(/[\]]/,"\\]");
    var regexS = "[\?&]"+name+"=([^&#]*)";
    var regex = new RegExp( regexS );
    var results = regex.exec( window.location.href );
    if( results == null )
    return "";
    else
    return results[1];
 }


hitId = turkGetParam('hitId');
workerId = turkGetParam('workerId');
link = 'http://www.melodiesfor.us/consent.php?hitId='+hitId+"&workerId="+workerId;

if(workerId != '') {
	data = { 'param_workerId': workerId };
	url = "http://www.melodiesfor.us/editSession.php";
	document.write("<h1><a href='"+link+"'>Link to task</a></h1>");
}
else {
	data = { 'param_hitId': hitId };
	url = "http://www.melodiesfor.us/createSession.php";
	$('#submitButton').attr('disabled', 'disabled');
}

if(hitId != '') { //dont log when creating the HIT

     $.ajax({
        'url': url,
        'data': data,
        dataType: 'jsonp',
        async: false,
		  success: function(data) {
				console.log('success;Created session |'+data+"|");
console.log(data);
        },        
        error: function(data) {
				console.log('error;Created session |'+data+"|");
console.log(data.responseText);
        },         
        complete: function(data) {
				console.log('complete;Created session |'+data+"|");
console.log(data);
        }        
     });

}


</script></p>

<p>This task involves an online shopping environment for music. Please click on the link above to take you to a consent form and take the chance to sample different songs. If you do not see a link above, please accept the HIT to see the link In addition to the participation fee, we have allocated to you a budget of $1.50. You are required to purchase exactly one song in the music store. This purchase will reduce your budget accordingly. Any budget that remains at the end of task will be paid to you as a bonus. After completing your shopping, you will be redirected to a survey. Once you complete the survey the task is finished, and you will receive a task completion code, which you can enter below.<br />
<br />
<input id="code" type="text" /></p>

<p><input id="submitButton" type="submit" value="Click to finish" /></p>

