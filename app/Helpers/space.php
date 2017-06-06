<?php
function getStatusName($status)
{
	if($status == SPACE_STATUS_PUBLIC)
	{
		return('公開');
	}
	elseif($status == SPACE_STATUS_PRIVATE)
	{
		return('非公開');
	}
	elseif($status == SPACE_STATUS_DRAFT)
	{
		return('下書き');
	}
}

function getSpaceStatusMapper(){
	return array(
			SPACE_STATUS_PUBLIC => 'Public',
			SPACE_STATUS_PRIVATE => 'Private',
			SPACE_STATUS_DRAFT => 'Draft',
	);
}

function checkType($type){
	if($type==SPACE_FIELD_CORE_WORKING || $type==SPACE_FIELD_OPEN_DESK):
	return true;
	else:
	return false;
	endif;
}

function getSpaceTypeText ( $space )
{
	$feeType = is_object($space) ? $space->FeeType : $space;
	$spaceType = '';
	if ( $feeType == 1 ) $spaceType = '時間';
	else if ( $feeType == 2 ) $spaceType = '日間';
	else if ( $feeType == 3 ) $spaceType = '週間';
	else if ( $feeType == 4 ) $spaceType = 'ヶ月';
	else if ( $feeType == 100 ) $spaceType = '未分類';
	
	return $spaceType;
}

function getSpaceTypeFee($space)
{
	if($space->FeeType==1)
		$term = $space->HourFee;
	else if($space->FeeType==2)
		$term = $space->DayFee;
	else if($space->FeeType==3)
		$term = $space->WeekFee;
	else if($space->FeeType==4)
		$term = $space->MonthFee;

	return $term;
}

function getSpaceAddress($space) 
{
	return $space->Prefecture . $space->District . $space->Address1 . $space->Address2;
}

function isCoreWorkingOrOpenDesk($space)
{
	return 
			in_array($space->Type, array(SPACE_FIELD_CORE_WORKING, SPACE_FIELD_OPEN_DESK));
}

function getSpaceTypeFieldByNumber($typeNumber)
{
	if($typeNumber == 1)
		$type = 'Hour';
	else if($typeNumber==2)
		$type = 'Day';
	else if($typeNumber==3)
		$type = 'Week';
	else if($typeNumber==4)
		$type = 'Month';

	return $type;
}

function renderSpaceUsageDateText($space)
{
	$term='';
	if($space->FeeType==1)
		$term = '利用日/時間帯:';
	else if($space->FeeType==2)
		$term = '利用日:';
	else if($space->FeeType==3)
		$term = '利用週:';
	else if($space->FeeType==4)
		$term = '利用開始:';

	return $term;
}

function renderSpaceDurationText($space)
{
	$term='';
	if($space->FeeType==1)
		$term = '選択時間:';
	else if($space->FeeType==2)
		$term = '選択期間:';
	else if($space->FeeType==3)
		$term = '選択期間:';
	else if($space->FeeType==4)
		$term = '選択期間:';

	return $term;
}

function renderSpaceTypeTermText($space)
{
	$term='';
	if($space->FeeType==1)
		$term = '最低利用時間';
	else if($space->FeeType==2)
		$term = '最低利用日数';
	else if($space->FeeType==3)
		$term = '最低利用期間';
	else if($space->FeeType==4)
		$term = '最低利用期間';

	return $term;
}

function getSpaceMinTermAlert($space)
{
	if($space->FeeType==1)
		$message =  trans('common.min_term_hour_error', ['min_term' => renderSpaceTypeTerm($space, false)]);
	else if($space->FeeType==2)
		$message =  trans('common.min_term_day_error', ['min_term' => renderSpaceTypeTerm($space, false)]);
	else if($space->FeeType==3)
		$message =  trans('common.min_term_week_error', ['min_term' => renderSpaceTypeTerm($space, false)]);
	else if($space->FeeType==4)
		$message =  trans('common.min_term_month_error', ['min_term' => renderSpaceTypeTerm($space, false)]);

	return $message;
}

function getSpaceSlotType($space)
{
	$type='';
	if($space->FeeType==1)
		$type = 'HourSpace';
	else if($space->FeeType==2)
		$type = 'DailySpace';
	else if($space->FeeType==3)
		$type = 'WeeklySpace';
	else if($space->FeeType==4)
		$type = 'MonthlySpace';

	return $type;
}

