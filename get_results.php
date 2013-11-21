<?php
include('functions.php');

date_default_timezone_set('America/New_York');
$date = date('m-d-Y', time());

if(!array_key_exists('online', $_GET)) {
	header("Content-type: text/csv");
	header("Content-Disposition: attachment; filename=data$date.csv");
	header("Pragma: no-cache");
	header("Expires: 0");
}
else {
	print "<pre>";
}

function init() {
	$db = db_connect();
	get_entry_data($db);
}

function get_entry_data($db) {
	$q = "SELECT * FROM session";

	try {
		$results = $db->query($q);
		$data = $results->fetchAll(PDO::FETCH_ASSOC);
	}
	catch(PDOException $e) {
   	print $e->getMessage();
	}
 	
	$headers = array();
	$headersSet = false;

	$ignore = array('sid','mturk_id','pre_email','pre_mturk_id');

	for($i=0;$i<count($data);$i++) {
		$row2 = array();
		$row3 = array();
		$data[$i]['finished'] = ($data[$i]['post_info'] != '') ? 'true':'false';

      $data[$i]['bonus'] = 'NO FINISH';
		if($data[$i]['finished'] == 'true') {
			$data[$i]['bonus'] = 0.51;

			if($data[$i]['email_sent'] == 'true') {
				$data[$i]['bonus'] = 0.01;
			}
		}

      $data[$i]['email_matches_pre_post'] = 'undef';

		if($data[$i]['post_email'] != 'undef' && $data[$i]['post_email'] != '') {
			if($data[$i]['pre_email'] == $data[$i]['post_email']) {
				$data[$i]['email_matches_pre_post'] = 'true';
			}
			else {
				$data[$i]['email_matches_pre_post'] = 'false';
			}
		}

      $data[$i]['last_page'] = 'undef';

		if($data[$i]['finished'] == 'true') {
			$data[$i]['last_page'] = 'FINISHED';
		}
		else {
			$q = "SELECT page_name FROM page_event WHERE session_id=".$data[$i]['id']." ORDER BY id DESC LIMIT 1";
			$r = $db->query($q);
			$last_page= $r->fetchAll(PDO::FETCH_ASSOC);
			if($last_page && count($last_page) > 0) {
				$last_page = $last_page[0]['page_name'];
				$data[$i]['last_page'] = $last_page;
			}
		}



		foreach($data[$i] as $k=>$v) {
			
			if($k == 'pre_info' || $k == 'post_info') {
         	$info = json_decode($v, true);
				$data[$i][$k] = 'expanded';

				if(!$info) continue;

				foreach($info as $k2=>$v2) {
					if(in_array($k2, $ignore)) continue;

					$data[$i][$k2] = $v2;
				}
			}
		}
	}

	
	$headers = array_keys($data[0]);
	for($i=1;$i<count($data);$i++) {
		$headers2 = array_keys($data[$i]);
		if(count($headers2) > count($headers)) {
      	$headers = $headers2;
		}
	}

	for($i=0;$i<count($data);$i++) {
		foreach($headers as $h) {
      	if(!array_key_exists($h, $data[$i])) {
				$data[$i][$h] = 'undef';
			}
		}
	}

	$stdout = fopen('php://output','w');
	fputcsv($stdout,$headers);
	foreach($data as $row) {
		fputcsv($stdout,$row);
	}
}

init();
