<?php
$baseUrl = "";

if(!session_id()) session_start();

require_once('../includes/config.php');
require_once('../autoload.php');

$PayPalConfig = array(
					'Sandbox' => $sandbox,
					'APIUsername' => $api_username,
					'APIPassword' => $api_password,
					'APISignature' => $api_signature, 
					'APIVersion' => '97.0', 
					'APISubject' => '',
                    'PrintHeaders' => $print_headers, 
					'LogResults' => $log_results, 
					'LogPath' => $log_path,
					);

$PayPal = new angelleye\PayPal\PayPal($PayPalConfig);

#if(isset($_GET['GetExpressCheckoutDetails'])){
	$PayPalResult = $PayPal->GetExpressCheckoutDetails($_GET["token"]);
	print '<pre>';
	print_r($PayPalResult);
	#print_r(get_class_methods($PayPal));
	die("DoCapture");
	exit;
#}

if(isset($_GET['CreateRecurringPaymentsProfile'])){
		
		$DCFields = array(
					//'token' => 'EC-0VL71396MG248014U', 
					'token' => 'B-70540949KK807962G', 
				   );
		$ProfileDetails = array("PROFILESTARTDATE" => "PROFILESTARTDATE");
		$ScheduleDetails = array();
		$BillingPeriod = array();
		$ActivationDetails = array();
		$CCDetails = array();
		$PayerInfo = array();
		$PayerName = array();
		$BillingAddress = array();
		$ShippingAddress = array();
		$OrderItems = array();
	
		$PayPalRequestData = array(
						   'CRPPFields' => $DCFields, 
						   'ProfileDetails' => $ProfileDetails, 
						   'ScheduleDetails' => $ScheduleDetails, 
						   'BillingPeriod' => $BillingPeriod, 
						   'ActivationDetails' => $ActivationDetails, 
						   'CCDetails' => $CCDetails, 
						   'PayerInfo' => $PayerInfo, 
						   'PayerName' => $PayerName, 
						   'BillingAddress' => $BillingAddress, 
						   'ShippingAddress' => $ShippingAddress, 
						   'OrderItems' => $OrderItems
						 );
						   
	//$PayPalRequestData = array( "METHOD" => "DoCapture" , "AuthorizationID" => "2TX07253X2980940U" ,"AMT" => 100 );
	$PayPalResult = $PayPal->CreateRecurringPaymentsProfile($PayPalRequestData);
	
	
	print '<pre>';
	print_r($PayPalResult);
	print_r(get_class_methods($PayPal));
	die("DoCapture");
	exit;
	
	
	die("CreateRecurringPaymentsProfile..");
	
}





// Basic array of survey choices.  Nothing but the values should go in here.  
$SurveyChoices = array('Yes', 'No');

$Payments = array();

$Payment = array('amt' => '0.00');
				
$PaymentOrderItems = array();
$Item = array(
			'name' => 'Widget 123', 							// Item name. 127 char max.
			'desc' => 'Widget 123', 							// Item description. 127 char max.
			'amt' => '40.00', 								// Cost of item.
			'number' => '123', 							// Item number.  127 char max.
			'qty' => '1', 								// Item qty on order.  Any positive integer.
			'taxamt' => '', 							// Item sales tax
			'itemurl' => 'http://www.angelleye.com/products/123.php', 							// URL for the item.
			'itemcategory' => '', 				// One of the following values:  Digital, Physical
			'itemweightvalue' => '', 					// The weight value of the item.
			'itemweightunit' => '', 					// The weight unit of the item.
			'itemheightvalue' => '', 					// The height value of the item.
			'itemheightunit' => '', 					// The height unit of the item.
			'itemwidthvalue' => '', 					// The width value of the item.
			'itemwidthunit' => '', 					// The width unit of the item.
			'itemlengthvalue' => '', 					// The length value of the item.
			'itemlengthunit' => '',  					// The length unit of the item.
			'ebayitemnumber' => '', 					// Auction item number.  
			'ebayitemauctiontxnid' => '', 			// Auction transaction ID number.  
			'ebayitemorderid' => '',  				// Auction order ID number.
			'ebayitemcartid' => ''					// The unique identifier provided by eBay for this order from the buyer. These parameters must be ordered sequentially beginning with 0 (for example L_EBAYITEMCARTID0, L_EBAYITEMCARTID1). Character length: 255 single-byte characters
			);
array_push($PaymentOrderItems, $Item);

