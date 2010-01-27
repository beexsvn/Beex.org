<?php



class User extends Controller {



	public $data;

	public $table_name;



	function User() {

		parent::Controller();



		$this->load->model('MItems');

		$this->load->model('MUser');

		$this->data['header']['title'] = 'Users';

		$this->data['data']['message'] = '';

		$this->data['data']['item'] = '';

		$this->data['username'] = $this->session->userdata('username');

		$this->data['data']['user_id'] = $this->session->userdata('user_id');

		$this->table_name = 'users';

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
	
	function entercode($user_id, $code = '') {
		
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
			$this->load->view('error', $data);
		}
		
		
		
	}	



	function view() {

		$data = $this->data;

		$item = $this->MItems->get($this->table_name, $this->uri->segment(3, 0), 'id');

		if($item->num_rows()) {

			$data['item'] = $item->row();
			$data['user_id'] = $data['item']->id;
			$profile = $this->MItems->get('profiles', $data['item']->id, 'user_id');

			if($profile->num_rows()) {
				
				//$browser = $this->MItems->getChallenge($data['item']->id, 'challenges.user_id');
				$browser = $this->MItems->getChallengeByUser($data['item']->id);
				$data['clusters'] =  $this->MItems->getClustersByUser($data['item']->id);
				$data['browser'] = $browser;
				$data['owner'] = ($this->session->userdata('user_id') == $data['user_id']) ? true : false;
				$data['profile'] = $profile->row();
				$data['sponsor'] = 'Test Sponsor';
				$this->load->view('user', $data);

			}
			else {
				$this->edit(true);
			}

		}
		else {
			// No profile for that id
			$this->load->view('framework/error.php');
		}
	}



	function edit($must = false) {

		$id = $this->uri->segment(3);

		if($this->session->userdata('user_id') == $id && $id) {
			$data = $this->data;
	
			$data['header']['title'] = 'Edit Your Profile';
	
			$data['data']['item'] = $this->MItems->getUser($id, 'id');
	
			$data['data']['edit'] = true;
	
			$data['data']['new'] = false;
	
			$data['data']['id'] = $id;
	
			//$data['data']['message'] = ($must) ? 'You must enter some profile information before we can continue. We just need your first and last name really, but why don\'t you load up a picture and stay a while!' : '';
	
			$this->load->view('edit_user', $data);
		}
		else {
			redirect('user/login', 'refresh');	
		}
	
	}
	
	function forgot() {
		
		$data = $this->data;
		$data['header']['title'] = "Forgot Your Password?";
		$data['message'] = ($this->uri->segment(3)) ? 'An email has been sent to the address on file. Click the link or copy and paste the link into a browser to access the reset password screen.' : '';
		
		$this->load->view("forgotpassword", $data);
		
	}



	function login() {

		$data = $this->data;

		$data['header']['title'] = 'Login';

		$data['message'] = '';



		if($_POST) {
			
			if($result = $this->MUser->validate_user($_POST['email'], $_POST['password'])) {
			
				$user = $result->row();

				$userdata = array('logged_in'=>true, 'user_id'=>$user->id, 'username'=>$user->email);
				if($_POST['email'] == 'zkilgore@gmail.com' || $_POST['email'] == 'devin@beex.org' || $_POST['email'] == 'matt@beex.org') {
					$userdata['super_user'] = true;	
				}
				$this->session->set_userdata($userdata);
				
				$this->MItems->update('users', array('id'=>$user->id), array('official'=>'1'));
				
				redirect('user/view/'.$user->id, 'refresh');

			}

			else {

				$data['message'] = 'There was a problem with your information. Please try again.';



			}

		}

		$this->load->view('login.php', $data);

	}



	function logout() {

		$data = $this->data;

		$data['message'] = 'You have been successfully logged out';

		$this->session->unset_userdata(array('logged_in'=>'', 'npo_id'=>'', 'admin'=>'', 'username'=>'', 'user_id'=>''));



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



	function addUpdate() {







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



	function process() {



		$data = $this->data;



		$id = $this->uri->segment(4,'add');



		$this->load->library('form_validation');



		if($id == 'add') {

			$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email|callback_username_check');
			$this->form_validation->set_rules('password', 'Password', 'trim|requiredmatches[password_conf]|md5');
			$this->form_validation->set_rules('password_conf', 'Password Confirmation', 'trim');

		}
		elseif(@$_POST['password']) {
			
			$this->form_validation->set_rules('password', 'Password', 'trim|requiredmatches[password_conf]|md5');
			$this->form_validation->set_rules('password_conf', 'Password Confirmation', 'trim');
			
		}

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



		if ($this->form_validation->run() == FALSE)
		{

			$data['data']['message'] = "Please fill out all the required fields.";
			$data['data']['new'] = ($id == 'add') ? true : false;
			$data['data']['edit'] = ($id == 'add') ? false : true;
			$this->load->view('new_user', $data);

		}
		else {

			$_POST['birthdate'] = $_POST['birthyear']."-".$_POST['birthmonth']."-".$_POST['birthday'];
			$_POST['created'] = date("Y-m-d H:i:s");

			$user = array();

			$user['email'] = @$_POST['email'];
			$user['password'] = @$_POST['password'];

			$profile['first_name'] = $_POST['first_name'];
			$profile['last_name'] = $_POST['last_name'];
			$profile['birthdate'] = $_POST['birthdate'];
			$profile['hometown'] = $_POST['hometown'];
			$profile['zip'] = $_POST['zip'];
			//$profile['network'] = $_POST['network'];
			$profile['gender'] = $_POST['gender'];
			$profile['whycare'] = $_POST['whycare'];
			$profile['blurb'] = $_POST['blurb'];
			//$profile['advice'] = $_POST['advice'];



			if($id == 'add') {

				$user['created'] = $_POST['created'];
				$profile['created'] = $_POST['created'];
				$user['code'] = generate_password(12);

			}
			
			foreach($_POST as $key => $val) {
				if(!$val) {
					unset($_POST[$key]);
				}
			}

			/* Process Special Fields */

			if($_FILES['profile_pic']['name']) {
				$profile['profile_pic'] = $this->beex->do_upload($_FILES, 'profile_pic', './profiles/');
			}
			elseif($id == 'add') {
				$profile['profile_pic'] = '';
			}

			if($id == 'add') {

				if($user_id = $this->MItems->add('users', $user)) {

					$profile['user_id'] = $user_id;

					if(0 === $this->MItems->add('profiles', $profile)) {

						beex_mail($user['email'], 'registration', 'thefolks@beex.org', array('user_id'=>$user_id, 'code'=>$user['code']));

						$data['message'] = $_POST['first_name']." ".$_POST['last_name']." has successfully been added.";

						//$userdata = array('logged_in'=>true, 'user_id'=>$user_id, 'username'=>$user['email']);

						//$this->session->set_userdata($userdata);

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