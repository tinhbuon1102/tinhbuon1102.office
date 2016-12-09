<div class="container-fluid">
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="invoice-list basic-inner-box wht-bg">
				<table class="table table-striped table-bordered dataTable">
					<thead>
						<tr role="row">
							<th class="sorting_asc th01 mb-none">請求書番号</th>
							<th class="sorting th02">日付</th>
							<!--<th class="sorting th03">顧客名</th>-->
							<th class="sorting th04 mb-none">予約番号</th>
							<th class="sorting th05">利用スペース</th>
							<th class="sorting th06 mb-none">期間</th>
							<th class="sorting th07">金額</th>
							<th class="sorting th08 mb-none">ステータス</th>
							<th class="no-sort th09"></th>
						</tr>
					</thead>
					<tbody>
						<?php 
						foreach ($invoices as $invoice)
						{
							$aFlexiblePrice = \App\Rentbookingsave::getInvoiceBookingPayment($invoice);
								
							if (!$invoice->bookedSpace) continue;
							?>
						<tr role="row">
							<td class="sorting_1 mb-none">
								<a href="{{url('MyAdmin/RentUser/'. $user->HashCode .'/Invoice')}}/{{$invoice->InvoiceID}}">{{$invoice->InvoiceID}}</a>
							</td>
							<td>{{$invoice->created_at}}</td>
							<!--<td><a href="{{getUser2ProfileUrl($invoice->rentUser)}}">{{getUserName($invoice->rentUser)}}</a></td>-->
							<td class="mb-none">{{$invoice->id}}</td>
							<td>{{$invoice->bookedSpace->Title}}</td>
							<td class="mb-none">{{$invoice->DurationText}}</td>
							<td>
								@if($invoice->status==BOOKING_STATUS_REFUNDED && $invoice->refund_status != BOOKING_REFUND_CHARGE_100)
								<span class="refund-fee default-fee">
									<label>
										<?php echo getRefundTypeText($invoice)?>
									</label>
									<br>
									<b>
										<?php 
										if ($invoice->refund_status == BOOKING_REFUND_CHARGE_50)
											echo priceConvert($invoice->amount + $invoice->ChargeFee - getRefundChargedPrice($invoice, $html = false, true), true);
										else
											echo priceConvert($invoice->amount - getRefundChargedPrice($invoice, $html = false, true), true)
											?>
									</b>
								</span>
								@else
								<?php echo priceConvert($invoice->amount + $invoice->ChargeFee * 2, true);?>
								@endif
							</td>
							<td class="mb-none">
								<p class="btn btn-paypend-alt btn-xs">{{getBookingPaymentStatus($invoice)}}</p>
							</td>
							<td>
								<a href="{{url('MyAdmin/RentUser/'. $user->HashCode .'/Invoice')}}/{{$invoice->InvoiceID}}" class="btn btn-primary btn-xs">詳細</a>
							</td>
						</tr>
						<?php
						}
						?>
					</tbody>
				</table>
				<div class="rentuser-content-inner">
					<div class="ns_pagination">{{ $invoices->links() }}</div>
					<span class="result-amount">表示結果: {{$invoices->total()}}</span>
				</div>
			</div>
			<!--invoive-list-->
		</div>
	</div>
</div>
<script>
jQuery('table.dataTable').dataTable( {
	  paginate: true,
	  searching: true,
	  ordering: true,
	  "pageLength": 10,
	  "bInfo" : false,
	  "bPaginate": false,
	  "order": [[ 1, "desc" ]],
	  "columnDefs": [ {
        "targets": 'no-sort',
        "orderable": false,
     } ],
     <?php echo getDataTableTranslate()?>
			  

} );
});
						</script>