$Item = array(
			'name' => 'Widget 456', 							// Item name. 127 char max.
			'desc' => 'Widget 456', 							// Item description. 127 char max.
			'amt' => '40.00', 								// Cost of item.
			'number' => '456', 							// Item number.  127 char max.
			'qty' => '1', 								// Item qty on order.  Any positive integer.
			'taxamt' => '', 							// Item sales tax
			'itemurl' => 'http://www.angelleye.com/products/456.php', 							// URL for the item.
			'itemcategory' => 'Digital', 						// One of the following values:  Digital, Physical
			'itemweightvalue' => '', 					// The weight value of the item.
			'itemweightunit' => '', 					// The weight unit of the item.
			'itemheightvalue' => '', 					// The height value of the item.
			'itemheightunit' => '', 					// The height unit of the item.
			'itemwidthvalue' => '', 					// The width value of the item.
			'itemwidthunit' => '', 					// The width unit of the item.
			'itemlengthvalue' => '', 					// The length value of the item.
			'itemlengthunit' => '',  					// The length unit of the item.
			'ebayitemnumber' => '', 					// Auction item number.  
			'ebayitemauctiontxnid' => '', 			// Auction transaction ID number.  
			'ebayitemorderid' => '',  				// Auction order ID number.
			'ebayitemcartid' => ''					// The unique identifier provided by eBay for this order from the buyer. These parameters must be ordered sequentially beginning with 0 (for example L_EBAYITEMCARTID0, L_EBAYITEMCARTID1). Character length: 255 single-byte characters
			);
array_push($PaymentOrderItems, $Item);

$Payment = array('amt' => '0.00');
$Payment['order_items'] = $PaymentOrderItems;
$Payment['order_items'] = array();//$PaymentOrderItems;

array_push($Payments, $Payment);

$BuyerDetails = array(
						'buyerid' => '', 				// The unique identifier provided by eBay for this buyer.  The value may or may not be the same as the username.  In the case of eBay, it is different.  Char max 255.
						'buyerusername' => '', 			// The username of the marketplace site.
						'buyerregistrationdate' => ''	// The registration of the buyer with the marketplace.
						);
						
// For shipping options we create an array of all shipping choices similar to how order items works.
$ShippingOptions = array();
$Option = array(
				'l_shippingoptionisdefault' => '', 				// Shipping option.  Required if specifying the Callback URL.  true or false.  Must be only 1 default!
				'l_shippingoptionname' => '', 					// Shipping option name.  Required if specifying the Callback URL.  50 character max.
				'l_shippingoptionlabel' => '', 					// Shipping option label.  Required if specifying the Callback URL.  50 character max.
				'l_shippingoptionamount' => '' 					// Shipping option amount.  Required if specifying the Callback URL.  
				);
array_push($ShippingOptions, $Option);
		
$BillingAgreements = array();
$Item = array(
			  'l_billingtype' => 'MerchantInitiatedBilling', 							// Required.  Type of billing agreement.  For recurring payments it must be RecurringPayments.  You can specify up to ten billing agreements.  For reference transactions, this field must be either:  MerchantInitiatedBilling, or MerchantInitiatedBillingSingleSource
			  'l_billingagreementdescription' => 'Billing Agreement', 			// Required for recurring payments.  Description of goods or services associated with the billing agreement.  
			  'l_paymenttype' => 'Any', 							// Specifies the type of PayPal payment you require for the billing agreement.  Any or IntantOnly
			  'l_billingagreementcustom' => ''					// Custom annotation field for your own use.  256 char max.
			  );
array_push($BillingAgreements, $Item);






if(isset($_GET['DoCapture'])){
	$DCFields = array(
				  // 'referenceid' => $_GET['do_transaction'], 
				  // 'paymentaction' => 'Authorization',//'Sale',
				   'amt' => '10',
				   "AUTHORIZATIONID" => "2TX07253X2980940U" ,
				   "CompleteType" => "NotComplete" ,
				   
				  
				   );
				   
	$PaymentDetails = array(
						'amt' => '100.00', 
						'notifyurl' => 'http://www.office-spot.com/paypal-test/paypal-php-library-dev/return.php',// URL for receiving Instant Payment Notifications
						 "AuthorizationID" => "2TX07253X2980940U" ,
						);
	
	$PayPalRequestData = array(
						   'DCFields' => $DCFields, 
						   //'DRTFields' => $DRTFields, 
						   'PaymentDetails' => $PaymentDetails ,
						   "AUTHORIZATIONID" => "2TX07253X2980940U" ,
						   "AuthorizationID" => "2TX07253X2980940U" ,
						   "AMT" => 100
						 );
						   
	//$PayPalRequestData = array( "METHOD" => "DoCapture" , "AuthorizationID" => "2TX07253X2980940U" ,"AMT" => 100 );
	$PayPalResult = $PayPal->DoCapture($PayPalRequestData);
	
	
	
	echo '<pre />';
	print_r($PayPalResult);
	exit;
	
	print '<pre>';
	print_r(get_class_methods($PayPal));
	die("DoCapture");
	
}

