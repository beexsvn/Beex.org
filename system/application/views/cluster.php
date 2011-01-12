<?php

$fb_user = $this->MUser->get_fb($this->session->userdata('user_id')); // whether or not we show fb connect dialog

$this->load->view('framework/header', $header);
?>

<?php if($fb_user) : ?>
	
<script language="javascript" type="text/javascript">

var fb_user = '<?php echo $fb_user; ?>';

function fbAddNote(el, mess, title, proof) {
	
	/* publish to the news feed */
	var caption = mess;
	var name = title;
	var link = base_url + 'cluster/view/<?php echo $item->id; ?>';
	<?php if($item->cluster_image) : ?>
		var picture = true_base_url + 'media/clusters/<?php echo $item->id; ?>/sized_<?php echo $item->cluster_image; ?>';
	<?php else : ?>
		var picture = true_base_url + "images/defaults/cluster_default.png";
	<?php endif; ?>
	
	var captionplus = '';
	
	if(caption.length > 110) {
		caption = caption.substr(0, 110) + '...';
		captionplus = " Click link to see more";
	}
	caption = '"' + caption + '"' + captionplus;
	
	var message = "I just posted a note to my BEEx.org cluster.";
	
	var user_prompt = 'Would you like to share your cluster\'s note on Facebook?';
	
	streamPublish(message, caption, '', picture, name, link, 'View Cluster', link, user_prompt, 'note', el);

	return false;
}
</script>

<?php endif; ?>


<div id="Cluster">

<div id="LeftColumn">
	<?php
	
	// *Piece* - Mini Profile
	echo $this->pieces->miniProfile($user_id, true, true);
	
	// * Piece * - Mini NPO
	echo $this->pieces->miniNPO($item->cluster_npo);
	
	?>
    
   
</div>

