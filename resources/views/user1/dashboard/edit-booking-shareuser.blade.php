 @include('pages.header')
<!--/head-->
<?php 
use App\Spaceslot;
$count = count($rent_data->bookedSlots);
 ?>
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
<body class="mypage shareuser">
	<div class="viewport">
		@include('pages.header_nav_shareuser')
		<div class="main-container">
			<div id="main" class="container fixed-container">
				<div id="left-box">
					@include('user1.dashboard.left_nav')
					<!--/right-content-->
				</div>
				<!--/leftbox-->
				<div class="right_side" id="samewidth">
					<form id="form" action='/ShareUser/Dashboard/EditBookSave/{!!$rent_data->id!!}' method='post'>
						<div id="page-wrapper" class="has_fixed_title">
							<div class="page-header header-fixed">
								<div class="container-fluid">
									<div class="row">
										<div class="col-xs-6 col-md-6 col-sm-8 clearfix">
											<h1 class="pull-left">
												<i class="fa fa-calendar-check-o"></i>
												{{ trans('booking_details.booking_details_title') }}
												<!--予約詳細-->
											</h1>
											<div class="pull-left text-right">
												<a href="/ShareUser/Dashboard/BookList">
													<button class="btn btn-default mt15" type="button">
														<i class="fa fa-reply"></i>
														<span class="hidden-sm hidden-xs">
															{{ trans('booking_details.go_back_list') }}
															<!--一覧に戻る-->
														</span>
													</button>
												</a>
												
												
											</div>
											
										</div>
										<div class="col-xs-6 col-md-6 col-sm-4 clearfix pb15 text-right">
												
													@if($rent_data->in_use==0) 
													@if(($rent_data->status==1 || $rent_data->status==2))
														@if($rent_data->status==2)
															<button class="btn btn-default mt15 refund_booking_button header_booking_button" data-form="#form_refund" type="button" >キャンセルする</button>
														@else
															<button class="btn btn-default mt15 accept_booking_button header_booking_button" data-form="#form_accept" type="button" >{{ trans('booking_details.accept_booking') }}</button>
															<button class="btn btn-default mt15 reject_booking_button header_booking_button" data-form="#form_reject" type="button" >{{ trans('booking_details.deny_booking') }}</button>
														@endif
													@endif @endif
												
											</div>
										
									</div>
								</div>
							</div>
							<!--/page-headre-->
							<div id="BookingDetails">
								@if (count($errors) > 0)
                                <div class="container-fluid">
								<div class="alert alert-danger">
									<ul>
										@foreach ($errors->all() as $error)
										<li>{{ $error }}</li>
										@endforeach
									</ul>
								</div>
                                </div>
								@endif
								<?php $message = Session::get('success'); ?>
								@if( isset($message) )
                                <div class="container-fluid">
								<div class="alert alert-success">{!! $message !!}</div>
                                </div>
								@endif
								<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
								<div class="container-fluid">
									<div class="row">
										<div class="col-md-9">
											<div class="panel panel-default">
												<div class="panel-body">
													<div class="row book-head">
														<div class="col-xs-6 col-md-6 col-sm-8 clearfix">
															<h2>
																{{ trans('booking_details.booking_id') }}
																<!--予約番号-->
																#{!!$rent_data->id!!}
															</h2>
														</div>
														<div class="col-xs-6 col-md-6 col-sm-4 clearfix text-right"></div>
													</div>
													<hr>
													<div class="row">
														<div class="col-md-6 pad_m7">
															<h4>
																{{ trans('booking_details.booking_basic_info') }}
																<!--予約基本情報-->
															</h4>
															<div class="form-row">
																<label class="col-lg-4 control-label">
																	{{ trans('booking_details.booked_date') }}
																	<!--予約受付日-->
																	&nbsp;
																	<span class="require-mark">*</span>
																</label>
																<div class="col-lg-8">
																	<div class=" form-inline"><?php echo renderJapaneseDate($rent_data->created_at)?></div>
																	<!--/form-inline-->
																</div>
																<!--/col-lg-9-->
															</div>
															<!--/form-row-->
															<div class="form-row">
																<label class="col-lg-4 control-label">
																	{{ trans('booking_details.status') }}
																	<!--ステータス-->
																</label>
																<div class="col-lg-8">
																	<div class=" form-inline">
																		<span class='hide_edit_space4'>
																			<?php echo getBookingStatus($rent_data, true)?>
																		</span>
																	</div>
																	<!--/form-inline-->
																</div>
																<!--/col-lg-9-->
															</div>
															<!--/form-row-->
															<div class="form-row">
																<label class="col-lg-4 control-label">
																	{{ trans('booking_details.cancel_possible_date') }}
																	<!--キャンセル可能日-->
																</label>
																<div class="col-lg-8">
																	<div class=" form-inline">{{$finalCancling}}</div>
																</div>
															</div>
															<!--/form-row-->
														</div>
														<div class="col-md-6 pad_m7">
															<h4>
																{{ trans('booking_details.booking_details_title') }}
																<!--予約詳細-->
															</h4>
															<div class="form-row">
																<label class="col-lg-4 control-label">
																	{{ trans('booking_details.use_date') }}
																	<!--利用日-->
																	&nbsp;
																	<span class="require-mark">*</span>
																</label>
																<div class="col-lg-8">
																	<div class=" form-inline"><?php echo $rent_data->UsedDate?></div>
																	<!--/form-inline-->
																</div>
																<!--/col-lg-9-->
															</div>
															<!--/form-row-->
															<div class="form-row">
																<label class="col-lg-4 control-label">
																	{{ trans('booking_list.space_name') }}
																	<!--スペース名-->
																	&nbsp;
																</label>
																<div class="col-lg-8">
																	<div class=" form-inline">{!!$rent_data->bookedSpace->Title!!}</div>
																	<!--/form-inline-->
																</div>
																<!--/col-lg-9-->
															</div>
															<!--/form-row-->
															<div class="form-row">
																<label class="col-lg-4 control-label">
																	{{ trans('booking_details.space_type') }}
																	<!--スペースタイプ-->
																	&nbsp;
																</label>
																<div class="col-lg-8">
																	<div class=" form-inline">{!!$rent_data->bookedSpace->Type!!}</div>
																	<!--/form-inline-->
																</div>
																<!--/col-lg-9-->
															</div>
															<!--/form-row-->
															<div class="form-row">
																<label class="col-lg-4 control-label">
																	{{ trans('booking_details.use_people') }}
																	<!--利用人数-->
																	&nbsp;
																</label>
																<div class="col-lg-8">
																	<div class=" form-inline">{!!$rent_data->total_persons!!}人</div>
																	<!--/form-inline-->
																</div>
																<!--/col-lg-9-->
															</div>
															<!--/form-row-->
															<div class="form-row">
																<label class="col-lg-4 control-label">
																	{{ trans('booking_details.note') }}
																	<!--備考-->
																</label>
																<div class="col-lg-8">
																	<div class=" form-inline">{!!$rent_data->request!!}</div>
																	<!--/form-inline-->
																</div>
																<!--/col-lg-9-->
															</div>
															<!--/form-row-->
														</div>
														<div class="col-md-12 customer-info pad_m7">
															<h4>
																{{ trans('booking_details.customer_info') }}
																<!--予約者情報-->
															</h4>
															<!--start of if user2 has company name-->
															<?php if (userHasCompany($rent_data->rentUser)) {?>
															<div class="form-row">
																<label class="col-lg-3 control-label">
																	{{ trans('booking_details.company_name') }}
																	<!--会社名-->
																</label>
																<div class="col-lg-9">
																	<div class=" form-inline">
																		<div class="cus-info">
																			<a href="#" class="cus-link" target="_blank"> <?php echo getUserName($rent_data->rentUser)?> </a>
																		</div>
																	</div>
																	<!--/form-inline-->
																</div>
																<!--/col-lg-9-->
															</div>
															<!--/form-row-->
															<!--/end of if user2 has company name-->
															<?php }?>
															<!--/end of if user2 has company name-->
															<div class="form-row">
																<label class="col-lg-3 control-label">
																	{{ trans('booking_details.name') }}
																	<!--氏名-->
																</label>
																<div class="col-lg-9">
																	<div class=" form-inline">
																		<div class="cus-info">{{$rent_data->rentUser->LastName}}{{$rent_data->rentUser->FirstName}}({{$rent_data->rentUser->LastNameKana}}{{$rent_data->rentUser->FirstNameKana}})</div>
																	</div>
																	<!--/form-inline-->
																</div>
																<!--/col-lg-9-->
															</div>
															<!--/form-row-->
															<div class="form-row">
																<label class="col-lg-3 control-label">
																	{{ trans('booking_details.address') }}
																	<!--住所-->
																</label>
																<div class="col-lg-9">
																	<div class="form-inline">
																		<div class="cus-info">
																			{{$rent_data->rentUser->PostalCode}}
																			<br />
																			{{getUserAddress($rent_data->rentUser)}}
																		</div>
																	</div>
																	<!--/form-inline-->
																</div>
															</div>
															<!--/form-row-->
															<a href="#!" class="chat-link mb-none">
																{{ trans('booking_details.chat') }}
																<!--チャット-->
															</a>
															
															<a href="/ShareUser/Dashboard/Message/<?php echo $rent_data->rentUser->HashCode;?>" class="chat-link pc-none">
																{{ trans('booking_details.chat') }}
																<!--チャット-->
															</a>
														</div>
													</div>
													<div class="form-row bgry">
														<div class="table-responsive">
															<div class="ofsp-order-data-row ofso-book-edit-table">
																<!--start if payment is recurring-->
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
																<!--end if payment is recurring-->
																<div class="col-book clearfix">
																	<table class="col-md-6 book-details book-table calc-table no-border-table">
																		<tbody>
																			<tr class="total-amount-value ver-top pad-top20 no-btm-pad">
																				<th>
																					<h3>
																						<!--合計金額-->
																						{{ trans('booking_details.total_amount') }}
																					</h3>
																				</th>
																				<td>
																					<div class="lead text-right right-amount-1">
																						<span id="total_booking" class='total_booking-charged @if(isAllowShowRefund($rent_data)) strike @endif'>
																							<?php echo priceConvert($rent_data->amount, true);?>
																						</span>
																						@if(isAllowShowRefund($rent_data))
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
																					<p class="total-calc">
																						<span class="subtotal">
																							{{ trans('booking_details.subtotal') }}
																							<!--小計-->
																						</span>
																					</p>
																				</th>
																				<td>
																					<div class="lead text-right">
																						<span id="unit_total" class="price-value <?php if($rent_data->status==BOOKING_STATUS_REFUNDED): echo 'strike'; endif;?>" style="float: right">
																							<small>
																								<?php echo $subTotal;?>
																							</small>
																						</span>
																					</div>
																				</td>
																			</tr>
																			<tr class="no-pad">
																				<th>
																					<p class="other-fee">
																						{{ trans('booking_details.tax') }}
																						<!--消費税-->
																					</p>
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
																					<p class="other-fee">
																						{{ trans('booking_details.charge') }}
																						<!--手数料-->
																						(10%)
																					</p>
																				</th>
																				<td>
																					<div class="lead text-right">
																						<span id="margin_fee">
																							<small>
																								<?php echo "- " . $subTotalIncludeChargeFee?>
																							</small>
																						</span>
																					</div>
																				</td>
																			</tr>
																			@if( ($rent_data->status == 4 or $rent_data->status == 3) && !$rent_data->recur_id && isAllowShowRefund($rent_data)) 
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
																							<small><?php echo (getRefundPrice($rent_data, true, false));?></small>
																						</span>
																					</div>
																				</td>
																			</tr>
																			@endif
																		</tbody>
																	</table>
																</div>
																<!--/col-book-->
																<div class="ofsp-order-data-row ofsp-book-bulk-actions">
																	<p class="bulk-actions"></p>
																	<p class="add-book">
																</div>
																<span class='hide_edit_space hide_edit_total' style='display: none;'>
																	<div class="ofsp-order-data-row ofsp-book-add-list">
																		<a href='/ShareUser/Dashboard/EditBook/{!!$rent_data->id!!}' type="button" class="btn gry-btn cancel-action" data-reload="true">Cancel</a>
																		<button type="submit" class="btn button dylw-btn button-primary save-action saveBasicInfo">Save</button>
																	</div>
																</span>
															</div>
															<!--/table-responsive-->
														</div>
													</div>
													<!--
