<?php

include('functions.php');

$sid = enter_new_look($_REQUEST['param_hitId']);

header('Content-Type: application/json');
die(json_encode(array('sid'=>$sid)));
