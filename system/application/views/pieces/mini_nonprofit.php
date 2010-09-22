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
   </div>
   <img class="bottom" src="<?php echo base_url(); ?>images/backgrounds/left-tout-bottom.gif" />
	
</div>	