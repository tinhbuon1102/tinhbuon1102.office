@if(request()->has('start_from') && request()->get('start_from') != '' && request()->get('start_from') != '0')
    <?php switch (request()->get('start_from')) {
        case date('H-m-d'):
           $day = 'Today';
            break;
        default:
            $day = date("Y/m/d", strtotime(request()->get('start_from')));
            $short_day = date("Y/m/d", strtotime(request()->get('start_from')));
            break;
    }?>
@endif
       <?php switch (request()->get('fee_type') ) {
           case '1':
              $day = isset($day) ? $day : '日にちと時間を選択';
              $dayTime = '日にちを選択';
               break;

           case '2':
              $day = isset($day) ? $day : '日にちと時間を選択';
              $dayTime = '日にちを選択';
               break;

           case '3':
              $day = isset($day) ? $day : '週を選択';
              $dayTime = '週を選択';
               break;
           case '4':
              $day = isset($day) ? $day : '月を検索';
              $dayTime = '月を検索';
               break;
           default:
              $day = isset($day) ? $day : '日にちと時間を選択';
              $dayTime = '日にちを選択';
              break;
                 
       } ?>

@if(request()->has('duration'))
    <?php switch (request()->get('duration')) {
        case '1':
           $duration_h = 1;
           $duration_minutes = 60;
            break;
        case '2':
           $duration_h = '2';
           $duration_minutes = 120;
            break;
        case '4':
           $duration_h = '4';
           $duration_minutes = 240;
            break;
        case '8':
           $duration_h = '8';
           $duration_minutes = 480;
            break;
        default:
          $duration_h = 0;
          $duration_minutes = 0;
          break;
    }?>
@else
    <?php  $duration_h = '0'; ?>
@endif

@if(request()->has('start_at') && request()->get('start_at') != '0'  && request()->get('start_at') != '' && request()->has('duration') && request()->get('duration') != '' && request()->get('duration') != '0')
    <?php $duration_h  = date('H:i A', strtotime('+' + request()->get('duration') . ' hours', strtotime(request()->get('start_at')))); ?>

@elseif( (!request()->has('duration') || request()->get('duration') == '' || request()->get('duration') == '0') && request()->has('start_at') && request()->get('start_at') != '0'  && request()->get('start_at') != '')
    <?php $duration_h  = date('H:i A', strtotime("+1 hour", strtotime(request()->get('start_at')))); ?>
@endif

<?php $short_day = isset($short_day) ? $short_day : $day ?>
<?php $duration_text = $short_day; ?>
@if(request()->has('start_at') && request()->get('start_at') != '' && request()->get('start_at') != '0')

    <?php $duration_text = $short_day.', '.date('H:i A', strtotime(request()->get('start_at'))).' - '.$duration_h; ?>
@else
    @if(request()->has('fee_type') && request()->get('fee_type') != '1' && request()->get('fee_type') != '2')
        <?php $duration_text = $short_day; ?>
    @endif
@endif


<div class="filter-input-wrapper time-block">
   <div class="time-block-display top-display" data-bind="click: timeFilters.timeBlockPopupToggleVisibility">
      <div class="heading top-fillter">
          <span data-bind="text: timeFilters.displayText">

              {!! $duration_text !!}
              <i class="fa fa-angle-down"></i>
          </span>
      </div>
   </div>
   <div class="time-block-popup displaye_none">
     <div class="date_picker time-block-display padding-0-20">
        <div class="heading"><p>{{$dayTime}} <i class="fa fa-angle-down "></i></p></div>
     </div>
     <div class="date_picker_block time-block-display" style="text-align:center">
       <div class="datepicker_container displaye_none">
           <div id="datepicker" data-date="{!! request()->has('start_from') && request()->get('start_from') != '' && request()->get('start_from') != '0' ? request()->get('start_from')  : date('Y-m-d') !!}" data-date-format="yyyy-mm-dd"></div>

           @if(!request()->has('fee_type') || request()->get('fee_type') != '4' && request()->get('fee_type') != '3')
               <div class="pad_1em"><a href="#" class="yellow-button-small-centered reset_calendar" id="anytime-this-week"><?=trans("common.Anytime this week")?></a></div>
           @else
               <div class="pad_1em"><a href="#" class="yellow-button-small-centered reset_calendar" id="flexible-start"><?=trans("common.My start date is flexible")?></a></div>
           @endif
       </div>
     </div>
     @if(!request()->has('fee_type') || request()->get('fee_type') != '4' && request()->get('fee_type') != '3')
         <div class="start_at time-block-display padding-0-20">
            <div class="heading"><p>利用開始 @if(request()->has('start_at') && request()->get('start_at') != '0') {!! date('H:i A', strtotime(request()->get('start_at')))  !!} @else {!! '時間指定無し' !!} @endif <i class="fa fa-angle-down "></i></p></div>
         </div>
         <select multiple class="start_at-main-block displaye_none">
           <option class="start_at_option padding-0-20" @if(request()->has('start_at') && request()->get('start_at') == '0' || !request()->has('start_at')) selected="selected" @endif value="0">時間指定無し</option>
             <?php $startTime = "12:00 AM";
                   $endTime = "11:00 PM";
                   for ($i = strtotime($startTime); $i <= strtotime($endTime)  ; $i += strtotime("+1 hours", strtotime($i))) { ?>
                       <option class="start_at_option padding-0-20" @if(request()->has('start_at') && request()->get('start_at') == date('H:i:s', $i)) selected="selected" @endif value="{!! date('H:i:s', $i) !!}">{!! date('H:i A', $i) !!}</option>
                  <?php } ?>
         </select>
         @if(request()->has('start_at') && request()->get('start_at') != '0')
           <?php  $startTime = strtotime("+1 hours", strtotime(request()->get('start_at') ));
                  $time = '1 時間';
                  $endTime = "11:00 PM";
           ?>
           <div id="end_at-main-block" >
             <div class="end_at time-block-display padding-0-20">
                <div class="heading"><p>利用終了 {!! $duration_h !!}<i class="fa fa-angle-down "></i></p></div>
             </div>
             <select multiple class="end_at-main-block displaye_none">
               <?php $startTime = strtotime("+1 hours", strtotime(request()->get('start_at') ));
                    $time = '1 hours';
                     $endTime = "11:00 PM"; ?>
                       <?php for ($i = $startTime; $i <= strtotime($endTime)  ; $i += strtotime("+1 hours", strtotime($i))) { ?>
                            <?php
                              $to_time = strtotime("+1 hours", $i);
                              $from_time = $startTime;
                              $minutes  = round(abs($to_time - $from_time) / 60,2);
                              if($minutes >= 60){
                                $hours = round($minutes/60,2);
                                if($hours == 1){
                                  $difference = '1 hour';
                                  $duration = '1';
                                }else{
                                  $difference = $hours.' hours';

                                  $hours = explode('.', $hours);

                                  $duration = $hours[0];
                                  if($hours[0] == 1){
                                      $duration = $hours[0];

                                  }
                                  if(count($hours) == 2){
                                      $duration = $duration;
                                  }
                                }
                              }else{
                                $difference = $minutes.' min';
                                $duration = '1';

                              }
                            ?>
                           <option class="end_at_option padding-0-20" @if(request()->has('duration') && request()->get('duration') == $duration) selected="selected" @endif value="{!! $duration !!}">{!! date('H:i A', $i).' ('.$difference.')' !!}</option>
                      <?php } ?>
             </select>
           </div>
         @endif

     @endif
  </div>
</div>
