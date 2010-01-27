<?php

class MUser extends Model {
	
	function MUser() {
		parent::Model();
		$this->load->library('session');
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
	
	function login($email, $password, $retval = 'id') {
		
		if($result = $this->validate_user($email, $password)) {
			$user = $result->row();
			$userdata = array('logged_in'=>true, 'user_id'=>$user->id, 'username'=>$user->email);
			$this->session->set_userdata($userdata);
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
		
		if($data['signup_pass'] == $data['signup_passconf']) {
			
			$user = $this->MItems->get('users', $data['signup_email'], 'email');
			
			if($user->num_rows()) {
				
				$id = $user->row()->id;
				
				if($this->isOfficial($id)) {
					$error = "That email has already been registered and is in use";
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