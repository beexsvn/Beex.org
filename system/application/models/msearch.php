<?php

class MSearch extends Model {
	
	function MSearch() {
		parent::Model();
		$this->load->library('session');
	}
	
	function getResults($term) {
		
		$results['challenges'] = $this->getChallengeResults($term);
		$results['clusters'] = $this->getClustersResults($term);
		$results['people'] = $this->getPeopleResults($term);
		$results['npos'] = $this->getNposResults($term);
		
		return $results;
	}
	
	//Search the challenges table
	function getChallengeResults($term, $cluster_id = '') {
		
		$this->db->select('challenges.*, profiles.*, npos.name');
		$this->db->from('challenges');
		
		$this->db->join('profiles', 'profiles.user_id = challenges.user_id');
		$this->db->join('npos', 'npos.id = challenges.challenge_npo');
		
		$cluster_query = '';
		if($cluster_id) {
			$cluster_query = " AND cluster_id='$cluster_id'";
		}
		
		$this->db->where("(MATCH (challenge_title, challenge_declaration, challenge_location, challenge_address1, challenge_address2, challenge_city, challenge_state, challenge_zip, challenge_blurb, challenge_description, challenge_whydo, challenge_whycare) AGAINST ('".addslashes($term)."') OR MATCH(profiles.first_name, profiles.last_name) AGAINST ('".addslashes($term)."'))$cluster_query", NULL, FALSE);
		
		
		
		return $this->db->get();
		
	}
	
	//Search the clusters table
	function getClustersResults($term) {
		
		$this->db->select('clusters.*, clusters.id AS theid, profiles.*, npos.name');
		$this->db->from('clusters');
		
		$this->db->join('profiles', 'profiles.user_id = clusters.user_id');
		$this->db->join('npos', 'npos.id = clusters.cluster_npo');
		
		
		$this->db->where("(MATCH (cluster_title, cluster_blurb, cluster_description, cluster_location, cluster_link) AGAINST ('".addslashes($term)."') OR MATCH(profiles.first_name, profiles.last_name) AGAINST ('".addslashes($term)."'))", NULL, FALSE);
		
		
		
		return $this->db->get();
		
	}
	
	//Search the npos table
	function getNposResults($term) {
		
		$this->db->select('npos.*');
		$this->db->from('npos');
		
		$this->db->where("(MATCH (name, address_street, address_city, address_state, address_zip, website, contact_firstname, contact_lastname, contact_title, contact_email, contact_phone, about_us, mission_statement, blurb) AGAINST ('".addslashes($term)."'))", NULL, FALSE);
		
		
		
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
	
	function search_cluster($id, $term) {
		$results = $this->getChallengeResults($term, $id);
		return $results;
	}
}

?>