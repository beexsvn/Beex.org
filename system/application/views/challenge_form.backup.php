<?php

$new = true;

if($message) {
	echo "<p class='message'>".$message."<span class='val_errors'>";
	echo validation_errors();
	echo "</span></p>";
}

echo "<h2>challenge Module</h2>";



if($new)
	$edit = true;

if($edit){
	$attributes = array('id' => 'challengeform');
	$edit_id = '';
	if($item) {
		$edit_id = $item->id;
	}
	echo form_open_multipart('challenge/process/challenge/'.$edit_id, $attributes);
}

echo "<table border=0 cellpadding=0 cellspacing=0>";
if(!$edit) {
	echo "<tr><td colspan=2>".anchor('item/view/challenge/'.$item->id.'/1', 'Edit', array('class'=>'editbutton'))."</td></tr>";
}
echo "<th colspan=2>1. Who</td></tr>
		<tr>";

if($username) {
	
	echo "<td>Email</td><td>".$username."</td>
			</tr>
			<tr>";
			
	$name = 'user_id';
	echo generate_input($name, 'hidden', $edit, $user_id);
	
}
else {
		
$data = array('name'=>'email', 'id'=>'email', 'size'=>25, 'value'=>($new) ? set_value('email') : $item->user_id);
$email_cell = ($edit) ? form_input($data) : $item->user_id;


$name = 'password';
$password_value = ($new) ? set_value($name) : $item->$name;


echo "<td>Password</td><td>".generate_input($name, 'password', $edit, $value)."</td>
		</tr>
		<tr>";
		
}
echo "<td colspan=2>Are you part of a cluster?</td>
		</tr>
		<tr>";

$data = array('name'=>'cluster_id', 'id'=>'cluster_id', 'size'=>25, 'value'=>(($new) ? set_value('cluster_id') : $item->cluster_id));
$cell = ($edit) ? form_input($data) : $item->cluster_id;
echo "<td>Enter Cluster ID</td><td>".$cell."</td>
		</tr>
		<tr>";

echo "<th colspan=2>2. What</td></tr>
		<tr>";
$data = array('name'=>'challenge_title', 'id'=>'challenge_title', 'size'=>25, 'value'=>($new) ? set_value('challenge_title') : $item->challenge_title);
$cell = ($edit) ? form_input($data) : $item->challenge_title;
echo "<td>challenge Title</td><td>".$cell."</td>
		</tr>
		<tr>";

$data = array('name'=>'challenge_declaration', 'id'=>'challenge_declaration', 'value'=>(($new) ? set_value('challenge_declaration') : $item->challage_declaration));
$cell = ($edit) ? form_textarea($data) : $item->challenge_declaration;
echo "<td>Delclaration: <b>\"I/we* will </td><td>".$cell."</td>
		</tr>
		<tr>";
	
$data = array('name'=>'challenge_goal', 'id'=>'challenge_goal', 'size'=>25, 'value'=>($new) ? set_value('challenge_goal') : $item->challenge_goal);
$cell = ($edit) ? form_input($data) : $item->challenge_goal;
echo "<td>Fundraising Goal</td><td>$".$cell."</td>
		</tr>
		<tr>";
		
		
$npos = array(
           
		   'NPO1' => 'NPO 1',
		   'NPO2' => 'TEST NPO 2',
		   'NPO3' => 'THIS NPO IS SWEET'
		   	
			);

$data = array('name'=>'challenge_npo', 'id'=>'challenge_npo');
$value = ($new) ? set_value('challenge_npo') : $item->challnage_npo;
$cell = ($edit) ? form_dropdown('challenge_npo', $npos, $value) : $item->challenge_npo;
echo "<td>Benefiting Nonprofit</td><td>".$cell."</td>
		</tr>
		<tr>";

echo "<td colspan=2>-Optional-</td></tr>
		<tr>
			<td colspan=2>Offer to sweeten the deal:</td>
		</tr>
		<tr>";

