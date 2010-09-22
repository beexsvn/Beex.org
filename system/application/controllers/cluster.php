<?php



class Cluster extends Controller {

	public $data;
	public $table_name;

//Initialize the cluster class
	function Cluster() {

		parent::Controller();

		$this->load->model('MItems');
		$this->load->library('beex');
		$this->data['header']['title'] = 'Cluster';
		$this->data['data']['message'] = '';
		$this->data['data']['item'] = '';
		$this->data['data']['username'] = $this->session->userdata('username');
		$this->data['data']['user_id'] = $this->session->userdata('user_id');
		$this->table_name = 'clusters';

	}


/* Index: Default view for cluster. Shows "Clusters" page */
	function index() {

		$data = $this->data;
		
		// Get clusters for browser. Defunct
		$browser = $this->MItems->getCluster();
		
		// Get the featured clusters for featured module
		$data['featured'] = $this->MItems->getCluster(array('featured'=>'1'));
		
		//Set remainging view data
		$data['browser'] = $browser;
		$data['header']['title'] = "Clusters";
		$this->load->view('clusters', $data);

	}


	/* Editor: Catchall for editing functionality. Includes basic editing, admin control, messaging, etc */
	function editor($eid = '', $etype = '', $iid = '', $itype = '', $message = '') {
		
		//Set the id based on the passed variable or the URI element
		if($id = ($iid) ? $iid : $this->uri->segment(3)) {
			
			//Verify the logged in user has access to be able to edit the cluster
			if($this->madmins->verifyUser($this->session->userdata('user_id'),$id, 'cluster')) {
			
				$data = $this->data;
				
				/*
					Section for getting the right data to pass to the views
																				*/
				
				// Set the type based on URI or passed variable
				$type = ($itype) ? $itype : ((is_numeric($etype)) ? 'default' : $etype);
				
				switch($type) {
				
					// Case basic editor
					case 'edit':
						$data['data']['item'] = $this->MItems->getCluster($id);
						$data['data']['new'] = false;
						$data['data']['edit'] = true;
						
						break;
					// Case manage challengers
					case 'challengers':
						break;
						
					default: 
						break;
					
				}
				
				// Standard data
				$data['data']['message'] = ($message) ? $message : '';
				$data['type'] = $type;
				$data['id'] = $id;
				
				// Load the cluster editor view
				$this->load->view('cluster_editor', $data);
				
			
			}
		
			else {
				
				//Not allowed to edit this cluster so just show them the cluster
				$this->view($id);
				
			}
		
		}

	}


	/* View: The URI call to display the cluster to the visitor */
	function view() {

		$data = $this->data;

		// Add one to the counter
		$this->mstat->addStat();
		
		$id = $this->uri->segment(3,0);

		$result = $this->MItems->getCluster($id, 'clusters.id');
		
		if($result->num_rows()) {
			$item = $result->row();
			
			$data['item'] = $item;

			$user = $this->MItems->getUser($data['item']->user_id, 'id');
			$user = $user->row();
			$data['user_id'] = $user->id;
			$profile = $this->MItems->get('profiles', $user->id, 'user_id');

			$data['activityfeed'] = $this->beex->processActivityFeed('cluster', $item->item_id, $profile->row());

			$data['profile'] = $profile->row();

			$data['owner'] = $this->madmins->verifyUser($this->session->userdata('user_id'), $id, 'cluster');
			$data['header']['title'] = "BEEx.org Cluster - ".$data['item']->cluster_title;
			$this->load->view('cluster', $data);
		}
		else {
			$this->load->view('framework/error', $data);
		}

	}



	function joina() {



		$data = $this->data;
		
		$id = $this->uri->segment(3,0);

		if(!$id) {
			$id = @$_POST['cluster_id'];
			$id = $id/3459;
		}

		if($id) {

			$item = $this->MItems->getCluster($id);

			if($item->num_rows() > 0) {

				$data['item'] = '';

				$data['message'] = '';
				
				$data['new'] = true;
				$data['join'] = true;
				$data['help_title'] = "Join a Cluster";
				$data['help_copy'] = 'Fill in the fields at left to create a challenge and join the cluster';
				$data['cluster'] = $item->row();
				

				$this->load->view('challenge_new_form', $data);
			}

			else {
				// Trying to load a cluster that doesn't exist
				$this->load->view('framework/error.php', $data);
			}

		}
		else {

			// Trying to join a cluster with no id
			$this->load->view('framework/error.php', $data);
		}

	}





	function start() {

		$data = $this->data;

		$data['header']['title'] = 'Start a Cluster';

		$data['data']['item'] = '';

		$data['data']['new'] = true;

		$this->load->view('start_a_cluster', $data);

	}



	function edit() {

		$id = $this->uri->segment(3);

		$data = $this->data;



		if($this->madmins->verifyUser(@$data['data']['user_id'],$id, 'cluster')) {

			$data['header']['title'] = 'Edit Cluster';
			$data['data']['item'] = $this->MItems->getCluster($id);
			$data['data']['edit'] = true;
			$data['data']['new'] = false;		
			$this->load->view('start_a_cluster', $data);

		}

		else {

			$this->load->view('framework/notauthorized', $data);

		}

	}



