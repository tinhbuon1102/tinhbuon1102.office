<table class="book-details book-table no-border-table" id="booking_summary">
	<?php $count = count($aSlotIds);?>
	<tbody>
		<tr class="t-caption">
			<th colspan="2">予約詳細</th>
		</tr>
		<tr class="ver-top pad">
			<th>
				<h3>{!!$rent_data->spaceID->Title!!}</h3>
				<p>
					@if($rent_data->spaceID->FeeType!=1)利用開始日:
					<strong>{{renderJapaneseDate($rent_data->charge_start_date, false)}}</strong>
					@endif
					<br />
					利用タイプ:
					<strong>@if($rent_data->spaceID->FeeType==1) 時間毎 @elseif($rent_data->spaceID->FeeType==3) 週毎 @elseif($rent_data->spaceID->FeeType==4) 月毎 @else 日毎 @endif</strong>
					<br />
					@if($rent_data->spaceID->FeeType==1)利用時間: @else 利用期間: @endif
					<strong>
						<span><?php echo @$aBookingTimeInfoSelected['duration']?></span>
					</strong>
					@if($count>5 && $rent_data->spaceID->FeeType==4)
					<br />
					<strong>支払タイプ: 月払い </strong>
					@endif
				</p>
			</th>
			<td>
				<span class="pull-right lead text-center price-value subtotal_value">
					<?php echo $subTotal?>
				</span>
			</td>
		</tr>
	</tbody>
</table>
<!--start if recrusion-->
@if($count>5 && $rent_data->spaceID->FeeType==4)
<?php 
if($count>5 && $rent_data->spaceID->FeeType==4):
$months=2;
$sub_total_months=$months*$rent_data->spaceID->MonthFee;
endif;
echo renderBookingFor6Months($sub_total_months, $rent_data,$rent_data->charge_start_date,$count)?>
@endif
<table class="book-details book-table calc-table no-border-table">
	<tbody>
		@include('public.booking-total-table')
		<tr class="t-caption pd-top">
			<th colspan="2">備考</th>
		</tr>
		<tr class="no-pad">
			<td colspan="2">
				<div class="form-group">
					<textarea class="form-control" name="request">{!!$rent_data->request!!}</textarea>
					<div class="field-notice" rel="comments"></div>
				</div>
			</td>
		</tr>
	</tbody>
</table>
