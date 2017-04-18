<?php

namespace App\Http\Controllers;
use App\Notification;

use Illuminate\Http\Request;

use App\User1;
use App\User2;
use App\Userreview;
use App\Spaceslot;
use App\User2requirespace;
use App\User1sharespace;
use App\Rentbookingsave;
use App\User2portfolio;
use App\User2identitie;
use Session;
use Mail;
use Config,DB;
use App\Library\WebPay\WebPay;
use Auth;
use Response,Redirect;
use Cache;
use View;
use Form;
use App\Chatmessage;
use URL;
use App\Models\Paypalbilling;
use App\Models\Paypal;
use Date;
use Hash;
use Illuminate\Support\Facades\Validator;
use App\Bookedspace;


class User2Controller extends Controller
{
	public function __construct(){
		$this->middleware('user2', ['except' => ['registerUser','login','isvalid','logout','landing','step2','confirm','saveUser','verifyEmail','thankyou','basicInfo','basicInfoSubmit','requireSpace','requireSpaceSubmit','successStep','validatePayment','searchSpaces', 'myPortfolio', 'myPortfolioSave','deleterecPayment','getajaxhour','getAmmountByfilter','registerPreSuccess']]);
		if (Auth::guard('user2')->check())
		{
			Cache::remember('chatNotification-'.Auth::guard('user2')->user()->HashCode, 60, function() {
				$msgs=Chatmessage::where('User2ID','')->whereIn('ChatID', function($query){
					$query->select(array('id'))->from('chats')->where('User2ID',Auth::guard('user2')->user()->HashCode)->get();
				})->orderBy('id', 'DESC')->take(10)->get();
				return($msgs);
				//return Article::all();
			});
		}
		return parent::__construct();
	}
	//
	public function registerUser()
	{
		return view('user2.register');
	}
	public function landing()
	{
		return view('user2.home');
	}
	public function step2(Request $request,User2 $user2)
	{
		if ($request->has('LastName')) {

			$this->validate($request ,[
					'LastName'=> 'required' ,
					'FirstName'=> 'required' ,
					'LastNameKana'=> 'required' ,
					'FirstNameKana'=> 'required' ,
					'Email'=> 'required|unique:user2s|email' ,
					'password'=> 'required'
					]);

			Session::put("LastName",$request->LastName);
			Session::put("FirstName",$request->FirstName);
			Session::put("LastNameKana",$request->LastNameKana);
			Session::put("FirstNameKana",$request->FirstNameKana);
			Session::put("Email",$request->Email);
			Session::put("password",$request->password);
		}
		return view('user2.step2');
	}

	public function invoiceList(Request $request)
	{
		$user=User2::find(Auth::guard('user2')->user()->id);
		$invoices = Rentbookingsave::where('user_id', $user->id)
		->where(function($query){
			$query->orWhere(function($query){
				$query->whereIn('rentbookingsaves.status', array(BOOKING_STATUS_RESERVED, BOOKING_STATUS_COMPLETED));
			});
			$query->orWhere(function($query){
				$query->where('rentbookingsaves.status', BOOKING_STATUS_REFUNDED);
				$query->where('rentbookingsaves.refund_status', '>', BOOKING_REFUND_NO_CHARGE);
			});
		})
		->where('rentbookingsaves.spaceslots_id', '<>', '')
		->whereNotNull('rentbookingsaves.spaceslots_id')
		->where('rentbookingsaves.transaction_id', '<>', '')
		->whereNotNull('rentbookingsaves.transaction_id')
		->where('rentbookingsaves.InvoiceID', '<>', '')
		->whereNotNull('rentbookingsaves.InvoiceID')
		->orderBy('created_at', 'DESC');
		$invoices= $invoices->paginate(LIMIT_INVOICE);
		$invoices->appends($request->except(['page']))->links();

		return view('user2.dashboard.invoice-shareuser',compact('user', 'invoices'));
	}

	public function invoiceDetail($id)
	{
		$user=User2::find(Auth::guard('user2')->user()->id);
		$booking = Rentbookingsave::where('InvoiceID', $id)->first();
		
		if(empty($booking)):
			Session::flash('error', trans('common.The Invoice you accessed not exists'));
			return redirectToDashBoard();
		endif;
		
		$aFlexiblePrice = Rentbookingsave::getInvoiceBookingPayment($booking);
		$prices = $aFlexiblePrice['prices'];
		$refundamount = priceConvert(ceil($booking->refund_amount));
		$totalPrice = priceConvert($aFlexiblePrice['totalPrice'], true);
		$remaining_amont=abs($aFlexiblePrice['totalPrice'] - $booking->refund_amount);

		return view('user2.dashboard.invoice-details-shareuser',compact('user', 'booking', 'prices','refundamount','remaining_amont'));

	}

	public function confirm(Request $request)
	{

		$this->validate($request ,[
				'PostalCode' => 'required',
				'Address' => 'required'
				]);

		Session::put('BusinessType', $request->BusinessType);
		Session::put("UserType",$request->UserType);
		Session::put("PostalCode",$request->PostalCode);
		Session::put("Address",$request->Address);

		Session::put("Newsletter",$request->Newsletter);
		//return redirect('Register-ShareUser/Confirm');
		return view('user2.confirm');
	}
	public function saveUser(Request $request,User2 $user2)
	{
		$request->merge(array('HashCode' => uniqid()));
		$request->merge(array('password' => bcrypt(Session::get("password"))));
		$request->merge(array('NameOfCompany' => Session::get("NameOfCompany")));
		$request->merge(array('LastName' => Session::get("LastName")));
		$request->merge(array('FirstName' => Session::get("FirstName")));
		$request->merge(array('LastNameKana' => Session::get("LastNameKana")));
		$request->merge(array('FirstNameKana' => Session::get("FirstNameKana")));
		$request->merge(array('Email' => Session::get("Email")));
		$request->merge(array('UserName' => Session::get("Email")));
		$request->merge(array('Address' => Session::get("Address")));
		$request->merge(array('PostalCode' => Session::get("PostalCode")));
		$request->merge(array('UserType' => Session::get("UserType")));
		$request->merge(array('BusinessType' => Session::get("BusinessType")));
		$request->merge(array('Newsletter' => Session::get("Newsletter")));
		$request->merge(array('IsAdminApproved' => "No"));
		$request->merge(array('EmailVerificationText' => uniqid()));

		$user2->create($request->except(['_token']));

		// Send email to admin
		global $from;
		$from = Config::get('mail.from');

		// Send email to admin
		sendEmailCustom ([
			'user' => $request,
			'sendTo' => $from['address'],
			'template' => 'user2.emails.admin',
			'subject' => 'OFFISPOでレントユーザーが新規登録されました']
				);
		
		// Send email to user
		sendEmailCustom ([
			'user' => $request,
			'sendTo' => $request->Email,
			'template' => 'user2.emails.register',
			'subject' => '仮会員登録完了のお知らせ | hOurOffice']
				);
		
		Session::flush();
		return redirect('Register-RentUser/ThankYou');
	}


	public function verifyEmail($id)
	{
		$user=User2::where('EmailVerificationText','=', $id)->first();
		if ($user) {
			if($user->IsEmailVerified!="Yes")
			{
				$user->IsEmailVerified="Yes";
				$user->save();
			}
			return view('user2.emailverify');


		}
		return("Invalid ID");

	}
	public function thankyou()
	{
		return view('user2.thankyou');
	}

	public function logout()
	{
		if (Auth::guard('user2')->check())
		{
			auth()->guard('user2')->logout();
		}
		Session::put('user2.url.intended','');
		return redirect('/');
	}
	public function login(Request $request)
	{
		if ($request->spaceID)
		{
			Session::put('user2.url.intended', getSpaceUrl($request->spaceID));
		}
		return view('user2.login-form-temp');
	}
	public function isvalid(Request $request, User2 $user2)
	{
		$this->validate($request ,[
				'Email' => 'required' ,
				'password'=> 'required'
				]);

		$auth = auth()->guard('user2');
		$user2 = $user2->isEmailVerified()->where(function ($query) use ($request) {
			$query->orWhere('Email', $request->Email);
			$query->orWhere('UserName', $request->Email);
		})->first();
		
		$errMessage = '';
		if (!$user2)
		{
			$errMessage = trans('common.login_not_exists_or_verified');
			$redirect = '/User2/Login';
		}
		else {
			//if($auth->attempt($request->only('Email', 'password')))
			if($auth->attempt(['Email' => $request->Email, 'password' => $request->password]) || $auth->attempt(['UserName' => $request->Email, 'password' => $request->password]))
			{
				Auth::guard('user1')->logout();
				if (Session::get('user2.url.intended'))
				{
					$redirect = Session::get('user2.url.intended');
					
				}
				else {
					$redirect = '/RentUser/Dashboard';
				}
			}
			else{
				$errMessage = '認証エラー';
				$redirect = '/User2/Login';
			}
		}
		
		if ($request->ajax())
		{
			return Response::json(array(
					'errMessage' => $errMessage,
					'redirect' => $redirect
			));
		}
		else {
			if ($errMessage)
			{
				session()->flash('err', $errMessage);
			}
			return Redirect::to($redirect);
		}
	}

	public function changePassword(Request $request)
	{
		$inputData = $request->formData;
		parse_str($inputData, $formFields);
		$request->merge($formFields);
		$this->validate($request ,[
				'oldpassword'=> 'required' ,
				'password' => 'required|confirmed',
				]);
		$user=User2::find(Auth::guard('user2')->user()->id);
		if (Hash::check($request->oldpassword, $user->password)) {
			$user->password=bcrypt($request->password);
			$user->save();
				
			return Response::json(array(
					'success' => true,
					'next' => ""
			));

		}
	}


	public function changeEmail(Request $request)
	{
		$inputData = $request->formData;
		parse_str($inputData, $formFields);
		$request->merge($formFields);
		$this->validate($request ,[
				'Email'=> 'required|unique:user1s|email'

				]);
		$user=User2::find(Auth::guard('user2')->user()->id);

		$user->Email=$request->Email;
		$user->EmailVerificationText=uniqid();
		$user->IsEmailVerified='No';
		$user->save();
			
		$from = Config::get('mail.from');
		Mail::send('user2.emails.verifyemail',
		[
		'EmailVerificationText' => $user->EmailVerificationText,
		],
		function ($message) use ($user, $from){
			$message->from($from['address'], $from['name']);
			$mails = [$user->Email];
			$message->to($mails)->subject('メールアドレスの認証 | hOur Office');
		});
		return Response::json(array(
				'success' => true,
				'next' => ""
		));



		return Response::json(array(
				'matched' => false,
				'next' => ""
		));
	}



	public function basicInfo()
	{
		if(Session::has("RentUserID") && !empty(Session::get("RentUserID")))
		{
			$providerUser = Session::has("providerUser") ? Session::get("providerUser") : '';
			return view('user2.register.select-basicinfo', compact('providerUser'));
		}
		else
		{
			return redirectToDashBoard();
		}
		//return 'test '.Session::get("RentUserID");
	}
	public function basicInfoSubmit(Request $request)
	{

		$this->validate($request ,[
				'LastName'=> 'required' ,
				'FirstName'=> 'required' ,
				'LastNameKana'=> 'required' ,
				'FirstNameKana'=> 'required' ,
				'PostalCode' => 'required',
				'Address1' => 'required'

				]);

		if(!empty($request->Skills))
		{
			$request->merge(array('Skills' => implode (",", $request->Skills)));
		}

		$u=User2::find(Session::get("RentUserID"));
		$u->fill($request->except(['_token']));
		if($u->save())
		{
			$from = Config::get('mail.from');
			Mail::send('user2.emails.register',
			['user' => $u],
			function ($message) use ($u, $from) {
				$message->from($from['address'], $from['name']);
				$mails = [$u->Email];
				$message->to($mails)->subject('ユーザー会員登録完了のお知らせ');
			});
				
			return redirect('/RentUser/RegisterPreSuccess');
		}


	}

	public function registerPreSuccess(){
		$user=User2::find(Session::get("RentUserID"));
		if ($user)
		{
			return view('user2.register.register_pre_success', compact('user'));
		}
		return '';
	}
	public function editBasicInfo ()
	{
		$pb = new Paypalbilling();
		$paypalStatus = $pb->getUserBillingStatus();
		
		$user = User2::find(Auth::guard('user2')->user()->id);
		$userIde = User2identitie::where('User2ID', Auth::guard('user2')->user()->id)->where('SentToAdmin', 'Yes')->get();
		return view('user2.dashboard.setting-rentuser', compact('user', 'userIde', 'paypalStatus'));
	}
	public function editBasicInfoSubmit ( Request $request )
	{
		$input = $request->all();
		$credit = new User2();
		$user = User2::find(Auth::guard('user2')->user()->id);
		if ( $this->validDate($input['exp_year'], $input['exp_month']) == false )
		{
			return redirect()->back()->withErrors([
				'massage' => '有効期限が過ぎています'
			]);
		}
		$type = $this->creditCardType($input['card_number']);
		if ( $type == "" )
		{
			return redirect()->back()->withErrors([
				'massage' => 'カードの種類が確認できません'
			]);
		}
		if ( $this->validCvcLength($input['security_code'], $type) == false )
		{
			return redirect()->back()->withErrors([
				'massage' => 'セキュリティーコードが間違っています'
			]);
		}
		if ( strpos($input['card_number'], '*') !== false )
		{
			$request['card_number'] = $credit->cc_encrypt($user['modifiededit_card_number']);
		}
		else
		{
			$request['card_number'] = $credit->cc_encrypt($input['card_number']);
		}
		if ( $credit->cc_encrypt($input['card_number'] != $user['card_number'] && ! $credit->is_valid_card($input['card_number'])) )
		:
		//Session::flash('error', 'Your card number is invalid.');
		//return redirect('/RentUser/Dashboard/BasicInfo/Edit');
		endif;
		$type = $this->validate_cc_number($input['card_number']);
		if ( $type == false )
		{
			return redirect()->back()->withErrors([
				'success' => 'カード番号が無効です'
			]);
		}
		else
		{
			if ( strpos($input['card_number'], '*') !== false )
			{
				$request['card_number'] = $credit->cc_encrypt($user['modifiededit_card_number']);
			}
			else
			{
				$request['card_number'] = $credit->cc_encrypt($input['card_number']);
			}
			
			$user->fill($request->except([
				'_token',
				'oldpassword',
				'password',
				'cpassword',
				'UserName',
				'Email'
			]));
			$user->save();
			Session::flash('success', 'You have successfully updated profile info.');
			return redirect('/RentUser/Dashboard/BasicInfo/Edit');
		}
	}

