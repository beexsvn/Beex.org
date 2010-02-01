<?php



class MItems extends Model {



	function MItems() {

		parent::Model();

	}



	function add($table, $data){



		if($this->db->insert($table, $data)) {

			return $this->db->insert_id();

		}

		else {

			return false;

		}

	}

	function delete($table, $id, $key = 'id'){
		
		if($id) {
			if(is_array($id)) {
				$this->db->where($id);
			}
			else {
				$this->db->where($key, $id);
			}
		}

		if($this->db->delete($table)) {
			return true;
		}

		else {
			return false;
		}
	}



	function update($table, $id, $data) {

		if($id) {

			if(is_array($id)) {

				$this->db->where($id);

			}

			else {

				$this->db->where('id', $id);

			}

		}

		if($this->db->update($table, $data)) {

			return true;

		}

		else {

			return false;

		}

	}



	function get($table, $id='', $key='', $order='', $order_way='', $limit='', $offset='') {

		if($order) {

			$this->db->order_by($order, $order_way);

		}

		if($id) {

			if(is_array($id)) {

				$this->db->where($id);

			}

			else {

				$this->db->where($key, $id);

			}

		}



		return $this->db->get($table, $limit, $offset);



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



		if($result = $this->db->get_where('npodata', array('admin_email'=>$admin['admin_email'], 'admin_password'=>md5($admin['admin_password'])))){

			//echo $this->db->last_query();

			if($result->num_rows()) {

				return $result;

			}

			else {

				return false;

			}

		}

	}



	function getDonations($id = '', $key = 'id') {



		$this->db->select('*');

		$this->db->from('donors');



		if($key == 'cluster') {

			$this->db->join('challenges', 'challenges.id = donors.itemnumber');

			$this->db->join('clusters', 'clusters.id = challenges.cluster_id');

			$this->db->where('clusters.id', $id);

		}

		elseif($id) {

			if(is_array($id)) {

				$this->db->where($id);

			}

			else {

				$this->db->where($key, $id);

			}

		}



		return $this->db->get();

	}



	/* Challenge Functions */



	function getChallenge($id = '', $key='challenges.id', $order='', $order_way='', $limit='', $offset='') {

		$this->db->select('challenges.*, profiles.*, npos.name');

		$this->db->from('challenges');

		if($order) {

			$this->db->order_by($order, $order_way);

		}

		if($limit) {

			$this->db->limit($limit);

		}

		if($offset) {

			$this->db->offset($offset);

		}

		$this->db->join('profiles', 'profiles.user_id = challenges.user_id');

		$this->db->join('npos', 'npos.id = challenges.challenge_npo');

		if($id) {

			if(is_array($id)) {

				$this->db->where($id);

			}

			else {

				$this->db->where($key, $id);

			}

		}
		
		return $this->db->get();

	}
	
	function getChallengeByUser($id,$order='', $order_way='', $limit='', $offset='') {

		$this->db->select('challenges.*, profiles.*, npos.name');

		$this->db->from('challenges');

		if($order) {

			$this->db->order_by($order, $order_way);

		}

		if($limit) {

			$this->db->limit($limit);

		}

		if($offset) {

			$this->db->offset($offset);

		}

		$this->db->join('profiles', 'profiles.user_id = challenges.user_id');

		$this->db->join('npos', 'npos.id = challenges.challenge_npo');
		
		$this->db->join('teammates', 'teammates.challenge_id = challenges.id');
		$this->db->join('users', 'users.id = teammates.user_id');
		
		if($id) {

			if(is_array($id)) {

				$this->db->where($id);

			}

			else {

				$this->db->where('users.id', $id);

			}

		}



		return $this->db->get();

	}
	
	function hasTeammates($id) {
		
		$result = $this->db->get_where('teammates', array('challenge_id' => $id));

		return ($result->num_rows() > 1) ? 'We' : 'I';
		
	}



	/* Cluster Functions */



	function getCluster($id = '', $key='clusters.id', $order='', $order_way='', $limit='', $offset='') {

		$this->db->select('*, clusters.id AS theid');

		$this->db->from('clusters');

		if($order) {

			$this->db->order_by($order, $order_way);

		}

		if($limit) {

			$this->db->limit($limit);

		}

		if($offset) {

			$this->db->offset($offset);

		}

		$this->db->join('users', 'users.id = clusters.user_id');

		$this->db->join('profiles', 'profiles.user_id = users.id');

		if($id) {

			if(is_array($id)) {

				$this->db->where($id);

			}

			else {

				$this->db->where($key, $id);

			}

		}



		return $this->db->get();

	}



