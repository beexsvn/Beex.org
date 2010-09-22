
                
            	<div class="gallery">
                	<?php
						if($media) :
						$i = 1;
						foreach($media->result() as $m) :
					?>
                    	<div class="note">
                    			<p class="step"><?php echo $i; ?>)</p>
                                <p class="created"><?php echo date('M n, Y \a\t g:iA', strtotime($m->created)); ?></p>
                                <p class="title"><?php echo $m->name; ?></p>
                                <?php if($m->type == 'video') : ?>
                                <div class="video"><?php echo process_video_link($m->link); ?></div>
                                <?php else : ?> 
                                <div class="image"><img src="/media/<?php echo $item_id; ?>/<?php echo $m->link; ?>" class="note_image"></div>
                                <?php endif; ?>
                                <p class="copy"><?php echo $m->caption; ?></p>
                                <p><?php if($owner) : ?><a class="edit_proof_button" id="edit_proof<?php echo $m->id; ?>">Edit</a> &bull; <?php endif; ?><a href="#">Comment</a></p>

						</div>
                       	<div class="note_edit" id="edit_proof_form<?php echo $m->id; ?>" style="display:none;">
                        	<?php	echo $this->load->view("media_form", array('edit'=>1, 'new'=>0, 'item'=>$m, 'message'=>'', 'itemtype'=>'challenge', 'itemid'=>$item_id, 'galleryid'=>$m->gallery_id), true); ?>
						
                        </div>
                    <?php 
						
						
						$i++;
					 	endforeach;
						endif;?>
					<div style="clear:both;"></div>
               	</div>
