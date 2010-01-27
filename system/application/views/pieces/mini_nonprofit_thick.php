<div class="MiniProfile" id="MiniNPO">

    <h2><?php echo $npo->name; ?>

         <?php if($npo->id== @$data['npo_id']) :

                    echo anchor('npo/edit/'.$npo->id, "Edit NPO", array('style'=>'float:right;'));

                endif;

        ?>



    </h2>

    <table border='0' cellpadding="0" cellspacing="0">

     <tr>

        <td class="leftcol" style="width:130px;">



            <div class='image'>

                <?php if($npo->logo) : ?>

                    <img src="/media/npos/<?php echo $npo->logo; ?>" />
				<?php else : ?>
                	<img src="/images/imagedefault.gif" />
                <?php endif; ?>

            </div>

            <p>Location</p>

            <p><a><?php echo $npo->address_city.', '.$npo->address_state; ?></a></p>



            <p style="margin-top:15px;">Category</p>

            <p><a><?php echo $npo->category; ?></a></p>



            <p style="margin-top:15px;">Website</p>

            <p><a><?php echo link_to_long(prep_url($npo->website)); ?></a></p>


        </td>

        <td class="rightcol">

            <p><b>What we do:</b> <?php echo $npo->mission_statement; ?></p>

            <p><b>History:</b> <?php echo $npo->about_us; ?></p>



        </td>

     </tr>

    </table>

</div>