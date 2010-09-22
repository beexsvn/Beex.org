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
            	<h2 class="title">Donations</h2>
                
                <img src="/beex/images/temp/donor_bdown.gif" style="margin:30px 35px 10px;" />
                <br />
                <a href="/beex/media/donor_breakdown.xls"><img src="/beex/images/buttons/export_donor_bdown.gif" style="float:right; margin:0px 36px;" /></a>
                
                <img src="/beex/images/temp/transactionemails.gif" style="margin:30px 35px 10px;" />
                <br />
                <a href="/beex/media/donor_emails.xls"><img src="/beex/images/buttons/export-emails.gif" style="margin:0px 225px 60px;" /></a>
                
                <img src="/beex/images/buttons/backnext.gif" style="display:block; margin:0px auto; padding-bottom:20px;" />
            </form>
            
        
    </div>
    
  
</div>

<div style="clear:both;"></div>

</div>



<?php
$this->load->view('framework/footer');
?>