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
<body class="mypage shareuser calender">
	<div class="viewport">
		@include('pages.header_nav_shareuser')
		<div class="main-container">
			<div id="main" class="container fixed-container">
				<div id="left-box">@include('user1.dashboard.left_nav')</div>
				<div class="right_side" id="samewidth">
                <div id="page-wrapper" class="nofix">
                <div class="page-header header-fixed">
<div class="container-fluid">
<div class="row">
<div class="col-xs-6 col-md-6 col-sm-8 clearfix">
<h1 class="pull-left"><i class="fa fa-calendar-check-o" aria-hidden="true"></i> カレンダー</h1>
</div>
<div class="col-xs-6 col-md-6 col-sm-4 clearfix pb15 text-right">

</div><!--/col-xs-6-->
</div>
</div>
</div><!--/page-header header-fixed-->
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
					if (count($groupedSpaces)) {
						$count = 1;
						echo '<ul id="space_calendar_tabs_horizontal">';
						foreach ($groupedSpaces as $spaceType => $spaces)
						{
							echo '<li><a href="#tab-'.$count.'">'. $feeTypeArray[$spaceType].'</a></li>';
							$count ++;
						}
						echo '</ul>';
						
						$count = 1;
						foreach ($groupedSpaces as $spaceType => $spaces) {
							echo '<div id="tab-'.$count.'" class="calendar_horizontal_wraper">';
								echo '<ul class="resp-tabs-list main-calendar space_calendar_tabs">';
								foreach ($spaces as $index => $space) {
									$class = $space->isThisSpaceHasSlot ? '' : 'no-schedule';
									echo '<li class="'. $class .'" id="tab_calendar_'.$count.$index.'" data-spaceID="'.$space->id.'">
									<a title="'. $space->Title .'" href="#space_calendar_'.$count.$index.'">';
									echo str_limit($space->Title, 26, '...');
									echo '<br /> ID:'. $space->id .'</a>
									</li>';
								}
								echo '</ul>';
								echo '<div class="resp-tabs-container main-calendar" id="space_calendar_content_wraper_'.$count.'">';
								foreach ($spaces as $index => $space) {
									echo '<div class="space-calendar-content" id="space_calendar_'.$count.$index.'" data-spaceID="'.$space->id.'"></div>';
								}
								echo '</div>';
							echo '</div>';
							$count++;
						}
						
					}
					?>
					</div>
                    </div>
                    </div>

					<div class="space-calendar"></div>
                    </div>
                    <!--footer-->
				@include('pages.dashboard_user1_footer')

		<!--/footer-->
                    
				</div>
				
			</div>
			<!--/#main-->
		</div>
		<!--/main-container-->
        </div><!--/#containers-->
	</div>
	<!--/viewport-->

	<div class="bd-example">
		<div class="modal fade" id="bookingModal" tabindex="-1" role="dialog" aria-labelledby="bookingModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title" id="bookingModalLabel">予約可能日を設定</h4>
					</div>
					<div class="modal-body">
						<form id="booking_form" data-toggle="validator" role="form">
							<div class="form-group form-wraper-group year-group" id="booking_month_start_wraper" style="display: none">
								<label for="booking_month_start" class="form-control-label">利用開始月</label>
								<input type="text" id="booking_month_start" name="booking_month_start"  class="form-control date-control  hasDatepicker" data-error="Please fill out this field." required>
							</div>

							<div class="form-group form-wraper-group " id="booking_month_end_wraper" style="display: none">
								<label for="booking_month_end" class="form-control-label">利用終了月</label>
								<input type="text" id="booking_month_end" name="booking_month_end"  class="form-control date-control  hasDatepicker" data-error="Please fill out this field." required>
							</div>

							<div class="form-group form-wraper-group hour-group day-group week-group" id="booking_date_start_wraper" style="display: none">
								<label for="booking_date_start" class="form-control-label">利用開始時間</label>
								<input type="text" id="booking_date_start" name="booking_date_start"  class="form-control date-control  hasDatepicker" data-error="Please fill out this field." required>
							</div>

							<div class="form-group form-wraper-group week-group" id="booking_date_end_wraper" style="display: none">
								<label for="booking_date_end" class="form-control-label">利用終了時間</label>
								<input type="text" id="booking_date_end" name="booking_date_end"  class="form-control date-control" data-error="Please fill out this field." required>
							</div>

							<div class="row">
								<div class="col-xs-6">
									<div class="form-group form-wraper-group hour-group day-group" id="booking_time_start_wraper" style="display: none">
										<label for="booking_time_start" class="form-control-label">利用開始時間</label>
										<input type="text" id="booking_time_start" name="booking_time_start"  class="time start booking-time form-control hasTimepicker " data-error="Please fill out this field." required>
									</div>
								</div>
								<div class="col-xs-6">
									<div class="form-group form-wraper-group hour-group day-group" id="booking_time_end_wraper" style="display: none">
										<label for="booking_time_end" class="form-control-label">利用終了時間</label>
										<input type="text" id="booking_time_end" name="booking_time_end"  class="time end booking-time form-control hasTimepicker " data-error="Please fill out this field." required>
									</div>
								</div>
							</div>

							<div class="form-group" id="repeat_booking_wraper">
								<div class="form-wraper-group hourly-duration day-group week-group year-group" style="display: none">
									<div class="checkbox">
										<label>
											<input type="checkbox" id="repeat_checkox" value="1">
											この予約を繰り返します
										</label>
									</div>
								</div>
							</div>

							<div id="repeat_field_wraper" class="row repeat_field_wraper" style="display: none;">
								<div class="form-group form-wraper-group day-group hour-group year-group" id="booking_repeat_wraper" style="display: none">
									<div class="col-xs-3">
										<label for="booking_repeat_start" class="form-control-label">繰り返し期間</label>
									</div>
									<div class="col-xs-9">
										<div class="form-group form-wraper-group day-group hour-group year-group" id="booking_repeat_start_wraper" style="display: none">
											<input type="text" id="booking_repeat_start" name="booking_repeat_start" class="form-control date-control  hasDatepicker" data-error="Please fill out this field.">
											<span class="separator">~</span>
											<input type="text" id="booking_repeat_end" name="booking_repeat_end" class="form-control date-control  hasDatepicker" data-error="Please fill out this field.">
										</div>
									</div>
								</div>
							</div>

							<div id="repeat_number_wraper" class="row repeat_number_wraper" style="display: none;">
								<div class="col-xs-2">
									<span class="form-wraper-group week-group ">繰り返す</span>
								</div>
								<div class="col-xs-3">
									<input type="text" maxlength="2" class="form-control repeat-number" id="repeat_number" name="repeat-number" value="1">
								</div>
								<div class="col-xs-2">
									<span class="form-wraper-group week-group">週間</span>
								</div>
							</div>
							
							<div id="repeat_date_wraper" class="repeat_field_wraper" style="display: none;">
								<label class="checkbox-inline">
									<input type="checkbox" class="repeat-checkbox-date" name="repeat-Mon" value="Mon">
									月曜日
								</label>
								<label class="checkbox-inline">
									<input type="checkbox" class="repeat-checkbox-date" name="repeat-Tue" value="Tue">
									火曜日
								</label>
								<label class="checkbox-inline">
									<input type="checkbox" class="repeat-checkbox-date" name="repeat-Wed" value="Wed">
									水曜日
								</label>
								<label class="checkbox-inline">
									<input type="checkbox" class="repeat-checkbox-date" name="repeat-Thu" value="Thu">
									木曜日
								</label>
								<label class="checkbox-inline">
									<input type="checkbox" class="repeat-checkbox-date" name="repeat-Fri" value="Fri">
									金曜日
								</label>
								<label class="checkbox-inline">
									<input type="checkbox" class="repeat-checkbox-date" name="repeat-Sat" value="Sat">
									土曜日
								</label>
								<label class="checkbox-inline">
									<input type="checkbox" class="repeat-checkbox-date" name="repeat-Sun" value="Sun">
									日曜日
								</label>
							</div>
							
							<div id="repeat_month_wraper" class="repeat_month_wraper" style="display: none;">
								<label class="checkbox-inline">
									<input type="checkbox" class="repeat-checkbox-month repeat-month-1" name="repeat-month[]" value="1">
									1月
								</label>
								<label class="checkbox-inline">
									<input type="checkbox" class="repeat-checkbox-month repeat-month-2" name="repeat-month[]" value="2">
									2月
								</label>
								<label class="checkbox-inline">
									<input type="checkbox" class="repeat-checkbox-month repeat-month-3" name="repeat-month[]" value="3">
									3月
								</label>
								<label class="checkbox-inline">
									<input type="checkbox" class="repeat-checkbox-month repeat-month-4" name="repeat-month[]" value="4">
									4月
								</label>
								<label class="checkbox-inline">
									<input type="checkbox" class="repeat-checkbox-month repeat-month-5" name="repeat-month[]" value="5">
									5月
								</label>
								<label class="checkbox-inline">
									<input type="checkbox" class="repeat-checkbox-month repeat-month-6" name="repeat-month[]" value="6">
									6月
								</label>
								<label class="checkbox-inline">
									<input type="checkbox" class="repeat-checkbox-month repeat-month-7" name="repeat-month[]" value="7">
									7月
								</label>
								<label class="checkbox-inline">
									<input type="checkbox" class="repeat-checkbox-month repeat-month-8" name="repeat-month[]" value="8">
									8月
								</label>
								<label class="checkbox-inline">
									<input type="checkbox" class="repeat-checkbox-month repeat-month-9" name="repeat-month[]" value="9">
									9月
								</label>
								<label class="checkbox-inline">
									<input type="checkbox" class="repeat-checkbox-month repeat-month-10" name="repeat-month[]" value="10">
									10月
								</label>
								<label class="checkbox-inline">
									<input type="checkbox" class="repeat-checkbox-month repeat-month-11" name="repeat-month[]" value="11">
									11月
								</label>
								<label class="checkbox-inline">
									<input type="checkbox" class="repeat-checkbox-month repeat-month-12" name="repeat-month[]" value="12">
									12月
								</label>
							</div>

							<div class="form-group" id="duration_booking_wraper">
								<div class="duration_wraper monthly-duration weekly-duration daily-duration hourly-duration" style="display: none">
									<span class="price-label">利用単位</span>
									<span id="booking_duration"></span>
								</div>
								<div>
									<span id="price_duration_label"></span>
									<span id="booking_price"></span>
								</div>
							</div>

							<input type="hidden" value="¥" id="booking_currency" />
							<input type="hidden" value="" id="booking_event_id" name="event_id" />
							<input type="hidden" value="" id="remove_events" name="remove_events" />
							<input type="hidden" value="" id="booking_day_clicked" />
							<input type="hidden" value="" id="view_id" name="Type" />
							<input type="hidden" value="{{$firstSpace ? $firstSpace->id: ''}}" name="SpaceID" />
							<input type="hidden" value="" name="DurationDays" id="DurationDays" />
							<input type="hidden" value="" name="DurationHours" id="DurationHours" />
							<input type="hidden" name="_token" id="calendar_token" value="{{ csrf_token() }}">
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
						<button type="button" id="booking_button" class="btn btn-primary">保存</button>
						<button type="button" id="booking_button_remove" class="btn btn-danger">予約設定を削除</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="remodal" id="booking_modal"  data-remodal-options="hashTracking: false, closeOnOutsideClick: true">
		<button data-remodal-action="close" class="remodal-close"></button>
		<h1>予約内容</h1>
		<div id="booking_popup_content"></div>
		<button data-remodal-action="cancel" class="remodal-cancel">Close</button>
	</div>
</body>
</html>
