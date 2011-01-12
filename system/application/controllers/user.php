<?php



class User extends Controller {



	public $data;

	public $table_name;



	function User() {

		parent::Controller();
		
		$this->load->model('MItems');
		$this->load->model('MUser');
		$this->load->model('MCaptcha');
		
		$this->data['header']['title'] = 'Users';
		$this->data['data']['message'] = '';
		$this->data['data']['item'] = '';
		$this->data['username'] = $this->session->userdata('username');
		$this->data['data']['user_id'] = $this->session->userdata('user_id');
		$this->table_name = 'users';
		
		$this->load->library('facebook', array(
		  'appId' => $this->config->item('facebook_api_key'),
		  'secret' => $this->config->item('facebook_secret_key'),
		  'cookie' => true,
		));

		$session = $this->facebook->getSession();

		$me = null;
		// Session based API call.
		if ($session) {
		  try {
		    $uid = $this->facebook->getUser();
		    $me = $this->facebook->api('/me');
			$this->data['me'] = $me;
		
		  } catch (FacebookApiException $e) {
		    error_log($e);
		  }
		}
		
	}



	function index() {

		$data = $this->data;

		$browser = $this->MItems->getUser();
		$data['browser'] = $browser;

		$data['header']['title'] = "People";

		if($id = $data['data']['user_id']) {
			$profile = $this->MItems->get('profiles', $id, 'user_id');
			$first_name = $profile->row()->first_name;
		}

		$data['username'] = (@$first_name) ? $first_name : $data['username'];

		$this->load->view('people', $data);

	}
	
	function entercode() {
		
		$user_id = $this->uri->segment(3);
		$code = $this->uri->segment(4);
		
		$data = $this->data;
		$data['user_id'] = $user_id;
		$data['message'] = '';
		if($user_id) {
			if($code || $code = @$_POST['code']) {
				if($this->MUser->verify_code($user_id, $code)) {
					$data['success'] = true;
					$data['message'] = "You have been succesfully verified. Would you like to start browsing ".anchor('challenge', 'challengers')." or ".anchor('cluster/', 'clusters').", or maybe just go to ".anchor('user/view/'.$user_id, 'your profile')."?";
					$this->MItems->update('users', array('id'=>$user_id), array('official'=>1));
					$userdata = array('logged_in'=>true, 'user_id'=>$user_id);
					
					$this->session->set_userdata($userdata);
				}
				else {
					$data['success'] = false;
					$data['message'] = "That code could not be verified. Please try again.";
				}
			}
			else {
				$data['success'] = false; 
			}
			
			$this->load->view('verifycode.php', $data);
			
		}
		else {
			$this->load->view('framework/error', $data);
		}
		
	}	



	function view() {

		$data = $this->data;

		$item = $this->MItems->get($this->table_name, $this->uri->segment(3, 0), 'id');

		if($item->num_rows()) {

			$data['item'] = $item->row();
			$data['user_id'] = $data['item']->id;
			$profile = $this->MItems->get('profiles', $data['item']->id, 'user_id');

			
			if($profile->num_rows() && $item->row()->official) {
				
				//$browser = $this->MItems->getChallenge($data['item']->id, 'challenges.user_id');
				$browser = $this->MItems->getChallengeByUser($data['item']->id, 'challenges.created', 'DESC');
				$data['clusters'] =  $this->MItems->getClustersByUser($data['item']->id);
				$data['browser'] = $browser;
				$data['owner'] = ($this->session->userdata('user_id') == $data['user_id']) ? true : false;
				$data['profile'] = $profile->row();
				$data['sponsor'] = 'Test Sponsor';				
				
				$this->load->view('user', $data);

			}
			elseif(!$item->row()->official) {
				$data['header']['title'] = 'User does not exist';
				$this->load->view('framework/error', $data);
			}
			else {
				$this->edit(true);
			}

		}
		else {
			// No profile for that id
			$this->load->view('framework/error.php', $data);
		}
	}



	function edit($must = false) {

		$id = $this->uri->segment(3);

		if(($this->session->userdata('user_id') == $id && $id) || $this->session->userdata('super_user')) {
			
			$data = $this->data;	
			$data['header']['title'] = 'Edit Your Profile';
			$data['data']['item'] = $this->MItems->getUser($id, 'id');	
			$data['data']['edit'] = true;	
			$data['data']['new'] = false;	
			$data['data']['id'] = $id;
			if(isset($me)) $data['data']['me'] = $me;
			//$data['data']['message'] = ($must) ? 'You must enter some profile information before we can continue. We just need your first and last name really, but why don\'t you load up a picture and stay a while!' : '';
	
			$this->load->view('edit_user', $data);
		}
		else {
			redirect('user/login', 'refresh');	
		}
	
	}
	
