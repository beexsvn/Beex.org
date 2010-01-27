<?php

//$new = true;

if($message) {
	echo "<p class='message'>".$message."<span class='val_errors'>";
	echo validation_errors();
	echo "</span></p>";
}

if($new) {
	$edit = true;
	$attributes = array('id' => 'userform');
	$edit_id = '';
}
elseif($edit){
	$edit = true;
	$attributes = array('id' => 'userform');

	$item = $item->row();
	$edit_id = '';
	if($item) {
		$edit_id = $item->user_id;
	}
	elseif(@$id) {
		$edit_id = $id;
	}

}



$name = 'email';
$value = ($new) ? set_value($name) : @$item->$name;
$email_cell = ($new) ? generate_input($name, 'input', $edit, $value) : $item->$name;


$name = 'password';
$value = ($new) ? set_value($name) : @$item->$name;
$password_cell = generate_input($name, 'password', $edit, $value);

$name = 'password_conf';
$value = ($new) ? set_value($name) : @$item->password;
$password_conf_cell = generate_input($name, 'password', $edit, $value);


//Profile Information

$name = 'first_name';
$value = ($new) ? set_value($name) : @$item->$name;
$first_name_cell = generate_input($name, 'input', $edit, $value);

$name = 'last_name';
$value = ($new) ? set_value($name) : @$item->$name;
$last_name_cell = generate_input($name, 'input', $edit, $value);


$name = 'profile_pic';
$value = ($new) ? set_value($name) : @$item->$name;
$profile_pic_cell = generate_input($name, 'file', $edit, $value);



$months = array ();
for($i=1; $i < 13; $i++) {
	$months[$i] = $i;
}

$days = array();
for($i=1; $i < 32; $i++) {
	$days[$i] = $i;
}

$years = array();
for($i=2000; $i > 1901; $i--) {
	$years[$i] = $i;
}

if($edit && !$new) {
	 $birthmonth = substr(@$item->birthdate, 5, 2);
	 if($birthmonth < 10) {
		$birthmonth = substr($birthmonth, 1);
	 }
	 $birthday = substr(@$item->birthdate, 8, 2);
	 if($birthday < 10) {
			$birthday = substr($birthday, 1);
	 }
	 $birthyear = substr(@$item->birthdate, 0, 4);
}


$name = 'birthmonth';
$value = ($new) ? set_value($name) : $birthmonth;
$birthmonth_cell = generate_input($name, 'dropdown', $edit, $value, $months);
$name = 'birthday';
$value = ($new) ? set_value($name) : $birthday;
$birthday_cell = generate_input($name, 'dropdown', $edit, $value, $days);
$name = 'birthyear';
$value = ($new) ? set_value($name) : $birthyear;
$birthyear_cell = generate_input($name, 'dropdown', $edit, $value, $years);


$name = 'hometown';
$value = ($new) ? set_value($name) : @$item->$name;
$hometown_cell = generate_input($name, 'input', $edit, $value);

$name = 'zip';
$value = ($new) ? set_value($name) : @$item->$name;
$zip_cell = generate_input($name, 'input', $edit, $value, '', array('class'=>'zip', 'maxlength'=>5));

$name = 'network';
$value = ($new) ? set_value($name) : @$item->$name;
$network_cell = generate_input($name, 'input', $edit, $value);

$sexes = array(
			   'Male' => 'Male',
			   'Female' => 'Female'
			   );

$name = 'gender';
$value = ($new) ? set_value($name) : @$item->$name;
$gender_cell = generate_input($name, 'dropdown', $edit, $value, $sexes);

$name = 'whycare';
$value = ($new) ? set_value($name) : @$item->$name;
$whycare_cell = generate_input($name, 'text', $edit, $value);

$name = 'blurb';
$value = ($new) ? set_value($name) : @$item->$name;
$blurb_cell = generate_input($name, 'text', $edit, $value, '', array('maxlength'=>'140'));

