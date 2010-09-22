<div class="MiniProfile" id="MiniProfile">
    <h2><?php echo ($cluster) ? 'Cluster Admin' : 'Challenger'; ?></h2>	
	<div class="info">
    	<div class='image'>
		
			<?php echo anchor('user/view/'.$profile->user_id, (($profile->profile_pic) ? '<img src="'.base_url().'/media/profiles/'.$profile->user_id.'/cropped120_'.$profile->profile_pic.'" />' : display_default_image('profile')), array('class'=>'picture')); ?>
			<?php echo anchor('user/view/'.$profile->user_id, '<img class="border" src="'.base_url().'images/tout-image-border.png" />'); ?>
	    </div>
		<p><?php echo anchor('user/view/'.$profile->user_id, $profile->first_name." ".$profile->last_name, array('class'=>'namelink')); ?></p>
		<?php 
		// * Piece * Display Team
			echo $this->pieces->teammates($item->id); 
		?>
	</div>
	<img src="<?php echo base_url(); ?>images/backgrounds/left-tout-bottom.gif" />
</div>	