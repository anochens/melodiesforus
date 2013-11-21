<?php
//This script gives qualifications approvals, and bonuses.
//Each of these can be turned off with vars here.
//The default is to do a dry run, unless realrun.txt contains a 1.
//This script excludes action on mturk_ids that are in affected.csv.
//BE CAREFUL!
$giveQuals = true;
$approve = false;
$giveBonus = true;

$bonus_file = 'outfile.csv';
$record_file = 'affected.csv';
$realrun_file ='realrun.txt';

$dry = 1-intval(@file_get_contents($realrun_file));

$previously_affected = file_get_contents($record_file);
$previously_affected = explode(',', $previously_affected);
$previously_affected = array_unique($previously_affected);


$mturk = new MechanicalTurk(MTURK_KEY, MTURK_SECRET);


if($dry) {
	print "This is a DRY RUN. The actions below are NOT happening for real.\n";
}
else {
	print "This is NOT a dry run. The actions below ARE happening for real.\n";
}

include(dirname(__FILE__).'/MechanicalTurk.class.php');



//READ BONUS DATA FROM CSV FILE (from python script)
$ndata = array();
$headers = array();
$line = 0;
if (($handle = fopen($bonus_file, "r")) !== FALSE) {
	while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
		$nrow = array();
		$num = count($data);
		if($line == 0) { //get and store the header data
			$headers = $data;
			$line++;
			continue;
		}
		for ($c=0; $c < $num; $c++) {
			if($c < count($headers)) {
				$nrow[$headers[$c]] = $data[$c];
			}
		}
		$bonus_data[] = $nrow;
		$line++;
	}
	fclose($handle);
}


print_r($bonus_data);
die;

//make and array of mturk_id => bonus
$bonuses = array();
$wids= array();
foreach($bonus_data as $run) {
	if(!array_key_exists($run['mturk_id'], $bonuses)) {
		if($run['mturk_id'] != 'Naomi')
   	$bonuses[strtoupper(trim($run['mturk_id']))] = trim($run['total_bonus']);
   	$wids[] = strtoupper(trim($run['mturk_id']));
	}
}

$reason = 'This bonus is for the completion of the Music Purchasing Study task on 11/20/2013. Due to server problems, we were unable to recover your data, and therefore can only pay you the base payment of $0.50 for completing the task. Thank you.';

//GRANT BONUS
$total_bonus = 0;
$j = 0;
if($giveBonus) {
	for($i=0;$i<count($wids);$i++) {
		$wid =$wids[$i];
		if(in_array($wid, $previously_affected)) {
			continue;
		}
		
		if(array_key_exists($wid, $bonuses)) {
			$total_bonus += $bonuses[$wid];
			if(!$dry) {
				$mturk->grantBonus($wid, $aids[$i], $bonuses[$wid], $reason);
				$mturk->assignQualification(QUAL_ID, $wid, '1'); 
			} 
			$j++;
		}
		else {
      	unset($wids[$i]);
		}   

	}
	print "Paid $j people bonuses (total $$total_bonus).\n";
}
else {
	print "Giving bonuses is OFF.\n";
}


//Record affected mturk_ids
sort($wids);
$affected = '';
for($i=0;$i<count($wids);$i++) {
   $affected .= $wids[$i].',';
}

if($dry) {
	print "NOT recording affected ids to $record_file\n";
}
else {
	print 'Recorded affected ids.\n';
	file_put_contents($record_file, $affected);
	file_put_contents($realrun_file, '0'); //only 1 real run at a time
}