	public function editBasicInfoSubmitData(Request $request)
	{
		$input=$request->all();
		$credit=new User2();
		$user=User2::find(Auth::guard('user2')->user()->id);
    

            $user->fill($request->except(['_token','oldpassword','password','cpassword','UserName','Email']));
            $user->save();
		    Session::flash('success', 'You have successfully updated profile info.');
            return redirect('/RentUser/Dashboard/BasicInfo/Edit');
        

    }


	
    protected static $cards = array(
        // Debit cards must come first, since they have more specific patterns than their credit-card equivalents.
        'visaelectron' => array(
            'type' => 'visaelectron',
            'pattern' => '/^4(026|17500|405|508|844|91[37])/',
            'length' => array(16),
            'cvcLength' => array(3),
            'luhn' => true,
        ),
        'maestro' => array(
            'type' => 'maestro',
            'pattern' => '/^(5(018|0[23]|[68])|6(39|7))/',
            'length' => array(12, 13, 14, 15, 16, 17, 18, 19),
            'cvcLength' => array(3),
            'luhn' => true,
        ),
        'forbrugsforeningen' => array(
            'type' => 'forbrugsforeningen',
            'pattern' => '/^600/',
            'length' => array(16),
            'cvcLength' => array(3),
            'luhn' => true,
        ),
        'dankort' => array(
            'type' => 'dankort',
            'pattern' => '/^5019/',
            'length' => array(16),
            'cvcLength' => array(3),
            'luhn' => true,
        ),
        // Credit cards
        'visa' => array(
            'type' => 'visa',
            'pattern' => '/^4/',
            'length' => array(13, 16),
            'cvcLength' => array(3),
            'luhn' => true,
        ),
        'mastercard' => array(
            'type' => 'mastercard',
            'pattern' => '/^(5[0-5]|2[2-7])/',
            'length' => array(16),
            'cvcLength' => array(3),
            'luhn' => true,
        ),
        'amex' => array(
            'type' => 'amex',
            'pattern' => '/^3[47]/',
            'format' => '/(\d{1,4})(\d{1,6})?(\d{1,5})?/',
            'length' => array(15),
            'cvcLength' => array(3, 4),
            'luhn' => true,
        ),
        'dinersclub' => array(
            'type' => 'dinersclub',
            'pattern' => '/^3[0689]/',
            'length' => array(14),
            'cvcLength' => array(3),
            'luhn' => true,
        ),
        'discover' => array(
            'type' => 'discover',
            'pattern' => '/^6([045]|22)/',
            'length' => array(16),
            'cvcLength' => array(3),
            'luhn' => true,
        ),
        'unionpay' => array(
            'type' => 'unionpay',
            'pattern' => '/^(62|88)/',
            'length' => array(16, 17, 18, 19),
            'cvcLength' => array(3),
            'luhn' => false,
        ),
        'jcb' => array(
            'type' => 'jcb',
            'pattern' => '/^35/',
            'length' => array(16),
            'cvcLength' => array(3),
            'luhn' => true,
        ),
    );
    public static function validCreditCard($number, $type = null)
    {
        $ret = array(
            'valid' => false,
            'number' => '',
            'type' => '',
        );
        // Strip non-numeric characters
        $number = preg_replace('/[^0-9]/', '', $number);
        if (empty($type)) {
            $type = self::creditCardType($number);
        }
        if (array_key_exists($type, self::$cards) && self::validCard($number, $type)) {
            return array(
                'valid' => true,
                'number' => $number,
                'type' => $type,
            );
        }
        return $ret;
    }
    public static function validCvc($cvc, $type)
    {
        return (ctype_digit($cvc) && array_key_exists($type, self::$cards) && self::validCvcLength($cvc, $type));
    }
    public static function validDate($year, $month)
    {
        $month = str_pad($month, 2, '0', STR_PAD_LEFT);
        if (! preg_match('/^20\d\d$/', $year)) {
            return false;
        }
        if (! preg_match('/^(0[1-9]|1[0-2])$/', $month)) {
            return false;
        }
        // past date
        if ($year < date('Y') || $year == date('Y') && $month < date('m')) {
            return false;
        }
        return true;
    }
    // PROTECTED
    // ---------------------------------------------------------
    protected static function creditCardType($number)
    {
        foreach (self::$cards as $type => $card) {
            if (preg_match($card['pattern'], $number)) {
                return $type;
            }
        }
        return '';
    }
    protected static function validCard($number, $type)
    {
        return (self::validPattern($number, $type) && self::validLength($number, $type) && self::validLuhn($number, $type));
    }
    protected static function validPattern($number, $type)
    {
        return preg_match(self::$cards[$type]['pattern'], $number);
    }
    protected static function validLength($number, $type)
    {
        foreach (self::$cards[$type]['length'] as $length) {
            if (strlen($number) == $length) {
                return true;
            }
        }
        return false;
    }
    protected static function validCvcLength($cvc, $type)
    {
        foreach (self::$cards[$type]['cvcLength'] as $length) {
            if (strlen($cvc) == $length) {
                return true;
            }
        }
        return false;
    }
    protected static function validLuhn($number, $type)
    {
        if (! self::$cards[$type]['luhn']) {
            return true;
        } else {
            return self::luhnCheck($number);
        }
    }
    protected static function luhnCheck($number)
    {
        $checksum = 0;
        for ($i=(2-(strlen($number) % 2)); $i<=strlen($number); $i+=2) {
            $checksum += (int) ($number{$i-1});
        }
        // Analyze odd digits in even length strings or even digits in odd length strings.
        for ($i=(strlen($number)% 2) + 1; $i<strlen($number); $i+=2) {
            $digit = (int) ($number{$i-1}) * 2;
            if ($digit < 10) {
                $checksum += $digit;
            } else {
                $checksum += ($digit-9);
            }
        }
        if (($checksum % 10) == 0) {
            return true;
        } else {
            return false;
        }
    }

    function validate_cc_number($cc_number) {
        /* Validate; return value is card type if valid. */
        $false = false;
        $card_type = "";
        $card_regexes = array(
            "/^4\d{12}(\d\d\d){0,1}$/" => "visa",
            "/^5[12345]\d{14}$/"       => "mastercard",
            "/^3[47]\d{13}$/"          => "amex",
            "/^6011\d{12}$/"           => "discover",
            "/^30[012345]\d{11}$/"     => "diners",
            "/^3[68]\d{12}$/"          => "diners",
        );

        foreach ($card_regexes as $regex => $type) {
            if (preg_match($regex, $cc_number)) {
                $card_type = $type;
                break;
            }
        }

        if (!$card_type) {
            return $false;
        }

        /*  mod 10 checksum algorithm  */
        $revcode = strrev($cc_number);
        $checksum = 0;

        for ($i = 0; $i < strlen($revcode); $i++) {
            $current_num = intval($revcode[$i]);
            if($i & 1) {  /* Odd  position */
                $current_num *= 2;
            }
            /* Split digits and add. */
            $checksum += $current_num % 10; if
            ($current_num >  9) {
                $checksum += 1;
            }
        }

        if ($checksum % 10 == 0) {
            return $card_type;
        } else {
            return $false;
        }
    }

    
    public function removeCard(){

		if(User2::where('id' , Auth::guard('user2')->user()->id)->update([
            'card_name' => '',
            'card_number' => '',
            'exp_month' => '',
            'exp_year' => '',
            'security_code' => ''
        ])){
            return redirect()->back();
        }
        
        
        
        
    }
	public function requireSpace()
	{
		//if(1)
		if(Session::has("RentUserID") && !empty(Session::get("RentUserID")))
		{
			$budgets= \App\Budget :: where('Type', '!=','search')->get();
			$timeslots=\App\Timeslot :: get();
			return view('user2.register.select-requirespace',compact('budgets','timeslots'));
				
		}
		else
		{
			return redirectToDashBoard();
		}


	}
	public function requireSpaceSubmit(Request $request)
	{

		if (Auth::guard('user2')->check())
		{
			$user=User2::find(Auth::guard('user2')->user()->id);
			$space= User2requirespace::firstOrNew(array('User2ID' => Auth::guard('user2')->user()->id));

		}
		else
		{
			$user=User2::find(Session::get("RentUserID"));
			$space= User2requirespace::firstOrNew(array('User2ID' => Session::get("RentUserID")));
		}

		if(!empty($request->SpaceType))
		{
			$request->merge(array('SpaceType' => implode (",", $request->SpaceType)));
		}
		else
		{
			$request->merge(array('SpaceType' => ''));
		}
		if(!empty($request->OtherFacility))
		{
			$request->merge(array('OtherFacility' => implode (",", $request->OtherFacility)));
		}
		else
		{
			$request->merge(array('OtherFacility' =>''));
		}

		if(!empty($request->DesireLocationDistricts))
		{
			$request->merge(array('DesireLocationDistricts' => implode (",", $request->DesireLocationDistricts)));

		}
		else
		{
			$request->merge(array('DesireLocationDistricts' => ''));

		}
		$space->fill($request->except(['_token']));
		$space->save();
		if (Auth::guard('user2')->check())
		{
			return redirect('/RentUser/Dashboard/EditMySpace');
		}
		else
		{
			return redirect('/RentUser/ValidatePayment');
		}
		//return($request->all());
	}

	public function validatePayment()
	{
		if(Session::has("RentUserID") && !empty(Session::get("RentUserID")))
		{
			$userId = Session::get("RentUserID");
			$user = User2::find($userId);
			$pb = new Paypalbilling();
			$paypalStatus = $pb->getUserBillingStatus($userId);
			return view('user2.register.select-validpayment' ,compact('user' , 'paypalStatus'));
			/*return view('user2.register.select-validpayment');*/
		}
		else
		{
			return redirectToDashBoard();
		}

	}

