<?php



//$new = true;



if($new) {

	$edit = true;

	$attributes = array('id' => 'clusterform', 'class'=>'itemform');

	$edit_id = '';

}



elseif($edit){

	$edit = true;

	$attributes = array('id' => 'clusterform', 'class'=>'itemform');

	$item = $item->row();

	$edit_id = '';

	if($item) {

		$edit_id = $item->theid;

	}

}





if($username = $this->session->userdata('username')) {



	$name = 'admin_email';

	$admin_email_cell =  $username;
	//generate_input($name, 'hidden', $edit, $username);



}

else {



$data = array('name'=>'admin_email', 'id'=>'admin_email', 'size'=>25, 'value'=>($new) ? set_value('admin_email') : $item->admin_email);

$admin_email_cell = ($edit) ? form_input($data) : $item->admin_email;



$name = 'password';

$value = ($new) ? set_value($name) : $item->$name;

$password_cell = generate_input($name, 'password', $edit, $value);



}



if($new) {



$name = 'admin1_name';

$value = ($new) ? set_value($name) : $item->$name;

$admin1_name_cell = generate_input($name, 'input', $edit, $value);



$name = 'admin2_name';

$value = ($new) ? set_value($name) : $item->$name;

$admin2_name_cell = generate_input($name, 'input', $edit, $value);



$name = 'admin3_name';

$value = ($new) ? set_value($name) : $item->$name;

$admin3_name_cell = generate_input($name, 'input', $edit, $value);



$name = 'admin4_name';

$value = ($new) ? set_value($name) : $item->$name;

$admin4_name_cell = generate_input($name, 'input', $edit, $value);



$name = 'admin5_name';

$value = ($new) ? set_value($name) : $item->$name;

$admin5_name_cell = generate_input($name, 'input', $edit, $value);



$name = 'admin1_email';

$value = ($new) ? set_value($name) : $item->$name;

$admin1_email_cell = generate_input($name, 'input', $edit, $value);



$name = 'admin2_email';

$value = ($new) ? set_value($name) : $item->$name;

$admin2_email_cell = generate_input($name, 'input', $edit, $value);



$name = 'admin3_email';

$value = ($new) ? set_value($name) : $item->$name;

$admin3_email_cell = generate_input($name, 'input', $edit, $value);



$name = 'admin4_email';

$value = ($new) ? set_value($name) : $item->$name;

$admin4_email_cell = generate_input($name, 'input', $edit, $value);



$name = 'admin5_email';

$value = ($new) ? set_value($name) : $item->$name;

$admin5_email_cell = generate_input($name, 'input', $edit, $value);



$name = 'personal_message';

$value = ($new) ? set_value($name) : $item->$name;

$personal_message_cell = generate_input($name, 'text', $edit, $value);



}



$name = 'affiliate_organization';

$value = ($new) ? set_value($name) : $item->$name;

$affiliate_cell = generate_input($name, 'text', $edit, $value);



//NPO



$npos = $this->MItems->getDropdownArray('npos', 'name');



/*$npos = array(

			'Brooklyn for Peace' => 'Brooklyn for Peace',

           'Greenpeace' => 'Greenpeace',

		   'Project Kindle' => 'Project Kindle',

		   'Bear Necessities' => 'Bear Necessities',

		   "Children's Heart Foundation" => "Children's Heart Foundation",

		   'Juvenile Diabetes Research Foundation' => 'Juvenile Diabetes Research Foundation'



			);*/



$data = array('name'=>'cluster_npo', 'id'=>'cluster_npo');

$value = ($new) ? set_value('cluster_npo') : $item->cluster_npo;

$npo_cell = ($edit) ? form_dropdown('cluster_npo', $npos, $value) : $item->cluster_npo;





$name = 'cluster_title';

$value = ($new) ? set_value($name) : $item->$name;

$title_cell = generate_input($name, 'input', $edit, $value);





$name = 'cluster_goal';

$value = ($new) ? set_value($name) : $item->$name;

$goal_cell = generate_input($name, 'input', $edit, $value, '', 'short');



$name = 'cluster_blurb';

$value = ($new) ? set_value($name) : $item->$name;

$blurb_cell = generate_input($name, 'text', $edit, $value);



$name = 'cluster_description';

$value = ($new) ? set_value($name) : $item->$name;

$description_cell = generate_input($name, 'text', $edit, $value, '', 'bigtext');



$name = 'cluster_video';

$value = ($new) ? set_value($name) : $item->$name;

