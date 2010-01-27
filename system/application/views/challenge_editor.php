<?php
$this->load->view('framework/header', $header);
?>

<div id="ClusterForm" class="form">

<div id="LeftColumn">
	<div class="leftmenu">
		<?php echo anchor('challenge/view/'.$id, "View Challenge"); ?>
		<?php echo anchor('challenge/editor/'.$id.'/edit', "Edit Challenge"); ?>
		<?php echo anchor('challenge/editor/'.$id.'/teammates', "Manage Teammates"); ?>
	</div>
</div>

<?php
switch($type) {
	
	case 'teammates': 
		$this->load->view('add_teammates_form', $data);
		break;
	case 'edit':
		$this->load->view('challenge_form', $data);
		break;
	default :
		$this->load->view('challenge_editor_home', $data);
		break;
	
}

$this->load->view('framework/footer');
?>