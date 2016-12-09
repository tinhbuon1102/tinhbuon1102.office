<body>
	<div id="pop-bone" class="editReservationDialog">
	<form action="/transaction/card-transaction" id="editReservationForm" method="post">
	<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
    <div class="pop-cl">X</div>
	<?php $tax=0.08;?>
	<div class="ui-dialog-titlebar ui-widget-header ui-helper-clearfix">
    <span class="ui-dialog-title" id="ui-dialog-title-editReservationDialog">Complete Your Booking</span>
    </div>
    <div id="editReservationDialog" class="ui-dialog-content ui-widget-content">
    <div id="reservation-div">
    <div class="reservation-content-wrapper">
    <div class="reservation-timepicker">
    <div class="reservation-booking-info bin-block show-at-step1">
    <div class="clearfix">
    <div class="h5 booking-info-caption">Space: </div>
    <div class="h5 booking-info-label">Space Name<text> - </text>Share User Name</div>
    </div>
    </div>
    <?php $j=1;?>
    <div class="time-picker-wrapper bin-block show-at-step1">
    <div class="show-at-step1 reservationMethod_SpecificTimePeriod">
    <div class="custom-dropdown-wrapper">
    <div class="box-label" style="padding-bottom:5px;">DATE</div>
    <div class="selectedDay">
	 <input type='hidden' id="amount" name='amount' value="{!!($j*$fee)+($fee*$tax)!!}" />
	  <input type='hidden' id="user1sharespaces_id" name='user1sharespaces_id' value="{!!$space_id!!}" />
	  <input type='hidden' id="spaceslots_id" name='spaceslots_id' value="{!!$all_slots!!}" />
	@if($FeeType==1)
		<input value="@if(isset($space1[0]) && $space1[0]!='') {!! $space1[0] !!} @else {{ date('m/d/Y') }} @endif" type="text" name="ReservationDayDisplay" id="ReservationDayDisplay" data-bind="value: selectedDayDisplay" class="date-control  hasDatepicker valid" readonly>
	@else
		<input value="re-select date" type="text" id="ReservationDayDisplay"  class="date-control valid dailydate_popup" readonly>
    @endif
    </div>
	
    </div>

	@if($FeeType!=2 && $FeeType!=3 && $FeeType!=4) 
    <div class="custom-dropdown-wrapper mobile-half">
		<div class="box-label" style="padding-bottom:5px;">STARTS</div>
		<select class="pop-one-sel" name="startTime">
			<option selected="selected" value="{!! $from !!}">@if(isset($from) && $from!='') {!! $from !!} @endif</option>
			<!--<option value="16:00:00">16:00 PM</option>-->
		</select>
    </div>
	
	
    <div class="custom-dropdown-wrapper mobile-half">
		<div class="box-label" style="padding-bottom:5px;">ENDS</div>
		<select class="pop-one-sel" name="endTime">
			<option selected="selected" value="{!! $to !!}">@if(isset($to) && $to!='') {!! $to !!} @endif</option>
			<!--<option value="17:00:00">5:00 PM</option>-->
		</select>
    </div>
	@else
		<div class="custom-dropdown-wrapper">
    <div class="box-label" style="padding-bottom:5px;">@if($FeeType==2) Days @elseif($FeeType==3) Weeks @elseif($FeeType==4) Months @endif</div>
    <div class="selectedDay">
	<?php $j=0; ?>
	@foreach(array_unique($space1) as $key=>$value)
		@if($value!='')
			<?php $j++;?>
	    @endif
	@endforeach
			<input value="{!! $j !!} @if($FeeType==2) Days @elseif($FeeType==3) Weeks @elseif($FeeType==4) Months @endif" type="text" id="count_days" class="date-control valid" readonly="">
        </div>
	
    </div>
	@endif
    <div class="mobile-clear"></div>
	
    <div class="custom-dropdown-wrapper persons">
		<div class="box-label" style="padding-bottom:5px;">GUESTS</div>
		<select class="pop-one-sel" name="Reservation.GuestsCount">
			<option selected="selected" value="1">Just me</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
		</select>
    </div>
    <div class="clear"></div>
    
	@if($FeeType!=1)	
		<div class='selecteddays_display'>
		@foreach(array_unique($space1) as $key=>$value)
			@if($value!='')
				-{!!$value!!}<br/>
			@endif
		@endforeach
			</div>
	@endif
	
		
   <!-- <div id="recurrenceBuilderDiv">
         <label for="chkEnableRecurrence">
            <input type="checkbox" data-event="event-bin-recurring-click" data-bind="checked: enabled, disable: canUncheck" id="chkEnableRecurrence">
            <span class="checkbox-icon"></span>
            <span data-bind="text: recurringText" class="h5 checkbox-text" style="margin-left: 5px;">Repeat This Booking</span>
         </label>
         <span class="recurring-text-pattern h5 checkbox-text" data-bind="text: ruleText"></span>
      </div>-->
      </div>
      
      
    
    </div>
    </div><!--/reservation-timepicker-->
    <div class="reservation-step1 show-at-step1 bin-block">
      <div class="fac-list">
    <div class="box-label">Included Amenities and Services</div>
    <div class="included-fac">