<h4>Other Details</h4>
<div class="form-row">
<label class="col-lg-3 control-label">People&nbsp;<span class="require-mark">*</span></label>
<div class="col-lg-9">
<div class=" form-inline">
<input type="text" name="people-use" value="1" class="form-control">
</div><!--/form-inline
</div>
</div>




<div class="form-row">
<label class="col-lg-3 control-label">Comments</label>
<div class="col-lg-9">
<div class=""><textarea name="comments0" id="comments0" cols="40" rows="5" class="form-control"></textarea></div>
</div>
</div><!--/form-row-->
					
					</form>
					<h4>
						{{ trans('booking_details.payment_info') }}
						<!--支払情報-->
						<!--Payment Details-->
					</h4>
					<div class="form-row">
						<label class="col-lg-3 control-label">
							{{ trans('booking_details.payment_status') }}
							<!--支払いステータス-->
						</label>
						<div class="col-lg-9">
							<div class="invoice-view-bt action-wrapper ns_action-wrap btn-group">
								<form action='/ShareUser/Dashboard/acceptPayment' method='post' >
									<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
										@if($rent_data->status==1)
										<button class="btn btn-mini btn-info btn-mini lnk-accept-payment" type="button">
											{{ trans('booking_details.pre-sale') }}
											<!--Pre-Sale-->
										</button>
										@else
											<?php echo getBookingPaymentStatus($rent_data, true);?>
										@endif
										<input type='hidden' name='t_id' value='{!!$rent_data->transaction_id!!}' />
										<input type='hidden' name='type' value='accept' />
										<input type='hidden' name='id' value='{!!$rent_data->id!!}' />
								
								</form>
								@if(($rent_data->status==1 || $rent_data->status==2) && ($rent_data->in_use==0))
								<button class="ns_btn ns_actions ns_align-center btn btn-mini btn-info dropdown-toggle" data-toggle="dropdown">
									<span class="ns_blue-arrow ns_down caret"></span>
									<div class="ns_clear"></div>
								</button>
								@endif @if($rent_data->in_use==0) @if(($rent_data->status==1 || $rent_data->status==2))
								<ul class="actions ns_actions dropdown-menu payment-action-{!!$rent_data->id!!}">
									@if($rent_data->status==2)
									<li>
										<form action='/ShareUser/Dashboard/acceptPayment' method='post' id="form_refund">
											<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
											<button class="ns_pad lnk-reject" type="button" style='padding: 12px; width: 100%;'>
												{{ trans('booking_list.refund_action') }}
												<!--Refund-->
											</button>
											<input type='hidden' name='t_id' value='{!!$rent_data->transaction_id!!}' />
											<input type='hidden' name='type' value='refund' />
											<input type='hidden' name='id' value='{!!$rent_data->id!!}' />
										</form>
									</li>
									@else
									<li>
										<form action='/ShareUser/Dashboard/acceptPayment' method='post' id="form_accept">
											<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
											<button class="ns_pad lnk-accept-payment" type="button" style='padding: 12px; width: 100%;'>{{ trans('booking_details.pre-sale') }}</button>
											<input type='hidden' name='t_id' value='{!!$rent_data->transaction_id!!}' />
											<input type='hidden' name='type' value='accept' />
											<input type='hidden' name='id' value='{!!$rent_data->id!!}' />
										</form>
									</li>
									<li>
										<form action='/ShareUser/Dashboard/acceptPayment' method='post' id="form_reject">
											<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
											<button class="ns_pad lnk-reject" type="button" style='padding: 12px; width: 100%;'>{{ trans('booking_list.reject_action') }}</button>
											<input type='hidden' name='t_id' value='{!!$rent_data->transaction_id!!}' />
											<input type='hidden' name='type' value='reject' />
											<input type='hidden' name='id' value='{!!$rent_data->id!!}' />
										</form>
									</li>
									@endif
								</ul>
								@endif @endif
							</div>
						</div>
					</div>
					<div class="form-row">
						<label class="col-lg-3 control-label">
							{{ trans('booking_details.payment_method') }}
							<!--決済方法-->
						</label>
						<div class="col-lg-9">
							<div class=" form-inline"><?php echo getPaymentMethod($rent_data)?></div>
							<!--/form-inline-->
						</div>
						<!--/col-lg-9-->
					</div>
					<!--/form-row-->
					<div class="form-row">
						<label class="col-lg-3 control-label">
							{{ trans('booking_details.transaction_id') }}
							<!--トランザクションID-->
							<!--Transaction ID-->
						</label>
						<div class="col-lg-9">
							<div class=" form-inline">{!!$rent_data->transaction_id!!}</div>
							<!--/form-inline-->
						</div>
						<!--/col-lg-9-->
					</div>
					<!--/form-row-->
					<div class="form-row">
						<label class="col-lg-3 control-label">
							{{ trans('booking_details.paid_date') }}
							<!--支払日-->
							<!--Payment Date-->
						</label>
						<div class="col-lg-9">
							<div class=" form-inline">{!!$rent_data->created_at!!}</div>
							<!--/form-inline-->
						</div>
						<!--/col-lg-9-->
					</div>
					<!--/form-row-->
				</div>
				<!--/panel-body-->
			</div>
			<!--/panel-default-->
		</div>
		<div class="col-md-3 right_sider">
			<div class="panel panel-default">
				<div class="side-head">
					<h4>予約メモ</h4>
				</div>
				<div class="panel-body">
					<?php if (count($bookingHistories)) {?>
					<ul class="booking_notes">
						<?php foreach ($bookingHistories as $indexHistory => $bookingHistory) {
		$bookingStatusType = 'Status';
		if (isset($bookingHistories[$indexHistory - 1])) {
			if ($bookingHistory->status == $bookingHistories[$indexHistory - 1]->status)
			{
				if ($bookingHistory->status == BOOKING_STATUS_REFUNDED)
				{
					if ($bookingHistory->refund_status == BOOKING_REFUND_CHARGE_50)
					{
						$bookingStatusType = 'Refund50%';
					}
					elseif ($bookingHistory->refund_status == BOOKING_REFUND_CHARGE_100) {
						$bookingStatusType = 'Refund100%';
					}
					else{
						$bookingStatusType = '0%';
					}
				}
			}
			else {
				$bookingStatusType = 'Status';
			}
		}
		?>
						<?php if ($bookingStatusType == 'Status') {?>
						<!--when booking status has changed-->
						<li class="note">
							<div class="note_content">
								<p>
									予約ステータスが
									<strong>{{getBookingStatus($bookingHistory)}}</strong>
									に変更されました。
								</p>
							</div>
							<p class="meta">
								<abbr class="exact-date" title="">{{renderJapaneseDate($bookingHistory->updated_at, true)}}に追加</abbr>
							</p>
						</li>
						<!--/when booking status has changed-->
						<!--when payment status has changed-->
						<li class="note">
							<div class="note_content">
								<p>
									支払いステータスが
									<strong>{{getBookingPaymentStatus($bookingHistory)}}</strong>
									に変更されました。
								</p>
							</div>
							<p class="meta">
								<abbr class="exact-date" title="">{{renderJapaneseDate($bookingHistory->updated_at, true)}}に追加</abbr>
							</p>
						</li>
						<!--/when payment status has changed-->
						<?php }?>
						<?php if ($bookingStatusType == 'Refund50') {?>
						<!--when payment is refunded 50%-->
						<li class="note">
							<div class="note_content">
								<p>Payment has redunded 50% {{priceConvert($bookingHistory->refund_amount, true)}}</p>
							</div>
							<p class="meta">
								<abbr class="exact-date" title="">{{renderJapaneseDate($bookingHistory->updated_at, true)}}に追加</abbr>
							</p>
						</li>
						<!--/when payment is refunded 50%-->
						<?php }?>
						<?php if ($bookingStatusType == 'Refund100') {?>
						<!--when payment is refunded 100%-->
						<li class="note">
							<div class="note_content">
								<p>Payment has redunded 100% {{priceConvert($bookingHistory->amount, true)}}</p>
							</div>
							<p class="meta">
								<abbr class="exact-date" title="">{{renderJapaneseDate($bookingHistory->updated_at, true)}}に追加</abbr>
							</p>
						</li>
						<!--/when payment is refunded 100%-->
						<?php }?>
						<?php }?>
					</ul>
					<?php }?>
				</div>
			</div>
		</div>
	</div>
	<!--/row-->
	</div>
	<!--/container-fluid-->
	</div>
	<!--/BookingDetails-->
    <!--footer-->
						@include('pages.dashboard_user1_footer')
						<!--/footer-->
	</div>
	<!--/#page-wrapper-->
	</div>
	</div>
	</div>
	<!--/main-container-->
	</div><!--/#containers-->
    
	</div>
	<!--/viewport-->
	<script>
	jQuery(function($) {
    	jQuery( "#tabs" ).tabs();
		
		jQuery( "#price" ).change(function() {
			price=jQuery(this).val();
			count='{!!$count!!}';
			days=jQuery('#count_days').val();
			jQuery('#sub_total').val(price*days);
			jQuery('.tax').html('¥'+price*days*0.08);
			jQuery('.total_amount').html('¥'+(parseInt(price*days)+parseInt(price*days*0.08)));
			jQuery('.sub_rec').html('¥'+(parseInt((price*2*0.08)+parseInt(((price*2*0.08)+(price*2))*0.10)+parseInt(price*2))));
			jQuery('.sub_rec1').html('¥'+(parseInt((price*0.08)+parseInt(((price*0.08)+parseInt(price))*0.10)+parseInt(price))));
			
		});
		
		jQuery( ".change-date" ).click(function() {
		  jQuery(".hide_edit_space").toggle();
		  jQuery(".show_edit_space").toggle();
		});
		
		jQuery( ".change-total" ).click(function() {
		  jQuery(".hide_edit_total").toggle();
		  jQuery(".show_edit_total").toggle();
		});

		jQuery('body').on('click', '.header_booking_button', function(){
			var formID = $($(this).attr('data-form'));
			formID.find('button').trigger('click');
		});
		

  	});
