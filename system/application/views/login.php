<?php

$this->load->view('framework/header', $header);

if($message) {
    echo "<p class='message'>".$message."<span class='val_errors'>";
    echo validation_errors();
    echo "</span></p>";
}

?>


<?php


$attributes = array('id' => 'login', 'class'=>'form', 'style'=>'width:600px; margin:0px auto;');
echo form_open('user/login', $attributes);

echo "<h2>".$header['title']."</h2>";

if(isset($fb_no_email) && $fb_no_email) {
    echo "";
}
else {
    echo "<p>Please enter your login credentials (".anchor('user/forgot', 'Forgot your password?').")</p>";
}

if(isset($fb_no_email) && $fb_no_email) {
	
	echo "<p class='fb_message'>We see you are logged into Facebook. Please enter your current Beex.org email and password to connect your accounts. This will make it incredibly easy to post your Beex.org challenge updates incredibly easy to facebook! If you are new to Beex.org, enter just your email to create and link a new Beex.org account.";
	
	$data = array('name'=>'fb_connect_email', 'id'=>'fb_connect_email');
	echo "<div class='form_element'>
			<label>Email</label>
			<div class='input_text'>".form_input($data)."</div>
		  </div>";
	$data = array('name'=>'password', 'id'=>'password', 'size'=>25);
    echo "<div class='form_element'>
			<label>Password</label>
			<div class='input_text'>".form_password($data)."</div>
		  </div>";
	
}
else {
	
	$data = array('name'=>'beex_email', 'id'=>'beex_email', 'size'=>25);
	echo "<div class='form_element'>
			<label>Email</label>
			<div class='input_text'>".form_input($data)."</label></div>
		  </div>";
    $data = array('name'=>'password', 'id'=>'password', 'size'=>25);
    echo "<div class='form_element'>
			<label>Password</label>
			<div class='input_text'>".form_password($data)."</label></div>
		  </div>";

}

$data = array('class'=>'submit');
if(!$fb_valid) { $login_btn = 'Login';} else { $login_btn = 'Register'; }
echo "<div class='form_element' class='text-align:center'><input type='image' value='Submit' class='rollover' src='".base_url()."images/buttons/reg-form-submit-off.png' /></div>";

if ( $user_id == '' ) { // only show the fb-connect button if they HAVE NOT YET CONNECTED
?>
    <div class='form_element'><fb:login-button onlogin="window.location='<?php echo current_url()?>'"></fb:login-button></div>
<?php
}

echo "</form>";

$this->load->view('framework/footer');

?>