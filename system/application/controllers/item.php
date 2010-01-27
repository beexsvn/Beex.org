<?php

class Item extends Controller { 
	
	// Preload data
	public $data;
	public $form_elements;
	
	function Item() {
		parent::Controller();
		
		$this->load->helper('form');
		$this->data = $data;
		
		$this->form_elements = array (
			'name' => array(
								'name'=> "Name",
								'type'=> 'text'
							),
			'date' => array(
								'name'=> "Date of Entry",
								'type'=> 'date',
								'hidden'=>true,
								'value'=> date( 'Y-m-d H:i:s', $phpdate )
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
	
	function login() {
		$data = $this->data;
		$data['header']['title'] = 'Login';
		
		if($_POST) {
			if($_POST['admin_email'] != 'bxadmin') {
				if($result = $this->MNpos->validate_admin($_POST)) {
					$npo = $result->row();
					$userdata = array('logged_in'=>true, 'npo_id'=>$npo->id, 'username'=>$npo->contact_firstname);
					$this->session->set_userdata($userdata);
					redirect('/npo/view/'.$npo->id, 'refresh');
				}
				else {
					$data['message'] = 'There was a problem with your information. Please try again.';	
				}
			}
			else {
				if($_POST['admin_password'] == 'peterson') {
					$userdata = array('logged_in'=>true, 'npo_id'=>0, 'admin'=>true);
					$this->session->set_userdata($userdata);
					redirect('/npo/viewall', 'refresh');
				}
				else {
					$data['message'] = "There was a problem with your information. Please try again.  If that doesn't work, contact support <a href='mailto:support@beex.org'>support@beex.org</a>.";	
				}

			}
		}
		$this->load->view('login.php', $data);
	}
	
	function logout() {
		$data = $this->data;
		$this->session->unset_userdata(array('logged_in'=>'', 'npo_id'=>'', 'admin'=>'', 'username'=>''));
		
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
			$output .= "<tr><td>".anchor('npo/view/'.$row->id, $row->name)."</td><td>".$row->ein."</td><td>".$row->contact_firstname." ".$row->contact_lastname."</td></tr>";
		}
		
		$data['output'] = $output;
		
		$this->load->view('npolist.php', $data);
	}
	
	function view() {
		$data = $this->data;
		if(($npo_id = $this->session->userdata('npo_id')) || $this->session->userdata('admin')) {
			if($this->session->userdata('logged_in')) {
				
				if(!$npo_id) {
					$npo_id = $this->uri->segment(3);	
				}
				
				$data['edit'] = $this->uri->segment(4,0);
				$npo = $this->MNpos->getNpo($npo_id);
				$data['npo'] = $npo->row();
				
				$data['tags']= '';
				if($tags = $this->MNpos->getTags($npo_id)) {
					$data['tags'] = $this->processTags($this->MNpos->getTags($npo_id));
				}
				
				$this->load->view('npoview.php', $data);
			}
			else {
				redirect('/npo/login', 'refresh');
			}
		}
		else {
			redirect('/npo/login', 'refresh');
		}
	}
	
	function update() {
		$npo_id = $this->uri->segment(3);
		$data = $this->data;
		$header['title'] = "BeExtrarodinary Non Profit Database - Add NPO";
		$data['header'] = $header;
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('ein', 'EIN Number', 'trim|required');
		$this->form_validation->set_rules('name', 'Organization Name', 'trim|required');
		$this->form_validation->set_rules('address_street', 'Mailing Address', 'trim|required');
		$this->form_validation->set_rules('address_city', 'City', 'trim|required');
		$this->form_validation->set_rules('address_state', 'State', 'trim|required');
		$this->form_validation->set_rules('address_zip', 'Zip', 'trim|required');
		$this->form_validation->set_rules('admin_email', 'Administrator Email', 'trim|required|valid_email|requiredmatches[admin_emailconf]');
		$this->form_validation->set_rules('admin_password', 'Administrator Password', 'trim|requiredmatches[admin_passconf]|md5');
		$this->form_validation->set_rules('admin_passconf', 'Admin Password Confirmation', 'trim');
		$this->form_validation->set_rules('contact_firstname', 'Contact First Name', 'trim|required');
		$this->form_validation->set_rules('contact_lastname', 'Contact Last Name', 'trim|required');
		$this->form_validation->set_rules('contact_email', 'Contact Email', 'trim|required|valid_email|requiredmatches[contact_emailconf]');
		$this->form_validation->set_rules('contact_phone', 'Contact Phone Number', 'trim|required');
		
		if ($this->form_validation->run() == FALSE)
		{
			$data['message'] = "Please fill out all the required fields.";
		}
		else {
			unset($_POST['admin_emailconf']);
			unset($_POST['contact_emailconf']);
			unset($_POST['admin_passconf']);
			
			if(!$_POST['admin_password']) {
				unset($_POST['admin_password']);	
			}
			
			$tags = $_POST['causetags'];
			unset($_POST['causetags']);
			
			if($this->MNpos->updateNpo($npo_id, $_POST)) {
				$this->MNpos->deleteTags($npo_id);
				$this->MNpos->addTags($tags, $npo_id);
				$data['message'] = $_POST['name']." has successfully been updated.";
			}
			else {
				$data['message'] = "We're sorry, there has been a problem processing your request.";
			}
			
			$npo = $this->MNpos->getNpo($npo_id);
			$data['npo'] = $npo->row();
			
			$data['tags'] = $this->processTags($this->MNpos->getTags($npo_id));
		}
		
		$this->load->view('npoview.php', $data);
	}
	
	function process() {
		
		$data = $this->data;
		
		$id = $this->uri->segment(3,'add');
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('ein', 'EIN Number', 'trim|required');
		$this->form_validation->set_rules('name', 'Organization Name', 'trim|required');
		$this->form_validation->set_rules('address_street', 'Mailing Address', 'trim|required');
		$this->form_validation->set_rules('address_city', 'City', 'trim|required');
		$this->form_validation->set_rules('address_state', 'State', 'trim|required');
		$this->form_validation->set_rules('address_zip', 'Zip', 'trim|required');
		$this->form_validation->set_rules('admin_email', 'Administrator Email', 'trim|required|valid_email|requiredmatches[admin_emailconf]');
		if($_POST['admin_password'] || $npo_id == 'add') {
			$this->form_validation->set_rules('admin_password', 'Administrator Password', 'trim|requiredmatches[admin_passconf]|md5');
			$this->form_validation->set_rules('admin_passconf', 'Admin Password Confirmation', 'trim|required');
		}
		$this->form_validation->set_rules('contact_firstname', 'Contact First Name', 'trim|required');
		$this->form_validation->set_rules('contact_lastname', 'Contact Last Name', 'trim|required');
		$this->form_validation->set_rules('contact_email', 'Contact Email', 'trim|required|valid_email|requiredmatches[contact_emailconf]');
		$this->form_validation->set_rules('contact_phone', 'Contact Phone Number', 'trim|required');
		
		if ($this->form_validation->run() == FALSE)
		{
			$data['message'] = "Please fill out all the required fields.";
		}
		else {
			unset($_POST['admin_emailconf']);
			unset($_POST['contact_emailconf']);
			unset($_POST['admin_passconf']);
			
			$tags = $_POST['causetags'];
			unset($_POST['causetags']);
			
			if($_FILES['logo']['name']) {
				print_r($_FILES['logo']);
				$_POST['logo'] = $this->do_upload($_FILES);	
			}
			
			if($npo_id == 'add') {
				if($npo_id = $this->MNpos->addNpo($_POST)) {
					$this->MNpos->addTags($tags, $npo_id);
					$data['message'] = $_POST['name']." has successfully been added to the BeExtraordinary NPO Database.";
				}
				else {
					$data['message'] = "We're sorry, there has been a problem processing your request.";
				}
				
				$this->load->view('npoform.php', $data);
			}
			else {
				if($this->MNpos->updateNpo($npo_id, $_POST)) {
					$this->MNpos->deleteTags($npo_id);
					$this->MNpos->addTags($tags, $npo_id);
					$data['message'] = $_POST['name']." has successfully been updated.";
				}
				else {
					$data['message'] = "We're sorry, there has been a problem processing your request.";
				}
				
				$npo = $this->MNpos->getNpo($npo_id);
				$data['npo'] = $npo->row();
			
				$data['tags'] = $this->processTags($this->MNpos->getTags($npo_id));
			}
			
			$this->load->view('npoview.php', $data);
		}
	}
	
	function addUpdate() {
		
		if($npo_id == 'add') {
			if($ = $this->MItem->add($_POST)) {
				$this->MNpos->addTags($tags, $npo_id);
				$data['message'] = $_POST['name']." has successfully been added to the BeExtraordinary NPO Database.";
			}
			else {
				$data['message'] = "We're sorry, there has been a problem processing your request.";
			}
			
			$this->load->view('npoform.php', $data);
		}
		else {
			if($this->MNpos->updateNpo($npo_id, $_POST)) {
				$this->MNpos->deleteTags($npo_id);
				$this->MNpos->addTags($tags, $npo_id);
				$data['message'] = $_POST['name']." has successfully been updated.";
			}
			else {
				$data['message'] = "We're sorry, there has been a problem processing your request.";
			}
			
			$npo = $this->MNpos->getNpo($npo_id);
			$data['npo'] = $npo->row();
		
			$data['tags'] = $this->processTags($this->MNpos->getTags($npo_id));
		}
		
		
	}
	
	function do_upload($files)
	{
		$config['upload_path'] = '/beexdev/uploads/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '100';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
		
		$this->load->library('upload', $config);
		
		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());
			print_r($error);
		}	
		else
		{
			$data = $this->upload->data('file_name');
			return $data['file_name'];
		}
	}
	
}

?>