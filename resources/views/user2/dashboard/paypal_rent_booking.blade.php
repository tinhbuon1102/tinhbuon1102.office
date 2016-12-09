<?php 
/***
*** user2
***/
	use App\Spaceslot;
?>
<tr role="row" class="odd paypal-booking" style="color:green">
		<td tabindex="0" class="booking-id">{!!$rent->id!!}</td>
		<td  class="booking-title">{!!$rent->bookedSpace->Title!!}</td>
		<td class="sorting_1 booking-time">{!!$rent->created_at!!}</td>
	<?php 
			$slots_data=\App\Bookedspaceslot::where('BookedID', $rent->id)->get(); 
	?>
		<td class="sorting_1 booking-start-date">
		<?php $count=0;$in_use=0?>
			@if($rent->bookedSpace->FeeType!=1)
				
						@foreach($slots_data as $slot)
							@if($slot->Type=='MonthlySpace')
								{{$rent->month_start_date}} <br/>
							@else	
								{!!$slot->StartDate!!} <br/>
							@endif
							@break;
							
						@endforeach 
				
						@foreach($slots_data as $slot)
								@if($slot->Type=='MonthlySpace')
									@if(date('Y-m',strtotime($slot->StartDate))==date('Y-m'))
										<?php $in_use=1;?>
									@endif
								@else	
									@if(date('Y-m-d',strtotime($slot->StartDate))==date('Y-m-d') || (Date('Y-m-d')>=date('Y-m-d',strtotime($slot->StartDate)) && Date('Y-m-d')<=date('Y-m-d',strtotime($slot->EndDate))))
										<?php $in_use=1;?>
									@endif
								@endif
								<?php $count++;?>
						@endforeach
			@else
		<?php 
			$dates=explode('-',$rent['hourly_time']);

			if(isset($dates[1]) && isset($dates[0])):
					$t11 = StrToTime ( trim($dates[0]));
					$t11_1=trim($dates[0]);
					$t11_date = StrToTime ($rent['hourly_time'].' '.$t11_1);
					
					$t21 = StrToTime (  trim($dates[1]));
					$t21_1 =  (  trim($dates[1]));
					$t21_date = StrToTime ($rent['hourly_time'].' '.$t21_1);
					$diff1 = $t11 - $t21;
					$hours1 = str_replace('-','',$diff1 / ( 60 * 60 ));
					$count=$hours1;
					
						if(strtotime(date('Y-m-d H:i'))>=$t11_date && strtotime(date('Y-m-d H:i'))<=$t21_date):
							$in_use=1;
						endif;
			else:
					$count=1;
			endif;										
	?>
	
				{!!$rent->hourly_date!!}
			@endif
		</td>
		<td class="booking-duration">
			@if($rent->bookedSpace->FeeType!=1)
				{!!$count!!} @if($rent->bookedSpace->FeeType==1)時間 @elseif($rent->bookedSpace->FeeType==3)週間 @elseif($rent->bookedSpace->FeeType==4)ヶ月 @else 日 @endif
			@else
				{!!$count!!}時間
			@endif
		</td>
		<td class="booking-amount">
			@if($rent->hourly_time>5 && $rent->bookedSpace->FeeType==4) 		¥{!!priceConvert(($rent['bookedSpace']['MonthFee']*2*0.08)+(($rent['bookedSpace']['MonthFee']*2*0.08)+($rent['bookedSpace']['MonthFee']*2))*0.10+$rent['bookedSpace']['MonthFee']*2)!!}
				<br/>
			月払い 
				¥{!! priceConvert(($rent['bookedSpace']['MonthFee']*0.08)+(($rent['bookedSpace']['MonthFee']*0.08)+($rent['bookedSpace']['MonthFee']))*0.10+$rent['bookedSpace']['MonthFee'])!!}
			@else
				¥{!!priceConvert($rent->amount)!!} 
			@endif
		</td>
			 <td>@if($rent->status==1) <p class="btn btn-pending-alt btn-xs">仮支払</p>
			@elseif($rent->status==2) <p class="btn btn-reserved-alt btn-xs">支払済</p>
			@elseif($rent->status==3) <p class="btn btn-success-alt btn-xs">返金済</p> 
			@elseif($rent->status==4) <p class="btn btn-cancel-alt btn-xs">受取拒否</p> 
			@else
			<p class="btn btn-cancel-alt btn-xs">本売上</p> 
			@endif
			
			</td>
			<td>
			@if($rent->status!=2)
			<?php $in_use=0;?>
		@endif
			@if($in_use==1) <p class="btn btn-reserved-alt btn-xs">利用中</p> @else @if($rent->status==1) <p class="btn btn-pending-alt btn-xs">処理中</p> @endif
			@if($rent->status==2) <p class="btn btn-reserved-alt btn-xs">予約済み</p> @endif
			@if($rent->status==3) <p class="btn btn-cancel-alt btn-xs">キャンセル</p> @endif
			@if($rent->status==4) <p class="btn btn-cancel-alt btn-xs">キャンセル</p>@endif
			@if($rent->status==6) <p class="btn btn-success-alt btn-xs">完了</p>
			@endif @endif</p></span></td>
		   
			
			<td><a href="/RentUser/Dashboard/Reservation/View/{!!$rent->id!!}" class="btn btn-primary btn-xs">詳細</a></td>
			<td>
			@if(($rent->status==1 || $rent->status==2) && ($in_use==0))
						@if($rent->status==1)
							 
								 <div class='paypal-cover-{!!$rent->id!!}'>
									<button parent-container="{!!$rent->id!!}"  class="ns_pad lnk-reject paypal-refund btn btn-mini btn-info btn-mini lnk-reject cancel_payment" type="submit" transid="{!!$rent->id!!}">キャンセル<!--返金処理--></button>
									<input type='hidden' name='t_id' id="refd-t_id-{!!$rent->id!!}" value='{!!$rent->transaction_id!!}' />
									<input type='hidden' name='id'  id="refd-id-{!!$rent->id!!}" value='{!!$rent->id!!}' />
									<input type='hidden' name='type' class='type' value='refund' />
								</div>
							
							<!---
							<form action='/RentUser/Dashboard/cancelPayment' method='post'>
								<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
								<button class="btn btn-mini btn-info btn-mini lnk-accept-payment cancel_payment" type="submit">キャンセル</button>
								<input type='hidden' name='t_id' value='{!!$rent->transaction_id!!}' />
								<input type='hidden' name='type' value='cancel' />
								<input type='hidden' name='id' value='{!!$rent->id!!}' />
							</form>
							----><!--Cancel-->	
						@endif
				@if($rent->status==2)
							<div class='paypal-cover-{!!$rent->id!!}'>
								<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
								<button class="ns_pad paypal-reject btn btn-mini btn-info btn-mini lnk-reject cancel_payment" type="submit" transid="{!!$rent->id!!}">
									キャンセル<!--受取拒否-->
								</button>
								<input type='hidden' name='t_id' id="t_id-{!!$rent->id!!}" value='{!!$rent->transaction_id!!}' />
								<input type='hidden' name='id'  id="id-{!!$rent->id!!}" value='{!!$rent->id!!}' />
							 </div>
							 <!---
							<form action='/RentUser/Dashboard/cancelPayment' method='post'>
								<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
								<button class="btn btn-mini btn-info btn-mini lnk-accept-payment cancel_payment" type="submit">キャンセル</button>
								<input type='hidden' name='t_id' value='{!!$rent->transaction_id!!}' />
								<input type='hidden' name='type' value='cancel' />
								<input type='hidden' name='id' value='{!!$rent->id!!}' />
							</form>
							---->
				@endif
			@elseif($in_use==1)
				利用中
			@endif
			
			@if($rent->status==3)
				キャンセル不可
			<!--no cancellation--->
			@endif
			@if($rent->status==4)
				キャンセル済み
			<!--Canceled--->	
			@endif
			</td>
	</tr>