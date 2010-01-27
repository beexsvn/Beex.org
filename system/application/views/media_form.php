<?php


if($message) {
	echo "<p class='message'>".$message."<span class='val_errors'>";
	echo validation_errors();
	echo "</span></p>";
}


if($new) {
//echo "<h2>".$title."</h2>";
}

if($new) {
	$attributes = array('id' => 'imageform');
	$edit = true;
	$edit_id = '';
	
}
if($edit){
	$attributes = array('id' => 'imageform');
	$edit_id = '';
	if($item) {
		$edit_id = $item->id;
	}
	 
}

if($new || ($edit && !$new && $item->type == 'image')) {
	
	echo form_open_multipart('gallery/process/image/'.$edit_id, $attributes);
	echo "<table border=0 cellpadding=0 cellspacing=0 class='formtable'>";
	
	echo "<th colspan=2>1. Add a Proof Image</td></tr>
			<tr>";
	
	$name = 'item_type';
	$value = ($new) ? $itemtype : $itemtype;
	echo generate_input($name, 'hidden', $edit, $value);
	
	
	$name = 'item_id';
	$value = ($new) ? $itemid : $itemid;
	echo generate_input($name, 'hidden', $edit, $value);
	
	$name = 'gallery_id';
	$value = ($new) ? $galleryid : $item->gallery_id;
	echo generate_input($name, 'hidden', $edit, $value);
	
	$name = 'type';
	$value = 'image';
	echo generate_input($name, 'hidden', $edit, $value);
	
	
	$name = 'name';
	$value = ($new) ? set_value($name) : $item->$name;
	echo "<td>Photo Name</td><td>".generate_input($name, 'input', $edit, $value)."</td>
			</tr>
			<tr>";
			
	$name = 'file';
	$value = ($new) ? set_value($name) : $item->link;
	echo "<td>File</td><td>".generate_input($name, 'file', $edit, $value)."</td>
			</tr>
			<tr>";		
	
	$name = 'caption';
	$value = ($new) ? set_value($name) : $item->$name;
	echo "<td>Caption</td><td>".generate_input($name, 'text', $edit, $value)."</td>
			</tr>
			<tr>";
	
	if($edit){
		$data = array('class'=>'submit');
		echo "<td colspan=2>".form_submit($data, 'Add Image')."</td>";
	}
	
	echo "</tr>
		</table>";
	
	if($edit) {
		echo "</form>";
	}
}

if($edit){
	$attributes = array('id' => 'videoform');
	$edit_id = '';
	if($item) {
		$edit_id = $item->id;
	}
	
} 

if($new || ($edit && !$new && $item->type == 'video')) {
	echo form_open_multipart('gallery/process/video/'.$edit_id, $attributes);
	echo "<table border=0 cellpadding=0 cellspacing=0 class='formtable'>";
	
	echo "<th colspan=2>2. Embed a Proof Video</td></tr>
			<tr>";
	
	$name = 'item_type';
	$value = ($new) ? $itemtype : $itemtype;
	echo generate_input($name, 'hidden', $edit, $value);
	
	
	$name = 'item_id';
	$value = ($new) ? $itemid : $itemid;
	echo generate_input($name, 'hidden', $edit, $value);
	
	$name = 'gallery_id';
	$value = ($new) ? $galleryid : $item->gallery_id;
	echo generate_input($name, 'hidden', $edit, $value);
	
	$name = 'name';
	$value = ($new) ? set_value($name) : $item->$name;
	echo "<td>Video Name</td><td>".generate_input($name, 'input', $edit, $value)."</td>
			</tr>
			<tr>";
			
	$name = 'link'; 
	$value = ($new) ? set_value($name) : $item->$name;
	echo "<td>Embed Link</td><td>".generate_input($name, 'text', $edit, $value)."</td>
			</tr>
			<tr>";		
	
	$name = 'caption';
	$value = ($new) ? set_value($name) : $item->$name;
	echo "<td>Cpation</td><td>".generate_input($name, 'text', $edit, $value)."</td>
			</tr>
			<tr>";
			
	if($edit){
		$data = array('class'=>'submit');
		echo "<td colspan=2>".form_submit($data, 'Add Video')."</td>";
	}
	
	echo "</tr>
		</table>";
	
	if($edit) {
		echo "</form>";
	}
}
?>