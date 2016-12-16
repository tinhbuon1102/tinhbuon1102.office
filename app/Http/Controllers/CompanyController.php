<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User1;
use Mail;
use Session;


class CompanyController extends Controller
{
	public function __construct(){
	}

	public function company()
	{
		return view('company.company');
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
			
		Session::put('company_name', $request->company_name);
		Session::put("name",$request->name);
		Session::put('tel', $request->tel);
		Session::put('email', $request->email);
		Session::put("message",$request->message);
		
		// Send email to admin
		sendEmailCustom ([
			'company_name' => $request->company_name, 
			'name' => $request->name, 
			'tel' => $request->tel, 
			'email' => $request->email, 
			'company_message' => $request->message,
			'sendTo' => $from['address'],
			'template' => 'company.emails.admin',
			'subject' => 'offispo お問い合わせを承りました']
				);
		
		
		// Send email to user
		sendEmailCustom ([
			'company_name' => $request->company_name, 
			'name' => $request->name, 
			'tel' => $request->tel, 
			'email' => $request->email, 
			'company_message' => $request->message,
			'sendTo' => $request->email,
			'template' => 'company.emails.user',
			'subject' => 'offispo お問い合わせを承りました']
				);
		
		return redirect('company/thankyou');
	}

	public function thankyou()
	{
		return view('company.thankyou');
	}
	
}
