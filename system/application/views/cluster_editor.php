<?php
switch($type) {
	
	case 'challengers': 
?>		
		<div id="LeftColumn">
			<div class="leftmenu">
				<?php echo anchor('cluster/view/'.$id, "View Cluster"); ?>
				<?php echo anchor('cluster/editor/'.$id.'/edit', "Edit Cluster"); ?>
				<?php echo anchor('cluster/editor/'.$id.'/challengers', "Manage Challengers"); ?>
			</div>
		</div>
<?php 

		$this->load->view('add_challengers_form', $data);
		break;
	case 'edit':
		$this->load->view('cluster_new_form', $data);
		break;
	default :
		$this->load->view('cluster_editor_home', $data);
		break;
	
}

?>