/*
step 3
pay for transaction
*/

if(isset($_GET['do_transaction'])){
	
	
	//[REFERENCEID] => B-40S626699C068413T
	
	//[BILLINGAGREEMENTID] => B-40S626699C068413T
	//[CORRELATIONID] => b9faf0197c071
	// [TRANSACTIONID] => 2TX07253X2980940U
	
	$DRTFields = array(
				   'referenceid' => $_GET['do_transaction'], 
				   'paymentaction' => 'Authorization',//'Sale',
				   'amt' => '10'
				   );
				   
	$PaymentDetails = array(
						'amt' => '1100.00',// Required. Total amount of the order, including shipping, handling, and tax.
						'currencycode' => 'USD', // A three-character currency code.  Default is USD.
						'itemamt' => '', // Required if you specify itemized L_AMT fields. Sum of cost of all items in this order.  
						'shippingamt' => '', // Total shipping costs for this order.  If you specify SHIPPINGAMT you mut also specify a value for ITEMAMT.
						'insuranceamt' => '', 
						'shippingdiscount' => '', 
						'handlingamt' => '', // Total handling costs for this order.  If you specify HANDLINGAMT you mut also specify a value for ITEMAMT.
						'taxamt' => '', // Required if you specify itemized L_TAXAMT fields.  Sum of all tax items in this order. 
						'insuranceoptionoffered' => '',// If true, the insurance drop-down on the PayPal review page displays Yes and shows the amount.
						'desc' => 'Angell EYE Invoice - Final Payment for MiltonsBells.com', // Description of items on the order.  127 char max.
						'custom' => '', 						// Free-form field for your own use.  256 char max.
						'invnum' => time(), 						// Your own invoice or tracking number.  127 char max.
						'buttonsource' => '', 					// ID code for use by third-party apps to identify transactions in PayPal. 
						'notifyurl' => 'http://www.office-spot.com/paypal-test/paypal-php-library-dev/return.php'// URL for receiving Instant Payment Notifications
						);
	
	$PayPalRequestData = array(
						   'DRTFields' => $DRTFields, 
						   'PaymentDetails' => $PaymentDetails 
						   );
	
	$PayPalResult = $PayPal->DoReferenceTransaction($PayPalRequestData);

	echo '<pre />';
	print_r($PayPalResult);
	exit;
}




/*
step 2
*/

if(isset($_GET['token'])){


		
		$PayPalResult = $PayPal->CreateBillingAgreement($_GET['token']);

// Write the contents of the response array to the screen for demo purposes.
echo '<pre />';
print_r($PayPalResult);
	
		exit;

					
}


/*
step 1
*/

