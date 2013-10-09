<?php

if(!array_key_exists('sid', $_COOKIE)) {
	header('Location: index.php');
	die;	
}  
 
//based on http://goo.gl/k1UJrC

date_default_timezone_set("America/New_York");
$random_hash = md5(date('r', time())); 


$to = 'anochenson@gmail.com';
$subject = 'SafeDelivery: Your song';
$headers = "From: admin@safedelivery.com\r\nReply-To: noreply@safedelivery.com"; 
$headers .= "\r\nContent-Type: multipart/mixed; boundary=\"PHP-mixed-".$random_hash."\""; 

$attachment = chunk_split(base64_encode(file_get_contents('songs/song1.zip'))); 

ob_start();
?> 
--PHP-mixed-<?php echo $random_hash; ?>  
Content-Type: multipart/alternative; boundary="PHP-alt-<?php echo $random_hash; ?>" 

--PHP-alt-<?php echo $random_hash; ?>  
Content-Type: text/plain; charset="iso-8859-1" 
Content-Transfer-Encoding: 7bit

<h1>Thank you!</h1>
Thank you for choosing to receive your song through SafeDelivery! You have been charged $0.50 for this service. Your song is attached.

--PHP-alt-<?php echo $random_hash; ?>  
Content-Type: text/html; charset="iso-8859-1" 
Content-Transfer-Encoding: 7bit

<h1>Thank you!</h1>
Thank you for choosing to receive your song through SafeDelivery! You have been charged $0.50 for this service. Your song is attached.

--PHP-alt-<?php echo $random_hash; ?>-- 

--PHP-mixed-<?php echo $random_hash; ?>  
Content-Type: application/zip; name="song.zip"  
Content-Transfer-Encoding: base64  
Content-Disposition: attachment  

<?php echo $attachment; ?> 
--PHP-mixed-<?php echo $random_hash; ?>-- 

<?php 
$message = ob_get_clean(); 
$mail_sent = @mail( $to, $subject, $message, $headers ); 

echo $mail_sent ? "Mail sent" : "Mail failed"; 
