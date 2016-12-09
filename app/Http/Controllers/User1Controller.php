<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User1;
use App\User1sharespace;
use App\Spaceimage;
use App\Spaceslot;
use App\User1paymentinfo;
use App\User1hostmember;
use App\User1certificate;
use App\Rentbookingsave;
use App\Notification;
use App\Userreview;
use Session;
use Mail;
use Config;
use WebPay\WebPay;
use Auth;
use Response;
use Redirect;
use URL;
use App\Chat;
use App\Chatmessage;
use \Cache;
use DB;
use Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Models\Paypalbilling;
use App\Models\Paypal;

class User1Controller extends Controller
{
	public function __construct(){
		$this->middleware('user1', ['except' => ['index','login','logout','register','save','isvalid','registerShareUser','step2','saveUser','thankyou','thankyoudashboard','confirm','verifyEmail','basicInfo','basicInfoSubmit','shareInfo','dashboardshareInfoSubmit', 'dashboardshareInfoUpload','editshareInfo','processBookingPaymentAuto', 'acceptHourPayment','acceptDayPayment','acceptMonthPayment','acceptWeekPayment','shareInfoSaveCalendar', 'hostingImages','dashboardHostSettingUpload','resizeThumbnailImage', 'registerPreSuccess','acceptPayment', 'shareInfoEditSubmit', 'deleteShareInfo']]);

		if (Auth::check())
		{
			Cache::remember('chatNotification-'.Auth::user()->HashCode, 60, function() {
				$msgs=Chatmessage::where('User1ID','')->whereIn('ChatID', function($query){
						$query->select(array('id'))->from('chats')->where('User1ID',Auth::user()->HashCode)->get();
					})->orderBy('id', 'DESC')->take(10)->get();
					return($msgs);
				//return Article::all();
			});
		}
	}
	public function test()
	{
		/*$msgs=Chatmessage::where('User1ID','')->whereIn('ChatID', function($query){
			$query->select(array('id'))->from('chats')->where('User1ID',Auth::user()->HashCode)->get();
		})->orderBy('id', 'DESC')->take(10)->get();
		return($msgs);
		//return(DB::table('chats')->select(array('id'))->where('User1ID',Auth::user()->HashCode)->get());
	*/
		return view('pages.fb-signup');
	
	}
	public function index()
	{
		return view('user1.home');
	}
		public function logout()
	{
			if (Auth::guard('user1')->check())
		{
			auth()->guard('user1')->logout();
		}	
			Session::put('user1.url.intended','');

		 return redirect('/');
	}
	public function login()
	{
		/*if (URL::previous() != URL::to('/') && strpos(URL::previous(), 'User1/Login')  === false)
		{
			Session::put('url.intended',URL::previous());
		}*/
		return view('user1.login-form-temp');
		//return view('user1.login');
	}
	public function isvalid(Request $request, User1 $user1)
	{
		$this->validate($request ,[
				'Email' => 'required' ,
				'password'=> 'required'
				]);

		$auth = auth()->guard('user1');
		$user1 = $user1->isEmailVerified()->where(function ($query) use ($request) {
			$query->orWhere('Email', $request->Email);
			$query->orWhere('UserName', $request->Email);
		})->first();
		
		if (!$user1)
		{
			session()->flash('err', trans('common.login_not_exists_or_verified'));
			return redirect('/User1/Login');
		}
		else {
			//if($auth->attempt($request->only('Email', 'password')))
			if($auth->attempt(['Email' => $request->Email, 'password' => $request->password]) || $auth->attempt(['UserName' => $request->Email, 'password' => $request->password]))
			{
				Auth::guard('user2')->logout();
				//if (Session::get('url.intended') && Session::get('url.intended') != URL::to('/') && strpos(Session::get('url.intended'), 'User1/Login')  === false)
				if (Session::get('user1.url.intended'))
				{
					return Redirect::to(Session::get('user1.url.intended'));
				}
				else {
					return redirect('/ShareUser/Dashboard');
				}
			}
			else{
				session()->flash('err', '認証エラー');
				return back();
			}
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
		$user=User1::find(Auth::user()->id);
		if (Hash::check($request->oldpassword, $user->password)) {
			$user->password=bcrypt($request->password);
			$user->save();
			
			return Response::json(array(
				'success' => true,
				'next' => ""
		));
		
		}
		
		return Response::json(array(
				'matched' => false,
				'next' => ""
		));
	}

	public function changeEmail(Request $request)
	{
		$this->validate($request ,[
			'Email'=> 'required|unique:user1s|email' 
		]);	
		
		$user=User1::find(Auth::user()->id);
		
			$user->Email=$request->Email;
			$user->EmailVerificationText=uniqid();
			$user->IsEmailVerified='No';
			$user->save();
			
			$from = Config::get('mail.from');
					Mail::send('user1.emails.verifyemail',
					[
					'EmailVerificationText' => $user->EmailVerificationText,
					],
					function ($message) use ($user, $from){
						$message->from($from['address'], $from['name']);
						$mails = [$user->Email];
						$message->to($mails)->subject('メールアドレスの認証 | OFFISPO');
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
	
	public function registerShareUser()
	{
		return view('user1.registerShareUser');
	}
	public function step2(Request $request,User1 $user1)
	{
		if ($request->has('LastName')) {

			$this->validate($request ,[
					'LastName'=> 'required' ,
					'FirstName'=> 'required' ,
					'Email'=> 'required|unique:user1s|email' ,
					'password'=> 'required'
					]);
			if (Session::has('WebUrl'))
			{
			}
			else{
				Session::put("WebUrl","http://");
			}
			Session::put("LastName",$request->LastName);
			Session::put("FirstName",$request->FirstName);
			Session::put("Email",$request->Email);
			Session::put("password",$request->password);
		}
		return view('user1.registerShareUserStep2');
	}
	public function confirm(Request $request)
	{

		$this->validate($request ,[
				'NameOfCompany' => 'required'
				]);

		Session::put('NameOfCompany', $request->NameOfCompany);
		Session::put("WebUrl",$request->WebUrl);
		Session::put("PostalCode",$request->PostalCode);
		Session::put("Address",$request->Address);
		Session::put("Tel",$request->Tel);
		Session::put("isweb",$request->isweb);
		Session::put("Newsletter",$request->Newsletter);
		//return redirect('Register-ShareUser/Confirm');
		return view('user1.confirm');
	}
	public function saveUser(Request $request,User1 $user1)
	{
		$request->merge(array('password' => bcrypt(Session::get("password"))));
		$request->merge(array('NameOfCompany' => Session::get("NameOfCompany")));
		$request->merge(array('LastName' => Session::get("LastName")));
		$request->merge(array('FirstName' => Session::get("FirstName")));
		$request->merge(array('Email' => Session::get("Email")));
		$request->merge(array('UserName' => Session::get("Email")));
		$request->merge(array('WebUrl' => Session::get("WebUrl")));
		$request->merge(array('Address' => Session::get("Address")));
		$request->merge(array('PostalCode' => Session::get("PostalCode")));
		$request->merge(array('Tel' => Session::get("Tel")));
		$request->merge(array('Newsletter' => Session::get("Newsletter")));
		$request->merge(array('HashCode' => uniqid()));
		//$request->merge(array('isweb' => Session::get("isweb")));
		$request->merge(array('EmailVerificationText' => uniqid()));

		$user1->create($request->except(['_token']));

		global $from;
		$from = Config::get('mail.from');

		// Send email to admin
		Mail::send('user1.emails.admin',
		[
		'NameOfCompany' => $request->NameOfCompany,
		'LastName' => $request->LastName,
		'FirstName' => $request->FirstName,
		'Email' => $request->Email,
		'WebUrl' => $request->WebUrl,
		'isweb' => isset($request->isweb)? $request->isweb : '',
		'Address' => getUserAddress($request),
		'PostalCode' => $request->PostalCode,
		'Telephone' => $request->Tel,
		'Newsletter' => $request->Newsletter,
		], function ($message) {
			global $request, $from;
			$message->from($from['address'], $from['name']);
			$message->cc('kyoko@heart-hunger.com', 'Kyoko');
			$mails = [$from['address']];
			$message->to($mails)->subject('OFFISPOでシェアユーザーが新規登録されました');
		});


		Mail::send('user1.emails.register',
		[
		'NameOfCompany' => $request->NameOfCompany,
		'LastName' => $request->LastName,
		'FirstName' => $request->FirstName,
		'Email' => $request->Email,
		'WebUrl' => $request->WebUrl,
		'isweb' => isset($request->isweb)? $request->isweb : '',
		'Address' => getUserAddress($request),
		'PostalCode' => $request->PostalCode,
		'Telephone' => $request->Tel,
		'Newsletter' => $request->Newsletter,
		'EmailVerificationText' => $request->EmailVerificationText,
		],
		function ($message) {
			global $request, $from;
			$message->from($from['address'], $from['name']);
			$mails = [$request->Email];
			$message->to($mails)->subject('仮会員登録完了のお知らせ | OFFISPO');
		});

		Session::flush();
		return redirect('Register-ShareUser/ThankYou');
	}


	public function verifyEmail($id)
	{
		//$user=new User1();
		$user=User1::where('EmailVerificationText','=', $id)->first();
		if ($user) {
			if($user->IsEmailVerified!="Yes")
			{
				$user->IsEmailVerified="Yes";
				$user->save();
			}
			return view('user1.emailverify');


		}
		return("Invalid ID");

	}
	public function thankyou()
	{
		return view('user1.thankyou');
	}
	public function thankyoudashboard()
	{
		return view('user1.dashboard.thankyou');
	}

	public function basicInfo()
	{
		if(Session::has("ShareUserID") && !empty(Session::get("ShareUserID")))
		{

			return view('user1.register.select-basicinfo');
		}
		else
		{
			return redirect('/');
		}
		//return view('user1.register.select-basicinfo');

	}

	public function shareInfo()
	{
		$space= new User1sharespace();
		$IsEdit='False';
		$IsDuplicate='False';
		if(Session::has("ShareUserID") && !empty(Session::get("ShareUserID")))
		{
			$user = User1::find(Session::get("ShareUserID"));
			return view('user1.register.select-sharespace',compact('IsDuplicate','IsEdit','space','user'));
		}
		else
		{
			return redirect('/');
		}
		//return view('user1.register.select-basicinfo');

	}

	public function basicInfoSubmit(Request $request)
	{
		$this->validate($request ,[
				'BusinessType'=> 'required' ,
				'NameOfCompany'=> 'required' ,
				'LastName'=> 'required' ,
				'FirstName'=> 'required' ,
				'LastNameKana'=> 'required' ,
				'FirstNameKana'=> 'required' ,
				]);
		try{
			if (Auth::check())
			{
				$u=User1::find(Auth::user()->id);
			}
			else
			{
				$u=User1::find(Session::get("ShareUserID"));
			}
			$u->fill($request->except(['_token']));
			if($u->save())
			{
				if (Auth::check())
				{
					return redirect('/ShareUser/Dashboard/ShareInfo');
				}
				else{
					$from = Config::get('mail.from');
					Mail::send('user1.emails.register',
					[
					'NameOfCompany' => $u->NameOfCompany,
					'LastName' => $u->LastName,
					'FirstName' => $u->FirstName,
					'Email' => $u->Email,
					'UserName' => $u->UserName,
					'user' => $u,
					'WebUrl' => $u->WebUrl,
					'isweb' => isset($u->isweb)? $u->isweb : '',
					'Address' => getUserAddress($u),
					'PostalCode' => $u->PostalCode,
					'Telephone' => $u->Tel,
					'Newsletter' => $u->Newsletter,
					'EmailVerificationText' => $u->EmailVerificationText,
					],
					function ($message) use ($u, $from){
						$message->from($from['address'], $from['name']);
						$mails = [$u->Email];
						$message->to($mails)->subject('仮会員登録完了のお知らせ');
					});
					
					return redirect('/ShareUser/RegisterPreSuccess');
				}
			}
			else
			{
				return "error";
			}
		}
		catch(Exception $e){
			// do task when error
			return $e->getMessage();   // insert query
		}
	}

	public function registerPreSuccess(){
		$user=User1::find(Session::get("ShareUserID"));
		if ($user)
		{
			return view('user1.register.register_pre_success',compact('user'));
		}
		return '';
	}
	
	public function dashboardbasicInfo()
	{
		$user=User1::find(Auth::user()->id);
		return view('user1.dashboard.select-basicinfo',compact('user'));
	}
	public function dashboardshareInfo()
	{
		$user = Auth::user();
		$space= new User1sharespace();
		$IsEdit='False';
		$IsDuplicate='False';
		$isThisSpaceHasSlot = false;
		return view('user1.dashboard.edit-space',compact('user', 'space','IsEdit','IsDuplicate','isThisSpaceHasSlot'));
	}
	public function duplicateShareInfo($id)
	{
		$user = Auth::user();
		$space=User1sharespace::where('HashID', $id)->firstOrFail();
		$IsEdit='False';
		$IsDuplicate='True';
		$isThisSpaceHasSlot = false;
		return view('user1.dashboard.edit-space',compact('user', 'space','IsEdit','IsDuplicate','isThisSpaceHasSlot'));
	}

	public function editshareInfoBeforeLauncht($id)
	{
		$user = Auth::user();
		$space=User1sharespace::where('HashID', $id)->firstOrFail();
		$IsEdit='True';
		$IsDuplicate='False';
		//$space->merge(array('Edit' => 'true'));

		// Check this space has slot or not
		$isThisSpaceHasSlot = Spaceslot::isthisSpaceHasSlot($space);
		
		return view('user1.dashboard.edit-space',compact('user', 'space','IsEdit','IsDuplicate','isThisSpaceHasSlot'));
		//return $space;
	}

	public function editshareInfo($id)
	{
		$IsEdit='True';
		$IsDuplicate='False';
		$space=User1sharespace::where('HashID', $id)->firstOrFail();
		//return $space;
		return view('user1.dashboard.editspace-shareuser',compact('space','IsEdit','IsDuplicate'));

	}
	public function deleteShareInfo(Request $request, $id)
	{
		if (Auth::check() || auth()->guard('useradmin')->check())
		{
			$space=User1sharespace::where('HashID', $id)->firstOrFail();
			if (Auth::check() && Auth::user()->id != $space->User1ID && !$request->admin)
			{
				return redirect('ShareUser/Dashboard/MySpace/List1');
			}
			$id1=$space->id;
			$space->forceDelete();
			$path = public_path() . "/images/space/".$id1;
			$this->delete_files($path);			
		}
		
		if ($request->admin)
			return redirect::back();
		else 
			return redirect('ShareUser/Dashboard/MySpace/List1');
	}

	public function deleteSpaceImage(Request $request)
	{
		$spaceID = (int)$request->spaceID;
		$imageID = (int)$request->imageID;
		$image = Spaceimage::where('id', $imageID)->where('ShareSpaceID', $spaceID)->first();
		$success = false;
		if ($image)
		{
			if($image->delete())
			{
				@unlink(public_path() . $image->OrgPath);
				@unlink(public_path() . $image->ThumbPath);
				@unlink(public_path() . $image->SThumbPath);
				$success = true;
			}
		}
		
		return Response::json(array(
				'success' => $success,
				'message' => $success ? trans('common.Image is deleted') : trans('common.Have something wrong, Image could not be deleted, please try again'),
		));
	}
	
	public function shareInfoSaveCalendar(Request $request, Spaceslot $spaceSlot)
	{
		// Delete all not correct slot example Negative
		Spaceslot::where('Type', 'HourSpace')->whereColumn('StartTime', '>=', 'EndTime')->delete();
		Spaceslot::where('Type', '<>', 'HourSpace')->whereColumn('StartDate', '>', 'EndDate')->delete();
		
		$user1ID = Auth::user()->id;
		
		if (isset($_POST['calAction']))
		{
			if ($_POST['calAction'] == 'remove')
			{
				$isDeleted = false;
				$spaceSlot = Spaceslot::where('id', $_POST['event_id'])->first();
				if ($spaceSlot->Status == SLOT_STATUS_AVAILABLE && $spaceSlot->User1sharespace->shareUser->id == $user1ID)
				{
					$isDeleted = $spaceSlot->delete();
				}
				return Response::json(array(
						'success' => $isDeleted ? $isDeleted : -1,
						'message' => $isDeleted ? 'Slot is deleted successfully' : 'Can not be deleted because this slot is booked or something wrong !',
				));
			}
			elseif ($_POST['calAction'] == 'getEvents')
			{
				$spaceType = trim($_POST['Type']);
				if ($spaceType)
				{
					switch ($spaceType){
						case 'HourSpace':
							break;
						case 'DailySpace':
							break;
						case 'WeeklySpace':
							break;
						case 'MonthlySpace':
							break;
					}

				}
				$spaceSlots = SpaceSlot::getSpaceSlotBySpaceIDAndType(trim($_POST['SpaceID']), $spaceType);
				$calendarEvents = array();
				if (count($spaceSlots))
				{
					foreach ($spaceSlots as $indexSlot => $slot)
					{
						$calendarEvents[$indexSlot]['start'] = $slot->StartDate . 'T'. $slot->StartTime;
						$calendarEvents[$indexSlot]['end'] = $slot->EndDate . 'T'. $slot->EndTime;
						$calendarEvents[$indexSlot]['id'] = $slot->id;
						$calendarEvents[$indexSlot]['title'] = '予約受付中';
						$calendarEvents[$indexSlot]['type'] = $slot->Type;
						$calendarEvents[$indexSlot]['editable'] = true;

						if ($calendarEvents[$indexSlot]['type'] != 'HourSpace')
						{
							$calendarEvents[$indexSlot]['constraint'] = null;
							$calendarEvents[$indexSlot]['overlap'] = false;
						}

						if ($calendarEvents[$indexSlot]['type'] == 'DailySpace')
						{
							$calendarEvents[$indexSlot]['title'] = '';
						}
					}
				}

				$defaultRangeStart = '09:00 AM';
				$defaultRangeEnd = '17:00 PM';
				$space = User1sharespace::where('id', $_POST['SpaceID'])->firstOrFail();
				$timeRange = array(
					'fc-sun'=> array(
					'opening_start' => $space->SundayStartTime ? $space->SundayStartTime : $defaultRangeStart,
					'opening_end' => $space->SundayEndTime ? $space->SundayEndTime : $defaultRangeEnd,
						'closed' => $space->isClosedSunday ? true : false,
						'open247' => $space->isOpen24Sunday ? true : false,
					),
					'fc-mon'=> array(
						'opening_start' => $space->MondayStartTime ? $space->MondayStartTime : $defaultRangeStart,
						'opening_end' => $space->MondayEndTime ? $space->MondayEndTime : $defaultRangeEnd,
						'closed' => $space->isClosedMonday ? true : false,
						'open247' => $space->isOpen24Monday ? true : false,
					),
					'fc-tue'=> array(
						'opening_start' => $space->TuesdayStartTime ? $space->TuesdayStartTime : $defaultRangeStart,
						'opening_end' => $space->TuesdayEndTime ? $space->TuesdayEndTime : $defaultRangeEnd,
						'closed' => $space->isClosedTuesday ? true : false,
						'open247' => $space->isOpen24Tuesday ? true : false,
					),
					'fc-wed'=> array(
						'opening_start' => $space->WednesdayStartTime ? $space->WednesdayStartTime : $defaultRangeStart,
						'opening_end' => $space->WednesdayEndTime ? $space->WednesdayEndTime : $defaultRangeEnd,
						'closed' => $space->isClosedWednesday ? true : false,
						'open247' => $space->isOpen24Wednesday ? true : false,
					),
					'fc-thu'=> array(
						'opening_start' => $space->ThursdayStartTime ? $space->ThursdayStartTime : $defaultRangeStart,
						'opening_end' => $space->ThursdayEndTime ? $space->ThursdayEndTime : $defaultRangeEnd,
						'closed' => $space->isClosedThursday ? true : false,
						'open247' => $space->isOpen24Thursday ? true : false,
					),
					'fc-fri'=> array(
						'opening_start' => $space->FridayStartTime ? $space->FridayStartTime : $defaultRangeStart,
						'opening_end' => $space->FridayEndTime ? $space->FridayEndTime : $defaultRangeEnd,
						'closed' => $space->isClosedFriday ? true : false,
						'open247' => $space->isOpen24Friday ? true : false,
					),
					'fc-sat'=> array(
						'opening_start' => $space->SaturdayStartTime ? $space->SaturdayStartTime : $defaultRangeStart,
						'opening_end' => $space->SaturdayEndTime ? $space->SaturdayEndTime : $defaultRangeEnd,
						'closed' => $space->isClosedSaturday ? true : false,
						'open247' => $space->isOpen24Saturday ? true : false,
						),
				);

				if (count($calendarEvents) && $calendarEvents[0]['type'] != 'HourSpace')
				{
					foreach ($timeRange as &$range)
					{
// 						$range['opening_start'] = '00:00 AM';
// 						$range['opening_end'] = '23:59 AM';
					}
				}

				return Response::json(array('calendarEvents' => $calendarEvents, 'timeRange' => $timeRange));
			}
			elseif ($_POST['calAction'] == 'saveEvents')
			{
				$_POST['StartTime'] = date('H:00:00', strtotime($_POST['StartTime']));
				$_POST['EndTime'] = date('H:00:00', strtotime($_POST['EndTime']));
				
				if ($_POST[ 'event_id'])
					$spaceSlot =  Spaceslot::find($_POST[ 'event_id']);

				// in Hourly, if the day have booked event, the new event can't overlap booked events
				if ($_POST['Type'] == 'HourSpace')
				{
					$bookedSlots = Spaceslot::where('Type', 'HourSpace')->where('StartDate', $_POST['StartDate'])->where('SpaceID', $_POST['SpaceID'])->where('Status', SLOT_STATUS_AVAILABLE)->where('id', '<>', (int)$_POST[ 'event_id'])->get();
					if (count($bookedSlots))
					{
						foreach ($bookedSlots as $bookedSlot)
						{
							if (is2TimeRangeOverlap($bookedSlot, $_POST))
							{
								return Response::json(array(
									'success' => -1,
									'message' => 'You can not replace schedule which have booked on ' . $bookedSlot['StartDate'] . ' : ' . $bookedSlot['StartTime'] . ' ~ ' . $bookedSlot['EndTime']
								));
							}
						}
					}
				}else {
					$bookedSlots = Spaceslot::where('Type', $_POST['Type'])->where('StartDate', $_POST['StartDate'])->where('SpaceID', $_POST['SpaceID'])->get();
					if (count($bookedSlots))
					{
						return Response::json(array(
								'success' => -1,
								'message' => 'You can not replace schedule which have booked : ' . $_POST['StartDate']
						));
					}
				}
				
				if (($spaceSlot->id && $spaceSlot->User1sharespace->shareUser->id == $user1ID && $spaceSlot->Status == SLOT_STATUS_AVAILABLE) || !$spaceSlot->id)
				{				
					$dateStart 	= new \DateTime($_POST['StartDate']);
					$dateEnd 	= new \DateTime($_POST['EndDate']);
					$diff = date_diff($dateStart, $dateEnd);
					
					$spaceSlot->SpaceID      = $_POST['SpaceID'];
					$spaceSlot->StartDate     =  $_POST['StartDate'];
					$spaceSlot->EndDate     =  $_POST['EndDate'];
					$spaceSlot->StartTime  =  $_POST['StartTime'];
					$spaceSlot->EndTime =  $_POST['EndTime'];
					$spaceSlot->Type =  $_POST['Type'];
					$spaceSlot->DurationHours =  (int)$_POST[ 'EndTime'] - (int)$_POST['StartTime'];
					$spaceSlot->DurationDays =  $diff->days;
					$spaceSlot->save();
					return Response::json(array(
							'success' => $spaceSlot->id,
					));
				}
			}
		}

	}
	public function dashboardshareInfoSubmit(Request $request,User1sharespace $space)
	{
		if (!isset($request->saveDraft))
		{
			$this->validate($request ,[
				'Title'=> 'required' ,
				'PostalCode'=> 'required' ,
				'Type'=> 'required' ,
				'Details'=> 'required' ,
				'FeeType'=> 'required' ,
				'Address1'=> 'required' ,
				]);
		}
		
		$request->merge(array('HashID' => uniqid()));
		
		if (auth()->guard('useradmin')->check() && $request->User1ID)
		{
			$user = User1::find($request->User1ID);
		}
		else {
			if (Auth::check())
			{
				$request->merge(array('User1ID' => Auth::user()->id));
			}
			else
			{
				$request->merge(array('User1ID' => Session::get("ShareUserID")));
			}
		}

		if(!$request->HourMinTerm)
			$request->merge(array('HourMinTerm' => 1));
		
		if(!$request->DayMinTerm)
			$request->merge(array('DayMinTerm' => 1));
		
		if(!$request->WeekMinTerm)
			$request->merge(array('WeekMinTerm' => 1));
		
		if(!$request->MonthMinTerm)
			$request->merge(array('MonthMinTerm' => 1));
		
		if(!empty($request->original_point))
		{
			$request->merge(array('original_point' => implode (",", $request->original_point)));
		}
		if(!empty($request->Skills))
		{
			$request->merge(array('Skills' => implode (",", $request->Skills)));
		}
		if(!empty($request->OtherFacilities))
		{
			$request->merge(array('OtherFacilities' => implode (",", $request->OtherFacilities)));
		}
		
		if($request->Type == SPACE_FIELD_SHARE_DESK)
		{
			$request->merge(array('Capacity' => 1));
		}
		
		// default status will be private
		//$request->merge(array('status' => ($request->action == 'preview' ? SPACE_STATUS_DRAFT : SPACE_STATUS_PRIVATE)));
		
		if (isset($request->saveDraft))
		{
			$space->status = SPACE_STATUS_DRAFT;
		}
		
		// Save nearest Station;
		$address = $request->Prefecture . $request->Prefecture . $request->Town . $request->Address1 . $request->Address2 . ',' . $request->PostalCode;
		$nearestStation = 	new \App\Library\NearestStation;
		$aStations = $nearestStation->getNearestStations($address);
		$request->merge(array('NearestStations' => json_encode($aStations)));
		
		$space=$space->create($request->except(['_token','dataimage', 'callback', 'action', 'saveDraft']));

		$spaceID=$space->id;
		
		// Save Neareast Station
		\App\Station::where('SpaceID', $spaceID)->delete();
		foreach ($aStations as $station)
		{
			$oStation = new \App\Station;
			$oStation->SpaceId = $spaceID;
			$oStation->Name = $station['name'];
			$oStation->Line = $station['line'];
			$oStation->Postal = $station['postal'];
			$oStation->Prefecture = $station['prefecture'];
			$oStation->Distance = $station['distance'];
			$oStation->Lat = $station['y'];
			$oStation->Long = $station['x'];
			$oStation->save();
		}
		
		$path_tmp = public_path() . "/images/space/tmp/";
		$path = public_path() . "/images/space/";
		$path1 = "/images/space/";

		$mydir=$path.$spaceID;
		$mydir1=$path1.$spaceID;
		if(!is_dir($mydir))
		{
			mkdir($mydir, 0755, true);
		}
		$mydir .="/";
		$mydir1 .="/";

		if(!empty($request->dataimage['main']))
		{
			$main = json_decode($request->dataimage['main']);
			$filename= $main->filename;
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			$newfilename=$mydir.'main_org_'.$spaceID.'.'.$ext;
			$newfilename1=$mydir1.'main_org_'.$spaceID.'.'.$ext;
			
			if (file_exists($path_tmp.$filename))
			{
				rename($path_tmp.$filename, $newfilename);
				
				$filenameT= 'main_'.$main->filename;
				$ext = pathinfo($filenameT, PATHINFO_EXTENSION);
				$newfilenameT=$mydir.'main_'.$spaceID.'.'.$ext;
				$newfilenameT1=$mydir1.'main_'.$spaceID.'.'.$ext;
				rename($path_tmp.$filenameT, $newfilenameT);
				
				$filenameTS= 'small_main_'.$main->filename;
				$ext = pathinfo($filenameTS, PATHINFO_EXTENSION);
				$newfilenameTS=$mydir.'small_main_'.$spaceID.'.'.$ext;
				$newfilenameTS1=$mydir1.'small_main_'.$spaceID.'.'.$ext;
				rename($path_tmp.$filenameTS, $newfilenameTS);
				
				$spaceimg=new Spaceimage;
				$spaceimg->ShareSpaceID=$spaceID;
				$spaceimg->OrgPath=$newfilename1;
				$spaceimg->ThumbPath=$newfilenameT1;
				$spaceimg->SThumbPath=$newfilenameTS1;
				$spaceimg->Main=1;
				$spaceimg->Coords="x1:".$main->x1.",y1:".$main->y1.",x2:".$main->x2.",y2:".$main->y2.",w:".$main->w.",h:".$main->h.",wr:".$main->wr."";
				$spaceimg->save();
			}
		}
		for($i=1;$i<=5;$i++)
		{
			if(!empty($request->dataimage["thumb_$i"]))
			{
				$main = json_decode($request->dataimage['thumb_'.$i]);
				$filename= $main->filename;
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				$newfilename=$mydir.'thumb_'.$i.'_org_'.$spaceID.'.'.$ext;
				$newfilename1=$mydir1.'thumb_'.$i.'_org_'.$spaceID.'.'.$ext;
				
				if (file_exists($path_tmp.$filename))
				{
					rename($path_tmp.$filename, $newfilename);
					
					$filenameT= 'thumb_'.$main->filename;
					$ext = pathinfo($filenameT, PATHINFO_EXTENSION);
					$newfilenameT=$mydir.'thumb_'.$i.'_'.$spaceID.'.'.$ext;
					$newfilenameT1=$mydir1.'thumb_'.$i.'_'.$spaceID.'.'.$ext;
					rename($path_tmp.$filenameT, $newfilenameT);
					
					$filenameTS= 'small_thumb_'.$main->filename;
					$ext = pathinfo($filenameTS, PATHINFO_EXTENSION);
					$newfilenameTS=$mydir.'small_thumb_'.$i.'_'.$spaceID.'.'.$ext;
					$newfilenameTS1=$mydir1.'small_thumb_'.$i.'_'.$spaceID.'.'.$ext;
					rename($path_tmp.$filenameTS, $newfilenameTS);
					
					$spaceimg=new Spaceimage;
					$spaceimg->ShareSpaceID=$spaceID;
					$spaceimg->OrgPath=$newfilename1;
					$spaceimg->ThumbPath=$newfilenameT1;
					$spaceimg->SThumbPath=$newfilenameTS1;
					$spaceimg->Main=0;
					$spaceimg->Coords="x1:".$main->x1.",y1:".$main->y1.",x2:".$main->x2.",y2:".$main->y2.",w:".$main->w.",h:".$main->h.",wr:".$main->wr."";
					$spaceimg->save();
				}
			}
		}

		if ($request->ajax())
		{
			return Response::json(array(
					'success' => $spaceID,
					'HashID' => $space->HashID,
					'url' => getSpaceUrl($space->HashID)
			));
		}
		//	return view('user1.dashboard.select-sharespace');

		//echo $request->dataimage['main'];
		//$request->Skills=implode (",", $request->Skills);
		//print_r($request->except(['_token','dataimage']));
		//return($request->all());
		
		if (auth()->guard('useradmin')->check() && $request->User1ID)
		{
			return redirect('MyAdmin/ShareUser/'.Auth::user()->HashCode . '#tab-2');
		}
		else {
			if (Auth::check())
			{
				return redirect('ShareUser/Dashboard/editspace/' . $space->HashID);
			}
			else{
					
				return redirect('ShareUser/DesirePerson');
			}
		}
	}

	public function shareInfoEditSubmit(Request $request,$id)
	{
		$space=User1sharespace::where('HashID', $id)->firstOrFail();

		if (!auth()->guard('useradmin')->check())
		{
			if($space->User1ID != Auth::user()->id)
			{
				return redirect('/');
			}
			$user = Auth::user();
		}
		else {
			if ($space)
				$user = User1::find($space->User1ID);
			else 
				$user = User1::find($request->User1ID);
		}
		
		
		if (!isset($request->saveDraft))
		{
			$this->validate($request ,[
				'Title'=> 'required' ,
				'PostalCode'=> 'required' ,
				'Type'=> 'required' ,
				'Details'=> 'required' ,
				'FeeType'=> 'required' ,
				'Address1'=> 'required' ,
				]);
		}
		/*$request->merge(array('HashID' => uniqid()));
		 $request->merge(array('User1ID' => $user->id));		*/

		if(!$request->HourMinTerm)
			$request->merge(array('HourMinTerm' => 1));
		
		if(!$request->DayMinTerm)
			$request->merge(array('DayMinTerm' => 1));
		
		if(!$request->WeekMinTerm)
			$request->merge(array('WeekMinTerm' => 1));
		
		if(!$request->MonthMinTerm)
			$request->merge(array('MonthMinTerm' => 1));
		
		if(!empty($request->original_point))
		{
			$request->merge(array('original_point' => implode (",", $request->original_point)));
		}
		
		if(!empty($request->Skills))
		{
			$request->merge(array('Skills' => implode (",", $request->Skills)));
		}
		if(!empty($request->OtherFacilities))
		{
			$request->merge(array('OtherFacilities' => implode (",", $request->OtherFacilities)));
		}
		
		if($request->Type == SPACE_FIELD_SHARE_DESK)
		{
			$request->merge(array('Capacity' => 1));
		}

		$request->merge(array('isOpen24Monday' => $request->isOpen24Monday));
		$request->merge(array('isOpen24Tuesday' => $request->isOpen24Tuesday));
		$request->merge(array('isOpen24Wednesday' => $request->isOpen24Wednesday));
		$request->merge(array('isOpen24Thursday' => $request->isOpen24Thursday));
		$request->merge(array('isOpen24Friday' => $request->isOpen24Friday));
		$request->merge(array('isOpen24Saturday' => $request->isOpen24Saturday));
		$request->merge(array('isOpen24Sunday' => $request->isOpen24Sunday));


		$request->merge(array('isClosedMonday' => $request->isClosedMonday));
		$request->merge(array('isClosedTuesday' => $request->isClosedTuesday));
		$request->merge(array('isClosedWednesday' => $request->isClosedWednesday));
		$request->merge(array('isClosedThursday' => $request->isClosedThursday));
		$request->merge(array('isClosedFriday' => $request->isClosedFriday));
		$request->merge(array('isClosedSaturday' => $request->isClosedSaturday));
		$request->merge(array('isClosedSunday' => $request->isClosedSunday));

		$space->fill($request->except(['_token','dataimage', 'callback', 'action', 'saveDraft', 'tags']));

		// Check this space has slot or not
		$isThisSpaceHasSlot = Spaceslot::isthisSpaceHasSlot($space);
		
		if (!$isThisSpaceHasSlot || $user->IsAdminApproved == 'No')
		{
			// If don't have slot, change status to private
			if ($user->IsAdminApproved == 'No')
			{
				Session::flash('error', trans('common.user1_not_allow_to_make_space_public'));
			}
			$space->IsPublished ='No';
		}
        if (isset($request->status))
		{
				if ($request->status == 1)
			{
				$space->status = 1;
				$space->IsPublished	='Yes';	 
			}
		}
		
		if (isset($request->saveDraft))
		{
			$space->status = SPACE_STATUS_DRAFT;
			$space->IsPublished ='No';
		}
 
		if($request->per_day_status == 1)
		{
			$space->per_day_status = $request->per_day_status;
		}
		else
		{
			$space->per_day_status = 0;
		}


		if($request->per_hour_status == 1)
		{
			$space->per_hour_status = $request->per_hour_status;
		}
		else
		{
			$space->per_hour_status = 0;
		}

		// Save nearest Station;
		$address = $space->Prefecture . $space->Prefecture . $space->Town . $space->Address1 . $space->Address2 . ',' . $space->PostalCode;
		$nearestStation = 	new \App\Library\NearestStation;
		$aStations = $nearestStation->getNearestStations($address);
		$space->NearestStations = json_encode($aStations);
		
		$space->save();
		$spaceID=$space->id;
		

		// Save Neareast Station
		\App\Station::where('SpaceID', $spaceID)->delete();
		foreach ($aStations as $station)
		{
			$oStation = new \App\Station;
			$oStation->SpaceId = $spaceID;
			$oStation->Name = $station['name'];
			$oStation->Line = $station['line'];
			$oStation->Postal = $station['postal'];
			$oStation->Prefecture = $station['prefecture'];
			$oStation->Distance = $station['distance'];
			$oStation->Lat = $station['y'];
			$oStation->Long = $station['x'];
			$oStation->save();
		}
		
		if ($request->tags)
		{
			$tags = explode(',', $request->tags);
			\App\Spacetag::where('SpaceID', $space->id)->delete();
			foreach ($tags as $tag)
			{
				if (!$tag) continue;
				$oTag = new \App\Spacetag;
				$oTag->SpaceID = $space->id;
				$oTag->Name = $tag;
				$oTag->save();
			}
		}
		
		$path_tmp = public_path() . "/images/space/tmp/";
		$path = public_path() . "/images/space/";
		$path1 = "/images/space/";

		$mydir=$path.$spaceID;
		$mydir1=$path1.$spaceID;
		if(!is_dir($mydir))
		{
			mkdir($mydir, 0755, true);
		}
		$mydir .="/";
		$mydir1 .="/";

		if(!empty($request->dataimage['main']))
		{
			$rmd=uniqid();
			$main = json_decode($request->dataimage['main']);
			$filename= $main->filename;
			
			if (file_exists($path_tmp.$filename))
			{
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				$newfilename=$mydir.'main_'.$rmd.'_org_'.$spaceID.'.'.$ext;
				$newfilename1=$mydir1.'main_'.$rmd.'_org_'.$spaceID.'.'.$ext;
				rename($path_tmp.$filename, $newfilename);
				
				$filenameT= 'main_'.$main->filename;
				$ext = pathinfo($filenameT, PATHINFO_EXTENSION);
				$newfilenameT=$mydir.'main_'.$rmd.'_'.$spaceID.'.'.$ext;
				$newfilenameT1=$mydir1.'main_'.$rmd.'_'.$spaceID.'.'.$ext;
				rename($path_tmp.$filenameT, $newfilenameT);
				
				$filenameTS= 'small_main_'.$main->filename;
				$ext = pathinfo($filenameTS, PATHINFO_EXTENSION);
				$newfilenameTS=$mydir.'small_main_'.$rmd.'_'.$spaceID.'.'.$ext;
				$newfilenameTS1=$mydir1.'small_main_'.$rmd.'_'.$spaceID.'.'.$ext;
				rename($path_tmp.$filenameTS, $newfilenameTS);
				
				if(!empty($request->dataimage['main_id']))
				{
					$spaceimg=Spaceimage::find($request->dataimage['main_id']);
				}
				else{
					$spaceimg=new Spaceimage;
				}
				$spaceimg->ShareSpaceID=$spaceID;
				$spaceimg->OrgPath=$newfilename1;
				$spaceimg->ThumbPath=$newfilenameT1;
				$spaceimg->SThumbPath=$newfilenameTS1;
				$spaceimg->Main=1;
				$spaceimg->Coords="x1:".$main->x1.",y1:".$main->y1.",x2:".$main->x2.",y2:".$main->y2.",w:".$main->w.",h:".$main->h.",wr:".$main->wr."";
				$spaceimg->save();
			}
		}
		for($i=1;$i<=5;$i++)
		{
			if(!empty($request->dataimage["thumb_$i"]))
			{
				$rmd=uniqid();
				$main = json_decode($request->dataimage['thumb_'.$i]);
				$filename= $main->filename;
				
				if (file_exists($path_tmp.$filename))
				{
					$ext = pathinfo($filename, PATHINFO_EXTENSION);
					$newfilename=$mydir.'thumb_'.$rmd.'_org_'.$spaceID.'.'.$ext;
					$newfilename1=$mydir1.'thumb_'.$rmd.'_org_'.$spaceID.'.'.$ext;
					rename($path_tmp.$filename, $newfilename);
					
					$filenameT= 'thumb_'.$main->filename;
					$ext = pathinfo($filenameT, PATHINFO_EXTENSION);
					$newfilenameT=$mydir.'thumb_'.$rmd.'_'.$spaceID.'.'.$ext;
					$newfilenameT1=$mydir1.'thumb_'.$rmd.'_'.$spaceID.'.'.$ext;
					rename($path_tmp.$filenameT, $newfilenameT);
					
					$filenameTS= 'small_thumb_'.$main->filename;
					$ext = pathinfo($filenameT, PATHINFO_EXTENSION);
					$newfilenameTS=$mydir.'small_thumb_'.$rmd.'_'.$spaceID.'.'.$ext;
					$newfilenameTS1=$mydir1.'small_thumb_'.$rmd.'_'.$spaceID.'.'.$ext;
					rename($path_tmp.$filenameTS, $newfilenameTS);
					
					if(!empty($request->dataimage["thumb_".$i."_id"]))
					{
						$spaceimg=Spaceimage::find($request->dataimage["thumb_".$i."_id"]);
					}
					else{
						$spaceimg=new Spaceimage;
					}
					$spaceimg->ShareSpaceID=$spaceID;
					$spaceimg->OrgPath=$newfilename1;
					$spaceimg->ThumbPath=$newfilenameT1;
					$spaceimg->SThumbPath=$newfilenameTS1;
					$spaceimg->Main=0;
					$spaceimg->Coords="x1:".$main->x1.",y1:".$main->y1.",x2:".$main->x2.",y2:".$main->y2.",w:".$main->w.",h:".$main->h.",wr:".$main->wr."";
					$spaceimg->save();
				}
			}
		}


		if ($request->ajax())
		{
			return Response::json(array(
				'success' => $spaceID,
				'HashID' => $space->HashID,
				'url' => getSpaceUrl($space->HashID)
			));
		}

		if (auth()->guard('useradmin')->check() && isset($request->tags))
		{
			return redirect('MyAdmin/ShareUser/'.$user->HashCode.'/EditSpace/'.$id);
		}
		else{
			return redirect('ShareUser/Dashboard/editspace/'.$id);			
		}


		//return($request->all());
	}
	function shareSpaceList()
	{
		$user=User1::find(Auth::user()->id);
		$spaces=$user->spaces;
		return view('user1.dashboard.list-myspaces',compact('spaces','user'));
	}

	function shareSpaceList1()
	{
		$user=User1::find(Auth::user()->id);
		$spaces=$user->spaces;
		$groupedSpaces = array();
		$aNoScheduleSpace = array();
		foreach ($spaces as $space)
		{
			$isThisSpaceHasSlot = (boolean)Spaceslot::isthisSpaceHasSlot($space);
			$space->isThisSpaceHasSlot = $isThisSpaceHasSlot;
			$aNoScheduleSpace[$space->FeeType] = !isset($aNoScheduleSpace[$space->FeeType]) ? 0 : $aNoScheduleSpace[$space->FeeType];
			$aNoScheduleSpace[$space->FeeType] = $aNoScheduleSpace[$space->FeeType] + ($isThisSpaceHasSlot ? 0 : 1);
			$groupedSpaces[$space->FeeType][] = $space;
		}
		ksort($groupedSpaces);
			
		return view('user1.dashboard.list-myspaces-new',compact('spaces', 'groupedSpaces','user', 'aNoScheduleSpace'));
	}

	function shareSpaceCalendar(Request $request) {
		if ($request->ajax())
		{
			if (!$request->spaceID) return '';

			$space=User1sharespace::where('id', (int)$request->spaceID)->firstOrFail();
			$bookedSpace = \App\Bookedspace::where('SpaceID', $space->id)->where('User1ID', $space->User1ID)->first();
			
			$dateNames = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
			foreach ( $dateNames as $dateName )
			{
				if (!$space['isOpen24' . $dateName])
				{
					$startTime = strtotime($space[$dateName . 'StartTime']);
					$endTime = strtotime($space[$dateName . 'EndTime']);
					if ($startTime >= $endTime)
					{
						$space['isClosed' . $dateName] = true;
					}
				}
				else {
					$space[$dateName . 'StartTime'] = '0:00 AM';
					$space[$dateName . 'EndTime'] = '11:00 PM';
					$space['isClosed' . $dateName] = false;
				}
			}
			$feeTypeArray = array(
					1 => 'HourSpace',
					2 => 'DailySpace',
					3 => 'WeeklySpace',
					4 => 'MonthlySpace',
					5 => 'DailySpace,HourSpace',
					6 => 'WeeklySpace,DailySpace',
					7 => 'MonthlySpace,WeeklySpace'
			);

			$aFreeType = explode(',',$feeTypeArray[$space['FeeType']]);
			$spaceSlots = SpaceSlot::getSpaceSlotBySpaceIDAndType($space['id'], trim($aFreeType[0]));
			$calendarEvents = array();
			if (count($spaceSlots))
			{
				for ($i = 0; $i < count($spaceSlots); $i++)
				{
					$indexSlot = $i;
					$slot = $spaceSlots[$i];
					
					if ($bookedSpace)
					{
						$slot->Status = (isCoreWorkingOrOpenDesk($bookedSpace) && $slot->total_booked >= 1) ? SLOT_STATUS_BOOKED : $slot->Status;
					}
					
					$descriptionContent = array();
					
					$calendarEvents[$indexSlot]['start'] = $slot->StartDate . 'T'. $slot->StartTime;
					$calendarEvents[$indexSlot]['end'] = $slot->EndDate . 'T'. $slot->EndTime;
					$calendarEvents[$indexSlot]['id'] = $slot->id;
					$calendarEvents[$indexSlot]['type'] = $slot->Type;
					
					$calendarEvents[$indexSlot]['backgroundColor'] = $slot->Status ? '#F00' : '#3a87ad';
					$calendarEvents[$indexSlot]['title'] = $slot->Status ? '予約済' : '予約受付中';
					$calendarEvents[$indexSlot]['description'] = $slot->Status ? '' : '';
					$calendarEvents[$indexSlot]['editable'] = $slot->Status ? false : true;
					$calendarEvents[$indexSlot]['className'] = $slot->Status ? 'booked' : 'available';
					if ($slot->ParentID == 0 && $slot->total_booked && $space->FeeType == SPACE_FEE_TYPE_HOURLY)
					{
						$calendarEvents[$indexSlot]['rendering'] = 'background';
						$calendarEvents[$indexSlot]['backgroundColor'] = '3a87ad';
					}
					
					if ($bookedSpace && !isCoreWorkingOrOpenDesk($bookedSpace))
					{
						$calendarEvents[$indexSlot]['is_single'] = '1';
					}
			

					if ($calendarEvents[$indexSlot]['type'] != 'HourSpace')
					{
						$calendarEvents[$indexSlot]['constraint'] = null;
						$calendarEvents[$indexSlot]['overlap'] = true;
					}

					if ($calendarEvents[$indexSlot]['type'] == 'DailySpace')
					{
						//$calendarEvents[$indexSlot]['title'] = '';
					}
					
					// Make booked event wit summary popup data
					if ($slot->Status == SLOT_STATUS_BOOKED)
					{
						$bookedSchedules = Rentbookingsave::select('rentbookingsaves.*')->where('rentbookingsaves.user1sharespaces_id', $space['id'])
										->whereIn('rentbookingsaves.status', array(
												BOOKING_STATUS_PENDING, 
// 												BOOKING_STATUS_CALCELLED, 
// 												BOOKING_STATUS_REFUNDED,
												BOOKING_STATUS_RESERVED,
												BOOKING_STATUS_COMPLETED));
						$bookedSchedules = $bookedSchedules->join('bookedspaceslots', 'rentbookingsaves.id', '=' ,'bookedspaceslots.BookedID');
						$bookedSchedules = $bookedSchedules->where('bookedspaceslots.SlotID', $slot->id);
						$bookedSchedules = $bookedSchedules->where('bookedspaceslots.Status', SLOT_STATUS_BOOKED);
						
						$bookedSchedules = $bookedSchedules->get();
						
						$isContinue = true;
						$multipleBookedIds = array();
						$aColor = array('#8995FB', '#9CA2D6', '#9CC9D6', '#67BBD4', '#0DC8FF', '#1DE2D0', '#10B7A8', '#0BB155', '#C781F3', '#D5B5E8', '#EFA7E2', '#E25DB3');
						$addedColor = array();
						foreach ($bookedSchedules as $indexBookedSchedule => $bookedSchedule)
						{
							if ($bookedSchedule)
							{
								$bookedSpace = \App\Bookedspace::where('BookedID', $bookedSchedule->id)->first();
								$bookedSlot = \App\Bookedspaceslot::where('BookedID', $bookedSchedule->id)->first();
							}
							
							if ($bookedSchedule && $bookedSchedule->status == BOOKING_STATUS_REFUNDED)
							{
								$slot->Status = SLOT_STATUS_AVAILABLE;
								$calendarEvents[$indexSlot]['backgroundColor'] = $slot->Status ? '#F00' : '#3a87ad';
								$calendarEvents[$indexSlot]['title'] = $slot->Status ? '予約済' : '予約受付中';
								$calendarEvents[$indexSlot]['description'] = $slot->Status ? '' : '';
								$calendarEvents[$indexSlot]['editable'] = $slot->Status ? false : true;
								$calendarEvents[$indexSlot]['className'] = $slot->Status ? 'booked' : 'available';
							}
							elseif (!$bookedSchedule || !@$bookedSpace || !@$bookedSlot || in_array($bookedSchedule->status, array(BOOKING_STATUS_CALCELLED)))
							{
								$isContinue = false;
								break;
							}
								
							$duration = getSpaceSlotDuration($bookedSlot, false, $bookedSchedule);
							$unitPrice = getPrice($bookedSpace, false, $bookedSlot->StartDate, false, false);
							
							if (!isCoreWorkingOrOpenDesk($bookedSpace))
							{
								// For single booking in one slot
								$descriptionContent[] = '<span class="booked_id_text">'. trans('common.Booked ID:') .'<span> ' . '<span class="booked_id">#' . $bookedSchedule->id . '</span>';
								$descriptionContent[] = '<span class="booked_date_text">'. trans('common.Booked Date:') .'<span> ' . '<span class="booked_date">' . renderJapaneseDate($bookedSchedule->created_at, false) . '</span>';
								$descriptionContent[] = '<span class="booked_user_text">'. trans('common.Booked User:') .'<span> ' . '<span class="booked_user">' . getUserName($bookedSchedule->rentUser) . '</span>';
								if ($bookedSlot->Type == 'DailySpace' || $bookedSlot->Type == 'HourSpace')
								{
									$descriptionContent[] = '<span class="booked_time_text">'. trans('common.Time Range:') .'<span> ' . '<span class="booked_time">' . getTimeFormat($bookedSlot->StartTime) .' - ' . getTimeFormat($bookedSlot->EndTime) . '</span>';
								}
								$descriptionContent[] = '<span class="booked_price_text">'. trans('common.Booked Price:') .'</span> ' . '<span class="booked_price">' . priceConvert($unitPrice, true) . '</span>';
								$descriptionContent[] = '<span class="booked_status_text">'. trans('common.Booking Status:') .'</span> ' . '<span class="booked_status">' . getBookingPaymentStatus($bookedSchedule) . '</span>';
							}
							else {
								// For Multiple booking in one slot
								$multipleBookedIds[] = $bookedSchedule->id;
								if ($indexBookedSchedule == count($bookedSchedules) - 1)
								{
									$descriptionContent[] = '<span class="booked_id_text">'. trans('common.Booked ID:') .'<span> ' . '<span class="booked_id">#' . implode(', #', $multipleBookedIds) . '</span>';
									$descriptionContent[] = '<span class="booked_date_text">'. trans('common.Booked Date:') .'<span> ' . '<span class="booked_date">' . renderJapaneseDate($bookedSlot->created_at, false) . '</span>';
									if ($bookedSlot->Type == 'DailySpace' || $bookedSlot->Type == 'HourSpace')
									{
										$descriptionContent[] = '<span class="booked_time_text">'. trans('common.Time Range:') .'<span> ' . '<span class="booked_time">' . getTimeFormat($bookedSlot->StartTime) .' - ' . getTimeFormat($bookedSlot->EndTime) . '</span>';
									}
									if ($space->FeeType != SPACE_FEE_TYPE_HOURLY)
									{
										$descriptionContent[] = '<span class="booked_capacity_text">'. trans('common.Capacity:') .'<span> ' . '<span class="capacity_id">' . count($bookedSchedules) . '/'. $space->Capacity .'</span>';
									}
									elseif(count($multipleBookedIds)){
										$randomColor = '';
										while(!$randomColor) {
											if (count($addedColor) == count($aColor))
											{
												$addedColor = array();
											}
											$randomColorKey = array_rand($aColor);
											$randomColor = $aColor[$randomColorKey];
											if (in_array($randomColor, $addedColor))
											{
												$randomColor = '';
											}
											else{
												$addedColor[] = $randomColor;
											}
										}
										$calendarEvents[$indexSlot]['backgroundColor'] = $randomColor . ' !important';
									}
								}
							}
						}
						
						if ($isContinue == false || !count($bookedSchedules))
						{
							$slot = Spaceslot::find($slot->id);
							if (($slot->ParentID > 0 && $space->FeeType == SPACE_FEE_TYPE_HOURLY) || $space->FeeType != SPACE_FEE_TYPE_HOURLY)
							{
								// If status is not acceptable like Cancelled, refund, draft, restore it to variable slot
								$spaceSlots[$i]->total_booked = $slot->total_booked = ($slot->total_booked > 0 ? $slot->total_booked - 1 : 0);
								$slot->save();
								
								$oParentSlot = Spaceslot::where('id', $slot->ParentID)->where('Type', 'HourSpace')->first();
								if ($space->FeeType == SPACE_FEE_TYPE_HOURLY)
								{
									// Remove issue slot
									if ($slot->total_booked == 0)
									{
										$spaceSlots[$i]->Status = $slot->Status = -1;
										$slot->save();
									}
									
									if (isCoreWorkingOrOpenDesk($space)) {
										if ($oParentSlot)
										{
											// Query to get all booked slot of this parent slot
											$oaBookedSlots = Spaceslot::select('total_booked')->where('ParentID', $slot->ParentID)->where('Type', 'HourSpace')->get();
											$total_booked = 0;
											foreach ($oaBookedSlots as $oaBookedSlot)
											{
												$total_booked += $oaBookedSlot->total_booked;
											}
											$oParentSlot->total_booked = $total_booked;
											$oParentSlot->save();
										}
									}
								}
								else {
									$spaceSlots[$i]->Status = $slot->Status = isCoreWorkingOrOpenDesk($space) && $space['Capacity'] <= $slot->total_booked ? SLOT_STATUS_BOOKED : SLOT_STATUS_AVAILABLE;
									$slot->save();
								}
								// Back one step to show this slot is avaiable instead booked
								$i-- ;
								
								continue;
							}
						}
						
						$calendarEvents[$indexSlot]['description'] = implode(('<br />'), $descriptionContent);
						$calendarEvents[$indexSlot]['url'] = 'javascript:void(0)';
					}
				}
			}
			$calendarEvents = json_encode(array_values($calendarEvents));
			return view('user1.dashboard.calendar',compact('space','user','calendarEvents'));
		}
		else {
			$user=User1::find(Auth::user()->id);
			$spaces=$user->spaces;
			$groupedSpaces = array();
			$firstSpace = false;
			
			foreach ($spaces as $spaceIndex => $space)
			{
				$isThisSpaceHasSlot = (boolean)Spaceslot::isthisSpaceHasSlot($space);
				$space->isThisSpaceHasSlot = $isThisSpaceHasSlot;
				$groupedSpaces[$space->FeeType][] = $space;
				
				if ($firstSpace === false) {
					$firstSpace = $space;
				}
			}
			
			ksort($groupedSpaces);
			return view('user1.dashboard.space-calendar',compact('groupedSpaces', 'firstSpace', 'user'));
		}
	}

	public function dashboard(Request $request)
	{
		$user=User1::find(Auth::user()->id);
		$spaces=$user->spaces;
		
		$bank= User1paymentinfo::firstOrNew(array('User1ID' => Auth::user()->id));;
		
		// Create Booking Notification
		$aNotifications = array();
		$aNotificationTimes = Notification::select('Time')
			->whereIn('Type', getUser1DashboardNotifications())
			->where('UserReceiveID', $user->id)
			->where('UserSendType', 2)
			->where('UserReceiveType', 1)
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
				if (in_array($notification['Type'], getUser1BookingNotifications()))
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
		
		
		if (IsAdminApprovedUser($user))
		{
			// Find User 2 matched with Disired Person fields (Business Type, Skills...)
			$conditions = array(
					'BusinessKindWelcome' => array($user->BusinessKindWelcome),
					'Skills' => explode(',', $user->Skills),
					'Sex' => array(getUserSexMapper()[$user->DisiredSex]),
					'BirthYear' => $user->DisiredAge,
			);
			$user2s = \App\User2::getMatchedRentUser($conditions);
			$user2s = $user2s->isApproved()->inRandomOrder()->take(2)->get();
		}
		else {
			$user2s = array();
		}
		
		$bookingHistories = \App\Rentbookingsave::where('User1ID', $user->id)->where('status', '<>', BOOKING_STATUS_DRAFT)->orderBy('updated_at', 'DESC')->take(10)->get();
		
		if ($request->ajax() && $request->page)
		{
			if (count($aNotificationTimes))
				return view('user1.dashboard.dashboard-shareuser-feed',compact('user', 'user2s', 'bank', 'spaces'));
			else exit();
		}
		
		return view('user1.dashboard.dashboard-shareuser',compact('user', 'user2s', 'bank', 'spaces', 'bookingHistories'));

	}
	
	public function RecommendUser(Request $request) {
		$user=User1::find(Auth::user()->id);
		if (!IsAdminApprovedUser($user))
		{
			Session::flash('error', trans('common.user1_not_allow_to_see_rent_list'));
			return redirect('/ShareUser/Dashboard');	
		}
		
		// Find User 2 matched with Disired Person fields (Business Type, Skills...)
		$conditions = array(
				'BusinessKindWelcome' => array($user->BusinessKindWelcome),
				'Skills' => explode(',', $user->Skills),
				'Sex' => array(getUserSexMapper()[$user->DisiredSex]),
				'BirthYear' => $user->DisiredAge,
		);
		$user2s = \App\User2::getMatchedRentUser($conditions);
		
		$user2s= $user2s->isApproved()->paginate(10);
		$user2s->appends($request->except(['page']))->links();
		
		return view('user1.dashboard.list-recommenduser',compact('user2s', 'user'));
	}
	
	public function myPage()
	{
		$userErrors = array();
		$user=User1::find(Auth::user()->id);
		//show if user is not approval yet
		if (!User1::isAdminApproved($user) and count($user->certificates) >= 1) {
			$userErrors['approve']['message'] = '審査中の為、アカウント権限が制限されています。'; 
		}
		//show if cerdificate is not completed and not approval yet
		if (!count($user->certificates)) {
			$userErrors['certificates']['message'] = '証明書の提出が完了していないため、アカウント権限が制限されています。';
			$userErrors['certificates']['url'] = User1::getCertificatePageUrl();
			$userErrors['certificates']['button'] = '証明書の提出';
		}
			$total_spaces= 0;
			$public_spaces=0;
			$private_spaces=0;
			$draft_spaces=0;
		//show if no space is added yet
		if (!count($user->spaces)) {
			$userErrors['spaces']['message'] = 'スペースがまだ追加されていません。';
			$userErrors['spaces']['url'] = User1::getListSpaceUrl();
			$userErrors['spaces']['button'] = 'スペースの追加';
		}
		//show if a space doesn't have schedule yet
		else {
		    $total_spaces= count($user->spaces);
			$isHasSpaceSlot = false; 
			foreach ($user->spaces as $space)
			{
				if (count($space->spaceAvailable))
					$isHasSpaceSlot = true;
				
				if($space->status==SPACE_STATUS_PUBLIC)
				{
					$public_spaces +=1;
				}
				
				if($space->status==SPACE_STATUS_PRIVATE)
				{
					$private_spaces +=1;
				}
				
				if($space->status==SPACE_STATUS_DRAFT)
				{
					$draft_spaces +=1;
				}
			}
			if (!$isHasSpaceSlot)
			{
				$userErrors['schedule']['message'] = 'スペースに予約可能日が設定されていません。';
				$userErrors['schedule']['url'] = User1::getCalendarSpaceUrl();
				$userErrors['schedule']['button'] = '予約可能日を設定';
			}
		}
		
			$reviewList= new \App\Userreview();
			$groupedReviews = array();
			$allReviewsTmp = $reviewList->where('ReviewedBy', 'User2')->where('user1ID', $user->id)->orderBy('created_at', 'DESC')->get();
			$allReviews = array();
			foreach ($allReviewsTmp as $review)
			{
				$slots_id=explode(';', $review['booking']['spaceslots_id']);
				$slots_data=Spaceslot::whereIn('id', array_filter(array_unique($slots_id)))->orderBy('StartDate','asc')->get();
				if (count($slots_data))
				{
					$review['booking']['slotID'] = $slots_data;
					$allReviews[] = $review;
				}
			}
			
			$user = User1::find($user->id);
			$spaceIDs = array();
			foreach ( $user->availableSpaces as $space)
			{
				$spaceIDs[] = $space->id;
			}
			
			if (!empty($spaceIDs))
				$waitingReviews = Rentbookingsave::whereIn('user1sharespaces_id', $spaceIDs)->where('status', BOOKING_STATUS_COMPLETED)->orderBy('created_at', 'DESC')->get();
			else
				$waitingReviews = array();
			
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
					$slots_data=Spaceslot::whereIn('id', array_filter(array_unique($slots_id)))->orderBy('StartDate','asc')->get();
					if (count($slots_data))
					{
						$waitingReview['slotID'] = $slots_data;
						$groupedReviews[0][] = $waitingReview;
						$groupedReviews[-1][] = $waitingReview;
					}
				}
			}
			
			foreach ($allReviews as $review)
			{
				$groupedReviews[$review['Status']][] = $review;
				$groupedReviews[-1][] = $review;;
			}
			
			ksort($groupedReviews);
			
			$spaces = $user->availableSpaces;
			$groupedSpaces = array();
			$fav_cnt=0;
			foreach ( $spaces as $spaceIndex => $space )
			{
				$groupedSpaces[$space->FeeType][] = $space;
				$fav_cnt=$fav_cnt+$space->favorites->count();
			}
			ksort($groupedSpaces);
			
			// Get Booking status
			$allDatas = Rentbookingsave::select('rentbookingsaves.*')
			->where('rentbookingsaves.InvoiceID', '<>', '')
			->where('rentbookingsaves.User1ID', $user->id)
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
		return view('user1.dashboard.mypage-shareuser',compact(
				'user','userErrors', 'groupedReviews', 'fav_cnt', 'total_spaces',
				'public_spaces','private_spaces','draft_spaces',
				'aDataStatus', 'totalCountStatus'
		));

	}
	
	public function invoiceList(Request $request)
	{
		$user=User1::find(Auth::user()->id);
		$invoices = Rentbookingsave::where('User1ID', $user->id)
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
		
		return view('user1.dashboard.invoice-shareuser',compact('user', 'invoices'));

	}
	
	public function invoiceDetail($id)
	{
		$user=User1::find(Auth::user()->id);
		$booking = Rentbookingsave::where('InvoiceID', $id)->first();
		
		$aFlexiblePrice = Rentbookingsave::getInvoiceBookingPayment($booking);
		$prices = $aFlexiblePrice['prices'];
		$refundamount = priceConvert(ceil($booking->refund_amount));
		$totalPrice = priceConvert($aFlexiblePrice['totalPrice'], true);
		$remaining_amont=abs($aFlexiblePrice['totalPrice'] - $booking->refund_amount);
		
		return view('user1.dashboard.invoice-details-shareuser',compact('user', 'booking', 'prices','refundamount','remaining_amont'));
	}
	public function editBooking($id)
	{
		$Paypalbilling = new Paypalbilling;
		$user=User1::find(Auth::user()->id);
		$rentBooking = new Rentbookingsave();
		
		$rent_data = Rentbookingsave::Where('id', $id)->first();
		
		if($rent_data == null)
			 return redirect('/ShareUser/Dashboard/BookList?msb=booking+not+exist');
		
		$refundamount = priceConvert(ceil($rent_data['refund_amount']));
		$rent_data->isArchive = true;
		$aFlexiblePrice = getFlexiblePrice($rent_data, new \App\Bookedspaceslot());
		
		$subTotal = priceConvert($aFlexiblePrice['subTotal'], true);
		$subTotalIncludeTax = priceConvert($aFlexiblePrice['subTotalIncludeTax'], true);
		$subTotalIncludeChargeFee = priceConvert($aFlexiblePrice['subTotalIncludeChargeFee'], true);
		$totalPrice = priceConvert($aFlexiblePrice['totalPrice'], true);
		$remaining_amont=abs($aFlexiblePrice['totalPrice'] - $rent_data->refund_amount);
		$prices = $aFlexiblePrice['prices'];
		
		$usershares=User1sharespace::where('User1ID', Auth::user()->id)->get();
		$spaceslots=SpaceSlot::where('SpaceID', $rent_data['user1sharespaces_id'])->get();
		$bookingHistories = \App\Bookinghistory::where('BookedID', $rent_data->id)->orderBy('updated_at', 'DESC')->get();
		$finalCancling = $rent_data->finalCancel;
		
		if ($rent_data->recur_id && in_array($rent_data->status, array(BOOKING_STATUS_RESERVED, BOOKING_STATUS_PENDING)))
		{
			$rentBooking->storeRecursionHistory(array($rent_data));
		}
		return view('user1.dashboard.edit-booking-shareuser',compact(
				'user','rent_data','usershares','spaceslots', 'prices', 'subTotal', 
				'subTotalIncludeTax', 'subTotalIncludeChargeFee', 'totalPrice' , 'refundamount',
				'remaining_amont', 'bookingHistories' ,'finalCancling'
		));

	}
	
	public function EditBookSave(Request $request,$id){}
	
	public function acceptPayment(Request $request)
	{
		$input=$request->all();
		$rentbooking = new Rentbookingsave();
		
		if (auth()->guard('useradmin')->check())
		{
			$rent_data = Rentbookingsave::where('id', @$input['id'])->first();
			$user = User1::find($rent_data->User1ID);
		}
		else {
			$user = Auth::guard('user1')->user();
			$rent_data=Rentbookingsave::where('id', @$input['id'])->where('User1ID', $user->id)->first();
		}
		
		try {
			if (!$rent_data)
			{
				Session::flash('error', 'booking_list.Error Occured, Please try again');
				return redirect::back();
			}
			
			switch ($input['type'])
			{
				case 'accept':
					$response = $rentbooking->processPaidPayment($rent_data, false);
					break;
					
				case 'reject':
				case 'refund':
					$response = $rentbooking->processCancelPayment($rent_data, false);
					break;
			}
			
			if (isset($response))
			{
				if ($response === true)
				{
					// success
					Session::flash('success', '予約ステータスの更新に成功しました。');
					return redirect::back();
				}
				elseif (isset($response['error'])){
					// failed
					$message = is_string($response['response']) ? $response['response'] : $response['response']->getMessage();
					Session::flash('error', $message);
					return redirect::back();
				}
				else {
					Session::flash('error', 'booking_list.Error Occured, Please try again');
					return redirect::back();
				}
			}
			
		} catch (\Exception $e) {
			return redirect::back()
			->withErrors($e->getMessage())
			->withInput();
		}
		return redirect::back();	
	}
	
	public function offerList(Request $request)
	{
		// User get User 2 from notifications
		$notifications = Notification::with('user2Receive')
				->where('UserSendID', Auth::user()->id)
				->where('UserSendType', 1)
				->where('UserReceiveType', 2)
				->where('Type', NOTIFICATION_SPACE)
				->groupBy('UserReceiveID')
		;
		
		$notifications= $notifications->paginate(LIMIT_OFFERS);
		$notifications->appends($request->except(['page']))->links();
		$user1=User1::find(Auth::user()->id);
		return view('user1.dashboard.offerlist-shareuser',compact('user1', 'notifications'));

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
				imagejpeg($newImage,$thumb_image_name,100);
				break;
			case "image/png":
			case "image/x-png":
				imagepng($newImage,$thumb_image_name);
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

	public function dashboardshareInfoUpload(Request $request,User1 $user1)
	{
		$upload_path_tmp = public_path() . "/images/space/tmp/";
		$upload_path = public_path() . "/images/space/";
		$upload_path_url = url('/') . "/images/space/";
		$upload_path_tmp_url = url('/') . "/images/space/tmp/";
		$upload_path_usr = public_path() . "/images/user/";
		$upload_path_usr_url = url('/') . "/images/user/";

		$thumb_width = "130";
		$large_width = '750';

		if (isset($_POST["upload_thumbnail"])) {

			$filename = $_POST['filename'];
			// 			if(file_exists($filename))
				// 			{
				// 				copy($filename, $upload_path_tmp . basename($filename));
				// 				$filename = basename($filename);
				// 			}
				if (!file_exists($upload_path_tmp.$filename))
				{
					// In this case file original moved to real folder
					$upload_path_tmp = $upload_path;
				}
				if (file_exists($upload_path_usr.$filename) ) {
					$upload_path_tmp = $upload_path_usr;
					$upload_path_tmp_url = $upload_path_usr_url;
					
				}

				$large_image_location = $upload_path_tmp.$filename;
				$x1 = $_POST["x1"];
				$y1 = $_POST["y1"];
				$x2 = $_POST["x2"];
				$y2 = $_POST["y2"];
				$w = $_POST["w"];
				$h = $_POST["h"];

				// Create Thumb
				if (strpos($filename, 'thumb_') !== false)
				{
					$scale = $large_width/$w;
					$scale1 = $thumb_width/$w;
					$thumb_image_location = $upload_path_tmp."thumb_".$filename;
					$thumb_image_location1 = $upload_path_tmp."small_thumb_".$filename;
					$image_url = $upload_path_tmp_url ."thumb_".$filename;
					$cropped = $this->resizeThumbnailImage($upload_path, $thumb_image_location, $large_image_location,$w,$h,$x1,$y1,$scale);
					$cropped1 = $this->resizeThumbnailImage($upload_path, $thumb_image_location1, $large_image_location,$w,$h,$x1,$y1,$scale1);
				}
				else {
					// Create Main
					$scale = $large_width/$w;
					$scale1 = $thumb_width/$w;
					$thumb_image_location = $upload_path_tmp."main_".$filename;
					$thumb_image_location1 = $upload_path_tmp."small_main_".$filename;
					$image_url = $upload_path_tmp_url ."main_".$filename;
					$cropped = $this->resizeThumbnailImage($upload_path, $thumb_image_location, $large_image_location,$w,$h,$x1,$y1,$scale);
					$cropped1 = $this->resizeThumbnailImage($upload_path, $thumb_image_location1, $large_image_location,$w,$h,$x1,$y1,$scale1);
				}

				echo json_encode(array('file_orig'=> $upload_path_tmp_url . $filename, 'file_thumb' => $image_url, 'file_name' => $filename));
				exit();
				}
		}


		public function dashboardHostSettingUpload(Request $request,User1 $user1)
		{
			$upload_path_tmp = public_path() . "/images/user/";
			$upload_path = public_path() . "/images/user/";
			$upload_path_url = url('/') . "/images/user/";
			$upload_path_tmp_url = url('/') . "/images/user/";
			$up="/images/user/";

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
				$thumb_image_location = $upload_path_tmp.$un.$filename;
				$image_url = $upload_path_tmp_url .$un.$filename;
				$cropped = $this->resizeThumbnailImage($upload_path, $thumb_image_location, $large_image_location,$w,$h,$x1,$y1,$scale);

				echo json_encode(array('file_orig'=> $upload_path_tmp_url . $filename, 'file_thumb' => $image_url, 'file_name' => $filename, 'file_thumb_path' => $up . $un . $filename ));
				exit();
			}
		}

		public function hostSetting()
		{
			$user=User1::find(Auth::user()->id);
			$user->Skills = explode("," , $user->Skills);
			$bank= User1paymentinfo::firstOrNew(array('User1ID' => Auth::user()->id));;
			$hosts=$user->host;
			$certificates=$user->certificates;
			return view('user1.dashboard.hostsetting-shareuser',compact('user','bank','hosts','certificates'));

		}
		
		public function Certificate(Request $request){
			$user = Auth::user();
			if ($request->isMethod('post'))
			{
				if ($request->hasFile('certificate')) {
					$f=$request->file('certificate');
					$destinationPath = public_path() . "/certificate";
					foreach($f as $f1)
					{
						$fileName=uniqid().$f1->getClientOriginalName();

						$validator = Validator::make(
								array('file' => $f1),
								array('file' => 'required|mimes:jpeg,jpg,bmp,gif,png,pdf,doc,docx')
						);

						if ($validator->passes()) {
							$f1->move($destinationPath, $fileName);
							$cert=new User1certificate();
							$cert->User1ID=Auth::guard('user1')->user()->id;
							$cert->HashID=uniqid();
							$cert->Path="/certificate/".$fileName;
							$cert->FileType=$request->doctype;
							$cert->Description=$request->Description;
							$cert->save();
						} else {
							// Collect error messages
							Session::flash('error', 'ファイル"' . $f1->getClientOriginalName() . '"がアップロードできません。以下の拡張子を持つファイルのみ、アップロードが可能です。<br/>jpeg, jpg, bmp, gif, png, pdf, doc, docx');
							return redirect('/ShareUser/Dashboard/HostSetting/Certificate');;
						}
					}
				}
				Session::flash('success', trans('common.file_uploaded_successfully'));

				return redirect('/ShareUser/Dashboard/HostSetting/Certificate');;
			}
			elseif ($request->sendAdmin)
			{
				$from = Config::get('mail.from');
				User1certificate::where('User1ID',$user->id)->update(['SentToAdmin' => 1]);
				$user->SentToAdmin = 1;
				$user->save();
				// Send email to admin
				sendEmailCustom ([
						'user1' => $user, 
						'sendTo' => $from['address'], 
						'template' => 'user1.emails.request_approve_certificate', 
						'subject' => 'シェアユーザーから審査証明書提出されました'] 
					);
				
				Session::flash('success', trans('common.file_send_to_admin_successfully'));
				return redirect('/ShareUser/Dashboard/HostSetting/Certificate');;
			}
			elseif ($request->removeID) {
				$cert = User1certificate::find((int)$request->removeID);
				if ($cert)
				{
					$cert->delete();
					Session::flash('success', trans('common.file_deleted_successfully'));
				}
			}
			$user->certificates = $user->certificates()->orderBy('updated_at', 'DESC')->get();
			return view('user1.dashboard.hostsetting-upload-certificate',compact('user'));
		}
		
		public function HostSettingDesiredPerson()
		{
			$user=User1::find(Auth::user()->id);
			$user->Skills = explode("," , $user->Skills);
			return view('user1.dashboard.hostsetting-desired-person',compact('user'));
		
		}
		
		public function iframeMultipleUpload(){
			$hosting_upload_url = url('/') . '/ShareUser/Dashboard/HostSetting/hostingImages';
			return view('pages.multiple_upload', compact('hosting_upload_url'));
		}
		
		
		public function hostingImages(){
			$myUploader = 	new \App\Library\HostingHandler;
		}
		
		public function hostSettingSubmit(Request $request)
		{
			$user=User1::find(Auth::user()->id);
			//return ($request->all());
			if ($request->hasFile('CompanyCertificate')) {
				//return("YEs");
				//print_r($request->file('CompanyCertificate'));
				$f=$request->file('CompanyCertificate');
				$destinationPath = public_path() . "/certificate";
				foreach($f as $f1)
					{
					 $fileName=uniqid().$f1->getClientOriginalName();
				/*$this->validate($request ,[
						'CompanyCertificate'=> 'mimes:jpeg,bmp,png,pdf' ,
						]);*/
				//$fileName=uniqid().".".$request->file('CompanyCertificate')->getClientOriginalExtension();

        $validator = Validator::make(
            array('file' => $f1),
            array('file' => 'required|mimes:jpeg,jpg,bmp,png,pdf,doc,docx')
        );

        if ($validator->passes()) {
           $f1->move($destinationPath, $fileName);
				$cert=new User1certificate();
				$cert->User1ID=Auth::user()->id;
				$cert->HashID=uniqid();
				$cert->Path="/certificate/".$fileName;
				$cert->save();
        } else {
            // Collect error messages
            $error_messages[] = 'File "' . $f1->getClientOriginalName() . '":' . $validator->messages()->first('file');
        }

				}
				$user->CompanyCertificate="/certificate/".$fileName;
				$user->save();
			}
			//die;
			if ($request->has('Logo')) {
				$user->Logo=$request->Logo;
				$user->save();
			}
			if($request->has('Skills')) {
				$user->Skills = implode("," , $request->input('Skills'));
			}

			$user->fill($request->except(['_token','CompanyCertificate','Logo', 'Skills', 'returnURL','oldpassword','password','password_confirmation','UserName','Email']));
			
			$user->save();
			if ($request->returnURL)
				return redirect($request->returnURL);
			else
				return redirect('ShareUser/Dashboard/HostSetting');

			//return($request->all());
		}
		public function SaveBankInfo(Request $request)
		{
			$inputData = $request->formData;
			parse_str($inputData, $formFields);
			$userData = array(
					'AccountType'      => $formFields['AccountType'],
					'AccountName'     =>  $formFields['AccountName'],
					'BankName'     =>  $formFields['BankName'],
					'BranchLocationName'  =>  $formFields['BranchLocationName'],
					'BranchCode' =>  $formFields[ 'BranchCode'],
					'AccountNumber' =>  $formFields[ 'AccountNumber'],
			);

			$user=User1::find(Auth::user()->id);
			$payinfo= User1paymentinfo::firstOrNew(array('User1ID' => Auth::user()->id));;
			$payinfo->fill($userData);

			//echo Auth::user()->id;
			//print_r($payinfo->all());
			//die;
			//$user->bank->fill($request->except(['_token']));
			$user->bank()->save($payinfo);
			//return ($request->all());
			return Response::json(array(
					'success' => true,
					'resp' => 'Inserted'
			));

		}

		public function SaveHostInfo(Request $request)
		{
			$inputData = $request->formData;
			parse_str($inputData, $formFields);
			
			if (isset($request->action) && $request->action == 'remove')
			{
				$host=User1hostmember::where('HashID', $formFields['HashID'])->firstOrFail();
				$host->delete();
			}
			else {
				if(!empty($formFields['HashID']))
				{
					$userData = array(
							'HostLastName'      => $formFields['HostLastName'],
							'HostFirstName'     =>  $formFields['HostFirstName'],
							'HostEmail'     =>  $formFields['HostEmail'],
							'HostMobilePhone'  =>  $formFields['HostMobilePhone'],
							'HostPhoto' =>  $formFields[ 'HostPhoto'],
					);
					$host=User1hostmember::where('HashID', $formFields['HashID'])->firstOrFail();
					$host->fill($userData);
					$host->save();
				}
				else
				{
					$userData = array(
							'HostLastName'      => $formFields['HostLastName'],
							'HostFirstName'     =>  $formFields['HostFirstName'],
							'HostEmail'     =>  $formFields['HostEmail'],
							'HostMobilePhone'  =>  $formFields['HostMobilePhone'],
							'HostPhoto' =>  $formFields[ 'HostPhoto'],
							'HashID' => uniqid(),
					);
					$user=User1::find(Auth::user()->id);
					$host= new User1hostmember();
					$host->fill($userData);
					$user->host()->save($host);
				}
			}
			return Response::json(array(
					'success' => true,
					'resp' => 'Inserted'
			));
		}
		public function delete_files($target) {
			if(is_dir($target)){
				$files = glob( $target . '*', GLOB_MARK ); //GLOB_MARK adds a slash to directories returned

				foreach( $files as $file )
				{
					$this->delete_files( $file );
				}
				if(is_dir($target)){
					rmdir( $target );
				}
			} elseif(is_file($target)) {
				unlink( $target );
			}
		}
		public function review()
		{
			$user1ID = Auth::guard('user1')->user()->id;
			$reviewList= new \App\Userreview();
			$groupedReviews = array();
			$allReviewsTmp = $reviewList->where('ReviewedBy', 'User2')->where('user1ID', $user1ID)->orderBy('created_at', 'DESC')->get();
			$allReviews = array();
			foreach ($allReviewsTmp as $review)
			{
				$slots_data=\App\Bookedspaceslot::where('BookedID', $review['booking']['id'])->orderBy('StartDate','asc')->get();
				
				if (count($slots_data))
				{
					$review['booking']['slotID'] = $slots_data;
					$allReviews[] = $review;
				}
			}
			
			$user = User1::find($user1ID);
			$spaceIDs = array();
			foreach ( $user->availableSpaces as $space)
			{
				$spaceIDs[] = $space->id;
			}
			
			if (!empty($spaceIDs))
				$waitingReviews = Rentbookingsave::whereIn('user1sharespaces_id', $spaceIDs)->where('status', BOOKING_STATUS_COMPLETED)->orderBy('created_at', 'DESC')->get();
			else
				$waitingReviews = array();
			
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
					if (count($slots_data))
					{
						$waitingReview['slotID'] = $slots_data;
						$groupedReviews[0][] = $waitingReview;
						$groupedReviews[-1][] = $waitingReview;
					}
				}
			}
			
			foreach ($allReviews as $review)
			{
				$groupedReviews[$review['Status']][] = $review;
				$groupedReviews[-1][] = $review;;
			}
			
			ksort($groupedReviews);
			return view('user1.dashboard.review-shareuser',compact('reviews', 'groupedReviews'));
		}
		
