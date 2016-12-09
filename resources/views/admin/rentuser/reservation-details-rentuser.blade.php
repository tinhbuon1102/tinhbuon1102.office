@extends('adminLayout') @section('head')
<title>予約詳細</title>
@stop @section('PageTitle') 予約詳細 @stop @section('Content')
<script src="{{ URL::asset('js/chosen/chosen.jquery.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('js/assets/custom_edit_form.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('js/jquery.validate.js?v=1') }}"></script>
<script src="{{ URL::asset('js/assets/custom.js') }}" type="text/javascript"></script>
<?php $count = count($rent_data->bookedSlots);?>
<div class="viewport">
	<div class="main-container">
		<div id="main" class="container fixed-container">
			<div class="page-header ">
				<div class="container-fluid">
					<div class="row">
						<div class="col-xs-6 col-md-6 col-sm-8 clearfix">
							<h1 class="pull-left">
								<i class="fa fa-calendar-check-o"></i>
								予約詳細
								<!--予約詳細-->
							</h1>
							<div class="pull-left text-right">
								<a href="/MyAdmin/RentUser/<?php echo $rent_data->rentUser->HashCode?>#tab-2">
									<button class="btn btn-default " type="button">
										<i class="fa fa-reply"></i>
										<span class="hidden-sm hidden-xs">
											{{ trans('booking_details.go_back_list') }}
											<!--一覧に戻る-->
										</span>
									</button>
								</a>
							</div>
						</div>
						<div class="col-xs-6 col-md-6 col-sm-4 clearfix pb15 text-right  hide_edit_total3">
							<!--<button id="saveBasicInfo" type="submit" class="btn btn-default mt15 saveBasicInfo" ><i class="fa fa-floppy-o"></i><span class="hidden-sm hidden-xs"> 保存</span></button>-->
						</div>
					</div>
				</div>
			</div>
			<!--/leftbox-->
			<!--/page-header-->
			<div id="BookingDetails" class="container-fluid">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-9">
							<div class="panel panel-default">
								<div class="panel-body">
									<div class="col-book">
										<h2>予約番号 #{!!$rent_data->id!!}</h2>
										<div class="row">
											<div class="col-md-6 pad_m7">
												<h4>予約基本情報</h4>
												<div class="form-row">
													<label class="col-lg-3 control-label">予約日</label>
													<div class="col-lg-9">
														<div class=" form-inline">{!!$rent_data->created_at!!}</div>
														<!--/form-inline-->
													</div>
													<!--/col-lg-9-->
												</div>
												<!--form-row-->
												<div class="form-row">
													<label class="col-lg-3 control-label">支払いステータス</label>
													<div class="col-lg-9">
														<div class=" form-inline">
															<?php echo getBookingPaymentStatus($rent_data, true)?>
														</div>
														<!--/form-inline-->
													</div>
													<!--/col-lg-9-->
												</div>
												<!--form-row-->
												<div class="form-row">
													<label class="col-lg-3 control-label">予約ステータス</label>
													<div class="col-lg-9">
														<div class=" form-inline">
															<?php echo getBookingStatus($rent_data, true)?>
														</div>
														<!--/form-inline-->
													</div>
													<!--/col-lg-9-->
												</div>
												<!--form-row-->
												@if($rent_data->status==3 || $rent_data->status==4) @endif
												<div class="form-row">
													<label class="col-lg-3 control-label">Final Cancel</label>
													<div class="col-lg-9">
														<div class=" form-inline">{!!$rent_data->finalCancel!!}</div>
													</div>
												</div>
												<!--/form-row-->
											</div>
											<div class="col-md-6 pad_m7">
												<h4>予約詳細</h4>
												<div class="form-row">
													<label class="col-lg-3 control-label">利用開始日</label>
													<div class="col-lg-9">
														<div class=" form-inline">
															<?php echo renderJapaneseDate($rent_data->charge_start_date)?>
														</div>
													</div>
													<!--/col-lg-9-->
												</div>
												<!--form-row-->
												<div class="form-row">
													<label class="col-lg-3 control-label">利用日</label>
													<div class="col-lg-9">
														<div class="row">
															<?php echo $rent_data->UsedDate?>
														</div>
													</div>
													<!--/col-lg-9-->
												</div>
												<!--form-row-->
												<div class="form-row">
													<label class="col-lg-3 control-label">期間</label>
													<div class="col-lg-9">
														<div class="row">
															<div class="col-md-6">{{$rent_data->DurationText}}</div>
														</div>
													</div>
													<!--/col-lg-9-->
												</div>
												<!--form-row-->
												<div class="form-row">
													<label class="col-lg-3 control-label">
														スペース提供者
														<!--Host Name-->
													</label>
													<div class="col-lg-9">
														<div class=" form-inline">{{$user1Obj->NameOfCompany}}</div>
													</div>
												</div>
												<!--/form-row-->
											</div>
										</div>
										<!--/row-->
									</div>
									<!--/col-book-->
									<div class="col-book">
										<table class="col-md-6 book-details book-table calc-table no-border-table">
											<tbody>
												<tr class="total-amount-value ver-top pad-top20 no-btm-pad">
													<th>
														<h3>合計金額</h3>
													</th>
													<td>
														<div class="lead text-right right-amount-1">
															<span id="total_booking" class='total_booking-charged @if($rent_data->status==3) strike @endif'>
																<?php echo $totalPrice?>
															</span>
															@if($rent_data->status==3)
															<span id="total_booking" class='current_amount'>
																<?php echo priceConvert(getRefundChargedPrice($rent_data, false, true), true)?>
															</span>
															@endif
														</div>
													</td>
												</tr>
												<?php echo renderBookingSummary($rent_data->bookedSpace, $prices,$count,$rent_data->status)?>
												<tr class="no-pad">
													<th>
														<p class="total-calc">{{ trans('booking_details.subtotal') }}</p>
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
												@if( $rent_data->status == 4 or $rent_data->status == 3)
												<tr class="no-pad red-tr">
													<th>
														<p class="other-fee">
															{{ trans('booking_details.refund') }}
															<!--返金-->
															<?php echo getRefundTypeText($rent_data)?>
														</p>
													</th>
													<td>
														<div class="lead text-right">
															<span id="margin_fee">
																<small>
																	<?php echo (getRefundPrice($rent_data, true, false));?>
																</small>
															</span>
														</div>
													</td>
												</tr>
												@endif
											</tbody>
										</table>
									</div>
									<!--/col-book-->
								</div>
								<!--/panel-body-->
								<?php if($count > 5 && $rent_data->bookedSpace->FeeType == SPACE_FEE_TYPE_MONTHLY) {?>
								<div class="col-book clearfix">
									<?php 
									$sub_total_months=BOOKING_MONTH_RECURSION_INITPAYMENT * $rent_data->bookedSpace->MonthFee;
									echo renderBookingFor6Months($sub_total_months, $rent_data,$rent_data->charge_start_date,$count,$edit_booking=true);
									?>
								</div>
								<div class="col-book clearfix">
									<table class="col-md-6 payment-history no-border-table">
										<thead>
											<tr class="ver-top pad-top20 no-btm-pad">
												<th colspan="4">
													<h3>
														{{ trans('booking_details.paid_history') }}
														<!--支払い履歴-->
													</h3>
												</th>
											</tr>
											<tr>
												<th class="ph_date">
													{{ trans('booking_details.date') }}
													<!--日付-->
												</th>
												<th class="ph_desc">
													{{ trans('booking_details.description') }}
													<!--項目-->
												</th>
												<th class="ph_price">
													{{ trans('booking_details.price') }}
													<!--金額-->
												</th>
												<th class="ph_stat align-center">
													{{ trans('booking_details.status') }}
													<!--ステータス-->
												</th>
											</tr>
										</thead>
										<tbody>
											<?php echo getRecursionbooking( $rent_data ); ?>
										</tbody>
									</table>
								</div>
								<?php }?>
							</div>
							<!--/panel-->
						</div>
						<div class="col-md-3 right_sider">
							<div class="panel panel-default">
								<div class="side-head">
									<h4>予約スペース詳細</h4>
								</div>
								<div class="panel-body">
									<div class="side_con">
										<div class="col-detail">
											<span class="space-name">{!!$rent_data->bookedSpace->Title!!}</span>
										</div>
										<div class="col-detail">
											<div class="side_list">
												<div class="label-list">スペースタイプ:</div>
												<div class="list-content">{!!$rent_data->bookedSpace->Type!!}</div>
											</div>
											<!--/side_list-->
										</div>
										<!--/col-detail-->
										<div class="col-detail">
											<div class="side_list">
												<div class="label-list">利用可能人数:</div>
												<div class="list-content">{!!$rent_data->bookedSpace->Capacity!!}人</div>
											</div>
											<!--/side_list-->
										</div>
										<!--/col-detail-->
										@if($rent_data->bookedSpace->NumOfDesk!='0')
										<div class="col-detail">
											<div class="side_list">
												<div class="label-list">デスク:</div>
												<div class="list-content">{!!$rent_data->bookedSpace->NumOfDesk!!}台</div>
											</div>
											<!--/side_list-->
										</div>
										<!--/col-detail-->
										@endif @if($rent_data->bookedSpace->NumOfChair!='0')
										<div class="col-detail">
											<div class="side_list">
												<div class="label-list">イス:</div>
												<div class="list-content">{!!$rent_data->bookedSpace->NumOfChair!!}個</div>
											</div>
											<!--/side_list-->
										</div>
										<!--/col-detail-->
										@endif @if($rent_data->bookedSpace->NumOfTable!='0')
										<div class="col-detail">
											<div class="side_list">
												<div class="label-list">テーブル:</div>
												<div class="list-content">{!!$rent_data->bookedSpace->NumOfTable!!}台</div>
											</div>
											<!--/side_list-->
										</div>
										<!--/col-detail-->
										@endif
										<div class="col-detail">
											<div class="side_list">
												<div class="label-list">設備:</div>
												<div class="list-content">
													<ul class="fac-list">
														<?php $facilities=explode(',',$rent_data->bookedSpace->OtherFacilities);?>
														@if(!empty($facilities)) @foreach($facilities as $key=>$facility)
														<li>{!!$facility!!}</li>
														@endforeach @endif
													</ul>
												</div>
											</div>
											<!--/side_list-->
										</div>
										<!--/col-detail-->
									</div>
									<!--/col-md-->
								</div>
								<!--/panel-body-->
								<div class="side-head">
									<h4>支払詳細</h4>
								</div>
								<div class="panel-body">
									<div class="side_con">
										<div class="col-detail">
											<div class="side_list">
												<div class="label-list">支払方法:</div>
												<div class="list-content">@if($rent_data->transaction_id!='')クレジットカード @else ペイパル @endif</div>
											</div>
											<!--/side_list-->
										</div>
										<!--/col-detail-->
										<div class="col-detail">
											<div class="side_list">
												<div class="label-list">トランザクションID:</div>
												<div class="list-content">{!!$rent_data->transaction_id!!}</div>
											</div>
											<!--/side_list-->
										</div>
										<!--/col-detail-->
										<div class="col-detail">
											<div class="side_list">
												<div class="label-list">支払日:</div>
												<div class="list-content">{!!$rent_data->created_at!!}</div>
											</div>
											<!--/side_list-->
										</div>
										<!--/col-detail-->
									</div>
									<!--/col-md-->
								</div>
								<!--/panel-body-->
							</div>
							<!--/panel-->
						</div>
					</div>
					<!--/row-->
				</div>
				<!--/container-fluid-->
			</div>
			<!--/right_side-->
		</div>
		<!--/main-->
	</div>
</div>
<!--/viewport-->
@stop
