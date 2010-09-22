
<div id="Teammates">
	<p><span class="orange uppercase">Teammates</span></p>
	<?php foreach($teammates as $teammate) : ?>
    <p class="teammate"><?php echo anchor('user/view/'.$teammate->id, $teammate->first_name.' '.$teammate->last_name); ?></p>
    <?php endforeach; ?>
</div>