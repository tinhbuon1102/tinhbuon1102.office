jQuery(document).ready(function($) {
	var isWeekTab = false;
	var timeStep = 60;
	var hourDuration = '01:00:00';
	var limitYears = 2;
	var limitMonths = 2;
	var revertEventFunc;
	var calendarDateFormat = 'YYYY-MM-DD';
	var yearFormat = 'YYYY';
	var japanDateFormat = 'YYYY年MM月DD日';
	var japanMonthFormat = 'YYYY年MM月';
	var monthFormat = 'YYYY-MM-DD';
	var monthFormatOnly = 'YYYY-MM';
	var dateFormat = 'YYYY-MM-DD';
	var timeFormat = 'H:mm';
	var timeFormatDefault = 'H:mm A';
	var timePickerFormat = 'H:i';
	var minTime = '05:00:00';
	var maxTime = '24:00:00';
	var maxTimePicker;
	var currentDay = moment().format(dateFormat);
	var isBackgroundEdited = false;

	function getBusinessHours() {
		if (!timeRange || feeType != 'HourSpace') return false;

		var todayName = moment().format('ddd').toLowerCase();
		var todayTime = moment().format('H:00');
		var businessHours = [];
		var timeIndex = 0;
		$.each(timeRange, function(dayName, data){
			var availHours = {};
			availHours.dow = [];

			if (!data.closed)
			{
				availHours.dow.push(timeIndex);

				if (data.open247)
				{
					availHours.start = '00:00';
					availHours.end = '23:00';
					
					if (dayName == 'fc-' + todayName && moment(currentDay, dateFormat).diff(moment(), 'days') <= 0)
					{
						if (moment().diff(moment(data.opening_start, timeFormatDefault), 'hours') >= 1)
						{
							availHours.start = moment().format('HH:00');
						}
					}
				}
				else {
					if (dayName == 'fc-' + todayName && moment(currentDay, dateFormat).diff(moment(), 'days') <= 0)
					{
						if (moment().diff(moment(data.opening_start, timeFormatDefault), 'hours') >= 1)
						{
							availHours.start = moment().format('HH:00');
						}
						else{
							availHours.start = moment(data.opening_start, timeFormatDefault).format('HH:00');
						}
												
						if (moment().diff(moment(data.opening_end, timeFormatDefault), 'hours') <= 1)
						{
							availHours.end = moment(data.opening_end, timeFormatDefault).format('HH:00');
						}
						else
						{
							availHours = null;
						}
					}
					else {
						availHours.start = moment(data.opening_start, timeFormatDefault).format('HH:00');
						availHours.end = moment(data.opening_end, timeFormatDefault).format('HH:00');
					}
					
					
				}

				//availHours.rendering = 'background';
				if (availHours)
					businessHours.push(availHours);
			}
			timeIndex++;
		});
		return businessHours;
	}


	function getDayData(cell, view) {
		if (!timeRange) return false;

		var dayData = {};
		$.each(timeRange, function(dayName, data){
			if ($(cell[0]).hasClass(dayName))
			{
				dayData = data;
				return false;
			}
		});

		return dayData;
	}

	function resetBookingForm() {
		$('#bookingModal').find('#booking_date_start').val('');
        $('#bookingModal').find('#booking_time_start').val((''));
        $('#bookingModal').find('#booking_time_end').val((''));
        $('#bookingModal').find('#booking_price').html((''));
	}

	function createEventEndTime(event) {
		if (!event.end)
		{
			eventEnd = moment(event.start);
			eventEnd.add(hourMinTerm, 'hours');
			return eventEnd;
		}
		return event.end;
	}

	function calculateDuration(type, start_el, end_el, format) {
		if (type == 'days')
		{
			var startTime = moment($('#bookingModal').find(start_el).val() + 'T' + $('#booking_time_start').val(), format);
			var endTime = moment($('#bookingModal').find(end_el).val() + 'T' + $('#booking_time_end').val(), format);
			var duration = endTime.diff(startTime, 'hours');
			duration = Math.ceil(duration/24);
		}
		else {
			var startTime = moment($('#bookingModal').find(start_el).val(), format);
			var endTime = moment($('#bookingModal').find(end_el).val(), format);

			if (type == 'weeks')
			{
				var duration = endTime.diff(startTime, 'days');
				var duration = Math.ceil(duration / 7);
			}
			else{
				var duration = endTime.diff(startTime, type);
			}
		}

		return Math.ceil(duration);
	}

	function calculatePrice() {
		var currency = $('#booking_currency').val();

		if ($('#view_id').val() == 'MonthlySpace')
		{
			var months = calculateDuration('months', '#booking_month_start', '#booking_month_end', monthFormat);
			var strMonth = (months == 1 ? '月' : '月');

			$('#bookingModal').find('#booking_price').html(months * monthlyPrice);
			$('#bookingModal').find('#booking_duration').html(months + ' ' + strMonth);
			$('#bookingModal').find('#price_duration_label').html(months + ' ' + strMonth + ' @ ' + currency + monthlyPrice + '/'+ strMonth +'  = ');
			$('#bookingModal').find('#booking_price').html(currency + (months * monthlyPrice));
		}
		else if ($('#view_id').val() == 'WeeklySpace')
		{
			var weeks = calculateDuration('weeks', '#booking_date_start', '#booking_date_end', dateFormat);
			var strWeek = (weeks == 1 ? '週間' : '週間');

			$('#bookingModal').find('#booking_price').html(weeks * weeklyPrice);
			$('#bookingModal').find('#booking_duration').html(weeks + ' ' + strWeek);
			$('#bookingModal').find('#price_duration_label').html(weeks + ' ' + strWeek + ' @ ' + currency + weeklyPrice + '/'+ strWeek +'  = ');
			$('#bookingModal').find('#booking_price').html(currency + (weeks * weeklyPrice));
		}
		else if ($('#view_id').val() == 'DailySpace')
		{
			var days = calculateDuration('days', '#booking_date_start', '#booking_date_end', dateFormat+'T'+timeFormat);
			var strDay = (days == 1 ? '日' : '日');

			$('#bookingModal').find('#booking_price').html(days * dailyPrice);
			$('#bookingModal').find('#booking_duration').html(days + ' ' + strDay);
			$('#bookingModal').find('#price_duration_label').html(days + ' ' + strDay + ' @ ' + currency + dailyPrice + '/'+ strDay +'  = ');
			$('#bookingModal').find('#booking_price').html(currency + (days * dailyPrice));
		}
		else {
			var hours = calculateDuration('hours', '#booking_time_start', '#booking_time_end', timeFormat);
			var strHour = (hours == 1 ? '時間' : '時間');
			$('#bookingModal').find('#booking_price').html(hours * hourlyPrice);
			$('#bookingModal').find('#booking_duration').html(hours + strHour);
			$('#bookingModal').find('#price_duration_label').html(hours + strHour + ' @ ' + currency + hourlyPrice + '/' + strHour + ' = ');
			$('#bookingModal').find('#booking_price').html(currency + (hours * hourlyPrice));
		}
	}

	function createTimePicker(element, minTime, maxTime)
	{
		element.timepicker({
			'timeFormat': timePickerFormat,
			'step': timeStep,
			'lang' : {
					am: 'AM',
					pm: 'PM',
					AM: 'AM',
					PM: 'PM',
					decimal: '.',
					mins: '分',
					hr: '時間',
					hrs: '時間'
			},
			'minTime': moment(minTime, timeFormatDefault).format('HH:mm'),
			'maxTime': moment(maxTime, timeFormatDefault).format('HH:mm')
		});
	}

	function removeTimePicker(element) {
		element.timepicker('remove');
	}

	function showModalEditTime(event, view, isBackground){
		eventEnd = createEventEndTime(event);
		var startTime = event.start.format(timeFormat);
		var endTime = eventEnd.format(timeFormat);
		// Make Endtime must >= hourMinTerm
		diffHour = eventEnd.diff(event.start, 'hours');
		if (diffHour < hourMinTerm)
		{
			endTime = moment(event.start).add(hourMinTerm, 'hours').format(timeFormat);
		}

		$('#bookingModal').find('#booking_month_start').val(event.start.format(monthFormat));
		$('#bookingModal').find('#booking_month_end').val(event.end.format(monthFormat));
		$('#bookingModal').find('#booking_date_start').val(event.start.format(dateFormat));
		$('#bookingModal').find('#booking_date_end').val(event.end.format(dateFormat));
		$('#bookingModal').find('#booking_time_start').val(startTime).trigger('change');
		
		$('#bookingModal').find('#booking_time_end').val(endTime);
		$('#bookingModal').find('#booking_event_id').val(event._id);

		calculatePrice();

		$('#bookingModal').off('show.bs.modal');
		$('#bookingModal').on('show.bs.modal', function (e) {
        });

		// Show remove button if updating
		if (event._id)
		{
			$('#bookingModal').find('#booking_button_remove').show();
		}
		else{
			$('#bookingModal').find('#booking_button_remove').hide();
		}

		if (isBackground)
		{
			$('#booking_button').click();
		}
		else
		{
			// Convert to japanese date format to showing only
			dateShowingFormat(event);

			$('#bookingModal').modal({
				'show': true,
				'keyboard': false,
				'backdrop': 'static'
			});

	        $('#bookingModal').on('hidden.bs.modal', function () {
	            if (revertEventFunc)
	            {
	            	revertEventFunc();
	            	revertEventFunc = null;
	            }
	            if ($('#repeat_checkox').is(':checked')) {
	            	$('#repeat_checkox').trigger('click');
	            }
	            //Reset booking form
	            $('#booking_form').get(0).reset();
	        })
		}
	}

	function showHideNavButton(currentSelected, currentDate, maxLimit) {
		//@TODO remove below if need hide past
		return '';
		
		// Show / hide next button
		if (maxLimit == currentSelected){
			$('.fc-toolbar .fc-next-button').css('visibility', 'hidden');
		}
		else {
			$('.fc-toolbar .fc-next-button').css('visibility', 'visible');
		}

		// Show / hide previous button
		if (currentSelected == currentDate){
			$('.fc-toolbar .fc-prev-button').css('visibility', 'hidden');
		}
		else {
			$('.fc-toolbar .fc-prev-button').css('visibility', 'visible');
		}
	}

	function getDaysClosed () {
		//find closed days to calculate end day
		var intDayClosed = 0;
		$.each(timeRange, function(dayName, data){
			if (data.closed)
				intDayClosed ++;
		});
		return intDayClosed;
	}

	function regenerateTimePicker(event, view) {
		var clickedDate = event.start.format(dateFormat);
		// Regenerate pickerTime
		var selectedDayElement = $('td.fc-day[data-date="'+ event.start.format(calendarDateFormat) +'"]');
		var selectedDay = {};
		$.each(timeRange, function(dayName, data){
			if (selectedDayElement.hasClass(dayName))
			{
				selectedDay = data;
				return false;
			}
		});

		minTime = selectedDay.opening_start;
		maxTimePicker = maxTime = selectedDay.opening_end;

		removeTimePicker($('.hasTimepicker.start'));
		createTimePicker($('.hasTimepicker.start'), minTime, moment(maxTime, timeFormatDefault).subtract(hourMinTerm, 'hours').format(timeFormatDefault));

		startTimeObj = moment(event.start.format(timeFormatDefault), timeFormatDefault);
		minTimeObj = moment(minTime, timeFormatDefault);
		maxTimeObj = moment(maxTime, timeFormatDefault);

		if (view.intervalUnit == 'week' && (startTimeObj.isBefore(minTimeObj) || maxTimeObj.isBefore(startTimeObj)) || selectedDay.closed)
		{
			return false;
		}

		startTime = moment(clickedDate +'T' + minTime, dateFormat + 'T' + timeFormatDefault);
		endTime = moment(startTime).add(parseInt(hourMinTerm), 'hours');

		if (view.type == 'DailySpace')
		{
			endTime = moment(clickedDate +'T' + maxTime, dateFormat + 'T' + timeFormatDefault);
		}

		removeTimePicker($('.hasTimepicker.end'));
		createTimePicker($('.hasTimepicker.end'), endTime.format(timeFormatDefault), maxTime);

		return {
				start: startTime,
				end: endTime
			};

	}

	function timeCommonPicker() {
		$('.hasTimepicker').timepicker({
			'timeFormat': timePickerFormat,
			'step': 60,
			'lang' : {
				am: 'AM',
				pm: 'PM',
				AM: 'AM',
				PM: 'PM',
				decimal: '.',
				mins: '分',
				hr: '時間',
				hrs: '時間'
		},
		});
	}

	function removeDatePicker(element){
		element.datepicker('destroy');
	}

	function showHideInprogressBackground(type){
		if(type == 'show')
		{
			jQuery('.space-calendar.active').LoadingOverlay("show");
			$('body').css('cursor', 'progress');
		}
		else
		{
			jQuery('.space-calendar.active').LoadingOverlay("hide");
			$('body').css('cursor', 'inherit');
		}
	}

	function removeEvents(eventId) {
		var success = true;
		showHideInprogressBackground('show');
		data = $('#booking_form').serialize();
		//Remove old event
		$.ajax({
			url: SITE_URL + 'ShareUser/Dashboard/SaveCalendar',
			method: 'post',
			dataType: 'json',
			data: data + '&calAction=remove&event_id='+eventId,
			success: function(response){
				if (response.success != -1)
				{
					$.each(calendarEvents, function(indexEvent, valueEvent){
						if (eventId == valueEvent.id)
						{
							calendarEvents = calendarEvents.filter(function(el) {
							    return el.id != eventId;
							});
							return false;
						}
					})
					$('.space-calendar.active').fullCalendar('removeEvents', eventId);
				}
				else
				{
					success = false;
					//alert (response.message);
				}
				showHideInprogressBackground('hide');
			},
			error: function(){
				success = false;
				showHideInprogressBackground('hide');
			}
		});
		return success;
	}

	function saveEventData(eventData) {
		showHideInprogressBackground('show');
		data = $('#booking_form').serialize();
		data += '&StartDate=' + eventData.start.format(dateFormat);
		data += '&EndDate=' + eventData.end.format(dateFormat);
		data += '&StartTime=' + eventData.start.format('HH:mm:00');
		data += '&EndTime=' + eventData.end.format('HH:mm:00');
		data += '&calAction=saveEvents';

		//Remove old event
		$.ajax({
			url: SITE_URL + 'ShareUser/Dashboard/SaveCalendar',
			method: 'post',
			dataType: 'json',
			data: data,
			success: function(response){
				if (response.success != -1)
				{
					eventData['id'] = response.success;
					$('.space-calendar.active').fullCalendar('removeEvents', $('#booking_event_id').val());
					$('.space-calendar.active').fullCalendar('renderEvent', eventData, true);
					$('.space-calendar.active').fullCalendar('unselect');
					calendarEvents.push(eventData);
					removeDuplicateEvents(eventData);
					
					$('.resp-tab-active').removeClass('no-schedule');
					
					if (isBackgroundEdited)
						$('.main-calendar.resp-tab-active:visible').trigger('click');
					
				}
				else {
					alert(response.message);
				}
				showHideInprogressBackground('hide');
			},
			error: function(){
				showHideInprogressBackground('hide');
			}
		})
	}
	function dateCommonPicker() {
		var nowDate = new Date();
		var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);

		if ($('#view_id').val() == 'MonthlySpace')
		{
			$('#booking_month_start').datepicker({
				format: japanMonthFormat.toLowerCase(),
				minViewMode: 1,
				todayBtn: true,
				todayHighlight: true,
				language: "ja",
				autoclose: true,
			});
		}
		else if ($('#view_id').val() == 'WeeklySpace')
		{
			$('#booking_date_start').datepicker({
				format: japanDateFormat.toLowerCase(),
			    weekStart: 1,
			    language: "ja",
			    todayBtn: true,
			    todayHighlight: true,
			    calendarWeeks: true,
			    autoclose: true,
			    //startDate: today,
			    daysOfWeekDisabled: "0,2,3,4,5,6",
			    daysOfWeekHighlighted: "1"
			}).on('changeDate', function(ev) {
				var date_start = moment($('#booking_date_start').val(), japanDateFormat);
				var date_end = moment(date_start).add(weekMinTerm, 'weeks');
				$('#booking_date_end').val(date_end.format(japanDateFormat));
			});

		}
		else {
			$('.hasDatepicker').datepicker({
				format: japanDateFormat.toLowerCase(),
				language: "ja",
				weekStart: 1,
				todayHighlight: true,
				todayBtn: true,
				autoclose: true,
			})
		}
	}

	jQuery('#booking_form input[type="text"]:not(".repeat-number")').keypress(function(e) {
	    e.preventDefault();
	    return false;
	});

	$('body').on('change', '.hasTimepicker.start', function(){
		var time_start = moment(jQuery('#booking_time_start').val(), timeFormat);
		var time_end = moment(jQuery('#booking_time_end').val(), timeFormat);
		var nexttime_start = moment(time_start).add(hourMinTerm, 'hours');

		var diffHour = time_end.diff(time_start, 'days');

		if (diffHour <= 0)
		{
			jQuery('#booking_time_end').val(nexttime_start.format(timeFormat));
		}

		// Regenerate pickerTime
		removeTimePicker($('.hasTimepicker.end'));
		createTimePicker($('.hasTimepicker.end'), nexttime_start.format(timeFormatDefault), maxTimePicker);
	});

	$('body').on('change', '.hasTimepicker, .hasDatepicker', function(){
		calculatePrice();
	});

	$('body').on('click', '#booking_button', function(){
		$('form#booking_form').submit();
	});

	$('body').on('click', '#repeat_number', function(){
		$(this).select();
	});
	$('body').on('click', '#repeat_checkox', function(){
		$('form#booking_form #repeat_field_wraper .hasDatepicker').datepicker('destroy');
		
		if (defaultCalendarView == 'HourSpace' || defaultCalendarView == 'DailySpace')
		{
			$('form#booking_form #repeat_field_wraper .hasDatepicker').datepicker({
				format: japanDateFormat.toLowerCase(),
				language: "ja",
				weekStart: 1,
				todayHighlight: true,
				todayBtn: true,
				autoclose: true,
			})
			
			$('form#booking_form #repeat_field_wraper input').attr('required', $(this).is(':checked'));
			$('form#booking_form .repeat_field_wraper').toggle();
		}
		else if(defaultCalendarView == 'WeeklySpace'){
			$('form#booking_form #repeat_number_wraper input').val(1);
			$('form#booking_form .repeat_number_wraper').toggle();
		}
		else if(defaultCalendarView == 'MonthlySpace'){
			$('form#booking_form #repeat_field_wraper .hasDatepicker').datepicker({
				format: japanMonthFormat.toLowerCase(),
				minViewMode: 1,
				todayBtn: true,
				todayHighlight: true,
				language: "ja",
				autoclose: true,
			});
			
			$('form#booking_form .repeat_month_wraper').toggle();
			$('form#booking_form #repeat_field_wraper').toggle();
			$('.repeat-checkbox-month').each(function(){
				$(this).prop('checked', !$(this).is(':checked'));
			})
			
		}
		
		var dateName = moment($('#booking_date_start').val(), japanDateFormat);
		$.each(timeRange, function(dayName, data){
			dateName = dayName.replace('fc-', '');
			dateName = CapitalizeString(dateName);
			if (!data.closed)
				$('input[name="repeat-'+ dateName +'"]').prop('checked', !$(this).is(':checked'));
		});
	});

	$('body').on('click', '#booking_button_remove', function(){
		if (confirm('本当に削除しますか？'))
		{
			removeEvents($('#booking_event_id').val());
			jQuery('#bookingModal').modal('hide');
		}
	});

	function CapitalizeString(string)
	{
		return string.charAt(0).toUpperCase() + string.slice(1);
	}

	function replaceDayMonthYearJapanToDefault(str){
		str = str.replace(/年|月/g,'-');
		str = str.replace(/日/g,'');
		return str;
	}
	function dateShowingFormat(event)
	{
		if(event)
		{
			if ($('#view_id').val() == 'MonthlySpace')
			{
				event.end.add(5, 'days').startOf('month');
			}
			intDayClosed = getDaysClosed();
			$('#bookingModal').find('#booking_month_start').val(event.start.format(japanMonthFormat)).trigger('change');
			$('#bookingModal').find('#booking_month_end').val(moment(event.start).add(monthMinTerm, 'months').format(japanMonthFormat)).trigger('change');
			$('#bookingModal').find('#booking_date_start').val(event.start.format(japanDateFormat)).trigger('change');
			$('#bookingModal').find('#booking_date_end').val(moment(event.start).endOf('isoweek').subtract(intDayClosed - 1, 'days').format(japanDateFormat)).trigger('change');

			if ($('#view_id').val() == 'MonthlySpace')
			{
				$('#bookingModal').find('#booking_repeat_start').val(moment(event.start).add('1', 'months').format(japanMonthFormat));
				$('#bookingModal').find('#booking_repeat_end').val(moment(event.start).add('2', 'months').format(japanMonthFormat));
			}
			else {
				$('#bookingModal').find('#booking_repeat_start').val(moment(event.start).add('1', 'days').format(japanDateFormat));
				$('#bookingModal').find('#booking_repeat_end').val(moment(event.start).add('2', 'days').format(japanDateFormat));
			}
			
		}
		else{
			$('#bookingModal').find('#booking_month_start').val(replaceDayMonthYearJapanToDefault($('#bookingModal').find('#booking_month_start').val()));
			$('#bookingModal').find('#booking_month_end').val(replaceDayMonthYearJapanToDefault($('#bookingModal').find('#booking_month_end').val()));
			$('#bookingModal').find('#booking_date_start').val(replaceDayMonthYearJapanToDefault($('#bookingModal').find('#booking_date_start').val()));
			$('#bookingModal').find('#booking_date_end').val(replaceDayMonthYearJapanToDefault($('#bookingModal').find('#booking_date_end').val()));
			$('#bookingModal').find('booking_repeat_start').val(replaceDayMonthYearJapanToDefault($('#bookingModal').find('#booking_repeat_start').val()));
			$('#bookingModal').find('#booking_repeat_end').val(replaceDayMonthYearJapanToDefault($('#bookingModal').find('#booking_repeat_end').val()));

			var startTime = moment($('#bookingModal').find('booking_time_start').val(), timeFormat);
			var endTime = moment($('#bookingModal').find('#booking_time_end').val(), timeFormat);
			$('#bookingModal').find('booking_time_start').val(startTime.format(timeFormatDefault));
			$('#bookingModal').find('booking_time_end').val(endTime.format(timeFormatDefault))
			
			var startMonth = moment($('#bookingModal').find('#booking_month_start').val(), dateFormat);
			startMonth.startOf('month');
			var endMonth = moment(startMonth).add(1, 'months');
			endMonth.startOf('month');

			$('#bookingModal').find('#booking_month_start').val(startMonth.format(dateFormat));
			$('#bookingModal').find('#booking_month_end').val(endMonth.format(dateFormat));
		}

	}

	function removeDuplicateEvents (eventData){
		// Remove old events
		// Remove all events on this day
	    var removeEventIds = [];
		$('.space-calendar.active').fullCalendar( 'removeEvents', function(event) {
			if (jQuery.inArray(event._id, removeEventIds) != -1 || $('#booking_event_id').val() == event._id || eventData['id'] == event._id)
				return false;

			removeEventIds.push(event._id);
			var startDate = event.start.format(dateFormat);
			var clickedDate = eventData.start.format(dateFormat);
			if (event.end)
				var endDate = event.end.format(dateFormat);
			else
				var endDate = null;

			// remove all events inside day or week
			if ($('#view_id').val() == 'WeeklySpace')
			{
				var startWeek = moment(startDate).startOf('isoweek');
				var clickedStartWeek = moment(clickedDate).startOf('isoweek');
				var duration = clickedStartWeek.diff(startWeek, 'days');
				if(duration === 0)
				{
					var $return = true;
				}
			}
			else if ($('#view_id').val() == 'MonthlySpace')
			{
				var startMonth = moment(startDate).startOf('month');
				var clickedStartMonth = moment(clickedDate).startOf('month');
				var duration = clickedStartMonth.diff(startMonth, 'days');
				if(duration === 0)
				{
					var $return = true;
				}
			}
			else if ($('#view_id').val() == 'DailySpace')
			{
				if((clickedDate == startDate && !endDate) || (clickedDate == startDate && clickedDate <= endDate)) {
					var $return = true;
                }
			}
			else if ($('#view_id').val() == 'HourSpace')
			{
				var startHour = event.start;
				var endHour = event.end;
				var clickedTimeStart = eventData.start;
				var clickedTimeEnd = eventData.end;

				if(
						clickedTimeStart.format(dateFormat) == startHour.format(dateFormat) &&
					(
						clickedTimeStart.format(timeFormat) == startHour.format(timeFormat) ||
						(startHour.diff(clickedTimeStart)  <= 0 && endHour.diff(clickedTimeEnd) >= 0) ||
						(startHour.diff(clickedTimeStart)  <= 0 && endHour.diff(clickedTimeStart) > 0)  ||
						(startHour.diff(clickedTimeEnd) 	< 0 && endHour.diff(clickedTimeEnd) >= 0)  ||
						(startHour.diff(clickedTimeStart)  >= 0 && endHour.diff(clickedTimeEnd) <= 0)
					)
				) {
					var $return = true;
                }
			}

			if ($return)
			{
				success = removeEvents(event._id);
				return success;
			}

		});
	}
	$('form#booking_form').validator().on('submit', function (e) {

		// Convert to default date format to calculate, etc...
		dateShowingFormat();

	  if (e.isDefaultPrevented()) {

	  } else {
		  if ($('#view_id').val() == 'MonthlySpace')
		  {
			  var startMonth = moment($('form#booking_form #booking_month_start').val(), dateFormat);
			  var endMonth = moment($('form#booking_form #booking_month_end').val(), dateFormat);

			  var booking_date_start = startMonth.format(monthFormat);
			  var booking_date_end = endMonth.format(monthFormat);
		  }
		  else {
			  var booking_date_start = $('form#booking_form #booking_date_start').val();
			  var booking_date_end = $('form#booking_form #booking_date_end').val();
		  }

		  if ($('#view_id').val() == 'HourSpace' || $('#view_id').val() == 'DailySpace')
		  {
			  var booking_date_end = $('form#booking_form #booking_date_start').val();
		  }

		  var time_start = $('form#booking_form #booking_time_start').val();
		  var time_end = $('form#booking_form #booking_time_end').val();
		  var title = '予約受付中';
		  
		  //Store duration hidden field
		  var startDay = moment(booking_date_start, dateFormat);
		  var endDay = moment(booking_date_end, dateFormat);
		  var durationDays = endDay.diff(startDay, 'days');

		  var startHour = moment(time_start, timeFormat);
		  var endHour = moment(time_end, timeFormat);
		  var durationHours = endHour.diff(startHour, 'hours');
		  var aEventData = [];

		  $('#DurationDays').val((durationDays ? durationDays : 0));
		  $('#DurationHours').val((durationHours ? durationHours : 0));

		  if ($('#view_id').val() == 'WeeklySpace')
		  {
			  intDayClosed = getDaysClosed();
			  var numWeeks = Math.ceil(durationDays / 7);
			  if($('#repeat_checkox').is(':checked'))
			  {
				var repeat_number = parseInt($('#repeat_number').val());
				if (repeat_number > 0)
				{
					numWeeks += repeat_number;
				}
			  }
			  if (numWeeks)
			  {
				  for (i=0; i<numWeeks; i++)
				 {
					  startWeek = moment(startDay).add(i, 'weeks');
					  endWeek = moment(startWeek).endOf('isoweek').subtract(intDayClosed - 1, 'days');

					  var booking_date_start = startWeek.format(dateFormat);
					  var booking_date_end = endWeek.format(dateFormat);
					  var eventData = {
								title: title,
								start: moment(booking_date_start + 'T' + startHour.format(timeFormatDefault), dateFormat + 'T' + timeFormatDefault),
								end: moment(booking_date_end + 'T' + endHour.format(timeFormatDefault), dateFormat + 'T' + timeFormatDefault),
								className : "available",
								editable: true,
								constraint: null,
								overlap: false,
								color: '#BABBBF',
								type: $('#view_id').val(),
								eventColor: '#000',
								 backgroundColor: '#3a87ad',
							};

					  durationDays = endWeek.diff(startWeek, 'days');
					  $('#DurationDays').val((durationDays ? durationDays : 0));

					  aEventData.push(eventData);
				 }
			  }
		  }

		  else if ($('#view_id').val() == 'HourSpace' || $('#view_id').val() == 'DailySpace')
		  {
			  durationRepeat = -1;
			  if($('#repeat_checkox').is(':checked'))
			  {
				  var startRepeat = moment($('#booking_repeat_start').val(), dateFormat);
				  var endRepeat = moment($('#booking_repeat_end').val(), dateFormat);
				  var durationRepeat = endRepeat.diff(startRepeat, 'days');
			  }

			  //Prepair date to array
			  var aDateArray = [];
			  var aRepeateDate = []

			  aRepeateDate['start'] =  booking_date_start;
			  aRepeateDate['end'] =  booking_date_start;
			  aDateArray.push(aRepeateDate);

			  for (i=0; i <= durationRepeat; i++)
			  {
				  var allowRepeat = true;
				  var repeatDate = moment(startRepeat).add(i, 'days');
				  var repeatDateName = repeatDate.format('ddd');
				  var dateTimeRange = timeRange['fc-'+repeatDateName.toLowerCase()];
				  if ($('input[name="repeat-'+ repeatDateName +'"]').is(':checked') && !dateTimeRange.closed)
				  {
					  aRepeateDate = [];
					  aRepeateDate['start'] =  repeatDate.format(dateFormat);
					  aRepeateDate['end'] =  repeatDate.format(dateFormat);
					  $.each(aDateArray, function(indexDate, aDate){
						  if (aDate['start'] == aRepeateDate['start'])
						  {
							  allowRepeat = false;
							  return false;
						  }
					  });
					  if (allowRepeat)
						  aDateArray.push(aRepeateDate);
				  }
			  }

			  $.each(aDateArray, function(index, repeatDate){
				  // Keep only main event id to update, other repeat will be create new
				  if (index > 0)
					  $('#booking_event_id').val('');

				  var eventData = {
							title: title,
							start: moment(repeatDate['start'] + 'T' + startHour.format(timeFormatDefault), dateFormat + 'T' + timeFormatDefault),
							end: moment(repeatDate['end'] + 'T' + endHour.format(timeFormatDefault), dateFormat + 'T' + timeFormatDefault),
							className : "available",
							editable: true,
							type: $('#view_id').val(),
							color: '#BABBBF',
							eventColor: '#000',
							 backgroundColor: '#3a87ad',
						};

				  if ($('#view_id').val() == 'DailySpace')
				  {
					  eventData['overlap'] = false;
					  eventData['constraint'] = null;
				  }
				  aEventData.push(eventData);
			  })
		  }
		  else if ($('#view_id').val() == 'MonthlySpace'){
			  durationRepeat = -1;
			  if($('#repeat_checkox').is(':checked'))
			  {
				  var startRepeat = moment($('#booking_repeat_start').val(), dateFormat);
				  var endRepeat = moment($('#booking_repeat_end').val(), dateFormat);
				  var durationRepeat = endRepeat.diff(startRepeat, 'months');
			  }

			  //Prepair date to array
			  var aDateArray = [];
			  var aRepeateDate = []

			  aRepeateDate['start'] =  booking_date_start;
			  aRepeateDate['end'] =  booking_date_end;
			  aDateArray.push(aRepeateDate);

			  for (i=0; i <= durationRepeat; i++)
			  {
				  var allowRepeat = true;
				  var repeatDate = moment(startRepeat).add(i, 'months');
				  var repeatEndDate = moment(startRepeat).add(i+1, 'months');
				  
				  var repeatDateName = parseInt(repeatDate.format('M'));
				  if ($('input.repeat-month-'+ repeatDateName).is(':checked'))
				  {
					  aRepeateDate = [];
					  aRepeateDate['start'] =  repeatDate.format(dateFormat);
					  aRepeateDate['end'] =  repeatEndDate.format(dateFormat);
					  $.each(aDateArray, function(indexDate, aDate){
						  if (aDate['start'] == aRepeateDate['start'])
						  {
							  allowRepeat = false;
							  return false;
						  }
					  });
					  if (allowRepeat)
						  aDateArray.push(aRepeateDate);
				  }
			  }
			  $.each(aDateArray, function(index, repeatDate){
				  // Keep only main event id to update, other repeat will be create new
				  if (index > 0)
					  $('#booking_event_id').val('');

				  var eventData = {
							title: title,
							start: moment(repeatDate['start'] + 'T' + startHour.format(timeFormatDefault), dateFormat + 'T' + timeFormatDefault),
							end: moment(repeatDate['end'] + 'T' + endHour.format(timeFormatDefault), dateFormat + 'T' + timeFormatDefault),
							className : "available",
							editable: true,
							type: $('#view_id').val(),
							color: '#BABBBF',
							eventColor: '#000',
							overlap: false,
							constraint: null,
							backgroundColor: '#3a87ad',
						};
				  
				  aEventData.push(eventData);
			  })
		  }
		  // Save data to database;
		  $.each(aEventData, function(index, eventData){
			  saveEventData(eventData);
		  });

		  	revertEventFunc = null;
		  	$('#bookingModal').modal('hide');
			e.preventDefault();
		  return false;
	  }
	});

	function reRenderCalendar() {
        var calendar = $('.space-calendar.active').fullCalendar('getCalendar');
        var view = calendar.view;
        currentDay = view.start.format(dateFormat);
		$('.space-calendar.active').fullCalendar('destroy');
		renderCalendar();
    }

	$('body').on('afterButtonClick', '.fc-prev-button, .fc-next-button, .fc-today-button', function(){
		if ($('#view_id').val() == 'HourSpace')
		{
			setTimeout(function(){
				reRenderCalendar();
			}, 100);
		}
	});
	
	function verticalCalendarTabs(){
		var verticalTabs = [];
		var horizontalTabs = [];
		var tabHorizontalIndex;
	    $('#calendar_tabs_wraper').responsiveTabs({
	        rotate: false,
	        startCollapsed: 'accordion',
	        collapsible: 'accordion',
	        //setHash: true,
	        //disabled: [3,4],
	        activate: function(e, tab) {
	        	var selector = $(tab.selector);
	        	var tabHorizontalIndex = tab.id + 1;
	        	if (horizontalTabs.indexOf(tab.selector) != -1){
//	        		return;
	        	}
	        	horizontalTabs.push(tab.selector);
	        	
	        	$('li.main-calendar').each(function(){
	        		$(this).unbind('click');
	        	})
	        	
	        	$('div.calendar_horizontal_wraper').each(function(){
	        		$(this).unbind('tabactivate');
	        	})
	        	
	        	selector.easyResponsiveTabs({
					type: 'vertical',
			        width: 'auto',
			        fit: true,
			        tabidentify: 'main-calendar',
			        activetab_bg: '#fff', // background color for active tabs in this group
			        inactive_bg: '#F5F5F5', // background color for inactive tabs in this group
			        active_border_color: '#c1c1c1', // border color for active tabs heads in this group
			        active_content_border_color: '#5AB1D0', // border color for active tabs contect in this group so that it matches the tab head border
					activate: function(event){
						firstLoading = true;
						var tabIndex = $(event.target).index();
						if(tabIndex > 0 && event.target.tagName == "H2"){
							tabIndex = tabIndex /2;
						}
						// faraz work
						var contentSelector = $('#space_calendar_'+ tabHorizontalIndex + tabIndex);
//						if (verticalTabs.indexOf(tabIndex) != -1) return;
						//verticalTabs.push(tabIndex);
						
						jQuery("#space_calendar_content_wraper_" + tabHorizontalIndex).LoadingOverlay("show");
						// Empty all calendar before render new calendar with tab
						$('.space-calendar-content').html('');
						// Set space ID for new calendar can use.
						var spaceID = contentSelector.attr('data-spaceID');
						$('#booking_form input[name="SpaceID"]').val(spaceID);

						// Call ajax to load
						var calendar_url = globalUserType == 1 ? (SITE_URL + 'ShareUser/Dashboard/MySpace/Calendar?spaceID='+spaceID) : (SITE_URL + 'RentUser/Dashboard/Calendar?spaceID='+spaceID);
						$.get(
							calendar_url,
							function(data) {
								var spaceCalendar = $('.space-calendar').clone();
								spaceCalendar.addClass('active');
								contentSelector.html(data);
								contentSelector.prepend(spaceCalendar);
								$('.space-calendar.active').fullCalendar('destroy');
								renderCalendar();
								jQuery("#space_calendar_content_wraper_" + tabHorizontalIndex).LoadingOverlay("hide");
							}

						)
					}
				});
	        },
	        activateState: function(e, state) {
	            //$('.info').html('Switched from <strong>' + state.oldState + '</strong> state to <strong>' + state.newState + '</strong> state!');
	        }
	    });
	    
	}

	function renderCustomButton(name, text)
	{
		var data = {};
    	data['_token'] = $('#booking_form #calendar_token').val();
    	data['SpaceID'] = $('#booking_form input[name="SpaceID"]').val();
    	data['calAction'] = 'getEvents';
		data['Type'] = name;
		return button = {
            text: text,
            click: function() {
            	showHideInprogressBackground('show');
            	var calendar_url = globalUserType == 1 ? (SITE_URL + 'ShareUser/Dashboard/MySpace/Calendar?spaceID=' + data['SpaceID']) : (SITE_URL + 'RentUser/Dashboard/Calendar?spaceID=' + data['SpaceID']);
            	$.ajax({
        			url: calendar_url,
        			method: 'get',
        			dataType: 'json',
        			success: function(response){
        				if (response)
        				{
        					calendarEvents = response.calendarEvents;
        					timeRange = response.timeRange;

        					//Change timerange format
        					$.each(timeRange, function(dayName, data){
        						timeRange[dayName].opening_start = moment(data.opening_start, 'hh:mm A').format(timeFormat);
        						timeRange[dayName].opening_end = moment(data.opening_end, 'hh:mm A').format(timeFormat);
        					});

        					defaultCalendarView = name;
        					switch(name)
        					{
	        					case 'HourSpace' :
	        						eventTimeFormat = 'Ah(:mm)';
	    							break;
        						case 'DailySpace' :
        							eventTimeFormat = 'Ah(:mm)';
        							break;
        						case 'WeeklySpace':
        						case 'MonthlySpace':
        							eventTimeFormat = ' ';
        							break;
        					}

        					$('.space-calendar.active').fullCalendar('destroy');
        					renderCalendar();
        					$('.space-calendar.active').css('opacity', 1);
        				}
        				showHideInprogressBackground('hide');
        			},
        			error: function(){
        				showHideInprogressBackground('hide');
        			}
        		});
            }
        }
	}

	function disablePastDate(date, view, cell) {

		if (!cell || !cell.length) false;
		if (!timeRange) return false;

		var cellDay = date.format(dateFormat);
		var dayData = getDayData(cell, view);
		if (view.type == "MonthlySpace")
		{
			if (moment().diff(date, 'months') > 0){
	            $(cell).addClass('disabled');
	            return false;
	        }
		}
		else {
			if (dayData.closed == true || moment().diff(date, 'days') > 0){
	            $(cell).addClass('disabled');
	            return false;
	        }
		}
		return true;
	}
	function renderCalendar(){
		dateCommonPicker();
		timeCommonPicker();

		$('.space-calendar.active').fullCalendar({
			customButtons: {
				HourSpaceCustom: renderCustomButton('HourSpace', '時間毎'),
		        DailySpaceCustom: renderCustomButton('DailySpace', '日毎'),
		        WeeklySpaceCustom: renderCustomButton('WeeklySpace', '週毎'),
		        MonthlySpaceCustom: renderCustomButton('MonthlySpace', '月毎'),
		    },
			header: {
				left: 'prev,next today',
				center: 'title',
				right: feeType + ',' + customButtons
			},
			lang: 'ja',
			timeFormat: eventTimeFormat,
			axisFormat: 'H:mm',
			timezone: 'local',
			displayEventEnd: true,
			defaultDate: currentDay,
			allDaySlot: false,
			selectOverlap: false,
			eventOverlap: false,
			droppable: true,
			selectable: true,
			selectHelper: true,
			editable: true,
			slotDuration: hourDuration,
			defaultTimedEventDuration: hourDuration,
			weekends: true,
			weekNumbers: true,
			eventLimit: true, // allow "more" link when too many events
			firstDay: 1, // Set first day of week is monday - 0 is sunday
			//minTime: minTime,
			//maxTime: maxTime,
			longPressDelay: 500,

			views: {
				MonthlySpace: {
					type: 'year',
					buttonText: '月毎',
					selectable: true,
					weekNumbers: false,
				},
				WeeklySpace: {
					type: 'month',
					buttonText: '週毎',
					selectable: true,
				},
				DailySpace: {
					type: 'month',
		            buttonText: '日毎',
		            weekNumbers: false,
		            selectable: true,
				},
				HourSpace: {
		            type: 'agenda',
		            duration: { weeks: 1 },
		            buttonText: '時間毎',
		            weekNumbers: false,
		        }
		    },

			eventLimitClick: 'popover',
			viewRender: function( view, element ){
				var disablePrevButton = false;
				var disableNextButton = false;

				// Reset default show buttons
				$('.fc-toolbar .fc-prev-button').show();
				$('.fc-toolbar .fc-next-button').show();

				$('#booking_form .form-wraper-group').hide();
				$('#booking_form .duration_wraper').hide();
				$('#view_id').val(view.type);

				switch(view.type) {
					case "MonthlySpace" :
						var maxLimit = moment().add(limitYears, 'years').format(yearFormat);
						var currentDate = moment().format(yearFormat);
						var currentSelected = view.calendar.getDate().format(yearFormat);
						showHideNavButton(currentSelected, currentDate, maxLimit);
						break;
					case "WeeklySpace" :
					case "DailySpace" :
						var maxLimit = moment().add(limitMonths, 'months').format(monthFormatOnly);
						var currentDate = moment().format(monthFormatOnly);
						var currentSelected = view.calendar.getDate().format(monthFormatOnly);
						showHideNavButton(currentSelected, currentDate, maxLimit);
						break;
					case "HourSpace" :
						moment().startOf('isoweek');
						var maxLimit = moment().startOf('isoweek').add(4 * limitMonths, 'weeks').format(dateFormat);
						var currentDate = moment().startOf('isoweek').format(dateFormat);
						var currentSelected = moment(view.calendar.getDate()).startOf('isoweek').format(dateFormat);
						showHideNavButton(currentSelected, currentDate, maxLimit);
						break;	
				}


				// Show hide form fields
				$('.fc-week').removeClass('week-tab');
				switch(view.type) {
				case "MonthlySpace" :
					$('#booking_form .year-group').show();
					$('#booking_form .monthly-duration').show();
					break;
				case "WeeklySpace" :
					$('#booking_form .week-group').show();
					$('.fc-week').addClass('week-tab');
					$('#booking_form .weekly-duration').show();
					isWeekTab = true;
					break;
				case "DailySpace" :
					$('#booking_form .day-group').show();
					$('#booking_form .daily-duration').show();
					break;
				case "HourSpace" :
					$('#booking_form .hour-group').show();
					$('#booking_form .hourly-duration').show();
					break;
				}
			},
			eventDestroy : function(event, element, view ){
				// Reset available class for event
				$('.fc-day').removeClass('available');
		    	$('.fc-day-number').removeClass('available');
		    	$('.fc-month-name').removeClass('available');
			},
			dayRender: function(date, cell, view){
				if (view.type == 'HourSpace' || view.type == 'DailySpace' || view.type == 'WeeklySpace') {
					HolidayDateTime.setDate(date.format(calendarDateFormat));
					isHoliday = HolidayDateTime.holiday();
					if (isHoliday)
					{
						// Set holiday date column
						cellIndex = cell[0].cellIndex;
						cell.addClass('is-holiday');
						cell.addClass('fc-sun');
						if (view.type == 'HourSpace')
						{
							cell.closest('.space-calendar').find('thead.fc-head table th:eq('+ cellIndex +')').addClass('is-holiday');
							cell.closest('.space-calendar').find('thead.fc-head table th:eq('+ cellIndex +')').addClass('fc-sun');
						}
					}
				}
			},
		    eventRender: function(event, element, view){
		    	var eventStart = event.start;
		    	var eventEnd = event.end;
		    	var diffDays = eventEnd ? eventEnd.diff(eventStart, 'days') : 0;

		    	if (view.type == 'MonthlySpace')
				{
		    		var duration = moment(moment().startOf('month').format(dateFormat), dateFormat).diff(moment(event.start.format(dateFormat), dateFormat), 'months');
					if (duration >= 0)
						$(element).addClass('disabled');
				}
				else if (view.type == 'WeeklySpace')
				{
					var duration = moment(moment().startOf('isoweek').format(dateFormat), dateFormat).diff(moment(event.start.format(dateFormat), dateFormat), 'weeks');
					if (duration > 0)
						$(element).addClass('disabled');
				}
				else if (view.type == 'DailySpace')
				{
					var duration = moment(moment().format(dateFormat), dateFormat).diff(moment(event.start.format(dateFormat), dateFormat), 'days');
					if (duration > 0)
						$(element).addClass('disabled');
				}
		        else if (view.type == 'HourSpace')
				{
					var duration = moment(moment().format(dateFormat), dateFormat).diff(moment(event.start.format(dateFormat), dateFormat), 'days');
					if (duration > 0)
						$(element).addClass('disabled');
				}
		    	
		    	// Add popover to a events
		    	if (event.className == 'booked' && event.description) {
		    		$(element).attr('data-toggle', 'popover');
		    		$(element).attr('title', '予約内容');
		    		$(element).attr('data-content', event.description);
		    		$(element).attr('data-placement', 'top');
		    		$(element).attr('data-trigger', 'hover');
		    		$(element).popover({
		    			container: 'body',
		    			html : true 
		    		});
		    		
		    		$(element).on('click', function(){
		    			$('#booking_popup_content').html(event.description);
		    			var remodal = jQuery('#booking_modal').remodal();
		    			remodal.open();
		    		});
		    	}
		    	
		        // Show only centain events base on view type
		        if (event.type && event.type != view.type)
		        	return false;
		    },
		    eventAfterRender:function(event, element, view){
				$(element).addTouch();
		    	var eventDate = event.start.format(dateFormat);
		    	var eventRow = $(element).closest('.fc-row');
		    	var eventClass = event.className;
		    	var eventStatus = event.status;
		    	eventClass = eventClass[0];
		    	
		    	eventRow.find('.fc-day').each(function(gridIndex){
					var gridDate = $(this).data('date');
					var dayGrid = $(this);
					var startDate = moment(event.start).format(dateFormat);
					if (defaultCalendarView == 'MonthlySpace' || defaultCalendarView == 'WeeklySpace')
					{
						// Diable current month in MonthView
						if (defaultCalendarView == 'MonthlySpace' && dayGrid.hasClass('fc-today'))
						{
							dayGrid.addClass('fc-past');
						}
						var endDate = moment(event.end).subtract(1, 'days').format(dateFormat);
					}
					else {
						var endDate = moment(event.end).format(dateFormat);
					}
					if (gridDate >= startDate && gridDate <= endDate)
					{
							if (defaultCalendarView == 'MonthlySpace' && dayGrid.hasClass('fc-today') && eventClass != 'booked')
							{
								// Do nothing here
							}
							else {
								
								dayGrid.addClass(eventClass + ' ' + eventStatus);
								eventRow.find('.fc-day-number[data-date="'+ gridDate +'"]').addClass(eventClass + ' ' + eventStatus);
								eventRow.find('.fc-month-name[data-date="'+ gridDate +'"]').addClass(eventClass + ' ' + eventStatus);
							}
					}
					
					if (defaultCalendarView == 'WeeklySpace')
					{
						dayGrid.attr('data-slotid', event.id);
						element.attr('data-slotid', event.id);
						eventRow.find('.fc-day-number[data-date="'+ gridDate +'"]').attr('data-slotid', event.id);
						eventRow.find('.fc-month-name[data-date="'+ gridDate +'"]').attr('data-slotid', event.id);
					}
				});
		    	
		    	if (defaultCalendarView != 'WeeklySpace')
		    	{
		    		if (event.is_single)
		    		{
		    			element.addClass('is_single');
		    		}
		    		element.attr('data-slotid', event.id);
		    		element.attr('data-startdate', moment(event.start).format(dateFormat));
		    		element.attr('data-starttime', moment(event.start).format(timeFormatDefault));
		    		element.attr('data-endtime', moment(event.end).format(timeFormatDefault));
			    	eventRow.find('.fc-day[data-date="'+ eventDate +'"]').attr('data-slotid', event.id);
					eventRow.find('.fc-day-number[data-date="'+ eventDate +'"]').attr('data-slotid', event.id);
					eventRow.find('.fc-month-name[data-date="'+ eventDate +'"]').attr('data-slotid', event.id);
		    	}
		    },
			select: function(start, end, jsEvent, view, resouce) {
				if (moment().diff(start, 'hours') >= 1)
					return false;
				
				var eventData = {
					start: start,
					end: end
				};
				
				// Check end time is valid opening hours or not
				var selectedDayElement = $('td.fc-day[data-date="'+ start.format(calendarDateFormat) +'"]');
				$.each(timeRange, function(dayName, data){
					if (selectedDayElement.hasClass(dayName))
					{
						selectedDay = data;
						return false;
					}
				});
				var opening_end = moment(selectedDay.opening_end, timeFormatDefault);
				var startEvent = moment(start.format(timeFormatDefault), timeFormatDefault);
				diffHour = opening_end.diff(startEvent, 'hours');
				if (diffHour < hourMinTerm)
				{
					alert('Min hour limited is ' + hourMinTerm + ', Please choose another time range.');
					return false;
				}
				else {					
					regenerateTimePicker(eventData, view);
					showModalEditTime(eventData, view);
				}
			},
			eventDragStart: function( event, jsEvent, ui, view ) {
			},
			eventDrop: function( event, delta, revertFunc, jsEvent, ui, view  ) {
				var allowDrop = true;
				if (view.type == 'MonthlySpace')
				{
					event.end.add(5, 'days').startOf('month');
					if (moment().diff(event.start, 'months') > 0)
						allowDrop = false;
				}
				else if (view.type == 'WeeklySpace')
				{
					if (moment().diff(event.start, 'weeks') > 0)
						allowDrop = false;
				}
				else if (view.type == 'DailySpace' || view.type == 'HourSpace')
				{
					var duration = moment(moment().format(dateFormat), dateFormat).diff(moment(event.start.format(dateFormat), dateFormat), 'days');
					if (duration > 0)
						allowDrop = false;
				}

				if (allowDrop)
				{
					revertEventFunc = revertFunc;
					showModalEditTime(event, view, true);
				}
				else {
					revertFunc();
				}
			},
			eventResize:function( event, delta, revertFunc, jsEvent, ui, view  ) {
				revertEventFunc = revertFunc;
				showModalEditTime(event, view, true);
			},
			eventClick: function(event, jsEvent, view) {
				if (jQuery.inArray('booked', event.className) == -1)
				{
					removeDatePicker($('#booking_date_start'));
					dateCommonPicker();
					regenerateTimePicker(event, view);
					showModalEditTime(event, view);
					$('body').trigger('afterEventClick', [event.id, jsEvent.currentTarget, event.start, event.end]);
				}
			},
			dayClick: function(date, jsEvent, view)
	        {
				isBackgroundEdited = false;
				var clickedDate = date.format(dateFormat);
				$('#booking_day_clicked').val(clickedDate);

				if (!$(this).hasClass('fc-past'))
		        {
					removeDatePicker($('#booking_date_start'));
					removeDatePicker($('#booking_month_start'));
	    			dateCommonPicker();

					// Render date popup for weekly space
	    			if (view.type == 'MonthlySpace')
					{
						var startTime = moment(date).startOf('month');
						var endTime = moment(startTime).add(monthMinTerm, 'months');
					}
	    			else if (view.type == 'WeeklySpace')
					{
						var startTime = moment(date).startOf('isoweek');
						var endTime = moment(startTime).add(weekMinTerm, 'weeks');
						if ($('.fc-day[data-date="'+ startTime.format(dateFormat) +'"]').hasClass('fc-past'))
							return false;
					}
					else
					{
						// Render date time popup for Daily, hourly space
			        	var eventData = {
		    				start: date,
		    				end: moment(date).add(hourMinTerm, 'hours')
		    			};
			        	
						if ($(jsEvent.target).hasClass('fc-bgevent') && !$(jsEvent.target).hasClass('fc-nonbusiness')) {
							var startTime = moment($(jsEvent.target).data('startdate') + 'T' + $(jsEvent.target).data('starttime'), calendarDateFormat + 'T' + timeFormatDefault);
							var endTime =   moment($(jsEvent.target).data('startdate') + 'T' + $(jsEvent.target).data('endtime'), calendarDateFormat + 'T' + timeFormatDefault);
							isBackgroundEdited = true;
				        }
						else {
				        	eventData = regenerateTimePicker(eventData, view);
				        	var startTime = eventData.start;
							var endTime = eventData.end;
						}
					}

	    			if (isBackgroundEdited)
	    			{
	    				eventData = {
		        				start: startTime,
		        				end: endTime,
		        				_id: $(jsEvent.target).data('slotid')
		        			};
	    			}else {
	    				eventData = {
		        				start: startTime,
		        				end: endTime
		        			};
	    			}
	    			
	    			if (view.intervalUnit == 'month' || view.intervalUnit == 'year' || isBackgroundEdited)
	    			{
	    				showModalEditTime(eventData, view);
	    			}
		        }
	        },
	        loading: function(bool) {
				$('#loading').toggle(bool);
			},

			businessHours: getBusinessHours(),
			selectConstraint: 'businessHours',
			eventConstraint: 'businessHours',
		    events: calendarEvents,
			eventAfterAllRender: function() {
				if ($('.fc-right').find('.fc-state-active').length == 0)
				{
					$('.fc-'+defaultCalendarView+'Custom-button').addClass('fc-state-active');
					$('.fc-'+defaultCalendarView+'-button').trigger('click');
					if (firstLoading)
						$('.space-calendar.active').css('opacity', 1);
				}

				$('.fc-row.fc-week').each(function(){
					if (!$(this).find('.fc-bgevent-skeleton').length && $(this).find('.fc-week-number').length && !$(this).find('.fc-past').length)
					{
						$(this).find('.fc-bg').addClass('hover-enable');
						$(this).find('.fc-content-skeleton').addClass('hover-enable');
					}
				})

				$('.fc-row.fc-week').each(function(){
					if ($(this).find('.fc-bgevent-skeleton').length && $(this).find('.fc-week-number').length && !$(this).find('.fc-past').length)
					{
						$(this).find('.fc-bgevent-skeleton').find('.fc-week-number').next('td').addClass('hover-enable');
					}
				});
				
//				if (defaultCalendarView == 'MonthlySpace')
//					$('.fc-day-grid-event').css('padding-top', ($('.fc-day-grid-event').height() - 20)/2 + 'px')
//				else if (defaultCalendarView == 'WeeklySpace')
//					$('.fc-day-grid-event').css('padding-top', ($('.fc-day-grid-event').height() - 30)/2 + 'px')
//				else if (defaultCalendarView == 'DailySpace')
//					$('.fc-day-grid-event').css('padding-top', ($('.fc-day-grid-event').height() - 50)/2 + 'px')
			},
		});

	}

	if ($('#calendar_tabs_wraper').length)
		verticalCalendarTabs();
	else
	{
		// Call ajax to load
		$.get(
			calendarURL,
			function(data) {
				var contentSelector = $('#space_calendar');
				var spaceCalendar = $('.space-calendar').clone();
				spaceCalendar.addClass('active');
				contentSelector.html(data);
				contentSelector.prepend(spaceCalendar);
				$('.space-calendar.active').fullCalendar('destroy');
				renderCalendar();
				jQuery("#space_calendar_content_wraper").LoadingOverlay("hide");
			}

		)
		
	}
	
	
	$.fn.validator.Constructor.FOCUS_OFFSET = '100000000';
});
