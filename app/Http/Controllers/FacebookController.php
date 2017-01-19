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
	public function redirect(Request $request)
	{
		return Socialite::driver('facebook')->redirect();
	}

	public function callback(Request $request)
	{
		try {
			// when facebook call us a with token
			$providerUser = \Socialite::driver('facebook')->fields([
				'name',
				'first_name',
				'last_name',
				'email',
				'gender',
			])->user();
				
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
				Session::put("providerUser",$providerUser);
				
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
		
		$providerUser = Session::get("providerUser");

		$content = file_get_contents("http://graph.facebook.com/$providerUser->id/picture?width=300&height=300&redirect=false");
		if ($content)
		{
			$data = json_decode($content, true);
			$avatar_file = '/images/user/' . uniqid() . '.jpg';
			file_put_contents(public_path() . '/' . $avatar_file, file_get_contents($data['data']['url']));
			$request->merge(array('Logo' => $avatar_file));
		}
		
		$request->merge(array('password' => bcrypt($request->password)));
		$request->merge(array('Email' => $providerUser->email));
		$request->merge(array('FirstName' => $providerUser->user['first_name']));
		$request->merge(array('LastName' => $providerUser->user['last_name']));
		$request->merge(array('FBID' => $providerUser->id));
		$request->merge(array('HashCode' => uniqid()));
		$request->merge(array('EmailVerificationText' => uniqid()));
		
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

			$u=$user1->create($request->except(['_token','looking_for','password_confirmation']));
			Session::put("ShareUserID",$u->id);
			return redirect('/ShareUser/BasicInfo');
		}
		else if($request->looking_for=="RentUser")
		{
			$request->merge(array('Sex' => ($providerUser->user['gender'] == 'female' ? '女性' : '男性')));
			$coverContent = file_get_contents("https://graph.facebook.com/$providerUser->id?fields=cover&access_token=$providerUser->token");
			if ($coverContent)
			{
				$data = json_decode($coverContent, true);
				$cover_file = '/images/covers/cover_' . uniqid() . '.jpg';
				file_put_contents(public_path() . '/' . $cover_file, file_get_contents($data['cover']['source']));
				$request->merge(array('Cover' => $cover_file));
			}
			
			$user2=User2::firstOrNew(['Email' => Session::get("Email")]);
			if($user2->exists)
			{
				$user2->FBID=Session::get("FBID");
				$user2->save();
				Auth::login($user2);
				return redirect('/RentUser/Dashboard/MyProfile');

			}

			$u=$user2->create($request->except(['_token','looking_for','password_confirmation']));
			Session::put("RentUserID",$u->id);
			return redirect('/RentUser/BasicInfo');
		}
	}
}
