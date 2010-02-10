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
		
		$data['browser'] = $browser;
		$data['header']['title'] = "Challenges";
		
		$this->load->view('challenges', $data);
		
		
	} 
	
	function editor($eid = '', $etype = '', $iid = '', $itype = '', $message = '') {
		
		if($id = ($iid) ? $iid : $this->uri->segment(3)) {
			
			if($this->madmins->verifyUser($this->session->userdata('user_id'),$id, 'challenge')) {
			
				$data = $this->data;
			
				$type = ($itype) ? $itype : ((is_numeric($etype)) ? 'default' : $etype);
				
				switch($type) {
				
					case 'edit':
						$data['data']['item'] = $this->MItems->getChallenge($id);
						$data['data']['new'] = false;
						$data['data']['edit'] = true;
						
						break;
				
					case 'teammates':
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
			
				echo "Not allowed here";
				//Not allowed to view this
			
			}
		}
	}
	
	function view() {
		$this->load->library('gallery');
		
		$data = $this->data;
		
		$id = $this->uri->segment(3,0);
		
		$item = $this->MItems->getChallenge($id);
		
		$data['item'] = $item->row();
		
		$profile = $this->MItems->get('profiles', $data['item']->user_id, 'user_id');
		
		$data['activityfeed'] = $this->beex->processActivityFeed('challenge', $data['item']->id, $profile->row());
		
		$gallery = $this->MItems->getGallery($data['item'], 'challenge');
		@$data['media'] = $this->MItems->get('media', $gallery->id, 'gallery_id');
		if(!$video = $data['item']->challenge_video) {
			@$video = $this->MItems->getVideo($gallery->id);
			@$video = $video->link;
		}
		
		$proof = $this->MItems->getGallery($data['item'], 'challenge', 'proof');
		
		$data['notes'] = $this->MItems->getNotes($id);
		
		$data['gallery_id'] = ($gallery) ? $gallery->id : '';
		$data['proof_id'] = ($proof) ? $proof->id : '';
		$data['video'] = $video;
		$data['profile'] = $profile->row();
		$data['sponsor'] = 'Test Sponsor';
		$data['header']['title'] = "BEEx.org Challenge - ".$data['item']->challenge_title;
		$data['owner'] = $this->madmins->verifyUser($this->session->userdata('user_id'), $id, 'challenge');
		
		
		$this->load->view('challenge', $data);
	}
	
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
	
	function start_a_challenge() {
		$data = $this->data;
		$data['header']['title'] = 'Start a challenge';
		$data['data']['item'] = '';
		$data['data']['new'] = true;
		$this->load->view('start_a_challenge', $data);	
	}
	
	function edit_a_challenge() {
		$id = $this->uri->segment(3);
		$data = $this->data;
		$data['header']['title'] = 'Edit a challenge';
		$data['data']['item'] = $this->MItems->getChallenge($id, 'challenges.id');
		$data['data']['edit'] = true;
		$data['data']['new'] = false;
		$this->load->view('edit_a_challenge', $data);	
	}
	
	function addUpdate() {
		
		
		
	}
	
	function process_user($email = '', $password = '') {
		if($this->session->userdata('logged_id')) {
			return $this->session->userdata['user_id'];	
		}
		else {
			return $this->MUser->login($email, $password);	
		}
	}
	
	function blurb_check($str) {
		
		if(strlen($str) > 120) {
			$this->form_validation->set_message('blurb_check', 'The blurb is longer then 120 characters');
			return false;
		}
		else {
			return true;	
		}
	}
	
	function goal_check($str) {
		
		if(!is_numeric($str)) {
			$this->form_validation->set_message('goal_check', 'The goal is not a valid number');
			return false;
		}
		else return true;
	}
	
	function cluster_check($str) {
		
		if(!($this->MItems->getCluster($str)->num_rows() > 0)) {
			$this->form_validation->set_message('cluster_check', 'The Cluster Code is not valid');
			return false;
		}
		else return true;
	}
							   
	
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
	
	function generate_password ($length = 8)
	{

	  // start with a blank password
	  $password = "";

	  // define possible characters
	  $possible = "0123456789bcdfghjkmnpqrstvwxyz"; 

	  // set up a counter
	  $i = 0; 

	  // add random characters to $password until $length is reached
	  while ($i < $length) { 

	    // pick a random character from the possible ones
	    $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);

	    // we don't want this character if it's already in the password
	    if (!strstr($password, $char)) { 
	      $password .= $char;
	      $i++;
	    }

	  }

	  // done!
	  return $password;

	}
	
	function add_teammates() {
		$id = $this->uri->segment(3);
		
		$challenge = $this->MItems->getChallenge($id)->row();
		
		if($_POST['email']) {
			$this->add_teammate($_POST, array('id'=>$challenge->id, 'title'=>$challenge->challenge_title));
		}
		
	 	$this->editor('', '', $id, 'teammates', 'Teammmate has been successfully invited');
	}
	
	function add_teammate($teammate, $challenge) {

		$item = array();

		if(!($user_id = $this->MUser->get_user_by_email($teammate['email']))) {
				
				$password = $this->generate_password();
				
				$user_id = $this->MItems->add('users', array('email'=>$teammate['email'], 'password'=>md5($password), 'created' => date('Y-m-d H:i:s'), 'official' => 0));
				$this->MItems->add('profiles', array('user_id'=>$user_id, 'first_name'=>$teammate['name'], 'last_name' => ' ', 'created' => date("Y-m-d H:i:s")));
				
				$item['password'] = $password;

		}

		$this->MItems->add('teammates', array('user_id'=>$user_id, 'challenge_id'=>$challenge['id']));
		$item['message'] = '';
		$item['name'] = $teammate['name'];
		$item['challenge'] = $challenge;
		
		beex_mail($teammate['email'], 'teammate', 'folks@beex.org', $item);

	}
	
	function add_note() {
		
		$data = $this->data;
		
		$challenge_id = $this->uri->segment(3);
		$note_id = $this->uri->segment(4, 'add');
		
		//Process special fields
		$_POST['created'] = date("Y-m-d H:i:s");
		$_POST['challenge_id'] = $challenge_id;
		
		
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
				$this->MItems->addActivity('note', $note_id, 'challenge', $challenge_id);
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
		redirect('challenge/view/'.$challenge_id, 'refresh');
		
	}
	
	
	function add_reply() {
		
		$data = $this->data;

		$challenge_id = $this->uri->segment(3);
		$note_id = $this->uri->segment(4);

		//Process special fields
		$_POST['created'] = date("Y-m-d H:i:s");
		$_POST['note_id'] = $note_id;

		//Get rid of empty values
		foreach($_POST as $key => $val) {
			if(!$val) { 
				unset($_POST[$key]);	
			}
		}

		if('add' == 'add') {
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
		redirect('challenge/view/'.$challenge_id, 'refresh');
	
	}
	
}
?>