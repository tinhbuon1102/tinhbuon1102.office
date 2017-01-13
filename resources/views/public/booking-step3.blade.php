
<?php 
use App\Spaceslot;

?>
<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header.php'); ?>
@include('pages.header')
<script class="rs-file" src="<?php echo SITE_URL?>js/assets/royalslider/jquery.easing-1.3.js"></script>
<script src="<?php echo SITE_URL?>js/perfect-scrollbar/js/perfect-scrollbar.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL?>assets/css/main.css">
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
		<section id="page">
			<div id="main">
				<header class="page-header">
					<div class="container">
						<div class="row">
							<div class="col-sm-7">
								<h1 itemprop="name">予約内容を確認</h1>
							</div>
							<!--/col-sm-7-->
							<div class="col-sm-5 hidden-xs">
								<div itemprop="breadcrumb" class="breadcrumb clearfix">
									<a href="#" title="hOur Office">Home</a>
									<a href="#" title="Booking">予約</a>
									<a href="#" title="Details">予約詳細</a>
									<span>予約確認</span>
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
									<div class="breadcrumb-item active">
										<i class="fa fa-list"></i>
										<span>予約確認</span>
									</div>
								</a>
							</div>
							<!--/col-xs-3-->
							<div class="col-xs-3">
								<a href="#">
									<div class="breadcrumb-item">
										<i class="fa fa-credit-card"></i>
										<span>支払い</span>
									</div>
								</a>
							</div>
							<!--/col-xs-3-->
						</div>
						<form method="post">
							<div class="row mb30">
								<div class="col-md-4">
									<table class="book-summary book-table billing-table">
										<tbody>
											<?php $months=0;?>
											<tr class="t-caption">
												<th colspan="2">請求先情報</th>
											</tr>
											<tr>
												<td colspan="2">{!!$user->LastName!!} {!!$user->FirstName!!}</td>
											</tr>
											@if($user->NameOfCompany!='')
											<tr>
												<td colspan="2">{!!$user->NameOfCompany !!}</td>
											</tr>
											@endif
											<tr>
												<td colspan="2">
													〒{!!$user->PostalCode !!}
													<br />
													{!!$user->City !!}@if($user->Address1!=''){!!$user->Address1 !!}@endif
												</td>
											</tr>
											<tr>
												<th>電話番号</th>
												<td>{!!$user->Tel !!}</td>
											</tr>
											<tr>
												<th>メールアドレス</th>
												<td>{!!$user->Email !!}</td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="col-md-4">
									<table class="book-summary book-table">
										<tbody>
											<tr class="t-caption">
												<th colspan="2">スペース概要</th>
											</tr>
											<tr>
												<td colspan="2">{!!$rent_data->spaceID->Title!!}</td>
											</tr>
											<tr>
												<th>スペースタイプ</th>
												<td>{!!$rent_data->spaceID->Type!!}</td>
											</tr>
											<tr>
												<th>利用可能人数</th>
												<td>{!!$rent_data->spaceID->Capacity!!}人</td>
											</tr>
											@if($rent_data->spaceID->NumOfDesk!='0')
											<tr>
												<th>デスク</th>
												<td>{!!$rent_data->spaceID->NumOfDesk!!}</td>
											</tr>
											@endif @if($rent_data->spaceID->NumOfTable!='0')
											<tr>
												<th>テーブル</th>
												<td>{!!$rent_data->spaceID->NumOfTable!!}</td>
											</tr>
											@endif @if($rent_data->spaceID->NumOfChair!='0')
											<tr>
												<th>イス</th>
												<td>{!!$rent_data->spaceID->NumOfChair!!}</td>
											</tr>
											@endif
											<tr>
												<th>設備</th>
												<td>
													<ul class="fc-list-td">
														<?php $facilities=explode(',',$rent_data->spaceID->OtherFacilities);?>
														@if(!empty($facilities)) @foreach($facilities as $key=>$facility)
														<li>{!!$facility!!}</li>
														@endforeach @endif
													</ul>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="col-md-4">
									@if($rent_data->spaceID->FeeType!=1)
									<?php 
$slots_id=explode(';',$rent_data['spaceslots_id']);

$slots_data=Spaceslot::whereIn('id', array_filter(array_unique($slots_id)))->orderBy('StartDate','asc')->get();
$slots_array=array();
foreach($slots_data as $slot):
$slots_array[]=$slot->id;
endforeach;
$count=0;
?>
									<?php $count=0; ?>
									@foreach($slots_data as $slot)
									<?php $count++;
