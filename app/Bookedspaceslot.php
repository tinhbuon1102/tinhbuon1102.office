<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Bookedspaceslot extends Model
{
	//
	protected $guarded = ['id'];

	public static function isthisSpaceHasSlot($spaceID)
	{
		$slot = DB::table('bookedspaceslot')
		->select('id')
		->where('SpaceID', '=', trim($spaceID))
		->first();
		return $slot ? true : false;
	}
	
public function User1sharespace()
    {                       
        return $this->hasOne('App\Bookedspace', 'SpaceID', 'SpaceID');
    }
	
	public static function getSpaceSlotBySpaceIDAndType($spaceID, $type, $status = false){
		$carbon = new \Carbon\Carbon;
		$slots = DB::table('bookedspaceslot')
		->select(DB::raw('*'))
		->where('SpaceID', '=', trim($spaceID))
		->where('StartDate', '>', '0')
		->where('EndDate', '>', '0')
		->where('Type', '=', trim($type));
		
		if ($status !== false)
		{			
			$slots->where('status', '=', $status);
		}
		
		switch($type)
		{
			case 'HourSpace';
			case 'DailySpace';
				$slots->whereColumn('StartDate', '=', 'EndDate');
				$slots->whereColumn('StartTime', '<', 'EndTime');
				$slots->where('StartDate', '>', $carbon->yesterday()->format('Y-m-d'));
				break;
			case 'WeeklySpace';
				$slots->whereColumn('StartDate', '<', 'EndDate');
				$slots->where('StartDate', '>', $carbon->subWeek(2)->format('Y-m-d'));
				break;
			case 'MonthlySpace';
				$slots->whereColumn('StartDate', '<', 'EndDate');
				$slots->where('StartDate', '>', $carbon->subMonths(2)->format('Y-m-d'));
				break;
			
		}
		return $slots->get();
	}
}