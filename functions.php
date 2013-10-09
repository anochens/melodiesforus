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
   return $data[$rand_index];
}

function enter_new_session() {
	$db = db_connect();

	$new_treatment = get_new_treatment();
	$new_id = $new_treatment['id'];
	$sql = 'INSERT INTO session(ip, treatment_id) VALUES(?,?)';

   $prep = $db->prepare($sql);
	$prep->execute(array(get_ip(),$new_id));

	//set a cookie with the session id to use for logging later
	$sid = $db->lastInsertId();
	setcookie('sid', $sid, time()+60*60*24*30);

	$sql = "SELECT treatment.* FROM session, treatment WHERE session.treatment_id = treatment.id AND session.id = $sid";

   $data = runQuery($db, $sql, true);
	$treatment = $data[0];
 
	setcookie('treatment-id', $treatment['id'], time()+60*60*24*30);
	setcookie('treatment-description', $treatment['description'], time()+60*60*24*30);
	setcookie('opt', $treatment['opt'], time()+60*60*24*30);
	setcookie('pre-pop', $treatment['pre-pop'], time()+60*60*24*30);
}


function recordEvent($session_id, $page_name, $subject_name, $event_name, $current_time) {
	$db = db_connect();

	$sql = 'INSERT INTO page_event(session_id, page_name, subject_name, event_name, ts) VALUES(?,?,?,?, ?)';

   $prep = $db->prepare($sql);
	$prep->execute(array($session_id, $page_name, $subject_name, $event_name, $current_time)); 
}
