<?php
		define('SSL_P_URL', 'https://www.paypal.com/cgi-bin/webscr');
		define('SSL_SAND_URL', 'https://www.sandbox.paypal.com/cgi-bin/webscr');
		
class PayPal_IPN{
	
		function infotuts_ipn($im_debut_ipn) {
				$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
				$paypal_url = ($_REQUEST['test_ipn'] == 1) ? SSL_SAND_URL : SSL_P_URL;
				
				if (!preg_match('/paypal\.com$/', $hostname)) {
						$ipn_status = 'Validation post isn\'t from PayPal';
					if ($im_debut_ipn == true) {
							// mail test
						}
					return false;
				}

			// parse the paypal URL
				$url_parsed = parse_url($paypal_url);			
				
				$post_string = '';
				foreach ($_REQUEST as $field => $value) {
					$post_string .= $field . '=' . urlencode(stripslashes($value)) . '&';
				}
					$post_string.="cmd=_notify-validate"; // append ipn command
			
			$paypal_mode_status = $im_debut_ipn;
			
			if ($paypal_mode_status == true)
					$fp = fsockopen('ssl://www.sandbox.paypal.com', "443", $err_num, $err_str, 60);
			else
				$fp = fsockopen('ssl://www.paypal.com', "443", $err_num, $err_str, 60);

			$ipn_response = '';

			if (!$fp) {
						// open the connection. If loggin is on, the error message
						// will be in the log.
						$ipn_status = "fsockopen error no. $err_num: $err_str";	
						 if ($im_debut_ipn == true) {
								//echo 'fsockopen fail';
						 }
						 
					// log the error	 
					return false;
			 }
			 else {
						// Post the data back to paypal
						 fputs($fp, "POST $url_parsed[path] HTTP/1.1\r\n");
						 fputs($fp, "Host: $url_parsed[host]\r\n");
						 fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
						 fputs($fp, "Content-length: " . strlen($post_string) . "\r\n");
						 fputs($fp, "Connection: close\r\n\r\n");
						 fputs($fp, $post_string . "\r\n\r\n");
				// loop through the response from the server and append to variable
				 while (!feof($fp)) {
							$ipn_response .= fgets($fp, 1024);
				 }
				 fclose($fp); // close connection
			}

		// Invalid IPN transaction. Check the $ipn_status and log for details.
	    if (!preg_match("/VERIFIED/s", $ipn_response)) {
					 $ipn_status = 'IPN Validation Failed';
					 
					if ($im_debut_ipn == true) {
							echo 'Validation fail';
							//log failed record
							//print_r($_REQUEST);
					}
					return false;
			}
		else {
				$ipn_status = "IPN VERIFIED";
				if ($im_debut_ipn == true) {
						//echo 'SUCCESS';
						// log verified record
				}
			return true;
			}
 }
		
		function ipn_response($request){
				mail("iamjagseergill@gmail.com","ipn respinse message",print_r($request,true)); 
				$im_debut_ipn=true;
 
				if ($this->infotuts_ipn($im_debut_ipn)) {// if paypal sends a response code back let's handle it
				
					 if ($im_debut_ipn == true) {
							$sub = 'PayPal IPN Debug Email Main';
							$msg = print_r($request, true);
							$aname = 'infotuts';
							//mail send
					 }
				 $this->insert_data($request);// process the membership since paypal gave us a valid +
			  }
 }

 
		function issetCheck($post,$key){
			
			if(isset($post[$key])){
				$return=$post[$key];
			}
			else{
				$return='';
			}
			return $return;
		}
		
		function insert_data($request){
			 //require_once('dbconnect.php');
			$post=$request;
			$item_name=$this->issetCheck($post,'item_name');
			$amount=$this->issetCheck($post,'mc_gross');
			$currency=$this->issetCheck($post,'mc_currency');
			$payer_email=$this->issetCheck($post,'payer_email');
			$first_name=$this->issetCheck($post,'first_name');
			$last_name=$this->issetCheck($post,'last_name');
			$country=$this->issetCheck($post,'residence_country');
			$txn_id=$this->issetCheck($post,'txn_id');
			$txn_type=$this->issetCheck($post,'txn_type');
			$payment_status=$this->issetCheck($post,'payment_status');
			$payment_type=$this->issetCheck($post,'payment_type');
			$payer_id=$this->issetCheck($post,'payer_id');
			$create_date=date('Y-m-d H:i:s');
			$payment_date=date('Y-m-d H:i:s');

			/*
			mysqli_query($con,"INSERT INTO infotuts_transection_tbl (item_name,payer_email,first_name,last_name,amount,currency,country,txn_id,txn_type,payer_id,payment_status,payment_type,create_date,payment_date)
			VALUES ('$item_name','$payer_email','$first_name','$last_name','$amount','$currency','$country','$txn_id','$txn_type','$payer_id','$payment_status','$payment_type','$create_date','$payment_date')");
			mysqli_close($con);
			*/
		}
	}
 $obj = New PayPal_IPN();
 $obj->ipn_response($_REQUEST);
