<?php
namespace App\Library\WebPay;

use App\Library\WebPay\Recursion;
use App\Library\WebPay\Charge;
use \Payjp\Payjp;
use \Payjp\Token;
use \Payjp\Customer;

class WebPay
{
	public $token;
	public $charge;
	public $customer;
	public $recursion;
	
	/**
	 * Create construct Webpay function to call PayJp
	 * Webpay gate way is end but we want maintain old code so we created this class
	 */
	public function __construct($apiKey) {
		Payjp::setApiKey($apiKey);
		$this->charge = new Charge();
		$this->token = new Token();
		$this->customer = new Customer();
		$this->recursion = new Recursion();
	}
}
