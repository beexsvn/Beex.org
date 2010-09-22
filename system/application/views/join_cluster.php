<?php
$this->load->view('framework/header', $header);
?>

<div id="Cluster">

<div id="LeftColumn">
	
	<?php
	
	// Display MiniProfile
	echo $this->pieces->miniProfile($item->user_id);
	?>

    <!--
    <div class="Team" id="Team">
    	<div id="teamname">Team Name Here</div>
    </div>
    -->
    
    <?php 
	// * Piece * - MiniNPO
	echo $this->pieces->miniNPO($item->cluster_npo); 
	
	?>
    
    
    
</div>

<div id="RightColumn">
	<div id="challengeInfo">
	    <h1 class='title'>Join this cluster</h1>
        <!--<div id="InfoDisplay" class="InfoDisplay">
            <h2></h2>
           
            
            <?php $this->beex->generate_info_display($item, 'clusters'); ?>
            
            
            <div class='social'> 
            	SHARE: 
               	<img src="/beex/images/share/facebook.png" /> FACEBOOK
                <img src="/beex/images/share/twitter.png" /> TWITTER
                <img src="/beex/images/share/email.png" /> EMAIL
            </div>
            
            <div style="clear:both;"></div>
        </div>
        
        <img src="/beex/images/temp/search.gif" style="margin-bottom:10px;"/>-->
        <div id="TheClusters" class="form">
        	<h2 class="title" style="background-color:#EFAB32; color:#fff; padding:5px 5px; width:auto;"><?php echo $item->cluster_title; ?></h2>
              <?php $this->load->view('challenge_new_form.php', array('cluster' => $item, 'new'=>true, 'username'=>$data['username'], 'user_id' => $data['user_id'], 'message' => $message)); ?> 
               
            
        </div>
         
    </div>
    
  
</div>

<div style="clear:both;"></div>

</div>



<?php
$this->load->view('framework/footer');
?>