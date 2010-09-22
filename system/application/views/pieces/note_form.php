<?php

$edit = true;

//Edit or New Note?
if($id == 'new') {
	$id = '';
	$edit = false;
}

$item_type = $this->MItems->get_item_type($item_id);

$attributes = array(
				'class' => 'form note_form',
				'id' => 'edit_note_form'.$id,
				'style' => 'display:none'
				  );

echo form_open_multipart('item/add_note/'.$item_id.(($edit) ? '/'.$id : ''), $attributes);
?>


<h3><?php echo ($edit) ? "Edit" : "Write"; ?> A Note</h3>
<div class="form_element">
	<label>Title:<span class="required">*</span></label>
	<div class="input_text"><input name="title" value="<?php echo ($edit) ? $note->title : ''; ?>" /></div>
</div>
<div class="form_element">
	<label>Note:<span class="required">*</span></label>

    <div class="input_textarea">
		<img src="<?php echo base_url(); ?>images/backgrounds/text-area-top.png" />
		<textarea id="editor_<?php echo $id; ?>" name="note"><?php echo ($edit) ? $note->note : ''; ?></textarea>
		<img src="<?php echo base_url(); ?>images/backgrounds/text-area-bottom.png" />
	</div>
	
</div>

<div class="form_element">
	<label>Add <?php echo ($edit) ? 'New' : ''; ?> Image:<br><span class="small">(4MB Max)</span></label>
	<div class="input_picture"><input type="file" name="note_image" /></div>
</div>
<div class="form_element">
	<label>Paste Video Link:</label>
    <div class="input_text"><input type="text" class="videoembed" name="note_video" <?php echo ($edit) ? $note->note_video : ''; ?> /></div>
</div>

<?php if($item_type == 'challenge') : ?>
<div class="form_element">
	<label>Is this proof?:</label>
    <div class="input_radio"><input type="radio" name="proof" value="1" <?php echo ($edit && $note->proof == '1') ? 'checked="checked"' : ''; ?>> Yes <input type="radio" name="proof" value="0" <?php echo (!$edit || $note->proof == '0') ? 'checked="checked"' : ''; ?>> No</div>
</div>
<?php else : ?>
<div class="form_element">
	<label>Would you like to email the challengers this note?:</label>
    <div class="input_radio"><input type="radio" name="email_challengers" value="1" checked="checked"> Yes <input type="radio" name="email_challengers" value="0"> No</div>
</div>
<?php endif; ?>
<div class="note_errors error" id="note_errors<?php echo $id; ?>"></div>

<div class="buttons">
	<input type="image" class="rollover" src="<?php echo base_url(); ?>images/buttons/reg-form-submit-off.png" />  <img class="cancel_button rollover" src="<?php echo base_url(); ?>images/buttons/cancel-off.png" />
</div>

</form>
