<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
    <input type="hidden" name="cmd" value="_xclick">
    <input type="hidden" name="business" value="jagseer_bussiness@gmail.com">
    <input type="hidden" name="item_name" value="Space Purchased">
    <input type="hidden" name="item_number" value="1">
    <input type="hidden" name="amount" value="9.00">
    <input type="hidden" name="no_shipping" value="0">
    <input type="hidden" name="no_note" value="1">
    <input type="hidden" name="currency_code" value="USD">
    <input type="hidden" name="lc" value="AU">
    <input type="hidden" name="bn" value="PP-BuyNowBF">
	<input type="hidden" name="notify_url" value="http://office-spot.com/paypal/my_ipn.php">
    <input type="hidden" name="return" value="http://office-spot.com/paypal/checkout_complete.php">
    <input type="hidden" name="rm" value="2">
	<input type="hidden" name="cbt" value="Return to The Store">
	<input type="hidden" value="http://office-spot.com/paypal/cancel.php" name="cancelUrl">
	<input type="hidden" value="http://office-spot.com/paypal/success.php" name="returnUrl">
	<input type="hidden" value="http://office-spot.com/paypal/cancel_return.php" name="cancel_return">
	<input type="submit" value="submit" name="submit">
</form>

<?php 
$data = array();	
$data["sandbox"] = true;
$data["reciever_email"] = "jagseer_bussiness@gmail.com";

print chargeCustomer( $data );

//var_dump(chargeCustomer( $data ));


	function chargeCustomer($data = array()){
	
				$paypalUrl = "https://www.paypal.com/cgi-bin/webscr";
				$currency_code = "USD";
				$lc = $no_note = false;
				$return = "http://office-spot.com/paypal/checkout_complete.php";
				$cancel_return = "http://office-spot.com/paypal/cancel_return.php";
				$notify_url = "http://office-spot.com/paypal/my_ipn.php";
				$return_data = "";
				
				if(isset($data["sandbox"]) && $data["sandbox"] == true){
					$paypalUrl = "https://www.sandbox.paypal.com/cgi-bin/webscr";
				}
				
				if(isset($data["reciever_email"]) && $data["reciever_email"] != ""){
					$reciever_email = $data["reciever_email"];
				}else{
					return "Invalid reciever_email";
				}
				
				if(isset($data["lc"]) && $data["lc"] != ""){
					$lc = $data["lc"];
				}
				if(isset($data["no_note"]) && $data["no_note"] != ""){
					$no_note = $data["no_note"];
				}
				if(isset($data["return"]) && $data["return"] != ""){
					$return = $data["return"];
				}
				if(isset($data["cancel_return"]) && $data["cancel_return"] != ""){
					$cancel_return = $data["cancel_return"];
				}
				if(isset($data["notify_url"]) && $data["notify_url"] != ""){
					$notify_url = $data["notify_url"];
				}
				
				if(isset($data["item_data"]) && is_array($data["item_data"]) && count($data["item_data"]) > 0){ 
					$item_data = $data["item_data"];
				}
				if(isset($data["return_data"])){ 
					$return_data = $data["return_data"];
				}
				
				
				
				
				
				
				
					
			$output = "";
			$output .= "<form action='".$paypalUrl."' method='post'>";
			$output .= '<input type="hidden" name="cmd" value="_xclick">';
			$output .= '<input type="hidden" name="business" value="'.$reciever_email.'">';
			$output .= '<input type="hidden" name="currency_code" value="'.$currency_code.'">';
			
			if($lc){
				$output .= '<input type="hidden" name="lc" value="'.$lc.'">';	
			}
			else{
				$output .= '<input type="hidden" name="lc" value="US">';	
			}
			
			if($no_note){
				$output .= '<input type="hidden" name="no_note" value="'.$no_note.'">';	
			}
			else{
				$output .= '<input type="hidden" name="no_note" value="1">';	
			}
			
		if(count($item_data ) > 1){
			foreach($item_data as $key => $item){
					$output .= '<input type="hidden" name="item_name_'.$key.'" value="'.$item["name"].'">';
					$output .= '<input type="hidden" name="item_number_'.$key.'" value="'.$item["number"].'">';
					$output .= '<input type="hidden" name="amount_'.$key.'" value="'.$item["amount"].'">';
				}
		}else{
					$output .= '<input type="hidden" name="item_name" value="Space Purchased">';
					$output .= '<input type="hidden" name="item_number" value="1">';
					$output .= '<input type="hidden" name="amount" value="9.00">';
		}
			
				
			
			$output .= '<input type="hidden" name="cbt" value="Return to The website">'; 
			$output .= '<input type="hidden" name="bn" value="PP-BuyNowBF">'; // button identifier
			$output .= ' <input type="hidden" name="rm" value="2">'; // post back submission data
			$output .= '<input type="hidden" name="no_shipping" value="0">'; // post back submission data
			$output .= '<input type="hidden" name="return" value="'.base64_encode($return_data).'">';
			
			$output .= '<input type="hidden" name="return" value="'.$return.'">';
			$output .= '<input type="hidden" name="cancel_return" value="'.$cancel_return.'">'; 
			$output .= '<input type="hidden" name="$notify_url" value="'.$notify_url.'">';
			$output .= '<input type="submit" name="submit" value="submit">';
			$output .= "</form>";
			return $output; 
	}

?>