	function is_valid_email($email) {
		$user = $this->MItems->get('users', $email, 'email');
		return ($user->num_rows()) ? $user->row() : false;
	}
	
	function add_reset($user) {
		$code = generate_password();
		$id = $this->MItems->add('forgottenpasswords', array('user_id'=>$user->id, 'code'=>$code));
		return array('id'=>$id, 'code'=>$code);	
	}
	
	function forgot() {
		
		$data = $this->data;
		$data['header']['title'] = "Forgot Your Password?";
		$data['message'] = '';
		if(isset($_POST['email'])) {
		
			if($user = $this->is_valid_email($_POST['email'])) {
				
				$code = $this->add_reset($user);
				$this->beex_email->generate_temppass_email($_POST['email'], $code);
				
				$data['message'] = 'An email has been sent to the address on file. Click the link or copy and paste the link into a browser to access the reset password screen.';
				$data['sent'] = true;
			}
			else {
				$data['message'] = "Please enter a valid BEEx.org email address.";
			}
		}
		
		$this->load->view("forgotpassword", $data);
		
	}
	
	function valid_reset($id, $code) {
		$reset = $this->MItems->get('forgottenpasswords', array('id'=>$id, 'code'=>$code));
		return($reset->num_rows()) ? $reset->row() : '';
	}
	
	function resetpassword($reset_id, $code) {
		
		$data = $this->data;
		$data['header']['title'] = "Reset Your Password?";
		$data['message'] = '';
		$data['reset_id'] = $reset_id;
		$data['code'] = $code;
		if($reset = $this->valid_reset($reset_id, $code)) {
			if(isset($_POST['password']) && $_POST['password']) {
				if($_POST['password'] != $_POST['password_conf']) {
					$data['message'] = "Your passwords did not match. Please make sure you are typing in the password you want.";							   
				}
				else {
					
					$this->MItems->update('users', $reset->user_id, array('password' => md5($_POST['password'])));
					
					$data['message'] = 'Your password has been reset. Click '.anchor('user/login', 'here').' to login.';
					$data['sent'] = true;
				}
			}
		}
		else {
			$data['message'] = "You have reached this page in error. You are using an invalid reset code.";	
		}
		$this->load->view('resetpassword', $data);
		
	}

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

