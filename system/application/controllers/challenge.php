<?php

class challenge extends Controller { 
	
	public $data;
	public $table_name;	
	
	function challenge() {
		parent::Controller();
		
		$this->load->model('MItems');
		$this->load->library('beex');
		$this->data['header']['title'] = 'Challenge';
		$this->data['data']['message'] = '';
		$this->data['data']['item'] = '';
		$this->data['data']['username'] = $this->session->userdata('username');
		$this->data['data']['user_id'] = $this->session->userdata('user_id');
		$this->table_name = 'challenges';
	}
	
	function index() {
		
		$data = $this->data;
		
		$browser = $this->MItems->getChallenge('', '', '', '', 5);
		
		$data['featured'] = $this->MItems->getChallenge(array('featured'=>'1'), '', '', '', 5);
		
		$data['browser'] = $browser;
		$data['header']['title'] = "Challenges";
		
		$this->load->view('challenges', $data);
		
		
	} 
	
	/* Function for setting up different editor pages (Challenge editor, Adding Teammates, etc) */
	
	function editor($eid = '', $etype = '', $iid = '', $itype = '', $message = '') {
		
		if($id = ($iid) ? $iid : $this->uri->segment(3)) {
			
			// Make sure user owns challenges
			if($this->madmins->verifyUser($this->session->userdata('user_id'),$id, 'challenge')) {
			
				$data = $this->data;
			
				$type = ($itype) ? $itype : ((is_numeric($etype)) ? 'default' : $etype);
				
				switch($type) {
				
					case 'edit':
						$data['data']['item'] = $this->MItems->getChallenge($id);
						$data['data']['new'] = false;
						$data['data']['edit'] = true;
						if(isset($data['data']['item']->row()->cluster_id) && $c_id = $data['data']['item']->row()->cluster_id) {
							$data['data']['cluster'] = $this->MItems->getCluster($c_id)->row();
						}
						$data['data']['join'] = false;
						
						break;
				
					case 'teammates':
						$data['data']['teammates'] = $this->MItems->getTeammates($id);
						$data['data']['item'] = $this->MItems->getChallenge($id)->row();
						break;
						
					default: 
						break;
					
				}
				
				$data['data']['message'] = ($message) ? $message : '';
				$data['type'] = $type;
				$data['id'] = $id;

				
				$this->load->view('challenge_editor', $data);
				
			
			}
		
			else {
			
				$this->view($id);
				//Not allowed to view this
			
			}
		}
	}
	
	/* Delete: Sets up the view asking if user wants to remove the challenge */
	function delete() {
		$id = $this->uri->segment(3);
		
		// Verify that the user owns the challenge
		if($this->madmins->verifyUser($this->session->userdata('user_id'), $id, 'challenge')) {
			$data = $this->data;
			$data['id'] = $id;
			$this->load->view('challenge_delete', $data);
		}
		else {
			$this->view();
		}
	}
	
	/* Challenge Delete: Deletes the challenge */
	function challenge_delete() {
		$id = $this->uri->segment(3);
		
		// Verify that the user owns the challenge they are deleting
		if($this->madmins->verifyUser($this->session->userdata('user_id'), $id, 'challenge')) {
			$this->MItems->delete("challenges", $id);
			redirect('user/view/'.$this->session->userdata('user_id'), 'refresh');
		}
		else {
			$this->view();
		}
	}
	
	
	/* Set up the challenge page view */
	function view() {
		
		/* Plus 1 to the page count */
		$this->mstat->addStat();
		
		
		$data = $this->data;
		
		$id = $this->uri->segment(3,0);
		
		$item = $this->MItems->getChallenge($id);
		
		if($item->num_rows()) {
			$data['item'] = $item->row();
			
			/* Get challenge owners profile data */
			$profile = $this->MItems->get('profiles', $data['item']->user_id, 'user_id');
			
			/* Set the data to pass to the view */
			$data['activityfeed'] = $this->beex->processActivityFeed('challenge', $data['item']->item_id, $profile->row());
			$data['profile'] = $profile->row();
			$data['header']['title'] = "BEEx.org Challenge - ".$data['item']->challenge_title;
			$data['owner'] = $this->madmins->verifyUser($this->session->userdata('user_id'), $id, 'challenge');
			
			
			$this->load->view('challenge', $data);
		}
		else {
			$this->load->view('framework/error', $data);
		}
	}
	
