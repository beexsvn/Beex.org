<?php



class Beex {



	function Beex() {

		$CI =& get_instance();

		$CI->load->helper('url');
		$CI->load->library('session');
		$CI->load->model('MItems');
		$CI->config->item('base_url');

	}

 
	function do_upload($files, $filename, $uploadpath = './media/', &$error = '')
	{
		//$uploadpath = './media/6';
		if(!file_exists($uploadpath)) {
			//echo $uploadpath;
			if(!mkdir($uploadpath)) {
 
			}
		}

		$config['upload_path'] = $uploadpath; 
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= 4000; 


		$CI =& get_instance();
		$CI->load->library('upload', $config);

		if ( ! $CI->upload->do_upload($filename))
		{
			$error = array('error' => $CI->upload->display_errors());
			//print_r($error);
			return '';
		}
		else
		{
			$data = $CI->upload->data('file_name');
			return $data['file_name'];
		}
	}

	// Function that gets the cluster name

	function name_that_npo($id) {
	
		$CI =& get_instance();
		$CI->load->model('MItems');
		
		$npo = $CI->MItems->getNPO($CI->MItems->getCluster($id)->row()->cluster_npo)->row();
		return $npo->name;

	}
	
	function name_that_npoparttwo($id) {
		echo "TETST".$id;
		$CI =& get_instance();
		$CI->load->model('MItems');

		$npo = $CI->MItems->getNPO($CI->MItems->getCluster($id/3459)->row()->cluster_npo)->row();
		return $npo->name;

	}
	
	function getDonatedAmount($cluster_id, $type) {
		
		$CI =& get_instance();
		
		if($type == 'cluster') {
			$donations = $CI->MItems->getDonations($cluster_id, 'cluster');
		}
		else {
			$donations = $CI->MItems->getDonations($CI->MItems->get_item_id('challenge', $cluster_id), 'itemnumber');
		}
		
		$total = 0;
		
		if($donations->num_rows()) {
			foreach($donations->result() as $donation) {
				$total += $donation->mc_gross;
			}
		}
		
		return $total;
	}
	

	function processProgressBar($type, $id, $view = 'full') {

		$output = '';

		$CI =& get_instance();
		$CI->load->model('MItems');

		if($type == 'challenges') {
			$donations = $CI->MItems->getDonations($CI->MItems->get_item_id('challenge', $id), 'itemnumber');
			$challenge = $CI->MItems->getChallenge($id)->row();
			$challenge_goal = $challenge->challenge_goal;
			$challenge_date = $challenge->challenge_completion;

			

		}

		elseif($type == 'clusters') {
			$donations = $CI->MItems->getDonations($id, 'cluster');
			$cluster = $CI->MItems->getCluster($id)->row();
			$challenge_goal = $cluster->cluster_goal;
			$challenge_date = $cluster->cluster_completion;
			

		}
		
		$daysleft = process_days_left($challenge_date);
		
		$total = 0;



		if($donations->num_rows()) {
			foreach($donations->result() as $donation) {
				$total += $donation->mc_gross;
			}
		}

		$challenge_goal = preg_replace('/[^0-9.]+/', '', $challenge_goal);

		if($challenge_goal <= 0 || !(is_numeric($challenge_goal))) {
			$challenge_goal = "N/A";
			$percent_complete = 0;
			return "";
		}

		$percent_complete = $total/$challenge_goal;
		if($percent_complete > 1) $percent_complete = 1;

		$pwidth = 219;
		
		if($view == 'full') {
			$output = "<div class='fundinfo'>
							<div class='progressbar'>
								<div class='fullpots' style='width:".(integer)($percent_complete * $pwidth)."px;'></div>";
			if($total < $challenge_goal) {
								$output .= "<div class='gradient' style='left:".((integer)($percent_complete * $pwidth)-62)."px;'></div>";
					
			}
			$output .= "</div>";
			$output .= '<div class="goal"><script type="text/javascript" src="http://w.sharethis.com/button/sharethis.js#publisher=bfd562d7-4fbd-425d-8a09-678ae7f18fd6&amp;type=website&amp;embeds=true&amp;style=rotate&amp;post_services=email%2Cfacebook%2Ctwitter%2Cmyspace%2Cdigg%2Csms%2Cwindows_live%2Cdelicious%2Cwordpress%2Cstumbleupon%2Ccare2%2Ccurrent%2Creddit%2Cgoogle_bmarks%2Clinkedin%2Cblogger%2Cyahoo_bmarks%2Cmixx%2Ctechnorati%2Cfriendfeed%2Cybuzz%2Cpropeller%2Cnewsvine%2Cxanga&amp;headerbg=%23FFC400&amp;headerTitle=Share%20this%20Challenge%20on%20other%20Networks"></script></div>';
			$output .= "<div class='daysleft'><p class='ending'>".date("m.d.y", strtotime($challenge_date))."</p><p class='days'>".$daysleft."</p></div>";
			$output .= "<div class='raised'>Goal: $".number_format($challenge_goal)." | Progress: $".number_format($total)."</div>";
			$output .= "</div>";

		}

		else {

			$output = "<div class='fundinfo'>
							<div class='progressbar'>
								<div class='fullpots' style='width:".(integer)($percent_complete * $pwidth)."px;'></div>";
			if($total < $challenge_goal) {
				$output .= "<div class='gradient' style='left:".((integer)($percent_complete * $pwidth)-62)."px;'></div>
							</div>";
			}
			$output .= "</div>";
			$output .= "<div class='goal'>Goal: $".number_format($challenge_goal)."</div>";
			$output .= "<div class='daysleft'><p>".$daysleft."</p></div>";
			$output .= "<div class='raised'>Progress: $".number_format($total)."</div>";
			$output .= "</div>";
		}



		return $output;



	}

