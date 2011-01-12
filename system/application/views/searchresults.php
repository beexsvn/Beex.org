<?php
$this->load->view('framework/header', $header);
?>

<div id="SearchResults">

<div id="LeftColumn">
	
	<h2 class="title">Search Results</h2>
	<?php if(is_array($results)) : ?>
	    <?php if($results['challenges']->num_rows()) : ?>
			<div class="feed" id="ChallengesFeed">
		        <?php $this->beex->create_browser($results['challenges'], 'challenges'); ?>
	        </div>
		<?php endif; ?>
	
		<?php if($results['clusters']->num_rows()) : ?>
			<div class="feed" id="ClustersFeed">
		        <?php $this->beex->create_browser($results['clusters'], 'clusters', 'cluster'); ?>
	        </div>
		<?php endif; ?>
    
	    <?php if($results['people']->num_rows()) : ?>
			<div class="feed" id="PeopleFeed">
		        <?php $this->beex->create_browser($results['people'], 'people'); ?>
	        </div>
		<?php endif; ?>
	
		<?php if($results['npos']->num_rows()) : ?>
			<div class="feed" id="NPOSFeed">
		        <?php $this->beex->create_browser($results['npos'], 'nposearch'); ?>
	        </div>
		<?php endif; ?>
	    <?php if(!$results['challenges']->num_rows() && !$results['people']->num_rows() && !$results['npos']->num_rows()) : ?>
	    	<p>There are no results for your search. Go back to try again.</p>
	    <?php endif; ?>
	<?php else : ?>
		<p>Please enter a search term.</p>
	<?php endif; ?>
</div>

<div style="clear:both;"></div>

</div>


<?php
$this->load->view('framework/footer');
?>