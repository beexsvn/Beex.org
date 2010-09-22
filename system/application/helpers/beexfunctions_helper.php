<?php

/* Process Days Left: Function to get the number of days left in a challenge */
function process_days_left($date) {

	$diff = strtotime($date) - time();

	$daysleft = ($diff - ($diff % (60*60*24)))/(60*60*24);

	return ($daysleft >= 0) ? $daysleft : "0";

}

/* Get Facebook Cookie: Function to communicate with facebook */
function get_facebook_cookie($app_id, $application_secret) {
  $args = array();

  if(isset($_COOKIE['fbs_'.$app_id])) {
	  parse_str(trim($_COOKIE['fbs_' . $app_id], '\\"'), $args);
	  ksort($args);
	  $payload = '';
	  foreach ($args as $key => $value) {
	    if ($key != 'sig') {
	      $payload .= $key . '=' . $value;
	    }
	  }
	  if (md5($payload . $application_secret) != $args['sig']) {
	    return null;
	  }
	  return $args;
  }
  return null;
}

/* Check Email Address: Makes sure that a string is a valid email address */
function check_email_address($email) {
  // First, we check that there's one @ symbol, 
  // and that the lengths are right.
  if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
    // Email invalid because wrong number of characters 
    // in one section or wrong number of @ symbols.
    return false;
  }
  // Split it into sections to make life easier
  $email_array = explode("@", $email);
  $local_array = explode(".", $email_array[0]);
  for ($i = 0; $i < sizeof($local_array); $i++) {
    if
(!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&
↪'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$",
$local_array[$i])) {
      return false;
    }
  }
  // Check if domain is IP. If not, 
  // it should be valid domain name
  if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) {
    $domain_array = explode(".", $email_array[1]);
    if (sizeof($domain_array) < 2) {
        return false; // Not enough parts to domain
    }
    for ($i = 0; $i < sizeof($domain_array); $i++) {
      if
(!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|
↪([A-Za-z0-9]+))$",
$domain_array[$i])) {
        return false;
      }
    }
  }
  return true;
}

/* Link To Long: Function to check if a string will fit on one line in it's container. Otherwise it generates a shorter message and a tooltip with the full link*/
function link_to_long($str, $message = 'Click here', $len = 15) {
	
	$class = '';
	if(strlen($str) > $len) {
		$class = ' class="link_to_long" title="'.$str.'"';
	}
	
	return "<a href='".prep_url($str)."' target='_blank'".$class.">".((strlen($str) > $len) ? $message : $str)."</a>";

}

/* Process Video Link: Function to take video link and generate embed code for video links */
function process_video_link($link, $width=310, $height=222) {


	//Check if video is YouTube
	if(substr($link, 0, 31) == 'http://www.youtube.com/watch?v=') {
	
	$vidparser = parse_url($link);
	parse_str($vidparser['query'], $query);
	$vid_code = ($query['v']);
	
	
	$link = '<object width="'.$width.'" height="'.$height.'">
	<param name="movie" value="http://www.youtube.com/v/'.$vid_code.'?fs=1"></param>
	<param name="allowFullScreen" value="true"></param>
	<param name="wmode" value="transparent"></param>
	<embed src="http://www.youtube.com/v/'.$vid_code.'?&fs=1"
	type="application/x-shockwave-flash"
	width="'.$width.'" height="'.$height.'"
	allowfullscreen="true" wmode="transparent"></embed>
	</object>';
	
	}
	
	// Check if video is vimeo
	elseif($position = strpos($link,'vimeo.com/')) {
	
	$oembed_endpoint = 'http://www.vimeo.com/api/oembed';
	$json_url = $oembed_endpoint.'.json?url='.rawurlencode($link);
	$xml_url = $oembed_endpoint.'.xml?url='.rawurlencode($link);
	$curl = curl_init($xml_url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_TIMEOUT, 30);
	$curl_return = curl_exec($curl);
	curl_close($curl);
	$oembed = simplexml_load_string($curl_return);
	$link = html_entity_decode($oembed->html);
	
	
	$link = preg_replace('/(width)=("[^"]*")/i', 'width="'.$width.'"', $link);
	$link = preg_replace('/(height)=("[^"]*")/i', 'height="'.$height.'"', $link);
	$link = substr($link, 0, strpos($link, '</param>')).'<param name="wmode" value="transparent"></param>'.substr($link, strpos($link, "</param>"));
	$link = substr($link, 0, strpos($link, '<embed ')+7).'wmode="transparent" '.substr($link, strpos($link, "<embed ")+7);
	
	
	}
	//the ELSE condition is accessed when a user likely pastes in some EMBED code
	
	elseif(strpos($link, '<embed')) {
	$link = preg_replace('/(width)=("[^"]*")/i', 'width="'.$width.'"', $link);
	$link = preg_replace('/(height)=("[^"]*")/i', 'height="'.$height.'"', $link);
	$link = substr($link, 0, strpos($link, '</param>')).'<param name="wmode" value="transparent"></param>'.substr($link, strpos($link, "</param>"));
	$link = substr($link, 0, strpos($link, '<embed ')+7).'wmode="transparent" '.substr($link, strpos($link, "<embed ")+7);
	} 
	
	else {
		return 'wrong_type';
	}
	
	return $link;

}

