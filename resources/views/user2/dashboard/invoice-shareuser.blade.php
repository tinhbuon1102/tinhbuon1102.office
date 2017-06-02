 @include('pages.header')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
<!--/head-->
<body class="mypage shareuser">
	<div class="viewport">
		@include('pages.header_nav_rentuser')
		<div class="main-container">
			<div id="main" class="container fixed-container">
				<div id="left-box">
					@include('user2.dashboard.left_nav')
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
											請求書一覧
										</h1>
									</div>
								</div>
							</div>
						</div>
						<!--/page-header-->
						<div class="container-fluid">
							<div class="panel panel-default">
								<div class="panel-body">
									<div class="invoice-list basic-inner-box wht-bg">
										<div id="example_wrapper"  class="dataTables_length wrapper_dataTables">
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
															])) . '" + (this.value ? "' . $paramConcat . 'filter_year=" + this.value : "")'
														]);
														
														if ( empty($_GET) || (count($_GET) == 1 && isset($_GET['filter_month'])) ) $paramConcat = '?';
														else $paramConcat = '&';
														
														echo Form::select('filter_month', @$rent_data_month, @$param['filter_month'], [
															'id' => 'filter_by_date',
															'placeholder' => trans('common.all_date'),
															'onchange' => 'location = "' . getFullUrl(Request::except([
																'filter_month',
																'page'
															])) . '" + (this.value ? "' . $paramConcat . 'filter_month=" + this.value : "")'
														]);
														?>
													</div>
											</div>
											<table class="table table-striped table-bordered dataTable">
												<thead>
													<tr role="row">
														<th class="sorting_asc th01 mb-none">請求書番号</th>
														<th class="sorting th02 mb-none">日付</th>
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
										foreach ( $invoices as $invoice )
										{
											$aFlexiblePrice = \App\Rentbookingsave::getInvoiceBookingPayment($invoice);
											
											if ( ! $invoice->bookedSpace ) continue;
											?>
										<tr role="row">
														<td class="sorting_1 mb-none">
															<a href="{{url('/RentUser/Dashboard/InvoiceList/Detail')}}/{{$invoice->InvoiceID}}">{{$invoice->InvoiceID}}</a>
														</td>
														<td class="mb-none">{{$invoice->charge_start_date}}</td>
														<!--<td><a href="{{getUser2ProfileUrl($invoice->rentUser)}}">{{getUserName($invoice->rentUser)}}</a></td>-->
														<td class="mb-none">{{$invoice->id}}</td>
														<td>{{$invoice->bookedSpace->Title}}</td>
														<td class="mb-none">{{$invoice->DurationText}}</td>
														<td>
															@if($invoice->status==BOOKING_STATUS_REFUNDED && $invoice->refund_status != BOOKING_REFUND_CHARGE_100)
															<span class="refund-fee default-fee">
																<label><?php echo getRefundTypeText($invoice)?></label>
																<br>
																<b>
													<?php
											if ( $invoice->refund_status == BOOKING_REFUND_CHARGE_50 ) echo priceConvert($invoice->amount + $invoice->ChargeFee - getRefundChargedPrice($invoice, $html = false, true), true);
											else echo priceConvert($invoice->amount - getRefundChargedPrice($invoice, $html = false, true), true)?>
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
															<a href="{{url('/RentUser/Dashboard/InvoiceList/Detail')}}/{{$invoice->InvoiceID}}" class="btn btn-primary btn-xs">詳細</a>
														</td>
													</tr>
										<?php
										}
										?>
										</tbody>
											</table>
										</div>
										<div class="pagenation-inner">
											<div class="ns_pagination">{{ $invoices->links() }}</div>
											<span class="result-amount">表示結果: {{$invoices->total()}}</span>
										</div>
									</div>
									<!--invoive-list-->
								</div>
							</div>
						</div>
						<!--/container-fluid-->
					</div>
					<!--footer-->
					@include('pages.dashboard_user2_footer')
					<!--/footer-->
				</div>
			</div>
		</div>
		<!--/main-container-->
		<!--footer-->
		<!--/footer-->
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
			  "order": [[ 1, "desc" ]],
			  "columnDefs": [ {
		          "targets": 'no-sort',
		          "orderable": false,
		       } ],
		       initComplete: function () {
		        	jQuery('.tablenav').prependTo("#DataTables_Table_0_wrapper");
		        },
		       <?php echo getDataTableTranslate()?>
					  
		  
		} );
  	});
    </script>
</body>
</html>
