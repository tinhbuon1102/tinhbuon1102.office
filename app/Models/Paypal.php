<?php

namespace App\Models;
use App\Rentbookingsave;
use App\Spaceslot;
use Mail;
use DB;
use App\Library\Paypal\PayPalCore;
use Illuminate\Database\Eloquent\Model;

define('SSL_SAND_URL', 'https://www.sandbox.paypal.com/cgi-bin/webscr');
define('SSL_P_URL', 'https://www.paypal.com/cgi-bin/webscr');

define('PAYPAL_APP_APIVersion', '95.0');
define('CURRENCYCODE', 'JPY');
define('PAYPAL_LOCALE', 'ja_JP');

class Paypal extends Model {

	public $return_success;
	public $cancel_return;
	public $notify_url;
	protected $table = 'js_paypal_transections';
	protected $primaryKey = 'TID';

	public $sandbox = true;
	public $actionUrl = SSL_SAND_URL;
	public $rentBookingId = '';
	public $ipnStatus = '';

	public function __construct(){
			
		$this->return_success = url("/ShareUser/Dashboard/PaypalSuccess");
		$this->cancel_return = url("/ShareUser/Dashboard/PaypalCancel");
		$this->notify_url = url("/ShareUser/Dashboard/PaypalIpn");
			
		if( PAYPAL_SANDBOX ){
			$this->actionUrl = SSL_SAND_URL;
		}else{
			$this->actionUrl = SSL_P_URL;
		}
			
	}
	function infotuts_ipn($im_debut_ipn) {}
	function ipn_response($request){}
	function issetCheck($post,$key){

		if(isset($post[$key])){
			$return=$post[$key];
		}
		else{
			$return='';
		}
		return $return;
	}



