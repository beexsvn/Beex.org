<?php

$this->load->view('framework/header', $header);

?>



<div id="LeftColumn">

	<h1 class="title" style="font-size:25px; margin-top:10px;">Recently Declared</h1>

	<div id="TodaysDeclarations">



		<?php $this->beex->displayRecentlyDeclared(); ?>





        <?php echo anchor('challenge/start_a_challenge', "<img src='/beex/images/buttons/start-challenge.png' alt='Start Your Own Challenge' class='start_challenge' />"); ?>

    </div>



    <div id="Login">

        <?php

		echo render_login($username);

		?>



    </div>







    <div id="JoinCluster" class="homeform">

    	<h2>Join a Cluster</h2>

        <form style="background-color:inherit;" method="post" action="/index.php/cluster/joina/">

         <label>cluster ID#</label>

         <input type="text" name="cluster_id">

         <input type="submit" value="Enter">

        </form>

    </div>





</div>





<div id="RightColumn">

	<div id="GraphicalExplanation" class="module">

    	<p>
        
        <object width="599" height="296"><param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="always" /><param name="movie" value="http://vimeo.com/moogaloop.swf?clip_id=8706824&amp;server=vimeo.com&amp;show_title=0&amp;show_byline=0&amp;show_portrait=0&amp;color=00ADEF&amp;fullscreen=1" /><embed src="http://vimeo.com/moogaloop.swf?clip_id=8706824&amp;server=vimeo.com&amp;show_title=0&amp;show_byline=0&amp;show_portrait=0&amp;color=00ADEF&amp;fullscreen=1" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="599" height="296"></embed></object>
        
        <!--<object width="600" height="360" style="width:100%;">

        <param name="movie" value="http://www.youtube.com/v/JD-VxfcYveI&hl=en&fs=1&"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/JD-VxfcYveI&hl=en&fs=1&" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="600" height="360"></embed></object>-->

        </p>

    	<div id="LearnMore">

    		<h3 class="javapopuplink"><a href="/pieces/auxpage.php?id=learnmore">Learn More</a></h3>

	        <p class="javapopuplink"><a href="/pieces/auxpage.php?id=learnnpo">Nonprofit Organizations</a> | <a href="/pieces/auxpage.php?id=learnsponsors">Sponsors</a> | <a href="/pieces/auxpage.php?id=learnpeople">Fund Raisers</a></p>

        </div>

      	<input type="input" value="Search" id="search" class="search" style="width:88%;"/> <input type="submit" value="Go!" />

    </div>



    <div id="BrowserModule" class="module">

    	<div class="tabs"><a id="browse_featured" class="browser_button button">Featured</a><a id="browse_raised" class="browser_button button" >Most Raised</a><a id="browse_ending" class="browser_button button">Ending Soon</a><a id="browse_new" class="browser_button button">New</a></div>

        <h2 class="title titlebg">Challenges</h1>



        <div class="Browser" id="Browser">

	        <?php $this->beex->create_browser($browser, 'challenges'); ?>



        </div>

    </div>

</div>



<div style="clear:both;"></div>



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