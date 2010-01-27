<div class="MiniProfile" id="MiniCluster">
    <h2><small>Cluster Stub</small><br><?php echo anchor('cluster/view/'.$cluster->theid, $cluster->cluster_title); ?></h2>
    
	<?php if($cluster->cluster_image) : ?>
    <div class='image'>
            <?php echo anchor('user/view/'.$cluster->theid, '<img src="/media/clusters/'.$cluster->cluster_image.'" />'); ?>
    </div>
    <?php endif; ?>
    
    <p><?php echo $cluster->cluster_blurb; ?></p>
</div>	