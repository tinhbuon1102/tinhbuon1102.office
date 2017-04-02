
<?php 
use App\Spaceslot;
?>
<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header.php'); ?>
@include('pages.header')
<!-- Base MasterSlider style sheet -->
<link rel="stylesheet" href="<?php echo SITE_URL?>js/swipe-slider/quick-start/masterslider/style/masterslider.css" />

<!-- MasterSlider default skin -->
<link rel="stylesheet" href="<?php echo SITE_URL?>js/swipe-slider/quick-start/masterslider/skins/default/style.css" />

<!-- MasterSlider Template Style -->
<link href='<?php echo SITE_URL?>js/swipe-slider/slider-templates/lightbox/style/ms-lightbox.css' rel='stylesheet' type='text/css'>
<script class="rs-file" src="<?php echo SITE_URL?>js/assets/royalslider/jquery.easing-1.3.js"></script>
<!-- MasterSlider main JS file -->
<script src="<?php echo SITE_URL?>js/swipe-slider/quick-start/masterslider/masterslider.min.js"></script>

<script src="<?php echo SITE_URL?>js/perfect-scrollbar/js/perfect-scrollbar.js"></script>

<script src="<?php echo SITE_URL?>js/swipe-slider/slider-templates/lightbox/js/jquery.prettyPhoto.js"></script>
 
   <link rel="stylesheet" type="text/css" href="<?php echo SITE_URL?>assets/css/main.css">      
  <!-- <script type="text/javascript" src="<?php echo SITE_URL?>assets/js/jquery.min.js"></script> -->
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
<script src="{{ URL::asset('js/calendar/calendar-custom1.js') }}"></script>
<!--/head-->
<body class="booking-process common">
<div class="viewport">
		<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header_nav_shareuser.php'); ?>
		@if(Auth::check())
			@include('pages.header_nav_shareuser')
		@elseif(Auth::guard('user2')->check())
			@include('pages.header_nav_rentuser')
		@endif
		<section id="page">
		<div id="main">
        <header class="page-header">
        <div class="container">
        <div class="row">
        <div class="col-sm-7">
        <h1 itemprop="name">予約完了</h1>
        </div><!--/col-sm-7-->
        
        
        </div><!--/row-->
        </div><!--/container-->
        </header>
        <div id="content" class="pt30 pb30">
        <!--confirm booking-->
<div id="confirm-book" class="container">

<div class="text-center lead pt20 pb20">
<h1>予約の申し込みが完了しました</h1>
<p class="comp-msg">ご予約内容の確認メールが登録されたメールアドレス宛に送信されますので、ご確認ください。<br/><span class="red bold">予約が承認されるまでは、予約は確定されませんので、ご注意ください。</span></p>
</div>
<div class="row mb30 pt30">
<div class="col-md-4">
<table class="book-summary book-table billing-table">
<tbody>
<?php $months=0;?>
<tr class="t-caption"><th colspan="2">支払い方法</th></tr>


<tr><td colspan="2">@if($rent_data->payment_method == 'creditcard')クレジットカード @else Paypal @endif</td></tr>

<!---<tr><td colspan="2">@if($rent_data->transaction_id!='')クレジットカード @else Paypal @endif</td></tr>---->

<tr class="t-caption"><th colspan="2">請求先情報</th></tr>
<tr><td colspan="2">{!!$user->LastName!!} {!!$user->FirstName!!}</td></tr>
@if($user->NameOfCompany!='')<tr><th>会社名</th><td>{!!$user->NameOfCompany	!!}</td></tr>@endif
<tr><td colspan="2">{!!$user->PostalCode !!} {!!$user->City !!}@if($user->Address1!=''){!!$user->Address1 !!}<br/>@endif</td></tr>
<tr><th>電話番号</th><td>{!!$user->Tel	!!}</td></tr>
<tr><th>メールアドレス</th><td>{!!$user->Email	!!}</td></tr>
</tbody>
</table>
</div>
<div class="col-md-8">
<table class="book-details book-table no-border-table">
<tbody>
<tr class="t-caption"><th colspan="2">予約詳細</th></tr>
<tr class="ver-top pad">
@if(isset($rent_data->spaceID->spaceImage[0]))<td><a href='ShareUser/ShareInfo/View/{!!$rent_data->spaceID->HashID!!}'><img src="{{url('/')}}/{!!$rent_data->spaceID->spaceImage[0]->ThumbPath!!}" class="space-thum" /> </td>@endif
<td>
<?php 
$slots_id=explode(';',$rent_data['spaceslots_id']);

$slots_data=Spaceslot::whereIn('id', array_filter(array_unique($slots_id)))->orderBy('StartDate','asc')->get();
$slots_array=array(); 
foreach($slots_data as $slot):
	$slots_array[]=$slot->id;
