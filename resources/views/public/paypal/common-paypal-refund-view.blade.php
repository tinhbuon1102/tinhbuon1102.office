@if($rent_data->refund_amount != '' && $rent_data->refund_amount > 0 )
		<tr class="no-pad red-tr">
			<th>
				<p class="other-fee">
					{{ trans('booking_details.refund') }}
					@if($rent_data->refund_amount == ceil($rent_data->amount))	
						(100%)
					@elseif(($rent_data->refund_amount)*2 == ceil($rent_data->amount))
						(50%)
					@endif
				</p>
			</th>
			<td>
				<div class="lead text-right">
					<span id="margin_fee"><small>- {{priceConvert($refundamount, true)}}</small></span>
				</div>
			</td>
		</tr>
	@elseif( $rent_data->status == 3 )
		<tr class="no-pad red-tr">
			<th>
			<p class="other-fee">{{ trans('booking_details.refund') }}
				@if($rent_data->refund_amount == $rent_data->amount)	
					(100%)
				@elseif(($rent_data->refund_amount)*2 == $rent_data->amount)
					(50%)
				@endif
			</p>
			</th>
			<td>
				<div class="lead text-right">
					<span id="margin_fee"><small>
					- {!! priceConvert(ceil($rent_data->amount), true) !!}
					</small>
					</span>
				</div>
			</td>
		</tr>
	@endif