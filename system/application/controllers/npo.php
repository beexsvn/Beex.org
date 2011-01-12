<?php

class Npo extends Controller { 
	
	// Preload data
	public $data;
	
	function Npo() {
		parent::Controller();
		$this->load->helper('form');
		$this->load->model('MNpos');
		$this->load->model('MCaptcha');
		$header['title'] = "Nonprofit Organization Database";
		$data['header'] = $header;
		$data['message'] = '';
		$data['edit'] = '';
		$this->data['header']['title'] = 'Non-Profit Organizations';
		$this->data['data']['message'] = '';
		$this->data['data']['item'] = '';
		$this->data['data']['username'] = $this->session->userdata('username');
		$this->data['data']['user_id'] = $this->session->userdata('user_id');
		$this->data['data']['npo_username'] = $this->session->userdata('npo_username');
		$this->data['data']['npo_id'] = $this->session->userdata('npo_id');
		$this->table_name = 'npos';
		$this->data = $data;
	}
	
	function index() {
		$data = $this->data;
		
		$browser = $this->MItems->getNPO();
		
		$data['browser'] = $browser;
		$data['header']['title'] = "Organizations";
		
		$this->load->view('npos', $data);
	}

	
	function newNpo() {
		$header['title'] = "Nonprofit Organization Registration Form";
		$data['message'] = '';
		$data['header'] = $header;
		$data['new'] = true;
		$data['edit'] = true;
		$data['edit_id'] = 'add';
		$this->load->view('npoform', $data);
	}
	
	function login() {
		$data = $this->data;
		$data['header']['title'] = 'Login';
		
		if($_POST) {
			if($_POST['admin_email'] != 'bxadmin') {
				if($result = $this->MNpos->validate_admin($_POST)) {
					$npo = $result->row();
					$userdata = array('npo_logged_in'=>true, 'npo_id'=>$npo->id, 'npo_username'=>$npo->contact_firstname);
					$this->session->set_userdata($userdata);
					redirect('/npo/edit/'.$npo->id, 'refresh');
				}
				else {
					$data['message'] = 'There was a problem with your information. Please try again.';	
				}
			}
			else {
				if($_POST['admin_password'] == 'peterson') {
					$userdata = array('npo_logged_in'=>true, 'npo_id'=>0, 'npo_admin'=>true);
					$this->session->set_userdata($userdata);
					redirect('/npo/viewall', 'refresh');
				}
				else {
					$data['message'] = "There was a problem with your information. Please try again.  If that doesn't work, contact support <a href='mailto:support@beex.org'>support@beex.org</a>.";	
				}

			}
		}
		$this->load->view('npologin.php', $data);
	}
	
	function logout() {
		$data = $this->data;
		$this->session->unset_userdata(array('npo_logged_in'=>'', 'npo_id'=>'', 'admin'=>'', 'npo_username'=>''));
		
		$this->load->view('login', $data);
	}
	
	function processTags($tags) {
		$count = 0;
		$causetags = '';
		foreach($tags as $tag) {
			if($count !=0) {
				$causetags .= ', ';
			}
			$count++;
			$causetags .= $tag->tag;
		}
		return $causetags;
	}
	
	function viewall() {
		$data = $this->data;
		$npos = $this->MNpos->getNpos();
		$output = "";
		foreach($npos->result() as $row) {
			$output .= "<tr><td>".anchor('npo/view/'.$row->id, $row->name)."</td><td>".$row->ein."</td><td>".$row->contact_firstname." ".$row->contact_lastname."</td><td>".anchor('npo/edit/'.$row->id,"Edit")."</tr>";
		}
		
		$data['output'] = $output;
		
		$this->load->view('npolist.php', $data);
		
	}
	
	function view() {
		$data = $this->data;
		$id = $this->uri->segment(3);
		
		$data['npo_id'] = $id;
		
		$data['npo'] = $this->MItems->getNPO($id)->row();
		$data['browser'] = $this->MItems->getChallenge(array('challenge_npo'=>$id, 'cluster_id'=>NULL));
		$data['clusters'] = $this->MItems->getCluster($id, 'cluster_npo');
		$this->load->view('npo', $data);
	}
	
