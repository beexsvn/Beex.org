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



	function process_image($file) {

		$CI =& get_instance();

		$CI->load->library('image_lib', $config);

	}



	// Function that gets the cluster name

	function name_that_npo($id) {
	
		$CI =& get_instance();
		$CI->load->model('MItems');

		$npo = $CI->MItems->getNPO($id)->row();
		return $npo->name;

	}

	function processProgressBar($type, $id, $view = 'full') {

		$output = '';

		$CI =& get_instance();
		$CI->load->model('MItems');

		if($type == 'challenges') {
			$donations = $CI->MItems->getDonations($id, 'itemnumber');
			$challenge = $CI->MItems->getChallenge($id)->row();
			$challenge_goal = $challenge->challenge_goal;
			$challenge_date = $challenge->challenge_completion;

			$daysleft = process_days_left($challenge_date);

		}

		elseif($type == 'clusters') {
			$donations = $CI->MItems->getDonations($id, 'cluster');
			$cluster = $CI->MItems->getCluster($id)->row();
			$challenge_goal = $cluster->cluster_goal;

		}

		$total = 0;



		if($donations->num_rows()) {
			foreach($donations->result() as $donation) {
				$total += $donation->mc_gross;
			}
		}



		if($challenge_goal <= 0 || !(is_numeric($challenge_goal))) {
			$challenge_goal = "N/A";
			$percent_complete = 0;
			return "<p>Amount Raised: $".$total."</p>";
		}

		$percent_complete = $total/$challenge_goal;
		if($percent_complete > 1) $percent_complete = 1;

		if($view == 'full') {
			$output = "<div class='fundinfo'>
							<div class='progressbar'>
								<img src='".base_url()."/beex/images/assets/progressbar_orange.gif' style='margin-left:-".(integer)((1-$percent_complete) * 264)."px;'>

							</div>

							<p>Amount Raised: $".$total." of $".$challenge_goal;



			if($type == 'challenges') $output .= "/ Days Left: ".$daysleft;

			$output .= "</p>

						</div>";

		}

		else {

			$output = "<div class='progress'>

							<div class='progressbar' style='float:left;'>

								<img src='".base_url()."/beex/images/assets/progressbar_orange.gif' style='margin-left:-".(integer)((1-$percent_complete) * 264)."px;'>

						</div><span style='padding:5px;'>Days Left: ".$daysleft."</span></div>";

		}



		return $output;



	}



	function processActivityFeed($item_type, $item_id, $profile = '') {

		$output = '';

		$CI =& get_instance();
		$CI->load->model('MItems');

		$result = $CI->MItems->getActivities($item_type, $item_id);

		if($result->num_rows()) {

			foreach($result->result() as $row) {

				if($row->type == 'media') {

					$output	.= '<p class="activity">'.$profile->first_name.' '.$profile->last_name.' posted '.anchor('gallery/view_media/'.$row->piece_id, '1 new media').' to this challenge</p>';

				}

				elseif($row->type == 'note') {

					$output	.= '<p class="activity">'.$profile->first_name.' '.$profile->last_name.' posted a new note to this challenge</p>';

				}

				elseif($row->type == 'donation') {

					$donation = $CI->MItems->getDonations($row->piece_id)->row();

					$output .= '<p class="activity">'.$donation->firstname.' '.$donation->lastname.' donated $'.$donation->mc_gross.' to the cause.</p>';
					
					if($donation->os0) 
						$output .= '<p class="activity donationnote"><i>"'.$donation->on0.'"</p>';
				}

			}

		}

		return $output;
	}



	function displayRecentlyDeclared() {
		
		$CI =& get_instance();
		$CI->load->model('MItems');
		
		$result = $CI->MItems->getChallenge('', '', 'challenges.created', 'DESC', 3);
		$output = '';

		foreach($result->result() as $row) {



			$output .= "<div class='recently_declared'>
						";
			$output .= ($row->profile_pic) ? "<img src='".base_url()."/profiles/".$row->profile_pic."'>" : display_default_image('profile');
			
			$output .= "<p>".anchor('/user/view/'.$row->user_id, ucwords($row->first_name.' '.$row->last_name))." has pledged to ".anchor('challenge/view/'.$row->id, $row->challenge_declaration)." if $".$row->challenge_goal." is raised for ".anchor('npo/view/'.$row->challenge_npo, $row->name)."</p></div>";

		}

		echo $output;
		
	}





	function create_browser($result, $table) {



		foreach($result->result() as $item) {

			if($table == 'challenges') {

				$pronoun = 'I';
				$CI =& get_instance(); 
				$pronoun = $CI->MItems->hasTeammates($item->id);

				?>

				<div class='item'>

					<div class='image'>

						<?php if($item->profile_pic) : ?>

							<img src="<?php echo base_url(); ?>/profiles/<?php echo $item->profile_pic; ?>" />
                        
                        <?php else : ?>
                        
                        	<?php echo display_default_image('profile'); ?>
						
						<?php endif; ?>

					</div>

					<div class='copy'>

						<h3><?php echo anchor('challenge/view/'.$item->id, $item->challenge_title); ?></h3>

						<p><span class='hl'><?php echo $pronoun; ?></span> will <span class='hl'><?php echo $item->challenge_declaration; ?></span> if <span class='hl'>$<?php echo $item->challenge_goal; ?></span> is raised for <?php echo anchor('npo/view/'.$item->challenge_npo, $item->name); ?></span></p>

						<?php echo $this->processProgressBar($table, $item->id, 'browser'); ?>

					</div>

					<div class="donate">

						<?php echo anchor('challenge/view/'.$item->id, '<img src="/beex/images/buttons/view.gif" />'); ?>

						<img class="donatebutton" id="donatebuttonbrowse<?php echo $item->id; ?>" src="<?php echo base_url(); ?>/beex/images/buttons/donatesmall.gif" />

                        <script>

                            jQuery("#donatebuttonbrowse<?php echo $item->id; ?>").colorbox({href:"/pieces/donate.php?challenge_id=<?php echo $item->id; ?>&challenge_name=<?php echo urlencode($item->challenge_title); ?>"});

                        </script>

					</div>



				</div>

				<?php

			}



			elseif($table == 'clusters') {

				?>

				<div class='item'>

					<div class='image'>

						<?php if($item->profile_pic) : ?>

							<img src="<?php echo base_url(); ?>/profiles/<?php echo $item->profile_pic; ?>" />
                            
                        <?php else : ?>
                        
                        	<?php echo display_default_image('profile'); ?>

						<?php endif; ?>

					</div>

					<div class='copy'>

						<h3><?php echo anchor('cluster/view/'.$item->theid, $item->cluster_title); ?></h3>

						<p><?php echo $item->cluster_blurb; ?></p>

					</div>

					<div class="donate">

						<?php echo anchor('cluster/view/'.$item->theid, '<img src="/beex/images/buttons/view.gif" />'); ?>

						<img src="<?php echo base_url(); ?>/beex/images/buttons/donatesmall.gif" style="display:none;" />

					</div>



				</div>

				<?php

			}



			elseif($table == 'oldnpos') {

				?>

				<div class='item'>

					<div class='image'>

						<?php if($item->logo) : ?>

							<img src="<?php echo base_url(); ?>/profiles/<?php echo $item->logo; ?>" />

						<?php endif; ?>

					</div>

					<div class='copy'>

						<h3><?php echo anchor('npo/view/'.$item->id, $item->name); ?></h3>

						<p><?php echo $item->blurb; ?></p>

					</div>

					<div class="donate">

						<?php echo anchor('npo/view/'.$item->id, '<img src="'.base_url().'/beex/images/buttons/learn-more.gif">'); ?>

					</div>



				</div>

				<?php

			}



			elseif($table == 'npos') {

				?>

				<div class='item person'>

					<div class='image'>

						<?php echo anchor("npo/view/".$item->id, (($item->logo) ? '<img src="'.base_url().'/media/npos/'.$item->logo.'" />' : display_default_image('profile'))); ?>
                            
						<p class="namelink"><?php echo anchor('npo/view/'.$item->id, $item->name); ?></p>

					</div>





				</div>

				<?php

			}



			elseif($table == 'people') {

				?>

				<div class='item person'>

					<div class='image'>

						<?php if($item->profile_pic) : ?>

							<?php echo anchor("user/view/".$item->user_id, '<img src="'.base_url().'/profiles/'.$item->profile_pic.'" />'); ?>
						<?php else: ?>
							<?php echo anchor("user/view/".$item->user_id, display_default_image('profile'))?>
						<?php endif; ?>

						<p class="namelink"><?php echo anchor('user/view/'.$item->user_id, $item->first_name.' '.$item->last_name); ?></p>

					</div>





				</div>

				<?php

			}

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

		$i = 0;
		
		foreach($result->result() as $item) {
		
			if($table == 'challenges') {
			?>
				<div id="Featured<?php echo $i; ?>" class="InfoDisplay" <?php if($i != 0) echo "style='display:none;'"; ?>>
					<h2>Featured Challenges</h2>
					<?php $this->generate_info_display($item, 'challenges'); ?>
			   </div>
			<?php
			}
			elseif($table == 'clusters') {
			?>
				<div id="Featured<?php echo $i; ?>" class="InfoDisplay" <?php if($i != 0) echo "style='display:none;'"; ?>>
					<h2>Featured Clusters</h2>
				   <?php $this->generate_info_display($item, 'clusters'); ?>
			   </div>
			<?php
			}
			elseif($table == 'people') {
	
			}

			elseif($table == 'npos') {
			?>
				<div id="Featured<?php echo $i; ?>" class="InfoDisplay" <?php if($i != 0) echo "style='display:none;'"; ?>>

					<h2>Featured Non-Profits</h2>

				   <?php $this->generate_info_display($item, 'npos'); ?>
			   </div>
			<?php
			}
			$i++;
		}
		
		echo '<div class="featured_buttons">';

		for($j = 0; $j < $i; $j++) {

		?>
			<div id="button<?php echo $j; ?>" class="button<?php if($j == 0) echo " on"; ?>"></div>

		<?php 

		}



		echo "<div class='clearboth'></div></div>";





		$width = 26 * $i;

		echo "<style>.featured_buttons {width:".$width."px;}</style>";



	}



	function generate_info_display($item, $table) {

		if($table == 'challenges') {
			$pronoun = 'I';
			$CI =& get_instance(); 
			$pronoun = $CI->MItems->hasTeammates($item->id);
			
		?>

			<table cellpadding="0" cellspacing="0" border="0">

				<tr>

					<td class="media">

						<?php if($video = $item->challenge_video) : ?>

                        <div class="video" style="width:400px;">

                            <?php echo process_video_link($video); ?>

                        </div>

                        <?php elseif($image = $item->challenge_image) : ?>

                            <img id="main_image" src="<?php echo base_url(); ?>/media/challenges/<?php echo $image; ?>" />

                        <?php endif; ?>

						<div class="donation">

                            <img class="donatebutton" id="donatebutton<?php echo $item->id; ?>" src="<?php echo base_url(); ?>/beex/images/buttons/donate.gif" style="float:right; margin:20px 10px 10px;" />



                            <script>

                           jQuery("#donatebutton<?php echo $item->id; ?>").colorbox({href:"/pieces/donate.php?challenge_id=<?php echo $item->id; ?>&challenge_name=<?php echo urlencode($item->challenge_title); ?>"});
							
							//jQuery("#donatebutton<?php echo $item->id; ?>").colorbox({href:"http://www.beex.org/index.php/npo/donateTo/<?php echo $item->id; ?>"});
                            </script>
                            <div class="fundinfo">
							<?php echo $this->processProgressBar($table, $item->id); ?>
                            </div>

						</div>

					</td>



					<td class="declaration">
						<p><span class='hl'><?php echo $pronoun; ?></span> will <span class='hl'><?php echo anchor('challenge/view/'.$item->id, $item->challenge_declaration); ?></span> if<br /><span class='hlb'>$<?php echo $item->challenge_goal; ?></span>
						<br />is raised for <br />
						<span class='hlb'><?php echo anchor('npo/view/'.$item->challenge_npo, $item->name); ?></span>

						<div style="clear:both;"></div>
					</td>
			   </tr>
		  </table>

		<?php

		}
		elseif($table == 'clusters') {

		?>

			<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td class="media">
						<?php if(@$video = $item->cluster_video) : ?>
						<div class="video" style="width:400px;">
							<?php echo process_video_link($video); ?>
						</div>
						<?php elseif($item->cluster_image) : ?>
						<img src="<?php echo base_url(); ?>/media/clusters/<?php echo $item->cluster_image; ?>" id="main_image" />
						<?php endif; ?>

						<div class="donation">
							<img src="<?php echo base_url(); ?>/beex/images/buttons/donate.gif" style="float:right; display:none; margin:14px 10px 10px;" />
							<div class="fundinfo">
                            	<?php echo $this->processProgressBar($table, $item->theid); ?>
							</div>
						</div>
					</td>

					<td class="declaration">
						<p>
							<span class='hlb'><?php echo anchor('cluster/view/'.$item->theid, $item->cluster_title); ?></span>
							<br /><?php echo $item->cluster_blurb; ?>
						</p>

						<div style="clear:both;"></div>
					</td>
			   </tr>
		   </table>
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