<span class="fac-other ">WiFi</span>,<span class="fac-other ">Water Server</span>
      </div>
      </div>
      </div>
     
    </div><!--/reservation-content-wrapper-->
    <div class="action-buttons bin-block">
    <div class="dialog-buttons">
     <input type='submit' value="Procced" id="checkout" class="button45 orange-button show-at-step2 ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only ui-button-disabled" style="float: left; display: block;" role="button" aria-disabled="true" />
   <button id="cancelBtn" class="pop-cl button45 orange-inverted-button cancel-button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" style="float: left; margin-left: 10px;" onclick="reservationModel.cancelBtnClick(this, '');return false;" role="button" aria-disabled="false"><span class="ui-button-text">
      Cancel
   </span></button>
    </div>
    </div>
    </div><!--/#reservation-div-->
    
    </div><!--/#editReservationDialog-->
     </form>
    </div>
	
	<!-- ------------------------ booking 2 ----------------------- -->
	
	<div id="pop-btwo" class="editReservationDialog">
	<form action="/ShareUser/Dashboard/BookingDetails" id="editReservationForm" method="post">
	<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
    <div class="pop-cl">X</div>
	<div class="ui-dialog-titlebar ui-widget-header ui-helper-clearfix">
    <span class="ui-dialog-title" id="ui-dialog-title-editReservationDialog">Complete Your Booking</span>
    </div>
    <div id="editReservationDialog" class="ui-dialog-content ui-widget-content">
    <div id="reservation-div">
    <div class="reservation-content-wrapper">
    
    <div class="reservation-step2 show-at-step2" style="display: block;">
            <div class="info-line" id="costDetails">
               
   <div class="hourly-cost-wrapper bin-block">
      <div>
         <div class="recurrent-notice">
            <div class="box-label">
               Cost Details
            </div>
               <div style="padding-top: 5px;">
                  Your card will be charged 24 hours before each reservation. Changes and cancellations are free of charge with a 24 hours notice.
                  <a href="/Terms/Hourly-Space-License-Agreement" target="_blank">Cancellation Policy</a>
               </div>
         </div>

            <div class="vertical-separator-reservation"></div>
         <div class="element-box left">
            <div class="box-label">
               Cost Details
            </div>
               <div style="padding: 15px 0;">
                  <div>
				  
                        <div style="font-weight: 500">
                           <span>Duration: </span><span>{!! $j !!} @if($FeeType==2) Day @elseif($FeeType==3) Week @elseif($FeeType==4) Month @elseif($FeeType==1) Hour @endif</span>@if($FeeType==1)<?php $j= (timeDiff($from,$to)/60)/60;?> @endif
                        </div>
                           <div class="clearfix"><span class="costdetails-label">1 @if($FeeType==5) Day @elseif($FeeType==3) Week @elseif($FeeType==4) Month @elseif($FeeType==1) Hour @endif @ {!!$fee!!}/@if($FeeType==5) Day @elseif($FeeType==3) Week @elseif($FeeType==4) Month @elseif($FeeType==1) Hour @endif</span><span class="price-value">$<?php echo $total_price=$j*$fee;?></span></div>
                  </div>
               </div>
         </div>
            <div class="element-box right">
      <div class="clearfix"><span class="costdetails-label">Total @if($FeeType==2) Days @elseif($FeeType==3) Weeks @elseif($FeeType==4) Months @elseif($FeeType==1) Hours @endif:</span><span class="count_days" style='float:right'>{!! $j !!}</span></div>
      <div class="clearfix"><span class="costdetails-label">Subtotal:</span><span class="price-value">$<?php echo $j*$fee;?></span></div>
      <div class="clearfix"><span class="costdetails-label">Tax:</span><span class="price-value">$<?php echo $fee*$tax;?></span></div>
            </div>
      </div>
      <div class="bottom">
         <div class="element-box left">
               <div>
                     
                     <div class="coupon-input-form" style="display: none;">
                        <div style="float: left;">
                           <label>
                              Coupon:
                           </label>
                           <input type="text" id="promotionCode" style="margin-left: 8px; width:100px;">
                        </div>
                        <button class="ocean-button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" onclick="applyCoupon(); return false;" id="validatePromotionBtn" style="float: left; margin-right:2px;" role="button" aria-disabled="false"><span class="ui-button-text">
                           Apply
                        </span></button>
                     </div>
               </div>
         </div>
            <div class="element-box right" style='float:right'>
               
               <div class="box-label h2">
                  
      <div class="clearfix"><span class="costdetails-label" id="&quot;amountDueLabel&quot;">Total amount:</span><span class="price-value_total">$<?php echo ($j*$fee)+($fee*$tax);?></span></div>
               </div>
            </div>
      </div>
      <div style="clear: both;">
      </div>
   </div>
   

            </div>
            <div id="paymentProfileDetails">
               
