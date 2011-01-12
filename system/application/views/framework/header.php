<?php

if(ctype_digit($this->session->userdata("fb_user"))) {
	$fb_user = $this->session->userdata("fb_user");
}
else {
	$fb_user = false;
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title><?php echo $title; ?></title>

<link href="<?php echo base_url(); ?>beex_styles/beex.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>beex_styles/new.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>styles/smoothness/jquery-ui-1.7.2.custom.css" rel="stylesheet" type="text/css" /> 
<link href="<?php echo base_url(); ?>styles/smoothness/ui.datepicker.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>styles/colorbox.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>styles/ceebox/ceebox.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>styles/tipTip.css" rel="stylesheet" type="text/css" />

<?php if(@$admin) : ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>beex_styles/admin.css" />
<?php endif; ?>	

<link rel="Shortcut Icon" href="<?php echo base_url(); ?>/favicon.ico">
<link rel="icon" href="<?php echo base_url(); ?>/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="<?php echo base_url(); ?>/favicon.ico">
<link rel="icon" type="image/ico" href="<?php echo base_url(); ?>/favicon.ico">


<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>scripts/beex_base.js"></script>
<script language="javascript" type="text/javascript" src="http://code.jquery.com/jquery-1.4.2.min.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery-popup.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery-ui-1.7.2.custom.min.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>scripts/ui.datepicker.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery.colorbox-min.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery.ceebox-min.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery.easing.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery.metadata.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery.color.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery.timers.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery.preloader.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery.tipTip.minified.js"></script>
 
<!--[if lte IE 6]>
	<script type="text/javascript" src="<?php echo base_url(); ?>scripts/superslight-min.js"></script>
    <script type="text/javascript" >
    	jQuery(document).ready(function(){
    		jQuery("#Logo").supersleight({shim: '<?php echo base_url(); ?>/images/header/x.gif'}); 
        });
    </script>
<![endif]-->

<!--[if IE 7]> 
<link href="<?php echo base_url(); ?>beex_styles/ie.css" rel="stylesheet" type="text/css" />
<![endif]-->

<!--[if lt IE 7]>
<div style='border: 1px solid #F7941D; background: #FEEFDA; text-align: center; clear: both; height: 75px; position: relative;'>
  <div style='position: absolute; right: 3px; top: 3px; font-family: courier new; font-weight: bold;'><a href='#' onclick='javascript:this.parentNode.parentNode.style.display="none"; return false;'><img src='http://www.ie6nomore.com/files/theme/ie6nomore-cornerx.jpg' style='border: none;' alt='Close this notice'/></a></div>
  <div style='width: 640px; margin: 0 auto; text-align: left; padding: 0; overflow: hidden; color: black;'>
    <div style='width: 75px; float: left;'><img src='http://www.ie6nomore.com/files/theme/ie6nomore-warning.jpg' alt='Warning!'/></div>
    <div style='width: 275px; float: left; font-family: Arial, sans-serif;'>
      <div style='font-size: 14px; font-weight: bold; margin-top: 12px;'>You are using an outdated browser</div>
      <div style='font-size: 12px; margin-top: 6px; line-height: 12px;'>This site was designed to be used with a modern web browser. For a better experience using this site, please upgrade your browser.</div>
    </div>
    <div style='width: 75px; float: left;'><a href='http://www.firefox.com' target='_blank'><img src='http://www.ie6nomore.com/files/theme/ie6nomore-firefox.jpg' style='border: none;' alt='Get Firefox 3.5'/></a></div>
    <div style='width: 75px; float: left;'><a href='http://www.browserforthebetter.com/download.html' target='_blank'><img src='http://www.ie6nomore.com/files/theme/ie6nomore-ie8.jpg' style='border: none;' alt='Get Internet Explorer 8'/></a></div>
    <div style='width: 73px; float: left;'><a href='http://www.apple.com/safari/download/' target='_blank'><img src='http://www.ie6nomore.com/files/theme/ie6nomore-safari.jpg' style='border: none;' alt='Get Safari 4'/></a></div>
    <div style='float: left;'><a href='http://www.google.com/chrome' target='_blank'><img src='http://www.ie6nomore.com/files/theme/ie6nomore-chrome.jpg' style='border: none;' alt='Get Google Chrome'/></a></div>
  </div>
</div>
<![endif]-->


</head>

<body>

<!-- Facebook Integration Initialization -->
<div id="fb-root"></div>
<script type="text/javascript">
    window.fbAsyncInit = function() {
        FB.init({appId: '<?php echo $this->config->item('facebook_api_key')?>', status: true, cookie: true, xfbml: true}, '<?php echo base_url(); ?>xd_receiver.htm');

		     /* All the events registered */
		     FB.Event.subscribe('auth.login', function(response) {
		         // do something with response
		         //login();
		     });
		     FB.Event.subscribe('auth.logout', function(response) {
		         // do something with response
		         //logout();
		     });

		     FB.getLoginStatus(function(response) {
		         if (response.session) {
		             // logged in and connected user, someone you know
		             //login();
		         }
		     });
		
    };
    (function() {
        var e = document.createElement('script');
        e.type = 'text/javascript';
        e.src = document.location.protocol +
            '//connect.facebook.net/en_US/all.js';
        e.async = true;
        document.getElementById('fb-root').appendChild(e);
    }());
</script>

<!-- BEEx.org scripts -->
<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>beex_scripts/beex.js"></script>


<div id="Header">
 <div id="SubHeader">
	 
 <div id="HiddenLogIn" class="hidden_element">
	<div class="form_element">
		<label>Email</label>
		<div class="short_text_input"><input type="text" name="hidden_login_email" id="hidden_login_email"></div>
	</div>
	<div class="form_element">
		<label>Password</label>
		<div class="short_text_input"><input type="password" name="hidden_login_password" id="hidden_login_password"></div>
	</div>
	
	<?php echo anchor('user/forgot', 'Forgot your password?'); ?>
	
	<div id="hidden_login_errors"></div>
	
	<div class="small_button" id="hidden_close_button">Close</div>
	<div class="small_button" id="hidden_login_button">Log In</div>
	
 </div>	
	
  <?php echo anchor("site/", '<img id="Logo" src="'.base_url().'/images/logo.png" />', array('target'=>'_parent')); ?>
	<div class="bee_tail"></div>
  <form id="SearchForm" method="POST" action="<?php echo base_url(); ?>/index.php/search/">
	<div class="search_bg">
		<input type="input" name="searchterm" value="Search..." class="search" onfocus="this.value=''"/>
	</div><input type="image" value="Go!" src="<?php echo base_url(); ?>images/buttons/search-go-off.png"  /></form>
  <div id="UpperMenu">

  	 <?php if($user_id = $this->session->userdata('user_id')) : ?>
			
			<?php if($this->session->userdata('super_user')) : ?>
				<?php echo anchor('admin/', 'Admin'); ?> &bull;
			<?php endif; ?>
			
			
			<?php if($fb_user) : ?>
				<a href="#" onclick="FB.logout(function() {window.location='<?=base_url()?>index.php/user/logout' }); return false;" >Logout</a>
			
			<?php else : ?>
				<a href="<?php echo base_url(); ?>index.php/user/logout">Logout</a>
			
			<?php endif; ?>
			
			<?php
            // "a8656f..." should be replaced with $this->config->item('facebook_api_key');
            echo ' &bull; '.anchor('user/view/'.$user_id, 'My Profile');
        else :
			
			?>
			
			<?php if(@$external_header) : ?>
				<?php echo anchor('user/newuser', 'Register', 'target="_parent"'); ?> &bull; <?php echo anchor('user/login', 'Login', 'target="_parent"'); ?>
			<?php else : ?>
			<div id="RegisterButton" class='register_button'>
				<a>Register</a>
				<div class="register_types">
					<p>Are you an organization or a person?</p>
					<?php echo anchor('npo/newNpo', 'Organization'); ?>
					<?php echo anchor('user/newuser', 'Person'); ?>
				</div>
			</div>
			
			<?php
			
			 echo  '&bull; <a id="user_login_button">Login</a>';
			
			endif;

		endif; 

     ?>

  </div>

  <div id="Menu">

  	<?php echo anchor('challenge/', 'Challenges', array('class'=>"tab", 'target'=>"_parent")); ?>

    <?php echo anchor('cluster/', 'Clusters', array('class'=>"tab", 'target'=>"_parent")); ?>

    <?php //echo anchor('user/', 'People', array('class'=>"tab tab3")); ?>

    <?php echo anchor('npo/', 'Organizations', array('class'=>"tab", 'target'=>"_parent")); ?>

   	<a href="http://learn.beex.org/index.php?option=com_content&view=category&layout=blog&id=1&Itemid=33" class="tab" target="_parent">Learn</a>

  </div>

 </div>

</div>



<div id="MainContainer">

 <div id="SubContainer" <?php if(@$admin) echo 'class="Admin"'; ?> >