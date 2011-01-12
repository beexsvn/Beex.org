<?php

class MNpos extends Model {
	
	function MNpos() {
		parent::Model();
		$this->tablename = 'npos';
	}
	
	function addNpo($data){
		
		if($this->db->insert($this->tablename, $data)) {
			return $this->db->insert_id();
		}
		else {
			return false;	
		}
	}
	
	function updateNpo($npo_id, $data) {
		if($this->db->update($this->tablename, $data, array('id'=>$npo_id))) {
			return true;	
		}
		else {
			return false;	
		}
	}
	
	function getNpos() {
		
		return $this->db->get($this->tablename);
			
	}
	
	function getNpo($npo_id) {	
		return $this->db->get_where($this->tablename, array('id'=>$npo_id));
	}
	
	function addTags($tags, $npo_id) {
		
		$tags = explode(',', $tags);
		
		foreach($tags as $tag) {
			$data = array('npo_id'=>$npo_id, 'tag'=>trim($tag));
			$this->db->insert('causetags', $data);
		}
	}
	
	function deleteTags($npo_id) {
		$this->db->delete('causetags', array('npo_id'=>$npo_id));
	}
	
	function getTags($npo_id) {
		$result = $this->db->get_where('causetags', array('npo_id'=>$npo_id));
		if($result->num_rows()) {
			return $result->result();
		}
	}
	
	function validate_admin($admin) {
		
		if($result = $this->db->get_where($this->tablename, array('admin_email'=>$admin['admin_email'], 'admin_password'=>md5($admin['admin_password'])))){
			//echo $this->db->last_query();
			if($result->num_rows()) {
				return $result;
			}
			else {
				return false;	
			}
		}
	}
	
	function valid_npo_admin($npo_id, $user_id) {
		if($result = $this->db->get_where('npos', array('user_id'=>$user_id, 'id'=>$npo_id))) {
			return ($result->num_rows()) ? true : false;
		}
	}
	
	function get_levels($id) {
		$this->db->order_by("amount");
		$levels = $this->db->get_where('subscription_levels', array('npo_id'=>$id, 'active'=>1));
		
		if($levels->num_rows()) {
			return $levels->result(); 
		}
		return false;
	}
	
	function add_level($id, $amount, $name) {
		$data = array(
			'npo_id' => $id,
			'amount' => $amount,
			'name' => $name,
			'created' => date('Y-m-d H:i:s'),
			'active' => 1
		);
		
		$this->db->insert('subscription_levels', $data);
	}
	
	function remove_level($id) {

		$this->db->update('subscription_levels', array('active'=>0), array('id'=>$id));
		echo $this->db->last_query();
	}
	
}

?>