	/* Start A Challenge: Fucntion to set up the view for starting a challenge */
	function start_a_challenge() {
		
		$vars = $this->uri->uri_to_assoc();
		
		if(element('from_widget', $vars)) {
			if($cd = $this->session->userdata('temp_challenge_declaration')) {
				$_POST['challenge_declaration'] = $cd;
			}
			elseif($cd = $this->input->post('challenge_declaration')) {
				$this->session->set_userdata('temp_challenge_declaration', $cd);
			}
		}
		else {
			$this->session->set_userdata('temp_challenge_declaration', '');
		}
		
		$data = $this->data;
		$data['header']['title'] = 'Start a challenge';
		$data['data']['item'] = '';
		$data['data']['new'] = true;
		$data['data']['help_copy'] = "Reference the help editor below if you're confused by a field.";
		$data['data']['help_title'] = 'Start a Challenge';
		
		$this->session->set_userdata('edit_id', '');
		
		$this->load->view('start_a_challenge', $data);	
	}
	
	
	function add_teammates() {
		$id = $this->uri->segment(3);
		
		$challenge = $this->MItems->getChallenge($id)->row();
		
		$message = 'Please enter your teammates email';
		
		if($email = $this->input->post('email')) {
			
			if($this->MItems->isTeammate($this->MUser->get_user_by_email($email), $id)) {
				$message = 'This user is already a teammate for this challenge';
				
			}
			else {
				$this->add_teammate($_POST, array('id'=>$challenge->id, 'title'=>$challenge->challenge_title));
				$message = 'Teammmate has been successfully invited';
			}
		}
		
	 	$this->editor('', '', $id, 'teammates', $message);
	}
	
	function add_teammate($teammate, $challenge) {

		$item = array();

		if(!($user_id = $this->MUser->get_user_by_email($teammate['email']))) {
				
				$password = generate_password();
				
				$user_id = $this->MItems->add('users', array('email'=>$teammate['email'], 'password'=>md5($password), 'created' => date('Y-m-d H:i:s'), 'official' => 0));
				$this->MItems->add('profiles', array('user_id'=>$user_id, 'first_name'=>$teammate['name'], 'last_name' => ' ', 'created' => date("Y-m-d H:i:s")));
				
				$item['password'] = $password;

		}

		$this->MItems->add('teammates', array('user_id'=>$user_id, 'challenge_id'=>$challenge['id']));
		$item['personal'] = array('name' => $teammate['name']);
		$item['challenge'] = $challenge;
		
		
		//beex_mail($teammate['email'], 'teammate', 'folks@beex.org', $item);
		$this->beex_email->generate_teammate_invite_email($teammate['email'], $item);

	}
	
	// Add Note: Function that processes adding the note to a challenge */
	function add_note() {
		
		$data = $this->data;
		
		$item_id = $this->uri->segment(3);
		$note_id = $this->uri->segment(4, 'add');
		
		//Process special fields
		$_POST['created'] = date("Y-m-d H:i:s");
		$_POST['item_id'] = $item_id;
		
		unset($_POST['x'], $_POST['y']);
		
		
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
		
		if($note_id == 'add') {
			if($note_id = $this->MItems->add('notes', $_POST)) {
				$this->MItems->addActivity('note', $note_id, $item_id);
			}
			else {
				$data['message'] = "We're sorry, there has been a problem processing your request.";
			}
		}
		else {
			
			if($this->MItems->update('notes', $note_id, $_POST)) {
				$data['message'] = 'Update Successful';
			}
			else {
				
				$data['message'] = 'Update Failed';
			}
			
		}
		
		$challenge_id = $this->MItems->getChallenge(array('challenges.item_id'=>$item_id))->row()->id;
		
		redirect('challenge/view/'.$challenge_id, 'refresh');
		
	}
	
	/* Add Reply: Function that adds a reply to a note to the database */ 
	function add_reply() {
		
		
		
		$data = $this->data;

		$challenge_id = $this->uri->segment(3);
		$note_id = $this->uri->segment(4);

		/* Temporarily turn this function off 

		//Process special fields
		$_POST['created'] = date("Y-m-d H:i:s");
		$_POST['note_id'] = $note_id;

		//Get rid of empty values
		foreach($_POST as $key => $val) {
			if(!$val) {
				unset($_POST[$key]);	
			}
		}
		
		if($note_id == 'add') {
			if($reply_id = $this->MItems->add('note_replies', $_POST)) {
				$this->MItems->addActivity('reply', $reply_id, 'challenge', $challenge_id);
			}
			else {
				$data['message'] = "We're sorry, there has been a problem processing your request.";
			}
		}
		else {

			if($this->MItems->update('notes', $note_id, $_POST)) {
				$data['message'] = 'Update Successful';
			}
			else {

				$data['message'] = 'Update Failed';
			}

		}
		*/
		redirect('challenge/view/'.$challenge_id, 'refresh');
	
	}
	
	/* Edit a challenge: Function to set up the editing of a challenge. DEFUNCT */
	function edit_a_challenge() {
		$id = $this->uri->segment(3);
		$data = $this->data;
		$data['header']['title'] = 'Edit a challenge';
		$data['data']['item'] = $this->MItems->getChallenge($id, 'challenges.id');
		$data['data']['edit'] = true;
		$data['data']['new'] = false;
		$this->load->view('edit_a_challenge', $data);	
	}
	
