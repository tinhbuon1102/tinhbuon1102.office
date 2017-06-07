<?php
function getBookingStatus($rent_data, $html = false)
{
	if ($html)
	{
		if($rent_data->status == BOOKING_STATUS_PENDING) {
			$status =  '<p class="btn btn-pending-alt btn-xs">'. trans('booking_list.pending') .'</p>';
		}
		elseif($rent_data->status == BOOKING_STATUS_RESERVED) {
			if($rent_data->in_use == BOOKING_IN_USE)
				$status =  '<p class="btn btn-inuse-alt btn-xs">'. trans('booking_list.in_use') .'</p>';
			else
				$status =  '<p class="btn btn-reserved-alt btn-xs">'. trans('booking_list.reserved') .'</p>';
		}
		elseif($rent_data->status == BOOKING_STATUS_REFUNDED) {
			if ($rent_data->refund_status != BOOKING_REFUND_CHARGE_100) {
				$status = '<p class="btn btn-cancel-alt btn-xs">'. trans('booking_list.cancel') .'</p>';
			}
			elseif ($rent_data->refund_status == BOOKING_REFUND_CHARGE_100) {
				$status = '<p class="btn btn-cancel-alt btn-xs">'. trans('booking_list.cancel') .'</p>';
			}
		
		}
		elseif($rent_data->status == BOOKING_STATUS_CALCELLED) {
			$status = '<p class="btn btn-cancel-alt btn-xs">'. trans('booking_list.cancel') .'</p>';
		}
		elseif($rent_data->status == BOOKING_STATUS_COMPLETED) {
			$status = '<p class="btn btn-success-alt btn-xs">'. trans('booking_list.completed') .'</p>';
		}
		else {
			$status = '<p class="btn btn-cancel-alt btn-xs">'. trans('booking_list.No Status') .'</p>';
		}
		
	}
	else {
		switch($rent_data->status)
		{
			case BOOKING_STATUS_PENDING :
				$status = trans('booking_list.pending');
				break;
			case BOOKING_STATUS_RESERVED :
				if ($rent_data->in_use)
					$status = trans('booking_list.in_use');
				else
					$status = trans('booking_list.reserved');
					
				break;
			case BOOKING_STATUS_REFUNDED :
				if ($rent_data->refund_status == BOOKING_REFUND_CHARGE_100)
					$status = trans('booking_list.cancel');
				else
					$status = trans('booking_list.cancel');
				break;
			case BOOKING_STATUS_CALCELLED :
				$status = trans('booking_list.cancel');
				break;
			case BOOKING_STATUS_DRAFT :
				$status = '未払い';
				break;
			case BOOKING_STATUS_COMPLETED :
				$status = trans('booking_list.completed');
				break;
			default :
				$status = 'No status';
				break;
		}		
	}
	
	return $status;
}

