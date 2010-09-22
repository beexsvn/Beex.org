<div class="MiniProfile" id="MiniCluster">
    <h2>Cluster Stub</h2>
    <div class="info">
		<?php if($cluster->cluster_image) : ?>
    	<div class='image'>
            <?php echo anchor('cluster/view/'.$cluster->theid, get_item_image('clusters', $cluster->theid, $cluster->cluster_image, 'cropped120', '', 1)); ?>
			<img class="border" src="<?php echo base_url(); ?>images/tout-image-border.png" />
    	</div>
    	<?php endif; ?>
    
		<?php echo anchor('cluster/view/'.$cluster->theid, $cluster->cluster_title, array('class'=>'namelink')); ?>
	</div>
	<img src="<?php echo base_url(); ?>images/backgrounds/left-tout-bottom.gif" />
</div>	