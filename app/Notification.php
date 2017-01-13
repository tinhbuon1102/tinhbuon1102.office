<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Config;

class Notification extends Model
{
	protected $guarded = ['id'];

	public function user1Send()
	{
		return $this->belongsTo('App\User1','UserSendID','id');
	}

	public function user1Receive()
	{
		return $this->belongsTo('App\User1','UserReceiveID','id');
	}
	
	public function user2Send()
	{
		return $this->belongsTo('App\User2','UserSendID','id');
	}
	
	public function user2Receive()
	{
		return $this->belongsTo('App\User2','UserReceiveID','id');
	}
	
	public function user1Space(){
		return $this->belongsTo('App\User1sharespace','TypeID', 'id')->with('spaceImage');
	}
	
	public function user1FavSpace(){
		return $this->belongsTo('App\Favorite','TypeID', 'id');
	}
	
	public function booking(){
		return $this->belongsTo('App\Rentbookingsave','TypeID', 'id')->with('bookedSpace')->with('review');
	}
	
	
	public static function isOfferedSpace($user1, $user2){
		$notification = \App\Notification::where('Type', NOTIFICATION_SPACE)
				->where('UserSendType', 1)
				->where('UserSendID', $user1->id)
				->where('UserReceiveID', $user2->id)
				->first();
		
		return $notification;
	}
	
	public static function updateCompleteReviewNotifications($bookingID, $user1ID, $user2ID){
		// Save User 2 notification
		$notification = Notification::where('Type', NOTIFICATION_REVIEW_BOOKING)->where('TypeID', $bookingID)->update(['Status' => 1]);
	} 
	
	public static function createNotification($type, $typeID, $userReceivedID, $userSendID, $userReceiveType, $userSendType){
		// delete old notification if exists
		$deleteNotification = \App\Notification::where('TypeID', $typeID)
			->where('UserReceiveID', $userReceivedID)
			->where('UserReceiveType', $userReceiveType)
			->where('UserSendID', $userSendID)
			->where('UserSendType', $userSendType);
		
		$aBookingNotifications = array(
				NOTIFICATION_BOOKING_PLACED,
				NOTIFICATION_BOOKING_CHANGE_STATUS,
				NOTIFICATION_BOOKING_REFUND_50,
				NOTIFICATION_BOOKING_REFUND_100);
		
		if (in_array($type, $aBookingNotifications)) 
		{
			$deleteNotification = $deleteNotification->whereIn('Type', $aBookingNotifications);
		}
		else {
			$deleteNotification = $deleteNotification->where('Type', $type);
		}
		
// 		$deleteNotification->delete();
			
		// Save notification
		$notification = new \App\Notification();
		$notification->Type = $type;
		$notification->TypeID = $typeID;
		$notification->UserReceiveID = $userReceivedID;
		$notification->UserReceiveType = $userReceiveType;
		$notification->UserSendID = $userSendID;
		$notification->UserSendType = $userSendType;
		$notification->Status = 0;
		$notification->Time = date('Y-m-d H:i:s');
		$notification->save();
	}
}