	function processActivityFeed($item_type, $item_id, $profile = '') {

		$output = '';
		
		$CI =& get_instance();
		$CI->load->model('MItems');

		if($item_type != 'cluster') {
			$result = $CI->MItems->getNewActivities($item_id);
		}
		else {
			$result = $CI->MItems->getClusterActivities($item_id);
			//echo $CI->db->last_query();
		}
		
		$i = 0;
		
		if($result->num_rows()) {

			foreach($result->result() as $row) {
			
				if($row->type == 'media') {
					$output .= "<div class='".(($i == 0) ? "row top_" : '')."row ".$row->type."'>";
					$output	.= '<p class="activity">'.$profile->first_name.' '.$profile->last_name.' posted '.anchor('gallery/view_media/'.$row->piece_id, '1 new media').' to this challenge</p>';
					
					$output .= '<p class="date">'.date('m.d.Y', strtotime($row->created)).' at '.date('H:i', strtotime($row->created)).'</p>';
					$output .= "<div style='clear:both;'></div>";
					$output .= "</div>";
					
					$i++;

				}

				elseif($row->type == 'note') {
					$note = $CI->MItems->get('notes', $row->piece_id, 'id')->row();
					if($note) {
						$owner = false;
						$verbage = 'this challenge';
						if($item_type == 'cluster') {
							
							if(($note_type = $CI->MItems->get_item_type($note->item_id)) == 'cluster') {
								$verbage = 'this cluster';
							}
							else {
								$challenge = $CI->MItems->getChallenge(array('challenges.item_id'=> $note->item_id));
								if($challenge->num_rows()) {
									$c = $challenge->row();
									$user = $CI->MItems->getUserByChallenge($c->id);
									$profile = $user->row();
									
									$verbage = 'the challenge '.anchor('challenge/view/'.$c->id, $c->challenge_title);
								}
							}
						}
						$output .= "<div id='note_".$note->id."' class='".(($i == 0) ? "row top_" : '')."row ".$row->type."'>";
						
						$output .= "<img class='watermark' src='".base_url()."images/glyphs/note".(($i > 0) ? "-small" : '').".png'>";
						if($item_type == 'cluster') {
							$output .= $this->displayProfileImage($profile->user_id, $profile->profile_pic);
							$output .= "<div class='float_left copy'>";
						}
						$output	.= '<p class="activity">'.anchor('user/view/'.$profile->user_id,$profile->first_name.' '.$profile->last_name).' posted a new note to '.$verbage.' <span class="see_more_activity activity_button" id="see_more_activity_'.$i.'">&lt;view&gt;</span>';
						
						if($CI->session->userdata('user_id') == $profile->user_id) {
							$owner = true;
							$output .= "<span class='activity_button edit_note_button' id='edit_note".$note->id."'>&lt;edit&gt;</span>";
							$output .= "<span class='activity_button delete_note_button' id='delete_note".$note->id."'>&lt;delete&gt;</span>";
							
						}
						
						$output .= '</p>';
						$output .= '<div class="more_activity" id="more_activity_'.$i.'">
								<p class="note_title">'.$note->title.'</p>
								<p class="note_body">'.nl2br($note->note).'</p>';
						if($note->note_image) {
							$output .= "<img src='".base_url()."media/notes/".$note->note_image."' />";
						}
						if($note->note_video) {
							$output .= process_video_link($note->note_video);
						}
								
						$output .= '</div>';
						
						$output .= '<p class="date">'.date('m.d.Y', strtotime($row->created)).' at '.date('H:i', strtotime($row->created)).'</p>';
						
						
						if($item_type == 'cluster') {
							$output .= "</div>";
						}
						$output .= "<div style='clear:both;'></div>";
						$output .= "</div>";
						
						if($owner) {
							 $note_form_data['id'] = $note->id;
							 $note_form_data['note'] = $note;
							$note_form_data['item_id'] = $item_id;
							 $output .= $CI->load->view('pieces/note_form', $note_form_data, true);
						}
						
						$i++;
					}

				}
				
				elseif($row->type == 'join') {
					$piece = $CI->MItems->getChallenge($row->piece_id)->row();
					if($piece) {
						if($item_type == 'cluster' && $user = $CI->MItems->getUserByChallenge($piece->id)) {
							$profile = $user->row();
						}
						$output .= "<div id='join".$piece->id."' class='".(($i == 0) ? "row top_" : '')."row ".$row->type."'>";
						
						$output .= "<img class='watermark' src='".base_url()."images/glyphs/join".(($i > 0) ? "-small" : '').".png'>";
						
						$output .= $this->displayProfileImage($profile->user_id, $profile->profile_pic);
						$output .= "<div class='float_left copy'>";
						$output .= anchor('challenge/view/'.$piece->id, $piece->challenge_title, "class='activity orange bold'");
						$output	.= '<p class="activity">'.anchor('user/view/'.$profile->user_id, $profile->first_name.' '.$profile->last_name).' will '.anchor('challenge/view/'.$piece->id, $piece->challenge_declaration).' if $'.$piece->challenge_goal.' is raised for '.anchor('npo/view/'.$piece->challenge_npo, $piece->name).'</p>';
						$output .= "<p class='activity raised_goal'>Raised: $".(($raised = $CI->MItems->amountRaised($piece->item_id)) ? number_format($raised) : '0')." | Goal :$".$piece->challenge_goal."</p>";
								
						$output .= '<p class="date">'.date('m.d.Y', strtotime($row->created)).' at '.date('H:i', strtotime($row->created)).'</p>';
						$output .= "</div>";
						$output .= "<div style='clear:both;'></div>";

						$output .= "</div>";
						
						$i++;
					}

				}

				elseif($row->type == 'donation') {

					$donation = $CI->MItems->getDonations($row->piece_id)->row();
					if($donation) {
						$output .= "<div class='".(($i == 0) ? "row top_" : '')."row ".$row->type."'>";
						
						$output .= "<img class='watermark' src='".base_url()."images/glyphs/donate".(($i > 0) ? "-small" : '').".png'>";
						$output .= '<p class="activity">'.((isset($donation->on1) && $donation->on1) ? "Anonymous" : $donation->firstname.' '.$donation->lastname).' donated $'.$donation->mc_gross.' to the cause.</p>';
					
						if($donation->on0) 
							$output .= '<p class="activity donationnote"><i>"'.$donation->on0.'"</i></p>';
							
						$output .= '<p class="date">'.date('m.d.Y', strtotime($row->created)).' at '.date('H:i', strtotime($row->created)).'</p>';
						$output .= "<div style='clear:both;'></div>";
						$output .= "</div>";
						
						$i++;
					}
				}
				elseif($row->type == 'proof') {
					$proof = $CI->MItems->get('notes', $row->piece_id, 'id')->row();
					if($proof) {
						$owner = false;
						
						$output .= "<div id='proof_".$proof->id."' class='".(($i == 0) ? "row top_" : '')."row ".$row->type."'>";
						
						$output .= "<img class='watermark' src='".base_url()."images/glyphs/proof".(($i > 0) ? "-small" : '').".png'>";
						
						$output	.= '<p class="activity">'.anchor('user/view/'.$profile->user_id, $profile->first_name.' '.$profile->last_name).' posted a new proof to this challenge <span class="activity_button see_more_activity" id="see_more_activity_'.$i.'">&lt;view&gt;</span>';
						if($CI->session->userdata('user_id') == $profile->user_id) {
							$owner = true;
							$output .= "<span class='activity_button edit_note_button' id='edit_note".$proof->id."'>&lt;edit&gt;</span>";
							$output .= "<span class='activity_button delete_note_button' id='delete_note".$proof->id."'>&lt;delete&gt;</span>";
							
						}
						$output .= "</p>";
						$output .= '<div class="more_activity" id="more_activity_'.$i.'">';
						$output .= "<p class='note_title'>".$proof->title."</p>";
						$output .= '<p class="note_body">'.nl2br($proof->note).'</p>';
						if($proof->note_image) {
							$output .= "<img src='".base_url()."media/notes/".$proof->note_image."' />";
						}
						if($proof->note_video) {
							$output .= process_video_link($proof->note_video);
						}
						$output .= "</div>";
						
						$output .= '<p class="date">'.date('m.d.Y', strtotime($row->created)).' at '.date('H:i', strtotime($row->created)).'</p>';
						$output .= "<div style='clear:both;'></div>";
						$output .= "</div>";
						
						
						if($owner) {
							 $note_form_data['id'] = $proof->id;
							 $note_form_data['note'] = $proof;
							 $note_form_data['item_id'] = $item_id;
							 $output .= $CI->load->view('pieces/note_form', $note_form_data, true);
						}
						
						
						$i++;
					}
				}
			}

		}

		return $output;
	}

