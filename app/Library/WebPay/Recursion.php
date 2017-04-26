<?php
namespace App\Library\WebPay;

use \Payjp\Customer;
use \Payjp\Subscription;
use \Payjp\Plan;

class Recursion
{
	public function __construct() 
	{
		$this->plan = new Plan();
		$this->subscription = new Subscription();
		
		return $this;
	}
	
	public function create($data)
	{
		$billing_day = 27;
		// 2 months trial because it already paid for initial payment
		$first_scheduled = \Carbon\Carbon::createFromTimestamp($data['first_scheduled']);
		$now = \Carbon\Carbon::now();
		$dayLength = (int)$first_scheduled->diffInDays($now);
		
			// Create plan
		$plan = Plan::create(array(
			"amount" => $data['amount'],
			"currency" => $data['currency'],
			"interval" => $data['period'],
			"name" => $data['description'],
			'trial_days' => $dayLength,
			'billing_day' => $billing_day
		));
		
		$sub = Subscription::create(array(
			'customer' => $data['customer'],
			'plan' => $plan->id
		));
		
		return $sub;
	}
	
	public function delete($data)
	{
		$sub = Subscription::retrieve($data['id']);
		if ($sub)
		{
			// get plan ID before delete subscription
			$planID = $sub->plan->id;
			
			// Delete subscription
			$subDeleted = $sub->delete();
			
			// Delete plan
			$plan = Plan::retrieve($planID);
			$plan->delete();
			
			return $subDeleted;
		}
		else {
			return false;
		}
		
	}
	
	public function retrieve($data)
	{
		return Subscription::retrieve($data['id']);
	}
	
}

