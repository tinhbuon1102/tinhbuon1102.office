<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User1;
use Mail;
use Session;
use Config;


class ContactController extends Controller
{
	public function __construct(){
	}

	public function contact()
	{
		return view('contact.contact');
	}
	
	public function send(Request $request)
	{

		$this->validate($request ,[
			'company_name' 	=> 'required',
			'name' 			=> 'required',
			'tel' 			=> 'required',
			'email' 		=> 'required',
			'message' 		=> 'required',
		],
		[
			'company_name.required' => 'Company Name is required',
			'name.required' 		=> 'Name is required',
			'tel.required' 			=> 'Tel is required',
			'email.required' 		=> 'Email is required',
			'message.required' 		=> 'Message is required',
		]);
		global $from;
		$from = Config::get('mail.from');
		Session::put('company_name', $request->company_name);
		Session::put("name",$request->name);
		Session::put('tel', $request->tel);
		Session::put('email', $request->email);
		Session::put("message",$request->message);
		
		// Send email to admin
		Mail::send('contact.emails.admin', ['company_name' => $request->company_name, 'name' => $request->name, 'tel' => $request->tel, 'email' => $request->email, 'contact_message' => $request->message], function ($message) {
			global $request, $from;
			$message->from($from['address'], $from['name']);
			$mails = [$from['address']];
			$message->to($mails)->subject('offispo お問い合わせを承りました');
		});
		
		// Send email to user
		Mail::send('contact.emails.user', ['company_name' => $request->company_name, 'name' => $request->name, 'tel' => $request->tel, 'email' => $request->email, 'contact_message' => $request->message], function ($message) {
			global $request, $from;
			$message->from($from['address'], $from['name']);
			$mails = [$request->email];
			$message->to($mails)->subject('offispo お問い合わせを承りました');
		});
			
		return redirect('contact/thankyou');
	}

	public function thankyou()
	{
		return view('contact.thankyou');
	}
	
}
