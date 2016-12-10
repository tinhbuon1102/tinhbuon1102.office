<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Contracts\Validation\Validator;
use App\Http\Requests;
use App\User1;
use App\User2;
use Session;
use Mail;
use Config;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Auth\Passwords\PasswordBroker;
use Password;
use DB;
use Auth;
use URL;
use App\Chatmessage;
use App\Chat;
use View;
use Redirect;



class PageController extends Controller
{
	//
	public function register(Request $request,User1 $user1,User2 $user2)
	{
		$inputData = $request->formData;
		parse_str($inputData, $formFields);
		$userData = array(
				'UserName'      => $formFields['UserName'],
				'looking_for'     =>  $formFields['looking_for'],
				'Email'     =>  $formFields['Email'],
				'password'  =>  $formFields['password'],
				'password_confirmation' =>  $formFields[ 'password_confirmation'],
		);

		$userCreateData = array(
				'EmailVerificationText'     =>  uniqid(),
				'UserName'      => $formFields['UserName'],
				'Email'     =>  $formFields['Email'],
				'password'  =>  bcrypt($formFields['password']),
				'HashCode'     =>  uniqid(),
		);
		/*print_r($userCreateData);
		 die;*/

		$rules = array(
				'UserName'=> 'required' ,
				'looking_for'=> 'required' ,
				'Email'=> 'required|email' ,
				'password'=> 'required|confirmed',
				'password_confirmation'=> 'required'
		);
		$validator = Validator::make($userData,$rules);
		if($validator->fails())
			return Response::json(array(
					'fail' => true,
					'errors' => $validator->getMessageBag()->toArray()
			));

		if($formFields['looking_for']=="ShareUser")
		{
			$rules = array( 'Email'=> 'unique:user1s',
					'UserName'=> 'unique:user1s'
			);
			$validator = Validator::make($userData,$rules);
			if($validator->fails())
				return Response::json(array(
						'fail' => true,
						'errors' => $validator->getMessageBag()->toArray()
				));
			$u=$user1->create($userCreateData);
			Session::put("ShareUserID",$u->id);

			return Response::json(array(
					'success' => true,
					'next' => "ShareUser/BasicInfo"
			));
		}
		else if($formFields['looking_for']=="RentUser")
		{
			$rules = array( 'Email'=> 'unique:user2s',
					'UserName'=> 'unique:user2s'
			);

			$validator = Validator::make($userData,$rules);
			if($validator->fails())
				return Response::json(array(
						'fail' => true,
						'errors' => $validator->getMessageBag()->toArray()
				));

			//	$userCreateData->merge(array('IsAdminApproved' => "Yes"));
			$userCreateData['IsAdminApproved']="No";
			$u=$user2->create($userCreateData);
			Session::put("RentUserID",$u->id);

			return Response::json(array(
					'success' => true,
					'next' => "RentUser/BasicInfo"
			));
		}
	}

