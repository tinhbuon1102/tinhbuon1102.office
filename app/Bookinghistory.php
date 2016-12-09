<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Bookinghistory extends Model
{
	protected $guarded = ['id'];
	protected $table = 'bookinghistories';
	protected $primaryKey = 'id';

}