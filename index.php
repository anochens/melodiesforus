<?php //helper functions
include_once('functions.php');


$hitId = '';
$workerId = '';
if(array_key_exists('param_hitId', $_REQUEST)) {
	$hitId = $_REQUEST['param_hitId'];
}

if(array_key_exists('param_workerId', $_REQUEST)) {
	$workerId = $_REQUEST['param_workerId'];
}                                 


if(array_key_exists('override', $_REQUEST)) {
	$hitId = 'testing_hit_id';
	$workerId = 'test_mturk_id';
}        

if(!$hitId) {
	if(!array_key_exists('sid', $_COOKIE)) {
		echo "You cannot access this page directly. You need to accept the HIT and then come here through the consent form.";
		die;
	}
}

//dont make a new session if we already have one
if(!array_key_exists('sid', $_COOKIE)) {
	$sid = enter_new_session($hitId, $workerId);
}


//move to intro page
include('intro.php');