function renderSpaceTypeTerm($space, $showType = true, $minTerm = 0)
{
	$term='';
	if($space->FeeType==1)
		$term = ($minTerm ? $minTerm : ($space->HourMinTerm ? $space->HourMinTerm : '1')) . ($showType ? '時間' : '');
	else if($space->FeeType==2)
		$term = ($minTerm ? $minTerm : ($space->DayMinTerm ? $space->DayMinTerm : '1')) . ($showType ? '日間' : '');
	else if($space->FeeType==3)
		$term = ($minTerm ? $minTerm : ($space->WeekMinTerm ? $space->WeekMinTerm : '1')) . ($showType ? '週間' : '');
	else if($space->FeeType==4)
		$term = ($minTerm ? $minTerm : ($space->MonthMinTerm ? $space->MonthMinTerm : '1')) . ($showType ? 'ヶ月' : '');

	return $term;
}

function renderNearestStations($space)
{
	$stations = json_decode($space['NearestStations']);
	$html = '';
	if (empty($stations))
	{
		$address = $space->Prefecture . $space->District . $space->Address1;
		$nearestStation = 	new \App\Library\NearestStation;
		$aStations = $nearestStation->getNearestStations($address);
		
		// Save Neareast Station
		\App\Station::where('SpaceID', $space->id)->delete();
		foreach ($aStations as $station)
		{
			$oStation = new \App\Station;
			$oStation->SpaceId = $space->id;
			$oStation->Name = $station['name'];
			$oStation->Line = $station['line'];
			$oStation->Postal = $station['postal'];
			$oStation->Prefecture = $station['prefecture'];
			$oStation->Distance = $station['distance'];
			$oStation->Lat = $station['y'];
			$oStation->Long = $station['x'];
			$oStation->save();
		}
		
		$stations = $aStations;
		$space->NearestStations = json_encode($aStations);
		$space->save();
	}
		
	foreach ($stations as $station) {
		$station = (array)$station;
		$minute = ceil($station['distance'] / 80);
		$html .= '<div class="station">'. $station['name'] . '駅 '. $minute . '分</div>';
	}
	return $html;
}

function getFlexiblePrice(&$rent_data, $oSlot,$count=0){
	if (!$rent_data) return '';

	if (isset($rent_data->isArchive) && $rent_data->isArchive)
	{
		$rent_data->spaceID = $rent_data->bookedSpace;
	}

	$prices = array();
	// Change the space price depending date.
	$slots_id=explode(';',$rent_data->spaceslots_id);
	if (isset($rent_data->isArchive) && $rent_data->isArchive)
	{
		$spaceslots = $oSlot->where('SpaceID', $rent_data->user1sharespaces_id)
		->where('BookedID', $rent_data->id);
		if (isset($rent_data->recurSlotIds) && count($rent_data->recurSlotIds))
		{
			$spaceslots = $oSlot->whereIn('SlotID', $rent_data->recurSlotIds);
		}
		$spaceslots = $spaceslots->groupBy(array('SlotID'));
	}
	else {
		$spaceslots = $oSlot->where('SpaceID', $rent_data->user1sharespaces_id)->whereIn('id', array_filter(array_unique($slots_id)));
		$spaceslots = $spaceslots->where('Status', '<>', -1);
	}

	//$spaceslots = $spaceslots->where('Status', '<>', -1);   /* Moved inside else to solve bug number 67 */
	$spaceslots = $spaceslots->orderBy('StartDate', 'ASC');
	$spaceslots = $spaceslots->get();

	foreach ($spaceslots as $indexSlot => $spaceSlot)
	{
		$prices[$indexSlot]['duration'] = $rent_data->spaceID->FeeType == SPACE_FEE_TYPE_HOURLY ? $rent_data->Duration : 1;
		$prices[$indexSlot]['timeRange'] = $rent_data->hourly_time;
		$prices[$indexSlot]['price'] = flexibleSpacePrice($rent_data->spaceID, $spaceSlot->StartDate);
		$prices[$indexSlot]['SpecialDay'] = @$rent_data->spaceID->SpecialDay;
		$prices[$indexSlot]['Holiday'] = @$rent_data->spaceID->Holiday;
		$prices[$indexSlot]['Date'] = $spaceSlot['StartDate'];
	}

	$subTotal = 0;
	foreach ($prices as $price )
	{
		$subTotal += $price['price'] * $price['duration'];
	}

	$aReturn = array();
	$aReturn['subTotal'] = round($subTotal);
	$aReturn['subTotalIncludeTax'] = round($subTotalIncludeTax = $subTotal * BOOKING_TAX_PERCENT / 100);
	$aReturn['subTotalIncludeChargeFee'] = round($subTotalIncludeChargeFee = ($subTotal + $subTotalIncludeTax) * BOOKING_CHARGE_FEE_PERCENT / 100);
	$aReturn['totalPrice'] = round($subTotal + $subTotalIncludeTax + $subTotalIncludeChargeFee);
	$aReturn['prices'] = $prices;

	return $aReturn;
}

