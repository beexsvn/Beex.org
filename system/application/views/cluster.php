<?php
$this->load->view('framework/header', $header);
?>

<div id="challenge">

<div id="LeftColumn">
	<?php
	
	// *Piece* - Mini Profile
	echo $this->pieces->miniProfile($user_id);
	
	// * Piece * - Mini NPO
	echo $this->pieces->miniNPO($item->cluster_npo);
	
	?>
    
   
</div>

<div id="RightColumn">
	<div id="challengeInfo">
	    <h1 class='title'>the cluster</h1>
        <div id="InfoDisplay" class="InfoDisplay">
            <h2><?php echo $item->cluster_title; ?> <?php  echo anchor('cluster/joina/'.$item->theid, '<img src="/beex/images/buttons/join.gif" style="float:right; margin-left:20px;" />');?> <?php if($owner) echo anchor('cluster/editor/'.$item->theid.'/edit', '<img src="/beex/images/buttons/edit.gif" style="float:right;" />'); ?></h2>
           
            
            <?php $this->beex->generate_info_display($item, 'clusters'); ?>
            
            <div class="essential">
           		<table class="whatwherewhen" cellspacing=0 cellpadding=0 border=0>
                    <tr>
                     <th>What:</th><td rowspan="3" style="padding:5px; vertical-align:middle; text-align:center;">Find out more by selecting a challenge below:</td>
					</tr>
                    <tr>
	               	 	<th>Where:</th>
                    </tr>
                    <tr>
	                	<th>When:</th>
                    </tr>
				</table>
            	
                <div class="right">
	                
                    <p class="blurb">
                    	Blurb: <?php echo $item->cluster_blurb; ?>
			        </p>
                    <p class="description">
    	            	Description: <?php echo $item->cluster_description; ?>
			        </p>
                    
                </div>
                
            </div>
            <div class='social'>
            	SHARE: 
               	<a style="margin-left:15px;" name="fb_share" type="icon_link" href="http://www.facebook.com/sharer.php">Share on Facebook</a><script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share" type="text/javascript"></script>
               <span style="margin-left:15px;"><script type="text/javascript" src="http://w.sharethis.com/button/sharethis.js#publisher=bfd562d7-4fbd-425d-8a09-678ae7f18fd6&amp;type=website&amp;embeds=true&amp;style=rotate&amp;post_services=email%2Cfacebook%2Ctwitter%2Cmyspace%2Cdigg%2Csms%2Cwindows_live%2Cdelicious%2Cwordpress%2Cstumbleupon%2Ccare2%2Ccurrent%2Creddit%2Cgoogle_bmarks%2Clinkedin%2Cbebo%2Cybuzz%2Cblogger%2Cyahoo_bmarks%2Cmixx%2Ctechnorati%2Cfriendfeed%2Cpropeller%2Cnewsvine%2Cxanga&amp;headerbg=%23FF9900&amp;headerTitle=Share%20your%20Cluster%20on%20other%20Networks%20"></script></span>
                <!--<img src="/beex/images/share/email.png" /> EMAIL-->
            </div>
             
            <div style="clear:both;"></div>
        </div>
        
        <img src="/beex/images/temp/search.gif" style="margin-bottom:10px;"/>
        <div id="TheChallenges" class="form">
        	<div class="tabs"><a id="browse_featured" class="browser_button button">Featured</a><a id="browse_raised" class="browser_button button">Most Raised</a><a id="browse_ending" class="browser_button button">Ending Soon</a><a id="browse_new" class="browser_button button">New</a></div>
            <h2 class="title titlebg">The Challenges</h2>
            
            <div class="Browser BigBrowser" id="Browser">
                <?php $this->beex->create_browser($browser, 'challenges'); ?>
                
            </div>
        </div>
    </div>
    
  
</div>

<div style="clear:both;"></div>

</div>



<?php
$this->load->view('framework/footer');
?>