	function displayProfileImage($id, $pic, $folder = 'profile') {
		if($pic) {
			if(strpos($pic, 'http://') === 0) {
				$src = $pic;
			}
			else {
				$src = base_url()."media/".$folder."s/".$id."/cropped120_".$pic;
			}
		}
		else {
			$src = display_default_image($folder, true);
		}
		
		if($folder == 'profile') {
			$folder = 'user';
		}
		
		$output = '';
		$output .= "<div class='profile_image'>";
		$output .= "<img class='picture' src='".$src."' />";
		$output .= anchor($folder.'/view/'.$id, '<img class="border" src="'.base_url().'images/tout-image-border.png" />', 'target="_blank"');
		$output .= "</div>";
		
		return $output;
		
	}

	function displayRecentlyDeclared($n = 3) {
		
		$CI =& get_instance();
		$CI->load->model('MItems');
		
		$result = $CI->MItems->getChallenge('', '', 'challenges.created', 'DESC', $n);
		$output = '';

		$i = 0;
		
		foreach($result->result() as $row) {
//	<div class='image' style='background-image: url(\"".base_url()."/media/profiles/".$row->user_id.'/cropped120_'.$row->profile_pic."\");'></div>"
	
			$total_length = strlen($row->first_name) + strlen($row->last_name) + strlen(' pledged to ') + strlen($row->challenge_declaration);
			
			$char_limit = 140;
			
			$copy = "<p>".anchor('/user/view/'.$row->user_id, ucwords($row->first_name))." pledged to ".anchor('challenge/view/'.$row->id, $row->challenge_declaration)."</p><div style='clear:both;'></div>";
						
			
			$picture = "<div class='image_cntr'>
							<img class='border' src='".base_url()."images/rd-border.png' />";
			$picture .= ($row->profile_pic) ? 
						"<img src='".base_url()."media/profiles/".$row->user_id.'/cropped120_'.$row->profile_pic."' />" : display_default_image('profile');
			$picture .= "</div>";
			
			$link = anchor('user/view/'.$row->user_id, $picture);
			
			$output .= "<div class='recently_declared' id='recently_declared_$i'>";
			$output .= $link;
			$output .= $copy;
			$output .= "</div>";
			
			$i++;

		}
		
		echo $output;
		
	}