function lowestFlexibleSpacePrice(&$space)
{
	$aFees = array();
	if($space->FeeType == SPACE_FEE_TYPE_HOURLY){
		if ($space->per_hour_status)
		{
			$aFees[] = $space->HourFeeHoliday;
			$aFees[] = $space->HourFeeSun;
			$aFees[] = $space->HourFeeSat;
			$aFees[] = $space->HourFeeWeek;
			sort($aFees);
			$space->HourFee = $aFees[0];
		}
		return $space->HourFee;
	}
	elseif($space->FeeType == SPACE_FEE_TYPE_DAYLY){
		if ($space->per_day_status)
		{
			$aFees[] = $space->DayFeeHoliday;
			$aFees[] = $space->DayFeeSun;
			$aFees[] = $space->DayFeeSat;
			$aFees[] = $space->DayFeeWeekday;
			sort($aFees);
			$space->DayFee = $aFees[0];
		}
		return $space->DayFee;
	}
	elseif($space->FeeType == SPACE_FEE_TYPE_WEEKLY){
		return $space->WeekFee;
	}
	elseif($space->FeeType == SPACE_FEE_TYPE_MONTHLY){
		return $space->MonthFee;
	}
}

function flexibleSpacePrice(&$space, $date = '')
{
	if ($date)
		$dateTime = \Carbon\Carbon::createFromFormat('Y-m-d', $date);
	else
		$dateTime = \Carbon\Carbon::now();

	$dayOfWeek = $dateTime->dayOfWeek;
	$holidayTime = new \App\Library\HolidayDateTime($dateTime->format('Y-m-d'));
	$isHoliday = $holidayTime->holiday();
	$isSun = $dayOfWeek == \Carbon\Carbon::SUNDAY;
	$isSat = $dayOfWeek == \Carbon\Carbon::SATURDAY;

	$space->Holiday = '';
	if($space->FeeType == SPACE_FEE_TYPE_HOURLY){
		if ($space->per_hour_status)
		{
			if ($isHoliday)
			{
				$space->HourFee = $space->HourFeeHoliday ? $space->HourFeeHoliday : $space->HourFee;
				$space->SpecialDay = '祝日料金';
				$space->Holiday = $isHoliday;
			}
			elseif ($isSun)
			{
				$space->HourFee = $space->HourFeeSun ? $space->HourFeeSun : $space->HourFee;
				$space->SpecialDay = '日曜料金';
			}
			elseif ($isSat)
			{
				$space->HourFee = $space->HourFeeSat ? $space->HourFeeSat : $space->HourFee;
				$space->SpecialDay = '土曜料金';
			}
			else
			{
				$space->HourFee = $space->HourFeeWeek ? $space->HourFeeWeek : $space->HourFee;
				$space->SpecialDay = '平日料金';
			}
		}

		return $space->HourFee;
	}
	elseif($space->FeeType == SPACE_FEE_TYPE_DAYLY){
		if ($space->per_day_status)
		{
			if ($isHoliday)
			{
				$space->DayFee = $space->DayFeeHoliday ? $space->DayFeeHoliday : $space->DayFee;
				$space->SpecialDay = '祝日料金';
				$space->Holiday = $isHoliday;
			}
			elseif ($isSun)
			{
				$space->DayFee = $space->DayFeeSun ? $space->DayFeeSun : $space->DayFee;
				$space->SpecialDay = '日曜料金';
			}
			elseif ($isSat)
			{
				$space->DayFee = $space->DayFeeSat ? $space->DayFeeSat : $space->DayFee;
				$space->SpecialDay = '土曜料金';
			}
			else
			{
				$space->DayFee = $space->DayFeeWeekday ? $space->DayFeeWeekday : $space->DayFee;
				$space->SpecialDay = '平日料金';
			}
		}
		return $space->DayFee;
	}
	elseif($space->FeeType == SPACE_FEE_TYPE_WEEKLY){
		return $space->WeekFee;
	}
	elseif($space->FeeType == SPACE_FEE_TYPE_MONTHLY){
		return $space->MonthFee;
	}

}