	public function writeReview($bookingID, Request $request)
	{
		$user1ID = Auth::guard('user1')->user()->id;
		$booking = Rentbookingsave::where('id', $bookingID)->where('status', BOOKING_STATUS_COMPLETED)->first();
		
		$error = Session::has('error') ? Session::get('error') : '';
		$success = Session::has('success') ? Session::get('success') : '';
		$space = $booking->spaceID;
		$rentUser = $booking->rentUser;
		if (!$error && !$success)
		{
			if ($booking)
			{
				$user2ID = $booking->user_id;
				$error = $booking->spaceID->User1ID != $user1ID ? trans('reviews.review_booking_not_belong_space') : '';
				
				if (!$error)
				{
					// Validate User2 can write review for User id or not
					$isAllow = Userreview::isAllowUser1WriteReviewToUser2($bookingID, $user1ID, $user2ID);
					if (!$isAllow)
					{
						// If not validated, go to 404 page
						$error = trans('reviews.review_already_left_or_permission');
					}
				}
			}
			else {
				$error = trans('reviews.review_already_left_or_permission');
			}			
		}
		return view('user1.dashboard.write-review-shareuser', compact('error', 'success', 'space', 'rentUser'));
	}
	public function reviewSave($bookingID, Request $request)
	{
		// Validate
		if (!$request->Comment) {
			Session::flash('submitFailed', trans('reviews.review_empty_comment'));
			return redirect('ShareUser/Dashboard/Review/Write/'.$bookingID);
		}
		$user1ID = Auth::guard('user1')->user()->id;
		$booking = Rentbookingsave::where('id', $bookingID)->where('status', BOOKING_STATUS_COMPLETED)->first();
		if ($booking)
		{
			$user2ID = $booking->user_id;
			
			// Check Booking User1 is user are logged in or not
			if ($booking->spaceID->User1ID != $user1ID )
			{
				Session::flash('error', trans('reviews.review_booking_not_belong_space'));
				return redirect('ShareUser/Dashboard/Review/Write/'.$bookingID);
			}
			
			// Validate User2 can write review for User id or not
			$isAllow = Userreview::isAllowUser1WriteReviewToUser2($bookingID, $user1ID, $user2ID);
			if (!$isAllow)
			{
				// If not validated, go to 404 page
				Session::flash('error', trans('reviews.review_already_left_or_permission'));
				return redirect('ShareUser/Dashboard/Review/Write/'.$bookingID);
			}
			$avgRating = round((($request->Cleaniness + $request->Kindness + $request->Polite  + $request->Repeat)/4) * 2) / 2;
			$request->merge(array('User1ID' => $user1ID));
			$request->merge(array('User2ID' => $user2ID));
			$request->merge(array('SpaceID' => $booking->user1sharespaces_id));
			$request->merge(array('BookingID' => $bookingID));
			$request->merge(array('ReviewedBy' => 'User1'));
			$request->merge(array('AverageRating' => $avgRating ));
			$request->merge(array('Status' => REVIEW_STATUS_AWAITING ));
			$review= new \App\Userreview();
			$review->fill($request->except(['_token']));
			if ($review->save())
			{
				// delete old notification if exists
				Notification::where('Type', NOTIFICATION_REVIEW_BOOKING)
							->where('TypeID', $bookingID)
							->where('UserReceiveID', $user2ID)
							->where('UserReceiveType', 2)
							->where('UserSendID', $user1ID)
							->where('UserSendType', 1) -> delete();
				
				// Save notification
				$notification = new Notification();
				$notification->Type = NOTIFICATION_REVIEW_BOOKING;
				$notification->TypeID = $bookingID;
				$notification->UserReceiveID = $user2ID;
				$notification->UserReceiveType = 2;
				$notification->UserSendID = $user1ID;
				$notification->UserSendType = 1;
				$notification->Status = 0;
				$notification->Time = date('Y-m-d H:i:s');
				$notification->save();
				
				// Check and update status of reviews : awaiting or completed
				$status = Userreview::updateStatusBookingReview($bookingID, $booking->user1sharespaces_id, $user1ID, $user2ID);
			}
			Session::flash('success', trans('reviews.review_left_feedback_successfully'));
			return redirect('ShareUser/Dashboard/Review/Write/'.$bookingID);
		}
		else {
			Session::flash('error', trans('reviews.review_booking_not_exists'));
			return redirect('ShareUser/Dashboard/Review/Write/'.$bookingID);
		}
	}
	
