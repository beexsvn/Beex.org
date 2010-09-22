<?php

$this->load->view('framework/header', $header);

//Generate CAPTCHA code and store it in the session for later;
$captcha = $this->MCaptcha->generateCaptcha();
$this->session->set_userdata('captchaWord', $captcha['word']);

if($edit_id != 'add') {
	$item = $this->MItems->getNPO($edit_id, 'id', '', '', '', '', 0)->row();
}

if($message) {

	echo "<p class='message'>".$message."<span class='val_errors'>";

	echo validation_errors();

	echo "</span></p>";

}

if($this->session->userdata('user_id')) {
	$user = $this->MItems->getUser($this->session->userdata('user_id'))->row();

	$name = 'name';
	$value = ($new) ? set_value($name) : @$item->$name;
	$name_cell = generate_input($name, 'input', $edit, $value);

	$name = 'ein';
	$value = ($new) ? set_value($name) : @$item->$name;
	$ein_cell = generate_input($name, 'input', $edit, $value);

	$name = 'paypal_email';
	$value = ($new) ? set_value($name) : @$item->$name;
	$paypal_email_cell = generate_input($name, 'input', $edit, $value);

	$name = 'contact_firstname';
	$value = ($new) ? ((set_value($name)) ? set_value($name) : $user->first_name)  : @$item->$name;
	$contact_firstname_cell = generate_input($name, 'input', $edit, $value);

	$name = 'contact_lastname';
	$value = ($new) ? ((set_value($name)) ? set_value($name) : $user->last_name) : @$item->$name;
	$contact_lastname_cell = generate_input($name, 'input', $edit, $value);

	$name = 'contact_title';
	$value = ($new) ? set_value($name) : @$item->$name;
	$contact_title_cell = generate_input($name, 'input', $edit, $value);

	$name = 'admin_email';
	$value = ($new) ? ((set_value($name)) ? set_value($name) : $user->email) : @$item->$name;
	$admin_email_cell = generate_input($name, 'input', $edit, $value);

	$name = 'admin_emailconf';
	$value = ($new) ? ((set_value($name)) ? set_value($name) : $user->email) : @$item->$name;
	$admin_emailconf_cell = generate_input($name, 'input', $edit, $value);

	$name = 'admin_password';
	$value = ($new) ? set_value($name) : @$item->$name;
	$admin_password_cell = generate_input($name, 'password', $edit, $value);

	$name = 'admin_passconf';
	$value = ($new) ? set_value($name) : @$item->$name;
	$admin_passconf_cell = generate_input($name, 'password', $edit, $value);

	$name = 'contact_phone';
	$value = ($new) ? set_value($name) : @$item->$name;
	$contact_phone_cell = generate_input($name, 'input', $edit, $value);


	/* Profile Info */

	$cats = array ("Animal Rights"=>"Animal Rights",
				   "Justice"=>"Justice",
				   "Education"=>"Education",
				   "Health"=>"Health",
				   "Abuse"=>"Abuse",
				   "Discrimination"=>"Discrimination",
				   "Environment"=>"Environment",
				   "Homelessness"=>"Homelessness",
				   "Relief Efforts"=>"Relief Efforts",
				   "Food Justice"=>"Food Justice",
				   "Politics"=>"Politics",
				   "Arts"=>"Arts",
				   "Development"=>"Development",
				   "Social Enterprise"=>"Social Enterprise",
				   "Poverty"=>"Poverty",
				   "Water"=>"Water",
				   "Peace"=>"Peace",
				   "Journalism"=>"Journalism",
				   "Religious"=>"Religious"
	);

	$name = 'category';
	$value = ($new) ? set_value($name) : @$item->$name;
	$category_cell = generate_input($name, 'dropdown', $edit, $value, $cats);




	$name = 'address_street';
	$value = ($new) ? set_value($name) : @$item->$name;
	$address_street_cell = generate_input($name, 'input', $edit, $value);

	$name = 'address_city';
	$value = ($new) ? set_value($name) : @$item->$name;
	$address_city_cell = generate_input($name, 'input', $edit, $value);

	$name = 'address_state';
	$value = ($new) ? set_value($name) : @$item->$name;
	$address_state_cell = generate_input($name, 'dropdown', $edit, $value, get_special_array('states'));

	$name = 'address_zip';
	$value = ($new) ? set_value($name) : @$item->$name;
	$address_zip_cell = generate_input($name, 'input', $edit, $value);

	$name = 'website';
	$value = ($new) ? set_value($name) : @$item->$name;
	$website_cell = generate_input($name, 'input', $edit, $value);

	$name = 'causetags';
	$value = ($new) ? set_value($name) : $tags;
	$causetags_cell = generate_input($name, 'input', $edit, $value);

	$name = 'mission_statement';
	$value = ($new) ? set_value($name) : @$item->$name;
	$mission_statement_cell = generate_input($name, 'text', $edit, $value);

	$name = 'about_us';
	$value = ($new) ? set_value($name) : @$item->$name;
	$about_us_cell = generate_input($name, 'text', $edit, $value);

	$name = 'rss_feed';
	$value = ($new) ? set_value($name) : @$item->$name;
	$rss_feed_cell = generate_input($name, 'input', $edit, $value);

	$name = 'twitter_link';
	$value = ($new) ? set_value($name) : @$item->$name;
	$twitter_link_cell = generate_input($name, 'input', $edit, $value);

	$name = 'facebook_link';
	$value = ($new) ? set_value($name) : @$item->$name;
	$facebook_link_cell = generate_input($name, 'input', $edit, $value);

	$name = 'youtube_link';
	$value = ($new) ? set_value($name) : @$item->$name;
	$youtube_link_cell = generate_input($name, 'input', $edit, $value);
}

