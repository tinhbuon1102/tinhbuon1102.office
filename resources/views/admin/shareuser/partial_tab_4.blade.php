<div class="container-fluid">
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="invoice-list basic-inner-box wht-bg dataTables_wrapper no-footer">
				<div class="dataTables_length wrapper_dataTables">
					<div class="tablenav top">
						<div class="alignleft actions">
							<?php
							$request = new Request();
							$param = Request::all();
							
							if ( empty($_GET) || (count($_GET) >= 1 && isset($_GET['filter_year'])) ) $paramConcat = '?';
							else $paramConcat = '&';
							
							echo Form::select('filter_year', @$rent_data_year, @$param['filter_year'], [
								'id' => 'filter_by_year',
								'placeholder' => trans('common.all_year'),
								'onchange' => 'location = "' . getFullUrl(Request::except([
									'filter_year',
									'filter_month',
									'page'
								])) . '" + (this.value ? "' . $paramConcat . 'filter_year=" + this.value : "") + "#tab-4"'
							]);
							
							if ( empty($_GET) || (count($_GET) == 1 && isset($_GET['filter_month'])) ) $paramConcat = '?';
							else $paramConcat = '&';
							
							echo Form::select('filter_month', @$rent_data_month_invoice, @$param['filter_month'], [
								'id' => 'filter_by_date',
								'placeholder' => trans('common.all_date'),
								'onchange' => 'location = "' . getFullUrl(Request::except([
									'filter_month',
									'page'
								])) . '" + (this.value ? "' . $paramConcat . 'filter_month=" + this.value : "") + "#tab-4"'
							]);
							?>
						</div>
					</div>
					<table class="table table-striped table-bordered dataTable">
						<thead>
							<tr role="row">
								<th class="sorting_asc th01 mb-none">支払番号</th>
								<th class="sorting th02">予約日</th>
								<th class="sorting th03">顧客名</th>
								<th class="sorting th04 mb-none">予約番号</th>
								<th class="sorting th05 mb-none">スペース名</th>
								<th class="sorting th06 mb-none">期間</th>
								<th class="sorting th07">金額</th>
								<th class="sorting th08 mb-none">ステータス</th>
								<th class="no-sort th08"></th>
							</tr>
						</thead>
						<tbody>
		<?php
		foreach ( $invoices as $invoice )
		{
			$aFlexiblePrice = \App\Rentbookingsave::getInvoiceBookingPayment($invoice);
			if ( ! $invoice->bookedSpace ) continue;
			?>
		<tr role="row">
								<td class="sorting_1 mb-none">
									<a href="{{url('/MyAdmin/ShareUser/' .$invoice->shareUser->HashCode . '/Invoice/')}}/{{$invoice->InvoiceID}}">{{$invoice->InvoiceID}}</a>
								</td>
								<td class="mb-none">{{renderJapaneseDate($invoice->charge_start_date)}}</td>
								<td>
									<a href="{{getUser2ProfileUrl($invoice->rentUser)}}">{{getUserName($invoice->rentUser)}}</a>
								</td>
								<td class="mb-none">{{$invoice->id}}</td>
								<td class="mb-none">{{$invoice->bookedSpace->Title}}</td>
								<td class="mb-none">{{$invoice->DurationText}}</td>
								<td>
									@if($invoice->status==BOOKING_STATUS_REFUNDED && $invoice->refund_status != BOOKING_REFUND_CHARGE_100)
									<span class="refund-fee default-fee">
										<label><?php echo getRefundTypeText($invoice)?></label>
										<br>
										<b>
					<?php
			if ( $invoice->refund_status == BOOKING_REFUND_CHARGE_50 ) echo priceConvert($invoice->amount - $invoice->ChargeFee - getRefundChargedPrice($invoice, $html = false, true), true);
			else echo priceConvert($invoice->amount - getRefundChargedPrice($invoice, $html = false, true), true)?>
					</b>
									</span>
				@else
					<?php echo priceConvert($invoice->amount, true);?>
				@endif
			</td>
								<td class="mb-none">
									<p class="btn btn-paypend-alt btn-xs">{{getBookingPaymentStatus($invoice)}}</p>
								</td>
								<td>
									<a href="{{url('/MyAdmin/ShareUser/' .$invoice->shareUser->HashCode . '/Invoice/')}}/{{$invoice->InvoiceID}}" class="btn btn-primary btn-xs">詳細</a>
								</td>
							</tr>
		<?php
		}
		?>
		</tbody>
					</table>
				</div>
				<div class="pagenation-inner">
					<div class="dataTables_info">表示結果: {{$invoices->total()}}件</div>
					<div class="dataTables_paginate paging_simple_numbers">{{ $invoices->links() }}</div>
				</div>
			</div>
			<!--invoive-list-->
		</div>
	</div>
</div>
<!-- /.row -->
<script>
jQuery('table.dataTable').dataTable( {
	  paginate: true,
	  searching: true,
	  ordering: true,
	  "pageLength": 10,
	  "bInfo" : false,
	  "bPaginate": false,
	  "order": [[ 0, "desc" ]],
	  "columnDefs": [ {
        "targets": 'no-sort',
        "orderable": false,
     } ],
     initComplete: function () {
     	jQuery('#tab-4 .tablenav').prependTo("#DataTables_Table_0_wrapper");
     },
     <?php echo getDataTableTranslate()?>
			  

} );
					</script>