<?php

class Ajax extends Controller { 
	
	function Ajax() {
		parent::Controller();
		
		$this->load->model('MItems');
		$this->data['header']['title'] = 'challenge';
		$this->data['data']['message'] = '';
		$this->data['data']['item'] = '';
	}
		
	function get_browsers() {
		
		if($_POST['type'] == 'challenges') {
			if($_POST['sort'] == 'featured') {
				echo $this->beex->create_browser($this->MItems->getChallenge(1, 'featured', 'challenges.created', 'desc', 5), 'challenges');
			}
			elseif($_POST['sort'] == 'ending') {
				echo $this->beex->create_browser($this->MItems->getChallenge(date('Y-m-d'), 'challenge_completion >', 'challenge_completion', 'asc', 5), 'challenges');
			}
			elseif($_POST['sort'] == 'new') {
				echo $this->beex->create_browser($this->MItems->getChallenge('', '', 'challenges.created', 'desc', 5), 'challenges');
			}
			else {
				echo $this->beex->create_browser($this->MItems->getChallenge('', '', 'challenges.created', 'asc', 5), 'challenges');
			}
				
		}	
		
		if($_POST['type'] == 'clusters') {
			if($_POST['sort'] == 'featured') {
				echo $this->beex->create_browser($this->MItems->getCluster(1, 'clusters.featured', 'clusters.created', 'desc', 5), 'clusters');
			}
			else {
				echo $this->beex->create_browser($this->MItems->getCluster('', '', 'clusters.created', 'asc', 5), 'clusters');
			}
				
		}	
		
		if($_POST['type'] == 'users') {
			if($_POST['sort'] == 'popular') {
				$browser = $this->MItems->get('profiles', '', '', 'created', 'desc');
			}
			else {
				$browser = $this->MItems->get('profiles', '', '', 'created', 'desc');
			}
		}
	}
	
	function delete_note($id) {
		
		$this->MItems->delete('notes', $id);
		
	}
	
	function delete_note($id) {
		
		$this->MItems->delete('note_replies', $id);
		
	}
	
}

?>