<?php

class MAdmins extends Model{
	
	function MAdmins(){
		parent::Model();
	}
	
	function verifyUser($u,$i,$type){
		
		$this->db->select('id');
		$this->db->limit(1);
		$this->db->where('user_id',$u);
		
		if($type == 'cluster') {
			$this->db->where('cluster_id', $i);
			$this->db->from('admins');
			
		}
		elseif($type == 'challenge') {
			$this->db->where('challenge_id', $i);
			$this->db->from('teammates');
		}
		
		$q = $this->db->get();
		
		if($q->num_rows() > 0) {
			return true;
		}
		elseif($this->session->userdata('super_user')) {
			return true;	
		}
		
		return false;
	}
}

?>