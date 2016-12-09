<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class BookingRecursion extends Model
{
	protected $guarded = ['id'];
	protected $table = 'rentbooking_recursion';
	protected $primaryKey = 'id';

}