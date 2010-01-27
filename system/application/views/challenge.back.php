<?php
$this->load->view('framework/header', $header);
?>

<div id="challenge">

<div id="LeftColumn">
	<div class="MiniProfile" id="MiniProfile">
    	<h2><?php echo $profile->first_name." ".$profile->last_name; ?></h2>
        <div class='image'>
        	<?php if($profile->profile_pic) : ?>
            	<img src="/beex/profiles/<?php echo $profile->profile_pic; ?>" />
            <?php endif; ?>
        </div>
        <p>Hometown</p>
        <p><a><?php echo $profile->hometown; ?></a></p>
        <p>Network</p>
        <p><a><?php echo $profile->network; ?></a></p>
        
        <p style="margin-top:15px;">Challenges:</p>
        <p><a>Active: (1)</a></p>
        <p><a>Complete: (0)</a></p>
    </div>
    <!--
    <div class="Team" id="Team">
    	<div id="teamname">Team Name Here</div>
    </div>
    -->
    <div class="MiniProfile" id="BenefittingNPO">
        <h2><?php echo $item->challenge_npo; ?></h2>
        <p style="padding:10px;">This non profit is striving to help as much as they can.</p>
    </div>
</div>

<div id="RightColumn">
	<div id="challengeInfo">
	    <h1 class='title'>the challenge</h1>
        <div id="InfoDisplay" class="InfoDisplay">
            <h2><?php echo $item->challenge_title; ?> <?php if(@$data['user_id'] == $item->user_id) : ?><a href="/beex/index.php/challenge/edit_a_challenge/<?php echo $item->id; ?>"><img src="/beex/images/buttons/edit.gif" style="float:right;" /></a><?php endif; ?></h2>
           
            
            <div class="media">
				<?php if($video) : ?>
                <div class="video" style="width:400px;">
                	<?php echo process_video_link($video); ?>
                </div>
                <?php endif; ?>
                <!--<p>Media</p>
                <p>Media Selector</p>-->
                
                <?php echo anchor('gallery/new_media/challenge/'.$item->id, 'New Media'); ?>
                <?php if($gallery_id) {
                		echo anchor('gallery/view_gallery/'.$gallery_id, 'View Media');
				}
				?>
                <div class="donation">
                	<img src="/beex/images/buttons/donate.gif" style="float:right; margin:20px 10px 10px;" />
                	<div class="fundinfo">
                    	<img class="progressbar" src="/beex/images/temp/progressbar.gif" />
	                    <p>Amount Raised: $0 of $<?php echo $item->challenge_goal; ?> / Days Left: <?php echo process_days_left($item->challenge_completion); ?></p>
                    </div>
                </div>
            </div>
            
            <div class="declaration">
                <p><span class='hl'>I</span> will <span class='hl'><?php echo $item->challenge_declaration; ?></span> if<br /><span class='hlb'>$<?php echo $item->challenge_goal; ?></span>
                <br />is raised for <br />
                <span class='hlb'><?php echo $item->challenge_npo; ?></span>
                <br />with support from<br />
				<span class='hl'><img src="/beex/images/sponsors/chase.gif" /></span></p>
                
                <div style="clear:both;"></div>
            </div>
            
            <div class="essential">
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
            	
                <div class="right">
	                
                    <p class="blurb">
                    	Blurb: <?php echo $item->challenge_blurb; ?>
			        </p>
                    <p class="description">
    	            	Description: <?php echo $item->challenge_description; ?>
			        </p>
                    
                </div>
                
            </div>
            <div class='social'>
            	SHARE: 
               	<img src="/beex/images/share/facebook.png" /> FACEBOOK
                <img src="/beex/images/share/twitter.png" /> TWITTER
                <img src="/beex/images/share/email.png" /> EMAIL
            </div>
            
            <div style="clear:both;"></div>
        </div>
    </div>
    
    <div id="TheJourney">
    	<h2 class="title titlebg">The Journey</h2>
        <div id="JourneyInfo" class="InfoDisplay">
        	<table cellpadding="0" cellspacing="0" border="0" style="width:100%; margin-top:18px;">
             <tbody>
              <tr>
               <td style="width:184px; padding-left:16px;">
                <img src="/beex/images/challenge/prooftop.png" />
               	<div id="Proof">
                	
                    <h3>Proof Countdown</h3>
                    
                    <p><span class='big'><?php echo process_days_left($item->challenge_completion); ?></span> days</p>
                    <?php echo anchor('gallery/new_media/challenge/'.$item->id.'/proof', 'New Proof'); ?>
                    <?php if($proof_id) {
                			echo anchor('gallery/view_gallery/'.$proof_id, 'View Proof!');
						}
					?>
                    
                </div>
                <img src="/beex/images/challenge/proofbottom.png" id="ProofBottom" />
                <div id="ActivityFeed">
                   <h2>Activity Feed</h2>
                   <?php echo $activityfeed; ?>
                </div>
                
               </td>
               <td style="width:26px;">
               </td>
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
						
						else  {
							echo "<h2>Add your thoughts here...</h2>";	
						}
                        
                        
                    ?>
                    
                    <a id='new_note'>Write a New Note</a>
                   <?php 
				   
				   $attributes = array(
									'class' => 'form',
									'id' => 'add_note_form',
									'style' => 'display:none'
									   );
				   
				   echo form_open_multipart('challenge/add_note/'.$item->id, $attributes);
				   
				   ?>
                    <h2>New Note</h2>
                    <table>
                    	<tr>
                        	<td>Title: </td>
                            <td><input name="title" /></td>
                        </tr>
                    	<tr>
                        	<td>Note: </td>
                            <td><textarea name="note"></textarea></td>
                        </tr>
                        <tr>
                        	<td colspan="2">Select media for your post</td>
                        </tr>
                        <tr>
                        	<td>Upload Image:</td>
                            <td><input type="file" name="note_image" /></td>
                        </tr>
                        <tr>
                        	<td colspan="2">Or</td>
                        </tr>
                        <tr>
                        	<td>Embed Video:</td>
                            <td><textarea class="videoembed" name="note_video"></textarea></td>
                        </tr>
                        <tr>
                        	<td colspan=2><input type="submit" value="Add Note" class="submit" /></td>
                        </tr>
                    </table>
                    </form>
                    </div>
                </div>
                
                
               </td>
              </tr>
             </tbody>
            </table>
        </div>
    </div>
</div>

<div style="clear:both;"></div>

</div>



<?php
$this->load->view('framework/footer');
?>