$data = array('name'=>'challenge_sweetener_goal', 'id'=>'challenge_sweetener_goal', 'size'=>25, 'value'=>($new) ? set_value('challenge_sweetener_goal') : $item->challenge_sweetener_goal);
$cell = ($edit) ? form_input($data) : $item->challenge_sweetener_goal;
echo "<td colspan=2>(+) If an additional $".$cell." is raised I/we* will</td>
		</tr>
		<tr>";
		
$data = array('name'=>'challenge_sweetener', 'id'=>'challenge_sweetener', 'size'=>25, 'value'=>($new) ? set_value('challenge_sweetener') : $item->challenge_sweetener);
$cell = ($edit) ? form_textarea($data) : $item->challenge_sweetener;
echo "<td colspan=2>".$cell."</td>
		</tr>
		<tr>";
		
$data = array('name'=>'challenge_reserve_price', 'id'=>'challenge_reserve_price', 'size'=>25, 'value'=>($new) ? set_value('challnage_reserve_price') : $item->challenge_reserve_price);
$cell = ($edit) ? form_input($data) : $item->challenge_reserve_price;
echo "<td>What is your reserve price? (leave blank if none)</td><td>".$cell."</td>
		</tr>
		<tr>";
		
echo "<th colspan=2>3. When</td></tr>
		<tr>";

$data = array('name'=>'challenge_completion', 'class'=>'datepicker', 'id'=>'challenge_completion', 'size'=>25, 'value'=>($new) ? set_value('challenge_completion') : $item->challenge_completion);
$cell = ($edit) ? form_input($data) : $item->challenge_completion;
echo "<td>Date challenge is Completed</td><td>".$cell."</td>
		</tr>
		<tr>";

$data = array('name'=>'challenge_fr_completed', 'class'=>'datepicker', 'id'=>'challenge_fr_completed', 'size'=>25, 'value'=>($new) ? set_value('challenge_fr_completed') : $item->challenge_fr_completed);
$cell = ($edit) ? form_input($data) : $item->challenge_fr_completed;
echo "<td>Date Fund Raising is Completed</td><td>".$cell."</td>
		</tr>
		<tr>";
		
$data = array('name'=>'challenge_proof_upload', 'class'=>'datepicker', 'id'=>'challenge_proof_upload', 'size'=>25, 'value'=>($new) ? set_value('challenge_proof_upload') : $item->challenge_proof_upload);
$cell = ($edit) ? form_input($data) : $item->challenge_proof_upload;
echo "<td>Date Proof will be uploaded</td><td>".$cell."</td>
		</tr>
		<tr>";
		
echo "<th colspan=2>4. Where</td></tr>
		<tr>";

$data = array('name'=>'challenge_address1', 'id'=>'challenge_address1', 'size'=>25, 'value'=>($new) ? set_value('challenge_address1') : $item->challenge_address1);
$cell = ($edit) ? form_input($data) : $item->challenge_address1;
echo "<td>Address</td><td>".$cell."</td>
		</tr>
		<tr>";
		
$data = array('name'=>'challenge_address2', 'id'=>'challenge_address2', 'size'=>25, 'value'=>($new) ? set_value('challenge_address2') : $item->challenge_address2);
$cell = ($edit) ? form_input($data) : $item->challenge_address2;
echo "<td>Address 2 (if needed)</td><td>".$cell."</td>
		</tr>
		<tr>";

$data = array('name'=>'challenge_city', 'id'=>'challenge_city', 'size'=>25, 'value'=>($new) ? set_value('challenge_city') : $item->challenge_city);
$cell = ($edit) ? form_input($data) : $item->challenge_city;
echo "<td>City</td><td>".$cell."</td>
		</tr>
		<tr>";

$state_list = array('AL'=>"Alabama",  
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
			'WY'=>"Wyoming");

$name = 'challenge_state';
$value = ($new) ? set_value('challenge_attend') : $item->challenge_attend;
echo "<td>State</td><td>".generate_input($name, 'dropdown', $edit, $value, $state_list)."</td>
		</tr>
		<tr>";