	function displayRecentlyDeclared2($n = 3) {
		
		$CI =& get_instance();
		$CI->load->model('MItems');
		
		$result = $CI->MItems->getChallenge('', '', 'challenges.created', 'DESC', $n);
		$output = '';

		$i = 0;
		
		foreach($result->result() as $row) {
//	<div class='image' style='background-image: url(\"".base_url()."/media/profiles/".$row->user_id.'/cropped120_'.$row->profile_pic."\");'></div>"
	
			$total_length = strlen($row->first_name) + strlen($row->last_name) + strlen(' has pledged to ') + strlen($row->challenge_declaration) + strlen(" if $") + strlen($row->challenge_goal) + strlen(' is raised for ') + strlen($row->name);
			
			$char_limit = 150;
			
			if($total_length < $char_limit) {
				$copy = "<p>".anchor('/user/view/'.$row->user_id, ucwords($row->first_name.' '.$row->last_name))." has pledged to ".anchor('challenge/view/'.$row->id, $row->challenge_declaration)." if $".$row->challenge_goal." is raised for ".anchor('npo/view/'.$row->challenge_npo, $row->name)."</p>";
			}
			else {
				$CI->load->helper('text');
				$copy = "<p>".anchor('/user/view/'.$row->user_id, ucwords($row->first_name.' '.$row->last_name))." has pledged to ";
				$len = strlen($row->first_name) + strlen($row->last_name) + strlen(' has pledged to ');
				
				$more_link = anchor('challenge/view/'.$row->id, '&lt;more&gt;', array('class'=>'rd_more_link'));
				$fin = false;
				if($len + strlen($row->challenge_declaration) > $char_limit) {
					$declaration = character_limiter($row->challenge_declaration, $char_limit-$len-8);
					$copy .= anchor('challenge/view/'.$row->id, $declaration).' '.$more_link;
					$fin = true;
					$len = $char_limit;
				}
				else {
					$copy .= anchor('challenge/view/'.$row->id, $row->challenge_declaration).' if ';
					$len += strlen($row->challenge_declaration) + 4;
				}
				
				if(($len + strlen($row->challenge_goal) > $char_limit) && !$fin) {	
					$copy .= "&#0133; ".$more_link;
					$len = $char_limit;
					$fin = true;
				}
				elseif(!$fin) {
					$copy .= "$".$row->challenge_goal;
					$len += strlen($row->challenge_goal) + 1;
				}
				
				if(($len + strlen(' is raised for ') > $char_limit) && !$fin) {
					$text = character_limiter(" is raised for ", $char_limit-$len-8);
					$copy .= ' '.$text.' '.$more_link;
					$len = $char_limit;
					$fin = true;
				}
				elseif(!$fin) {
					$copy .= " is raised for ";
					$len += strlen(' is raised for ');
				}
				
				if(($len + strlen($row->name) > $char_limit) && !$fin) {
					$npo = character_limiter($row->name, $char_limit-$len-8);
					$copy .= anchor('npo/view/'.$row->challenge_npo, $npo).' '.$more_link;
					$len = $char_limit;
					$fin = true;
				}
				elseif(!$fin) {
					$copy .= anchor('npo/view/'.$row->challenge_npo, $row->name);
				}
			}
			
			$picture = "<div class='image_cntr'>
							<img class='border' src='".base_url()."images/rd-border.png' />";
			$picture .= ($row->profile_pic) ? 
						"<img src='".base_url()."media/profiles/".$row->user_id.'/cropped120_'.$row->profile_pic."' />" : display_default_image('profile');
			$picture .= "</div>";
			
			$link = anchor('user/view/'.$row->user_id, $picture);
			
			$output .= "<div class='recently_declared' id='recently_declared_$i'>";
			$output .= $link;
			$output .= $copy;
			$output .= "</div>";
			
			$i++;

		}
		
		echo $output;
		
	}

