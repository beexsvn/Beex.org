<?php

class Ajax extends Controller { 
	
	function Ajax() {
		parent::Controller();
		
		$this->load->model('MItems');
		$this->data['header']['title'] = 'challenge';
		$this->data['data']['message'] = '';
		$this->data['data']['item'] = '';
	}
		
	function process_challenge() {
		
		$edit_id = $this->session->userdata('edit_id');
		
		$challenge_info_post = $_POST;
		foreach($challenge_info_post as $key=>$val) {
			$challenge_info[$key] = $val;
		}
		
		//Process image
		if($image_name = $this->session->userdata('challenge_image')) {
			if($image_name == 'NULL' && $edit_id) {
				$this->db->update('challenges', array('challenge_image' => ''), array('id'=>$edit_id));
			}
			elseif($image_name == 'NULL') {
				$challenge_info['challenge_image'] = NULL;				
			}
			else {
				$challenge_info['challenge_image'] = $image_name;
			}
		}
		
		$this->session->unset_userdata('challenge_image');
		
		//$this->session->set_userdata("challenge_info", $challenge_info);
//		$this->session->unsetset_userdata("challenge_creation_step");// wtf? buggy
		
		//Store this for later
		$this->session->set_userdata("modified_challenge", $challenge_info);
		
		$_POST = $challenge_info;
		//print_r($_POST);
		
		
		
		//Clear session variable
		$this->session->unset_userdata('challenge_info');
		
		if(!$edit_id) {
			$_POST['created'] = date("Y-m-d H:i:s");
		}
				
		$_POST['user_id'] = $this->session->userdata('user_id');
	
		
		// Process Teammate 
		if(isset($_POST['partner_bool']) && $_POST['partner_bool'] == 'yes') {
			$teammate = array('name'=>@$_POST['partner_name'], 'email'=>$_POST['partner_email']);
		}

 
		// these fields do not yet exist in the db...
		
		unset($_POST['partner_bool']);
		unset($_POST['partner_name']);
		unset($_POST['partner_email']);
		
		// Process Special Fields
		$_POST['challenge_completion'] = ($this->input->post('challenge_completion')) ? date('Y-m-d', strtotime($_POST['challenge_completion'])) : '';
		$_POST['challenge_fr_completed'] = ($this->input->post('challenge_fr_completed')) ? date('Y-m-d', strtotime($_POST['challenge_fr_completed'])) : '';
		$_POST['challenge_proof_upload'] = ($this->input->post('challenge_proof_upload')) ? date('Y-m-d', strtotime($_POST['challenge_proof_upload'])) : '';
		
		
		if(!$edit_id || true) {		
			foreach($_POST as $key => $val) {
				if(!$val) {
					if($edit_id) :  $_POST[$key] = NULL; else : unset($_POST[$key]); endif;	
				}
			}
		}

		
		if(isset($edit_id) && $edit_id != '') {

			unset($_POST['user_id']);
			
			$this->MItems->update('challenges', $edit_id, $_POST);
			if(isset($challenge_info['challenge_image']) && $challenge_info['challenge_image']) {
				$this->beex_image->process_media('media/challenges/', $challenge_info['challenge_image'], 'media/challenges/'.$edit_id.'/');
				$this->session->unset_userdata('challenge_image');
			}
			$ret['challenge_id'] = $edit_id;
			$ret['success'] = true;
			$this->session->unset_userdata('edit_id');
			echo json_encode($ret);
			return;

		}
		elseif($challenge_id = $this->MItems->add('challenges', $_POST)) {
			
			$new_item_id = $this->MItems->process_new_item($challenge_id, 'challenge', $_POST['created']);
			
			$data['message'] = $_POST['challenge_title']." has successfully been created.";
			$this->MItems->add('teammates', array('user_id'=>$_POST['user_id'], 'challenge_id'=>$challenge_id));
			if(isset($teammate)) {
				$this->add_teammate($teammate, array('id'=>$challenge_id, 'name'=>$_POST['challenge_title']));
			}
			
			$this->beex_email->generate_new_challenge_email($_POST['user_id'], array('id'=>$challenge_id));
			
			$ret['challenge_image'] = '';
			if(isset($challenge_info['challenge_image']) && $challenge_info['challenge_image']) {
				$this->beex_image->process_media('media/challenges/', $challenge_info['challenge_image'], 'media/challenges/'.$challenge_id.'/');
				$ret['challenge_image'] = $challenge_info['challenge_image'];
				$this->session->unset_userdata('challenge_image');
			}
			
			/* Add Cluster Activity */
			if(isset($_POST['cluster_id'])) {
				
				$this->MItems->addActivity('join', $challenge_id, $new_item_id);
			}
			
			$ret['challenge_id'] = $challenge_id;			
		}
		else {
			$data['message'] = "We're sorry, there has been a problem processing your request.";

		}

		$data['data']['new'] = true;
		$ret['success'] = true;
		echo json_encode($ret);
		return;		
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
		
		$this->beex_email->generate_new_challenge_email($user_id, array('id'=>$challenge['id']), true);

	}
	
