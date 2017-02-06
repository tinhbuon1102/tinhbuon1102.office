<?php 
		$api_url = "https://api-3t.paypal.com/nvp";	
			$posts = "USER=jean_api1.collegeprepgenius.com&PWD=RKQ3T87AQ37JUB4V&SIGNATURE=AcoBU6HrgGCQLf3VLmOqquP3xmwlAnFmpW4rUf70DC9eqlzAlQqTgV4N&METHOD=GetBalance&VERSION=94&REFUNDTYPE=$REFUNDTYPE";
			
			//if($amount <= 0){
			//	$return["status"] = "error";
			//	$return["message"] = "invalid amouunt price $amount";
			//	return $return;
			//}
			
			if($REFUNDTYPE == "Partial" and $amount > 0 ){
				//convert zen to sen 
				#$amount = $amount;
				$description ="Partial refunded";
				$posts .= "&AMT=".$amount."&CURRENCYCODE=".CURRENCYCODE."&NOTE=$description";
			}
			
			#print $posts;
			$ch = curl_init();
			// set URL and other appropriate options
			curl_setopt($ch, CURLOPT_URL, $api_url );
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_POST, 0); 
			curl_setopt($ch, CURLOPT_POSTFIELDS , $posts );
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

			// grab URL and pass it to the browser
			$result = curl_exec($ch);
			#var_dump($result);\
			#print '<pre>====';
			#print_r($result);
			#print '</pre>';
			parse_str ($result);
			//print '<pre>';
		if($ACK == "Success"){
			$return["status"] = "success";
			//$return["message"] = "payment refunded successfully";
		}else{
			$return["status"] = $ACK ;
			$return["message"] = $L_LONGMESSAGE0;
		}
			print '<pre>====';
			print_r($return);
			print_r($L_AMT0);
			print '</pre>';
			?>