<?php
namespace App;
use App\Library\WebPay\WebPay;
use App\Spaceslot;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use app\Models\Paypal;
use Illuminate\Support\Facades\Auth;

class Rentbookingsave extends Model
{
	protected $guarded = [
		'id'
	];
	protected $table = 'rentbookingsaves';
	protected $webpay;
	protected $fillable = [
		'month_start_date',
		'user_id',
		'user1sharespaces_id',
		'spaceslots_id',
		'total_persons',
		'amount',
		'price',
		'refund_amount',
		'transaction_id',
		'status',
		'request',
		'hourly_date',
		'hourly_time',
		'recur_id'
	];
	public function spaceID ()
	{
		if ( isset($this->InvoiceID) && $this->InvoiceID )
		{
			return $this->hasOne('App\Bookedspace', 'BookedID', 'id');
		}
		else
		{
			return $this->hasOne('App\User1sharespace', 'id', 'user1sharespaces_id');
		}
	}
	public function getSpace ()
	{
		return $this->hasOne('App\User1sharespace', 'id', 'user1sharespaces_id');
	}
	public function bookedSpace ()
	{
		if ( isset($this->InvoiceID) && $this->InvoiceID )
		{
			return $this->hasOne('App\Bookedspace', 'BookedID', 'id');
		}
		else
		{
			return $this->hasOne('App\User1sharespace', 'id', 'user1sharespaces_id');
		}
	}
	public function rentUser ()
	{
		return $this->hasOne('App\User2', 'id', 'user_id');
	}
	public function shareUser ()
	{
		return $this->hasOne('App\User1', 'id', 'User1ID');
	}
	public function review ()
	{
		return $this->hasMany('App\Userreview', 'BookingID', 'id');
	}
	public function SpaceSlot ()
	{
		return $this->hasOne('App\Bookedspaceslot', 'BookedID', 'id')->orderBy('StartDate', 'asc');
	}
	public function bookedSlots ()
	{
		return $this->hasMany('App\Bookedspaceslot', 'BookedID', 'id')->orderBy('StartDate', 'asc');
	}
	public function bookedHistories ()
	{
		return $this->hasMany('App\Bookinghistory', 'BookedID', 'id')->orderBy('created_at', 'DESC');
	}
	public function bookingRecursion ()
	{
		return $this->hasMany('App\BookingRecursion', 'BookingID', 'id')
			->whereNotNull('status')
			->groupBy('NextScheduled')
			->orderBy('id', 'desc');
	}
	public function ScopeBySpacetype ( $query, $id )
	{
		return $query->whereHas('spaceID', function ( $query ) use ( $id )
		{
			$query->where('FeeType', $id);
		});
	}
	public function ScopeJoinSpace ( $query )
	{
		$query->join('bookedspaces', 'rentbookingsaves.id', '=', 'bookedspaces.BookedID');
		$query->join('bookedspaceslots', 'rentbookingsaves.id', '=', 'bookedspaceslots.BookedID');
	}
	public static function getInvoiceBookingPayment ( &$booking )
	{
		$slotIds = explode(';', $booking->spaceslots_id);
		$spaceslots = \App\Bookedspaceslot::whereIn('SlotID', $slotIds)->where('BookedID', $booking->id)->groupBy(array('SlotID'))->orderBy('StartDate', 'ASC')->get();
		
		if ( $booking->recur_id && count($spaceslots) && count($booking->bookingRecursion) )
		{
			$initSlots = array();
			$recurNum = count($booking->bookingRecursion) == 1 ? BOOKING_MONTH_RECURSION_INITPAYMENT : 1;
			// Initial
			for ( $i = 0; $i < $recurNum; $i ++ )
			{
				$initSlots[] = $spaceslots[$i]->SlotID;
			}
			
			$booking->recurSlotIds = $initSlots;
		}
		
		// Don't move Flexible price line, keep it here
		$booking->isArchive = count($spaceslots) ? true : false;
		$oSlot = count($spaceslots) ? new \App\Bookedspaceslot() : new Spaceslot();
		$aFlexiblePrice = getFlexiblePrice($booking, $oSlot);
		
		if ( (isRecurring($booking) || $booking->Duration >= 6) && $aFlexiblePrice && count($aFlexiblePrice) )
		{
			$booking->amount = $aFlexiblePrice['totalPrice'];
			$booking->SubTotal = $aFlexiblePrice['subTotal'];
			$booking->Tax = $aFlexiblePrice['subTotalIncludeTax'];
			$booking->ChargeFee = $aFlexiblePrice['subTotalIncludeChargeFee'];
		}
		
		if ( $booking->status == BOOKING_STATUS_REFUNDED )
		{
			if ( $booking->refund_status == BOOKING_REFUND_CHARGE_50 )
			{
				$booking->refund_amount = round(($booking->SubTotal + $booking->Tax) / 2);
				$booking->ChargeFee = $booking->ChargeFee / 2;
			}
		}
		
		// User 1 amount will be sub to charge fee (user1 + user2)
		global $glob_user;
		if ((!Auth::guard('useradmin')->check() && Auth::guard('user1')->check()) || (Auth::guard('useradmin')->check() && $glob_user && $glob_user->isUser1))
		{
			$booking->amount = $booking->amount - $booking->ChargeFee * 2;
		}
		
		return $aFlexiblePrice;
	}
	public function storeRecursionHistory ( $rent_datas = array() )
	{
		if ( ! count($rent_datas) )
		{
			$rent_datas = \App\Rentbookingsave::where('recur_id', '<>', '')->whereIn('status', array(
				BOOKING_STATUS_RESERVED
			))
				->where('in_use', BOOKING_IN_USE)
				->get();
		}
		
		if ( count($rent_datas) > 0 )
		{
			foreach ( $rent_datas as $rent_data )
			{
				try
				{
					$sTimeNow = \Carbon\Carbon::now('UTC')->timestamp;
					
					if ( $rent_data->payment_method == 'creditcard' )
					{
						$webpay = new WebPay(WEPAY_SECRET_API_KEY);
						$existRecursion = \App\BookingRecursion::where('BookingID', $rent_data->id)->where('RecursionID', $rent_data->recur_id)->first();
						
						if ( ! $existRecursion || ($existRecursion->NextScheduled && $sTimeNow > $existRecursion->NextScheduled) )
						{
							$info = $webpay->recursion->retrieve(array(
								'id' => $rent_data->recur_id
							));
							
							if ( $info && count($info) && (!$existRecursion || ($existRecursion && $info->current_period_start != $existRecursion->LastExecuted)) )
							{
								$oRecursion = new \App\BookingRecursion();
								$oRecursion->BookingID = $rent_data->id;
								$oRecursion->RecursionID = $rent_data->recur_id;
								$oRecursion->RecursionCreated = $info->created;
								$oRecursion->RecursionCustomer = $info->customer;
								$oRecursion->Amount = ! $existRecursion ? ($info->plan->amount * BOOKING_MONTH_RECURSION_INITPAYMENT) : $info->plan->amount;
								$oRecursion->Period = $info->plan->interval;
								$oRecursion->Description = $info->plan->name;
								$oRecursion->LastExecuted = $info->current_period_start;
								$oRecursion->NextScheduled = $info->current_period_end;
								$oRecursion->Status = strtolower($info->status) == 'trial' ? 'active' : $info->status;
								$oRecursion->InitialPayment = ! $existRecursion ? 1 : 0;
								$oRecursion->Deleted = $info->deleted;
								$success = $oRecursion->save();
							}
						}
					}
					elseif ( $rent_data->payment_method == 'paypal' )
					{
						$paypalModel = new \App\Models\Paypal();
						$paypalBilling = new \App\Models\Paypalbilling();
						$PayPal = $paypalModel->getRefrecePaypalClient();
						
						$existRecursion = \App\BookingRecursion::where('BookingID', $rent_data->id)->where('RecursionID', $rent_data->recur_id)->first();
						
						if ( ! $existRecursion || ($existRecursion->NextScheduled && $sTimeNow > $existRecursion->NextScheduled) )
						{
							$inputParam['GRPPDFields'] = array(
								'PROFILEID' => $rent_data->recur_id
							);
							$info = $PayPal->GetRecurringPaymentsProfileDetails($inputParam);
							
							if ( $info && $info['ACK'] == PAYPAL_RESPONSE_STATUS_SUCCESS && 
								(!$existRecursion || ($existRecursion && strtotime($info['LASTPAYMENTDATE']) != $existRecursion->LastExecuted && $existRecursion->RecursionCreated != $existRecursion->LastExecuted)) )
							{
								$oRecursion = new \App\BookingRecursion();
								$oRecursion->BookingID = $rent_data->id;
								$oRecursion->RecursionID = $rent_data->recur_id;
								$oRecursion->RecursionCreated = strtotime($info['TIMESTAMP']);
								$oRecursion->RecursionCustomer = '';
								$oRecursion->Amount = ! $existRecursion ? ($info['AMT'] * BOOKING_MONTH_RECURSION_INITPAYMENT) : $info['AMT'];
								$oRecursion->Period = strtolower($info['REGULARBILLINGPERIOD']);
								$oRecursion->Description = $info['DESC'];
								$oRecursion->LastExecuted = ! $existRecursion ? ($oRecursion->RecursionCreated) : strtotime($info['LASTPAYMENTDATE']);
								$oRecursion->NextScheduled = strtotime($info['NEXTBILLINGDATE']);
								$oRecursion->Status = strtolower($info['STATUS']);
								$oRecursion->InitialPayment = ! $existRecursion ? 1 : 0;
								$oRecursion->Deleted = in_array($info['STATUS'], array(
									'Cancelled',
									'Suspended',
									'Expired'
								)) ? 1 : 0;
								$success = $oRecursion->save();
							}
						}
					}
				}
				catch ( \Exception $e )
				{
					return $this->processException(array(
						'error' => 1,
						'function' => 'storeRecursionHistory',
						'response' => $e
					));
					;
				}
			}
		}
		return true;
	}
	public function reSaveStartEndBookingTime ()
	{
		$rent_datas = \App\Rentbookingsave::get();
		foreach ( $rent_datas as $rent_data )
		{
			$slots_data = array();
			if ( isset($rent_data) && $rent_data['spaceslots_id'] )
			{
				$slots_id = explode(';', $rent_data['spaceslots_id']);
				$slots_id = array_filter(array_unique($slots_id));
				$slots_data = \App\Bookedspaceslot::where('BookedID', $rent_data->id)->get();
				
				if ( count($slots_id) != count($slots_data) ) $slots_data = array();
			}
			
			if ( count($slots_data) )
			{
				$aStartDate = $slots_data[0];
				$aEndDate = $slots_data[count($slots_data) - 1];
				
				if ( in_array($rent_data->SpaceType, array(
					SPACE_FEE_TYPE_MONTHLY,
					SPACE_FEE_TYPE_WEEKLY
				)) )
				{
					$aStartDate['StartTime'] = '';
					$aEndDate['EndTime'] = '';
				}
				$rent_data->charge_start_date = $aStartDate['StartDate'] . ' ' . $aStartDate['StartTime'];
				$rent_data->charge_end_date = @$aEndDate['EndDate'] . ' ' . $aEndDate['EndTime'];
				$rent_data->save();
			}
		}
	}
	function testApi ()
	{
		try
		{
			$webpay = new WebPay(WEPAY_SECRET_API_KEY);
			$before = $webpay->charge->retrieve('ch_3u8g4S5Dy2KO1jZ');
		}
		catch ( \Exception $e )
		{
			return $this->processException(array(
				'error' => 1,
				'function' => 'testAPI',
				'response' => $e
			));
		}
		pr($before);
		die();
	}
	public function deleteRecursion ( $rent_data )
	{
		// Delete Recursion
		if ( $rent_data->recur_id )
		{
			if ( $rent_data->payment_method == 'creditcard' )
			{
				try
				{
					$webpay = new WebPay(WEPAY_SECRET_API_KEY);
					$webpay->recursion->delete(array(
						'id' => $rent_data->recur_id
					));
				}
				catch ( \Exception $e )
				{}
			}
			if ( $rent_data->payment_method == 'paypal' )
			{
				try
				{
					$paypalModel = new \App\Models\Paypal();
					$PayPal = $paypalModel->getRefrecePaypalClient();
					
					$PayPalRequestData = array();
					$PayPalRequestData['MRPPSFields'] = array(
						'PROFILEID' => $rent_data->recur_id,
						'ACTION' => 'Cancel'
					);
					$responseData = $PayPal->ManageRecurringPaymentsProfileStatus($PayPalRequestData);
				}
				catch ( \Exception $e )
				{}
			}
		}
	}
	private function cancelBookingPayment ( &$rent_data, $refund_status = '' )
	{
		if ( ! $refund_status ) return false;
		
		// No charge when status is Pending or Draft
		if ( in_array($rent_data->status, array(
			BOOKING_STATUS_PENDING,
			BOOKING_STATUS_DRAFT
		)) )
		{
			$refund_status = BOOKING_REFUND_NO_CHARGE;
		}
		
		// Return refund status when need get information such as click refund
		// button
		if ( isset($rent_data->return_info) && $rent_data->return_info )
		{
			return array(
				'refund_status' => $refund_status
			);
		}
		if ( isBookingRecursion($rent_data) ) $bookingAmount = round(($rent_data->amount / $rent_data->Duration) * BOOKING_MONTH_RECURSION_INITPAYMENT);
		else $bookingAmount = $rent_data->amount;
		
		switch ( $refund_status )
		{
			case BOOKING_REFUND_NO_CHARGE:
				$refund_amount = 0;
				break;
			case BOOKING_REFUND_CHARGE_50:
				$refund_amount = round($bookingAmount / 2);
				break;
			case BOOKING_REFUND_CHARGE_100:
				$refund_amount = $bookingAmount;
				break;
		}
		
		// round amount refund
		$refund_amount = round($refund_amount);
		
		if ( $rent_data->payment_method == 'creditcard' )
		{
			$webpay = new WebPay(WEPAY_SECRET_API_KEY);
			try
			{
				$aTransaction = array();
				$aTransaction['id'] = $rent_data->transaction_id;
				
				if ( $refund_status != BOOKING_REFUND_CHARGE_100 )
				{
					// Refund if not charge 100%
					if ( $refund_amount )
					{
						$aTransaction['amount'] = $refund_amount;
					}
					$info = $webpay->charge->refund($aTransaction);
					
					if ( $refund_status == BOOKING_REFUND_CHARGE_50 )
					{
						$info = $webpay->charge->capture($aTransaction);
					}
				}
				else
				{
					// Capture and cancel booking if charge 100%
					$info = $webpay->charge->capture($aTransaction);
				}
				
				if ( $info && ($info->refunded || $info->captured) )
				{
					// pr($rent_data->charge_start_date .' -- Refund ');
					$rent_data->status = BOOKING_STATUS_REFUNDED;
					$rent_data->refund_amount = $refund_amount;
					$rent_data->refund_status = $refund_status;
					$rent_data->save();
					$this->bookingSaveCallBack($rent_data);
					
					// Delete Recursion
					$this->deleteRecursion($rent_data);
					
					return true;
				}
			}
			catch ( \Exception $e )
			{
				$info = $webpay->charge->retrieve($rent_data->transaction_id);
				if ( $info && ($info->refunded || $info->amount_refunded) )
				{
					// pr($rent_data->charge_start_date .' -- Refunded ');
					$rent_data->status = BOOKING_STATUS_REFUNDED;
					$rent_data->refund_amount = $refund_amount;
					$rent_data->refund_status = $refund_status;
					$rent_data->save();
					$this->bookingSaveCallBack($rent_data);
					
					// Delete Recursion
					$this->deleteRecursion($rent_data);
				}
				return $this->processException(array(
					'error' => 1,
					'function' => 'cancelBookingPayment',
					'response' => $e
				));
			}
		}
		if ( $rent_data->payment_method == 'paypal' )
		{
			try
			{
				$paypalModel = new \App\Models\Paypal();
				$PayPal = $paypalModel->getRefrecePaypalClient();
				$refundSuccess = false;
				$captureSuccess = false;
				
				if ( $refund_status != BOOKING_REFUND_CHARGE_100 )
				{
					if ( $refund_status == BOOKING_REFUND_CHARGE_50 )
					{
						$REFUNDTYPE = 'Partial';
						$refundData['RTFields'] = array(
							'TRANSACTIONID' => $rent_data->transaction_id,
							'REFUNDTYPE' => $REFUNDTYPE,
							'AMT' => $refund_amount,
							'CURRENCYCODE' => 'JPY'
						);
					}
					
					else
					{
						$REFUNDTYPE = 'Full';
						$refundData['RTFields'] = array(
							'TRANSACTIONID' => $rent_data->transaction_id,
							'REFUNDTYPE' => $REFUNDTYPE,
							'CURRENCYCODE' => 'JPY'
						);
					}
					
					// $getTransData['GTDFields'] = array('TRANSACTIONID' =>
					// $rent_data->transaction_id);
					// $response =
					// $PayPal->GetTransactionDetails($getTransData);
					
					$response = $PayPal->RefundTransaction($refundData);
					
					$voidData['DVFields'] = array(
						'AUTHORIZATIONID' => $rent_data->transaction_id
					);
					$response = $PayPal->DoVoid($voidData);
					
					if ( $refund_status == BOOKING_REFUND_CHARGE_50 )
					{
						$response = $this->captureBookingPayment($rent_data);
					}
				}
				else
				{
					// Capture and cancel booking if charge 100%
					$response = $this->captureBookingPayment($rent_data);
				}
				
				// pr($rent_data->charge_start_date .' -- Refund ');
				$rent_data->status = BOOKING_STATUS_REFUNDED;
				$rent_data->refund_amount = $refund_amount;
				$rent_data->refund_status = $refund_status;
				$rent_data->save();
				$this->bookingSaveCallBack($rent_data);
				
				// Delete Recursion
				$responseDelete = $this->deleteRecursion($rent_data);
				
				return true;
			}
			catch ( \Exception $e )
			{
				return $this->processException(array(
					'error' => 1,
					'function' => 'cancelBookingPayment',
					'response' => $e
				));
			}
		}
	}
	private function saveBookingWithParam ( $rent_data, $params )
	{
		foreach ( $params as $param )
		{}
	}
	private function captureBookingPayment ( &$rent_data )
	{
		if ( $rent_data->payment_method == 'creditcard' )
		{
			$webpay = new WebPay(WEPAY_SECRET_API_KEY);
			try
			{
				// Call the Callback function after change status
				$info = $webpay->charge->capture(array(
					'id' => $rent_data->transaction_id
				));
				if ( $info->captured )
				{
					// pr($rent_data->charge_start_date .' -- Capture ');
					$rent_data->save();
					$this->bookingSaveCallBack($rent_data);
					
					if ( $rent_data->status == BOOKING_STATUS_COMPLETED )
					{
						// Delete Recursion
						$this->deleteRecursion($rent_data);
					}
					
					return true;
				}
			}
			catch ( \Exception $e )
			{
				$info = $webpay->charge->retrieve($rent_data->transaction_id);
				if ( $info->refunded )
				{
					$this->processCancelPayment($rent_data, false);
				}
				elseif ( $info->captured )
				{
					// pr($rent_data->charge_start_date .' -- Captured ');
					$rent_data->save();
					$this->bookingSaveCallBack($rent_data);
				}
				
				if ( $rent_data->status == BOOKING_STATUS_COMPLETED )
				{
					// Delete Recursion
					$this->deleteRecursion($rent_data);
				}
				
				return $this->processException(array(
					'error' => 1,
					'function' => 'captureBookingPayment',
					'response' => $e
				));
			}
		}
		
		if ( $rent_data->payment_method == 'paypal' )
		{
			try
			{
				$paypalModel = new \App\Models\Paypal();
				$PayPal = $paypalModel->getRefrecePaypalClient();
				
				if ( isBookingRecursion($rent_data) ) $amount = round(($rent_data->amount / $rent_data->Duration) * BOOKING_MONTH_RECURSION_INITPAYMENT);
				else $amount = $rent_data->amount;
				
				$DCFields = array(
					'AMT' => $amount,
					"AUTHORIZATIONID" => $rent_data->transaction_id,
					"COMPLETETYPE" => "Complete",
					"CURRENCYCODE" => CURRENCYCODE,
					"INVNUM" => $rent_data->InvoiceID
				);
				
				$PayPalRequestData = array(
					'DCFields' => $DCFields
				);
				$response = $PayPal->DoCapture($PayPalRequestData);
				$rent_data->transaction_id = isset($response['TRANSACTIONID']) ? $response['TRANSACTIONID'] : $rent_data->transaction_id;
				$rent_data->save();
				$this->bookingSaveCallBack($rent_data);
				
				if ( $rent_data->status == BOOKING_STATUS_COMPLETED )
				{
					// Delete Recursion
					$this->deleteRecursion($rent_data);
				}
				return true;
			}
			catch ( \Exception $e )
			{
				return $this->processException(array(
					'error' => 1,
					'function' => 'processCancelPayment',
					'response' => $e
				));
			}
		}
	}
	private function cancelPaymentBySpaceType ( $rent_data, $aDiff )
	{
		$oTimeNow = \Carbon\Carbon::now();
		$oUsedTime = \Carbon\Carbon::createFromFormat(DATE_TIME_DEFAULT_FORMAT, $rent_data->charge_start_date);
		$oCreatedTime = \Carbon\Carbon::createFromFormat(DATE_TIME_DEFAULT_FORMAT, $rent_data->created_at);
		
		if (isMonthlySpace($rent_data->spaceID)){
			$oUsedTime = \Carbon\Carbon::createFromFormat(DATE_TIME_DEFAULT_FORMAT, $rent_data->created_at);
		}
		
		// Future will be Relative
		// Past will be Nagative
		$iUsedInSeconds = $oTimeNow->diffInSeconds($oUsedTime, false);
		$iUsedInHours = $iUsedInSeconds / 3600;
		$iUsedInDays = $iUsedInHours / 24;
		
		$iCreatedInSeconds = $oTimeNow->diffInSeconds($oCreatedTime, false);
		$iCreatedInHours = $iCreatedInSeconds / 3600;
		$iCreatedInDays = $iCreatedInHours / 24;
		
		if ( $iUsedInDays >= $aDiff['free'] || ($iCreatedInDays >= - 1 && $iCreatedInDays <= 0) && ($iCreatedInHours >= - 1 && $iCreatedInHours <= 0) )
		{
			// Free refundable
			$response = $this->cancelBookingPayment($rent_data, BOOKING_REFUND_NO_CHARGE);
		}
		elseif ( $iUsedInDays < $aDiff['free'] && $iUsedInDays >= $aDiff['half_charge'] )
		{
			// 50% will be charged
			$response = $this->cancelBookingPayment($rent_data, BOOKING_REFUND_CHARGE_50);
		}
		elseif ( $iUsedInDays < $aDiff['full_charge'])
		{
			// 100% will be charged and cancel booking
			$response = $this->cancelBookingPayment($rent_data, BOOKING_REFUND_CHARGE_100);
		}
		return $response;
	}
	public function processCancelPayment ( $rent_data, $isAuto = true )
	{
		// Return false if rent data not found
		if ( ! $rent_data ) return false;
		
		try
		{
			$oTimeNow = \Carbon\Carbon::now();
			$oUsedTime = \Carbon\Carbon::createFromFormat(DATE_TIME_DEFAULT_FORMAT, $rent_data->charge_start_date);
			
			if (isMonthlySpace($rent_data->spaceID)){
				$oUsedTime = \Carbon\Carbon::createFromFormat(DATE_TIME_DEFAULT_FORMAT, $rent_data->created_at);
				$oUsedTime = $oUsedTime->addDays((int)config('booking.Monthly.DAY_AUTOMATIC_CANCELLED'));
			}
			
			// Future will be Relative
			// Past will be Nagative
			$iUsedInSeconds = $oTimeNow->diffInSeconds($oUsedTime, false);
			if ( $iUsedInSeconds <= 0 && $rent_data->status == BOOKING_STATUS_PENDING )
			{
				// - PEDING should be changed to CANCELLED if start date has
				// passed as pending
				return $this->cancelBookingPayment($rent_data, BOOKING_REFUND_NO_CHARGE);
			}
			
			elseif ( ! $isAuto )
			{
				// If cancelled by USER
				$aChargeStatus = array(
					BOOKING_STATUS_DRAFT,
					BOOKING_STATUS_PENDING,
					BOOKING_STATUS_RESERVED
				);
				
				if ( ! in_array($rent_data->status, $aChargeStatus) )
				{
					return array(
						'error' => 1,
						'function' => 'processCancelPayment',
						'response' => trans('common.Your booking status is not able to refund !')
					);
				}
				
				switch ( $rent_data->SpaceType )
				{
					case SPACE_FEE_TYPE_HOURLY :
						/* * Hourly Booking
						 can be cancelled-more than 2days before start date
						 50% will be charged- 1day before start date
						 100% will be charged- less than 24hours.
						 *If a reservation is booked with less than 24 hours notice for all space type,
						 *user2 will have 1hour from the time they booked to cancel and not be charged for the reservation.
						 */
						$aDiff = [
							'free' => (int)config('booking.Hourly.DAYS_BEFORE_START_DATE_CAN_BE_CANCELLED_CHARGE_0'),
							'half_charge' => (int)config('booking.Hourly.MORE_THAN_HOURS_BEFORE_START_DATE_CANCELLED_CHARGE_50') / 24,
							'full_charge' => (int)config('booking.Hourly.LESS_THAN_HOURS_BEFORE_START_DATE_CANCELLED_CHARGE_100') / 24
						];
						
						break;
					
					case SPACE_FEE_TYPE_DAYLY:
						/* Daily Booking
						 can be cancelled- more than 7days before start date
						 50% will be charged- 3days before start date
						 100% will be charged- less than 3 days before start date
						 *If a reservation is booked with less than 24 hours notice for all space type,
						 *user2 will have 1hour from the time they booked to cancel and not be charged for the reservation.
						 */

						$aDiff = [
							'free' => (int)config('booking.Daily.DAYS_BEFORE_START_DATE_CAN_BE_CANCELLED_CHARGE_0'),
							'half_charge' => (int)config('booking.Daily.MORE_THAN_DAYS_BEFORE_START_DATE_CANCELLED_CHARGE_50'),
							'full_charge' => (int)config('booking.Daily.LESS_THAN_DAYS_BEFORE_START_DATE_CANCELLED_CHARGE_100')
						];
						break;
					
					case SPACE_FEE_TYPE_WEEKLY:
						/* Weekly Booking
						 can be cancelled- more than 2weeks before start date
						 50% will be charged- 1week before start date
						 100% will be charged- less than 1week before start date
						 *If a reservation is booked with less than 24 hours notice for all space type,
						 *user2 will have 1hour from the time they booked to cancel and not be charged for the reservation.
						 */

						$aDiff = [
							'free' => (int)config('booking.Weekly.DAYS_BEFORE_START_DATE_CAN_BE_CANCELLED_CHARGE_0'),
							'half_charge' => (int)config('booking.Weekly.MORE_THAN_DAYS_BEFORE_START_DATE_CANCELLED_CHARGE_50'),
							'full_charge' => (int)config('booking.Weekly.LESS_THAN_DAYS_BEFORE_START_DATE_CANCELLED_CHARGE_100')
						];
						
						break;
					
					case SPACE_FEE_TYPE_MONTHLY :
						/* Monthly Booking
						 can be cancelled- more than 1month before start date
						 50% of 1 month will be charged- 3weeks before start dated
						 100% of 1 month will be charged- less than 3weeks before start date
						 *If a reservation is booked with less than 24 hours notice for all space type,
						 *user2 will have 1hour from the time they booked to cancel and not be charged for the reservation.
						 */
						$oNextMonth = $oTimeNow->copy()->addMonths((int)config('booking.Monthly.MONTHS_BEFORE_START_DATE_CAN_BE_CANCELLED_CHARGE_0'));
						$aDiff = [
							'free' => -(int)config('booking.Monthly.MONTHS_BEFORE_START_DATE_CAN_BE_CANCELLED_CHARGE_0'),
							'half_charge' => -(int)config('booking.Monthly.MORE_THAN_DAYS_BEFORE_START_DATE_CANCELLED_CHARGE_50'),
							'full_charge' => -(int)config('booking.Monthly.LESS_THAN_DAYS_BEFORE_START_DATE_CANCELLED_CHARGE_100')
						];
						break;
				}
				
				// Call cancel by space type
				if ( isset($aDiff) & count($aDiff) )
				{
					return $this->cancelPaymentBySpaceType($rent_data, $aDiff);
				}
				
				return false;
			}
		}
		catch ( \Exception $e )
		{
			return $this->processException(array(
				'error' => 1,
				'function' => 'processCancelPayment',
				'response' => $e
			));
		}
	}
	private function processException ( $param )
	{
		return $param;
	}
	public function processPaidPayment ( $rent_data, $isAuto = true )
	{
		$sTimeNow = date(DATE_TIME_DEFAULT_FORMAT);
		
		$allowCapture = false;
		
		if ( $isAuto )
		{
			if ( $rent_data->status == BOOKING_STATUS_RESERVED && ($sTimeNow >= $rent_data->charge_start_date || $sTimeNow >= $rent_data->charge_end_date) )
			{
				// - RESERVED should be changed to IN-USE while start time
				// starts until end time
				if ( $sTimeNow >= $rent_data->charge_start_date && $rent_data->in_use != BOOKING_IN_USE )
				{
					$rent_data->in_use = BOOKING_IN_USE;
					$allowCapture = true;
				}
				
				// - RESERVED should be changed to COMPLETED after end time has
				// passed
				if ( $sTimeNow >= $rent_data->charge_end_date && $rent_data->in_use == BOOKING_IN_USE && $rent_data->status == BOOKING_STATUS_RESERVED )
				{
					$rent_data->status = BOOKING_STATUS_COMPLETED;
					$allowCapture = true;
				}
			}
		}
		else
		{
			// Process accept payment
			if ( $rent_data->status == BOOKING_STATUS_PENDING && $sTimeNow < $rent_data->charge_start_date )
			{
				$rent_data->status = BOOKING_STATUS_RESERVED;
				$allowCapture = true;
			}
		}
		
		try
		{
			if ( $allowCapture )
			{
				return $this->captureBookingPayment($rent_data);
			}
		}
		catch ( \Exception $e )
		{
			return $this->processException(array(
				'error' => 1,
				'function' => 'processPaidPayment',
				'response' => $e
			));
		}
	}
	