$attributes = array('id' => 'npoform', 'class'=>'form');
$hidden_fields = array('user_id'=>$this->session->userdata('user_id'));
?>

<div id="NPORegistration" class="registration_form">

<div id="LeftColumn">
	
	<p class="small_help_title">THIS IS HOW YOUR PROFILE SIDEBAR WILL APPEAR.</p>
	
	<div class="MiniProfile" id="MiniProfile">
	    <h2>NonProfit</h2>	
		<div class="info">
			<div class='image'>	
				<div class="picture">
				<?php echo (isset($item->logo) && $item->logo) ? '<img src="'.base_url().'/media/npos/'.$item->id.'/cropped120_'.$item->logo.'" />' : display_default_image('npo'); ?>
				</div>
				<img class="border" src="<?php echo base_url(); ?>images/tout-image-border.png" />
		    </div>
			<p><span id="dyna_name" class="namelink"><?php echo (isset($item->name)) ? $item->name : 'Organization Name'; ?></span></p>
			
		</div>
		<img src="<?php echo base_url(); ?>images/backgrounds/left-tout-bottom.gif" />
	</div>
	
	<img class="block" src="<?php echo base_url(); ?>images/backgrounds/secondary-left-tout-top.png" />
	<div class="secondary_left_tout">
		<p class="question">What We Do: </p>
		<p class="answer" id="dyna_mission_statement"><?php echo (isset($item->mission_statement)) ? $item->mission_statement : 'This will be what you write in the "What We Do" section'; ?></p>
		<p class="question">History: </p>
		<p class="answer" id="dyna_about_us"><?php echo (isset($item->about_us)) ? $item->about_us : 'This will be your history '; ?></p>
	</div>
	<img class="block" src="<?php echo base_url(); ?>images/backgrounds/secondary-left-tout-bottom.png" />
	
	<div id="HelpDescriptor1" class="help_floater">
		<p>Your Logo</p>
		<img src="<?php echo base_url(); ?>images/graphics/curvy-arrow.png">
	</div>
	
	<div id="HelpDescriptor2" class="help_floater">
		<p>Your Name</p>
		<img src="<?php echo base_url(); ?>images/graphics/curvy-arrow.png">
	</div>
	
	<div id="HelpDescriptor3" class="help_floater">
		<p>Your Profile Information</p>
		<img src="<?php echo base_url(); ?>images/graphics/curvy-arrow.png">
	</div>
	
