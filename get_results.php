<?php
include('functions.php');
include('BigInteger.php');

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
	$q = "SELECT session.*, treatment.opt as opt, `pre-pop` as pre_pop FROM session, treatment WHERE session.treatment_id=treatment.id";


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


	$q = "SELECT * FROM page_event WHERE event_name='load' OR page_name='purchase.php' OR subject_name='secondStage' ORDER BY session_id ASC, ts_ms ASC";
	$r = $db->query($q);
	$all_event_data= $r->fetchAll(PDO::FETCH_ASSOC);

	for($i=0;$i<count($data);$i++) {
		$row2 = array();
		$row3 = array();
		$data[$i]['finished'] = ($data[$i]['post_info'] != '') ? 'true':'false';

      $data[$i]['email_sent'] = explode('|', $data[$i]['email_sent']);

		$data[$i]['email_sent_revised_matches'] = 'undef';
		if(count($data[$i]['email_sent']) > 1) 
			$data[$i]['email_sent_revised_matches'] = $data[$i]['email_sent'][1]; 

		$data[$i]['total_time_mins'] = 'NO FINISH';
		
		
		$data[$i]['email_sent'] = $data[$i]['email_sent'][0];  





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


	//here is where the condition was taken out is pre_survey true
		$data[$i]['purchase_page_mins'] = 'NEVER REACHED';
		$data[$i]['total_time_mins'] = 'NEVER REACHED';

		$last_page='undef';


		$load_purchase_page = 'ERROR';
		$close_purchase_page = 'ERROR';

		$load_first_page = 'ERROR';
		$close_last_page = 'ERROR';
		$sid = intval($data[$i]['id']);

		for($j=0;$j<count($all_event_data);$j++) {
			$e_sid = intval($all_event_data[$j]['session_id']);

			if($e_sid < $sid) {
				continue;
			}
			elseif($e_sid > $sid) {
				$close_last_page = new Math_BigInteger($all_event_data[$j-1]['ts_ms']);
				$last_page = $all_event_data[$j-1];
				break;
			}  

			//only if we are in the right session
			$e = $all_event_data[$j];

			//this is the first event for this session
			if($j == 0 || ($j>0 && intval($all_event_data[$j-1]['session_id']) < $sid)) {
				$load_first_page = new Math_BigInteger($e['ts_ms']);
				$close_last_page = new Math_BigInteger($e['ts_ms']);
			}


			if($all_event_data[$j]['page_name'] == 'purchase.php') {
				$event_name  = $e['event_name'];
				$subject_name  = $e['subject_name'];
				if($event_name == 'load') {
					$load_purchase_page = new Math_BigInteger($e['ts_ms']);
				}
				elseif($subject_name != 'page') {
					$close_purchase_page = new Math_BigInteger($e['ts_ms']);
					//break;
				}
			}

			if($close_purchase_page != 'ERROR') {
				$data[$i]['purchase_page_mins'] = $close_purchase_page->subtract($load_purchase_page)->toString(); 
				$data[$i]['purchase_page_mins'] = round(intval($data[$i]['purchase_page_mins'])/1000/60,2);

			}
			else {
				$data[$i]['purchase_page_mins'] = 'DROPPED';

			}

			$data[$i]['total_time_mins'] = $close_last_page->subtract($load_first_page)->toString(); 
			$data[$i]['total_time_mins'] = round(intval($data[$i]['total_time_mins'])/1000/60,2);

		}

		////////////

      $data[$i]['last_page'] = 'undef';

		if($data[$i]['finished'] == 'true') {
			$data[$i]['last_page'] = 'FINISHED';
		}
		else {
			$data[$i]['last_page'] = $last_page['page_name'];

			if($last_page['subject_name'] == 'secondStage') {
				$data[$i]['last_page'] = 'secondStage';
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
