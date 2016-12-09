@foreach($rent_datas as $rent)
<?php if (!isset($rent->shareUser->bank) || !$rent->shareUser->bank->BankName) {
	$bankName = 'Not included';
}else {
	$bankName = $rent->shareUser->bank->BankName;
}
?>
	<tr class="gradeX odd" role="row">
		<td>#{{$rent->shareUser->id}}</td>
		<td>{{$bankName}}</td>
		<td>{{priceConvert($rent->total_amount, true)}}</td>
		<td>{{priceConvert($rent->total_amount - $rent->total_charge_fee, true)}}</td>
		<td>{{priceConvert($rent->total_charge_fee * 2, true)}}</td>
		<td>
			<a target="_blank" href="/MyAdmin/Sales?detail=1&id={{$rent->shareUser->id}}&tab=transfer_list">詳細</a>
		</td>
	</tr>
@endforeach
