<?php

class Gallery { 
	
	public $data;
	public $table_name;	
	
	function Gallery() {
		$CI =& get_instance();
		
		$CI->load->library('Beex');

	}
	
	function index() {
	
	}
	
	function new_media() {
		
		$CI =& get_instance();
		
		$itemtype = $CI->uri->segment(3);
		$itemid = $CI->uri->segment(4);
		$galleryid = $CI->uri->segment(5);
		
		if($galleryid == 'proof') {
			$galleryid = $CI->get_gallery($itemid, $itemtype, $galleryid);
		}
		
		$data['header']['title'] = "Add Media";
		$data['data']['galleryid'] = $galleryid;
		$data['data']['itemid'] = $itemid;
		$data['data']['itemtype'] = $itemtype;
		$data['data']['message'] = '';
		$data['data']['item'] = '';
		
		$CI->load->view('new_media', $data);
		
	}
	
	function view_gallery($item_id, $table) {
		$CI =& get_instance();
		
		$gallery = $CI->MItems->getGallery($item_id, $table);
		$gallery_id = $gallery->id;
		
		$media = $CI->MItems->get('media', $gallery_id, 'gallery_id');
		
		$data['media'] = ($media->num_rows()) ? $media : '';
		$data['gallery'] = $gallery;
		 
		$CI->load->view('view_gallery', $data);
		
	}
	
	function view_proof_gallery($item_id, $owner = false) {
		$CI =& get_instance();
		
		$gallery_id = $CI->MItems->getProofGalleryId($item_id, 'challenge');
		
		$media = $CI->MItems->get('media', $gallery_id, 'gallery_id');
		
		$data['media'] = ($media->num_rows()) ? $media : ''; 
		$data['item_id'] = $item_id;
		$data['owner'] = $owner;
		//$data['gallery'] = $gallery;
		 
		$CI->load->view('view_proof_gallery', $data);
		
	}
	
	function view_gallery_backup() {
		$CI =& get_instance();
		
		$gallery_id = $CI->uri->segment(3);
		
		$media = $CI->MItems->get('media', $gallery_id, 'gallery_id');
		$gallery = $CI->MItems->get('galleries', $gallery_id, 'id');
		$gallery = $gallery->row();
		
		$item = $CI->MItems->get($gallery->item_type.'s', $gallery->item_id, 'id');
		$data['item'] = $item->row();
		$profile = $CI->MItems->get('profiles', $data['item']->user_id, 'user_id');
		
		
		$data['media'] = $media;
		$data['header']['title'] = "View Gallery";
		$data['gallery'] = $gallery;
		$data['profile'] = $profile->row();
		$data['message'] = '';
		
		$CI->load->view('view_gallery', $data);
		
	}
	
	function view_media() {
		$CI =& get_instance();
		$id = $CI->uri->segment(3);
		
		$media = $CI->MItems->get('media', $id, 'id');
		$media = $media->row();
		$gallery = $CI->MItems->get('galleries', $media->gallery_id, 'id');
		$gallery = $gallery->row();
		
		$prev = '';
		$next = '';
		$m = $CI->MItems->get('media', $gallery->id, 'gallery_id');
		if($m->num_rows()) {
			
			$nextdone = 0;
			foreach($m->result() as $row) {
				if($nextdone == 1) {
					$next = $row->id;
					break;
				}
				if($row->id == $id) {
					$nextdone++;	
				}
				if($nextdone == 0) {
					$prev = $row->id;	
				}
			}
		}
		
		$data['next'] = $next;
		$data['prev'] = $prev; 
		
		$item = $CI->MItems->get($gallery->item_type.'s', $gallery->item_id, 'id');
		$data['item'] = $item->row();
		$profile = $CI->MItems->get('profiles', $data['item']->user_id, 'user_id');
		
		
		$data['media'] = $media;
		$data['header']['title'] = "View Gallery";
		$data['gallery'] = $gallery;
		$data['profile'] = $profile->row();
		$data['message'] = '';
		
		$CI->load->view('view_media', $data);
		
	}
	
	
	function get_gallery($itemid, $itemtype, $gallerytype = '') {
		
		$CI =& get_instance();
		
		$result = $CI->MItems->get('galleries', array('item_type'=>$itemtype, 'item_id'=>$itemid, 'type'=>$gallerytype));
		if($result->num_rows()) {
			//echo "MADE IT TO GET GALLERY";
			//print_r($result);
			$gallery = $result->row();
			return $gallery->id;
		}
		else {
			$data = array('item_type'=>$itemtype, 'item_id'=>$itemid, 'type'=>$gallerytype, 'name'=>($gallerytype == 'proof') ? 'Proof Gallery' : 'Default Gallery');
			$gallery_id = $CI->MItems->add('galleries', $data);
			if(!$gallery_id) echo "FUCK";
			return $gallery_id;
		}
		
	}
	
