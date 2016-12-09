<tr>
<td>
<?php 
$setupAmount = (isset($recuData['api_txn_Response']['PAYMENTSTATUS']))?$recuData['api_txn_Response']['AMT']:'';?>

	<?php echo date('Y-m',strtotime($recuData['apiResponse']['PROFILESTARTDATE']));?>
</td>	
<td>
	{{$rent_data->item_name}} (2 Month Fees + 8% tax + 10% charge )
</td>

<?php 
//$db = $recuData['db'];
//$value = 0;//isset( $db->mc_amount1 )?$db->mc_amount1:0; 
#var_dump($value);
#exit;
?>

<td>&yen;<?php echo (isset($recuData['api_txn_Response']['AMT']))?$recuData['api_txn_Response']['AMT']:'';?></td>
<td><?php echo (isset($recuData['api_txn_Response']['PAYMENTSTATUS']))?$recuData['api_txn_Response']['PAYMENTSTATUS']:'';?></td>
</tr>

@if(isset($recuData['db']->history) && count($recuData['db']->history) > 0)
	@foreach($recuData['db']->history as $key => $payment)
		<tr>
				<td>
					{{$payment->payment_date}}
				</td>	
				<td>
					{{$payment->txn_id}} &nbsp;
					{{$payment->item_name}}
				</td>
				<td>&yen;{{$payment->mc_gross}}</td>
				<td>{{$payment->payment_status}}</td>
		</tr>
	@endforeach
@endif