$name = 'advice';
$value = ($new) ? set_value($name) : @$item->$name;
$advice_cell = generate_input($name, 'text', $edit, $value);

if($edit){
	$data = array('class'=>'submit');
	$verb = ($new) ? 'Add' : 'Edit';
	$submit_cell = form_submit($data, $verb.' User');
}
?>
<div id="UserForm" class="form">

<div id="LeftColumn">
</div>

<div id="RightColumn">

	<div class="featuredbox">

    </div>

    <div class="module">
    	<div class="tabs">
        	<a id="account" class="button">Account</a>
            <a id="profile" class="button">Profile</a>
        </div>
        <h2 class="title titlebg">User Information</h1>
        <div class="InfoDisplay FormBG">
<?php

if(!$edit) {
	echo "<tr><td colspan=2>".anchor('item/view/user/'.$item->id.'/1', 'Edit', array('class'=>'editbutton'))."</td></tr>";
}


if($new)
	$edit = true;

if($edit){

	echo form_open_multipart('user/process/user/'.$edit_id, $attributes);
}
?>


           
          	<h2 class="title">Account Information (all fields required)</h2>
            	<table>
                	<tr>
	                	<td colspan=2><h5>Log In/Register:</h5></td>
                    </tr>
                    <tr>
	                    <td class="label"><label>Email:</label></td>
                        <td><?php echo $email_cell; ?></td>
                    </tr>
					<?php if(!$new) : ?>
					<tr>
						<td colspan=2>
							If you wish to change you password, fill out the password fields below. Otherwise, you leave the password fields blank.
						</td>
					</tr>
					<?php endif; ?>
                    <tr>
                    	<td class="label"><label>Password:</label></td>
                        <td><?php echo $password_cell; ?></td>
                    </tr>
                    <tr>
                    	<td class="label"><label>Password Confirmation:</label></td>
                        <td><?php echo $password_conf_cell; ?></td>
                    </tr>
					
                    <tr>
                    	<td class="label"><label>First Name:</label></td>
                        <td><?php echo $first_name_cell; ?></td>
                    </tr>
                    <tr>
                    	<td class="label"><label>Last Name:</label></td>
                        <td><?php echo $last_name_cell; ?></td>
                    </tr>
                    
                </table>
           

                <h2 class="title">Profile Information</h2>
                <table>
                    <tr>
                    	<td colspan=2><h5>Contact Info</h5></td>
                    </tr>
                    
                    <tr>
                    	<td class="label"><label>Profile Picture:</label><br />(4 MB maximum size)</td>
                        <td><?php echo $profile_pic_cell; ?></td>
                    </tr>
                    <tr>
                    	<td class="label"><label>Birthday:</label></td>
                        <td><?php echo $birthmonth_cell.' '.$birthday_cell.' '.$birthyear_cell; ?></td>
                    </tr>

                    <tr>
                    	<td class="label"><label>Origin:</label></td>
                        <td><?php echo $hometown_cell; ?></td>
                    </tr>
                    <tr>
                    	<td class="label"><label>Zip:</label></td>
                        <td><?php echo $zip_cell; ?></td>
                    </tr>

                    <tr>
                    	<td class="label"><label>Gender:</label></td>
                        <td><?php echo $gender_cell; ?></td>
                    </tr>
                    <tr>
                    	<td class="label"><label>Why am I here?:</label></td>
                        <td><?php echo $whycare_cell; ?></td>
                    </tr>

                    <tr>
                    	<td class="label"><label>Bio: (140 chars):</label></td>
                        <td><?php echo $blurb_cell; ?></td>
                    </tr>


                    <tr>
                    	<td colspan="2"><input type="image" src="/beex/images/buttons/save.gif" style="width:auto;" /></td>
                    </tr>
                </table>


            </form>


        </div>
    </div>

</div>

</div>
<div style="clear:both;"></div>