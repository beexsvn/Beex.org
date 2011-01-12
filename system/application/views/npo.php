<?php
$this->load->view('framework/header', $header);
?>

<img class="block" src="<?php echo base_url(); ?>images/backgrounds/profile-cntr-top.png">
<div id="NPO" class="profile_page blue_cntr">
	
<div id="LeftColumn">
	<?php
	// * Piece * - Thick Mini Profile
		echo $this->pieces->miniNPO($npo_id, false)
	?>
    
</div>

<div id="RightColumn">
	
	<div class="start_buttons">
		<?php
			if(($org_id = $this->MItems->does_user_have_organizations($this->session->userdata('user_id'))) == $npo->id || $this->session->userdata('super_user')) {
				echo anchor('npo/edit/'.$npo->id, '<img id="edit_organization_button" class="rollover float_left" src="'.base_url().'images/buttons/edit-organization-off.png" />');
				echo anchor('npo/widget/'.$npo->id, '<img id="create_widget_button" class="rollover float_left" style="margin-left:10px;" src="'.base_url().'images/buttons/create-widgets-off.png" />');
			}
		?>
		<?php if($this->MNpos->get_levels($npo->id)) : ?>
			<a class="subscription_ceebox" href="<?php echo base_url(); ?>pieces/subscription.php?id=<?php echo $npo->id; ?>"><img src="<?php echo base_url(); ?>/images/buttons/subscription-off.png" class="rollover" /></a>
		<?php endif;?>
		<?php echo anchor('challenge/start_a_challenge/organization/'.$npo_id, '<img id="start_a_challenge_button" class="rollover" src="'.base_url().'images/buttons/start-a-challenge-off.png">'); ?>
		<?php echo anchor('cluster/start/organization/'.$npo_id, '<img id="start_a_cluster_button" class="rollover" src="'.base_url().'images/buttons/start-a-cluster-off.png">'); ?>
	</div>

	<div class="feed">
		<img class="block" src="<?php echo base_url(); ?>images/backgrounds/activity-top-profile.png" />
		<div id="FeedWrapper" class="feed_wrapper">
			<div id="FeedContent">
				<div class="about section">
					<?php if((isset($npo->mission_statement) && $npo->mission_statement) || (isset($npo->about_us) && $npo->about_us)) : ?>
						<?php if(isset($npo->mission_statement) && $npo->mission_statement) : ?>
						<h2>What We Do</h2>
						<p><?php echo $npo->mission_statement; ?></p>
						<?php endif; ?>
						<?php if(isset($npo->about_us) && $npo->about_us) : ?>
						<h2>Our History</h2>
						<p><?php echo $npo->about_us; ?></p>
						<?php endif;?>
					<?php else : ?>
						<h2>No information</h2>
					<?php endif; ?>
					
					
				</div>
				<style>
					.profile_page .feed .organizer .profile_image {width:60px; height:60px;}
					.profile_page .feed .organizer .copy {width:85%;}
				</style>
				<div class="challenges section" style="display:none;">
					<h2>Supporters</h2>
					<?php 
						$no_organizers = false;
						if($organizers = $this->MItems->getCluster(array('cluster_npo'=>$npo->id))) {
							if($organizers->num_rows()) {
								echo "<h3>Organizers</h3>";
								foreach($organizers->result() as $organizer) {
									?>
								
										<div class='row organizer'>
					
											<?php echo $this->beex->displayProfileImage($organizer->user_id, $organizer->profile_pic, 'profile'); ?>
										
											<div class="float_left copy">
												<p class="activity">
												<?php echo anchor('user/view/'.$organizer->id, $organizer->first_name.' '.$organizer->last_name, 'class="orange bold"'); ?> started the cluster 
												<?php echo anchor('cluster/view/'.$organizer->theid, $organizer->cluster_title, "class='orange bold'"); ?> and has raised <span class="bold">$<?php echo $this->beex->getDonatedAmount($organizer->theid, 'cluster'); ?></span> for <span class="orange bold"><?php echo $npo->name; ?>!</span>
											
												<div style='clear:both;'></div>
											</div>
											<div style='clear:both;'></div>
										</div>

									<?php
								}
							}
							else {
								$no_organizers = true;
							}
						}
					?>
					
					<?php 
						$no_challengers = false;
						if($challengers = $this->MItems->getChallenge(array('challenge_npo'=>$npo->id))) {
							if($challengers->num_rows()) {
								echo "<h3>Challengers</h3>";
								foreach($challengers->result() as $challenger) {
									?>
								
										<div class='row organizer'>
					
											<?php echo $this->beex->displayProfileImage($challenger->user_id, $challenger->profile_pic, 'profile'); ?>
										
											<div class="float_left copy">
												<p class="activity">
												<?php echo anchor('user/view/'.$challenger->user_id, $challenger->first_name.' '.$challenger->last_name, 'class="orange bold"'); ?> started the challenge 
												<?php echo anchor('challenge/view/'.$challenger->id, $challenger->challenge_title, "class='orange bold'"); ?> and has raised <span class="bold">$<?php echo $this->beex->getDonatedAmount($challenger->id, 'challenge'); ?></span> for <span class="orange bold"><?php echo $npo->name; ?>!</span>
											
												<div style='clear:both;'></div>
											</div>
											<div style='clear:both;'></div>
										</div>

									<?php
								}
							}
							else {
								$no_challengers = true;
							}
						}
					?>
					
					<?php 
						$no_subscribers = false;
						if($supporters = $this->MItems->getSupporters($npo->id)) {
							if($supporters->num_rows()) {
								echo "<h3>Subscribers</h3>";
								foreach($supporters->result() as $s) {
									?>
								
										<div class='row organizer'>
															
											<div class="float_left copy" style="width:100%;">
												<p class="activity">
												<span class="orange bold"><?php echo $s->firstname.' '.$s->lastname; ?></span> pledged <b>$<?php echo $s->mc_gross; ?></b> per month to <span class="orange bold"><?php echo $npo->name; ?>!</span>  
											 
												<div style='clear:both;'></div>
											</div>
											<div style='clear:both;'></div>
										</div>

									<?php
								}
							}
							else {
								$no_subscribers = true;
							}
						}
						
						if($no_subscribers && $no_organizers && $no_challengers) {
							echo "<h3>No Supporters</h3>";
						}
						
					?>
					
				</div>

				<div class="clusters section" style="display:none;">
					<?php 
						$any_clusters = true;
						if($clusters->num_rows()) {
							echo "<h2>Clusters</h2>";
							$this->beex->create_browser($clusters, 'clusters', 'cluster');
						}
						else {
							$any_clusters = false;
						}
					?>
					<?php
						$any_challenges = true;
						if($browser->num_rows()) {
							echo "<h2>Challenges</h2>";
							$this->beex->create_browser($browser, 'challenges', 'challenge');
						}
						else {
							$any_challenges = false;
						}
						
						if(!$any_challenges && !$any_clusters) {
							echo "<h2>No Activity</h2>";
						}
					?>
				</div>

			</div>
		</div>
		<img src="<?php echo base_url(); ?>images/backgrounds/activity-bottom-profile.png" />
	</div>


	<div style="clear:both;"></div>

</div>
<img src="<?php echo base_url(); ?>images/backgrounds/profile-cntr-bottom.png">
	

</div>



<?php
$this->load->view('framework/footer');
?>