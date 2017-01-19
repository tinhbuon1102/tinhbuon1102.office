
@include('pages.header')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
<!--/head-->
<body class="mypage shareuser invoice">
	<div class="viewport">
		@include('pages.header_nav_shareuser')
		<div class="main-container">
			<div id="main" class="container fixed-container">
				<div id="left-box">
					@include('user1.dashboard.left_nav')
					<!--/right-content-->
				</div>
				<!--/leftbox-->
				<div class="right_side" id="samewidth">
					<div id="page-wrapper" class="nofix">
						<div class="page-header header-fixed">
							<div class="container-fluid">
								<div class="row">
									<div class="col-xs-6 col-md-6 col-sm-8 clearfix">
										<h1 class="pull-left">
											<i class="fa fa-credit-card" aria-hidden="true"></i>
											支払い通知書一覧
										</h1>
									</div>
								</div>
							</div>
						</div>
						<!--/page-header-->
						<div class="container-fluid">
							<div class="panel panel-default">
                            <div class="panel-body">
								<div class="invoice-list basic-inner-box wht-bg dataTables_wrapper no-footer">
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
										foreach ($invoices as $invoice)
										{
											$aFlexiblePrice = \App\Rentbookingsave::getInvoiceBookingPayment($invoice);
											if (!$invoice->bookedSpace) continue;
										?>
										<tr role="row">
											<td class="sorting_1 mb-none">
												<a href="{{url('/ShareUser/Dashboard/InvoiceList/Detail')}}/{{$invoice->InvoiceID}}">{{$invoice->InvoiceID}}</a>
											</td>
											<td>{{$invoice->updated_at}}</td>
											<td><a href="{{getUser2ProfileUrl($invoice->rentUser)}}">{{getUserName($invoice->rentUser)}}</a></td>
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
													if ($invoice->refund_status == BOOKING_REFUND_CHARGE_50)
														echo priceConvert($invoice->amount - $invoice->ChargeFee - getRefundChargedPrice($invoice, $html = false, true), true);
													else
													echo priceConvert($invoice->amount - getRefundChargedPrice($invoice, $html = false, true), true)
													?>
													</b>
												</span>
												@else
													<?php echo priceConvert($invoice->amount, true);?>
												@endif
											</td>
											<td class="mb-none">
                                            @if($invoice->status==BOOKING_STATUS_REFUNDED && $invoice->refund_status != BOOKING_REFUND_CHARGE_100)
                                            <span class="btn ps-refund btn-mini">
                                            @elseif($invoice->status==BOOKING_STATUS_REFUNDED && $invoice->refund_status = BOOKING_REFUND_CHARGE_100)
                                            <span class="btn ps-refund btn-mini">
                                            @else
                                            <span class="btn accepted btn-mini">
                                            @endif
										    {{getBookingPaymentStatus($invoice)}}</span>
											</td>
											<td>
												<a href="{{url('/ShareUser/Dashboard/InvoiceList/Detail')}}/{{$invoice->InvoiceID}}" class="btn btn-primary btn-xs">詳細</a>
											</td>
										</tr>
										<?php
										}
										?>
										</tbody>
									</table>
									
									<div class="pagenation-inner">
                                    <div class="dataTables_info">表示結果: {{$invoices->total()}}件</div>
										<div class="dataTables_paginate paging_simple_numbers">{{ $invoices->links() }}</div>
			                        	
			                    	</div>
								</div>
								<!--invoive-list-->
                                </div>
							</div>
						</div>
						<!--/container-fluid-->
					</div>
                    <!--footer-->
				@include('pages.dashboard_user1_footer')

		<!--/footer-->
				</div>

			</div>
		</div>
		<!--/main-container-->
		</div><!--/#containers-->
	</div>
	<!--/viewport-->
	<script>
	jQuery(function() {
    	jQuery( "#tabs" ).tabs();

    	jQuery('table.dataTable').dataTable( {
			  paginate: true,
			  searching: true,
			  ordering: true,
			  "pageLength": 10,
			  "bInfo" : false,
			  "bPaginate": false,
			  "order": [[ 3, "desc" ]],
			  "columnDefs": [ {
		          "targets": 'no-sort',
		          "orderable": false,
		       } ],
		       <?php echo getDataTableTranslate()?>
					  
		  
		} );
  	});
    </script>
</body>
</html>
