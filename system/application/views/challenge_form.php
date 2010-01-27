<?php



//$new = true;



if($message) {

	echo "<p class='message'>".$message."<span class='val_errors'>";

	echo validation_errors();

	echo "</span></p>";

}



$attributes = array('id' => 'challengeform', 'class'=>'itemform');



if($new) {

	$edit = true;

	$edit_id = '';

}

elseif($edit){

	$new = false;

	$edit = true;

	$item = $item->row();

	$edit_id = '';

	if($item) {

		$edit_id = $item->id;

	}



}



if($username = $this->session->userdata('username')) {



	$name = 'user_id';



	$email_cell = $username;
	
	if($new) {
		$email_cell .= generate_input($name, 'hidden', $edit, $user_id);
	}



}

else {



$data = array('name'=>'email', 'id'=>'email', 'size'=>25, 'value'=>($new) ? set_value('email') : $item->user_id);

$email_cell = ($edit) ? form_input($data) : $item->user_id;





$name = 'password';

$value = ($new) ? set_value($name) : $item->$name;

$password_cell = generate_input($name, 'password', $edit, $value);



}



//Cluster ID

$data = array('name'=>'cluster_id', 'id'=>'cluster_id', 'size'=>25, 'value'=>(($new) ? '' :$item->cluster_id));

$cluster_id_cell = (@$cluster->theid) ? $cluster->theid : ($edit) ? ((@$item->cluster_id) ? $item->cluster_id : form_input($data)) : $item->cluster_id;



//Challenge Title

$data = array('name'=>'challenge_title', 'id'=>'challenge_title', 'size'=>25, 'value'=>($new) ? set_value('challenge_title') : $item->challenge_title);

$challenge_title_cell = (@$cluster->cluster_ch_title) ? $cluster->cluster_ch_title.generate_input('challenge_title', 'hidden', $edit, $cluster->cluster_ch_title) : (($edit) ? form_input($data) : $item->challenge_title);



//Challenge Declaration

$data = array('name'=>'challenge_declaration', 'id'=>'challenge_declaration', 'value'=>(($new) ? set_value('challenge_declaration') : $item->challenge_declaration));

$challenge_declaration_cell = (@$cluster->cluster_ch_declaration) ? $cluster->cluster_ch_declaration.generate_input('challenge_declaration', 'hidden', $edit, $cluster->cluster_ch_declaration) : (($edit) ? form_textarea($data) : $item->challenge_declaration);



//Goal

$data = array('name'=>'challenge_goal', 'id'=>'challenge_goal', 'size'=>25, 'class'=>'short', 'value'=>($new) ? set_value('challenge_goal') : $item->challenge_goal);

$goal_cell = (@$cluster->cluster_ch_goal) ? $cluster->cluster_ch_goal.generate_input('challenge_goal', 'hidden', $edit, $cluster->cluster_ch_goal) : (($edit) ? form_input($data) : $item->challenge_goal);



//Link

$data = array('name'=>'challenge_link', 'id'=>'challenge_link', 'value'=>($new) ? set_value('challenge_link') : $item->challenge_link);

$link_cell = (@$cluster->cluster_ch_link) ? $cluster->cluster_ch_link.generate_input('challenge_link', 'hidden', $edit, $cluster->cluster_ch_link) : (($edit) ? form_input($data) : $item->challenge_link);



//RSS

$data = array('name'=>'challenge_rss', 'id'=>'challenge_rss', 'size'=>25, 'value'=>($new) ? set_value('challenge_rss') : $item->challenge_rss);

$rss_cell = (@$cluster->cluster_ch_rss) ? $cluster->cluster_ch_rss.generate_input('challenge_rss', 'hidden', $edit, $cluster->cluster_ch_rss) : (($edit) ? form_input($data) : $item->challenge_rss);







//NPO

$npos = $this->MItems->getDropdownArray('npos', 'name');



$data = array('name'=>'challenge_npo', 'id'=>'challenge_npo');

$value = ($new) ? set_value('challenge_npo') : $item->challenge_npo;

$npo_cell = (@$cluster->cluster_npo) ? $this->beex->name_that_npo($cluster->cluster_npo).generate_input('challenge_npo', 'hidden', $edit, $cluster->cluster_npo) : (($edit) ? form_dropdown('challenge_npo', $npos, $value) : $item->challenge_npo);



