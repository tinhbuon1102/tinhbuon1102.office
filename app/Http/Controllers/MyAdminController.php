<?php

namespace App\Http\Controllers;

use App\Bookedspace;

use App\Bookedspaceslot;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Useradmin;
use Auth;
use App;
use App\User1;
use App\User2;
use App\User1paymentinfo;
use App\User1sharespace;
use App\Rentbookingsave;
use App\Spaceimage;
use App\Spaceslot;
use App\Spacetag;
use App\User1hostmember;
use Mail;
use URL;
use App\User2identitie;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Session;
use Config;
use DB;

class MyAdminController extends Controller
{
	//
	public function __construct(){
		$this->middleware('useradmin', ['except' => ['validateMyAdmin','login']]);
	}
	public function dashboard()
	{
		return view("admin/dashboard");
	}
	public function user1(Request $request)
	{
		$users=new App\User1();
		$users= $users->orderBy('id', 'desc');
// 		$users= $users->paginate(20);
// 		$users->appends($request->except(['page']))->links();
		$users=$users->get();
		
		return view("admin/user1",compact('users'));
	}

	public function Spaces(Request $request)
	{
		$spaces=new App\User1sharespace();
		if ($request->has('deletebtn')) {
			$this->validate($request ,[
					'delete'=> 'required'
					]);
				
			User1sharespace::whereIn('id', $request->delete )->delete();
			session()->flash('suc', 'Space Deleted');
			return back();
		}

		$spaces = $spaces->get();
		return view("admin/spaces",compact('spaces'));
	}

	public function test()
	{
		$user1=new App\User1();
		$users= $user1->get();
		return view("admin/test",compact('users'));
	}
	public function deletemuser1(Request $request)
	{
		$this->validate($request ,[
				'delete'=> 'required'
				]);
		if ($request->has('deletebtn')) {


			User1::whereIn('id', $request->delete )->delete();

			session()->flash('suc', 'User Deleted');
		}

		if ($request->has('acceptbtn')) {

			//User1::whereIn('id', $request->delete )->delete();
			foreach($request->delete as $uid)
			{
				$user1 = App\User1::find($uid);
				if($user1->IsAdminApproved !="Yes")
				{
					$user1->IsAdminApproved="Yes";
					$user1-> EmailVerificationText=uniqid();
					$user1->save();
					
					sendEmailCustom ([
						'user' => $user1,
						'sendTo' => $user1->Email,
						'template' => 'admin.emails.user1approve',
						'subject' => 'offispo 会員登録完了のお知らせ']
							);
					
				}
			}
			session()->flash('suc', 'ユーザーが承認されました。');
		}
		return back();
	}

	public function deletemuser2(Request $request)
	{
		$this->validate($request ,[
				'delete'=> 'required'
				]);
		User2::whereIn('id', $request->delete )->delete();
		session()->flash('suc', 'ユーザーが削除されました。');
		return back();
	}

	public function view(User1 $user1)
	{
		return view("admin/user1view",compact('user1'));
	}

	public function user2()
	{
		$users=new App\User2();
		$users= $users->orderBy('id', 'desc');
		// 		$users= $users->paginate(20);
		// 		$users->appends($request->except(['page']))->links();
		$users=$users->get();
		return view("admin/user2",compact('users'));
	}

	public function view2(User2 $user2)
	{
		return view("admin/user2view",compact('user2'));
	}
	
	public function sendUser1EmailVerify(User1 $user){
		$from = Config::get('mail.from');
		Mail::send('admin.emails.user1_verifyemail',
		[
			'EmailVerificationText' => $user->EmailVerificationText,
		],
		function ($message) use ($user, $from){
			$message->from($from['address'], $from['name']);
			$mails = [$user->Email];
			$message->to($mails)->subject('メール認証のご確認 | Offispo');
		});
		session()->flash('suc', 'メール認証の確認メールが送信されました。');
		return back();
	}
	
