<?php



//$new = true;

$challenge_info = $this->session->userdata('challenge_info');

if($message) {

	echo "<p class='message'>".$message."<span class='val_errors'>";
	echo validation_errors();
	echo "</span></p>";

}



$attributes = array('id' => 'challengeform', 'class'=>'itemform');

if($new) {

	$challenge_info = array();
	$this->session->set_userdata('challenge_info',$challenge_info);
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
		$this->session->set_userdata('edit_id', $edit_id);
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

$npo_cell = (@$cluster->cluster_npo) ? $this->beex->name_that_npo($cluster->cluster_npo).generate_input('challenge_npo', 'hidden', $edit, $cluster->cluster_npo) : (($edit) ? form_dropdown('challenge_npo', $npos, $value, 'id="challenge_npo"') : $item->challenge_npo);



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

$attend_cell = (@$cluster->cluster_ch_attend) ? $cluster->cluster_ch_attend.generate_input('challenge_attend', 'hidden', $edit, $cluster->cluster_ch_attend) : (($edit) ? form_dropdown('challenge_attend', $attends, $value,  'id="challenge_attend"') : $item->challenge_attend);



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
        <h2 class="title titlebg">Start A Challenge</h2>



<?php endif; ?>



        <div class="InfoDisplay FormBG">

<?php



if(!$edit) {

	echo "<tr><td colspan=2>".anchor('item/view/challenge/'.$item->id.'/1', 'Edit', array('class'=>'editbutton'))."</td></tr>";

}





if($new)

	$edit = true;



if($edit){


/* don't want to display the <form> anymore, to avoid the [return] button invoking a submit */
//	echo (@$cluster) ? form_open_multipart('challenge/process/challenge/'.$edit_id, $attributes) : form_open_multipart('challenge/process/challenge/'.$edit_id, $attributes);
	echo '<form id="challengeform" class="itemform" onsubmit="return false;">';


}

?>


<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>scripts/beex_helper.js"></script>	
<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>scripts/ajaxupload.js"></script>	


<style type="text/css">
	#challenge_module {
		height: 400px;
		width: 700px;
	}
	#help_column {
		width: 150px;
		height: 400px;
		float: right;
	}
	#creation_tab {
		padding-top: 25px;
	}	
	.creation_step {
		display: none;
	}
	.creation_substep {
		display: none;
	}
	#error_field {
		color: red;
		font-weight: bold;
		font-size: 1.3em;
	}
	.black_overlay{
		display: none;
		position: absolute;
		top: 0%;
		left: 0%;
		width: 100%;
		height: 100%;
		background-color: black;
		z-index:1001;
		-moz-opacity: 0.8;
		opacity:.80;
		filter: alpha(opacity=80);
	}
	.white_content {
		display: none;
		position: absolute;
		top: 25%;
		left: 25%;
		width: 50%;
		height: 50%;
		padding: 16px;
		border: 16px solid orange;
		background-color: white;
		z-index:1002;
		overflow: auto;
	}
	.bold {
		font-weight: bold;
	}
	.disabled {
		background-color: gray;
	}
