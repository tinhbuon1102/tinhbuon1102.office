<?php if (isMonthlySpace($rent_data->spaceID) && (isRecurring($rent_data) || $rent_data->Duration >= 6)) {
	if (isRecurring($rent_data))
	{
		$firstPayment = round($rent_data->SubTotal + $rent_data->Tax + $rent_data->ChargeFee); 
		$monthlyTotal = round(($firstPayment / BOOKING_MONTH_RECURSION_INITPAYMENT) * ($rent_data->Duration - BOOKING_MONTH_RECURSION_INITPAYMENT)); 
		$totalChargeFee = ($rent_data->ChargeFee / BOOKING_MONTH_RECURSION_INITPAYMENT) * $rent_data->Duration;
		$totalPayment = $firstPayment + $monthlyTotal;
	}
	else {
		$firstPayment = round((($rent_data->SubTotal + $rent_data->Tax + $rent_data->ChargeFee) / $rent_data->Duration) * BOOKING_MONTH_RECURSION_INITPAYMENT);
		$monthlyTotal = round(($firstPayment / BOOKING_MONTH_RECURSION_INITPAYMENT) * ($rent_data->Duration - BOOKING_MONTH_RECURSION_INITPAYMENT));
		$totalChargeFee = $rent_data->ChargeFee;
		$totalPayment = $firstPayment + $monthlyTotal;
	}
?>
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
				<?php echo $totalPayment?>
			</span>
		</div>
	</td>
</tr>
<tr class="no-pad">
	<th>
		<p class="total-calc">
			<span class="subtotal">
				{{ trans('booking_details.First Payment') }}
				<!--小計-->
			</span>
		</p>
	</th>
	<td>
		<div class="lead text-right">
			<span id="unit_total" class="price-value <?php if($rent_data->status==BOOKING_STATUS_REFUNDED): echo 'strike'; endif;?>" style="float: right">
				<small>
					<?php echo priceConvert($firstPayment, true);?>
				</small>
			</span>
		</div>
	</td>
</tr>
<tr class="no-pad">
	<th>
		<p class="other-fee">
			{{ trans('booking_details.Monthly Total Payment') }}
			<!--消費税-->
		</p>
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
<?php if ((isRecurring($rent_data) || $rent_data->Duration >= 6) && false) {?>
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
					<?php echo "- " . priceConvert($totalChargeFee, true)?>
				</small>
			</span>
		</div>
	</td>
</tr>
<?php }?>
<?php } else {?>
	<tr class="total-amount-value ver-top pad-top20 no-btm-pad">
		<th>
			<h3>合計金額</h3>
		</th>
		<td>
			<div class="lead text-right">
				<span id="total_booking">
					<?php echo $totalPrice?>
				</span>
			</div>
		</td>
	</tr>
	<?php echo renderBookingSummary($rent_data->spaceID, $prices,$count)?>
	<tr class="no-pad">
		<th>
			<p class="total-calc">
				<span class="subtotal">小計</span>
			</p>
		</th>
		<td>
			<div class="lead text-right">
				<span id="unit_total" class="price-value subtotal_value1" style="float: right">
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
