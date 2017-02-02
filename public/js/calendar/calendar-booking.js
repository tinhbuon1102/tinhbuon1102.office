jQuery(document).ready(function($) {
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
	var timeFormat = 'AH:mm';
	var timeFormatDefault = 'H:mm A';
	var timePickerFormat = 'AH:i';
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

	function getDaysClosed () {
		//find closed days to calculate end day
		var intDayClosed = 0;
		$.each(timeRange, function(dayName, data){
			if (data.closed)
				intDayClosed ++;
		});
		return intDayClosed;
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


	function CapitalizeString(string)
	{
		return string.charAt(0).toUpperCase() + string.slice(1);
	}

	function replaceDayMonthYearJapanToDefault(str){
		str = str.replace(/年|月/g,'-');
		str = str.replace(/日/g,'');
		return str;
	}
	function renderCustomButton(name, text)
	{
		var data = {};
    	data['_token'] = $('#csrf-token').val();
    	data['SpaceID'] = globalSpaceID;
    	data['calAction'] = 'getEvents';
		data['Type'] = name;
		return button = {
            text: text,
            click: function() {
            	showHideInprogressBackground('show');
            	$.ajax({
        			url: calendarURL,
        			method: 'post',
        			dataType: 'json',
        			data: data,
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
			axisFormat: 'h:A',
			timezone: 'local',
			displayEventEnd: true,
			defaultDate: currentDay,
			allDaySlot: false,
			selectOverlap: false,
			eventOverlap: false,
			droppable: false,
			selectable: false,
			selectHelper: false,
			editable: false,
			slotDuration: hourDuration,
			defaultTimedEventDuration: hourDuration,
			weekends: true,
			weekNumbers: true,
			eventLimit: true, // allow "more" link when too many events
			firstDay: 1, // Set first day of week is monday - 0 is sunday
			//minTime: minTime,
			//maxTime: maxTime,

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
				$('#view_id').val(view.type);
				switch(view.type) {}

				// Show hide form fields
				$('.fc-week').removeClass('week-tab');
				switch(view.type) {
				case "WeeklySpace" :
					$('.fc-week').addClass('week-tab');
					break;
				}
			},
			dayRender: function(date, cell, view){
				if (view.type == 'HourSpace' || view.type == 'DailySpace' || view.type == 'WeeklySpace') {
					HolidayDateTime.setDate(date.format(calendarDateFormat));
					isHoliday = HolidayDateTime.holiday();
					if (isHoliday)
					{
						console.log(isHoliday);
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
		    	
		    	// Add popover to booked events
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
		    	}
		    	
		        // Show only centain events base on view type
		        if (event.type && event.type != view.type)
		        	return false;
		    },
		    eventAfterRender:function(event, element, view){
		    	var eventDate = event.start.format(dateFormat);
		    	var eventRow = $(element).closest('.fc-row');
		    	var eventClass = event.className;
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
							if (defaultCalendarView == 'MonthlySpace' && dayGrid.hasClass('fc-today'))
							{
								// Do nothing here
							}
							else {
								dayGrid.addClass(eventClass);
								eventRow.find('.fc-day-number[data-date="'+ gridDate +'"], .fc-month-name[data-date="'+ gridDate +'"]').addClass(eventClass);
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
		    	
		    	$('body').trigger('afterEventRendered', [event, element, view]);
		    },
			eventClick: function(event, jsEvent, view) {
				$('body').trigger('afterEventClick', [ event, jsEvent, view ]);
			},
			dayClick: function(date, jsEvent, view) {
				if ($(jsEvent.target).is('th') || $(jsEvent.target).hasClass('fc-day-number'))
				{
					var slotID = $(jsEvent.target).data('slotid');
					var eventRow = $(jsEvent.target).closest('.fc-row');
					eventRow.find('.fc-event[data-slotid="'+ slotID +'"]').trigger('click');
				}
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
				
				$('body').trigger('afterAllRender');
			},
		});

	}

	$('#myModal').on('show.bs.modal', function () {
		if (!$('#space_calendar').html())
		{
			$('#myModal .modal-content').LoadingOverlay("show");
			$.ajax({
				url: calendarURL,
				dataType: 'html',
				async: true,
				method: 'get',
				success: function(data) {
					var contentSelector = $('#space_calendar');
					var spaceCalendar = $('.space-calendar').clone();
					spaceCalendar.addClass('active');
					contentSelector.html(data);
					contentSelector.prepend(spaceCalendar);
					setTimeout(function(){
						renderCalendar();
						$('body').trigger('myModalShowUp');
						$('#myModal .modal-content').LoadingOverlay("hide");
						
						if (!$('.space-calendar.active .fc-scroller').length) {
							$('.fc-today-button').trigger('click');
						}
						
						$('#myModal .modal-dialog').trigger('touchstart');
						$('#myModal .modal-dialog').focus();
					}, 200);
				}
			})
		}
	});
	
	$.fn.validator.Constructor.FOCUS_OFFSET = '100000000';
});
