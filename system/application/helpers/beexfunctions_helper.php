<?php



function process_days_left($date) {

	$diff = strtotime($date) - time();

	$daysleft = ($diff - ($diff % (60*60*24)))/(60*60*24);

	return ($daysleft >= 0) ? $daysleft : "Time's Up!";

}



function link_to_long($str, $message = 'Click here') {

	return "<a href='".prep_url($str)."' target='_blank'>".((strlen($str) > 15) ? $message : $str)."</a>";

}



function process_video_link($link, $width=400, $height=200) {



	//$link = str_replace(array('width="425"', 'height="344"'), array('width="400"', 'height="250"'), $link);



	$link = preg_replace('/(width)=("[^"]*")/i', 'width="400"', $link);

	$link = preg_replace('/(height)=("[^"]*")/i', 'height="250"', $link);



	$link = substr($link, 0, strpos($link, '</param>')).'<param name="wmode" value="transparent"></param>'.substr($link, strpos($link, "</param>"));



	$link = substr($link, 0, strpos($link, '<embed ')+7).'wmode="transparent" '.substr($link, strpos($link, "<embed ")+7);



	return $link;



}









function generate_input($name, $type, $edit, $value, $array = '', $class = '') {

	$data = array();

	$data['name'] = $date['id'] = $name;

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

		$cell = ($edit) ? form_hidden($name, $value) : $value;

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

function display_default_image($type) {
	return '<img src="/images/imagedefault.png" style="opacity:.4;">';
}


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



function get_special_array($name) {



	$arrays = array(

		// US States Array

		'states' =>  array(

			'' => '',

			'AL'=>"Alabama",

			'AK'=>"Alaska",

			'AZ'=>"Arizona",

			'AR'=>"Arkansas",

			'CA'=>"California",

			'CO'=>"Colorado",

			'CT'=>"Connecticut",

			'DE'=>"Delaware",

			'DC'=>"District Of Columbia",

			'FL'=>"Florida",

			'GA'=>"Georgia",

			'HI'=>"Hawaii",

			'ID'=>"Idaho",

			'IL'=>"Illinois",

			'IN'=>"Indiana",

			'IA'=>"Iowa",

			'KS'=>"Kansas",

			'KY'=>"Kentucky",

			'LA'=>"Louisiana",

			'ME'=>"Maine",

			'MD'=>"Maryland",

			'MA'=>"Massachusetts",

			'MI'=>"Michigan",

			'MN'=>"Minnesota",

			'MS'=>"Mississippi",

			'MO'=>"Missouri",

			'MT'=>"Montana",

			'NE'=>"Nebraska",

			'NV'=>"Nevada",

			'NH'=>"New Hampshire",

			'NJ'=>"New Jersey",

			'NM'=>"New Mexico",

			'NY'=>"New York",

			'NC'=>"North Carolina",

			'ND'=>"North Dakota",

			'OH'=>"Ohio",

			'OK'=>"Oklahoma",

			'OR'=>"Oregon",

			'PA'=>"Pennsylvania",

			'RI'=>"Rhode Island",

			'SC'=>"South Carolina",

			'SD'=>"South Dakota",

			'TN'=>"Tennessee",

			'TX'=>"Texas",

			'UT'=>"Utah",

			'VT'=>"Vermont",

			'VA'=>"Virginia",

			'WA'=>"Washington",

			'WV'=>"West Virginia",

			'WI'=>"Wisconsin",

			'WY'=>"Wyoming"

		),



		'networks' => array (

			'Brooklyn' => 'Brooklyn',

			'Chicago' => 'Chicago',

			'Los Angeles' => 'Los Angeles'

		),



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



function beex_mail($address, $type, $replyto = 'folks@beex.org', $item = '') {



	$headers  = 'MIME-Version: 1.0' . "\r\n";

	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	$headers .= 'From: '.$replyto. "\r\n" .

    'Reply-To: '.$replyto . "\r\n";



	if($type == 'registration') {



		$subject = "Welcome to BEEx.org";

		$message = "Welcome to BEEx.org. You must now verify you email address. Click ".anchor('user/entercode/'.$item['user_id'].'/'.$item['code'], 'here')." to vailidate, or paste the link below into your browser.<br><br>

".site_url('user/entercode/'.$item['user_id'].'/'.$item['code'])."

<br><br>

BEEx is a social fundraising service.  Our mission is to provide you with extraordinary tools to raise money from your social network and beyond.  Our first application is a challenge-based fundraising application.  It's extremely simple: you declare that you'll perform an action if a specific amount of money is raised  for the nonprofit organization of your choice.  Ex.  Devin will shave his head if $1000 is raised for The Ubuntu Education Fund.  We provide you with an attractive and functional challenge page, social networking tools (Facebook App, blog widget), emailing and more.  We think BEEx.org is the best challenge-based fundraising tool around but we're going to make it much much better.

<br><br>

For more information about clusters, challenges and BEEx, check out our blog at <a href='http://blog.beex.org'>blog.beex.org</a>.

<br><br>

live free,

thefolks@beex.org";







	}



	if($type == 'admininvite') {



		$subject = "You've been asked to join a cluster fundraising initiative on BEEx.org";



		$message = "Dear ".$item['name'].",

<br><br>

You've been invited to join the ".$item['cluster']['name']." Cluster on BEEx.org.

<br><br>

By joining a cluster, you will be creating your own fund raising page on BEEx.org.

<br><br>

In order to join, click ".anchor('cluster/joina/'.$item['cluster']['id'], 'this link')." or type in the following cluster code at the 'Join a Cluster' field on the BEEx homepage.

<br><br>

Cluster code: ".($item['cluster']['id'] * 3459)."

<br><br>

For more information about clusters, challenges and BEEx, check out our blog at <a href='http://blog.beex.org'>blog.beex.org</a>.

<br><br>

live free,

thefolks@beex.org";

	}
	
	
	if($type == 'teammate') {



		$subject = "You've been asked to be part of a fundraising team on BEEx.org";



		$message = "Dear ".$item['name'].",

<br><br>You've been invited to be apart of the team raising money by participating in the ".anchor('challenge/view/'.$item['challenge']['id'],$item['challenge']['name'])." challenge on BEEx.org.

<br><br>

If you cannot click the link above, copy and paste the following into your web browser:
<br><br>
http://www.beex.org/index.php/challenge/view/".$item['challenge']['id']."
<br><br>";

		if(@$item['password']) {
			
			$message .= "You have been automatically generated an account on BEEx.org. To activate it, log in by clicking ".anchor('user/login/', 'this link').". You can use this email address and the password below:
			<br><br>
			password: ".$item['password']."<br><br>
			
			If you cannot click the link above, copy and paste the following into your web browser to login:<br><br>
			
			http://www.beex.org/index.php/user/login";
			
		}

		$message .= "For more information about clusters, challenges and BEEx, check out our blog at <a href='http://blog.beex.org'>blog.beex.org</a>.

<br><br>

live free,

thefolks@beex.org";

	}


 
	mail($address, $subject, $message, $headers);







}



?>