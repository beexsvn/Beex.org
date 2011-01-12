<div class="MiniProfile" id="MiniNPO">
    <h2>ORGANIZATION</h2>
	<div class="info">
    	<div class='image'>
       		<?php if($npo->logo) : ?>
				<div class='picture'>
				<?php get_item_image('npos', $npo->id, $npo->logo, 'cropped120', 'npologo'); ?>
				</div>
        	<?php else: ?>
        		<?php display_default_image('npo'); ?>
        	<?php endif; ?>
			<?php echo anchor('npo/view/'.$npo->id, '<img class="border" src="'.base_url().'images/tout-image-border.png" />'); ?>
		</div>
		<p><?php echo anchor('npo/view/'.$npo->id, $npo->name, array('class'=>'namelink')); ?></p>

		<p class="header">Address:</p>
		<p class="answer"><?php echo (($npo->address_city) ? $npo->address_city.', ' : '').(($npo->address_state) ? $npo->address_state : ''); ?></p>

		<?php if($npo->website) : ?>
		<p class="header">Website:</p>
		<p class="answer"><?php echo link_to_long(prep_url($npo->website)); ?></p>
		<?php endif; ?>
	</div>
	<img class="block" src="<?php echo base_url(); ?>images/backgrounds/left-tout-bottom-filled.png" />


	<div id="Buttons" class="MiniProfileButtons">
		<div id="feed_button_about" class="selected"><p>About</p></div>
		<div id="feed_button_clusters" class="button"><p>Activity</p></div>
		<div id="feed_button_challenges" class="button"><p>Supporters</p></div>
	</div>

	<img src="<?php echo base_url(); ?>images/backgrounds/left-tout-bottom-totally-filled.png">
</div>
