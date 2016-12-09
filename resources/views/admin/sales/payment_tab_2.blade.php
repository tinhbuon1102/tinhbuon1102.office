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
				<li class="">
					<a class="time_tab" href="javascript:void(0);" data-time="{{LAST_WEEK}}">過去１週間</a>
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
		<div class="chart-sidebar">
			@include('admin.sales.payment_total_sales_table')
		</div>
	</div>
</div>
