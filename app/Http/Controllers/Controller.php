<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;
    
    public function __destruct()
    {
    	if (Auth::guard('user1')->check() || Auth::guard('user2')->check())
    	{
    		$user = Auth::guard('user1')->check() ? Auth::guard('user1')->user() : Auth::guard('user2')->user();
    		$_SESSION['mirrormx_customer_chat']['guest'] = array(
    				'id' => '', 
    				'name' => getUserName($user), 
    				'mail' => $user->Email, 'roles' => array(0 => 'GUEST'),
    				'last_activity' => date('Y-m-d H:i:s'),
    				'image' => getUser1Photo($user)
    		);
    	}
    	else {
    		if (isset($_SESSION['mirrormx_customer_chat']) && isset($_SESSION['mirrormx_customer_chat']['guest']))
    			unset($_SESSION['mirrormx_customer_chat']['guest']);
    	}
    }
}
