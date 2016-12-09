<?php 
use App\Spaceslot;
?>
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
	<?php $message = Session::get('success'); ?>
	@if( isset($message) )
	<div class="alert alert-success">{!! $message !!}</div>
	@endif
	
	@if((Session::has('error')) )
	<div class="alert alert-danger">{!! Session::get('error') !!}</div>
	@endif
	
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table table-striped table-bordered book-list-table" id="example" cellspacing="0" width="100%">
					<thead>
						<tr role="row">
							<th class="sorting_asc id_no">#</th>
							<th class="sorting cus_name">
								顧客名
								<!--Name-->
							</th>
							<th class="sorting sp_name">
								スペース名
								<!--Space Name-->
							</th>
							<th class="sorting book_date">
								予約日
								<!--Booking Date-->
							</th>
							<th class="sorting start_date">
								利用開始日
								<!--Start Date-->
							</th>
							<th class="sorting term_dur">
								期間
								<!--Duration-->
							</th>
							<th class="sorting total_amount">
								合計金額
								<!--Total-->
							</th>
							<th class="sorting pay_amount">
								支払い金額
								<!--Payment-->
							</th>
							<th class="sorting pay_status">
								支払状況
								<!--Payment status-->
							</th>
							<th class="sorting book_sts">
								予約状況
								<!--Status-->
							</th>
							<th class="sorting act_th">
								アクション
								<!--Action-->
							</th>
						</tr>
					</thead>
					<tbody>
						@foreach($rent_datas as $rent)
						<tr role="row">
							<td class="sorting_1">{!!$rent->id!!}</td>
							<td>@if(isset($rent->rentUser->FirstName)){{getUserName($rent->rentUser)}}@endif</td>
							<td>
								<a target="_blank" href="<?php echo getSpaceUrl($rent->bookedSpace->HashID)?>">{!!$rent->bookedSpace->Title!!}</a>
							</td>
							<td>
								<?php echo renderJapaneseDate($rent->created_at)?>
							</td>
							<td>
								<?php 
								$isDisplayTime = in_array($rent->SpaceType, array(SPACE_FEE_TYPE_HOURLY, SPACE_FEE_TYPE_DAYLY)) ? true  : false;
								echo renderJapaneseDate($rent->charge_start_date, $isDisplayTime)?>
							</td>
							</td>
							<td>
								{{$rent->DurationText}}
								<!--{{ trans('booking_list.'.$rent->DurationText) }}-->
							</td>
							<td class="rent-booking-blade">
								@if($rent->status==BOOKING_STATUS_REFUNDED && $rent->refund_status != BOOKING_REFUND_CHARGE_100)
								<span class="refund-fee default-fee">
									<label>
										<?php echo getRefundTypeText($rent)?>
									</label>
									<br>
									<b>
										<?php echo getRefundPrice($rent)?>
									</b>
								</span>
								@else
								<?php echo priceConvert($rent->amount, true);?>
								@endif
							</td>
							<td>
								<span class='@if($rent->status==BOOKING_STATUS_REFUNDED) strike @endif'>
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
										@endif
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
								<a href="/MyAdmin/ShareUser/Dashboard/EditBook/{!!$rent->id!!}" class="btn-detail">
									<button class="btn btn-primary btn-xs">詳細</button>
								</a>
<!-- 								&nbsp; -->
<!-- 								<a href="/ShareUser/Dashboard/EditBook/{!!$rent->id!!}?action=delete" class='delete-button btn-icon'> -->
<!-- 									<i class="fa fa-trash" aria-hidden="true"></i> -->
<!-- 								</a> -->
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
<script type='text/javascript'>
	jQuery(document).ready(function() {
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
        <?php echo getDataTableTranslate();?>
    });
} );


 
	
        jQuery(document).ready(function () {
			
			jQuery.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': "{{ csrf_token() }}"
			}
		});	
        });
  
</script>
<div class="loader"></div>
<style type="text/css">
.loader {
	z-index: 1000;
	top: 50%;
	left: 50%;
	position: absolute;
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
