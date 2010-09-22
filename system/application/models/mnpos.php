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
}

?>