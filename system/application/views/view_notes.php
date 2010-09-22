<div id="notecopy">

<?php
$data['item_id'] = $item_id;
?>

<?php if($owner) : ?>
<a id='new_note' class="button">Write a New Note</a>
<?php 

$new['id'] = 'new';
$new['item_id'] = $item_id;

echo $this->load->view('pieces/note_form', $new, true); 

?>
<?php endif; ?>


<?php
	if(@$notes) {
		$i = 1;
		foreach($notes as $note) {
			?>
            	<div class="note<?php if($i%2 == 0) echo " note_alt"; ?>" id="note_<?php echo $note->id; ?>">
                	<p class="created"><?php echo $note->created; ?></p>
					<h3><?php echo $note->title; ?></h3>
					<?php if($note->note_image) : ?>
						<img src='<?php echo base_url(); ?>media/notes/<?php echo $note->note_image; ?>' />
					<?php endif; ?>
                    <div class="video"><?php echo process_video_link($note->note_video, 480, 320); ?></div>
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
			$i++;
		}
	}
	
	elseif($owner)  {
		echo "<h3>Add your thoughts here...</h3>";
	}
	else {
		echo "<h3>No posts</h3>";
	}
?>

</div>