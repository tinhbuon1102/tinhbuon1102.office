<?php 
$space_last= $space[count($space) - 1];
$aFulledRange = \App\Spaceslot::getBookedHourSlots($space[0]['User1sharespace'], date('Y-m-d', strtotime($date)));

$con_after_one_hour=0;
if($space_last_hour['LastBookUnit']==1):

$first_latest_id_value='';
$disabled=0;
if(strtotime($space[0]['StartDate'].' '.$space[0]['StartTime'])-(60*60*$space_last_hour['LastBook'])<strtotime(date('g:i a'))):
	$after_hour=$space_last_hour['LastBook']+1;
	
	$new_time=date('g:00 a',strtotime('+'.$after_hour.' hour'));
	//print_r($first_latest_time);exit;
	
	for ($inc_time = 0; $inc_time <= 24; $inc_time++):
		$inc_time1=$after_hour+$inc_time;
		if (isset($first_latest_time[$inc_time]) && $new_time > $first_latest_time[$inc_time] && $new_time < $last_latest_time[$inc_time]):
			$key = array_search($new_time, $first_latest_time);
			
			if(in_array(date('g:i a', StrToTime($new_time)),($allbook_array))):
				$disabled=1;
			endif;
			
			$space_write_start=$new_time;
			$first_latest_id_value=$first_latest_id[$key];
			break;
		else:
			$space_write_start=date('g:00 a',strtotime('+'.$after_hour.' hour'));
			
			if(in_array(date('g:i a', StrToTime($space_write_start)),($allbook_array))):
				$disabled=1;
			endif;
			
			
		endif;
		
		$new_time=date('g:00 a',strtotime('+'.$inc_time1.' hour'));
	endfor;
	
	//$space_write_start=date('g:i a',strtotime($space[0]['StartTime']));
else:
	
		$space_write_start=date('g:i a',strtotime($space[0]['StartTime']));
		
	$new_time=date('12:00 \a\m',strtotime('+0 hour'));	
	//echo $new_time;exit;
	for ($inc_time = 0; $inc_time <= 24; $inc_time++):
		if(in_array($new_time,$first_latest_time)):
			$key = array_search($new_time, $first_latest_time);
			$space_write_start=$new_time;
			if(in_array(date('g:i a', StrToTime($new_time)),($allbook_array))):
				$disabled=1;
			endif;
			$first_latest_id_value=$first_latest_id[$key];
			break;
		else:
			$space_write_start=date('g:i a',strtotime($space[0]['StartTime']));
			if(in_array(date('g:i a', StrToTime($space_write_start)),($allbook_array))):
				$disabled=1;
			endif;
		endif;
		$new_time=date('g:00 a',strtotime('+'.$inc_time.' hour',strtotime('12:00 am')));
	endfor;
	
	//$space_write_start_logic=date('g:i a',strtotime($space[0]['StartTime']));
endif;
else:
$space_write_start=date('g:i a',strtotime($space[0]['StartTime']));
endif;

//echo '<pre>';print_r($space_last);exit;
$space_write_last=date('g:i a',strtotime($space[0]['EndTime']));
$total_minutes=$space[0]['User1sharespace']['HourMinTerm']*60;
$space_write_last = date('g:i a',strtotime('+'.$total_minutes.'mins', strtotime($space_write_start)));
$current_time=strtotime(date('g:i a'));
?>
<?php if($hourly_time!=''):
			$hourly_time=explode('-',$hourly_time);
		endif;
	
 ?>