	public function sendUser2EmailVerify(User2 $user){
		$from = Config::get('mail.from');
		Mail::send('admin.emails.user2_verifyemail',
		[
			'EmailVerificationText' => $user->EmailVerificationText,
		],
		function ($message) use ($user, $from){
			$message->from($from['address'], $from['name']);
			$mails = [$user->Email];
			$message->to($mails)->subject('メール認証のご確認 | Offispo');
		});
		session()->flash('suc', 'メール認証の確認メールが送信されました。');
		return back();
	}
	
	public function user1approve(User1 $user1)
	{
		$user1->IsAdminApproved="Yes";
		$user1->save();
		session()->flash('suc', 'ユーザーが承認されました。');
		return back();
	}

	public function user2approve(User2 $user2)
	{
		$user2->IsAdminApproved="Yes";
		$user2->save();
		session()->flash('suc', 'ユーザーが承認されました。');
		return back();
	}

	public function sendmail(User1 $user1)
	{
		sendEmailCustom ([
			'user' => $user1,
			'sendTo' => $user1->Email,
			'template' => 'admin.emails.user1approve',
			'subject' => 'offispo 会員登録完了のお知らせ']
				);
	}
	public function validateMyAdmin(Request $request, Useradmin $useradmin)
	{
		$this->validate($request ,[
				'UserName' => 'required' ,
				'password'=> 'required'
				]);
		$auth = auth()->guard('useradmin');
		if($auth->attempt($request->only('UserName', 'password')))
		{
			return redirect('/MyAdmin/Dashboard');
		}
		else{
			session()->flash('err', '認証エラー');
			return redirect('/MyAdmin/Login');
		}
	}
	public function login()
	{
		return view("admin/login");
	}
	public function logout()
	{
		auth()->guard('useradmin')->logout();
		return redirect('/MyAdmin/Login');
	}

	public function shareUser(Request $request, $id)
	{
		$user=User1::where('HashCode', $id)->firstOrFail();

		$user->Skills = explode("," , $user->Skills);
		$bank= User1paymentinfo::firstOrNew(array('User1ID' => $user->id));;
		$hosts=$user->host;
		$certificates=$user->certificates;

		$rent_datas = Rentbookingsave::select('rentbookingsaves.*')
		->where('rentbookingsaves.User1ID', $user->id)
		->where('rentbookingsaves.InvoiceID', '<>', '')
		->joinSpace()
		->orderBy('rentbookingsaves.id','desc')
		->groupBy(array('rentbookingsaves.id'))
		->where('rentbookingsaves.status','!=', BOOKING_STATUS_DRAFT);
		$rent_datas = $rent_datas->get();

		// Get invoices
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
		$invoices= $invoices->paginate(100);
		$invoices->appends($request->except(['page']))->links();

			
		return view("admin/shareuser/edit-share",compact('user','bank','hosts','certificates','id','rent_datas', 'invoices'));


	}

	public function EditBookSave(Request $request,$id){
		$input=$request->all();


		$rent_data=Rentbookingsave::find($id);
		if(isset($input['space_slot'])):
		$space_slots=implode(';',$input['space_slot']);
		$rent_data->spaceslots_id=$space_slots;
		$rent_data->hourly_time=count($input['space_slot']);
		$slots_data=\App\Bookedspaceslot::whereIn('SlotID', array_filter(array_unique($input['space_slot'])))->orderBy('StartDate','asc')->get();
		if(isset($slots_data[0]->StartDate)):
		$rent_data->hourly_date=date('Y-m-28',strtotime('+0 month',strtotime($slots_data[0]->StartDate)));
		endif;
		else:
		$rent_data->hourly_date=$input['ReservationDayDisplay'];
		$rent_data->hourly_time=$input['hourly_time'];
		endif;
		// 		$rent_data->amount=trim($input['total-price']*0.08+$input['total-price']+(($input['total-price']*0.08)+($input['total-price']))*0.10);
		// 		$rent_data->price=trim($input['unit-price']);
		$rent_data->status=$input['status'];
		$rent_data->save();

		Session::flash('success', '予約情報の更新に成功しました。');

		return redirect('/MyAdmin/ShareUser/Dashboard/EditBook/'.$id);
	}