	/*
	 * We will process Pending , Reserved payment here
	 * - PEDING should be changed to CANCELLED if start date has passed as
	 * pending
	 * - RESERVED should be changed to IN-USE while start time starts until end
	 * time
	 * - RESERVED should be changed to COMPLETED after end time has passed
	 */
	public function processBookingPaymentAuto ( $rent_datas = array() )
	{
		// @TODO remove test function
		// $this->testApi();
		$processStatus = array(
			BOOKING_STATUS_PENDING,
			BOOKING_STATUS_RESERVED
		);
		$sTimeNow = date(DATE_TIME_DEFAULT_FORMAT);
		if ( ! count($rent_datas) )
		{
			$rent_datas = self::whereIn('status', $processStatus)->where('charge_start_date', '<=', $sTimeNow)
				->take(20)
				->get();
		}
		
		foreach ( $rent_datas as $rent_data )
		{
			switch ( $rent_data->status )
			{
				case BOOKING_STATUS_PENDING:
					// - Process Pending payment
					self::processCancelPayment($rent_data);
					
					break;
				
				case BOOKING_STATUS_RESERVED:
					// - RESERVED should be changed to IN-USE while start time
					// starts until end time
					// - RESERVED should be changed to COMPLETED after end time
					// has passed
					self::processPaidPayment($rent_data);
					
					break;
				
				default:
					break;
			}
		}
		die('done import');
	}
	public function deleterecPayment ()
	{}
	private function restoreAvailableSlot ( $slots_data, $rent_data )
	{
		if ( count($slots_data) )
		{
			foreach ( $slots_data as $historySlot )
			{
				// Delete history
				$historySlot->Status = - 1;
				$historySlot->save();
				
				$slot = \App\Spaceslot::find($historySlot->SlotID);
				if ( ! $slot ) continue;
				
				$slot->total_booked = ($slot->total_booked > 0 ? $slot->total_booked - 1 : 0);
				
				if ( $slot->Type == 'HourSpace' )
				{
					if ( $slot->total_booked == 0 )
					{
						$slot->Status = - 1;
						$slot->save();
					}
					else
					{
						$slot->Status = isCoreWorkingOrOpenDesk($rent_data->spaceID) && $rent_data->spaceID->Capacity <= $slot->total_booked ? SLOT_STATUS_BOOKED : SLOT_STATUS_AVAILABLE;
						$slot->save();
					}
					
					$oParentSlot = Spaceslot::where('id', $slot->ParentID)->where('Type', 'HourSpace')->first();
					if ( isCoreWorkingOrOpenDesk($rent_data->spaceID) )
					{
						if ( $oParentSlot )
						{
							// Query to get all booked slot of this parent slot
							$oaBookedSlots = \App\Spaceslot::select('total_booked')->where('ParentID', $slot->ParentID)
								->where('Type', 'HourSpace')
								->get();
							$total_booked = 0;
							foreach ( $oaBookedSlots as $oaBookedSlot )
							{
								$total_booked += $oaBookedSlot->total_booked;
							}
							$oParentSlot->total_booked = $total_booked;
							
							$oParentSlot->save();
						}
					}
				}
				else
				{
					$slot->Status = isCoreWorkingOrOpenDesk($rent_data->spaceID) && $rent_data->spaceID->Capacity <= $slot->total_booked ? SLOT_STATUS_BOOKED : SLOT_STATUS_AVAILABLE;
					$slot->save();
				}
			}
		}
	}
	public function storeBookingHistory ( $rent_data, $storedType )
	{
		// Save Booking History Space table
		$oBookingHistory = new \App\Bookinghistory();
		$bookingAttr = $rent_data->getAttributes();
		$oBookingHistory->BookedID = $rent_data->id;
		$oBookingHistory->StoredType = $storedType;
		foreach ( $bookingAttr as $attField => $attribute )
		{
			if ( ! in_array($attField, array(
				'id',
				'created_at',
				'updated_at'
			)) )
			{
				$oBookingHistory->{$attField} = $attribute;
			}
		}
		$oBookingHistory->save();
	}
	public function bookingSaveCallBack ( $rent_data, $storedType = 'status' )
	{
		if ( $storedType == 'status' )
		{
			// Don't save same status with latest
			$oldBooking = \App\Bookinghistory::where('BookedID', $rent_data->id)->orderBy('id', 'DESC')->first();
			if ( $oldBooking && $oldBooking->status == $rent_data->status )
			{
				return false;
			}
		}
		
		$slots_data = \App\Bookedspaceslot::where('BookedID', $rent_data->id)->orderBy('StartDate', 'asc')->get();
		
		$cloneBooking = clone $rent_data;
		$cloneBooking->isArchive = true;
		$aFlexiblePrice = getFlexiblePrice($cloneBooking, new \App\Bookedspaceslot());
		
		$aHostMembers = [
			$rent_data->shareUser->Email
		];
		$hostMembers = $rent_data->shareUser->host;
		
		if ( count($hostMembers) )
		{
			foreach ( $hostMembers as $hostMember )
			{
				if ( filter_var($hostMember->HostEmail, FILTER_VALIDATE_EMAIL) )
				{
					$aHostMembers[] = $hostMember->HostEmail;
				}
			}
		}
		
		if ( $storedType == 'status' )
		{
			switch ( $rent_data->status )
			{
				case BOOKING_STATUS_COMPLETED:
					// Send email complete to shared user :
					sendEmailCustom(array(
						'sendTo' => $aHostMembers,
						'rent_data' => $rent_data,
						'space' => $rent_data->spaceID,
						'user2' => $rent_data->rentUser,
						'slots_data' => $slots_data,
						'template' => 'user2.emails.booked_shared_user',
						'subject' => 'レビューを投稿しましょう! | hOurOffice'
					));
					
					// Send email complete to rent user
					sendEmailCustom(array(
						'sendTo' => $rent_data->rentUser->Email,
						'rent_data' => $rent_data,
						'space' => $rent_data->spaceID,
						'user2' => $rent_data->rentUser,
						'slots_data' => $slots_data,
						'template' => 'user2.emails.booked_rent_user',
						'subject' => 'レビューを投稿しましょう! | hOurOffice'
					));
					break;
				
				case BOOKING_STATUS_RESERVED:
					// Send email complete to rent user
					sendEmailCustom(array(
					'sendTo' => $rent_data->rentUser->Email,
					'rent_data' => $rent_data,
					'space' => $rent_data->spaceID,
					'user1' => $rent_data->shareUser,
					'user2' => $rent_data->rentUser,
					'slots_data' => $slots_data,
					'aFlexiblePrice' => $aFlexiblePrice,
					'template' => 'user2.emails.accepted_rent_user',
					'subject' => '予約の申込みがありました | hOurOffice'
					));
					break;
					
				case BOOKING_STATUS_REFUNDED:
					// Send email complete to shared user :
					sendEmailCustom(array(
						'sendTo' => $aHostMembers,
						'rent_data' => $rent_data,
						'space' => $rent_data->spaceID,
						'user1' => $rent_data->shareUser,
						'user2' => $rent_data->rentUser,
						'slots_data' => $slots_data,
						'aFlexiblePrice' => $aFlexiblePrice,
						'template' => 'user2.emails.booking_request_refund',
						'subject' => '予約のキャンセルを受け付けました。 | hOurOffice'
					));
					
					// Send email complete to rent user
					sendEmailCustom(array(
						'sendTo' => $rent_data->rentUser->Email,
						'rent_data' => $rent_data,
						'space' => $rent_data->spaceID,
						'user1' => $rent_data->shareUser,
						'user2' => $rent_data->rentUser,
						'slots_data' => $slots_data,
						'aFlexiblePrice' => $aFlexiblePrice,
						'template' => 'user2.emails.booking_refunded_rent_user',
						'subject' => '予約がキャンセルされました。 | hOurOffice'
					));
					
					// Remove relation slot
					$this->restoreAvailableSlot($slots_data, $rent_data);
					break;
				
				case BOOKING_STATUS_CALCELLED:
					// Send email Calcelled
					
					// Remove relation slot
					$this->restoreAvailableSlot($slots_data, $rent_data);
					break;
				
				case BOOKING_STATUS_DRAFT:
					break;
				
				case BOOKING_STATUS_PENDING:
					// Send email complete to shared user :
					sendEmailCustom(array(
						'sendTo' => $aHostMembers,
						'rent_data' => $rent_data,
						'space' => $rent_data->spaceID,
						'user1' => $rent_data->shareUser,
						'user2' => $rent_data->rentUser,
						'slots_data' => $slots_data,
						'aFlexiblePrice' => $aFlexiblePrice,
						'template' => 'user2.emails.booking_completed_shared_user',
						'subject' => '予約の申込みがありました | hOurOffice'
					));
					
					// Send email complete to rent user
					sendEmailCustom(array(
						'sendTo' => $rent_data->rentUser->Email,
						'rent_data' => $rent_data,
						'space' => $rent_data->spaceID,
						'user1' => $rent_data->shareUser,
						'user2' => $rent_data->rentUser,
						'slots_data' => $slots_data,
						'aFlexiblePrice' => $aFlexiblePrice,
						'template' => 'user2.emails.booking_completed_rent_user',
						'subject' => 'ご予約の確認 | hOurOffice'
					));
					
					// Save recursion
					if ( $rent_data->recur_id )
					{
						try
						{
							$this->storeRecursionHistory(array(
								$rent_data
							));
						}
						catch ( \Exception $e )
						{}
					}
					break;
				
				case BOOKING_STATUS_RESERVED:
					break;
			}
			
			if ( $rent_data->status == BOOKING_STATUS_PENDING )
			{
				$notiStatus = NOTIFICATION_BOOKING_PLACED;
			}
			else
			{
				if ( $rent_data->status == BOOKING_STATUS_REFUNDED )
				{
					if ( $rent_data->refund_status == BOOKING_REFUND_CHARGE_50 )
					{
						// Refund 50%
						$notiStatus = NOTIFICATION_BOOKING_REFUND_50;
					}
					elseif ( $rent_data->refund_status == BOOKING_REFUND_CHARGE_100 )
					{
						// Refund 100%
						$notiStatus = NOTIFICATION_BOOKING_REFUND_100;
					}
					else
					{
						$notiStatus = NOTIFICATION_BOOKING_REFUND_NO_CHARGE;
					}
				}
				else
				{
					$notiStatus = NOTIFICATION_BOOKING_CHANGE_STATUS;
				}
			}
			
			// Create notification for User1
			Notification::createNotification($notiStatus, $rent_data->id, $rent_data->User1ID, $rent_data->user_id, 1, 2);
			
			// Create notification for User2
			Notification::createNotification($notiStatus, $rent_data->id, $rent_data->user_id, $rent_data->User1ID, 2, 1);
		}
		$this->storeBookingHistory($rent_data, $storedType);
	}
	public function getStartEndBooking ( $bookingSlots )
	{
		if ( ! $bookingSlots ) return array();
		
		$startSlot = $bookingSlots[0];
		$endSlot = $bookingSlots[count($bookingSlots) - 1];
		
		$startDate = $startSlot->StartDate . ' ' . $startSlot->StartTime;
		$endDate = $startSlot->StartDate . ' ' . $startSlot->StartTime;
		
		return array(
			'StartDate' => $startDate,
			'EndDate' => $endDate
		);
	}
	public function getBookedSlots ( $booking, $isArchive = true )
	{
		if ( $isArchive ) $oSlot = new \App\Bookedspaceslot();
		else $oSlot = new \App\Spaceslot();
		
		$slots = array();
		if ( $isArchive )
		{
			$slots = $oSlot->where('BookedID', $booking->id)
				->orderBy('StartDate', 'ASC')
				->orderBy('StartTime', 'ASC')
				->get();
		}
		else
		{
			$bookedSlotIds = explode(';', $booking->spaceslots_id);
			$slots = $oSlot->whereIn('id', $bookedSlotIds)
				->orderBy('StartDate', 'ASC')
				->orderBy('StartTime', 'ASC')
				->get();
		}
		
		return $slots;
	}
	public function getFinalCancelAttribute ()
	{
		$rentType = $this->spaceSlot->Type;
		
		$rentDate = Carbon::createFromFormat('Y-m-d', $this->spaceSlot->StartDate);
		
		if ( date('Y-m-d', strtotime($rentDate)) == date('Y-m-d', strtotime($this->created_at)) )
		{
			$rentDate = Carbon::createFromFormat('Y-m-d', date('Y-m-d', strtotime($this->created_at)));
			
			$finalcancel = $rentDate->subHours(1);
		}
		
		else
		{
			
			switch ( $rentType )
			{
				
				case 'HourSpace':
					$finalcancel = $rentDate->subDays(2);
					break;
				case 'DailySpace':
					$finalcancel = $rentDate->subDays(7);
					break;
				case 'WeeklySpace':
					$finalcancel = $rentDate->subWeeks(2);
					break;
				case 'MonthlySpace':
					$finalcancel = $rentDate->subMonths(1);
					break;
			}
		}
		
		if ( date('Y-m-d', strtotime($finalcancel)) < date('Y-m-d', strtotime($this->created_at)) )
		{
			// $rentDate_=
			// Carbon::createFromFormat(DATE_TIME_DEFAULT_FORMAT,$this->spaceSlot->StartDate.'
			// '.$this->spaceSlot->StartTime);
			// $finalcancel= $rentDate_->subHours(1);
			
			$created_at = $this->spaceSlot->created_at;
			$finalcancel = $created_at->addHours(1);
			// echo "<pre>rent_data:"; print_r($this->spaceSlot->created_at);
			// echo "</pre>";
			// echo "<pre>rent_data2:"; print_r($this->created_at); echo
			// "</pre>";
		}
		return $finalcancel;
	}
}
