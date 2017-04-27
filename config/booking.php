<?php
return [
	/* --------------------- PAYPAL SETTING --------------------- */
	'PaypalLive' => [
		'PAYPAL_APP_ID' => 'APP-80W284485P519543T',
		'PAYPAL_APP_UN' => 'skoh_api1.properties.co.jp',
		'PAYPAL_APP_PW' => 'AL3T3FJ6BSYLZ7VU',
		'PAYPAL_APP_SIGNATURE' => 'AQU0e5vuZCvSg-XJploSa.sGUDlpAXzHPaBghDQ5TsmZ6WXE-Z6TnhDa',
		'PAYPAL_MERCHANT_EMAIL' => 'skoh@properties.co.jp'
	],
	
	'PaypalTest' => [
		'PAYPAL_APP_ID' => 'APP-80W284485P519543T',
		'PAYPAL_APP_UN' => 'quocthang.2001.japan_api1.gmail.com',
		'PAYPAL_APP_PW' => 'UA4WC9XVN7CDWRLJ',
		'PAYPAL_APP_SIGNATURE' => 'AFcWxV21C7fd0v3bYYYRCpSSRl31AbQ5v1TJK2G5TmwZ.NqGFsN-Ru0M',
		'PAYPAL_MERCHANT_EMAIL' => 'quocthang.2001.japan@gmail.com',
	],
	
	/* --------------------- Webpay SETTING --------------------- */
	'WebpayLive' => [
		'WEPAY_SECRET_API_KEY' => 'sk_live_5caa322ad1420da3d345fb48b449894f1f73b0992b0388cd87bab191',
		'WEPAY_PUBLIC_API_KEY' => 'pk_live_7488905c082af065fec39c26',
	],
	
	'WebpayTest' => [
		'WEPAY_SECRET_API_KEY' => 'sk_test_ee016d56c886a2b6f8f85671',
		'WEPAY_PUBLIC_API_KEY' => 'pk_test_3879aded1afdd5a161c7bb1a',
	],
	
	/* --------------------- Booking Cancelation Time Setting --------------------- */
	'Hourly' => [
		'DAYS_BEFORE_START_DATE_CAN_BE_CANCELLED_CHARGE_0' => 2, // can be cancelled-more than 2days before start date
		'MORE_THAN_HOURS_BEFORE_START_DATE_CANCELLED_CHARGE_50' => 24, // 50% will be charged- more than 24 hours before start date
		'LESS_THAN_HOURS_BEFORE_START_DATE_CANCELLED_CHARGE_100' => 24, // 100% will be charged- less than 24hours.
	],
	'Daily' => [
		'DAYS_BEFORE_START_DATE_CAN_BE_CANCELLED_CHARGE_0' => 7, // can be cancelled- more than 7days before start date
		'MORE_THAN_DAYS_BEFORE_START_DATE_CANCELLED_CHARGE_50' => 3, // 50% will be charged- 3days before start date
		'LESS_THAN_DAYS_BEFORE_START_DATE_CANCELLED_CHARGE_100' => 3, // 100% will be charged- less than 3 days before start date
	],
	'Weekly' => [
		'DAYS_BEFORE_START_DATE_CAN_BE_CANCELLED_CHARGE_0' => 14, // can be cancelled- more than 14 days before start date
		'MORE_THAN_DAYS_BEFORE_START_DATE_CANCELLED_CHARGE_50' => 7, // 50% will be charged- 7 days before start date
		'LESS_THAN_DAYS_BEFORE_START_DATE_CANCELLED_CHARGE_100' => 7, // 100% will be charged- less than 7 days before start date
	],
	'Monthly' => [
		'MONTHS_BEFORE_START_DATE_CAN_BE_CANCELLED_CHARGE_0' => 1, // can be cancelled- more than 1month before start date
		'MORE_THAN_DAYS_BEFORE_START_DATE_CANCELLED_CHARGE_50' => 21, // 50% of 1 month will be charged- 21 days before start dated
		'LESS_THAN_DAYS_BEFORE_START_DATE_CANCELLED_CHARGE_100' => 21, // 100% of 1 month will be charged- less than 21 days before start date
	],
];