/* Get Vimeo Info: Used to get attributes from vimeo */
function get_vimeo_info($id, $info = 'thumbnail_medium') {
	if (!function_exists('curl_init')) die('CURL is not installed!');
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://vimeo.com/api/v2/video/".$id.".php");
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	$output = unserialize(curl_exec($ch));
	$output = $output[0][$info];
	curl_close($ch);
	return $output;
}


/* Get Video Thumbnail: Process what kind of video and then get it */
function get_video_thumbnail($link) {


	//Check if video is YouTube
	if(substr($link, 0, 31) == 'http://www.youtube.com/watch?v=') {
	
		$vidparser = parse_url($link);
		parse_str($vidparser['query'], $query);
		$vid_code = ($query['v']);
	
		if($vid_code) {
			return "http://img.youtube.com/vi/".$vid_code."/1.jpg";
		}
		return '';
	
	}
	
	// Check if video is vimeo
	elseif($position = strpos($link,'vimeo.com/')) {
		
		$id = substr($link, $position+strlen('vimeo.com/'));
		
		$thumb = get_vimeo_info($id);
		
		return ($thumb) ? $thumb : '';
	
	}
	
	//the ELSE condition is accessed when a user likely pastes in some EMBED code
	else {
		return '';
	}

}

 
/* DEFUNCT Process Video Link Too: Function to correctly size youtube video */
function process_video_link_too($link, $width=400, $height=200) {

	//$link = str_replace(array('width="425"', 'height="344"'), array('width="400"', 'height="250"'), $link);
	$link = preg_replace('/(width)=("[^"]*")/i', 'width="400"', $link);
	$link = preg_replace('/(height)=("[^"]*")/i', 'height="250"', $link);

	$link = substr($link, 0, strpos($link, '</param>')).'<param name="wmode" value="transparent"></param>'.substr($link, strpos($link, "</param>"));

	$link = substr($link, 0, strpos($link, '<embed ')+7).'wmode="transparent" '.substr($link, strpos($link, "<embed ")+7);

	return $link;
}

/* Word Too Long: Function to check if a block of text will have a word that will be too big for it's container */
function word_too_long($string, $maxchars = 25) {
	
	$len = 0;
	
	if($string) {
		$words = explode(' ', $string);

		foreach($words as $word) {
			
			if(strlen($word) > $len) {
				$len = strlen($word);	
			}
		}
	}
	
	return ($len > $maxchars) ? true : false;
	
}

/* Generate Input: Wrapper function to generate forms */
function generate_input($name, $type, $edit, $value, $array = '', $class = '', $texttype = '', $vars = '') {

	$data = array();
	
	$data['id'] = $name;
	$data['name'] = $name;
	
	if(is_array($vars)) {
		foreach($vars as $key=>$val) {
			$data[$key] = $val;
		}
	}

	if(is_array($class)) {
		foreach($class as $key=>$val) {
			$data[$key] = $val;
		}
	}

	else {
		$data['class'] = $class;
	}



	if($type == 'input') {
		$data['value'] = $value;
		$cell = ($edit) ? form_input($data) : $value;
	}

	if($type == 'password') {
		$cell = ($edit) ? form_password($data) : $value;
	}

	if($type == 'hidden') {
		$data['value'] = $value;
		$extra = array('value' => $value, 'id' => $name);
		$cell = ($edit) ? form_hidden($name, $extra) : $value;

	}

	if($type == 'text') {
		$data['value'] = $value;
		$cell = ($edit) ? form_textarea($data) : $value;
	}

	if($type == 'dropdown') {
		$cell = ($edit) ? form_dropdown($name, $array, $value) : $value;
	}

	if($type == 'file') {
		$data['value'] = $value;
		$cell = ($edit) ? form_upload($data) : $value;
	}

	if($type == 'check') {

		$data;

	}

	return $cell;



}


