<?php //helper functions
include_once('config.php');

function db_connect() {
	global $db;
	if($db) return $db;

	try {
		$db = new PDO('mysql:host=localhost;dbname=negative_options', DB_USERNAME, DB_PASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch(PDOException $e) {
		print $e->getMessage();
	}
	return $db;
}

function get_ip() {
	return $_SERVER['REMOTE_ADDR'];
}

function runQuery($db, $q, $return = true) {
   try {
      $results = $db->query($q);
      if($return) {
         return $results->fetchAll(PDO::FETCH_ASSOC);
      }
   }
   catch(PDOException $e) {
      print "$q<br>\n";
      print $e->getMessage();
      die;
   }
}

function get_new_treatment() {
	$db = db_connect();
	$tt = 'treatment';
   $q = "SELECT $tt.id, description, count($tt"."_id) as count FROM $tt LEFT JOIN session ON $tt.id = $tt"."_id WHERE $tt.active=1 GROUP by $tt.id ORDER BY count($tt"."_id) ASC";
   $data = runQuery($db, $q, true);

	$min_treatments = array();
	$min_count = $data[0]['count'];

	foreach($data as $row) {
		if($row['count'] != $min_count) {
			break;
		}
		$min_treatments[] = $row;
	}
	$data = $min_treatments;
   $rand_index = array_rand($data);
   return $data[$rand_index]['id'];
}


function enter_new_session($param_hitId, $param_workerId) {
   $db = db_connect();

   $sql = 'INSERT INTO session(ip, param_hitId, param_workerId, treatment_id) VALUES(?,?,?,?)';

   $prep = $db->prepare($sql);
   $prep->execute(array(get_ip(),$param_hitId, $param_workerId, get_new_treatment()));

   $sid = $db->lastInsertId();
   setcookie('sid', $sid, time()+60*60*24*30, '/');
   return $sid;
}

function enter_new_look($data) {
   $param_hitId = '';
   $param_workerId = '';

   if(array_key_exists('param_workerId', $data)) {
      $param_workerId = $data['param_workerId'];
   }

   if(array_key_exists('param_hitId', $data)) {
      $param_hitId = $data['param_hitId'];
   }
	else {
		return -1;
	}

	$time = '';
   if(array_key_exists('time', $data)) {
      $time = $data['time'];
   }      

   $db = db_connect();

   $sql = 'INSERT INTO looks(ip, param_hitId, param_workerId, ts) VALUES(?,?,?, ?)';

   $prep = $db->prepare($sql);
   $prep->execute(array(get_ip(),$param_hitId, $param_workerId, $time));

	return $db->lastInsertId();
}

function edit_session($data, $ignoreOtherData, $prepost) {
	$db = db_connect();
	$fields=array();

	if(array_key_exists('pre_mturk_id',$data)) {
		$fields []= 'pre_mturk_id';
	}

	if(array_key_exists($prepost.'_email',$data)) {
		$fields []= $prepost.'_email';
	}              

	if(!$ignoreOtherData) {
		$data[$prepost.'_info'] = json_encode($data); 
		$fields[] = $prepost.'_info';
	}


	if(array_key_exists('email_sent',$data)) {
		$fields []= 'email_sent';
	}                   

	if($prepost == 'override') {
   	$fields = array_keys($data);
	}


	$fields_str = array_reduce($fields, function($arr, $v) {
		if(!$arr) $arr = array();
      $arr []= $v."=:".$v;
		return $arr;
	});
	$fields_str = implode(',',$fields_str);


	$sid = intval($_COOKIE['sid']);
	$sql = "UPDATE session SET $fields_str WHERE id=:sid";

   $prep = $db->prepare($sql);

	$prep->bindParam(':sid', $sid);

	foreach($fields as $key) {
   	$prep->bindParam(':'.$key, $data[$key]);
	}

	$prep->execute();
}


function has_consented($sid) {
	$db = db_connect();

	$sid = intval($sid);
	$sql = "SELECT consent FROM session WHERE session.id = $sid";

   $data = runQuery($db, $sql, true);
	if(!$data || count($data) < 0) return false;
	return $data[0]['consent'] == 'yes';
}      


function has_finished() {
	$db = db_connect();

	$ip = get_ip();
	$sql = "SELECT id, post_info FROM session WHERE ip = '$ip'";

   $data = runQuery($db, $sql, true);

   if(count($data) > 0) { //we have a session
		$session = $data[0];
		if($session['post_info']) {
      	return true;
		}
	}
	//maybe check here for sid if ip doesnt match

	return false;
}   

 

function getTreatmentForSession($sid) {
	$db = db_connect();

	$sid = intval($sid);
	$sql = "SELECT treatment.* FROM session, treatment WHERE session.treatment_id = treatment.id AND session.id = $sid";

   $data = runQuery($db, $sql, true);
	$treatment = $data[0];

	return $treatment;
}

function getEmailForCurrentSession() {
	if(!array_key_exists('sid', $_COOKIE)) return 'NO SESSION';
	$db = db_connect();

	$sid = intval($_COOKIE['sid']);
	$sql = "SELECT pre_email FROM session WHERE id = $sid";

   $data = runQuery($db, $sql, true);

	return $data[0]['pre_email'];
}             


function recordEvent($session_id, $page_name, $subject_name, $event_name, $current_time) {
	$db = db_connect();

	$sql = 'INSERT INTO page_event(session_id, page_name, subject_name, event_name, ts) VALUES(?,?,?,?, ?)';

   $prep = $db->prepare($sql);
	$prep->execute(array($session_id, $page_name, $subject_name, $event_name, $current_time)); 
}


function multiexplode ($delimiters,$string) {
    
    $ready = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    return  $launch;
}

