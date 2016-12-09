<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;

//class Useradmin extends Model

class Useradmin extends Authenticatable
{
    //
	protected $fillable = [
        'UserName','Password',
    ];
	protected $hidden = [
        'Password', 
    ];
}