	public function successStep()
	{
		if(Session::has("RentUserID") && !empty(Session::get("RentUserID")))
			//if(1)
		{
			$user=User2::find(Session::get("RentUserID"));
			Auth::guard('user2')->login($user);
			return view('user2.register.success-steps');
		}
		else
		{
			return redirectToDashBoard();
		}

	}
	public function dashboard(Request $request)
	{
		$pb = new Paypalbilling();

		$paypalStatus = $pb->getUserBillingStatus();
		$aDataMapperSearch = array(
				'SpaceType' => array(
						'search' => 'Type',
						'conditionType' => 'whereIn',
						'whereType' => 'IN',
				),
				'DesireLocationPrefecture' => array(
						'search' => 'Prefecture',
						'conditionType' => 'where',
						'whereType' => '=',
				),
				'DesireLocationDistricts' => array(
						'search' => 'District',
						'conditionType' => 'whereIn',
						'whereType' => 'IN',
				),
				'BudgetID' => array(
						'search' => 'Budgets',
						'conditionType' => 'whereBetween',
						'whereType' => 'Between',
				),
				'TimeSlot' => array(
						'search' => array(
								array('start' => 'MondayStartTime', 'end' => 'MondayEndTime', 'close' => 'isClosedMonday', 'open' => 'isOpen24Monday'),
								array('start' => 'TuesdayStartTime', 'end' => 'TuesdayEndTime', 'close' => 'isClosedTuesday', 'open' => 'isOpen24Tuesday'),
								array('start' => 'WednesdayStartTime', 'end' => 'WednesdayEndTime', 'close' => 'isClosedWednesday', 'open' => 'isOpen24Wednesday'),
								array('start' => 'ThursdayStartTime', 'end' => 'ThursdayEndTime', 'close' => 'isClosedThursday', 'open' => 'isOpen24Thursday'),
								array('start' => 'FridayStartTime', 'end' => 'FridayEndTime', 'close' => 'isClosedFriday', 'open' => 'isOpen24Friday'),
								array('start' => 'SaturdayStartTime', 'end' => 'SaturdayEndTime', 'close' => 'isClosedSaturday', 'open' => 'isOpen24Saturday'),
								array('start' => 'SundayStartTime', 'end' => 'SundayEndTime', 'close' => 'isClosedSunday', 'open' => 'isOpen24Sunday'),
						),
						'conditionType' => 'StartEnd',
						'whereType' => 'Between',
				),
				'SpaceArea' => array(
						'search' => 'Area',
						'conditionType' => 'whereBetween',
						'whereType' => 'Between',
				),
				'NumberOfPeople' => array(
						'search' => 'Capacity',
						'conditionType' => 'Special',
						'whereType' => '>=',
				),
				'NumOfDesk' => array(
						'search' => 'NumOfDesk',
						'conditionType' => 'where',
						'whereType' => '>=',
				),
				'NumOfChair' => array(
						'search' => 'NumOfChair',
						'conditionType' => 'where',
						'whereType' => '>=',
				),
				'NumOfBoard' => array(
						'search' => 'NumOfBoard',
						'conditionType' => 'where',
						'whereType' => '>=',
				),
				'NumOfLargeDesk' => array(
						'search' => 'NumOfTable',
						'conditionType' => 'where',
						'whereType' => '>=',
				),
				'OtherFacility' => array(
						'search' => 'OtherFacilities',
						'conditionType' => 'Special',
						'whereType' => 'IN',
				),
		);
		$user2Space= User2requirespace::firstOrNew(array('User2ID' => Auth::guard('user2')->user()->id));

		global $user1Space;
		$user1Space = new User1sharespace();
		$aSpaceTypes = getSpaceTypeMapper();

		foreach ($aDataMapperSearch as $field => $sMapper)
		{
			global $conditionType, $mapper, $fieldValue;

			if (!$user2Space[$field]) continue;

			$mapper = $sMapper;
			$conditionType = $mapper['conditionType'];
			$whereType = $mapper['whereType'];

			if ($field == 'TimeSlot')
			{
				$timeslot = \App\Timeslot::find((int)$user2Space[$field]);
				$fieldValue = date('g:i A', strtotime($timeslot->StartValue)) . '-' . date('g:i A', strtotime($timeslot->EndValue));
			}
			else {
				$fieldValue = $user2Space[$field];
			}

			if (in_array($conditionType, array('whereIn', 'whereNotIn', 'whereBetween', 'whereNotBetween')))
			{
				$fieldValue = explode(',', $fieldValue);
				if ($field == 'BudgetID')
				{
					$budgetType = $user2Space['BudgetType'];
					$mapper['search'] = ucwords($budgetType).'Fee';
					$budget= \App\Budget :: firstOrNew(array('id' => $fieldValue));
					$fieldValue = array($budget['StartValue'], $budget['EndValue']);
				}
				elseif ($field == 'SpaceArea')
				{
					$aConfigSpaceArea = Config::get('lp.spaceArea');
					$spaceId = $fieldValue[0];
					$fieldValue = array($aConfigSpaceArea[$spaceId]['start'], $aConfigSpaceArea[$spaceId]['end']);
				}
				elseif ($field == 'SpaceType'){
					$fieldValueTmp = array();
					if (!empty($fieldValue))
					{
						foreach ($fieldValue as $value)
						{
							if (isset($aSpaceTypes[$value]))
								$spaceType = $aSpaceTypes[$value];
							$fieldValueTmp = array_merge($fieldValueTmp, $spaceType);
						}
						$fieldValue = $fieldValueTmp;
					}
				}
				$user1Space = $user1Space->{$conditionType}($mapper['search'], $fieldValue);

				if (in_array($conditionType, array('whereIn', 'whereNotIn')))
				{
					$user1Space = $user1Space->orderByRaw($mapper['search'] . ' ' . $whereType . '("' . implode('","', $fieldValue) . '") DESC');
				}
				else {
					$user1Space = $user1Space->orderByRaw($mapper['search'] . ' ' . $whereType . ' "'. $fieldValue[0] .'" AND "'. $fieldValue[1] .'" DESC');
				}
			}
			elseif (in_array($conditionType, array('StartEnd')))
			{

				if (is_array($mapper['search']))
				{
					$user1Space = $user1Space->where(function ($query) {
						global $mapper;
						foreach ($mapper['search'] as $search)
						{
							global $mySearch;
							$mySearch = $search;
							$query->orWhere(function ($query) {
								global $mapper, $mySearch, $fieldValue;
								$aExplodeValue = explode('-', $fieldValue);
								$query->whereRaw(DB::raw('CAST(`'. $mySearch['start'] .'` AS signed) <= CAST("'. $aExplodeValue[0] .'" AS signed)'));
								$query->whereRaw(DB::raw('CAST(`'. $mySearch['end'] .'` AS signed) >= CAST("'. $aExplodeValue[1] .'" AS signed)'));
								$query->where($mySearch['close'], '=', '');
							});
							$query->orWhere($mySearch['open'], '<>', '');
						}
					});
				}

			}
			elseif (in_array($conditionType, array('Special'))) {
				if ($field == 'NumberOfPeople') {
					$aFieldValue  = explode('~', $fieldValue);
					if (count($aFieldValue) == 2)
					{
						$fieldValue = array_map('intval', $aFieldValue);
						$conditionType = 'whereBetween';
						$whereType = 'Between';
						$user1Space = $user1Space->{$conditionType}($mapper['search'], $fieldValue);
						$user1Space = $user1Space->orderByRaw($mapper['search'] . ' ' . $whereType . ' "'. $fieldValue[0] .'" AND "'. $fieldValue[1] .'" DESC');
					}
					else{
						if (strpos($aFieldValue[0], '以上') !== false)
							$whereType = '>=';
						else
							$whereType = '<=';
						$conditionType = 'where';
						$fieldValue = (int)$aFieldValue[0];
						$user1Space = $user1Space->{$conditionType}($mapper['search'], $whereType, $fieldValue);
						$user1Space = $user1Space->orderByRaw($mapper['search'] . ' ' . $whereType . " '" . $fieldValue . "'" . ' DESC');
					}
				}
				elseif ($field == 'OtherFacility')
				{
					global $aFieldValue;
					$aFieldValue = explode(',', $fieldValue);
					if (!empty($fieldValue))
					{
						$user1Space = $user1Space->where(function ($query) {
							global $mapper, $aFieldValue, $fieldValue;
							foreach ($aFieldValue as $search)
							{
								$fieldValue = $search;
								$query->orWhere(function ($query) {
									global $mapper, $fieldValue;
									$query->where($mapper['search'], 'LIKE', '%'. $fieldValue .'%');
								});
							}
						});
					}
				}
			}
			else {
				if ($conditionType == 'where')
				{
					$user1Space = $user1Space->orderByRaw($mapper['search'] . ' ' . $whereType . " '" . $fieldValue . "'" . ' DESC');
				}
				$user1Space = $user1Space->{$conditionType}($mapper['search'], $whereType, $fieldValue);
			}

		}
		//inRandomOrder
		$user1Space = $user1Space->where('status', SPACE_STATUS_PUBLIC)->take(100)->with('spaceImage');
		$user1Space = $user1Space->get();
		$spacesTmp = clone $user1Space;
		
		foreach ($spacesTmp as $spaceIndex => $space)
		{
			// Check available slots
			$aVailableSlots = Spaceslot::getAvailableSpaceSlot($space);
			$aBookingTimeInfo = false;
			$aAvailableDate = array();
			$aBookingTimeInfoSelected = array();
			foreach ($aVailableSlots as $aVailableSlot)
			{
				if (in_array($aVailableSlot['StartDate'], array_keys($aAvailableDate))) continue;
		
				$myRequest = new Request();
				$myRequest->merge(array('booked_date' => $aVailableSlot['StartDate']));
				$myRequest->merge(array('spaceID' => $space->id));
		
				$aBookingTimeInfo = Spaceslot::getBookingTimeInfo($myRequest, $aVailableSlots, $space);
					
				if (count(@$aBookingTimeInfo['timeDefaultSelected']))
				{
					if (!isset($aBookingTimeInfo['timeDefaultSelected']['StartDate']))
						continue;
							
						if (!count($aBookingTimeInfoSelected))
							$aBookingTimeInfoSelected = $aBookingTimeInfo;
								
							$aAvailableDate[$aBookingTimeInfo['timeDefaultSelected']['StartDate']] = $aBookingTimeInfo['timeDefaultSelected'];
								
							// If has booking info, break now.
							if ($space->FeeType != SPACE_FEE_TYPE_HOURLY && $aBookingTimeInfo)
							{
								break;
							}
				}
			}
				
			if (!count($aBookingTimeInfoSelected))
			{
				unset($user1Space[$spaceIndex]);
			}
		}
		// Unset temp variable
		unset($spacesTmp);
		$spacesTmp = array();
		
		$user = Auth::guard('user2')->user();

		// Create Booking Notification
		$aNotifications = array();
		$aNotificationTimes = Notification::select('Time')
		->whereIn('Type', getUser2DashboardNotifications())
		->where('UserReceiveID', $user->id)
		->where('UserSendType', 1)
		->where('UserReceiveType', 2)
		->orderBy('Time', 'DESC')
		->groupBy(array('Time'));

		$aNotificationTimes= $aNotificationTimes->paginate(LIMIT_DASHBOARD_FEED);
		$aNotificationTimes->appends($request->except(['page']))->links();

		$aTime = array();
		foreach ($aNotificationTimes as $aNotificationTime)
		{
			$aTime[] = $aNotificationTime->Time;
		}

		$allNotifications = $user->receiveBookingNotifications()->whereIn('Time', $aTime)->get();

		if (isset($allNotifications) && count($allNotifications))
		{
			foreach ($allNotifications as $notification) {
				// Check to get only Dash board notification for User2
				if (in_array($notification['Type'], getUser2BookingNotifications()))
				{
					if (!$notification['booking'])
						continue;
					else
					{
						$slots_data=\App\Bookedspaceslot::where('BookedID', $notification['booking']['id'])->orderBy('StartDate','asc')->get();
						$notification['booking']['slotID'] = $slots_data;
					}
				}
				$aNotifications[$notification['Time']][] = $notification;
			}
			// Sort notification by key Time
			krsort($aNotifications);
		}

		$user->notifications = $aNotifications;
		$user->paginator = $aNotificationTimes;

		$bookingHistories = \App\Rentbookingsave::where('user_id', $user->id)->where('status', '<>', BOOKING_STATUS_DRAFT)->orderBy('updated_at', 'DESC')->take(10)->get();

		\Carbon\Carbon::setLocale('ja');

		if ($request->ajax() && $request->page)
		{
			if (count($aNotificationTimes))
				return view('user2.dashboard.dashboard-rentuser-feed',compact('user', 'user1Space', 'paypalStatus', 'user2Space', 'bookingHistories'));
			else exit();
		}
		return view('user2.dashboard.dashboard-rentuser',compact('user', 'user1Space', 'paypalStatus', 'user2Space', 'bookingHistories'));

	}
	public function myPage(Request $request)
	{
		$user=User2::find(Auth::guard('user2')->user()->id);
		$favorite= \App\Favorite::where('User2ID','=', Auth::guard('user2')->user()->id)->groupBy('SpaceId')->get();
		$spaces= new \App\User1sharespace();
		$spaces= $spaces->get();

		$userErrors = array();
		//show if user is not approval yet
		if (!IsAdminApprovedUser($user) and count($user->certificates) >= 1) {
			$userErrors['approve']['message'] = '審査中の為、アカウント権限が制限されています。';
		}
		//show if cerdificate is not completed and not approval yet
		if (!count($user->certificates)) {
			$userErrors['certificates']['message'] = '証明書の提出が完了していないため、アカウント権限が制限されています。';
			$userErrors['certificates']['url'] = User2::getCertificatePageUrl();
			$userErrors['certificates']['button'] = '証明書の提出';
		}

		if (!User2::isProfileFullFill($user)) {
			$userErrors['setting']['message'] = 'アカウント設定が完了していません。';
			$userErrors['setting']['url'] = url('/RentUser/Dashboard/BasicInfo/Edit');
			$userErrors['setting']['button'] = '設定する';
		}

		$reviews = $this->getGroupedReviews($request);
		
		$oTimeNow = \Carbon\Carbon::now();
		// Get User Offers
		$oCountTotalOffer = $user->receiveNotificationsOffers()->select(DB::Raw('Count(*) as total'))->first();
		// New is less than 1 week
		$oCountNewOffer = $user->receiveNotificationsOffers()->where('Time', $oTimeNow->subWeeks(1)->format('Y-m-d H:i:s'))->select(DB::Raw('Count(*) as total_new'))->first();
		
		
		// Get Booking status
		$allDatas = Rentbookingsave::select('rentbookingsaves.*')
		->where('rentbookingsaves.InvoiceID', '<>', '')
		->where('rentbookingsaves.user_id', $user->id)
		->joinSpace()
		->groupBy(array('rentbookingsaves.id'))
		->whereNotIn('rentbookingsaves.status', array(BOOKING_STATUS_DRAFT));
			
		$allDatas = $allDatas->get();
		$totalCountStatus = count($allDatas);
			
		//Filter by status
		$aDataStatus = array();
		foreach ($allDatas as $rent_data)
		{
			$status = ($rent_data->status == BOOKING_STATUS_RESERVED && $rent_data->in_use == BOOKING_IN_USE) ? BOOKING_STATUS_INUSE : $rent_data->status;
			$status = $status == BOOKING_STATUS_CALCELLED ? BOOKING_STATUS_REFUNDED : $status;
			$aDataStatus[$status] = isset($aDataStatus[$status]) ? $aDataStatus[$status] + 1 : 1;
		}
		
		return view('user2.dashboard.mypage-rentuser',compact(
				'user','favorite','spaces','userErrors', 'reviews', 'oCountTotalOffer', 'oCountNewOffer',
				'aDataStatus', 'totalCountStatus'
		));
	}
	public function myPageFavorite()
	{
		$favorite= \App\Favorite::where('User2ID','=', Auth::guard('user2')->user()->id)->groupBy('SpaceId')->get();
		$spaces= new \App\User1sharespace();
		$spaces= $spaces->get();
		return view('user2.dashboard.mypage-favorite',compact('favorite','spaces'));
	}
	public function offerList()
	{
		$user = User2::with('receiveNotificationsWithSpace')->where('id', Auth::guard('user2')->user()->id)->first();
		$aNotifications = array();
		if (isset($user->receiveNotificationsWithSpace) && count($user->receiveNotificationsWithSpace))
		{
			foreach ($user->receiveNotificationsWithSpace as $notification) {
				$aNotifications[$notification['Time']][] = $notification;
			}
			$user->notifications = $aNotifications;
		}

		\Carbon\Carbon::setLocale('ja');
		return view('user2.dashboard.offerlist-rentuser',compact('user'));
	}

	public function editMySpace()
	{
		$budgets= \App\Budget :: where('Type', '!=','search')->get();
		$timeslots=\App\Timeslot :: get();
		$space= User2requirespace::firstOrNew(array('User2ID' => Auth::guard('user2')->user()->id));
		return view('user2.dashboard.editmyspace-rentuser',compact('budgets','timeslots','space'));

	}

	public function myProfile()
	{
		$user=User2::find(Auth::guard('user2')->user()->id);
		$space= User2requirespace::firstOrNew(array('User2ID' => Auth::guard('user2')->user()->id));;
		$me="True";
		return view('user2.dashboard.profile-rentuser',compact('user','space','me'));
	}
	public function myProfileEdit(Request $request)
	{
		if ($request->action == 'delete_portfolio')
		{
			$userPortfolio = User2portfolio::find($request->portfolio_id);
			if ($userPortfolio)
			{
				@unlink(public_path() . $userPortfolio->Photo);
				$userPortfolio->delete();
			}
		}

		$aBudgets = \App\Budget::where('Type', '!=', 'search')->get();
		$aTimeslots = \App\Timeslot::get();
		$user = User2::find(Auth::guard('user2')->user()->id);
		$space = User2requirespace::firstOrNew(array(
			'User2ID' => Auth::guard('user2')->user()->id
		));
		
		$aSpaceTypes = getSpaceTypeMapper();
		
		$timeslots = array();
		$budgets = array();
		$areas = array();
		foreach ($aTimeslots as $timeslot)
		{
			$timeslots[$timeslot->id] = $timeslot->Display;
		}
		
		foreach ($aBudgets as $budget)
		{
			$budgets[$budget->id] = $budget->Display;
		}
		
		foreach(Config::get('lp.spaceArea') as $area => $ar )
		{
			$areas[$ar['id']] = $ar['display'];
		}
			
		$userPortfolios = User2portfolio::where('User2Id', '=', Auth::guard('user2')->user()->id)->get();
		$reviews = Userreview::avarageUser2Reviews($user->id);
		$allReviews = Userreview::getUser2Reviews($user->id);
		
		$isPaymentSetup = User2::isPaymentSetup($user);
		$isProfileFullFilled = User2::isProfileFullFill($user);

		$spaceTypes = explode(',', $space->SpaceType);
		foreach ($spaceTypes as $indexSpaceType => $spaceType)
		{
			if (isset($aSpaceTypes[$spaceType]) && is_array($aSpaceTypes[$spaceType]))
			{
				$spaceTypes[$indexSpaceType] = implode(',', @$aSpaceTypes[$spaceType]);
			}
		}
		$space->SpaceType = implode(',', $spaceTypes);
		return view('user2.dashboard.profile-rentuser_edit',compact('user','aSpaceTypes', 'space','budgets','timeslots', 'areas', 'userPortfolios', 'reviews', 'allReviews', 'isPaymentSetup', 'isProfileFullFilled'));
	}
	public function myProfileEditSubmit(Request $request)
	{

		$user=User2::find(Auth::guard('user2')->user()->id);
		$space= User2requirespace::firstOrNew(array('User2ID' => Auth::guard('user2')->user()->id));
		$space->fill($request->all());
		$space->save();
		return 'success';
		//return view('user2.dashboard.setting-rentuser',compact('user'));
	}

	public function myProfileEditSubmit2(Request $request)
	{

		$user=User2::find(Auth::guard('user2')->user()->id);
		$user->fill($request->all());
		$user->save();
		return 'success';
		//return view('user2.dashboard.setting-rentuser',compact('user'));
	}
	public function myProfile1()
	{
		$user=User2::find(Auth::guard('user2')->user()->id);
		$space= User2requirespace::firstOrNew(array('User2ID' => Auth::guard('user2')->user()->id));;
		return($space);
		//return view('user2.dashboard.profile-rentuser',compact('user'));
	}

	public function myPortfolio(Request $request)
	{
		$userPortfolio = User2portfolio::find($request->id);
		$action = $request->action;
		$html = View::make('user2.dashboard.profile-rentuser_portfolio',compact('userPortfolio', 'action'));
		return $html;
	}

	public function myPortfolioSave(Request $request)
	{
		if ($request->id)
			$userPortfolio = User2portfolio::find($request->id);
		else
			$userPortfolio = new User2portfolio();

		$userPortfolio->Title = $request->Title;
		$userPortfolio->User2Id = Auth::guard('user2')->user()->id;
		$userPortfolio->Description = $request->Description;
		if ($request->Photo)
			$userPortfolio->Photo = $request->Photo;
		$success = $userPortfolio->save();
		$message = $success ? '実績が追加されました。' : 'エラーが発生しました。再度お試しください。';
		echo json_encode(array('success' => $success, 'message' => $message));
		exit();
	}

	public function myProfileCoverUpload(Request $request)
	{
		$user=User2::find(Auth::guard('user2')->user()->id);
		// Remove old cover
		if (file_exists(public_path() . $user->Cover))
		{
			@unlink(public_path() . $user->Cover);
		}
		$user->Cover=$request->Cover;
		$user->save();
		return('success');
	}
	public function myProfileEditUpload(Request $request,User2 $user2)
	{
		$upload_path_tmp = public_path() . "/images/avatars/tmp/";
		$upload_path = public_path() . "/images/avatars/";
		$upload_path_url = url('/') . "/images/avatars/";
		$upload_path_tmp_url = url('/') . "/images/avatars/tmp/";
		$up="/images/avatars/";

		$thumb_width = "130";
		$large_width = '300';

		if (isset($_POST["upload_thumbnail"])) {

			$filename = $_POST['filename'];
			// 			if(file_exists($filename))
			// 			{
			// 				copy($filename, $upload_path_tmp . basename($filename));
				// 				$filename = basename($filename);
				// 			}
				/*if (!file_exists($upload_path_tmp.$filename))
				{
				// In this case file original moved to real folder
				$upload_path_tmp = $upload_path;
				}*/

				$large_image_location = $upload_path_tmp.$filename;
				$x1 = $_POST["x1"];
				$y1 = $_POST["y1"];
				$x2 = $_POST["x2"];
				$y2 = $_POST["y2"];
				$w = $_POST["w"];
				$h = $_POST["h"];


				$scale = $large_width/$w;
				$un=uniqid();
				$thumb_image_location = $upload_path.$un.$filename;
				$image_url = $upload_path_tmp.$un.$filename;
				$cropped = $this->resizeThumbnailImage($upload_path, $thumb_image_location, $large_image_location,$w,$h,$x1,$y1,$scale);
				$user=User2::find(Auth::guard('user2')->user()->id);
				
				// Remove old avatar
				if (file_exists(public_path() . $user->Logo))
				{
					@unlink(public_path() . $user->Logo);
				}
				
				$user->Logo = $up.$un.$filename;
				$user->save();
				echo json_encode(array('file_orig'=> $upload_path_tmp_url . $filename, 'file_thumb' => $image_url, 'file_name' => $un.$filename, 'file_thumb_path' => $up.$un.$filename));
				exit();
			}
		}

