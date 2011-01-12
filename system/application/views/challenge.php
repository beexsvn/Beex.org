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
	var link = base_url + 'challenge/view/<?php echo $item->id; ?>';
	<?php if($item->challenge_image) : ?>
		var picture = true_base_url + 'media/challenges/<?php echo $item->id; ?>/sized_<?php echo $item->challenge_image; ?>';
	<?php else : ?>
		var picture = true_base_url + "images/defaults/challenge_default.png";
	<?php endif; ?>
	
	var captionplus = '';
	
	if(caption.length > 110) {
		caption = caption.substr(0, 110) + '...';
		captionplus = " Click link to see more";
	}
	caption = '"' + caption + '"' + captionplus;
	
	var message = "I just posted a note to my BEEx.org challenge.";
	if(proof == 1) {
		message = "I just posted proof to my BEEx.org challenge.";
	}
	
	var user_prompt = 'Would you like to share your challenge\'s note on Facebook?';
	
	streamPublish(message, caption, '', picture, name, link, 'Donate', link, user_prompt, 'note', el);	
	
	/*
	FB.ui(
   	{
	     method: 'stream.publish',
	     message: message,
	     attachment: {
	       name: title,
	       caption:  caption,
	       //description: '',
	       href: link,
		   media: [
			      {
			        type: 'image',
			        href: link,
			        src: picture
			      }
		   ],
	     },
	     action_links: [
	       { text: 'Donate', href: link }
	     ],
	     user_message_prompt: 'Would you like to share your challenge\'s note on Facebook?'
	   },
	   function(response) {
		  if (response && response.post_id) {
	       	//successful post
			//return true;
	     } else {
	       	//unsuccessful post
			//return true;
	     }
		 el.submit();
	   }
	);
	*/

	return false;
}

<?php if($this->uri->segment(4) == 'fb_add') : ?>

$(document).ready(function() {

	var npo = '<?php echo $this->beex->name_that_npo($item->challenge_npo); ?>';
					
	/* publish to the news feed */
	var caption = "Support {*actor*}'s fundraiser on BEEx.org!";
	var message = 'I will ' + "<?php echo addslashes($item->challenge_declaration); ?>" + ' if $' + '<?php echo $item->challenge_goal; ?>' + ' is raised for ' + npo + '.';
	var link = base_url + 'challenge/view/<?php echo $item->id; ?>/';
	var name = '<?php echo addslashes($item->challenge_title); ?>';
	var picture = "http://www.beex.org/images/defaults/challenge_default.png";

	var image = '<?php echo $item->challenge_image; ?>';

	if(image) {
		picture = "http://sandbox.beex.org/media/challenges/<?php echo $item->id; ?>/sized_"+image;
	}

	var user_prompt = 'Would you like to share your challenge on Facebook?'
	var redirect = base_url + '/challenge/view/<?php echo $item->id; ?>';
	
	FB.ui(
	{
	     method: 'stream.publish',
	     message: message,
	     attachment: {
	       name: name,
	       caption:  caption,
	       href: link,
		   media: [
			      {
			        type: 'image',
			        href: link,
			        src: picture
			      }
		   ],
	     },
	     action_links: [
	       { text: 'Donate', href: link }
	     ],
	     user_message_prompt: 'Would you like to share your challenge on Facebook?'
	   },
	   function(response) {
		  if (response && response.post_id) {
	       //successful post
	     } else {
	       //unsuccessful post
	     }
	   }
	);

});

<?php elseif($this->uri->segment(4) == 'give') : ?>
	$.fn.ceebox.popup('<a href="<?php echo base_url(); ?>pieces/donate.php?challenge_id=<?php echo $item->item_id; ?>&challenge_name=<?php echo urlencode($item->challenge_title); ?>">Link</a>', {borderColor:'#DBE7E6', borderWidth:'18px', boxColor:"#ffffff", htmlWidth:360, htmlHeight:360, titles:false, padding:0});
<?php endif; ?>

</script>	
<?php endif; ?>

<div id="challenge">

<div id="LeftColumn">
	
	<?php
	// Display MiniProfile
	echo $this->pieces->miniProfile($item->user_id);
	?>

    <?php
	// * Piece * - MiniNPO
	echo $this->pieces->miniNPO($item->challenge_npo);

	?>



</div>



