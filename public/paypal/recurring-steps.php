<?php
	$sub_req_url = "https://api-3t.sandbox.paypal.com/nvp";
	
	$muser = "jagseer_bussiness_api1.gmail.com";
	$password = "TTKG492SHWQYGWGU";
	$signature = "AFcWxV21C7fd0v3bYYYRCpSSRl31AoRN99DcLLwF093cUwUHSUKkI9Cc";
	
	$post_data =array(
				"USER"=>"$muser",
				"PWD"=>"$password",
				"SIGNATURE"=>"$signature",
				"METHOD"=>"CreateRecurringPaymentsProfile",
				"VERSION"=>76,
				"PROFILESTARTDATE" => "2016-09-26T00:00:00Z",
				"DESC"=>"RacquetClubMembership",
				"BILLINGPERIOD"=>"Month",
				"BILLINGFREQUENCY"=>"1",
				"AMT"=>"10",
				"MAXFAILEDPAYMENTS"=>"3",
				"ACCT"=>"4641631486853053",
				"CREDITCARDTYPE"=>"VISA",
				"CVV2"=>"123",
				"FIRSTNAME"=>"James",
				"LASTNAME"=>"Smith",
				"STREET"=>"FirstStreet",
				"CITY"=>"SanJose",
				"STATE"=>"CA",
				"ZIP"=>"95131",
				"COUNTRYCODE"=>"US",
				"CURRENCYCODE"=>"USD",
				"EXPDATE"=>"052018"
			);


print '<pre>';
print_r($post_data);
print '</pre>';

	$ch = curl_init($sub_req_url);
	$encoded = '';
	// include GET as well as POST variables; your needs may vary.
	
	
	foreach($post_data as $name => $value) {
	  $encoded .= urlencode($name).'='.urlencode($value).'&';
	}
	
	
	
	// chop off last ampersand
	$encoded = substr($encoded, 0, strlen($encoded)-1);
	
	curl_setopt($ch, CURLOPT_POSTFIELDS,  $encoded);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_exec($ch);
	
	print '<pre>====';
	print_r($encoded);
	print_r($ch);
	
	print '</pre>';
	curl_close($ch);


?>