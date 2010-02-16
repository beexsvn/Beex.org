<?php

$this->load->view('framework/header', $header);

if($message) {
    echo "<p class='message'>".$message."<span class='val_errors'>";
    echo validation_errors();
    echo "</span></p>";
}

?>

<script src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php" type="text/javascript"></script>

<script type="text/javascript">
    FB.init("<?=$this->config->item('facebook_api_key')?>", "/xd_receiver.htm");
</script>

<a href="#" onclick="FB.Connect.logout(function() {window.location='<?=current_url()?>' }); return false;" >(Logout)</a>
<?php

echo "<h2>".$header['title']."</h2>";
$attributes = array('id' => 'login');
echo form_open('user/login', $attributes);
echo "<table border=0 cellpadding=0 cellspacing=0>";
echo "<th colspan=2>";
if($fb_valid) {
    echo "Please enter your email address";
}
else {
    echo "Please enter your login credentials";
}
echo "</td></tr>";


$data = array('name'=>'email', 'id'=>'email', 'size'=>25);
echo "<tr><td>Email</td><td>".form_input($data)."</td></tr>";

if($fb_valid) {
    $data = array('name'=>'first_name', 'id'=>'first_name', 'size'=>25);
    echo "<tr><td>First name</td><td>".form_input($data)."</td></tr>";
    $data = array('name'=>'last_name', 'id'=>'last_name', 'size'=>25);
    echo "<tr><td>Last name</td><td>".form_input($data)."</td></tr>";

}

else {

    $data = array('name'=>'password', 'id'=>'password', 'size'=>25);
    echo "<tr><td>Password</td><td>".form_password($data)."</td></tr>";

}

$data = array('class'=>'submit');
if($fb_valid) { $login_btn = 'Login';} else { $login_btn = 'Register'; }
echo "<tr><td colspan=2>".form_submit($data, $login_btn)."</td></tr>";
if ( $user_id == '' ) { // only show the fb-connect button if they HAVE NOT YET CONNECTED
?>

    <tr><td colspan=2><fb:login-button onlogin="window.location='<?=current_url()?>'"></fb:login-button></td></tr>
<?
}


echo "</table></form>";

$this->load->view('framework/footer');

?>