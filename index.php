<?php //helper functions
include_once('functions.php');

$ref='NONE';
if(array_key_exists('HTTP_REFERER', $_SERVER)) {
	$ref=$_SERVER['HTTP_REFERER'];
}
$ref = explode('/',$ref);
$ref = $ref[count($ref)-1];

$ref = explode('?', $ref);
$ref = $ref[0];

if($ref == 'consent.php' && array_key_exists('consent', $_GET) && $_GET['consent'] == 'yes') {
	edit_session(array('consent'=>'yes'),true, 'override'); 
}





if(!array_key_exists('sid', $_COOKIE) || !has_consented($_COOKIE['sid'])) {
	header("Location: /consent.php?".$_SERVER['QUERY_STRING']);
	die;
}


//move to intro page
include('intro.php');