	function create_browser($result, $table, $folder = 'profile', $widget = false, $from_cluster = false, $small = false, $from_npo = true) {
		$i = 0;
		foreach($result->result() as $item) {
			
			if($table == 'challenges') {
				
				$pronoun = 'I';
				$CI =& get_instance(); 
				$pronoun = $CI->MItems->hasTeammates($item->id);
				$profile = $CI->MItems->getUserByChallenge($item->id)->row();
				
				if($profile) {
			
					if($folder == 'profile') {
						$image_name = $profile->profile_pic;
						$link_id = $profile->user_id;
					}
					else {
						$link_id = $item->id;
						if($item->challenge_video) {
							$image_name = get_video_thumbnail($item->challenge_video);
						}
						else {
							$image_name = $item->challenge_image;
						}
					}
				
				?>
				
				<div class='row join<?php if($widget) echo " widget".$i; ?><?php if($small) echo ' smaller'; ?>' id="join<?php echo $item->id; ?>">
					
					<?php /*if(!($widget || $from_cluster)) : ?>
						<img class='watermark' src='<?php echo base_url(); ?>images/glyphs/join.png'>
					<? endif; */?>
					
					<?php echo $this->displayProfileImage($link_id, $image_name, $folder); ?>
					<div class="float_left copy">
						<?php echo anchor('challenge/view/'.$item->id, $item->challenge_title, "class='activity orange bold' style='display:inline-block;' target='_parent'"); ?>
						<?php if(!$widget) : ?>
							<?php if($CI->session->userdata('user_id') == $item->user_id) echo anchor('challenge/editor/'.$item->id.'/edit', "&lt;edit&gt;", 'class="browser_button"'); ?>
						<?php endif; ?>
						<?php if($from_cluster) : ?>
							<a class="deactivate_challenge browser_button" id="deactivate_<?php echo $item->id; ?>">&lt;deactivate from cluster&gt;</a>
						<?php endif; ?>
						<p class="activity"><?php echo anchor('user/view/'.$profile->user_id, $profile->first_name.' '.$profile->last_name, "target='_parent'"); ?> will <?php echo anchor('challenge/view/'.$item->id, $item->challenge_declaration, "target='_parent'"); ?> if $<?php echo $item->challenge_goal; ?> is raised for <?php echo anchor('npo/view/'.$item->challenge_npo, $item->name, 'target="_parent"'); ?></p>
						<?php if($widget) : ?>
							<?php echo anchor('challenge/view/'.$item->id.'/give', '<img class="give_button" src="'.base_url().'images/buttons/widget-give.png">', 'target="_blank"'); ?>
						<?php endif;?>
						<p class='activity raised_goal'>Raised: $<?php echo number_format($CI->MItems->amountRaised($item->item_id), 2); ?> | Goal: $<?php echo number_format($item->challenge_goal); ?></p>
						<p class="date"><?php echo date('m.d.Y', strtotime($item->challenge_created)); ?> at <?php echo date('H:i', strtotime($item->challenge_created)) ; ?></p>					
						<div style='clear:both;'></div>
					</div>
					<div style='clear:both;'></div>
				</div>
				
				
				<?php
				}
			
			}

			elseif($table == 'clusters') {
				
				if($folder == 'profile' && false) {
					$image_name = $profile->profile_pic;
					$link_id = $profile->user_id;
				}
				else {
					$link_id = $item->theid;
					$image_name = $item->cluster_image;
				}
				$CI =& get_instance(); 
				
				$challenges = $CI->MItems->getChallenge(array('cluster_id'=>$item->theid));
				
				?>
				<div class='row'>
					
					<img class='watermark' src='<?php echo base_url(); ?>images/glyphs/cluster.png'>
					<?php echo $this->displayProfileImage($link_id, $image_name, $folder); ?>
					
					<div class="float_left copy">
						<?php echo anchor('cluster/view/'.$item->theid, $item->cluster_title, "class='activity orange bold'"); ?>
						<p class="activity"><?php echo $item->cluster_blurb; ?></p>
						<p class='activity raised_goal'>Raised: $0 | Goal: $<?php echo $item->cluster_goal; ?></p>	
						<?php echo anchor('cluster/joina/'.$item->theid, '<img class="rollover" src="'.base_url().'images/buttons/join-browse-off.png" />'); ?>
						<p class="date"><?php echo date('m.d.Y', strtotime($item->created)); ?> at <?php echo date('H:i', strtotime($item->created)) ; ?></p>

						<div style='clear:both;'></div>
					</div>
					<div style='clear:both;'></div>
					<?php
						if($from_npo) {
						$this->create_browser($challenges, 'challenges', 'profile', false, false, true);
						} 					
					?>
				</div>
				<?php
				
				
			}
			
			elseif($table == 'nposearch') {
				
				?>
				<div class='row'>
					
					<img class='watermark' src='<?php echo base_url(); ?>images/glyphs/npo.png'>
					
					<div class='profile_image'>
			       		<?php if($item->logo) : ?>
							<?php get_item_image('npos', $item->id, $item->logo, 'cropped120', 'picture'); ?>
			        	<?php else: ?>
			        		<?php display_default_image('npo'); ?>
			        	<?php endif; ?>
						<?php echo anchor('npo/view/'.$item->id, '<img class="border" src="'.base_url().'images/tout-image-border.png" />'); ?>
					</div>
					
					<div class="float_left copy">
						<?php echo anchor('npo/view/'.$item->id, $item->name, "class='activity orange bold'"); ?>
						<p class="activity"><?php echo $item->blurb; ?></p>

						<div style='clear:both;'></div>
					</div>
					<div style='clear:both;'></div>

				</div>
				<?php
			}

			elseif($table == 'npos') {
				?>
				<?php if($i % 4 == 0) : ?>
				<div class="npo_row">
				<?php endif; ?>
				
				<div class="item npo" <?php if($i%4 == 3) echo 'style="margin-right:0px;"'; ?>>
			    	<div class='image'>
			       		<?php if($item->logo) : ?>
							<div class='picture'>
							<?php get_item_image('npos', $item->id, $item->logo, 'cropped120', 'npologo'); ?>
							</div>
			        	<?php else: ?>
			        		<?php display_default_image('npo'); ?>
			        	<?php endif; ?>
						<?php echo anchor('npo/view/'.$item->id, '<img class="border" src="'.base_url().'images/tout-image-border.png" />'); ?>
					</div>
					<p><?php echo anchor('npo/view/'.$item->id, $item->name, array('class'=>'namelink')); ?></p>
			   </div>
			
				<?php if($i % 4 == 3) : ?>
					<div class="clear_both"></div>
				</div>
				<?php endif; ?>

				<?php
			}
			elseif($table == 'people') {
				?>
				
				<div class='row'>
				
					<img class='watermark' src='<?php echo base_url(); ?>images/glyphs/user.png'>
					<?php echo $this->displayProfileImage($item->user_id, $item->profile_pic); ?>
					<div class="float_left copy">
						<?php echo anchor('user/view/'.$item->user_id, $item->first_name.' '.$item->last_name, "class='activity orange bold'"); ?>
						<div style='clear:both;'></div>
					</div>
					<div style='clear:both;'></div>
				</div>
				
				
				<?php
			}
			$i++;
		}
		if($table == 'npos' && $i%4 != 0) {
			echo "</div>";
		}
		echo '<div style="clear:both;"></div>';

	}
	
