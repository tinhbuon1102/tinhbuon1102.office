<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chatmessage extends Model
{
    //
		protected $guarded = ['id'];
		
		public function user1()
		{
        return $this->belongsTo('App\User1','User1ID','HashCode');
		}
	
		public function user2()
		{
        return $this->belongsTo('App\User2','User2ID','HashCode');
		}
		
		public function chat()
		{
        return $this->belongsTo('App\Chat','ChatID');
		}
}
