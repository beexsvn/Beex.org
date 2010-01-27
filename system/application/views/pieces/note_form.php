<?php
$attributes = array(
				'class' => 'form',
				'id' => 'add_note_form',
				'style' => 'display:none'
				   );

echo form_open_multipart('challenge/add_note/'.$item->id, $attributes);
?>
<h3>New Note</h3>
<table>
	<tr>
    	<td>Title: </td>
        <td><input name="title" /></td>
    </tr>
	<tr>
    	<td>Note: </td>
        <td><textarea name="note"></textarea></td>
    </tr>
    <tr>
    	<td colspan="2">Select media for your post</td>
    </tr>
    <tr>
    	<td>Upload Image:</td>
        <td><input type="file" name="note_image" /></td>
    </tr>
    <tr>
    	<td colspan="2">Or</td>
    </tr>
    <tr>
    	<td>Embed Video:</td>
        <td><textarea class="videoembed" name="note_video"></textarea></td>
    </tr>
    <tr>
    	<td colspan=2><input type="submit" value="Add Note" class="submit" /></td>
    </tr>
</table>
</form>
<?php


?>