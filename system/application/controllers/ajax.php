<?php

class Ajax extends Controller { 
	
	function Ajax() {
		parent::Controller();
		
		$this->load->model('MItems');
		$this->data['header']['title'] = 'challenge';
		$this->data['data']['message'] = '';
		$this->data['data']['item'] = '';
	}

	function challenge_what() {
		$challenge_info_post = $_POST;
		$challenge_info = $this->session->userdata("challenge_info");
		foreach($challenge_info_post as $key=>$val) {
			$challenge_info[$key] = $val;
		}
		$this->session->set_userdata("challenge_info", $challenge_info);
		$this->session->set_userdata("challenge_creation_step", "when_where");
		echo json_encode(array('success' => true));  // or we could do some error validation, whatevs
				
		return;
	}
	
	function challenge_when_where() {
		$challenge_info_post = $_POST;
		$challenge_info = $this->session->userdata("challenge_info");
		foreach($challenge_info_post as $key=>$val) {
			$challenge_info[$key] = $val;
		}
		$this->session->set_userdata("challenge_info", $challenge_info);
		$this->session->set_userdata("challenge_creation_step", "why");
		echo json_encode(array('success' => true));  // or we could do some error validation, whatevs
		return;		
	}
	
	function challenge_why() {
		$challenge_info_post = $_POST;
		$challenge_info = $this->session->userdata("challenge_info");
		foreach($challenge_info_post as $key=>$val) {
			$challenge_info[$key] = $val;
		}
		$this->session->set_userdata("challenge_info", $challenge_info);
//		$this->session->unsetset_userdata("challenge_creation_step");// wtf? buggy
	
		
		
		$_POST = $challenge_info; 
		$edit_id = $this->session->userdata('edit_id');
		
				
		$_POST['user_id'] = $this->session->userdata['user_id'];
		
		// Process Teammate 
		if(@$_POST['teammate_email']) {
			$teammate = array('name'=>@$_POST['teammate_name'], 'email'=>$_POST['teammate_email']);
			unset($_POST['teammate_email'], $_POST['teammate_name']);
		}



		// these fields do not yet exist in the db...
		unset($_POST['proof_description']);
		unset($_POST['partner_bool']);
		unset($_POST['partner_name']);
		unset($_POST['partner_email']);
		
		// Process Special Fields
		$_POST['challenge_completion'] = ($_POST['challenge_completion']) ? date('Y-m-d', strtotime($_POST['challenge_completion'])) : '';
		$_POST['challenge_fr_completed'] = ($_POST['challenge_fr_completed']) ? date('Y-m-d', strtotime($_POST['challenge_fr_completed'])) : '';
		$_POST['challenge_proof_upload'] = ($_POST['challenge_proof_upload']) ? date('Y-m-d', strtotime($_POST['challenge_proof_upload'])) : '';

		foreach($_POST as $key => $val) {
			if(!$val) {
				unset($_POST[$key]);	
			}
		}
		

		
		if(isset($edit_id) && $edit_id != '') {

			unset($_POST['user_id']);		
			$this->MItems->update('challenges', $edit_id, $_POST);
			$ret['challenge_id'] = $edit_id;
			$ret['success'] = true;
			$this->session->unset_userdata('edit_id');
			echo json_encode($ret);
			return;

		}
		elseif($challenge_id = $this->MItems->add('challenges', $_POST)) {
			$data['message'] = $_POST['challenge_title']." has successfully been created.";
			$this->MItems->add('teammates', array('user_id'=>$_POST['user_id'], 'challenge_id'=>$challenge_id));
			if(@$teammate) {
				$this->add_teammate($teammate, array('id'=>$challenge_id, 'name'=>$_POST['challenge_title']));
			}
			$ret['challenge_id'] = $challenge_id;			
		}
		else {
			$data['message'] = "We're sorry, there has been a problem processing your request.";

		}

		$data['data']['new'] = true;

		$ret['success'] = true;
		echo json_encode($ret);
		return;		
	}
	
	
	function image_upload() {
		
		$filename = strip_tags($_REQUEST['filename']);
		$maxSize = strip_tags($_REQUEST['maxSize']);
		$maxW = strip_tags($_REQUEST['maxW']);
		$fullPath = strip_tags($_REQUEST['fullPath']);
		$relPath = strip_tags($_REQUEST['relPath']);
		$colorR = strip_tags($_REQUEST['colorR']);
		$colorG = strip_tags($_REQUEST['colorG']);
		$colorB = strip_tags($_REQUEST['colorB']);
		$maxH = strip_tags($_REQUEST['maxH']);
		
		
		$filesize_image = $_FILES[$filename]['size'];
		if($filesize_image > 0){			
			$upload_result = $this->beex->do_upload($_FILES, 'filename', './media/challenges/');
			$upload_filepath = base_url() . 'media/challenges/' . $upload_result;
			$upload_metadata = $this->upload->data();

			$width = $upload_metadata['image_width'];
			$height = $upload_metadata['image_height'];
			$challenge_info = $this->session->userdata("challenge_info");
			$challenge_info['challenge_image'] = $upload_result;
			$this->session->set_userdata("challenge_info", $challenge_info);			
			echo <<<IMG
				<img src="{$upload_filepath}">
IMG;
			
/*
** LIGHTBOX CODE **

			echo <<<POPUP
<a href="javascript:void(0)" onclick="document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block'"><img src="{$upload_filepath}"></a>
			<div id="light" class="white_content" style="height:{$height};width:{$width}"><a href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'"><img src="{$upload_filepath}"></a></div>
			<div id="fade" class="black_overlay"></div>			
			<script type="text/javascript">
			$("#light").height({$height});
			$("#light").width({$width});
			$("#light").click(function() {
				document.getElementById('light').style.display='none';
				document.getElementById('fade').style.display='none';
			});		
			</script>
POPUP;
*/
			$imgUploaded = true;
		}
		else {
			$imgUploaded = false;
		}


	}
	
	

