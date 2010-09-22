<?php

if($message) {
	echo "<p class='message'>".$message."<span class='val_errors'>";
	echo validation_errors();
	echo "</span></p>";
}

if($new) {
	$attributes = array('id' => 'edit_proof_form', 'class'=>'form proof_form');
	$edit = false;
	$edit_id = '';
	
}
if($edit){
	$attributes = array('id' => 'edit_proof_form'.$item->id, 'class'=>'form proof_form');
	$edit_id = '';
	if($item) {
		$edit_id = $item->id;
	}
	 
}


echo form_open_multipart('gallery/process/image/'.$edit_id, $attributes);
	
	$hiddens = array(
		 'item_type' => ($new) ? $itemtype : $itemtype,
		'item_id' => ($new) ? $itemid : $itemid,
		'gallery_id' => ($new) ? $galleryid : $item->gallery_id
	);
	echo form_hidden($hiddens);
?>

<h3><?php echo ($edit) ? "EDIT" : "NEW"; ?> PROOF</h3>
<div class="form_element">
	<label>Title:<span class="required">*</span></label>
	<div class="input_text"><input name="name" value="<?php echo ($edit) ? $item->name : ''; ?>" /></div>
</div>
<div class="form_element">
	<label>Note:<span class="required">*</span></label>

    <div class="input_textarea">
		<img src="<?php echo base_url(); ?>images/backgrounds/text-area-top.png" />
		<textarea id="editor_<?php if($item) echo $item->id; ?>" name="caption"><?php echo ($edit) ? $item->caption : ''; ?></textarea>
		<img src="<?php echo base_url(); ?>images/backgrounds/text-area-bottom.png" />
	</div>
	
</div>

<div class="form_element">
	<label>Add <?php echo ($edit) ? 'New' : ''; ?> Image:<br><span class="small">(4MB Max)</span></label>
	<div class="input_picture"><input type="file" name="file" /></div>
</div>
<div class="form_element">
	<label>Paste Video Link:</label>
    <div class="input_text"><input type="text" class="videoembed" name="link" value="<?php echo ($edit) ? $item->link : ''; ?>" /></div>
</div>

<div class="proof_errors error" id="proof_errors<?php echo $edit_id; ?>"></div>

<div class="buttons">
	<input type="image" class="rollover" src="<?php echo base_url(); ?>images/buttons/reg-form-submit-off.png" />  <img class="cancel_button rollover" src="<?php echo base_url(); ?>images/buttons/cancel-off.png" />
</div>
</form>
