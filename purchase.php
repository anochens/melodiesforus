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
		<p>Entering your email address below constitutes your electronic signature and we will automatically charge your budget according to the Offer Details to the right.</p>
		<p style="text-align: center;">
		
		E-mail Address: 
		<input type='text' class='input-block-level' style='margin-top:5px;width:85%' placeholder='Email Address' name='email' />
		<a href='#' class='btn btn-large' style='font-family:times;width:85%' onclick='next("yes")'>Email song</a>
		<br/><br/>
		<a href='#' onclick='next("no")'>No thanks</a>
	</td>

<td rowspan="2" valign="top">
	<p><span style="font-size: x-small;"><strong>SafeDelivery benefit details:</strong></span></p>
	<p>SafeDelivery is a trustworthy provider for digital communications and the delivery of digital content. This service is offered by leading online music retailers to ensure that customers get the music they want without problems. There are many benefits of using SafeDelivery.<br /> -If you lose your original copy of the song, you will always have a second copy available.<br /> -You save 50% when ordering the delivery of a copy of your song via SafeDelivery email.<br /> -We guarantee that the emailed copy is exactly similar to the initial selection.<br /> -100 Percent satisfaction guaranteed.</p>
	<p><span style="font-size: x-small;"><strong>Offer Details:</strong></span></p>
	<p>Simply type in your email address and click "Yes" to use our services and to take advantage of the great value that SafeDelivery provides. By clicking "Yes" you will receive a safe email copy of the identical song you selected in the PSU MUSIC store for just $0.50. This is a 50% DISCOUNT for the additional copy. You will SAVE an incredible $0.50 on this purchase. If you decide to not take advantage of this great offer you can click no thanks at the bottom. When you agree to use SafeDelivery you will receive your PSU MUSIC selection delivered in a timely manner by email to your account. Your emailed backup copy of the song will help you to have continued access to your song in case of data loss or when you are using different computers. Alternative offers will not give you the same satisfaction or the same $0.50 DISCOUNT. Because of this special reduced offer price we cannot offer any refunds. We always strive to serve our customers to provide them with the quickest and most reliable mode of music delivery. Our customers have the highest degree of satisfaction with SafeDelivery and we invite you to try our offer.</p>
</td>
</tr>

</table>
