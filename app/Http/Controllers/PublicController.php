<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User1;
use App\User2;
use App\Spaceslot;
use App\User2requirespace;
use App\User1sharespace;
use App\Notification;
use App\Rentbookingsave;
use App\User2portfolio;
use App\Spaceimage;
use App\User1paymentinfo;
use App\Userreview;
use WebPay\WebPay;
use View;
use Session;
use DB;
use Mail,Redirect;
use Config;
use Auth;
use Response;



class PublicController extends Controller
{
	public function __construct(){
		$this->middleware('user1', ['except' => [
				'viewShareSpace',
				'viewShareSpaceBooking',
				'viewHostProfile', 
				'getUserNotifications',
				'getRentUserSpaceOffers',
				'saveRentUserSpaceOffers',
				'cardTransaction', 
				'searchSpaces', 
				'checkSessionExpire', 
				'getSpaceFlexiblePrice',
				'landingPage',
				'getSpaceCalendar', 
				'getBookingPaymentInfo',
		]]);
	}
	public function viewShareSpace(Request $request,$id)
	{
		$space=User1sharespace::where('HashID', $id)->first();
		$aVailableSlots = Spaceslot::getAvailableSpaceSlot($space);	
		
		if (!$space || !count($aVailableSlots))
		{
			Session::flash('error', trans('common.space_not_existed'));
			return redirectToDashBoard();
			
		}
		
		if(!(Auth::guard('user1')->check() && $space->User1ID==Auth::guard('user1')->user()->id))
		{
			if($space->status != SPACE_STATUS_PUBLIC)
			{
				return view('public.private-draft-error');
			}
		}
		
		$reviews = Userreview::avarageSpaceReviews($space->id);
		$allReviews = Userreview::getSpaceReviews($space->id);
		
		$userSpace = User1::find($space->User1ID);
		$spaces = $userSpace->availableSpaces;
		$groupedSpaces = array();
		foreach ( $spaces as $spaceIndex => $availableSpace )
		{
			if ($availableSpace->id != $space->id)
			{
				$groupedSpaces[$availableSpace->FeeType][] = $availableSpace;
			}
		}
		
		ksort($groupedSpaces);
		
		// Get Booking information
		$request->merge(array('spaceID' => $space->id));
		
		$aAvailableDate = array();
		$aBookingTimeInfoSelected = array();
		
		foreach ($aVailableSlots as $aVailableSlot)
		{
			if (in_array($aVailableSlot['StartDate'], array_keys($aAvailableDate))) continue;
			
			$request->merge(array('booked_date' => $aVailableSlot['StartDate']));
			$aBookingTimeInfo = Spaceslot::getBookingTimeInfo($request, $aVailableSlots, $space);
			
			if (count(@$aBookingTimeInfo['timeDefaultSelected']))
			{
				if (!isset($aBookingTimeInfo['timeDefaultSelected']['StartDate']))
					continue;
				
				$aAvailableDate[$aBookingTimeInfo['timeDefaultSelected']['StartDate']] = $aBookingTimeInfo['timeDefaultSelected'];
				
				if (!count($aBookingTimeInfoSelected))
					$aBookingTimeInfoSelected = $aBookingTimeInfo;
				
				if ($space->FeeType != SPACE_FEE_TYPE_HOURLY && $aBookingTimeInfo)
				{
					break;
				}
			}
		}
		
		if (!count($aBookingTimeInfoSelected))
		{
			return redirectToDashBoard();
		}
		
		
		return view('public.view-sharespace',compact('space', 'reviews', 'allReviews', 'groupedSpaces','aAvailableDate', 'aBookingTimeInfoSelected'));
	}

