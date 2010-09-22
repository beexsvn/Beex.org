<?php
$this->load->view('framework/header', $header);
?>

<div id="Cluster">

<div id="LeftColumn">
	&nbsp;
</div>

<div id="RightColumn">
	<div id="challengeInfo">
    	<div class="tabs tabsmain"><a id="browse_featured" class="browser_button button">Cluster</a><a id="browse_raised" class="browser_button button">Challenge</a><a href="/beex/index.php/cluster/editor/donations" id="browse_ending" class="browser_button button">Donations</a><a href="/beex/index.php/cluster/editor/messaging" id="browse_new" class="browser_button button">Messaging</a><a id="browse_new" class="browser_button button">Sponsorship</a><a id="browse_new" class="browser_button button">Promotion</a></div>
	    <h1 class='title'>Editor</h1>
        	<style>
				table th {background-color:inherit; border:none; color:#999; vertical-align:top;}
				.messagebig {width:auto;}
				.messagetext {width:100%;height:200px;}
				#buttontable {margin-left:228px; width:65%; margin-top:10px;}
				#buttontable td {text-align:right; width:50%}
				#buttontable th {text-align:left; width:50%}
				#buttontable img {cursor:pointer;}
			</style>
            <form class="FormBG form" style="background-color:#fff;">
            	<h2 class="title">Messaging</h2>
                
                <table style="margin-bottom:0px;">
                	<tr>
                    	<th>Message Text</th>
                        <td class="messagebig"><?php echo generate_input('message', 'text', true, '', '', 'messagetext'); ?></td>
                    </tr>
                </table>
                
                <table id="buttontable">
                	<tr>
                    	<th><a href="/beex/media/donor_emails.xls"><img src="/beex/images/buttons/export-donor.gif" /></a></th>
                        <td><img src="/beex/images/buttons/send-all-donors.gif" /></td>
                    </tr>
                    
                    <tr>
                    	<th><img src="/beex/images/buttons/export-challenger.gif" /></th>
                        <td><img src="/beex/images/buttons/send-all-challengers.gif" /></td>
                    </tr>
                    
                    <tr>
                    	<th>&nbsp;</th>
                        <td><img src="/beex/images/buttons/send-all.gif" /></td>
                </table>
            </form>
            
        
    </div>
    
  
</div>

<div style="clear:both;"></div>

</div>



<?php
$this->load->view('framework/footer');
?>