</div>

<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>beex_scripts/beex_helper.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>beex_scripts/start_login.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>scripts/ajaxupload.3.5.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>beex_scripts/dynamic_forms.js"></script>

<script type="text/javascript">
$(document).ready(function() {
	
	$(".dynamic_input input, .dynamic_input textarea").keyup(function(event) {
		var id = $(this).attr('id');
		if($(this).val()) {
			$("#dyna_"+id).html($(this).val());
		}
		else {
			var message = '';
			if(id == 'name') {
				message = 'Organization Name';
			}
			if(id == 'mission_statement') {
				message = 'This will be what you write in the "What We Do" section';
			}
			if(id == 'about_us'){
				message = 'This will be your history';
			}
			$("#dyna_"+id).html(message);
		}
	})

	$(".form_save_cell input").hover(function() {
	
		$(this).attr('src', '<?php echo base_url(); ?>images/buttons/submit-over.png');
	
	}, function() {
		$(this).attr('src', '<?php echo base_url(); ?>images/buttons/submit.png');
	});

});

</script>

<div id="RightColumn">

	<?php if(!$this->session->userdata('user_id')) : ?>
		<style>
		#NPORegistration .loginform {width:auto; padding:1px 0px 10px;}
		</style>
		<img class="block" src="<?php echo base_url(); ?>images/backgrounds/reg-form-bg-top.png" />
	    <div id="FormWrapper" class="start_something">
		   	<img class="block" src="<?php echo base_url(); ?>images/backgrounds/reg-form-top.png" />
			<div id="FormBody">
			<?php displayStartLogin('register an organization', 'organization'); ?>
			</div>
			<img class="block" src="<?php echo base_url(); ?>images/backgrounds/reg-form-bottom-white.png" />

		</div>	
		<div class="form_save_cell"></div>
	<?php else: ?>
	
<?php
	if($new) {
		$edit = true;
	}
	if($edit){
		echo form_open_multipart('npo/process/'.$edit_id, $attributes, $hidden_fields);
	}
