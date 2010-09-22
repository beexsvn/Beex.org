<?php

class MUser extends Model {
	
	function MUser() {
		parent::Model();
		$this->load->library('session');
		$this->load->library('facebook', array(
		  'appId' => $this->config->item('facebook_api_key'),
		  'secret' => $this->config->item('facebook_secret_key'),
		  'cookie' => true,
		));
	}
	
	function checkUsername($username){
		
		$result = $this->db->get_where('users', array('email' => $username));
		
		if($result->num_rows()) {
			$row = $result->row();
			if($row->official)
				return true;
			else {
				$this->MItems->delete('users', $row->id);
				$this->MItems->delete('profiles', $row->id, 'user_id');
			}
		}
		return false;
	}
	
	function deleteTags($npo_id) {
		$this->db->delete('causetags', array('npo_id'=>$npo_id));
	}
	
	function getTags($npo_id) {
		$result = $this->db->get_where('causetags', array('npo_id'=>$npo_id));
		if($result->num_rows()) {
			return $result->result();
		}
	}
	
	function isOfficial($id) {
		
		$result = $this->db->get_where('users', array('id'=>$id));
		
		if($result->num_rows()) {
			return ($result->row()->official) ? true : false;
		}
		else {
			// User does not exist	
		}
	}
	
	function verify_code($user_id, $code) {
		$result = $this->db->get_where('users', array('id'=>$user_id, 'code'=>$code));
		
		return ($result->num_rows()) ? true : false;
	}
	
	function process_user($email = '', $password = '') {
		if($this->session->userdata('logged_id')) {
			return $this->session->userdata['user_id'];	
		}
		else {
			return $this->MUser->login($email, $password);	
		}
	}
	
	function validate_user($email, $password) {
		
		if($result = $this->db->get_where('users', array('email'=>$email, 'password'=>md5($password)))){
			//echo $this->db->last_query();
			if($result->num_rows()) {
				return $result;
			}
			else {
				return false;	
			}
		}
	}
	
	function validate_fb($uid) {
		if($result = $this->db->get_where('users', array('fb_user'=>$uid))){
			if($result->num_rows()) {
				return $result;
			}
			else {
				return false;	
			}
		}		
	}
	
	// Get FB: Get the users Facebook ID
	function get_fb($id) {
		if($result = $this->MItems->getUser($id)) {
			if($result->num_rows()) {
				if($fb_id = $result->row()->fb_user) {
					return $fb_id;
				}
			}
		}
		
		//If user isn't FB connect check if they are logged into facebook
		$session = $this->facebook->getSession();
			
		$me = null;
		// Session based API call.
		if ($session) {
		
		  try {
		    $uid = $this->facebook->getUser();
		    $me = $this->facebook->api('/me');
			return $me['id'];
		  } catch (FacebookApiException $e) {
		    //error_log($e);
		  }
		}
				
		return '';
	}
	
	function part_of_cluster($id, $cluster_id) {
		
		$result = $this->MItems->getChallenge(array('challenges.user_id'=>$id, 'challenges.cluster_id'=>$cluster_id));
		
		return ($result->num_rows()) ? true : false;
		
	}
	
	function set_usersession($id, $email) {
		
		$userdata = array('logged_in'=>true, 'user_id'=>$id, 'username'=>$email);
		if($email == 'zkilgore@gmail.com' ||  $email == 'devin@beex.org' || $email == 'devinbalkind@gmail.com' || $email == 'matt@beex.org') {
			$userdata['super_user'] = true;	
		}
		else {
			$userdata['super_user'] = false;
		}
		$this->session->set_userdata($userdata);
		
	}
	
	function login($email, $password, $retval = 'id') {
		
		if($result = $this->validate_user($email, $password)) {
			$user = $result->row();
			$this->set_usersession($user->id, $user->email);
			return $user->$retval;
		}
		else {
			return false;		
		}
		
	}
	
	function get_user_by_email($email) {
		
		$result = $this->db->get_where('users', array('email'=>$email));
		
		if($result->num_rows()) {
			
			$user = $result->row();
			return $user->id;
		}
		else {
			return false;
		}
		
	}
	
	function add_user($data) {
		// Adds a user and profile to DB, sends a registration email, logs them in.
		$user_id = $this->MItems->add('users', array('email' => trim($data['signup_email']), 'password' => md5($data['signup_pass']), 'official'=>'1', 'created' => date('Y-m-d H:i:s')));
		
		$this->MItems->add('profiles', array('user_id'=>$user_id, 'first_name'=>$data['signup_name']));
		
		beex_mail($data['signup_email'], 'registration');
		
		$this->login($data['signup_email'], $data['signup_pass']);	
		
		return $user_id;
	}
	
	function update_user($id, $data) {
		// Adds a user and profile to DB, sends a registration email, logs them in.
		$this->MItems->update('users', $id, array('password' => md5($data['signup_pass']), 'official'=>'1', 'created' => date('Y-m-d H:i:s')));
		
		$this->MItems->update('profiles', array('user_id'=>$id), array('first_name'=>$data['signup_name']));
		
		beex_mail($data['signup_email'], 'registration');
		
		$this->login($data['signup_email'], $data['signup_pass']);	
	}
	
	
	
	function process_new_user($data, &$error) {
		
		if(element('signup_pass', $data) == element('signup_passconf', $data)) {
			
			$user = $this->MItems->get('users', $data['email'], 'email');
			
			if($user->num_rows()) {
				
				$id = $user->row()->id;
				
				if($this->isOfficial($id)) {
					$error = "That email has already been registered and is in use. If you have forgotten your password please ".anchor('user/forgot', 'click here')." to retrieve it.";
				}
				else {
					$this->update_user($id, $data);
					return $id;
				}
			}
			else {	
				return $this->add_user($data);	
			}
		}
		else { 
			$error = "You're passwords do not match. Please try again";
		}
	}
}

?>