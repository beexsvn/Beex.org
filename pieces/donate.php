<?php

function db_connect() {
	
	$mydb = mysql_connect("internal-db.s85554.gridserver.com", "db85554", "Bulld0zer") or die(mysql_error());
	
	mysql_select_db("db85554_beexmaster", $mydb) or die(mysql_error());
	
	return $mydb;
}

$mydb = db_connect();

$id = $_GET['challenge_id']; 
//$name = $_GET['challenge_name'];

$query = "SELECT challenges.challenge_title AS name, profiles.first_name, profiles.last_name, npos.paypal_email, npos.name AS nponame, npos.id FROM challenges, npos, profiles WHERE npos.id = challenges.challenge_npo AND challenges.user_id = profiles.user_id AND challenges.id = '".$id."';";

$result = mysql_query($query, $mydb);

if(mysql_num_rows($result)) {
	$info = mysql_fetch_assoc($result);	
}

mysql_close($mydb);

?>


<style>

.orangetitle {width:100%; padding:5px 0px; background-color:orange; text-transform:uppercase; color:#fff; margin:0px 0px 25px;}
p {margin:5px 10px; color:#605f5f; font:12px Verdana, Geneva, sans-serif;}
textarea {width:90%;}
.donatebuttoncntr {background-color:#5f5f5f; padding:10px 0; text-align:center;}

</style>


 
<div style="width:400px; text-align:right;">

<h2 class='orangetitle'>Donation Box</h2>

<!--<form id="DonateForm" target="paypal" class="add_form" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">-->
<form id="DonateForm" target="paypal" class="add_form" action="https://www.paypal.com/cgi-bin/webscr" method="post">


    <p>How much would you like to donate to the challenge <b><?php echo $info['name']; ?></b>, benefitting the nonprofit <?php echo $info['nponame']; ?>?</p>

    <p><i>(ex. $22.50)</i> $<input type="text" id="pp_item_price1" name="amount" value=""></p>

    <p style="margin-top:17px;">Would you like to leave a comment?</p>

    <textarea name="os0"></textarea><br>

    <p style="margin-top:15px;">Check below to donate anonymously</p>
    <p><input name="os1" type="checkbox" value="Yes" /></p>
	
    <div class="donatebuttoncntr"><input id="ac1" class="add_to_cart_button" type="image" value="Donate" src="/images/buttons/donateformbutton.gif" /></div>
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


</form>