<input id="PaymentProvider" name="PaymentProvider" type="hidden" value="BrainTree">   <div class="info-line bin-block" style="padding-top: 20px;">
         <div class="h5" style="font-weight: 500">
            Payment Method
         </div>
      <div>
                  <div class="credit-card-provider" style="">
                        <div>
                           <div class="paymentProfileViewDiv change-hide h3" style="padding-bottom: 30px; display:none">
                              We'll bill
                                 your
                              <span id="paymentAccountType">
                              </span>
                              <span id="creditCardShortNumber" style="font-weight: 500;">
                                 
                              </span>
                                  24 hours before the start of your reservation
                              <span class="lsPopupHost" title="You can edit your payment profile on Settings page"><a href="/My/Settings#payments" class="font-icon information-note" target="_blank"></a> </span>
                           </div>
                        </div>
                           <div class="PaymentProfileEditWrapper change-show" style="display: inherit">

                              
<div id="paymentProfiles" class="payment-profile" style="padding-top: 20px;">
   <input id="Member_Id" name="Member.Id" type="hidden" value="60484f8a-6a6c-4b07-845e-6b696669a746">   
   <input id="SelectedPaymentProfileId" name="SelectedPaymentProfileId" type="hidden" value="">
   <input id="paymentAddress" name="PaymentProfileForEdit.Address" type="hidden" value="2225 E. Bayshore Road, Suite 200">
   <div class="payment-profile-line">
      <div class="payment-profile-label">
         Cardholder Name
      </div>
      <div><input required class="focus cardholder-name valid" data-bind="css: { 'input-validation-error-add' : cardholderNameInvalid() }, value: cardholderName, valueUpdate: 'afterkeydown'" id="PaymentProfileForEdit_FullName" maxlength="50" name="PaymentProfileForEdit.FullName" type="text" value="{!!$user->card_name!!}"></div>
   </div>
   <div class="payment-profile-line credit-card-number-wrapper">
      <div class="payment-profile-label">
         Card Number
      </div>
	  <input type='hidden' id="amount1" name='amount' value="{!!($j*$fee)+($fee*$tax)!!}" />
	  <input type='hidden' id="user1sharespaces_id" name='user1sharespaces_id' value="{!!$space_id!!}" />
	  <input type='hidden' id="spaceslots_id" name='spaceslots_id' value="{!!$all_slots!!}" />
      <div>
         <input required autocomplete="off" class="ccard-number" data-bind="css: { 'input-validation-error-add' : cardNumberInvalid() == true }, value: cardNumber, valueUpdate: 'afterkeydown'" data-encrypted-name="number" id="PaymentProfileForEdit_CardNumber" name="PaymentProfileForEdit.CardNumber" type="text" value="{{$user->modified_card_number}}">
         <div class="card-types">
            <div class="cc-image image-visa" data-bind="css: { 'opacity03': hideCardType('Visa') }"></div>
            <div class="cc-image image-mastercard" data-bind="css: { 'opacity03': hideCardType('MasterCard') }"></div>
            <div class="cc-image image-discovery" data-bind="css: { 'opacity03': hideCardType('Discover') }"></div>
            <div class="cc-image image-express" data-bind="css: { 'opacity03': hideCardType('AMEX') }"></div>
         </div>
      </div>
   </div>
   <div class="payment-profile-line expiration-date-wrapper">
      <div class="payment-profile-label">
         Expiration Date
      </div>
      <div>
         <div class="ls-select" style="width: 60px;">
            <select required data-bind="css: { 'input-validation-error-add' : filedsRequired($data.expMonth()) == true }, value: expMonth, valueUpdate: 'afterkeydown'" data-val="true" data-val-number="The field ExpirationMonth must be a number." id="PaymentProfileForEdit_ExpirationMonth" name="PaymentProfileForEdit.ExpirationMonth"><option value="">--</option>
 <option value="1" @if($user->exp_month==1) Selected='selected' @endif>1</option>
      <option value="2" @if($user->exp_month==2) Selected='selected' @endif>2</option>
      <option value="3" @if($user->exp_month==3) Selected='selected' @endif>3</option>
      <option value="4" @if($user->exp_month==4) Selected='selected' @endif>4</option>
      <option value="5" @if($user->exp_month==5) Selected='selected' @endif>5</option>
      <option value="6" @if($user->exp_month==6) Selected='selected' @endif>6</option>
      <option value="7" @if($user->exp_month==7) Selected='selected' @endif>7</option>
      <option value="8" @if($user->exp_month==8) Selected='selected' @endif>8</option>
      <option value="9" @if($user->exp_month==9) Selected='selected' @endif>9</option>
      <option value="10" @if($user->exp_month==10) Selected='selected' @endif>10</option>
      <option value="11" @if($user->exp_month==11) Selected='selected' @endif>11</option>
      <option value="12" @if($user->exp_month==12) Selected='selected' @endif>12</option>
