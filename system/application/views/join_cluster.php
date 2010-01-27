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
	    <h1 class='title'>the cluster</h1>
        <div id="InfoDisplay" class="InfoDisplay">
            <h2><?php echo $item->cluster_title; ?></h2>
           
            
            <?php $this->beex->generate_info_display($item, 'clusters'); ?>
            
            
            <div class='social'>
            	SHARE: 
               	<img src="/beex/images/share/facebook.png" /> FACEBOOK
                <img src="/beex/images/share/twitter.png" /> TWITTER
                <img src="/beex/images/share/email.png" /> EMAIL
            </div>
            
            <div style="clear:both;"></div>
        </div>
        
        <img src="/beex/images/temp/search.gif" style="margin-bottom:10px;"/>
        <div id="TheClusters" class="form">
        	<div class="tabs"><a id="browse_featured" class="browser_button button">Who</a><a id="browse_raised" class="browser_button button">What</a><a id="browse_ending" class="browser_button button">Why</a><a id="browse_new" class="browser_button button">How</a></div>
            <h2 class="title titlebg">Join This Cluster</h2>
            <table cellpadding="0" cellspacing="0" border="0" style="width:100%;">
             <tr>
               <td class="join_essential" style="width:28%;">

            <style>
				.join_essential table th {color:#efab32; background-color:inherit; border:none; font:bold 12px Verdana, Geneva, sans-serif; padding:5px;}
				.join_essential table td {color:#333; font:11px Verdana, Geneva, sans-serif; padding:5px;}
			</style>
           		<table class="whatwherewhen" cellspacing=0 cellpadding=0 border=0>
                	<tr>
                    	<td colspan="2" class="essentialinfo" style="font:20px Verdana, Geneva, sans-serif; color:#efab32; text-transform:uppercase;">Essential Info</td>
                    </tr>
                    <tr>
                     <th>What:</th><td><?php echo $item->cluster_ch_declaration; ?></td>
					</tr>
                    <tr>
	               	 	<th>Where:</th><td><?php echo $item->cluster_location; ?></td>
                    </tr>
                    <tr>
	                	<th>When:</th><td><?php echo $item->cluster_ch_completion; ?></td>
                    </tr>
				</table>
              </td>
             
              <td class="form FormBG" id="JoinForm" style="width:64%;">
              <?php $this->load->view('challenge_form.php', array('cluster' => $item, 'new'=>true, 'username'=>$data['username'], 'user_id' => $data['user_id'], 'message' => $message)); ?> 
               
             
                
               
             </td>
            </tr>
           </table>

        </div>
         
    </div>
    
  
</div>

<div style="clear:both;"></div>

</div>



<?php
$this->load->view('framework/footer');
?>