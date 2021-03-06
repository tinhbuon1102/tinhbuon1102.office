<?php 
$count = count($rent_data->bookedSlots);
?>
@include('pages.header')
<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header.php'); ?>
<!--/head-->
<link rel="stylesheet" href="{{url('/')}}/js/chosen/chosen.min.css">
<link rel="stylesheet" type='text/css' href="<?php echo SITE_URL?>css/select2.min.css">
<body class="mypage">
	<div class="viewport">
		<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header_nav_rentuser.php'); ?>
		@include('pages.header_nav_rentuser')
		<div class="main-container">
			<div id="main" class="container fixed-container">
				<div id="left-box" class="col_3_5">@include('user2.dashboard.left_nav')</div>
				<!--/leftbox-->
				<div id="samewidth" class="right_side">
					<div id="page-wrapper" class="nofix">
						<div class="page-header header-fixed">
							<div class="container-fluid">
								<div class="row">
									<div class="col-xs-6 col-md-6 col-sm-8 clearfix">
										<h1 class="pull-left">
											<i class="fa fa-list-alt" aria-hidden="true"></i>
											予約詳細
										</h1>
									</div>
								</div>
							</div>
						</div>
						<!--/page-header header-fixed-->
						<div id="BookingDetails" class="container-fluid">
							<div class="container-fluid">
								<div class="row">
									<div class="col-md-9">
										<div class="panel panel-default">
											<div class="panel-body">
												<div class="col-book">
													<h2>予約番号 #{!!$rent_data->id!!}</h2>
													<div class="form-row">
														<div class="col-md-6 pad_m7">
															<h4>予約基本情報</h4>
                                                            
															<div class="side_list">
																<div class="label-list">予約日</div>
																<div class="list-content">
																	<div class=" form-inline">{!!$rent_data->created_at!!}</div>
																	<!--/form-inline-->
																</div>
																<!--/list-content-->
															</div>
															<!--side_list-->
                                                            <div class="side_list">
																<div class="label-list">予約状況</div>
																<div class="list-content">
																	<div class=" form-inline">
																		<?php echo getBookingStatus($rent_data, true)?>
																	</div>
																	<!--/form-inline-->
																</div>
																<!--/list-content-->
															</div>
															<!--side_list-->
															<div class="side_list">
																<div class="label-list">支払い状況</div>
																<div class="list-content">
																	<div class=" form-inline">
																		<?php echo getBookingPaymentStatus($rent_data, true)?>
																	</div>
																	<!--/form-inline-->
																</div>
																<!--/list-content-->
															</div>
															<!--side_list-->
															
															@if($rent_data->status==3 || $rent_data->status==4) @endif
															<div class="side_list">
																<div class="label-list">キャンセル可能日</div>
																<div class="list-content">
																	<div class=" form-inline">{!!$rent_data->finalCancel!!}</div>
																</div>
																<!--/list-content-->
																<!--Cancel button -->
													@if(($rent_data->status==1 || $rent_data->status==2) && ($rent_data->in_use==0)) @if($rent_data->status==1)
													<form action='/RentUser/Dashboard/cancelPayment' method='post'>
														<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
														<input type='hidden' name='t_id' value='{!!$rent_data->transaction_id!!}' />
														<input type='hidden' name='type' value='cancel' />
														<input type='hidden' name='id' value='{!!$rent_data->id!!}' />
														<input type='hidden' name='redirect_to' value='/RentUser/Dashboard/Reservation/View/{!!$rent_data->id!!}' />
														<button class="btn btn-mini btn-info btn-mini lnk-reject cancel_payment" type="button">キャンセル</button>
													</form>
													@endif @if($rent_data->status==2)
													<form action='/RentUser/Dashboard/cancelPayment' method='post'>
														<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
														<input type='hidden' name='t_id' value='{!!$rent_data->transaction_id!!}' />
														<input type='hidden' name='type' value='cancel' />
														<input type='hidden' name='id' value='{!!$rent_data->id!!}' />
														<input type='hidden' name='redirect_to' value='/RentUser/Dashboard/Reservation/View/{!!$rent_data->id!!}' />
														<button class="btn btn-mini btn-info btn-mini lnk-reject cancel_payment" type="button">キャンセル</button>
													</form>
													@endif @elseif($rent_data->in_use==1) キャンセル不可 @endif @if($rent_data->status==3) キャンセル済み @endif @if($rent_data->status==4) キャンセル済み @endif
													<!-- /Cancel button -->
															</div>
															<!--side_list-->
															
														
                                                        </div>
														<div class="col-md-6 pad_m7">
															<h4>予約詳細</h4>
															
                                                             <div class="side_list">
																<div class="label-list">利用開始日</div>
																<div class="list-content">
																	<div class=" form-inline">
																		<?php echo renderJapaneseDate($rent_data->charge_start_date)?>
																	</div>
																</div>
																<!--/list-content-->
															</div>
															<!--side_list-->
															<div  class="side_list">
																<div class="label-list">利用日</div>
																<div class="list-content">
																	<div class=" form-inline">
																		<?php echo $rent_data->UsedDate?>
																	</div>
																</div>
																<!--/list-content-->
															</div>
															<!--side_list-->
															<div class="side_list">
																<div class="label-list">期間</div>
																<div class="list-content">
																	<div class=" form-inline">{{$rent_data->DurationText}}</div>
																</div>
																<!--/col-lg-9-->
															</div>
															<!--side_list-->
															<div class="side_list">
																<div class="label-list">
																	スペース提供者
																	<!--Host Name-->
																</div>
																<div class="list-content">
																	<div class=" form-inline">{{$user1Obj->NameOfCompany}}</div>
																</div>
															</div>
															<!--/side_list-->
                                                            <a href="#!" class="chat-link mb-none">
																<i class="fa fa-commenting" aria-hidden="true"></i> {{ trans('common.Chat') }}
																<!--チャット-->
															</a>
															
															
															<a href="/RentUser/Dashboard/Message/<?php echo $user1Obj->HashCode;?>" class="chat-link pc-none">
																<i class="fa fa-commenting" aria-hidden="true"></i> {{ trans('common.Chat') }}
                                                                </a>
																<!--チャット-->
														</div>
													</div>
													<!--/form-row-->
												</div>
												<!--/col-book-->
												
												<div class="how-to-wraper">
													<?php if ($rent_data->bookedSpace->EnterDetails) {?>
													<div class="how-to-enter">
														<?php echo trans('common.How to enter')?> : {{$rent_data->bookedSpace->EnterDetails}}
													</div>
													<?php }?>
													
													<?php if ($rent_data->bookedSpace->ExitDetails) {?>
													<div class="how-to-exit">
														<?php echo trans('common.How to exit')?> : {{$rent_data->bookedSpace->ExitDetails}}
													</div>
													<?php }?>
												</div>
                                            </div>
											<!--/panel-body-->
										</div>
										<!--/panel-->
                                        <div class="panel panel-default">
											<div class="panel-body">
                                        
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
												<div class="col-book clearfix">
													<table class="col-md-6 book-details book-table calc-table no-border-table">
														<tbody>
															<?php if (isRecurring($rent_data)) {
																$firstPayment = round($rent_data->SubTotal + $rent_data->Tax + $rent_data->ChargeFee);
																$monthlyTotal = round(($firstPayment / BOOKING_MONTH_RECURSION_INITPAYMENT) * ($rent_data->Duration - BOOKING_MONTH_RECURSION_INITPAYMENT));
																$totalChargeFee = ($rent_data->ChargeFee / BOOKING_MONTH_RECURSION_INITPAYMENT) * $rent_data->Duration;
																$totalPayment = $firstPayment + $monthlyTotal;
															?>
															<tr class="total-amount-value ver-top pad-top20 no-btm-pad">
																<th>
																	<h3>合計金額</h3>
																</th>
																<td>
																	<div class="lead text-right right-amount-1">
																		<span id="total_booking" class='total_booking-charged @if(isAllowShowRefund($rent_data)) strike @endif'>
																			<?php echo priceConvert($totalPayment, true);?>
																		</span>
																		@if(isAllowShowRefund($rent_data))
																		<span id="total_booking" class='current_amount'>
																			<?php echo priceConvert(getRefundChargedPrice($rent_data, false, true), true)?>
																		</span>
																		@endif
																	</div>
																</td>
															</tr>
															<tr class="no-pad">
																<th>
																	<p class="total-calc">{{ trans('booking_details.First Payment') }}</p>
																</th>
																<td>
																	<div class="lead text-right">
																		<span id="unit_total" class="price-value" style="float: right">
																			<small>
																				<?php echo priceConvert($firstPayment, true);?>
																			</small>
																		</span>
																	</div>
																</td>
															</tr>
															<tr class="no-pad">
																<th>
																	<p class="other-fee">{{ trans('booking_details.Monthly Total Payment') }}</p>
																</th>
																<td>
																	<div class="lead text-right">
																		<span id="tax_fee">
																			<small>
																				<?php echo priceConvert($monthlyTotal, true);?>
																			</small>
																		</span>
																	</div>
																</td>
															</tr>
															<?php if (!isRecurring($rent_data)) {?>
															<tr class="no-pad">
																<th>
																	<p class="other-fee">手数料(10%)</p>
																</th>
																<td>
																	<div class="lead text-right">
																		<span id="margin_fee">
																			<small>
																				<?php echo $totalChargeFee?>
																			</small>
																		</span>
																	</div>
																</td>
															</tr>
															<?php }?>
															
															<?php }else {?>
															<tr class="total-amount-value ver-top pad-top20 no-btm-pad">
																<th>
																	<h3>合計金額</h3>
																</th>
																<td>
																	<div class="lead text-right right-amount-1">
																		<span id="total_booking" class='total_booking-charged @if(isAllowShowRefund($rent_data)) strike @endif'>
																			<?php echo $totalPrice?>
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
															<?php }?>
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
                                                <div class="col-book mgt-30">
                                                <h4>支払詳細</h4>
                                                <div class="form-row">
													<div class="col-md-12">
														<div class="side_list">
															<div class="label-list">支払方法:</div>
															<div class="list-content">@if($rent_data->transaction_id!='')クレジットカード @else ペイパル @endif</div>
														</div>
														<!--/side_list-->
													</div>
													<!--/col-detail-->
													<div class="col-md-12">
														<div class="side_list">
															<div class="label-list">トランザクションID:</div>
															<div class="list-content">{!!$rent_data->transaction_id!!}</div>
														</div>
														<!--/side_list-->
													</div>
													<!--/col-detail-->
													<div class="col-md-12">
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
                                                </div>
											<!--/panel-body-->
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
														<span class="space-name"><a href="{{getSpaceUrl($rent_data->getSpace->HashID)}}">{!!$rent_data->bookedSpace->Title!!}</a></span>
													</div>
                                                    <div class="col-detail">
														<div class="side_list">
															<div class="label-list">住所:</div>
															<div class="list-content">
                                                            {!!$rent_data->bookedSpace->PostalCode!!}<br/>
{!!$rent_data->bookedSpace->Prefecture!!}{!!$rent_data->bookedSpace->District!!}{!!$rent_data->bookedSpace->Address1!!}{!!$rent_data->bookedSpace->Address2!!}
                                                            
                                                            </div>
                                                            <div class="mgt-10">
                                                            <a target="_blank" class="gmap_link" href="https://www.google.co.jp/maps/place/{!!$rent_data->bookedSpace->Prefecture!!}{!!$rent_data->bookedSpace->District!!}{!!$rent_data->bookedSpace->Address1!!}"><i class="fa fa-map-marker" aria-hidden="true"></i> Google Mapで見る</a>
                                                            </div>
														</div>
														<!--/side_list-->
													</div>
													<!--/col-detail-->
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
											
										</div>
										<!--/panel-->
									</div>
								</div>
								<!--/row-->
							</div>
							<!--/container-fluid-->
						</div>
						<!--/container-fluid-->
						<!--footer-->
						@include('pages.dashboard_user1_footer')
						<!--/footer-->
					</div>
					<!--/page-wrapper-->
				</div>
				<!--/right_side-->
			</div>
		</div>
		<!--/main-container-->
	</div>
	<!--/viewport-->
	<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script> -->
	<script src="<?php echo SITE_URL?>js/chosen/chosen.jquery.min.js" type="text/javascript"></script>
	<script src="<?php echo SITE_URL?>js/chosen/chosen.proto.min.js" type="text/javascript"></script>
	<script src="<?php echo SITE_URL?>js/chosen/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?php echo SITE_URL?>js/address_select.js" type="text/javascript"></script>
	<script src="<?php echo SITE_URL?>js/select2.full.min.js"></script>
	<script type="text/javascript">
