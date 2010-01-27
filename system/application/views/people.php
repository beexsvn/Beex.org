<?php
$this->load->view('framework/header', $header);
?>

<div id="People">

<style>

</style>

<div id="LeftColumn">
	
    <div id="Login">
        <?php
		echo render_login($username, true);
		?>
        
    </div>
  
    
    <div id="Filter">
    	<p></p>
        <p></p>
        <p></p>
    </div>
</div>

<div id="RightColumn">
	
    
    <div id="BrowserModule" class="module">
    	<div class="tabs" style="display:none;"><a id="browse_popular" class="browser_button button">Popular</a><a id="browse_new" class="browser_button button">New</a><a id="browse_popular" class="browser_button button">Ending Soon</a><a id="browse_raised" class="browser_button button">Most Raised</a></div>
    	<h2 class="title titlebg">Browse People</h2>
    	
        <div class="Browser" id="Browser">
	        <?php $this->beex->create_browser($browser, 'people'); ?>
        	
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