<?php 
use App\Spaceslot;
?>
@include('pages.header')
<script class="rs-file" src="<?php echo SITE_URL?>js/assets/royalslider/jquery.easing-1.3.js"></script>
<script src="<?php echo SITE_URL?>js/perfect-scrollbar/js/perfect-scrollbar.js"></script>
<script src="<?php echo SITE_URL?>js/swipe-slider/slider-templates/lightbox/js/jquery.prettyPhoto.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL?>assets/css/main.css">
<!-- <script type="text/javascript" src="<?php echo SITE_URL?>assets/js/jquery.min.js"></script> -->
<script type="text/javascript" src="<?php echo SITE_URL?>assets/js/jquery-ui.min.js"></script>
<script src="<?php echo SITE_URL?>js/datepicker-ja.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL?>assets/css/tab.css">
<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL?>assets/css/folio.css">
<!-- <script type="text/javascript" src="<?php echo SITE_URL?>assets/js/CommonJs.js"></script>  -->
<script src="{{ URL::asset('js/responsive-tabs/easyResponsiveTabs.js') }}"></script>
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
<script src="{{ URL::asset('js/calendar/calendar-booking.js') }}"></script>
<script src="{{ URL::asset('js/assets/booking.js') }}"></script>
<script type="text/javascript">
	var calendarURL = SITE_URL + 'getSpaceCalendar?spaceID='+"{{$space->HashID}}";
	var getHourURL = "{{URL::to('/user2/getajaxhour/')}}";
	var globalSpaceID = '{{$space->id}}';
	var globalSpaceHashID = '{{$space->HashID}}';
	var globalSpaceType = '<?php echo getSpaceSlotType($space);?>';
	var globalMinTerm = <?php echo (int)renderSpaceTypeTerm($space, false)?>;
	var globalStep = 2;
	var active_dates = <?php echo json_encode(array_keys($aAvailableDate))?>;
	var scheduleAvailableText = '<?php echo trans('common.Schedule Available')?>';
	var scheduleBookedText = '<?php echo trans('common.Schedule Booked')?>';
	var scheduleSelectedText = '<?php echo trans('common.Schedule Selected')?>';
	var scheduleSelectedText = '<?php echo trans('common.Schedule Selected')?>';
	var consecutive_error = '<?php echo $space->FeeType == SPACE_FEE_TYPE_MONTHLY ? trans('common.consecutive_month_error') : trans('common.consecutive_week_error')?>';
	var messageMintemError = '<?php echo getSpaceMinTermAlert($space)?>';
	var aSelectedSlots = [];
	var aSelectedSlotIds = [];
	var aSelectedSlotDates = [];
