<!DOCTYPE html>
<html lang="en-US">
<head>
<meta charset="utf-8">
</head>
<body>
<div style="width:100%;display:block; max-width:100%;margin:0 auto;box-sizing:border-box;">
	<div style="width:100%;text-align:center;">
<img src='http://office-spot.com/images/logo.png' />
    </div>
    <div style="display:block;border:1px solid #000;box-sizing:border-box;float:left;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;">
        <div style="padding: 10px 10px 10px 10px;border-bottom:1px solid #000;width: 100%;float: left;box-sizing: border-box;">
		<table style="padding:0 10px 0 10px;">
		<tr><td>
            <center><h3 style="text-decoration:underline;color:#03775f;">Booking Info</h3></center>
            <div style="float: left;width: 100%;text-align: left;">
				<strong style="color:#1bbc9b;display:inline-block;">firstname: </strong>
				<span style="display:inline-block;margin:0 5px;">{!!$data->rentUser->FirstName!!}</span>
			</div>
            <div style="float: left;width: 100%;text-align: left;">
				<strong style="color:#1bbc9b;">lastname: </strong>
				<span style="display:inline-block;margin:0 5px;">{!!$data->rentUser->LastName!!}</span>
			</div>
			<div style="float: left;width: 100%;text-align: left;">
				<strong style="color:#1bbc9b;">Email: </strong>
				<span style="display:inline-block;margin:0 5px;">{!!$data->rentUser->Email!!}</span>
			</div>
		</td>
		</tr></table>	
      	</div>	
		
        <div style="padding:20px 10px;border-bottom:1px solid #000;width: 100%;float: left;box-sizing: border-box;">
		<table style="padding:0 10px 0 10px;">
		<tr><td>
            <center><h3 style="text-decoration:underline;color:#03775f;">Booking date</h3></center>
			@if($data->spaceID->FeeType!=1) @foreach($slots_data as $slot)
				<table style="width: 100%;border: 1px solid #000;border-collapse: collapse;box-sizing:border-box;padding: 10px 0px 10px 00px">
					<tr style="background-color: #03775f;">
						<th style="padding: 10px;text-align: center;border: 1px solid #000;color:#fff;">Space title</th>
						<th style="padding: 10px;text-align: center;border: 1px solid #000;color:#fff;">@if($data->spaceID->FeeType!=1)From @else  Date @endif</th>
						<th style="padding: 10px;text-align: center;border: 1px solid #000;color:#fff;">@if($data->spaceID->FeeType!=1)To @else Time @endif</th>
						<th style="padding: 10px;text-align: center;border: 1px solid #000;color:#fff;">Duration</th>
						<th style="padding: 10px;text-align: center;border: 1px solid #000;color:#fff;">Total Persons</th>
					</tr>
					<tr>
						<td style="padding: 10px;text-align: center;border: 1px solid #000;">{!!$data->spaceID->Title!!}</td>
						<td style="padding: 10px;text-align: center;border: 1px solid #000;">@if($data->spaceID->FeeType!=1){!!$slot['StartDate']!!}@else {!!$data['hourly_date']!!} @endif</td>
                    <td style="padding: 10px;text-align: center;border: 1px solid #000;">@if($data->spaceID->FeeType!=1)
						@if($data->spaceID->FeeType==4){!! 
							date("Y-m-t", strtotime($slot->StartDate))!!}
						@else
							{!!$slot->EndDate!!}
						@endif
					@else {!!$data['hourly_time']!!} @endif</td>
                    <td style="padding: 10px;text-align: center;border: 1px solid #000;">
					@if($data->spaceID->FeeType==1) {!!$data->spaceID->HourMinTerm!!} Hours @elseif($data->spaceID->FeeType==2) 1 Day @elseif($data->spaceID->FeeType==3) 7 Days @else 1 Month @endif
					
					</td>
					<td style="padding: 10px;text-align: center;border: 1px solid #000;">{!!$data->total_persons!!}人</td>
					</tr>
				</table>
			@endforeach
			@else
				<?php $dates=explode('-',$data['hourly_time']);

										$t11 = StrToTime ( trim($dates[0]));
										$t21 = StrToTime (  trim($dates[1]));
										$diff1 = $t11 - $t21;
										$hours1 = str_replace('-','',$diff1 / ( 60 * 60 ));
										$count=$hours1;
										
