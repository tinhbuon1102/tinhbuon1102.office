<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Config;
use App\Notification;

class Userreview extends Model
{
	//
	protected $guarded = ['id'];

	public function space(){
		return $this->hasOne('App\User1sharespace','id', 'SpaceID');
	}
	
	public function booking(){
		return $this->hasOne('App\Rentbookingsave','id', 'BookingID');
	}
	
	public function user2(){
		return $this->hasOne('App\User2','id', 'User2ID');
	}
	
	public function user1(){
		return $this->hasOne('App\User1','id', 'User1ID');
	}
	
	public  static function isAllowUser2WriteReviewToUser1($bookingID, $user1ID, $user2ID){
		$isAllow = self::where('User1ID', $user1ID)
		->where('User2ID', $user2ID)
		->where('BookingID', $bookingID)
		->where('ReviewedBy', 'User2')->first();
		return $isAllow ? false : true;
	}
	
	public  static function isAllowUser1WriteReviewToUser2($bookingID, $user1ID, $user2ID){
		$isAllow = self::where('User1ID', $user1ID)
		->where('User2ID', $user2ID)
		->where('BookingID', $bookingID)
		->where('ReviewedBy', 'User1')->first();
		return $isAllow ? false : true;
	}
	
	public static function avarageSpaceReviews($spaceID){
		$result = self::select(DB::raw('COUNT(*) as count, round(round(avg(AverageRating) * 2, 0)/2, 1) as average'))
		->where('ReviewedBy', 'User2')
		->where('Status', '1')
		->where('SpaceID', $spaceID)->first();
		
		return $result;
	}
	
	public static function avarageUser2Reviews($user2ID){
		$result = self::select(DB::raw('COUNT(*) as count, round(round(avg(AverageRating) * 2, 0)/2, 1) as average
		, round(round(avg(Cleaniness) * 40, 0)/2, 0) as CleaninessAvg
		, round(round(avg(Kindness) * 40, 0)/2, 0) as KindnessAvg
		, round(round(avg(`Repeat`) * 40, 0)/2, 0) as RepeatAvg
		, round(round(avg(Polite) * 40, 0)/2, 0) as PoliteAvg'))
		->where('ReviewedBy', 'User1')
		->where('Status', '1')
		->where('User2ID', $user2ID)->first();

		return $result;
	}
	
	public static function avarageUser1Reviews($user2ID){
		$result = self::select(DB::raw('COUNT(*) as count, round(round(avg(AverageRating) * 2, 0)/2, 1) as average
		, round(round(avg(Cleaniness) * 40, 0)/2, 0) as CleaninessAvg
		, round(round(avg(Kindness) * 40, 0)/2, 0) as KindnessAvg
		, round(round(avg(`Repeat`) * 40, 0)/2, 0) as RepeatAvg
		, round(round(avg(Polite) * 40, 0)/2, 0) as PoliteAvg'))
			->where('ReviewedBy', 'User2')
			->where('Status', '1')
			->where('User1ID', $user2ID)->first();
	
		return $result;
	}
	
	public static function getSpaceReviews($spaceID, $limit=10, $offset=0){
		$results = self::where('ReviewedBy', 'User2')
		->where('Status', '1')
		->where('SpaceID', $spaceID)->orderBy('created_at', 'DESC')->get();
	
		return $results;
	}
	
	public static function getUser2Reviews($user2ID, $limit=10, $offset=0){
		$results = self::where('ReviewedBy', 'User1')
		->where('Status', '1')
		->where('user2ID', $user2ID)->orderBy('created_at', 'DESC')->get();
	
		return $results;
	}
	
	public static function getUser1Reviews($user1ID){
		$results = self::where('ReviewedBy', 'User2')
		->where('Status', '1')
		->where('user1ID', $user1ID)->orderBy('created_at', 'DESC')->get();
	
		return $results;
	}
	
	public static function updateStatusBookingReview($bookingID, $spaceID, $user1ID, $user2ID){
		$reviewBookings = self::where('BookingID', $bookingID)
				->where('User1ID', $user1ID)
				->where('User2ID', $user2ID)
				->where('SpaceID', $spaceID)->groupBy('ReviewedBy')->get();
		
		$status = count($reviewBookings) <= 1 ? REVIEW_STATUS_AWAITING : REVIEW_STATUS_COMPLETE;
		
		if ($status == REVIEW_STATUS_COMPLETE)
		{
			$success = self::where('BookingID', $bookingID)
				->where('User1ID', $user1ID)
				->where('User2ID', $user2ID)
				->where('SpaceID', $spaceID)
				->update(['Status' => $status]);
			
			Notification::updateCompleteReviewNotifications($bookingID, $user1ID, $user2ID);
		}
		return $status;
	}
}