</script>
<body class="booking-process common">
	<div class="viewport">
		@if(Auth::check()) @include('pages.header_nav_shareuser') @elseif(Auth::guard('user2')->check()) @include('pages.header_nav_rentuser') @endif
		<section id="page">
			<div id="main">
				<header class="page-header">
					<div class="container">
						<div class="row">
							<div class="col-sm-7">
								<h1 itemprop="name">予約詳細</h1>
							</div>
							<!--/col-sm-7-->
							<div class="col-sm-5 hidden-xs">
								<div itemprop="breadcrumb" class="breadcrumb clearfix">
									<a href="#" title="hOur Office">Home</a>
									<a href="#" title="Booking">予約</a>
									<span>予約詳細</span>
								</div>
							</div>
							<!--/col-sm-5-->
						</div>
						<!--/row-->
					</div>
					<!--/container-->
				</header>
				<div id="content" class="pt30 pb30">
					<!--details booking-->
					<div id="confirm-book" class="container">
						<div class="row mb30" id="booking-breadcrumb">
							<div class="col-xs-3">
								<a href="#">
									<div class="breadcrumb-item done">
										<i class="fa fa-calendar"></i>
										<span>予約</span>
									</div>
								</a>
							</div>
							<!--/col-xs-3-->
							<div class="col-xs-3">
								<a href="#">
									<div class="breadcrumb-item active">
										<i class="fa fa-info-circle"></i>
										<span>予約詳細</span>
									</div>
								</a>
							</div>
							<!--/col-xs-3-->
							<div class="col-xs-3">
								<a href="#">
									<div class="breadcrumb-item">
										<i class="fa fa-list"></i>
										<span>予約確認</span>
									</div>
								</a>
							</div>
							<!--/col-xs-3-->
							<div class="col-xs-3">
								<a href="#">
									<div class="breadcrumb-item">
										<i class="fa fa-credit-card"></i>
										<span>支払い</span>
									</div>
								</a>
							</div>
							<!--/col-xs-3-->
						</div>
						<form id="editReservationForm" method="post" action="/ShareUser/Dashboard/BookingSummary">
							<input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />
							<input type='hidden' id='step' value='2' name='step' />
							<input type='hidden' id='spaceID' value='{{$space->id}}' name='spaceID' />
							<input type='hidden' id="spaceslots_id" name='spaceslots_id' value="<?php echo isset($aBookingTimeInfoSelected['bookedIDs']) ? implode(';', @$aBookingTimeInfoSelected['bookedIDs']) : ''?>" />
							<input type="hidden" name="booked_date" value="<?php echo isset($aBookingTimeInfoSelected['bookedDate']) ? implode(';', @$aBookingTimeInfoSelected['bookedDate']) : ''?>" id="booked_date" />
															
							<div class="row mb30">
								<div class="col-md-6">
									<table class="book-details book-table billing-table">
										<tbody>
											<tr class="t-caption">
												<th colspan="2">予約日</th>
											</tr>
											@if($rent_data->spaceID->FeeType!=1)
											<tr class="ver-top pad">
												<th>日程</th>
												<td style="width: 75%">
													<div class="custom-dropdown-wrapper">
														<div class="selectedDay">
															<input type="text" class="customdate dailydate_popup" id="calendar_picker" value='<?php echo @$aBookingTimeInfoSelected['timeDefaultSelected']['StartDateConverted']?>'>
														</div>
													</div>
													<ul class="selected-date selecteddays_display">
														<?php if (isset($aBookingTimeInfoSelected['bookedDate'])) {
														foreach ($aBookingTimeInfoSelected['bookedDate'] as $bookedDate) {
															if (isDaylySpace($space)) {
																$bookedDate = renderJapaneseDate($bookedDate, false);
															}elseif (isWeeklySpace($space)) {
																$oDateTime = \Carbon\Carbon::createFromFormat('Y-m-d', $bookedDate);
																$oDateTime->addWeeks(1)->subDay();
																$bookedDate = $bookedDate = renderJapaneseDate($bookedDate, false) . ' ~ ' . renderJapaneseDate($oDateTime->format('Y-m-d'), false);
															}elseif (isMonthlySpace($space)) {
																$oDateTime = \Carbon\Carbon::createFromFormat('Y-m-d', $bookedDate);
																$oDateTime->addMonths(1)->subDay();
																$bookedDate = $bookedDate = renderJapaneseDate($bookedDate, false) . ' ~ ' . renderJapaneseDate($oDateTime->format('Y-m-d'), false);
															}
															
														?>
														<li>
															<?php echo $bookedDate?>
														</li>
														<?php }}?>
													</ul>
												</td>
											</tr>
											@else
											<tr class="ver-top pad">
												<td colspan="2">
													<div class="reselect-box">
														<div class="box-label" style="padding-bottom: 5px;">利用日・時間帯</div>
														<div class="custom-dropdown-wrapper">
															<div class="selectedDay">
																<input type="text" name="datepicker" class="customdate" readonly id="datepicker" value="<?php echo @$aBookingTimeInfoSelected['timeDefaultSelected']['StartDateConverted']?>">
															</div>
														</div>
														<div class="wlp-start-date wlp-picker-wrapper wrap-selecttime">
															<input type='hidden' name='startTime' value='<?php echo @$aBookingTimeInfoSelected['timeDefaultSelected']['StartTime']?>' class='startTime' />
															<input type='hidden' name='endTime' value='<?php echo @$aBookingTimeInfoSelected['timeDefaultSelected']['EndTime']?>' class='endTime' />
															<div class='ajaxhourdata'>
																<div id="maintime" class="wlp-start-time-and-duration-display wlp-picker-display">
																	時間帯:
																	<span id="tfromtime">
																		<?php echo @$aBookingTimeInfoSelected['timeDefaultSelected']['StartTimeConverted']?>
																	</span>
																	-
																	<span id="toendtime">
																		<?php echo @$aBookingTimeInfoSelected['timeDefaultSelected']['EndTimeConverted']?>
																	</span>
																</div>
																<div id="timewrap" class="wlp-start-time-and-duration-pickers wlp-picker" style="display: none">
																	<div class="wlp-picker-wrapper">
																		<div id="fromtimed" class="wlp-picker-display">
																			開始時間:
																			<span class="fromtimed-value">
																				<?php echo @$aBookingTimeInfoSelected['timeDefaultSelected']['StartTimeConverted']?>
																			</span>
																		</div>
																		<div id="fromtime" class="wlp-picker wlp-time-picker" style="display: none;">
																			<?php 
																			if(isset($aBookingTimeInfoSelected['aAvailableTimeFromList'])) {
																				foreach (@$aBookingTimeInfoSelected['aAvailableTimeFromList'] as $availableTimeFromList) {
																				$time = date('H:00:00', strtotime($availableTimeFromList .':00:00'));
																				$timeConvert = getTimeFormat($availableTimeFromList .':00:00');
																				?>
																			<div class="wlp-time-picker-item fromtimer selectable " data-value="<?php echo $time ?>">
																				<?php echo $timeConvert?>
																			</div>
																			<?php }
																			}?>
																		</div>
																	</div>
																	<div class="wlp-picker-wrapper">
																		<div id="endtimed" class="wlp-picker-display">
																			終了時間:
																			<span class="endtimed-value">
																				<?php echo @$aBookingTimeInfoSelected['timeDefaultSelected']['EndTimeConverted']?>
																			</span>
																		</div>
																		<div id="endtime" class="wlp-picker wlp-time-picker" style="display: none">
																			<?php 
																			if(isset($aBookingTimeInfoSelected['aAvailableTimeToList'])) {
																			foreach (@$aBookingTimeInfoSelected['aAvailableTimeToList'] as $availableTimeFromList) {
																				$time = date('H:00:00', strtotime($availableTimeFromList .':00:00'));
																				$timeConvert = getTimeFormat($availableTimeFromList .':00:00');;
																				?>
																			<div class="wlp-time-picker-item totimer selectable " data-value="<?php echo $time ?>">
																				<?php echo $timeConvert?>
																			</div>
																			<?php }
																			}?>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</td>
											</tr>
											@endif
											<tr class="pad">
												<th>利用人数</th>
												<td>
													<?php echo Form::select('total_persons', getBookingTotalPersonArray(), $rent_data->total_persons, ['class' => 'pop-one-sel']);?>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="col-md-6">
									<div id="booking-summary-block">
										@include('public.booking-step2-summary')
									</div>
									<div class="confirm-term">
										<p>
											<a href="{{url('/')}}/TermCondition/RentUser" target="_blank">利用者規約</a>
											を確認した上で、予約を進めてください。
										</p>
										<input type="checkbox" id="checkTerm" />
										<span>
											<a href="{{url('/')}}/TermCondition/RentUser" target="_blank">利用者規約</a>
											に同意する
										</span>
									</div>
								</div>
							</div>
							<!--.mb30-->
							<div class="step-btn-group">
								<a class="btn btn-default btn-lg pull-left" href="{{getSpaceUrl($rent_data->spaceID->HashID)}}">
									<i class="fa fa-angle-left"></i>
									戻る
								</a>
								<button type="submit" name="book" class="btn btn-primary btn-lg pull-right" id='next_step'>
									次へ
									<i class="fa fa-angle-right"></i>
								</button>
							</div>
						</form>
					</div>
					<!--/container-->
					<!--/details booking-->
				</div>
				<!--footer-->
				@include('pages.dashboard_user1_footer')
				<!--/footer-->
			</div>
			<!--/#main-->
		</section>
	</div>
	<div id="myModal" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">@if($space['FeeType']==2) 利用日を選択 @elseif($space['FeeType']==3) 利用週を選択 @elseif($space['FeeType']==4) 利用月を選択 @else @endif</h4>
					</div>
					<div class="modal-body">
						<div id="space_calendar_content_wraper">
							<?php echo '<div class="space-calendar-content" id="space_calendar" data-spaceID="'.$space->id . '"></div>'; ?>
						</div>
						<div class="space-calendar"></div>
						<br />
						<div class='monthly_booking' style='text-align: center'></div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
					</div>
				</div>
			</div>
		</div>
	<!--/viewport-->
	<script>
	jQuery(function($) {
		$('#next_step').attr('disabled', 'disabled');
		$('body').on('click', '#checkTerm', function() {
			if ($(this).prop('checked') == false) {
				$('#next_step').attr('disabled', 'disabled');
			} else {
				$('#next_step').removeAttr('disabled');
			}
		});
	});
	</script>
</body>
</html>
