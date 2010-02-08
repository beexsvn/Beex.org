<div id="notecopy">
<?php

$data['item_id'] = $item_id;

	if(@$notes) {
		foreach($notes as $note) {
			?>
            	<div class="note" id="note_<?php echo $note->id; ?>">
                	<p class="created"><?php echo $note->created; ?></p>
					<?php if($note->note_image) : ?>
						<img src='<?php echo base_url(); ?>media/notes/<?php echo $note->note_image; ?>' />
					<?php endif; ?>
                    <div class="video"><?php echo $note->note_video; ?></div>
                    <h3><?php echo $note->title; ?></h3>
                    <p class="copy"><?php echo $note->note; ?></p>
                    <p><a class="reply_note_button" id="reply_note<?php echo $note->id; ?>">Reply</a><?php if($owner) echo " &bull; <a class='edit_note_button' id='edit_note".$note->id."'>Edit</a> &bull; <a class='delete_note_button' id='delete_note".$note->id."'>Delete</a>"; ?></p>
					 
					<?php echo $this->beex->show_replies($note->id, 'notes'); ?>
					
                </div>
				
				<?php
				
				 $replydata['note_id'] = $note->id;
				 $replydata['item_id'] = $item_id;
				 $replydata['note_title'] = $note->title;
				 echo $this->load->view('pieces/reply_form', $replydata, true); 
				
				
				 $data['id'] = $note->id;
				 $data['note'] = $note;
				 echo $this->load->view('pieces/note_form', $data, true); 
				
				?>

            <?php
		}
	}
	
	elseif($owner)  {
		echo "<h3>Add your thoughts here...</h3>";
	}
	else {
		echo "<h3>No posts</h3>";
	}
?>

<?php if($owner) : ?>
<a id='new_note'>Write a New Note</a>
<?php 

$new['id'] = 'new';
$new['item_id'] = $item_id;

echo $this->load->view('pieces/note_form', $new, true); 

?>
<?php endif; ?>

</div>