function getTotalSpaceSlotPrice($space, $aSlots, $specificTime = '')
{
	if ($specificTime)
	{
		$aTimeStart = explode('-', $specificTime);
		$timeStart = date('H:i:s', strtotime(trim($aTimeStart[0])));
		$timeEnd = date('H:i:s', strtotime(trim($aTimeStart[1])));
		$totalDuration = $timeEnd - $timeStart;
	}
	else
		$totalDuration = getSpaceSlotDuration($aSlots, false);

	$subTotal = $totalDuration * getSpaceTypeFee($space);
	return $subTotal;
}

function getSpaceSlotDuration($spaceSlot, $durationText = true, $rent_data = false)
{
	$cloneSpaceSlot = array();
	if (isset($spaceSlot->Type))
	{
		$cloneSpaceSlot[] = $spaceSlot;
		$spaceSlot = $cloneSpaceSlot;
	}

	if (empty($spaceSlot[0]))
		return '';

	$type = $spaceSlot[0]->Type;
	$durationHour = $durationDay = $durationWeek = $durationMonth = 0;
	foreach ($spaceSlot as $slot)
	{
		$dateStart 	= new DateTime($slot->StartDate);
		$dateEnd 	= new DateTime($slot->EndDate);
		$dateEnd->add(new DateInterval('P5D'));
		$diff = date_diff($dateStart, $dateEnd);

		$durationHour += $slot->DurationHours;
		$durationDay += 1;
		$durationWeek += ceil($slot->DurationDays / 7);
		$durationMonth += $diff->m;
	}

	switch($type)
	{
		case 'HourSpace' :
			return getDurationTimeRange($rent_data->hourly_time) . ($durationText ? '時間' : '');
			break;
		case 'DailySpace' :
			return $durationDay . ($durationText ? '日' : '');
			break;
		case 'WeeklySpace' :
			return $durationWeek . ($durationText ? '週間' : '');
			break;
		case 'MonthlySpace' :
			return $durationMonth . ($durationText ? 'ヶ月' : '');
			break;
	}
}

function getPrice(&$space, $showCurrency = false, $date = '', $isCalLowest = false, $hasHtml = true)
{
	if (!$space) return '';

	// Change the space price depending date.
	if ($isCalLowest)
		lowestFlexibleSpacePrice($space);
	else
		flexibleSpacePrice($space, $date);

	$price='';
	if($space->FeeType==1)
		$price = ($hasHtml ? '<strong class="price-label">' : '') . @number_format($space->HourFee,0). ($hasHtml ? "</strong>/ 時間" : '');
	else if($space->FeeType==2)
		$price = ($hasHtml ? '<strong class="price-label">' : '') . @number_format($space->DayFee,0). ($hasHtml ? "</strong>/ 日" : '');
	else if($space->FeeType==3)
		$price = ($hasHtml ? '<strong class="price-label">' : '') . @number_format($space->WeekFee,0). ($hasHtml ? "</strong>/ 週" : '');
	else if($space->FeeType==4)
		$price = ($hasHtml ? '<strong class="price-label">' : '') . @number_format($space->MonthFee,0). ($hasHtml ? "</strong>/ 月" : '');

	$price = ($showCurrency ? '¥' : '') . $price;
	return($price);
}

function getSpaceTitle($space, $limit = false, $end = '...') {
	if ($limit)
		return str_limit($space->Title, $limit, $end);
	else
		return $space->Title ;
}

function getSpaceDescription($space, $limit = false, $end = false) {
	if ($limit)
		return str_limit($space->Details, $limit, $end);
	else
		return $space->Details ;
}

function isHourlySpace($space)
{
	return $space->FeeType == SPACE_FEE_TYPE_HOURLY;
}

function isDaylySpace($space)
{
	return $space->FeeType == SPACE_FEE_TYPE_DAYLY;
}

function isWeeklySpace($space)
{
	return $space->FeeType == SPACE_FEE_TYPE_WEEKLY;
}

