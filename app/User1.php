<?php
namespace App;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Config;
use DB;

// class User1 extends Model
class User1 extends Authenticatable
{
	// protected $fillable = ['NameOfCompany' , 'NameOfPresident',
	// 'NameOfPerson', 'Address', 'Tel', 'Email', 'UserName', 'password',
	// 'EstablishDate',
	// 'BusinessSummary','FirstName','LastName','WebUrl','PostalCode','Newsletter','HashCode',
	// 'EmailVerificationText'];
	protected $guarded = [
			'id'
	];
	protected $hidden = [
			'password'
	];
	public function getEmailForPasswordReset ()
	{
		return $this->Email;
	}
	public function spaces ()
	{
		return $this->hasMany('App\User1sharespace', 'User1ID')->orderBy('id', 'DESC');
	}
	public function availableSpaces ()
	{
		return $this->hasMany('App\User1sharespace', 'User1ID')->where('status', '1');
	}
	public function reviews ()
	{
		return $this->hasMany('App\Userreview', 'User1ID')
			->where('Status', 1)
			->where('ReviewedBy', 'User2');
	}
	public function bank ()
	{
		return $this->hasOne('App\User1paymentinfo', 'User1ID', 'id');
	}
	public function host ()
	{
		return $this->hasMany('App\User1hostmember', 'User1ID');
	}
	public function certificates ()
	{
		return $this->hasMany('App\User1certificate', 'User1ID');
	}
	public function scopeIsApproved ( $query )
	{
		return $query->where('IsAdminApproved', 'Yes');
	}
	public function scopeIsEmailVerified ( $query )
	{
		return $query->where('IsEmailVerified', 'Yes');
	}
	public function receiveBookingNotifications ()
	{
		return $this->hasMany('App\Notification', 'UserReceiveID')
			->with('booking')
			->with('user2Send')
			->where('UserSendType', 2)
			->where('UserReceiveType', 1)
			->orderBy('Time', 'DESC');
	}
	public function applicationForm ()
	{
		return $this->hasOne('App\ApplicationForm', 'Email', 'Email');
	}
	
	/*
	 * public function spaceImage()
	 * {
	 * return $this->hasManyThrough('App\Spaceimage', 'App\User1sharespace',
	 * 'User1ID', 'ShareSpaceID');
	 * }
	 */
	public function getAllCompletedInvoices ( $user1ID )
	{
		return DB::table('rentbookingsaves')->leftJoin('user2s', 'user2s.id', '=', 'rentbookingsaves.user_id')
			->leftJoin('user1sharespaces', 'user1sharespaces.id', '=', 'rentbookingsaves.user1sharespaces_id')
			->leftJoin('user1s', 'user1s.id', '=', 'user1sharespaces.User1ID')
			->select('rentbookingsaves.id', 'rentbookingsaves.InvoiceID', 'rentbookingsaves.created_at', 'rentbookingsaves.updated_at', 'rentbookingsaves.transaction_id', 'rentbookingsaves.status', 'rentbookingsaves.price', 'rentbookingsaves.SpaceType', 'rentbookingsaves.Duration', 'rentbookingsaves.DurationText', 'rentbookingsaves.UsedDate', 'rentbookingsaves.amount', 'user1s.isUser1', 'user2s.NameOfCompany', 'user2s.HashCode', 'user2s.LastName', 'user2s.FirstName', 'user1sharespaces.Title')
			->orderBy('rentbookingsaves.updated_at', 'DESC')
			->where('user1s.id', $user1ID)
			->whereIn('rentbookingsaves.status', array(
				BOOKING_STATUS_REFUNDED,
				BOOKING_STATUS_RESERVED,
				BOOKING_STATUS_COMPLETED
		))
			->where('rentbookingsaves.spaceslots_id', '<>', '')
			->whereNotNull('rentbookingsaves.spaceslots_id')
			->where('rentbookingsaves.transaction_id', '<>', '')
			->whereNotNull('rentbookingsaves.transaction_id')
			->where('rentbookingsaves.InvoiceID', '<>', '')
			->whereNotNull('rentbookingsaves.InvoiceID')
			->get();
	}
	public static function isAdminApproved ( $user )
	{
		return $user->IsAdminApproved == 'Yes';
	}
	public static function getListSpaceUrl ()
	{
		return url('ShareUser/Dashboard/MySpace/List1');
	}
	public static function getCalendarSpaceUrl ()
	{
		return url('ShareUser/Dashboard/MySpace/Calendar');
	}
	public static function isProfileFullFill ( $user )
	{
		$aRequireFields = array(
				'NameOfCompany',
				'PostalCode',
				'Prefecture',
				'District',
				'Address1',
				'Tel',
				'BussinessCategory',
				'LastName',
				'FirstName',
				'LastName',
				'LastNameKana',
				'FirstNameKana',
				'Relation' => array(
						'bank' => array(
								'AccountName',
								'AccountType',
								'BankName',
								'BranchLocationName',
								'BranchCode',
								'AccountNumber'
						)
				)
		);
		foreach ( $aRequireFields as $fieldIndex => $requireField )
		{
			if ( $fieldIndex === 'Relation' )
			{
				foreach ( $requireField as $relationName => $relationMapper )
				{
					foreach ( $relationMapper as $relationIndex => $relationField )
					{
						$fieldValue = false;
						
						$relationData = $user->{$relationName};
						// Check relation is many or one
						if ( isset($relationMapper['multiple']) )
						{
							if ( $relationIndex != 'multiple' )
							{
								$fieldValue = isset($relationData[0]) ? (trim($relationData[0]->{$relationField}) ? true : false) : false;
							}
						} else
						{
							$fieldValue = isset($relationData) ? (trim($relationData->$relationField) ? true : false) : false;
						}
						
						if ( ! $fieldValue )
						{
							return false;
						}
					}
				}
			} elseif ( ! $user->{$requireField} )
			{
				return false;
				break;
			}
		}
		return true;
	}
	public static function getCertificatePageUrl ()
	{
		return url('ShareUser/Dashboard/HostSetting/Certificate');
    }
    
}
