<?php 

class Pieces {
	
	function Pieces() {
		$CI =& get_instance();

		$CI->load->helper('url');
		$CI->load->library('session');
		
		$CI->config->item('base_url');	
	}
	
	function miniProfile($user_id, $thin = true) {
		
		$CI =& get_instance();
	
		$data['profile'] = $CI->MItems->getUser(array('users.id'=>$user_id))->row();
		$data['num_active'] = $CI->MItems->getChallenge(array('challenges.user_id'=>$user_id, 'challenges.active'=>1))->num_rows();
		
	
		$data['num_complete'] = $CI->MItems->getChallenge(array('challenges.user_id'=>$user_id, 'challenges.active'=>0))->num_rows();
		
		$piece = ($thin) ? 'mini_profile' : 'mini_profile_thick'; 

		return $CI->load->view('pieces/'.$piece, $data, true);
	}
	
	function miniNPO($npo_id, $thin = true) {
		
		$CI =& get_instance();
		
		$data['npo'] = $CI->MItems->getNPO($npo_id)->row();
		
		$piece = ($thin) ? 'mini_nonprofit' : 'mini_nonprofit_thick';
		
		return $CI->load->view('pieces/'.$piece, $data, true);
	}
	
	function miniCluster($cluster_id) {
		
		$CI =& get_instance();
		
		$data['cluster'] = $CI->MItems->getCluster($cluster_id)->row();
		
		return $CI->load->view('pieces/mini_cluster', $data, true);
	}
	
	function teammates($challenge_id) {
		
		$CI =& get_instance();
		
		$teammates = $CI->MItems->get('teammates', array('challenge_id' => $challenge_id));
		
		if($teammates->num_rows()) {
			
			foreach($teammates->result() as $row) {
				
				$teammate = $CI->MItems->getUser($row->user_id, 'users.id')->row();
				if(@$teammate->official) {
					$data['teammates'][] = $teammate;	
				}
			}
			
			if(sizeof($data['teammates']) > 1) 
				return $CI->load->view('pieces/teammates', $data, true);
		}
		
		
	}
}

?>