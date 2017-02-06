<?php 
	if(isset($_REQUEST["notify"])){
			mail("iamjagseergill@gmail.com", "Test notfiy url", print_r( $_POST , true) , "From: info@saurbh.com");
			exit;
	}
	if(isset($_REQUEST["return"])){
		mail("iamjagseergill@gmail.com", "Test return url", print_r( $_POST , true) , "From: info@saurbh.com");
		exit;
	}
	
	mail("iamjagseergill@gmail.com", "Test direct url", print_r( $_POST , true) , "From: info@saurbh.com");
	
?>

<form name="frm_payment_method" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">

	<input type="hidden" name="cmd" value="_xclick-subscriptions">
	<input type="hidden" name="business" value="jagseer_bussiness@gmail.com" />
	
	<input type="hidden" name="notify_url" value="http://www.office-spot.com/paypal-test/paypal-php-library-dev/recur-form.php?notify=yes" />
	<input type="hidden" name="return" value="http://www.office-spot.com/paypal-test/paypal-php-library-dev/recur-form.php?return=yes" />
	<input type="hidden" name="cancel_return" value="" />
	
	<input type="hidden" name="rm" value="2" />
	
	<input type="hidden" name="no_shipping" value="1" />
	<input type="hidden" name="no_note" value="1" />
	<input type="hidden" name="page_style" value="paypal" />
	<input type="hidden" name="charset" value="utf-8" />
	<input type="hidden" name="item_name" value="itc recurring booking test" />
	<input type="hidden" name="item_number" value="58140b6d8fe9a" />
	<input type="hidden" name="currency_code" value="JPY" />
	
	<input type="hidden" name="a1" value="10" />
	<input type="hidden" name="p1" value="1" />
	<input type="hidden" name="t1" value="D" />
	
	<input type="hidden" name="a3" value="100" />
	<input type="hidden" name="p3" value="10" />
	<input type="hidden" name="t3" value="D" />
	
	<input type="hidden" value="16" name="tax"/>
	<input type="hidden" value="21.6" name="handling"/>
	
	<input type="hidden" value="1" name="src"/>
	<input type="hidden" value="21|49|31|monthly|7|customdata|4" name="custom"/>
	<input type="hidden" name="bn" value="PP-SubscriptionsBF:btn_subscribeCC_LG.gif:NonHosted">
	
	<script>
		setTimeout("document.frm_payment_method.submit()", 2);
	</script>
</form>