	/* Blurb Check: Function to check length of blurb for form validation */
	function blurb_check($str) {
		
		if(strlen($str) > 120) {
			$this->form_validation->set_message('blurb_check', 'The blurb is longer then 120 characters');
			return false;
		}
		else {
			return true;	
		}
	}
	
	/* Goal Check: Function to validate that goal is a number */
	function goal_check($str) {
		
		if(!is_numeric($str)) {
			$this->form_validation->set_message('goal_check', 'The goal is not a valid number');
			return false;
		}
		else return true;
	}
	
	/* Cluster Check: Function to make sure that the cluster code the user enters is valid */
	function cluster_check($str) {
		
		if(!($this->MItems->getCluster($str)->num_rows() > 0)) {
			$this->form_validation->set_message('cluster_check', 'The Cluster Code is not valid');
			return false;
		}
		else return true;
	}
		
	/* DEFUNCT Process User: Get the user id for the challenge. */
	function process_user($email = '', $password = '') {
		if($this->session->userdata('logged_id')) {
			return $this->session->userdata['user_id'];	
		}
		else {
			return $this->MUser->login($email, $password);	
		}
	}
							   
	/* Process defunct, now challenges are add in controller Ajax.php */
	function process() {
		
		$data = $this->data;
		
		$id = $this->uri->segment(4,'add');
		
		$from_cluster = @$_POST['from_cluster'];
		unset($_POST['from_cluster']);
		
		if(!$from_cluster && @$_POST['cluster_id']) {
			$_POST['cluster_id'] = @$_POST['cluster_id']/3459;	
		}
		
		$new = '';
		if($id == 'add') {
			$new = true;	
		}
		
		$error = '';
		
		if($user_id = $this->session->userdata('user_id')) {
			$_POST['user_id'] = $user_id;
		}
		elseif(@$_POST['signup_email'] && !@$_POST['email']) {
			
			$_POST['user_id'] = $this->MUser->process_new_user($_POST, $error);
			
		}
		else {
			$_POST['user_id'] = $this->process_user(@$_POST['email'], @$_POST['password']);
		}
			
		if(!$_POST['user_id']) {
			
			$data['message'] = ($error) ? $error : "You could not be logged in, please try again.";
			$data['new'] = true;
		}
		else {
			
			$this->load->library('form_validation');
			/*
			if(!$this->session->userdata('logged_in')) {
				$this->form_validation->set_rules('email', 'User Email', 'trim|required');
				$this->form_validation->set_rules('password', 'User Password', 'trim|required');
			}
			*/
			
			// Required fields
			$this->form_validation->set_rules('challenge_title', 'Challenge Title', 'trim|required');
			$this->form_validation->set_rules('challenge_declaration', 'Challenge Declaration', 'trim|required');
			$this->form_validation->set_rules('challenge_goal', 'Challenge Goal', 'trim|required|callback_goal_check');
			$this->form_validation->set_rules('challenge_completion', 'Challenge Completion Date', 'trim|required');
					
			
			//Value fields
			$this->form_validation->set_rules('challenge_npo', 'NPO', 'trim');
			$this->form_validation->set_rules('challenge_sweetener_goal', 'Sweetener Goal', 'trim');
			$this->form_validation->set_rules('challenge_sweetener', 'challenge Sweetener', 'trim');
			$this->form_validation->set_rules('challenge_reserve_price', 'Reserve Price', 'trim');
			$this->form_validation->set_rules('challenge_fr_completed', 'Completed', 'trim');
			$this->form_validation->set_rules('challenge_proof_upload', 'Proof Date', 'trim');
			$this->form_validation->set_rules('challenge_address1', 'Address', 'trim');
			$this->form_validation->set_rules('challenge_address2', 'Address 2', 'trim');
			$this->form_validation->set_rules('challenge_city', 'City', 'trim');
			$this->form_validation->set_rules('challenge_state', 'State', 'trim');
			$this->form_validation->set_rules('challenge_zip', 'Zip', 'trim');
			$this->form_validation->set_rules('challenge_network', 'Network', 'trim');
			$this->form_validation->set_rules('challenge_attend', 'Attendance', 'trim');
			$this->form_validation->set_rules('challenge_blurb', 'Blurb', 'trim|callback_blurb_check');
			$this->form_validation->set_rules('challenge_description', 'Description', 'trim');
			$this->form_validation->set_rules('challenge_video', 'Video', 'trim');
			$this->form_validation->set_rules('challenge_whydo', 'Why Do', 'trim');
			$this->form_validation->set_rules('challenge_whycare', 'Why do you care?', 'trim');
			if(@$_POST['cluster_id']) {
				$this->form_validation->set_rules('cluster_id', 'Cluster Code', 'trim|callback_cluster_check');
			}
			$this->form_validation->set_rules('teammate_name', 'Teammate Name', 'trim');
			$this->form_validation->set_rules('teammate_email', 'Teammate Email', 'trim');
			
			if ($this->form_validation->run() == FALSE){
				$data['message'] = "Please fill out all the required fields.";
			}
			else {
						
				// Process Teammate 
				if(@$_POST['teammate_email']) {
					$teammate = array('name'=>@$_POST['teammate_name'], 'email'=>$_POST['teammate_email']);
					unset($_POST['teammate_email'], $_POST['teammate_name']);
				}
				
				// Process Special Fields
				$_POST['challenge_completion'] = ($_POST['challenge_completion']) ? date('Y-m-d', strtotime($_POST['challenge_completion'])) : '';
				$_POST['challenge_fr_completed'] = ($_POST['challenge_fr_completed']) ? date('Y-m-d', strtotime($_POST['challenge_fr_completed'])) : '';
				$_POST['challenge_proof_upload'] = ($_POST['challenge_proof_upload']) ? date('Y-m-d', strtotime($_POST['challenge_proof_upload'])) : '';
				
				if($new) {
					$_POST['created'] = date("Y-m-d H:i:s");
				}
				
				// Remove Login Fields
				unset($_POST['signup_email'], $_POST['signup_name'], $_POST['signup_pass'], $_POST['signup_passconf']);
				unset($_POST['email']);
				unset($_POST['password']);
				unset($_POST['x']);
				unset($_POST['y']);
				
				foreach($_POST as $key => $val) {
					if(!$val) {
						unset($_POST[$key]);	
					}
				}
				
				//Separate Images for later
				if($_FILES['challenge_image']['name']) {
					$_POST['challenge_image'] = $this->beex->do_upload($_FILES, 'challenge_image', './media/challenges/');					
				}
								
				if($id == 'add') {
					if($challenge_id = $this->MItems->add($this->table_name, $_POST)) {
						$data['message'] = $_POST['challenge_title']." has successfully been created.";
						$this->MItems->add('teammates', array('user_id'=>$_POST['user_id'], 'challenge_id'=>$challenge_id));
						if(@$teammate) {
							$this->add_teammate($teammate, array('id'=>$challenge_id, 'name'=>$_POST['challenge_title']));
						}
						redirect('challenge/view/'.$challenge_id, 'refresh');
					}
					else {
						$data['message'] = "We're sorry, there has been a problem processing your request.";
					}
					
				}
				else {
					
					unset($_POST['user_id']);

					if($this->MItems->update('challenges', $id, $_POST)) {
						
						$data['message'] = $_POST['challenge_title']." has successfully been updated.";
						redirect('challenge/view/'.$id, 'refresh');
					}
					else {
						$data['message'] = "We're sorry, there has been a problem processing your request.";
					}
					
					$data['data']['item'] = $this->MItems->getChallenge($id, 'challenges.id');
					$data['data']['edit'] = true;
					$data['data']['new'] = false;
					//$data['item'] = $item->row();
				
				}
			}
		}
		
		$data['data']['message'] = $data['message'];
		
		if($new) {
			if(@$from_cluster) {
								
				$item = $this->MItems->getCluster($_POST['cluster_id']);
				$data['item'] = $item->row();
				
				$user = $this->MItems->get('users', $data['item']->admin_email, 'email');
				$user = $user->row();
				
				$profile = $this->MItems->get('profiles', $user->id, 'user_id');
				
				//$data['activityfeed'] = $this->beex->processActivityFeed('challenge', $data['item']->id, $profile->row());
				
			
				
				$video = $data['item']->cluster_video;
				
				
				$data['video'] = $video;
				$data['profile'] = $profile->row();
				
				
				
				$this->load->view('join_cluster', $data);
			}
			else {
				
				$data['data']['new'] = true;
				
				$this->load->view('start_a_challenge', $data);	
			}
		}
		else {
			$data['data']['item'] = $this->MItems->getChallenge($id, 'challenges.id');
			$data['data']['edit'] = true;
			$data['data']['new'] = false;
			$this->load->view('edit_a_challenge', $data);
		}
	}
		
	
	/* Cluster Challnege now defunct */
	function cluster_challenge() {
		
		$data = $this->data;
		
		$id = $this->uri->segment(3,0);
				
		$item = $this->MItems->get('clusters', $id, 'id');
		$data['item'] = $item->row();
		
		$profile = $_POST['name'];
		
		$video = $data['item']->cluster_video;
		
		$data['notes'] = $this->MItems->getNotes('');
		
		$data['video'] = $video;
		$data['profile'] = $profile;
		$data['sponsor'] = 'JP Morgan Chase';
		$this->load->view('cluster_challenge', $data);	
	}
	
}
?>