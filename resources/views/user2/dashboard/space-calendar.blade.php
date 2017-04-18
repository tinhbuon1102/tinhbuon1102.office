@include('pages.header')
<script src="{{ URL::asset('js/responsive-tabs/easyResponsiveTabs.js') }}"></script>
<script src="{{ URL::asset('js/jquery.responsiveTabs.js') }}"></script>
<link href="{{ URL::asset('js/responsive-tabs/easy-responsive-tabs.css') }}" rel='stylesheet' />
<link href="{{ URL::asset('js/calendar/calendar.css') }}" rel='stylesheet' />
<link href="{{ URL::asset('js/calendar/datepicker/css/bootstrap-datepicker.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('js/calendar/datepicker/css/timepicker.css') }}" rel="stylesheet" />
<script src="{{ URL::asset('js/calendar/lib/moment.min.js') }}"></script>
<script src="{{ URL::asset('js/calendar/calendar.js') }}"></script>
<script src="{{ URL::asset('js/calendar/lang-all.js') }}"></script>
<script src="{{ URL::asset('js/calendar/datepicker/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('js/calendar/datepicker/locales/bootstrap-datepicker.ja.min.js') }}"></script>
<script src="{{ URL::asset('js/calendar/datepicker/js/timepicker.min.js') }}"></script>
<script src="{{ URL::asset('js/calendar/datepicker/js/datepair.js') }}"></script>
<script src="{{ URL::asset('js/calendar/validator.js') }}"></script>
<script src="{{ URL::asset('js/calendar/loadingoverlay.js') }}"></script>
<script src="{{ URL::asset('js/assets/holiday.js') }}"></script>
<script src="{{ URL::asset('js/calendar/calendar-custom.js') }}"></script>
<!--/head-->
<body class="mypage rentuser calender rentuser_calendar">
	<div class="viewport">
		@include('pages.header_nav_rentuser')
		<div class="main-container">
			<div id="main" class="container fixed-container">
				<div id="left-box">@include('user2.dashboard.left_nav')</div>
				<div class="right_side" id="samewidth">
					<div id="page-wrapper" class="nofix">
						<div class="page-header header-fixed">
							<div class="container-fluid">
								<div class="row">
									<div class="col-xs-6 col-md-6 col-sm-8 clearfix">
										<h1 class="pull-left">
											<i class="fa fa-calendar-check-o" aria-hidden="true"></i>
											カレンダー
										</h1>
									</div>
									<div class="col-xs-6 col-md-6 col-sm-4 clearfix pb15 text-right"></div>
									<!--/col-xs-6-->
								</div>
							</div>
						</div>
						<!--/page-header header-fixed-->
						<div class="container-fluid">
							<div class="panel panel-default no-bgcolor">
								<div id="calendar_tabs_wraper" class="tab_style1">
						<?php
						$feeTypeArray = array(
							1 => '時間毎',
							2 => '日毎',
							3 => '週毎',
							4 => '月毎',
							5 => '日毎',
							6 => '週毎',
							7 => '月毎'
						);
						if ( count($groupedSpaces) )
						{
							$count = 1;
							echo '<ul id="space_calendar_tabs_horizontal">';
							foreach ( $groupedSpaces as $spaceType => $spaces )
							{
								echo '<li><a href="#tab-' . $count . '">' . $feeTypeArray[$spaceType] . '</a></li>';
								$count ++;
							}
							echo '</ul>';
							
							$count = 1;
							foreach ( $groupedSpaces as $spaceType => $spaces )
							{
								echo '<div id="tab-' . $count . '" class="calendar_horizontal_wraper">';
								echo '<ul class="resp-tabs-list main-calendar space_calendar_tabs" style="display: none;">';
								foreach ( $spaces as $index => $space )
								{
									$class = $space->isThisSpaceHasSlot ? '' : 'no-schedule';
									echo '<li class="' . $class . '" id="tab_calendar_' . $count . $index . '" data-spaceID="' . $space->id . '">
									<a title="' . $space->Title . '" href="#space_calendar_' . $count . $index . '">';
									echo str_limit($space->Title, 26, '...');
									echo '<br /> ID:' . $space->id; 
									#echo '<br /> Booked Date: '. renderJapaneseDate($space->BookedDate, true); 
									echo '</a></li>';
								}
								echo '</ul>';
								echo '<div class="resp-tabs-container main-calendar" id="space_calendar_content_wraper_' . $count . '">';
								foreach ( $spaces as $index => $space )
								{
									echo '<div class="space-calendar-content" id="space_calendar_' . $count . $index . '" data-spaceID="' . $space->id . '"></div>';
								}
								echo '</div>';
								echo '</div>';
								$count ++;
							}
						}
						else {
						?>
							<div class="no-result">データはありません</div>
						<?php
						}
						?>
					</div>
							</div>
						</div>
						<div class="space-calendar"></div>
					</div>
					<!--footer-->
					@include('pages.dashboard_user2_footer')
					<!--/footer-->
				</div>
			</div>
			<!--/#main-->
		</div>
		<!--/main-container-->
	</div>
	<!--/#containers-->
	</div>
	<!--/viewport-->
	<div class="remodal" id="booking_modal" data-remodal-options="hashTracking: false, closeOnOutsideClick: true">
		<button data-remodal-action="close" class="remodal-close"></button>
		<h1>予約内容</h1>
		<div id="booking_popup_content"></div>
		<button data-remodal-action="cancel" class="remodal-cancel">Close</button>
	</div>
</body>
</html>
