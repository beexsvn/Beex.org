<?php

$this->load->view('framework/header', $header);

?>



<div id="challenge">

<div id="LeftColumn">

    <?php

	// Display Mini Cluster

	if($item->cluster_id) {
		echo $this->pieces->miniCluster($item->cluster_id);
	}
	?>

	<?php
	// Display MiniProfile

	echo $this->pieces->miniProfile($item->user_id);

	?>
    
    <?php 
	// * Piece * Display Team
		
		echo $this->pieces->teammates($item->id); 

	?>

    <?php

	// * Piece * - MiniNPO

	echo $this->pieces->miniNPO($item->challenge_npo);



	?>



</div>



<div id="RightColumn">
	<div id="challengeInfo">
	    <h1 class='title'>the challenge</h1>
        <div id="InfoDisplay" class="InfoDisplay">
            <h2><?php echo $item->challenge_title; ?> <?php if($owner) : echo anchor('challenge/editor/'.$item->id.'/edit', '<img src="/beex/images/buttons/edit.gif" style="float:right;" />'); endif; ?></h2>

			<?php $this->beex->generate_info_display($item, 'challenges'); ?>

            <table class="essential">
			 <tr>
              <td style="width:25%;">
           		<table class="whatwherewhen" cellspacing=0 cellpadding=0 border=0>

                    <tr>

                     <th>What:</th><td><?php echo $item->challenge_declaration; ?></td>

					</tr>

                    <tr>

	               	 	<th>Where:</th><td><?php echo $item->challenge_address1."<br>".$item->challenge_city.", ".$item->challenge_state." ".$item->challenge_zip; ?></td>

                    </tr>

                    <tr>

	                	<th>When:</th><td><?php echo $item->challenge_completion; ?></td>

                    </tr>

                    <tr>

                    	<th>Guests:</th><td><?php echo ucwords($item->challenge_attend); ?></td>

                    </tr>

				</table>
			  </td>
              <td>
                
                    <p class="blurb">

                    	Blurb: <?php echo $item->challenge_blurb; ?>

			        </p>

                    <p class="description">

    	            	<b>Description:</b> <?php echo $item->challenge_description; ?>

			        </p>
                    
                    <?php if($item->challenge_whydo) : ?>
                    <p class="description">
                    	<b>Why do you want to peform this challenge:</b> <?php echo $item->challenge_whydo; ?>
                    </p>
                    <?php endif; ?>
                    
                    <?php if($item->challenge_whycare) : ?>
                    <p class="description">
						<b>Why do you care about this nonprofit:</b> <?php echo $item->challenge_whycare; ?>
                    </p>
                    <?php endif; ?>
                
               </td>
              </tr>
             </table>



            
            <div class='social'>

            	SHARE:

               	<a style="margin-left:15px;" name="fb_share" type="icon_link" href="http://www.facebook.com/sharer.php">Share on Facebook</a><script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share" type="text/javascript"></script>
               <span style="margin-left:15px;"><script type="text/javascript" src="http://w.sharethis.com/button/sharethis.js#publisher=bfd562d7-4fbd-425d-8a09-678ae7f18fd6&amp;type=website&amp;embeds=true&amp;style=rotate&amp;post_services=email%2Cfacebook%2Ctwitter%2Cmyspace%2Cdigg%2Csms%2Cwindows_live%2Cdelicious%2Cwordpress%2Cstumbleupon%2Ccare2%2Ccurrent%2Creddit%2Cgoogle_bmarks%2Clinkedin%2Cblogger%2Cyahoo_bmarks%2Cmixx%2Ctechnorati%2Cfriendfeed%2Cybuzz%2Cpropeller%2Cnewsvine%2Cxanga&amp;headerbg=%23FF9900&amp;headerTitle=Share%20your%20Challenge%20on%20other%20Networks"></script></span>
                <!--<img src="/beex/images/share/twitter.png" /> TWITTER-->
				<!--<img src="/beex/images/share/email.png" /> EMAIL-->

                <span style="float:right; font-weight:bold; font-size:13px;">

                	<?php

						if($item->challenge_link) echo link_to_long($item->challenge_link, 'Go to Website');

						if($item->challenge_link && $item->challenge_rss) echo " | ";

						if($item->challenge_rss) echo anchor($item->challenge_rss, 'RSS Feed');

					?>

                </span>

            </div>



            <div style="clear:both;"></div>
        </div>
    </div>

    <div id="TheJourney">
    	<h2 class="title titlebg">The Journey</h2>
        <div id="JourneyInfo" class="InfoDisplay">
         <div id="TheBlog">
        	<h2 id="blogprooftitle">The Blog</h2>
        	<table cellpadding="0" cellspacing="0" border="0" style="width:100%; margin-top:18px;">
             <tbody>
              <tr>
               <td style="width:184px; padding-left:16px;">
               <img src="/beex/images/challenge/prooftop.png" />
               	<div id="ProofCountdown">
                    <h3>Proof Countdown</h3>
                    <p><span class='big'><?php echo $days_left = process_days_left($item->challenge_completion); ?></span> <?php if(is_numeric($days_left)) echo "days"; ?></p>
                    &nbsp;
                </div>
                <img src="/beex/images/challenge/proofbottom.png" id="ProofBottom" />
                <br />
                <?php

					if(process_days_left($item->challenge_completion) <= 0 || $owner) {
                		echo '<img src="/beex/images/buttons/view-the-proof.gif" id="blogprooftoggle" />';
					} 

				?>

                <div id="ActivityFeed">
                   <h2>Activity Feed</h2>
                   <?php echo $activityfeed; ?>
                </div>
               </td>
               <td style="width:26px;"></td>
               <td>
                <div id="Notes">
                	<div id="notecopy">
                    <?php

						if(@$notes) {
                    		foreach($notes as $note) {
								?>
                                	<div class="note">
                                    	<p class="created"><?php echo $note->created; ?></p>
                                        <div class="video"><?php echo $note->note_video; ?></div>
                                        <p class="title"><?php echo $note->title; ?></p>
                                        <p class="copy"><?php echo $note->note; ?></p>
                                        <p><a href="#">Reply</a></p>
                                    </div>
                                <?php
							}
						}



						elseif($owner)  {
							echo "<h3>Add your thoughts here...</h3>";
						}
						else {
							echo "<h3>No posts</h3>";
						}
                    ?>

                    <?php if($owner) : ?>
                    <a id='new_note'>Write a New Note</a>
                   	
					<?php echo $this->load->view('pieces/note_form', $item, true); ?>

                    <?php endif; ?>

                    </div>

                </div>
				<div id="Proof" style="display:none;">
                    <?php if($owner) echo $this->load->view("media_form", array('new'=>1, 'item'=>'', 'message'=>'', 'itemtype'=>'challenge', 'itemid'=>$item->id, 'galleryid'=>$this->MItems->getProofGalleryId($item->id, 'challenge')), true); ?>
                     
                    <?php echo $this->gallery->view_proof_gallery($item->id, $owner); ?>
                </div>
               </td>
              </tr>
             </tbody>
            </table>
         </div>
        </div>
    </div>
</div>

<div style="clear:both;"></div>

</div>







<?php

$this->load->view('framework/footer');

?>