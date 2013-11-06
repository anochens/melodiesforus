<?php //helper functions
include_once('functions.php');


if(!array_key_exists('sid', $_COOKIE)) {
	header("Location: /consent.php");
	die;
}


//move to intro page
include('intro.php');
