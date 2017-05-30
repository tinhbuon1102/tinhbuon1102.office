<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Paypal;
use App\Http\Requests;
use Session;
use App\Rentbookingsave;
use App\Spaceslot;
use App\Http\Controllers\Controller;
use App\User1;
use App\User2;
use App\User2identitie;
use App\Spaceimage;
use App\User1paymentinfo;
use App\Userreview;
use View;
use Response;
use Redirect;
use Auth;
use App\Models\Paypalbilling;
use App\Library\Paypal\PayPalCore;
use App\User1sharespace;
use Config,DB;
use Mail;
use Carbon\Carbon;


class PaypalController extends Controller {
	private $paypal = null;
	private $merchantEmail = '';
	private $userBillingId = '';
	public $sanbox = true;
	private $txn_id = '';
	private $recur_id = '';
	private $custom = '';
	private $type = '';
	private $txn_type = '';
	private $duration = '';
	private $local = '';

	public function __construct() {
		$this->paypal = new Paypal;
		$this->merchantEmail = PAYPAL_MERCHANT_EMAIL;
	}
	public function PaypalPayment(Request $request) {}
	function chargeOneTimeCustomer($data = array(), Request $request) {}
	function chargeRecurringCustomer($data = array()) {}

	public function refrencepaypal($id) {
		$user = User2::where('HashCode', $id)->firstOrFail();
		$space = User2requirespace::firstOrNew(array('User2ID' => $user->id));
		$isPublicUser = true;
		$budgets = \App\Budget :: where('Type', '!=', 'search')->get();
		$timeslots = \App\Timeslot :: get();
		$userPortfolios = User2portfolio::where('User2Id', '=', $user->id)->get();
		$reviews = Userreview::avarageUser2Reviews($user->id);
		$allReviews = Userreview::getUser2Reviews($user->id);
		$return["status"] = "error";
		$return["BILLINGAGREEMENTID"] = "";
		return view('user2.dashboard.profile-paypal', compact('user', 'space', 'budgets', 'timeslots', 'isPublicUser', 'userPortfolios', 'reviews', 'allReviews', 'return'));
	}

	/***
	 ** processing requests for
	** recurring_payment , subscr_signup ,subscr_failed ,
	**	merch_pmt , subscr_payment , recurring_payment_profile_created ,mp_signup
	**/

	public function PaypalIpn( Request $request  ) {
		$paypal = new paypal;
		$veriy = $paypal->infotuts_ipn( true ); // veryfy transaction details
		$txn_id = $this->txn_id = (isset($_POST["txn_id"]) && $_POST["txn_id"] !== '') ? $_POST["txn_id"] : false;
		$payment_status = (isset($_POST["payment_status"]) && $_POST["payment_status"] !== '') ? $_POST["payment_status"] : "Failed";
		$custom = $this->custom = (isset($_POST["custom"]) && $_POST["custom"] !== '') ? $_POST["custom"] : "nothingrecieved";
		$txn_type = $this->txn_type = (isset($_POST["txn_type"]) && $_POST["txn_type"] !== '') ? $_POST["txn_type"] : "default";
		$verify_message = "yes";
		$post = $_POST; //$request;
		$data = $paypal->trackechEachIpnRequest( $post );

		//This Instant Payment Notification is for a subscription sign-up.
		if ($txn_type == "subscr_signup") {
			$this->recur_id = $paypal->issetCheck($post, 'subscr_id');
			$paypal->register_recurring_profile( $post );
			exit;#return true;
		}


		if ( $txn_type == "subscr_cancel" ) {
			$this->recur_id = $paypal->issetCheck($post, 'subscr_id');
			$profileId = $paypal->issetCheck($post, 'subscr_id');
			$paypal->cancel_recurring_profile($this->recur_id , $profileId);
			exit;#return true;
		}

		if ($txn_type == "recurring_payment_profile_created"){
			$_POST['txn_id'] = $txn_id = $this->txn_id= $paypal->issetCheck( $post, 'initial_payment_txn_id');
			$payment_status = $paypal->issetCheck( $post, 'initial_payment_status');

			$paypal->register_recurring_profile( $post );
			//$paypal->recurring_payment_profile_created( $post );
		}

		if ($txn_type == "subscr_failed") {
			$this->recur_id = $paypal->issetCheck($post, 'subscr_id');
			$paypal->cancel_recurring_profile( $this->recur_id );
			exit;# return true;
		}

		if ($txn_type == "subscr_payment") {
			$this->recur_id = $paypal->issetCheck($post, 'subscr_id');
		}

		/*****
		 *  insert each entry into transaction table
		/*****/
		if ( $veriy == false) {
			// send mail for failed payment
			$verify_message = "no";
			$_POST["verify_status"] = $veriy;
			exit;#return true;
		}
		if (!$txn_id) {
			exit;#return false;
		}
		$_POST["verify-message-data"] = $verify_message;
		if ($payment_status == "Failed") {
			$this->txn_id = $_POST["txn_id"];
		}
		if ($payment_status == "Refunded") {
			$this->txn_id = $_POST["txn_id"];
		}
		if ($payment_status == "Pending") {
			$this->txn_id = $_POST["txn_id"];
		}
		if ($payment_status == "Completed") {
			$this->txn_id = $_POST["txn_id"];
		}
		exit;#return true;
	}