	/* Reset Image: Function that resets the start challenge/cluster images */
	function reset_image() {
		
		//Reset the session variable that stores the val
		$this->session->set_userdata($_POST['type'], 'NULL');
		$ret['success'] = true;
		echo json_encode($ret);
		return;
		
	}
	
	/* New Ajax Upload: Function for file uploading for any item creation on site */
	function new_ajax_upload($for = 'challenges', $fromcluster = false, $update = false) {
		
		
		$filename = 'uploadfile';
		$foldername = $for;
				
		$filesize_image = $_FILES[$filename]['size'];
		
		if($filesize_image > 4000000) {
			
			$ret['success'] = false;
			$ret['error'] = "The file is too big to upload";
			
		}
		elseif((strpos($_FILES[$filename]['type'], 'image') !== FALSE) && $filesize_image > 0) {
			
			// Check for the special case of cluster_ch
			if($foldername == 'cluster_ch') {
				$foldername = 'cluster';
				$fromcluster = true;
			}
			
			//Add an 's' to the folder name as thats the way it's coming in
			$foldername .= 's';
			
			// Use the Beex library function do_upload to process the file to the server and get the appropriate return data
			$upload_result = $this->beex->do_upload($_FILES, $filename, './media/'. $foldername .'/');
			$upload_filepath = base_url() . 'media/'.$foldername.'/' . $upload_result;
			$upload_metadata = $this->upload->data();

			$width = $upload_metadata['image_width'];
			$height = $upload_metadata['image_height'];
			
			if($foldername == 'challenges') {		
				
				$this->beex_image->process_media('media/challenges/', $upload_result, 'media/challenges/', 310, 222, true);	
				$this->session->set_userdata("challenge_image", $upload_result);
				$result = base_url().'media/challenges/sized_'.$upload_result;
				$ret['start'] = true;
						
			}
			elseif($foldername == 'clusters') {
				$this->beex_image->process_media('media/'.$foldername.'/', $upload_result, 'media/'.$foldername.'/', 310, 222, true);				
				if(!$fromcluster) {
					$this->session->set_userdata("cluster_image", $upload_result);
				}
				else {
					$this->session->set_userdata("cluster_ch_image", $upload_result);
				}
				
				$result = base_url().'media/'.$foldername.'/sized_'.$upload_result;
				$ret['start'] = true;
			}
			elseif($foldername == 'profiles') {
				if($update) {
					$this->beex_image->process_media('media/profiles/', $upload_result, 'media/profiles/'.$update.'/', 300, 300, true);
					$this->beex_image->crop_square('media/profiles/', $upload_result, 'media/profiles/'.$update.'/', 120);
					$this->MItems->update('profiles', array('user_id'=>$update), array('profile_pic'=>$upload_result));
					$result = base_url().'media/profiles/'.$update.'/sized_'.$upload_result;
					$ret['short_name'] = "sized_".$upload_result;
				}
				else {
					$this->beex_image->crop_square('media/profiles/', $upload_result, 'media/profiles/', 134);
					$this->session->set_userdata('profile_picture', $upload_result);
					$result = base_url().'media/profiles/cropped134_'.$upload_result;
				}
				
				$ret['start'] = false;
				
			}
				
			elseif($foldername == 'npos') {
				$this->beex_image->crop_square('media/npos/', $upload_result, 'media/npos/', 134);
				$this->session->set_userdata('npo_logo', $upload_result);
				$result = base_url().'media/npos/cropped134_'.$upload_result;
				$ret['start'] = false;
			}
					
			$ret['file'] = $result;
			$ret['success'] = true;
			
			
		}
		else {
			
			$ret['success'] = false;
			$ret['error'] = "There has been a problem with your upload";
			
		}
		
		echo json_encode($ret);
		
	}
	
	
	/* Login User: Function for processing logins with javascript */
	function login_user() {
		
		// Try to log in the user	
		if($result = $this->MUser->validate_user($_POST['email'], $_POST['password'])) {
		
			$user = $result->row();
			if($user->official) {
				$userdata = array('logged_in'=>true, 'user_id'=>$user->id, 'username'=>$user->email);
				if($_POST['email'] == 'zkilgore@gmail.com' || $_POST['email'] == 'devinbalkind@gmail.com' || $_POST['email'] == 'devin@beex.org' || $_POST['email'] == 'matt@beex.org') {
					$userdata['super_user'] = true;	
				}
				$this->session->set_userdata($userdata);
				//$this->MItems->update('users', array('id'=>$user->id), array('official'=>'1'));
				
				// User exists and is logged in
				echo json_encode(array('success'=>true));
			}
			
			else {
				// User exists but is not official yet, set up javascript to redirect to enter code page
				echo json_encode(array('success'=>false, 'nocode'=>$user->id));
			}
						
		}

		else {
			// User could not be logged in. Either doesn't exitst or incorrect information
			echo json_encode(array('success'=>false, 'errors' => 'There was a problem with your information. Please try again.'));
		}
		
	}