function getBookingPaymentStatus($rent_data, $html = false)
{
	if ($html)
	{
		if($rent_data->status == BOOKING_STATUS_PENDING) {
			$status =  '<p class="btn btn-pending-alt btn-xs">'. trans('booking_details.pre-sale') .'</p>';
		}
		elseif($rent_data->status == BOOKING_STATUS_RESERVED) {
			if($rent_data->in_use == BOOKING_IN_USE)
				$status =  '<p class="btn btn-reserved-alt btn-xs">'. trans('booking_details.real-sale') .'</p>';
			else
				$status =  '<p class="btn btn-reserved-alt btn-xs">'. trans('booking_details.real-sale') .'</p>';
		}
		elseif($rent_data->status == BOOKING_STATUS_REFUNDED) {
			if ($rent_data->refund_status != BOOKING_REFUND_CHARGE_100) {
				$status = '<p class="btn btn-cancel-alt btn-xs">'. trans('booking_details.refunded') .'</p>';
			}
			elseif ($rent_data->refund_status == BOOKING_REFUND_CHARGE_100) {
				$status = '<p class="btn btn-cancel-alt btn-xs">'. trans('booking_details.non-refundable') .'</p>';
			}
		
		}
		elseif($rent_data->status == BOOKING_STATUS_CALCELLED) {
			$status = '<p class="btn btn-cancel-alt btn-xs">'. trans('booking_details.non-refundable') .'</p>';
		}
		elseif($rent_data->status == BOOKING_STATUS_COMPLETED) {
			$status =  '<p class="btn btn-reserved-alt btn-xs">'. trans('booking_details.real-sale') .'</p>';
		}
		else {
			$status = '<p class="btn btn-cancel-alt btn-xs">'. trans('booking_details.non-refundable') .'</p>';
		}
		
	}
	else {
		switch($rent_data->status)
		{
			case BOOKING_STATUS_PENDING :
				$status = trans('booking_details.pre-sale');
				break;
			case BOOKING_STATUS_RESERVED :
				if ($rent_data->in_use)
					$status = trans('booking_details.real-sale');
				else
					$status = trans('booking_details.real-sale');
				break;
			case BOOKING_STATUS_REFUNDED :
				if ($rent_data->refund_status == BOOKING_REFUND_CHARGE_100)
					$status = trans('booking_details.non-refundable');
				else
					$status = trans('booking_details.refunded');
				break;
				break;
			case BOOKING_STATUS_CALCELLED :
				$status = trans('booking_details.non-refundable');
				break;
			case BOOKING_STATUS_DRAFT :
				$status = '未払い';
				break;
			case BOOKING_STATUS_COMPLETED :
				$status = trans('booking_details.real-sale');
				break;
			default :
				$status = 'No status';
				break;
		}		
	}
	
	return $status;
}

function isBookingRecursion($rent_data)
{
	if (!$rent_data) return false;
	
	return $rent_data['spaceID']['FeeType'] == SPACE_FEE_TYPE_MONTHLY && $rent_data['Duration'] >= 6;
}
function getPaymentExpireDays($space)
{
	$expire_days = 5;
	if (isHourlySpace($space))
		$expire_days = 2;
	elseif (isDaylySpace($space))
		$expire_days = 7;
	elseif (isWeeklySpace($space))
		$expire_days = 14;
	elseif (isMonthlySpace($space))
		$expire_days = 31;
	
	return $expire_days;
}
function getBookingSlotDate($spaceSlot, $isReturn = false, $rent_data = false)
{
	$cloneSpaceSlot = array();
	if (isset($spaceSlot['Type']))
	{
		$cloneSpaceSlot[] = $spaceSlot;
		$spaceSlot = $cloneSpaceSlot;
	}

	if (empty($spaceSlot[0]))
		return '';

	$type = $spaceSlot[0]['Type'];
	$usedDate = '';
	$aUsedDate = array();
	$startSlot = $spaceSlot[0];
	$endSlot = $spaceSlot[count($spaceSlot) - 1];
	switch($type)
	{
		case 'HourSpace' :
			$aHourly = explode('-', $rent_data->hourly_time);
			$startTime = date('H:00:00', strtotime(trim($aHourly[0])));
			$endTime = date('H:00:00', strtotime(trim($aHourly[1])));
			$StartDate = date('Y-m-d', strtotime($rent_data->hourly_date));
			$usedDate = renderJapaneseDate($StartDate . ' ' . $startTime, false);
			$usedDate .= ' ' . getTimeFormat($startTime);
			$usedDate .= ' - ' . getTimeFormat($endTime);
			break;
		case 'DailySpace' :
			foreach ( $spaceSlot as $slot)
			{
				$aUsedDate[] =  date('Y-m-d', strtotime($slot['StartDate'] . ' ' . $slot['StartTime']));
			}
			$usedDate =  implode('<br /> ', $aUsedDate);
			break;
		case 'WeeklySpace' :
		case 'MonthlySpace' :
			foreach ( $spaceSlot as $slot)
			{
				$oEndDate = new DateTime($slot['EndDate']);
				$oEndDate->sub(new DateInterval('P1D'));
				$aUsedDate[] =  date('Y-m-d', strtotime($slot['StartDate'])) . ' ~ ' . $oEndDate->format('Y-m-d');
			}
			$usedDate =  implode('<br /> ', $aUsedDate);
			break;
	}

	return $usedDate;

}

