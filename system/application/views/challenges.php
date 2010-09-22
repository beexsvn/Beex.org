<?php
$this->load->view('framework/header', $header);
?>

<div id="Challenges" class="featured_page">

	<div id="LeftColumn">
		<div class="tout" id="GettingStarted">
    	
			<h3>Declare</h3>
			<p>an action you'll perform if a certain amount of money is raised for the organization of your choice.</p>
			
			<h3>Ask</h3>
			<p>your Friends to help you raise money and awareness.</p>
			
			<h3>Thank</h3>
			<p>your donors by posting notes, pictures, videos and proof that you performed your challenge.</p>
			
			
	        <div class="buttons">
				<?php echo anchor('challenge/start_a_challenge', 'Start', array('class'=>'button left', 'id'=>"StartChallenge")); ?>
				<?php echo anchor('http://learn.beex.org/?page_id=44#What_is_a_challenge', 'Learn', array('class'=>'button right', 'id'=>'LearnChallenge', 'target'=>'_blank')); ?>
			</div>
	    </div>
	</div>

	<div id="RightColumn">
		<img src="<?php echo base_url(); ?>images/backgrounds/challenge-blue-top.gif">
		<?php $this->beex->create_featured($featured, 'challenges'); ?>  
		<img src="<?php echo base_url(); ?>images/backgrounds/challenge-blue-bottom.gif">
     
	</div>

	<div style="clear:both;"></div>

</div>

<?php
$this->load->view('framework/footer');
?>