//Completion

$data = array('name'=>'challenge_completion', 'class'=>'datepicker', 'id'=>'challenge_completion', 'size'=>25, 'value'=>($new) ? set_value('challenge_completion') : $item->challenge_completion);

$completion_cell =  (@$cluster->cluster_ch_completion) ? $cluster->cluster_ch_completion.generate_input('challenge_completion', 'hidden', $edit, $cluster->cluster_ch_completion) : (($edit) ? form_input($data) : $item->challenge_completion);



//Fund Raising Completion

$data = array('name'=>'challenge_fr_completed', 'class'=>'datepicker', 'id'=>'challenge_fr_completed', 'size'=>25, 'value'=>($new) ? set_value('challenge_fr_completed') : $item->challenge_fr_completed);

$fr_cell = (@$cluster->cluster_ch_fr_ends) ? $cluster->cluster_ch_fr_ends.generate_input('challenge_fr_completed', 'hidden', $edit, $cluster->cluster_ch_fr_ends) : (($edit) ? form_input($data) : $item->challenge_fr_completed);



// Proof Completion

$data = array('name'=>'challenge_proof_upload', 'class'=>'datepicker', 'id'=>'challenge_proof_upload', 'size'=>25, 'value'=>($new) ? set_value('challenge_proof_upload') : $item->challenge_proof_upload);

$proof_cell = (@$cluster->cluster_ch_proofdate) ? $cluster->cluster_ch_proofdate.generate_input('challenge_proof_upload', 'hidden', $edit, $cluster->cluster_ch_proofdate) : (($edit) ? form_input($data) : $item->challenge_proof_upload);



//Location

$data = array('name'=>'challenge_location', 'id'=>'challenge_location', 'size'=>25, 'value'=>($new) ? set_value('challenge_location') : $item->challenge_location);

$location_cell = (@$cluster->cluster_ch_location) ? $cluster->cluster_ch_location.generate_input('challenge_location', 'hidden', $edit, $cluster->cluster_ch_location) : (($edit) ? form_input($data) : $item->challenge_location);





//Address

$data = array('name'=>'challenge_address1', 'id'=>'challenge_address1', 'size'=>25, 'value'=>($new) ? set_value('challenge_address1') : $item->challenge_address1);

$address_cell = (@$cluster->cluster_ch_address) ? $cluster->cluster_ch_address.generate_input('challenge_address1', 'hidden', $edit, $cluster->cluster_ch_address) : (($edit) ? form_input($data) : $item->challenge_address1);



//Address 2

$data = array('name'=>'challenge_address2', 'id'=>'challenge_address2', 'size'=>25, 'value'=>($new) ? set_value('challenge_address2') : $item->challenge_address2);

$address2_cell = (@$cluster->cluster_ch_address2) ? $cluster->cluster_ch_address2.generate_input('challenge_address2', 'hidden', $edit, $cluster->cluster_ch_address2) : (($edit) ? form_input($data) : $item->challenge_address2);



//City

$data = array('name'=>'challenge_city', 'id'=>'challenge_city', 'size'=>25, 'value'=>($new) ? set_value('challenge_city') : $item->challenge_city);

$city_cell = (@$cluster->cluster_ch_city) ? $cluster->cluster_ch_city.generate_input('challenge_city', 'hidden', $edit, $cluster->cluster_ch_city) : (($edit) ? form_input($data) : $item->challenge_city);





$name = 'challenge_state';

$value = ($new) ? set_value('challenge_state') : $item->challenge_state;

$state_cell = (@$cluster->cluster_ch_state) ? $cluster->cluster_ch_state.generate_input('challenge_state', 'hidden', $edit, $cluster->cluster_ch_state) : generate_input($name, 'dropdown', $edit, $value, get_special_array('states'));



//Zip

$data = array('name'=>'challenge_zip', 'id'=>'challenge_zip', 'class'=>'short', 'value'=>($new) ? set_value('challenge_zip') : $item->challenge_zip);

$zip_cell = (@$cluster->cluster_ch_zip) ? $cluster->cluster_ch_zip.generate_input('challenge_zip', 'hidden', $edit, $cluster->cluster_ch_zip) : (($edit) ? form_input($data) : $item->challenge_zip);