function isAllowShowRefund($rent_data)
{
	return $rent_data->status == BOOKING_STATUS_REFUNDED && $rent_data->refund_status != BOOKING_REFUND_CHARGE_100;
}

function countBookingByStatus($id,$status)
{
	$cnt=\App\Rentbookingsave::where('status',$status)->where('user_id',$id)->count();
	//$cnt=\App\Chatmessage::where($type,'=', $id)->where('IsRead','=','No')->count();
	return($cnt);
}

function countBookingTotal($id)
{
	$cnt=\App\Rentbookingsave::where('user_id',$id)->count();
	//$cnt=\App\Chatmessage::where($type,'=', $id)->where('IsRead','=','No')->count();
	return($cnt);
}

function countBookingUser1ByStatus($id, $status)
{
	$cnt=\App\Rentbookingsave::whereIn('user1sharespaces_id', function($query) use($id) {
		$query->select(array('id'))->from('user1sharespaces')->where('User1ID','=',$id)->get();
	});
	if ($status == BOOKING_STATUS_INUSE)
	{
		$cnt = $cnt->where('status', BOOKING_STATUS_RESERVED)->where('in_use', BOOKING_IN_USE);
	}
	else{
		$cnt = $cnt->where('status',$status);
	}
	
	$cnt = $cnt->count();
	//$cnt=\App\Chatmessage::where($type,'=', $id)->where('IsRead','=','No')->count();
	return($cnt);
}

function countBookingUser1Total($id)
{
	$cnt=\App\Rentbookingsave::whereIn('user1sharespaces_id', function($query) use($id) {
		$query->select(array('id'))->from('user1sharespaces')->where('User1ID','=',$id)->get();
	})->where('status','!=',5)->count();
	//$cnt=\App\Chatmessage::where($type,'=', $id)->where('IsRead','=','No')->count();
	return($cnt);
}

function lastBookingdate($id)
{
	$cnt=\App\Rentbookingsave::whereIn('user1sharespaces_id', function($query) use($id) {
		$query->select(array('id'))->from('user1sharespaces')->where('User1ID','=',$id)->get();
	})->where('status','!=',5)->orderBy('id','desc')->first();
	//$cnt=\App\Chatmessage::where($type,'=', $id)->where('IsRead','=','No')->count();
	if(!empty($cnt)):
	return($cnt->created_at);
	else:
	return '';
	endif;

}
function getBookingPaidDate($rent_data, $hasTime = true)
{
	$paidDate = $rent_data->created_at;
	$history = $rent_data->bookedHistories()->whereIn('status', array(BOOKING_STATUS_REFUNDED, BOOKING_STATUS_RESERVED))->first();
	if ($history)
	{
		$paidDate = $history->created_at;
	}
	
	$paidDate = renderJapaneseDate($paidDate, $hasTime);
	return $paidDate;
}

