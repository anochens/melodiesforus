<?php


$override = false;
if(array_key_exists('override', $_COOKIE)) {
	$override = true;
}

if(array_key_exists('override', $_REQUEST)) {
	setcookie("override", 'true', time()+3600); //1 hour
	$override = true;
}

if(!$override) {
	die('This experiment is now closed. Thank you for your participation.');
}

include_once('functions.php');

function redir($page, $includeQuery = false) {
	$base = basename($_SERVER["SCRIPT_FILENAME"]);
	if($page == $base || $page == "/$base") {
   	return; //don't redirect if we are already on the page
	}
	if($includeQuery) {
		if($_SERVER['QUERY_STRING']) {
			$page .= "?".$_SERVER['QUERY_STRING'];
		}
	}
	header("Location: $page");

	die;
}

if(!array_key_exists('sid', $_COOKIE)) {
	redir("consent.php", true);
	die;
}


$sid = intval($_COOKIE['sid']);
$last_page = get_last_page($sid);

if($last_page == 'undef') {
	redir('consent.php', true);
}
else{
	redir($last_page, true);
}
