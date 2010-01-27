<div class="MiniProfile" id="MiniProfile">
    <h2><small>Creator</small><br /><?php echo anchor('user/view/'.$profile->user_id, $profile->first_name." ".$profile->last_name); ?></h2>
    <div class='image'>
		<?php echo anchor('user/view/'.$profile->user_id, (($profile->profile_pic) ? '<img src="/profiles/'.$profile->profile_pic.'" />' : display_default_image('profile'))); ?>
    </div>
    <p>Origin</p>
    <p><a><?php echo $profile->hometown; ?></a></p>
            
    <p style="margin-top:15px;">Challenges:</p>
    <p><?php echo anchor('user/view/'.$profile->user_id.'/active', "Active: (".$num_active.")"); ?></p>
    <p><?php echo anchor('user/view/'.$profile->user_id.'/complete', "Complete: (".$num_complete.")"); ?></p>
</div>	