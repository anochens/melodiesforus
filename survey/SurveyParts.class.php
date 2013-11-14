<?php
class SurveyParts {
	public $sections;

	function fillArrays() {
		$integrityPre = 'Please answer the following questions exactly as asked.';
		$integrity = array('pre' => $integrityPre, 'title' => 'Additional questions',
		'data' => array(
		 'check5' => array('label' => 'Please select the rightmost option.', 'type' => 'likert', 'size' => '5'),
		 'check3' => array('label' => 'Please select the middle option.', 'type' => 'likert', 'size' => '5'),
		 'check1' => array('label' => 'Please select the left option.', 'type' => 'likert', 'size' => '5')

		));
		$demoPre = 'Please answer the following demographic questions.';
		$demo = array('pre' => $demoPre, 'title' => 'Survey',
		'data' => array(
			'mturk_id' => array('label' => "What is your Mechanical Turk ID?"),
			'hit_id' => array('label' => 'Which HIT did you accept to get here?', 'type'=>'hidden'),
			'age' => array('label' => 'What is your age (in years)?'),
			'gender' => array('type' => 'radio', 'options' => array('Male', 'Female', 'Decline to answer')),
			'education' => array('label' => 'What is the highest level of education that you have completed?', 'type' => 'radio', 'options' => array('Some high school', 'High school', 'Some college', 'Two year college degree', 'Four year college degree', 'Graduate or professional degree')),
			'country' => array('label' => 'What is your country of origin?', 'type' => 'radio', 'options' => array('United States', 'India', 'Canada', 'None of the above'))
			));

		$nfcPre = "Please indicate the extent to which you agree or disagree with the following statement by marking the circular button of the option you prefer.";
		$nfc = array('pre' => $nfcPre, 'title' => 'Self-assessment', 
		'data' => array(
		 'nfc1' => array('label' => 'I would rather do something that requires little thought than something that is sure to challenge my thinking abilities.', 'type' => 'likert', 'size' => '9'),
		 'nfc2' => array('label' => 'I try to anticipate situations where there is a likely chance I\'ll have to think in depth about something.', 'type' => 'likert', 'size' => '9'),
		 'nfc3' => array('label' => 'I only think as hard as I have to.', 'type' => 'likert', 'size' => '9'),
		 'nfc4' => array('label' => 'The idea of relying on thought to get my way to the top does not appeal to me.', 'type' => 'likert', 'size' => '9'),
		 'nfc5' => array('label' => 'The notion of thinking abstractly is not appealing to me.', 'type' => 'likert', 'size' => '9'),
		));

		$times = array('Daily', 'Weekly', 'Monthly', 'Rarely', 'Never');

		$shopping =  array('title'=>'Shopping questions',
		'data'=>array(
			'shopping_whichSong' => array('label' => 'Which song did you purchase?', 'type' => 'radio', 'options' => array('United States', 'India', 'Canada', 'None of the above')),
			'shopping_oftenPurchase' => array('label' => 'How often do you purchase music online?', 'type' => 'radio', 'options' => $times),
			'shopping_spendPerMonth'=> array('label'=> 'How much do you spend on average per month on music purchases?'),
			'shopping_oftenStreaming' => array('label' => 'How often do you purchase music online?', 'type' => 'radio', 'options' => $times),
		));



		$scamAvoid =  array('title'=>'Online experience questions',
		'data'=>array(
			'scamAvoid_creditCard' => array('label' => 'How often do you check your credit card statements?', 'type' => 'radio', 'options' => $times),
			'scamAvoid_FinePrint' => array('label' => 'How often do you read privacy statements online?', 'type' => 'radio', 'options' => $times),
		));
 
		$badExp =  array('title'=>'Online experience questions',
		'data'=>array(
			'badExp_wrongProductCount' => array('label' => 'How many times have you received the wrong product when order online?', 'type' => 'radio', 'options' => array('0','1-2','3-4','5+')),
			'badExp_didntRemember' => array('label' => 'Have you ever received a product that you did not remember ordering?', 'type' => 'radio', 'options' => array('Yes', 'No')),
			'badExp_beenScamTarget' => array('label' => 'Have you ever been the target of any kind of purchasing scam?', 'type' => 'radio', 'options' => array('Yes', 'No')),
			'badExp_privacyConcern' => array('label' => 'How concerned are you about your privacy online?', 'type' => 'likert', 'left'=>'Not concerned','right'=>'Very concerned'),
			'badExp_securityConcern' => array('label' => 'How concerned are you about your security online?', 'type' => 'likert', 'left'=>'Not concerned','right'=>'Very concerned'),
		));
        


		$comfort =  array('title'=>'Personal Questions', 'pre'=>'Please indicate how much each statement below is like you.',
		'data'=>array(
			'comfort_safeOnline' => array('label' => 'I feel safe when I am on the Internet.', 'type' => 'likert', 'size' => 7),
			'comfort_peaceOnline' => array('label' => 'I often find it peaceful to be online.', 'type' => 'likert', 'size' => 7),
			'comfort_careFreeOnline' => array('label' => 'When I am online, I can be carefree.', 'type' => 'likert', 'size' => 7),
		));                             



		$impulse =  array('title'=>'Personal Questions', 'pre'=>'Please indicate how much each statement below is like you.',
		'data'=>array(
			'impulse_beyondControl' => array('label' => 'My use of the Internet sometimes seems beyond my control.', 'type' => 'likert', 'size' => 7),
			'impulse_dontThinkResponOnline' => array('label' => 'When I am online, I don\'t think about my responsibilities.', 'type' => 'likert', 'size' => 7),
			'impulse_moreCarefulOffline' => array('label' => 'I am more careful purchasing things offline than I am online.', 'type' => 'likert', 'size' => 7),
		)); 

		$safeDelivery =  array('title'=>'SafeDelivery questions',
		'data'=>array(
			'safeDelivery_whatDoes'=> array('label'=> 'What does the SafeDelivery service do?'),
			'safeDelivery_howValuable' => array('label' => 'How valuable is this service?', 'type' => 'likert', 'size' => 5, 'left'=>'Not valuable', 'right'=>'Very valuable'),
		));                                                              

		$this->addComponents($demo, $scamAvoid, $badExp, $shopping, $safeDelivery, $integrity, $impulse, $comfort);
	}

