@foreach($rent_datas as $rent)
<tr class="gradeX odd" role="row">
	<td><?php echo renderJapaneseDate($rent->created_at)?></td>
	<td>{{getUserName($rent->shareUser)}}</td>
	<td>
		<?php echo priceConvert($rent->total_amount, true)?>
	</td>
	<td>
		<a target="_blank" href="/MyAdmin/Sales?detail=1&id={{$rent->shareUser->id}}&tab=user_sales">詳細</a>
	</td>
</tr>
@endforeach
