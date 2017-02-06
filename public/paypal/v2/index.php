<?php

?>
<form id='paypal-info' method='post' action='#'>
<label>Product Name : <?php echo $data['product_name']; ?></label></br>
<label>Product Price : <?php echo $data['amount'].''.$data['currency_code']; ?></label>

<input type='submit' name='pay_now' id='pay_now' value='Pay' />
</form>
<?php

if(isset($_POST['pay_now'])){
echo infotutsPaypal($data);

}

function infotutsPaypal( $data) {


 return $form;
 }
 
 //s_period variable to 1 and s_cycle to D (Days) so that you can test it well in a days time
 ?>