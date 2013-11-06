
<?php

if(array_key_exists('sid', $_COOKIE)) {
	header("Location: index.php");
	die;
}

include_once('functions.php');

$hitId = '';
$workerId = '';
if(array_key_exists('hitId', $_REQUEST)) {
	$hitId = $_REQUEST['hitId'];
}

if(array_key_exists('workerId', $_REQUEST)) {
	$workerId = $_REQUEST['workerId'];
}                                 


if(array_key_exists('override', $_REQUEST)) {
	$hitId = 'testing_hit_id';
	$workerId = 'test_mturk_id';
}        

if($hitId && $workerId) {
	$sid = enter_new_session($hitId, $workerId);
}
else {
	die("This page can only be accessed through the Mechanical Turk HIT. Please accept the task and click the link to this page from there.");
}
?>     


<script src="./eventRecorder.js"></script>

<script src="//code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<link href="./assets/css/bootstrap.css" rel="stylesheet">
<p>&nbsp;</p>
<script>
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
</script>

<div style="width:800px">
<p><strong>Title of Project:</strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Music purchasing study</p>

<p>&nbsp;</p>

<table style="border:0px;">
	<tbody>
		<tr>
			<td style="padding-right:5px" valign="top"><strong>Principal Investigator:</strong></td>
			<td valign="bottom">Alan Nochenson / 309 IST Building / University Park, 16802 / anochenson@psu.edu</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td style="padding-right:5px" valign="top"><strong>Advisor:</strong></td>
			<td valign="bottom">Jens Grossklags / 329A IST Building / University Park, 16802 / jensg@ist.psu.edu</td>
		</tr>
	</tbody>
</table>
<br>

<ol>
	<li><strong>Purpose of the Study:</strong>&nbsp; We aim to study music purchasing behaviors.</li>
	<li><strong>Procedures to be followed:</strong>&nbsp; To complete this study, you will be given $1.50 with which you purchase a <b>single</b> song from a music store. In the store, you may sample the songs. Any money that you do not spend during the course of the study will be paid to you as a bonus payment (see below). This study will also involve filling in a survey questionnaire.</li>
	<li><strong>Duration/Time:</strong> The whole process should take you about 10-15 minutes on average.</li>
	<li><strong>Statement of Confidentiality:</strong> Your participation in this research is confidential. In the event of a publication or presentation resulting from the research, no personally identifiable information will be shared.</li>
	<li><strong>Right to Ask Questions:</strong> Please contact Alan Nochenson at anochenson@psu.edu with questions or concerns about this study.</li>
	<li><strong>Payment for participation:</strong> You will be given a sum of $1.50 with which to purchase a <b>single</b> song. The price of the song will be deducted from this initial endowment. Any remaining money will be paid as a bonus at the end of this study, approximately on November 8, 2013. For completing all parts of the study, you are guaranteed the amount listed on the Mechanical Turk HIT that you have accepted, and you may be paid an additional sum as specified above.</li>
	<li><strong>Voluntary Participation:</strong> Your decision to take part in this research is voluntary. You can stop at any time. You do not have to answer any questions you do not want to answer. If this is the case, please abandon the Mechanical Turk HIT and exit the survey or game.</li>
	<li>You must be 18 years of age or older to consent to take part in this research study.&nbsp; If you agree to take part in this research study and to the conditions outlined above, please click the button below. If you do not consent, please exit the survey now and abandon the Mechanical Turk HIT.</li>
</ol>

</div>


<a id='beginBtn' class='btn btn-primary btn-small' href='/'>I agree to the above terms</a>

<script src="./assets/js/bootstrap-transition.js"></script>
<script src="./assets/js/bootstrap-alert.js"></script>
<script src="./assets/js/bootstrap-modal.js"></script>
<script src="./assets/js/bootstrap-dropdown.js"></script>
<script src="./assets/js/bootstrap-scrollspy.js"></script>
<script src="./assets/js/bootstrap-tab.js"></script>
<script src="./assets/js/bootstrap-tooltip.js"></script>
<script src="./assets/js/bootstrap-popover.js"></script>
<script src="./assets/js/bootstrap-button.js"></script>
<script src="./assets/js/bootstrap-collapse.js"></script>
<script src="./assets/js/bootstrap-carousel.js"></script>
<script src="./assets/js/bootstrap-typeahead.js"></script>

