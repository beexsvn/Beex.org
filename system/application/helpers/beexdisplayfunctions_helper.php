<?php

function render_login($username = '', $small = false) {
		if($username) :
		?>
        <h2>Welcome <?php echo ucwords($username); ?></h2>
        <?php echo anchor('user/logout', "Logout"); ?>
        <?php
		
		else :
	?>
    	<h2>Account Login</h2>
    <?php echo form_open('user/login'); ?>
    	<label>email</label>
      	<?php echo generate_input('email', 'input', 'input', ''); ?>
        <label>password</label>
        <?php echo generate_input('password', 'password', 'input', ''); ?>
     	<input type="image" src="/beex/images/buttons/signin.gif" style="width:auto;" />
    </form>
 	<?php echo anchor('', 'Forgot your password?'); ?>
    <?php echo ($small) ? anchor("user/newuser", "Register with Beex") : anchor ("user/newuser", "<img src='/beex/images/buttons/register.gif' style='display:block; margin:8px auto;'>"); ?>
    <?php
		endif;	
}

function displayStartLogin($copy, $type = '') {
?>

<?php if($type != 'organization') : ?>
<div id="LogIn" style="background-color:#DBE7E6;">
	<h1 class='awesometitle'>LogIn/Register</h1>
	<div class="loginform_cntr" style="width:701px; margin:0px auto;">
		<img src="<?php echo base_url(); ?>images/backgrounds/blurb-top.png">
<?php endif; ?>
		<div class="loginform" style="background-color:#fff;">
	 		<h3>Before you can <?php echo $copy; ?> you must Login</h3>
	
			<div id="user_registered_yet" style="display:none;">
				<p>Do you already have an account on BEEx?</p>
				<div class="buttons" style="padding:0px 0 32px;">
					<div class="yes_button small_button account_yet" name="already_have_account" id="already_have_account" value="Yes">Yes</div>
                	<div class="yes_button small_button account_yet" name="no_account_yet" id="no_account_yet" value="No">No</div>
				</div>
				<p>Or, login/register through Facebook connect!</p>
				<fb:login-button onlogin="window.location='<?php echo base_url()?>index.php/user/login'"></fb:login-button>
				
			</div>

			<div id="already_registered" class="creation_substep">
				<div class="form_element">
					<label>Email:<span class='required'>*</span></label>
					<div class="input_text"><input type="text" class="dark_gray" name="email" id="login_email"></div>
				</div>
				<div class="form_element">
					<label>Password:<span class='required'>*</span></label>
					<div class="input_text"><input type="password" class="dark_gray" name="password" id="login_password"></div>
				</div>
				<span class="errors" name="login_errors" id="login_errors"></span>
				<div class="buttons">
					<div class="small_button continue_button" name="registered_continue" id="registered_continue" value="Login">Login</div>
                	<!--><div class="small_button continue_button cancel_button" name="cancel_registered" id="cancel_registered" value="Cancel">Go Back</div>-->
				</div>
				<p>Not a member? <?php echo anchor('user/newuser', "Register now"); ?> or Connect with Facebook <fb:login-button onlogin="window.location='<?php echo base_url()?>index.php/user/login'"></fb:login-button></p>
				
			</div>
			<div id="not_registered" class="creation_substep" style="display:none;">
				<div class="form_element">
					<label>Full Name:<span class='required'>*</span></label>
					<div class="input_text"><input type="text" class="dark_gray" name="legal_name" id="legal_name"></div>
				</div>
				<div class="form_element">
					<label>Email:<span class='required'>*</span></label>
					<div class="input_text"><input type="text" class="dark_gray" name="email" id="email"></div>
				</div>
				<div class="form_element">
					<label>Password:<span class='required'>*</span></label>
					<div class="input_text"><input type="password" class="dark_gray" name="password1" id="password1"></div>
				</div>
				<div class="form_element">
					<label>Password Confirmation:<span class='required'>*</span></label>
					<div class="input_text"><input type="password" class="dark_gray" name="password2" id="password2"></div>
				</div>
  				<span class="errors" id="password_validation"></span><br />
				<span class="errors" name="registration_errors" id="registration_errors"></span>
				<div class="buttons">
					<div class="small_button continue_button" name="register_continue" id="register_continue">Continue</div>
                	<div class="small_button continue_button cancel_button" name="cancel_register" id="cancel_register">Go Back</div>
				</div>
			</div>			
		</div>
<?php if($type != 'organization') : ?>
		<img src="<?php echo base_url(); ?>images/backgrounds/blurb-bottom.png">
	</div>
</div>
<?php endif; ?>
<?php	
}


function sizeTheTitle($title, $size = 18, $maxwidth = 10) {
	
	$words = explode(' ', $title);
	
	$width = $maxwidth;
	
	foreach($words as $word) {
		if(strlen($word) > $maxwidth) {
			$width = strlen($word);
		}
	}

	return round($size * ($maxwidth/$width));
	
}


function report_error($message) {
	echo "<p class='error_reporting'>$message</p>";
}

?>