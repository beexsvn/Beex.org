<?php

//$new = true;
$this->session->set_userdata('temp_time', time());

//Generate CAPTCHA code and store it in the session for later;
$captcha = $this->MCaptcha->generateCaptcha();
$this->session->set_userdata('captchaWord', $captcha['word']);


if($message) {
	echo "<p class='message'>".$message."<span class='val_errors'>";
	echo validation_errors();
	echo "</span></p>";
}

if($new) {
	$edit = true;
	$attributes = array('id' => 'Registration', 'class'=>'form');
	$edit_id = '';
}
elseif($edit){
	$edit = true;
	$attributes = array('id' => 'Registration', 'class'=>'form');

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
$first_name_cell = generate_input($name, 'input', $edit, $value, '', '', '', array('maxlength'=>17));

$name = 'last_name';
$value = ($new) ? set_value($name) : @$item->$name;
$last_name_cell = generate_input($name, 'input', $edit, $value, '', '', '', array('maxlength'=>17));


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

// Website Cell
$name = 'website';
$value = ($new) ? set_value($name) : @$item->$name;
$website_cell = generate_input($name, 'input', $edit, $value);


// Website Cell
$name = 'upsets';
$value = ($new) ? set_value($name) : @$item->$name;
$upsets_cell = generate_input($name, 'text', $edit, $value);

// Website Cell
$name = 'joy';
$value = ($new) ? set_value($name) : @$item->$name;
$joy_cell = generate_input($name, 'text', $edit, $value);

if($edit){
	$data = array('class'=>'submit');
	$verb = ($new) ? 'Add' : 'Edit';
	$submit_cell = form_submit($data, $verb.' User');
}
?>
<div id="UserForm" class="registration_form">

<div id="LeftColumn">
	
	<p class="small_help_title">THIS IS HOW YOUR PROFILE STUB WILL APPEAR.</p>
	
	<div class="MiniProfile" id="MiniProfile">
	    <h2>Challenger</h2>	
		<div class="info">
	    	<div class='image'>
				
				<div class="picture">
				<?php 
					if($pic = $this->session->userdata('profile_picture')) {
						echo '<img src="'.base_url().'/media/profiles/cropped134_'.$pic.'" />';
					}
					elseif(isset($item->profile_pic) && $item->profile_pic) {
						echo '<img src="'.base_url().'/media/profiles/'.$item->user_id.'/cropped120_'.$item->profile_pic.'" />';
					}
					else {
						echo display_default_image('profile');
					}  
					
				?>
				</div>
				<img class="border" src="<?php echo base_url(); ?>images/tout-image-border.png" />
		    </div>
			<p><span id="dyna_first_name" class="namelink"><?php echo ($new) ? ((isset($_POST['first_name'])) ? $_POST['first_name'] : 'Your') : $item->first_name; ?></span> <span id="dyna_last_name" class="namelink"><?php echo ($new) ? ((isset($_POST['last_name'])) ? $_POST['last_name'] : 'Name') : $item->last_name; ?></span></p>
			
		</div>
		<img src="<?php echo base_url(); ?>images/backgrounds/left-tout-bottom.gif" />
	</div>
	
	<!--
	<img src="<?php echo base_url(); ?>images/backgrounds/secondary-left-tout-top.png" />
	<div class="secondary_left_tout">
		<p class="question">What upsets you the most?</p>
		<p class="answer" id="dyna_upsets"><?php echo (isset($item->upsets)) ? $item->upsets : 'This will be your first answer'; ?></p>
		<p class="question">What brings you the most joy?</p>
		<p class="answer" id="dyna_joy"><?php echo (isset($item->joy)) ? $item->joy : 'This will be your second answer'; ?></p>
	</div>
	<img src="<?php echo base_url(); ?>images/backgrounds/secondary-left-tout-bottom.png" />
	-->
	<div id="HelpDescriptor1" class="help_floater">
		<p>Your Picture</p>
		<img src="<?php echo base_url(); ?>images/graphics/curvy-arrow.png">
	</div>
	
	<div id="HelpDescriptor2" class="help_floater">
		<p>Your Name</p>
		<img src="<?php echo base_url(); ?>images/graphics/curvy-arrow.png">
	</div>
	
	<!--
	<div id="HelpDescriptor3" class="help_floater">
		<p>Your Personal Information</p>
		<img src="<?php echo base_url(); ?>images/graphics/curvy-arrow.png">
	</div>
	-->
</div>

<div id="RightColumn">

<?php
	if($new)
		$edit = true;

	if($edit){

		echo form_open_multipart('user/process/user/'.$edit_id, $attributes);
	}
?>
	<img class="block" src="<?php echo base_url(); ?>images/backgrounds/reg-form-bg-top.png" />
    <div id="FormWrapper">
	   	<img class="block" src="<?php echo base_url(); ?>images/backgrounds/reg-form-top.png" />
		<div id="FormBody">
        	<h2 class="heading">Registration</h2>
        		
<?php

if(true) :
?>

<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>scripts/ajaxupload.3.5.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>beex_scripts/dynamic_forms.js"></script>
		
<script type="text/javascript">
			
			$(document).ready(function() {
				
				$(".dynamic_input input").each(function() {
					if($(this).val()) {
						if($("#MiniProfile").css('opacity') < 1) {
							$("#MiniProfile").css('opacity', 1);
						}
					}
				});
				
				$(".dynamic_input input, .dynamic_input textarea").keyup(function(event) {
					var id = $(this).attr('id');
					if($(this).val()) {
						$("#dyna_"+id).html($(this).val());
					}
					else {
						var message = '';
						if(id == 'first_name') {
							message = 'Your';
						}
						if(id == 'last_name') {
							message = 'Name';
						}
						$("#dyna_"+id).html(message);
					}
					
					if($("#MiniProfile").css('opacity') < 1) {
						$("#MiniProfile").css('opacity', 1);
					}
					
				});
				
				
				FB.Event.subscribe('auth.login', function(response) {
				  	enable_fb_connect<?php if($new) echo "_new"; ?>();
				});
				
				$(".disable_fb_connect").click(function() {
					
					var id = $(this).attr('id').substr(18);
										
					jQuery.ajax({
						
						type:"POST",
						url:"<?php echo base_url(); ?>index.php/ajaxforms/disable_fb_connect",
						data: "id="+id,
						success: function(html) {
							$("#fb_connect_enabled").hide();
							$("#fb_connect_button").show();
						}
						
					});
					
				});
				
				$(".enable_fb_connect").click(function() {
					enable_fb_connect();
				});
				
				$(".enable_fb_connect_new").click(function() {	
					enable_fb_connect_new();
				});
				
				function enable_fb_connect_new() {
					
					jQuery.ajax({
						
						type:"POST",
						url:"<?php echo base_url(); ?>index.php/ajaxforms/enable_fb_connect_new",
						dataType:"json",
						
						success: function(ret) {
							if(ret['me']) {
								
								alert(ret['success']);
								
								newimage = ret['image'];
								ret = ret['me'];
								
								$("#fb_user").val(ret['id']);
								if(ret['first_name']) {
									$("#first_name").val(ret['first_name']);
									$("#dyna_first_name").html(ret['first_name']);
								}
								if(ret['last_name']) {
									$("#last_name").val(ret['last_name']);
									$("#dyna_last_name").html(ret['last_name']);
								}
								if(ret['birthday']) {
									bdate = ret['birthday']
									
									bmonth = bdate.substr(0, 2);
									if(bmonth < 10) {
										bmonth = bmonth.substr(1);
									}
									
									bday = bdate.substr(3, 2);
									if(bday < 10) {
										bday = bday.substr(1);
									}
									
									byear = bdate.substr(6, 4);
																		
									$("[name='birthmonth']").val(bmonth);
									$("[name='birthday']").val(bday);
									$("[name='birthyear']").val(byear);
								}
								/*
								if(ret['hometown']['name']) {
									$("#hometown").val(ret['hometown']['name']);
								}
								*/
								if(ret['gender']) {
									if(ret['gender'] == 'male') {
										$("#gender").val('Male');
									}
									else {
										$("#gender").val('Female');
									}
								}
								
								$('.picture img').attr('src', newimage)
								
								$("#fb_connect_enabled").html("<p>Facebook Connect enabled");
								$("#fb_connect_enabled").show();
								$("#fb_connect_button").hide();
								
							
							}
							else if(ret['error']) {
								FB.logout();
								alert(ret['error']);
							}
							else {
								FB.logout();
								alert('New FB User Function didnt work');
							}
						}
						
					});
					
				}
				
				function enable_fb_connect() {
					
					jQuery.ajax({
						
						type:"POST",
						url:"<?php echo base_url(); ?>index.php/ajaxforms/enable_fb_connect",
						dataType:"json",
						data: "id=" + <?php echo (isset($item->id)) ? $item->id : '0'; ?>,
						
						success: function(ret) {
							if(ret['success']) {
								$("#fb_connect_enabled").show();
								$("#fb_connect_button").hide();
								alert(ret['success']);
							}
							else if(ret['error']) {
								alert(ret['error']);
								FB.logout();
							}
							else {
								FB.logout();
								alert('Function didnt work');
							}
						}	
					});		
				}
				
			});
			
		</script>
		
<?php
	/// In the future, 'a8656fd483cd0ba9c14474feb455bc98' should be replaced with $this->config->item('facebook_api_key'). 
	/// I have no idea why it's not working

endif;

?>
	
	<?php if($new) : ?><input type="hidden" name="fb_user" id="fb_user" value="<?php if(isset($fb_user)) echo $fb_user; ?>"><?php endif;?>
	
	<div class="reg_section">
		<p class="direction">REQUIRED FIELDS<span class="required">*</span></p>
		
		<div class="form_element">
			<label>First Name:<span class='required'>*</span></label>
			<div class="input_text dynamic_input"><?php echo $first_name_cell; ?></div>
		</div>
	
		<div class="form_element">
			<label>Last Name:<span class='required'>*</span></label>
			<div class="input_text dynamic_input"><?php echo $last_name_cell; ?></div>
		</div>	
	
	    <div class="form_element">
			<label>Email:<span class='required'>*</span></label>
			<div class="input_text <?php if(!$new) echo 'no_bg_image'; ?>"><?php echo $email_cell; ?></div>
		</div>
	
		<?php if(!$new) : ?>
		<p class="direction" style="margin-top:18px;">If you wish to change you password, fill out the password fields below. Otherwise, you leave the password fields blank.</p>
	
		<?php endif; ?>
	
		<div class="form_element">
			<label>Password:<span class='required'>*</span></label>
			<div class="input_text"><?php echo $password_cell; ?></div>
		</div>
	
		<div class="form_element">
			<label>Confirm Password:<span class='required'>*</span></label>
			<div class="input_text"><?php echo $password_conf_cell; ?></div>
		</div>

	<?php 
		if(!@$item->fb_user) {	
			$e_class = 'none';
		}
		else {
			$b_class = 'none';
		}
	?>
	     <div id="fb_connect_button" <?php if(isset($b_class)) : ?>style="display:<?php echo $b_class; ?>; <?php endif; ?>">
							<label class="auto">Enable one-click login with Facebook Connect:</label>							
								<?php if(isset($me)) :?>
									<?php if(isset($fb_user)) : ?>
										<p>You are currently connected, <?php echo $me['first_name']; ?>. Please finish registering.</p>
									<?php else : ?>
										<p>You are logged into facebook as <?php echo $me['first_name']." ".$me['last_name']; ?>. <a class="enable_fb_connect<?php if($new) echo "_new"; ?>">Click here to connect your accounts</a>.</p>			
									<?php endif;?>
								<?php else : ?>	
									<fb:login-button perms="publish_stream"></fb:login-button>
								<?php endif; ?>							
		</div>
	
		<div id="fb_connect_enabled" <?php if(isset($e_class)) : ?>style="display:<?php echo $e_class; ?>; <?php endif; ?>">
			<label>Facebook Connect:</label>
			<p>Facebook connect is currently Enabled! (<a class="disable_fb_connect" id="disable_fb_connect<?php if(isset($item->id)) { echo $item->id; } ?>">Disable</a>)</p>
		</div>
		
		<?php if($new): ?>
		<p style="margin-top:18px;"><span class="required">*</span> Please enter the code below to complete your registration</p>
		<div class="form_element">
			<label>Security Code:</label>
			<div class="input_picture"><?php echo $captcha['image']; ?></div>
		</div>
		
		<div class="form_element">
			<label>Confirm Code:<span class="required">*</span></label>
			<div class="input_text"><input type="text" name="captcha"></div>
		</div>
		<?php endif; ?>
	</div>
	
	<div class="reg_section bottom_section">
    	<h2 class="heading">Profile Information</h2>
		
		<div class="form_element">
			<label>Profile Picture<br /><span class="small">(4 MB maximum size)</span></label>
			<?php if($new) : ?>
			<div class="input_picture"><div id="upload_profile" class="upload_button ajax_upload">Upload File</div><span id="status_profile" class="ajax_upload_status"></span></div>
			<?php else: ?>
				<div class="input_picture"><?php echo anchor("gallery/crop/".$user_id, "Edit Picture", array('class'=>'jcrop_pop upload_button', 'rel'=>'iframe')); ?></div>
			<?php endif; ?>
		</div>
		
		<div class="form_element">
			<labeL>Birthday: <span class="small">(MM/DD/YY)</span></label>
			<div class="input_select"><?php echo $birthmonth_cell.' '.$birthday_cell.' '.$birthyear_cell; ?></div>
		</div>
		<!--
		<div class="form_element">
			<label>Origin:</label>
			<div class="input_text"><?php echo $hometown_cell; ?></div>
		</div>
		-->
		<div class="form_element">
			<label>Zip:</label>
			<div class="input_text"><?php echo $zip_cell; ?></div>
		</div>
		
		<div class="form_element">
			<label>Gender:</label>
			<div class="input_select"><?php echo $gender_cell; ?></div>
		</div>
		
		<div class="form_element">
			<label>Website:</label>
            <div class="input_text"><?php echo $website_cell; ?></div>
        </div>

		<div class="form_element">
			<label class="auto">What upsets you the most?:</label>
            <div class="input_textarea"><?php echo "<img src='".base_url()."images/backgrounds/text-area-top.png'>".$upsets_cell."<img src='".base_url()."images/backgrounds/text-area-bottom.png'>"; ?></div>
        </div>

		<div class="form_element">
			<label class="auto">What brings you the most joy?:</label>
            <div class="input_textarea"><?php echo "<img src='".base_url()."images/backgrounds/text-area-top.png'>".$joy_cell."<img src='".base_url()."images/backgrounds/text-area-bottom.png'>"; ?></div>
        </div>

   	</div>	
	
	
        </div>
		<img class="block" src="<?php echo base_url(); ?>images/backgrounds/reg-form-bottom-white.png" />
	   	
		
    </div>	
	<div class="form_save_cell"><input type="image" class="rollover" value="Register" src="<?php echo base_url(); ?>images/buttons/save-off.png" /></div>
	</form>

</div>

</div>
<div style="clear:both;"></div>