</script>
	<script>
	jQuery(".chat-link").click(function () {
			var sid="<?php echo $rent_data->rentUser->HashCode;?>";
		var name="{{$rent_data->rentUser->LastName}} {{$rent_data->rentUser->FirstName}}";
		var url='/ShareUser/Dashboard/GetInstantMessageUser/'+sid;
		if(jQuery("#msg_box_" + sid).length == 0) {
					jQuery.get(	url,
									function(data1) {
									jQuery(".msg-scroll").append(getChat(sid,name,data1,'user1',''));
									jQuery("#msg_box_" + sid +" .msg_body").scrollTop(jQuery("#msg_box_" + sid +" .msg_body")[0].scrollHeight);

							});
		}else{
			
			jQuery("#msg_box_" + sid).show();
			jQuery("#msg_box_" + sid + " .msg_wrap").show();
		}
		
		});						
</script>
	<div class="loader"></div>
	<style type="text/css">
.loader {
	z-index: 1000;
	top: 50%;
	left: 50%;
	position: fixed;
	display: none;
	border: 16px solid #f3f3f3;
	border-radius: 50%;
	border-top: 16px solid #3498db;
	width: 120px;
	height: 120px;
	-webkit-animation: spin 2s linear infinite;
	animation: spin 2s linear infinite;
}

@
-webkit-keyframes spin { 0% {
	-webkit-transform: rotate(0deg);
}

100%
{
-webkit-transform
:
 
rotate
(360deg);
 
}
}
@
keyframes spin { 0% {
	transform: rotate(0deg);
}
100%
{
transform
:
 
rotate
(360deg);
 
}
}
</style>
</body>
</html>
