<?php
namespace App\Models;

use Mail;
use Illuminate\Database\Eloquent\Model;
use Auth;
use App\Rentbookingsave;
use App\Spaceslot;
use Carbon\Carbon;
use DB;


class Paypalbilling extends Model {

	protected $table = 'js_paypal_billings';
	protected $primaryKey = 'id';
	protected $history = array();

	public function getUserBillingStatus( $userID = null ) {

		if ($userID == null) {
			$userID = Auth::guard('user2')->user()->id;
		}

		$return = $this->where('userId', $userID)->first();


		if ($return != null) {
			$billingId = $return->billingId;
			$emailId = $return->emailId;
				
				
			$email_explode = explode( "@" , $return->emailId);
				
			$cut = 3;//count($email_explode[0]) - 2;
			$userName = substr($email_explode[0] , 0 , $cut);
				
			$Domain = $email_explode[1];
				
				
			$encrypted = $userName."****@".$Domain;
				
			$updated_at = $return->updated_at;
			$success = array( "status" => "success", "billingId" => $billingId, "updated_at" => $updated_at , 'emailId' => $emailId , "E_emailId"=>$encrypted );
			return $success;
		}

		return false;
	}

	/***
	 ** @params for diff format diffInSeconds,diffInMinutes,diffInDays,diffInWeeks,diffInMonths
	**
	**/
	public function diffrence_date( $start , $endDate , $type = "diffInMinutes"){
			
		#var_dump();
		#exit;
			
		if($type == "diffInSeconds"){
			$diff = $start->diffInSeconds( $endDate  );
		}
		else if($type == "diffInMinutes"){
			$diff = $start->diffInMinutes( $endDate  );
		}
		else if($type == "diffInHours"){
			$diff = $start->diffInHours( $endDate  );
		}
		else if($type == "diffInWeeks"){
			$diff = $start->diffInWeeks( $endDate  );
		}
		else if($type == "diffInMonths"){
			$diff = $start->diffInMonths( $endDate  );
		}
		else if($type == "diffInDays"){
			$diff = $start->diffInDays( $endDate  );
		}
		else {
			$diff = $start->diffInSeconds( $endDate  );
		}
		return $diff;
	}


	public function transactionStatusTochar($statusId){
		switch($statusId):
		case BOOKING_STATUS_PENDING:
			return "Pending";
		case BOOKING_STATUS_RESERVED:
			return "Reserved";
		case BOOKING_STATUS_REFUNDED:
			return "Refunded";
		case BOOKING_STATUS_CALCELLED:
			return "Canceled";
		case BOOKING_STATUS_DRAFT:
			return "Draft";
		default :
			return "Completed";
			endswitch;
	}
  }

?>