	function __construct($randomizeSections = true, $firstStable = true) {
		$this->fillArrays();
	
		for($i=0;$i<count($this->sections);$i++) {
			$sect = $this->sections[$i];
			$pre = '';
			if(array_key_exists('pre', $sect)) {
				$pre = $sect['pre'];
			}
			$this->sections[$i] = $this->getHtmlFromSurvey($sect['data'], $pre, $sect['title']); 
		}

		if($randomizeSections) {
			if($firstStable) {
         	$first = $this->sections[0];
				$this->sections = array_slice($this->sections, 1);
			}
			shuffle($this->sections);

			if($firstStable) {
				array_unshift($this->sections, $first);
			}
		}
	}

	function addComponents() {
		$components = func_get_args();

		foreach($components as $component) {
			$this->sections[] = $component;
		}
	}

	function getHtmlFromSurvey($survey, $preMsg = '', $title = 'Survey') {
		$result = '';
		$result .= "<legend>$title</legend><fieldset>";
		$result .= "<p class='preMsg'>$preMsg<span class='errorMsgTop'</p><ul>";
		foreach($survey as $param => $details) {
			if(!array_key_exists('value', $details)) {
				$details['value'] = '';
			}
			if(!array_key_exists('type', $details)) {
				$details['type'] = 'text';
			}
			if(!array_key_exists('label', $details)) {
				$details['label'] = "What is your $param?";
			}

			if($details['type'] !='hidden')
				$result .= "<li><label for='$param'>".$details['label']."</label>";
			
			if($details['type'] == 'likert') {
				if(!array_key_exists('left', $details)) {
					$details['left'] = 'totally disagree';
				}
				if(!array_key_exists('right', $details)) {
					$details['right'] = 'totally agree';
				} 

				$size = 5;
				if(array_key_exists('size', $details)) {
					$size = intval($details['size']);
				}
				$result .= '<br><ul><li><span style="float:left;min-width:150px">'.$details['left'].'&nbsp;</span>';

				for($i=1;$i<=$size;$i++) {
					$result .= "<input type='radio' name='$param' id='$param' value='$i'>\n";
				}
				$result .= $details['right'].'&nbsp;</li></ul>';

			}
			elseif($details['type'] == 'radio') {
				$result .= "<br><ul>";
				$i = 0;
				foreach($details['options'] as $option) {
					$result .= "<li>$option<input align='left' name='$param' id='$param' type='".$details['type']."' value='".$i."'></li>\n";
					$i++;
				}
				$result .= '</ul></li>';
			}
			elseif($details['type'] == 'select') {
				$result .= "<br><select id='$param'>";
				$i = 0;
				foreach($details['options'] as $option) {
					$result .= "<option value='$i'>$option</option>\n";
					$i++;
				}
				$result .= '</li>';
			}   
			else {
				$result .= "<input name='$param' id='$param' type='".$details['type']."' value='".$details['value']."'>\n";
				if($details['type'] != 'hidden') {
					$result .= '</li>';
				}
			}
		}
		$result .= '</ul></fieldset><hr>';

		return $result;
	}

	function printSections() {
		foreach($this->sections as $section) {
			print $section;
		}
	}
}    