	public function login(Request $request,User1 $user1,User2 $user2)
	{
		$inputData = $request->formData;
		parse_str($inputData, $formFields);
		$userData = array(
				'username'      => $formFields['username'],
				'looking_for'     =>  $formFields['looking_for'],
				'password'  =>  $formFields['password']
		);

		$rules = array(
				'username'=> 'required' ,
				'looking_for'=> 'required' ,
				'password'=> 'required'
		);
		$validator = Validator::make($userData,$rules);
		if($validator->fails())
			return Response::json(array(
					'fail' => true,
					'errors' => $validator->getMessageBag()->toArray()
			));

		if($formFields['looking_for']=="ShareUser")
		{

			$auth = auth()->guard('user1');
			$user1 = $user1->isEmailVerified()->where(function ($query) use ($formFields){
				$query->orWhere('Email', $formFields['username']);
				$query->orWhere('UserName', $formFields['username']);
			})->first();
				
			if (!$user1)
			{
				return Response::json(array(
						'error' => true,
						'msg' => trans('common.login_not_exists_or_verified')
				));
			}
			else {
				if($auth->attempt(['Email' => $formFields['username'], 'password' => $formFields['password']]) || $auth->attempt(['UserName' => $formFields['username'], 'password' => $formFields['password']]))
				{
					return Response::json(array(
							'success' => true,
							'next' => url('ShareUser/Dashboard')
					));
				}
				else{
					return Response::json(array(
							'error' => true,
							'msg' => "認証エラー"
					));
				}
			}
				
		}
		else if($formFields['looking_for']=="RentUser")
		{

			$auth = auth()->guard('user2');
			$user2 = $user2->isEmailVerified()->where(function ($query) use ($formFields){
				$query->orWhere('Email', $formFields['username']);
				$query->orWhere('UserName', $formFields['username']);
			})->first();
			if (!$user2)
			{
				return Response::json(array(
						'error' => true,
						'msg' => trans('common.login_not_exists_or_verified')
				));
			}
			else {
				if($auth->attempt(['Email' => $formFields['username'], 'password' => $formFields['password']]) || $auth->attempt(['UserName' => $formFields['username'], 'password' => $formFields['password']]))
				{
					return Response::json(array(
							'success' => true,
							'next' => url('RentUser/Dashboard')
					));
				}
				else{
					return Response::json(array(
							'error' => true,
							'msg' => "認証エラー"
					));
				}
			}

		}
	}

	public function forgetpassword(Request $request, User1 $user1, User2 $user2)
	{

		$inputData = $request->formData;
		parse_str($inputData, $formFields);
		$userData = array(
				'email'      => $formFields['email'],
				'looking_for'     =>  $formFields['looking_for'],
		);

		$rules = array(
				'email'=> 'required|email' ,
				'looking_for'=> 'required' ,
		);
		$validator = Validator::make($userData,$rules);
		
		if($validator->fails())
			return Response::json(array(
					'error' => true,
					'errors' => $validator->getMessageBag()->toArray()
			));

		$error = false;
		if($formFields['looking_for']=="ShareUser")
		{
			$existUser = User1::where('Email', trim($formFields['email']))->first();
			if ($existUser)
			{
				$response = Password::broker('user1')->sendResetLink(array('email'=>$formFields['email']), function($message)
				{
					$message->subject('Office Spot Password Reset');
				});
			}
			else {
				$error = true;
			}

		}
		else if($formFields['looking_for']=="RentUser")
		{
			$existUser = User2::where('Email', trim($formFields['email']))->first();
			if ($existUser)
			{
				$response = Password::broker('user2')->sendResetLink(array('email'=>$formFields['email']), function($message)
				{
					$message->subject('Office Spot Password Reset');
				});
			}
			else {
				$error = true;
			}

		}

		if ($error)
		{
			return Response::json(array(
					'error' => true,
					'errors' => array(trans('common.Email you filled is not exists in our system, please try again with other email'))
			));
		}
		
		return Response::json(array(
				'success' => true
		));
	}

	public function user1reset(Request $request, $token = null)
	{
		if (is_null($token)) {
			return PasswordBroker::getEmail();
		}


		$results = DB::select(
				DB::raw("select email from password_resets1 WHERE token	 = '".$token."'")
		);
		if($results)
		{
			$email = $results[0]->email;
			return view('user1.reset')->with(compact('token', 'email'));
		}
		else{
			echo "Invalid Token";
		}
	}
	public function user1resetsubmit(Request $request, $token = null)
	{
		$this->validate($request, [
				'Email' => 'required|email',
				'password' => 'required|confirmed|min:6',]);
			
		$request->merge(array('token' => $token));
		$credentials =$request->except(['_token']);

		$response = Password::broker('user1')->reset($credentials, function ($user, $password) {
			$user->forceFill([
					'password' => bcrypt($password)
					])->save();


			Auth::guard('user1')->login($user);

		});
		return redirect('/ShareUser/Dashboard/');

	}

