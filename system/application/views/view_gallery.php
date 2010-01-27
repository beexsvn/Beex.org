
                <h2><?php echo $gallery->name; ?></h2>
            	<div class="gallery">
                	<?php
						if($media) :
						foreach($media->result() as $m) :
					?>
                    	<a href="../../gallery/view_media/<?php echo $m->id; ?>"><div class="m">
                        	<img src="/beex/media/<?php echo $item->id; ?>/<?php echo $m->link; ?>" />
                            <div class="transparent">
	                            <p class="name"><?php echo $m->name; ?></p>
    	                        <p class="time"><?php echo $m->created; ?></p>
                            </div>
                        </div></a>
                    <?php
					 	endforeach;
						endif;?>
					<div style="clear:both;"></div>
               	</div>
