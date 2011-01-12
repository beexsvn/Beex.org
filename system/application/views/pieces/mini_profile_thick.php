<div class="MiniProfile" id="MiniProfile">
	<h2>Challenger</h2>	
	<div class="info">
    	<div class='image'>
			
			<?php if($this->session->userdata('user_id') == $profile->user_id) :
				echo anchor("gallery/crop/".$user_id, "Edit Picture", array('class'=>'jcrop_pop', 'rel'=>'iframe'));
			endif; ?>
			<?php echo anchor('user/view/'.$profile->user_id, (($profile->profile_pic) ? '<img src="'.base_url().'/media/profiles/'.$profile->user_id.'/cropped120_'.$profile->profile_pic.'" />' : display_default_image('profile')), array('class'=>'picture')); ?>
			<?php echo anchor('user/view/'.$profile->user_id, '<img class="border" src="'.base_url().'images/tout-image-border.png" />'); ?>
	    </div>
		<p><?php echo anchor('user/view/'.$profile->user_id, $profile->first_name." ".$profile->last_name, array('class'=>'namelink')); ?></p>
		
		<?php if($profile->hometown) :?>
		<p class="header">Location:</p>
		<p class="answer"><?php echo $profile->hometown; ?></p>
		<?php endif;?>
		
		<?php if($profile->website) : ?>
		<p class="header">Website:</p>
		<p class="answer"><?php echo link_to_long(prep_url($profile->website)); ?></p>
		<?php endif; ?>
	</div>
	<img class="block" src="<?php echo base_url(); ?>images/backgrounds/left-tout-bottom-filled.png" />
	
	
	<div id="Buttons" class="MiniProfileButtons">
		<div id="feed_button_challenges" class="selected"><p>Challenges</p></div>
		<div id="feed_button_clusters" class="button"><p>Clusters</p></div>
		<div id="feed_button_about" class="button"><p>About</p></div>
	</div>
	
	<img src="<?php echo base_url(); ?>images/backgrounds/left-tout-bottom-totally-filled.png">
	
</div>