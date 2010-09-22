<?php
$this->load->view('framework/header', $header);
?>

<div id="NPOS" class='featured_page'>

<div id="LeftColumn">
	<div class="tout" id="GettingStarted">
   	
		<!--<h3>Our Nonprofits</h3>-->
		<p>BEEx helps your organization's members and supporters to raise money and awareness by providing them easy to use resource raising tools.  Our basic services are free and we never take a transaction fee.</p>
		
        <div class="buttons">
			<?php //echo anchor('user/login', 'Login', array('class'=>'button left', 'id'=>"LoignNPO")); ?>
			<?php echo anchor('npo/newNpo', 'Register your organization', array('id'=>"RegisterOrg")); ?>
			<?php echo anchor('http://learn.beex.org/index.php?option=com_content&view=article&id=2&Itemid=4', 'Learn more about BEEx', array('id'=>'LearnCluster', 'target'=>'_blank')); ?>
		</div>
    </div>
</div>

<style>

</style>

<div id="RightColumn">
	<img class="block" src="<?php echo base_url(); ?>images/backgrounds/challenge-blue-top.gif">
	<div class="rc_cntr">
		<img class="block" src="<?php echo base_url(); ?>images/backgrounds/npos-top.png" />
		<div class="npo_cntr">
			<h1 class="title">Organizations</h1>
		    
			<div class="Browser" id="Browser" style="margin-top:25px;">
			        <?php $this->beex->create_browser($browser, 'npos'); ?>

		    </div>
		    
			<img src="<?php echo base_url(); ?>images/backgrounds/npos-bee.png" id="Bee" />
		</div>
		<img src="<?php echo base_url(); ?>images/backgrounds/npos-bottom.png" />
	</div>
	<img src="<?php echo base_url(); ?>images/backgrounds/challenge-blue-bottom.gif">
</div>

<div style="clear:both;"></div>

</div>

<?php
$this->load->view('framework/footer');
?>