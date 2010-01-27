<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title><?php echo $title; ?></title>

<link href="<?php echo base_url(); ?>styles/beex.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url(); ?>styles/smoothness/jquery-ui-1.7.2.custom.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url(); ?>styles/smoothness/ui.datepicker.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url(); ?>styles/colorbox.css" rel="stylesheet" type="text/css" />

<link rel="Shortcut Icon" href="/favicon.ico">
<link rel="icon" href="/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="favicon.ico">
<link rel="icon" type="image/ico" href="favicon.ico">


<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery-1.3.2.js"></script>

<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery-popup.js"></script>

<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery-ui-1.7.2.custom.min.js"></script>

<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>scripts/ui.datepicker.js"></script>

<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery.colorbox-min.js"></script>

<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>scripts/beex.js"></script>

<script>

$(document).ready(function(){

    $(".datepicker").datepicker();

  });



</script>

</head>



<body>



<div id="Header">

 <div id="SubHeader">

  <?php echo anchor("site/", '<img id="Logo" src="/images/header/logo-beat.png" />'); ?>
 
  <div id="UpperMenu">

  	 <?php

	 	if($user_id = $this->session->userdata('user_id')) {

	 		echo anchor('user/logout', 'Logout').' &bull; '.anchor('user/view/'.$user_id, 'My Profile');

		}

		else {

			echo anchor('user/login', 'Login');

		}

     ?>

  </div>

  <div id="Menu">

  	<?php echo anchor('challenge/', 'Challenges', array('class'=>"tab tab")); ?>

    <?php echo anchor('cluster/', 'Clusters', array('class'=>"tab tab")); ?>

    <?php echo anchor('user/', 'People', array('class'=>"tab tab3")); ?>

    <?php echo anchor('npo/', 'Nonprofits', array('class'=>"tab tab4")); ?>

    <?php echo anchor(($user_id) ? 'user/view/'.$user_id : 'user/login', 'Account', array('class'=>'tab')); ?>

  </div>

 </div>

</div>



<div id="MainContainer">

 <div id="SubContainer">