function renderBookingSummary($space, $prices,$count=0,$rent_data_status=0)
{
	if($space->FeeType == SPACE_FEE_TYPE_HOURLY || $space->FeeType == SPACE_FEE_TYPE_DAYLY) {
		$groupPrices = array();
		usort($prices, function($a, $b) {
			return $a['Date'] < $b['Date'] ? -1 : 1;
		});

			foreach ($prices as $subPrice)
			{
				$groupPrices[$subPrice['SpecialDay']][] = $subPrice;
			}
			$saturday_yes=0;
			$sunday_yes=0;
			$weekday_yes=0;
			foreach ($groupPrices as $groupPrice)
			{
				$aDates = array();
				$groupPriceTotal = 0;
				foreach ($groupPrice as $subPrice)
				{
					$groupPriceTotal += $subPrice['price'] * $subPrice['duration'];
					if($space->FeeType == SPACE_FEE_TYPE_HOURLY)
					{
						$aHourly = explode('-', $subPrice['timeRange']);
						$timeStart = date('H:00 A', strtotime(trim($aHourly[0])));
						$timeEnd = date('H:00 A', strtotime(trim($aHourly[1])));
						$aDates[] = $timeStart . '-' . $timeEnd;
					}
					else
						$aDates[] = date('m/d', strtotime($subPrice['Date']));
				}
				?>
<?php if ($space->FeeType == SPACE_FEE_TYPE_DAYLY) {?>
<tr class="no-pad summary-price">
	<th style="padding: 16px 16px 0; font-size: 15px; text-align: left; vertical-align: top; color: #888;">
		<p class="total-calc">
			<?php if ($subPrice['SpecialDay']) {?>
			<span class="unit-price">
				<?php echo $subPrice['SpecialDay']?>
				(
				<?php echo implode(', ', $aDates)?>
				)
			</span>
			<?php } else {?>
			<span class="unit-price">
				<?php echo priceConvert(flexibleSpacePrice($space), true)?>
			</span>
			<?php }?>
			x
			<span class="qty <?php if($subPrice['SpecialDay']=='日曜料金'): echo 'sunday_qty';elseif($subPrice['SpecialDay']=='土曜料金'): echo 'saturday_qty'; else: echo 'weekday_qty'; endif ?>">
				<?php echo count($groupPrice);?>
			</span>
			<?php if($subPrice['SpecialDay']=='日曜料金'):
			$sunday_yes=1;
			?>
			<input type='hidden' id='sunday_count' value='<?php echo count($groupPrice);?>' name='sunday_count' />
			<?php endif; ?>
			<?php if($subPrice['SpecialDay']=='平日料金'):
			$weekday_yes=1;
			?>
			<input type='hidden' id='weekday_count' value='<?php echo count($groupPrice);?>' name='weekday_count' />
			<?php endif; ?>
			<?php if($subPrice['SpecialDay']=='土曜料金'): 
			$saturday_yes=1;
			?>
			<input type='hidden' id='saturday_count' value='<?php if($subPrice['SpecialDay']=='土曜料金'): echo count($groupPrice); endif;?>' name='saturday_count' />
			<?php endif; ?>
			<?php echo getSpaceTypeText($space)?>
		</p>
	</th>
	<td style="padding: 16px 16px 0; font-size: 15px; text-align: left; vertical-align: top; color: #888;">
		<div class="lead text-right">
			<span id="unit_total" class="price-value <?php if($rent_data_status==BOOKING_STATUS_REFUNDED): echo 'strike'; endif;?> <?php if($subPrice['SpecialDay']=='日曜料金'): echo 'sunday';elseif($subPrice['SpecialDay']=='土曜料金'): echo 'saturday'; else: echo 'weekday'; endif ?>" style="float: right">
				<small>
					<?php echo priceConvert(round($groupPriceTotal), true);?>
				</small>
			</span>
		</div>
	</td>
</tr>
<?php }elseif($space->FeeType == SPACE_FEE_TYPE_HOURLY) {
	?>
<tr class="no-pad summary-price">
	<th style="padding: 16px 16px 0; font-size: 15px; text-align: left; vertical-align: top; color: #888;">
		<p class="total-calc">
			<?php if ($subPrice['SpecialDay']) {?>
			<span class="unit-price ajax_hour_day">
				<?php echo $subPrice['SpecialDay']?>
			</span>
			<?php } else {?>
			<span class="unit-price ajax_hour_day">
				<?php echo priceConvert(flexibleSpacePrice($space), true)?>
			</span>
			<?php }?>
			x
			<span class="qty <?php if($subPrice['SpecialDay']=='日曜料金'): echo 'sunday_qty';elseif($subPrice['SpecialDay']=='土曜料金'): echo 'saturday_qty'; else: echo 'weekday_qty'; endif ?>">
				<?php echo $subPrice['duration'];?>
			</span>
			<?php echo getSpaceTypeText($space)?>
		</p>
	</th>
	<td style="padding: 16px 16px 0; font-size: 15px; text-align: left; vertical-align: top; color: #888;">
		<div class="lead text-right">
			<span id="unit_total" class="price-value select-subtot <?php if($rent_data_status==BOOKING_STATUS_REFUNDED): echo 'strike'; endif;?> <?php if($subPrice['SpecialDay']=='日曜料金'): echo 'sunday';elseif($subPrice['SpecialDay']=='土曜料金'): echo 'saturday'; else: echo 'weekday'; endif ?>" style="float: right">
				<small>
					<?php echo priceConvert(round($groupPriceTotal), true)?>
				</small>
			</span>
		</div>
	</td>
</tr>
<?php }?>
<?php
			}
			?>
<?php if ($space->FeeType == SPACE_FEE_TYPE_DAYLY && $saturday_yes==0):?>
<tr class="no-pad summary-price saturday_block" style='display: none'>
	<th style="padding: 16px 16px 0; font-size: 15px; text-align: left; vertical-align: top; color: #888;">
		<p class="total-calc">
			<span class="unit-price saturday_date"></span>
			x
			<span class="qty saturday_qty"> 0 </span>
			<input type="hidden" id="saturday_count" value="0" name="saturday_count">
			日間
		</p>
	</th>
	<td style="padding: 16px 16px 0; font-size: 15px; text-align: left; vertical-align: top; color: #888;">
		<div class="lead text-right">
			<span id="unit_total" class="price-value  saturday" style="float: right">
				<small> ¥0</small>
			</span>
		</div>
	</td>
</tr>
<?php endif; ?>
<?php if ($space->FeeType == SPACE_FEE_TYPE_DAYLY && $sunday_yes==0):?>
<tr class="no-pad summary-price sunday_block" style='display: none'>
	<th style="padding: 16px 16px 0; font-size: 15px; text-align: left; vertical-align: top; color: #888;">
		<p class="total-calc">
			<span class="unit-price sunday_date"></span>
			x
			<span class="qty sunday_qty"> 0 </span>
			<input type="hidden" id="sunday_count" value="0" name="sunday_count">
			日間
		</p>
	</th>
	<td style="padding: 16px 16px 0; font-size: 15px; text-align: left; vertical-align: top; color: #888;">
		<div class="lead text-right">
			<span id="unit_total" class="price-value  sunday" style="float: right">
				<small> ¥0</small>
			</span>
		</div>
	</td>
</tr>
<?php endif; ?>
<?php if ($space->FeeType == SPACE_FEE_TYPE_DAYLY && $weekday_yes==0):?>
<tr class="no-pad summary-price weekday_block" style='display: none'>
	<th style="padding: 16px 16px 0; font-size: 15px; text-align: left; vertical-align: top; color: #888;">
		<p class="total-calc">
			<span class="unit-price weekday_date"></span>
			x
			<span class="qty weekday_qty"> 0 </span>
			<input type="hidden" id="weekday_count" value="0" name="weekday_count">
			日間
		</p>
	</th>
	<td style="padding: 16px 16px 0; font-size: 15px; text-align: left; vertical-align: top; color: #888;">
		<div class="lead text-right">
			<span id="unit_total" class="price-value  weekday" style="float: right">
				<small> ¥0</small>
			</span>
		</div>
	</td>
</tr>
<?php endif; ?>
<?php } else{
	?>
<tr class="no-pad summary-price">
	<th style="padding: 16px 16px 0; font-size: 15px; text-align: left; vertical-align: top; color: #888;">
		<p class="total-calc">
			<span class="unit-price">
				<?php if(isset($prices[0]['price'])): echo priceConvert(round($prices[0]['price']), true); endif;?>
			</span>
			x
			<span class="qty">
				<?php echo count($prices)?>
			</span>
			<?php echo getSpaceTypeText($space)?>
		</p>
	</th>
	<td style="padding: 16px 16px 0; font-size: 15px; text-align: left; vertical-align: top; color: #888;">
		<div class="lead text-right">
			<span id="unit_total" class="price-value <?php if($rent_data_status==BOOKING_STATUS_REFUNDED): echo 'strike'; endif;?>">
				<small>
					<?php if(isset($prices[0]['price'])): echo priceConvert(round($prices[0]['price'] * count($prices)), true); endif;?>
				</small>
			</span>
		</div>
	</td>
</tr>
<?php }
}

