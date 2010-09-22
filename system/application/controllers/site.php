<?php

class Site extends Controller { 
	
	public $data;
	public $table_name;	
	
	function Site() {
		parent::Controller();
		
		$this->load->model('MItems');
		$this->data['header']['title'] = 'BEEx.org';
		$this->data['data']['message'] = '';
		$this->data['data']['item'] = '';
		$this->data['username'] = $this->session->userdata('username');
		$this->data['user_id'] = $this->session->userdata('user_id');
		$this->table_name = 'challenges';
	}
	
	function index() {
		$data = $this->data;
		
		$browser = $this->MItems->getChallenge('', '', 'challenges.created', 'desc', 8);
		
		$data['browser'] = $browser;
	
		if($id = $this->session->userdata('user_id')) {

			$profile = $this->MItems->get('profiles', $id, 'user_id');

			$first_name = $profile->row()->first_name;

		}
		
		$data['username'] = (@$first_name) ? $first_name : '';
	
		$this->load->view('home', $data);
	}
	
	function logout() {
	
		$unset_items = array('super_user' => '', 'username'=> '', 'user_id'=>'');
		$this->session->unset_userdata($unset_items);
		$this->session->userdata('super_user', '');
		redirect('site', 'refresh');
	}
	
	function regmenu() {
	
		$this->load->view('framework/regmenu');
		
	}
	
	function header($ex_head = false) {
		$data['title'] = 'BEEx.org Header';
		$data['external_header'] = $ex_head;
		$this->load->view('framework/header', $data);
	}
	
}

?>