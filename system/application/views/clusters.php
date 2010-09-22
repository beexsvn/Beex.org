<?php
$this->load->view('framework/header', $header);
?>

<div id="Clusters" class="featured_page">

<div id="LeftColumn">
	<div class="tout" id="GettingStarted">
   	
		<h3>Describe</h3>
		<p>how your cluster's participants will raise money for the organization of your choice.</p>
		<h3>Invite</h3>
		<p>people to create their own fundraising page within your cluster.</p>
		
		<h3>Encourage</h3>
		<p>your participants as they complete their challenges.</p>
		
        <div class="buttons">
			<?php echo anchor('cluster/start', 'Start', array('class'=>'button left', 'id'=>"StartCluster")); ?>
			<?php echo anchor('http://learn.beex.org/?page_id=44#What_is_a_cluster', 'Learn', array('class'=>'button right', 'id'=>'LearnCluster', 'target'=>'_blank')); ?>
		</div>
    </div>
</div>

<div id="RightColumn">
	<img src="<?php echo base_url(); ?>images/backgrounds/challenge-blue-top.gif">
		<?php $this->beex->create_featured($featured, 'clusters'); ?>  
	<img src="<?php echo base_url(); ?>images/backgrounds/challenge-blue-bottom.gif">

</div>
    
    
</div>

<div style="clear:both;"></div>

</div>


<?php
$this->load->view('framework/footer');
?>