	public function user2reset(Request $request, $token = null)
	{
		if (is_null($token)) {
			return PasswordBroker::getEmail();
		}


		$results = DB::select(
				DB::raw("select email from password_resets2 WHERE token	 = '".$token."'")
		);
		if($results)
		{
			$email = $results[0]->email;
			return view('user2.reset')->with(compact('token', 'email'));
		}
		else{
			echo "Invalid Token";
		}
	}
	public function user2resetsubmit(Request $request, $token = null)
	{
		$this->validate($request, [
				'Email' => 'required|email',
				'password' => 'required|confirmed|min:6',]);
			
		$request->merge(array('token' => $token));
		$credentials =$request->except(['_token']);

		$response = Password::broker('user2')->reset($credentials, function ($user, $password) {
			$user->forceFill([
					'password' => bcrypt($password)
					])->save();



			Auth::guard('user2')->login($user);

		});
		return redirect('/RentUser/Dashboard/');
	}

	public function user1SendEmailVerificationLink()
	{
		if (Auth::check())
		{
			$u=User1::find(Auth::user()->id);
			$from = Config::get('mail.from');
			Mail::send('user1.emails.verifyemail',
			[
			'EmailVerificationText' => $u->EmailVerificationText,
			],
			function ($message) use ($u, $from){
				$message->from($from['address'], $from['name']);
				$mails = [$u->Email];
				$message->to($mails)->subject('office spot Email Verification Text');
			});
			return Response::json(array(
					'success' => true,
					'next' => ""
			));
		}

	}

	public function user2SendEmailVerificationLink()
	{
		if (Auth::guard('user2')->check())
		{
			$u=User2::find(Auth::guard('user2')->user()->id);
			$from = Config::get('mail.from');
			Mail::send('user2.emails.verifyemail',
			[
			'EmailVerificationText' => $u->EmailVerificationText,
			],
			function ($message) use ($u, $from){
				$message->from($from['address'], $from['name']);
				$mails = [$u->Email];
				$message->to($mails)->subject('office spot Email Verification Text');
			});
			return Response::json(array(
					'success' => true,
					'next' => ""
			));
		}

	}
	public function test1()
	{

		//  \App::setLocale('en');

		return view('pages.test1');
	}
		
	public function chatNotification()
	{
		$ch=Chatmessage::distinct()->select('ChatID')->where('IsRead',  'No')->where('IsEmailed','No')->groupBy('ChatID')->get();
		foreach($ch as $c)
		{
			$user1Chats=Chatmessage::where('IsRead',  'No')->where('IsEmailed','No')->where('ChatID',  $c->ChatID)->where('User1ID','')->get();
			/*foreach($user1Chats as $chts)
			 {
			$chts
			}*/
			$chat=Chat::firstOrNew(['id' => $c->ChatID]);
			if($user1Chats->count()>0)
			{
				$name=$chat->user2->LastName." ".$chat->user2->FirstName;
				$eml=$chat->user1->Email;

				global $from;
				$from = Config::get('mail.from');

				// Send email to admin
				Mail::send('chat.email.newchatmsgnew',
				[
				'name' => $name,
				'msgs' =>$user1Chats,
				'link' => 'http://www.office-spot.com/RentUser/Dashboard/Message/'.$chat->user2->HashCode,

				], function ($message)  use ($eml){
					global $request, $from;
					$message->from($from['address'], $from['name']);
					$message->to($eml)->subject('office spot New Chat Message');
				});
			}
				
			$user2Chats=Chatmessage::where('IsRead',  'No')->where('IsEmailed','No')->where('ChatID',  $c->ChatID)->where('User2ID','')->get();
				
				
			if($user2Chats->count()>0)
			{
				$name=$chat->user1->LastName." ".$chat->user1->FirstName;
				$eml=$chat->user2->Email;

				global $from;
				$from = Config::get('mail.from');

				// Send email to admin
				Mail::send('chat.email.newchatmsgnew',
				[
				'name' => $name,
				'msgs' =>$user2Chats,
				'link' => 'http://www.office-spot.com/ShareUser/Dashboard/Message/'.$chat->user1->HashCode,

				], function ($message)  use ($eml){
					global $request, $from;
					$message->from($from['address'], $from['name']);
					$message->to($eml)->subject('office spot New Chat Message');
				});
			}
				
			Chatmessage::where('ChatID',  $c->ChatID)->update(['IsEmailed' => 'Yes']);
		}


	}
		