	function challengers() {

		$data = $this->data;

		$data['header']['title'] = 'Add Challengers';
		$data['data']['item'] = '';
		$data['data']['new'] = true;
		$data['data']['cluster_id'] = $this->uri->segment(3);
		$data['data']['freshcluster'] = $this->uri->segment(4, '');
		
		$this->load->view('add_challengers', $data);

	}



	function addUpdate() {





	}



	function process_user($email = '', $password = '', $retval = 'user_id') {

		if($this->session->userdata('logged_id')) {

			return $this->session->userdata[$retval];

		}

		else {

			return ($retval == 'user_id') ? $this->MUser->login($email, $password) : $this->MUser->login($email, $password, 'email');

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



	function process() {
		
		
		$_POST['cluster_image'] = $this->session->userdata('cluster_image');
		$this->session->unset_userdata('cluster_image');
		
				
		$data = $this->data;
		$id = $this->uri->segment(4,'add');
		$new = ($id == 'add') ? true : false;
	
		if($user_id = $this->session->userdata('user_id')) {
			$_POST['user_id'] = $user_id;
		}
		elseif(@$_POST['signup_email'] && !@$_POST['admin_email']) {			
			$_POST['user_id'] = $this->MUser->process_new_user($_POST, $error);			
		}
		else {
			$_POST['user_id'] = $this->process_user(@$_POST['admin_email'], @$_POST['password']);
			unset($_POST['password']);
		}
			
		if(!$_POST['user_id']) {			
			$data['message'] = ($error) ? $error : "You could not be logged in, please try again.";
			$data['new'] = true;
		}
		
		else {
		
			$this->load->library('form_validation');				
			if(!$this->session->userdata('logged_in') && ($id == 'add')) {
				$this->form_validation->set_rules('admin_email', 'User Email', 'trim|required');
				$this->form_validation->set_rules('password', 'User Password', 'trim|required');
			}
	
			//Required Fields	
			$this->form_validation->set_rules('cluster_title', 'Cluster Title', 'trim|required');
			$this->form_validation->set_rules('cluster_npo', 'Cluster NPO', 'trim|required');
			$this->form_validation->set_rules('cluster_goal', 'Cluster Goal', 'trim');
			$this->form_validation->set_rules('cluster_blurb', 'Cluster Blurb', 'trim|callback_blurb_check');
			$this->form_validation->set_rules('cluster_completion', 'Cluster Fund Raising Completion Date', 'trim|required');

	
			//Other fields
	
			$this->form_validation->set_rules('cluster_description', 'Cluster Description', 'trim');
			$this->form_validation->set_rules('cluster_video', 'Cluster Video', 'trim');
			$this->form_validation->set_rules('cluster_ch_title', 'Cluster Challenge Title', 'trim');
			$this->form_validation->set_rules('cluster_ch_declaration', 'Cluster Challenge Declaration', 'trim');
			$this->form_validation->set_rules('cluster_ch_goal', 'Cluster Challenge Goal', 'trim');
			$this->form_validation->set_rules('cluster_ch_fr_ends', 'Cluster Challenge Fund Raising Ends', 'trim');
			$this->form_validation->set_rules('cluster_ch_completion', 'Cluster Challenge Completion', 'trim');
			$this->form_validation->set_rules('cluster_ch_proof', 'Cluster Challenge Proof', 'trim');
			$this->form_validation->set_rules('cluster_ch_location', 'Cluster Challenge Location', 'trim');
			$this->form_validation->set_rules('cluster_ch_address', 'Cluster Challenge Address', 'trim');
			
			if ($this->form_validation->run() == FALSE)
			{
				$data['message'] = "Please fill out all the required fields.";				
				if($new) {

					$data['edit'] = false;
					$data['new'] = true;
					$data['data'] = @$data;
					$this->load->view('start_a_cluster', $data);

				}
				else {					
					$this->editor('', '', $id, 'edit', $data['message']);					
				}
			}
			else {

				// User has been logged in, processing continues
				if($id == 'add') {

					for($i=1; $i<3; $i++) {

						if($email[$i] = @$_POST['admin'.$i.'_email']) {
							$name[$i] = $_POST['admin'.$i.'_name'];
						}

						unset($_POST['admin'.$i.'_email'], $_POST['admin'.$i.'_name']);

					}
					$personal_message = '';
					if(isset($_POST['personal_message'])) {
						$personal_message = $_POST['personal_message'];
						unset($_POST['personal_message']);
					}
				}



				$_POST['cluster_ch_fr_ends'] = (isset($_POST['cluster_ch_fr_ends'])) ? date('Y-m-d', strtotime($_POST['cluster_ch_fr_ends'])) : '';
				$_POST['cluster_ch_completion'] = (isset($_POST['cluster_ch_completion'])) ? date('Y-m-d', strtotime($_POST['cluster_ch_completion'])) : '';
				$_POST['cluster_ch_proofdate'] = (isset($_POST['cluster_ch_proofdate'])) ? date('Y-m-d', strtotime($_POST['cluster_ch_proofdate'])) : '';
				$_POST['cluster_completion'] = (isset($_POST['cluster_completion'])) ? date('Y-m-d', strtotime($_POST['cluster_completion'])) : '';


				if($id == 'add')
					$_POST['created'] = date("Y-m-d H:i:s");

				foreach($_POST as $key => $val) {
					if(!$val) {
						unset($_POST[$key]);
					}
				}

				unset($_POST['signup_email'], $_POST['signup_name'], $_POST['signup_pass'], $_POST['signup_passconf']);
				unset($_POST['x']);
				unset($_POST['y']);

				//Separate Images for later
				/* NOT NEEDED! we use ajax now			
				if($_FILES['cluster_image']['name']) {
					$_POST['cluster_image'] = $this->beex->do_upload($_FILES, 'cluster_image', './media/clusters/');
				}*/

				if($id == 'add') {
					if($cluster_id = $this->MItems->add('clusters', $_POST)) {
						$this->MItems->add('admins', array('user_id'=>$this->session->userdata('user_id'), 'cluster_id'=>$cluster_id));
						$data['message'] = $_POST['cluster_title']." has successfully been created.";
						for($i=1; $i<3; $i++) {
							if($email[$i]) {
								$this->add_admin($email[$i], $name[$i], $personal_message, array('id' => $cluster_id, 'name'=>$_POST['cluster_title']));
							}
						}
						if($image = $this->session->userdata('cluster_image')) {
							$this->beex_image->process_media('media/clusters/', $image, 'media/clusters/'.$cluster_id.'/');
							$this->session->unset_userdata('cluster_image');
						}
						
						$this->beex_email->generate_new_cluster_email($this->session->userdata('user_id'), array('id'=>$cluster_id));
						$this->editor('', '', $cluster_id, 'challengers', $data['message']);						
					}
					else {
						$data['message'] = "We're sorry, there has been a problem processing your request.";
					}
				}

				else {
					if($this->MItems->update('clusters', $id, $_POST)) {
						
						if($image = $this->session->userdata('cluster_image')) {
							$this->beex_image->process_media('media/clusters/', $image, 'media/clusters/'.$cluster_id.'/');
							$this->session->unset_userdata('cluster_image');
						}
					
						$data['message'] = $_POST['cluster_title']." has successfully been updated. ".anchor('cluster/view/'.$id, 'Back to cluster');
						//redirect('cluster/challengers/'.$id, 'refresh');					
						$this->editor('', '', $id, 'edit', $data['message']);						
					}
					else {
						$data['message'] = "We're sorry, there has been a problem processing your request.";
					}
										
					$data['data']['message'] = $data['message'];
					$data['data']['item'] = $this->MItems->getCluster($id);
					$data['data']['edit'] = true;
					$data['data']['new'] = 0;
				}
			}

		}
	
	}



	function add_admin($email, $name, $message, $cluster) {



		if(!($user_id = $this->MUser->get_user_by_email($email))) {

				$user_id = $this->MItems->add('users', array('email'=>$email, 'password'=>md5('password'), 'created' => date('Y-m-d H:i:s'), 'official' => 0));

				$this->MItems->add('profiles', array('user_id'=>$user_id, 'first_name'=>$name, 'last_name' => ' ', 'created' => date("Y-m-d H:i:s")));

		}


		$this->MItems->add('admins', array('user_id'=>$user_id, 'cluster_id'=>$cluster['id']));

		$item = array ('message' => $message, 'name' => $name, 'cluster' => $cluster);
		
		$vars['personal'] = $item;
		$vars['cluster'] = $cluster;
		
		$this->beex_email->generate_join_cluster_email($email, $vars);
		
	}



	function add_challengers() {

		$data = $this->data;
		$cluster_id = $this->uri->segment(3);

		$cluster_info = $this->MItems->getCluster($cluster_id, 'clusters.id');

		$data['item'] = $item = $cluster_info->row();

		if($_POST) {

			$recips = explode(',', $_POST['emails']);
			$cluster = array('id' => $item->theid, 'name' => $item->cluster_title);
			$eitem = array ('message' => $_POST['personal_message'], 'name' => 'You', 'cluster' => $cluster);
			
			$vars['cluster'] = $cluster;
			$vars['personal'] = $eitem;
			
			$this->beex_email->generate_join_cluster_email($recips, $vars);
			
			foreach($recips as $recipient){

				if(!($user_id = $this->MUser->get_user_by_email($recipient))) {

					$user_id = $this->MItems->add('users', array('email'=>$recipient, 'password'=>md5('password'), 'created' => date('Y-m-d H:i:s'), 'official' => 0));

					$this->MItems->add('profiles', array('user_id'=>$user_id, 'first_name'=>'YourName', 'last_name' => '', 'created' => date("Y-m-d H:i:s")));

				}
			}
		}


		$data['message'] = "Challengers Added";
		$data['cluster_id'] = $item->theid;

		$tempdata = $data;

		$data['data'] = $tempdata;


		$this->editor('', '', $item->theid, 'challengers', $data['message']);



	}

}

?>