	function getClustersByUser($id = '', $key='clusters.id', $order='', $order_way='', $limit='', $offset='') {

		$this->db->select('clusters.*, profiles.*, clusters.id AS theid');
		$this->db->from('clusters');
		
		if($order) {
			$this->db->order_by($order, $order_way);
		}
		if($limit) {
			$this->db->limit($limit);
		}
		if($offset) {
			$this->db->offset($offset);
		}

		$this->db->join('users', 'users.id = clusters.user_id');
		$this->db->join('profiles', 'profiles.user_id = users.id');
		$this->db->join('challenges', 'challenges.cluster_id = clusters.id', 'left');
		$this->db->join('admins', 'admins.cluster_id = clusters.id');

		$this->db->where('challenges.user_id', $id);
		$this->db->or_where('admins.user_id', $id);
		
		$this->db->distinct();
		
		$clusters = $this->db->get();
		//echo $this->db->last_query();
		
		return $clusters;

	}





	/* User Functions */



	function getUser($id = '', $key='', $order='', $order_way='', $limit='', $offset='') {

		$this->db->select('*');

		$this->db->from('users, profiles');

		if($order) {

			$this->db->order_by($order, $order_way);

		}

		if($limit) {

			$this->db->limit($limit);

		}

		if($offset) {

			$this->db->offset($offset);

		}

		$this->db->where('profiles.user_id = users.id');

		if($id) {

			if(is_array($id)) {

				$this->db->where($id);

			}

			else {

				$this->db->where($key, $id);

			}

		}

		$this->db->where('users.official', '1');



		return $this->db->get();

	}



	/* NPO Functions */



	function getNPO($id = '', $key='id', $order='', $order_way='', $limit='', $offset='') {
		$this->db->select('*');
		$this->db->from('npos');
		if($order) {
			$this->db->order_by($order, $order_way);
		}
		if($limit) {
			$this->db->limit($limit);
		}
		if($offset) {
			$this->db->offset($offset);
		}	

		if($id) {
			if(is_array($id)) {
				$this->db->where($id);
			}
			else {
				$this->db->where($key, $id);
			}
		}

		// Make sure it's approved
		$this->db->where('approved', 1);
		return $this->db->get();
	}



	/* Activity Funcitons */

	function addActivity($type, $piece_id, $item_type, $item_id) {

		$data = array(

					  'type' => $type,

					  'piece_id' => $piece_id,

					  'item_type' => $item_type,

					  'item_id' => $item_id,

					  'created' => date('Y-m-d H:i:s')

					  );

		$this->db->insert('activity', $data);

	}



	function getActivities($item_type, $item_id) {

		return 	$this->get('activity', array('item_type' => $item_type, 'item_id'=>$item_id));

	}





	/* Gallery Functions */



	function getGallery($item, $item_type, $gallery_type = '') {

		$result = $this->db->get_where('galleries', array('item_id' => $item->id, 'item_type'=>$item_type, 'type'=>$gallery_type));

		return ($result->num_rows()) ? $result->row() : '';

	}
	
	function getProofGalleryId($item_id, $item_type) {
		
		$result = $this->db->get_where('galleries', array('item_id'=>$item_id, 'item_type'=>$item_type, 'type'=>'proof'));
		
		if($result->num_rows() > 0) {
			return $result->row()->id;
		}	
		else {
			return $this->add('galleries', array('item_id'=>$item_id, 'item_type'=>$item_type, 'type'=>'proof', 'created'=>date('Y-m-d H:i:s'), 'name'=>"Proof Gallery"));
		}
	}



	function getVideo($gallery_id) {

		$result = $this->db->get_where('media', array('gallery_id' => $gallery_id, 'type'=>'video'));



		return ($result->num_rows()) ? $result->row() : '';

	}
	
	function getMedia($id) {
		
		$result = $this->db->get_where('media', array('id'=>$id)); 
		
		return ($result->num_rows()) ? $result->row() : '';
		
	}




	/*Notes Functions */


 
	function getNotes($challenge_id) {

		$this->db->where('challenge_id', $challenge_id);



		$result = $this->db->get('notes');



		return ($result->num_rows()) ? $result->result() : '';

	}
 


	/* Other Functions */



	function getDropdownArray($table, $val, $key = 'id') {

		$result = $this->db->get($table);



		$array = array();



		foreach($result->result() as $row) {

			$array[$row->$key] = $row->$val;

		}



		return $array;

	}

}



?>