		function resizeThumbnailImage($upload_path, $thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale){
			list($imagewidth, $imageheight, $imageType) = getimagesize($image);
			$imageType = image_type_to_mime_type($imageType);

			$newImageWidth = ceil($width * $scale);
			$newImageHeight = ceil($height * $scale);
			$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
			switch($imageType) {
				case "image/gif":
					$source=imagecreatefromgif($image);
					break;
				case "image/pjpeg":
				case "image/jpeg":
				case "image/jpg":
					$source=imagecreatefromjpeg($image);
					break;
				case "image/png":
				case "image/x-png":
					$source=imagecreatefrompng($image);
					break;
			}
			imagecopyresampled($newImage,$source,0,0,$start_width,$start_height,$newImageWidth,$newImageHeight,$width,$height);
			switch($imageType) {
				case "image/gif":
					imagegif($newImage,$thumb_image_name);
					break;
				case "image/pjpeg":
				case "image/jpeg":
				case "image/jpg":
					imagejpeg($newImage,$thumb_image_name, IMAGE_JPG_QUALITY);
					break;
				case "image/png":
				case "image/x-png":
					imagepng($newImage,$thumb_image_name, IMAGE_PNG_QUALITY);
					break;
			}

			chmod($thumb_image_name, 0777);
			return $thumb_image_name;

			$real_thumb_image = $upload_path . basename($thumb_image_name);
			$real_image = $upload_path . basename($image);

			rename($thumb_image_name, $real_thumb_image);

			chmod($real_thumb_image, 0777);
			return $real_thumb_image;
		}

		private function getGroupedReviews($request)
		{
			$user2ID = Auth::guard('user2')->user()->id;
			$reviewList= new \App\Userreview();
			$groupedReviews = array();
			$allReviewsTmp = $reviewList->where('user2ID', $user2ID)->orderBy('created_at', 'DESC')->get();
			$allReviews = array();
			foreach ($allReviewsTmp as &$review)
			{
				$slots_data=\App\Bookedspaceslot::where('BookedID', $review['booking']['id'])->orderBy('StartDate','asc')->get();
				if (count($slots_data))
				{
					$review['booking']['slotID'] = $slots_data;
					$allReviews[] = $review;
				}
			}

			$waitingReviews = Rentbookingsave::select('rentbookingsaves.*')->join('user1sharespaces', 'rentbookingsaves.user1sharespaces_id', '=' ,'user1sharespaces.id')
			->where('rentbookingsaves.status', BOOKING_STATUS_COMPLETED)->orderBy('rentbookingsaves.created_at', 'DESC')
			->where('rentbookingsaves.user_id', $user2ID)
// 			->whereRaw(DB::raw('rentbookingsaves.id NOT IN (SELECT BookingID From userreviews WHERE User2ID = ' . $user2ID . ' AND ReviewedBy = "User2")'))
			->get();

			foreach ($waitingReviews as $waitingReview)
			{
				$isWaiting = true;
				foreach ($allReviews as $review)
				{
					if ($waitingReview['id'] == $review['BookingID'])
					{
						$isWaiting = false;
						break;
					}
				}
				if ($isWaiting)
				{
					$slots_id=explode(';', $waitingReview['spaceslots_id']);
					$slots_data=\App\Bookedspaceslot::whereIn('SlotID', array_filter(array_unique($slots_id)))->orderBy('StartDate','asc')->get();
					$waitingReview['slotID'] = $slots_data;
					$waitingReview['reviewed'] = 0;
					$groupedReviews['1_waiting_owner'][] = $waitingReview;
					$groupedReviews['0_all'][] = $waitingReview;
				}
			}

			foreach ($allReviews as $review)
			{
				if ($review['ReviewedBy'] == 'User2')
				{
					if ($review['Status'] == 0)
					{
						$groupedReviews['3_waiting_partner'][] = $review;
						$waitingReview['reviewed'] = 1;
					}
					$groupedReviews['2_posted_owner'][] = $review;
				}
				elseif ($review['ReviewedBy'] == 'User1')
				{
					if ($review['Status'] == 0)
					{
						$groupedReviews['1_waiting_owner'][] = $review;
					}
					$groupedReviews['4_posted_partner'][] = $review;
				}
					 
				if ($review['ReviewedBy'] == 'User1' || ($review['ReviewedBy'] == 'User2' && $review['Status'] == 0))
				{
					$groupedReviews['0_all'][] = $review;;
				}
			}

			ksort($groupedReviews);
			if (isset($groupedReviews['1_waiting_owner']))
			{
// 				$groupedReviews['1_waiting_owner'] = msort($groupedReviews['1_waiting_owner'], array('reviewed'));
			}	
			
			return $groupedReviews;
		}
		public function review(Request $request)
		{
			$groupedReviews = $this->getGroupedReviews($request);
			return view('user2.dashboard.review-rentuser',compact('groupedReviews'));
		}

		public function writeReview($bookingID, Request $request)
		{
			$user2ID = Auth::guard('user2')->user()->id;
			$error = Session::has('error') ? Session::get('error') : '';
			$success = Session::has('success') ? Session::get('success') : '';
			$booking = Rentbookingsave::where('id', $bookingID)->where('status', BOOKING_STATUS_COMPLETED)->where('user_id', $user2ID)->first();

			if (!$error)
			{
				if ($booking)
				{
					$space = $booking->spaceID;
					$user1ID = $space->User1ID;
					// Validate User2 can write review for User id or not
					$isAllow = Userreview::isAllowUser2WriteReviewToUser1($bookingID, $user1ID, $user2ID);
					if (!$isAllow)
					{
						// If not validated, go to 404 page
						$error = trans('reviews.review_already_left_or_permission');
					}
				}
				else {
					$error = trans('reviews.review_booking_not_exists');
				}
			}

			return view('user2.dashboard.write-review-rentuser', compact('error', 'success', 'space'));
		}
		public function reviewSave($bookingID, Request $request)
		{
// 			if (!$request->Comment) {
// 				Session::flash('submitFailed', trans('reviews.review_empty_comment'));
// 				return redirect('RentUser/Dashboard/Review/Write/'.$bookingID);
// 			}

			$user2ID = Auth::guard('user2')->user()->id;
			$booking = Rentbookingsave::where('id', $bookingID)->where('status', BOOKING_STATUS_COMPLETED)->where('user_id', $user2ID)->first();
			if ($booking)
			{
				$user1ID = $booking->spaceID->User1ID;
				// Validate User2 can write review for User id or not
				$isAllow = Userreview::isAllowUser2WriteReviewToUser1($bookingID, $user1ID, $user2ID);
				if (!$isAllow)
				{
					// If not validated, go to 404 page
					Session::flash('error', trans('reviews.review_already_left_or_permission'));
					return redirect('RentUser/Dashboard/Review/Write/'.$bookingID);
				}

				$avgRating = round((($request->Cleaniness)/1) * 2) / 2;
				$request->merge(array('User1ID' => $user1ID));
				$request->merge(array('User2ID' => $user2ID));
				$request->merge(array('SpaceID' => $booking->user1sharespaces_id));
				$request->merge(array('BookingID' => $bookingID));
				$request->merge(array('ReviewedBy' => 'User2'));
				$request->merge(array('AverageRating' => $avgRating ));
				$request->merge(array('Status' => REVIEW_STATUS_AWAITING ));
				$review= new \App\Userreview();
				$review->fill($request->except(['_token']));
				if ($review->save())
				{
					// delete old notification if exists
					Notification::where('Type', NOTIFICATION_REVIEW_BOOKING)
					->where('TypeID', $bookingID)
					->where('UserReceiveID', $user1ID)
					->where('UserReceiveType', 1)
					->where('UserSendID', $user2ID)
					->where('UserSendType', 2) -> delete();

					// Save notification
					$notification = new Notification();
					$notification->Type = NOTIFICATION_REVIEW_BOOKING;
					$notification->TypeID = $bookingID;
					$notification->UserReceiveID = $user1ID;
					$notification->UserReceiveType = 1;
					$notification->UserSendID = $user2ID;
					$notification->UserSendType = 2;
					$notification->Status = 0;
					$notification->Time = date('Y-m-d H:i:s');
					$notification->save();

					// Check and update status of reviews : awaiting or completed
					$status = Userreview::updateStatusBookingReview($bookingID, $booking->user1sharespaces_id, $user1ID, $user2ID);
				}
				Session::flash('success', trans('reviews.review_left_feedback_successfully'));
				return redirect('RentUser/Dashboard');
			}
			else {
				Session::flash('error', trans('reviews.review_booking_not_exists'));
				return redirect('RentUser/Dashboard');
			}
		}

		public function addFavoriteSpace($spaceID, Request $request)
		{
			$user2ID = Auth::guard('user2')->user()->id;
			$favorite = \App\Favorite::where('SpaceId', $spaceID)->where('User2Id', $user2ID)->first();
			$success = false;

			if (!$favorite && $request->action == 'add')
			{
				// Save here
				$favorite = new \App\Favorite;
				$favorite->HashID = uniqid();
				$favorite->User2ID = $user2ID;
				$favorite->SpaceId = $spaceID;
				$success = $favorite->save();
					
					
				// delete old notification if exists
				Notification::where('Type', NOTIFICATION_FAVORITE_SPACE)
				->where('TypeID', $favorite->id)
				->where('UserReceiveID', $favorite->space->shareUser->id)
				->where('UserReceiveType', 1)
				->where('UserSendID', $user2ID)
				->where('UserSendType', 2) -> delete();
					
				$notification = new Notification();
				$notification->Type = NOTIFICATION_FAVORITE_SPACE;
				$notification->TypeID = $favorite->id;
				$notification->UserReceiveID =  $favorite->space->shareUser->id;
				$notification->UserReceiveType = 1;
				$notification->UserSendID = $user2ID;
				$notification->UserSendType = 2;
				$notification->Status = 0;
				$notification->Time = date('Y-m-d H:i:s');
				$notification->save();
			}
			elseif ($favorite && $request->action == 'remove') {
				// delete
				$success = $favorite->delete();
			}

			if ($request->ajax())
			{
				$count = \App\Favorite::where('SpaceId', $spaceID)->get()->count();
				$response = array('success' => $success, 'count' => $count);
				echo json_encode($response); die;
			}
			else {
				return redirect('/ShareUser/ShareInfo/View/'.$spaceID);
			}
		}

		public function viewShareSpaceBooking()
		{
			$user=User2::where('id', Auth::guard('user2')->user()->id)->first();
			$space=$_GET['space'];
			$FeeType=$_GET['FeeType'];
			$from='';
			$to='';
			$fee='';
			$all_slots='0';
			$space_id='0';

			$space1=explode(';',$space);

			if(is_array($space1) && $space1[0]!=''):
			$space1=$space1;
			else:
			$space1[0]=$space;
			endif;

			if(isset($_GET['from'])):
			$from=$_GET['from'];
			endif;

			if(isset($_GET['to'])):
			$to=$_GET['to'];
			endif;

			if(isset($_GET['fee'])):
			$fee=$_GET['fee'];
			endif;

			if(isset($_GET['all_slots'])):
			$all_slots=$_GET['all_slots'];
			 
			endif;

			if(isset($_GET['space_id'])):
			$space_id=$_GET['space_id'];
			endif;

			return view('public.process-booking',compact('space1','FeeType','from','to','fee','space_id','all_slots','user'));
		}

		public function reservation(Request $request)
		{
			$user=User2::where('id', Auth::guard('user2')->user()->id)->first();
			$rent_datas = Rentbookingsave::select('rentbookingsaves.*')
				->where('rentbookingsaves.user_id', $user->id)
				->where('rentbookingsaves.InvoiceID', '<>', '')
				->joinSpace()
				->orderBy('rentbookingsaves.id','desc')
				->groupBy(array('rentbookingsaves.id'));

			switch ($request->status)
			{
				case BOOKING_STATUS_PENDING :
				case BOOKING_STATUS_COMPLETED :
					$rent_datas = $rent_datas->where('rentbookingsaves.status', $request->status);
					break;
				case BOOKING_STATUS_REFUNDED :
					$rent_datas = $rent_datas->whereIn('rentbookingsaves.status', array(BOOKING_STATUS_REFUNDED, BOOKING_STATUS_CALCELLED));
					break;
				case BOOKING_STATUS_RESERVED :
					$rent_datas = $rent_datas->where('rentbookingsaves.status', $request->status)->where('in_use', 0);
					break;
				case BOOKING_STATUS_INUSE:
					$rent_datas = $rent_datas->where('rentbookingsaves.status', BOOKING_STATUS_RESERVED)->where('in_use', BOOKING_IN_USE);
					break;
				case 'all' :
				default :
					$rent_datas = $rent_datas->where('rentbookingsaves.status','!=', BOOKING_STATUS_DRAFT);
					break;

			}

			if ($request->filter_month)
			{
				$rent_datas = $rent_datas->where('rentbookingsaves.created_at','>=', $request->filter_month . '-01')->where('rentbookingsaves.created_at','<=', $request->filter_month . '-31');
			}

			$rent_datas= $rent_datas->paginate(LIMIT_BOOKING);
			$rent_datas->appends($request->except(['page']))->links();

			$allDatas = Rentbookingsave::select('rentbookingsaves.*')
				->where('rentbookingsaves.InvoiceID', '<>', '')
				->where('rentbookingsaves.user_id', $user->id)
				->joinSpace()
				->groupBy(array('rentbookingsaves.id'))
				->where('rentbookingsaves.status','!=', BOOKING_STATUS_DRAFT);
			
			$allAvailDatas = clone $allDatas;
			if ($request->filter_month)
			{
				$allAvailDatas = $allAvailDatas->where('rentbookingsaves.created_at','>=', $request->filter_month . '-01')->where('rentbookingsaves.created_at','<=', $request->filter_month . '-31');
			}

			$allDatas = $allDatas->get();
			$allAvailDatas = $allAvailDatas->get();

			//Filter by status
			$rent_data_status = array();
			$rent_data_month = array();

			foreach ($allAvailDatas as $rent_data)
			{
				$status = ($rent_data->status == BOOKING_STATUS_RESERVED && $rent_data->in_use == BOOKING_IN_USE) ? BOOKING_STATUS_INUSE : $rent_data->status;
				$status = $status == BOOKING_STATUS_CALCELLED ? BOOKING_STATUS_REFUNDED : $status;
				$rent_data_status[$status][] = $rent_data;
			}
			foreach ($allDatas as $rent_data)
			{
				$month = date('Y-m', strtotime($rent_data->created_at));
				$rent_data_month[$month] = $month;
			}

			return view('user2.dashboard.reservation-rentuser',compact('user','rent_datas', 'rent_data_status', 'allDatas', 'allAvailDatas', 'rent_data_month'));
		}
		public function reservationView($id)
		{
			$rent_data=Rentbookingsave::Where('user_id', Auth::guard('user2')->user()->id)->where('id',$id)->first();
			$rentBooking = new Rentbookingsave();
			
			if(empty($rent_data)):
				return redirectToDashBoard();
			endif;
			$user1Id = $rent_data->User1ID;
			$user1Obj = User1::where('id',$user1Id)->first();

			$rent_data->isArchive = true;
			$aFlexiblePrice = getFlexiblePrice($rent_data, new \App\Bookedspaceslot());
			$refundamount = priceConvert(ceil($rent_data['refund_amount']));

			$subTotal = priceConvert($aFlexiblePrice['subTotal'], true);
			$subTotalIncludeTax = priceConvert($aFlexiblePrice['subTotalIncludeTax'], true);
			$subTotalIncludeChargeFee = priceConvert($aFlexiblePrice['subTotalIncludeChargeFee'], true);
			$totalPrice = priceConvert($aFlexiblePrice['totalPrice'], true);
			$prices = $aFlexiblePrice['prices'];

			if ($rent_data->recur_id && in_array($rent_data->status, array(BOOKING_STATUS_RESERVED, BOOKING_STATUS_PENDING)))
			{
				$rentBooking->storeRecursionHistory(array($rent_data));
			}
			
			return view('user2.dashboard.reservation-view-rentuser',compact('rent_data', 'prices', 'subTotal', 'subTotalIncludeTax', 'subTotalIncludeChargeFee', 'totalPrice','user1Obj','refundamount'));
		}
		
