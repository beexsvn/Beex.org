<?php


$DB_HOST = "internal-db.s85554.gridserver.com";
$DB_USER = "db85554";
$DB_PASS = "newkids22";
$DB_DB = "db85554_beexmaster";

/*
$DB_HOST = 'localhost';
$DB_USER = "root";
$DB_PASS = "root";
$DB_DB = "beex";
*/
//$base_url = 'http://localhost:8888/beex/';
//$base_url = 'http://sandbox.beex.org/';
$base_url = 'http://www.beex.org/';

function db_connect($db_host, $db_user, $db_pass, $db_db) {
	
	$mydb = mysql_connect($db_host, $db_user, $db_pass) or die(mysql_error());
	
	mysql_select_db($db_db, $mydb) or die(mysql_error());
	
	return $mydb;
}

$mydb = db_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_DB);

$id = $_GET['challenge_id']; 
//$name = $_GET['challenge_name'];

$query = "SELECT challenges.challenge_title AS name, profiles.first_name, profiles.last_name, npos.paypal_email, npos.name AS nponame, npos.id FROM challenges, npos, profiles WHERE npos.id = challenges.challenge_npo AND challenges.user_id = profiles.user_id AND challenges.item_id = '".mysql_real_escape_string($id)."';";

$result = mysql_query($query, $mydb);

if(mysql_num_rows($result)) {
	$info = mysql_fetch_assoc($result);	
}

mysql_close($mydb);

?>

<script type="text/javascript" language="javascript">

function swapGraphic(state) {
	
	if(state == 'on') {
		document.getElementById('ac1').src = "<?php echo $base_url; ?>images/backgrounds/give/donate-on.png";
	}
	else {
		document.getElementById('ac1').src = "<?php echo $base_url; ?>images/backgrounds/give/donate-off.png";
	}
	
}

</script>


<style>

*:focus {outline: none;}

h2 {font:20px 'Arial Rounded MT Bold', 'Arial Black', Arial, sans-serif; color:#5C6771; margin:0 0 10px; padding:0;}
p {margin:10px 0px; color:#5C6771; font:12px Verdana, Arial, sans-serif;}
div {font:12px Verdana, Arial, sans-serif; color:#5C6771;}

.input_textarea {background-image:url('<?php echo $base_url; ?>images/backgrounds/give/textarea.png'); width:271px; height:61px; background-position:center top; background-repeat:no-repeat;}
.input_textarea textarea {width:260px; height:51px; font:11px verdana, arial, sans-serif; border:none; margin:5px 6px;}

.input_text {background-image:url('<?php echo $base_url; ?>images/backgrounds/give/input.png'); width:133px; height:20px; background-position:center top; background-repeat:no-repeat; padding-left:4px;}
.input_text input {height:12px; border:none; margin:4px 6px 4px 0; width:113px;}

.donatebuttoncntr {text-align:center; padding-top:12px; border-top:1px solid #CCC;}
</style>



<div style="width:324px; text-align:left;">

<h2>Give Box</h2>

<!--<form id="DonateForm" target="paypal" class="add_form" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">-->
<form id="DonateForm" target="paypal" class="add_form" action="https://www.paypal.com/cgi-bin/webscr" method="post" onSubmit='parent.$.fn.ceebox.closebox();'>


    <p>How much would you like to donate to the challenge <b><?php echo $info['name']; ?></b>, benefitting the nonprofit <?php echo $info['nponame']; ?>?</p>

	<p><span style="float:left">(ex. $22.50)</span> <div class="input_text" style="float:left; margin-left:5px;">$ <input type="text" id="pp_item_price1" name="amount" value=""></div></p>

    <p style="padding-top:17px; clear:both;">Leave a Comment:</p>

    <div class="input_textarea"><textarea name="os0"></textarea></div>

    <p style="padding-top:15px;">Check here to donate anonymously <input name="os1" type="checkbox" value="Yes" /></p>
	
    <div class="donatebuttoncntr"><input id="ac1" class="add_to_cart_button rollover" type="image" value="Donate" src="<?php echo $base_url; ?>images/backgrounds/give/donate-off.png" onmouseover="swapGraphic('on');" onmouseout="swapGraphic('off');" /></div>
    <input type="hidden" name="add" value="1">
    <input type="hidden" name="cmd" value="_xclick">
    <input type="hidden" name="business" value="<?php echo $info['paypal_email']; ?>">
    <input type="hidden" id="pp_item_name1" class="pp_item_name" name="item_name" value="<?php echo $info['nponame']." Donation (via ".$info['first_name'].' '.$info['last_name'].") - BEEx.org Challenge '".$info['name']."'"; ?>">
    <input type="hidden" id="pp_item_number1" name="item_number" value="<?php echo $id; ?>" />
	<input type="hidden" id="on0" name="on0" value="Note" />
    <input type="hidden" id="on1" name="on1" value="Anonymous" />
    <input type="hidden" name="page_style" value="PayPal">
    <input type="hidden" name="no_note" value="1">
    <input type="hidden" name="currency_code" value="USD">
    <input type="hidden" name="lc" value="US" />
    <input type="hidden" name="rm" value="2" />
    <input type="hidden" name="notify_url" value="http://www.beex.org/process_ipn.php" />
	<input type="hidden" name="shipping" value="0.00"> 
	
	<span style="font-size:10px; text-align:center; padding-top:4px; display:block;">(You will be redirected to the organizations Paypal page)</span>


</form>