$networks = array(



		   'Chicago' => 'Chicago',

		   'Los Angeles' => 'Los Angeles',

		   'New York' => 'New York'



			);



$data = array('name'=>'challenge_network', 'id'=>'challenge_network');

$value = ($new) ? set_value('challenge_network') : $item->challenge_network;

$network_cell = ($edit) ? form_dropdown('challenge_network', $networks, $value) : $item->challenge_network;





//Attend

$attends = array(



		   'anyone' => 'Yes, anyone can attend',

		   'donors' => 'Only donors',

		   'invited' => 'Invited guests',

		   'none' => 'No, people cannot attend'



			);



$data = array('name'=>'challenge_attend', 'id'=>'challenge_attend');

$value = ($new) ? set_value('challenge_attend') : $item->challenge_attend;

$attend_cell = (@$cluster->cluster_ch_attend) ? $cluster->cluster_ch_attend.generate_input('challenge_attend', 'hidden', $edit, $cluster->cluster_ch_attend) : (($edit) ? form_dropdown('challenge_attend', $attends, $value) : $item->challenge_attend);



//Blurb

$name = 'challenge_blurb';

$value = ($new) ? set_value($name) : $item->$name;

$blurb_cell = (@$cluster->cluster_ch_blurb) ? $cluster->cluster_blurb.generate_input('challenge_blurb', 'hidden', $edit, $cluster->cluster_ch_blurb) : generate_input($name, 'text', $edit, $value);



//Description

$name = 'challenge_description';

$value = ($new) ? set_value($name) : $item->$name;

$description_cell = (@$cluster->cluster_ch_description) ? $cluster->cluster_ch_description.generate_input('challenge_description', 'hidden', $edit, $cluster->cluster_ch_description) : generate_input($name, 'text', $edit, $value, '', 'bigtext');



//Video

$name = 'challenge_video';

$value = ($new) ? set_value($name) : $item->$name;

$video_cell = (@$cluster->cluster_ch_video) ? $cluster->cluster_ch_video.generate_input('challenge_video', 'hidden', $edit, $cluster->cluster_ch_video) : generate_input($name, 'text', $edit, $value);



//Image

$name = 'challenge_image';

$value = ($new) ? set_value($name) : $item->$name;

$image_cell = generate_input($name, 'file', $edit, $value);



//

$name = 'challenge_whydo';

$value = ($new) ? set_value($name) : $item->$name;

$whydo_cell = generate_input($name, 'text', $edit, $value);



$name = 'challenge_whycare';

$value = ($new) ? set_value($name) : $item->$name;

$whycare_cell = generate_input($name, 'text', $edit, $value);



?>



<?php if(!@$cluster) : ?>



<div id="challengeForm" class="form">



<div id="LeftColumn">

</div>



<div id="RightColumn">



	<div class="featuredbox">



    </div>



    <div class="module">
		
        <!--
    	<div class="tabs">

        	<a id="who" class="button">Who</a>

            <a id="what" class="button">What</a>

            <a id="when" class="button">When</a>

            <a id="where" class="button">Where</a>

            <a id="why" class="button">Why</a>

            <a id="how" class="button">How</a>

        </div>
		-->
        <h2 class="title titlebg">Start A Challenge</h1>



<?php endif; ?>



        <div class="InfoDisplay FormBG">

<?php



if(!$edit) {

	echo "<tr><td colspan=2>".anchor('item/view/challenge/'.$item->id.'/1', 'Edit', array('class'=>'editbutton'))."</td></tr>";

}





if($new)

	$edit = true;



if($edit){



	echo (@$cluster) ? form_open_multipart('challenge/process/challenge/'.$edit_id, $attributes) : form_open_multipart('challenge/process/challenge/'.$edit_id, $attributes);

}