	public function getSpaceCalendar(Request $request)
	{
		$space=User1sharespace::where('HashID', $request->spaceID)->first();
		if ($request->ajax() && $space)
		{
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
			$spaceSlots = SpaceSlot::getSpaceSlotBySpaceIDAndType($space['id'], trim($aFreeType[0]), false, true);
			$calendarEvents = array();
			if (count($spaceSlots))
			{
				for ($i = 0; $i < count($spaceSlots); $i++)
				{
				$indexSlot = $i;
				$slot = $spaceSlots[$i];
					
				if ($bookedSpace)
				{
				$slot->Status = (isCoreWorkingOrOpenDesk($bookedSpace) && $slot->total_booked < $space->Capacity) ? SLOT_STATUS_AVAILABLE : $slot->Status;
		
				}
					
				$calendarEvents[$indexSlot]['start'] = $slot->StartDate . 'T'. $slot->StartTime;
				$calendarEvents[$indexSlot]['end'] = $slot->EndDate . 'T'. $slot->EndTime;
				$calendarEvents[$indexSlot]['id'] = $slot->id;
				$calendarEvents[$indexSlot]['type'] = $slot->Type;
					
				$calendarEvents[$indexSlot]['backgroundColor'] = $slot->Status ? '#F00' : '#3a87ad';
					$calendarEvents[$indexSlot]['title'] = $slot->Status ? trans('common.Schedule Booked') : trans('common.Schedule Available');
					$calendarEvents[$indexSlot]['description'] = $slot->Status ? '' : '';
							$calendarEvents[$indexSlot]['editable'] = $slot->Status ? false : true;
							$calendarEvents[$indexSlot]['className'] = $slot->Status ? 'booked' : 'available';
									$calendarEvents[$indexSlot]['overlap'] = false;
										
									if ($bookedSpace && !isCoreWorkingOrOpenDesk($bookedSpace))
									{
									$calendarEvents[$indexSlot]['is_single'] = '1';
				}
				if ($calendarEvents[$indexSlot]['type'] != 'HourSpace')
				{
				$calendarEvents[$indexSlot]['constraint'] = null;
				}
				}
				}
				// 			pr($calendarEvents);die;
						$calendarEvents = json_encode(array_values($calendarEvents));
						return view('user1.dashboard.calendar',compact('space','user','calendarEvents'));
		}
	}
	