	function widget() {
		
		$data = $this->data;
		$id = $this->uri->segment(3);
		
		if($npo = $this->MItems->getNPO($id)) {
			if($npo->num_rows()) {
				//real npo
				$data['type'] = 'npo';
				$data['npo_id'] = $id;
				$this->load->view('widgets/create', $data);
			}
		}
		
	}
	
	function edit() {
		$data = $this->data;
		$npo_id = $this->uri->segment(3);
		
		if($this->MNpos->valid_npo_admin($npo_id, $this->session->userdata('user_id')) || $this->session->userdata('super_user')) {
				
							
				//$data['edit'] = $this->uri->segment(4,0);
				$data['edit'] = true;
				$data['new'] = false;
				$data['edit_id'] = $npo_id;
				$npo = $this->MNpos->getNpo($npo_id);
				$data['npo'] = $npo->row();
				
				$data['tags']= '';
				if($tags = $this->MNpos->getTags($npo_id)) {
					$data['tags'] = $this->processTags($this->MNpos->getTags($npo_id));
				}
				
				$this->load->view('npoform', $data);
		}
		else {
			redirect('user/login', 'refresh');
		}
	}
	/*
	function edit() {
		$data = $this->data;
		
		if(($npo_id = $this->session->userdata('npo_id')) || $this->session->userdata('npo_admin') || $this->session->userdata('super_user')) {
			if($this->session->userdata('npo_logged_in') || $this->session->userdata('super_user')) {
				
				if(!$npo_id) {
					$npo_id = $this->uri->segment(3);	
				}
				
				//$data['edit'] = $this->uri->segment(4,0);
				$data['edit'] = true;
				$data['new'] = false;
				$data['edit_id'] = $npo_id;
				$npo = $this->MNpos->getNpo($npo_id);
				$data['npo'] = $npo->row();
				
				$data['tags']= '';
				if($tags = $this->MNpos->getTags($npo_id)) {
					$data['tags'] = $this->processTags($this->MNpos->getTags($npo_id));
				}
				
				$this->load->view('npoform', $data);
			}
			else {
				redirect('user/login', 'refresh');
			}
		}
		else {
			redirect('user/login', 'refresh');
		}
	}
	*/
	
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
		
		$npo_id = $this->uri->segment(3,'add');
		
		$this->load->library('form_validation');
		
		//Required Fields
		$this->form_validation->set_rules('ein', 'EIN Number', 'trim|required');
		$this->form_validation->set_rules('name', 'Organization Name', 'trim|required');
		$this->form_validation->set_rules('address_street', 'Mailing Address', 'trim|required');
		$this->form_validation->set_rules('address_city', 'City', 'trim|required');
		$this->form_validation->set_rules('address_state', 'State', 'trim|required');
		$this->form_validation->set_rules('address_zip', 'Zip', 'trim|required');
		$this->form_validation->set_rules('paypal_email', 'Paypal Email', 'trim|required|valid_email');
		
		
		if($npo_id == 'add') {
			$this->form_validation->set_rules('admin_email', 'Administrator Email', 'trim|valid_email');
			$this->form_validation->set_rules('admin_emailconf', 'Administrator Email Confirmation', 'trim|required|matches[admin_email]|valid_email');
			$this->form_validation->set_rules('captcha', 'Security Code', 'required|callback_captcha_check');
		}
		else {
			$this->form_validation->set_rules('admin_email', 'Administrator Email', 'trim|required|valid_email');
		}
		/*if($this->input->post('admin_password') || $npo_id == 'add') {
			$this->form_validation->set_rules('admin_password', 'BEEx Password', 'trim|required|md5');
			$this->form_validation->set_rules('admin_passconf', 'BEEx Password Confirmation', 'trim|required|matches[admin_password]');
		}*/
		$this->form_validation->set_rules('contact_firstname', 'Your First Name', 'trim|required');
		$this->form_validation->set_rules('contact_lastname', 'Your Last Name', 'trim|required');
		
		$this->form_validation->set_rules('contact_phone', 'Organization Phone Number', 'trim|required');
		$this->form_validation->set_rules('contact_title', 'Your Title', 'trim|required');
				
