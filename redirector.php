<?php
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

if(has_finished(-1)) {
	redir("/thankYouPage.php");
}
else {

	if(!array_key_exists('sid', $_COOKIE)) {
		redir("/consent.php", true);
	}
	else {

		$sid = intval($_COOKIE['sid']);

		if(!has_consented($sid)) {
			redir("/consent.php", true);
		}
		else {

			if(!has_done_presurvey($sid)) {
				if("index.php" != basename($_SERVER["SCRIPT_FILENAME"]))
         	redir("/shopping.php");
			}
			else {

				if(!has_seen_negative_option($sid)) { //pre survey done
					redir('purchase.php', true);
					//go to negative options page
				}
				else {
					if(has_finished($sid)) {
						redir("/thankYouPage.php");
					}                      
					else {
                	redir('/endSurvey.php');
					}
				}
			}
		}
	}
}         
