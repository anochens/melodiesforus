<?php                        


if(!array_key_exists('sid', $_COOKIE) || !array_key_exists('email', $_REQUEST)) {
	header('Location: index.php');
	die;	
}
include('functions.php');

$email = htmlentities($_REQUEST['email'], ENT_QUOTES);
$sid = intval($_COOKIE['sid']);

$treatment = getTreatmentForSession($sid);

$box_value = '';
$prepop = $treatment['pre-pop'];
$opt = $treatment['opt'];
if(substr($prepop, 0, 3) == 'yes'){
	$box_value = htmlentities($_REQUEST['email'], ENT_QUOTES);
}

$box_display = 'block';
$box_hidden = false;
if($prepop == 'yes-hidden') {
	$box_display = 'none';
	$box_hidden = true;
}

?>      

<script src="./assets/js/jquery.js"></script>
<script src="./eventRecorder.js"></script>
<link href="./assets/css/bootstrap.css" rel="stylesheet">

<style>

table{
	margin-bottom:10px;

}
td {
	padding: 10px;
}

</style>
<script>

function next(yesno) {
   opt = '<?php echo $opt; ?>';


	sendEmail = false;
	if(yesno == 'no') { //clicked no btn
		if(opt == 'out') {
      	sendEmail = true;
		}
	}
	else { //clicked big yes btn
   	if(opt == 'in') {
			sendEmail = true;
		}
	}

	if(sendEmail) {
		alert('sending email');
   	//send email
	}
	else { alert('NO EMAIL'); }
}


</script>


<iframe width=1 height=1 style='display:none' src='download.php?songId=<?php echo $_REQUEST['songId']; ?>'></iframe>


  <body>

    <div class="container" style='margin:10px'>
	 <div class='row'>
	 <div class='span13'>
         

<p> 
	<strong style="line-height: 1.3em;"><span style="font-size: xx-large;">Thank you! <span style="font-size: small;">MelodiesFor.us has processed your order.</span></span> </strong>
</p>
<table style="width: 1042px; height: 170px;">
<tr>
	<td style="background-color: #8a92ef; height: 75px; border-color: black; border-style: solid; border-width: 3px;" valign="middle">
	<p><span style="font-size: x-large; color: #ffffff;"> Get your song sent to you safely and securely with SafeDelivery</span></p>
</td>
<td rowspan="2" valign="top" style='border:0px'>
	<img src="/assets/img/woman.jpg" border="0" alt="Woman " title="Woman" width="250" height="198" style="float: right;" />
</td>
</tr>
<tr>
<td style="border-color: black; border-style: solid; border-width: 3px;" valign="top">
<p><span style="font-size: small;"><strong> SafeDelivery offers you the following services:</strong></span></p>
<ul>
	<li>Extra security for your song delivery.</li>
	<li>An additional way to access your song.</li>
	<li><span style="text-decoration: underline;">SAVE 50% </span> when your song is delivered by email.</li>
</ul>
</tr>
</table>

<table style="width: 1040px; height: 351px;border: 3px solid black">

<tr>
	<td style="width: 200px;" valign="top">
	<?php 
		$start_text = 'Entering your email address ';

		$end_text = 'automatically charge your budget according to the Offer Details to the right';


		if($box_hidden || $prepop != 'no') {
      	$start_text = 'Clicking the button ';
		}

		if($opt == 'out') {
			$start_text = 'You are subscribed to the SafeDelivery service. ' . $start_text;
			$end_text = 'remove you from the SafeDelivery service described to the right';
		}
		echo "<p>$start_text below constitutes your electronic signature and we will $end_text.</p>";
		?>
		<p style="text-align: center;">


		
		<span style='display:<?php echo $box_display; ?>'>
			E-mail Address: 
			<input type='text' class='input-block-level' style='margin-top:5px;width:85%' placeholder='Email Address' value='<?php echo $box_value; ?>' name='email' />
		</span>

		<?php

		$button_text = 'Email song';

		if($opt == 'out') {
      	$button_text = 'Remove me from SafeDelivery';
		}

		echo "<a href='#' class='btn btn-large' style='font-family:times;width:85%' onclick='next(\"yes\")'>$button_text</a>";

		?>
		<br/><br/>
		<a href='#' onclick='next("no")'>No thanks</a>
	</td>

<td rowspan="2" valign="top">
	<p><span style="font-size: x-small;"><strong>SafeDelivery benefit details:</strong></span></p>
	<p>SafeDelivery is a trustworthy provider for digital communications and the delivery of digital content. This service is offered by leading online music retailers to ensure that customers get the music they want without problems. There are many benefits of using SafeDelivery.<br /> -If you lose your original copy of the song, you will always have a second copy available.<br /> -You save 50% when ordering the delivery of a copy of your song via SafeDelivery email.<br /> -We guarantee that the emailed copy is exactly similar to the initial selection.<br /> -100 Percent satisfaction guaranteed.</p>
	<p><span style="font-size: x-small;"><strong>Offer Details:</strong></span></p>

	<?php
		$start_text = 'type in your email address and ';
		$pre_text = '';
		if($box_hidden) {
      	$start_text = '';
		}            
		if($opt == 'out') {
      	$pre_text = 'You have been subscribed to the SafeDelivery service.';
			$button_text = 'No thanks';
		}
		echo "<p>".$pre_text."Simply ".$start_text."click \"$button_text\" to use our services and to take advantage of the great value that SafeDelivery provides. By clicking \"$button_text\" you will receive a safe email copy of the identical song you selected in the MelodiesFor.us store for just $0.50. This is a 50% DISCOUNT for the additional copy. You will SAVE an incredible $0.50 on this purchase. If you decide to not take advantage of this great offer you can click no thanks at the bottom. When you agree to use SafeDelivery you will receive your MelodiesFor.us selection delivered in a timely manner by email to your account. Your emailed backup copy of the song will help you to have continued access to your song in case of data loss or when you are using different computers. Alternative offers will not give you the same satisfaction or the same $0.50 DISCOUNT. Because of this special reduced offer price we cannot offer any refunds. We always strive to serve our customers to provide them with the quickest and most reliable mode of music delivery. Our customers have the highest degree of satisfaction with SafeDelivery and we invite you to try our offer.</p>";

	?>
</td>
</tr>

</table>