</select>
         </div>
         <div class="ls-select" style="width: 80px;">
            <select required data-bind="css: { 'input-validation-error-add' : filedsRequired($data.expYear()) == true }, value: expYear, valueUpdate: 'afterkeydown'" data-val="true" data-val-number="The field ExpirationYear must be a number." id="PaymentProfileForEdit_ExpirationYear" name="PaymentProfileForEdit.ExpirationYear"><option value="">----</option>
			<?php for($date=date('Y');$date<date('Y')+10;$date++): ?>
				<option value="<?php echo $date;?>" @if($user->exp_year==$date) Selected='selected' @endif><?php echo $date;?></option>
			<?php endfor; ?>
</select>
         </div>
      </div>
   </div>
   <div class="payment-profile-line security-code-wrapper">
      <div class="payment-profile-label">
         Security Code
      </div>
      <div>
         <input required autocomplete="off" data-bind="css: { 'input-validation-error-add' : filedsRequired($data.cardCode()) == true }, value: cardCode, valueUpdate: 'afterkeydown'" data-encrypted-name="cvv" id="PaymentProfileForEdit_CardCode" maxlength="4" name="PaymentProfileForEdit.CardCode" type="text" value="{!!$user->security_code!!}">      
      </div>
   </div>
   <div class="mobile-clear"></div>   
   <div class="payment-profile-line zip-code-wrapper">
      <div class="payment-profile-label">
         ZIP
      </div>
      <div>         
         <input data-bind="css: { 'input-validation-error-add' : filedsRequired($data.zip()) == true }, value: zip, valueUpdate: 'afterkeydown'" id="PaymentProfileForEdit_Zip" maxlength="20" name="PaymentProfileForEdit.Zip" type="text" value="">
      </div>
   </div>   
   
