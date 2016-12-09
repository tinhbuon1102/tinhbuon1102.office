@extends('adminLayout') @section('head')
<title>シェアユーザー詳細</title>
<script src="{{ URL::asset('js/chosen/chosen.jquery.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('js/assets/custom_edit_form.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('js/jquery.validate.js?v=1') }}"></script>
<script src="{{ URL::asset('js/tag-it/js/tag-it.min.js') }}"></script>
<link href="{{ URL::asset('js/tag-it/css/jquery.tagit.css') }}" rel="stylesheet" type="text/css">
@stop @section('PageTitle') シェアユーザー詳細 @stop @section('Content')
<div id="tabs_wraper">@include('admin.shareuser.partial_tab_2_form')</div>
<script>
	$(document).ready(function($) {
	
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
