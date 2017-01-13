<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
class Spaceslot extends Model
{
	//
	protected $guarded = ['id'];

	public static function isthisSpaceHasSlot($space)
	{
		// Check available slots
		$aVailableSlots = Spaceslot::getAvailableSpaceSlot($space);
		$aBookingTimeInfo = false;
		$aBookingTimeInfoSelected = array();
		foreach ($aVailableSlots as $aVailableSlot)
		{
		
			$myRequest = new \Illuminate\Http\Request();
			$myRequest->merge(array('booked_date' => $aVailableSlot['StartDate']));
			$myRequest->merge(array('spaceID' => $space->id));
		
			$aBookingTimeInfo = Spaceslot::getBookingTimeInfo($myRequest, $aVailableSlots, $space);
				
			if (count(@$aBookingTimeInfo['timeDefaultSelected']))
			{
				if (!isset($aBookingTimeInfo['timeDefaultSelected']['StartDate']))
					continue;
					
				$aBookingTimeInfoSelected = $aBookingTimeInfo;
				break;
					
			}
		}
		return $aBookingTimeInfoSelected;
	}

	public function User1sharespace()
	{
		return $this->hasOne('App\User1sharespace', 'id', 'SpaceID');
    }
	
	public static function getSpaceSlotBySpaceIDAndType($spaceID, $type, $status = false, $isFrontend = false){
		$carbon = new \Carbon\Carbon;
		$slots = DB::table('spaceslots')
		->select(DB::raw('*'))
		->where('SpaceID', '=', trim($spaceID))
		->where('StartDate', '>', '0')
		->where('EndDate', '>', '0')
		->whereIn('Status', array(SLOT_STATUS_AVAILABLE, SLOT_STATUS_BOOKED))
		->where('Type', '=', trim($type));
		
		if ($status !== false)
		{			
			$slots->where('status', '=', $status);
		}
		
		if ($isFrontend)
		{
			$space = \App\User1sharespace::where('id', $spaceID)->first();
			$oTimeNow = calculateSpaceLastBooking($space);
		
			$startDateAvailable = $oTimeNow->format('Y-m-d');
			$startTimeAvailable = $oTimeNow->format('H:00:00');
			
			$slots = $slots->where('StartDate', '>=', $startDateAvailable);
			if ($space->FeeType == SPACE_FEE_TYPE_HOURLY || $space->FeeType == SPACE_FEE_TYPE_DAYLY)
			{
				$slots = $slots->where(function ($query) use($startDateAvailable, $startTimeAvailable){
					$query = $query->orWhere(function ($query) use ($startDateAvailable, $startTimeAvailable){
						$query->where('StartDate', '>', $startDateAvailable);
					});
							
						$query = $query->orWhere(function ($query) use ($startDateAvailable, $startTimeAvailable){
							$query->where('StartDate', '=', $startDateAvailable);
							$query->whereRaw(DB::Raw('CURDATE() = "' . $startDateAvailable.'"'));
							$query->where('StartTime', '>=', $startTimeAvailable);
						});
						$query->orWhere(function ($query) use($startDateAvailable, $startTimeAvailable){
							$query->where('StartTime', '<=', $startTimeAvailable);
							$query->where('EndTime', '>=', $startTimeAvailable);
							$query->where('Type', '=', 'HourSpace');
				
						});
								
				});
						
			}
			elseif ($space->FeeType == SPACE_FEE_TYPE_WEEKLY || $space->FeeType == SPACE_FEE_TYPE_MONTHLY)
			{
				$slots = $slots->where('StartDate', '>', $startDateAvailable);
			}
			
			
		}
		
		switch($type)
		{
			case 'HourSpace';
			case 'DailySpace';
				$slots->whereColumn('StartDate', '=', 'EndDate');
				$slots->whereColumn('StartTime', '<', 'EndTime');
				$slots->where(function($query) use ($carbon){ 
					$query->orWhere(function($query) use ($carbon){
						$query->where('StartDate', '>', $carbon->today()->subDay(1)->format('Y-m-d'));
						$query->where('Status', '=', 0);
					});
					$query->orWhere(function($query) use ($carbon){
						$query->where('StartDate', '>=', $carbon->subYear(1)->format('Y-m-d'));
						$query->where('Status', '=', 1);
					});
				});
				break;
			case 'WeeklySpace';
				$slots->whereColumn('StartDate', '<', 'EndDate');
				$slots->where(function($query) use ($carbon){
					$query->orWhere(function($query) use ($carbon){
						$query->where('StartDate', '>', $carbon->subWeek(1)->format('Y-m-d'));
						$query->where('Status', '=', 0);
					});
					$query->orWhere(function($query) use ($carbon){
						$query->where('StartDate', '>=', $carbon->subYear(1)->format('Y-m-d'));
						$query->where('Status', '=', 1);
					});
				});
				break;
			case 'MonthlySpace';
				$slots->whereColumn('StartDate', '<', 'EndDate');
				$slots->where(function($query) use ($carbon){
					$query->orWhere(function($query) use ($carbon){
						$query->where('StartDate', '>', $carbon->subMonths(1)->format('Y-m-d'));
						$query->where('Status', '=', 0);
					});
					$query->orWhere(function($query) use ($carbon){
						$query->where('StartDate', '>=', $carbon->subYear(1)->format('Y-m-d'));
						$query->where('Status', '=', 1);
					});
				});
				break;
			
		}
		return $slots->get();
	}
	
