<?php

	#require_once( 'paypal-digital-goods.class.php' );
	require_once( 'paypal-subscription.class.php' );
	
	PayPal_Digital_Goods_Configuration::username( 'jsforever_business2_api1.gmail.com' );
	PayPal_Digital_Goods_Configuration::password( '7ZYPN8G3BH39E5LE' );
	PayPal_Digital_Goods_Configuration::business_name( 'business_name' );
	PayPal_Digital_Goods_Configuration::signature( 'AFcWxV21C7fd0v3bYYYRCpSSRl31A5t1H8Jd1ioKdUh5zqloGngM9523' );

	PayPal_Digital_Goods_Configuration::return_url( 'http://www.office-spot.com/paypal-test/recur-lib/recur-form.php?paypal=paid' );
	PayPal_Digital_Goods_Configuration::cancel_url( 'http://www.office-spot.com/paypal-test/recur-lib/recur-form.php?paypal=cancel' );
	PayPal_Digital_Goods_Configuration::notify_url( 'http://www.office-spot.com/paypal-test/recur-lib/recur-form.php?paypal=notify' );

	PayPal_Digital_Goods_Configuration::currency( 'USD' ); // 3 char character code, must be one of the values here:
//

	
	 
	$purchase_details = array(
	'name'        => 'Digital Good Purchase Example',
	'description' => 'Example Digital Good Purchase',
	'amount'      => '14.50', // Total including tax
	'tax_amount'      => '2.50', // Just the total tax amount
	'items'       => array(
		array( // First item
			'item_name'        => 'First item name',
			'item_description' => 'This is a description of the first item in the cart, it costs $9.00',
			'item_amount'      => '9.00',
			'item_tax'         => '1.00',
			'item_quantity'    => 1,
			'item_number'      => 'XF100',
		),
		array( // Second item
			'item_name'        => 'Second Item',
			'item_description' => 'This is a description of the SECOND item in the cart, it costs $1.00 but there are 3 of them.',
			'item_amount'      => '1.00',
			'item_tax'         => '0.50',
			'item_quantity'    => 3,
			'item_number'      => 'XJ100',
		),
	)
);

				

				
		
	$subscriptionDetails = array(
		  'description'        => 'Subscription for $10/month for the next year.',
		  'initial_amount'     => '10.00',
		  'amount'             => '10.00',
		  'period'             => 'Day',
		  'frequency'          => '1',
		  'total_cycles'       => '12',
		  'invoice_number'      => '',
		'max_failed_payments' => '4',
		// Price
		'average_amount'      => '25',
		'tax_amount'          => '0.00',
		// Temporal Details
		'start_date'          => date( 'Y-m-d\TH:i:s', time() + ( 24 * 60 * 60 ) ),
		'frequency'           => '1',
		// Trial Period
		'trial_amount'        => '10.00',
		'trial_period'        => 'Day',
		'trial_frequency'     => '3',
		'trial_total_cycles'  => '10',
		);
		

	$pay = new PayPal_Subscription( $subscriptionDetails );
	$res = $pay->start_subscription();
	
	print '<pre>';
	print_r($pay);
	print_r($res);
	exit;
?>