<div id="RightColumn">
	<div id="ClusterInfo">
	    <h1 class='awesometitle'><?php echo $item->cluster_title; ?> <?php if($owner) : echo anchor('cluster/editor/'.$item->theid.'/edit', 'Edit', 'class="float_right small_button"'); endif; ?>
		<span class='cluster_title'>
			(<?php 
				$num_challenges = $this->MItems->getChallenge($item->theid, 'challenges.cluster_id')->num_rows();
				$wording = $num_challenges.' Challenge'.(($num_challenges != 1) ? 's' : '');
				echo anchor('cluster/view/'.$item->theid.'/#TheJourney', $wording); 
			?>)</span>
		</h1>

        <div id="InfoDisplay" class="InfoDisplay">

            <?php $this->beex->generate_info_display($item, 'clusters'); ?>
            
            <div id="Blurb">
				<img src="<?php echo base_url(); ?>images/backgrounds/blurb-top.png" />
				<div class="body">
								
					<?php if($item->cluster_description) : ?> 
                	<p class="description">
	            		<?php echo $item->cluster_description; ?>
		        	</p>
                	<?php endif; ?>
					
					<?php if(isset($item->cluster_link)) : ?>
					<p class="website">
						<span class="label">Website:</span> <?php echo auto_link($item->cluster_link); ?>
					</p>
					<?php endif; ?>
					<div class="what_where">
							<div class="sharing">

								<span><script type="text/javascript" src="http://w.sharethis.com/button/sharethis.js#publisher=bfd562d7-4fbd-425d-8a09-678ae7f18fd6&amp;type=website&amp;embeds=true&amp;style=rotate&amp;post_services=email%2Cfacebook%2Ctwitter%2Cmyspace%2Cdigg%2Csms%2Cwindows_live%2Cdelicious%2Cwordpress%2Cstumbleupon%2Ccare2%2Ccurrent%2Creddit%2Cgoogle_bmarks%2Clinkedin%2Cblogger%2Cyahoo_bmarks%2Cmixx%2Ctechnorati%2Cfriendfeed%2Cybuzz%2Cpropeller%2Cnewsvine%2Cxanga&amp;headerbg=%23FFC400&amp;headerTitle=Share%20your%20Cluster%20on%20other%20Networks"></script></span>
							</div>
					<?php if($item->cluster_location) :?>
						<p><span class="label">Location:</span> <?php echo (($item->cluster_location) ? $item->cluster_location : ""); ?></p>
						
					<?php endif; ?>
					
					</div>
					<div style="clear:both;"></div>
				</div>
				
				<img src="<?php echo base_url(); ?>images/backgrounds/blurb-bottom.png" />
			</div>    
            
            <div style="clear:both;"></div>
        </div>
        
        
    </div>
	
	<div id="JourneyInfo">
		
		<?php if($owner) : ?>
		<div class="write_buttons">
			<img class="new_note rollover" src="<?php echo base_url(); ?>images/buttons/new-note-off.png">
		</div>
		<?php endif; ?>
		
		<div id="Buttons">
			<div class="selected_top" id="feed_button_join"><p>Challenges</p></div>
			<div class="button" id="feed_button_note"><p>Notes</p></div>
			<div class="button" id="feed_button_donation"><p>Donations</p></div>
			<div class="button" id="feed_button_all"><p>All Activity</p></div>
		</div>
		<div id="Feed" class="feed">
			<img src="<?php echo base_url(); ?>images/backgrounds/activity-top.png" />
			<div id="FeedWrapper">
				<div id="FeedContent">
					
					<?php
					if($owner) :
						$note_form_data['id'] = 'new';
						$note_form_data['item_id'] = $item->item_id;
						echo $this->load->view('pieces/note_form', $note_form_data, true);
					
			  			echo $this->load->view("media_form", array('new'=>1, 'edit' => 0, 'item'=>'', 'message'=>'', 'itemtype'=>'challenge', 'itemid'=>$item->id, 'galleryid'=>$this->MItems->getProofGalleryId($item->id, 'challenge')), true);
					endif;
					?>
					<!-- Cluster Specific Search Code -->
					<div class="cluster_search_cntr row join start_something">
						<div class='form_input'>
							<div class="short_text_input">
								<input type="text" id="cluster_search_term" class="go_blank">
							</div>
						</div>
						<img src="<?php echo base_url(); ?>images/buttons/search-off.png" class="rollover cluster_search_button" id="cluster_search_button<?php echo $item->theid;?>" />
						<img src="<?php echo base_url(); ?>images/graphics/beex-loading.gif" class="beex-loading"/>
						<a id="view_all_challenges">(View All Challenges)</a>
						<div style="float:left; clear:both;"></div>
					</div>
					<!-- End Cluster Search -->
					
					<?php echo ($activityfeed) ? $activityfeed : ''; ?>
					<h2 class="none_box"></h2>
					<h2 id="join_no_results"></h2>
					<?php if($this->MItems->noProof($item->id)) : ?>
						<div class="proof_graphic">
							<img src='<?php echo base_url(); ?>images/graphics/proof-bg.png' />
							<p>Proof will be posted when the challenge is complete.</p>
						</div>
					<?php endif;?>
				</div>
			</div>
			<img src="<?php echo base_url(); ?>images/backgrounds/activity-bottom.png" />
		</div>
		<!--<div class="feed_controls controls"><img class="scrollUp" src="<?php echo base_url(); ?>images/buttons/up.png"> <span class="see_more_feed">See More</span><span class="see_less_feed" style="display:none;">See Less</span> <img class="scrollDown" src="<?php echo base_url(); ?>images/buttons/down.png"></div>-->
		
		<div style="clear:both;"></div>
    </div>
	
   	<img src="<?php echo base_url(); ?>images/backgrounds/challenge-blue-bottom.gif">
</div>

<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>beex_scripts/in_page_search.js"></script>
<script language="javascript" type="text/javascript">

jQuery(document).ready(function() {
	shrinkFeed('join');
});

</script>

<div style="clear:both;"></div>

</div>

<?php
$this->load->view('framework/footer');
?>