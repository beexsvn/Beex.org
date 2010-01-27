
<div class="Team" id="Team">
  	<div id="teamname">Teammates</div>
	<?php foreach($teammates as $teammate) : ?>
    <p class="teammate" style="font-size:10px; text-align:center; margin:0px 4px 4px;"><?php echo anchor('user/view/'.$teammate->id, $teammate->first_name.' '.$teammate->last_name); ?></p>
    <?php endforeach; ?>
</div>