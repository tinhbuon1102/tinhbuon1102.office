<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User1sharespace extends Model
{
	//
	protected $guarded = ['id'];
	public function spaceImage()
	{
		return $this->hasMany('App\Spaceimage',  'ShareSpaceID');
	}

	public function spaceAvailable()
	{
		if ( (!\Auth::guard('user1')->check() && !\Auth::guard('user2')->check()) && $this->LoggedOnly)
		{
			// Make sql failed so space not exist
			return $this->hasMany('App\Spaceslot',  'SpaceID')->where('id', -1);
		}
		
		return $this->hasMany('App\Spaceslot',  'SpaceID');
		
	}
	
	public function bookedSlots()
	{
		return $this->hasMany('App\Bookedspaceslot',  'SpaceID');
	}

	public function shareUser()
	{
		return $this->hasOne('App\User1',  'id','User1ID');
	}

	public function favorites()
	{
		return $this->hasMany('App\Favorite',  'SpaceId','HashID');
	}
	
	public function notification()
	{
		return $this->hasMany('App\Notification', 'TypeID')->where('Type', NOTIFICATION_SPACE);
	}
	
	public function reviews(){
		return $this->hasMany('App\Userreview', 'SpaceID')->where('ReviewedBy', 'User2');
	}
	
	public function tags()
	{
		return $this->hasMany('App\Spacetag','SpaceID');
	}
	
	public function getPrefectures(){
		return $this->select('Prefecture')
		->whereStatus(1)
// 		->where('IsPublished','Yes')
		->groupBy('Prefecture')
		->orderBy('Prefecture', 'ASC')
		->get();
	}

	public function getDistricts(){
		return $this->select('District')
		->whereStatus(1)
		->groupBy('District')
		->orderBy('District', 'ASC')
		->get();
	}

	public function getDistrictByPrefecture($prefecture){
		return $this->select('District')
		->where('Prefecture', trim($prefecture))
		->where('status','1')
		->groupBy('District')
		->orderBy('District', 'ASC')
		->get();
	}
	
	public function getTownByPrefecture($prefecture){
		return $this->select('Town')
		->where('Prefecture', trim($prefecture))
		->where('status','1')
		->groupBy('Town')
		->orderBy('Town', 'ASC')
		->get();
	}
}
