<?php


//$new = true;

$challenge_info = $this->session->userdata('challenge_info');
$fb_user = $this->session->userdata('fb_user'); // whether or not we show fb connect dialog


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
	$editing = false;
	
}

elseif($edit){
	
	$editing = true;
	$new = false;
	$edit = true;
	$item = $item->row();
	$edit_id = '';

	if($item) {
		$edit_id = $item->id;
		$this->session->set_userdata('edit_id', $edit_id);
	}

	
	
}

if(isset($item->cluster_npo)) {
	$joina = true;	
	$cluster_code = $item->theid;
}
elseif(isset($item->cluster_id)) {
	$joina = false;
	$cluster_code = $item->cluster_id;
	//echo $cluster_code;
}
else {
	$joina = false;
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

if(isset($cluster_code)) {
	$setup['npo_name'] = $this->beex->name_that_npo(($cluster_code));
}

$setup['edit'] = $edit;
$setup['new'] = $new;
$setup['item'] = $item;
$setup['npos'] = $this->MItems->getDropdownArray('npos', 'name');
if(isset($cluster_code) && $cluster_code) {

	$setup['npo_name'] = $this->beex->name_that_npo(($cluster_code));
	$setup['cluster'] = $this->MItems->getCluster(($cluster_code))->row();
}

$this->load->helper('array');
$this->load->helper('beexform');
$cells = challenge_form_setup($setup);
extract($cells);

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

/* don't want to display the <form> anymore, to avoid the [return] button invoking a submit */
//	echo (@$cluster) ? form_open_multipart('challenge/process/challenge/'.$edit_id, $attributes) : form_open_multipart('challenge/process/challenge/'.$edit_id, $attributes);
	echo '<form id="challengeform" class="itemform" onsubmit="return false;">';

?>


<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>scripts/beex_helper.js"></script>	
<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>scripts/ajaxupload.js"></script>	



<script language="javascript" type="text/javascript">

	$(document).ready(function() {
		
		function form_input_is_int(input){
	  		return !isNaN(input)&&parseInt(input)==input;
		}

		var help_column = {
			"who_tab": "Start by logging in or registering a new account.  If you use Facebook, we suggest logging in through Facebook Connect because you can automatically update your Facebook friends from this website.",			
			"what_tab": {
				"cluster_id":"Is your challenge part of a greater cluster? If you don't know what this is, then don't worry about it.",
				"challenge_title": "What do you want your challenge to be called? Creativity is an asset but so is clarity.  Puns are popular but we try not to endorse them.",
				"challenge_declaration":"What are you willing to do? BEEx automatically adds the 'I will' ('We will' if you have a partner) so just type the action you're performing.  You're declaration is automatically generated at the bottom of this page.  For some advice about creating a compelling declaration, check out our <a href=\"http://blog.beex.org/?p=374\" target=\"_blank\">blog post</a>.",								
				"proof_description":"Use this box to describe how you're going to prove that you completed your challenge.  For example: I'm going to have pictures taken crossing the finish line or I'm filming my haircut. This proof will be prominently displayed on your challenge page once your challenge is over.  Make it great so your donors love you.",
				"challenge_goal":"How much money are you trying to raise? Our blog post <a href=\"http://blog.beex.org/?p=392\" target=\"_blank\">\"Challenge Creation\"</a> might give you some helpful tips for how to chose the best amount.",
				"challenge_npo": "If you don't see the nonprofit you're looking for email matt@beex.org and we'll register them ASAP and let you know when they've signed up.",				
				"partner_bool": "Partner - Are you partnering with someone to complete this challenge?  If so, fill in their info and we'll make sure they're signed up and ready to fundraise with you."
			},				
			"when_where_tab": {
				"challenge_location":"Where are you going to perform your challenge?  If it's somewhere virtual, enter it's URL.",
				"challenge_attend":"Will you be performing your challenge in front of an audience? Can anyone come and watch?",				
				"fundraising_completed_date":"What is the last day you'll be accepting funds?  If you're participating in an organized event, like a marathon, make sure you don't miss the fundraising deadline.",
				"proof_posted_date":"When are you going to post your proof onto BEEx? Yes...we expect you to actually prove you completed your challenge and so do your donors.",
				"challenge_completion":"What date will you perform this challenge?",
				"challenge_fr_completed":"What date must fundraising end?",
				"challenge_proof_upload":"What date will you post proof to BEEx that you've completed your challenge?  This proof will be automatically emailed to donors.",
			},
			"why_tab": {
				"challenge_blurb":"Think of this as the tagline for your challenge. Make it short, sweet and interesting.",
				"challenge_video":"We always recommend using video. For example:<br />http://www.youtube.com/watch?v=ZnehCBoYLbc<br />http://vimeo.com/2950999",
				"challenge_description":"This is your opportunity to be a little more wordy. Put in all the necessary details that haven't been addressed.",
				"challenge_whydo":"Why do you care about this nonprofit - Why is this organization great?  Why should your donors care about them?",
				"challenge_whycare":"Why do you want to perform this challenge - Everyone is probably wondering why you're doing this..."
			}
		}
		
		function buzzy_the_paper_clip() {
			// Adjusts help column text as appropriate
			var tab_info_type = typeof help_column[$(this).parent().parent()[0].id];
			switch(tab_info_type) {
				case 'object':
					$("#help_column").html(help_column[$(this).parent().parent()[0].id][this.id]);
					break;
				case 'string':
					$("#help_column").html(help_column[$(this).parent().parent()[0].id]);
					break;				
			}

		}
		$("#creation_tab input, textarea, select").focus(buzzy_the_paper_clip);
		

		<?php

		if(isset($edit_id) && $edit_id != '') {
			$challenge_creation_step = 'what';
			echo 'field_array = ';
			echo json_encode($item) . ';';
				
			echo 'var current_tab = \'what_tab\';';	
			echo '$("#nav_who").removeClass("bold");';
			echo '$("#nav_who").addClass("arrow");';
			echo '$("#nav_what").addClass("bold");';
			
		}
		elseif(isset($username) && $username != '') {
			$challenge_creation_step = 'what';
			echo 'var current_tab = \'what_tab\';';
			echo '$("#nav_who").removeClass("bold");';
			echo '$("#nav_who").addClass("arrow");';
			echo '$("#nav_what").addClass("bold");';
		}
		else {
			$challenge_creation_step = 'who';	
			echo 'var current_tab = \'who_tab\';';			
		}					
		

	
		echo <<<SHOW_HIDE
			var what_ok = false;
			var when_where_ok = false;
			
			if(current_tab == 'who_tab') {
				$("#nav_who").addClass("bold");		
			}
			else if(current_tab == 'what_tab') {
				$("#nav_what").addClass("bold");
			}
		
		
			$('#{$challenge_creation_step}_tab').show();
			$('#help_column').html(help_column['{$challenge_creation_step}_tab']);
SHOW_HIDE;
		
		
		//If editing let user save whenever
		if($edit_id) {
			echo "what_ok = true; when_where_ok = true;";
		}
		
		?>
		
		if($("#challenge_declaration").val().length > 0) {
			$("#dyn_what_will_do").html($("#challenge_declaration").val());
		}
		if($("#challenge_goal").val().length > 0) {
			$("#dyn_how_much_raised").html($("#challenge_goal").val());					
		}

		if(typeof $("#challenge_npo option:selected").val() != 'undefined') { //prepopulated and undefined during joina
			if($("#challenge_npo option:selected").val().length > 0) {
				$("#dyn_which_npo").html($("#challenge_npo option:selected").text());			
			}			
		}
		
		
		$(".account_yet").click(function() {
			$("#user_registered_yet").hide();
			if($(this).attr("name") == 'already_have_account') {
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
			var passwords_equal = ($("#password1").val() == $("#password2").val());
			if(passwords_equal) {
					
				var email = $("#email").val();
				var legal_name = $("#legal_name").val();
				var password = $("#password1").val();

				jQuery.ajax({
					 type: "POST",
					 url: "<?php echo base_url(); ?>index.php/ajax/create_user",
					 dataType: "json",
					 data: "email=" + email + "&legal_name=" + legal_name + "&password=" + password,
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

			var email = $("#login_email").val();
			var password = $("#login_password").val();
			
			
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
						$("#nav_who").addClass("arrow");
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
				$("#preview_pronoun").html("We");
			}
			else {
				$("#partner_field").hide();
				$("#preview_pronoun").html("I");
			}
		});
		
		/* Blurb Max Length */
		$("#challenge_blurb").keyup(function() {			
			var blurb = $("#challenge_blurb").val();
			if(blurb.length>120) {
				$("#error_field").html("Please enter a blurb less than 120 characters! You're currently at " + blurb.length + " characters.");
				
			}
			else {
				if($("#error_field").html()) {
					$("#error_field").html("");
				}
			}
		});
		
		/* Dynamic challenge declaration */
		$("#challenge_declaration").keyup(function() {			
			var	declaration_string = $("#challenge_declaration").val();
			if(declaration_string.length>120) {
				$("#declaration_chars").html("Please enter a declaration less than 120 characters! You're currently at " + declaration_string.length + " characters.");
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
		
<?php


		if(@$joina || @$cluster_code) :
			
			$npo_name = $this->beex->name_that_npo($cluster_code); 			
			
?>

		//$("#preview_pronoun").html("We");
		$("#dyn_which_npo").html('<?php echo $npo_name; ?>');


		/*jQuery.ajax({
			 type: "POST",
			 dataType: "json",
			 url: "<?php echo base_url(); ?>index.php/ajax/cluster_validate",
			 data: "cluster_code=" + <?php echo $cluster_code; ?>,	
			 success: function(ret){
				
				for(key in ret) {
					if($("#challenge_" + key).length > 0) {
						if(ret[key] != null && ret[key].length > 0) {
							$("#challenge_" + key).val(ret[key]);
							$("#challenge_" + key).attr("readonly", "true");
							$("#challenge_" + key).addClass("disabled");	
							/*
							if(key == 'zip') {
								$("select[name=challenge_state]").val(zipToState(ret[key]));
							}
							if(key == 'blurb') {
								solidify('blurb');
							}
							if(key == 'state') {
								solidify('state');
							}
						
							if(key == 'attend') {
								solidify('attend');
							}
							if(key == 'completion') {
								solidify('completion');
							}
							if(key == 'fr_completion') {
								solidify('fr_completion');
							}
							if(key == 'proof_date') {
								solidify('proof_date');
							}
							
							
							
						}
					}
				}				
				if(ret['goal']) { $("#dyn_how_much_raised").html(ret['goal']); }
				if(ret['declaration']) { $("#dyn_what_will_do").html(ret['declaration']); }
			}
	
		});									
		*/

<?php			
		endif;
?>


		function solidify(field) {
			var state_parent = $("#challenge_" + field).parent();
			var tempVal = $("#challenge_" + field).val();
			$("#challenge_" + field).remove();
			var solid_state = document.createElement('input');
			solid_state.id = "challenge_"  + field;
			solid_state.name = "challenge_" + field;
			state_parent.append(solid_state);
			$("#challenge_" + field).attr("readonly", "true");
			$("#challenge_" + field).addClass("disabled");	
			$("#challenge_" + field).val(tempVal);										
		}
		
		$("#cluster_id").blur(function() {
			var cluster_code = $(this).val();
			
			if(cluster_code.length>0) {
				jQuery.ajax({
					 type: "POST",
					 dataType: "json",
					 url: "<?php echo base_url(); ?>index.php/ajax/cluster_validate",
					 data: "cluster_code=" + cluster_code,
				
					 success: function(ret){
						
						
						if(ret == 'false') {
							$("#error_field").html("Not a valid cluster code!");
						}
						else {
							$("#error_field").html("");
							$("#cluster_id").parent().html("Cluster Code: Accepted!");
			
							for(key in ret) {
								if($("#challenge_" + key).length > 0) {
									if(ret[key] != null && ret[key].length > 0) {
										$("#challenge_" + key).val(ret[key]);
										$("#challenge_" + key).attr("readonly", "true");
										$("#challenge_" + key).addClass("disabled");	
									
										
									}
								}
							}				
						}
		
					 }
				});									
			}
			else if(cluster_code.length == 0) {
				$("#error_field").html("");				
			}

		});
		
		$("textarea[maxlength]").keypress(function(event){
			var key = event.which;
			var maxLength = $(this).attr("maxlength");
			var length = this.value.length;
			
			//all keys including return.
			if(key >= 33 || key == 13) {
				if(length == maxLength) {
					event.preventDefault();
					$("#error_field").html('Maximum length is 120 characters.');				
				}
			}
			if(length<maxLength) {
				$("#error_field").html('');
			}
		});
		
		var data = '';
		
		$("#what_continue").click(function() {
			var challenge_title = $("#challenge_title").val();
			var challenge_declaration = $("#challenge_declaration").val();
			var proof_description = $("#proof_description").val();
			var challenge_goal = $("#challenge_goal").val().replace(',', '');		// $123,345 comma thousands			
			var challenge_npo = $("#challenge_npo").val();
			var partner_bool = $("#partner_bool").attr("checked");
			var partner_name = $("#partner_name").val();
			var partner_email = $("#partner_email").val();
			
			$("#error_field").html("");
			// do validation locally, for required fields, before saving it off..
			var validation_errors = false;
			
			if(!(!isNaN(challenge_goal)&&parseInt(challenge_goal)==challenge_goal) || challenge_goal == '') {
				$("#error_field").append("Fundraising goal must be a valid number amount.<br />");
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
			else {
				
				$("#what_tab").hide();
				$("#when_where_tab").show();
				$("#nav_what").removeClass("bold");
				$("#nav_what").addClass("arrow");
				$("#nav_when_where").addClass("bold");
				$("#error_field").html("");
				what_ok = true;
				current_tab = 'when_where_tab';
				//$("#help_column").html(help_column['when_where_tab']);
				
			}
			
			/*jQuery.ajax({
				 type: "POST",
				 url: "<?php echo base_url(); ?>index.php/ajax/challenge_what",
				 dataType: "json",
				 data: "challenge_title=" + challenge_title + "&challenge_declaration=" + challenge_declaration + "&proof_description=" + proof_description + "&challenge_goal=" + challenge_goal + "&challenge_npo=" + challenge_npo + "&partner_bool=" + partner_bool + "&partner_name=" + partner_name + "&partner_email=" + partner_email,
				 success: function(ret){
					
					if(ret['success']) { // advance to the next step. 
						$("#what_tab").hide();
						$("#when_where_tab").show();
						$("#nav_what").removeClass("bold");
						$("#nav_what").addClass("arrow");
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
			});*/								
		});
		
		$("#remove_image").click(function() {
			
			jQuery.ajax({
				
				type: "POST",
				url: "<?php echo base_url(); ?>index.php/ajax/reset_image",
				dataType:"json",
				data: "type=challenge_image",
				success: function(ret) {
					
					if(ret['success']) {
						$("#upload_area").html('Image Cleared');
					}
					else {
						alert("Couldn't remove image");
					}
				}
				
			});
			
		});
		
		$("#when_where_continue").click(function() {
			
			var challenge_location = $("#challenge_location").val();
			var	challenge_address1 = $("#challenge_address1").val();
			var challenge_city = $("#challenge_city").val();
			var challenge_state = $("[name='challenge_state']").val();
			var challenge_zip = $("#challenge_zip").val();
			var challenge_attend = $("#challenge_attend").val();
			var challenge_fr_completed = $("#challenge_fr_completed").val();
			var challenge_completion = $("#challenge_completion").val();
			var challenge_proof_upload = $("#challenge_proof_upload").val();
			// do validation locally, for required fields, before saving it off..
			
		
			$("#error_field").html("");
			var validation_errors = false;
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
			else {
				$("#when_where_tab").hide();
				$("#why_tab").show();
				$("#nav_why").addClass("bold");
				$("#nav_when_where").removeClass("bold");
				$("#nav_when_where").addClass("arrow");
				$("#error_field").html("");
				when_where_ok = true;
				current_tab = 'why_tab';
			}
			
			
			/*jQuery.ajax({
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
						$("#nav_when_where").addClass("arrow");
						$("#error_field").html("");
						when_where_ok = true;
						current_tab = 'why_tab';
					}
					else {
						$("#login_errors").html(ret['errors']); 
					}
				 }
			});*/
		});
		
		$("#why_continue, .save_challenge").click(function() { // last step.. fin!
			
			var new_challenge_id;
			
			var cluster_id = $("#cluster_id").val();
			
			var challenge_title = $("#challenge_title").val();
			var challenge_declaration = $("#challenge_declaration").val();
			var proof_description = $("#proof_description").val();
			var challenge_goal = $("#challenge_goal").val().replace(',', '');		// $123,345 comma thousands			
			var challenge_npo = $("#challenge_npo").val();
			var partner_bool = $("#partner_bool").attr("checked");
			var partner_name = $("#partner_name").val();
			var partner_email = $("#partner_email").val();
			
			var challenge_location = $("#challenge_location").val();
			var challenge_address1 = $("#challenge_address1").val();
			var challenge_city = $("#challenge_city").val();
			var challenge_state = $("[name='challenge_state']").val();
			var challenge_zip = $("#challenge_zip").val();
			var challenge_attend = $("#challenge_attend").val();
			var challenge_fr_completed = $("#challenge_fr_completed").val();
			var challenge_completion = $("#challenge_completion").val();
			var challenge_proof_upload = $("#challenge_proof_upload").val();
			
			var challenge_blurb = $("#challenge_blurb").val();
			var challenge_description = $("#challenge_description").val();
			var challenge_whydo = $("#challenge_whydo").val();
			var challenge_whycare = $("#challenge_whycare").val();
			var challenge_video = escape($("#challenge_video").val());
				
			// do validation locally, for required fields, before saving it off..
			if(!what_ok || !when_where_ok) {
				
				$("#error_field").html("Please fill out the required fields on the what tab, and the when/where tab, before finishing up!");
				return false;
			}
			
			$("#error_field").html("");
			var validation_errors = false;
			
			if(challenge_title == '') {
				$("#error_field").append("WHAT: Challenge title must be filled out.<br />");
				validation_errors = true;				
			}
			if(challenge_declaration.length > 120 || challenge_declaration == '') {
				$("#error_field").append("WHAT: Challenge declaration must be filled out, and no more than 120 characters in length.<br />");
				validation_errors = true;				
			}
			if(proof_description == '') {
				$("#error_field").append("WHAT: Proof description must be filled out.<br />");
				validation_errors = true;				
			}
			
			if(!(!isNaN(challenge_zip)&&parseInt(challenge_zip)==challenge_zip) || challenge_zip.length != 5) {			
				$("#error_field").append("WHERE/WHEN: Please enter a valid 5-digit zipcode.<br />");
				validation_errors = true;				
			}
			if(challenge_completion == '') {
				$("#error_field").append("WHERE/WHEN: Please enter a date for your fundraising completion.<br />");
				validation_errors = true;
			}
			
			if(!(!isNaN(challenge_goal)&&parseInt(challenge_goal)==challenge_goal) || challenge_goal == '') {
				$("#error_field").append("WHERE/WHEN: Fundraising goal must be a valid number amount.<br />");
				validation_errors = true;				
			}
			
			if(challenge_blurb.length > 120) {
				$("#error_field").append("WHY: Blurb must be less than 120 characters");
				validation_errors = true;
			}
			
			
			if(validation_errors) {
				return false;
			}
			
			jQuery.ajax({
				 type: "POST",
				 url: "<?php echo base_url(); ?>index.php/ajax/challenge_why",
				 dataType: "json",
				 data: 	"challenge_title=" + challenge_title + 
						"&challenge_declaration=" + challenge_declaration + 
						"&proof_description=" + proof_description + 
						"&challenge_goal=" + challenge_goal + 
						"&challenge_npo=" + challenge_npo + 
						"&partner_bool=" + partner_bool + 
						"&partner_name=" + partner_name + 
						"&partner_email=" + partner_email + 
						"&challenge_location=" + challenge_location + 
						"&challenge_address1=" + challenge_address1 + 
						"&challenge_city=" + challenge_city + 
						"&challenge_state=" + challenge_state + 
						"&challenge_zip=" + challenge_zip + 
						"&challenge_attend=" + challenge_attend + 
						'&challenge_fr_completed=' + challenge_fr_completed + 
						'&challenge_completion=' + challenge_completion + 
						'&challenge_proof_upload=' + challenge_proof_upload + 
						"&challenge_blurb=" + challenge_blurb + 
						"&challenge_description=" + challenge_description + 
						"&challenge_whydo=" + challenge_whydo + 
						"&challenge_whycare=" + challenge_whycare + 
						"&challenge_video=" + challenge_video + 
						"&cluster_id=" + cluster_id,
				 success: function(ret){
					
					if(ret['success']) { // advance to the next step. 
						new_challenge_id = ret['challenge_id'];
						
						<?php						
						if(ctype_digit($fb_user)) {
						?>	
						
						/* publish to the news feed */
						var message = 'Support me in my challenge to raise money for charity!'; 
						var attachment = { 
							'name': challenge_title, 
							'caption': '{*actor*} started a challenge on http://www.beex.org', 
							'description': 'I will ' + challenge_declaration + ' if $' + challenge_goal + ' is raised for ' + $("#challenge_npo option:selected").text(), 
							'properties': { 
								'Donate': { 
									'text': 'Click to Donate', 
									'href': 'http://www.beex.org/challenge/view/'+new_challenge_id
								}
							 	
							}, 
							'media': [{ 
								'type': 'image', 
								'src': 'http://sandbox.beex.org/images/imagedefault.png', 
								'href': 'http://www.beex.org/challenge/view/'+ new_challenge_id
							}]
						}; 
						var action_links = [{
							'text':'Donate!', 
							'href':'http://www.beex.org/challenge/view/'+ new_challenge_id
						}]; 
						//FB.Connect.streamPublish(message, attachment, action_links, null, '', publishCallback);		
						publishCallback();
						<?php
						} 
						else { ?>						
						window.location = '<?php echo base_url(); ?>index.php/challenge/view/' + new_challenge_id;											
						<?php } ?>										
					}
					else {
						$("#login_errors").html(ret['errors']); // change this to a universal error field ..? hmm?
					}
				 }
			});
			
			function publishCallback(a,b) {
				window.location = '<?php echo base_url(); ?>index.php/challenge/view/' + new_challenge_id;
				
			}
					
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
		
		$("#challenge_zip").keyup(function() {

			var zip = $(this).val();
			if(zip.length == 5) {				
		 		$("select[name=challenge_state]").val(zipToState(zip));
			}

		});
		
		$(function(){
			var btnUpload=$('#upload');
			var status=$('#status');
			new AjaxUpload(btnUpload, {
				action: base_url + 'ajax/new_ajax_upload',
				//Name of the file input box
				name: 'uploadfile',
				onSubmit: function(file, ext){
					if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
		                  // check for valid file extension
						status.text('Only JPG, PNG or GIF files are allowed');
						return false;
					}
					status.text('Uploading...');
					
				},
				onComplete: function(file, response){
					//On completion clear the status
					status.text('');
				
					//Add uploaded file to list
					if(response){
						$('#upload_area').html('<img src="'+response+'" alt="" /><br />').addClass('success');
					} else{
						$('<li></li>').appendTo('#files').text(file).addClass('error');
					}
				}
			});
		});
		
	});
</script>
	
	
<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>scripts/ajaxupload.3.5.js"></script>

<div id="challenge_module">
	<div id="nav_bar">
<?php if(!$editing) {?>
		<span class="nav_button" id="nav_who" style="cursor:default">Who</span>		
<?php } ?>		
		<span class="nav_button" id="nav_what">What</span><span class="nav_button" id="nav_when_where">When/Where</span><span class="nav_button" id="nav_why">Why</span>
	</div>
	<div id="help">
    	<h3>Need Help?</h3>
        <p>This column will provide you with additional info at every step.</p>
		<div id="help_column">
			Hello. This is advice on how to complete the current step.
		</div>
        <span class="errors error_field" id="error_field"></span>
    </div>
	<div id="creation_tab">
		<div id="who_tab" class="creation_step">
			<div id="user_registered_yet">
				<h2 style="font-size:14px;">Do you already have an account on BeEx?</h2>
				<div class="input_buttons" style="text-align:left; margin:5px 0px 32px;">
                	<img src="<?php echo base_url(); ?>images/buttons/yes.gif" name="already_have_account" id="already_have_account" class="account_yet" value="Yes">
					<img src="<?php echo base_url(); ?>images/buttons/no.gif" name="no_account_yet" id="no_account_yet" class="account_yet" value="Not Yet!">
                </div>
				<h2 style="font-size:14px;">Or, login/register through Facebook connect!</h2>
				<div class="input_buttons" style="text-align:left; margin:5px 0px;">					
					<fb:login-button onlogin="window.location='<?php echo base_url()?>index.php/user/login'"></fb:login-button>
				</div>
			</div>
			
			<div id="already_registered" class="creation_substep">
				<div class="input_wrapper">
					<label>email</label>
					<input type="text" name="email" id="login_email">
				</div>
				<div class="input_wrapper">
					<label>password</label>
					<input type="password" name="password" id="login_password">
				</div>
				<span class="errors" name="login_errors" id="login_errors"></span>
				<div class="input_buttons">
                	<input type="button" name="registered_continue" id="registered_continue" value="Continue">
                </div>
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
  				<span class="errors" id="password_validation"></span><br />
				<span class="errors" name="registration_errors" id="registration_errors"></span>
				<div class="input_buttons">
                	<input type="button" name="register_continue" id="register_continue" value="Create Account &amp; Continue">
                </div>
			</div>			
		</div>
		<div id="what_tab" class="creation_step">
			<?php if(!$joina && false): ?>
			<div class="input_wrapper">
				<label>cluster code</label>
				<input type="text" name="cluster_id" id="cluster_id">
				<span id="cluster_ok" name="cluster_ok"></span>
			</div>
            <?php elseif(isset($cluster_code)) : ?>
            	<input type="hidden" name="cluster_id" id="cluster_id" value="<?php echo ($cluster_code/3459); ?>" />
			<?php endif; ?>
 		 	<div class="input_wrapper">
				<label class="required">challenge title</label>
				<?php echo $challenge_title_cell; ?>
			</div>
			<div class="input_wrapper">
				<label class="required">declaration</label>
				<?php echo $challenge_declaration_cell; ?>
			</div>
			<div class="input_wrapper">
				<label class="required">fundraising goal</label>
				<?php echo $goal_cell; ?>
			</div>
			<div class="input_wrapper">
				<label>benefitting nonprofit</label>
				<?php echo $npo_cell; ?> 
			</div>
			<div class="input_wrapper">
				<label class="required">proof description</label>
				<?php echo $proof_description_cell; ?>
			</div>	
			<?php if($new) : ?>					
			<div class="input_wrapper">
				<label>partner?</label>
				<input type="checkbox" name="partner_bool" id="partner_bool">				
			</div>
		
			<div id="partner_field" class="creation_substep">
				<div class="input_wrapper">
					<label>partner name</label><input type="text" name="partner_name" id="partner_name" value="<?php set_value('partner_name'); ?>" >
				</div>
				<div class="input_wrapper">
					<label>partner email</label><input type="text" name="partner_email" id="partner_email" value="<?php set_value('partner_email'); ?>">
				</div>
			</div>
			<?php endif; ?>
			<div class="preview_box" id="preview_box">
            
				<h1>Preview of Declaration</h1>
                <p class="text">This is exactly what your declaration will look like on your challenge page. Make it sure it looks right to you.</p>
				<span class="hl" id="preview_pronoun">I</span> will 
				<span class="dyn_what_will_do hl" id="dyn_what_will_do">_____</span> 
				if<br />
				<span class="hlb">$<span class="dyn_how_much_raised" id="dyn_how_much_raised">_____</span></span><br />
				is raised for <br />
				<span class="dyn_which_npo hlb" id="dyn_which_npo">______</span>
			</div>
            <div class="input_buttons">
            	<img src="<?php echo base_url(); ?>images/buttons/next.gif" name="what_continue" id="what_continue" value="Continue to next step" />
            	<!--<input type="button" name="what_continue" id="what_continue" value="Continue to next step">-->
                <?php if($edit_id) : ?><img src="<?php echo base_url(); ?>images/buttons/save.gif" class="save_challenge" value="Save your challenge" /><?php endif; ?>
            </div>
		</div>
		<div id="when_where_tab" class="creation_step">
			<div class="input_wrapper">
				<label>Location Name</label>
				<?php echo $location_cell; ?>			
			</div>
			<div class="input_wrapper">
				<label>address</label>
			 	<?php echo $address_cell; ?>
			</div>
			<div class="input_wrapper">
				<label>city</label>  
				<?php echo $city_cell; ?>	
			</div>
			<div class="input_wrapper">
				<label>zipcode</label>
				<?php echo $zip_cell; ?>	 
			</div>
			<div class="input_wrapper">
				<label>state</label>				
				<?php echo $state_cell; ?> 
			</div>
			<div class="input_wrapper">
				<label>can people attend?</label>
				<?php echo $attend_cell; ?>
			</div>
			<div class="input_wrapper">
				<label class="required">fundraising completed by</label>
				<?php echo $completion_cell; ?>
			</div>
			<div class="input_wrapper">
				<label>challenge completed on</label>
				<?php echo $fr_cell; ?>
			</div>
			<div class="input_wrapper">
				<label>proof posted on</label>
				<?php echo $proof_cell; ?>
			</div>
            <div class="input_buttons">
            	<img src="<?php echo base_url(); ?>images/buttons/prev.gif" name="when_where_previous" id="when_where_previous" value="Go back to edit the previous step" />
                <img src="<?php echo base_url(); ?>images/buttons/next.gif" name="when_where_continue" id="when_where_continue" value="Continue to the next step!" />
                <?php if($edit_id) : ?><img src="<?php echo base_url(); ?>images/buttons/save.gif" class="save_challenge" value="Save your challenge" /><?php endif; ?>
								
            </div>
		</div>
		<div id="why_tab" class="creation_step">
			<div class="input_wrapper">
				<label>blurb</label>
				<?php echo $blurb_cell; ?>
			</div>
			<div class="input_wrapper">
				<label>Description</label>
				<?php echo $description_cell; ?>
			</div>			
			<div class="input_wrapper">
				<label>Image (4MB max)</label>
				<div id="upload">Upload File</div><span id="status" ></span>  
				<!--List Files-->  
				<ul id="files" ></ul>
					
				<div id="upload_area" name="upload_area">
					<?php if($image_cell) : ?>
						<p>Current Image</p>
						<img src="<?php echo base_url()."media/challenges/".$edit_id.'/sized_'.$image_cell; ?>">
						<a id="remove_image">Remove Image</a>
					<?php endif; ?>
				</div>			
			</div>
			<div class="input_wrapper">
				<label>link to video</label>
				<?php echo $video_cell; ?>
			</div>
			<div class="input_wrapper">
				<label>why do you care?</label>
				<?php echo $whycare_cell; ?>
			</div>
			<div class="input_wrapper">
				<label>why are you performing this challenge?</label>
				<?php echo $whydo_cell; ?>
			</div>
            <div class="input_buttons">
            	<img src="<?php echo base_url(); ?>images/buttons/prev.gif" name="why_previous" id="why_previous" value="Go back to edit the previous step" />
                <?php if($edit_id) : ?>
					<img src="<?php echo base_url(); ?>images/buttons/save.gif" class="save_challenge" value="Save your challenge" />
				<?php else :  ?>
					<img src="<?php echo base_url(); ?>images/buttons/finish.gif" name="why_continue" id="why_continue" value="Finish creating your challenge!" />
				<?php endif; ?>
            </div>
		</div>
		
        
	   
	</div>
    
</div>			
 <div style="clear:both; float:left; padding:10px;"></div>







            </form>





        </div>

    </div>

</div>



</div>

<div style="clear:both;"></div>