function isMonthlySpace($space)
{
	return $space->FeeType == SPACE_FEE_TYPE_MONTHLY;
}

function calculateSpaceLastBooking($space)
{
	$timeNow = date('Y-m-d H:00:00');
	$oTimeNow = \Carbon\Carbon::createFromFormat('Y-m-d H:00:00', $timeNow);
	
	$minStartTime = $space->LastBook ? (int)$space->LastBook : 1;
	$minStartTimeUnit = $space->LastBookUnit ? (int)$space->LastBookUnit : 1;
	
	switch ($minStartTimeUnit)
	{
		case SPACE_FEE_TYPE_HOURLY:
			$oTimeNow->addHours($minStartTime);
			break;
		case SPACE_FEE_TYPE_DAYLY:
			$oTimeNow->addDays($minStartTime);
			break;
		case SPACE_FEE_TYPE_WEEKLY:
			$oTimeNow->addWeeks($minStartTime);
			break;
		case SPACE_FEE_TYPE_MONTHLY:
			$oTimeNow->addMonths($minStartTime);
			break;
	}
	// Calculate lastBook Time
	return $oTimeNow;
}

function getSpaceTypeMapper(){
	$aTypes = array(
			'Desk' => array(SPACE_FIELD_CORE_WORKING, SPACE_FIELD_OPEN_DESK, SPACE_FIELD_SHARE_DESK),
			'PrivateOffice' => array(SPACE_FIELD_PRIVATE_OFFICE_OLD, SPACE_FIELD_PRIVATE_OFFICE, SPACE_FIELD_TEAM_OFFICE, SPACE_FIELD_OFFICE),
			'MeetingSpace' => array(SPACE_FIELD_METTING),
			'SeminarSpace' => array(SPACE_FIELD_SEMINAR_SPACE),
	);
	return $aTypes;
}

function getSpaceTypeIconHtml($space){
	switch($space->Type) {
		case SPACE_FIELD_CORE_WORKING :
			$spaceTypeIcon = '<i class="icon-space-icon-st-coworking icon-size-2"></i>';
			break;
		case SPACE_FIELD_OPEN_DESK :
			$spaceTypeIcon = '<i class="icon-space-icon-st-open_desk icon-size-2"></i>';
			break;
		case SPACE_FIELD_SHARE_DESK :
			$spaceTypeIcon = '<i class="icon-space-icon-st-dedicated_desk icon-size-2"></i>';
			break;
		case SPACE_FIELD_PRIVATE_OFFICE :
			$spaceTypeIcon = '<i class="icon-space-icon-st-private_office icon-size-2"></i>';
			break;
		case SPACE_FIELD_TEAM_OFFICE :
			$spaceTypeIcon = '<i class="icon-space-icon-st-team_office icon-size-2"></i>';
			break;
		case SPACE_FIELD_OFFICE :
			$spaceTypeIcon = '<i class="icon-space-icon-st-office icon-size-2"></i>';
			break;
		case SPACE_FIELD_METTING :
			$spaceTypeIcon = '<i class="icon-space-icon-st-meetingroom icon-size-2"></i>';
			break;
		case SPACE_FIELD_SEMINAR_SPACE :
			$spaceTypeIcon = '<i class="icon-space-icon-st-seminar icon-size-2"></i>';
			break;
		default:
			$spaceTypeIcon = '';
			break;
	}
	return $spaceTypeIcon;
}

function getAllSpaceImages($id)
{
	$imgs=\App\Spaceimage::whereIn('ShareSpaceID', function($query) use ($id){
		$query->select(array('id'))->from('user1sharespaces')->where('User1ID','=',$id)->get();
	})->get();
	return $imgs;
}

function getAllAvailSpaceImages($id)
{
	$spaces = \App\User1sharespace::where('User1ID','=', $id)
		->where('status','=', SPACE_STATUS_PUBLIC)
		->get();
	
	$allImages = array();
	if ($spaces && !empty($spaces))
	{
		foreach ( $spaces as $space )
		{
			$aVailableSlots = \App\Spaceslot::getAvailableSpaceSlot($space);
			if (count($aVailableSlots))
			{
				$imgs = \App\Spaceimage::where('ShareSpaceID', $space->id)->get();
				
				if (count($imgs))
				{
					foreach ($imgs as $img)
					{
						$allImages[] = $img;
					}
				}
			}
		}
	}
	return $allImages;
}