</div>
                           </div>
                  </div>
      </div>
   </div>

            </div>
            <div class="agree-to-share-wrap">
               
<input data-val="true" data-val-required="The ShowRequestVisaForm field is required." id="ShowRequestVisaForm" name="ShowRequestVisaForm" type="hidden" value="True">

<div id="agreeToShareForm">
   <input data-val="true" data-val-required="The ShowFreeFormQuestion field is required." id="ShowFreeFormQuestion" name="ShowFreeFormQuestion" type="hidden" value="False">
   <input data-val="true" data-val-required="The ViewType field is required." id="ViewType" name="ViewType" type="hidden" value="EditReservation">
   
  
</div>

            </div>
         </div>
    </div>
    
    </div>
   
    </div>
    <div class="action-buttons bin-block">
      
<div class="dialog-buttons">
   <button id="continueBtn" class="button45 orange-button show-only-at-step1 ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" style="float: left; display: none;" role="button" aria-disabled="false"><span class="ui-button-text">
      Continue
   </span></button>
   <span class="ui-button-text">
     <input type='submit' value="Procced" id="checkout1" class="button45 orange-button show-at-step2 ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only ui-button-disabled" style="float: left; display: block;" role="button" aria-disabled="true" />
   </span>
   <button type="button" id="backBtn" class="button45 orange-inverted-button show-only-at-step2 ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" style="float: left; margin-left: 10px; display: block;" role="button" aria-disabled="false"><span class="ui-button-text">
      Go Back
   </span></button>
   
   <button id="cancelBtn" class="pop-cl button45 orange-inverted-button cancel-button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" style="float: left; margin-left: 10px;" onclick="reservationModel.cancelBtnClick(this, '');return false;" role="button" aria-disabled="false"><span class="ui-button-text">
      Cancel
   </span></button>

   <div class="clear"></div>
   <div class="no-charge-notification show-only-at-step1 h7" style="display: none;">
      You will not be charged until you confirm this booking on the next screen
   </div>
</div>
   </div>
    </form>
    </div>
    </div>
		
	</div>
	<script>
	 $ = jQuery.noConflict();
				
			   jQuery(document).ready(function ($) {
	 $( ".dailydate_popup" ).click(function(event) {
					   $('#myModal').modal('show');
					
					  $('.space-calendar').css('opacity', 1);
					  $('.fc-view-container').css('opacity', 1);
					  $(".space-calendar").fullCalendar('refetchEvents' );
					  $(".space-calendar").fullCalendar('rerenderEvents' );
					  $('.space-calendar.active').fullCalendar();
					  $('.space-calendar.active').fullCalendar('refresh');
					   event.preventDefault();
					
					setTimeout( function(){ 
   $('.fc-today-button').click();
  }  , 300 );
					
					   
				  });
			
				   $( "#checkout" ).click(function() {
					
					   if($('#amount').val()=='0'){
						   alert('Please select at least one space from calender');
						   return false;
					   }
				   });
	

				  });
				  </script>
				  <?php 
				  			  
				  function timeDiff($firstTime,$lastTime) {
    $firstTime=strtotime($firstTime);
    $lastTime=strtotime($lastTime);
    $timeDiff=$lastTime-$firstTime;
    return $timeDiff;
}
?>
	
	
</body>