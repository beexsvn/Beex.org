<?php
$this->load->view('framework/header', $header);
?>

<div id="NPOS">

<div id="LeftColumn">
	<div class="tout" id="NewNPO" style="margin:15px 0;">
    	<?php echo anchor('npo/newNpo', '<img src="/beex/images/buttons/register-npo.gif">'); ?>

    </div>




</div>

<div id="RightColumn">
<div id="BrowserModule" class="module">
	<h1 class="title">Nonprofits</h1>
	<!--<div id="FeaturedClusters" class="featuredbox">
	    <?php $this->beex->create_featured($browser, 'npos'); ?>
    </div>

    	<img src="/beex/images/temp/search.gif" style="margin:15px 0;">
        <div class="tabs"><a id="browse_featured" class="browser_button button">Featured</a><a id="browse_raised" class="browser_button button">Most Raised</a><a id="browse_ending" class="browser_button button">Ending Soon</a><a id="browse_new" class="browser_button button">New</a></div>
    	<h2 class="title titlebg">More Non-Profits</h1>
    	-->
        <div class="Browser" id="Browser">
	        <?php $this->beex->create_browser($browser, 'npos'); ?>

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
			 data: "type=clusters&sort="+id,
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