$video_cell = generate_input($name, 'text', $edit, $value);



$name = 'cluster_image';

$value = ($new) ? set_value($name) : $item->$name;

$image_cell = generate_input($name, 'text', $edit, $value);



$name = 'cluster_location';

$value = ($new) ? set_value($name) : $item->$name;

$location_cell = generate_input($name, 'input', $edit, $value);



/*

//Completion

$data = array('name'=>'cluster_completion', 'class'=>'datepicker', 'id'=>'cluster_completion', 'size'=>25, 'value'=>($new) ? set_value('cluster_completion') : $item->cluster_completion);

$completion_cell = ($edit) ? form_input($data) : $item->cluster_completion;



//Time

$name = 'cluster_time';

$value = ($new) ? set_value($name) : $item->$name;

$time_cell = generate_input($name, 'input', $edit, $value);



//Fund Raising Completion

$data = array('name'=>'cluster_fr_completed', 'class'=>'datepicker', 'id'=>'cluster_fr_completed', 'size'=>25, 'value'=>($new) ? set_value('cluster_fr_completed') : $item->cluster_fr_completed);

$fr_cell = ($edit) ? form_input($data) : $item->cluster_fr_completed;



// Proof Completion

$data = array('name'=>'cluster_proof_upload', 'class'=>'datepicker', 'id'=>'cluster_proof_upload', 'size'=>25, 'value'=>($new) ? set_value('cluster_proof_upload') : $item->cluster_proof_upload);

$proof_cell = ($edit) ? form_input($data) : $item->cluster_proof_upload;



*/







$name = 'cluster_ch_title';

$value = ($new) ? set_value($name) : $item->$name;

$ch_title_cell = generate_input($name, 'input', $edit, $value);



$name = 'cluster_ch_declaration';

$value = ($new) ? set_value($name) : $item->$name;

$ch_declaration_cell = generate_input($name, 'text', $edit, $value);



$name = 'cluster_ch_goal';

$value = ($new) ? set_value($name) : $item->$name;

$ch_goal_cell = generate_input($name, 'input', $edit, $value, '', 'short');







// Cluster Challenge Where



$name = 'cluster_ch_location';

$value = ($new) ? set_value($name) : $item->$name;

$ch_location_cell = generate_input($name, 'input', $edit, $value);



$name = 'cluster_ch_address';

$value = ($new) ? set_value($name) : $item->$name;

$ch_address_cell = generate_input($name, 'input', $edit, $value);



$name = 'cluster_ch_address2';

$value = ($new) ? set_value($name) : $item->$name;

$ch_address2_cell = generate_input($name, 'input', $edit, $value);



$name = 'cluster_ch_city';

$value = ($new) ? set_value($name) : $item->$name;

$ch_city_cell = generate_input($name, 'input', $edit, $value);



$name = 'cluster_ch_state';

$value = ($new) ? set_value($name) : $item->$name;

$ch_state_cell = generate_input($name, 'dropdown', $edit, $value, get_special_array('states'));



$name = 'cluster_ch_zip';

$value = ($new) ? set_value($name) : $item->$name;

$ch_zip_cell = generate_input($name, 'input', $edit, $value);



$name = 'cluster_ch_network';

$value = ($new) ? set_value($name) : $item->$name;

$ch_network_cell = generate_input($name, 'dropdown', $edit, $value, get_special_array('networks'));



$name = 'cluster_ch_attend';

$value = ($new) ? set_value($name) : $item->$name;

$ch_attend_cell = generate_input($name, 'dropdown', $edit, $value, get_special_array('attend'));



// Cluster Challenge When



$name = 'cluster_ch_fr_ends';

$value = ($new) ? set_value($name) : $item->$name;

$ch_fr_ends_cell = generate_input($name, 'input', $edit, $value, '', 'datepicker');



$name = 'cluster_ch_completion';

$value = ($new) ? set_value($name) : $item->$name;

$ch_completion_cell = generate_input($name, 'input', $edit, $value, '', 'datepicker');



$name = 'cluster_ch_proofdate';

$value = ($new) ? set_value($name) : $item->$name;

$ch_proofdate_cell = generate_input($name, 'input', $edit, $value, '', 'datepicker');





// Cluster challenge Why



$name = 'cluster_ch_blurb';

$value = ($new) ? set_value($name) : $item->$name;

$ch_blurb_cell = generate_input($name, 'text', $edit, $value);



$name = 'cluster_ch_description';

$value = ($new) ? set_value($name) : $item->$name;

