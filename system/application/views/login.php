<?php

$this->load->view('framework/header', $header);

if($message) {
	echo "<p class='message'>".$message."<span class='val_errors'>";
	echo validation_errors();
	echo "</span></p>";
}

echo "<h2>".$header['title']."</h2>";
$attributes = array('id' => 'login');
echo form_open('user/login', $attributes);
echo "<table border=0 cellpadding=0 cellspacing=0>";
echo "<th colspan=2>Please Login to Modify Your Record</td></tr>
		<tr>";
$data = array('name'=>'email', 'id'=>'email', 'size'=>25);
echo "<td>Email</td><td>".form_input($data)."</td>
		</tr>
		<tr>";		
		
$data = array('name'=>'password', 'id'=>'password', 'size'=>25);
echo "<td>Password</td><td>".form_password($data)."</td>
		</tr>
		<tr>";

$data = array('class'=>'submit');
echo "<td colspan=2>".form_submit($data, 'Login')."</td>";

echo "</tr>
 	</table>
	</form>";
	
$this->load->view('framework/footer');

?>