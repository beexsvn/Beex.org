<?php
$this->load->view('framework/header', $header);
?>

<div id="Media">

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
    
    <div id="RightColumn">
        <div id="ViewGallery" class="widecol">
            <h1 class='title'>Media Center</h1>
            <div id="InfoDisplay" class="InfoDisplay">
                <h2><?php echo $media->name; ?> >> <?php echo anchor('gallery/view_gallery/'.$gallery->id, $gallery->name); ?> </h2>
            	<div class="mediaviewer">
                	<?php if($prev) {
	                		echo anchor('gallery/view_media/'.$prev, '<img class="leftarrow" src="/beex/images/assets/left-arrow.png">');
						}
					?>
                	<div class="img">
                	   	<img src="/beex/media/<?php echo $item->id; ?>/<?php echo $media->link; ?>" />
                        <p class="time"><?php echo date('m.d.Y', strtotime($media->created)); ?></p>
                    </div>
                    <?php if($next) {
	                		echo anchor('gallery/view_media/'.$next, '<img class="rightarrow" src="/beex/images/assets/right-arrow.png">');
						}
					?>
                    
                    <?php echo anchor('gallery/view_gallery/'.$gallery->id, '<img class="thumbback" src="/beex/images/assets/thumbback.png">'); ?>
                    <div class="caption">
                    	<p><?php echo $media->caption; ?></p>
                    </div>
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