function getRefundTypeText($rent_data)
{
	$return = '';
	if ($rent_data->status == BOOKING_STATUS_REFUNDED)
	{
		if ($rent_data->refund_status == BOOKING_REFUND_NO_CHARGE)
		{
			$return = '(返金額100%)';
		}elseif ($rent_data->refund_status == BOOKING_REFUND_CHARGE_50)
		{
			$return = '(返金額50%)';
		}elseif ($rent_data->refund_status == BOOKING_REFUND_CHARGE_100)
		{
			$return = '(返金額0%)';
		}
	}
	return $return;
}

function getRefundPrice($rent_data, $html = true, $isAbs = false)
{
	$price = '';
	if ($rent_data->status == BOOKING_STATUS_REFUNDED)
	{
		if ($html)
		{
			$price = ($isAbs ? '' : '- ') . priceConvert($rent_data->amount - $rent_data->refund_amount, true, true);
		}
		else {
			$price = $rent_data->amount - $rent_data->refund_amount;
		}
	}
	return $price;
}

function getRefundChargedPrice($rent_data, $html = true, $isAbs = false)
{
	$price = '';
	if ($rent_data->status == BOOKING_STATUS_REFUNDED)
	{
		if ($html)
		{
			$price = ($isAbs ? '' : '- ') . priceConvert($rent_data->refund_amount, true, true);
		}
		else {
			$price = $rent_data->refund_amount;
		}
	}
	return $price;
}

