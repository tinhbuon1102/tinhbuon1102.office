jQuery(function($){
	var japanDateFormat = 'YYYY年MM月DD日';
	var dateFormat = 'YYYY-MM-DD';
	var japanTimeFormat = 'H:mm';
	var timeFormatDefault = 'H:00:00';
	var gotoDate = false;
	
	aSelectedSlots = [];
	aSelectedSlotIds = jQuery('#spaceslots_id').val() ? jQuery('#spaceslots_id').val().split(';') : [];
	aSelectedSlotDates = jQuery('#booked_date').val() ? jQuery('#booked_date').val().split(';') : [];
	$.each(aSelectedSlotIds, function(indexSlot, slotID) {
		aSelectedSlots[indexSlot] = {};
		aSelectedSlots[indexSlot]['slotID'] = slotID;				
		aSelectedSlots[indexSlot]['startDate'] = aSelectedSlotDates[indexSlot];
	});
	
	function getSelectedDateIDs(){
		var aSlotIds = [];
		var aSlotIDates = [];
		$.each(aSelectedSlots, function(indexSlot, aSlot) {
			aSlotIds.push(parseInt(aSlot.slotID));
			aSlotIDates.push(aSlot.startDate);
		});
		aSlotIds.sort();
		aSlotIDates.sort();
		
		$.each(aSlotIDates, function(indexSlot, slotDate) {
			if (indexSlot == aSlotIDates.length - 1)
			{
				if (globalSpaceType == 'WeeklySpace' || globalSpaceType == 'MonthlySpace')
				{
					var type = globalSpaceType == 'WeeklySpace' ? 'isoweek' : 'month';
					var startDate = moment(aSlotIDates[0], dateFormat).format(japanDateFormat);
					var endDate = moment(slotDate, dateFormat).endOf(type).format(japanDateFormat);
					$('#calendar_picker').val(startDate + ' ~ ' + endDate);					
				}
				else if (globalSpaceType == 'DailySpace')
				{
					var startDate = moment(aSlotIDates[0], dateFormat).format(japanDateFormat);
					var endDate = moment(slotDate, dateFormat).format(japanDateFormat);
					var strDate = aSelectedSlots.length > 1 ? (startDate + ' ~ ' + endDate) : startDate;
					$('#calendar_picker').val(strDate);					
				}
				else {
					$('#calendar_picker').val(moment(slotDate, dateFormat).format(japanDateFormat));
				}
				
			}
		});
		
		return {'slotIDs': aSlotIds, 'slotDates' : aSlotIDates}
	}
	
	function updateStepCommon(response) {
		$('#tfromtime').html(response.timeDefaultSelected.StartTimeConverted);
		$('#toendtime').html(response.timeDefaultSelected.EndTimeConverted);
		$('.fromtimed-value').html(response.timeDefaultSelected.StartTimeConverted);
		$('.endtimed-value').html(response.timeDefaultSelected.EndTimeConverted);
		
		$('input[name="startTime"]').val(response.timeDefaultSelected.StartTime);
		$('input[name="endTime"]').val(response.timeDefaultSelected.EndTime);
		
		$('#fromtime').html('');
		$.each(response.aAvailableTimeFromList, function(index, value){
			// Build time list
			var myTime = value + '00:00';
			var timeDefault = moment(myTime, timeFormatDefault);
			$('#fromtime'). append('<div class="wlp-time-picker-item fromtimer selectable " data-value="'+ timeDefault.format(timeFormatDefault) +'">'+ timeDefault.format(japanTimeFormat) +'</div>');
		});
		
		$('#endtime').html('');
		$.each(response.aAvailableTimeToList, function(index, value){
			// Build time list
			var myTime = value + '00:00';
			var timeDefault = moment(myTime, timeFormatDefault);
			$('#endtime'). append('<div class="wlp-time-picker-item totimer selectable " data-value="'+ timeDefault.format(timeFormatDefault) +'">'+ timeDefault.format(japanTimeFormat) +'</div>');
		})
	}
	function updateStep1PageInfo(response){
		$('#space-price .price').fadeOut(function(){
			$(this).html(response.aPrice[0].price);
    		$(this).fadeIn(function(){});
	    });
		
		$('.display-duration-value').fadeOut(function(){
			$(this).html(response.duration);
    		$(this).fadeIn(function(){});
	    });
		
		$('.display-subtotal-value').fadeOut(function(){
			$(this).html(response.totalPrice);
    		$(this).fadeIn(function(){});
	    });
		
		updateStepCommon(response);
	}
	
	function updateStep2PageInfo(response){
		updateStepCommon(response);
		
		$('ul.selected-date').html('');
		$.each(response.bookedDate, function(index, value){
			// Build Date list
			var bookedDate = moment(value, dateFormat);
			var strDate = '';
			
			switch (globalSpaceType) {
				case 'DailySpace':
					strDate = bookedDate.format(japanDateFormat);
					break;
				case 'WeeklySpace':
					strDate = bookedDate.format(japanDateFormat) + ' ~ ' + moment(bookedDate).add(1, 'weeks').subtract(1, 'days').format(japanDateFormat);
					break;
				case 'MonthlySpace':
					strDate = bookedDate.format(japanDateFormat) + ' ~ ' + moment(bookedDate).add(1, 'months').subtract(1, 'days').format(japanDateFormat);
					break;
			}
			$('ul.selected-date').append('<li>'+ strDate +'</li>');
		});
		
		$('#booking-summary-block').html(response.summary);
	}
	
	function getBookingHourInfo(){
		if (globalSpaceType != 'HourSpace')
		{
			var selectedDateIds = getSelectedDateIDs();
			aSlotIds = selectedDateIds.slotIDs;
			aSlotIDates = selectedDateIds.slotDates;
			
			$('#booked_date').val(aSlotIDates.join(';'));
			$('#spaceslots_id').val(aSlotIds.join(';'));
		}
		
		
		$.ajax({
			url : getHourURL,
			data: $('#editReservationForm').serialize(),
			success: function(response) {
				if (globalStep == 1) {
					updateStep1PageInfo(response);
				}
				else if (globalStep == 2) {
					updateStep2PageInfo(response);
				}
			}	
		});
	}
	
	function checkDateIsConsecutive(selectedDate, action) {
		// Check only for Monthly or Weekly
		var selectedDateIds = getSelectedDateIDs();
		
		aSlotIds = selectedDateIds.slotIDs;
		aSlotIDates = selectedDateIds.slotDates;
		
		if (globalSpaceType != 'MonthlySpace' && globalSpaceType != 'WeeklySpace') {
			return true;
		}
		if (aSlotIDates.length <= 0 || ($.inArray(selectedDate, aSlotIDates) != -1 && action == 'add'))
			return true;
		
		aSlotIDates.sort();
		var isConsecutive = true;
		var oSelectedDate = moment(selectedDate, dateFormat);
		
		if (globalSpaceType == 'MonthlySpace')
		{
			var prevDate = moment(oSelectedDate).subtract(1, 'months').format(dateFormat);
			var nextDate = moment(oSelectedDate).add(1, 'months').format(dateFormat);
		}
		else if (globalSpaceType == 'WeeklySpace')
		{
			var prevDate = moment(oSelectedDate).subtract(1, 'weeks').format(dateFormat);
			var nextDate = moment(oSelectedDate).add(1, 'weeks').format(dateFormat);
		}
		
		
		if ((action == 'add' && $.inArray(prevDate, aSlotIDates) == -1 && $.inArray(nextDate, aSlotIDates) == -1) ||
			(action == 'remove' && $.inArray(prevDate, aSlotIDates) > -1 && $.inArray(nextDate, aSlotIDates) > -1)
		)
		{
			isConsecutive = false;
			return false;
		}
		
		return isConsecutive;
	}
	
	function resetBookingForm(){
		$('#tfromtime').html('');
		$('#toendtime').html('');
		$('.fromtimed-value').html('');
		$('.endtimed-value').html('');
		$('#fromtime').html('');
		$('#endtime').html('');
		$('input[name="startTime"]').val('');
		$('input[name="endTime"]').val('');
	}
	
	$('#datepicker').datepicker({
		format: japanDateFormat.toLowerCase(),
		language: "ja",
		weekStart: 1,
		todayHighlight: true,
		todayBtn: true,
		autoclose: true,
		beforeShowDay: function(date){
	         var d = date;
	         var curr_date = d.getDate() + "";
	         curr_date = curr_date.length == 1 ? "0" + curr_date : curr_date;
	         var curr_month = (d.getMonth() + 1) + "";
	         var curr_year = d.getFullYear() + "";
	         var formattedDate = curr_year + '-' + curr_month + '-' + curr_date;

	         if ($.inArray(formattedDate, active_dates) != -1){
	           return {
	              classes: 'activeClass'
	           };
	         } else {
	        	 return false;
	         }
	      return;
	  }
	}).on('changeDate', function (ev) {
		resetBookingForm();
		$('#booked_date').val(moment($(this).val(), japanDateFormat).format(dateFormat));
		getBookingHourInfo();
	});
	
	function populateSlots(event, element, view, isCall) {

		var eventID = event.id;
		var eventStartDate = event.start.format(dateFormat);
		var elementRow = element.closest('.fc-row');
		
		if (event.className == 'available')
		{
			var dateSelected = event.start.format(dateFormat);
			// Change name, background
			if (elementRow.find('[data-slotid="'+ eventID +'"]').hasClass('selected'))
			{
				if (!checkDateIsConsecutive(eventStartDate, 'remove'))
				{
					alert(consecutive_error);
				}
				else {
					// Make event back to available
					if (aSelectedSlots.length == globalMinTerm)
					{
						alert(messageMintemError);
					}
					else {
						element.find('.fc-title').text(scheduleAvailableText);
						elementRow.find('[data-slotid="'+ eventID +'"]').removeClass('selected');
						aSelectedSlots = aSelectedSlots.filter(function(el) {
						    return el.slotID != eventID;
						});
					}
				}
			}else {
				if (!checkDateIsConsecutive(eventStartDate, 'add'))
				{
					alert(consecutive_error);
				}
				else {
					// Make event  to selected
					element.find('.fc-title').text(scheduleSelectedText);
					elementRow.find('[data-slotid="'+ eventID +'"]').addClass('selected');
					var indexSlot = aSelectedSlots.length;
					var isAllowPush = true;
					if (aSelectedSlots.length)
					{
						$.each(aSelectedSlots, function(index, slotSelected){
							if (slotSelected['slotID'] == eventID)
							{
								isAllowPush = false;
							}
						});
					}
					
					if (isAllowPush)
					{
						aSelectedSlots[indexSlot] = {};
						aSelectedSlots[indexSlot]['slotID'] = eventID.toString();				
						aSelectedSlots[indexSlot]['startDate'] = eventStartDate;
					}
				}
			}
		}
		
		if (isCall)
		{
			getBookingHourInfo();
		}
	
	}
	$(document).on('afterEventClick', 'body', function(e, event, jsEvent, view){
		populateSlots(event, $(jsEvent.currentTarget), view, true);
	});
	
	$(document).on('afterEventRendered', 'body', function(e, event, element, view){
		var selectedDateIds = getSelectedDateIDs();
		aSlotIds = selectedDateIds.slotIDs;
		
		// convert EventID to string
		var eventID = parseInt(event.id);
		var slotExistIndex = $.inArray(eventID, aSlotIds);
		if (slotExistIndex != -1) {
			var isCall = slotExistIndex == aSlotIds.length - 1 ? true : false
			populateSlots(event, element, view, isCall);
		}
	});
	
	
	$(document).on('afterAllRender', 'body', function(){
		if (!gotoDate)
		{
			gotoDate = true;
			$.each(aSelectedSlots, function(indexSlot, aSlot) {
				$('.space-calendar.active').fullCalendar('gotoDate', aSlot.startDate);
				return false;
			});
		}
	});
	
	$('#myModal').on('hidden.bs.modal', function () {
		
	});
	
	$('body').on('click', '#calendar_picker', function(){
		$('#myModal').modal('show');
	});
	
	$('body').on('click', '.ajaxhourdata #maintime', function(){
		$('.ajaxhourdata #timewrap').slideToggle();
	});
	
	$('body').on('click', '.ajaxhourdata #fromtimed', function(){
		$('.ajaxhourdata #fromtime').slideToggle();
	});
	
	$('body').on('click', '.ajaxhourdata #endtimed', function(){
		$('.ajaxhourdata #endtime').slideToggle();
	});
	
	$('body').on('click', '.wlp-time-picker-item.fromtimer.selectable', function(){
		$('input[name="startTime"]').val($(this).data('value'));
		$('.fromtimed-value').text($(this).text());
		$('.ajaxhourdata #fromtime').slideToggle();
		getBookingHourInfo();
	});
	
	$('body').on('click', '.wlp-time-picker-item.totimer.selectable', function(){
		$('input[name="endTime"]').val($(this).data('value'));
		$('.endtimed-value').text($(this).text());
		$('.ajaxhourdata #endtime').slideToggle();
		getBookingHourInfo();
	});
	
	$('body').on('click', '#booking_button', function(e){
		e.preventDefault();
		
		var allowSubmit = true;
		
		if (!globalIsLogged) {
			jQuery('#login_form_content_wrapper').modal('show');
			return;
		}
		else if (globalUserType == 1)
		{
			if (confirm(errorUser1BookingMessage))
			{
				allowSubmit = false;
				location.href = '/User2/Login?spaceID=' + globalSpaceHashID;
			}
			return false;
		}
		
		if (globalSpaceType != 'HourSpace')
		{
			if (aSelectedSlots.length < globalMinTerm)
			{
				allowSubmit = false;
				alert(messageMintemError);
			}
		}
		else {
			// Check Duration is enough or not
			var startTime = $('input[name="startTime"]').val();
			var endTime = $('input[name="endTime"]').val();
			var duration = parseInt(endTime) - parseInt(startTime);
			if (duration < globalMinTerm)
			{
				allowSubmit = false;
				alert(messageMintemError);
			}
		}
		
		if (allowSubmit)
		{
			if (globalSpaceType != 'HourSpace')
			{
				var selectedDateIds = getSelectedDateIDs();
				aSlotIds = selectedDateIds.slotIDs;
				aSlotIDates = selectedDateIds.slotDates;
				
				$('#booked_date').val(aSlotIDates.join(';'));
				$('#spaceslots_id').val(aSlotIds.join(';'));
			}
			
			$('#editReservationForm').submit();
		}
	})
	
});