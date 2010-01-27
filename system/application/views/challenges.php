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
	<h1 class="title">Challenges</h1>
	<div id="Featuredchallenges" class="featuredbox">
		<?php $this->beex->create_featured($browser, 'challenges'); ?>  
    </div>
    	
        <?php //Put Search Bar here ?>
        
       <div class="tabs"><a id="browse_popular" class="browser_button button">Popular</a><a id="browse_raised" class="browser_button button">Most Raised</a><a id="browse_ending" class="browser_button button">Ending Soon</a><a id="browse_new" class="browser_button button">New</a></div>
    	
        <h2 class="title">Browse Challenges</h2>
    	
        <div class="Browser BigBrowser" id="Browser">
	        <?php $this->beex->create_browser($browser, 'challenges'); ?>
        	
        </div>
    </div>
    
    
</div>

<div style="clear:both;"></div>

</div>

<script type="text/javascript">
jQuery(document).ready(function(){
	
	jQuery(".browser_button").click(function() {
		var id = $(this).attr('id').substring(7);
		
		jQuery.ajax({
			 type: "POST",
			 url: "ajax/get_browsers",
			 data: "type=challenges&sort="+id,
			 success: function(html){
				jQuery("#Browser").html(html);
			 }
		});
				
	});
});
</script>

<?php
$this->load->view('framework/footer');
?>