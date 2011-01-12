<?php

class Gallery extends Controller { 
	
	public $data;
	public $table_name;	
	
	function Gallery() {
		parent::Controller();
		$this->load->library('Beex');

	}
	
	function index() {
	
	}
	
	function new_media() {
		
		$itemtype = $this->uri->segment(3);
		$itemid = $this->uri->segment(4);
		$galleryid = $this->uri->segment(5);
		
		if($galleryid == 'proof') {
			$galleryid = $this->get_gallery($itemid, $itemtype, $galleryid);
		}
		
		$data['header']['title'] = "Add Media";
		$data['data']['galleryid'] = $galleryid;
		$data['data']['itemid'] = $itemid;
		$data['data']['itemtype'] = $itemtype;
		$data['data']['message'] = '';
		$data['data']['item'] = '';
		
		$this->load->view('new_media', $data);
		
	}
	
	function view_gallery() {
		
		$gallery_id = $this->uri->segment(3);
		
		$media = $this->MItems->get('media', $gallery_id, 'gallery_id');
		$gallery = $this->MItems->get('galleries', $gallery_id, 'id');
		$gallery = $gallery->row();
		
		$item = $this->MItems->get($gallery->item_type.'s', $gallery->item_id, 'id');
		$data['item'] = $item->row();
		$profile = $this->MItems->get('profiles', $data['item']->user_id, 'user_id');
		
		
		$data['media'] = $media;
		$data['header']['title'] = "View Gallery";
		$data['gallery'] = $gallery;
		$data['profile'] = $profile->row();
		$data['message'] = '';
		
		$this->load->view('view_gallery', $data);
		
	}
	
	function view_media() {
		
		$id = $this->uri->segment(3);
		
		$media = $this->MItems->get('media', $id, 'id');
		$media = $media->row();
		$gallery = $this->MItems->get('galleries', $media->gallery_id, 'id');
		$gallery = $gallery->row();
		
		$prev = '';
		$next = '';
		$m = $this->MItems->get('media', $gallery->id, 'gallery_id');
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
		
		$item = $this->MItems->get($gallery->item_type.'s', $gallery->item_id, 'id');
		$data['item'] = $item->row();
		$profile = $this->MItems->get('profiles', $data['item']->user_id, 'user_id');
		
		
		$data['media'] = $media;
		$data['header']['title'] = "View Gallery";
		$data['gallery'] = $gallery;
		$data['profile'] = $profile->row();
		$data['message'] = '';
		
		$this->load->view('view_media', $data);
		
	}
	
	
	function get_gallery($itemid, $itemtype, $gallerytype = '') {
		
		$result = $this->MItems->get('galleries', array('item_type'=>$itemtype, 'item_id'=>$itemid, 'type'=>$gallerytype));
		if($result->num_rows()) {
			//echo "MADE IT TO GET GALLERY";
			//print_r($result);
			$gallery = $result->row();
			return $gallery->id;
		}
		else {
			$data = array('item_type'=>$itemtype, 'item_id'=>$itemid, 'type'=>$gallerytype, 'name'=>($gallerytype == 'proof') ? 'Proof Gallery' : 'Default Gallery');
			$gallery_id = $this->MItems->add('galleries', $data);
			if(!$gallery_id) echo "FUCK";
			return $gallery_id;
		}
		
	}
	