if($count==1):
$start_date=$slot->StartDate;
endif;
?>
									@endforeach
									<table class="book-summary book-total-amount book-table">
										<tbody>
											<tr>
												<th>利用人数</th>
												<td>{!!$rent_data->total_persons!!}人</td>
											</tr>
											<tr>
												<th>利用開始日</th>
												<td>{!!$start_date!!}</td>
											</tr>
											<tr>
												<th>期間</th>
												<td>{!!$count!!} @if($rent_data->spaceID->FeeType==1)時間 @elseif($rent_data->spaceID->FeeType==3)週間 @elseif($rent_data->spaceID->FeeType==4)ヶ月 @else日間 @endif</td>
											</tr>
											@if($rent_data->spaceID->FeeType==1)
											<?php 
Session::put('duration', $count);
?>
											@elseif($rent_data->spaceID->FeeType==3)
											<?php
											Session::put('duration', $count);
?>
											@elseif($rent_data->spaceID->FeeType==4)
											<?php
											Session::put('duration', $count);
?>
											@else
											<?php
Session::put('duration', $count);
?>
											@endif
										</tbody>
										<tfoot>
											<?php if($rent_data->price==''):if($rent_data->spaceID->HourFee!=0): $sub_total=$rent_data->spaceID->HourFee; elseif($rent_data->spaceID->DayFee!=0): $sub_total=$rent_data->spaceID->DayFee; elseif($rent_data->spaceID->WeekFee!=0): $sub_total= $rent_data->spaceID->WeekFee; elseif($rent_data->spaceID->MonthFee!=0): $sub_total_one=$rent_data->spaceID->MonthFee;$sub_total=$rent_data->spaceID->MonthFee; endif; else: $sub_total=$rent_data->price;endif;
											?>
											@if($rent_data->spaceID->FeeType==1)
											<?php 
											Session::put('type', 'hourly');
											?>
											@elseif($rent_data->spaceID->FeeType==3)
											<?php
											Session::put('type', 'weekly');
											?>
											@elseif($rent_data->spaceID->FeeType==4)
											<?php
											Session::put('type', 'monthly');
											?>
											@else
											<?php
											Session::put('type', 'daily');
											?>
											@endif
									
									</table>
									<?php
									if($count>5 && $rent_data->spaceID->FeeType==4):
									$months=2;
									$sub_total_months=$months*$rent_data->spaceID->MonthFee;
									endif;
									?>
									@else
									<?php $dates=explode('-',str_replace('To:','',$rent_data['hourly_time']));

									$t11 = StrToTime ( trim($dates[0]));
									$t21 = StrToTime (  trim($dates[1]));
									$diff1 = $t11 - $t21;
									$hours1 = str_replace('-','',$diff1 / ( 60 * 60 ));
									$count=$hours1;

									?>
									@endif @if($count>5 && $rent_data->spaceID->FeeType==4)
									<?php 
									if($count>5 && $rent_data->spaceID->FeeType==4):
									$months=2;
									$sub_total_months=$months*$rent_data->spaceID->MonthFee;
									endif;
echo renderBookingFor6Months($sub_total_months, $rent_data,$start_date,$count)?>
									@endif
									<table class="book-details book-table calc-table no-border-table">
										<tbody>
											<tr class="total-amount-value ver-top pad-top20 no-btm-pad">
												<th>
													<h3>合計金額</h3>
												</th>
												<td>
													<div class="lead text-right">
														<span id="total_booking">
															<?php echo $totalPrice?>
														</span>
													</div>
												</td>
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
															<small>
																<?php echo $subTotal;?>
															</small>
														</span>
													</div>
												</td>
											</tr>
											<tr class="no-pad">
												<th>
													<p class="other-fee">消費税</p>
												</th>
												<td>
													<div class="lead text-right">
														<span id="tax_fee">
															<small>
																<?php echo $subTotalIncludeTax?>
															</small>
														</span>
													</div>
												</td>
											</tr>
											</tr>
											<tr class="no-pad">
												<th>
													<p class="other-fee">手数料(10%)</p>
												</th>
												<td>
													<div class="lead text-right">
														<span id="margin_fee">
															<small>
																<?php echo $subTotalIncludeChargeFee?>
															</small>
														</span>
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<!--.mb30-->
							<div class="step-btn-group">
								<a class="btn btn-default btn-lg pull-left" href="/ShareUser/Dashboard/BookingDetails">
									<i class="fa fa-angle-left"></i>
									前に戻る
								</a>
								<!--<button type="submit" name="confirm_booking" class="btn btn-primary btn-lg pull-right">Confirm the booking <i class="fa fa-angle-right"></i></button>-->
								<a class="btn btn-default btn-lg pull-right right-arrow" href="/ShareUser/Dashboard/BookingPayment">
									予約を確認し、支払へ進む
									<i class="fa fa-angle-right"></i>
								</a>
							</div>
						</form>
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
</body>
</html>
