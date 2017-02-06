<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Config;

//class User2 extends Model
class User2 extends Authenticatable
{
	//protected $fillable = ['NameOfCompany' , 'NameOfPresident', 'NameOfPerson', 'Address', 'Prefecture', 'City', 'Tel', 'Email', 'UserName', 'password', 'EstablishDate', 'BusinessSummary','FirstName','LastName','FirstNameKana','LastNameKana','PostalCode','Newsletter','HashCode','UserType','BusinessType','IsAdminApproved','EmailVerificationText','BirthYear','BirthMonth','BirthDay','Sex'];
	protected $guarded = ['id'];
	protected $hidden = [
	'password',
	];
	public function getEmailForPasswordReset()
{
    return $this->Email;
}
	public function space()
	{
		return $this->hasOne('App\User2requirespace','User2Id');
	}
	public function portfolio()
	{
		return $this->hasMany('App\User2portfolio','User2Id');
	}
	
	public function reviews(){
		return $this->hasMany('App\Userreview', 'User2ID')->where('Status', 1)->where('ReviewedBy', 'User1');
	}
	
	public function allReviews(){
		return $this->hasMany('App\Userreview', 'User2ID')->where('ReviewedBy', 'User1');
	}
	
	public function receiveNotificationsOffers()
	{
		return $this->hasMany('App\Notification', 'UserReceiveID')->where('Type', NOTIFICATION_SPACE)->where('UserSendType', 1)->where('UserReceiveType', 2)->orderBy('Time', 'DESC');
	}
	
	public function receiveNotificationsWithSpace()
	{
		return $this->hasMany('App\Notification', 'UserReceiveID')->with('user1Space')->where('Type', NOTIFICATION_SPACE)->with('user1Send')->where('UserSendType', 1)->where('UserReceiveType', 2)->orderBy('Time', 'DESC');
	}
	
	public function receiveBookingNotifications()
	{
		return $this->hasMany('App\Notification', 'UserReceiveID')
				->with('booking')
				->with('user1Send')
				->where('UserSendType', 1)->where('UserReceiveType', 2)->orderBy('Time', 'DESC');
	}
	
	public function certificates()
	{
		return $this->hasMany('App\User2identitie','User2ID');
	}
	
	public function billings()
	{
		return $this->hasOne('App\Models\Paypalbilling','userId');
	}
	
 	public function scopeIsApproved($query)
    {
    	return $query->where('IsAdminApproved', 'Yes');
    }
    
    public function scopeIsEmailVerified($query)
    {
    	return $query->where('IsEmailVerified', 'Yes');
    }
	
	function is_valid_card($number) {
		// Strip any non-digits (useful for credit card numbers with spaces and hyphens)
		$number=preg_replace('/\D/', '', $number);
		// Set the string length and parity
		$number_length=strlen($number);
		$parity=$number_length % 2;
		// Loop through each digit and do the maths
		$total=0;
		for ($i=0; $i<$number_length; $i++) {
		$digit=$number[$i];
		// Multiply alternate digits by two
		if ($i % 2 == $parity) {
		$digit*=2;
		// If the sum is two digits, add them together (in effect)
		if ($digit > 9) {
		$digit-=9;
		}
		}
		// Total up the digits
		$total+=$digit;
		}
		// If the total mod 10 equals 0, the number is valid
		return ($total % 10 == 0) ? TRUE : FALSE;
	}
	
	public function cc_encrypt($str)
	{
		# Add PKCS7 padding.
		$EncKey = "25c6c7dd"; //For security
		$block = mcrypt_get_block_size('des', 'ecb');
		if (($pad = $block - (strlen($str) % $block)) < $block) {
		$str .= str_repeat(chr($pad), $pad);
		}
		return base64_encode(mcrypt_encrypt(MCRYPT_DES, $EncKey, $str, MCRYPT_MODE_ECB));
	}
	
	public function getModifiedCardNumberAttribute($value)
    {
		$str=$this->card_number;
		$EncKey = "25c6c7dd";
		$str = mcrypt_decrypt(MCRYPT_DES, $EncKey, base64_decode($str), MCRYPT_MODE_ECB);
		# Strip padding out.
		$block = mcrypt_get_block_size('des', 'ecb');
		$pad = ord($str[($len = strlen($str)) - 1]);
		if ($pad && $pad < $block && preg_match(
		'/' . chr($pad) . '{' . $pad . '}$/', $str
		)
		) {
		$card=substr($str, 0, strlen($str) - $pad);
		return '***********'.substr($card,-4);
		}
		return '***********'.substr($str,-4);
    }	
	