endforeach;
$count=0;
?>
<h3><a href='ShareUser/ShareInfo/View/{!!$rent_data->spaceID->HashID!!}'>{!!$rent_data->spaceID->Title!!}</a></h3>
<div class="detail-list row">
<div class="col-md-4">予約日:</div>
<div class="col-md-8">
<strong>
@if($rent_data->spaceID->FeeType!=1)@foreach($slots_data as $slot)
<?php $count++;
if($count==1):
	$start_date=$slot->StartDate;
endif;
$start_date_array[]=$slot->StartDate;
?>
@if($rent_data->spaceID->FeeType==3 || $rent_data->spaceID->FeeType==4)
	@if($rent_data->spaceID->FeeType==4) {!!$slot->StartDate!!} ~ {!! date("Y-m-t", strtotime($slot->StartDate))!!}
	@else
		{!!$slot->StartDate!!} ~ {!!$slot->EndDate!!}
	@endif
<br/>
@else
	{!!$slot->StartDate!!}<br/>
@endif
@endforeach
@else
	<?php $dates=explode('-',$rent_data['hourly_time']);

										$t11 = StrToTime ( trim($dates[0]));
										$t21 = StrToTime (  trim($dates[1]));
										$diff1 = $t11 - $t21;
										$hours1 = str_replace('-','',$diff1 / ( 60 * 60 ));
										$count=$hours1;
										
?>
	{!!$rent_data['hourly_date']!!}
@endif
</strong>
 </div>
</div>
<div class="detail-list row">
<div class="col-md-4">利用タイプ:</div>
<div class="col-md-8"><strong>@if($rent_data->spaceID->FeeType==1) 時間毎 @elseif($rent_data->spaceID->FeeType==3) 週毎 @elseif($rent_data->spaceID->FeeType==4) 月毎 @else 日毎 @endif</strong></div>
</div>


@if($rent_data->spaceID->FeeType==1)
<div class="detail-list row">
<div class="col-md-4">利用時間帯:</div>
<div class="col-md-8"><strong>
		{!!$rent_data['hourly_time']!!}
</strong></div>
</div>
@endif


<div class="detail-list row">
<div class="col-md-4">@if($rent_data->spaceID->FeeType==1)利用時間@else利用期間@endif:</div>
<div class="col-md-8"><strong>
@if($rent_data->spaceID->FeeType!=1)
{!!$count!!} @if($rent_data->spaceID->FeeType==1)時間 @elseif($rent_data->spaceID->FeeType==3)週間 @elseif($rent_data->spaceID->FeeType==4)ヶ月 @else 日間 @endif
@else
		{!!$count!!}時間
@endif
</strong></div>
</div>

</p>
</td>
</tr>
</tbody>
</table>

@if($count>5 && $rent_data->spaceID->FeeType==4)
<?php 
if($count>5 && $rent_data->spaceID->FeeType==4):
	$months=2;
	$sub_total_months=$months*$rent_data->spaceID->MonthFee;
endif;
echo renderBookingFor6Months($sub_total_months, $rent_data,$start_date,$count)?>
@endif
<table class="book-details book-table calc-table no-border-table">
<tbody>

<tr class="total-amount-value ver-top pad-top20 no-btm-pad"><th>
<h3>合計金額</h3>
</th>
<td><div class="lead text-right"><span id="total_booking"><?php echo $totalPrice?></span></div></td>
</tr>
<?php echo renderBookingSummary($rent_data->spaceID, $prices,$count)?>

<tr class="no-pad">
	<th>
		<p class="total-calc">
			<span class="subtotal">小計</span>
		</p>
	</th>
	<td>
		<div class="lead text-right">
			<span id="unit_total" class="price-value" style="float: right">
				<small>  <?php echo $subTotal;?></small>
			</span>
		</div>
	</td>
</tr>
<tr class="no-pad">
	<th><p class="other-fee">消費税</p></th>
	<td><div class="lead text-right"><span id="tax_fee"><small><?php echo $subTotalIncludeTax?></small></span></div></td>
</tr>
</tr> 
<tr class="no-pad">
<th><p class="other-fee">手数料(10%)</p></th>
<td><div class="lead text-right"><span id="margin_fee"><small><?php echo $subTotalIncludeChargeFee?></small></span></div></td>
</tr>

</tbody>
</table>
</div>
</div><!--.mb30-->
<div class="clearfix"></div>
</div><!--/container-->
<!--/confirm booking-->
        </div>
        <!--footer-->
				@include('pages.dashboard_user1_footer')

		<!--/footer-->
        </div><!--/#main-->
        </section>
        
        </div>
	<!--/viewport-->
    <script type="text/javascript" src="<?php echo SITE_URL?>assets/js/fromJS.js"></script>
  <script type="text/javascript" src="<?php echo SITE_URL?>assets/js/pageCommon.js"></script>
  </body>
</html>