$data = array('name'=>'challenge_zip', 'id'=>'challenge_zip', 'size'=>25, 'value'=>($new) ? set_value('challenge_zip') : $item->challenge_zip);
$cell = ($edit) ? form_input($data) : $item->challenge_zip;
echo "<td>Zip</td><td>".$cell."</td>
		</tr>
		<tr>";
		
$networks = array(
           
		   'network1' => 'Network 1',
		   'network2' => 'Network 2',
		   'network3' => 'Network 3'
		   	
			);

$data = array('name'=>'challenge_network', 'id'=>'challenge_network');
$value = ($new) ? set_value('challenge_network') : $item->challenge_network;
$cell = ($edit) ? form_dropdown('challenge_network', $networks, $value) : $item->challenge_network;
echo "<td>Pick a Network for this challenge</td><td>".$cell."</td>
		</tr>
		<tr>";


$attends = array(
           
		   'anyone' => 'Yes, anyone can attend',
		   'donors' => 'Only donors',
		   'invited' => 'Invited guests',
		   'none' => 'No, people cannot attend'
		   	
			);

$data = array('name'=>'challenge_attend', 'id'=>'challenge_attend');
$value = ($new) ? set_value('challenge_attend') : $item->challenge_attend;
$cell = ($edit) ? form_dropdown('challenge_attend', $attends, $value) : $item->challenge_attend;
echo "<td>Can people attend the performance of the challenge</td><td>".$cell."</td>
		</tr>
		<tr>";

echo "<th colspan=2>5. How</td></tr>
		<tr>";


$name = 'challenge_blurb';
$value = ($new) ? set_value($name) : $item->$name;
echo "<td>Blurb (120 characters or less)</td><td>".generate_input($name, 'text', $edit, $value)."</td>
		</tr>
		<tr>";

$name = 'challenge_description';
$value = ($new) ? set_value($name) : $item->$name;
echo "<td>Describe the challenge (text)</td><td>".generate_input($name, 'text', $edit, $value)."</td>
		</tr>
		<tr>";
		
$name = 'challenge_video';
$value = ($new) ? set_value($name) : $item->$name;
echo "<td>Upload a video explanation</td><td>".generate_input($name, 'input', $edit, $value)."</td>
		</tr>
		<tr>";
		
$name = 'challenge_whydo';
$value = ($new) ? set_value($name) : $item->$name;
echo "<td colspan=2>Optional</td></tr><tr><td>Why are you doing this challenge?</td><td>".generate_input($name, 'text', $edit, $value)."</td>
		</tr>
		<tr>";
		
$name = 'challenge_whycare';
$value = ($new) ? set_value($name) : $item->$name;
echo "<td>Why do you care about this nonprofit?</td><td>".generate_input($name, 'text', $edit, $value)."</td>
		</tr>
		<tr>";
		



if($edit){
	$data = array('class'=>'submit');
	echo "<td colspan=2>".form_submit($data, 'Update challenge')."</td>";
}

echo "</tr>
 	</table>";

if($edit) {
	echo "</form>";
}

?>

<div id="challengeForm" class="form">

<div id="LeftColumn">
</div>

<div id="RightColumn">

	<div class="featuredbox">
	    
    </div>
    
    <div class="module">
    	<div class="tabs">
        	<a id="who" class="button">Who</a>
            <a id="what" class="button">What</a>
            <a id="when" class="button">When</a>
            <a id="where" class="button">Where</a>
            <a id="why" class="button">Why</a>
            <a id="how" class="button">How</a>
        </div>
        <h2 class="title titlebg">Start A Challenge</h1>
        <div class="InfoDisplay FormBG">
        	<h2 class="title">WHO</h2>
            
            <form>
            	<table>
                	<tr>
	                	<td colspan=2><h5>Log In/Register:</h5></td>
                    </tr>
                    <tr>
	                    <td><label>Username:</label></td>
                        <td><input /></td>
                    </tr>
                    <tr>
                    	<td><label>Password:</label></td>
                        <td><input /></td>
                    </tr>
                </table>
            </form>
            
        </div>
    </div>

</div>

</div>
