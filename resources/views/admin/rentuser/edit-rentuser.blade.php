@extends('adminLayout')
@section('head')
    <title>レントユーザー詳細</title>
@stop
@section('PageTitle')
	レントユーザー詳細
@stop
@section('Content')
	
	


		@if(session()->has('suc'))
			<div class="alert alert-success alert-dismissable">
	            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				{{ session()->get('suc') }}
        	</div>

		@endif
		<script src="{{ URL::asset('js/chosen/chosen.jquery.js') }}" type="text/javascript"></script>
		<script src="{{ URL::asset('js/assets/custom_edit_form.js') }}" type="text/javascript"></script>
		<script src="{{ URL::asset('js/jquery.validate.js?v=1') }}"></script>
		<script src="{{ URL::asset('js/assets/custom.js') }}" type="text/javascript"></script>
		<div id="tabs_wraper">
			<ul>
				<li id="tab_button_1">
					<a href="#tab-1">基本情報</a>
				</li>
				<li id="tab_button_2">
					<a href="#tab-2">利用履歴<!--History--></a>
				</li>
				<li id="tab_button_3">
					<a href="#tab-3">請求書<!--Invoice--></a>
				</li>
				<li id="tab_button_4">
					<a href="#tab-4">本人確認書類</a>
				</li>
			</ul>
			<div id="tab-1">@include('admin.rentuser.partial_tab_1')</div>
			<div id="tab-2">@include('admin.rentuser.partial_tab_2')</div>
			<div id="tab-3">@include('admin.rentuser.partial_tab_3')</div>
			<div id="tab-4">@include('admin.rentuser.partial_tab_4')</div>
		</div>
		
		<script>
			$(document).ready(function($) {
	$('#tabs_wraper').responsiveTabs({
		startCollapsed : 'accordion',
		collapsible : true,
		rotate : false,
		setHash: true,
		fluidHeight: true,
		click: function(event, tab){
			
		}
	});
	
	
	
});
		</script>
		<script>
$ = jQuery.noConflict();
$(document).ready(function() {
	$('#BirthDay').val("{{$user->BirthDay}}");
	$('#BirthMonth').val("{{$user->BirthMonth}}");
	$('#BirthYear').val("{{$user->BirthYear}}");
	$('#Sex').val("{{$user->Sex}}");
	$('#BusinessType').val("{{$user->BusinessType}}");
	$('#UserType').val("{{$user->UserType}}");
});
</script>
@stop