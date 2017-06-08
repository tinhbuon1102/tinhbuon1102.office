<?php 
use App\Spaceslot;
?>
@include('pages.header')
<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header.php'); ?>
<!--/head-->
<link rel="stylesheet" href="{{url('/')}}/design/js/chosen/chosen.min.css">
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
											予約リスト
										</h1>
									</div>
								</div>
							</div>
						</div>
						<!--/page-header header-fixed-->
						<div class="container-fluid">
							@if (count($errors) > 0)
							<div class="alert alert-danger">
								<ul>
									@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
									@endforeach
								</ul>
							</div>
							@endif
							<?php 
							$request = new Request();
							$param = Request::all();
							$message = Session::get('success'); ?>
							@if( isset($message) )
							<div class="alert alert-success">{!! $message !!}</div>
							@endif
							<?php $error = Session::get('error'); ?>
							@if( isset($error) )
							<div class="alert alert-danger">{!! $error !!}</div>
							@endif
							<div class="panel panel-default">
								<div class="panel-body">
									<div class="table-responsive">
										<ul class="subsubsub">
											<li class="all">
												<a href="{{Request::fullUrlWithQuery(array('status' => 'all'))}}" class="{{@$param['status'] == 'all' || !isset($param['status']) ? 'current' : ''}}">
													{{ trans('common.all') }}
													<span class="count">({{count($allAvailDatas)}})</span>
												</a>
												|
											</li>
											<li class="wc-completed">
												<a class="{{@$param['status'] == BOOKING_STATUS_PENDING ? 'current' : ''}}" href="{{Request::fullUrlWithQuery(array('status' => BOOKING_STATUS_PENDING))}}">
													{{ trans('common.pending') }}
													<span class="count">({{count(@$rent_data_status[BOOKING_STATUS_PENDING])}})</span>
												</a>
												|
											</li>
											<li class="wc-completed">
												<a class="{{@$param['status'] == BOOKING_STATUS_RESERVED ? 'current' : ''}}" href="{{Request::fullUrlWithQuery(array('status' => BOOKING_STATUS_RESERVED))}}">
													{{ trans('common.reserved') }}
													<span class="count">({{count(@$rent_data_status[BOOKING_STATUS_RESERVED])}})</span>
												</a>
												|
											</li>
											<li class="wc-completed">
												<a class="{{@$param['status'] == BOOKING_STATUS_INUSE ? 'current' : ''}}" href="{{Request::fullUrlWithQuery(array('status' => BOOKING_STATUS_INUSE))}}">
													{{ trans('common.In-Use') }}
													<span class="count">({{count(@$rent_data_status[BOOKING_STATUS_INUSE])}})</span>
												</a>
												|
											</li>
											<li class="wc-completed">
												<a class="{{@$param['status'] == BOOKING_STATUS_COMPLETED ? 'current' : ''}}" href="{{Request::fullUrlWithQuery(array('status' => BOOKING_STATUS_COMPLETED))}}">
													{{ trans('common.completed') }}
													<span class="count">({{count(@$rent_data_status[BOOKING_STATUS_COMPLETED])}})</span>
												</a>
												|
											</li>
											<li class="wc-cancelled">
												<a class="{{@$param['status'] == BOOKING_STATUS_REFUNDED ? 'current' : ''}}" href="{{Request::fullUrlWithQuery(array('status' => BOOKING_STATUS_REFUNDED))}}">
													{{ trans('common.cancel') }}
													<span class="count">({{count(@$rent_data_status[BOOKING_STATUS_REFUNDED])}})</span>
												</a>
											</li>
										</ul>
										<div id="example_wrapper" class="dataTables_wrapper no-footer booking-list-table">
											<div class="dataTables_length wrapper_dataTables">
												<div class="tablenav top">
													<div class="alignleft actions">
														<?php 
														if (empty($_GET) || (count($_GET) == 1 && isset($_GET['filter_month'])))
															$paramConcat = '?';
														else
															$paramConcat = '&';
															
														echo Form::select('filter_month', 
														@$rent_data_month, 
														@$param['filter_month'], 
														['id' => 'filter_by_date', 'placeholder' => trans('common.all_date'), 
														'onchange' => 'location = "'. getFullUrl(Request::except(['filter_month'])) .'" + (this.value ? "'.$paramConcat.'filter_month=" + this.value : "")']);?>
													</div>
												</div>
												<table class="table table-striped table-bordered" id="example" cellspacing="0" width="100%">
													<thead>
														<tr role="row">
															<th class="sorting th-no">#</th>
															<th class="sorting th-space">スペース名</th>
															<th class="sorting_desc th-bdate mb-none">予約日</th>
															<th class="sorting_desc th-rdate mb-none">利用開始日</th>
															<th class="sorting th-duration mb-none">期間</th>
															<th class="sorting th-fee mb-none">金額</th>
															<th class="sorting th-payment mb-none">支払状況</th>
															<th class="sorting th-status">予約状況</th>
															<th class="sorting th-view"></th>
															<th class="sorting th-cancel mb-none">アクション</th>
														</tr>
													</thead>
													<tbody>
														@foreach($rent_datas as $rent) 
														<?php 
														$aFlexiblePrice = \App\Rentbookingsave::getInvoiceBookingPayment($rent);
														
														if (isRecurring($rent)) {
															$firstPayment = round($rent->SubTotal + $rent->Tax + $rent->ChargeFee);
															$monthlyFee = round($firstPayment / 2);
															$monthlyTotal = round(($firstPayment / BOOKING_MONTH_RECURSION_INITPAYMENT) * ($rent->Duration - BOOKING_MONTH_RECURSION_INITPAYMENT));
															$totalChargeFee = ($rent->ChargeFee / BOOKING_MONTH_RECURSION_INITPAYMENT) * $rent->Duration;
															$totalPayment = $firstPayment + $monthlyTotal;
															$rent->amount = $firstPayment;
															
														}
														
														?>
														<tr role="row" class="odd">
															<td tabindex="0">{!!$rent->id!!}</td>
															<td>{!!$rent->bookedSpace->Title!!}</td>
															<td class="sorting_1 mb-none">{!!$rent->created_at!!}</td>
															<td class="sorting_1 mb-none">
																<?php 
																$isDisplayTime = in_array($rent->SpaceType, array(SPACE_FEE_TYPE_HOURLY, SPACE_FEE_TYPE_DAYLY)) ? true  : false;
																echo renderJapaneseDate($rent->charge_start_date, $isDisplayTime)?>
															</td>
															<td class="mb-none">{{$rent->DurationText}}</td>
															<td class="mb-none">
																@if($rent->status==BOOKING_STATUS_REFUNDED)
																<p class="refund-fee default-fee">
																	<label><?php echo getRefundTypeText($rent)?></label>
																	<br>
																</p>
																@endif
																
																<p class='@if($rent->status==BOOKING_STATUS_REFUNDED) price_strike @endif'>
																	@if(isBookingRecursion($rent)) 
																		¥{{priceConvert($firstPayment)}}
																		<br />
																		月額 ¥{{$monthlyFee}} 
																	@else 
																		<span class="default-fee">
																			<b>¥{!!priceConvert(ceil($rent->amount))!!}</b> 
																		</span>
																	@endif
																</p>
																
																@if($rent->status==BOOKING_STATUS_REFUNDED)
																<p class="refund-fee default-fee">
																	<b> <?php echo getRefundPrice($rent, true, true)?></b>
																</p>
																@endif
																
															</td>
															<td class="mb-none">
																<?php echo getBookingPaymentStatus($rent, true)?>
															</td>
															<td>
																<?php echo getBookingStatus($rent, true)?>
															</td>
															<td>
																<a href="/RentUser/Dashboard/Reservation/View/{!!$rent->id!!}" class="btn btn-primary btn-xs">詳細</a>
															</td>
															<td class="mb-none">
																@if(($rent->status==1 || $rent->status==2) && ($rent->in_use==0)) @if($rent->status==1)
																<form action='/RentUser/Dashboard/cancelPayment' method='post'>
																	<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
																	<input type='hidden' name='t_id' value='{!!$rent->transaction_id!!}' />
																	<input type='hidden' name='type' value='cancel' />
																	<input type='hidden' name='id' value='{!!$rent->id!!}' />
																	<button class="btn btn-mini btn-info btn-mini lnk-reject cancel_payment" type="button">キャンセル</button>
																</form>
																@endif @if($rent->status==2)
																<form action='/RentUser/Dashboard/cancelPayment' method='post'>
																	<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
																	<input type='hidden' name='t_id' value='{!!$rent->transaction_id!!}' />
																	<input type='hidden' name='type' value='cancel' />
																	<input type='hidden' name='id' value='{!!$rent->id!!}' />
																	<button class="btn btn-mini btn-info btn-mini lnk-reject cancel_payment" type="button">キャンセル</button>
																</form>
																@endif @elseif($rent->in_use==1) キャンセル不可 @endif @if($rent->status==3) キャンセル済み @endif @if($rent->status==4) キャンセル済み @endif
															</td>
														</tr>
														@endforeach
													</tbody>
												</table>
											</div>
										</div>
									</div>
									<!--/panel-->
								</div>
							</div>
							<!--/container-fluid-->
						</div>
						<!--/#page-wrapper-->
						<!--footer-->
						@include('pages.dashboard_user1_footer')
						<!--/footer-->
					</div>
					<!--/right_side-->
				</div>
			</div>
			<!--/main-container-->
			<!--footer-->
			<!--/footer-->
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
		<script type='text/javascript'>
	jQuery(document).ready(function() {
    jQuery('#example').DataTable( {
        "order": [[ 0, "desc" ]],
        <?php echo getDataTableTranslate();?>
    });
	
	setTimeout( function(){
		jQuery('.tablenav').prependTo("#example_wrapper");
	}, 3000 );
} );
</script>
		<style>
#example_filter label {
	float: right
}

.dataTables_wrapper .dataTables_length {
	float: right;
	width: auto;
}

.tablenav,#example_filter {
	float: left;
}
</style>
</body>
</html>