	public static function getBookedHourSlots($space, $dateStart, $returnOrigin = false){
		$aFulledRange = array();
		// Get User1 Schedules
		$isCoreWorkingOrOpenDesk = isCoreWorkingOrOpenDesk($space);
		$maxCapacity = $isCoreWorkingOrOpenDesk ? $space['Capacity'] : 1;
		
		// Get User2 booking schedules
		$aBookedSlots = self::where('StartDate', $dateStart)
						->where('SpaceID', $space->id)
						->where('Status', SLOT_STATUS_BOOKED)
						->where('Type', 'HourSpace')->get();
	
		if (count($aBookedSlots) > 1)
		{
			// Get the time range is full
			for ($i = 0; $i < count($aBookedSlots) - 1; $i ++)
			{
				$bookedSlot1 = $aBookedSlots[$i];
				$totalBooked = $isCoreWorkingOrOpenDesk ? $bookedSlot1['total_booked'] : 1;
				
				if ($totalBooked >= $maxCapacity)
				{
					$aFulledRange[$bookedSlot1['StartTime'].'-'.$bookedSlot1['EndTime']] = array(
							'StartDate' => $dateStart,
							'EndDate' => $dateStart,
							'StartTime' => $bookedSlot1['StartTime'], 
							'EndTime' => $bookedSlot1['EndTime']);
				}
				
				$Slot1 = array('StartDate' => $bookedSlot1['StartDate'], 'EndDate' => $bookedSlot1['StartDate'], 'StartTime' => $bookedSlot1['StartTime'], 'EndTime' => $bookedSlot1['EndTime']);
					
				if (count($aBookedSlots) > 1)
				{
					for ($j = $i+1; $j < count($aBookedSlots); $j ++)
					{
						$bookedSlot2 = $aBookedSlots[$j];
						$Slot2 = array('StartDate' => $bookedSlot2['StartDate'], 'EndDate' => $bookedSlot2['StartDate'], 'StartTime' => $bookedSlot2['StartTime'], 'EndTime' => $bookedSlot2['EndTime']);
						if ($Slot1 == $Slot2)
						{
							$totalBooked += $isCoreWorkingOrOpenDesk ? $bookedSlot2['total_booked'] : 1;
							if ($totalBooked >= $maxCapacity)
							{
								$aFulledRange[$bookedSlot2['StartTime'].'-'.$bookedSlot2['EndTime']] = array(
									'StartDate' => $dateStart, 
									'EndDate' => $dateStart,
									'StartTime' => $bookedSlot2['StartTime'], 
									'EndTime' => $bookedSlot2['EndTime']);
							}
						}
						elseif (is2TimeRangeOverlap($Slot1, $Slot2))
						{
							$totalBooked += 1;
							if ($totalBooked >= $maxCapacity)
							{
								$overLapStartTime = $bookedSlot1['StartTime'] >= $bookedSlot2['StartTime'] ? $bookedSlot1['StartTime'] : $bookedSlot2['StartTime'];
								$overLapEndTime = $bookedSlot1['EndTime'] <= $bookedSlot2['EndTime'] ? $bookedSlot1['EndTime'] : $bookedSlot2['EndTime'];
								
								$aFulledRange[$overLapStartTime . '-' . $overLapEndTime] = array(
									'StartDate' => $dateStart, 
									'EndDate' => $dateStart,
									'StartTime' => $overLapStartTime, 
									'EndTime'   => $overLapEndTime);
							}
						}
						else{
							$totalBooked2 = $isCoreWorkingOrOpenDesk ? $bookedSlot2['total_booked'] : 1;
								
							if ($totalBooked2 >= $maxCapacity)
							{
								$aFulledRange[$bookedSlot2['StartTime'].'-'.$bookedSlot2['EndTime']] = array(
									'StartDate' => $dateStart, 
									'EndDate' => $dateStart, 
									'StartTime' => $bookedSlot2['StartTime'], 
									'EndTime' => $bookedSlot2['EndTime']);
							}
								
						}
					}
				}
			}
		}
		elseif(count($aBookedSlots) == 1)
		{
			$bookedSlot1 = $aBookedSlots[0];
			$totalBooked = $isCoreWorkingOrOpenDesk ? $bookedSlot1['total_booked'] : 1;
				
			if ($totalBooked >= $maxCapacity)
			{
				$aFulledRange[$bookedSlot1['StartTime'].'-'.$bookedSlot1['EndTime']] = array(
					'StartDate' => $dateStart, 
					'EndDate' => $dateStart, 
					'StartTime' => $bookedSlot1['StartTime'], 
					'EndTime' => $bookedSlot1['EndTime']);
			}
		}
		if ($returnOrigin)
		{
			return $aFulledRange;
		}
		
		$finalRange = array();
		foreach ($aFulledRange as $index => $fulledRange)
		{
			$startTime = (int)$fulledRange['StartTime'];
			$endTime = (int)$fulledRange['EndTime'];
			for($i = $startTime; $i <= $endTime; $i++)
			{
// 				$finalRange[$index][] = date('H:i:s', strtotime($i . ':00:00'));
				$finalRange[$index][] = $i;
			}
		}
				
		return $finalRange;
	}
	
