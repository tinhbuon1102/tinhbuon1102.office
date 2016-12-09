@include('pages.header')
<script class="rs-file" src="<?php echo SITE_URL?>js/assets/royalslider/jquery.easing-1.3.js"></script>
<script src="<?php echo SITE_URL?>js/perfect-scrollbar/js/perfect-scrollbar.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL?>assets/css/main.css">
<script type="text/javascript" src="<?php echo SITE_URL?>assets/js/jquery-ui.min.js"></script>
<script src="<?php echo SITE_URL?>js/datepicker-ja.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL?>assets/css/tab.css">
<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL?>assets/css/folio.css">
<!-- <script type="text/javascript" src="<?php echo SITE_URL?>assets/js/CommonJs.js"></script>  -->
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
		@if(Auth::check()) @include('pages.header_nav_shareuser') @elseif(Auth::guard('user2')->check()) @include('pages.header_nav_rentuser') @endif
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
									<a href="#" title="Offispo">Home</a>
									<a href="#" title="Booking">予約</a>
									<a href="#" title="Details">予約詳細</a>
									<a href="#" title="Summary">予約確認</a>
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
										<span>予約確認</span>
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
							<!--payment form-->
							<div id="Checkout" class="inline">
								<h1>クレジットカード支払い</h1>
								<div class="card-row">
									<span class="visa"></span>
									<span class="mastercard"></span>
									<span class="amex"></span>
									<span class="discover"></span>
								</div>
								<form action='' method='post'>
									<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
									<div class="form-group">
										<label for="PaymentAmount">支払金額</label>
										<div class="amount-placeholder">
											<span>¥</span>
											<span> @if(Session::get('duration')>5 && $rent_data->spaceID->FeeType==4) {!!priceConvert(($rent_data['spaceID']['MonthFee']*2*0.08)+(($rent_data['spaceID']['MonthFee']*2*0.08)+($rent_data['spaceID']['MonthFee']*2))*0.10+$rent_data['spaceID']['MonthFee']*2)!!} @else {!!priceConvert($rent_data->amount)!!} @endif</span>
										</div>
									</div>
									<div class="form-group">
										<label or="NameOnCard">カード名義</label>
										<input id="NameOnCard" name="PaymentProfileForEdit.FullName" class="form-control" type="text" value="{!!$user->card_name!!}" maxlength="255"></input>
									</div>
									<div class="form-group">
										<label for="CreditCardNumber">カード番号</label>
										<input id="CreditCardNumber" class="null card-image form-control" type="text" value="{{$user->modified_card_number}}" name="PaymentProfileForEdit.CardNumber"></input>
									</div>
									<div class="expiry-date-group form-group">
										<label for="ExpiryDate">有効期限</label>
										<input id="ExpiryDate" class="form-control" type="text" value="@if($user->exp_month!='')@if(strlen($user->exp_month)==1)0{!!$user->exp_month!!}@else{!!$user->exp_month!!}@endif/{!!substr($user->exp_year, -2)!!}@endif" placeholder="MM / YY" name="ExpiryDate" maxlength="7" required>
									</div>
									<!-- <div class="expiry-date-group form-group">
              <label for="ExpiryDate">Expiry year</label>
              <select required data-bind="css: { 'input-validation-error-add' : filedsRequired($data.expYear()) == true }, value: expYear, valueUpdate: 'afterkeydown'" data-val="true" data-val-number="The field ExpirationYear must be a number." id="PaymentProfileForEdit_ExpirationYear" name="PaymentProfileForEdit.ExpirationYear"><option value="">----</option>
			<?php for($date=date('Y');$date<date('Y')+10;$date++): ?>
				<option value="<?php echo $date;?>" @if($user->exp_year==$date) Selected='selected' @endif><?php echo $date;?></option>
			<?php endfor; ?>
</select>
          </div>-->
									<div class="security-code-group form-group">
										<label for="SecurityCode">セキュリティーコード<i id="cvc" class="fa fa-question-circle"></i></label>
										<div class="input-container">
											<input id="SecurityCode" name="PaymentProfileForEdit.CardCode" class="form-control" type="text" value="{!!$user->security_code!!}"></input>
											
										</div>
										<div class="cvc-preview-container two-card hide">
											<div class="amex-cvc-preview"></div>
											<div class="visa-mc-dis-cvc-preview"></div>
										</div>
									</div>
									<button id="PayButton" class="btn btn-block btn-success submit-button" type="submit">
										<span class="submit-button-lock"></span>
										<span class="align-middle">¥ @if(Session::get('duration')>5 && $rent_data->spaceID->FeeType==4) {!!priceConvert(($rent_data['spaceID']['MonthFee']*2*0.08)+(($rent_data['spaceID']['MonthFee']*2*0.08)+($rent_data['spaceID']['MonthFee']*2))*0.10+$rent_data['spaceID']['MonthFee']*2)!!} @else {!!priceConvert($rent_data->amount)!!} @endifを支払う</span>
									</button>
								</form>
							</div>
							<!--/payment form-->
						</div>
						<div class="clearfix"></div>
						<div class="step-btn-group">
							<a class="btn btn-default btn-lg pull-left" href="/ShareUser/Dashboard/BookingPayment">
								<i class="fa fa-angle-left"></i>
								前へ戻る
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
	<!--/viewport-->
	<script>
  jQuery(function ($) {
  $('[data-toggle="popover"]').popover();
  
  $('#cvc').on('click', function(){
    if ( $('.cvc-preview-container').hasClass('hide') ) {
      $('.cvc-preview-container').removeClass('hide');
    } else {
      $('.cvc-preview-container').addClass('hide');
    }    
  });
  
  $('.cvc-preview-container').on('click', function(){
    $(this).addClass('hide');
  });
});
  </script>
</body>
</html>
