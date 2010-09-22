<?php

$this->load->view('framework/header', $header);

?>

<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>beex_scripts/beex_slideshow.js"></script>

<!-- Recently Declared -->
<div id="LeftColumn">

	<h1 class="recently_declared_title">Recently Declared</h1>

	<div id="TodaysDeclarations">
		<div id="DeclarationsBox">


		<?php $this->beex->displayRecentlyDeclared(40); ?>

		</div>
    </div>

	
	<div class="rd_controls controls"><img class="scrollUp" src="<?php echo base_url(); ?>images/buttons/up.png"><img class="scrollDown" src="<?php echo base_url(); ?>images/buttons/down.png"></div>
	
</div>


<img src="<?php echo base_url(); ?>images/backgrounds/home-blue-bg.png" class="block">
<div id="RightColumn">
	<div id="GraphicalExplanation" class="homemodule">
    	<div id="HPSlideshow">
			<div class="slide" id="Slide1">
				<img class="tagline" src="<?php echo base_url(); ?>images/slideshow/text1.png">
			</div>
			<div class="slide" id="Slide2">
				<img class="tagline" src="<?php echo base_url(); ?>images/slideshow/text2.png">
			</div>
			<div class="slide" id="Slide3">
				<img class="tagline" src="<?php echo base_url(); ?>images/slideshow/text3.png">
			</div>
			<div class="slide" id="Slide4">
				<img class="tagline" src="<?php echo base_url(); ?>images/slideshow/text4.png">
			</div>
			<div class="slide" id="Slide5">
				<img class="img1" src="<?php echo base_url(); ?>images/slideshow/text51b.png">
				<?php echo anchor('challenge/start_a_challenge', '<img class="img2" src="'.base_url().'images/slideshow/text52.png">'); ?>
				<!--<img class="img3" src="<?php echo base_url(); ?>images/slideshow/text53.png">-->
			</div>
			<div class="slide" id="Slide6">
				<?php echo anchor('challenge/start_a_challenge', '<img class="img1" src="'.base_url().'images/slideshow/text61.png">'); ?>
				<?php echo anchor('cluster/start/', '<img class="img2" src="'.base_url().'images/slideshow/text62.png">'); ?>
				<img class="img3" src="<?php echo base_url(); ?>images/slideshow/text63.png">
			</div>
			<div class="slide" id="Slide7">
				<img class="img1" src="<?php echo base_url(); ?>images/slideshow/text7.png">
			</div>
		
		</div>
        
		<div class="hp_tagline">
        	<p><a href="<?php echo base_url(); ?>"><b>BEEx.org</b></a> is a place where people raise money and awareness for organizations by doing stuff.
			Organizations can <?php echo anchor('npo/newNpo', 'register here'); ?> for our free service. We take no transaction fees.</p>
		</div>
    	
        <div class="homebox homeboxleft">
        	<h3><img src="<?php echo base_url(); ?>images/glyphs/challenge-home.png">Challenges</h3>
        	<p>Do something to raise money for the organization of your choice.
			</p>
            <?php echo anchor('challenge/start_a_challenge', 'Start', array('class'=>"home_button left")); ?>
            <?php echo anchor('http://learn.beex.org/?page_id=44#What_is_a_challenge', 'Learn', array('class'=>"home_button right", 'target'=>'_blank')); ?>
        </div>
        
        <div class="homebox homeboxright">
        	<h3><img src="<?php echo base_url(); ?>images/glyphs/cluster-home.png">Clusters</h3>
            <p>Create a group fundraising initiative.
			</p>
            <?php echo anchor('cluster/start', 'Start',array('class'=>"home_button left")); ?>
            <?php echo anchor('http://learn.beex.org/?page_id=44#What_is_a_cluster', 'Learn', array('class'=>"home_button right", 'target'=>'_blank')); ?>
        </div>
		<div style="clear:both;"></div>
	</div>
	<img src="<?php echo base_url(); ?>images/backgrounds/home-blue-bg-bottom.png">
	
</div>


<div style="clear:both;"></div>



<?php
$this->load->view('framework/footer');

?>