?>
	<img class="block" src="<?php echo base_url(); ?>images/backgrounds/reg-form-bg-top.png" />
    <div id="FormWrapper">
	   	<img class="block" src="<?php echo base_url(); ?>images/backgrounds/reg-form-top.png" />
		<div id="FormBody">
        	<h2 class="heading">Registration</h2>
			<div class="reg_section no-border bottom_section">
				<p class="direction">REQUIRED FIELDS<span class="required">*</span></p>

				<h2>Organization Information</h2>
				
				<div class="form_element">
					<label>Organization Name:<span class='required'>*</span></label>
					<div class="input_text dynamic_input"><?php echo $name_cell; ?></div>
				</div>
				
				<div class="form_element">
					<label>EIN Number:<span class='required'>*</span></label>
					<div class="input_text"><?php echo $ein_cell; ?></div>
				</div>
				
				<div class="form_element">
					<label>Paypal Email:<span class='required'>*</span></label>
					<div class="input_text"><?php echo $paypal_email_cell; ?></div>
				</div>
				
				<div class="form_element">
					<label>Mailing Address:<span class='required'>*</span></label>
					<div class="input_text"><?php echo $address_street_cell; ?></div>
				</div>
				
				<div class="form_element">
					<label>City:<span class='required'>*</span></label>
					<div class="input_text"><?php echo $address_city_cell; ?></div>
				</div>
				
				<div class="form_element">
					<label>State:<span class='required'>*</span></label>
					<div class="input_select"><?php echo $address_state_cell; ?></div>
				</div>
				
				<div class="form_element">
					<label>Zip:<span class='required'>*</span></label>
					<div class="input_text"><?php echo $address_zip_cell; ?></div>
				</div>
				
				<div class="form_element">
					<label>Phone Number:<span class='required'>*</span></label>
					<div class="input_text"><?php echo $contact_phone_cell; ?></div>
				</div>
				
				<div class="form_element">
					<label>Logo:<span class='required'>*</span></label>
					<div class="input_picture"><div id="upload_npo" class="ajax_upload upload_button">Upload Logo</div><span id="status_npo" class="ajax_upload_status"></span></div>
				</div>
				
				<h2>Adminstrator Information</h2>
				
				<div class="form_element">
					<label>Your First Name:<span class='required'>*</span></label>
					<div class="input_text"><?php echo $contact_firstname_cell; ?></div>
				</div>
				
				<div class="form_element">
					<label>Your Last Name:<span class='required'>*</span></label>
					<div class="input_text"><?php echo $contact_lastname_cell; ?></div>
				</div>
				
				<div class="form_element">
					<label>Your Title:<span class='required'>*</span></label>
					<div class="input_text"><?php echo $contact_title_cell; ?></div>
				</div>
				
				<div class="form_element">
					<label>Your Email:<span class='required'>*</span></label>
					<div class="input_text"><?php echo $admin_email_cell; ?></div>
				</div>
				<?php if($new) : ?>
				<div class="form_element">
					<label>Confirm Your Email:<span class='required'>*</span></label>
					<div class="input_text"><?php echo $admin_emailconf_cell; ?></div>
				</div>
				<?php endif;?>
				
				<?php if(FALSE) :?> 
					<?php if(!$new) : ?>
					<p class="direction" style="margin:10px 0 4px;">If you wish to change you password, fill out the password fields below. Otherwise, you leave the password fields blank.</p>

					<?php endif; ?>
					<div class="form_element">
						<label>BEEx Password:<span class='required'>*</span></label>
						<div class="input_text"><?php echo $admin_password_cell; ?></div>
					</div>
					
					<div class="form_element">
						<label>Confirm BEEx Password:<span class='required'>*</span></label>
						<div class="input_text"><?php echo $admin_passconf_cell; ?></div>
					</div>
				<?php endif; ?>
				
				<h2>Profile Information</h2>
				<div class="form_element">
					<label>What We Do:</label>
					<div class="input_textarea dynamic_input"><?php echo "<img src='".base_url()."images/backgrounds/text-area-top.png'>".$mission_statement_cell."<img src='".base_url()."images/backgrounds/text-area-bottom.png'>"; ?></div>
				</div>
				
				<div class="form_element">
					<label>History:</label>
					<div class="input_textarea dynamic_input"><?php echo "<img src='".base_url()."images/backgrounds/text-area-top.png'>".$about_us_cell."<img src='".base_url()."images/backgrounds/text-area-bottom.png'>"; ?></div>
				</div>
				
				<div class="form_element">
					<label>Cause Tags:<br><span class="small">Cause tags are words that describe your organization's work</span></label>
					<div class="input_text"><?php echo $causetags_cell; ?></div>
				</div>
			
				<div class="form_element">
					<label>Website:</label>
					<div class="input_text"><?php echo $website_cell; ?></div>
				</div>
				
				<div class="form_element">
					<label>Facebook Address:</label>
					<div class="input_text"><?php echo $facebook_link_cell; ?></div>
				</div>
				
				<div class="form_element">
					<label>Twitter Address:</label>
					<div class="input_text"><?php echo $twitter_link_cell; ?></div>
				</div>
				
				<div class="form_element">
					<label>RSS Feed:</label>
					<div class="input_text"><?php echo $rss_feed_cell; ?></div>
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

		   </div>
			<img class="block" src="<?php echo base_url(); ?>images/backgrounds/reg-form-bottom-white.png" />

		  </div>	
		<div class="form_save_cell"><input type="image" value="Register" src="<?php echo base_url(); ?>images/buttons/submit.png" /></div>
	</form>
	<?php endif; ?>
	</div>

</div>
<div style="clear:both;"></div>


<?php


$this->load->view('framework/footer');



?>