		public function reservationViewTest($id)
		{
			$rent_data=Rentbookingsave::Where('user_id', Auth::guard('user2')->user()->id)->where('id',$id)->first();
			$rentBooking = new Rentbookingsave();
			
			if(empty($rent_data)):
				return redirectToDashBoard();
			endif;
			$user1Id = $rent_data->User1ID;
			$user1Obj = User1::where('id',$user1Id)->first();

			$rent_data->isArchive = true;
			$aFlexiblePrice = getFlexiblePrice($rent_data, new \App\Bookedspaceslot());
			//return($rent_data);
			$refundamount = priceConvert(ceil($rent_data['refund_amount']));

			$subTotal = priceConvert($aFlexiblePrice['subTotal'], true);
			$subTotalIncludeTax = priceConvert($aFlexiblePrice['subTotalIncludeTax'], true);
			$subTotalIncludeChargeFee = priceConvert($aFlexiblePrice['subTotalIncludeChargeFee'], true);
			$totalPrice = priceConvert($aFlexiblePrice['totalPrice'], true);
			$prices = $aFlexiblePrice['prices'];

			if ($rent_data->recur_id && in_array($rent_data->status, array(BOOKING_STATUS_RESERVED, BOOKING_STATUS_PENDING)))
			{
				$rentBooking->storeRecursionHistory(array($rent_data));
			}
			
			return view('user2.dashboard.reservation-view-rentuser',compact('rent_data', 'prices', 'subTotal', 'subTotalIncludeTax', 'subTotalIncludeChargeFee', 'totalPrice','user1Obj','refundamount'));
		}

		public function getajaxhour(Request $request){
			$aBookingTimeInfoSelected = Spaceslot::getBookingTimeInfo($request);
			$space = User1sharespace::find($request->spaceID);
			if (isset($aBookingTimeInfoSelected['bookedIDs']) && $request->step == 2)
			{
				$aSlotIds = $aBookingTimeInfoSelected['bookedIDs'];
				$aTimeDefault = $aBookingTimeInfoSelected['timeDefaultSelected'];
				$rent_data = Rentbookingsave::where('id', Session::get('rent_id'))->first();
				$rent_data->spaceslots_id = implode(';', $aSlotIds);
				$slots_data = Spaceslot::getBookingSlots($rent_data);
				$aBookedDate = $slots_data[0];
					
				if (isDaylySpace($space))
				{
					$aTimeDefault['StartTime'] = @$slots_data[0]->StartTime;
					$aTimeDefault['EndTime'] = @$slots_data[0]->EndTime;
				}
				
				$rent_data->hourly_date = $aBookedDate['StartDate'];
				$rent_data->hourly_time = $aTimeDefault['StartTime'].' - '.$aTimeDefault['EndTime'];
				$rent_data->month_start_date = $aBookedDate['StartDate'];
				$rent_data->charge_start_date = $aBookedDate['StartDate'] . ' ' . $aTimeDefault['StartTime'];
				$rent_data->charge_end_date = @$slots_data[count($slots_data) - 1]['EndDate'] . ' ' . $aTimeDefault['EndTime'];
				$rent_data->save();

				// Save duration
				$duration = getSpaceSlotDuration($slots_data, false, $rent_data);
				$durationText = getSpaceSlotDuration($slots_data, true, $rent_data);
				$usedDate = getBookingSlotDate($slots_data, false, $rent_data);
				$rent_data->UsedDate = $usedDate;
				$rent_data->Duration = $duration;
				$rent_data->DurationText = $durationText;
				$rent_data->save();
				
				$aFlexiblePrice = getFlexiblePrice($rent_data, new Spaceslot());
					
				$subTotal = priceConvert($aFlexiblePrice['subTotal'], true);
				$subTotalIncludeTax = priceConvert($aFlexiblePrice['subTotalIncludeTax'], true);
				$subTotalIncludeChargeFee = priceConvert($aFlexiblePrice['subTotalIncludeChargeFee'], true);
				$totalPrice = priceConvert($aFlexiblePrice['totalPrice'], true);
				$prices = $aFlexiblePrice['prices'];
				$aBookingTimeInfoSelected['summary'] =  View::make('public.booking-step2-summary',compact(
						'rent_data',
						'aSlotIds',
						'aBookingTimeInfoSelected',
						'space',
						'prices',
						'subTotal',
						'subTotalIncludeTax',
						'subTotalIncludeChargeFee',
						'totalPrice'))->__tostring();
					
			}
			return response()->json($aBookingTimeInfoSelected);
		}

		private function getBookingAvailableSlotIds($space, $input){
			$isCoreWorkingOrOpenDesk = isCoreWorkingOrOpenDesk($space);
			$oTimeNow = calculateSpaceLastBooking($space);
			$startDateAvailable = $oTimeNow->format('Y-m-d');
			$startTimeAvailable = $oTimeNow->format('H:00:00');
			$isAllowBooking  =true;
			$slotIds = array();
			
			if ($space->FeeType==1)
			{
				$dateStart = date('Y-m-d', strtotime(trim($input['booked_date'])));
				$timeStart = date('H:00:00', strtotime(trim($input['startTime'])));
				$timeEnd = date('H:00:00', strtotime(trim($input['endTime'])));

				// Find slot by space
				$aAvailSlot = SpaceSlot::where('StartDate', $dateStart)
				->where('SpaceID', $space->id)
				->where('ParentID', 0)
				->where('Status', SLOT_STATUS_AVAILABLE)
				->where('Type', getSpaceSlotType($space))
				->where('StartDate', '>=', $startDateAvailable)
				->orderBy('StartDate', 'ASC')
				->orderBy('StartTime', 'ASC') ;

				$aAvailSlot = $aAvailSlot->where(function ($query) use($startDateAvailable, $startTimeAvailable){
					$query->where('StartDate', '>=', $startDateAvailable);
					$query = $query->orWhere(function ($query) use ($startDateAvailable, $startTimeAvailable){
						$query->where('StartDate', '=', $startDateAvailable);
						$query->where('StartTime', '>=', $startTimeAvailable);
					});

				});
				$aAvailSlot = $aAvailSlot->get();


				if (count($aAvailSlot))
				{
					$isAllowBooking = false;
					foreach ( $aAvailSlot as $availSlot )
					{
						if ($timeStart >= $availSlot['StartTime'] && $timeEnd <= $availSlot['EndTime'])
						{
							$slotIds[] = $availSlot['id'];
						}

						// Check the time added is acceptable or not
						if (!($timeStart >= $availSlot['StartTime'] && $timeEnd <= $availSlot['EndTime']) || $timeStart >= $timeEnd)
							continue;

						$isAllowBooking = true;
					}
				}
				if ($isCoreWorkingOrOpenDesk)
				{
					$aFulledRange = \App\Spaceslot::getBookedHourSlots($space, $dateStart, true);
					if (count($aFulledRange))
					{
						$BookSlot = array('StartDate' => $dateStart, 'EndDate' => $dateStart, 'StartTime' => $timeStart, 'EndTime' => $timeEnd);
						foreach ($aFulledRange as $fulledRange)
						{
							if (is2TimeRangeOverlap($BookSlot, $fulledRange)) {
								$isAllowBooking = false;
							}
						}
					}
					else {
						$isAllowBooking = true;
					}
				}

				if (!$isAllowBooking)
				{
					return redirect(getSpaceUrl($space->HashID))
					->withErrors(trans('common.booking_time_not_available'))
					->withInput();
				}
			}
			else {
				$slotIds = explode(';', $input['spaceslots_id']);

				// Check Slots is ok or not
				$capacity = $isCoreWorkingOrOpenDesk ? $space->Capacity : 1;
				$aAvailableSlots = Spaceslot::where('Status', SLOT_STATUS_AVAILABLE)
				->where('SpaceID', $space->id)
				->where('ParentID', 0)
				->where('Type', getSpaceSlotType($space))
				->where('total_booked', '<', $capacity)
				->where('EndDate', '>=', date('Y-m-d'))
				->where('StartDate', '>=', $startDateAvailable)
				->whereIn('id', $slotIds)
				->orderBy('StartDate', 'ASC');
				$aAvailableSlots = $aAvailableSlots->get();

				if (count($aAvailableSlots) <= 0 || (count($slotIds) && count($aAvailableSlots)  != count($slotIds)))
					return redirect(getSpaceUrl($space->HashID))
					->withErrors(trans('common.booking_time_not_available'))
					->withInput();

			}

			return $slotIds;
		}

		public function cardTransaction(Request $request){
			$input=$request->all();
			$isAllowBooking  =true;

			$user=User2::find(Auth::guard('user2')->user()->id);
			$space = User1sharespace::find($request->spaceID);

			if ($user->IsAdminApproved == 'No')
			{
				Session::flash('error', trans('common.user2_not_allow_to_booking'));
				return redirect(getSpaceUrl($space->HashID));
			}
			
			if (!User2::isPaymentSetup($user))
			{
				Session::flash('error', trans('common.missing_payment_setup'));
				return redirect(getSpaceUrl($space->HashID));
			}

			$Rentbookingsave=new Rentbookingsave();

			// Get Slots ids
			$slotIds = $this->getBookingAvailableSlotIds($space, $input);
			if (is_a($slotIds, 'Illuminate\Http\RedirectResponse'))
				return $slotIds;

			$aBookedDate = explode(';', $input['booked_date']);
			$request->merge(array('user_id' => Auth::guard('user2')->user()->id));
			$request->merge(array('spaceslots_id' => implode(';', $slotIds) ));
			$request->merge(array('user1sharespaces_id' => $input['spaceID'] ));
			$request->merge(array('hourly_date' => $aBookedDate[0] ));
			$request->merge(array('hourly_time' => isset($input['startTime']) ? ($input['startTime'].' - '.$input['endTime']) : '' ));

			$request->merge(array('status' => BOOKING_STATUS_DRAFT));
			$Rentbookingsave->fill($request->except(['_token']));
			$Rentbookingsave->User1ID = $space->User1ID;
			$Rentbookingsave->SpaceType = $space->FeeType;

			// add some data
			$slots_data=Spaceslot::whereIn('id', $slotIds)->orderBy('StartDate','asc')->get();
			$duration = getSpaceSlotDuration($slots_data, false, $Rentbookingsave);
			$durationText = getSpaceSlotDuration($slots_data, true, $Rentbookingsave);
			$usedDate = getBookingSlotDate($slots_data, false, $Rentbookingsave);

			if (isDaylySpace($space))
			{
				$input['startTime'] = @$slots_data[0]->StartTime;
				$input['endTime'] = @$slots_data[0]->EndTime;
			}
			
			$Rentbookingsave->UsedDate = $usedDate;
			$Rentbookingsave->Duration = $duration;
			$Rentbookingsave->DurationText = $durationText;
			$Rentbookingsave->charge_start_date = @$slots_data[0]->StartDate . ' ' . @$input['startTime'];
			$Rentbookingsave->charge_end_date = @$slots_data[count($slots_data) - 1]->EndDate . ' ' . @$input['endTime'];
			
			$Rentbookingsave->save();
			Session::put('rent_id', $Rentbookingsave->id);

			Session::flash('success', 'You have successfully selected date.');
			return redirect('ShareUser/Dashboard/BookingDetails');
		}

		public function bookingDetails(Request $request)
		{
			if(!Session::get('rent_id')):
				Session::flash('error', 'common.Your Session is expired, please try again.');
				return redirectToDashBoard();
			endif;

			$rent_data=Rentbookingsave::Where('id', Session::get('rent_id'))->first();
			$space = $rent_data->spaceID;
			$aFlexiblePrice = getFlexiblePrice($rent_data, new Spaceslot());

			$subTotal = priceConvert($aFlexiblePrice['subTotal'], true);
			$subTotalIncludeTax = priceConvert($aFlexiblePrice['subTotalIncludeTax'], true);
			$subTotalIncludeChargeFee = priceConvert($aFlexiblePrice['subTotalIncludeChargeFee'], true);
			$totalPrice = priceConvert($aFlexiblePrice['totalPrice'], true);
			$prices = $aFlexiblePrice['prices'];

			// Get Booking information
			$aBookingTimeInfoSelected = array();
			$slots_data = Spaceslot::getBookingSlots($rent_data);

			if (!count($slots_data))
			{
				Session::flash('error', 'common.booking_time_not_available');
				return redirectToDashBoard();
			}

			$aVailableSlots = Spaceslot::getAvailableSpaceSlot($space);

			if (!$space || !count($aVailableSlots))
			{
				Session::flash('error', trans('common.space_not_existed'));
					return redirectToDashBoard();

			}

			$aSlotIds = array();
			$booked_date = array();
			foreach ($slots_data as $slot)
			{
				$aSlotIds[] = $slot->id;
				$booked_date[$slot->StartDate] = $slot->StartDate;
			}

			$bookedTime = explode('-', $rent_data->hourly_time);

			$request->merge(array('spaceID' => $space->id));
			$request->merge(array('spaceslots_id' => implode(';', $aSlotIds)));
			$request->merge(array('booked_date' => implode(';', $booked_date)));
			$request->merge(array('startTime' => isset($bookedTime[0]) ? $bookedTime[0] : ''));
			$request->merge(array('endTime' => isset($bookedTime[1]) ? $bookedTime[1] : ''));
			$aBookingTimeInfoSelected = Spaceslot::getBookingTimeInfo($request);

			if ($aBookingTimeInfoSelected === false)
			{
				Session::flash('error', trans('common.space_not_existed'));
				return redirectToDashBoard();
			}
				
			// Get available Date to fill out Calendar
			$aAvailableDate = array();
			foreach ($aVailableSlots as $aVailableSlot)
			{
				if (in_array($aVailableSlot['StartDate'], array_keys($aAvailableDate))) continue;
				
				$request->merge(array('spaceID' => $space->id));
				$request->merge(array('spaceslots_id' => ''));
				$request->merge(array('booked_date' => $aVailableSlot['StartDate']));
				$request->merge(array('startTime' => ''));
				$request->merge(array('endTime' => ''));
				$aBookingTimeInfo = Spaceslot::getBookingTimeInfo($request);
					
				if ($aBookingTimeInfo === false) return redirectToDashBoard();
				if (count(@$aBookingTimeInfo['timeDefaultSelected']))
				{
					if (!isset($aBookingTimeInfo['timeDefaultSelected']['StartDate'])) continue;
					$aAvailableDate[$aBookingTimeInfo['timeDefaultSelected']['StartDate']] = $aBookingTimeInfo['timeDefaultSelected'];
					if ($space->FeeType != SPACE_FEE_TYPE_HOURLY) break;
				}
			}
			
			return view('public.booking-step2',compact(
					'rent_data',
					'space',
					'prices',
					'subTotal',
					'aSlotIds',
					'aAvailableDate',
					'aBookingTimeInfoSelected',
					'subTotalIncludeTax',
					'subTotalIncludeChargeFee',
					'totalPrice'));
		}