	public static function getAvailableSpaceSlot($space)
	{
		if (!$space) return array();
		
		// Calculate lastBook Time
		$oTimeNow = calculateSpaceLastBooking($space);
		$startDateAvailable = $oTimeNow->format('Y-m-d');
		$startTimeAvailable = $oTimeNow->format('H:00:00');
		$aAvailableSlots = array();
		if ($space)
		{
			$capacity = isCoreWorkingOrOpenDesk($space) ? $space->Capacity : 1;
			
			$aAvailableSlots = $space->spaceAvailable()
			->where('Status', SLOT_STATUS_AVAILABLE)
			->where('Type', getSpaceSlotType($space))
			->where('ParentID', 0)
			->where('EndDate', '>=', date('Y-m-d'))
			->where('StartDate', '>=', $startDateAvailable)
			->orderBy('StartDate', 'ASC')
			->orderBy('StartTime', 'ASC');
			
			if ($space->FeeType == SPACE_FEE_TYPE_HOURLY || $space->FeeType == SPACE_FEE_TYPE_DAYLY)
			{
				$aAvailableSlots = $aAvailableSlots->where(function ($query) use($startDateAvailable, $startTimeAvailable){
					$query = $query->orWhere(function ($query) use ($startDateAvailable, $startTimeAvailable){
						$query->where('StartDate', '>', $startDateAvailable);
					});
					
					$query = $query->orWhere(function ($query) use ($startDateAvailable, $startTimeAvailable){
						$query->where('StartDate', '=', $startDateAvailable);
						$query->whereRaw(DB::Raw('CURDATE() = "' . $startDateAvailable.'"'));
						$query->where('StartTime', '>=', $startTimeAvailable);
					});
					$query->orWhere(function ($query) use($startDateAvailable, $startTimeAvailable){
						$query->where('StartTime', '<=', $startTimeAvailable);
						$query->where('EndTime', '>=', $startTimeAvailable);
						$query->where('Type', '=', 'HourSpace');
								
					});
							
				});
			}
			elseif ($space->FeeType == SPACE_FEE_TYPE_WEEKLY || $space->FeeType == SPACE_FEE_TYPE_MONTHLY)
			{
				$aAvailableSlots = $aAvailableSlots->where('StartDate', '>', $startDateAvailable);
			}
			
			$aAvailableSlots = $aAvailableSlots->get();
		}
		
		return $aAvailableSlots;
	}
	