	public function privacyPolicy() {
		return view('pages.privacy-policy');
	}
	public function cookiePolicy() {
		return view('pages.cookie-policy');
	}
	public function cancelPolicy() {
		return view('pages.cancel-policy');
	}
	public function listService(Request $request) {
		if($request->method() == 'POST')
		{
			$input = $request->all();
			$rules = [
					'LastName'=> 'required' ,
					'FirstName' => 'required',
					'LastNameKana' => 'required',
					'FirstNameKana' => 'required',
					'BusinessType' => 'required',
					'Email' => 'required|email',
					'Tel' => 'required',
			];
			
			$validator = $this->validate($request, $rules);
			
			// validate email
			$existed = User1::where('Email', $request->Email)->first();
			if ($existed)
			{
				return redirect::back()
				->withErrors(trans('common.This Email is registered, please choose other Email'))
				->withInput();
			}
			
			// If ok Save form to database
			$applicationForm = new \App\ApplicationForm();
			$applicationForm->fill($request->except(['_token']));
			
			$user1 = new \App\User1();
			$user1->HashCode = uniqid();
			$user1->EmailVerificationText = uniqid();
			$user1->IsEmailVerified = 'No';
			$user1->fill($request->except(['_token']));
			
			if ($applicationForm->save() && $user1->save())
			{
				$applicationFormMapper = [
						'LastName'=> "姓",
						'FirstName' => "名",
						'LastNameKana' => "姓(ふりがな)",
						'FirstNameKana' => "名(ふりがな)",
						'BusinessType' => "事業のタイプ",
						'Email' => "メールアドレス",
						'NameOfCompany' => "会社名",
						'Department' => "部署",
						'Tel' => "電話番号",
						'HashCode' => "パスワード",
				];
				
				// Send email
				$from = Config::get('mail.from');
				// Send to admin
				sendEmailCustom ([
					'applicationForm' => $user1,
					'applicationFormMapper' => $applicationFormMapper,
					'sendTo' => $from['address'],
					'template' => 'pages.emails.application_form_admin',
					'subject' => trans('common.One user has been sent a application form')]
				);
				
				// Send to user was sent
				sendEmailCustom ([
						'applicationForm' => $user1,
						'applicationFormMapper' => $applicationFormMapper,
						'sendTo' => $from['address'],
						'template' => 'pages.emails.application_form_user',
						'subject' => trans('common.One user has been sent a application form')]
						);
				
				Session::flash('success', trans('common.Your Application was successfully sent, we will check and reply to you soon'));
				return redirect::back();
			}
			else {
				if (isset($applicationForm->id))
					$applicationForm->delete();
				
				if (isset($user1->id))
					$user1->delete();
				
				Session::flash('error', 'common.Error occured, Please try again');
				return redirect::back();
			}
		}
		
		// Save info to database
		return view('pages.list-service', compact('request'));
	}
	
	public function helpUser(Request $request, $subUrl = false){
		if (request()->is('help/rentuser') || request()->is('help/rentuser/*'))
		{
			$template = 'pages.rentuser.help-rentuser' . ($subUrl ? '-' . $subUrl : '');
		}
		elseif (request()->is('help/shareuser') || request()->is('help/shareuser/*'))
		{
			$template = 'pages.shareuser.help-shareuser' . ($subUrl ? '-' . $subUrl : '');
		}
		elseif (request()->is('help/guest') || request()->is('help/guest/*'))
		{
			$template = 'pages.guest.help-guest' . ($subUrl ? '-' . $subUrl : '');
		}

		if ($subUrl)
		{
			if (View::exists($template))
			{
				$subView = View::make($template)->__toString();
			}
			
			else
				abort(404);
		}
		else {
			$subView = View::make($template)->__toString();
		}
		
		return view('pages.help-template', compact('subView'));
	}
}