	/* Create User: Function to create a user when that user is starting a challenge/cluster */
	function create_user() {
		
		// Make sure that name is set and if is set up the profile info
		if(isset($_POST['legal_name'])) {
			$full_name = $_POST['legal_name'];
			$full_name_words = split(' ', $full_name);
			$profile['last_name'] = array_pop($full_name_words);  
			$profile['first_name'] = join(' ', $full_name_words);			
		}

		// Set up user array to add to the database
		$user['created'] = date("Y-m-d H:i:s");
		$user['email'] = $_POST['email'];
		$user['password'] = md5($_POST['password']);
		$user['official'] = 1;
		
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email|callback_username_check');
		if ($this->form_validation->run() == FALSE) {
			$this->form_validation->set_error_delimiters('', '<br />');
			echo json_encode(array('success'=>false, 'errors' => validation_errors()));
			return;
		}
		else {
			$id = $this->MItems->add('users', $user);
			
			
			$profile['created'] = $user['created'];
			$profile['user_id'] = $id;
			$this->MItems->add('profiles', $profile);
			
			$userdata = array('logged_in'=>true, 'user_id'=>$id, 'username'=>$_POST['email'], 'challenge_creation_step'=> 'what');		
			$this->session->set_userdata($userdata);
			echo json_encode(array('success'=>true));
		}
		
		
	}
	
	// Username Check: Callback function for username creation
	function username_check($str)
	{
		if ($this->MUser->checkUsername($str))
		{
			$this->form_validation->set_message('username_check', 'This email is already in the system');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	// Delete Note: Function for deleting a note 
	function delete_note($id) {
		
		$this->MItems->delete('notes', $id);
		
	}
	
	// Delete Proof: Function for deleting a proof
	function delete_proof($id) {
		
		$this->MItems->delete('media', $id);
	
	}
	
	// Delete Note Reply: Function for deleting a note reply
	function delete_note_reply($id) {
		
		$this->MItems->delete('note_replies', $id);
		
	}
	
	function jcrop_image() {
		
		$path = $this->input->post('path');
		$image = $this->input->post('image');
		$new_image = substr($this->input->post('image'), 6);
		
		$this->load->library('imagemanipulation', array('img'=>'./'.$path.$image), 'image');
		
		$this->image;
		
		if($this->image->imageok) {
		    $this->image->setJpegQuality('100');
		    $this->image->setCrop($this->input->post('x'), $this->input->post('y'), $this->input->post('w'), $this->input->post('h'));
		    $this->image->resize('120');
		    $this->image->save('./'.$path.'cropped120_'.$new_image);
		
			echo $path.'cropped120_'.$image;
		} else {
		   //Throw error as there was a problem loading the image
		}
		
	}
}

?>