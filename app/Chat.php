<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
	protected $guarded = ['id'];
	public function user1()
		{
        return $this->belongsTo('App\User1','User1ID','HashCode');
		}
	
	 public function user2()
		{
        return $this->belongsTo('App\User2','User2ID','HashCode');
		}
		
	public function chats()
		{
        return $this->hasMany('App\Chatmessage','ChatID')->orderBy('id', 'DESC');
		}
	public function latestChat()
		{
		 return $this->hasMany('App\Chatmessage','ChatID')->orderBy('id', 'DESC')->first();
		}
}