		//Optional Fields
		$this->form_validation->set_rules('cuasetags', 'Cause Tags', 'trim');
		$this->form_validation->set_rules('website', 'Website', 'trim');
		$this->form_validation->set_rules('facebook_link', 'Facebook Address', 'trim');
		$this->form_validation->set_rules('twitter_link', 'Twitter Address', 'trim');
		$this->form_validation->set_rules('rss_feed', 'RSS Feeds', 'trim');
		$this->form_validation->set_rules('mission_statement', 'What We Do', 'trim');
		$this->form_validation->set_rules('about_us', 'History', 'trim');
		
		if ($this->form_validation->run() == FALSE)
		{
			$data['message'] = "Please fill out all the required fields.";
			if($npo_id == 'add') {
				$data['new'] = true;		
			}
			else {
				$data['new'] = false;
			}
			$data['tags'] = $_POST['causetags'];
			$data['edit'] = true;
			$data['edit_id'] = $npo_id;
			$this->load->view('npoform.php', $data);
			
		}
		else {
			unset($_POST['admin_emailconf']);
			unset($_POST['contact_emailconf']);
			unset($_POST['admin_passconf']);
			unset($_POST['captcha']);
			unset($_POST['x']);
			unset($_POST['y']);
			
			$tags = $_POST['causetags'];
			unset($_POST['causetags']);
			
			/*
			if($_FILES['logo']['name']) {
				print_r($_FILES['logo']);
				$this->load->library('Beex_image');
				$_POST['logo'] = $this->beex_image->do_upload($_FILES, 'logo', './media/npos/');	
			}
			*/
			
			if($pic = $this->session->userdata('npo_logo')) {
				$_POST['logo'] = $pic;
			}
			elseif($npo_id == 'add') {
				$_POST['logo'] = '';
			}
			else {
				
			}
			
			if($npo_id == 'add') {
				
				$_POST['created'] = date('Y-m-d H:i:s');
				
				if($npo_id = $this->MNpos->addNpo($_POST)) {
					$this->MNpos->addTags($tags, $npo_id);
					if(isset($_POST['logo']) && $_POST['logo']) {
						$this->beex_image->process_media('media/npos/', $_POST['logo'], 'media/npos/'.$npo_id.'/');
					}
					
					$this->beex_email->generate_new_npo_email($_POST['admin_email']);
						
					$data['message'] = $_POST['name']." has successfully applied to BEEx.org. If you're application is approved we'll contact you within 5 business days and activate your account.  Once activated you'll be able to edit elements of your profile.";
					
					$data['fresh_org'] = true;
					
					
					$toaddress = 'zkilgore@gmail.com';
					$subject = 'A new Organization has registered';
					$message = 'Organization Name: '.$this->input->post('name').'
Administrative Contact: '.$this->input->post('admin_email');
					
					mail('zkilgore@gmail.com', $subject, $message);
					
					
				}
				else {
					$data['message'] = "We're sorry, there has been a problem processing your request.";
				}
				
				
			}
			else {
				if($this->MNpos->updateNpo($npo_id, $_POST)) {
					$this->MNpos->deleteTags($npo_id);
					$this->MNpos->addTags($tags, $npo_id);
					if(isset($_POST['logo']) && $_POST['logo']) {
						$this->beex_image->process_media('media/npos/', $_POST['logo'], 'media/npos/'.$npo_id.'/');
						$this->session->unset_userdata('npo_logo');
					}
					$data['message'] = $_POST['name']." has successfully been updated.";
				}
				else {
					$data['message'] = "We're sorry, there has been a problem processing your request.";
				}
				
				$npo = $this->MNpos->getNpo($npo_id);
				$data['npo'] = $npo->row();
			
				$data['tags'] = $this->processTags($this->MNpos->getTags($npo_id));
				
			}
			
			$data['tags'] = $tags;
			
			$data['new'] = false;
			$data['edit'] = true;
			$data['edit_id'] = $npo_id;
			
			$this->load->view('npoform.php', $data);
		}
	}
	
}

?>