		public function desiredPerson()
		{
			if(Auth::check() || (Session::has("ShareUserID") && !empty(Session::get("ShareUserID"))))
			{

				return view('user1.register.select-desiredperson');
			}
			else
			{
				return redirect('/');
			}
		}
		public function desiredPersonSubmit(Request $request)
		{
			if (Auth::check())
			{
				$u=User1::find(Auth::user()->id);
			}
			else
			{
				$u=User1::find(Session::get("ShareUserID"));
			}
			if(!empty($request->Skills))
			{
				$request->merge(array('Skills' => implode (",", $request->Skills)));
			}
			$u->fill($request->except(['_token']));
			if($u->save())
			{
				if (Auth::check())
				{
					return redirect('/ShareUser/Dashboard');
				}
				else{

					return redirect('/ShareUser/Dashboard');
				}
			}
		}
		public function message()
		{
			return view('user1.dashboard.message-shareuser');
		}
		
		public function notAuth() {
			return view('user1.dashboard.not-auth');
		}
		
		public function processBookingPaymentAuto(Request $request){
			$rentbooking=new Rentbookingsave();
			if ($request->reSaveTime)
			{
				$rentbooking->reSaveStartEndBookingTime();
			}
			if ($request->storeRecursion)
			{
				$rentbooking->storeRecursionHistory();
			}
// 			mail("quocthang.2001@gmail.com", "IPN RECEVING DATA test for recurring payment", 'Is it ok?', "processBookingPaymentAuto");
			return $rentbooking->processBookingPaymentAuto();
		}
}