		public function bookingSummary(Request $request)
		{
			if(!Session::get('rent_id')):
				Session::flash('error', 'common.Your Session is expired, please try again.');
				return redirectToDashBoard();
			endif;

			$input=$request->all();
			$rent_data=Rentbookingsave::Where('id', Session::get('rent_id'))->first();
			$space = $rent_data->spaceID;

			$user=User2::find(Auth::guard('user2')->user()->id);

			if($input):
			$aBookedDate = explode(';', $input['booked_date']);
			// Get Slots ids
			$aSlotIds = $this->getBookingAvailableSlotIds($space, $input);
			if (is_a($aSlotIds, 'Illuminate\Http\RedirectResponse'))
				return $aSlotIds;

			$rent_data_save = Rentbookingsave::where('id', Session::get('rent_id'))->first();
			if (!$rent_data_save)
			{
				return redirect(getSpaceUrl($space->HashID))
				->withErrors(trans('common.Your session is expired'))
				->withInput();
			}
				
			// Save slot first
			$rent_data_save->spaceslots_id = implode(';', $aSlotIds);
			$rent_data_save->hourly_date = $aBookedDate[0];
			$rent_data_save->hourly_time = trim(isset($input['startTime']) ? ($input['startTime'].' - '.$input['endTime']) : '' );
			$rent_data_save->save();
			// Get new slot data
			$slots_data = Spaceslot::getBookingSlots($rent_data);
				
			$aFlexiblePrice = getFlexiblePrice($rent_data_save, new Spaceslot());
			$subTotal = getTotalSpaceSlotPrice($rent_data_save->spaceID, array(), $rent_data_save->hourly_time);
				
			if (isDaylySpace($space))
			{
				$input['startTime'] = @$slots_data[0]->StartTime;
				$input['endTime'] = @$slots_data[0]->EndTime;
			}
			
			$rent_data_save = Rentbookingsave::where('id', Session::get('rent_id'))->firstOrFail();
			$rent_data_save->charge_start_date = @$slots_data[0]->StartDate . ' ' . @$input['startTime'];
			$rent_data_save->charge_end_date = @$slots_data[count($slots_data) - 1]->EndDate . ' ' . @$input['endTime'];
			$rent_data_save->month_start_date = @$aBookedDate[0];
			$rent_data_save->SubTotal = $aFlexiblePrice['subTotal'];
			$rent_data_save->Tax = $aFlexiblePrice['subTotalIncludeTax'];
			$rent_data_save->ChargeFee = $aFlexiblePrice['subTotalIncludeChargeFee'];
			$rent_data_save->amount = $aFlexiblePrice['totalPrice'];
			$rent_data_save->request=$input['request'];
			$rent_data_save->total_persons=$input['total_persons'];
			$rent_data_save->save();
			endif;

			$aFlexiblePrice = getFlexiblePrice($rent_data, new Spaceslot());
			$subTotal = priceConvert($aFlexiblePrice['subTotal'], true);
			$subTotalIncludeTax = priceConvert($aFlexiblePrice['subTotalIncludeTax'], true);
			$subTotalIncludeChargeFee = priceConvert($aFlexiblePrice['subTotalIncludeChargeFee'], true);
			$totalPrice = priceConvert($aFlexiblePrice['totalPrice'], true);
			$prices = $aFlexiblePrice['prices'];
			$rent_data=Rentbookingsave::Where('id', Session::get('rent_id'))->first();

			return view('public.booking-step3',compact('rent_data','user', 'prices', 'subTotal', 'subTotalIncludeTax', 'subTotalIncludeChargeFee', 'totalPrice'));
		}

		public function bookingPayment(Request $request)
		{
			$rent_data=Rentbookingsave::Where('id', Session::get('rent_id'))->first();

			// Change the space price depending date.
			$aFlexiblePrice = getFlexiblePrice($rent_data, new Spaceslot());
			$user = User2::find(Auth::guard('user2')->user()->id);

			$input=$request->all();
			$pb = new Paypalbilling();

			// Get Slots ids
			// Get Slots ids to validate
			$aTimeStart = explode('-', $rent_data->hourly_time);
			$timeStart = date('H:00:00', strtotime(trim($aTimeStart[0])));
			$timeEnd = date('H:00:00', strtotime(trim(isset($aTimeStart[1]) ? $aTimeStart[1] : '')));
			
			$myRequest = new Request();
			$myRequest->merge(array('booked_date' => $rent_data->hourly_date));
			$myRequest->merge(array('startTime' => $timeStart));
			$myRequest->merge(array('endTime' => $timeEnd));
			$myRequest->merge(array('spaceslots_id' => $rent_data['spaceslots_id']));
			$aSlotIds = $this->getBookingAvailableSlotIds($rent_data->spaceID, $myRequest->all());
			
			if (is_a($aSlotIds, 'Illuminate\Http\RedirectResponse'))
				return $aSlotIds;
			
			$paypalStatus = $pb->getUserBillingStatus();
			$rent_data=Rentbookingsave::Where('id', Session::get('rent_id'))->first();


			if(!Session::get('rent_id')):
				Session::flash('error', 'common.Your Session is expired, please try again.');
				return redirectToDashBoard();
			endif;

			return view('public.booking-step4',compact('rent_data' , 'aFlexiblePrice' , 'paypalStatus'));

		}

		public function BookingCompleted()
		{
			if(!Session::get('rent_id')):
				Session::flash('error', 'common.Your Session is expired, please try again.');
				return redirectToDashBoard();
			endif;

			$user=User2::find(Auth::guard('user2')->user()->id);
			$rent_data=Rentbookingsave::Where('id', Session::get('rent_id'))->first();

			$aFlexiblePrice = getFlexiblePrice($rent_data, new Spaceslot());

			$subTotal = priceConvert($aFlexiblePrice['subTotal'], true);
			$subTotalIncludeTax = priceConvert($aFlexiblePrice['subTotalIncludeTax'], true);
			$subTotalIncludeChargeFee = priceConvert($aFlexiblePrice['subTotalIncludeChargeFee'], true);
			$totalPrice = priceConvert($aFlexiblePrice['totalPrice'], true);
			$prices = $aFlexiblePrice['prices'];

			$spaceslots=SpaceSlot::where('SpaceID', $rent_data['user1sharespaces_id'])->get();

			Session::forget('rent_id');
			return view('public.bookingcompleted',compact('rent_data', 'spaceslots','user', 'prices', 'subTotal', 'subTotalIncludeTax', 'subTotalIncludeChargeFee', 'totalPrice'));
		}

