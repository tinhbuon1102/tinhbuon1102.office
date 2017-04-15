<?php
if(isset($_REQUEST['looking_for']) && $_REQUEST['looking_for'] == "ShareUser")
{
	$faceUrl = url('FBLogin?looking_for=ShareUser');
}
else if(isset($_REQUEST['looking_for']) && $_REQUEST['looking_for'] == "RentUser")
{
	$faceUrl = url('FBLogin?looking_for=RentUser');
}
else
{
	if (isset($_SERVER['argv'][0]) && $_SERVER['argv'][0] == 'artisan')
	{
		$faceUrl = Config('app.url') . '/FBLogin';
	}
	else {
		$faceUrl = url('FBLogin');
	}
}

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
	'facebook' => [
    'client_id' => '315767042137325',
    'client_secret' => 'bbb8be34d8bd339879e1b50810830bdd',
    'redirect' => $faceUrl,
],

];