	function process() {
		
		$data = $this->data;
		
		$id = $this->uri->segment(4,'add');
		$type = $this->uri->segment(3);
		
		$this->load->library('form_validation');
		
		/*
		if(!$this->session->userdata('logged_in')) {
			$this->form_validation->set_rules('email', 'User Email', 'trim|required');
			$this->form_validation->set_rules('password', 'User Password', 'trim|require');
		}
		*/
		
		// Required fields
	
		//Value fields
		$this->form_validation->set_rules('caption', 'Caption', 'trim');
		$this->form_validation->set_rules('itemtype', 'Item Type', 'trim');
		$this->form_validation->set_rules('itemid', 'Item ID', 'trim');
		$this->form_validation->set_rules('galleryid', 'Gallery ID', 'trim');
		
		
		if ($this->form_validation->run() == FALSE)
		{
			$data['message'] = "Please fill out all the required fields.";
		}
		else {
		
				
			if($type == 'image' || true) {		
				
				if($id == 'add') {
					foreach($_POST as $key => $val) {
						if(!$val) {
							unset($_POST[$key]);	
						}
					}
				}	
				unset($_POST['y'], $_POST['x']);	
				
				// Process Special Fields
				if($_FILES['file']['name']) {
					$_POST['filename'] = $this->beex->do_upload($_FILES, 'file', './media/'.$_POST['item_id']);	
				}
				elseif($id == 'add') {
					$_POST['filename'] = '';	
				}
				
				if($id == 'add') {
					$_POST['created'] = date('Y-m-d H:i:s');
				}
				
				if(!$_POST['gallery_id']){
					$_POST['gallery_id'] = $this->get_gallery($_POST['item_id'], $_POST['item_type']);
				}
				
				$data['data']['itemid'] = $_POST['item_id'];
				$data['data']['itemtype'] = $_POST['item_type'];
				$data['data']['galleryid'] = $_POST['gallery_id'];
				
				if($id == 'add') {
					$item_id = $_POST['item_id'];
					$item_type = $_POST['item_type'];
						
					unset($_POST['item_id'], $_POST['item_type']);
					
					if($media_id = $this->MItems->add('media', $_POST)) {
						$data['message'] = "Media has successfully been created.";
						$this->MItems->addActivity('proof', $media_id, $item_type, $item_id);
						redirect($item_type.'/view/'.$item_id, 'refresh');
					}
					else {
						$data['message'] = "We're sorry, there has been a problem processing your request.";
					}
					
				}
				else {
					
					$item_id = $_POST['item_id'];
					$item_type = $_POST['item_type'];
						
					unset($_POST['item_id'], $_POST['item_type']);
					
					if($this->MItems->update('media', $id, $_POST)) {
						
						$data['message'] =  "Image has successfully been updated.";
						redirect($item_type.'/view/'.$item_id, 'refresh');
					}
					else {
						$data['message'] = "We're sorry, there has been a problem processing your request.";
					}
					
					$item = $this->MItems->getItem($this->table_name, $id);
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
				
				if($id == 'add') {
					$_POST['created'] = date('Y-m-d H:i:s');
				}
				
				if(!$_POST['gallery_id']){
					$_POST['gallery_id'] = $this->get_gallery($_POST['item_id'], $_POST['item_type']);
				}
				
				$data['data']['itemid'] = $_POST['item_id'];
				$data['data']['itemtype'] = $type;
				$data['data']['galleryid'] = $_POST['gallery_id'];
				
				if($id == 'add') {
					if($_POST['link']) {
						$item_id = $_POST['item_id'];
						$item_type = $_POST['item_type'];
						
						$_POST['type'] = $type;
						
						unset($_POST['item_id'], $_POST['item_type']);
						
						if($media_id = $this->MItems->add('media', $_POST)) {
							$data['message'] = "Video has successfully been created.";
							$this->MItems->addActivity('media', $media_id, $item_type, $item_id);
							redirect($item_type.'/view/'.$item_id, 'refresh');
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
					if($this->MItems->update('media', $id, $_POST)) {
						
						$data['message'] = $_POST['challenge_title']." has successfully been updated.";
						redirect($item_type.'/view/'.$item_id, 'refresh');
					}
					else {
						$data['message'] = "We're sorry, there has been a problem processing your request.";
					}
					
					$item = $this->MItems->getItem($this->table_name, $id);
					$data['item'] = $item->row();
				
				}
			}
		}
		
		$data['data']['message'] = $data['message'];
		$data['header']['title'] = "Add Media";
		$data['data']['item'] = '';

		if($id == 'add') {
			$this->load->view('new_media', $data);
		}
		
	}
	
	function crop($id, $type = 'profile') {
		
		if($type == 'profile') {
			
			$user = $this->MItems->getUser($id);
			
			$data = array('id'=>$id, 'type'=>$type, 'image'=>$user->row()->profile_pic);
			$this->load->view('utility/crop',$data); 
			
		}
		
		
	}
	
	
	
}

?>