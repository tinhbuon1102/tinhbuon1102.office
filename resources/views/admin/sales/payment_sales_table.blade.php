@foreach($rent_datas as $rent)
<tr class="gradeX odd" role="row">
	<td><a target="_blank" href="<?php echo getUser1ProfileUrl($rent->shareUser)?>">{{getUserName($rent->shareUser)}}</a></td>
	<td>{{$rent->count_booking}}</td>
	<td>
		<?php echo priceConvert($rent->total_amount, true)?>
	</td>
	<td>
		<?php 
		$params = array();
		if (isset($_REQUEST['filter_time']) && $_REQUEST['filter_time'])
			$params['filter_time'] = $_REQUEST['filter_time'];
		if (isset($_REQUEST['start_date']) && $_REQUEST['start_date'])
		{
			$params['start_date'] = $_REQUEST['start_date'];
			$params['end_date'] = $_REQUEST['end_date'];
		}
		?>
		<a target="_blank" href="/MyAdmin/Sales?detail=1&id={{$rent->shareUser->id}}&tab=user_sales<?php echo !empty($params) ? '&' . http_build_query($params) : ''?>">詳細</a>
	</td>
</tr>
@endforeach
