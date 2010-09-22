<?php

class Item extends Controller { 
	
	// Preload data
	public $data;
	public $form_elements;
	
	function Item() {
		parent::Controller();
		
		$this->load->helper('form');
		
		$this->form_elements = array (
			'name' => array(
								'name'=> "Name",
								'type'=> 'text'
							),
			'date' => array(
								'name'=> "Date of Entry",
								'type'=> 'date',
								'hidden'=>true,
								'value'=> date( 'Y-m-d H:i:s', time())
							),
			'text' => array(
								'name'=> "Textfield Describe This",
								'type'=> "textarea"
							),
			'dropdown' => array (
								 	'name'=> "Ex Dropdown",
									'type'=> 'dropdown'
								),
			'image' => array (
							  	'name'=> "Logo",
								'type'=> "file",
								'filetype' => 'image'
							)
		);
	}
	
	function index() {
		
		$this->load->view('npoform', $data);
	}

	
	// Add Note: Function that processes adding the note to a challenge */
	function add_note() {
		
		$data = $this->data;
		
		$item_id = $this->uri->segment(3);
		$note_id = $this->uri->segment(4, 'add');
		
		$item = $this->MItems->getItem($item_id);
		
		if($item->num_rows()) {
			
			// Item information. Store for function
			$i = $item->row();
			$item_type = $i->type;
			
			// Check to see if cluster and if they want to email challengers 
			$email_challengers = false;
			if($item_type == 'cluster') {
				if($this->input->post('email_challengers')) {
					$email_challengers = true;
				}
			}
			
			//Process special fields
			$_POST['created'] = date("Y-m-d H:i:s");
			$_POST['item_id'] = $item_id;
		
			unset($_POST['x'], $_POST['y'], $_POST['email_challengers']);
				
			//Process Images
			if($_FILES['note_image']['name']) {
				$_POST['note_image'] = $this->beex->do_upload($_FILES, 'note_image', './media/notes/');					
			}
		
			//Get rid of empty values
			foreach($_POST as $key => $val) {
				if(!$val) {
					unset($_POST[$key]);	
				}
			}
		
			if($this->input->post('proof')) {
				$type = 'proof';
			}
			else {
				$type = 'note';
				$_POST['proof'] = 0;
			}
		
			if($note_id == 'add') {
				if($note_id = $this->MItems->add('notes', $_POST)) {	
					$this->MItems->addActivity($type, $note_id, $item_id);
					if($email_challengers) {
						$this->cluster_note_email($item_id, $_POST);
					}
				}
				else {
					$data['message'] = "We're sorry, there has been a problem processing your request.";
				}
			}
			else {
			
				if($this->MItems->update('notes', $note_id, $_POST)) {
					$data['message'] = 'Update Successful';
					$this->MItems->updateNoteActivity($note_id, $item_id, $type);
				
				}
				else {
				
					$data['message'] = 'Update Failed';
				}
			}
					
			$el = $this->MItems->get($item_type.'s', array('item_id'=>$item_id))->row();
			redirect($item_type.'/view/'.$el->id, 'refresh');
		}
		else {
			redirect('site', 'refresh');
		}			
	}
	
	function cluster_note_email($item_id, $note) {

		$cluster_id = $this->MItems->get_id($item_id);
		$cluster = $this->MItems->getCluster($cluster_id);
		
		if($cluster->num_rows()) {
			$cluster = $cluster->row_array();
			// Get the challengers for the cluster
			$challenges = $this->MItems->getChallenge(array('cluster_id'=>$cluster_id));
		
			if($challenges->num_rows()) {
				foreach($challenges->result() as $c) {
					$user = $this->MItems->getUser($c->user_id);
					if($user->num_rows()) {
						$this->beex_email->generate_cluster_note_email($user->row()->email, array('cluster'=>$cluster, 'message'=>$note['note'], 'note_title'=>$note['title']));
						//report_error('Emailed to '.$user->row()->email);
					}
				}
			}
		}
	}
	
}

?>