	public function PaypalCancel(Request $request) {

		$req = 'cmd=_notify-validate';
		// Read the post from PayPal
		foreach ($_POST as $key => $value) {
			$value = urlencode(stripslashes($value));
			$req .= "&$key=$value";
		}

		foreach ($_GET as $key => $value) {
			$value = urlencode(stripslashes($value));
			$req .= "&$key=$value";
		}

		return view('public.paypal.user2-cancel');
	}

	public function PaypalSuccess(Request $request) {
		return view('public.paypal.user2-success');
	}

	public function paypalVerifyStep1(Request $request) {

		$paypalModel = new paypal;
		$PayPal = $paypalModel->getRefrecePaypalClient();


		if ($request->input('returnUrl') != "") {
			$returnUrl = $request->input('returnUrl');
		} else {
			$returnUrl = action('PaypalController@paypalVerifyStep2');
		}

		if ($request->input('cancelUrl') != "") {
			$cancelUrl = $request->input('cancelUrl');
		} else {
			$cancelUrl = action('User2Controller@editBasicInfo');
		}


		$SECFields = array(
				'token' => '',
				'maxamt' => '10000.00',
				'returnurl' => $returnUrl,
				'cancelurl' => action('User2Controller@editBasicInfo'),
				'callback' => '',
				'callbacktimeout' => '', // An override for you to request more or less time to be able to process the callback request and response.  Acceptable range for override is 1-6 seconds.  If you specify greater than 6 PayPal will use default value of 3 seconds.
				'callbackversion' => '',
				'reqconfirmshipping' => '0', // The value 1 indicates that you require that the customer's shipping address is Confirmed with PayPal.  This overrides anything in the account profile.  Possible values are 1 or 0.
				'noshipping' => '1',
				'allownote' => '1', // The value 1 indicates that the customer may enter a note to the merchant on the PayPal page during checkout.  The note is returned in the GetExpresscheckoutDetails response and the DoExpressCheckoutPayment response.  Must be 1 or 0.
				'addroverride' => '', // The value 1 indicates that the PayPal pages should display the shipping address set by you in the SetExpressCheckout request, not the shipping address on file with PayPal.  This does not allow the customer to edit the address here.  Must be 1 or 0.
				'localecode' => '',
				'pagestyle' => '',
				'hdrimg' => '',
				'hdrbordercolor' => '',
				'hdrbackcolor' => '',
				'payflowcolor' => '',
				'skipdetails' => '',
				'email' => '',
				'solutiontype' => 'Sole',
				'landingpage' => 'Billing',
				'channeltype' => '',
				'giropaysuccessurl' => '', // The URL on the merchant site to redirect to after a successful giropay payment.  Only use this field if you are using giropay or bank transfer payment methods in Germany.
				'giropaycancelurl' => '', // The URL on the merchant site to redirect to after a canceled giropay payment.  Only use this field if you are using giropay or bank transfer methods in Germany.
				'banktxnpendingurl' => '', // The URL on the merchant site to transfer to after a bank transfter payment.  Use this field only if you are using giropay or bank transfer methods in Germany.
				'brandname' => 'hOur Office | アワーオフィス', // A label that overrides the business name in the PayPal account on the PayPal hosted checkout pages.  127 char max.
				'customerservicenumber' => '555-555-5555', // Merchant Customer Service number displayed on the PayPal Review page. 16 char max.
				'giftmessageenable' => '1', // Enable gift message widget on the PayPal Review page. Allowable values are 0 and 1
				'giftreceiptenable' => '1', // Enable gift receipt widget on the PayPal Review page. Allowable values are 0 and 1
				'giftwrapenable' => '1', // Enable gift wrap widget on the PayPal Review page.  Allowable values are 0 and 1.
				'giftwrapname' => 'Box with Ribbon', // Label for the gift wrap option such as "Box with ribbon".  25 char max.
				'giftwrapamount' => '2.50', // Amount charged for gift-wrap service.
				'buyeremailoptionenable' => '1', // Enable buyer email opt-in on the PayPal Review page. Allowable values are 0 and 1
				'surveyquestion' => '', // Text for the survey question on the PayPal Review page. If the survey question is present, at least 2 survey answer options need to be present.  50 char max.
				'surveyenable' => '1', // Enable survey functionality. Allowable values are 0 and 1
				'buyerid' => '', // The unique identifier provided by eBay for this buyer. The value may or may not be the same as the username. In the case of eBay, it is different. 255 char max.
				'buyerusername' => '', // The user name of the user at the marketplaces site.
				'buyerregistrationdate' => '2012-07-14T00:00:00Z', // Date when the user registered with the marketplace.
				'allowpushfunding' => ''// Whether the merchant can accept push funding.  0 = Merchant can accept push funding : 1 = Merchant cannot accept push funding.
		);

		$Payments = array();

		$SurveyChoices = array('Yes', 'No');

		$BillingAgreements = array();
		$Item = array(
				'l_billingtype' => 'RecurringPayments', // Required.  Type of billing agreement.  For recurring payments it must be RecurringPayments.  You can specify up to ten billing agreements.  For reference transactions, this field must be either:  MerchantInitiatedBilling, or MerchantInitiatedBillingSingleSource
				'l_billingagreementdescription' => 'Billing Agreement', // Required for recurring payments.  Description of goods or services associated with the billing agreement.
				'l_paymenttype' => 'Any', // Specifies the type of PayPal payment you require for the billing agreement.  Any or IntantOnly
				'l_billingagreementcustom' => ''     // Custom annotation field for your own use.  256 char max.
		);

		array_push($BillingAgreements, $Item);

		$Payment = array('amt' => '0.00');
		$Payment['order_items'] = array(); //$PaymentOrderItems;

		array_push($Payments, $Payment);

		$PayPalRequest = array(
				'SECFields' => $SECFields,
				'SurveyChoices' => $SurveyChoices,
				'BillingAgreements' => $BillingAgreements,
				'Payments' => $Payments
		);

		$SetExpressCheckoutResult = $PayPal->SetExpressCheckout($PayPalRequest);

		$return = array();

		if (isset($SetExpressCheckoutResult['ACK']) && $SetExpressCheckoutResult['ACK'] == "Failure") {
			$return["status"] = "error";
			$return["message"] = $SetExpressCheckoutResult['L_LONGMESSAGE0'];
			//$return["return"] = $SetExpressCheckoutResult;
		} else if (isset($SetExpressCheckoutResult['ACK']) && $SetExpressCheckoutResult['ACK'] == "Success") {//
			$return["status"] = "success";
			$return["url"] = $SetExpressCheckoutResult['REDIRECTURL'];
			$return["message"] = $SetExpressCheckoutResult['TOKEN'];
		} else {
			$return["status"] = "error";
			$return["message"] = "不明なエラーが起こりました。";
		}
		echo json_encode($return);
		exit;
	}

