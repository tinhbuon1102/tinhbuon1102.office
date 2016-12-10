<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Socialite;
use App\User1;
use App\User2;
use Session;
use Auth;
use Config;


class FacebookController extends Controller
{
	//
	public function redirect ( Request $request )
	{
		$object = (object)array(
				'id' => 1405654046112329,
				'name' => 'Quốc Thắng Trần',
				'email' => 'quocthang_2001@yahoo.com',
				'avatar' => 'https://graph.facebook.com/v2.6/1405654046112329/picture?type=normal',
				'user' => Array(
						'name' => 'Quốc Thắng Trần',
						'email' => 'quocthang_2001@yahoo.com',
						'gender' => 'male',
						'verified' => 1,
						'id' => '1405654046112329'
				),
				
				'avatar_original' => 'https://graph.facebook.com/v2.6/1405654046112329/picture?width=1920'
		);
		
		return Socialite::driver('facebook')->redirect();
	}

	public function callback(Request $request)
	{
		try {
			// when facebook call us a with token
			$providerUser = \Socialite::driver('facebook')->user();
				
// 			echo '<pre>'; print_r($providerUser);die;
			$fbid= $providerUser->getId();
			$user1=User1::firstOrNew(['FBID' => $fbid]);
			$user2=User2::firstOrNew(['FBID' => $fbid]);
			
			if(($user1->exists && !isset($request->looking_for)) || ($user1->exists && isset($request->looking_for) && $request->looking_for == 'ShareUser'))
			{
				Auth::login($user1);
				return redirect('/ShareUser/Dashboard');
					
			}
			if(($user2->exists && !isset($request->looking_for)) || ($user2->exists && isset($request->looking_for) && $request->looking_for == 'RentUser'))
			{
				Auth::guard('user2')->login($user2);
				return redirect('/RentUser/Dashboard');
					
			}
			else
			{
					
				$email= $providerUser->getEmail();
				$logo=$providerUser->getAvatar();
				Session::put("Email",$email);
				Session::put("logo",$logo);
				Session::put("FBID",$fbid);
				return view('pages.fb-signup');
			}
		}
		catch(\Exception $e){
			return redirect(action('PublicController@landingPage') . '#modal');
		}

	}

	public function register(Request $request)
	{
		$this->validate($request ,[
				'UserName'=> 'required|unique:user1s' ,
				'password'=> 'required|confirmed',
				'password_confirmation'=> 'required',
				'looking_for'=> 'required'
					
				]);
		if($request->looking_for=="ShareUser")
		{
			$user1=User1::firstOrNew(['Email' => Session::get("Email")]);
			if($user1->exists)
			{
				$user1->FBID=Session::get("FBID");
				$user1->save();
				Auth::login($user1);
				return redirect('/ShareUser/Dashboard/MySpace/List1');

			}
			$request->merge(array('Email' => Session::get("Email")));
			$request->merge(array('FBID' => Session::get("FBID")));
			$request->merge(array('Logo' => Session::get("logo")));
				
			$request->merge(array('HashCode' => uniqid()));

			$u=$user1->create($request->except(['_token','looking_for','password_confirmation']));
			Session::put("ShareUserID",$u->id);
			return redirect('/ShareUser/BasicInfo');
		}
		else if($request->looking_for=="RentUser")
		{
			$user2=User2::firstOrNew(['Email' => Session::get("Email")]);
			if($user2->exists)
			{
				$user2->FBID=Session::get("FBID");
				$user2->save();
				Auth::login($user2);
				return redirect('/RentUser/Dashboard/MyProfile');

			}
			$request->merge(array('Email' => Session::get("Email")));
			$request->merge(array('FBID' => Session::get("FBID")));
			$request->merge(array('Logo' => Session::get("logo")));
			$request->merge(array('HashCode' => uniqid()));

			$u=$user2->create($request->except(['_token','looking_for','password_confirmation']));
			Session::put("RentUserID",$u->id);
			return redirect('/RentUser/BasicInfo');
		}
	}
}
