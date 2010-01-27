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
?>