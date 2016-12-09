<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    //
					protected $guarded = ['id'];

	public function space()
	{
        return $this->hasOne('App\User1sharespace','HashID','SpaceId');
	}		
}