</style>
<script type="text/javascript">
	$(document).ready(function() {
		
		
		
		help_column = {
			"who_tab": "Start by logging in or registering a new account.  If you use Facebook, we suggest logging in through Facebook Connect because you can automatically update your Facebook friends from this website.",			
			"what_tab": {
				"cluster_id":"Is your challenge part of a greater cluster? If you don't know what this is, then don't worry about it!",
				"challenge_title": "What do you want your challenge to be called? Creativity is an asset but so is clarity.  Puns are popular but we try not to endorse them.",
				"challenge_declaration":"What are you willing to do?  BEEx automatically adds the 'I will' ('We will' if you have a partner) so just type the action you're performing. For instance, if you type &quot;Jump the Grand Canyon&quot;, your challenge will read &quot;I will Jump the Grand Canyon&quot;. Check out our blog post &quot;What is a Challenge&quot; (http://blog.beex.org/?p=374) if you want more advice.",
				"proof_description":"Use this box to describe how you're going to prove that you completed your challenge.  For example: I'm going to have pictures taken crossing the finish line or I'm filming my haircut. This proof will be prominently displayed on your challenge page once your challenge is over.  Make it great so your donors love you.",
				"challenge_goal":"How much money are you trying to raise?  This is a big question.  Our blog post &quot;Challenge Creation&quot; (http://blog.beex.org/?p=392) might give you some helpful tips for how to chose the best amount.",
				"challenge_npo": "If you don't see the nonprofit you're looking for email Matt[at]beex.org and we'll register them ASAP and let you know when they've signed up.",
				"partner_bool": "Partner - Are you partnering with someone to complete this challenge?  If so, fill in their info and we'll make sure they're signed up and ready to fundraise with you."
			},				
			"when_where_tab": {
				"challenge_location":"Where are you going to perform your challenge?  If it's somewhere virtual, enter it's URL.",
				"challenge_attend":"Will you be performing your challenge in front of an audience? Can anyone come and watch?",				
				"fundraising_completed_date":"What is the last day you'll be accepting funds?  If you're participating in an organized event, like a marathon, make sure you don't miss the fundraising deadline.",
				"proof_posted_date":"When are you going to post your proof onto BEEx? Yes...we expect you to actually prove you completed your challenge and so do your donors."
			},
			"why_tab": {
				"challenge_blurb":"Think of this as the tagline for your challenge. Make it short, sweet and interesting.",
				"challenge_video":"We always recommend using video. For example:<br />http://www.youtube.com/watch?v=ZnehCBoYLbc<br />http://vimeo.com/2950999",
				"challenge_description":"This is your opportunity to be a little more wordy. Put in all the necessary details that haven't been addressed.",
				"challenge_whydo":"Why do you want to perform this challenge - Everyone is probably wondering why you're doing this...",
				"challenge_whycare":"Why do you care about this nonprofit - Why is this organization great?  Why should your donors care about them?"
			}
		}
		
		function buzzy_the_paper_clip() {
			// Adjusts help column text as appropriate
			tab_info_type = typeof help_column[$(this).parent().parent()[0].id];
			switch(tab_info_type) {
				case 'object':
					$("#help_column").html(help_column[$(this).parent().parent()[0].id][this.id]);
					break;
				case 'string':
					$("#help_column").html(help_column[$(this).parent().parent()[0].id]);
					break;				
			}

		}
		$("#creation_tab input, textarea").focus(buzzy_the_paper_clip);
		

		

		<?php

		if(isset($edit_id) && $edit_id != '') {
			$challenge_creation_step = 'what';
			echo 'field_array = ';
			echo json_encode($item) . ';';
			if(isset($item->challenge_image)) {
				$ch_img = base_url() . 'media/challenges/' . $item->challenge_image;
				echo <<<JS_IMG
					ch_img = document.createElement("img");
					ch_img.src = "{$ch_img}";
					$("#upload_area").append(ch_img);
JS_IMG;
			}
			echo <<<JAVASCRIPT
				
				for(fieldName in field_array) {
					if($("#" + fieldName).length > 0) {
						$("#" + fieldName).val(field_array[fieldName]);
					}
				}				
JAVASCRIPT;
				
				echo 'current_tab = \'what_tab\';';	
		}
		elseif(isset($username) && $username != '') {
			$challenge_creation_step = 'what';
			echo 'current_tab = \'what_tab\';';
		}
		else {
			$challenge_creation_step = 'who';	
			echo 'current_tab = \'who_tab\';';
		}					
		

	
		echo <<<SHOW_HIDE
			what_ok = false;
			when_where_ok = false;
			
			if(current_tab == 'who_tab') {
				$("#nav_who").addClass("bold");		
			}
			else if(current_tab == 'what_tab') {
				$("#nav_what").addClass("bold");
			}
		
		
			$('#{$challenge_creation_step}_tab').show();
			$('#help_column').html(help_column['{$challenge_creation_step}_tab']);
SHOW_HIDE;

		?>
		
		if($("#challenge_declaration").val().length > 0) {
			$("#dyn_what_will_do").html($("#challenge_declaration").val());
		}
		if($("#challenge_goal").val().length > 0) {
			$("#dyn_how_much_raised").html($("#challenge_goal").val());					
		}
		
		if($("#challenge_npo option:selected").val().length > 0) {
			$("#dyn_which_npo").html($("#challenge_npo option:selected").text());			
		}
		
		
		$(".account_yet").click(function() {
			$("#user_registered_yet").hide();
			if($(this).val() == 'Yes!') {
				$("#already_registered").show();
			}
			else {
				$("#not_registered").show();
				$("#password2").blur(function() {
					if($("#password1").val() == $(this).val() && $(this).val() != '') {
						$("#password_validation").html("PASSWORDS MATCH");
					}
					else {						
						$("#password_validation").html("PASSWORDS DO NOT MATCH");
					}
				});			
			}
		});
		
		$("#register_continue").click(function() {
			passwords_equal = ($("#password1").val() == $("#password2").val());
			if(passwords_equal) {
					
				email = $(this).parent().find("input[name=email]").val();
				legal_name = $(this).parent().find("input[name=legal_name]").val();
				password = $(this).parent().find("input[name=password1]").val();

				jQuery.ajax({
					 type: "POST",
					 url: "<?php echo base_url(); ?>index.php/ajax/create_user",
					 dataType: "json",
					 data: "email=" + email + "&legal_name=" + legal_name + "&password=" + MD5(password),
					 success: function(ret){
						if(ret['success']) { // advance to the next step. 
							$("#who_tab").hide();
							$("#what_tab").show();
							$("#nav_what").addClass("bold");
							$("#nav_who").removeClass("bold");
							current_tab = 'what_tab';							
						}
						else {
							$("#registration_errors").html(ret['errors']);
						}
					 }
				});
			}
			else {
				$("#password_validation").html("PASSWORDS DO NOT MATCH");
			}

		});
		
		$("#registered_continue").click(function() {

			email = $(this).parent().find("input[name=email]").val();
			password = $(this).parent().find("input[name=password]").val();
			
			jQuery.ajax({
				 type: "POST",
				 url: "<?php echo base_url(); ?>index.php/ajax/login_user",
				 dataType: "json",
				 data: "email=" + email + "&password=" + password,
				 success: function(ret){
					if(ret['success']) { // advance to the next step. 
						$("#who_tab").hide();
						$("#what_tab").show();
						$("#nav_who").removeClass("bold");
						$("#nav_what").addClass("bold");		
						$("#login_errors").html("");
						current_tab = 'what_tab';
					}
					else {
						$("#login_errors").html(ret['errors']);
					}
				 }
			});
		});
		
		$("#partner_bool").change(function() {
		    if($(this).attr("checked") == true) {
				$("#partner_field").show();
			}
			else {
				$("#partner_field").hide();
			}
		});
		
		
		
		$("#challenge_declaration").keyup(function() {			
			declaration_string = $("#challenge_declaration").val();
			if(declaration_string.length>120) {
				$("#error_field").html("Please enter a declaration less than 120 characters! You're currently at " + declaration_string.length + " characters.");
				$("#dyn_what_will_do").html('<span style="color:red;text-decoration:line-through">'+ declaration_string+'</span>');
			}
			else {
				$("#error_field").html("");
				$("#dyn_what_will_do").html(declaration_string);
			}
		});		
		$("#challenge_goal").keyup(function() {
			$("#dyn_how_much_raised").html($("#challenge_goal").val());
		});
		$("#challenge_npo").change(function() {
			$("#dyn_which_npo").html($("#challenge_npo option:selected").text());
		});
		
		$("#cluster_id").blur(function() {
			cluster_code = $(this).val();

			jQuery.ajax({
				 type: "POST",
				 dataType: "json",
				 url: "<?php echo base_url(); ?>index.php/ajax/cluster_validate",
				 data: "cluster_code=" + cluster_code,
				
				 success: function(ret){
					if(ret == 'false') {
						$("#error_field").append("Not a valid cluster code!");
					}
					else {
						$("#error_field").html("");
						$("#cluster_id").parent().html("Cluster Code: Accepted!");


						function solidify(field) {
							state_parent = $("#challenge_" + field).parent();
							$("#challenge_" + field).remove();
							solid_state = document.createElement('input');
							solid_state.id = "challenge_"  + field;
							solid_state.name = "challenge_" + field;
							state_parent.append(solid_state);
							$("#challenge_" + field).attr("readonly", "true");
							$("#challenge_" + field).addClass("disabled");	
							$("#challenge_" + field).val(ret[key]);										
						}
						
						for(key in ret) {
							if($("#challenge_" + key).length > 0) {
								if(ret[key] != null && ret[key].length > 0) {
									$("#challenge_" + key).val(ret[key]);
									$("#challenge_" + key).attr("readonly", "true");
									$("#challenge_" + key).addClass("disabled");	
									
									if(key == 'state') {
										solidify('state');
									}
									
									if(key == 'attend') {
										solidify('attend');
									}
									if(key == 'completion') {
										solidify('completion');
									}
									if(key == 'blurb') {
										solidify('blurb');
									}
								}
							}
						}				
					}
		
				 }
			});									



		});
		
		$("#what_continue").click(function() {
			challenge_title = $("#challenge_title").val();
			challenge_declaration = $("#challenge_declaration").val();
			proof_description = $("#proof_description").val();
			challenge_goal = $("#challenge_goal").val();
			challenge_npo = $("#challenge_npo").val();
			partner_bool = $("#partner_bool").attr("checked");
			partner_name = $("#partner_name").val();
			partner_email = $("#partner_email").val();
			
			$("#error_field").html("");
			// do validation locally, for required fields, before saving it off..
			validation_errors = false;
			
			if(!(!isNaN(challenge_goal)&&parseInt(challenge_goal)==challenge_goal) || challenge_goal == '') {
				$("#error_field").append("Fundraising goal must be a NUMBER.<br />");
				validation_errors = true;				
			}
			if(challenge_title == '') {
				$("#error_field").append("Challenge title must be filled out.<br />");
				validation_errors = true;				
			}
			if(challenge_declaration.length > 120 || challenge_declaration == '') {
				$("#error_field").append("Challenge declaration must be filled out, and no more than 120 characters in length.<br />");
				validation_errors = true;				
			}
			if(proof_description == '') {
				$("#error_field").append("Proof description must be filled out.<br />");
				validation_errors = true;				
			}
			
			if(validation_errors) { 
				return false;
			}
			
			jQuery.ajax({
				 type: "POST",
				 url: "<?php echo base_url(); ?>index.php/ajax/challenge_what",
				 dataType: "json",
				 data: "challenge_title=" + challenge_title + "&challenge_declaration=" + challenge_declaration + "&proof_description=" + proof_description + "&challenge_goal=" + challenge_goal + "&challenge_npo=" + challenge_npo + "&partner_bool=" + partner_bool + "&partner_name=" + partner_name + "&partner_email=" + partner_email,
				 success: function(ret){
					
					if(ret['success']) { // advance to the next step. 
						$("#what_tab").hide();
						$("#when_where_tab").show();
						$("#nav_what").removeClass("bold");
						$("#nav_when_where").addClass("bold");
						$("#error_field").html("");
						what_ok = true;
						current_tab = 'when_where_tab';
//						$("#help_column").html(help_column['when_where_tab']);
					}
					else {
						$("#login_errors").html(ret['errors']); // change this to a universal error field?? hm..??
					}
				 }
			});									
		});
		
		$("#when_where_continue").click(function() {
			challenge_location = $("#challenge_location").val();
			challenge_address1 = $("#challenge_address1").val();
			challenge_city = $("#challenge_city").val();
			challenge_state = $("#challenge_state").val();
			challenge_zip = $("#challenge_zip").val();
			challenge_attend = $("#challenge_attend").val();
			challenge_fr_completed = $("#challenge_fr_completed").val();
			challenge_completion = $("#challenge_completion").val();
			challenge_proof_upload = $("#challenge_proof_upload").val();
			// do validation locally, for required fields, before saving it off..
			
			$("#error_field").html("");
			validation_errors = false;
			if(!(!isNaN(challenge_zip)&&parseInt(challenge_zip)==challenge_zip) || challenge_zip.length != 5) {			
				$("#error_field").append("Please enter a valid 5-digit zipcode.<br />");
				validation_errors = true;				
			}
			if(challenge_completion == '') {
				$("#error_field").append("Please enter a date for your fundraising completion.<br />");
				validation_errors = true;
			}
			if(validation_errors) {
				return false;
			}
			
			jQuery.ajax({
				 type: "POST",
				 url: "<?php echo base_url(); ?>index.php/ajax/challenge_when_where",
				 dataType: "json",
				 data: "challenge_location=" + challenge_location + "&challenge_address1=" + challenge_address1 + "&challenge_city=" + challenge_city + "&challenge_state=" + challenge_state + "&challenge_zip=" + challenge_zip + "&challenge_attend=" + challenge_attend + '&challenge_fr_completed=' + challenge_fr_completed + '&challenge_completion=' + challenge_completion + '&challenge_proof_upload=' + challenge_proof_upload,
				 success: function(ret){
					if(ret['success']) { // advance to the next step. 
						$("#when_where_tab").hide();
						$("#why_tab").show();
						$("#nav_why").addClass("bold");
						$("#nav_when_where").removeClass("bold");
						$("#error_field").html("");
						when_where_ok = true;
						current_tab = 'why_tab';
					}
					else {
						$("#login_errors").html(ret['errors']); 
					}
				 }
			});
		});
	
		tab_list = ["who","what","when_where","why"];
		
		
		$("#nav_what").click(function() {
			if(current_tab != 'who_tab') {
				$("#when_where_tab").hide();
				$("#why_tab").hide();
				$("#what_tab").show();
				for(tab in tab_list) {
					$("#nav_" + tab_list[tab]).removeClass("bold");
				}
				$(this).addClass("bold");							
				
			}
			
		});
		$("#nav_when_where").click(function() {
			if(current_tab != 'who_tab') {				
				$("#when_where_tab").show();
				$("#why_tab").hide();
				$("#what_tab").hide();
				for(tab in tab_list) {
					$("#nav_" + tab_list[tab]).removeClass("bold");
				}
				$(this).addClass("bold");
			}
			
		});
		$("#nav_why").click(function() {
			if(current_tab != 'who_tab') {			
				$("#when_where_tab").hide();
				$("#what_tab").hide();
				$("#why_tab").show();
				for(tab in tab_list) {
					$("#nav_" + tab_list[tab]).removeClass("bold");
				}
				$(this).addClass("bold");
			}			
		});
		
		$("#when_where_previous").click(function() {
			$("#when_where_tab").hide();
			$("#what_tab").show();
			$("#nav_what").addClass("bold");
			$("#nav_when_where").removeClass("bold");
			
//			$("#help_column").html(help_column['what_tab']);
		});
		$("#why_previous").click(function() {
			$("#why_tab").hide();
			$("#when_where_tab").show();
			$("#nav_when_where").addClass("bold");
			$("#nav_why").removeClass("bold");
			
//			$("#help_column").html(help_column['when_where_tab']);			
		});
		
		$("#why_continue").click(function() { // last step.. fin!
			challenge_blurb = $("#challenge_blurb").val();
			challenge_description = $("#challenge_description").val();
			challenge_whydo = $("#challenge_whydo").val();
			challenge_whycare = $("#challenge_whycare").val();
			challenge_video = $("#challenge_video").val();
					
			// do validation locally, for required fields, before saving it off..
			if(!what_ok || !when_where_ok) {
				
				$("#error_field").html("Please fill out the required fields on the what tab, and the when/where tab, before finishing up!");
				return false;
			}
			
			jQuery.ajax({
				 type: "POST",
				 url: "<?php echo base_url(); ?>index.php/ajax/challenge_why",
				 dataType: "json",
				 data: "challenge_blurb=" + challenge_blurb + "&challenge_description=" + challenge_description + "&challenge_whydo=" + challenge_whydo + "&challenge_whycare=" + challenge_whycare + "&challenge_video=" + challenge_video,
				 success: function(ret){
					console.log(ret);
					if(ret['success']) { // advance to the next step. 
						window.location = '<?php echo base_url(); ?>index.php/challenge/view/' + ret['challenge_id'];
					}
					else {
						$("#login_errors").html(ret['errors']); // change this to a universal error field ..? hmm?
					}
				 }
			});			
		});
		
		
	});