	public function editBooking($id)
	{
		$Paypalbilling = new \App\Models\Paypalbilling;
		$rentBooking = new \App\Rentbookingsave;

		$rent_data = Rentbookingsave::Where('id', $id)->first();
		$user=User1::find($rent_data['spaceID']['shareUser']['id']);
		
		if($rent_data == null)
			return redirect::back();


		$paypalModel = new \App\Models\Paypal;
		$PayPalRefrence = $paypalModel->getRefrecePaypalClient();
			
		$refundamount = priceConvert(ceil($rent_data['refund_amount']));

		$rent_data->isArchive = true;
		$aFlexiblePrice = getFlexiblePrice($rent_data, new \App\Bookedspaceslot());

		$subTotal = priceConvert($aFlexiblePrice['subTotal'], true);
		$subTotalIncludeTax = priceConvert($aFlexiblePrice['subTotalIncludeTax'], true);
		$subTotalIncludeChargeFee = priceConvert($aFlexiblePrice['subTotalIncludeChargeFee'], true);
		$totalPrice = priceConvert($aFlexiblePrice['totalPrice'], true);
		$remaining_amont=abs($aFlexiblePrice['totalPrice'] - $rent_data->refund_amount);
		$prices = $aFlexiblePrice['prices'];

		$usershares=User1sharespace::where('User1ID', $user->id)->get();
		$spaceslots=SpaceSlot::where('SpaceID', $rent_data['user1sharespaces_id'])->get();
		$bookingHistories = \App\Bookinghistory::where('BookedID', $rent_data->id)->orderBy('updated_at', 'DESC')->get();
		$finalCancling = $rent_data->finalCancel;

		if ($rent_data->recur_id && in_array($rent_data->status, array(BOOKING_STATUS_RESERVED, BOOKING_STATUS_PENDING)))
		{
			$rentBooking->storeRecursionHistory(array($rent_data));
		}
		return view('admin/shareuser/edit-booking-shareuser',compact(
				'user','rent_data','usershares','spaceslots', 'prices', 'subTotal',
				'subTotalIncludeTax', 'subTotalIncludeChargeFee', 'totalPrice' , 'refundamount',
				'remaining_amont', 'bookingHistories' , 'finalCancling'
		));

	}

	public function SaveBankInfo(Request $request,$id)
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

		$user=User1::where('HashCode', $id)->firstOrFail();
		$payinfo= User1paymentinfo::firstOrNew(array('User1ID' => $user->id));;
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

