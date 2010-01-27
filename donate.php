

<?php $id = $_GET['challenge_id']; ?>
<?php $name = $_GET['challenge_name']; ?>

<form id="DonateForm" target="paypal" class="add_form" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">

    <p>Thank you for donating to this wonderful cause</p>
    
    <p>How much would you like to donate?</p>
    
    $<input type="text" id="pp_item_price1" name="amount" value="">
    
    <input id="ac1" class="add_to_cart_button" type="submit" value="Donate" />
    <input type="hidden" name="add" value="1">
    <input type="hidden" name="cmd" value="_xclick">
    <input type="hidden" name="business" value="zachar_1257192521_biz@yahoo.com">
    <input type="hidden" id="pp_item_name1" class="pp_item_name" name="item_name" value="<?php echo $name; ?>">
    <input type="hidden" id="pp_item_number1" name="item_number" value="<?php echo $id; ?>" />
    <input type="hidden" name="page_style" value="PayPal">
    <input type="hidden" name="no_note" value="1">
    <input type="hidden" name="currency_code" value="USD">
    <input type="hidden" name="lc" value="US" />
    <input type="hidden" name="rm" value="2" />
    <input type="hidden" name="notify_url" value="http://www.beex.org/process_ipn.php" />

</form>