	function process() {
		
		$CI =& get_instance();
		
		$data = $CI->data;
		
		$id = $CI->uri->segment(4,'add');
		$type = $CI->uri->segment(3);
		
		$CI->load->library('form_validation');
		
		/*
		if(!$CI->session->userdata('logged_in')) {
			$CI->form_validation->set_rules('email', 'User Email', 'trim|required');
			$CI->form_validation->set_rules('password', 'User Password', 'trim|require');
		}
		*/
		
		// Required fields
	
		//Value fields
		$CI->form_validation->set_rules('caption', 'Caption', 'trim');
		$CI->form_validation->set_rules('itemtype', 'Item Type', 'trim');
		$CI->form_validation->set_rules('itemid', 'Item ID', 'trim');
		$CI->form_validation->set_rules('galleryid', 'Gallery ID', 'trim');
		
		
		if ($CI->form_validation->run() == FALSE)
		{
			$data['message'] = "Please fill out all the required fields.";
		}
		else {
				
			if($type == 'image' ) {		
				
				foreach($_POST as $key => $val) {
					if(!$val) {
						unset($_POST[$key]);	
					}
				}
				
				// Process Special Fields
				if($_FILES['file']['name']) {
					$_POST['link'] = $CI->beex->do_upload($_FILES, 'file', './media/'.$_POST['item_id']);	
				}
				elseif($id == 'add') {
					$_POST['link'] == '';	
				}
				
				$_POST['created'] = date('Y-m-d H:i:s');
				
				if(!$_POST['gallery_id']){
					$_POST['gallery_id'] = $CI->get_gallery($_POST['item_id'], $_POST['item_type']);
				}
				
				$data['data']['itemid'] = $_POST['item_id'];
				$data['data']['itemtype'] = $_POST['item_type'];
				$data['data']['galleryid'] = $_POST['gallery_id'];
				
				if($id == 'add') {
					if($_POST['link']) {
						$item_id = $_POST['item_id'];
						$item_type = $_POST['item_type'];
						
						unset($_POST['item_id'], $_POST['item_type']);
						
						if($media_id = $CI->MItems->add('media', $_POST)) {
							$data['message'] = "Image has successfully been created.";
							$CI->MItems->addActivity('media', $media_id, $item_type, $item_id);
						}
						else {
							$data['message'] = "We're sorry, there has been a problem processing your request.";
						}
					}
					else {
						$data['message'] = "Youre image could not be uploaded";	
					}
					
				}
				else {
					if($CI->MNpos->update($id, $_POST)) {
						
						$data['message'] = $_POST['challenge_title']." has successfully been updated.";
					}
					else {
						$data['message'] = "We're sorry, there has been a problem processing your request.";
					}
					
					$item = $CI->MItems->getItem($CI->table_name, $id);
					$data['item'] = $item->row();
				
				}
			}
			
			if($type == 'video' ) {		
				
				foreach($_POST as $key => $val) {
					if(!$val) {
						unset($_POST[$key]);	
					}
				}
				
				// Process Special Fields
				
				$_POST['created'] = date('Y-m-d H:i:s');
				
				if(!$_POST['gallery_id']){
					$_POST['gallery_id'] = $CI->get_gallery($_POST['item_id'], $_POST['item_type']);
				}
				
				$data['data']['itemid'] = $_POST['item_id'];
				$data['data']['itemtype'] = $type;
				$data['data']['galleryid'] = $_POST['gallery_id'];
				
				if($id == 'add') {
					if($_POST['link']) { 
						$item_id = $_POST['item_id'];
						$item_type = $type;
						
						$_POST['type'] = $type;
						
						unset($_POST['item_id'], $_POST['item_type']);
						
						if($media_id = $CI->MItems->add('media', $_POST)) {
							$data['message'] = "Video has successfully been created.";
							$CI->MItems->addActivity('media', $media_id, $item_type, $item_id);
						}
						else {
							$data['message'] = "We're sorry, there has been a problem processing your request.";
						}
					}
					else {
						$data['message'] = "Youre video could not be embedded";	
					}
					
				}
				else {
					if($CI->MNpos->update($id, $_POST)) {
						
						$data['message'] = $_POST['challenge_title']." has successfully been updated.";
					}
					else {
						$data['message'] = "We're sorry, there has been a problem processing your request.";
					} 
					
					$item = $CI->MItems->getItem($CI->table_name, $id);
					$data['item'] = $item->row();
				
				}
			}
		}
		
		$data['data']['message'] = $data['message']; 
		$data['header']['title'] = "Add Media";
		$data['data']['item'] = '';

		if($id == 'add') {
			$CI->load->view('new_media', $data);
		}
		
	}
	
}

?>