	function login() {
		
		$this->load->library('facebook', array(
		  'appId' => $this->config->item('facebook_api_key'),
		  'secret' => $this->config->item('facebook_secret_key'),
		  'cookie' => true,
		));
		
		$session = $this->facebook->getSession();
		
		$me = null;
		// Session based API call.
		if ($session) {
		  try {
		    $uid = $this->facebook->getUser();
		    $me = $this->facebook->api('/me');
		  } catch (FacebookApiException $e) {
		    error_log($e);
		  }
		}
		
		if ($me) {
		  $logoutUrl = $this->facebook->getLogoutUrl();
		} else {
		  $loginUrl = $this->facebook->getLoginUrl();
		}
				
		$data = $this->data;
		
		$data['header']['title'] = 'Login';
		$data['message'] = '';
		if(isset($_SERVER['HTTP_REFERER'])) {
			if(strpos($_SERVER['HTTP_REFERER'], 'start_a_challenge') !== FALSE) {
				$this->session->set_userdata("challenge_creation", true);
			
			}			
			elseif(strpos($_SERVER['HTTP_REFERER'], 'cluster/start') !== FALSE) {
				$this->session->set_userdata("cluster_creation", true);
			}
		}

		$data['user'] = '';
		$data['user_id'] = '';
		
		if($me) {
			$data['user'] = $me;
			$data['user_id'] = $me['id'];
		}
		
		try {
			//$this->load->library('facebook_connect');			
			//$data['user']	= $this->facebook_connect->user;
			//$data['user_id'] =  $this->facebook_connect->user_id;
					
		}
		catch (Exception $e) {
			// exception
		}
		$data['fb_valid'] = false;
		
		if($me) {
			//print_r($me);
			$data['fb_no_email'] = true;
			
			$this->session->set_userdata("fb_user", $me['id']);
			if($user = $this->MUser->validate_fb($me['id'])) {
				$user = $user->row();
				$this->MUser->set_usersession($user->id, $user->email);
				
				if(isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'start_a_challenge') !== FALSE) {
					redirect('challenge/start_a_challenge', 'refresh');
				}
				elseif(isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'cluster/start') !== FALSE) {
					redirect('cluster/start', 'refresh');
				}
				elseif(isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'cluster/joina') !== FALSE) {
					redirect($_SERVER['HTTP_REFERER'], 'refresh');
				} 
				else {
					redirect('user/view/'.$user->id, 'refresh');							
				}
			}
			elseif($email = $this->input->post('fb_connect_email')) {
				
				if(check_email_address($email)) {
				
					if($pass = $this->input->post('password')) {
						if($id = $this->MUser->login($email, $pass)) {
							$this->MItems->update('users', array('id' => $id), array('fb_user' => $me['id']));
							redirect('user/view/'.$id, 'refresh');
						}
						else {
							$user['email'] = $email;
							$user['signup_pass'] = $pass;
							$user['signup_passconf'] = $pass;
							$user['fb_user'] = $me['id'];
							$user['official'] = 1;
							$user['created'] = date('Y-m-d H:i:s');

							$error = '';
							$id = $this->MUser->process_new_user($user, $error);

							if($error) {
								$data['fb_no_email'] = true;
								$data['message'] = $error;
							}
							elseif($id) {

								$profile['first_name'] = $me['first_name'];
								$profile['last_name'] = $me['last_name'];
								if(isset($me['birthday'])) {
									$profile['birthdate'] = date('Y-m-d', strtotime($me['birthday']));
								}
								if(isset($me['hometown']['name'])) {
									$profile['hometown'] = $me['hometown']['name'];
								}
								$profile['user_id'] = $id;

								$this->MItems->add('profiles', $profile);

								redirect('user/view/'.$id, 'refresh');
							}
						}
					
					}
					else {
						$data['message'] = "Please enter a password";
					
					}
				}
				else {
					
					$data['message'] = "Please enter a valid email address";
					
				}
			}
			elseif($this->session->userdata("logged_in") && $this->session->userdata("user_id")) { 
				// they are an existing user, and logged in, and linking accounts
				$this->MItems->update('users', array('id'=>$this->session->userdata("user_id")), array('fb_user'=>$me['id']));
				redirect('user/edit/'.$this->session->userdata("user_id"), 'refresh');
			}
			else {
				// Facebook user has no email in system
				$data['fb_no_email'] = true;
			}
			
		}
		elseif(isset($_POST['beex_email']) && $_POST['beex_email'] != '') {
			$email = $_POST['beex_email'];
			if($result = $this->MUser->validate_user($email, $_POST['password'])) {			
				$user = $result->row();
				$this->MUser->set_usersession($user->id, $user->email);
				$this->MItems->update('users', array('id'=>$user->id), array('official'=>'1'));				
				redirect('user/view/'.$user->id, 'refresh');
			}

			else {			
				$data['message'] = 'There was a problem with your information. Please try again.';
			}
		}
		
		elseif($me['id']) { // they hit facebook connect...
			$this->session->set_userdata("fb_user", $me['id']);
			$data['fb_valid'] = true;
						
			if(isset($_POST['email']) && $_POST['email']!='') { // they're a NEW USER connecting fb w/ an email address..
				$user = array();
				$user['created'] = date("Y-m-d H:i:s");
				$user['email'] = $_POST['email'];
				$user['fb_user'] = $this->facebook_connect->user_id;
				$user['official'] = 1;

				$this->load->library('form_validation');
				$this->form_validation->set_rules('first_name', 'First name', 'required');
				$this->form_validation->set_rules('last_name', 'Last name', 'required');				
				$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email|callback_username_check');				
				if ($this->form_validation->run() == FALSE) {
					$data['message'] = 'Error';
				}
				else {
					$id = $this->MItems->add('users', $user);
					
					$profile = array();
					$profile['user_id'] = $id;
					$profile['first_name'] = $_POST['first_name'];
					$profile['last_name'] = $_POST['last_name'];
					$profile['created'] = date("Y-m-d H:i:s");
					$this->MItems->add('profiles', $profile);
					
					
					$userdata = array('logged_in'=>true, 'user_id'=>$id, 'username'=>$_POST['email']);
					$this->session->set_userdata($userdata);
					
					if($this->session->userdata("challenge_creation") == true) {
						redirect('challenge/start_a_challenge', 'refresh');
						$this->session->unset_userdata("challenge_creation");
					}
					elseif($this->session->userdata("cluster_creation") == true) {
						redirect('cluster/start', 'refresh');
						$this->session->unset_userdata("cluster_creation");						
					}
					redirect('user/view/'.$id, 'refresh');
				}
			}
			else {
				if($this->session->userdata("logged_in") && $this->session->userdata("user_id")) { 
					// they are an existing user, and logged in, and linking accounts
					$this->MItems->update('users', array('id'=>$this->session->userdata("user_id")), array('fb_user'=>$me['id']));
					redirect('user/edit/'.$this->session->userdata("user_id"), 'refresh');
				}
				else { // they are logging in.. 
					if($result = $this->MUser->validate_fb($me['id'])) {			
						$user = $result->row();
						$userdata = array('logged_in'=>true, 'user_id'=>$user->id, 'username'=>$user->email);
						if($user->email == 'zkilgore@gmail.com' || $user->email == 'devin@beex.org' || $user->email == 'matt@beex.org') {
							$userdata['super_user'] = true;	
						}
						$this->session->set_userdata($userdata);				
						$this->MItems->update('users', array('id'=>$user->id), array('official'=>'1'));				
						
						if(strpos($_SERVER['HTTP_REFERER'], 'start_a_challenge') !== FALSE) {
							redirect('challenge/start_a_challenge', 'refresh');
						}
						elseif(strpos($_SERVER['HTTP_REFERER'], 'cluster/start') !== FALSE) {
							redirect('cluster/start', 'refresh');
						}
						elseif(strpos($_SERVER['HTTP_REFERER'], 'cluster/joina') !== FALSE) {
							redirect($_SERVER['HTTP_REFERER'], 'refresh');
						} 
						else {
							redirect('user/view/'.$user->id, 'refresh');							
						}

					}
					else { // the connect went fine, but they need to enter more info to complete their profile
						$data['message'] = 'Your Facebook account has linked, registration is almost over! Now just enter your email and first/last name.';
					}					
				}

				
			}
			
		}
		$this->load->view('login.php', $data);
	}

	function logout() {

		$data = $this->data;
		$data['message'] = 'You have been successfully logged out';
		$this->session->unset_userdata(array('logged_in'=>'', 'npo_id'=>'', 'admin'=>'', 'username'=>'', 'user_id'=>'', 'fb_user'=>'', 'superuser'=>'', 'super_user'=>''));

		$this->load->view('login', $data);
		redirect('site', 'refresh');		

	}

	function newuser() {
		
		$data = $this->data;
		$data['header']['title'] = 'New User Information';
		$data['data']['item'] = '';
		$data['data']['new'] = true;
		$this->load->view('new_user', $data);

	}
	
	function captcha_check() {
		if(strcasecmp($this->session->userdata('captchaWord'), $this->input->post('captcha')) == 0) {
		    return true;
		}
		else {
			$this->form_validation->set_message('captcha_check', 'You have entered an incorrect security code.');
		    return false;
		}
	}

	function process() {

		$data = $this->data;
		$id = $this->uri->segment(4,'add');
		$this->load->library('form_validation');

		if($id == 'add') {

			$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email|callback_username_check');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|md5');
			$this->form_validation->set_rules('password_conf', 'Password Confirmation', 'trim|required|matches[password]');
			
			$this->form_validation->set_rules('captcha', 'Security Code', 'required|callback_captcha_check');

		}
		elseif(@$_POST['password']) {
			
			$this->form_validation->set_rules('password', 'Password', 'trim|required|requiredmatches[password_conf]|md5');
			$this->form_validation->set_rules('password_conf', 'Password Confirmation', 'trim');
			
		}

		$this->form_validation->set_rules('fb_user', 'Facebook User ID', 'trim');
		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('birthyear', 'Birth Year', 'trim');
		$this->form_validation->set_rules('birthmonth', 'Birth Month', 'trim');
		$this->form_validation->set_rules('birthday', 'Birth Day', 'trim');
		$this->form_validation->set_rules('hometown', 'Hometown', 'trim');
		$this->form_validation->set_rules('zip', 'Zip', 'trim');
		$this->form_validation->set_rules('gender', 'Gender', 'trim');
		$this->form_validation->set_rules('whycare', 'Why are you here?', 'trim');
		$this->form_validation->set_rules('blurb', 'Blurb', 'trim');
		$this->form_validation->set_rules('upsets', 'What upsets you?', 'trim');
		$this->form_validation->set_rules('joy', 'What brings you joy?', 'trim');
		
				

		if ($this->form_validation->run() == FALSE)
		{

			$data['data']['message'] = "Please fill out all the required fields.";
			$data['data']['new'] = ($id == 'add') ? true : false;
			$data['data']['edit'] = ($id == 'add') ? false : true;
			$data['data']['fb_user'] = $this->input->post('fb_user');
			$this->load->view('new_user', $data);

		}
		elseif(((time() - $this->session->userdata('temp_time')) < 8) && $id == 'add') {
			$data['data']['message'] = "You have registered for Beex.org at an alarming rate. If you are an actual person and not a robot then we at Beex.org applaud your abilities and hope that you bring those talents to the fundraising table as well! However, it is far more likely you are just a stinking bot and if you would please not spam us we would appreciate it.";
			$data['data']['new'] = ($id == 'add') ? true : false;
			$data['data']['edit'] = ($id == 'add') ? false : true;
			$this->load->view('new_user', $data);	
		}
		else {

			$_POST['birthdate'] = $_POST['birthyear']."-".$_POST['birthmonth']."-".$_POST['birthday'];
			$_POST['created'] = date("Y-m-d H:i:s");

			$user = array();

			$user['email'] = $this->input->post('email');
			$user['password'] = $this->input->post('password');
			$user['fb_user'] = $this->input->post('fb_user');

			$profile['first_name'] = $this->input->post('first_name');
			$profile['last_name'] = $this->input->post('last_name');
			$profile['birthdate'] = $this->input->post('birthdate');
			$profile['hometown'] = $this->input->post('hometown');
			$profile['zip'] = $this->input->post('zip');
			//$profile['network'] = $_POST['network'];
			$profile['gender'] = $this->input->post('gender');
			$profile['whycare'] = $this->input->post('whycare');
			$profile['blurb'] = $this->input->post('blurb');
			//$profile['advice'] = $_POST['advice'];
			$profile['upsets'] = $this->input->post('upsets');
			$profile['joy'] = $this->input->post('joy');
			$profile['website'] = $this->input->post('website');



			if($id == 'add') {

				$user['created'] = $_POST['created'];
				$profile['created'] = $_POST['created'];
				$user['code'] = generate_password(12);
				$user['official'] = 0;

			}
			
			foreach($_POST as $key => $val) {
				if(!$val) {
					unset($_POST[$key]);
				}
			}

			/* Process Special Fields */

			if($pic = $this->session->userdata('profile_picture')) {
				$profile['profile_pic'] = $pic;
			}
			elseif($id == 'add') {
				$profile['profile_pic'] = '';
			}
			else {
				
			}

			if($id == 'add') {
				if($user_id = $this->MItems->add('users', $user)) {

					$profile['user_id'] = $user_id;

					if(0 === $this->MItems->add('profiles', $profile)) {
						//beex_mail($user['email'], 'registration', 'thefolks@beex.org', array('user_id'=>$user_id, 'code'=>$user['code']));
						$this->beex_email->generate_new_registration_email($user['email'], $user_id, $user['code']);
						
						if(isset($profile['profile_pic']) && $profile['profile_pic']) {
							$this->beex_image->process_media('media/profiles/', $profile['profile_pic'], 'media/profiles/'.$user_id.'/');
							$this->session->unset_userdata('profile_picture');
						}
						
						$data['message'] = $_POST['first_name']." ".$_POST['last_name']." has successfully been added.";
						
						//$this->MUser->set_usersession($user_id, $user['email']);
						redirect('user/entercode/'.$user_id, 'refresh');
											}
					else {
						$data['message'] = "We're sorry, there has been a problem processing your request: Profile.";
					}
				}
				else {
					$data['message'] = "We're sorry, there has been a problem processing your request: User.";
				}
			}
			else {
				

				if($user['password']) {
					$this->MItems->update('users', array('id'=>$id), array('password'=>$user['password']));
				}
				

				if($this->MItems->update('profiles', array('user_id'=>$id), $profile)) {
				
					$data['message'] = $message =  "Your profile has successfully been updated.";
					
					if(!$this->MItems->get('users', $id, 'id')->row()->official) {
						$this->MItems->update('users', array('id'=>$id), array('official'=>'1'));
					}
					if(isset($profile['profile_pic']) && $profile['profile_pic']) {
						$this->beex_image->process_media('media/profiles/', $profile['profile_pic'], 'media/profiles/'.$id.'/');
						$this->session->unset_userdata('profile_picture');
					}
					
					redirect('user/view/'.$id, 'refresh');

				}
				else {
					$data['message'] = "We're sorry, there has been a problem processing your request.";
				}

				$data['data']['message'] = $message;
				$data['header']['title'] = 'Edit Your Profile';
				$data['data']['item'] = $this->MItems->getUser($id, 'id');
				$data['data']['edit'] = true;
				$data['data']['new'] = false;
	
			}

			$this->load->view('edit_user', $data);
			
		}
	}
}

?>