$SECFields = array(
					'token' => '', 								// A timestamped token, the value of which was returned by a previous SetExpressCheckout call.
					'maxamt' => '200.00', 						// The expected maximum total amount the order will be, including S&H and sales tax.
					'returnurl' => $domain . 'refrence.php', 							// Required.  URL to which the customer will be returned after returning from PayPal.  2048 char max.
					'cancelurl' => $domain . 'paypal/class/cancel.php',// Required.  URL to which the customer will be returned if they cancel payment on PayPal's site.
					'callback' => '', 							// URL to which the callback request from PayPal is sent.  Must start with https:// for production.
					'callbacktimeout' => '', 					// An override for you to request more or less time to be able to process the callback request and response.  Acceptable range for override is 1-6 seconds.  If you specify greater than 6 PayPal will use default value of 3 seconds.
					'callbackversion' => '', 					// The version of the Instant Update API you're using.  The default is the current version.							
					'reqconfirmshipping' => '0', 				// The value 1 indicates that you require that the customer's shipping address is Confirmed with PayPal.  This overrides anything in the account profile.  Possible values are 1 or 0.
					'noshipping' => '1', 						// The value 1 indicates that on the PayPal pages, no shipping address fields should be displayed.  Maybe 1 or 0.
					'allownote' => '1', 							// The value 1 indicates that the customer may enter a note to the merchant on the PayPal page during checkout.  The note is returned in the GetExpresscheckoutDetails response and the DoExpressCheckoutPayment response.  Must be 1 or 0.
					'addroverride' => '', 						// The value 1 indicates that the PayPal pages should display the shipping address set by you in the SetExpressCheckout request, not the shipping address on file with PayPal.  This does not allow the customer to edit the address here.  Must be 1 or 0.
					'localecode' => '', 						// Locale of pages displayed by PayPal during checkout.  Should be a 2 character country code.  You can retrive the country code by passing the country name into the class' GetCountryCode() function.
					'pagestyle' => '', 							// Sets the Custom Payment Page Style for payment pages associated with this button/link.  
					'hdrimg' => '', 							// URL for the image displayed as the header during checkout.  Max size of 750x90.  Should be stored on an https:// server or you'll get a warning message in the browser.
					'hdrbordercolor' => '', 					// Sets the border color around the header of the payment page.  The border is a 2-pixel permiter around the header space.  Default is black.  
					'hdrbackcolor' => '', 						// Sets the background color for the header of the payment page.  Default is white.  
					'payflowcolor' => '', 						// Sets the background color for the payment page.  Default is white.
					'skipdetails' => '', 						// This is a custom field not included in the PayPal documentation.  It's used to specify whether you want to skip the GetExpressCheckoutDetails part of checkout or not.  See PayPal docs for more info.
					'email' => '', 								// Email address of the buyer as entered during checkout.  PayPal uses this value to pre-fill the PayPal sign-in page.  127 char max.
					'solutiontype' => 'Sole', 						// Type of checkout flow.  Must be Sole (express checkout for auctions) or Mark (normal express checkout)
					'landingpage' => 'Billing', 						// Type of PayPal page to display.  Can be Billing or Login.  If billing it shows a full credit card form.  If Login it just shows the login screen.
					'channeltype' => '', 						// Type of channel.  Must be Merchant (non-auction seller) or eBayItem (eBay auction)
					'giropaysuccessurl' => '', 					// The URL on the merchant site to redirect to after a successful giropay payment.  Only use this field if you are using giropay or bank transfer payment methods in Germany.
					'giropaycancelurl' => '', 					// The URL on the merchant site to redirect to after a canceled giropay payment.  Only use this field if you are using giropay or bank transfer methods in Germany.
					'banktxnpendingurl' => '',  				// The URL on the merchant site to transfer to after a bank transfter payment.  Use this field only if you are using giropay or bank transfer methods in Germany.
					'brandname' => 'Angell EYE', 							// A label that overrides the business name in the PayPal account on the PayPal hosted checkout pages.  127 char max.
					'customerservicenumber' => '555-555-5555', 				// Merchant Customer Service number displayed on the PayPal Review page. 16 char max.
					'giftmessageenable' => '1', 					// Enable gift message widget on the PayPal Review page. Allowable values are 0 and 1
					'giftreceiptenable' => '1', 					// Enable gift receipt widget on the PayPal Review page. Allowable values are 0 and 1
					'giftwrapenable' => '1', 					// Enable gift wrap widget on the PayPal Review page.  Allowable values are 0 and 1.
					'giftwrapname' => 'Box with Ribbon', 						// Label for the gift wrap option such as "Box with ribbon".  25 char max.
					'giftwrapamount' => '2.50', 					// Amount charged for gift-wrap service.
					'buyeremailoptionenable' => '1', 			// Enable buyer email opt-in on the PayPal Review page. Allowable values are 0 and 1
					'surveyquestion' => '', 					// Text for the survey question on the PayPal Review page. If the survey question is present, at least 2 survey answer options need to be present.  50 char max.
					'surveyenable' => '1', 						// Enable survey functionality. Allowable values are 0 and 1
					'buyerid' => '', 							// The unique identifier provided by eBay for this buyer. The value may or may not be the same as the username. In the case of eBay, it is different. 255 char max.
					'buyerusername' => '', 						// The user name of the user at the marketplaces site.
					'buyerregistrationdate' => '2012-07-14T00:00:00Z',  			// Date when the user registered with the marketplace.
					'allowpushfunding' => ''					// Whether the merchant can accept push funding.  0 = Merchant can accept push funding : 1 = Merchant cannot accept push funding.			
				);

$PayPalRequest = array(
					   'SECFields' => $SECFields, 
					   'SurveyChoices' => $SurveyChoices, 
					   'BillingAgreements' => $BillingAgreements, 
					   'Payments' => $Payments
					   );
					   
$SetExpressCheckoutResult = $PayPal->SetExpressCheckout($PayPalRequest);
$url = $SetExpressCheckoutResult['REDIRECTURL'];

header("Location: $url ");
?>