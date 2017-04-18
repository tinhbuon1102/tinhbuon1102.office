@extends('adminLayout') @section('head')
<title>シェアユーザー詳細</title>
@section('Content') @if(session()->has('suc'))
<div class="alert alert-success alert-dismissable">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	{{ session()->get('suc') }}
</div>
@endif
<script src="<?php echo SITE_URL?>js/assets/custom.js"></script>
<?php 
$count = count($rent_data->bookedSlots);
?>
<?php $message = Session::get('success'); ?>
	@if( isset($message) )
	<div class="alert alert-success">{!! $message !!}</div>
	@endif
	
	@if((Session::has('error')) )
	<div class="alert alert-danger">{!! Session::get('error') !!}</div>
	@endif
<div class="right_side" id="samewidth">
					<form id="form" action='/ShareUser/Dashboard/EditBookSave/{!!$rent_data->id!!}' method='post'>
						<div class="">
							<div class="page-header ">
								<div class="container-fluid">
									<div class="row">
										<div class="col-xs-6 col-md-6 col-sm-8 clearfix">
											<h1 class="pull-left">
												<i class="fa fa-calendar-check-o"></i>
												{{ trans('booking_details.booking_details_title') }}
												<!--予約詳細-->
											</h1>
											<div class="pull-left text-right">
												<a href="/MyAdmin/ShareUser/<?php echo $rent_data->shareUser->HashCode?>#tab-3">
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
							<!--/page-headre-->
							<div id="BookingDetails">
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
								<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
								<div class="container-fluid">
									<div class="row">
										<div class="col-md-12">
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
															<?php 
															if (userHasCompany($rent_data->rentUser)) {?>
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
															<a href="#!" class="chat-link">
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
								<form action='/ShareUser/Dashboard/acceptPayment' method='post'>
									<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
									@if($rent_data->payment_method == 'paypal' && $rent_data->status==1)
									<button class="btn btn-mini btn-info btn-mini lnk-accept-payment" type="button">
										{{ trans('booking_details.pre-sale') }}
										<!--Pre-Sale-->
										</span>
										@else
										@if($rent_data->status==1)
										<button class="btn btn-mini btn-info btn-mini lnk-accept-payment" type="button">
											{{ trans('booking_details.pre-sale') }}
											<!--Pre-Sale-->
										</button>
										@else
											<?php echo getBookingPaymentStatus($rent_data, true);?>
										@endif 
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
									@if($rent_data->payment_method == 'paypal') 
										@if($rent_data->status == 2)
										<li>
											<div class='paypal-cover-{!!$rent_data->id!!}'>
												<button parent-container="{!!$rent_data->id!!}" class="paypal-refund " transid="{!!$rent_data->id!!}" style='padding: 12px;'>
													{{ trans('booking_list.refund_action') }}
													<!--Refund-->
												</button>
												<input type='hidden' name='t_id' id="refd-t_id-{!!$rent_data->id!!}" value='{!!$rent_data->transaction_id!!}' />
												<input type='hidden' name='id' id="refd-id-{!!$rent_data->id!!}" value='{!!$rent_data->id!!}' />
												<input type='hidden' name='type' class='type' value='refund' />
											</div>
										</li>
										@elseif($rent_data->status == 1)
										<li>
											<div class='paypal-cover-{!!$rent_data->id!!}'>
												<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
												<span class="ns_pad paypal-accept" type="submit" transid="{!!$rent_data->id!!}" style='padding: 12px; width: 100%;'>
													{{ trans('booking_details.accept') }}
													<!--Accept-->
												</span>
												<input type='hidden' name='t_id' id="t_id-{!!$rent_data->id!!}" value='{!!$rent_data->transaction_id!!}' />
												<input type='hidden' name='id' id="id-{!!$rent_data->id!!}" value='{!!$rent_data->id!!}' />
											</div>
										</li>
										<li>
											<div class='paypal-cover-{!!$rent_data->id!!}'>
												<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
												<span class="ns_pad paypal-reject" transid="{!!$rent_data->id!!}" style='padding: 12px; width: 100%;'>
													{{ trans('booking_list.reject_action') }}
													<!--Reject-->
												</span>
												<input type='hidden' name='t_id' id="t_id-{!!$rent_data->id!!}" value='{!!$rent_data->transaction_id!!}' />
												<input type='hidden' name='id' id="id-{!!$rent_data->id!!}" value='{!!$rent_data->id!!}' />
											</div>
										</li>
										@endif 
									@else @if($rent_data->status==2)
									<li>
										<form action='/ShareUser/Dashboard/acceptPayment' method='post'>
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
									@endif
									<li>
										<form action='/ShareUser/Dashboard/acceptPayment' method='post'>
											<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
											<button class="ns_pad lnk-accept-payment" type="button" style='padding: 12px; width: 100%;'>{{ trans('booking_details.pre-sale') }}</button>
											<input type='hidden' name='t_id' value='{!!$rent_data->transaction_id!!}' />
											<input type='hidden' name='type' value='accept' />
											<input type='hidden' name='id' value='{!!$rent_data->id!!}' />
										</form>
									</li>
									<li>
										<form action='/ShareUser/Dashboard/acceptPayment' method='post'>
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
							<div class=" form-inline">@if($rent_data->payment_method == 'paypal') Paypal @else Credit Card @endif</div>
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
<script>
	jQuery(function() {
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
		

  	});
        jQuery(document).ready(function () {
			
			jQuery.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': "{{ csrf_token() }}"
			}
		});	
																	
		
				
           
        
		
		
			
			jQuery(".paypal-refund").click(function () {
					var transid = jQuery(this).attr("transid");
					var t_id = jQuery("#refd-t_id-"+transid).val();
					var id = jQuery("#refd-id-"+transid).val();
			
					jQuery.ajax({
					type:"post",
					url:"<?php echo action('PaypalController@refundRequest');?>",
					data:{"id":id,"t_id":t_id , "action":"refund"},//"type":type,"payer_id":payer_id
					success:function( response ){
						data = jQuery.parseJSON(response);
						jQuery(".loader").hide();
						alert(data.message);
						//console.log("success send");
					},
					beforeSend:function(){
							jQuery(".loader").show();
							console.log("before send");
					}
					});
			});
			
			
			
			
			jQuery(".paypal-reject").click(function (){
					var transid = jQuery(this).attr("transid");
					var t_id = jQuery("#t_id-"+transid).val();
					//var type = dhis.find(".type").val();
					var id = jQuery("#id-"+transid).val();
					//var payer_id = dhis.find(".payer_id").val();
					
				jQuery.ajax({
					type:"post",
					url:"<?php echo action('PaypalController@rejectRequest');?>",
					data:{"id":id,"t_id":t_id , "action":"reject"},//"type":type,"payer_id":payer_id
					success:function( response ){
						data = jQuery.parseJSON(response);
						jQuery(".loader").hide();
						alert(data.message);
						//console.log("success send");
					},
					beforeSend:function(){
							jQuery(".loader").show();
							console.log("before send");
					}
				});
				return false;
			});
			
			jQuery(".paypal-accept").click(function (){
			
					var transid = jQuery(this).attr("transid");
					var t_id = jQuery("#t_id-"+transid).val();
					//var type = dhis.find(".type").val();
					var id = jQuery("#id-"+transid).val();
					//var payer_id = dhis.find(".payer_id").val();
					
				jQuery.ajax({
					type:"post",
					url:"<?php echo action('PaypalController@acceptPaymentRequest');?>",
					data:{"id":id,"t_id":t_id , "action":"accept"},//"type":type,"payer_id":payer_id
					success:function( response ){
						data = jQuery.parseJSON(response);
						jQuery(".loader").hide();
						alert(data.message);
						//console.log("success send");
					},
					beforeSend:function(){
							jQuery(".loader").show();
							console.log("before send");
					}
				});
				return false;
			});
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
@include('pages.footer_js') @stop