?>







          	<h2 class="title">WHO</h2>

            	<table>

                	<tr>

	                	<td colspan=2><h5>Log In/Register:</h5></td>

                    </tr>

                    <tr>

	                    <td class="label"><label><span class="required">*</span>Email:</label></td>

                        <td><?php echo $email_cell; ?></td>

                    </tr>

                    <?php if(!$username) : ?>

                    <tr>

                    	<td class="label"><label><span class="required">*</span>Password:</label></td>

                        <td><?php echo $password_cell; ?></td>

                    </tr>
                                        
                    <tr>

                    	<td colspan=2><h5>If you haven't registered yet for Beex.org, don't worry.  Enter your name, email and password below.</h5></td>

                    </tr>
					
                    <tr>
                     <td colspan="2">
                        <table style="border:1px solid #aaa; width:100%; padding:5%;">
                        <tr>
    
                            <td class="label"><label>Name:</label></td>
    
                            <td><?php echo generate_input('signup_name', 'input', true, ''); ?></td>
    
                        </tr>
    
                        <tr>
    
                            <td class="label"><label>Email:</label></td>
    
                            <td><?php echo generate_input('signup_email', 'input', true, ''); ?></td>
    
                        </tr>
    
    
    
                        <tr>
    
                            <td class="label"><label>Password:</label></td>
    
                            <td><?php echo generate_input('signup_pass', 'password', true, ''); ?></td>
    
                        </tr>
    
                        <tr>
    
                            <td class="label"><label>Password Confirm:</label></td>
    
                            <td><?php echo generate_input('signup_passconf', 'password', true, ''); ?></td>
    
                        </tr>
                        </table>
                       </td>
                      </tr>
                    
                    <?php else : ?>
                    
                    
					
                    <?php endif; ?>

					

                    <?php if(@$cluster) : ?>



                    <?php 		if(!$username) : ?>

                    <tr>

	                	<td colspan=2><h5>Not yet a member? Then register:</h5><br />If you haven't registered yet for Beex.org, don't worry, it's as easy as entering your e-mail and creating a password below.</td>

                    </tr>




                    <?php 		endif; ?>

                    <input type="hidden" name="from_cluster" value="1" />

					<input type="hidden" name="cluster_id" value="<?php echo $cluster->theid; ?>" />

                    <?php else: ?>



                    <tr>

                    	<td colspan=2><h5>Are you part of a cluster?</h5></td>

                    </tr>

                    <tr>

                    	<td class="label"><label>Cluster Code:</label></td>

                        <td><?php echo $cluster_id_cell; ?></td>

                    </tr>

                    <?php endif; ?>
					
                    <?php if($new) : ?>
                    
                    <tr>

                    	<td colspan=2><h5>Do you have a teammate for this challenge?</h5></td>

                    </tr>
                    
                    <tr>

	                    <td class="label"><label>Teammate Name:</label></td>

                        <td><?php echo generate_input('teammate_name', 'input', true, ''); ?></td>

                    </tr>
                    
                    <tr>

	                    <td class="label"><label>Teammate Email:</label></td>

                        <td><?php echo generate_input('teammate_email', 'input', true, ''); ?></td>

                    </tr>

					<?php endif; ?>
					

                    <!--

                    <tr>

                    	<td colspan=2><h5>Do you have teammates? <a>(learn more)</a></h5></td>

                    </tr>

                    <tr>

                    	<td class="label">Yes <input type="checkbox" style="width:auto;" /></td>

                        <td>No <input type="checkbox" style="width:auto;" /></td>

                    </tr>



                    <tr>

                    	<td colspan=2><h5>Add a teammate</a></h5></td>

                    </tr>



                    <tr>

                    	<td class="label"><label>Name:</label></td>

                        <td><input type="text" /></td>

                    </tr>

                    <tr>

                    	<td class="label"><label>E-mail:</label></td>

                        <td><input type="text" /></td>

                    </tr>

                    <tr>

                    	<td class="label"><label>Personal Message:</label></td>

                        <td rowspan="2"><textarea class="bigtext" ></textarea></td>

                    </tr>

                    <tr>

                    	<td><a>(+) add more</a></td>

                    </tr>

                    -->





                </table>

                <h2 class="title">What</h2>

                <table>

                    <tr>

                    	<td colspan=2><h5>Challenge</h5></td>

                    </tr>

                    <tr>

                    	<td class="label"><label><span class="required">*</span>Challenge Title:</label></td>

                        <td><?php echo $challenge_title_cell; ?></td>

                    </tr>

                    <tr>

                    	<td class="label"><label><span class="required">*</span>Declaration (I/We will):</label></td>

                        <td><?php echo $challenge_declaration_cell; ?></td>

                    </tr>

                    <tr>

                    	<td class="label"><label><span class="required">*</span>Fundraising Goal:</label></td>

                        <td>$ <?php echo $goal_cell; ?></td>

                    </tr>



                    <tr>

                    	<td colspan=2><h5>Nonprofit</h5></td>

                    </tr>

                    <tr>

                    	<td class="label"><label><span class="required">*</span>Select your Nonprofit:</label></td>

                        <td><?php echo $npo_cell; ?></td>

                    </tr>



                    <tr>

                    	<td class="label"><label>External Link:</label></td>

                        <td><?php echo $link_cell; ?></td>

                    </tr>



                    <tr>

                    	<td class="label"><label>RSS Feed:</label></td>

                        <td><?php echo $rss_cell; ?></td>

                    </tr>



                </table>



                <h2 class="title">When</h2>

                <table>

                    <tr>

                    	<td colspan=2><h5>Challenge Dates</h5></td>

                    </tr>

                    <tr>

                    	<td class="label"><label><span class="required">*</span>Date challenge will be completed:</label></td>

                        <td><?php echo $completion_cell; ?></td>

                    </tr>

                    <tr>

                    	<td class="label"><label>Date fund raising will be completed:</label></td>

                        <td><?php echo $fr_cell; ?></td>

                    </tr>

                    <tr>

                    	<td class="label"><label>Date proof will be uploaded:</label></td>

                        <td><?php echo $proof_cell; ?></td>

                    </tr>

                </table>



                <h2 class="title">Where</h2>

                <table>

                    <tr>

                    	<td colspan=2><h5>Challenge Location</h5></td>

                    </tr>

                    <tr>

                    	<td class="label"><label>Location:<br /><small>Feel free to enter a website address if your challenge takes place online</label></td>

                        <td><?php echo $location_cell; ?></td>

                    </tr>

                    <tr>

                    	<td class="label"><label>Address:</label></td>

                        <td><?php echo $address_cell; ?></td>

                    </tr>

                    <tr>

                    	<td class="label"><label>Address 2 (if needed):</label></td>

                        <td><?php echo $address2_cell; ?></td>

                    </tr>



                    <tr>

                    	<td class="label"><label>City:</label></td>

                        <td><?php echo $city_cell; ?></td>

                    </tr>

                    <tr>

                    	<td class="label"><label>State:</label></td>

                        <td><?php echo $state_cell; ?></td>

                    </tr>

                    <tr>

                    	<td class="label"><label>Zip:</label></td>

                        <td><?php echo $zip_cell; ?></td>

                    </tr>

                    <tr>

                    	<td colspan=2><h5>Can people attend this challenge?</h5></td>

                    </tr>

                    <tr>

                    	<td><?php echo $attend_cell; ?></td>

                    </tr>

                </table>



                <h2 class="title">Why</h2>

                <table>

                    <tr>

                    	<td colspan=2><h5>Challenge Info</h5></td>

                    </tr>

                    <tr>

                    	<td class="label"><label>Blurb (120 Characters):</label></td>

                        <td><?php echo $blurb_cell; ?></td>

                    </tr>

                    <tr>

                    	<td class="label"><label>Description:</label></td>

                        <td><?php echo $description_cell; ?></td>

                    </tr>



                    <tr>

                    	<td class="label"><label>Embed URL of video here:</label></td>

                        <td><?php echo $video_cell; ?></td>

                    </tr>



                    <tr>

                    	<td colspan="2"><label>No video to embed? Upload a challenge photo here!</label></td>

                    </tr>

                    <tr>

                    	<td class="label"><label>Photo:<br />(4 MB maximum size)</label></td>

                        <td><?php echo $image_cell; ?></td>

                    </tr>



                    <tr>

                    	<td class="label"><label>Why do you want to peform this challenge (optional):</label></td>

                        <td><?php echo $whydo_cell; ?></td>

                    </tr>

                    <tr>

                    	<td class="label"><label>Why do you care about this nonprofit? (optional):</label></td>

                        <td><?php echo $whycare_cell; ?></td>

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