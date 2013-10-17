<?php

processSurveyAndCreateSession();


include('thankYouPage.php');
die;







function processSurveyAndCreateSession() {  
	$_REQUEST['action'] = 'connect';
	unset($_REQUEST['action']);
	unset($_REQUEST['prevPage']);
		 
	integrityCheck();

	collapseScale('rps', 9);
	collapseScale('nfc', 9);
	ksort($_REQUEST);
	
	edit_session($_REQUEST, false, 'post');
}

function collapseScale($type, $size) {
	if($type == 'rps' || $type == 'nfc') {
		
		if($type == 'rps') {
			$rev = array(1, 2, 3, 5);
		}
		else {
			$rev = array(1, 3, 4, 5);
		}

		$rpstotal = 0;

		foreach($_REQUEST as $k => $v) {
			if(preg_match('/^'.$type.'(\d)$/', $k, $matches)) {
				$rpsnum = intval($matches[1]);
				
				if(in_array($rpsnum, $rev)) {
					$v = $size+1-$v;
				}

				$rpstotal += $v;
				unset($_REQUEST[$k]);
			}
		}
		$_REQUEST[$type.'total'] = $rpstotal;
	}
} 

function integrityCheck() {
	foreach($_REQUEST as $k => $v) {
		if(preg_match('/^check(\d)$/', $k, $matches)) {
			$correct = intval($matches[1]);
			$check = $v;

			if($check != $correct) {
				?>
				<script>
					alert("You have answered an integrity question incorrectly. Please go back to the survey and read the directions carefully. Then, check your answers and re-submit.");
					window.history.back(-1);
				</script>
				<?php
				die;
			}
			unset($_REQUEST[$k]);
		}
	}
}
