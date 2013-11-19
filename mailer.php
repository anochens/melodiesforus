<?php

//based on http://goo.gl/k1UJrC

date_default_timezone_set("America/New_York");
$random_hash = md5(date('r', time())); 

if(!isset($to))
	$to = '';

if(!isset($songId))
	$songId=2;

$subject = 'SafeDelivery: Your song';
$headers = "From: admin@safedelivery.com\r\nReply-To: noreply@safedelivery.com"; 
$headers .= "\r\nContent-Type: multipart/mixed; boundary=\"PHP-mixed-".$random_hash."\""; 
$attachment = chunk_split(base64_encode(file_get_contents("songs/$songId.zip"))); 
 

$message = <<<EOT
--PHP-mixed-$random_hash  
Content-Type: multipart/alternative; boundary="PHP-alt-$random_hash" 
 
--PHP-alt-$random_hash  
Content-Type: text/plain; charset="iso-8859-1" 
Content-Transfer-Encoding: 7bit

You must enable HTML email to read this message.


--PHP-alt-$random_hash  
Content-Type: text/html; charset="iso-8859-1" 
Content-Transfer-Encoding: 7bit

<p>
Thank you for choosing to receive your song through SafeDelivery! Your song is attached.
</p>

--PHP-alt-$random_hash--

--PHP-mixed-$random_hash  
Content-Type: application/zip; name="song.zip"  
Content-Transfer-Encoding: base64  
Content-Disposition: attachment  

$attachment  
--PHP-mixed-$random_hash-- 
            

EOT;

$mail_sent = @mail( $to, $subject, $message, $headers );
echo $mail_sent ? "Mail sent" : "Mail failed";
die;
?>

