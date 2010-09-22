<?php
switch($type) {
	
	case 'teammates': 
?>
<div id="LeftColumn">
	<div class="leftmenu">
		<?php echo anchor('challenge/view/'.$id, "View Challenge"); ?>
		<?php echo anchor('challenge/editor/'.$id.'/edit', "Edit Challenge"); ?>
		<?php echo anchor('challenge/editor/'.$id.'/teammates', "Manage Teammates"); ?>
	</div>
</div>
<?php
		$this->load->view('add_teammates_form', $data);
		break;
	case 'edit':
		$data['help_copy'] = 'Fill out the form to the right to edit your challenge. Reference the Help Editor that appears below if you’re confused about a section.';
		$data['help_title'] = 'Edit Your Challenge';
		$this->load->view('challenge_new_form', $data);
		break;
	default :
		$this->load->view('challenge_editor_home', $data);
		break;
	
}

?>