	public function getModifiededitCardNumberAttribute($value)
    {
		$str=$this->card_number;
		$EncKey = "25c6c7dd";
		$str = mcrypt_decrypt(MCRYPT_DES, $EncKey, base64_decode($str), MCRYPT_MODE_ECB);
		# Strip padding out.
		$block = mcrypt_get_block_size('des', 'ecb');
		$pad = ord($str[($len = strlen($str)) - 1]);
		if ($pad && $pad < $block && preg_match(
		'/' . chr($pad) . '{' . $pad . '}$/', $str
		)
		) {
		$card=substr($str, 0, strlen($str) - $pad);
		return $card;
		}
		return $str;
    }	
	
    public static function getSpaceType(){
    	$aTypes = array(
    			'Desk' => array(SPACE_FIELD_CORE_WORKING, SPACE_FIELD_OPEN_DESK, SPACE_FIELD_SHARE_DESK),
    			'PrivateOffice' => array(SPACE_FIELD_PRIVATE_OFFICE_OLD, SPACE_FIELD_PRIVATE_OFFICE, SPACE_FIELD_TEAM_OFFICE, SPACE_FIELD_OFFICE),
    			'MeetingSpace' => array(SPACE_FIELD_METTING),
    			'SeminarSpace' => array(SPACE_FIELD_SEMINAR_SPACE),
    	);
    	return $aTypes;
    }
    
    public static function getMatchedRentUser($conditions){
    	$users = self::select('*');
    	foreach ($conditions as $field => $aValues)
    	{
    		if (in_array($field, array('BirthYear')))
    		{
    			if (!$aValues) continue;
    			
    			$users = $users->where(function ($query) use ($field, $aValues){
    				$currentYear = date('Y');
    				$toYear = $currentYear - $aValues * 10;
    				$fromYear = $toYear - 9;
    				$query->whereBetween($field, [$fromYear, $toYear]);
    			});
    		}
    		else {
    			$users = $users->where(function ($query) use ($field, $aValues){
    				foreach ($aValues as $value)
    				{
    					if (!$value) continue;
    					
    					$query->orWhere($field, 'LIKE', '%'. trim($value) .'%');
    				}
    			});
    		}
    		
    	}
    	return $users;
    }
    public static function isPaymentSetup($user)
    {
    	$pb = new \App\Models\Paypalbilling();
    	$paypalStatus = $pb->getUserBillingStatus($user->id);
    	
    	if (!$paypalStatus || $paypalStatus['status'] != 'success')
    	{
    		$aRequireFields = array(
    				'card_name',
    				'card_number',
    				'exp_month',
    				'exp_year',
    				'security_code',
    		);
    		foreach ($aRequireFields as $fieldIndex => $requireField)
    		{
    			if (!$user->{$requireField})
    			{
    				return false;
    			}
    		}
    	}
    	return true;
    }
    
    
    public static function isCreditCardSetup($user)
    {
    	$aRequireFields = array(
    		'card_name',
    		'card_number',
    		'exp_month',
    		'exp_year',
    		'security_code',
    	);
    	foreach ($aRequireFields as $fieldIndex => $requireField)
    	{
    		if (!$user->{$requireField})
    		{
    			return false;
    		}
    	}
    	return true;
    }
    
    public static function isPaypalSetup($user)
    {
    	$pb = new \App\Models\Paypalbilling();
    	$paypalStatus = $pb->getUserBillingStatus($user->id);
    	if (!$paypalStatus || $paypalStatus['status'] != 'success')
    		return false;
    	else return true;
    }
    
    public static function isProfileFullFill($user)
    {
    	$aRequireFields = array(
    			'LastName',
    			'FirstName',
    			'LastName',
    			'LastNameKana',
    			'FirstNameKana',
    			'BirthYear',
    			'Sex',
    			'Tel',
    			'PostalCode',
    			'Prefecture',
    			'City',
    			'Address1',
    			'UserType',
    			'BusinessType',
    			'NameOfCompany',
    	);
    	foreach ($aRequireFields as $fieldIndex => $requireField)
    	{
    		if ($requireField == 'NameOfCompany' && $user->UserType != '法人')
    		{
    			continue;
    		}
    		elseif (!$user->{$requireField})
    		{
    			return false;
    			break;
    		}
    	}
    	return true;
    }
    
    public static function getCertificatePageUrl()
    {
    	return url('/RentUser/Dashboard/Identify/Upload');
    }
}