	public static function getBookingTimeInfo($request, $aAvailableSlots = array(), $space = false)
	{
		// Assign variable from request
		$success = true;
		$message = '';
		$aAvailableTimeFromList = array();
		$aAvailableTimeToList = array();
		$timeDefaultSelected = array();
		$dateDefaultSelected = array();
		
		$spaceID = trim((int)$request->spaceID);
		$bookedDate = $request->booked_date ? explode(';', trim($request->booked_date)) : (array)date('Y-m-d');
		$bookedIDs = $request->spaceslots_id ? explode(';', trim($request->spaceslots_id)) : array();
		$bookedStartTime = $request->startTime ? date('H:00:00', strtotime(trim($request->startTime))) : '';
		$bookedEndTime = $request->endTime ? date('H:00:00', strtotime(trim($request->endTime))) : '';

		$space = $space ? $space : User1sharespace::find($spaceID);
		$minTerm = (int)renderSpaceTypeTerm($space, false);
		
		$oTimeNow = calculateSpaceLastBooking($space);
		$startDateAvailable = $oTimeNow->format('Y-m-d');
		$startTimeAvailable = $oTimeNow->format('H:00:00');
		
		if ($space)
		{
			$aAvailableSlots = count($aAvailableSlots) ? $aAvailableSlots : Spaceslot::getAvailableSpaceSlot($space);
			$isCoreWorkingOrOpenDesk = isCoreWorkingOrOpenDesk($space);
		}
			
		

		// Validate submitted Space is correct, available or not
		if (!$spaceID || !$space || !count($aAvailableSlots))
		{
			// show error
			$success = false;
			$message = trans('common.You not submited correct data, pls reload and try again');
		}
		else {
			// Validate submitted Date is correct, available or not
			switch ($space->FeeType)
			{
				case SPACE_FEE_TYPE_HOURLY:
					$bookedDate = $bookedDate[0];
					// Get booked duration
					$aBookedSlots = self::getBookedHourSlots($space, $bookedDate, false);
					$aBookedSlotFulls = self::getBookedHourSlots($space, $bookedDate, true);
					$iBookedDuration = 0;
					foreach ( $aBookedSlots as $aBookedSlot ){
						$iBookedDuration += $aBookedSlot[count($aBookedSlot)-1] - $aBookedSlot[0];
					}

					// Get available duration
					$iAvailableDuration = 0;
					$currentHour = date('H');
					$currentDate = date('Y-m-d');
					$allowAddTimeToList = true;
					
					foreach ($aAvailableSlots as $indexAvaiSlot => $aAvailableSlot)
					{
						if ($bookedDate != $aAvailableSlot['StartDate']) continue;
						
						
						$iAvailableDuration += $aAvailableSlot['DurationHours'];

						//Get default selected time and List Time From
						for($i = (int)$aAvailableSlot['StartTime']; $i<= (int)$aAvailableSlot['EndTime'] - $minTerm; $i++)
						{
							// Move next if is past time;
							if ($bookedDate == $currentDate && ($i <= $currentHour || $i <= (int)$startTimeAvailable))
							{
								continue;
							}
							
							$iCountNotOverlap = 0;
							$checkRange = array();
							$checkRange['StartDate'] = $bookedDate;
							$checkRange['EndDate'] = $bookedDate;
							$checkRange['StartTime'] = date('H:i:s', strtotime($i . ":0:0"));
							$checkRange['EndTime'] = date('H:i:s', strtotime(($i+$minTerm) . ":0:0"));
								
							// Check overlap with booked or not, if not , make this is default selected time
							if (count($aBookedSlotFulls))
							{
								foreach ($aBookedSlotFulls as $aBookedSlotFull)
								{
									if (!is2TimeRangeOverlap($aBookedSlotFull, $checkRange))
									{
										$iCountNotOverlap ++;
									}
	
									if ($iCountNotOverlap == count($aBookedSlotFulls))
									{
										$aAvailableTimeFromList[$i] = strlen($i) == 1 ? ('0' . $i) : $i;;
										$timeDefaultSelected = $timeDefaultSelected ? $timeDefaultSelected : $checkRange;
										$bookedIDs = (array)$aAvailableSlot['id']; 
									}
								}
							}
							else {
								$aAvailableTimeFromList[$i] = strlen($i) == 1 ? ('0' . $i) : $i;;
								$timeDefaultSelected = $timeDefaultSelected ? $timeDefaultSelected : $checkRange;
								$bookedIDs = (array)$aAvailableSlot['id'];
							}
							
						}
						
						if (!isset($timeDefaultSelected['StartTime']))
						{
							continue;
						}

						$bookedStartTime = $bookedStartTime ? $bookedStartTime : (isset($timeDefaultSelected['StartTime']) ? $timeDefaultSelected['StartTime'] : '00:00:00');
						if ($request->startTime)
						{
							$timeDefaultSelected = array();
						}
						
						for($i = (int)$bookedStartTime + $minTerm; $i<= (int)$aAvailableSlot['EndTime']; $i++)
						{
							// Move next if is past time;
							if ($bookedDate == $currentDate && ($i <= $currentHour || $i < (int)$startTimeAvailable))
							{
								continue;
							}
							// Get List Time To
							$iCountNotOverlap = 0;
							$checkRange = array();
							$checkRange['StartDate'] = $bookedDate;
							$checkRange['EndDate'] = $bookedDate;
							$checkRange['StartTime'] = $bookedStartTime;
							$checkRange['EndTime'] = date('H:i:s', strtotime(($i) . ":0:0"));

							// Check overlap with booked or not, if not , make this is default selected time
							if (count($aBookedSlotFulls))
							{
								foreach ($aBookedSlotFulls as $aBookedSlotFull)
								{
									if (!is2TimeRangeOverlap($aBookedSlotFull, $checkRange))
									{
										$iCountNotOverlap ++;
									}
	
									if ($iCountNotOverlap == count($aBookedSlotFulls))
									{
										$timeDefaultSelected = $timeDefaultSelected ? $timeDefaultSelected : $checkRange;
										if ($allowAddTimeToList)
											$aAvailableTimeToList[$i] = strlen($i) == 1 ? ('0' . $i) : $i;
										
										$bookedIDs = (array)$aAvailableSlot['id'];
									}
								}
							}
							else {
								$timeDefaultSelected = $timeDefaultSelected ? $timeDefaultSelected : $checkRange;
								if ($allowAddTimeToList)
									$aAvailableTimeToList[$i] = strlen($i) == 1 ? ('0' . $i) : $i;;
								
								$bookedIDs = (array)$aAvailableSlot['id'];
							}
						}
						
						if ($bookedEndTime && in_array((int)$bookedEndTime, $aAvailableTimeToList))
						{
							$timeDefaultSelected['EndTime'] = $bookedEndTime;
							$bookedIDs = (array)$aAvailableSlot['id'];
						}
						
						
						// Make false to stop at current slot time list
						if (count($aAvailableTimeToList))
							$allowAddTimeToList = false;
					}
					
					// Get error
					if ($iBookedDuration >= $iAvailableDuration || ($iAvailableDuration - $iBookedDuration < $minTerm))
					{
						// show error
						$success = false;
						$message = trans('common.The date/time you booked is not avaialbe, please choose another one');
					}
					
					break;
						
				default :
					$capacity = $isCoreWorkingOrOpenDesk ? $space->Capacity : 1;
					$aAvailableSlots = self::where('Status', SLOT_STATUS_AVAILABLE)
						->where('SpaceID', $space->id)
						->where('ParentID', 0)
						->where('Type', getSpaceSlotType($space))
						->where('StartDate', '>=', $startDateAvailable)
						->where('total_booked', '<', $capacity)
						->where('EndDate', '>=', date('Y-m-d'))
						->orderBy('StartDate', 'ASC');
					
					if (count($bookedIDs))
					{
						$aAvailableSlots = $aAvailableSlots->whereIn('id', $bookedIDs);
					}
					
					if ($space->FeeType == SPACE_FEE_TYPE_DAYLY)
					{
						$aAvailableSlots = $aAvailableSlots->where(function ($query) use($startDateAvailable, $startTimeAvailable){
							$query = $query->orWhere(function ($query) use ($startDateAvailable, $startTimeAvailable){
								$query->where('StartDate', '>', $startDateAvailable);
							});
							
							$query = $query->orWhere(function ($query) use ($startDateAvailable, $startTimeAvailable){
								$query->where('StartDate', '=', $startDateAvailable);
								$query->whereRaw(DB::Raw('CURDATE() = "' . $startDateAvailable.'"'));
								$query->where('StartTime', '>=', $startTimeAvailable);
							});
							$query->orWhere(function ($query) use($startDateAvailable, $startTimeAvailable){
								$query->where('StartTime', '<=', $startTimeAvailable);
								$query->where('EndTime', '>=', $startTimeAvailable);
								$query->where('Type', '=', 'HourSpace');
										
							});
									
						});
					}
					elseif ($space->FeeType == SPACE_FEE_TYPE_WEEKLY || $space->FeeType == SPACE_FEE_TYPE_MONTHLY)
					{
						$aAvailableSlots = $aAvailableSlots->where('StartDate', '>', $startDateAvailable);
					}
					
					$aAvailableSlots = $aAvailableSlots->get();
					break;

			}
			
			if (count($aAvailableSlots) <= 0 || (count($bookedIDs) && count($aAvailableSlots)  != count($bookedIDs) && $space->FeeType != SPACE_FEE_TYPE_HOURLY))
			{
				// show error
				$success = false;
				$message = trans('common.The date/time you booked is not avaialbe, please choose another one');
			}
			else {
				if ($space->FeeType != SPACE_FEE_TYPE_HOURLY)
				{
					$aAvailableSlots = $aAvailableSlots->toArray();
					$bookedDate = array();
					// Get the last is current selected
					if (!count($bookedIDs))
					{
						if ($space->FeeType == SPACE_FEE_TYPE_WEEKLY || $space->FeeType == SPACE_FEE_TYPE_MONTHLY)
						{
							$isBreak = false;
							// Get Consecutive dates
							for($i = 0; $i < count($aAvailableSlots); $i++)
							{
								if (!count($bookedDate))
								{
									$bookedDate[] = $aAvailableSlots[$i]['StartDate'];
									continue;
								}
								
								$lastDate = end($bookedDate);
								$oLastDate = \Carbon\Carbon::createFromFormat('Y-m-d', $lastDate);
								$isConsective = $space->FeeType == SPACE_FEE_TYPE_MONTHLY ? 
													$oLastDate->addMonths(1)->format('Y-m-d') == $aAvailableSlots[$i]['StartDate'] :
													$oLastDate->addWeeks(1)->format('Y-m-d') == $aAvailableSlots[$i]['StartDate'];
								
								if ($isConsective){
									if (count($bookedDate) == $minTerm)
									{
										break;
									}
									$bookedDate[] = $aAvailableSlots[$i]['StartDate'];
								}
								else {
									$bookedDate = array();
									continue;
								}
								
							}
							
							
							if (!count($bookedDate) || count($bookedDate) < $minTerm)
							{
								// show error
								$success = false;
								$message = trans('common.space_not_existed');
							}
							else {
								$lastSeletectedDate = @$bookedDate[0];
								foreach ($aAvailableSlots as $aAvailableSlot)
								{
									if (in_array($aAvailableSlot['StartDate'], $bookedDate))
									{
										$bookedIDs[] = $aAvailableSlot['id'];
							
										if ($aAvailableSlot['StartDate'] == $lastSeletectedDate)
										{
											$dateDefaultSelected = $aAvailableSlot;
										}
									}
								}
							}
						}
						else {

							// Get the last is current selected
							for($i = 0; $i < $minTerm; $i++)
							{
								if (isset($aAvailableSlots[$i]) && count($aAvailableSlots[$i]))
									$bookedIDs[] = $aAvailableSlots[$i]['id'];
							}
							
							$lastSeletectedID = @$bookedIDs[0];
							foreach ($aAvailableSlots as $aAvailableSlot)
							{
								if (in_array($aAvailableSlot['id'], $bookedIDs))
								{
									$bookedDate[] = $aAvailableSlot['StartDate'];
									if ($aAvailableSlot['id'] == $lastSeletectedID)
									{
										$dateDefaultSelected = $aAvailableSlot;
									}
								}
							}
							
						}
					}
					else {
						$lastSeletectedID = @$bookedIDs[0];
						foreach ($aAvailableSlots as $aAvailableSlot)
						{
							if (in_array($aAvailableSlot['id'], $bookedIDs))
							{
								$bookedDate[] = $aAvailableSlot['StartDate'];
								if ($aAvailableSlot['id'] == $lastSeletectedID)
								{
									$dateDefaultSelected = $aAvailableSlot;
								}
							}
						}
					}
				}
			}
		}
		if (!$success)
		{
			if (!$request->ajax())
			{
				session()->flash('error', $message);
				return false;
			}
		}

		$timeDefaultSelected = count($timeDefaultSelected) ? $timeDefaultSelected : $dateDefaultSelected;
		
		if (isWeeklySpace($space) || isMonthlySpace($space) || isDaylySpace($space))
		{
			
			
			if (isWeeklySpace($space) || isMonthlySpace($space))
			{
				$endDate = \Carbon\Carbon::createFromFormat('Y-m-d', $timeDefaultSelected['StartDate']);
				
				if (isWeeklySpace($space))
					$endDate->addWeeks(count($bookedDate) - 1)->endOfWeek();
				else
					$endDate->addMonths(count($bookedDate) - 1)->endOfMonth();
					
			}
			else{
				$endDate = \Carbon\Carbon::createFromFormat('Y-m-d', end($bookedDate));
			}
			
			$timeDefaultSelected['StartDateConverted'] = isset($timeDefaultSelected['StartDate']) ? renderJapaneseDate($timeDefaultSelected['StartDate'], false) : '';
			$timeDefaultSelected['EndDateConverted'] = isset($timeDefaultSelected['EndDate']) ? renderJapaneseDate($endDate->format('Y-m-d'), false) : '';
			
			if (isWeeklySpace($space) || isMonthlySpace($space) || (isDaylySpace($space) && count($bookedDate) > 1))
				$timeDefaultSelected['StartDateConverted'] .= ' ~ ' . $timeDefaultSelected['EndDateConverted'];
		}
		else
		{
			$timeDefaultSelected['StartDateConverted'] = isset($timeDefaultSelected['StartDate']) ? renderJapaneseDate($timeDefaultSelected['StartDate'], false) : '';
			$timeDefaultSelected['EndDateConverted'] = isset($timeDefaultSelected['EndDate']) ? renderJapaneseDate($timeDefaultSelected['EndDate'], false) : '';
		}
		
		$timeDefaultSelected['StartTimeConverted'] = isset($timeDefaultSelected['StartTime']) ? getTimeFormat($timeDefaultSelected['StartTime']) : '';
		$timeDefaultSelected['EndTimeConverted'] = isset($timeDefaultSelected['EndTime']) ? getTimeFormat($timeDefaultSelected['EndTime']) : '';
		
		$aDates = (array)$bookedDate;
		$totalPrice = 0;
		$duration = 1;
		$aPrice = array();
		foreach ($aDates as $indexDate => $date)
		{
			$date=date('Y-m-d',strtotime($date));
			// Change the space price depending date.
			$aPrice[$indexDate]['priceNumber'] = (float)str_replace(',', '', getPrice($space, false, $date, false, false));
			$aPrice[$indexDate]['price'] = getPrice($space, true, $date, false, true);
			$aPrice[$indexDate]['date'] = $date;

			if ($space->FeeType == SPACE_FEE_TYPE_HOURLY)
			{
				$duration = (int)getDurationTimeRange(@$timeDefaultSelected['StartTime'] . '-' . @$timeDefaultSelected['EndTime']);
				$duration = $duration ? $duration : 1;
				$aPrice[$indexDate]['priceNumber'] = $aPrice[$indexDate]['priceNumber'] * $duration;
				$dateTime = \Carbon\Carbon::createFromFormat('Y-m-d', $date);
			}

			$totalPrice += $aPrice[$indexDate]['priceNumber'];
		}

		usort($aPrice, function($a, $b) {
			return $a['priceNumber'] - $b['priceNumber'];
		});
				
		$duration = $space->FeeType == SPACE_FEE_TYPE_HOURLY ? $duration : count($aDates);
		return [
				'success' => $success,
				'message' => $message,
				'aPrice' => $aPrice,
				'bookedIDs' => $bookedIDs,
				'bookedDate' => $aDates,
				'duration' => renderSpaceTypeTerm($space, true, $duration),
				'totalPrice' => priceConvert($totalPrice, true, true),
				'timeDefaultSelected' => $timeDefaultSelected,
				'aAvailableTimeFromList' => $aAvailableTimeFromList,
				'aAvailableTimeToList' => $aAvailableTimeToList,

				];
		
	}
	
	public static function getBookingSlots($rent_data){
		$slots_data = array();
		if (isset($rent_data) && $rent_data['spaceslots_id']) {
			$slots_id = explode(';',$rent_data['spaceslots_id']);
			$slots_id = array_filter(array_unique($slots_id));
			$slots_data = Spaceslot::whereIn('id', $slots_id)->where('status', SLOT_STATUS_AVAILABLE)->orderBy('StartDate','asc')->orderBy('StartTime','asc')->get();
			
			if (count($slots_id) != count($slots_data))
				$slots_data = array();
		}
		return $slots_data;
	}
}