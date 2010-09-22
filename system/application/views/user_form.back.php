<?php

$new = true;

if($message) {
	echo "<p class='message'>".$message."<span class='val_errors'>";
	echo validation_errors();
	echo "</span></p>";
}

echo "<h2>".$title."</h2>";

if($new)
	$edit = true;

if($edit){
	$attributes = array('id' => 'userform');
	$edit_id = '';
	if($item) {
		$edit_id = $item->id;
	}
	echo form_open_multipart('user/process/user/'.$edit_id, $attributes);
}

echo "<table border=0 cellpadding=0 cellspacing=0>";
if(!$edit) {
	echo "<tr><td colspan=2>".anchor('user/view/user/'.$item->id.'/1', 'Edit', array('class'=>'editbutton'))."</td></tr>";
}
echo "<th colspan=2>1. Account Information</td></tr>
		<tr>";
		
$name = 'email';
$value = ($new) ? set_value($name) : $item->$name;
echo "<td>Email</td><td>".generate_input($name, 'input', $edit, $value)."</td>
		</tr>
		<tr>";		

$name = 'password';
$value = ($new) ? set_value($name) : $item->$name;
echo "<td>Password</td><td>".generate_input($name, 'password', $edit, $value)."</td>
		</tr>
		<tr>";
		
$name = 'password_conf';
$value = ($new) ? set_value($name) : $item->$name;
echo "<td>Password Confirm</td><td>".generate_input($name, 'password', $edit, $value)."</td>
		</tr>
		<tr>";

echo "<th colspan=2>2. Profile Infomation</td></tr>
		<tr>";

$name = 'first_name';
$value = ($new) ? set_value($name) : $item->$name;
echo "<td>First Name</td><td>".generate_input($name, 'input', $edit, $value)."</td>
		</tr>
		<tr>";

$name = 'last_name';
$value = ($new) ? set_value($name) : $item->$name;
echo "<td>Last Name</td><td>".generate_input($name, 'input', $edit, $value)."</td>
		</tr>
		<tr>";
		
$name = 'profile_pic';
$value = ($new) ? set_value($name) : $item->$name;
echo "<td>Profile Picture</td><td>".generate_input($name, 'file', $edit, $value)."</td>
		</tr>
		<tr>";

		

$months = array ();
for($i=1; $i < 13; $i++) {
	$months[$i] = $i;
}

$days = array();
for($i=1; $i < 32; $i++) {
	$days[$i] = $i;	
}

$years = array();
for($i=1900; $i < 2009; $i++) {
	$years[$i] = $i;	
}
$name = 'birthmonth';
$value = ($new) ? set_value($name) : $item->$name;
echo "<td>Date of Birth</td><td>".generate_input($name, 'dropdown', $edit, $value, $months)." ";
$name = 'birthday';
$value = ($new) ? set_value($name) : $item->$name;
echo generate_input($name, 'dropdown', $edit, $value, $days)." ";
$name = 'birthyear';
$value = ($new) ? set_value($name) : $item->$name;
echo generate_input($name, 'dropdown', $edit, $value, $years);

echo"</tr>
		<tr>";

$name = 'hometown';
$value = ($new) ? set_value($name) : $item->$name;
echo "<td>Hometown</td><td>".generate_input($name, 'input', $edit, $value)."</td>
		</tr>
		<tr>";

$name = 'zip';
$value = ($new) ? set_value($name) : $item->$name;
echo "<td>Zip</td><td>".generate_input($name, 'input', $edit, $value, '', array('class'=>'zip', 'maxlength'=>5))."</td>
		</tr>
		<tr>";

$name = 'network';
$value = ($new) ? set_value($name) : $item->$name;
echo "<td>Network</td><td>".generate_input($name, 'input', $edit, $value)."</td>
		</tr>
		<tr>";

$sexes = array(
			   'M' => 'M',
			   'F' => 'F'
			   );

$name = 'gender';
$value = ($new) ? set_value($name) : $item->$name;
echo "<td>Gender</td><td>".generate_input($name, 'dropdown', $edit, $value, $sexes)."</td>
		</tr>
		<tr>";
		
$name = 'whycare';
$value = ($new) ? set_value($name) : $item->$name;
echo "<td>Why do you care?</td><td>".generate_input($name, 'text', $edit, $value)."</td>
		</tr>
		<tr>";

$name = 'blurb';
$value = ($new) ? set_value($name) : $item->$name;
echo "<td>Blurb (140 chars)</td><td>".generate_input($name, 'text', $edit, $value)."</td>
		</tr>
		<tr>";
		
$name = 'advice';
$value = ($new) ? set_value($name) : $item->$name;
echo "<td>Advice for fundraisers</td><td>".generate_input($name, 'text', $edit, $value)."</td>
		</tr>
		<tr>";

if($edit){
	$data = array('class'=>'submit');
	echo "<td colspan=2>".form_submit($data, 'Add User')."</td>";
}

echo "</tr>
 	</table>";

if($edit) {
	echo "</form>";
}

?>