	/**
	 * *
	 * * [BILLINGAGREEMENTID] => B-7BX01375HP597974Y
	 * * [TIMESTAMP] => 2016-10-06T07:47:48Z
	 * * [CORRELATIONID] => c110d5b22cbba[ACK] => Success
	 * */
	public function paypalVerifyStep2($id = null, $redirect = true) {

		$paypalModel = new paypal;
		$PayPal = $paypalModel->getRefrecePaypalClient();
		$PaypalBilling = new PaypalBilling();

		if ($id == null) {
			$user = User2::find(Auth::guard('user2')->user()->id);
			$id = Auth::guard('user2')->user()->id;
			$userIde = User2identitie::where('User2ID', Auth::guard('user2')->user()->id)->where('SentToAdmin', 'Yes')->get();
		}
		if (isset($_GET["token"]) && $_GET["token"] != "") {
			$token = $_GET["token"];
			$PayPalResult = $PayPal->GetExpressCheckoutDetails($token);
			
// 			$PayPalResult = $PayPal->CreateBillingAgreement($token);
			$ACK = $PayPalResult["ACK"];
			$return = array("status" => "", "message" => "");
			if ($ACK == "Success") {
// 				$agreementDetail = $PayPal->GetBillingAgreementCustomerDetails($token);
// 				$responseStatus = $agreementDetail["ACK"];

// 				if ($responseStatus == "Success") {
// 					$PaypalBilling->emailId = $agreementDetail["EMAIL"];
// 				} else {
// 					Session::flash('error', 'common.Unable to get details of authenticated token , paypal server error.');
// 					return redirect()->action('User2Controller@editBasicInfo');
// 				}
// 				$return["BILLINGAGREEMENTID"] = $PayPalResult["BILLINGAGREEMENTID"];
// 				$return["TIMESTAMP"] = $PayPalResult["TIMESTAMP"];
// 				$return["CORRELATIONID"] = $PayPalResult["CORRELATIONID"];
// 				$return["status"] = "Success";

				$tokenBilling = Paypalbilling::where('token', $token)->first();
				
				if (!$tokenBilling)
				{
					$PaypalBilling->emailId = $PayPalResult["EMAIL"];
					$PaypalBilling->token = $token;
					$PaypalBilling->billingId = $PayPalResult["TOKEN"];
					$PaypalBilling->userId = $id;
					$PaypalBilling->save();
				}

				if (isset($_GET["return"])) {
					$return = urldecode($_GET["return"]);
					if ($redirect) {
						return redirect($return);
					} else {
						return true;
					}
				}
				if ($redirect) {
					return redirect()->action('User2Controller@editBasicInfo');
				} else {
					return true;
				}
			} else {
				Session::flash('error', 'Paypalアカウントが認証できませんでした。しばらくたってから再度お試しください。');
				return redirect()->action('User2Controller@editBasicInfo');
			}
		} else {
			Session::flash('error', '無効なトークンです。');
			return redirect()->action('User2Controller@editBasicInfo');
		}
	}

