<?php
/**
 user1 profile section
**/ 
use App\Spaceslot;
	
?>

<tr role="row" class="paypal-row" style="color: green;">
			<td class="sorting_1">{!!$rent->id!!}</td>
			<td>
				@if(isset($rent->rentUser->FirstName))
					{{getUserName($rent->rentUser)}}
				@endif
				
			</td>
			
			<td>
				<a target="_blank" href="<?php echo getSpaceUrl($rent->bookedSpace->HashID)?>">{!!$rent->bookedSpace->Title!!}</a>
			</td>
			
			<td>
				{!!$rent->created_at!!}
			</td>
		<?php 
			$slots_id = explode(';',$rent['spaceslots_id']);
			$slots_data = \App\Bookedspaceslot::where('BookedID', $rent->id)->orderBy('StartDate','asc')->get(); ?>
			<td>
			<?php $count=0;$in_use =0;?>
			
				@if($rent->bookedSpace->FeeType!=1)
					@foreach($slots_data as $slot)
						@if($slot->Type=='MonthlySpace')
							{{renderCustomDate($slot->StartDate, true, true, false)}}
							<br/>
						@else	
							{!!$slot->StartDate!!}
							<br/>
						@endif
						@break;
					@endforeach 
					
					@foreach($slots_data as $slot)
						@if($slot->Type=='MonthlySpace')
							@if(date('Y-m',strtotime($slot->StartDate)) == date('Y-m'))
								<?php $in_use=1;?>
							@endif
						@else	
							@if(
								date('Y-m-d',strtotime($slot->StartDate))== date('Y-m-d') 
								|| 
								(
									Date("Y-m-d")>= date("Y-m-d" , strtotime( $slot->StartDate )) 
										&& 
									Date("Y-m-d") <= date( "Y-m-d",strtotime( $slot->EndDate )
									)))
								<?php $in_use=1; ?>
							@endif
						@endif
						<?php $count++;?>
					@endforeach
				@else
			<?php $dates = explode('-',$rent['hourly_time']);

					if(isset($dates[1]) && isset($dates[0])){
							$t11 = StrToTime ( trim($dates[0]));
							$t11_1=trim($dates[0]);
							$t11_date = StrToTime ($rent['hourly_time'].' '.$t11_1);
							$t21 = StrToTime (  trim($dates[1]));
							$t21_1 =  (  trim($dates[1]));
							$t21_date = StrToTime ($rent['hourly_time'].' '.$t21_1);
							$diff1 = $t11 - $t21;
							$hours1 = str_replace('-','',$diff1 / ( 60 * 60 ));
							$count=$hours1;
					}
					else{
							$count=1;
					}
					
					if(strtotime(date('Y-m-d H:i'))>=$t11_date && strtotime(date('Y-m-d H:i'))<=$t21_date){
						$in_use=1;
					}										
		?>
					{!!$rent->hourly_date!!}
				@endif
		</td>
		<td class="colmn-duration"> 
				@if($rent->bookedSpace->FeeType!=1)
					{!!$count!!} 
					@if($rent->bookedSpace->FeeType==1) 
						 {{ trans('booking_list.時間') }}
					@elseif($rent->bookedSpace->FeeType==3) 
						{{ trans('booking_list.週間') }} 
					@elseif($rent->bookedSpace->FeeType==4) 
						{{ trans('booking_list.ヶ月') }}  
					@else 
						{{ trans('booking_list.日') }} 
					@endif
				@else
					{!!$count!!}{{ trans('booking_list.時間') }}
				@endif
		</td>
		
		
		
		
    @if($rent->payment_method == 'paypal')
		<td class="rent-booking-blade total-amount paypal">
				@if( $rent->status == BOOKING_STATUS_REFUNDED)
					<span class="refund-fee default-fee">		
						@if($rent->refund_amount == ceil($rent->amount))	
								<label>(100%)</label><b>- &nbsp;&yen;{{$rent->refund_amount}}</b>
						@elseif( ($rent->refund_amount)*2 == ceil($rent->amount))
								¥{!!priceConvert(ceil($rent->amount))!!}
								<label>(50%)</label><br/><b>- &nbsp;&yen;{{$rent->refund_amount}}</b>	
						@else
								<b>&nbsp;&yen;{{$rent->amount}}</b>
						@endif
					</span>
					<br/>
				@else
					¥{!!priceConvert(ceil($rent->amount))!!}
				@endif
			<br>
		</td>
	@else	
		<td class="rent-booking-blade total-amount custom-{{$rent->payment_method}}">
				@if( $rent->status == BOOKING_STATUS_REFUNDED && $rent->refund_amount != 0)
					<span class="@if($rent->refund_amount==0) refund-fee  @endif default-fee">
						@if($rent->refund_amount == 0 )
							<label>100%</label><br/>
						@endif
				@endif 
					<b>¥{!!priceConvert(ceil($rent->amount))!!}</b>
				@if($rent->status==BOOKING_STATUS_REFUNDED)
					</span>
				@endif
			<br>
			
			@if($rent->refund_amount !=0 )
				<span class="refund-fee">
					<label>50%</label>
						<b>-¥{!!priceConvert(ceil($rent->refund_amount))!!}</b>
					</span>
			@endif
		</td>
	@endif	
		
		
		
		<td class="colmn-payment">
				<span class='@if($rent->status == BOOKING_STATUS_REFUNDED) strike @endif'>
					@if($rent->Duration > 5 && $rent->bookedSpace->FeeType == 4 )		¥{!!priceConvert(($rent['bookedSpace']['MonthFee']*2*0.08)+(($rent['bookedSpace']['MonthFee']*2*0.08)+($rent['bookedSpace']['MonthFee']*2))*0.10+$rent['bookedSpace']['MonthFee']*2)!!}
					<br/>
						月額 ¥{!!priceConvert(($rent['bookedSpace']['MonthFee']*0.08)+(($rent['bookedSpace']['MonthFee']*0.08)+($rent['bookedSpace']['MonthFee']))*0.10+$rent['bookedSpace']['MonthFee'])!!} 
					@else 
						@if ($rent->status == BOOKING_STATUS_REFUNDED)
						<span class="refund-fee default-fee">
							<b>¥{!!priceConvert(ceil($rent->amount))!!}</b> 
						</span>
						@else
							¥{!!priceConvert(ceil($rent->amount))!!}
						@endif
					@endif
				</span>
		</td>
		
		<td class="action-colmns">
			<div class="invoice-view-bt action-wrapper ns_action-wrap btn-group">
				<form action='/ShareUser/Dashboard/acceptPayment' method='post'>
					<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
				@if($rent->status==1)
					 <span>
					 <button class="btn btn-mini btn-info btn-mini lnk-accept-payment" type="submit">
					 {{ trans('booking_list.仮売上') }}
					 </span>
				@elseif($rent->status==4) 
					<span class="btn ps-rejected btn-mini">{{ trans('booking_list.受取拒否') }}</span> 
				@elseif($rent->status==3)
							@if( $rent->refund_amount == 0)
									<span class="btn ps-refund btn-mini">{{ trans('booking_list.non_refundable') }}</span>
							@else
									<span class="btn ps-refund btn-mini">{{ trans('booking_list.返金済') }}</span>
							@endif	
							<!---<span class="btn ps-refund btn-mini">{{ trans('booking_list.返金済') }}</span> -->
				@else 
					<span class="btn accepted btn-mini">{{ trans('booking_list.本売上') }}</span> 
				@endif
					<input type='hidden' name='t_id' value='{!!$rent->transaction_id!!}' />
					<input type='hidden' name='type' value='accept' />
					<input type='hidden' name='id' value='{!!$rent->id!!}' />
				</form>
				 
				@if(($rent->status==1 || $rent->status==2) && ($in_use==0))
					<button class="ns_btn ns_actions ns_align-center btn btn-mini btn-info dropdown-toggle" data-toggle="dropdown">
						<span class="ns_blue-arrow ns_down caret"></span>
						<div class="ns_clear"></div>
					</button>
				@endif
				
				@if(($rent->status==1 || $rent->status==2) && ($in_use==0))
					<ul class="actions ns_actions dropdown-menu">
					@if($rent->status == 2)
						<li>
							 <div class='paypal-cover-{!!$rent->id!!}'>
								<button parent-container="{!!$rent->id!!}"  class="ns_pad lnk-reject paypal-refund " type="submit" transid="{!!$rent->id!!}" 
								style='padding: 12px;width: 100%;'>{{ trans('booking_list.refund_action') }}<!--返金処理--></button>
								<input type='hidden' name='t_id' id="refd-t_id-{!!$rent->id!!}" value='{!!$rent->transaction_id!!}' />
								<input type='hidden' name='id'  id="refd-id-{!!$rent->id!!}" value='{!!$rent->id!!}' />
								<input type='hidden' name='type' class='type' value='refund' />
							</div>
						</li>
					@elseif($rent->status == 1)
						<li>
							 <div class='paypal-cover-{!!$rent->id!!}'>
								<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
								<button class="ns_pad paypal-accept" type="submit" transid="{!!$rent->id!!}" style='padding: 12px;width: 100%;'>
								{{ trans('booking_list.本売上') }}</button>
								<input type='hidden' name='t_id' id="t_id-{!!$rent->id!!}" value='{!!$rent->transaction_id!!}' />
								<input type='hidden' name='id'  id="id-{!!$rent->id!!}" value='{!!$rent->id!!}' />
							 </div>
						</li>
					 @endif
					 
					 <li>
							 <div class='paypal-cover-{!!$rent->id!!}'>
								<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
								<button class="ns_pad paypal-reject" type="submit" transid="{!!$rent->id!!}" style='padding: 12px;width: 100%;'>{{ trans('booking_list.reject_action') }}<!--受取拒否--></button>
								<input type='hidden' name='t_id' id="t_id-{!!$rent->id!!}" value='{!!$rent->transaction_id!!}' />
								<input type='hidden' name='id'  id="id-{!!$rent->id!!}" value='{!!$rent->id!!}' />
							 </div>
						</li>
						
					</ul>
				@endif
				</div>	 
		</td>
		
		<td class="booking-status">
			@if($rent->status !=2 )
				<?php $in_use=0;?>
			@endif

			@if($in_use==1) 
					<p class="btn btn-reserved-alt btn-xs">{{ trans('booking_list.in_use') }}<!--利用中--></p> 
			@else @if($rent->status==1)
					<p class="btn btn-pending-alt btn-xs">{{ trans('booking_list.pending') }}<!--処理中--></p> 
			@endif
			
			@if($rent->status==2) <p class="btn btn-reserved-alt btn-xs">{{ trans('booking_list.reserved') }}<!--予約済み--></p> @endif
			@if($rent->status==3) 
				<p class="btn btn-cancel-alt btn-xs">{{ trans('booking_list.cancel') }}<!--キャンセル--></p>
			@endif
			@if($rent->status==4) <p class="btn btn-cancel-alt btn-xs">{{ trans('booking_list.cancel') }}<!--キャンセル--></p>@endif
			@if($rent->status==6) <p class="btn btn-success-alt btn-xs">{{ trans('booking_list.completed') }}<!--完了--></p>
			@endif @endif</p>
		</td>
		
		
		<td>
			<a href="/ShareUser/Dashboard/EditBook/{!!$rent->id!!}" class="btn-detail">
				<button class="btn btn-primary btn-xs"><!--詳細-->{{ trans('booking_list.view') }}</button>
			</a>
			&nbsp;
			<!--<a href="/ShareUser/Dashboard/EditBook/{!!$rent->id!!}?action=delete" class='delete-button btn-icon'>
				<i class="fa fa-trash" aria-hidden="true"></i>
			</a>-->
		</td>
</tr>