	function show_replies($id, $type = 'notes') {
		
		$CI =& get_instance();
		
		if($replies = $CI->MItems->getReplies($id, $type)) {
			
			$output = "<div class='replies' id='replies_".$id."'>
						<h4>Replies</h4>";
			
			foreach($replies as $row) {
				
				$data['reply'] = $row;
				
				$output .= $CI->load->view('pieces/reply', $data, true);
				
			}
			
			$output .= "</div>";
	
			return $output;
		}
		
	}
	
	function view_notes($notes, $item_id, $owner = false) {
	
		$CI =& get_instance();

		$data['notes'] = $notes;
		$data['owner'] = $owner;
		$data['item_id'] = $item_id;
		//$data['gallery'] = $gallery;
		$CI->load->view('view_notes', $data);	
		
	}

	function create_featured($result, $table) {
		
		$CI =& get_instance();
		
		$i = 0;
		$num = $result->num_rows();
		echo "<div id='Featured$table' class='featuredbox featured_items'><div id='FCWrapper' style='width:".($num * 758)."px;' >";
		
		foreach($result->result() as $item) {
		
			if($table == 'challenges') {
			?>
				<div id="Featured<?php echo $i; ?>" class="InfoDisplay">
					<h1 class='awesometitle'><?php echo $item->challenge_title; ?>
					<?php if($item->cluster_id) : ?>
						<span class='cluster_title'>A member of the cluster <?php echo anchor('cluster/view/'.$item->cluster_id, $CI->MItems->getClusterName($item->cluster_id)); ?></span>
					<?php endif; ?>
					</h1>
					<?php $this->generate_info_display($item, 'challenges', $i); ?>
					<div style="clear:both;"></div>
			   </div>
			<?php
			}
			elseif($table == 'clusters') {
			?>
				<div id="Featured<?php echo $i; ?>" class="InfoDisplay">
					<h1 class="awesometitle"><?php echo anchor('cluster/view/'.$item->theid, $item->cluster_title); ?></h1>
				   <?php $this->generate_info_display($item, 'clusters', $i); ?>
				   <div style="clear:both;"></div>
			   </div>
			<?php
			}
			elseif($table == 'people') {
	
			}

			elseif($table == 'npos') {
			?>
				<div id="Featured<?php echo $i; ?>" class="InfoDisplay">

					<h2>Featured Non-Profits</h2>

				   <?php $this->generate_info_display($item, 'npos'); ?>
			   </div>
			<?php
			}
			$i++;
		}
		echo "<div style='clear:both;'></div>";
		echo "</div></div>";
		
		echo '<div class="featured_buttons">';
		echo "<div class='previous arrow'><img src='".base_url()."images/buttons/left.png'> Prev</div>";
		echo "<div class='buttons'>";
		for($j = 0; $j < $i; $j++) {
		?>
			<div id="button<?php echo $j; ?>" class="button<?php if($j == 0) echo " on"; ?>"></div>

		<?php 
		}
		echo '</div>';
		echo "<div class='next arrow'><span class='next_text'>Next</span> <img src='".base_url()."images/buttons/right.png'></div>";
		echo "<div class='clearboth'></div></div>";

		$width = 29 * $i;

		echo "<style>.featured_buttons .buttons {width:".$width."px; left:".((758/2) - $width/2 + 17)."px;}</style>";



	}



