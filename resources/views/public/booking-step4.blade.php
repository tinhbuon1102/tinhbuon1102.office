<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header.php'); ?>
@include('pages.header')
<script class="rs-file" src="<?php echo SITE_URL?>js/assets/royalslider/jquery.easing-1.3.js"></script>
<script src="<?php echo SITE_URL?>js/perfect-scrollbar/js/perfect-scrollbar.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL?>assets/css/main.css">
<!-- <script type="text/javascript" src="<?php echo SITE_URL?>assets/js/jquery.min.js"></script> -->
<script type="text/javascript" src="<?php echo SITE_URL?>assets/js/jquery-ui.min.js"></script>
<script src="<?php echo SITE_URL?>js/datepicker-ja.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL?>assets/css/tab.css">
<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL?>assets/css/folio.css">
<script src="{{ URL::asset('js/responsive-tabs/easyResponsiveTabs.js') }}"></script>
<link href="{{ URL::asset('js/responsive-tabs/easy-responsive-tabs.css') }}" rel='stylesheet' />
<link href="{{ URL::asset('js/calendar/calendar.css') }}" rel='stylesheet' />
<link href="{{ URL::asset('js/calendar/datepicker/css/bootstrap-datepicker.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('js/calendar/datepicker/css/timepicker.css') }}" rel="stylesheet" />
<script src="{{ URL::asset('js/calendar/lib/moment.min.js') }}"></script>
<script src="{{ URL::asset('js/calendar/calendar.js') }}"></script>
<script src="{{ URL::asset('js/calendar/lang-all.js') }}"></script>
<script src="{{ URL::asset('js/calendar/datepicker/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('js/calendar/datepicker/locales/bootstrap-datepicker.ja.min.js') }}"></script>
<script src="{{ URL::asset('js/calendar/datepicker/js/timepicker.min.js') }}"></script>
<script src="{{ URL::asset('js/calendar/datepicker/js/datepair.js') }}"></script>
<script src="{{ URL::asset('js/calendar/validator.js') }}"></script>
<script src="{{ URL::asset('js/calendar/loadingoverlay.js') }}"></script>
<!--/head-->
<body class="booking-process common">
	<div class="viewport">
		<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header_nav_shareuser.php'); ?>
		@if(Auth::check()) @include('pages.header_nav_shareuser') @elseif(Auth::guard('user2')->check()) @include('pages.header_nav_rentuser') @endif
		<?php $user = Auth::guard('user2')->user();?>
		<section id="page">
			<div id="main">
				<header class="page-header">
					<div class="container">
						<div class="row">
							<div class="col-sm-7">
								<h1 itemprop="name">支払い</h1>
							</div>
							<!--/col-sm-7-->
							<div class="col-sm-5 hidden-xs">
								<div itemprop="breadcrumb" class="breadcrumb clearfix">
									<a href="#" title="hOur Office">Home</a>
									<a href="#" title="Booking">予約</a>
									<a href="#" title="Details">予約詳細</a>
									<a href="#" title="Symmary">予約確認</a>
									<span>支払い</span>
								</div>
							</div>
							<!--/col-sm-5-->
						</div>
						<!--/row-->
					</div>
					<!--/container-->
				</header>
				<div id="content" class="pt30 pb30">
					<!--confirm booking-->
					<div id="confirm-book" class="container">
						<div class="row mb30" id="booking-breadcrumb">
							<div class="col-xs-3">
								<a href="#">
									<div class="breadcrumb-item done">
										<i class="fa fa-calendar"></i>
										<span>予約</span>
									</div>
								</a>
							</div>
							<!--/col-xs-3-->
							<div class="col-xs-3">
								<a href="#">
									<div class="breadcrumb-item done">
										<i class="fa fa-info-circle"></i>
										<span>予約詳細</span>
									</div>
								</a>
							</div>
							<!--/col-xs-3-->
							<div class="col-xs-3">
								<a href="#">
									<div class="breadcrumb-item done">
										<i class="fa fa-list"></i>
										<span>予約内容を確認</span>
									</div>
								</a>
							</div>
							<!--/col-xs-3-->
							<div class="col-xs-3">
								<a href="#">
									<div class="breadcrumb-item active">
										<i class="fa fa-credit-card"></i>
										<span>支払い</span>
									</div>
								</a>
							</div>
							<!--/col-xs-3-->
						</div>
						<div class="text-center lead pt20 pb20">
							@if (count($errors) > 0)
							<div class="alert alert-danger">
								<ul>
									@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
									@endforeach
								</ul>
							</div>
							@endif
							<?php $message = Session::get('success'); ?>
							@if( isset($message) )
							<div class="alert alert-success">{!! $message !!}</div>
							@endif
							
							@if( Session::has('error') )
							<div class="alert alert-success">{!! Session::get('error') !!}</div>
							@endif
							
							<form method="post" id="payment-method">
								{{ csrf_field() }}
								<div class="mb10">お支払い方法を選択してください</div>
								<a href='/ShareUser/Dashboard/CreditPayment' id="cards_button" class="btn btn-default" value="cards" style='min-width: 160px; min-height: 104px; padding: 20px;'>
									<i class="fa fa-credit-card"></i>
									<br>
									クレジットカード
								</a>
								<a class="btn btn-default" value="paypal" style='min-width: 160px; min-height: 104px; padding: 20px;' id="paypal-payment-button" data-remodal-target="modal">
									<i class="fa fa-paypal"></i>
									<br>
									ペイパル
									<input type="hidden" name="payment_type" class="btn btn-default" value="paypal" />
								</a>
							</form>
						</div>
						<div class="clearfix"></div>
						<div class="step-btn-group">
							<a class="btn btn-default btn-lg pull-left" href="/ShareUser/Dashboard/BookingSummary">
								<i class="fa fa-angle-left"></i>
								前に戻る
							</a>
						</div>
					</div>
					<!--/container-->
					<!--/confirm booking-->
				</div>
				<!--footer-->
				@include('pages.dashboard_user1_footer')
				<!--/footer-->
			</div>
			<!--/#main-->
		</section>
	</div>
	<!--- popup start --->
	<div class="remodal no-pad" data-remodal-id="modal">
		<div class="pr-bannr">
			<div class="payment_popup_wraper" style="<?php echo $paypalStatus == false ? 'display:none' : '';?>">
			<div class="pr-hedaer">
				<h3 class="pr-head">お支払のご確認</h3>
				<p class="pr-para">
					<span class="pr-bold">支払金額:</span>
					<!---payment:-->
					&yen;
					<?php echo ceil($aFlexiblePrice["totalPrice"]); ?>
				</p>
				<p class="pr-para2">Paypalアカウントにご登録のクレジットカードから引き落とされます。</p>
				<!---It will be withdrawn from the credit card registered to the Paypal account.--->
				@include('public.paypal.paypal-recuring-detail')
				<div class="payment-logos-container ng-scope">
					<div style="width: 100%; float: left;">
						<h6 style="float: left;">認証済みのアカウント:</h6>
					</div>
					<span class="payment-source-option">
						<div class="pp-icon">
							<span class="payment-icon-paypal"></span>
						</div>
						<span style="vertical-align: top">
							<?php echo $paypalStatus["E_emailId"]; ?>
						</span>
						<span class="payment-source-preference is-preferred ng-scope">認証済み</span>
					</span>
				</div>
			</div>
			<div class="pr-foter">
				<div class="pr-buttn">
					<button data-remodal-action="confirm" class="remodal-confirm btn pr-one">支払う</button>
					<button data-remodal-action="cancel" class="remodal-cancel pr-btn">キャンセル</button>
				</div>
			</div>
			</div>
			
			<div class="payment_missing_popup_wraper" style="<?php echo $paypalStatus != false ? 'display:none' : '';?>">
			<div class="pr-hedaer">
				<h3 class="pr-head">Authorise Payment</h3>
				<p class="pr-para">
					<span class="pr-bold">Amount to be paid:</span>
					&yen;
					<?php echo $aFlexiblePrice["totalPrice"]; ?>
				</p>
				<div class="paypal_wraper">
					<div class="payment-logos-container ng-scope">
						<div class="pp-icon">
							<span class="payment-icon-paypal"></span>
						</div>
						<p><?php echo trans('common.missing_payment_setup')?></p>
					</div>
				</div>
				
				<div class="cc_wraper" style="display: none">
					<div class="card-row">
						<span class="visa"></span>
						<span class="mastercard"></span>
						<span class="amex"></span>
						<span class="discover"></span>
					</div>
					
					<p><?php echo trans('common.missing_selected_payment_setup')?></p>
				</div>
			</div>
			<div class="pr-foter">
				<div class="pr-buttn">
					<button data-remodal-action="cancel" class="remodal-cancel pr-btn">Cancel</button>
				</div>
			</div>
			</div>
		</div>
	</div>
	<!--- popup end --->
	<script>
		var isPaypalSetup = <?php echo (int) \App\User2::isPaypalSetup($user);?>;
		var isCreditCardSetup = <?php echo (int) \App\User2::isCreditCardSetup($user);?>;
		jQuery(document).on('confirmation', '.remodal', function () {
			jQuery("#payment-method").attr("action"  , "<?php echo action('User2Controller@creditPayment'); ?>");
			jQuery("#payment-method").trigger("submit");
		});

			jQuery(document).ready(function($){
				$('body').on('click', '#cards_button', function(e){
					if (!isCreditCardSetup)
					{
						e.preventDefault();
						$('.payment_popup_wraper').hide();
						$('.payment_missing_popup_wraper').show();
						$('.paypal_wraper').hide();
						$('.cc_wraper').show();
					    $('[data-remodal-id=modal]').remodal().open();
					}
				});

				$(document).on('closed', '.remodal', function () {
					$('.paypal_wraper').show();
					$('.cc_wraper').hide();

					if (isPaypalSetup)
					{
						$('.payment_popup_wraper').show();
						$('.payment_missing_popup_wraper').hide();
					}
					else {
						$('.payment_popup_wraper').hide();
						$('.payment_missing_popup_wraper').show();
					}
				});

				
				jQuery("#paypal-payment-button").click(function(){
					//alert("payment-method");
					//return false;
					//jQuery("#payment-methodpayment-method").trigger("submit");
				});
			});
		</script>
</body>
</html>