/*var config = {
      '.chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }*/

    
  </script>
	<script>
jQuery(function(){
    jQuery('#state-select').select2({
                    multiple:true
    });
    // 全ての駅名を非表示にする
    jQuery(".budget-price").addClass('hide');
    // 路線のプルダウンが変更されたら
    jQuery("#choose_budget_per").change(function(){
        // 全ての駅名を非表示にする
        jQuery(".budget-price").addClass('hide');
        // 選択された路線に連動した駅名プルダウンを表示する
        jQuery('#' + $("#choose_budget_per option:selected").attr("class")).removeClass("hide");
    });
})
jQuery(".input-container.iconbutton").click(function(){
  jQuery(this).toggleClass("checked");
});
</script>
<script>
	jQuery(".chat-link").click(function () {
			var sid="<?php echo $user1Obj->HashCode;?>";
		var name="{{$user1Obj->LastName}} {{$user1Obj->FirstName}}";
		var url='/RentUser/Dashboard/GetInstantMessageUser/'+sid;
		if(jQuery("#msg_box_" + sid).length == 0) {
					jQuery.get(	url,
									function(data1) {
									jQuery(".msg-scroll").append(getChat(sid,name,data1,'user2',''));
									jQuery("#msg_box_" + sid +" .msg_body").scrollTop(jQuery("#msg_box_" + sid +" .msg_body")[0].scrollHeight);

							});
		}else{
			
			jQuery("#msg_box_" + sid).show();
			jQuery("#msg_box_" + sid + " .msg_wrap").show();
		}
		
		});						
</script>
</body>
</html>
