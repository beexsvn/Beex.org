<?php
$this->load->view('framework/header', $header);
?>

<div id="challenge">

<div id="LeftColumn">
	<div class="tout" id="StartACluster" style="margin:15px 0;">
    	<?php echo anchor('challenge/start_a_challenge', '<img src="/beex/images/buttons/start-challenge.gif">'); ?>
        
    </div>
</div>

<div id="RightColumn">
<div id="BrowserModule" class="module">
	<h1 class="title">Search Results</h1>
	
    <?php if($results['challenges']->num_rows()) : ?>
    <h2 class="title">Challenges</h2>
		<div class="Browser BigBrowser" id="Browser">
	        <?php $this->beex->create_browser($results['challenges'], 'challenges'); ?>
        </div>
	<?php endif; ?>
    
    <?php if($results['people']->num_rows()) : ?>
    <h2 class="title">People</h2>
		<div class="Browser BigBrowser" id="Browser">
	        <?php $this->beex->create_browser($results['people'], 'people'); ?>
        </div>
	<?php endif; ?>
    
    <?php if(!$results['challenges']->num_rows() && !$results['people']->num_rows()) : ?>
    	<p>There are no results for your search</p>
    <?php endif; ?>
</div>
</div>

<div style="clear:both;"></div>

</div>


<?php
$this->load->view('framework/footer');
?>