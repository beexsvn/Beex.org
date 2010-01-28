<?php

class MSearch extends Model {
	
	function MSearch() {
		parent::Model();
		$this->load->library('session');
	}
	
	function getResults($term) {
		
		$results['challenges'] = $this->getChallengeResults($term);
		
		return $results;
	}
	
	//Search the challenges table
	function getChallengeResults($term) {
		
		$this->db->from('challenges');
		$this->db->where("MATCH (challenge_title, challenge_declaration) AGAINST ('".$term."')", NULL, FALSE);
		
		return $this->db->get();
		
	}
	
}

?>