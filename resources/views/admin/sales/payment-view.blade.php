@extends('adminLayout') @section('head')
<title>Payment Details</title>
<link href="{{ URL::asset('js/calendar/datepicker/css/bootstrap-datepicker.css') }}" rel="stylesheet" />
<script src="{{ URL::asset('js/calendar/datepicker/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('js/calendar/datepicker/locales/bootstrap-datepicker.ja.min.js') }}"></script>
<script src="{{ URL::asset('js/calendar/loadingoverlay.js') }}"></script>
@stop @section('PageTitle') 売上 @stop @section('Content')
<div id="tabs_wraper">
	<ul>
		<li id="tab_button_1">
			<a href="#tab-4">ユーザー別売上</a>
		</li>
		<li id="tab_button_2">
			<a href="#tab-5">トータル売上</a>
		</li>
		<li id="tab_button_3">
			<a href="#tab-6">振り込みリスト</a>
		</li>
	</ul>
	<div id="tab-4" data-tab="user_sales">@include('admin.sales.payment_tab_1')</div>
	<div id="tab-5" data-tab="total_sales">@include('admin.sales.payment_tab_2')</div>
	<div id="tab-6" data-tab="transfer_list">@include('admin.sales.payment_tab_3')</div>
</div>
</div>
<!-- /#page-wrapper -->
</div>
<script>
$(document).ready(function($) {
	$('#tabs_wraper').responsiveTabs({
		rotate: false,
        startCollapsed: 'accordion',
        collapsible: 'accordion',
        setHash: true,
		activate: function(e, tab) {
			var selector = $(tab.selector);
			var tabHorizontalIndex = tab.id + 1;

			if (!$('#tab_button_' + tabHorizontalIndex).hasClass('r-tabs-state-active')) return;
			
			selector.css('opacity', 0);
			$.ajax({
				url : '/MyAdmin/Sales',
				data: {tab : selector.data('tab')},
				method: 'get',
				dataType: 'html',
				success : function(response){
					reloadDataTable(true);
					selector.html(response);
					reloadDataTable(false);
					selector.css('opacity', 1);
					renderDatePicker();
				},
				error: function(){
					selector.css('opacity', 1);
				}
			});
		 }
	});

	$('body').on('click', 'a.time_tab', function(){
		var time_tab = $(this);
		var tabSelector = time_tab.closest('.r-tabs-panel');
		$.ajax({
			url : '/MyAdmin/Sales',
			data: {filter_time : time_tab.data('time'), tab : tabSelector.data('tab')},
			method: 'get',
			dataType: 'html',
			success : function(response){
				time_tab.closest('ul').find('li').removeClass('active');
				time_tab.closest('li').addClass('active');
				if (tabSelector.data('tab') == 'total_sales')
				{
					tabSelector.find('.chart-sidebar').html(response);
				}
				else {
					reloadDataTable(true);
					$('.r-tabs-state-active table.table-striped tbody').html(response);
					reloadDataTable(false);
				}
			}
		});
	});

	$('body').on('click', '.submit_sales_range', function(){
		var time_tab = $(this);
		var tabSelector = time_tab.closest('.r-tabs-panel');
		$.ajax({
			url : '/MyAdmin/Sales',
			data: {start_date : $('input[name="start_date"]:visible').val(), end_date : $('input[name="end_date"]:visible').val(), tab : tabSelector.data('tab')},
			method: 'get',
			dataType: 'html',
			success : function(response){
				time_tab.closest('ul').find('li').removeClass('active');
				if (tabSelector.data('tab') == 'total_sales')
				{
					tabSelector.find('.chart-sidebar').html(response);
				}
				else {
					reloadDataTable(true);
					$('.r-tabs-state-active table.table-striped tbody').html(response);
					reloadDataTable(false);
				}
			}
		});
	});
	
	function reloadDataTable(isDestroy){
		if (!$('.loadingoverlay').length)
			$('#tabs_wraper').LoadingOverlay("show");
		$('table.table-striped:visible').each(function(){

			if (isDestroy) {
				var table = $(this).DataTable();
	        	table.destroy();
			}
			else {
				$(this).DataTable( {
		    		responsive: true,
		    		  paginate: true,
		    		  searching: true,
		    		  ordering: true,
		    		  "pageLength": 50,
		    		  "bInfo" : false,
		    		  "bPaginate": true,
		    		  "order": [[ 0, "desc" ]],
		    		  "columnDefs": [ {
		    	          "targets": 'no-sort',
		    	          "orderable": false,
		    	       } ],
		    	       <?php echo getDataTableTranslate()?>
		    	} );
			}
		});
		$('#tabs_wraper').LoadingOverlay("hide");
	}

	function renderDatePicker(){
		$('.hasDatepicker').datepicker({
			format: 'yyyy-mm-dd',
			language: "ja",
			weekStart: 1,
			todayHighlight: true,
			todayBtn: true,
			autoclose: true,
		})
	}

	renderDatePicker();
});
</script>
@stop
