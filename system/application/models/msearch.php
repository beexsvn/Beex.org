<?php

class MSearch extends Model {
	
	function MSearch() {
		parent::Model();
		$this->load->library('session');
	}
	
	function getResults($term) {
		
		$results['challenges'] = $this->getChallengeResults($term);
		$results['people'] = $this->getPeopleResults($term);
		
		return $results;
	}
	
	//Search the challenges table
	function getChallengeResults($term) {
		
		$this->db->select('challenges.*, profiles.*, npos.name');
		$this->db->from('challenges');
		
		$this->db->join('profiles', 'profiles.user_id = challenges.user_id');
		$this->db->join('npos', 'npos.id = challenges.challenge_npo');
		
		$this->db->where("MATCH (challenge_title, challenge_declaration, challenge_location, challenge_address1, challenge_address2, challenge_city, challenge_state, challenge_zip, challenge_blurb, challenge_description, challenge_whydo, challenge_whycare) AGAINST ('".$term."')", NULL, FALSE);
		return $this->db->get();
		
	}
	
	// Search people table
	function getPeopleResults($term) {

		$this->db->select('*');
		$this->db->from('users, profiles');	
		
		$this->db->where('profiles.user_id = users.id');
		$this->db->where('users.official', '1');
		$this->db->where("MATCH (first_name, last_name, hometown, zip, whycare, blurb) AGAINST ('".$term."')", NULL, FALSE);
		
		return $this->db->get();
	}
}

?>