@extends('adminLayout')
@section('head')
    <title>Space List</title>
@stop
@section('PageTitle')
	Space List
@stop
@section('Content')
		<div id="tabs_wraper">
			<ul>
				<li id="tab_button_1">
					<a href="#tab-1">Hourly Space</a>
				</li>
				<li id="tab_button_2">
					<a href="#tab-2">Daily Space</a>
				</li>
				<li id="tab_button_3">
					<a href="#tab-3">Weekly Space</a>
				</li>
				<li id="tab_button_4">
					<a href="#tab-4">Monthly Space</a>
				</li>
			</ul>
			<div id="tab-1">@include('admin.space.partial_tab_1')</div>
			<div id="tab-2">@include('admin.space.partial_tab_2')</div>
			<div id="tab-3">@include('admin.space.partial_tab_3')</div>
			<div id="tab-4">@include('admin.space.partial_tab_4')</div>
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
		 <script>
    $(document).ready(function() {
        $('.table-striped').DataTable({
                responsive: true,
                <?php echo getDataTableTranslate()?>
        });
    });
    </script>
		
@stop