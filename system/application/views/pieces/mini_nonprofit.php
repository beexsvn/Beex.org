<div class="MiniProfile" id="MiniNPO">
    <h2><small>Benefiting Nonprofit</small><br /><?php echo anchor('npo/view/'.$npo->id, $npo->name); ?></h2>
    <div class='image'>
        <?php if($npo->logo) : ?>
            <img class="npologo" src="/media/npos/<?php echo $npo->logo; ?>" />
        <?php else: ?>
        	<?php display_default_image('npo'); ?>
        <?php endif; ?>
     </div>
    
    <p><?php echo $npo->blurb; ?></p>
    
</div>	