
@include('pages.header')
<link rel="stylesheet" href="{{ URL::asset('js/chosen/chosen.css') }}">
<script src="{{ URL::asset('js/calendar/loadingoverlay.js') }}"></script>
<script>
	jQuery( document ).ready(function($) {
            

 
	@if($IsEdit=='True' || $IsDuplicate=='True')
		$('#prefecture').val("{{$space->Prefecture}}");
           
 $('#choose_per_type').val("{{$space->FeeType}}");
 $('#choose_type_of_office').val("{{$space->Type}}");
 $('#HourMinTerm').val("{{$space->HourMinTerm}}")
 $('#WeekMinTerm').val("{{$space->WeekMinTerm}}")
 $('#MonthMinTerm').val("{{$space->MonthMinTerm}}")  		
 $('#status').val("{{$space->status}}")  
 
 

 
	var i;
	for(i=1;i<8;i++)
	{			
		switch(i)
		{
			 case 1:
					if("{{$space->isClosedMonday}}" == "Yes")
					{
						$('input[name="isClosedMonday"]').attr('checked','checked');
						$('input[name="isClosedMonday"]').click();
					}
					if("{{$space->isOpen24Monday}}" == "Yes")
					{
						$('input[name="isOpen24Monday"]').attr('checked','checked');
						$('input[name="isOpen24Monday"]').click();
					}
				break;
			case 2:
					if("{{$space->isClosedTuesday}}" == "Yes")
					{
						$('input[name="isClosedTuesday"]').attr('checked','checked');
						$('input[name="isClosedTuesday"]').click();
					}
					if("{{$space->isOpen24Tuesday}}" == "Yes")
					{
						$('input[name="isOpen24Tuesday"]').attr('checked','checked');
						$('input[name="isOpen24Tuesday"]').click();
					}
				break;
			case 3:
					if("{{$space->isClosedWednesday}}" == "Yes")
					{
						$('input[name="isClosedWednesday"]').attr('checked','checked');
						$('input[name="isClosedWednesday"]').click();
					}
					if("{{$space->isOpen24Wednesday}}" == "Yes")
					{
						$('input[name="isOpen24Wednesday"]').attr('checked','checked');
						$('input[name="isOpen24Wednesday"]').click();
					}
				break;
			case 4:				
					if("{{$space->isClosedThursday}}" == "Yes")
					{
						$('input[name="isClosedThursday"]').attr('checked','checked');
						$('input[name="isClosedThursday"]').click();
					}
					if("{{$space->isOpen24Thursday}}" == "Yes")
					{
						$('input[name="isOpen24Thursday"]').attr('checked','checked');
						$('input[name="isOpen24Thursday"]').click();
					}
				break;
			case 5:
					if("{{$space->isClosedFriday}}" == "Yes")
					{
						$('input[name="isClosedFriday"]').attr('checked','checked');
						$('input[name="isClosedFriday"]').click();
					}
					if("{{$space->isOpen24Friday}}" == "Yes")
					{
						$('input[name="isOpen24Friday"]').attr('checked','checked');
						$('input[name="isOpen24Friday"]').click();
					}
				break;
			case 6:
					if("{{$space->isClosedSaturday}}" == "Yes")
					{
						$('input[name="isClosedSaturday"]').attr('checked','checked');
						$('input[name="isClosedSaturday"]').click();
					}
					if("{{$space->isOpen24Saturday}}" == "Yes")
					{
						$('input[name="isOpen24Saturday"]').attr('checked','checked');
						$('input[name="isOpen24Saturday"]').click();
					}
				break;
			case 7:
					if("{{$space->isClosedSunday}}" == "Yes")
					{
						$('input[name="isClosedSunday"]').attr('checked','checked');
						$('input[name="isClosedSunday"]').click();
					}
					if("{{$space->isOpen24Sunday}}" == "Yes")
					{
						$('input[name="isOpen24Sunday"]').attr('checked','checked');
						$('input[name="isOpen24Sunday"]').click();
					}
				break; 
		}
	}
	@endif
	@if(Auth::check() && Auth::user()->Prefecture && $IsEdit=='False')
		jQuery('#prefecture').val("{{Auth::user()->Prefecture}}");
	@endif
	});
	</script>
<!--/head-->

<body class="mypage shareuser editspace">
	<div class="viewport">
		<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header_nav_shareuser.php'); ?>
		@include('pages.header_nav_shareuser')
		<div class="main-container">
			<div id="main" class="container fixed-container">
				<div id="left-box">@include('user1.dashboard.left_nav')</div>
				<!--/leftbox-->
				<div class="right_side" id="samewidth">
					<div id="page-wrapper" class="has_fixed_title">
						@if($IsEdit=='True')
	<form id="shareinfo" data-spaceID="{{$space->id}}" name="ShareInfo" method="post" action="{{ url('ShareUser/ShareInfo/'.$space->HashID) }}" class="fl-form ">
@else
	<form id="shareinfo" data-spaceID="{{$space->id}}" name="ShareInfo" method="post" action="{{ url('ShareUser/ShareInfo') }}" class="fl-form ">
@endif
		<div class="page-header header-fixed">
			<div class="container-fluid">
				<div class="row">
					<div class="col-xs-6 col-md-6 col-sm-8 clearfix">
						<h1 class="pull-left">
							<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
							スペースを編集
						</h1>
						<div class="pull-left text-right">
							<a href="/ShareUser/Dashboard/MySpace/List1">
								<button class="btn btn-default mt15" type="button">
									<i class="fa fa-reply"></i>
									<span class="hidden-sm hidden-xs"> 一覧に戻る</span>
								</button>
							</a>
						</div>
					</div>
					<div class="col-xs-6 col-md-6 col-sm-4 clearfix pb15 text-right">
						<button id="saveBasicInfo" type="submit" class="btn btn-default mt15 dblk-button">
							<i class="fa fa-floppy-o"></i>
							<span class="hidden-sm hidden-xs"> 保存</span>
						</button>
						<button id="saveDraft" name="saveDraft" value="1" formnovalidate type="submit" class="btn btn-default mt15 dblk-button">
							<i class="fa fa-floppy-o"></i>
							<span class="hidden-sm hidden-xs"> 下書きで保存</span>
						</button>
						<button id="previewBasicInfo" type="button" class="btn btn-default mt15 dblk-button">
							<i class="fa fa-floppy-o"></i>
							<span class="hidden-sm hidden-xs"> プレビュー</span>
						</button>
					</div>
					<!--/col-xs-6-->
				</div>
			</div>
		</div>
		<div class="container-fluid">
			@if(session()->has('error'))
			<div class="alert alert-danger alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				{{ session()->get('error') }}
			</div>
			@endif
			@include('user1.dashboard.edit-space-form')
		</div>
	</form>
					</div>
                    <!--footer-->
				@include('pages.dashboard_user1_footer')

		<!--/footer-->
				</div>
                </div>
	<!--/#containers-->
			</div>
			<!--/viewport-->
</body>
</html>