<div id="maintime" class="wlp-start-time-and-duration-display wlp-picker-display" >時間帯: <span id="tfromtime">@if(isset($hourly_time[0])) {!!$hourly_time[0]!!} @else {!! $space_write_start!!} @endif</span> - <span id="toendtime">@if(isset($hourly_time[1])) {!!$hourly_time[1]!!} @else  {!! $space_write_last!!} @endif</span></div>
                        <div id="timewrap" class="wlp-start-time-and-duration-pickers wlp-picker" style="display:none;"  >
                              <div  class="wlp-picker-wrapper" >
							    <?php if(isset($hourly_time[0])): $first_show_time=$hourly_time[0]; else:  $first_show_time=$space_write_start; endif ?>
                                 <div id="fromtimed" class="wlp-picker-display @if((strtotime($date.' '.$first_show_time)<=$current_time)  )pasthour @endif @if($disabled==1) not_available @endif" latestid='{!!$first_latest_id_value!!}'>From: @if(isset($hourly_time[0])) {!!$hourly_time[0]!!} @else {!! $space_write_start!!} @endif</div>
                                 <div id="fromtime" class="wlp-picker wlp-time-picker" style="display:none;" >
								 <?php
								 $j=0;
								 foreach($space as $key=>$spac):
								  $check_j=0;
								 if($con_after_one_hour==1 && $key==0):
										$current_time=strtotime(date('g:i a'),'-'.$space_last_hour['LastBook'].' hour');
								 else:
										$current_time=strtotime(date('g:i a'));
								 endif;
										 $space1_start=date('g:i a',strtotime($spac['StartTime']));
										 $t11_date =  ($spac['StartDate'].' '.$spac['StartTime']);
										 $space1_end=date('g:i a',strtotime($spac['EndTime']));
									
										$t21_date =  ($spac['StartDate'].' '.$spac['EndTime']);
										
										 $start_explode=explode(':',$space1_start);
										 $end_explode=explode(':',$space1_end);

												$t1 = StrToTime ( $space1_start);
												$t2 = StrToTime ( $space1_end);
												$diff = $t1 - $t2;
												$hours = str_replace('-','',$diff / ( 60 * 60 ));
												
											   if($space[0]['User1sharespace']['HourMinTerm']==1):
													$time=60;
													$total_hours=$hours;
											   elseif($space[0]['User1sharespace']['HourMinTerm']==2):
													$time=60*2;
													$total_hours=ceil(($hours)/2);
											   elseif($space[0]['User1sharespace']['HourMinTerm']==3):
													$time=60*3;
													$total_hours=ceil(($hours)/3);
											   elseif($space[0]['User1sharespace']['HourMinTerm']==4):
													$time=60*4;
													$total_hours=ceil(($hours)/4);
											   endif;
											   $time=60;
											   $total_hours=$hours;


											   $time1=$t11_date;
											   
										 ?>
										
										 @for ($i = 0; $i <= $total_hours-$space[0]['User1sharespace']['HourMinTerm']; $i++)
										 	<?php 
										 	$classUnselect = '';
										 	
										 	if (!isCoreWorkingOrOpenDesk($space[0]['User1sharespace']))
										 	{
										 		if(in_array(date('g:i a', StrToTime($time1)),($allbook_array)) || StrToTime($time1)<=$current_time)
										 			$classUnselect = 'unselectable';
										 	}
										 	else {
										 		foreach ($aFulledRange as $fulledRange) {
													if (in_array($i, $fulledRange)){
														$classUnselect = 'unselectable';
														break;
													}
												}
										 	}
										 	
										 	?>
											<?php $check_j=1;?>
												 <div class="wlp-time-picker-item fromtimer {{$classUnselect}} " id='{!! $j !!}' lt="{!! date('M d,Y g:i a', strtotime($time1));!!}" value="{!!$spac['id']!!}">{!! date('g:i a', strtotime($time1));!!}
												<?php  $next = strtotime('+'.$time.'mins', strtotime($time1));$time1 = date('d-m-Y g:i a', $next);?>
												</div>
												<?php $j++;?>
										 @endfor
										@if($check_j==1)
										 <?php $j=$j+$space[0]['User1sharespace']['HourMinTerm']-1;?>
									    @endif
								<?php endforeach ;?>
                                 </div>
								
                              </div>
							  <?php if(isset($hourly_time[1])): $last_show_time=$hourly_time[1]; else:  $last_show_time=$space_write_last; endif ?>
                              <div  class="wlp-picker-wrapper" >
                                 <div id="endtimed" class="wlp-picker-display @if(strtotime($last_show_time)<=$current_time) pasthour @endif" >To:@if(isset($hourly_time[1])) {!!$hourly_time[1]!!} @else  {!! $space_write_last!!} @endif</div>
                                 <div id="endtime"   class="wlp-picker wlp-time-picker"   style="display:none">
							 <?php
								 foreach($space as $spac):
										 $space1_start=date('g:i a',strtotime($spac['StartTime']));
										 $space1_end=date('g:i a',strtotime($spac['EndTime']));
										 
										$t11_date =  ($spac['StartDate'].' '.$spac['StartTime']);
										$t21_date =  ($spac['StartDate'].' '.$spac['EndTime']);
										
										 $start_explode=explode(':',$space1_start);
										 $end_explode=explode(':',$space1_end);

												$t1 = StrToTime ( $space1_start);
												$t2 = StrToTime ( $space1_end);
												$diff = $t1 - $t2;
												$hours = str_replace('-','',$diff / ( 60 * 60 ));
												
											   if($space[0]['User1sharespace']['HourMinTerm']==1):
													$time=60;
													$total_hours=$hours;
											   elseif($space[0]['User1sharespace']['HourMinTerm']==2):
													$time=60*2;
													$total_hours=ceil(($hours)/2);
											   elseif($space[0]['User1sharespace']['HourMinTerm']==3):
													$time=60*3;
													$total_hours=ceil(($hours)/3);
											   elseif($space[0]['User1sharespace']['HourMinTerm']==4):
													$time=60*4;
													$total_hours=ceil(($hours)/4);
											   endif;
											   $time=60;
											   $total_hours=$hours;


											   $time1=$t11_date;
											  $time2=strtotime($time1) + $time*60;
											  $time2 = date('H:i', $time2); ?>
                                   @for ($i = 1; $i <= $total_hours; $i++)
									 <?php 
									  $classUnselect = '';
									  
									  if (!isCoreWorkingOrOpenDesk($space[0]['User1sharespace']))
									  {
									  	if(in_array(date('g:i a', strtotime($spac['StartDate'].' '.$time2)),($allbook_array)) || strtotime($spac['StartDate'].' '.$time2)<=$current_time)
									  		$classUnselect = 'unselectable';
									  }
									  else {
									  	foreach ($aFulledRange as $fulledRange) {
									  		if (in_array($i, $fulledRange)){
									  			$classUnselect = 'unselectable';
									  			break;
									  		}
									  	}
									  }		  
									?>
                                    <div class="wlp-time-picker-item totimer {{$classUnselect}}" value="{!!$spac['id']!!}" @if($i+1<$space[0]['User1sharespace']['HourMinTerm']) unselectable @endif>{!! date('g:i a', strtotime($time2));!!}
								<?php  $next = strtotime('+'.$time.'mins', strtotime($spac['StartDate'].' '.$time2));  $time2 = date('g:i a', $next);?>
								</div>
								
								 @endfor
								<?php endforeach ;?>
                                 </div>
                              </div>
                           </div>

						