	public function viewHostProfile($id)
	{
		$user=User1::where('HashCode', $id)->firstOrFail();
		$spaces = $user->availableSpaces;
		
		$spacesTmp = clone $spaces;
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
				unset($spaces[$spaceIndex]);
			}
		}
		
		// Unset temp variable
		unset($spacesTmp);
		$spacesTmp = array();
		
		$groupedSpaces = array();
		$fav_cnt=0;
		foreach ( $spaces as $spaceIndex => $space )
		{
			$groupedSpaces[$space->FeeType][] = $space;
			$fav_cnt=$fav_cnt+$space->favorites->count();
		}
		ksort($groupedSpaces);
		
		$reviews = Userreview::avarageUser1Reviews($user->id);
		$allReviews = Userreview::getUser1Reviews($user->id);
		
		return view('public.view-host-profile',compact('user', 'spaces', 'groupedSpaces','fav_cnt','allReviews','reviews'));
	}
	

	public function RentBooking(Request $request){
		$user=User1::find(Auth::user()->id);
		$rent_datas = Rentbookingsave::select('rentbookingsaves.*')
				->where('rentbookingsaves.User1ID', $user->id)
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
				->where('rentbookingsaves.User1ID', $user->id)
				->joinSpace()
				->groupBy(array('rentbookingsaves.id'))
				->where('rentbookingsaves.status','!=', BOOKING_STATUS_DRAFT);
		
		$allAvailDatas = clone $allDatas;
		if ($request->filter_month)
		{
			$allAvailDatas = $allAvailDatas->where('rentbookingsaves.created_at','>=', $request->filter_month . '-01')->where('rentbookingsaves.created_at','<=', $request->filter_month . '-31');
		}
// 		pr(getSqlQuery($allAvailDatas));die;
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
		return view('user1.dashboard.rent_booking',compact('user','rent_datas', 'rent_data_status', 'allDatas', 'allAvailDatas', 'rent_data_month'));
	}
	
	public function profile($id)
	{
		$user=User2::where('HashCode', $id)->firstOrFail();
		
		
		if ($user->IsAdminApproved == 'No')
		{
			Session::flash('error', trans('common.that_user_not_verfied'));
			return redirect('/ShareUser/Dashboard');
		}
		
		$space= User2requirespace::firstOrNew(array('User2ID' => $user->id));
		$isPublicUser = true;
		$budgets= \App\Budget :: where('Type', '!=','search')->get();
		$timeslots=\App\Timeslot :: get();
		$userPortfolios = User2portfolio::where('User2Id', '=', $user->id)->get();
		$reviews = Userreview::avarageUser2Reviews($user->id);
		$allReviews = Userreview::getUser2Reviews($user->id);
		
		$isPaymentSetup = User2::isPaymentSetup($user);
		$isProfileFullFilled = User2::isProfileFullFill($user);
		
		return view('user2.dashboard.profile-rentuser_edit',compact('user','space','budgets','timeslots', 'isPublicUser', 'userPortfolios', 'reviews', 'allReviews', 'isPaymentSetup', 'isProfileFullFilled'));

	}
	public function listDistrict($Prefecture){

		$user2=new User2();
		$District = User2::select('City')->isApproved()->where('Prefecture', '=', $Prefecture)->distinct()->get();

		echo $District;
	}
	public function listRentUser(Request $request)
	{
		$user2=new User2();
		$user1=User1::find(auth()->user()->id);
		$error = '';
		// Check User is approve or not
		if ($user1->IsAdminApproved == 'No')
		{
			$error = trans('common.user1_not_allow_to_see_rent_list');
		}
		$Prefectures = User2::select('Prefecture')->isApproved()->distinct()->get();
		
		$Districts = array();
		if ($request->Prefecture)
			$Districts = User2::select('City')->isApproved()->where('Prefecture', $request->Prefecture)->distinct()->get();
		
		$request->Skills = (array)$request->Skills;
		$search=$request->except(['page']);
		$last_activity = \Carbon\Carbon::now()->subSeconds('1500');
		$aNormalSearch = array('BusinessType', 'Prefecture', 'City');
		
		foreach($search as $key => $value)
		{
			
			if(empty($value))
			{
				continue;
			}
			elseif (is_string($value))
			{
				$value = trim($value);
			}
			
			// Start searching
			if(in_array($key, $aNormalSearch))
			{
				$value = (array)($value);
				$user2=$user2->whereIn('user2s.'.$key, $value);
			}
			elseif($key=="Online")
			{
				$user2=$user2->where('user2s.LastActivity', '>=', $last_activity);
			}
			elseif($key=="Skills")
			{
				$aSkills = (array)$request->Skills;
				$user2=$user2->where(function ($query) use ($aSkills){
					foreach ($aSkills as $skill)
					{
						$skill = trim($skill);
						$query->orWhere('user2s.Skills', 'LIKE', '%'. $skill .'%');
					}
				});
			}
			elseif($key=="filter_name")
			{
				global $search_value;
				$search_value = $value;
				$user2=$user2->where(function ($query) {
					global $search_value;
					$search_value = trim($search_value);
					$query->where('user2s.NameOfCompany', 'LIKE', '%'. $search_value .'%')
						->orWhere('user2s.FirstName', 'LIKE', '%'. $search_value .'%')
						->orWhere('user2s.LastName', 'LIKE', '%'. $search_value .'%');
				});
			}
			elseif($key=="star_rating")
			{
				$user2=$user2->join(DB::raw('(
						SELECT userreviews.User2ID, AVG(userreviews.AverageRating) as rating 
						FROM userreviews
						WHERE 
							userreviews.ReviewedBy = "User1"
							AND userreviews.Status = 1 
						GROUP BY userreviews.User2ID) as userreviews'), 'user2s.id', '=', 'userreviews.User2ID');
				$user2=$user2->where('userreviews.rating', '>=', $value);
				$user2=$user2->groupBy(array('userreviews.User2ID'));
				
			}
		}
		$user2 = $user2->isApproved();
		$users= $user2->paginate(10);
		return view("public/list-rentusers",compact('users','last_activity','Prefectures', 'Districts', 'request','user1', 'error'));
		$users->appends($request->except(['page']))->links();
	}
	
	public function getUserSpaceOffers(Request $request){
		$user1 = User1::find(Auth::guard('user1')->user()->id);
		if ($user1->IsAdminApproved == 'No')
		{
			// Don't allow get offers when haven't approved
			return trans('common.user1_not_allow_to_offer');
		}
		
		$spaces= User1sharespace::where(array('User1ID' => Auth::guard('user1')->user()->id))->get();
		$html = View::make('public/list-rentuser-spaces',compact('spaces', 'request'));
		return $html;
	}
	
	public function saveRentUserSpaceOffers(Request $request){
		$user1 = User1::find(Auth::guard('user1')->user()->id);
		if ($user1->IsAdminApproved == 'No')
		{
			// Don't allow get offers when haven't approved
			return '';
		}
		
		$spaceIds = $request->space_id;
		$success = false;
		$TimeSave = date('Y-m-d H:i:s');
		if (is_array($spaceIds) && !empty($spaceIds))
		{
			foreach ($spaceIds as $spaceId)
			{
				$Notification = new Notification();
				$aData['Type'] = NOTIFICATION_SPACE;
				$aData['TypeID'] = $spaceId;
				$aData['UserReceiveID'] = $request->userReceiveId;
				$aData['UserReceiveType'] = 2;
				$aData['UserSendID'] = Auth::guard('user1')->user()->id;
				$aData['UserSendType'] = 1;
				$aData['IsRead'] = 0;
				$aData['Time'] = $TimeSave;
				
				$Notification->fill($aData);
				$success = $Notification->save();
			}
			
			
			// Send email to user 2
			global $from, $user2;
			$user2=User2::find($request->userReceiveId);
			$user1=User1::find(Auth::guard('user1')->user()->id);
			$spaces=User1sharespace::with('spaceImage')->whereIn('id', $spaceIds)->get();
			$from = Config::get('mail.from');
			Mail::send('user2.emails.space-notifications',['user1' => $user1, 'user2' => $user2, 'spaces' => $spaces],
			function ($message) {
				global $request, $from, $user2; 
				$message->from($from['address'], $from['name']);
				//$mails = [$user2['Email']];
				$mails = ['quocthang.2001@gmail.com'];
				$message->cc('kyoko@heart-hunger.com', 'Kyoko');
				$message->to($mails)->subject('Notifications');
			});
		}
		
		return json_encode(array('success' => $success, 'message' => 'オファーが送られました。'));
	}
	
	public function getUserNotifications(Request $request){
		$notifyLimit = LIMIT_NOTIFICATION;
		$notificationTypes = getAllNotificationTypes();
		if (isset($request->action) && $request->action == 'read')
		{
			$notifications = Notification::where('Time', trim($request->Time))->get();
			if (count($notifications))
			{
				foreach ($notifications as $notification)
				{
					$notification['IsRead'] = 1;
					$notification->save();
				}
			}
			$aResponse['success'] = 1;
		}
		else
		{
			// Detect User Type
			if (Auth::guard('user1')->check())
			{
				$userType = 1;
				$user=User1::find(Auth::guard('user1')->user()->id);
				$userId = $user->id;
				$userSend = 'user2Send';
				$notifications = Notification::with('user1Space')->with($userSend)->where('UserSendType', 2);
			}
			elseif (Auth::guard('user2')->check())
			{
				$userType = 2;
				$user=User2::find(Auth::guard('user2')->user()->id);
				$userId = $user->id;
				$userSend = 'user1Send';
				$notifications = Notification::with('user1Space')->with($userSend)->where('UserSendType', 1);
			}
			
			if (isset($notifications) && $notifications)
			{
				// Get Space Notification
				$notifications->whereIn('Type', $notificationTypes);
				$notifications->where('UserReceiveType', $userType);
				$notifications->where('UserReceiveID', $userId);
				$notifications->where('IsRead', '0');
				$notifications->groupBy('Time');
				$notifications->orderBy('Time', 'DESC');
					
				$countNotiObj = clone $notifications;
				$notifications->select('*',DB::raw('count(Time) as CountBulk'));
				$countNotiObj->select(DB::raw('count(*) as total'));
				$notifySpaces = $notifications->take($notifyLimit)->offset($request->offset)->get();
				$totalSpaces = $countNotiObj->get()->count();
					
				$notifySpacesTmp = clone $notifySpaces;
				foreach ($notifySpacesTmp as $notifyIndex => $notifySpace)
				{
					if ($notifySpace['Type'] == NOTIFICATION_FAVORITE_SPACE)
					{
						$userSpace = \App\User1sharespace::where('HashID', $notifySpace['user1FavSpace']['SpaceId'])->first();
						$notifySpaces[$notifyIndex]['user1Space'] = $userSpace;
						if (!$userSpace)
						{
							unset($notifySpaces[$notifyIndex]);
							$totalSpaces --;
						}
					}
				}
				// Create resonse
				$spaceResponse = array('count' => count($notifySpaces), 'data' => $notifySpaces);
				$html = View::make('public/user-notifications',compact('notifySpaces', 'user', 'userSend'));
				$spaceResponse['html'] = (string)$html;
					
				$aResponse['space'] = $spaceResponse;
				$aResponse['count_total'] = count($notifySpaces);
				$aResponse['offset_count'] = count($notifySpaces);
				$aResponse['offset'] = $notifyLimit + $request->offset;
			}
			else {
				$aResponse = array('offset_count' => 0);
			}
			
		}
		
		echo json_encode($aResponse);die;
	}
	
	public function searchSpaces(Request $request)
	{
		$input = $request->all();
		$aDataMapperSearch = array(
				'SpaceType' => array(
						'search' => 'Type',
						'conditionType' => 'whereIn',
						'whereType' => 'IN',
				),
				'prefecture' => array(
						'search' => 'Prefecture',
						'conditionType' => 'where',
						'whereType' => '=',
				),
				'district' => array(
						'search' => 'District',
						'conditionType' => 'whereIn',
						'whereType' => 'IN',
				),
				'budget' => array(
						'search' => 'Budgets',
						'conditionType' => 'Special',
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
				'Capacity' => array(
						'search' => 'Capacity',
						'conditionType' => 'Special',
						'whereType' => '>=',
				),
				'OtherFacilities' => array(
						'search' => 'OtherFacilities',
						'conditionType' => 'Special',
						'whereType' => 'IN',
				)				
		);
		global $user1Space;
		$user1Space = new User1sharespace();
		$aSpaceTypes = getSpaceTypeMapper();
	
		foreach ($aDataMapperSearch as $field => $sMapper)
		{
			global $conditionType, $mapper, $fieldValue;
	
			if (!isset($input[$field]) || !$input[$field]) continue;
	
			$mapper = $sMapper;
			$conditionType = $mapper['conditionType'];
			$whereType = $mapper['whereType'];
	
			$fieldValue = $input[$field];
				
			if (in_array($conditionType, array('whereIn', 'whereNotIn', 'whereBetween', 'whereNotBetween')))
			{
				if ($field == 'SpaceType'){
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
	
				$user1Space = $user1Space->{$conditionType}('user1sharespaces.' . $mapper['search'], $fieldValue);
	
				if (in_array($conditionType, array('whereIn', 'whereNotIn')))
				{
					$user1Space = $user1Space->orderByRaw('user1sharespaces.' . $mapper['search'] . ' ' . $whereType . '("' . implode('","', $fieldValue) . '") DESC');
				}
				else {
					$user1Space = $user1Space->orderByRaw('user1sharespaces.' . $mapper['search'] . ' ' . $whereType . ' "'. $fieldValue[0] .'" AND "'. $fieldValue[1] .'" DESC');
				}
			}
			elseif (in_array($conditionType, array('StartEnd')))
			{
	
				if ($field == 'TimeSlot' && count($input[$field]))
				{
					global $timeslots;
					$timeslots = \App\Timeslot::whereIn('id', $input[$field])->get();
					if (is_array($mapper['search']))
					{
						$user1Space = $user1Space->where(function ($query) {
							global $mapper, $timeslots, $fieldValue;
							foreach ($timeslots as $timeslot)
							{
								$fieldValue = date('g:i A', strtotime($timeslot->StartValue)) . '-' . date('g:i A', strtotime($timeslot->EndValue));
								foreach ($mapper['search'] as $search)
								{
									global $mySearch, $fieldValue;
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
							}
						});
					}
				}
			}
			elseif (in_array($conditionType, array('Special'))) {
				if ($field == 'budget')
				{
					global $budgets;
					$budgetType = getSpaceTypeFieldByNumber($input['fee_type']);
					$mapper['search'] = ucwords($budgetType).'Fee';
					$budgets= \App\Budget :: whereIn('id', $fieldValue)->get();
					if (count($budgets))
					{
						$user1Space = $user1Space->where(function ($query) {
							global $budgets, $fieldValue;
							foreach ( $budgets as $budget)
							{
								$fieldValue = array($budget['StartValue'], $budget['EndValue']);
								$query->orWhere(function ($query) {
									global $mapper, $fieldValue;
									$query->whereBetween('user1sharespaces.' . $mapper['search'], $fieldValue);
								});
							}
						});
					}
				}
				elseif ($field == 'Capacity') {
					$aFieldValue  = explode('-', $fieldValue);
					if (count($aFieldValue) == 2)
					{
						$fieldValue = array_map('intval', $aFieldValue);
						$conditionType = 'whereBetween';
						$whereType = 'Between';
						$user1Space = $user1Space->{$conditionType}('user1sharespaces.' . $mapper['search'], $fieldValue);
						$user1Space = $user1Space->orderByRaw('user1sharespaces.' . $mapper['search'] . ' ' . $whereType . ' "'. $fieldValue[0] .'" AND "'. $fieldValue[1] .'" DESC');
					}
					else{
						if (strpos($aFieldValue[0], '>') !== false)
							$whereType = '>=';
						else
							$whereType = '<=';
						$conditionType = 'where';
	
						$fieldValue = (int)$aFieldValue[0];
						$user1Space = $user1Space->{$conditionType}('user1sharespaces.' . $mapper['search'], $whereType, $fieldValue);
						$user1Space = $user1Space->orderByRaw('user1sharespaces.' . $mapper['search'] . ' ' . $whereType . " '" . $fieldValue . "'" . ' DESC');
					}
				}
				elseif ($field == 'OtherFacilities')
				{
					global $aFieldValue;
					$aFieldValue = $fieldValue;
					if (!empty($fieldValue))
					{
						$user1Space = $user1Space->where(function ($query) {
							global $mapper, $aFieldValue, $fieldValue;
							foreach ($aFieldValue as $search)
							{
								$fieldValue = $search;
								$query->orWhere(function ($query) {
									global $mapper, $fieldValue;
									$query->where('user1sharespaces.' . $mapper['search'], 'LIKE', '%'. $fieldValue .'%');
								});
							}
						});
					}
				}
			}
			else {
				if ($conditionType == 'where')
				{
					$user1Space = $user1Space->orderByRaw('user1sharespaces.' . $mapper['search'] . ' ' . $whereType . " '" . $fieldValue . "'" . ' DESC');
				}
				$user1Space = $user1Space->{$conditionType}('user1sharespaces.' . $mapper['search'], $whereType, $fieldValue);
			}
	
		}
	
	
		$user1Space = $user1Space->join('spaceslots', 'user1sharespaces.id', '=' ,'spaceslots.SpaceID');
		if (isset($input['start_from']) && $input['start_from'])
		{
			$user1Space = $user1Space->where('spaceslots.StartDate', '=', $input['start_from']);
		}
	
		if (isset($input['start_at']) && $input['start_at'])
		{
			$user1Space = $user1Space->where('spaceslots.StartTime', '<=', $input['start_at']);
			if (isset($input['duration']) && $input['duration'])
			{
				$dateTime = new \DateTime($input['start_at']);
				$dateTime->modify('+'.$input['duration'].' hours');
				$endTime=$dateTime->format('H:i:s');
				$user1Space = $user1Space->where('spaceslots.EndTime', '>=' , $endTime);
				
			}
		}
	
		
		if(isset($input['tag']) && $input['tag'])
		{
			$user1Space = $user1Space->join('spacetags', 'user1sharespaces.id', '=' ,'spacetags.SpaceID');
			$user1Space = $user1Space->where('spacetags.Name', '=', $input['tag']);
		}

			
		if(Auth::guard('user2')->check())
		{
			$required_space= User2requirespace::firstOrNew(array('User2ID' => Auth::guard('user2')->user()->id));
			$default_has_space=1;
			switch ($required_space->BudgetType) {
				case 'hour':
					$default_has_space=1;
					break;
				case 'day':
					$default_has_space=2;
					break;
				case 'week':
					$default_has_space=3;
					break;
				case 'month':
					$default_has_space=4;
					break;
			}
				
			$feeType = (isset($input['fee_type']) && $input['fee_type']) ? $input['fee_type'] : $default_has_space;

		}
		else{
			$feeType = (isset($input['fee_type']) && $input['fee_type']) ? $input['fee_type'] : SPACE_FEE_TYPE_HOURLY;
		}
		$feeType1=$feeType;
		$spaces = $user1Space->select('user1sharespaces.*')
		->where('spaceslots.Status', SLOT_STATUS_AVAILABLE)
		->where('spaceslots.EndDate', '>=', date('Y-m-d'))
		->where('user1sharespaces.status', SPACE_STATUS_PUBLIC)
		->where('user1sharespaces.FeeType', $feeType)
		->orderBy('user1sharespaces.id', 'DESC')
		->groupBy(array('user1sharespaces.id'));
		
		$spaces= $spaces->paginate(LIMIT_SPACES);
		$spacesTmp = clone $spaces;
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
				unset($spaces[$spaceIndex]);
			}
		}
		
		// Unset temp variable
		unset($spacesTmp);
		$spacesTmp = array();
		
		$spaces->appends($request->except(['page']))->links();
	
	
		$spaces1= new \App\User1sharespace();
		$prefectures = $spaces1->getPrefectures();
		$districts = array();
	
		foreach ($prefectures as &$prefecture)
		{
			if ($request->prefecture == $prefecture->Prefecture)
			{
				$prefecture->selected = true;
			}
		}
	
		if ($request->prefecture)
		{
			$districts = $spaces1->getDistrictByPrefecture($request->prefecture);

			if (!empty($districts))
				foreach ($districts as &$district)
				{
					if (is_array($request->district) && in_array($district->District, $request->district))
					{
						$district->selected = true;
					}
				}

				
		}
	
		$budgets = \App\Budget::where('Type', '!=','search')->get();
		$timeslots=\App\Timeslot::all();
			
		return view('public.search-spaces',compact('spaces', 'prefectures', 'districts', 'budgets', 'timeslots', 'available_spaces_message','feeType1', 'request'));
	}
	
	public function checkSessionExpire(Request $request){
		cleanTemporaryData();
		
		if ($request->expired)
		{
			$request->session()->regenerate();
			
			if ($request->userType == 1)
			{
				$request->session()->put('user1.url.intended', $request->backUrl);
			}
			elseif ($request->userType == 2)
			{
				$request->session()->put('user2.url.intended', $request->backUrl);
			}
			
			return Response::json(array(
					'expired' => true,
					'token' => csrf_token()
			));
		}
		else {
			$expired = false;
			if (!Auth::guard('user1')->check() && !Auth::guard('user2')->check() && $request->ajax())
			{
				$expired = true;
			}
			echo json_encode (array(
					'expired' => $expired,
			));
			die;
		}
	}
	
	public function getSpaceFlexiblePrice(Request $request) {
		if ($request->ajax())
		{
			$space_type='';
			$aPrice = array();
			$user1Space = User1sharespace::find($request->SpaceID);
			if ($user1Space)
			{
				$aDates=explode(';', $request->dates);
				$aDates = array_filter(array_unique($aDates));
				$totalPrice = 0;
				foreach ($aDates as $indexDate => $date)
				{
					$date=date('Y-m-d',strtotime($date));
					// Change the space price depending date.
					$aPrice[$indexDate]['priceNumber'] = (float)str_replace(',', '', getPrice($user1Space, false, $date, false, false));
					$aPrice[$indexDate]['price'] = getPrice($user1Space, true, $date, false, true);
					$aPrice[$indexDate]['date'] = $date;
					
					if ($user1Space->FeeType == SPACE_FEE_TYPE_HOURLY)
					{
						$duration = getDurationTimeRange($request->startTime . '-' . $request->endTime);
						$aPrice[$indexDate]['priceNumber'] = $aPrice[$indexDate]['priceNumber'] * $duration;
						$dateTime = \Carbon\Carbon::createFromFormat('Y-m-d', $date);
						$dayOfWeek = $dateTime->dayOfWeek;
						$holidayTime = new \App\Library\HolidayDateTime($dateTime->format('Y-m-d'));
						$isHoliday = $holidayTime->holiday();
						$isSun = $dayOfWeek == \Carbon\Carbon::SUNDAY;
						$isSat = $dayOfWeek == \Carbon\Carbon::SATURDAY;
						$space_type='';
						if ($isHoliday)
						{
							$space_type = '祝日';
						}
						elseif ($isSun)
						{
							$space_type = '日曜料金';
						}
						elseif ($isSat)
						{
							$space_type = '土曜料金';
						}
						else 
						{
							$space_type = '平日料金';
						}
					}
					
					$totalPrice += $aPrice[$indexDate]['priceNumber'];
				}
				
				usort($aPrice, function($a, $b) {
					return $a['priceNumber'] - $b['priceNumber'];
				});
				
			}
			
			
			return Response::json(array(
					'prices' => $aPrice,
					'space_type' => $space_type,
					'count' => count($aPrice),
					'totalPrice' => priceConvert($totalPrice, true)
			));
		}
		return '';
	}
	
	public function getBookingPaymentInfo(Request $request)
	{
		$input = $request->all();
		if (Auth::guard('user1')->check())
		{
			$user = \App\User1::find(Auth::guard('user1')->user()->id);
			$rent_data = Rentbookingsave::where('User1ID', $user->id)->where('id', $input['id'])->where('transaction_id', $input['t_id'])->first();
		}
		elseif (Auth::guard('user2')->check())
		{
			$user = \App\User2::find(Auth::guard('user2')->user()->id);
			$rent_data = Rentbookingsave::where('user_id', $user->id)->where('id', $input['id'])->where('transaction_id', $input['t_id'])->first();
		}
		
		if ($user)
		{
			if ($rent_data)
			{
				$rent_data->return_info = 1;
				$rentbooking = new Rentbookingsave();
				$response = $rentbooking->processCancelPayment($rent_data, false);
				if (isset($response['refund_status']))
				{
					if (isBookingRecursion($rent_data))
						$bookingAmount = ceil(($rent_data->amount / $rent_data->Duration) * BOOKING_MONTH_RECURSION_INITPAYMENT);
					else
						$bookingAmount = $rent_data->amount;
					
					switch($response['refund_status'])
					{
						case BOOKING_REFUND_NO_CHARGE:
							$refund_amount = 0;
							$refund_text = 'キャンセル料無し';
							break;
						case BOOKING_REFUND_CHARGE_50:
							$refund_amount = ceil($bookingAmount / 2);
							$refund_text = 'キャンセル料 50%';
							break;
						case BOOKING_REFUND_CHARGE_100:
							$refund_amount = $bookingAmount;
							$refund_text = 'キャンセル料 100%';
							break;
					}
					$refund_amount = ceil($refund_amount);
					$message = '予約番号#' . $rent_data->id . 'のキャンセルをリクエストします。<br />';
					$message .= 'キャンセルポリシーに基づき、支払金額は返金処理されます。' . $refund_text . '<br />';
					$message .= 'キャンセル料金 : ' . priceConvert($refund_amount, true, true);
					
					return Response::json(array(
						'body' => $message,
						'title' => 'キャンセルポリシー',
					));
				}
			}
		}
	}
	
	public function landingPage(){
		$spaces = User1sharespace::select('user1sharespaces.*')->where('spaceslots.Status', SLOT_STATUS_AVAILABLE)
		->where('spaceslots.EndDate', '>=', date('Y-m-d'))
		->where('spaceslots.StartDate', '>=', date('Y-m-d H:i:s'))
		->where('user1sharespaces.status', SPACE_STATUS_PUBLIC)
		->orderBy('user1sharespaces.id', 'DESC')
		->groupBy(array('user1sharespaces.id'))
		->take(20)
		->join('spaceslots', 'user1sharespaces.id', '=' ,'spaceslots.SpaceID')->get();
		
		$finalSpaces = array();
		foreach ($spaces as $spaceIndex => $space)
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
				
			if (count($aBookingTimeInfoSelected))
			{
				$finalSpaces[] = $spaces[$spaceIndex];
			}
			
			if (count($finalSpaces) >= LIMIT_SPACE_HOME) break;
		}
		
		return view('pages.index', ['spaces' => $finalSpaces]);
	}
	
}
