<?php
namespace App\Library\WebPay;

class Charge extends \Payjp\Charge
{
	/**
	 * Create construct Webpay function to call PayJp
	 * Webpay gate way is end but we want maintain old code so we created this class
	 */
	public function capture($data = null, $options = null) {
		$ch = \Payjp\Charge::retrieve($data['id']);
		return $ch->capture();
	}
	
	public function refund($data = null, $options = null) {
		$ch = \Payjp\Charge::retrieve($data['id']);
		unset($data['id']);
		
		return $ch->refund($data);
	}
	
	public static function create($data = null, $options = null) {
		$data['expiry_days'] = $data['expire_days'];
		unset($data['expire_days']);
		
		return \Payjp\Charge::create($data);
	}
	
}
