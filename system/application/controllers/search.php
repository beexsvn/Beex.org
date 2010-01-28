<?php



class Search extends Controller {



	public $data;

	function Search() {

		parent::Controller();
		$this->load->model('MItems');
		$this->load->model('MSearch');
		$this->load->library('beex');
		$this->data['header']['title'] = 'Search Beex.org';
		$this->data['data']['message'] = '';
		$this->data['data']['item'] = '';
		$this->data['data']['username'] = $this->session->userdata('username');
		$this->data['data']['user_id'] = $this->session->userdata('user_id');
	}
	
	function index() {
		
		if($searchterm = $this->input->post('searchterm')) {
			
			$searchresults = $this->MSearch->getResults($searchterm);
			
			if($searchresults['challenges']->num_rows()){
				
				foreach($searchresults['challenges']->result() as $sresult) {
					
					print_r($sresult);
					echo "<BR><br>";
					
				}
				
			}
		}
		
		
		
	}


}

?>