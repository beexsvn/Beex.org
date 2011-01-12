<?php
$this->load->view('framework/header', $header);
?>

<img class="block" src="<?php echo base_url(); ?>images/backgrounds/profile-cntr-top.png">
<div id="User" class="blue_cntr profile_page">

<div id="LeftColumn">
	<?php
	// * Piece * - Thick Mini Profile
		echo $this->pieces->miniProfile($user_id, false)
	?>
    
</div>

<div id="RightColumn">
	
	<div class="start_buttons">
		<?php 
		
			$user_id = $this->session->userdata('user_id');
			
			if($user_id == $profile->user_id || $this->session->userdata('superadmin')) {
					echo anchor('user/edit/'.$profile->user_id, '<img id="edit_profile_button" class="rollover float_left" style="margin-left:0;" src="'.base_url().'images/buttons/edit-profile-off.png" />');
					
					if($org_id = $this->MItems->does_user_have_organizations($profile->user_id)) {
						echo anchor('npo/edit/'.$org_id, '<img id="edit_organization_button" class="rollover float_left" style="margin-left:10px;" src="'.base_url().'images/buttons/edit-organization-off.png" />');
					}
									
			}
			
		?>
			
		<?php echo anchor('challenge/start_a_challenge/', '<img id="start_a_challenge_button" class="rollover" src="'.base_url().'images/buttons/start-a-challenge-off.png">'); ?>
		<?php echo anchor('cluster/start', '<img id="start_a_cluster_button" class="rollover" src="'.base_url().'images/buttons/start-a-cluster-off.png">'); ?>
	</div>
	
	<div class="feed">
		<img class="block" src="<?php echo base_url(); ?>images/backgrounds/activity-top-profile.png" />
		<div id="FeedWrapper" class="feed_wrapper">
			<div id="FeedContent">
				<div class="challenges section">
					<?php 
						if($browser->num_rows()) {
							$this->beex->create_browser($browser, 'challenges', 'challenge'); 
						}
						else {
							echo "<h2>No Challenges</h2>";
						}
					?> 
				</div>
				
				<div class="clusters section" style="display:none;">
					<?php
						if($clusters->num_rows()) {
							$this->beex->create_browser($clusters, 'clusters', 'cluster', false, false, false, false);
						}
						else {
							echo "<h2>No Clusters</h2>";
						}
					?> 
				</div>
				
				<div class="about section" style="display:none;">
					<?php if((isset($profile->upsets) && $profile->upsets) || (isset($profile->joy) && $profile->joy)) : ?>
						<?php if(isset($profile->upsets) && $profile->upsets) : ?>
						<h2>What upsets me the most...</h2>
						<p><?php echo $profile->upsets; ?></p>
						<?php endif; ?>
						<?php if(isset($profile->joy) && $profile->joy) : ?>
						<h2>What brings me the most joy...</h2>
						<p><?php echo $profile->joy; ?></p>
						<?php endif;?>
					<?php else : ?>
						<h2>No Information</h2>
					<?php endif; ?>
				</div>
				
			</div>
		</div>
		<img src="<?php echo base_url(); ?>images/backgrounds/activity-bottom-profile.png" />
	</div>
    
 
<div style="clear:both;"></div>

</div>
<img src="<?php echo base_url(); ?>images/backgrounds/profile-cntr-bottom.png">


<?php
$this->load->view('framework/footer');
?>