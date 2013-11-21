<?php

include('functions.php');

$id = enter_new_look($_REQUEST);

if($id == -1) {
	die('{"err":"hitId not specified"}');
}

if($id == 0) {
	die('{"err":"generic error"}');
}                                   

die('{"msg":"Created look #'.$id.'"}');