	function generate_info_display($item, $table, $i = '') {

		if($table == 'challenges') {
			$pronoun = 'I';
			$CI =& get_instance(); 
			$pronoun = $CI->MItems->hasTeammates($item->id);
			
			$decsize = strlen($item->challenge_declaration);
			$nposize = strlen($item->name);
			
			$npostandard = 24;
			$decstandard = 40;
			
			$hlbstandard = 28;
			$hlstandard = 22;
			
			$sizecoef = .6;
			
			$coef = ( ($npostandard+$decstandard) / ( (($npostandard + $decstandard) > $sizecoef*($nposize + $decsize)) ? ($npostandard + $decstandard) : $sizecoef*($nposize + $decsize)));
			
			$hlb = round($hlbstandard * $coef);
			$hl = round($hlstandard * $coef);
			
			
		?>
<style>
#featured_id<?php echo $item->id; ?> .declaration .hl {font-size:<?php echo $hl; ?>px;}
#featured_id<?php echo $item->id; ?> .declaration .hlb {font-size:<?php echo $hlb; ?>px;}
#Declaration p.declare {font-size:<?php echo $hlb; ?>px;}
#Featured<?php echo $i; ?> #Declaration p.declare {font-size:<?php echo $hlb; ?>px;}
</style>

			<div id="MediaViewer" class="mediaviewer">
				<div class="media">
					<?php if($video = $item->challenge_video) : ?>
	               	<div class="video">
	                   <?php echo process_video_link($video); ?>
	                </div>
	                <?php elseif($image = $item->challenge_image) : ?>
	                   <img id="main_image" src="<?php echo base_url(); ?>/media/challenges/<?php echo $item->id.'/sized_'.$image; ?>" />
	                <?php endif; ?>
				</div>
				<div class="donation">                          
					<?php echo $this->processProgressBar($table, $item->id); ?>
					<a class="ceebox" href="<?php echo base_url(); ?>pieces/donate.php?challenge_id=<?php echo $item->item_id; ?>&challenge_name=<?php echo urlencode($item->challenge_title); ?>"><div class="donatebutton" id="donatebutton<?php echo $item->item_id; ?>"></div></a>

                    <script>
                   /*jQuery("#donatebutton<?php echo $item->id; ?>").colorbox({href:"/pieces/donate.php?challenge_id=<?php echo $item->id; ?>&challenge_name=<?php echo urlencode($item->challenge_title); ?>", width:'420', height:'400px'});
					
					jQuery("#donatebutton<?php echo $item->id; ?>").colorbox({href:"http://www.beex.org/index.php/npo/donateTo/<?php echo $item->id; ?>"});*/
                    </script>                            
				</div>
			</div>
			<div id="Declaration" class="declaration_class">
				<p class="declare"><span class="uppercase"><?php echo $pronoun; ?> will</span><br>
				<?php echo anchor('challenge/view/'.$item->id, $item->challenge_declaration); ?></span> <span class="uppercase">if</span>  <span class='copper'>$<?php echo number_format($item->challenge_goal); ?></span>
				<br />is raised for<br />
				<?php echo anchor('npo/view/'.$item->challenge_npo, $item->name); ?>

				<!--<div class="sponsor">
					<p>Sponsored By:</p>
				</div>-->
				
			</div>

		<?php

		}
		elseif($table == 'clusters') {

		?>

			<div id="MediaViewer" class="mediaviewer">
				<div class="media <?php if(!$item->cluster_goal) echo 'media_large'; ?>">
					<?php if($video = $item->cluster_video) : ?>
	               	<div class="video">
	                   <?php echo process_video_link($video); ?>
	                </div>
	                <?php elseif($image = $item->cluster_image) : ?>
	                   <img id="main_image" src="<?php echo base_url(); ?>/media/clusters/<?php echo $item->theid.'/sized_'.$image; ?>" />
	                <?php endif; ?>
				</div>
				<div class="donation">                          
					<?php echo $this->processProgressBar($table, $item->theid); ?>
					<?php if(!$item->cluster_goal) : ?>
						<div class="days_left_long"><?php echo process_days_left($item->cluster_completion); ?> days left</div>
					<?php endif; ?>
					<?php echo anchor('cluster/joina/'.$item->theid, '<div class="joinbutton"></div>'); ?>
				</div>
			</div>
			<div id="Declaration" class="declaration_class">
				<p class="declare"><?php echo (is_int($i)) ? anchor('cluster/view/'.$item->theid, $item->cluster_blurb) : $item->cluster_blurb; ?></p>
			</div>
			
		<?php
		}
		elseif($table == 'people') {
			
		}

		elseif($table == 'npos') {
		?>
			<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td class="media">
						<?php if(@$video) : ?>
						<div class="video" style="width:400px;">
							<?php echo process_video_link($video); ?>
						</div>
						<?php elseif($item->logo) : ?>
						<img src="<?php echo base_url(); ?>/media/npos/<?php echo $item->logo; ?>" id="main_image" />
						<?php endif; ?>

						<div class="donation">
							<img src="<?php echo base_url(); ?>/beex/images/buttons/learn-more-long.gif" style="display:block; margin:14px auto;;" />
						</div>
					</td>



					<td class="declaration">
						<p>
							<span class='hlb'><?php echo $item->name; ?></span>
							<br /><?php echo $item->blurb; ?>
						</p>

						<div style="clear:both;"></div>
					</td>
			   </tr>
		   </table>
		<?php
		}
	}
}

?>