</script>
	
<div id="challenge_module">
	<div id="nav_bar">
		<span id="nav_who">Who</span> *
		<span id="nav_what">What</span> *
		<span id="nav_when_where">When/Where</span> *
		<span id="nav_why">Why</span>
	</div>
	<div id="help_column">
		Hello. This is advice on how to complete the current step.
	</div>
	<div id="creation_tab">
		<div id="who_tab" class="creation_step">
			<div id="user_registered_yet">
				<h2>Do you already have an account on BeEx?</h2>
				<input type="button" name="already_have_account" id="already_have_account" class="account_yet" value="Yes!">
				<input type="button" name="no_account_yet" id="no_account_yet" class="account_yet" value="Not Yet!">
			</div>
			
			<div id="already_registered" class="creation_substep">
				<div class="input_wrapper">
					<label>email</label>
					<input type="text" name="email" id="email">
				</div>
				<div class="input_wrapper">
					<label>password</label>
					<input type="password" name="password" id="password">
				</div>
				<span name="login_errors" id="login_errors"></span>
				<input type="button" name="registered_continue" id="registered_continue" value="Continue">
			</div>
			<div id="not_registered" class="creation_substep">
				<div class="input_wrapper">
					<label>full name</label>
					<input type="text" name="legal_name" id="legal_name">
				</div>
				<div class="input_wrapper">
					<label>email address</label>
					<input type="text" name="email" id="email">
				</div>
				<div class="input_wrapper">
					<label>password</label>
					<input type="password" name="password1" id="password1">
				</div>
				<div class="input_wrapper">
					<label>password confirmation</label>
					<input type="password" name="password2" id="password2">
				</div>
  				<span id="password_validation"></span><br />
				<span name="registration_errors" id="registration_errors"></span>
				<input type="button" name="register_continue" id="register_continue" value="Create Account &amp; Continue">
			</div>			
		</div>
		<div id="what_tab" class="creation_step">
			<div class="input_wrapper">
				<label>cluster code</label>
				<input type="text" name="cluster_id" id="cluster_id">
				<span id="cluster_ok" name="cluster_ok"></span>
			</div>
 		 	<div class="input_wrapper">
				<label class="required">challenge title</label>
				<input type="text" name="challenge_title" id="challenge_title">
			</div>
			<div class="input_wrapper">
				<label class="required">declaration</label>
				<textarea name="challenge_declaration" id="challenge_declaration"></textarea>
			</div>
			<div class="input_wrapper">
				<label class="required">proof description</label>
				<textarea name="proof_description" id="proof_description"></textarea>
			</div>
			<div class="input_wrapper">
				<label class="required">fundraising goal</label>
				<input type="text" name="challenge_goal" id="challenge_goal">
			</div>
			<div class="input_wrapper">
				<label>benefitting npo</label>
				<?php echo $npo_cell; ?>
			</div>
			<div class="input_wrapper">
				<label>partner?</label>
				<input type="checkbox" name="partner_bool" id="partner_bool">				
			</div>
			<div id="partner_field" class="creation_substep">
				<div class="input_wrapper">
					<label>partner name</label><input type="text" name="partner_name" id="partner_name">
				</div>
				<div class="input_wrapper">
					<label>partner email</label><input type="text" name="partner_email" id="partner_email">
				</div>
			</div>
			<div class="preview_box" id="preview_box">
				<h1>Preview of Declaration</h1>
				I will 
				<span class="dyn_what_will_do" id="dyn_what_will_do">_____</span> 
				if
				$<span class="dyn_how_much_raised" id="dyn_how_much_raised">_____</span>
				is raised for 
				<span class="dyn_which_npo" id="dyn_which_npo">______</span>
			</div>
			<input type="button" name="what_continue" id="what_continue" value="Continue to next step">
		</div>
		<div id="when_where_tab" class="creation_step">
			<div class="input_wrapper">
				<label>Location Name</label>
				<input type="text" name="challenge_location" id="challenge_location">				
			</div>
			<div class="input_wrapper">
				<label>address</label>
			 	<input type="text" name="challenge_address1" id="challenge_address1">
			</div>
			<div class="input_wrapper">
				<label>city</label>  
				<input type="text" name="challenge_city" id="challenge_city">		
			</div>
			<div class="input_wrapper">
				<label>state</label>				
				<?php 
				if(isset($challenge_info['challenge_state'])) {
					$set_state = $challenge_info['challenge_state'];
				}
				else {
					$set_state='';
				}
				$state_cell = generate_input('challenge_state', 'dropdown', true, $set_state, get_special_array('states')); 
				echo $state_cell; 
				?> 
			</div>
			<div class="input_wrapper">
				<label>zipcode</label>
				<input type="text" name="challenge_zip" id="challenge_zip">			 
			</div>
			<div class="input_wrapper">
				<label>can people attend?</label>
				<?php echo $attend_cell; ?>
			</div>
			<div class="input_wrapper">
				<label class="required">fundraising compl</label>
				<?php echo $completion_cell; ?>
			</div>
			<div class="input_wrapper">
				<label>challenge compl</label>
				<?php echo $fr_cell; ?>
			</div>
			<div class="input_wrapper">
				<label>proof post</label>
				<?php echo $proof_cell; ?>
			</div>
			<input type="button" name="when_where_previous" id="when_where_previous" value="Go back to edit the previous step">
			<input type="button" name="when_where_continue" id="when_where_continue" value="Continue to the next step!">				
		</div>
		<div id="why_tab" class="creation_step">
			<div class="input_wrapper">
				<label>blurb</label>
				<textarea name="challenge_blurb" id="challenge_blurb"></textarea>
			</div>
			<div class="input_wrapper">
				<label>descript</label>
				<textarea name="challenge_description" id="challenge_description"></textarea>
			</div>			
			<div class="input_wrapper">
				<label>image (4MB max)</label>
				<fieldset>
					<form action="<?php echo base_url(); ?>index.php/ajax/image_upload" method="post" name="sleeker" id="sleeker" enctype="multipart/form-data">
						<input type="hidden" name="maxSize" value="9999999999" />
						<input type="hidden" name="maxW" value="200" />
						<input type="hidden" name="fullPath" value="<?php echo base_url(); ?>/media/challenges/" />
						<input type="hidden" name="relPath" value="../uploads/" />
						<input type="hidden" name="colorR" value="255" />
						<input type="hidden" name="colorG" value="255" />
						<input type="hidden" name="colorB" value="255" />
						<input type="hidden" name="maxH" value="300" />
						<input type="hidden" name="filename" value="filename" />
						<p><input type="file" name="filename" onchange="ajaxUpload(this.form,'<?php echo base_url(); ?>index.php/ajax/image_upload?filename=name&amp;maxSize=9999999999&amp;maxW=200&amp;fullPath=http://www.atwebresults.com/php_ajax_image_upload/uploads/&amp;relPath=../uploads/&amp;colorR=255&amp;colorG=255&amp;colorB=255&amp;maxH=300','upload_area','File Uploading Please Wait...&lt;br /&gt;&lt;img src=\'images/loader_light_blue.gif\' width=\'128\' height=\'15\' border=\'0\' /&gt;','&lt;img src=\'images/error.gif\' width=\'16\' height=\'16\' border=\'0\' /&gt; Error in Upload, check settings and path info in source code.'); return false;" /></p>
					</form>					
				</fieldset>
				<div id="upload_area" name="upload_area">					
				</div>			
			</div>
			<div class="input_wrapper">
				<label>link to video</label>
				<input type="text" id="challenge_video" name="challenge_video" />
			</div>
			<div class="input_wrapper">
				<label>why do u care?</label>
				<textarea name="challenge_whydo" id="challenge_whydo"></textarea>
			</div>
			<div class="input_wrapper">
				<label>why do u want to perform?</label>
				<textarea name="challenge_whycare" id="challenge_whycare"></textarea>
			</div>			
			<input type="button" name="why_previous" id="why_previous" value="Go back to edit the previous step">
			<input type="button" name="why_continue" id="why_continue" value="Finish creating your challenge!">	
		</div>
		<span class="error_field" id="error_field"></span>
	</div>
</div>			








            </form>





        </div>

    </div>



</div>



</div>

<div style="clear:both;"></div>