	public function SaveHostInfo(Request $request,$id)
	{
		$inputData = $request->formData;
		parse_str($inputData, $formFields);
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
			$user=User1::where('HashCode', $id)->firstOrFail();
			$host= new User1hostmember();
			$host->fill($userData);
			$user->host()->save($host);
		}
		return Response::json(array(
				'success' => true,
				'resp' => 'Inserted'
		));
	}


	public function hostSettingSubmit(Request $request,$id)
	{
		$user=User1::where('HashCode', $id)->firstOrFail();
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

		$user->fill($request->except(['_token','CompanyCertificate','Logo', 'Skills', 'returnURL', 'password', 'Email', 'UserName']));
		
		
		$rules = [
				'NameOfCompany'=> 'required' ,
				'UserName' => 'required',
				'Email' => 'required',
		];
			
		$message = [
				'NameOfCompany.required'=> "会社名" . REQUIRE_MESSAGE_FIELD_TEXT ,
				'UserName.required' => "ユーザー名" . REQUIRE_MESSAGE_FIELD_TEXT ,
				'Email.required' => "メールアドレス" . REQUIRE_MESSAGE_FIELD_TEXT ,
		];
		
		$this->validate($request, $rules, $message);
		
		if ($request->Email)
		{
			$newEmail = $request->Email;
			if ($user->Email != $newEmail)
			{
				$rules['Email'] = 'required|unique:user1s';
				$this->validate($request, $rules, $message);
				
				$user->Email = $newEmail;
				$user->EmailVerificationText = uniqid();
				$user->IsEmailVerified = 'No';
				
				if ($user->save()) {
					// Send email verification
					$from = Config::get('mail.from');
					// Send to admin
					sendEmailCustom ([
						'EmailVerificationText' => $user->EmailVerificationText,
						'sendTo' => $user->Email,
						'template' => 'admin.emails.user1_verifyemail',
						'subject' => trans('common.office spot Email Verification Text')
					]);
				}
			}
		}
		
		if ($request->password)
		{
			$newPass = bcrypt($request->password);
			if ($user->password != $newPass)
			{
				$user->password = $newPass;
				if ($user->save()) {
					// Send email changed password
					sendEmailCustom ([
							'newPassword' => $request->password,
							'user' => $user,
							'sendTo' => $user->Email,
							'template' => 'admin.emails.user1_password_change',
							'subject' => trans('common.office spot - Your password changed')
					]);
				}
			}
		}
		
		if ($request->UserName)
		{
			$newUserName = $request->UserName;
			if ($user->UserName != $newUserName)
			{
				$rules['UserName'] = 'required|unique:user1s';
				$this->validate($request, $rules, $message);
				
				$user->UserName = $newUserName;
				
				if ($user->save()) {
					// Send email changed Username
					sendEmailCustom ([
							'newUserName' => $request->UserName,
							'user' => $user,
							'sendTo' => $user->Email,
							'template' => 'admin.emails.user1_username_change',
							'subject' => trans('common.office spot - Your UserName changed')
					]);
				}
			}
		}
			
		$user->save();
		
		Session::flash('suc', 'updated');

		if ($request->returnURL)
			return redirect($request->returnURL);
		else
			return redirect(URL::current());

		//return($request->all());
	}


	public function editspace($id)
	{
		$user=User1::where('HashCode', $id)->firstOrFail();
		//User1sharespace::where('HashID', $id)->firstOrFail();
		return view("admin/shareuser/edit-space",compact('user'));


	}
	public function shareUserSpaceList($id)
	{
		$user=User1::where('HashCode', $id)->firstOrFail();
		$spaces=$user->spaces;
		return view("admin/shareuser/partial_tab_2",compact('user','spaces'));


	}

	public function shareUserAddSpace($id)
	{
		$IsEdit='False';
		$IsDuplicate='False';

		$space=new User1sharespace();

		$user=User1::where('HashCode', $id)->firstOrFail();
		// Check this space has slot or not
		$isThisSpaceHasSlot = Spaceslot::isthisSpaceHasSlot($space);

		return view("admin/shareuser/partial_tab_2_form",compact('user', 'space','IsEdit','IsDuplicate', 'isThisSpaceHasSlot'));

	}

	public function shareUserEditSpace($id,$spaceID)
	{
		$IsEdit='True';
		$IsDuplicate='False';
		$user=User1::where('HashCode', $id)->firstOrFail();
		$space=User1sharespace::where('HashID', $spaceID)->firstOrFail();
		$tags = $space->tags;
		$aTagName = array();
		if (count($tags))
		{
			foreach ($tags as $tag)
			{
				$aTagName[] = $tag->Name;
			}
		}

		// Check this space has slot or not
		$isThisSpaceHasSlot = Spaceslot::isthisSpaceHasSlot($space);

		return view('admin/shareuser/edit-space',compact('user','space','IsEdit','IsDuplicate','isThisSpaceHasSlot','aTagName'));
	}

	public function spaceList()
	{
		$spaces=new User1sharespace();
		$hourly=$spaces->where('FeeType','1')->get();
		$daily=$spaces->where('FeeType','2')->get();
		$weekly=$spaces->where('FeeType','3')->get();
		$monthly=$spaces->where('FeeType','4')->get();
		return view("admin/space/list",compact('hourly','daily','weekly','monthly'));

	}
	public function rentUser(Request $request, $id)
	{
		$user=User2::where('HashCode', $id)->firstOrFail();
		$userIde=User2identitie::where('User2ID',$user->id)->where('SentToAdmin','Yes')->get();

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

		// Get invoices
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
		$invoices= $invoices->paginate(100);
		$invoices->appends($request->except(['page']))->links();
			

		return view("admin/rentuser/edit-rentuser",compact('user','userIde', 'invoices', 'rent_data', 'rent_datas', 'rent_data_status', 'allDatas', 'allAvailDatas', 'rent_data_month'));
	}

	public function shareUserInvoiceDetail($userHash, $invoiceID)
	{
		$user=User1::where('HashCode', $userHash)->firstOrFail();
		$booking = Rentbookingsave::where('InvoiceID', $invoiceID)->first();
		$aFlexiblePrice = Rentbookingsave::getInvoiceBookingPayment($booking);
		$prices = $aFlexiblePrice['prices'];
		$refundamount = priceConvert(ceil($booking->refund_amount));
		$totalPrice = priceConvert($aFlexiblePrice['totalPrice'], true);
		$remaining_amont=abs($aFlexiblePrice['totalPrice'] - $booking->refund_amount);

		return view('admin.shareuser.invoice-details-shareuser',compact('user', 'booking', 'prices','refundamount','remaining_amont'));
	}

	public function rentUserInvoiceDetail($userHash, $invoiceID)
	{
		$user=User2::where('HashCode', $userHash)->firstOrFail();
		$booking = Rentbookingsave::where('InvoiceID', $invoiceID)->first();
		$booking->isArchive = true;
		$aFlexiblePrice = getFlexiblePrice($booking, new \App\Bookedspaceslot());
		$prices = $aFlexiblePrice['prices'];
		$refundamount = priceConvert(ceil($booking->refund_amount));
		$totalPrice = priceConvert($aFlexiblePrice['totalPrice'], true);
		$remaining_amont=abs($aFlexiblePrice['totalPrice'] - $booking->refund_amount);

		return view("admin/rentuser/invoice-details-rentuser",compact('user', 'booking', 'prices','refundamount','remaining_amont'));

	}

	public function rentUserReservationDetail($userHash, $bookingID)
	{
		$user=User2::where('HashCode', $userHash)->firstOrFail();
		$rent_data=Rentbookingsave::Where('user_id', $user->id)->where('id',$bookingID)->first();
		$rentBooking = new \App\Rentbookingsave;
		
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

		return view("admin/rentuser/reservation-details-rentuser",compact('user', 'rent_data', 'prices', 'subTotal', 'subTotalIncludeTax', 'subTotalIncludeChargeFee', 'totalPrice','user1Obj','refundamount'));
	}

	public function rentUserCancelPayment(Request $request, $userHash){
		$input=$request->all();
		$rentbooking=new Rentbookingsave();
		$rent_data=Rentbookingsave::find($input['id']);

		try {
			$rentbooking=$rentbooking->cancelpayment($rent_data,$input['id'],$input['type'],$input['t_id']);

			return redirect('MyAdmin/RentUser/' . $userHash . '#tab-2');
		} catch (\WebPay\ErrorResponse\InvalidRequestException $e) {

			return redirect('MyAdmin/RentUser/' . $userHash . '#tab-2')
			->withErrors($e->getMessage())
			->withInput();
		}
	}


	public function rentUserSubmit(Request $request,$id)
	{
		$user=User2::where('HashCode', $id)->firstOrFail();

		$user->fill($request->except(['_token','UserName','Email']));
		$user->save();
		//User1sharespace::where('HashID', $id)->firstOrFail();
		return view("admin/rentuser/edit-rentuser",compact('user'));


	}

	public function sales(Request $request)
	{
		if (isset($request->detail) && $request->detail)
		{
			$aFileTab = array(
					'user_sales' => 'admin.sales.user-sale-detail',
					'total_sales' => 'admin.sales.transfer-detail',
					'transfer_list' => 'admin.sales.transfer-detail',
			);
				
			$rent_datas=Rentbookingsave::where('User1ID', (int)$request->id)
			->whereIn('rentbookingsaves.status', array(BOOKING_STATUS_RESERVED, BOOKING_STATUS_COMPLETED))
			->OrderBy('created_at','desc')->get();
				
			return view($aFileTab[$request->tab],compact('rent_datas'));
		}

		$aFileTab = array(
				'user_sales' => array('parent' => 'admin.sales.payment_tab_1', 'child' => 'admin.sales.payment_sales_table'),
				'total_sales' => array('parent' => 'admin.sales.payment_tab_2', 'child' => 'admin.sales.payment_total_sales_table'),
				'transfer_list' => array('parent' => 'admin.sales.payment_tab_3', 'child' => 'admin.sales.payment_transfer_table'),
		);

		if ($request->tab == 'total_sales')
		{
			$purchasedCondition = '(`status` = '.BOOKING_STATUS_RESERVED.' OR `status` = '.BOOKING_STATUS_COMPLETED.' OR (`status` = '.BOOKING_STATUS_REFUNDED.' AND refund_status > '. BOOKING_REFUND_NO_CHARGE .'))';
			$rent_datas=Rentbookingsave::select(DB::raw('
					COUNT(*) as num_booking,
					SUM(if(`status` = '.BOOKING_STATUS_PENDING.', 1, 0)) AS placed,
					SUM(if(`status` = '.BOOKING_STATUS_REFUNDED.', 1, 0)) AS cancelled,
					SUM(if('.$purchasedCondition.', 1, 0)) AS purchased,
						
					SUM(if('.$purchasedCondition.', amount + refund_amount, 0)) as total_gross_sale,
					SUM(if('.$purchasedCondition.', (ChargeFee * 2) + refund_amount, 0)) as total_net_sale ,
					AVG(if('.$purchasedCondition.', amount + refund_amount, 0)) as avarage_gross_sale,
					AVG(if('.$purchasedCondition.', (ChargeFee * 2) + refund_amount, 0)) as avarage_net_sale'
			));
			$rent_datas = $rent_datas->whereIn('rentbookingsaves.status', array(BOOKING_STATUS_PENDING, BOOKING_STATUS_RESERVED, BOOKING_STATUS_COMPLETED, BOOKING_STATUS_REFUNDED));
		}
		else {
			$rent_datas=Rentbookingsave::select(DB::raw('*, SUM(amount) as total_amount, SUM(ChargeFee) as total_charge_fee'))
			->GroupBy(array('User1ID'))
			->OrderBy('id','desc');
			$rent_datas = $rent_datas->whereIn('rentbookingsaves.status', array(BOOKING_STATUS_RESERVED, BOOKING_STATUS_COMPLETED));
		}
		$dateTime = \Carbon\Carbon::now();
		if ($request->filter_time)
		{
			switch ($request->filter_time)
			{
				case CURRENT_YEAR :
					$startDate = $dateTime->startOfYear()->format('Y-m-d 00:00:00');
					$endDate = $dateTime->endOfYear()->format('Y-m-d 23:59:59');
						
					break;
				case LAST_MONTH :
					$dateTime = $dateTime->subMonths(1);
					$startDate = $dateTime->startOfMonth()->format('Y-m-d 00:00:00');
					$endDate = $dateTime->endOfMonth()->format('Y-m-d 23:59:59');
					break;
				case THIS_MONTH :
					$startDate = $dateTime->startOfMonth()->format('Y-m-d 00:00:00');
					$endDate = $dateTime->endOfMonth()->format('Y-m-d 23:59:59');
					break;
				case LAST_WEEK :
					$dateTime = $dateTime->subWeeks(1);
					$startDate = $dateTime->startOfWeek()->format('Y-m-d 00:00:00');
					$endDate = $dateTime->endOfWeek()->format('Y-m-d 23:59:59');
					break;
			}
				
			$rent_datas = $rent_datas->where('created_at', '>=', $startDate);
			$rent_datas = $rent_datas->where('created_at', '<=', $endDate);
		}
		elseif ($request->start_date || $request->end_date) {
				
			if (trim($request->start_date))
				$rent_datas = $rent_datas->where('created_at', '>=', date('Y-m-d 00:00:00', strtotime($request->start_date)));
				
			if (trim($request->end_date))
				$rent_datas = $rent_datas->where('created_at', '<=', date('Y-m-d 23:59:59', strtotime($request->end_date)));
		}

		$rent_datas = $rent_datas->get();

		if ($request->ajax())
		{
			if (isset($request->filter_time) || (isset($request->tab) && (isset($request->start_date) || isset($request->end_date)))) {
				return view($aFileTab[$request->tab]['child'],compact('rent_datas'));
			}
			elseif ($request->tab) {
				return view($aFileTab[$request->tab]['parent'],compact('rent_datas'));

			}
		}
		else {
			return view("admin/sales/payment-view",compact('rent_datas'));
		}
	}

	public function Identify (Request $request, $userId)
	{
		if ($request->remove)
		{
			$identitieID = $request->remove;
			$aRemove = array();
			$identities = \App\User2identitie::where('id', $identitieID)->get();
			if (count($identities))
			{
				foreach ($identities as $identitie)
				{
					if ($identitie->delete())
					{
						@unlink(public_path() . $identitie->FilePath);
						$aRemove[] = $identitie->id;
					}
				}
			}
			return Response::json(array(
					'success' => true,
					'aRemove' => $aRemove
			));
		}
		elseif (isset($request->approve) || isset($request->unapprove))
		{
			$userID = isset($request->approve) ? $request->approve : $request->unapprove;
			$user = User2::find($userID);
				
			if ($user)
			{
				$user->IsAdminApproved = isset($request->approve) ? 'Yes' : 'No';
				$user->SentToAdmin = isset($request->approve) ? 1 : 0;
				$user->save();
				session()->flash('success', isset($request->approve) ? 'identitie are approved' : 'identitie are change to not approved');
					
				if (isset($request->approve))
				{
					// Send email to admin
					sendEmailCustom ([
					'user2' => $user,
					'sendTo' => $user->Email,
					'template' => 'user2.emails.approve_identify',
					'subject' => 'Offispo レントユーザー審査完了のお知らせ']
					);
				}
					
				return redirect('MyAdmin/RentUser/'.$user->HashCode.$request->hash);
			}
		}
	}
	public function Certificate (Request $request, $userId)
	{
		if ($request->remove)
		{
			$certificateID = $request->remove;
			$aRemove = array();
			$certificates = \App\User1certificate::where('id', $certificateID)->get();
			if (count($certificates))
			{
				foreach ($certificates as $certificate)
				{
					if ($certificate->delete())
					{
						@unlink(public_path() . $certificate->Path);
						$aRemove[] = $certificate->id;
					}
				}
			}
			return Response::json(array(
					'success' => true,
					'aRemove' => $aRemove
			));
		}
		elseif (isset($request->approve) || isset($request->unapprove))
		{
			$userID = isset($request->approve) ? $request->approve : $request->unapprove;
			$user = User1::find($userID);
			if ($user)
			{
				$user->IsAdminApproved = isset($request->approve) ? 'Yes' : 'No';
				$user->SentToAdmin = isset($request->approve) ? 1 : 0;
				$user->save();
				session()->flash('success', isset($request->approve) ? 'Certificate are approved' : 'Certificate are change to not approved');
					
				if (isset($request->approve))
				{
					// Send email to admin
					sendEmailCustom ([
					'user1' => $user,
					'sendTo' => $user->Email,
					'template' => 'user1.emails.approve_certificate',
					'subject' => 'Offispo シェアユーザー審査完了のお知らせ']
					);
				}
					
				return redirect('MyAdmin/ShareUser/'.$user->HashCode.$request->hash);
			}
		}
	}

	public function shareUserAddSpaceSubmit(Request $request,User1sharespace $space,$id)
	{
		$inputData = $request->formData;
		parse_str($inputData, $formFields);
		$request->merge($formFields);
			

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
		$user=User1::where('HashCode', $id)->firstOrFail();
		$request->merge(array('User1ID' => $user->id));
		/*if (Auth::check())
		 {
		$request->merge(array('User1ID' => Auth::user()->id));
		}
		else
		{
		$request->merge(array('User1ID' => Session::get("ShareUserID")));
		} */

		if(!empty($request->Skills))
		{
			$request->merge(array('Skills' => implode (",", $request->Skills)));
		}
		if(!empty($request->OtherFacilities))
		{
			$request->merge(array('OtherFacilities' => implode (",", $request->OtherFacilities)));
		}

		if (isset($request->saveDraft))
		{
			$request->merge(array('status' => SPACE_STATUS_DRAFT));
		}

		$s=$space->create($request->except(['_token','dataimage','formData','saveDraft']));

		$spaceID=$s->id;
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
		for($i=1;$i<=5;$i++)
		{
			if(!empty($request->dataimage["thumb_$i"]))
			{
				$main = json_decode($request->dataimage['thumb_'.$i]);
				$filename= $main->filename;
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				$newfilename=$mydir.'thumb_'.$i.'_org_'.$spaceID.'.'.$ext;
				$newfilename1=$mydir1.'thumb_'.$i.'_org_'.$spaceID.'.'.$ext;
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

		session()->flash('success', 'Space Created');
		return back();

		//	return view('user1.dashboard.select-sharespace');

		//echo $request->dataimage['main'];
		//$request->Skills=implode (",", $request->Skills);
		//print_r($request->except(['_token','dataimage']));
		//return($request->all());
		return Response::json(array(
				'success' => true,
				'next' => ""
		));


	}

	public function shareUserEditSpaceSubmit(Request $request,$id,$thisSpaceID)
	{
		$space=User1sharespace::where('HashID', $thisSpaceID)->firstOrFail();

		$inputData = $request->formData;
		parse_str($inputData, $formFields);
		$request->merge($formFields);
			

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
		 $request->merge(array('User1ID' => Auth::user()->id));		*/

		if(!empty($request->Skills))
		{
			$request->merge(array('Skills' => implode (",", $request->Skills)));
		}
		if(!empty($request->OtherFacilities))
		{
			$request->merge(array('OtherFacilities' => implode (",", $request->OtherFacilities)));
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

		$space->fill($request->except(['_token','dataimage','formData','tags','saveDraft']));

		// Check this space has slot or not
		$isThisSpaceHasSlot = Spaceslot::isthisSpaceHasSlot($space);
		if (!$isThisSpaceHasSlot || $space->shareUser->IsAdminApproved == 'No')
		{
			// If don't have slot, change status to private
			if ($space->shareUser->IsAdminApproved == 'No')
			{
				Session::flash('error', trans('common.user1_not_allow_to_make_space_public'));
			}
		}

		if (isset($request->saveDraft))
		{
			$space->status = SPACE_STATUS_DRAFT;
		}

		$space->save();
		$spaceID=$space->id;

		if (!$spaceID)
		{
			Session::flash('error', trans('Space save not successfully, please try again !'));
			return back();
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
			$spaceimg->Coords="x1:".$main->x1.",y1:".$main->y1.",x2:".$main->x2.",y2:".$main->y2.",w:".$main->w.",h:".$main->h.",wr:".$main->wr."";
			$spaceimg->Main=1;

			$spaceimg->save();
		}
		for($i=1;$i<=5;$i++)
		{
			if(!empty($request->dataimage["thumb_$i"]))
			{
				$rmd=uniqid();
				$main = json_decode($request->dataimage['thumb_'.$i]);
				$filename= $main->filename;
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

		session()->flash('success', 'Space is updated');
		return back();

		return Response::json(array(
				'success' => true,
				'url' => '/MyAdmin/ShareUser/'. $id,
				'next' => ""
		));
	}



}