		private function createWebpayPayment($rent_data, $input) {
			$user = User2::find(Auth::guard('user2')->user()->id);
			
			if( strpos($input['PaymentProfileForEdit_CardNumber'], '*') !== false ){
				$input['PaymentProfileForEdit_CardNumber'] = $user['modifiededit_card_number'];
			}
			
			$webpay = new WebPay(WEPAY_SECRET_API_KEY);
			
			$expire=explode('/',$input['ExpiryDate']);
			
			if(!isset($expire[0]) && !isset($expire[1])) {
			
				return array('error' => 1, 'message' => '正しい有効期限を選択してください。');
			
			}
			$expire[1] = strlen($expire[1]) == 2 ? "20$expire[1]" : $expire[1];
			$expire_days = getPaymentExpireDays($rent_data['spaceID']);
			
			try {
				$rent_data_save = Rentbookingsave::where('id', Session::get('rent_id'))->firstOrFail();
				
				$token = $webpay->token->create(array(
						"card"=> array("number" => $input['PaymentProfileForEdit_CardNumber'],
								"exp_month" => $expire[0],
								"exp_year" => $expire[1],
								"cvc" => $input['PaymentProfileForEdit_CardCode'],
								"name" => $input['PaymentProfileForEdit_FullName'],)
				));
					
				if (isBookingRecursion($rent_data)) {
						
					$monthly_payment = $rent_data->amount / $rent_data->Duration;
					$info = $webpay->charge->create(array(
							"amount" => ceil($monthly_payment * BOOKING_MONTH_RECURSION_INITPAYMENT),
							"currency" => "jpy",
							"card" => $token->id,
							"description" => $rent_data['request'],
							"capture" => false,
							"expire_days" => $expire_days
					));
					$rent_data_save->transaction_id = $info->id;
					$rent_data_save->save();
						
					$token = $webpay->token->create(array(
							"card"=>
							array("number" => $input['PaymentProfileForEdit_CardNumber'],
									"exp_month" => $expire[0],
									"exp_year" => $expire[1],
									"cvc" => $input['PaymentProfileForEdit_CardCode'],
									"name" => $input['PaymentProfileForEdit_FullName'],)
					));
					$custom_info = $webpay->customer->create(array(
							"card" => $token->id,
							"description" => str_limit($rent_data->spaceID->Title, 70),
					));
				
					$oStartDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $rent_data->charge_start_date);
					// Next month will be charge by recursion
					$oStartDate->addMonths(2);
					
					$infoRecursion = $webpay->recursion->create(array(
							"amount" => ceil($monthly_payment),
							"currency" => "jpy",
							"card" => $token->id,
							"description" => str_limit($rent_data->spaceID->Title, 70),
							"capture" => false,
							"customer" => $custom_info->id,
							"period" => "month",
							"first_scheduled" => strtotime($oStartDate->format('Y-m-d')),
							"expire_days" => $expire_days
					));
						
					$rent_data_save->recur_id = $infoRecursion->id;
					$rent_data_save->save();
				
				}else{
					$info=$webpay->charge->create(array(
							"amount" => $rent_data->amount,
							"currency" => "jpy",
							"card" => $token->id,
							"description" => $rent_data['request'],
							"capture" => false,
							"expire_days" => $expire_days
					));
					$rent_data_save->transaction_id = $info->id;
					$rent_data_save->save();
				}
				
			}
			catch(\Exception $e)
			{
				// If error Occurred, delelete the transaction, Recursion
				$somethingWrong = $this->rollBackPaymentIfSomethingWrong(true);
				
				return array('error' => 1, 'message' => trans('common.Error Occurred during making payment ' . $e->getMessage()));
			}
		}
		
		private function setCheckoutExpress($rent_data, $userBilling)
		{
			$paypalModel = new Paypal;
			$paypalBilling = new Paypalbilling;
			$PayPal = $paypalModel->getRefrecePaypalClient();
				
			$monthly_payment = ceil($rent_data->amount / $rent_data->Duration);
			
			try {
				// Get checkout express token
				$SECFields = array(
						'RETURNURL' => action('User2Controller@doPaypalRecurring'),
						'CANCELURL' => action('User2Controller@bookingPayment'),
						'ALLOWNOTE' => 1,
						'LOCALECODE' => PAYPAL_LOCALE,
						'SKIPDETAILS' => 0,
						'CUSTOM' => '',
						'INVNUM' => '',
						'NOTIFYURL' => ''
				);
					
				$profile_description = trans('common.recurring_paypal_description', ['monthly_price' => priceConvert($monthly_payment, true)]);
				$Payments = array();
				$BillingAgreements = array();
				$BillingAgreements[] = array(
						'L_BILLINGTYPE' => 'RecurringPayments', // Required.  Type of billing agreement.  For recurring payments it must be RecurringPayments.  You can specify up to ten billing agreements.  For reference transactions, this field must be either:  MerchantInitiatedBilling, or MerchantInitiatedBillingSingleSource
						'L_BILLINGAGREEMENTDESCRIPTION' => $profile_description, // Required for recurring payments.  Description of goods or services associated with the billing agreement.
						'L_PAYMENTTYPE' => 'Any', // Specifies the type of PayPal payment you require for the billing agreement.  Any or IntantOnly
						'L_CUSTOM' => ''
				);
				$Payments[] = array('AMT' => $monthly_payment, 'CURRENCYCODE' => CURRENCYCODE);
				$PayPalRequest = array(
						'SECFields' => $SECFields,
						'BillingAgreements' => $BillingAgreements,
						'Payments' => $Payments
				);
					
				$SetExpressCheckoutResult = $PayPal->SetExpressCheckout($PayPalRequest);
				if ($SetExpressCheckoutResult['ACK'] == PAYPAL_RESPONSE_STATUS_SUCCESS)
				{
					$userBilling->token = $SetExpressCheckoutResult['TOKEN'];
					$userBilling->save();
					return redirect($SetExpressCheckoutResult['REDIRECTURL']);
				}
			}
			catch(\Exception $e)
			{
				return redirect(url('ShareUser/Dashboard/BookingPayment'))
					->withErrors(trans('common.Error occured, Please try again'))
					->withInput();
			}
		}
		
		private function paypalPaymentOneTime($rent_data)
		{
			$user = User2::find(Auth::guard('user2')->user()->id);
			$paypalModel = new Paypal;
			$PayPal = $paypalModel->getRefrecePaypalClient();
			$userBilling = Paypalbilling::where('userId', $user->id)->first();
			
			$custom = $rent_data->id . "|" . $rent_data->User1ID . "|" . $rent_data->user_id . "|" . getSpaceSlotType($rent_data->spaceID) . "|" . $rent_data->Duration;
			
			if (isBookingRecursion($rent_data))
				$amount = ceil(($rent_data->amount / $rent_data->Duration) * BOOKING_MONTH_RECURSION_INITPAYMENT);
			else
				$amount = $rent_data->amount;
			
			$PaymentDetails = array(
					'CURRENCYCODE' => CURRENCYCODE,
					'DESC' => str_limit($rent_data->spaceID->Title, 70),
					'INVNUM' => 'off-' . time(),
					'NOTIFYURL' => $paypalModel->notify_url,
					'custom' => $custom,
			);
			
			$DRTFields = array(
					'REFERENCEID' => $userBilling->billingId,
					'PAYMENTACTION' => 'Authorization',
					'AMT' => $amount
			);
			
			
			$PayPalRequestData = array(
					'DRTFields' => $DRTFields,
					'PaymentDetails' => $PaymentDetails,
			);
			
			$PayPalResult = $PayPal->DoReferenceTransaction($PayPalRequestData);
			
			if (isset($PayPalResult['ACK']) && $PayPalResult['ACK'] == PAYPAL_RESPONSE_STATUS_SUCCESS)
			{
				$rent_data->transaction_id = $PayPalResult['TRANSACTIONID'];
				$rent_data->save();
			}
			else{
				if ($rent_data->transaction_id)
				{
					$refundData['DVFields'] = array('AUTHORIZATIONID' => $rent_data->transaction_id);
					$response = $PayPal->DoVoid($refundData);
				}
					
				$message = (isset($PayPalResult["L_LONGMESSAGE0"])) ? $PayPalResult["L_LONGMESSAGE0"] : trans('common.Error occured, Please try again');
				
				return redirect(url('ShareUser/Dashboard/BookingPayment'))
				->withErrors($message)
				->withInput();
				
			}
			
			return $PayPalResult;
		}
		
		private function createPaypalPayment($rent_data, $input) {
			$user = Auth::guard('user2')->user();
			$paypalModel = new Paypal;
			$paypalBilling = new Paypalbilling;
			$PayPal = $paypalModel->getRefrecePaypalClient();
			
			$userBilling = Paypalbilling::where('userId', $user->id)->first();
			
			if (!$userBilling || !$userBilling->billingId) {
				return array('error' => 1, 'message' => trans('common.Please add paypal account info'));
			}
			
			try {
				$rent_data_save = Rentbookingsave::where('id', Session::get('rent_id'))->firstOrFail();
				
				if (isBookingRecursion($rent_data)) 
				{
					// Make Recursion for booking over 6 months
					$PayPalExpress = $userBilling->token ? $PayPal->GetExpressCheckoutDetails($userBilling->token) : array();
					if (count($PayPalExpress) && isset($PayPalExpress['ACK']) && $PayPalExpress['ACK'] == PAYPAL_RESPONSE_STATUS_SUCCESS && false)
					{
						return Redirect::action('User2Controller@doPaypalRecurring', array('token' => $userBilling->token));
					}
					else {
						// Set checkout express to get new token because it is expired
						$PayPalResult = $this->setCheckoutExpress($rent_data, $userBilling);
						if (is_a($PayPalResult, 'Illuminate\Http\RedirectResponse'))
							return $PayPalResult;
					}
				}
				else {
					// Do papal payment as normal way
					$PayPalResult = $this->paypalPaymentOneTime($rent_data);
					if (is_a($PayPalResult, 'Illuminate\Http\RedirectResponse'))
						return $PayPalResult;
				}
			}
			catch(\Exception $e)
			{
				return array('error' => 1, 'message' => $e->getMessage());
			}
		}
		
		public function doPaypalRecurring(Request $request) {
			$user = Auth::guard('user2')->user();
			$paypalModel = new Paypal;
			$paypalBilling = new Paypalbilling;
			$PayPal = $paypalModel->getRefrecePaypalClient();
			$userBilling = Paypalbilling::where('userId', $user->id)->first();
			
			$input = $request->all();
			$rent_data = Rentbookingsave::find(Session::get('rent_id'));
			
			if (!isset($input['token']) || !$input['token'])
			{
				return redirect(getSpaceUrl($rent_data->spaceID->HashID))
				->withErrors(trans('common.Has error when do payment via Paypal, Please try again'))
				->withInput();
			}
				
			
			$oStartDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $rent_data->charge_start_date)->setTimezone('UTC');
			// Next month will be charge by recursion
			$oStartDate->addMonths(1);
			$PROFILESTARTDATE = $oStartDate->format('Y-m-d').'T'.$oStartDate->format('H:i:s').'Z';
			
			$monthly_payment = ceil($rent_data->amount / $rent_data->Duration);
			$profile_description = trans('common.recurring_paypal_description', ['monthly_price' => priceConvert($monthly_payment, true)]);
			
			$CRPPFields = array(
					'TOKEN' => isset($input['token']) ? $input['token'] : '',
			);
			$invoice = "INVOICE".rand();
			
			$ProfileDetails = array(
					'PROFILESTARTDATE' => $PROFILESTARTDATE,//'2017-02-03T18:29:50Z'
					'PROFILEREFERENCE' => $invoice // The merchant's own unique invoice number or reference ID.  127 char max.
			);
			
			
			$ScheduleDetails = array(
					'DESC' => $profile_description,//
					'MAXFAILEDPAYMENTS' => 3, // The number of scheduled payment periods that can fail before the profile is automatically suspended.
					'AUTOBILLOUTAMT' => 'NoAutoBill'
			);
			
			$BillingPeriod = array(
					'BILLINGPERIOD' => 'Month',
					'BILLINGFREQUENCY' => 1,
					'TOTALBILLINGCYCLES' => $rent_data->Duration - BOOKING_MONTH_RECURSION_INITPAYMENT,
					'AMT' => $monthly_payment,
					'CURRENCYCODE' => CURRENCYCODE,
					'L_BILLINGAGREEMENTDESCRIPTION0' => $profile_description,
			);
			
			$ActivationDetails = array();//'initamt' => $f_amount
			$PayerInfo = array( 'EMAIL' => @$userBilling->emailId);
			$PayPalRequestData = array(
					'CRPPFields' => $CRPPFields,
					'ProfileDetails' => $ProfileDetails,
					'ScheduleDetails' => $ScheduleDetails,
					'BillingPeriod' => $BillingPeriod,
					'ActivationDetails' => $ActivationDetails,
					'PayerInfo' => $PayerInfo,
			);
			
			try{
				$responseData = $PayPal->CreateRecurringPaymentsProfile( $PayPalRequestData );
				if (isset($responseData['ACK']) && $responseData['ACK'] == PAYPAL_RESPONSE_STATUS_SUCCESS)
				{
					$rent_data->recur_id = $responseData['PROFILEID'];
					$rent_data->save();
					$rentbooking = new Rentbookingsave();
					$success = $rentbooking->storeRecursionHistory(array($rent_data));
					if ($success === true)
					{
						// Do initial payment
						$PayPalResult = $this->paypalPaymentOneTime($rent_data);
						if (is_a($PayPalResult, 'Illuminate\Http\RedirectResponse'))
							return $PayPalResult;
						
						return Redirect::action('User2Controller@creditPayment', array('payment_type' => 'paypal', 'save_booking' =>$userBilling->token));
					}
				}
				
				// Empty TOKEN ID if the token is expired
				$userBilling->token = '';
				$userBilling->save();
				
				if ($rent_data->recur_id)
				{
					$PayPalRequestData = array();
					$PayPalRequestData['MRPPSFields'] = array('PROFILEID' => $rent_data->recur_id, 'ACTION' => 'Cancel');
					$responseData = $PayPal->ManageRecurringPaymentsProfileStatus($PayPalRequestData);
					
					$infoRecurring = array();
					if (isset($responseData['ACK']) && $responseData['ACK'] == PAYPAL_RESPONSE_STATUS_FAILED)
					{
						$inputParam['GRPPDFields'] = array('PROFILEID' => $rent_data->recur_id);
						$infoRecurring = $PayPal->GetRecurringPaymentsProfileDetails($inputParam);
					}
					
					if ($responseData['ACK'] == PAYPAL_RESPONSE_STATUS_SUCCESS || !count($infoRecurring) || $infoRecurring['STATUS'] == PAYPAL_RESPONSE_STATUS_CANCELLED)
					{
						$oRecursion = \App\BookingRecursion::where('RecursionID', $rent_data->recur_id)->first();
						if ($oRecursion)
						{
							$oRecursion->delete();
						}
						
						$rent_data->recur_id = '';
						$rent_data->save();
					}
				}
				
				return redirect(url('ShareUser/Dashboard/BookingPayment'))
					->withErrors(isset($responseData['L_LONGMESSAGE0']) ? $responseData['L_LONGMESSAGE0']: trans('common.Error occured, Please try again'))
					->withInput();
			}
			catch(\Exception $e)
			{
				return redirect(url('ShareUser/Dashboard/BookingPayment'))
				->withErrors(trans('common.Error occured, Please try again'))
				->withInput();
			}
		}
		
		public function creditPayment(Request $request)
		{
			if(!Session::get('rent_id')):
				Session::flash('error', 'common.Your Session is expired, please try again.');
				return redirectToDashBoard();
			endif;

			$input = $request->all();
			$spaceslot = new Spaceslot();
			$user = Auth::guard('user2')->user();
			$rent_data = Rentbookingsave::Where('id', Session::get('rent_id'))->first();
			$space = User1sharespace::with('spaceImage')->where('id', $rent_data['user1sharespaces_id'])->first();
			$slots_id = explode(';',$rent_data['spaceslots_id']);
			$slots_id = array_filter(array_unique($slots_id));
			$slots_data = Spaceslot::whereIn('id', $slots_id)->where('status', SLOT_STATUS_AVAILABLE)->orderBy('StartDate','asc')->get();

			$isCoreWorkingOrOpenDesk = isCoreWorkingOrOpenDesk($space);
			
			// Get Slots ids to validate
			$aTimeStart = explode('-', $rent_data->hourly_time);
			$timeStart = date('H:00:00', strtotime(trim($aTimeStart[0])));
			$timeEnd = date('H:00:00', strtotime(trim(isset($aTimeStart[1]) ? $aTimeStart[1] : '')));
			
			$myRequest = new Request();
			$myRequest->merge(array('booked_date' => $rent_data->hourly_date));
			$myRequest->merge(array('startTime' => $timeStart));
			$myRequest->merge(array('endTime' => $timeEnd));
			$myRequest->merge(array('spaceslots_id' => $rent_data['spaceslots_id']));
			$slotIds = $this->getBookingAvailableSlotIds($space, $myRequest->all());
			
			if (is_a($slotIds, 'Illuminate\Http\RedirectResponse'))
				return $slotIds;
			elseif (count($slotIds) != count($slots_id))
			{
				return redirect(getSpaceUrl($space->HashID))
				->withErrors(trans('common.booking_time_not_available'))
				->withInput();
			}

			if($request->isMethod('post') || ($rent_data->recur_id && isset($input['save_booking']))):
			try {
				// If below = false mean not created REcursion for paypal yet
				if (!$rent_data->recur_id || !isset($input['save_booking']))
				{
					if($rent_data->amount < 50) {
						return redirect::back()
						->withErrors('50円以下の決済はできません。')
						->withInput();
					}
					
					$paymentResponse = array();
					if (isset($input['PaymentProfileForEdit_CardNumber']))
					{
						// ----- DO PAYMENT VIA WEPAY WITH CREDITCARD -------------//
						
						$rent_data->payment_method = 'creditcard';
						$rent_data->save();
						$paymentResponse = $this->createWebpayPayment($rent_data, $input);
					}
					elseif (isset($input['payment_type']) && $input['payment_type'] == 'paypal')
					{
						
						// ----- DO PAYMENT VIA WEPAY WITH PAYPAL -------------//
						
						$rent_data->payment_method = 'paypal';
						$rent_data->save();
						$paymentResponse = $this->createPaypalPayment($rent_data, $input);
						if (is_a($paymentResponse, 'Illuminate\Http\RedirectResponse'))
						{
							return $paymentResponse;
						}
					}
					else {
						return redirect::back()
						->withErrors(trans('common.Please select Payment Method to purchase'))
						->withInput();
					}
					
					if (isset($paymentResponse['error']))
					{
						return redirect::back()
						->withErrors($paymentResponse['message'])
						->withInput();
					}
				}
				
				// Recall booking data because it is changed to save transaction and recursion above
				$rent_data = Rentbookingsave::Where('id', Session::get('rent_id'))->first();
				if(isBookingRecursion($rent_data) && !$rent_data->recur_id)
				{
					return redirect(url('ShareUser/Dashboard/BookingPayment'))
					->withErrors(trans('common.Recurring for monthly not working properly, please try again'))
					->withInput();
				}
				
				$rent_data_save = Rentbookingsave::where('id', Session::get('rent_id'))->firstOrFail();
				
				$isInvoiceExisted = true;
				while ($isInvoiceExisted)
				{
					$invoiceID = createRandomInvoiceID(10);
					$oInvoice = Rentbookingsave::select('InvoiceID')->where('InvoiceID', $invoiceID)->first();
					$isInvoiceExisted = $oInvoice['InvoiceID'] ? true : false;
				}
					
				$duration = getSpaceSlotDuration($slots_data, false, $rent_data_save);
				$durationText = getSpaceSlotDuration($slots_data, true, $rent_data_save);
				$usedDate = getBookingSlotDate($slots_data, false, $rent_data_save);
				$spaceTypeFee = getSpaceTypeFee($space, false);
					
				$rent_data_save->SpaceType = $space->FeeType;
				$rent_data_save->InvoiceID = $invoiceID;
				$rent_data_save->price = $spaceTypeFee;
				$rent_data_save->UsedDate = $usedDate;
				$rent_data_save->Duration = $duration;
				$rent_data_save->DurationText = $durationText;
				$rent_data_save->status = BOOKING_STATUS_PENDING;
					
				$success = $rent_data_save->save();

				if ($success)
				{
					//Save Booking History Space table
					$oBookedSpace = new \App\Bookedspace();
					$BookingExist = $oBookedSpace->where('BookedID', $rent_data_save->id)->where('SpaceID', $space->id)->first();

					if (!$BookingExist)
					{
						$spaceAttributes = $space->getAttributes();
						$oBookedSpace->BookedID = $rent_data_save->id;
						$oBookedSpace->SpaceID = $space->id;
						foreach ( $spaceAttributes as $attField => $attribute )
						{
							if ($attField != 'id')
							{
								$oBookedSpace->$attField = $attribute;
							}
						}
						$oBookedSpace->save();

						$aBreakSlot=array();
						// Get Hour
						if ($space->FeeType==1)
						{
							$aTimeStart = explode('-', $rent_data_save->hourly_time);
							$dateStart = $rent_data_save->hourly_date;
							$timeStart = date('H:00:00', strtotime(trim($aTimeStart[0])));
							$timeEnd = date('H:00:00', strtotime(trim($aTimeStart[1])));

							$bookedSlot = Spaceslot::where('StartDate', $dateStart)->where('StartTime', $timeStart)
							->where('EndTime', $timeEnd)
							->where('SpaceID', $space->id)
							->where('total_booked', '>', 0)
							->where('ParentID', '>', 0)
							->where('Type', 'HourSpace')->first();


							if ($bookedSlot && isCoreWorkingOrOpenDesk($space))
							{
								$bookedSlot->total_booked = $bookedSlot->total_booked + 1;
								$bookedSlot->save();

								// Save the parent slot
								$oParentSlot = Spaceslot::where('id', $bookedSlot->ParentID)->where('Type', 'HourSpace')->first();
								if ($oParentSlot)
								{
									// Query to get all booked slot of this parent slot
									$oaBookedSlots = Spaceslot::select('total_booked')->where('ParentID', $bookedSlot->ParentID)->where('Type', 'HourSpace')->get();
									$total_booked = 0;
									foreach ($oaBookedSlots as $oaBookedSlot)
									{
										$total_booked += $oaBookedSlot->total_booked;
									}
									$oParentSlot->total_booked = $total_booked;

									if($oParentSlot->total_booked >= $space->Capacity){
										//$oParentSlot->Status = SLOT_STATUS_BOOKED;
									}
									$oParentSlot->save();
								}

								$slots_data=Spaceslot::whereIn('id', array($bookedSlot->id))->orderBy('StartDate','asc')->get();
							}
							else {
								$aAvailSlot = Spaceslot::where('StartDate', $dateStart)->where('SpaceID', $space->id)->where('Status', SLOT_STATUS_AVAILABLE)->where('Type', 'HourSpace')->get();
								if (count($aAvailSlot))
								{
									foreach ( $aAvailSlot as $availSlot )
									{
										if ($timeStart >= $availSlot['StartTime'] && $timeEnd <= $availSlot['EndTime']  || $timeStart >= $timeEnd)
										{
											// Break the avail Slot to 3 smaller slot
											// 1	: From StartAvailSlot -> StartBookedSlot
											// 2 	: From StartBookedSlot -> EndBookedSlot
											// 3	: From EndBookedSLot -> EndAvailSlot
											if ($availSlot['StartTime'] != $timeStart )
											{
												$aBreakSlot[$availSlot['StartTime'].$timeStart]['StartTime'] = $availSlot['StartTime'];
												$aBreakSlot[$availSlot['StartTime'].$timeStart]['EndTime'] = $timeStart;
											}
											if ($timeStart != $timeEnd )
											{
												// This is booked slot
												$aBreakSlot[$timeStart.$timeEnd]['StartTime'] = $timeStart;
												$aBreakSlot[$timeStart.$timeEnd]['EndTime'] = $timeEnd;
											}
											if ($timeEnd != $availSlot['EndTime'] )
											{
												$aBreakSlot[$timeEnd.$availSlot['EndTime']]['StartTime'] = $timeEnd;
												$aBreakSlot[$timeEnd.$availSlot['EndTime']]['EndTime'] = $availSlot['EndTime'];
											}
											break;
										}
									}
									if (count($aBreakSlot))
									{
										$parentSlotStatus = SLOT_STATUS_AVAILABLE;
										// Save breaked Slots with status : booked - 1, avail - 0
										foreach ( $aBreakSlot as $breakSlot )
										{
											$status = SLOT_STATUS_AVAILABLE;
											if ($breakSlot['StartTime'] == $timeStart && $breakSlot['EndTime'] == $timeEnd)
											{
												// This is booked slot, need save with status = 1
												if((isCoreWorkingOrOpenDesk($space) && $space['Capacity'] == 1) || !isCoreWorkingOrOpenDesk($space))
													$status = SLOT_STATUS_BOOKED;
											}

											$oSlot = $availSlot->replicate();
											$oSlot->Status = $status;
											$oSlot->StartTime = $breakSlot['StartTime'];
											$oSlot->EndTime = $breakSlot['EndTime'];
											$oSlot->DurationHours = (int)$breakSlot['EndTime'] - (int)$breakSlot['StartTime'];

											if ($status == SLOT_STATUS_BOOKED || ($breakSlot['StartTime'] == $timeStart && $breakSlot['EndTime'] == $timeEnd))
											{
												$oSlot->total_booked = isCoreWorkingOrOpenDesk($space) ? 1 : 0;
												$oSlot->ParentID = $availSlot->id;
												$oSlot->Status = SLOT_STATUS_BOOKED;
												$oSlot->save();

												// Save the parent slot
												$oParentSlot = Spaceslot::where('StartDate', $dateStart)->where('StartTime', $availSlot['StartTime'])->where('EndTime', $availSlot['EndTime'])->where('SpaceID', $space->id)->where('Status', SLOT_STATUS_AVAILABLE)->where('Type', 'HourSpace')->first();
												if ($oParentSlot)
												{
													if (isCoreWorkingOrOpenDesk($space))
													{
														// Query to get all booked slot of this parent slot
														$oaBookedSlots = Spaceslot::select('total_booked')->where('ParentID', $oSlot->ParentID)->where('Type', 'HourSpace')->get();
														$total_booked = 0;
														foreach ($oaBookedSlots as $oaBookedSlot)
														{
															$total_booked += $oaBookedSlot->total_booked;
														}
														$oParentSlot->total_booked = $total_booked;
													}

													$oParentSlot->save();
												}
												// Save the booked slot id to Booking Table
												$rent_data_save->spaceslots_id = $oSlot->id;
												$rent_data_save->save();
												$slots_data=Spaceslot::whereIn('id', array($oSlot->id))->orderBy('StartDate','asc')->get();
											}
										}
									}
									else {
										$saveBookingError = true;
									}
								}
								else {
									$saveBookingError = true;
								}
							}
						}
						else {
							if(!empty($slots_data)) {
								foreach($slots_data as $key=>$slot){
									$spaceslot_data_save=SpaceSlot::where('id', $slot->id)->firstOrFail();
									if($isCoreWorkingOrOpenDesk && $space['Capacity']<=$spaceslot_data_save['total_booked']+1){
										$spaceslot_data_save->Status= SLOT_STATUS_BOOKED;
									}elseif(!$isCoreWorkingOrOpenDesk){
										$spaceslot_data_save->Status= SLOT_STATUS_BOOKED;
									}

									if($isCoreWorkingOrOpenDesk){
										$spaceslot_data_save->total_booked= $spaceslot_data_save['total_booked']+1;
									}

									$spaceslot_data_save->save();
								}
							}
						}
					}

					// Save Booking history Space SLot
					foreach($slots_data as $key=>$slot){
						$oBookedSpaceSlot = new \App\Bookedspaceslot();
						$BookingExist = $oBookedSpaceSlot->where('BookedID', $rent_data_save->id)->where('SpaceID', $space->id)->where('SlotID', $slot->id)->first();
						$unitPrice = flexibleSpacePrice($space, $slot->StartDate);

						if (!$BookingExist)
						{
							$slotAttributes = $slot->getAttributes();
							foreach ( $slotAttributes as $attField => $attribute )
							{
								if ($attField != 'id')
								{
									$oBookedSpaceSlot->$attField = $attribute;
								}
							}
							$oBookedSpaceSlot->BookedID = $rent_data_save->id;
							$oBookedSpaceSlot->SlotID = $slot->id;
							$oBookedSpaceSlot->Status = SLOT_STATUS_BOOKED;
							$oBookedSpaceSlot->UnitPrice = $unitPrice;
							$oBookedSpaceSlot->save();
						}
					}

					// Trigger booking
					$rentbooking = new Rentbookingsave();
					$rentbooking->bookingSaveCallBack($rent_data_save);
				}

				// Rollback if wrong
				$somethingWrong = $this->rollBackPaymentIfSomethingWrong();
				
				if ((isset($saveBookingError) && $saveBookingError) || $somethingWrong)
				{
					throw new \Exception(trans('common.booking_time_not_available') . ' OR ' . trans('common.Error occured, Please try again'));
				}

				Session::flash('success', 'You have successfully completed your booking.');
				return redirect('BookingCompleted');

			} catch (\Exception $e) {
				// Rollback if wrong
				$success = $this->rollBackPaymentIfSomethingWrong(true);
				return redirect(getSpaceUrl($space->HashID))
					->withErrors($e->getMessage())
					->withInput();
			}
			endif;

			return view('public.booking-creditpayment',compact('rent_data','spaceslots','user'));
		}

		private function rollBackPaymentIfSomethingWrong($forceRollback = false)
		{
			$rent_data = Rentbookingsave::where('id', Session::get('rent_id'))->firstOrFail();
			$rentbooking = new Rentbookingsave();
			if ($forceRollback || ($rent_data->status == BOOKING_STATUS_PENDING && (!count($rent_data->bookedSlots) || !count($rent_data->bookedSpace) || !count($rent_data->bookedHistories))))
			{
				if ($rent_data->recur_id)
				{
					$rentbooking->deleteRecursion($rent_data);
				}
					
				if ($rent_data->transaction_id)
				{
					$rentbooking->processCancelPayment($rent_data, false);
				}
				$rent_data->status = BOOKING_STATUS_DRAFT;
				$rent_data->save();
				
				return true;
			}
			
			return false;
		}
		public function cancelPayment(Request $request){
			$user = Auth::guard('user2')->user();
			$input = $request->all();
			$rentbooking=new Rentbookingsave();
			$rent_data = Rentbookingsave::where('id', $input['id'])->where('user_id', $user->id)->first();

			try {
				$redirect_to = isset($input['redirect_to']) ? $input['redirect_to'] : '/RentUser/Dashboard/Reservation';
				if (!$rent_data)
				{
					Session::flash('error', 'booking_list.Error Occured, Please try again');
					return redirect($redirect_to);
				}
				
				$response = $rentbooking->processCancelPayment($rent_data, false);
				if (isset($response))
				{
					if ($response === true)
					{
						// success
						Session::flash('success', '予約ステータスの更新に成功しました。');
						return redirect($redirect_to);
					}
					elseif (isset($response['error'])){
						// failed
						$message = is_string($response['response']) ? $response['response'] : $response['response']->getMessage();
						Session::flash('error', $message);
						return redirect($redirect_to);
					}
					else {
						Session::flash('error', 'booking_list.Error Occured, Please try again');
						return redirect($redirect_to);
					}
				}
				
			} catch (\Exception $e) {
				return redirect($redirect_to)
				->withErrors($e->getMessage())
				->withInput();
			}
		}

		public function deleterecPayment(){

			$rentbooking=new Rentbookingsave();
			$delete=$rentbooking->deleterecPayment();
		}

		public function IdentifyUpload(Request $request){
			$userIde=User2identitie::where('User2ID',Auth::guard('user2')->user()->id)->get();
			$user = Auth::guard('user2')->user();
			return view('user2.dashboard.identify-rentuser', compact('userIde', 'user'));
		}
		public function IdentifyDelete($id)
		{
			User2identitie::where('HashID',$id)->delete();
			Session::flash('success', 'ファイルの削除に成功しました');
			return redirect('/RentUser/Dashboard/Identify/Upload');
		}
		public function IdentifySend()
		{
			$user = Auth::guard('user2')->user();
			$from = Config::get('mail.from');
			User2identitie::where('User2ID',Auth::guard('user2')->user()->id)->update(['SentToAdmin' => 'Yes']);
			$user->SentToAdmin = 1;
			$user->save();

			Session::flash('senttoadmin', 'ファイルが送信されました。審査の間(2~3営業日)、しばらくお待ち下さい。');

			// Send email to admin
			sendEmailCustom ([
			'user2' => Auth::guard('user2')->user(),
			'sendTo' => $from['address'],
			'template' => 'user2.emails.request_approve_identify',
			'subject' => 'レントユーザーから審査証明書提出されました']
			);

			return redirect('/RentUser/Dashboard/BasicInfo/Edit');
		}

		public function IdentifyUploadSubmit(Request $request){
			if ($request->hasFile('userfile')) {
				$f=$request->file('userfile');
				$destinationPath = public_path() . "/userfile";
				foreach($f as $f1)
				{
					$fileName=uniqid().$f1->getClientOriginalName();

					$validator = Validator::make(
							array('file' => $f1),
							array('file' => 'required|mimes:jpeg,jpg,gif,bmp,png,pdf,doc,docx')
					);

					if ($validator->passes()) {
						$f1->move($destinationPath, $fileName);
						$cert=new User2identitie();
						$cert->User2ID=Auth::guard('user2')->user()->id;
						$cert->HashID=uniqid();
						$cert->FilePath="/userfile/".$fileName;
						$cert->FileType=$request->doctype;
						$cert->Description=$request->Description;
						$cert->save();
				}
				else
				{
					// Collect error messages
					Session::flash('error', 'ファイル"' . $f1->getClientOriginalName() . '"がアップロードできません。以下の拡張子を持つファイルのみ、アップロードが可能です。<br/>jpeg, jpg, bmp, gif, png, pdf, doc, docx');
					return redirect('/RentUser/Dashboard/Identify/Upload');
				}
			}
		}
		Session::flash('success', 'ファイルのアップロードに成功しました。[書類を提出]をクリックすると、送信されます。');
		return redirect('/RentUser/Dashboard/Identify/Upload');
	}
	public function notAuth ()
	{
		return view('user2.dashboard.not-auth');
	}
	public function calendar ( Request $request )
	{
		$user = Auth::guard('user2')->user();
		$oTimeNow = \Carbon\Carbon::now();
		// Get all booking from user 2 in this year.
		$bookedSlots = Rentbookingsave::where('rentbookingsaves.user_id', $user->id)
			->where('rentbookingsaves.InvoiceID', '<>', '')
			->joinSpace()
			->orderBy('rentbookingsaves.id', 'desc')
			->whereIn('rentbookingsaves.status', array(
				BOOKING_STATUS_PENDING,
				BOOKING_STATUS_RESERVED,
				BOOKING_STATUS_COMPLETED
			))
			->where('rentbookingsaves.SpaceType', '=', SPACE_FEE_TYPE_DAYLY)
			->where('rentbookingsaves.created_at', '>=', $oTimeNow->subYear(USER2_CALENDAR_YEAR_NUMBER)->format('Y-m-d'));
		;
		if ( $request->ajax() )
		{
			$bookedSlots = $bookedSlots->select(DB::Raw('rentbookingsaves.*, 
				bookedspaceslots.StartDate,
				bookedspaceslots.StartTime,
				bookedspaceslots.EndDate,
				bookedspaceslots.EndTime,
				bookedspaceslots.SlotID,
				bookedspaceslots.Type,
				bookedspaces.FeeType,
				rentbookingsaves.status as BookedStatus
			'));
// 			$bookedSlots = $bookedSlots->where('bookedspaces.SpaceID', (int) $request->spaceID);
			$bookedSlots = $bookedSlots->get();
			
			$calendarEvents = array();
			$groupedSpaces = array();
			$firstSpace = false;
			
			foreach ( $bookedSlots as $indexSlot => $bookedSlot )
			{
				$descriptionContent = array();
				$space = $bookedSlot->bookedSpace;
					
				$calendarEvents[$indexSlot]['start'] = $bookedSlot->StartDate . 'T' . $bookedSlot->StartTime;
				$calendarEvents[$indexSlot]['end'] = $bookedSlot->EndDate . 'T' . $bookedSlot->EndTime;
				$calendarEvents[$indexSlot]['id'] = $bookedSlot->SlotID;
				$calendarEvents[$indexSlot]['type'] = $bookedSlot->Type;
					
				$calendarEvents[$indexSlot]['backgroundColor'] = $bookedSlot->BookedStatus == BOOKING_STATUS_PENDING ? '#6373fa !important' : ($bookedSlot->BookedStatus == BOOKING_STATUS_RESERVED ? 'orange !important' : 'green !important');
				$calendarEvents[$indexSlot]['title'] = getBookingPaymentStatus($bookedSlot);
				$calendarEvents[$indexSlot]['description'] = '';
				$calendarEvents[$indexSlot]['editable'] = false;
				$calendarEvents[$indexSlot]['className'] = 'booked';
				$calendarEvents[$indexSlot]['status'] = $bookedSlot->BookedStatus == BOOKING_STATUS_PENDING ? 'pending' : ($bookedSlot->BookedStatus == BOOKING_STATUS_RESERVED ? 'reserved' : 'completed');
				$calendarEvents[$indexSlot]['constraint'] = null;
				$calendarEvents[$indexSlot]['overlap'] = true;
				
				// Make booked event wit summary popup data
				$unitPrice = $bookedSlot->price;
					
				// For single booking in one slot
				$descriptionContent[] = '<span class="booked_id_text">' . trans('common.Booked ID:') . '<span> ' . '<span class="booked_id"><a class="booking_url" target="_blank" href="' . getRentBookingDetailUrl($bookedSlot->id) . '">#' . $bookedSlot->id . '</a></span>';
				$descriptionContent[] = '<span class="booked_date_text">' . trans('common.Booked Date:') . '<span> ' . '<span class="booked_date">' . renderJapaneseDate($bookedSlot->created_at, false) . '</span>';
				if ( $bookedSlot->Type == 'DailySpace' || $bookedSlot->Type == 'HourSpace' )
				{
					$descriptionContent[] = '<span class="booked_time_text">' . trans('common.Time Range:') . '<span> ' . '<span class="booked_time">' . getTimeFormat($bookedSlot->StartTime) . ' - ' . getTimeFormat($bookedSlot->EndTime) . '</span>';
				}
				$descriptionContent[] = '<span class="booked_price_text">' . trans('common.Booked Price:') . '</span> ' . '<span class="booked_price">' . priceConvert($unitPrice, true) . '</span>';
				$descriptionContent[] = '<span class="booked_status_text">' . trans('common.Booking Status:') . '</span> ' . '<span class="booked_status">' . getBookingPaymentStatus($bookedSlot) . '</span>';
					
				$calendarEvents[$indexSlot]['description'] = implode(('<br />'), $descriptionContent);
				$calendarEvents[$indexSlot]['url'] = 'javascript:void(0)';
				
			}
			
			$calendarEvents = json_encode(array_values($calendarEvents));
			return view('user1.dashboard.calendar', compact('space', 'user', 'calendarEvents'));
		}
		else {
			// Group space slot
			$bookedSpaces = $bookedSlots->groupBy(array('bookedspaces.id'));
			$bookedSpaces = $bookedSpaces->select(DB::Raw('bookedspaces.*, bookedspaces.SpaceID as id, rentbookingsaves.created_at as BookedDate'))->get();
			foreach ($bookedSpaces as $bookedSpace)
			{
				$bookedSpace->isThisSpaceHasSlot = true;
				#$groupedSpaces[$bookedSpace->FeeType][] = $bookedSpace;
				$groupedSpaces[1][] = $bookedSpace;
				
				if ( $firstSpace === false )
				{
					$firstSpace = $bookedSpace;
				}
			}
			
			ksort($groupedSpaces);
			return view('user2.dashboard.space-calendar', compact('groupedSpaces', 'firstSpace', 'user'));
		}
	}
}
