<?php

class Site extends Controller { 
	
	public $data;
	public $table_name;	
	
	function Site() {
		parent::Controller();
		
		$this->load->model('MItems');
		$this->data['header']['title'] = 'Beex.org';
		$this->data['data']['message'] = '';
		$this->data['data']['item'] = '';
		$this->data['username'] = $this->session->userdata('username');
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
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('user_id');
		
		redirect('site', 'refresh');
	}
	
	
	
	
}

?>