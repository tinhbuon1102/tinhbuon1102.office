<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicationForm extends Model
{
	//
	protected $guarded = ['id'];
	protected $table = 'application_form';
	protected $primaryKey = 'id';
	protected $fillable = [
			'FirstName',
			'LastName',
			'FirstNameKana',
			'LastNameKana',
			'Department',
			'Tel',
			'Email',
			'NameOfCompany',
			'BusinessType'
	];
}