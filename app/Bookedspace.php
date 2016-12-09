<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bookedspace extends Model
{
	//
	protected $guarded = ['id'];
	public function spaceImage()
	{
		return $this->hasMany('App\Spaceimage',  'ShareSpaceID', 'SpaceID');
	}

	public function abc() {
	    
	}
	public function spaceAvailable()
	{  
		return $this->hasMany('App\Bookedspaceslot',  'SpaceID', 'SpaceID');
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
		return $this->hasMany('App\Notification', 'TypeID', 'SpaceID')->where('Type', NOTIFICATION_SPACE);
	}
	
	public function reviews(){
		return $this->hasMany('App\Userreview', 'SpaceID', 'SpaceID')->where('ReviewedBy', 'User2');
	}
	
	public function getPrefectures(){
		return $this->select('Prefecture')
		->whereStatus(1)
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
		->groupBy('District')
		->orderBy('District', 'ASC')
		->where('Prefecture', trim($prefecture))
		->get();
	}
}