	public function paypalVerifyStep2Cancel($cancelUrl = null) {
		if (isset($cancelUrl) && $cancelUrl != null) {
			$cancelUrl = urldecode($_GET["cancelUrl"]);
			return redirect($cancelUrl);
		}
		//return redirect()->action('PaypalController@PaypalCancel');
		return redirect('/ShareUser/Dashboard/PaypalCancel');//->action('PaypalController@PaypalCancel');
	}

	public function paypalProcessRefrenceAmount( $userBillingId = null, $amount = 0, $currency_code = "USD", $notify_url = null  , $postData) {
	}

	public function paypalUnauthorize($userId = null) {

		$billingId = Paypalbilling::where('userId', '=', $userId)->first();
		if (!$billingId) {
			echo json_encode(array("status" => "error", "msg" => "アカウントIDが不明です"));
			exit;
		}
		$billingId->delete();
		echo json_encode(array("status" => "success", "msg" => "Paypalアカウントは削除されました"));
		exit;
	}

	public function signupValidateCancel() {
		return redirect('/RentUser/ValidatePayment');
	}

	public function signupValidateSuccess() {

		if (Session::has("RentUserID") && !empty(Session::get("RentUserID"))) {
			$userId = Session::get("RentUserID");
			$user = User2::find($userId);
			$pb = new Paypalbilling();
			$paypalStatus = $pb->getUserBillingStatus($userId);
			$this->paypalVerifyStep2($userId, false);
			header('Location: '.url('/RentUser/ValidatePayment'));
			exit;

		}
		return redirect("/");
	}
	public function paypal_process_before_payment( Request $request ) {
	}
	public function paypal_process_after_payment(Request $request, $return = true, $post_status = 1 , $custom_return = false ){
	}
	public function acceptPaymentRequest(Request $request) {
	}
	public function rejectRequest(Request $request) {
	}
	public function refundRequest( Request $request ) {
	}
	public function cancelExpiredProfile(){
		$paypal = new PayPal;
		$return = false;
		$all_booking = Rentbookingsave::BySpacetype(4)
		->where('Duration', '>', 5)
		->where('payment_method', '=', "paypal")
		->where('recur_id', '!=', "")
		->get();
		if (count($all_booking) > 0){
			foreach ($all_booking as $book) {
				$PROFILEID = $book['recur_id'];
			}
		}
		exit;
	}

}