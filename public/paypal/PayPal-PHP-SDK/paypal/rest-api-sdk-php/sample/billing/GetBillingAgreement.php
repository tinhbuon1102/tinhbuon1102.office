<?php

// # Get Billing Agreement Sample
//
// This sample code demonstrate how you can get a billing agreement, as documented here at:
// https://developer.paypal.com/webapps/developer/docs/api/#retrieve-an-agreement
// API used: /v1/payments/billing-agreements/<Agreement-Id>

// Retrieving the Agreement object from Create Agreement From Credit Card Sample
/** @var Agreement $createdAgreement */




//namespace \office-spot.com\public_html\lp1\public\paypal\PayPal-PHP-SDK\paypal\rest-api-sdk-php\lib;

use PayPal\Api\Agreement;

$createdAgreement = require_once('CreateBillingAgreementWithCreditCard.php');

$PayPal =  new PayPal;


try {
    $agreement = Agreement::get($createdAgreement->getId(), $apiContext);
} catch (Exception $ex) {
    // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
    ResultPrinter::printError("Retrieved an Agreement", "Agreement", $agreement->getId(), $createdAgreement->getId(), $ex);
    exit(1);
}

// NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
ResultPrinter::printResult("Retrieved an Agreement", "Agreement", $agreement->getId(), $createdAgreement->getId(), $agreement);

return $agreement;