<div id="RightColumn">

	<div id="challengeInfo">
	    <h1 class='awesometitle'><?php if($owner && $this->MItems->amountRaised($item->id) == 0) : echo anchor('challenge/delete/'.$item->id, 'Delete', 'class="small_button float_right" style="margin-left:5px;"'); endif; ?> <?php if($owner) : echo anchor('challenge/editor/'.$item->id.'/edit', 'Edit', 'class="small_button float_right"'); endif; ?><?php echo $item->challenge_title; ?>
		<?php if($item->cluster_id) : ?>
			<span class='cluster_title'>A member of the cluster <?php echo anchor('cluster/view/'.$item->cluster_id, $this->MItems->getClusterName($item->cluster_id)); ?></span>
		<?php endif; ?>
		</h1>
		
		<!-- Challenge Information Module -->
		
        <div id="InfoDisplay" class="InfoDisplay">
            
			<?php $this->beex->generate_info_display($item, 'challenges'); ?>
			
			<div id="Blurb">
				<img class="block" src="<?php echo base_url(); ?>images/backgrounds/blurb-top.png" />
				<div class="body">
								
					<?php if($item->challenge_description) : ?> 
                	<p class="description">
	            		<?php echo nl2br($item->challenge_description); ?>
		        	</p>
                	<?php endif; ?>
					
					<?php if(isset($item->challenge_link)) : ?>
					<p class="website">
						<span class="label">Website:</span> <?php echo auto_link($item->challenge_link); ?>
					</p>
					<?php endif; ?>
					
					<div class="what_where">
						<!-- Sharing here defunct <div class="sharing">

							<span><script type="text/javascript" src="http://w.sharethis.com/button/sharethis.js#publisher=bfd562d7-4fbd-425d-8a09-678ae7f18fd6&amp;type=website&amp;embeds=true&amp;style=rotate&amp;post_services=email%2Cfacebook%2Ctwitter%2Cmyspace%2Cdigg%2Csms%2Cwindows_live%2Cdelicious%2Cwordpress%2Cstumbleupon%2Ccare2%2Ccurrent%2Creddit%2Cgoogle_bmarks%2Clinkedin%2Cblogger%2Cyahoo_bmarks%2Cmixx%2Ctechnorati%2Cfriendfeed%2Cybuzz%2Cpropeller%2Cnewsvine%2Cxanga&amp;headerbg=%23FFC400&amp;headerTitle=Share%20this%20Challenge%20on%20other%20Networks"></script></span>
						</div> -->
					<?php if($item->challenge_location || $item->challenge_address1 || $item->challenge_city || $item->challenge_state || $item->challenge_zip) :?>
						
							<p><span class="label">Location:</span> <?php echo ($item->challenge_location) ? $item->challenge_location : ''; ?> <?php echo (($item->challenge_address1) ? $item->challenge_address1."," : "").(($item->challenge_city) ? $item->challenge_city.", " : "").(($item->challenge_state) ? $item->challenge_state." " : "").$item->challenge_zip; ?></p>
						
					<?php endif; ?>
						
					</div>
					
					<div class="ie_none" style="clear:both;"></div>
				</div>
				
				<img class="block" src="<?php echo base_url(); ?>images/backgrounds/blurb-bottom.png" />
			</div>    
            <div style="clear:both;"></div>
        </div>
    </div>
	
	<div id="JourneyInfo">
   		
		<?php if($owner) : ?>
		<div class="write_buttons">
			<img class="new_note rollover" src="<?php echo base_url(); ?>images/buttons/new-note-off.png">
			<!--<img id="new_proof" class="rollover" src="<?php echo base_url(); ?>images/buttons/add-proof-off.png">-->
		</div>
		<?php endif;?>
       	


		<div id="Buttons">
			<div class="selected_top challenge_feed_button" id="feed_button_all"><p>All Activity</p></div>
			<div class="button" id="feed_button_note"><p>Notes</p></div>
			<div class="button" id="feed_button_donation"><p>Donations</p></div>
			<div class="button" id="feed_button_proof"><p>Proof</p></div>
		</div>
	
		<div id="Feed" class="feed">
			<img class="block" src="<?php echo base_url(); ?>images/backgrounds/activity-top.png" />
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
					<?php echo ($activityfeed) ? $activityfeed : ''; ?>
					<h2 class="none_box"><?php echo (!$activityfeed) ? 'No activity' : ''; ?></h2>
					<?php if($this->MItems->noProof($item->id)) : ?>
						<div class="proof_graphic">
							<h3>The Proof</h3>
							<p class="proof_description"><?php echo $item->proof_description; ?></p>
							<img src='<?php echo base_url(); ?>images/graphics/proof-bg.png' style="width:510px;" />
							<p>Proof will be posted when the challenge is complete.</p>
						</div>
					<?php endif;?>
				</div>
			</div>
			<img src="<?php echo base_url(); ?>images/backgrounds/activity-bottom.png" />
		</div>
		
		<div style="clear:both;"></div>
    </div>
	
	<img src="<?php echo base_url(); ?>images/backgrounds/challenge-blue-bottom.gif">
</div>
	
<div style="clear:both;"></div>

</div>






<?php

$this->load->view('framework/footer');

?>