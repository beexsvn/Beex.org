<?php

//$new = true;

$attributes = array('id' => 'clusterform', 'class'=>'itemform');

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
	$this->session->set_userdata("cluster_image", $item->cluster_image);
		
}

if($username = $this->session->userdata('username')) {
	
	$name = 'admin_email';
	$logged_in = true;

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

//NPO

$npos = $this->MItems->getDropdownArray('npos', 'name');

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

}

$attributes['id'] = 'cluster_form';

echo form_open_multipart('cluster/process/cluster/'.$edit_id, $attributes);

?>


<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>beex_scripts/beex_helper.js"></script>	
<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>scripts/ajaxupload.3.5.js"></script>

<script type="text/javascript">
if (!Array.prototype.indexOf) // IE6 compatibility for Array.prototype.indexOf
{
  Array.prototype.indexOf = function(elt /*, from*/)
  {
    var len = this.length >>> 0;

    var from = Number(arguments[1]) || 0;
    from = (from < 0)
         ? Math.ceil(from)
         : Math.floor(from);
    if (from < 0)
      from += len;

    for (; from < len; from++)
    {
      if (from in this &&
          this[from] === elt)
        return from;
    }
    return -1;
  };
}

$(document).ready(function() {

	var help_column = {
		"who_tab": "Start by logging in or registering a new account.  If you use Facebook, we suggest logging in through Facebook Connect because you can automatically update your Facebook friends from this website.",			
		"admin_invite_tab": "Anyone can be an administrator. Administrators will be able to edit the cluster. To add an administrator, just type his or her email into the box. You can add as many admins as you like.",
		"what_tab": {
			"cluster_title":"Give your cluster a name. Make sure its something the participants will recognize",
			"cluster_goal": "Clusters do not require a fundraising goal but including one might be a good way to motivate everyone.",
			"cluster_blurb":"Short and sweet, what's this cluster all about.",
			"cluster_description":"Here's your chance to let it all out. Make sure you provide enough information about your cluster so that all the donors know what's going on. The more clear you are about what you are doing, the more successful the cluster will be.",
		},			
				
		/* 		accurate until here...				*/
			
		"media_tab": {
			"cluster_video":"This is the video everyone will see",
		},
		"challenge_control_tab": {
			"cluster_ch_title": "You already filled out your cluster title but challenges have titles too. If you'd like to control what every challenge is called then type it here. If not then just leave it blank.",
			"cluster_ch_declaration":"This is the action all the cluster participants are going to perform to raise money. As a cluster administrator, your most important decision is whether to",
			"cluster_ch_goal":"All challenges must have a goal. It's your decision whether that goal is set by you or the challengers. If your fundraiser has a minimum requirement to participate then it may be wise to set that as the goal.",
//			"cluster_ch_fr_ends":
//			"cluster_ch_completion":
//			"cluster_ch_proofdate":
			"cluster_ch_location":"This is the location where the challenges will be performed. If your cluster is an event then it may be wise to fill these fields out for your challengers.",
//			"cluster_ch_address":
//			"cluster_ch_city":
//			"cluster_ch_state":
//			"cluster_ch_zip":
//			"cluster_ch_attend":
			"cluster_ch_blurb": "The tagline for all the challenges. Make sure it is short, sweet, and interesting. Of course, you can always leave it blank and let the challengers decide.",
			"cluster_ch_description":"Your opportunity to say everything that needs to be said. The more detailed you can be the better. Like everything else on this form, you can always leave it to the participant to fill out.",
//			"cluster_ch_video":
		}
	}
	
	function buzzy_the_paper_clip() {
		// Adjusts help column text as appropriate
		var tab_info_type = typeof help_column[$(this).parent().parent()[0].id];

		switch(tab_info_type) {
			case 'object':
				$("#help_column").html(help_column[$(this).parent().parent()[0].id][$(this).attr("name")]);
				break;
			case 'string':
				$("#help_column").
				$("#help_column").html(help_column[$(this).parent().parent()[0].id]);
				break;				
		}	
	}
	
	$(".cluster_tab input, textarea").focus(buzzy_the_paper_clip);


	$("#cluster_ch_zip").keyup(function() {

			var zip = $(this).val();
			if(zip.length == 5) {				
		 		$("select[name=cluster_ch_state]").val(zipToState(zip));
			}

	});
	

	$("#clusterform").keypress(function(e) { 
		if(e.keyCode === 13) {
			return false;		
		}
	});
	
	
	
	var num_admin_cells = 1;
	//var tab_list = ["who_tab", "admin_invite_tab", "what_tab", "media_tab", "challenge_control_tab"];
	var tab_list = ["who_tab", "what_tab", "challenge_control_tab"];
	var current_tab = 'who_tab'; 
		
<?php	

	if(isset($logged_in) && $logged_in==true) {
		echo "current_tab = 'what_tab'; $('#who_tab').hide();\n\n";
	}

	if(isset($edit_id) && $edit_id != '') {
//		$challenge_creation_step = 'what';
		echo 'field_array = ';
		echo json_encode($item) . ';';
		if(isset($item->cluster_image)) {
			$ch_img = base_url() . 'media/clusters/' . $item->cluster_image;
			echo <<<JS_IMG
				var ch_img = document.createElement("img");
				ch_img.src = "{$ch_img}";
				$("#upload_area").append(ch_img);

JS_IMG;
		}
		echo <<<JAVASCRIPT
			
			current_tab = 'what_tab';
			$("#who_tab, #what_tab_prev_btn").remove();

JAVASCRIPT;
			
	}
?>
	
	

	if(current_tab == 'what_tab') {
		$("#nav_who").addClass("arrow");		
	}
	
	nextTab(current_tab);
		
	function nextTab(param) {
		$("#error_field").html("");
		if(typeof param != 'object') {
			var next_index = tab_list.indexOf(param);
		}
		else {
			var next_index = tab_list.indexOf(current_tab)+1;	
		}
		
		var toTab = tab_list[next_index];	
		for(tab in tab_list) {
			if(tab != 'indexOf') {
				$("#" + tab_list[tab]).hide();
			}
		}
		
		$("#" + toTab).show();
		current_tab = toTab;
		
		for(var tab in tab_list) {
			if(tab != 'indexOf') {
				$("#nav_" + tab_list[tab].substr(0, tab_list[tab].length-4)).removeClass("bold");
			}
		}		
		$("#nav_" + current_tab.substr(0, current_tab.length-4)).addClass("bold");					
	}
	function prevTab() {
		var next_index = tab_list.indexOf(current_tab)-1;	
		var toTab = tab_list[next_index];	
		for(var tab in tab_list) {
			$("#" + tab_list[tab]).hide();
		}
		$("#" + toTab).show();
		current_tab = toTab;		
		for(var tab in tab_list) {
			$("#nav_" + tab_list[tab].substr(0, tab_list[tab].length-4)).removeClass("bold");
		}		
		$("#nav_" + current_tab.substr(0, current_tab.length-4)).addClass("bold");				
	}
	
	/* No need for Admin Functions
	function newAdminCell() {
		var admin_cell = document.createElement("input");
		admin_cell.name = "admin" + (++num_admin_cells) + "_name";		
		admin_cell.id = "admin" + num_admin_cells + "_name";
		admin_cell.type = "text";
		admin_cell.onblur = makeMoreAdmins;
		return admin_cell;
	}
	*/
	function newLabel(text) {
		var label_cell = document.createElement("label");
		label_cell.innerHTML = text;
		return label_cell;
	}
	
	/* No need for Admin Functions
	function makeMoreAdmins() {
		var all_full = true;
		for(var i=1;i<=num_admin_cells;i++) {
			var cur_cell_contents = $("#admin" + i + "_name").val();
			if(cur_cell_contents == '' || cur_cell_contents.indexOf('@')==-1) {
				all_full = false;
			}
		}
		if(all_full) {
			$(this).parent().append("<br>"); // would rather do this by having CSS set a clear:left on the label selector
			$(this).parent().append(newLabel("Admin " + i + " email: "));
			$(this).parent().append(newAdminCell());
		}				
	}
	*/
	//$("#admin1_name").blur(makeMoreAdmins);	
	$('.next_btn').click(nextTab);
	$('.prev_btn').click(prevTab);
	

	$("#who_tab_next_btn").unbind();
	$("#who_tab_next_btn").click(function() {
		
		var email = $("#admin_email").val();
		var password = $("input[name='password']").val();		
		
		var signup_email = $("#signup_email").val();
		var signup_name = $("#signup_name").val();
		var signup_pass = $("#signup_pass").val();
		var signup_passconf = $("#signup_passconf").val();
				
		if(signup_passconf != signup_pass) {
			$("#error_field").html("Your passwords must match, son!");
			return;
		}
		
		if(signup_email && signup_name && signup_pass  && signup_passconf) {
			jQuery.ajax({
				 type: "POST",
				 url: "<?php echo base_url(); ?>index.php/ajax/create_user",
				 dataType: "json",
				 data: "email=" + signup_email + "&legal_name=" + signup_name + "&password=" + MD5(signup_pass),
				 success: function(ret){
					if(ret['success']) { // advance to the next step. 
						window.location = window.location;
					}
					else {
						$("#error_field").html(ret['errors']);
					}
				 }
			});
		}
		else {
			jQuery.ajax({
				 type: "POST",
				 url: "<?php echo base_url(); ?>index.php/ajax/login_user",
				 dataType: "json",
				 data: "email=" + email + "&password=" + password,
				 success: function(ret){
					if(ret['success']) { // advance to the next step. 
						window.location = window.location;
					}
					else {
						$("#error_field").html(ret['errors']);
					}
				 }
			});
		}		
	});
	
	$("#what_tab_next_btn").unbind();
	$("#what_tab_next_btn").click(function() {
		var cluster_title = $('input[name=cluster_title]').val();
		var cluster_blurb = $('#cluster_blurb').val();
		
		var validation_errors = false;
		
		$("#error_field").html("");
		
		if(cluster_title.length == 0) {
			$("#error_field").append("Cluster title is required.<br>");
			validation_errors = true;
		}
		if(cluster_blurb.length > 120) {
			$("#error_field").append("Cluster blurb must be less than 120 characters");
			validation_errors = true;
		}
		
		if(validation_errors) {
			return false;
		}
		else {
			$("#nav_what").addClass("arrow");
			//nextTab('media_tab');
			nextTab('challenge_control_tab');
		}
	});
	
	$("#admin_invite_tab_next_btn").unbind();
	$("#admin_invite_tab_next_btn").click(function() {
		$("#nav_admin_invite").addClass("arrow");
		nextTab('what_tab');		
	});
	
	$("#media_tab_next_btn").unbind();
	$("#media_tab_next_btn").click(function() {
		$("#nav_media").addClass("arrow");
		nextTab('challenge_control_tab');
	})
	
	$("#already_have_account").click(function() {

		$("#existing_account_div").show();
		$("#user_registered_yet").hide();
		$("#who_tab_next_btn").show();
	});
	$("#no_account_yet").click(function() {
		$("#new_account_div").show();
		$("#user_registered_yet").hide();		
		$("#who_tab_next_btn").show();
	});
	
	
	$(".nav_button").click(function() {		
		clicked_id = $(this).attr("id");
		to_tab = clicked_id.substr(4) + '_tab';
 		nextTab(to_tab);		
	});
	
	$("#cluster_finish_btn, .save_button").click(function() {
		
		$("#cluster_form").attr('action', "<?php echo base_url(); ?>index.php/cluster/process/cluster/<?php echo $edit_id; ?>");
		$("#cluster_form").attr('target', "_self");
		$("#cluster_form").attr('method', "post");
		$("#cluster_form").submit();
	});
	
	$(function(){
		var btnUpload=$('#upload');
		var status=$('#status');
		new AjaxUpload(btnUpload, {
			action: base_url + 'ajax/new_ajax_upload/1',
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

<div id="cluster_area"> <!-- enclosure .. -->
	<div id="nav_bar">
		<?php if($new) : ?>
		<span class="nav_button" id="nav_who">Who</span>
		<!--<span class="nav_button" id="nav_admin_invite">Administrators</span>-->
		<?php endif; ?>
		<span class="nav_button" id="nav_what">What</span>
		<!--<span class="nav_button" id="nav_media">Media</span>-->
		<span class="nav_button" id="nav_challenge_control">Challenges</span>
	</div>
	<div id="help">
    	<h3>Need Help???</h3>
        <p>This column has revelent info for the creation step you're on. Check back here if you get stuck.</p>
		<div id="help_column">
			Hello. This is advice on how to complete the current step.
		</div>
        <span class="errors error_field" id="error_field"></span>
    </div>
	
			<div id="cluster_data_area"> <!-- data enclosure .. -->
				<div id="who_tab" class="cluster_tab">										
					<div id="user_registered_yet">
						<h2>Do you already have an account on BeEx?</h2>
						<div class="input_buttons" style="text-align:left; margin:5px 0px 32px;">
		                	<img src="<?php echo base_url(); ?>images/buttons/yes.gif" name="already_have_account" id="already_have_account" class="account_yet" value="Yes">
							<img src="<?php echo base_url(); ?>images/buttons/no.gif" name="no_account_yet" id="no_account_yet" class="account_yet" value="Not Yet!">
		                </div>
						<h2>Or, login/register through Facebook connect!</h2>
						<div class="input_buttons" style="text-align:left; margin:5px 0px;">					
							<fb:login-button onlogin="window.location='<?php echo base_url()?>index.php/user/login'"></fb:login-button>
						</div>
					</div>		
					<div id="existing_account_div" style="display:none">
						<h5>Existing Users Log-In</h5>
						<div class="input_wrapper">
							<label>Admin Email:</label>
							<?php echo $admin_email_cell; ?>
						</div>	
						<div class="input_wrapper">
							<label>Password:</label>
							<?php echo $password_cell; ?>
						</div>	
					</div>
					<div id="new_account_div" style="display:none">					
		            	<h5>If you haven't registered yet for Beex.org, don't worry.</h5>
						<h6>You can enter your name, email and password below.</h6>
			            <div class="input_wrapper">
							<label>Name:</label>
							<?php echo generate_input('signup_name', 'input', true, ''); ?>
						</div>
				        <div class="input_wrapper">
							<label>Email:</label>
							<?php echo generate_input('signup_email', 'input', true, ''); ?>
						</div>
			            <div class="input_wrapper">
							<label>Password:</label>
							<?php echo generate_input('signup_pass', 'password', true, ''); ?>
						</div>
			            <div class="input_wrapper">
							<label>Password Confirm:</label>
							<?php echo generate_input('signup_passconf', 'password', true, ''); ?>
						</div>
					</div>		
					<div class="input_buttons">
						<img src="<?php echo base_url(); ?>images/buttons/next.gif" alt="Next Step" id="who_tab_next_btn" class="next_btn" style="display:none">
					</div>
				</div> <!-- end who_tab -->
				
				
				<!--  ***********  -->
				<div id="what_tab" class="cluster_tab">
  				    <h5>Cluster Information</h5>
		            <div class="input_wrapper">
						<label>Cluster Title:</label>
						<?php echo $title_cell; ?>
					</div>
					<div class="input_wrapper">
						<label>Fundraising Goal (optional):</label>
						<?php echo $goal_cell; ?>
					</div>
					<div class="input_wrapper">
						<label>Select your Nonprofit:</label>
						<?php echo $npo_cell; ?>						
					</div>
					<div class="input_wrapper">
						<label>Blurb (120 characters):</label>
						<?php echo $blurb_cell; ?>
					</div>
					<div class="input_wrapper">
						<label>Description:</label>					
						<?php echo $description_cell; ?>
					</div>
					
					<h5>Media</h5>
					<?php if(!$new && $item->cluster_image && false) : ?>
						<div class="input_wrapper">
							<label>Current Image</label>
							<img src="/media/clusters/<?php echo $item->id."/sized_".$item->cluster_image; ?>" />
						</div>
                 	<?php endif; ?>
		            <div class="input_wrapper">
						<label>Select your image:<br><span class="small">(4MB max)</span></label>
						<div id="upload">Upload File</div><span id="status" ></span>  
						<!--List Files-->  
						<ul id="files" ></ul>
						
						<div id="upload_area" name="upload_area">					
						</div>			
						
					</div>
					<div class="input_wrapper">
						<label>Video URL Link:</label>
						<?php echo generate_input('cluster_video', 'text', $edit, ''); ?>
					</div>
					
					<div class="input_buttons">
						<img src="<?php echo base_url(); ?>images/buttons/prev.gif" alt="Prev Step" id="what_tab_prev_btn" class="prev_btn">					
						<img src="<?php echo base_url(); ?>images/buttons/next.gif" value="Next Step" id="what_tab_next_btn" class="next_btn" />
						<?php if($edit_id) : ?><img src="<?php echo base_url(); ?>images/buttons/save.gif" class="save_button" value="Save your cluster" /><?php endif; ?>
					</div>
					
				</div> <!-- end what_tab div-->
				<!--  ***********  -->
				<!--
				<div id="media_tab" class="cluster_tab">
					<h5>Media</h5>
					<?php if(!$new && $item->cluster_image && false) : ?>
						<div class="input_wrapper">
							<label>Current Image</label>
							<img src="/media/clusters/<?php echo $item->cluster_image; ?>" />
						</div>
                 	<?php endif; ?>
		            <div class="input_wrapper">
						<label>Select your image:<br><span class="small">(4MB max)</span></label>
						<fieldset>
							<form action="<?php echo base_url(); ?>index.php/ajax/image_upload" method="post" name="sleeker" id="sleeker" enctype="multipart/form-data">
								<input type="hidden" name="maxSize" value="9999999999" />
								<input type="hidden" name="maxW" value="200" />
								<input type="hidden" name="fullPath" value="<?php echo base_url(); ?>/media/clusters/" />
								<input type="hidden" name="relPath" value="../uploads/" />
								<input type="hidden" name="colorR" value="255" />
								<input type="hidden" name="colorG" value="255" />
								<input type="hidden" name="colorB" value="255" />
								<input type="hidden" name="maxH" value="300" />
								<input type="hidden" name="filename" value="filename" />
								<p><input type="file" name="filename" onchange="ajaxUpload(this.form,'<?php echo base_url(); ?>index.php/ajax/image_upload/cluster','upload_area','File Uploading Please Wait...&lt;br /&gt;&lt;img src=\'images/loader_light_blue.gif\' width=\'128\' height=\'15\' border=\'0\' /&gt;','&lt;img src=\'images/error.gif\' width=\'16\' height=\'16\' border=\'0\' /&gt; Error in Upload.'); return false;" /></p>
							</form>					
						</fieldset>
						<div id="upload_area" name="upload_area">					
						</div>			
						<?php //echo generate_input('cluster_image', 'file', $edit, ''); ?>
					</div>
					<div class="input_wrapper">
						<label>Video URL Link:</label>
						<?php echo generate_input('cluster_video', 'text', $edit, ''); ?>
					</div>
					<div class="input_buttons">
						<img src="<?php echo base_url(); ?>images/buttons/prev.gif" alt="Prev Step" id="media_tab_prev_btn" class="prev_btn">
						<img src="<?php echo base_url(); ?>images/buttons/next.gif" alt="Next Step" id="media_tab_next_btn" class="next_btn">
						<?php if($edit_id) : ?><img src="<?php echo base_url(); ?>images/buttons/save.gif" class="save_button" id="test_button" value="Save your cluster" /><?php endif; ?>
					</div>
				</div> 
				-->
				<!-- end media_tab div -->
				<!--  ***********  -->	
<style>
h5 {clear:both;}
</style>				
		 		<div id="challenge_control_tab" class="cluster_tab">
			        <h5>Challenge Control: 
						<span style="font-weight:normal;">Challenge Template: Every challenge within your cluster will share the fields that you fill out in this template. If you want a field to remain empty or allow the user to fill out the field him or herself, leave it blank.</span>
					</h5>
					<h5>What</h5>
					<div class="input_wrapper">
						<label>Challenge Title:</label>
						<?php echo $ch_title_cell; ?>
					</div>
					<div class="input_wrapper">
						<label>Challenge Declaration: I/we will</label>
						<?php echo $ch_declaration_cell; ?>
					</div>
					<div class="input_wrapper">
						<label>Challenge Fundraising Goal:</label>
						$<?php echo $ch_goal_cell; ?>
					</div>
					
					<h5>When</h5>
					<div class="input_wrapper">
						<label>Challenge Fund Rasing Ends:</label>
						<?php echo $ch_fr_ends_cell; ?>
					</div>
					<div class="input_wrapper">
						<label>Challenge Completion:</label>
						<?php echo $ch_completion_cell; ?>
					</div>
					<div class="input_wrapper">
						<label>Challenge Proof Uploaded:</label>	
						<?php echo $ch_proofdate_cell; ?>
					</div>
					
					<h5>Where</h5>
					<div class="input_wrapper">
						<label>Location:</label>
						<?php echo $ch_location_cell; ?>
					</div>					
					<div class="input_wrapper">
						<label>Address:</label>
						<?php echo $ch_address_cell; ?>
					</div>
					<div class="input_wrapper">
						<label>Address 2 (if needed):</label>
						<?php echo $ch_address2_cell; ?>
					</div>
					<div class="input_wrapper">
						<label>City:</label>
						<?php echo $ch_city_cell; ?>
					</div>
					<div class="input_wrapper">
						<label>Zip:</label>
						<?php echo $ch_zip_cell; ?>
					</div>
					
					<div class="input_wrapper">
						<label>State:</label>
						<?php echo $ch_state_cell; ?>
					</div>
					
					<div class="input_wrapper">
						<label>Can people attend this challenge?:</label>
						<?php echo $ch_attend_cell; ?>
					</div>
					
					<h5>Why</h5>
					<div class="input_wrapper">						
						<label>Challenge Blurb:</label>
						<?php echo $ch_blurb_cell; ?>
					</div>
					<div class="input_wrapper">
						<label>Challenge Description:</label>
						<?php echo $ch_description_cell; ?>
					</div>
					
					<div class="input_wrapper">
						<label>Challenge Video URL Link:</label>
						<?php echo $ch_video_cell; ?>
					</div>
					<div class="input_buttons">
						<img src="<?php echo base_url(); ?>images/buttons/prev.gif" value="Prev Step" id="challenge_control_tab_prev_btn" class="prev_btn">					
					
						<img src="<?php echo base_url(); ?>images/buttons/finish.gif" id="cluster_finish_btn" style="width:auto;" />
						<?php if($edit_id) : ?><img src="<?php echo base_url(); ?>images/buttons/save.gif" class="save_button" value="Save your cluster" /><?php endif; ?>
					</div>
				</div> <!-- end challenge_control_tab div -->	
							    					
			</div> <!-- end cluster_data_area -->
<!-- end cluster_area -->

        </div>
    </div>
</div>



</div>

<div style="clear:both;"></div>