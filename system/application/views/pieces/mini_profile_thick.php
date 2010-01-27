<div class="MiniProfile" id="MiniProfile">

    <h2><?php echo $profile->first_name." ".$profile->last_name; ?>

         <?php if($profile->user_id == @$data['user_id']) :

                    echo anchor('user/edit/'.$profile->user_id, "Edit Profile", array('style'=>'float:right; font-size:10px;'));

                endif;

        ?>



    </h2>

    <table border='0' cellpadding="0" cellspacing="0">

     <tr>

        <td class="leftcol" style="width:">



            <div class='image'>

                <?php if($profile->profile_pic) : ?>

                    <img src="/profiles/<?php echo $profile->profile_pic; ?>" />
				<?php else : ?>
                	<?php echo display_default_image('profile'); ?>
                <?php endif; ?>

            </div>

            <p>Origin</p>

            <p><a><?php echo $profile->hometown; ?></a></p>



            <p style="margin-top:15px;">Challenges:</p>

   			<p><a>Active: (<?php echo $num_active; ?>)</a></p>

			<p><a>Complete: (<?php echo $num_complete; ?>)</a></p>

        </td>

        <td class="rightcol">

            <p><b>Why I'm here:</b> <?php echo $profile->whycare; ?></p>

            <p><b>Bio:</b> <?php echo $profile->blurb; ?></p>



        </td>

     </tr>

    </table>

</div>