	function login_user() {
		/* Only called in context of challenge creation */		
		if($result = $this->MUser->validate_user($_POST['email'], $_POST['password'])) {
		
			$user = $result->row();

			$userdata = array('logged_in'=>true, 'user_id'=>$user->id, 'username'=>$user->email);
			if($_POST['email'] == 'zkilgore@gmail.com' || $_POST['email'] == 'devin@beex.org' || $_POST['email'] == 'matt@beex.org') {
				$userdata['super_user'] = true;	
			}
			$userdata['challenge_creation_step'] = 'what';
			$this->session->set_userdata($userdata);			
			$this->MItems->update('users', array('id'=>$user->id), array('official'=>'1'));
			echo json_encode(array('success'=>true));
						
		}

		else {
			echo json_encode(array('success'=>false, 'errors' => 'There was a problem with your information. Please try again.'));
		}
		
	}

	
	function create_user() {
		/* Only called in the context of challenge creation. */

		$full_name = $_POST['legal_name'];
		$full_name_words = split(' ', $full_name);
		// these variables are actually part of the profiles table..
//		$user['last_name'] = array_pop($full_name_words);  
//		$user['first_name'] = join(' ', $full_name_words);
 
		$user['created'] = date("Y-m-d H:i:s");
		$user['email'] = $_POST['email'];
		$user['password'] = md5($_POST['password']);
		$user['official'] = 1;
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email|callback_username_check');
		if ($this->form_validation->run() == FALSE) {
			echo json_encode(array('success'=>false, 'errors' => validation_errors()));
			return;
		}
		else {
			$id = $this->MItems->add('users', $user);
			$userdata = array('logged_in'=>true, 'user_id'=>$id, 'username'=>$_POST['email'], 'challenge_creation_step'=> 'what');		
			$this->session->set_userdata($userdata);
			echo json_encode(array('success'=>true));
		}
		
		
	}

	function username_check($str)
	{

		if ($this->MUser->checkUsername($str))
		{
			$this->form_validation->set_message('username_check', 'This email is already in the system');
			return FALSE;
		}
		else
		{
			return TRUE;
		}

	}
	
	
	function delete_note($id) {
		
		$this->MItems->delete('notes', $id);
		
	}
	
	function delete_note_reply($id) {
		
		$this->MItems->delete('note_replies', $id);
		
	} 	
	
	// function get_browsers() {
	// 	
	// 	if($_POST['type'] == 'challenges') {
	// 		if($_POST['sort'] == 'featured') {
	// 			echo $this->~->create_browser($this->MItems->getChallenge(1, 'featured', 'challenges.created', 'desc', 5), 'challenges');
	// 		}
	// 		elseif($_POST['sort'] == 'ending') {
	// 			echo $this->beex->create_browser($this->MItems->getChallenge(date('Y-m-d'), 'challenge_completion >', 'challenge_completion', 'asc', 5), 'challenges');
	// 		}
	// 		elseif($_POST['sort'] == 'new') {
	// 			echo $this->beex->create_browser($this->MItems->getChallenge('', '', 'challenges.created', 'desc', 5), 'challenges');
	// 		}
	// 		else {
	// 			echo $this->beex->create_browser($this->MItems->getChallenge('', '', 'challenges.created', 'asc', 5), 'challenges');
	// 		}
	// 			
	// 	}	
	// 	
	// 	if($_POST['type'] == 'clusters') {
	// 		if($_POST['sort'] == 'featured') {
	// 			echo $this->beex->create_browser($this->MItems->getCluster(1, 'clusters.featured', 'clusters.created', 'desc', 5), 'clusters');
	// 		}
	// 		else {
	// 			echo $this->beex->create_browser($this->MItems->getCluster('', '', 'clusters.created', 'asc', 5), 'clusters');
	// 		}
	// 			
	// 	}	
	// 	
	// 	if($_POST['type'] == 'users') {
	// 		if($_POST['sort'] == 'popular') {
	// 			$browser = $this->MItems->get('profiles', '', '', 'created', 'desc');
	// 		}
	// 		else {
	// 			$browser = $this->MItems->get('profiles', '', '', 'created', 'desc');
	// 		}
	// 	}
	// }
	// 
}

?>