	public function trackechEachIpnRequest( $post ){

		$insertArray = array(
					
				"txn_type" => isset($post["txn_type"])?$post["txn_type"]:'',
				"recurring_payment_id" => isset($post["recurring_payment_id"])?$post["recurring_payment_id"]:'',
				"subscr_id" => isset($post["subscr_id"])?$post["subscr_id"]:'',
				"recurring" => isset($post["recurring"])?$post["recurring"]:'',
				"payer_status" => isset($post["payer_status"])?$post["payer_status"]:'',
				"profile_status" => isset($post["profile_status"])?$post["profile_status"]:'',

				"txn_id" => isset($post["txn_id"])?$post["txn_id"]:'',
				"payment_status" => isset($post["payment_status"])?$post["payment_status"]:'',
					
				"initial_payment_status" => isset($post["initial_payment_status"])?$post["initial_payment_status"]:'',
				"initial_payment_amount" => isset($post["initial_payment_amount"])?$post["initial_payment_amount"]:'',
				"initial_payment_txn_id" => isset($post["initial_payment_txn_id"])?$post["initial_payment_txn_id"]:'',
				"amount" => isset($post["amount"])?$post["amount"]:'',

				"amount_per_cycle" => isset($post["amount_per_cycle"])?$post["amount_per_cycle"]:'',
				"next_payment_date" => isset($post["next_payment_date"])?$post["next_payment_date"]:'',
				"payment_cycle" => isset($post["payment_cycle"])?$post["payment_cycle"]:'',

				"mc_amount1" => isset($post["mc_amount1"])?$post["mc_amount1"]:'',
				"period1" => isset($post["period1"])?$post["period1"]:'',
				"period_type" => isset($post["period_type"])?$post["period_type"]:'',
				"outstanding_balance" => isset($post["outstanding_balance"])?$post["outstanding_balance"]:'',


				"first_name" => isset($post["first_name"])?$post["first_name"]:'',
				"last_name" => isset($post["last_name"])?$post["last_name"]:'',
				"residence_country" => isset($post["residence_country"])?$post["residence_country"]:'',
				"product_type" => isset($post["product_type"])?$post["product_type"]:'',
				"custom" => isset($post["custom"])?$post["custom"]:'',

				//"payment_gross" => isset($post["mc_currency"])?$post["payment_gross"]:'',
				"mc_currency" => isset($post["mc_currency"])?$post["mc_currency"]:'',
				"mc_gross" => isset($post["mc_currency"])?$post["mc_gross"]:'',
				"mc_amount3" => isset($post["mc_amount3"])?$post["mc_amount3"]:'',
				"period3" => isset($post["period3"])?$post["period3"]:'',


				"item_name" =>isset($post["item_name"])?$post["item_name"]:'',
				"business" => isset($post["business"])?$post["business"]:'',

				"verify_sign" => isset($post["verify_sign"])?$post["verify_sign"]:'',

				"payer_email" => isset($post["payer_email"])?$post["payer_email"]:'',
				"receiver_email" => isset($post["receiver_email"])?$post["receiver_email"]:'',
				"payer_id" => isset($post["payer_id"])?$post["payer_id"]:'',
				"item_number" => isset($post["item_number"])?$post["item_number"]:'',
				"subscr_date" => isset($post["subscr_date"])?$post["subscr_date"]:'',

				"payment_date" => isset($post["payment_date"])?$post["payment_date"]:'',
				"payment_fee" => isset($post["payment_fee"])?$post["payment_fee"]:'',



				"ipn_track_id" => isset($post["ipn_track_id"])?$post["ipn_track_id"]:'',
				"notify_version" => isset($post["notify_version"])?$post["notify_version"]:'',
				"test_ipn" => isset($post["test_ipn"])?$post["test_ipn"]:'',
				"reattempt" => isset($post["reattempt"])?$post["reattempt"]:'',
				"retry_at" => isset($post["retry_at"])?$post["retry_at"]:'',

				"time_created" => isset($post["time_created"]) ? $post["time_created"]:'',


				"updated_at" => date("Y-m-d h:i:s"),
				"created_at" => date("Y-m-d h:i:s")
		);
			
		$daStatus = $inserEntry = DB::table('js_paypal_transections')->insert( $insertArray  );
			
			
		return $daStatus;

	}
	public function register_recurring_profile( $post ){}
	public function insertEntery( $data = array() ,  $rent_id){
		$rentBookingId = "";
			
		$insertArray = array(
				"CORRELATIONID" => $data["CORRELATIONID"],
				"TRANSACTIONID" => $data["TRANSACTIONID"],
				"TRANSACTIONTYPE" => $data["TRANSACTIONTYPE"],
				"PAYMENTTYPE" => $data["PAYMENTTYPE"],
				"PAYMENTSTATUS" => $data["PAYMENTSTATUS"],
				"PENDINGREASON" => $data["PENDINGREASON"],
				"REASONCODE" => $data["REASONCODE"],
				"rentBookingId" => $rent_id
		);
			
		$daStatus = $inserEntry = $this->insert( $insertArray );
		return $daStatus;
	}


	public function getRefrecePaypalClient(){
		$application_id = PAYPAL_APP_ID;
			
		/**
		 * Third Party User Values
		 * These can be setup here or within each caller directly when setting up the PayPal object.
		 */
		$device_ip_address = $_SERVER['REMOTE_ADDR'];
			
		$PayPalConfig = array(
				'Sandbox' => PAYPAL_SANDBOX,
				'APIUsername' => PAYPAL_APP_UN,
				'APIPassword' => PAYPAL_APP_PW,
				'APISignature' => PAYPAL_APP_SIGNATURE,
				'APIVersion' => PAYPAL_APP_APIVersion,
		);
			
		$PayPal = new PayPalCore($PayPalConfig);
			
		return $PayPal;
	}


	public function initiateRefundRequest( $t_id  , $REFUNDTYPE ="FUll" , $amount = 0 ){}
	function spaceTypeInttoChracter( $intvalue = null){
		if($intvalue == 1){
			$return  = "hourly";
		}
		else if($intvalue == 2){
			$return  = "daily";
		}else if($intvalue == 3){
			$return  = "weekly";
		}else if($intvalue == 4){
			$return  = "monthly";
		}
		return $return;
	}
	public function paypal_Manage_Reccuring_Profile( $PROFILEID = "" , $ACTION = "Cancel" ){}
	public function GetRecurringPaymentsProfileDetails( $PROFILEID = "" ){}
	public function getTransactionDetails($txn_id){}
	public function cancel_recurring_profile( $PROFILEID , $subscr_id = false){}
}
?>