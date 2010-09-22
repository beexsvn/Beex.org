<?php

$this->load->view('framework/header', $header);
$attributes = array('id'=>'VerificationCodeForm', 'class'=>'form');

echo "<h2>Verify Yourself!</h2>";

if($success) {
	echo "<p class='message'>".$message."</p>";
}
else {

if($message) {

	echo "<p class='message'>".$message."</p>";

}

echo form_open('user/entercode/'.$user_id, $attributes);
?>

<p>Please check your email and enter your verification code found in your BEEx registration email. Alternatively you may click the link found in that email.</p>
<?php $form_data = array('name'=>'code', 'id'=>'code', 'size'=>25); ?>
<div class="form_element">
	<label>Verification Code</label>
	<div class="input_text"><?php echo form_input($form_data); ?></div>
</div>

<?php $submit_data = array('class'=>'submit'); ?>
<div>
	<input type="image" class="rollover" src="<?php echo base_url(); ?>images/buttons/reg-form-submit-off.png" />
</div>
</form>

<?php
}

$this->load->view('framework/footer');

?>