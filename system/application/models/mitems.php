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

		return ($this->db->update($table, $data)) ? true : false;
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

	function amountRaised($id) {
		
		$this->db->select('SUM(donors.mc_gross) AS raised');
		$this->db->from('donors');
		
		$this->db->where('donors.itemnumber', $id);
		
		$result = $this->db->get();
		
		return $result->row()->raised;
		
	}

	/* Challenge Functions */



	function getChallenge($id = '', $key='challenges.id', $order='', $order_way='', $limit='', $offset='') {

		$this->db->select('challenges.*, profiles.*, npos.name, challenges.created AS challenge_created');

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

		$this->db->select('challenges.*, profiles.*, npos.name, challenges.created AS challenge_created');
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
		

	/* Teammates Functions */
	function hasTeammates($id) {
		
		$result = $this->db->get_where('teammates', array('challenge_id' => $id));

		return ($result->num_rows() > 1) ? 'We' : 'I';
		
	}
	
	function getTeammates($id) {
		
		$this->db->select("users.id as id, profiles.first_name as first_name, profiles.last_name as last_name");
		$this->db->from('teammates');
		
		$this->db->join('users', 'users.id = teammates.user_id');
		$this->db->join('challenges', 'challenges.id = teammates.challenge_id');
		$this->db->join('profiles', 'profiles.user_id = users.id');
		
		$this->db->where('challenges.id', $id);
		
		return $this->db->get();
		
	}
	
	function isTeammate($id, $challenge_id) {
		
		$result = $this->db->get_where('teammates', array('challenge_id'=>$challenge_id, 'user_id'=>$id));
		
		return($result->num_rows()) ? TRUE : FALSE;
		
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
	
	function getClusterName($id) {
		
		$this->db->select('cluster_title');
		$this->db->from('clusters');
		$this->db->where('id', $id);
		
		$cluster = $this->db->get();
		
		if($row = $cluster->row()) {
			return $row->cluster_title;
		}
		else return false;
		
	}
	
	function get_cluster_invites($cluster_id, $type = false) {
		
		$this->db->select('*');
		$this->db->from('cluster_invites');
		$this->db->where('cluster_id', $cluster_id);
		
		if($type) {
			
			
		}
		
		$result = $this->db->get();
		if($result->num_rows()) {
			return $result->result();	
		}
		else {
			return false;
		}
		
	}


	/* Item Functions */
	
	function getItem($id = '', $key = 'id') {
		
		$this->db->select('*');
		$this->db->from('items');
		if($id) {
			if(is_array($id)) {
				$this->db->where(array($id));
			}
			else {
				$this->db->where($key, $id);
			}
		}
		
		$result = $this->db->get();
		
		return $result;
	}

	function process_new_item($id, $type, $created) {
		
		$item_array = array('type'=>$type, 'created'=>$created);
		
		if($item_id = $this->add('items', $item_array)) {
			$this->update($type.'s', array('id'=> $id), array('item_id'=>$item_id));
			return $item_id;
		}
		
	}
	
	function get_item_type($id) {
		
		return $this->get('items', array('id'=>$id))->row()->type;
	}
	
	function get_item_id($type, $id) {
		$item = $this->get($type.'s', array('id'=>$id));
		if($item->num_rows()) {
			return $item->row()->item_id;
		} 
		echo "<p>Not an item. Type: $type, ID: $id</p>";
		return false;
	}
	
	// Function to reterm specific type id
	function get_id($item_id) {
		$item = $this->get('items', array('id'=>$item_id));
		if($item->num_rows()) {
			$i = $item->row();
			$el = $this->get($i->type.'s', array('item_id'=>$item_id));
			if($el->num_rows()) {
				return $el->row()->id;
			}
			else {
				report_error('Not a valid element: '.$i->type);
			}
		}
		else {
			report_error("No Item");
		}
	}

	/* User Functions */



	function getUser($id = '', $key='users.id', $order='', $order_way='', $limit='', $offset='', $official = true) {

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
		if($official) {
			$this->db->where('users.official', '1');
		}
		return $this->db->get();

	}
	
	function getUserByChallenge($challenge_id) {
		
		$c = $this->getChallenge($challenge_id);
		if($user = $this->getUser($c->row()->user_id)) {
			return $user;
		}
		else {
			return false;
		}
		
	}



	/* NPO Functions */



	function getNPO($id = '', $key='id', $order='', $order_way='', $limit='', $offset='', $approved = true) {
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
		if($approved) {
			$this->db->where('approved', 1);
		}
		return $this->db->get();
	}
	
	function getSupporters($id = '') {
		$this->db->select('*');
		$this->db->from('donors');
		
		$this->db->where('itemnumber', $id);
		$this->db->where('itemname !=', 'NULL');
		$this->db->where('quantity', '');
		
		return $this->db->get();
		
	}	
	
	function does_user_have_organizations($user_id) {
		$npos = $this->getNPO(array('npos.user_id'=>$user_id));
		
		if($npos->num_rows()) {
			return $npos->row()->id;
		}
		else {
			// No NPOs for users id
		}
		return false;
	}



	/* Activity Funcitons */

	function addActivity($type, $piece_id, $item_id, $created = '') {
		
		if(!$created) {
			$created = date('Y-m-d H:i:s');
		}
		
		$data = array(

					  'type' => $type,
					  'piece_id' => $piece_id,
					  'item_id' => $item_id,
					  'created' => $created

					  );

		$this->db->insert('newactivity', $data);

	}

	function updateNoteActivity($id, $item_id, $type) {
		
		$update_array = array('type' => $type);
		
		$result = $this->db->get_where('newactivity', "piece_id = '$id' AND item_id = '$item_id' AND (type = 'note' OR type = 'proof')");
		
		if($result->num_rows()) {
			$act_id = $result->row()->id;
			$this->update('newactivity', array('id'=>$act_id), $update_array);
		}
		else {
			echo "BAD NEWS";
		}
	}

	function getActivities($item_type, $item_id) {

		
		return 	$this->get('activity', array('item_type' => $item_type, 'item_id'=>$item_id, 'type !=' => 'join'), '', 'created', 'DESC');

	}
	
	function getNewActivities($item_id) {

		
		return 	$this->get('newactivity', array('item_id'=>$item_id, 'type !=' => 'join'), '', 'created', 'DESC');

	}
	
	/*function getClusterActivities($id) {
		$this->db->select('newactivity.*');
		$this->db->from('clusters');
		
		
		$this->db->join('challenges', 'challenges.cluster_id = clusters.id', 'left');
		$this->db->join('newactivity', 'newactivity.item_id = challenges.item_id');
		
		$this->db->order_by('newactivity.created', 'DESC');
		//$this->db->distinct();
		//$this->db->group_by('activity.item_id');
		$this->db->where('clusters.item_id = "'.$id.'" OR newactivity.item_id = "'.$id.'"');
		
		return $this->db->get();
	}*/
	
	function getClusterActivities($id) {
		$this->db->select('newactivity.*');
		$this->db->from('clusters, newactivity');
		
		
		$this->db->join('challenges', 'challenges.cluster_id = clusters.id', 'left');
		
		$this->db->order_by('newactivity.created', 'DESC');
		$this->db->distinct();
		//$this->db->group_by('activity.item_id');
		$this->db->where('(clusters.item_id = "'.$id.'" AND newactivity.item_id = challenges.item_id) OR newactivity.item_id = "'.$id.'"');
		
		return $this->db->get();
	}
	
	function noProof($id) {
		
		$result = $this->db->get_where('activity', array('item_id' => $id, 'type'=>'proof'));
		
		if($result->num_rows()) {
			return false;
		}
		return true;
		
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

		$result = $this->get('notes', $challenge_id, 'challenge_id', 'created', 'DESC');

		return ($result->num_rows()) ? $result->result() : '';

	}
	
	function getReplies($id, $type = 'notes') {
		
		if($type == 'notes') {
			$from = 'note_replies';				
		}
		
		$this->db->where('note_id', $id);
		$this->db->from($from);
		
		$result = $this->db->get();
		
		return ($result->num_rows()) ? $result->result() : '';
	}
 


	/* Other Functions */



	function getDropdownArray($table, $val, $key = 'id') {
		
		if($table == 'npos') {
			$result = $this->get($table, array('approved'=>'1'));
		}
		else {
			$result = $this->get($table);
		}		
		$array = array();

		foreach($result->result() as $row) {		
			$array[$row->$key] = $row->$val;
		}
		return $array;
	}

}



?>