<?php
include_once('functions.php');

if(array_key_exists('prevPage', $_REQUEST) && $_REQUEST['prevPage'] == 'survey') {
	include('endPage.php');
	die;

}


$sid = intval($_COOKIE['sid']);


$email_sent = false;

if(array_key_exists('sendEmail', $_GET)) {
	if($_REQUEST['sendEmail'] != 'false') {
		$to = getEmailForCurrentSession();
		$email_sent = true;

		include('mailer.php');
	}
}
if(array_key_exists('post_email', $_REQUEST)) {
	$email = htmlentities($_REQUEST['post_email'], ENT_QUOTES);

	edit_session(array('post_email'=>$email, 'sid'=>$sid, 'email_sent'=>var_export($email_sent, true)), true, 'post');
}          

include_once('redirector.php');

                                  
?>

<script src="./assets/js/jquery.js"></script>
<script src="./eventRecorder.js"></script>



<script>
	 $(document).ready(function() {
		$('input:text').addClass('input-block-level');
		$('button').addClass('btn');
		$('button').addClass('btn-primary');
		$('button').addClass('btn-large');
		$('button').css('margin-left','40%');
		$('button').eq(0).attr('id','submitBtn');
  });
</script> 
 

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <span style='font-weight:bold;color:black' class="brand">MelodiesFor.us</span>
        </div>
      </div>
    </div>

    <div class="container" style='margin-top:50px'>
 		<div class='row'>
			<div class='span8'>
 
<?php


include('survey/survey.php');


?>

</div> <!-- spanX -->
</div> <!-- row-->

</div> <!-- container -->

<link href="../assets/css/bootstrap.css" rel="stylesheet">

<style>
legend {
	border:0px;
}
.span8 {
/*	border:3px solid black; */
}

</style> 
