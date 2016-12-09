@extends('adminLayout')
@section('head')
    <title>Payment Details</title>
@stop
@section('PageTitle')
	Payment Details
@stop
@section('Content')
	
	

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
			<div id="tab-4">@include('admin.sales.payment_tab_1')</div>
			<div id="tab-5">@include('admin.sales.payment_tab_2')</div>
			<div id="tab-6">@include('admin.sales.payment_tab_3')</div>
		</div>
		
	</div>
	<!-- /#page-wrapper -->

</div>

		<script>
			$(document).ready(function($) {
	$('#tabs_wraper').responsiveTabs({
		startCollapsed : 'accordion',
		collapsible : true,
		rotate : false,
		fluidHeight: true,
		click: function(event, tab){
			
		}
	});
});
		</script>
</body>
</html>
@stop