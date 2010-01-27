<?php
$this->load->view('framework/header', $header);
?>

<div id="Gallery">

    <div id="LeftColumn">
        <div class="MiniProfile" id="MiniProfile">
            <h2><?php echo $profile->first_name." ".$profile->last_name; ?></h2>
            <div class='image'></div>
            <p>Hometown</p>
            <p><a><?php echo $profile->hometown; ?></a></p>
            <p>Network</p>
            <p><a><?php echo $profile->network; ?></a></p>
            
            <p style="margin-top:15px;">Challenges:</p>
            <p><a>Active: (1)</a></p>
            <p><a>Complete: (0)</a></p>
        </div>
        
        <div class="Team" id="Team">
            <div id="teamname">Team Name Here</div>
        </div>
        
        <div id="Ads">
            <p>Ad</p>
        </div>
    </div>
    
    <style>
	.gallery {padding:30px; background-color:#fff;}
	.gallery .m {width:150px; height:120px; border:1px solid #999; position:relative; margin:8px; float:left;}
	.gallery .m .transparent {background-color:#000; opacity:.5; position:absolute; top:0px; left:0px; width:150px; height:120px; display:none;}
	.gallery .m img {width:150px; height:120px;}
	.gallery .m p {margin:0; padding:0;}
	.gallery .m .name {font:bold 10.5px Verdana, Geneva, sans-serif; color:#fff; top:0px; margin:4px; position:absolute;}
	.gallery .m .time {font:bold 10.5px Verdana, Geneva, sans-serif; color:#fff; bottom:0px; right:0px; background-color:#ff9900; padding:2px; position:absolute;}
	
	.gallery .m:hover {border-color:#ff9900;}
	.gallery .m:hover .transparent {display:block;}
	
	</style>
    
    <div id="RightColumn">
        <div id="ViewGallery" class="widecol">
            <h1 class='title'>Media Center</h1>
            <div id="InfoDisplay" class="InfoDisplay">
                <h2><?php echo $gallery->name; ?></h2>
            	<div class="gallery">
                	<?php foreach($media->result() as $m) {
					?>
                    	<a href="../../gallery/view_media/<?php echo $m->id; ?>"><div class="m">
                        	<img src="/beex/media/<?php echo $item->id; ?>/<?php echo $m->link; ?>" />
                            <div class="transparent">
	                            <p class="name"><?php echo $m->name; ?></p>
    	                        <p class="time"><?php echo $m->created; ?></p>
                            </div>
                        </div></a>
                    <?php
					} ?>
					<div style="clear:both;"></div>
               	</div>
            </div>
        </div>
    </div>
    
    <div style="clear:both;"></div>
	
</div>

<?php
$this->load->view('framework/footer');
?>