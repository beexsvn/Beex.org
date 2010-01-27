<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
      xml:lang="en-US"
      lang="en-US">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php
	$myStyle = get_option('layers_style');
?>
<link rel="stylesheet" type="text/css" href="<?php print $myStyle; ?>" media="screen" title="style (screen)" />

<?php
	global $layers_options;	
	if ($layers_options['width']=='fixed')
		echo "<style>.center{width:980px;}</style>";
?>

<title><?php bloginfo('name'); ?> <?php wp_title(); ?> </title>
<?php /* you can include other xhtml meta tags according to your site here */ ?> 
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php wp_head(); ?>
</head>

<body>

    <div id="wrapper">
        <!-- Begin wrapper -->

        <div id="header">

            <!-- begin header -->

            <div class="center">
                <!-- Begin center -->

                <div id="headerTop">
                    <!-- Begin headerTop -->

	                <h1><a rel="home" href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a></h1>
	                <h2><?php bloginfo('description'); ?></h2>

                </div><!-- End headerTop -->

                <div id="navigation">
                    <!-- Begin navigation -->

	                <ul>
                        <li><a href="<?php echo get_option('home'); ?>/">Blog</a></li>
                        <?php wp_list_pages('title_li=&depth=1'); ?>
	                </ul>
                </div><!--End navigation -->
            </div><!-- End center -->
        </div><!-- End header -->