/* Display Default Image: Function for displaying the default image when user/npo/challenge/cluster has uploaded no media */
function display_default_image($type, $src = false) {
	
	$style = '';
	if($type == 'profile') {
		$image = 'profile_default.png';
	}
	elseif($type == 'npo') {
		$image = 'npo_default.png';
	}
	elseif($type == 'challenge') {
		$image = 'challenge_default.png';
	}
	elseif($type == 'cluster') {
		$image = 'cluster_default.png';
	}
	else {
		$image = 'imagedefault.png';
		$style = 'style="opacity:.4"';
	}
	
	if(!$src) {
		return '<img src="'.base_url().'images/defaults/'.$image.'" '.$style.' />';
	}
	else {
		return base_url().'images/defaults/'.$image;
	}
}

/* Generate Password: Simple password generating function */
function generate_password ($length = 8)
	{

	  // start with a blank password
	  $password = "";

	  // define possible characters
	  $possible = "0123456789bcdfghjkmnpqrstvwxyz"; 

	  // set up a counter
	  $i = 0; 

	  // add random characters to $password until $length is reached
	  while ($i < $length) { 

	    // pick a random character from the possible ones
	    $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);

	    // we don't want this character if it's already in the password
	    if (!strstr($password, $char)) { 
	      $password .= $char;
	      $i++;
	    }

	  }

	  // done!
	  return $password;

	}



function time_left($date) {

	return round((strtotime($date) - time()) / (60 * 60 * 24));

}


/* Get Special Array: Stores commonly used arrays found in the forms of the site */
function get_special_array($name) {


	// US States Array
	$arrays = array(

		'states' =>  array(

			'' => '', 'AL'=>"Alabama", 'AK'=>"Alaska", 'AZ'=>"Arizona",	'AR'=>"Arkansas",'CA'=>"California", 'CO'=>"Colorado",'CT'=>"Connecticut",'DE'=>"Delaware",'DC'=>"District Of Columbia",	'FL'=>"Florida", 'GA'=>"Georgia",'HI'=>"Hawaii",	'ID'=>"Idaho",'IL'=>"Illinois",	'IN'=>"Indiana",'IA'=>"Iowa",'KS'=>"Kansas", 'KY'=>"Kentucky",'LA'=>"Louisiana",	'ME'=>"Maine",'MD'=>"Maryland",	'MA'=>"Massachusetts",	'MI'=>"Michigan", 	'MN'=>"Minnesota",'MS'=>"Mississippi",'MO'=>"Missouri",'MT'=>"Montana",'NE'=>"Nebraska",'NV'=>"Nevada",	'NH'=>"New Hampshire",'NJ'=>"New Jersey",'NM'=>"New Mexico",'NY'=>"New York",'NC'=>"North Carolina",'ND'=>"North Dakota",'OH'=>"Ohio",'OK'=>"Oklahoma",'OR'=>"Oregon",'PA'=>"Pennsylvania",'RI'=>"Rhode Island",	'SC'=>"South Carolina",'SD'=>"South Dakota",'TN'=>"Tennessee",'TX'=>"Texas",'UT'=>"Utah",'VT'=>"Vermont",'VA'=>"Virginia",	'WA'=>"Washington", 'WV'=>"West Virginia",'WI'=>"Wisconsin",'WY'=>"Wyoming"

		),
		
		// Attendance answer array
		
		'attend' => array (
			'' => '',
			'anyone' => 'Yes, anyone can attend',
		    'donors' => 'Only donors',
		    'invited' => 'Invited guests',
			'none' => 'No, people cannot attend'
		)
	);

	return $arrays[$name];
}

/* Get Item Image: Function for retunring the appropriate sized image tag */
function get_item_image($type, $id, $image, $size = 'sized', $class='', $return = FALSE) {
	
	$class_text = '';
	if($class) {
		$class_text = 'class="'.$class.'"';
	}
	if($return) {
		return "<img $class_text src='".base_url()."media/".$type."/".$id."/".$size.'_'.$image."' />";
	}
	else {
		echo "<img $class_text src='".base_url()."media/".$type."/".$id."/".$size.'_'.$image."' />";
	}
	
	
}



?>