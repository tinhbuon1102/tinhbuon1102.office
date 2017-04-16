@extends('adminLayout') @section('head')
<title>請求書</title>
@stop @section('PageTitle') 請求書 @stop @section('Content')
<script src="{{ URL::asset('js/chosen/chosen.jquery.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('js/assets/custom_edit_form.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('js/jquery.validate.js?v=1') }}"></script>
<script src="{{ URL::asset('js/assets/custom.js') }}" type="text/javascript"></script>
<div class="viewport">
	<div class="main-container">
		<div id="main" class="container fixed-container">
			<div class="pull-left text-right">
				<a href="/MyAdmin/RentUser/<?php echo $booking->rentUser->HashCode?>#tab-3">
					<button class="btn btn-default " type="button">
						<i class="fa fa-reply"></i>
						<span class="hidden-sm hidden-xs">
							{{ trans('booking_details.go_back_list') }}
							<!--一覧に戻る-->
						</span>
					</button>
				</a>
			</div>
			<!--/leftbox-->
			<!--/page-header-->
			<div class="container-fluid">
				<page size="A4">
				<div id="invoice-container">
					<div class="head-invoice clearfix">
						<div class="row">
							<div class="col-md-4 logo">
								<h1>
									<img src="{{url('/')}}/images/logo-blk.png" />
								</h1>
							</div>
							<div class="col-md-4 tcenter">
								<div class="t-box">請求書</div>
							</div>
							<div class="col-md-4 tright">
								<div class="t-box">
									<p>{{url('/')}}</p>
								</div>
							</div>
						</div>
						<!--/row-->
					</div>
					<div class="invoice-inner">
						<div class="inv-info">
							<div class="row">
								<div class="col-md-6">
									<p class="inv-to">請求先</p>
									<h3>{{getUserName($booking->rentUser)}}</h3>
									<p class="inv-p">
										<b>{{$booking->rentUser->PostalCode}}</b>
										<br>
										<b>{{$booking->rentUser->Prefecture . $booking->rentUser->District . $booking->rentUser->Address1}}</b>
										<br>
										<b>{{$booking->rentUser->Tel}}</b>
									</p>
								</div>
								<div class="col-md-6">
									<div class="row inv-3blk">
										<div class="col-md-4">
											<span class="inv-icon">
												<i class="fa fa-calendar" aria-hidden="true"></i>
											</span>
											<strong>{{ trans('booking_details.date') }}</strong>
											<p class="price"><?php echo getBookingPaidDate($booking, false)?></p>
										</div>
										<div class="col-md-4">
											<span class="inv-icon">
												<i class="fa fa-barcode" aria-hidden="true"></i>
											</span>
											<strong>{{ trans('booking_details.recipt_no') }}</strong>
											<p class="price">{{$booking->InvoiceID}}</p>
										</div>
										<div class="col-md-4 total-cal">
											<span class="inv-icon">
												<i class="fa fa-jpy" aria-hidden="true"></i>
											</span>
											<strong>{{ trans('booking_details.total_amount') }}</strong>
											<p class="price">
												@if($booking->status!=3 || ($booking->status==3 && $booking->refund_status == BOOKING_REFUND_CHARGE_100)) {{priceConvert($booking->amount + $booking->ChargeFee * 2, true)}} @elseif($booking->status==3)
												<?php 
												if ($booking->refund_status == BOOKING_REFUND_CHARGE_50)
													echo priceConvert($booking->amount + $booking->ChargeFee - getRefundChargedPrice($booking, $html = false, true), true);
												else
													echo priceConvert($booking->amount - getRefundChargedPrice($booking, $html = false, true), true)
													?>
												@endif
											</p>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="clear"></div>
						<div class="responsive-table">
							<div class="iv-detail">
								<table class="table table-invoice disc-invoice dataTable">
									<thead>
										<tr>
											<th class="pd_20 no_bg"></th>
											<th>#</th>
											<th class="desc-th">{{ trans('booking_details.space_summary') }}</th>
											<th>{{ trans('booking_details.unit_price') }}</th>
											<th>{{ trans('booking_details.terms') }}</th>
											<th class="td_right">{{ trans('booking_details.price') }}</th>
											<th class="pd_20 no_bg"></th>
										</tr>
									</thead>
									<tbody>
										<?php 
										if($booking->spaceID->FeeType == SPACE_FEE_TYPE_DAYLY) {
														$groupPrices = array();
														usort($prices, function($a, $b) {
															return $a['Date'] < $b['Date'] ? -1 : 1;
														});

															foreach ($prices as $subPrice)
															{
																$groupPrices[$subPrice['SpecialDay']][] = $subPrice;
															}

															$countGroup = 0;
															foreach ($groupPrices as $groupPrice)
															{
																$countGroup++;
																$aDates = array();
																$groupPriceTotal = 0;
																foreach ($groupPrice as $subPrice)
																{
																	$groupPriceTotal += $subPrice['price'];
																	$aDates[] = date('m/d', strtotime($subPrice['Date']));
																}
																?>
										<tr>
											<td class="pd_20"></td>
											<td>
												<?php echo ($countGroup == 1) ?  $countGroup : ''?>
											</td>
											<td>
												<?php if ($countGroup == 1) {?>
												<p class="sp-name">{{$booking->spaceID->Title}}</p>
												<p class="small">{{ trans('booking_details.space_type') }}：{{$booking->spaceID->Type}}</p>
												<p class="small">{{ trans('booking_details.use_type') }}：{{getSpaceTypeText($booking->spaceID)}}毎</p>
												<?php }?>
											</td>
											<td class="price">
												<?php echo $subPrice['SpecialDay']?>
												({{priceConvert($subPrice['price'], true)}})
											</td>
											<td>
												<?php echo count($groupPrice);?>
												日
											</td>
											<td class="td_right price">
												<?php echo priceConvert($groupPriceTotal, true);?>
											</td>
											<td class="pd_20"></td>
										</tr>
										<?php }
												}
												else {
													$aRecursion = $booking->bookingRecursion;

													if( count($aRecursion) > 1 || $booking->spaceID->FeeType == SPACE_FEE_TYPE_HOURLY || $booking->spaceID->FeeType == SPACE_FEE_TYPE_WEEKLY):
													?>
										<tr>
											<td class="pd_20"></td>
											<td>1</td>
											<td>
												<p class="sp-name">{{$booking->spaceID->Title}}</p>
												<p class="small">{{ trans('booking_details.space_type') }}：{{$booking->spaceID->Type}}</p>
												<p class="small">{{ trans('booking_details.use_type') }}：{{getSpaceTypeText($booking->spaceID)}}毎</p>
											</td>
											<td class="price">
												<?php 
												$price = isset($prices[0]) ? $prices[0]['price'] : 0;
															echo priceConvert($price, true);?>
											</td>
											<td>
												<?php if ($booking->Duration >= 6 && $booking->SpaceType == 4) {?>
													2ヶ月
												<?php }else {?>
													{{$booking->DurationText}}
												<?php }?>
											</td>
											<td class="td_right price">{{priceConvert($booking->SubTotal, true)}}</td>
											<td class="pd_20"></td>
										</tr>
										<?php
										else:
										?>
										<tr>
											<td class="pd_20"></td>
											<td>1</td>
											<td>
												<p class="sp-name">{{$booking->spaceID->Title}}(Initial Payment)</p>
												<p class="small">{{ trans('booking_details.space_type') }}：{{$booking->spaceID->Type}}</p>
												<p class="small">{{ trans('booking_details.use_type') }}：{{getSpaceTypeText($booking->spaceID)}}毎</p>
											</td>
											<td class="price">
												<?php 
												$price = isset($prices[0]) ? $prices[0]['price'] : 0;
												echo priceConvert($price, true);
												?>
											</td>
											<td>2months</td>
											<td class="td_right price">
												¥
												<?php echo priceConvert($booking->SubTotal);?>
											</td>
											<td class="pd_20"></td>
										</tr>
										<?php endif;
												}

												?>
										<!--start if recursion payment-->
										<!--stard subtotal-->
										<tr class="subtotal-row">
											<td class="pd_20"></td>
											<td>&nbsp;</td>
											<td colspan="3">
												<p class="rpt-smy align-right">{{ trans('booking_details.subtotal') }}</p>
											</td>
											<td class="td_right price">{{priceConvert($booking->SubTotal, true)}}</td>
											<td class="pd_20"></td>
										</tr>
										<!--end subtotal-->
										<!--stard tax-->
										<tr class="subtotal-row">
											<td class="pd_20"></td>
											<td>&nbsp;</td>
											<td colspan="3">
												<p class="rpt-smy align-right">{{ trans('booking_details.tax') }}</p>
											</td>
											<td class="td_right price">{{priceConvert($booking->Tax, true)}}</td>
											<td class="pd_20"></td>
										</tr>
										<!--end tax-->
										<!--end if recursion payment-->
										<!--start if 50% refund-->
										<?php if ($booking->status == BOOKING_STATUS_REFUNDED && $booking->refund_status != BOOKING_REFUND_CHARGE_100) {?>
										<tr class="refund-row">
											<td class="pd_20"></td>
											<td>&nbsp;</td>
											<td colspan="3">
												<p class="rpt-smy align-right">
													<?php echo getRefundTypeText($booking)?>
												</p>
											</td>
											<td class="td_right price">
												<?php echo getRefundChargedPrice($booking, $html = true)?>
											</td>
											<td class="pd_20"></td>
										</tr>
										<?php }?>
										<!--/end if 50% refund-->
									</tbody>
								</table>
							</div>
							<!--<div class="subtotal_incltax">{{priceConvert($booking->SubTotal + $booking->Tax, true)}}</div>-->
							<!--<div class="sales_user1">{{priceConvert($booking->SubTotal + $booking->Tax - $booking->ChargeFee, true)}}</div>-->
							<!--<div class="sales_user1">{!! priceConvert(ceil($booking->amount)) !!}</div>-->
							<div class="total-block">
								<div class="row">
									<div class="col-md-7">
										<div class="row">
											<div class="col-md-4">
												<!--<span class="tl-tag">{{ trans('booking_details.subtotal') }}</span>-->
												<!--<p class="tl-amount">{{priceConvert($booking->SubTotal, true)}}</p>-->
											</div>
											<div class="col-md-4">
												<!--<span class="tl-tag">{{ trans('booking_details.tax') }}<!--Tax-->
												</span>
												<!--<p class="tl-amount">{{priceConvert($booking->Tax, true)}}</p>-->
											</div>
											<div class="col-md-4">
												<span class="tl-tag">
													{{ trans('booking_details.charge') }}(10%)
													<!--Charge-->
												</span>
												<p class="tl-amount">{{priceConvert($booking->ChargeFee, true)}}</p>
											</div>
										</div>
									</div>
									<div class="col-md-5 clearfix">
										<span class="tl-tag align-right">{{ trans('booking_details.total_amount') }}</span>
										<!--hide this code if 50% refund-->
										@if($booking->status!=3 || ($booking->status==3 && $booking->refund_status == BOOKING_REFUND_CHARGE_100))
										<p class="tl-amount big">{{priceConvert($booking->amount + $booking->ChargeFee * 2, true)}}</p>
										<!--hide this code if 50% refund-->
										<!--start if 50% refund-->
										@elseif($booking->status==3)
										<p class="tl-amount small strike">
											<span class="strike">{{priceConvert($booking->amount + $booking->ChargeFee, true)}}</span>
										</p>
										<p class="tl-amount big refunded-amount">
											<?php 
											if ($booking->refund_status == BOOKING_REFUND_CHARGE_50)
												echo priceConvert($booking->amount + $booking->ChargeFee - getRefundChargedPrice($booking, $html = false, true), true);
											else
												echo priceConvert($booking->amount - getRefundChargedPrice($booking, $html = false, true), true)
												?>
										</p>
										@endif
										<!--/end if 50% refund-->
									</div>
								</div>
							</div>
							<div class="pay-info">
								<div class="row">
									<div class="col-md-6">
										<h4>利用情報</h4>
										<table class="table table-invoice pay-method dataTable">
											<tbody>
												<tr>
													<th>予約番号</th>
													<td>
														<p class="pay-name">#{{$booking->id}}</p>
													</td>
												</tr>
												<tr>
													<th>利用者</th>
													<td>
														<p class="small">{{getUserName($booking->rentUser)}}</p>
													</td>
												</tr>
												<tr>
													<th>利用日</th>
													<td>
														<p class="small">
															<?php echo $booking->UsedDate?>
														</p>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
									<div class="col-md-6">
										<h4>支払情報</h4>
										<table class="table table-invoice pay-method dataTable">
											<tbody>
												<tr>
													<th>決済方法</th>
													<td>
														<p class="pay-name">{{getPaymentMethod($booking)}}</p>
													</td>
												</tr>
												<tr>
													<th>トランザクションID</th>
													<td>
														<p class="small">{{$booking->transaction_id}}</p>
													</td>
												</tr>
												<tr>
													<th>Paid Date</th>
													<td>
														<p class="small"><?php echo getBookingPaidDate($booking)?></p>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<div class="clear"></div>
						</div>
						<!--/responsive-table-->
					</div>
					<!--/inner-->
					<div class="inv-footer">株式会社Aventures 〒106-0032東京都港区六本木5-9-20六本木イグノポール5階</div>
				</div>
				<!--/invoice-conteiner--> </page>
			</div>
			<!--/right_side-->
		</div>
		<!--/main-->
	</div>
</div>
<!--/viewport-->
@stop