?>
				<table style="width: 100%;border: 1px solid #000;border-collapse: collapse;box-sizing:border-box;padding: 10px 0px 10px 00px">
					<tr style="background-color: #03775f;">
						<th style="padding: 10px;text-align: center;border: 1px solid #000;color:#fff;">Space title</th>
						<th style="padding: 10px;text-align: center;border: 1px solid #000;color:#fff;">@if($data->spaceID->FeeType!=1)From @else Date @endif</th>
						<th style="padding: 10px;text-align: center;border: 1px solid #000;color:#fff;">@if($data->spaceID->FeeType!=1)To @else Time @endif</th>
						<th style="padding: 10px;text-align: center;border: 1px solid #000;color:#fff;">Duration</th>
						<th style="padding: 10px;text-align: center;border: 1px solid #000;color:#fff;">Total Persons</th>
					</tr>
					<tr>
						<td style="padding: 10px;text-align: center;border: 1px solid #000;">{!!$data->spaceID->Title!!}</td>
						<td style="padding: 10px;text-align: center;border: 1px solid #000;">@if($data->spaceID->FeeType!=1){!!$slot['StartDate']!!}@else {!!$data['hourly_date']!!} @endif</td>
                    <td style="padding: 10px;text-align: center;border: 1px solid #000;">@if($data->spaceID->FeeType!=1){!!$slot['EndDate']!!}@else {!!$data['hourly_time']!!} @endif</td>
                    <td style="padding: 10px;text-align: center;border: 1px solid #000;">
					@if($data->spaceID->FeeType==1) {!!$count!!} Hours @else {!!$slot->DurationDays!!} Days @endif
					
					</td>
					<td style="padding: 10px;text-align: center;border: 1px solid #000;">{!!$data->total_persons!!}人</td>
					</tr>
				</table>
			@endif
		</td>
		</tr></table>
      	</div>

 <div style="padding: 10px 10px 10px 10px;box-sizing:border-box;">
            		
						<table style="padding:0 10px 0 10px;">
							<tr>
								<td>
									<strong style="color:#1bbc9b;text-align:left;float: left;">Total amount: </strong>
									<span style="text-align:left;margin:0 5px;"><b>¥</b>{!!priceConvert($data->amount)!!}</span>
								</td>
							</tr>
							 @if(Session::get('duration')>5 && $data->spaceID->FeeType==4) 
							<tr>
								<td>
									<strong style="color:#1bbc9b;text-align:left;float: left;">Amount for 2 months: </strong>
									<span style="text-align:left;margin:0 5px;"><b>¥</b>{!!priceConvert(($data['spaceID']['MonthFee']*2*0.08)+(($data['spaceID']['MonthFee']*2*0.08)+($data['spaceID']['MonthFee']*2))*0.10+$data['spaceID']['MonthFee']*2)!!}
									</span>
								</td>
							</tr>
							
							<tr>
								<td>
									<strong style="color:#1bbc9b;text-align:left;float: left;">Recursion payment for each {!! Session::get('duration')-2 !!} month: </strong>
									<span style="text-align:left;margin:0 5px;"><b>¥</b>{!!priceConvert(($data->spaceID->MonthFee*0.08)+(($data->spaceID->MonthFee*0.08)+($data->spaceID->MonthFee))*0.10+$data->spaceID->MonthFee)!!}
									</span>
								</td>
							</tr>
							
							@endif
						</table>
      			</div>
			
    </div>

</div>

<style type="text/css">
	@page {size: 5.5in 8.5in;box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);}
</style>

</body></html>