function renderBookingFor6Months($sub_total_months, $rent_data,$start_date,$count,$edit_booking=false){
	$sub_total_one=$rent_data->bookedSpace->MonthFee;
	
	if (isRecurring($rent_data))
	{
		$chargeFee = (Auth::guard('user1')->check() ? - $rent_data->ChargeFee : $rent_data->ChargeFee);
		$firstPayment = round($rent_data->SubTotal + $rent_data->Tax + $chargeFee);
		$monthlySubTotal = round($rent_data->SubTotal/2);
		$monthlyFee = round($rent_data->SubTotal/2 + ($rent_data->Tax + $chargeFee)/ 2);
	}
	else {
		$rent_data->ChargeFee = $rent_data->ChargeFee / $rent_data->Duration;
		$rent_data->Tax = $rent_data->Tax / $rent_data->Duration;
		$rent_data->SubTotal = $rent_data->SubTotal / $rent_data->Duration;
		
		$chargeFee = (Auth::guard('user1')->check() ? - $rent_data->ChargeFee : $rent_data->ChargeFee);
		$firstPayment = round(($rent_data->SubTotal + $rent_data->Tax + $chargeFee) * 2);
		$monthlySubTotal = round($rent_data->SubTotal);
		$monthlyFee = round($rent_data->SubTotal + ($rent_data->Tax + $chargeFee));
	}
	?>
<table class="book-details book-table calc-table no-border-table">
	<tbody>
		<tr class="total-amount-value ver-top pad-top20 no-btm-pad">
			<th>
				<h3>
					<!--初回支払金額-->
					<?=trans("booking_details.initial_payment")?>
					<!--{{ trans('booking_details.initial_payment') }}-->
				</h3>
			</th>
			<td>
				<div class="lead text-right">
					<span id="total_booking" class="<?php if(isAllowShowRefund($rent_data)): ?> strike <?php endif; ?>">
						¥
						<?php echo priceConvert($firstPayment);?>
					</span>
					<?php if(isAllowShowRefund($rent_data)): ?>
					<span id="total_booking" class="current_amount">
						¥
						<?php echo priceConvert($rent_data->refund_amount);?>
					</span>
					<?php endif; ?>
				</div>
			</td>
		</tr>
		<tr class="no-pad">
			<th>
				<p class="total-calc">
					<span class="unit-price">
						¥
						<?php echo ($sub_total_one);?>
					</span>
					x
					<span class="qty">2 </span>
					ヶ月
				</p>
			</th>
			<td>
				<div class="lead text-right">
					<span id="unit_total" class="price-value" style='float: right'>
						<small>
							¥
							<?php echo priceConvert($sub_total_months);?>
						</small>
					</span>
				</div>
			</td>
		</tr>
		<tr class="no-pad">
			<th>
				<p class="other-fee">
					<?=trans("booking_details.tax")?>
					<!--消費税-->
				</p>
			</th>
			<td>
				<div class="lead text-right">
					<span id="tax_fee">
						<small>
							¥
							<?php echo  priceConvert(($sub_total_months*0.08));?>
						</small>
					</span>
				</div>
			</td>
		</tr>
		<tr class="no-pad">
			<th>
				<p class="other-fee">
					<?=trans("booking_details.charge")?>
					<!--手数料-->
					<!--{{ trans('booking_details.charge') }}-->
					(10%)
				</p>
			</th>
			<td>
				<div class="lead text-right">
					<span id="margin_fee">
						<small>
							<?php echo $chargeFee < 0 ? '-' : ''?>¥
							<?php echo priceConvert(abs($chargeFee));?>
						</small>
					</span>
				</div>
			</td>
		</tr>
		<?php if(isAllowShowRefund($rent_data)): ?>
		<tr class="no-pad red-tr">
			<th>
				<p class="other-fee">
					<?=trans("booking_details.refund")?>
					<!--返金-->
					<?php echo getRefundTypeText($rent_data);?>
				</p>
			</th>
			<td>
				<div class="lead text-right">
					<span id="margin_fee">
						<small>
							- ¥
							<?php if($rent_data->refund_amount==0):?>
							<?php echo priceConvert($firstPayment);?>
							<?php else: ?>
							<?php echo priceConvert($rent_data->refund_amount);?>
							<?php endif;?>
						</small>
					</span>
				</div>
			</td>
		</tr>
		<?php endif; ?>
	</tbody>
</table>
<table class="book-details book-table calc-table no-border-table">
	<tbody>
		<tr class="total-amount-value ver-top pad-top20 no-btm-pad">
			<th>
				<h3>
					<?=trans("booking_details.monthly_payment")?>
					<!--月々の支払い-->
				</h3>
			</th>
			<td>
				<div class="lead text-right">
					<span id="total_booking">
						¥
						<?php echo priceConvert($monthlyFee);?>
					</span>
				</div>
			</td>
		</tr>
		<tr class="no-pad recur-payment">
			<th colspan="2">
				<p class="total-calc">
					<?php echo date('m',strtotime($start_date));?>
					月から、
					<span class="qty">
						<?php echo $count - BOOKING_MONTH_RECURSION_INITPAYMENT;?>
					</span>
					ヶ月間、
					<span class="unit-price">
						¥
						<?php echo priceConvert($monthlyFee);?>
					</span>
					/月 が引き落とされます。
					<!--月末から-->
					<!--ヶ月間、毎月-->
					<!--のお支払いとなります。-->
				</p>
			</th>
			<td></td>
		</tr>
		<tr class="no-pad recur-payment">
			<th>
				<p class="total-calc">
					<?=trans("booking_details.monthly_fee")?>
					<!--月額-->
				</p>
			</th>
			<td>
				<div class="lead text-right">
					<span id="unit_total" class="price-value" style='float: right'>
						<small>
							¥
							<?php echo priceConvert($monthlySubTotal);?>
						</small>
					</span>
				</div>
			</td>
		</tr>
		<tr class="no-pad">
			<th>
				<p class="other-fee">
					<?=trans("booking_details.tax")?>
					<!--消費税-->
				</p>
			</th>
			<td>
				<div class="lead text-right">
					<span id="tax_fee">
						<small>
							¥
							<?php echo priceConvert($sub_total_one*0.08);?>
						</small>
					</span>
				</div>
			</td>
		</tr>
		<tr class="no-pad">
			<th>
				<p class="other-fee">
					<?=trans("booking_details.charge")?>
					<!--手数料-->
					(10%)
				</p>
			</th>
			<td>
				<div class="lead text-right">
					<span id="margin_fee">
						<small>
							<?php echo $chargeFee < 0 ? '-' : ''?>¥
							<?php echo  priceConvert(abs($chargeFee) / BOOKING_MONTH_RECURSION_INITPAYMENT);?>
						</small>
					</span>
				</div>
			</td>
		</tr>
		<?php if($edit_booking==true): ?>
		<!--<tr class="no-pad">
<th><p class="other-fee">withdrawal date</p></th>
<td><div class="lead text-right"><span id="margin_fee"><small><!--月末-->
		<?php //echo date('Y年m月',strtotime('+'.$count-3 .'month',strtotime($start_date)));?>
		<!--</small></span></div></td>
</tr>-->
		<?php endif; ?>
		<tr class="no-pad recur-payment">
			<th>
				<p class="recur-term">
					<strong>
						<?=trans("booking_details.recurring_term")?>
						<!--支払い期間-->
						:
					</strong>
				</p>
			</th>
			<td>
			<?php 
			$endDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $rent_data->charge_end_date);
			$endDate->subMonths(1);
			?>
				<div class="lead text-right">
					<small>
						<span class="start-month">
							<?php echo date('Y年m月',strtotime($start_date));?>
						</span>
						から
						<span class="end-month">
							<?php echo $endDate->format('Y年m月');?>
						</span>
						まで
					</small>
				</div>
			</td>
		</tr>
		<!--start show if booking is cancelled-->
		<?php if($rent_data->status==3): ?>
		<tr class="no-pad red-tr">
			<th colspan="2">
				*
				<?=trans("booking_details.Recurring will not be paid because of cancel")?>
			</th>
		</tr>
		<?php endif; ?>
		<!--end show if booking is cancelled-->
	</tbody>