$ch_description_cell = generate_input($name, 'text', $edit, $value);



$name = 'cluster_ch_video';

$value = ($new) ? set_value($name) : $item->$name;

$ch_video_cell = generate_input($name, 'text', $edit, $value);











?>



<?php if($new) :?>
<div id="ClusterForm" class="form">

<div id="LeftColumn">
</div>
<?php endif; ?>


<div id="RightColumn">



	<div class="featuredbox">

	    <?php if($message) {

	echo "<p class='message'>".$message."<span class='val_errors'>";

	echo validation_errors();

	echo "</span></p>";

} ?>

    </div>



    <div class="module">

        <h2 class="title titlebg"><?php echo ($new) ? "Start A" : "Edit"; ?> Cluster</h2>

        <div class="InfoDisplay FormBG">

<?php



if(!$edit) {

	echo "<tr><td colspan=2>".anchor('item/view/cluster/'.$item->id.'/1', 'Edit', array('class'=>'editbutton'))."</td></tr>";

}





if($new)

	$edit = true;



if($edit){



	echo form_open_multipart('cluster/process/cluster/'.$edit_id, $attributes);

}

?>





<script>

var num_extra_admins = 1;

</script>



          		<h2 class="title">WHO</h2>

            	<table>

                	<tr>

	                	<td colspan=2><h5>Log In/Register:</h5></td>

                    </tr>

                    <tr>

	                    <td class="label"><label>Admin Email (or Username):</label></td>

                        <td><?php echo $admin_email_cell; ?></td>

                    </tr>

                    <?php if(!$username) : ?>

                    <tr>

                    	<td class="label"><label>Password:</label></td>

                        <td><?php echo $password_cell; ?></td>

                    </tr>



                    <?php 	if($new) : ?>

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

                    <?php 	endif; ?>

                    <?php endif; ?>



                    <?php if($new) : ?>



                    <tr>

                    	<td colspan=2><h5>Invite Additional Adminstrators</h5></td>

                    </tr>

                    <tr>

                    	<td class="label"><label>Admin 1 Name:</label></td>

                        <td><?php echo $admin1_name_cell; ?></td>

                    </tr>

                    <tr>

                    	<td class="label"><label>Admin 1 Email:</label></td>

                        <td><?php echo $admin1_email_cell;  ?></td>

                    </tr>

                   <tr id="admin2name">

                    	<td class="label"><label>Admin 2 Name:</label></td>

                        <td><?php echo $admin2_name_cell; ?></td>

                    </tr>

                    <tr id="admin2email">

                    	<td class="label"><label>Admin 2 Email:</label></td>

                        <td><?php echo $admin2_email_cell;  ?></td>

                    </tr>

                    <!--

                    <tr id="admin3name">

                    	<td class="label"><label>Admin 3 Name:</label></td>

                        <td><?php echo $admin3_name_cell; ?></td>

                    </tr>

                    <tr id="admin3email">

                    	<td class="label"><label>Admin 3 Email:</label></td>

                        <td><?php echo $admin3_email_cell;  ?></td>

                    </tr>

                    <tr id="admin4name">

                    	<td class="label"><label>Admin 4 Name:</label></td>

                        <td><?php echo $admin4_name_cell; ?></td>

                    </tr>

                    <tr id="admin4email">

                    	<td class="label"><label>Admin 4 Email:</label></td>

                        <td><?php echo $admin4_email_cell;  ?></td>

                    </tr>

                    <tr id="admin5name">

                    	<td class="label"><label>Admin 5 Name:</label></td>

                        <td><?php echo $admin5_name_cell; ?></td>

                    </tr>

                    <tr id="admin5email">

                    	<td class="label"><label>Admin 5 Email:</label></td>

                        <td><?php echo $admin5_email_cell;  ?></td>

                    </tr>

                    -->

                    <tr>

                    	<td class="label"><label>Personal Message:</label></td>

                        <td><?php echo $personal_message_cell; ?></td>

                    </tr>



                    <?php endif; ?>



                </table>



                <h2 class="title">WHAT</h2>



                <table>

                    <tr>

                    	<td colspan=2><h5>Cluster</h5></td>

                    </tr>

                    <tr>

                    	<td class="label"><label><span class="required">*</span>Cluster Title:</label></td>

                        <td><?php echo $title_cell; ?></td>

                    </tr>



                    <tr>

                    	<td class="label"><label>Fundraising Goal (optional):</label></td>

                        <td>$ <?php echo $goal_cell; ?></td>

                    </tr>





                    <tr>

                    	<td class="label"><label><span class="required">*</span>Select your Nonprofit:</label></td>

                        <td><?php echo $npo_cell; ?></td>

                    </tr>



                    <tr>

                    	<td class="label"><label><span class="required">*</span>Blurb (120 Characters):</label></td>

                        <td><?php echo $blurb_cell; ?></td>

                    </tr>



                    <tr>

                    	<td class="label"><label><span class="required">*</span>Description:</label></td>

                        <td><?php echo $description_cell; ?></td>

                    </tr>





                    <tr>

                    	<td colspan=2><h5>Media</h5></td>

                    </tr>



                    <?php if(!$new && $item->cluster_image) : ?>



                    <tr>

                    	<td class="label"><label>Current Image</label></td>

                        <td><img src="/media/clusters/<?php echo $item->cluster_image; ?>" /></td>

                    </tr>



                    <?php endif; ?>



                    <tr>

                    	<td class="label"><label>Select your image:</label><br />(4 MB maximum size)</td>

                        <td><?php echo generate_input('cluster_image', 'file', $edit, ''); ?></td>

                    </tr>



                    <tr>

                    	<td class="label"><label>Embed your video:</label></td>

                        <td><?php echo generate_input('cluster_video', 'text', $edit, ''); ?></td>

                    </tr>

                </table>



                <h2 class="title">CHALLENGE CONTROL</h2>

                <table>

                	<tr>

                    	<td colspan=2><h5>Challenge Control: <span style="font-weight:normal;">Editing the fields below will change all challenges within your cluster...</span></h5></td>

                    </tr>



                    <tr>

                    	<td class="label"><label>Challenge Title:</label></td>

                        <td><?php echo $ch_title_cell; ?></td>

                    </tr>



                    <tr>

                    	<td class="label"><label>Challenge Declaration: I/we will</label></td>

                        <td><?php echo $ch_declaration_cell; ?></td>

                    </tr>



                    <tr>

                    	<td class="label"><label>Challenge Fund Raising Goal:</label></td>

                        <td>$<?php echo $ch_goal_cell; ?></td>

                    </tr>





                    <tr>

                    	<td colspan=2><h5>When</h5></td>

                    </tr>

                    <tr>

                    	<td class="label"><label>Challenge Fund Rasing Ends:</label></td>

                        <td><?php echo $ch_fr_ends_cell; ?></td>

                    </tr>

                    <tr>

                    	<td class="label"><label>Challenge Completion:</label></td>

                        <td><?php echo $ch_completion_cell; ?></td>

                    </tr>



                    <tr>

                    	<td class="label"><label>Challenge Proof Uploaded:</label></td>

                        <td><?php echo $ch_proofdate_cell; ?></td>

                    </tr>



                    <tr>

                    	<td colspan=2><h5>Where</h5></td>

                    </tr>

                    <tr>

                    	<td class="label"><label>Location:</label></td>

                        <td><?php echo $ch_location_cell; ?></td>

                    </tr>

                    <tr>

                    	<td class="label"><label>Address:</label></td>

                        <td><?php echo $ch_address_cell; ?></td>

                    </tr>

                    <tr>

                    	<td class="label"><label>Address 2 (if needed):</label></td>

                        <td><?php echo $ch_address2_cell; ?></td>

                    </tr>

                    <tr>

                    	<td class="label"><label>City:</label></td>

                        <td><?php echo $ch_city_cell; ?></td>

                    </tr>

                    <tr>

                    	<td class="label"><label>State:</label></td>

                        <td><?php echo $ch_state_cell; ?></td>

                    </tr>

                    <tr>

                    	<td class="label"><label>Zip:</label></td>

                        <td><?php echo $ch_zip_cell; ?></td>

                    </tr>

                    <tr>

                    	<td class="label"><label>Can people attend this challenge?:</label></td>

                        <td><?php echo $ch_attend_cell; ?></td>

                    </tr>



                    <tr>

                    	<td colspan=2><h5>Why</h5></td>

                    </tr>

                    <tr>

                    	<td class="label"><label>Challenge Blurb:</label></td>

                        <td><?php echo $ch_blurb_cell; ?></td>

                    </tr>

                    <tr>

                    	<td class="label"><label>Challenge Description:</label></td>

                        <td><?php echo $ch_description_cell; ?></td>

                    </tr>

                    <tr>

                    	<td class="label"><label>Challenge Video:</label></td>

                        <td><?php echo $ch_video_cell; ?></td>

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