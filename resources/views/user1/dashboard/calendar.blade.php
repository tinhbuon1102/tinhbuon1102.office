<script>
//Define calendar variable
var hourlyPrice = '<?php echo $space->HourFee ? $space->HourFee : 2?>';
var dailyPrice = '<?php echo $space->DayFee ? $space->DayFee : 10 ?>';
var weeklyPrice = '<?php echo $space->WeekFee ? $space->WeekFee : 40 ?>';
var monthlyPrice = '<?php echo $space->MonthFee ? $space->MonthFee : 200 ?>';

var hourMinTerm = '<?php echo $space->HourMinTerm ? $space->HourMinTerm : 1 ?>';
var dayMinTerm = '<?php echo $space->DayMinTerm ? $space->DayMinTerm : 1 ?>';
var weekMinTerm = '<?php echo $space->WeekMinTerm ? $space->WeekMinTerm  : 1?>';
var monthMinTerm = '<?php echo $space->MonthMinTerm ? $space->MonthMinTerm : 1 ?>';
var eventTimeFormat = '<?php echo in_array($space->FeeType, array(1, 2, 5)) ? 'H:mm' : ' '; ?>' ;
var calendarEvents = <?php echo $calendarEvents?>;
var feeTypeArray = {
		1: 'HourSpace', 
		2: 'DailySpace', 
		3: 'WeeklySpace', 
		4: 'MonthlySpace', 
		5: 'DailySpace,HourSpace', 
		6: 'WeeklySpace,DailySpace', 
		7: 'MonthlySpace,WeeklySpace'};

<?php
if ($space->FeeType)
	echo "var feeType = feeTypeArray['". $space->FeeType ."']";
else
	echo "var feeType = 'MonthlySpace,WeeklySpace,DailySpace,HourSpace'";

$defaultRangeStart = '09:00 AM';
$defaultRangeEnd = '17:00 PM';
?>

var customButtons = feeType.replace(/Space/g, 'SpaceCustom');

if (typeof firstLoading == 'undefined' || firstLoading)
{
	var aCustomButtons = feeType.split(',');
	var firstLoading = true;
}
else
{
	var aCustomButtons = customButtons.split(',');
	var firstLoading = false;
}
var defaultCalendarView = aCustomButtons[0];


var timeRange = {
	'fc-sun': {
		opening_start: '<?php echo $space->SundayStartTime ? $space->SundayStartTime : $defaultRangeStart?>',
		opening_end: '<?php echo $space->SundayEndTime ? $space->SundayEndTime : $defaultRangeEnd?>',
		closed: <?php echo $space->isClosedSunday ? 'true' : 'false'?>,
		open247: <?php echo $space->isOpen24Sunday ? 'true' : 'false'?>,
	},
	'fc-mon': {
		opening_start: '<?php echo $space->MondayStartTime ? $space->MondayStartTime : $defaultRangeStart?>',
		opening_end: '<?php echo $space->MondayEndTime ? $space->MondayEndTime : $defaultRangeEnd?>',
		closed: <?php echo $space->isClosedMonday ? 'true' : 'false'?>,
		open247: <?php echo $space->isOpen24Monday ? 'true' : 'false'?>,
	},
	'fc-tue': {
		opening_start: '<?php echo $space->TuesdayStartTime ? $space->TuesdayStartTime : $defaultRangeStart?>',
		opening_end: '<?php echo $space->TuesdayEndTime ? $space->TuesdayEndTime : $defaultRangeEnd?>',
		closed: <?php echo $space->isClosedTuesday ? 'true' : 'false'?>,
		open247: <?php echo $space->isOpen24Tuesday ? 'true' : 'false'?>,
	},
	'fc-wed': {
		opening_start: '<?php echo $space->WednesdayStartTime ? $space->WednesdayStartTime : $defaultRangeStart?>',
		opening_end: '<?php echo $space->WednesdayEndTime ? $space->WednesdayEndTime : $defaultRangeEnd?>',
		closed: <?php echo $space->isClosedWednesday ? 'true' : 'false'?>,
		open247: <?php echo $space->isOpen24Wednesday ? 'true' : 'false'?>,
	},
	'fc-thu': {
		opening_start: '<?php echo $space->ThursdayStartTime ? $space->ThursdayStartTime : $defaultRangeStart?>',
		opening_end: '<?php echo $space->ThursdayEndTime ? $space->ThursdayEndTime : $defaultRangeEnd?>',
		closed: <?php echo $space->isClosedThursday ? 'true' : 'false'?>,
		open247: <?php echo $space->isOpen24Thursday ? 'true' : 'false'?>,
	},
	'fc-fri': {
		opening_start: '<?php echo $space->FridayStartTime ? $space->FridayStartTime : $defaultRangeStart?>',
		opening_end: '<?php echo $space->FridayEndTime ? $space->FridayEndTime : $defaultRangeEnd?>',
		closed: <?php echo $space->isClosedFriday ? 'true' : 'false'?>,
		open247: <?php echo $space->isOpen24Friday ? 'true' : 'false'?>,
	},
	'fc-sat': {
		opening_start: '<?php echo $space->SaturdayStartTime ? $space->SaturdayStartTime : $defaultRangeStart?>',
		opening_end: '<?php echo $space->SaturdayEndTime ? $space->SaturdayEndTime : $defaultRangeEnd?>',
		closed: <?php echo $space->isClosedSaturday ? 'true' : 'false'?>,
		open247: <?php echo $space->isOpen24Saturday ? 'true' : 'false'?>,
		},
};
</script>