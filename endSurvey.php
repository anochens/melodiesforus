<?php

if(!array_key_exists('sid', $_COOKIE)) {
	header('Location: index.php');
	die;	
}
include('functions.php');

$email_sent = false;

if(array_key_exists('sendEmail', $_GET)) {
	if($_REQUEST['sendEmail'] != 'false') {
		$to = getEmailForCurrentSession();
		$email_sent = true;

		include('mailer.php');
	}
}


$email = htmlentities($_REQUEST['post_email'], ENT_QUOTES);
$sid = intval($_COOKIE['sid']);

edit_session(array('post_email'=>$email, 'sid'=>$sid, 'email_sent'=>var_export($email_sent, true)), true, 'post')
                                  
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