</table>
<?php
}

function getPaypalRecursionbooking($rent_data,$recuData){
	return true;
?>
<td>
	<?php  echo date('Y-m-d',$charge_info->created); ?>
</td>
<td>
	<?=trans("booking_details.initial_payment")?>
	(
	<?=trans("booking_details.2_months_fee")?>
	)
	<!--Initial Payment(2 months fee)-->
</td>
<td>
	<?php echo priceConvert(round($charge_info->amount));?>
</td>
<td class="align-center">
	<?php if($charge_info->paid==1 && $charge_info->captured==1):echo '支払い済み';else:echo '返金済み';endif;?>
</td>
<?php
if($recursion_info->last_executed!=''):
?>
<td>
	<?php  echo date('Y-m-d',$recursion_info->last_executed); ?>
</td>
<td>
	<?php echo $rent_data->bookedSpace->Title;?>
</td>
<td>
	<?php echo priceConvert(round($recursion_info->amount));?>
</td>
<td class="align-center">
	<?php echo $recursion_info->status;?>
</td>
<?php
endif;
//endforeach;
}

function getRecursionbooking($rent_data){
	if (isset($rent_data->bookingRecursion) && count($rent_data->bookingRecursion))
	{
		foreach ($rent_data->bookingRecursion as $recursion)
		{
		?>
		<tr>
			<td class="ph_date">
				<?php echo renderJapaneseDate(date('Y-m-d H:i:s', $recursion->LastExecuted))?>
			</td>
			<td class="ph_desc">
				<?php echo count($rent_data->bookingRecursion) > 1 ? $recursion->Description : trans("booking_details.2_months_fee")?>
			</td>
			<td class="ph_price">
				<?php echo priceConvert($recursion->Amount, true)?>
			</td>
			<td class="ph_stat align-center">
				<?php echo $recursion->Status?>
			</td>
		</tr>
<?php
		}
	}
}


function isRecurring($rent_data)
{
	return $rent_data->recur_id;
}
