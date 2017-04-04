@foreach($rent_datas as $rent)
<?php if (!isset($rent->shareUser->bank) || !$rent->shareUser->bank->BankName) {
	$bankName = 'Not included';
}else {
	$bankName = $rent->shareUser->bank->BankName;
}

$params = array();
if (isset($_REQUEST['filter_time']) && $_REQUEST['filter_time'])
	$params['filter_time'] = $_REQUEST['filter_time'];
if (isset($_REQUEST['start_date']) && $_REQUEST['start_date'])
{
	$params['start_date'] = $_REQUEST['start_date'];
	$params['end_date'] = $_REQUEST['end_date'];
}
?>
	<tr class="gradeX odd" role="row">
		<td>#{{$rent->shareUser->id}}</td>
		<td>{{$bankName}}</td>
		<td>{{priceConvert($rent->total_amount, true)}}</td>
		<td>{{priceConvert($rent->total_amount - $rent->total_charge_fee, true)}}</td>
		<td>{{priceConvert($rent->total_charge_fee * 2, true)}}</td>
		<td>
			<a target="_blank" href="/MyAdmin/Sales?detail=1&id={{$rent->shareUser->id}}&tab=transfer_list<?php echo !empty($params) ? '&' . http_build_query($params) : ''?>">詳細</a>
		</td>
	</tr>
@endforeach
