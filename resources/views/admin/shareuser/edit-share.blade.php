@extends('adminLayout') @section('head')
<title>シェアユーザー詳細</title>
<script src="{{ URL::asset('js/chosen/chosen.jquery.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('js/assets/custom_edit_form.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('js/jquery.validate.js?v=1') }}"></script>
<script src="{{ URL::asset('js/assets/custom.js') }}" type="text/javascript"></script>
<style>
.modal1 {
	display: none;
	overflow: hidden;
	position: fixed;
	top: 0;
	right: 0;
	bottom: 0;
	left: 0;
	z-index: 1050;
	-webkit-overflow-scrolling: touch;
}

.modal-open .modal1 {
	overflow-x: hidden;
	overflow-y: auto;
}
</style>
@stop @section('PageTitle') シェアユーザー詳細 @stop @section('Content') 
<div class="error_wraper" style="margin-bottom: 20px;">
<?php renderErrorSuccessHtml($errors)?>
</div>
<div id="tabs_wraper" class="shareuser_edit">
	<ul>
		<li id="tab_button_1">
			<a href="#tab-1">基本情報</a>
		</li>
		<li id="tab_button_2">
			<a href="#tab-2">登録スペース</a>
		</li>
		<li id="tab_button_3">
			<a href="#tab-3">予約リスト</a>
		</li>
		<li id="tab_button_4">
			<a href="#tab-4">利用料売り上げ</a>
		</li>
		<li id="tab_button_5">
			<a href="#tab-5">確認書類</a>
		</li>
	</ul>
	<div id="tab-1"><?php //include (ROOT_PATH_FOLDER . '/admin/partial_tab_1.php');?>
					 @include('admin.shareuser.partial_tab_1')

			</div>
	<div id="tab-2"></div>
	<div id="tab-3"><?php //include (ROOT_PATH_FOLDER . '/admin/partial_tab_3.php');?>
				@include('admin.shareuser.partial_tab_3')

			</div>
	<div id="tab-4"><?php //include (ROOT_PATH_FOLDER . '/admin/partial_tab_4.php');?>
				@include('admin.shareuser.partial_tab_4')
			</div>
	<div id="tab-5"><?php //include (ROOT_PATH_FOLDER . '/admin/partial_tab_4.php');?>
				@include('admin.shareuser.partial_tab_5')
			</div>
</div>
<script>
		function getTab2()
		{
			$.get(
					'{{$user->HashCode}}/SpaceList',
					function(data) {
						$('#tab-2').html(data);
					}
					
				);
				
		}
			$(document).ready(function($) {
	$('#tabs_wraper').responsiveTabs({
		startCollapsed : 'accordion',
		collapsible : true,
		rotate : false,
		setHash: true,
		fluidHeight: true,
		click: function(event, tab){
			
		},
		activate: function(event, tab){
			if (tab.selector == '#tab-2' && !$('#tab-2').html())
			{
				$.get(
					'{{$user->HashCode}}/SpaceList',
					function(data) {
						$('#tab-2').html(data);
					}
					
				)
			}
			
			$('#tab2_wraper').show();
			$('#partial_tab_2_form_wraper').hide();
		}
	});
	
	$('body').on('click', '#cancelBasicInfo', function(){
		$('#tab2_wraper').show();
		$('#partial_tab_2_form_wraper').hide();
		$('html,body').animate({
	        scrollTop: $("#tab_button_2").offset().top},
	        'fast');
	})
	
});
		</script>
@stop
