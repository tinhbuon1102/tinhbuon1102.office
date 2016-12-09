<?php 
	use App\Spaceslot;
?>

@if($rent_data->spaceID->FeeType!=1)
		<?php 
			$slots_id=explode(';',$rent_data['spaceslots_id']);
			
			$slots_data=Spaceslot::whereIn('id', array_filter(array_unique($slots_id)))->orderBy('StartDate','asc')->get();
			
			$slots_array=array(); 
			
			foreach($slots_data as $slot):
				$slots_array[]=$slot->id;
			endforeach;
			
			$count=0;
			foreach($slots_data as $slot):
				$count++;
					if($count==1):
						$start_date=$slot->StartDate;
					endif;
			endforeach;
		?>
		<table class="book-summary book-total-amount book-table">
			<tbody>
			<tr><th>利用人数</th><td>{!!$rent_data->total_persons!!}人</td></tr>
			<tr><th>利用開始日</th><td>{!!$start_date!!}</td></tr>
			<tr><th>期間</th><td>{!!$count!!} 
			
		
		</tbody>
		<tfoot>	
				<?php

						if($rent_data->price==''):
								if($rent_data->spaceID->HourFee!=0): 
									$sub_total=$rent_data->spaceID->HourFee; 
								elseif($rent_data->spaceID->DayFee!=0): 
									$sub_total=$rent_data->spaceID->DayFee; 
								elseif($rent_data->spaceID->WeekFee!=0): 
									$sub_total= $rent_data->spaceID->WeekFee; 
								elseif($rent_data->spaceID->MonthFee!=0): 
									$sub_total_one=$rent_data->spaceID->MonthFee;
									$sub_total=$rent_data->spaceID->MonthFee;
								endif; 
						else: 
									$sub_total=$rent_data->price;
						endif;
				?>
				</table>
				<?php
						if($count>5 && $rent_data->spaceID->FeeType==4):
							$months=2;
							$sub_total_months=$months*$rent_data->spaceID->MonthFee;
						endif;
	?>
			@else
				<?php  
						$dates=explode('-',str_replace('To:','',$rent_data['hourly_time']));
						$t11 = StrToTime ( trim($dates[0]));
						$t21 = StrToTime (  trim($dates[1]));
						$diff1 = $t11 - $t21;
						$hours1 = str_replace('-','',$diff1 / ( 60 * 60 ));
						$count=$hours1;
													
					?>
			@endif


@if($count>5 && $rent_data->spaceID->FeeType==4)
	<?php 

		if($count>5 && $rent_data->spaceID->FeeType==4):
			$months=2;
			$sub_total_months=$months*$rent_data->spaceID->MonthFee;
		endif;
	echo renderBookingFor6Months($sub_total_months, $rent_data,$start_date,$count);
?>
@endif