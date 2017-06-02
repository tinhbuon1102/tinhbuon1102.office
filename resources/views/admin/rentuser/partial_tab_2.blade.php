<div class="panel panel-default">
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
	<?php $message = Session::get('success'); ?>
	@if( isset($message) )
	<div class="alert alert-success">{!! $message !!}</div>
	@endif
	<div class="table-responsive">
		<div id="example_wrapper" class="dataTables_wrapper no-footer">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="table-responsive">
						<ul class="subsubsub">
							<li class="all">
								<a href="{{Request::fullUrlWithQuery(array('status' => 'all'))}}" class="{{@$param['status'] == 'all' || !isset($param['status']) ? 'current' : ''}}#tab-2">
									{{ trans('common.all') }}
									<span class="count">({{count($allAvailDatas)}})</span>
								</a>
								|
							</li>
							<li class="wc-completed">
								<a class="{{@$param['status'] == BOOKING_STATUS_PENDING ? 'current' : ''}}" href="{{Request::fullUrlWithQuery(array('status' => BOOKING_STATUS_PENDING))}}#tab-2">
									{{ trans('common.pending') }}
									<span class="count">({{count(@$rent_data_status[BOOKING_STATUS_PENDING])}})</span>
								</a>
								|
							</li>
							<li class="wc-completed">
								<a class="{{@$param['status'] == BOOKING_STATUS_RESERVED ? 'current' : ''}}" href="{{Request::fullUrlWithQuery(array('status' => BOOKING_STATUS_RESERVED))}}#tab-2">
									{{ trans('common.reserved') }}
									<span class="count">({{count(@$rent_data_status[BOOKING_STATUS_RESERVED])}})</span>
								</a>
								|
							</li>
							<li class="wc-completed">
								<a class="{{@$param['status'] == BOOKING_STATUS_INUSE ? 'current' : ''}}" href="{{Request::fullUrlWithQuery(array('status' => BOOKING_STATUS_INUSE))}}#tab-2">
									{{ trans('common.In-Use') }}
									<span class="count">({{count(@$rent_data_status[BOOKING_STATUS_INUSE])}})</span>
								</a>
								|
							</li>
							<li class="wc-completed">
								<a class="{{@$param['status'] == BOOKING_STATUS_COMPLETED ? 'current' : ''}}" href="{{Request::fullUrlWithQuery(array('status' => BOOKING_STATUS_COMPLETED))}}#tab-2">
									{{ trans('common.completed') }}
									<span class="count">({{count(@$rent_data_status[BOOKING_STATUS_COMPLETED])}})</span>
								</a>
								|
							</li>
							<li class="wc-cancelled">
								<a class="{{@$param['status'] == BOOKING_STATUS_REFUNDED ? 'current' : ''}}" href="{{Request::fullUrlWithQuery(array('status' => BOOKING_STATUS_REFUNDED))}}#tab-2">
									{{ trans('common.cancel') }}
									<span class="count">({{count(@$rent_data_status[BOOKING_STATUS_REFUNDED])}})</span>
								</a>
							</li>
						</ul>
						<div id="example_wrapper" class="dataTables_wrapper no-footer">
							<div class="dataTables_length wrapper_dataTables">
								<div class="tablenav top">
									<div class="alignleft actions">
										<?php 
										if ( empty($_GET) || (count($_GET) == 1 && isset($_GET['filter_month'])) ) $paramConcat = '?';
										else $paramConcat = '&';
										
										echo Form::select('filter_month',
														@$rent_data_month,
														@$param['filter_month'],
														['id' => 'filter_by_date', 'placeholder' => trans('common.all_date'),
														'onchange' => 'location = "'. getFullUrl(Request::except(['filter_month'])) .'" + (this.value ? "&filter_month=" + this.value : "") + "#tab-2"']);?>
									</div>
								</div>
								<table class="table table-striped table-bordered" id="example" cellspacing="0" width="100%">
									<thead>
										<tr role="row">
											<th class="sorting th-no">予約番号</th>
											<th class="sorting th-space">スペース名</th>
											<th class="sorting_desc th-bdate">予約日</th>
											<th class="sorting_desc th-rdate">利用開始日</th>
											<th class="sorting th-duration">期間</th>
											<th class="sorting th-fee">金額</th>
											<th class="sorting th-payment">支払</th>
											<th class="sorting th-status">ステータス</th>
											<th class="sorting th-view"></th>
											<th class="sorting th-cancel"></th>
										</tr>
									</thead>
									<tbody>
										@foreach($rent_datas as $rent)
										<tr role="row" class="odd">
											<td tabindex="0">{!!$rent->id!!}</td>
											<td>{!!$rent->bookedSpace->Title!!}</td>
											<td class="sorting_1">{!!$rent->created_at!!}</td>
											<td class="sorting_1">
												<?php 
												$isDisplayTime = in_array($rent->SpaceType, array(SPACE_FEE_TYPE_HOURLY, SPACE_FEE_TYPE_DAYLY)) ? true  : false;
																echo renderJapaneseDate($rent->charge_start_date, $isDisplayTime)?>
											</td>
											</td>
											<td>{{$rent->DurationText}}</td>
											<td>
												<span>
													@if($rent->Duration>5 && $rent->bookedSpace->FeeType==4) ¥{!!priceConvert(($rent['bookedSpace']['MonthFee']*2*0.08)+(($rent['bookedSpace']['MonthFee']*2*0.08)+($rent['bookedSpace']['MonthFee']*2))*0.10+$rent['bookedSpace']['MonthFee']*2)!!}
													<br />
													月額 ¥{!! priceConvert(($rent['bookedSpace']['MonthFee']*0.08)+(($rent['bookedSpace']['MonthFee']*0.08)+($rent['bookedSpace']['MonthFee']))*0.10+$rent['bookedSpace']['MonthFee'])!!} @else
													<span class="@if ($rent->status==BOOKING_STATUS_REFUNDED) refund-fee @endif default-fee">
														<b>¥{!!priceConvert(ceil($rent->amount))!!}</b>
													</span>
													@endif
												</span>
											</td>
											<td>
												<?php echo getBookingPaymentStatus($rent, true)?>
											</td>
											<td>
												<?php echo getBookingStatus($rent, true)?>
											</td>
											<td>
												<a href="{{url('MyAdmin/RentUser')}}/{{$user->HashCode}}/Reservation/{!!$rent->id!!}" class="btn btn-primary btn-xs">詳細</a>
											</td>
											<td>
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
		</div>
	</div>
</div>
<!--/panel-->
<script>
	jQuery(function() {
		jQuery(document).ready(function() {
		    jQuery('#example').DataTable( {
		        "order": [[ 0, "desc" ]],
		        <?php echo getDataTableTranslate();?>
		    });
  	});
    </script>
