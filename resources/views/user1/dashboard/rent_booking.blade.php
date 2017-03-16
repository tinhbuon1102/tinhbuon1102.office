<?php 
use App\Spaceslot;
?>
@include('pages.header')
<!--/head-->
<body class="mypage shareuser">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
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
					<div id="page-wrapper" class="nofix">
						<div class="page-header header-fixed">
							<div class="container-fluid">
								<div class="row">
									<div class="col-xs-6 col-md-6 col-sm-8 clearfix">
										<h1 class="pull-left">
											<i class="fa fa-calendar-check-o"></i>
											{{ trans('booking_list.booking_list') }}
											<!--予約一覧-->
										</h1>
									</div>
								</div>
							</div>
						</div>
						<!--/page-headre-->
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
							?>
							@if( (Session::has('success')) )
							<div class="alert alert-success">{!! Session::get('success') !!}</div>
							@endif
							
							@if( (Session::has('error')) )
							<div class="alert alert-danger">{!! Session::get('error') !!}</div>
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
                                        <div class="booking-list-table">
										<div class="tablenav top">
											<div class="alignleft actions">
												<?php 
													echo Form::select('filter_month', 
															@$rent_data_month, @$param['filter_month'], 
															['id' => 'filter_by_date', 
															'placeholder' => trans('common.all_date'), 
															'onchange' => 'location = "'. getFullUrl(Request::except(['filter_month'])) .'" + (this.value ? "&filter_month=" + this.value : "")']);?>
											</div>
										</div>
                                        
										<table class="table table-striped table-bordered book-list-table" id="example" cellspacing="0" width="100%">
											<thead>
												<tr role="row">
													<th class="sorting_asc id_no">#</th>
													<th class="sorting cus_name">
														{{ trans('booking_list.customer_name') }}
														<!--顧客名-->
													</th>
													<th class="sp_name mb-none">
														{{ trans('booking_list.space_name') }}
														<!--スペース名-->
													</th>
													<th class="sorting book_date mb-none">
														{{ trans('booking_list.booked_date') }}
														<!--予約日-->
													</th>
													<th class="sorting start_date mb-none">
														{{ trans('booking_list.startuse_date') }}
														<!--利用開始日-->
													</th>
													<th class="sorting term_dur mb-none">
														{{ trans('booking_list.duration') }}
														<!--期間-->
													</th>
													<th class="total_amount mb-none">
														{{ trans('booking_list.total_amount') }}
														<!--合計金額-->
													</th>
													<th class="pay_amount mb-none">
														{{ trans('booking_list.pay_price') }}
														<!--支払い金額-->
													</th>
													<th class="pay_status mb-none">
														{{ trans('booking_list.payment_status') }}
														<!--支払状況-->
													</th>
													<th class="book_sts">
														{{ trans('booking_list.booking_status') }}
														<!--予約状況-->
													</th>
													<th class="act_th">
														<span class="mb-none">{{ trans('booking_list.action') }}</span>
														<!--アクション-->
													</th>
												</tr>
											</thead>
											<tbody>
												@foreach($rent_datas as $rent) 
												<?php 
												$aFlexiblePrice = \App\Rentbookingsave::getInvoiceBookingPayment($rent);
												?>
												<tr role="row">
													<td class="sorting_1">{!!$rent->id!!}</td>
													<td>@if(isset($rent->rentUser->FirstName)){{getUserName($rent->rentUser)}}@endif</td>
													<td class="mb-none">
														<a target="_blank" href="<?php echo getSpaceUrl($rent->bookedSpace->HashID)?>">{!!$rent->bookedSpace->Title!!}</a>
													</td>
													<td class="mb-none"><?php echo renderJapaneseDate($rent->created_at)?></td>
													<td class="mb-none">
														<?php 
														$isDisplayTime = in_array($rent->SpaceType, array(SPACE_FEE_TYPE_HOURLY, SPACE_FEE_TYPE_DAYLY)) ? true  : false;
														echo renderJapaneseDate($rent->charge_start_date, $isDisplayTime)?></td>
													</td>
													<td class="mb-none">
														{{$rent->DurationText}}
														<!--{{ trans('booking_list.'.$rent->DurationText) }}-->
													</td>
													<td class="rent-booking-blade mb-none">
														@if($rent->status==BOOKING_STATUS_REFUNDED && $rent->refund_status != BOOKING_REFUND_CHARGE_100)
														<span class="refund-fee default-fee">
															<label><?php echo getRefundTypeText($rent)?></label>
															<br>
															<b> <?php echo getRefundPrice($rent)?></b>
														</span>
														@else
															<?php echo priceConvert($rent->amount, true);?>
														@endif
													</td>
													<td class="mb-none">
														<span class='@if($rent->status==BOOKING_STATUS_REFUNDED) strike @endif'>
															@if(isBookingRecursion($rent)) 
																¥{!!priceConvert(($rent['bookedSpace']['MonthFee']*2*0.08)+(($rent['bookedSpace']['MonthFee']*2*0.08)+($rent['bookedSpace']['MonthFee']*2))*0.10+$rent['bookedSpace']['MonthFee']*2)!!}
																<br />
																月額 ¥{!! priceConvert(($rent['bookedSpace']['MonthFee']*0.08)+(($rent['bookedSpace']['MonthFee']*0.08)+($rent['bookedSpace']['MonthFee']))*0.10+$rent['bookedSpace']['MonthFee'])!!} 
															@else 
																<span class="@if ($rent->status==BOOKING_STATUS_REFUNDED) refund-fee @endif default-fee">
																	<b>¥{!!priceConvert(ceil($rent->amount))!!}</b> 
																</span>
															@endif
														</span>
													</td>
													<td class="mb-none">
														<div class="invoice-view-bt action-wrapper ns_action-wrap btn-group">
															<form action='/ShareUser/Dashboard/acceptPayment' method='post'>
																<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
																<?php //echo get_webpay_payment_status($rent->transaction_id); ?>
																@if($rent->status==1)
																<button class="btn btn-mini btn-info btn-mini lnk-accept-payment" type="button">
																	仮売上
																	</span>
																	@elseif($rent->status==4)
																	<span class="btn ps-refund btn-mini">返金済</span>
																	@elseif($rent->status==3 && $rent->refund_status != BOOKING_REFUND_CHARGE_100)
																	<span class="btn ps-refund btn-mini">返金済</span>
																	@elseif($rent->status==3 && $rent->refund_status == BOOKING_REFUND_CHARGE_100)
																	<span class="btn ps-refund btn-mini">返金不可</span>
																	@else
																	<span class="btn accepted btn-mini">本売上</span>
																	@endif
																	<input type='hidden' name='t_id' value='{!!$rent->transaction_id!!}' />
																	<input type='hidden' name='type' value='accept' />
																	<input type='hidden' name='id' value='{!!$rent->id!!}' />
															
															</form>
															@if(( $rent->status==1 || $rent->status==2 ) && ( $rent->in_use == 0 ))
															<button class="ns_btn ns_actions ns_align-center btn btn-mini btn-info dropdown-toggle" data-toggle="dropdown">
																<span class="ns_blue-arrow ns_down caret"></span>
																<div class="ns_clear"></div>
															</button>
															@endif @if(($rent->status==1 || $rent->status==2) && ($rent->in_use==0))
															<ul class="actions ns_actions dropdown-menu">
																@if($rent->status==2)
																<li>
																	<form action='/ShareUser/Dashboard/acceptPayment' method='post'>
																		<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
																		<button parent-container="{!!$rent->id!!}" class="ns_pad lnk-reject action-button " type="button" style='padding: 12px; width: 100%;'>
																			{{ trans('booking_list.refund_action') }}
																			<!--返金処理-->
																		</button>
																		<input type='hidden' name='t_id' class='t_id' value='{!!$rent->transaction_id!!}' />
																		<input type='hidden' name='type' class='type' value='refund' />
																		<input type='hidden' name='id' class='id' value='{!!$rent->id!!}' />
																	</form>
																</li>
																@else
																<li>
																	<form action='/ShareUser/Dashboard/acceptPayment' method='post'>
																		<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
																		<button class="ns_pad lnk-accept-payment" type="button" style='padding: 12px; width: 100%;'>{{ trans('booking_details.pre-sale') }}</button>
																		<input type='hidden' name='t_id' value='{!!$rent->transaction_id!!}' />
																		<input type='hidden' name='type' value='accept' />
																		<input type='hidden' name='id' value='{!!$rent->id!!}' />
																	</form>
																</li>
																<li>
																	<form action='/ShareUser/Dashboard/acceptPayment' method='post'>
																		<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
																		<button class="ns_pad lnk-reject " type="button" style='padding: 12px; width: 100%;'>
																			{{ trans('booking_list.reject_action') }}
																			<!--受取拒否-->
																		</button>
																		<input type='hidden' name='t_id' value='{!!$rent->transaction_id!!}' />
																		<input type='hidden' name='type' value='reject' />
																		<input type='hidden' name='id' value='{!!$rent->id!!}' />
																	</form>
																</li>
																@endif
															</ul>
															@endif
														</div>
													</td>
													<td>
														@if($rent->status==2 && $rent->in_use == BOOKING_IN_USE)
														<p class="btn btn-reserved-alt btn-xs">
															{{ trans('booking_list.in_use') }}
															<!--利用中-->
														</p>
														@else @if($rent->status==1)
														<p class="btn btn-pending-alt btn-xs">
															{{ trans('booking_list.pending') }}
															<!--処理中-->
														</p>
														@endif @if($rent->status==2)
														<p class="btn btn-reserved-alt btn-xs">
															{{ trans('booking_list.reserved') }}
															<!--予約済み-->
														</p>
														@endif @if($rent->status==3)
														<p class="btn btn-cancel-alt btn-xs">
															{{ trans('booking_list.cancel') }}
															<!--キャンセル-->
														</p>
														@endif @if($rent->status==4)
														<p class="btn btn-cancel-alt btn-xs">
															{{ trans('booking_list.cancel') }}
															<!--キャンセル-->
														</p>
														@endif @if($rent->status==6)
														<p class="btn btn-success-alt btn-xs">
															{{ trans('booking_list.completed') }}
															<!--完了-->
														</p>
														@endif @endif
														</p>
													</td>
													<td>
														<a href="/ShareUser/Dashboard/EditBook/{!!$rent->id!!}" class="btn-detail">
															<button class="btn btn-primary btn-xs">
																<!--詳細-->
																{{ trans('booking_list.view') }}
															</button>
														</a>
														&nbsp;
														<!--<a href="/ShareUser/Dashboard/EditBook/{!!$rent->id!!}?action=delete" class='delete-button btn-icon'><i class="fa fa-trash" aria-hidden="true"></i></a>-->
													</td>
												</tr>
												@endforeach
											</tbody>
										</table>
										<div class="dashboard-pagination" id="dashboard-pagination">
											<div class="ns_pagination">{{ $rent_datas->links() }}</div>
										</div>
                                        </div>
									</div>
								</div>
							</div>
							<!--/panel-->
						</div>
					</div>
					<!--/#page-wrapper-->
					<!--footer-->
					@include('pages.dashboard_user1_footer')
					<!--/footer-->
				</div>
			</div>
		</div>
		<!--/main-container-->
        </div><!--/#containers-->
	</div>
	<!--/viewport-->
	<script type='text/javascript'>
	jQuery(document).ready(function($) {
		jQuery(".delete-button").click(function(){
    if(confirm("Are you sure you want to delete this?")){
       return true;
    }
    else{
        return false;
    }
});
    jQuery('#example').DataTable( {
        "order": [[ 0, "desc" ]],
        columnDefs: [ { orderable: false, targets: [2,6,7,8,9,10] }],
        'pageLength': 25,
        initComplete: function () {
        	jQuery('.tablenav').prependTo("#example_wrapper");
            this.api().columns().every( function (index) {
            	var column = this;
                if ([2].indexOf(index) != -1) {
                	var select = $('<div class="tablenav" style="clear: none;"><select class="filter_dropdown" style="border: 1px solid #E0E0E0; float: left; width: 150px; margin-left: 10px;"><option value="">フィルタ空間</option></select></div>')
                    .insertBefore( $('#example_wrapper #example_filter') );
                    select.find('select').on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
 
                column.data().unique().sort().each( function ( d, j ) {
                    var content = $(d).text() ? $(d).text() : d;
                    select.find('select').append( '<option value="'+content+'">'+content+'</option>' )
                } );
                }
            } );
        },
        <?php echo getDataTableTranslate();?>
    });
} );


</script>
<style type="text/css">
	@-webkit-keyframes spin {
	  0% { -webkit-transform: rotate(0deg); }
	  100% { -webkit-transform: rotate(360deg); }
	}

	@keyframes spin {
	  0% { transform: rotate(0deg); }
	  100% { transform: rotate(360deg); }
	}
	.dataTables_wrapper .dataTables_length {
		float: right;
		width: auto;
	}
	.tablenav, #example_filter {
		float: left;
		
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
