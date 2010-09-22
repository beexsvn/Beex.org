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
			if(($org_id = $this->MItems->does_user_have_organizations($this->session->userdata('user_id'))) == $npo->id) {
				echo anchor('npo/edit/'.$org_id, '<img id="edit_organization_button" class="rollover float_left" src="'.base_url().'images/buttons/edit-organization-off.png" />');
				echo anchor('npo/widget/'.$org_id, '<img id="create_widget_button" class="rollover float_left" style="margin-left:10px;" src="'.base_url().'images/buttons/create-widgets-off.png" />');
			}
		?>
		
		<?php echo anchor('challenge/start_a_challenge/organization/'.$npo_id, '<img id="start_a_challenge_button" class="rollover" src="'.base_url().'images/buttons/start-a-challenge-off.png">'); ?>
		<?php echo anchor('cluster/start/organization/'.$npo_id, '<img id="start_a_cluster_button" class="rollover" src="'.base_url().'images/buttons/start-a-cluster-off.png">'); ?>
	</div>

	<div class="feed">
		<img class="block" src="<?php echo base_url(); ?>images/backgrounds/activity-top.png" />
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
				
				<div class="challenges section" style="display:none;">
					<?php 
						if($browser->num_rows()) {
							$this->beex->create_browser($browser, 'challenges', 'challenge');
						}
						else {
							echo "<h2>No challenges</h2>";
						}
					?>
					
				</div>

				<div class="clusters section" style="display:none;">
					<?php 
						if($clusters->num_rows()) {
							$this->beex->create_browser($clusters, 'clusters', 'cluster');
						}
						else {
							echo "<h2>No clusters</h2>";
						}
					?>
				</div>

			</div>
		</div>
		<img src="<?php echo base_url(); ?>images/backgrounds/activity-bottom.png" />
	</div>


	<div style="clear:both;"></div>

</div>
<img src="<?php echo base_url(); ?>images/backgrounds/profile-cntr-bottom.png">
	

</div>



<?php
$this->load->view('framework/footer');
?>