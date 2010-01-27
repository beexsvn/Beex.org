<?php
$this->load->view('framework/header', $header);
?>

<div id="User">

<div id="LeftColumn">
	<?php
	// * Piece * - Thick Mini Profile
		echo $this->pieces->miniNPO($npo_id, false)
	?>
    
    <!--
    <div class="MiniGallery tout" id="MiniGallery">
    	<h2>Media Gallery</h2>
    </div>
    -->
    
    <!--
    <div class="Team" id="Team">
    	<div id="teamname">Team Name Here</div>
    </div>
    -->
    
</div>

<div id="RightColumn">
	<div id="challengeInfo">
	    <h2 class='title'>the challenges</h2>
        <div class="Browser BigBrowser" id="Browser">
	        <?php $this->beex->create_browser($browser, 'challenges'); ?>
        	
        </div>
        <?php if(false) echo anchor('challenge/start_a_challenge', '<img class="startbutton" src="/beex/images/buttons/start-challenge.gif">'); ?>
    
    

	    <h2 class='title'>the clusters</h2>
        <div class="Browser BigBrowser" id="Browser">
	        <?php $this->beex->create_browser($clusters, 'clusters'); ?>
        	
        </div>
        <?php if(false)  echo anchor('cluster/start', '<img class="startbutton" src="/beex/images/buttons/start-cluster.gif">'); ?>
        
    </div>
</div>

<div style="clear:both;"></div>

</div>



<?php
$this->load->view('framework/footer');
?>