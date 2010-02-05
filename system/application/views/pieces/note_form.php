<?php

$edit = true;

//Edit or New Note?
if($id == 'new') {
	
	$id = '';
	$edit = false;
}

$attributes = array(
				'class' => 'form',
				'id' => 'edit_note_form'.$id,
				'style' => 'display:none'
				  );

echo form_open_multipart('challenge/add_note/'.$item_id.(($edit) ? '/'.$id : ''), $attributes);
?>
<h3><?php echo ($edit) ? "Edit" : "New"; ?> Note</h3>
<table>
	<tr>
    	<td>Title: </td>
        <td><input name="title" value="<?php echo ($edit) ? $note->title : ''; ?>" /></td>
    </tr>
	<tr>
    	<td>Note: </td>
        <td><textarea name="note"><?php echo ($edit) ? $note->note : ''; ?></textarea></td>
    </tr>
    <tr>
    	<td colspan="2">Select media for your post</td>
    </tr>
    <tr>
    	<td>Upload <?php echo ($edit) ? 'New' : ''; ?> Image<?php echo ($edit) ? ' (Otherwise just leave blank)' : ''; ?>:</td>
        <td><input type="file" name="note_image" /></td>
    </tr>
    <tr>
    	<td colspan="2">Or</td>
    </tr>
    <tr>
    	<td>Embed Video:</td>
        <td><textarea class="videoembed" name="note_video"><?php echo ($edit) ? $note->note_video : ''; ?></textarea></td>
    </tr>
    <tr>
    	<td colspan=2><input type="submit" value="<?php echo ($edit) ? "Edit" : "Add"; ?> Note" class="submit" /> <input type="button" class="cancel_button" value="Cancel"></td>
    </tr>
</table>
</form>
<?php


?>