<div>
	<div class="postbox">
		<h3 class="stats_range">
			<a href="#" download="report-month-2016-08-23.csv" class="export_csv" data-export="chart" data-xaxes="日付" data-exclude_series="2" data-groupby="day">CSVのエクスポート</a>
			<ul>
				<li class="">
					<a class="time_tab" href="javascript:void(0);" data-time="{{CURRENT_YEAR}}">年間</a>
				</li>
				<li class="">
					<a class="time_tab" href="javascript:void(0);" data-time="{{LAST_MONTH}}">先月</a>
				</li>
				<li class="active">
					<a class="time_tab" href="javascript:void(0);" data-time="{{THIS_MONTH}}">今月</a>
				</li>
				<li class="custom ">
					カスタム期間:&nbsp;&nbsp;
					<div>
						<input type="text" size="10" placeholder="yyyy-mm-dd" value="" name="start_date" class="range_datepicker from hasDatepicker">
						~&nbsp;&nbsp;<input type="text" size="10" placeholder="yyyy-mm-dd" value="" name="end_date" class="range_datepicker to hasDatepicker">
						<input type="button" class="submit_sales_range" value="表示">
					</div>
				</li>
			</ul>
		</h3>
		<table class="table table-striped table-bordered table-hover dataTable no-footer" id="dataTables-transfer" role="grid" aria-describedby="dataTables-example_info">
			<thead>
				<tr role="row">
				<th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-label="会社名: activate to sort column ascending" style="width: 239px;">ユーザーID #</th>
				<th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-label="予約数: activate to sort column ascending" style="width: 100px;">予約数</th>
					<th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-label="会社名: activate to sort column ascending" style="width: 139px;">銀行名</th>
					<th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-label="売上額: activate to sort column ascending" style="width: 139px;">売上金額</th>
					<th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-label="売上額: activate to sort column ascending" style="width: 139px;">ネット売上</th>
					<th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-label="売上額: activate to sort column ascending" style="width: 139px;">手数料売上</th>
					<th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-label="設定: activate to sort column ascending" style="width: 67px;">アクション</th>
				</tr>
			</thead>
			<tbody>
				@include('admin.sales.payment_transfer_table')
			</tbody>
		</table>
	</div>
	<!--/postbox-->
</div>
