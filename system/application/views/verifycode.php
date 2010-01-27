<?php

$this->load->view('framework/header', $header);


echo "<h2>Verification Code</h2>";

if($success) {
	echo "<p class='message'>".$message."</p>";
}
else {

$attributes = array('id' => 'verificationcode');
echo form_open('user/entercode/'.$user_id, $attributes);
echo "<table border=0 cellpadding=0 cellspacing=0>";
echo "<th colspan=2>Please check your email and enter your verification code found in your BEEx registration email. Alternatively you may click the link found in that email</td></tr>
		<tr>";
$data = array('name'=>'code', 'id'=>'code', 'size'=>25);
echo "<td>Verification Code</td><td>".form_input($data)."</td>
		</tr>
		<tr>";		
		

$data = array('class'=>'submit');
echo "<td colspan=2>".form_submit($data, 'Submit')."</td>";

echo "</tr>
 	</table>
	</form>";
}

$this->load->view('framework/footer');

?>