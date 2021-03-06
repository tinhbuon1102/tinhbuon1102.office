<?php
$otherFacility = explode(',', $space->OtherFacility);
?>

<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header.php'); ?>
 @include('pages.header')
<!--/head-->
<link rel="stylesheet" href="{{url('/')}}/js/chosen/chosen.min.css">
<body class="mypage rentuser myspace">
	<div class="viewport">
		<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header_nav_shareuser.php'); ?>
		 @include('pages.header_nav_rentuser')

		<div class="main-container">
			<div id="main" class="container fixed-container">
				<div id="left-box" class="col_3_5">@include('user2.dashboard.left_nav')</div>
				<!--/leftbox-->
				<div id="samewidth" class="right_side">
					<div id="page-wrapper" class="has_fixed_title">
						<form id="basicinfo" method="post" action="/RentUser/RequireSpace">
							{{ csrf_field() }}
							<div class="page-header header-fixed">
								<div class="container-fluid">
									<div class="row">
										<div class="col-xs-6 col-md-6 col-sm-8 clearfix">
											<h1 class="pull-left">
												<i class="fa fa-cogs" aria-hidden="true"></i>
												{{ trans('edit_myspace.スペースの希望条件') }}
											</h1>
										</div>
										<div class="col-xs-6 col-md-6 col-sm-4 clearfix pb15 text-right">
											<button id="SubmitBtn" type="submit" class="btn btn-default mt15 dblk-button" data-bind="jqButton: { disabled: !isDirty() }, click: save" role="button">
												<i class="fa fa-floppy-o"></i>
												<span class="">{{ trans('edit_myspace.save') }}</span>
											</button>
										</div>
										<!--/col-xs-6-->
									</div>
								</div>
							</div>
							<!--/page-header header-fixed-->
							<div id="feed">
								<section class="feed-event recent-follow feed-box">
									<div class="space-setting-content">
										<div class="form-container">
											<div class="form-field col4_wrapper">
												<label style="display: inline;" for="require-place">
													{{ trans('edit_myspace.space_type') }}
													<!--スペースタイプ-->
												</label>
												<img style="margin-top: 0px;" src="{{ URL::asset('images/help.png') }}" class="ttimg" data-title="スペースタイプについて" data-content="デスク：コワーキングスペースや、個別デスクなどのスペース<br/> 会議室：会議室タイプのスペース
												
												
												<br />
												プライベートオフィス：1人用の個室、複数人用の個室やフロア全体を利用できるオフィススペース
												<br />
												セミナースペース：セミナー用のスペース
												<br />
												" />
												<div class="space-type-section-content clearfix">
													<div class="input-container input-col4 iconbutton icondesk" data-id="desk">
														<div class="iconbutton-icon workspace-type-icon-Desk"></div>
														<div class="iconbutton-name">
															{{ trans('edit_myspace.desk') }}
															<!--デスク-->
														</div>
														<input type="checkbox" value="Desk" name="SpaceType[]" class="SpaceType" id="desk" style="display: none">
													</div>
													<!--/icon-button-->
													<div class="input-container input-col4 iconbutton iconmeetingspace" data-id="meetingspace">
														<div class="iconbutton-icon workspace-type-icon-Meeting"></div>
														<div class="iconbutton-name">
															{{ trans('edit_myspace.meeting_room') }}
															<!--会議室-->
														</div>
														<input type="checkbox" value="MeetingSpace" name="SpaceType[]" class="SpaceType" id="meetingspace" style="display: none">
													</div>
													<!--/icon-button-->
													<div class="input-container input-col4 iconbutton iconprivateoffice" data-id="privateoffice">
														<div class="iconbutton-icon workspace-type-icon-Office"></div>
														<div class="iconbutton-name">
															{{ trans('edit_myspace.office') }}
															<!--プライベートオフィス-->
														</div>
														<input type="checkbox" value="PrivateOffice" name="SpaceType[]" class="SpaceType" id="privateoffice" style="display: none">
													</div>
													<!--/icon-button-->
													<div class="input-container input-col4 iconbutton iconseminarspace" data-id="seminarspace">
														<div class="iconbutton-icon workspace-type-icon-Training"></div>
														<div class="iconbutton-name">
															{{ trans('edit_myspace.seminar_space') }}
															<!--セミナースペース-->
														</div>
														<input type="checkbox" value="SeminarSpace" name="SpaceType[]" class="SpaceType" id="seminarspace" style="display: none">
													</div>
													<!--/icon-button-->
												</div>
												<!--/space-type-section-content-->
											</div>
											<!--/form-field-->
											<div class="form-field col3_wrapper">
												<label for="require-place">
													<!--希望地域-->
													{{ trans('edit_myspace.desire_location') }}
												</label>
												<div class="input-container input-col3">
													<?php
															echo Form::select('DesireLocationPrefecture', getPrefectures(), $space->DesireLocationPrefecture, [
																	'id' => 'DesireLocationPrefecture', 'class' => 'address_select',
															]);
															?>
															
													<!--select prefecture-->
												</div>
												<div class="input-container input-col3">
													<select data-label="市区町村を選択" data-placeholder="市区町村を選択(複数選択可)" class="address_select chosen-select" multiple name="DesireLocationDistricts[]" id="DesireLocationDistricts"></select>
													<!--select districts-->
												</div>
												<div class="input-container input-col3 last" style="display: none;">
													<select data-label="町域を選択" class="chosen-select address_select" multiple tabindex="16" name="DesireLocationTown" id="DesireLocationTown"></select>
													<!--select towns-->
												</div>
											</div>
											<!--/form-field-->
											<div class="form-field two-inputs">
												<div class="input-container input-half">
													<div class="field_col2_wrapper clearfix">
														<label for="your_budget">
															{{ trans('edit_myspace.your_budget') }}
															<!--希望利用料金Your budget-->
														</label>
														<div class="field_col2">
															<select id="choose_budget_per" name="BudgetType">
																<option value="">{{ trans('edit_myspace.select_from_hdwm') }}
																	<!--時間・日・週・月あたりから選択--><!--select hour,day,week or month--></option>
																<option value="hour" <?php if ($space->BudgetType == 'hour') echo 'selected'?> class="choose_budget_per_hour" data-type="hour">{{ Config::get('lp.budget.hour') }}</option>
																<option value="day" <?php if ($space->BudgetType == 'day') echo 'selected'?> class="choose_budget_per_day" data-type="day">{{ Config::get('lp.budget.day') }}</option>
																<option value="week" <?php if ($space->BudgetType == 'week') echo 'selected'?> class="choose_budget_per_week" data-type="week">{{ Config::get('lp.budget.week') }}</option>
																<option value="month" <?php if ($space->BudgetType == 'month') echo 'selected'?> class="choose_budget_per_month" data-type="month">{{ Config::get('lp.budget.month') }}</option>
															</select>
														</div>
														<div class="field_col2">
															<select id="choose_budget_per_" class="" data-label="予算を選択" name="BudgetID">
																<option value="" selected="">{{ trans('edit_myspace.select_budget') }}</option>
																@foreach($budgets as $budget)
																<option value="{{ $budget->id }}" <?php if ($space->BudgetID == $budget->id) echo 'selected'?> class="{{ $budget->Type }} <?php echo $budget->Type == $space->BudgetType ? '' : 'hide'?> budget-price1">{{ $budget->Display }}</option>
																@endforeach
															</select>
														</div>
													</div>
													<!--/clearfix-->
												</div>
												<div class="input-container input-half">
													<label for="time_slot">
														{{ trans('edit_myspace.time_use') }}
														<!--利用時間帯-->
														<!--Time slot to use-->
													</label>
													<select id="choose_timeslot" data-label="時間帯を選択" name="TimeSlot">
														<option value="" selected="">時間帯を選択</option>
														@foreach($timeslots as $timeslot)
														<option value="{{ $timeslot->id }}" <?php if ($space->TimeSlot == $timeslot->id) echo 'selected'?>>{{ $timeslot->Display }}</option>
														@endforeach
													</select>
												</div>
											</div>
											<!--/form-field-->
											<div class="form-field two-inputs">
												<div class="input-container input-half">
													<label for="space_area">スペース面積</label>
													<select id="choose_spacearea" data-label="面積を選択" name="SpaceArea">
														<option value="" >面積を選択</option>
														@foreach(Config::get('lp.spaceArea') as $area => $ar )
														<option value="{{ $ar['id'] }}" <?php if ($space->SpaceArea == $ar['id']) echo 'selected'?>>{{ $ar['display'] }}</option>
														@endforeach
													</select>
												</div>
												<div class="input-container input-half">
													<label for="number_people">
														利用人数
														<!--Number of people to use-->
													</label>
													<select id="choose_numpeople" data-label="人数を選択" name="NumberOfPeople">
														<option value="" >人数を選択</option>
														<option value="1人" <?php if ($space->NumberOfPeople == '1人') echo 'selected'?>>1人</option>
														<option value="2人" <?php if ($space->NumberOfPeople == '2人') echo 'selected'?>>2人</option>
														<option value="3人" <?php if ($space->NumberOfPeople == '3人') echo 'selected'?>>3人</option>
														<option value="4人~6人" <?php if ($space->NumberOfPeople == '4人~6人') echo 'selected'?>>4人~6人</option>
														<option value="6人以上" <?php if ($space->NumberOfPeople == '6人以上') echo 'selected'?>>6人以上</option>
													</select>
												</div>
											</div>
											<!--/form-field-->
											<!--	</form> -->
											<div class="form-field two-inputs">
												<div class="input-container input-half">
													<label for="space_area">どんな事業に興味がありますか？</label>
													<?php
														echo Form::select('BusinessType', getBusinessTypes(), $space->BusinessType, [
																	'id' => 'BusinessType_workplace',
																	'class' => 'old_ui_selector',
															]);
															?>
												</div>
											</div>
										</div>
										<!--/form-container-->
										<div class="form-container">
											<div class="form-field">
												<div class="input-container">
													<label for="space_area">備考</label>
													<textarea rows="4" name="notes_ideals" id="comment-field-id" cols="90" value="{{$space->notes_ideals}}">{{$space->notes_ideals}}</textarea>
													<small id="text-counter" class="muted note right">
														残り
														<span>1500</span>
														文字
													</small>
													<small style="display: none;" class="help-inline">
														<span for="comment-field-id" generated="true" class="error">10文字以上入力して下さい</span>
													</small>
												</div>
											</div>
										</div>
										<div class="form-container">
											<!--	<form id="FacilitiesSpace"> -->
											<div class="form-field quater-inputs">
												<label for="SpaceFacilities" class="mgn-btm10">
													スペースに含まれる設備
													<!--Facilities available with space-->
												</label>
												<div class="input-container input-quater">
													<label for="num-desk" class="font-normal">
														デスク
														<!--Desk-->
													</label>
													<span class="field-number-input-withunit">
														<input type="number" name="NumOfDesk" min="1" max="50" value="{{$space->NumOfDesk}}">
														台
													</span>
												</div>
												<div class="input-container input-quater">
													<label for="num-chair" class="font-normal">
														イス
														<!--Chair-->
													</label>
													<span class="field-number-input-withunit">
														<input type="number" name="NumOfChair" min="1" max="50" value="{{$space->NumOfChair}}">
														脚
													</span>
												</div>
												<div class="input-container input-quater">
													<label for="num-board" class="font-normal">
														ボード
														<!--Board-->
													</label>
													<span class="field-number-input-withunit">
														<input type="number" name="NumOfBoard" min="1" max="50" value="{{$space->NumOfBoard}}">
														台
													</span>
												</div>
												<div class="input-container input-quater">
													<label for="num-largedesk" class="font-normal">
														複数人用デスク
														<!--Table for some people-->
													</label>
													<span class="field-number-input-withunit">
														<input type="number" name="NumOfLargeDesk" min="1" max="50" value="{{$space->NumOfLargeDesk}}">
														台
													</span>
												</div>
											</div>
											<!--/form-field-->
											<div class="form-field no-btm-border">
												<div class="input-container">
													<label for="OtherFac">
														その他設備
														<!--Other facilities-->
													</label>
													<span class="field-checkbox">
														<input type="checkbox" name="OtherFacility[]" value="wi-fi" <?php if(in_array('wi-fi', $otherFacility)) echo 'checked'?> data-labelauty="wi-fi|wi-fi" class="other_facilities custom-checkbox">
													</span>
													<span class="field-checkbox">
														<input type="checkbox" name="OtherFacility[]" value="プリンター" <?php if(in_array('プリンター', $otherFacility)) echo 'checked'?> data-labelauty="プリンター|プリンター" class="other_facilities custom-checkbox">
													</span>
													<span class="field-checkbox">
														<input type="checkbox" name="OtherFacility[]" value="プロジェクター" <?php if(in_array('プロジェクター', $otherFacility)) echo 'checked'?> data-labelauty="プロジェクター|プロジェクター" class="other_facilities custom-checkbox">
													</span>
													<span class="field-checkbox">
														<input type="checkbox" name="OtherFacility[]" value="自動販売機" <?php if(in_array('自動販売機', $otherFacility)) echo 'checked'?> data-labelauty="自動販売機|自動販売機" class="other_facilities custom-checkbox">
													</span>
													<span class="field-checkbox">
														<input type="checkbox" name="OtherFacility[]" value="男女別トイレ" <?php if(in_array('男女別トイレ', $otherFacility)) echo 'checked'?> data-labelauty="男女別トイレ|男女別トイレ" class="other_facilities custom-checkbox">
													</span>
													<span class="field-checkbox">
														<input type="checkbox" name="OtherFacility[]" value="喫煙所" <?php if(in_array('喫煙所', $otherFacility)) echo 'checked'?> data-labelauty="喫煙所|喫煙所" class="other_facilities custom-checkbox">
													</span>
												</div>
											</div>
											<!--/form-field-->
											<div class="form-field no-btm-border no-btm-pad">
												<div class="input-container">
													<label for="OtherFac">
														ビル設備
														<!--Building facilities-->
													</label>
													<span class="field-checkbox">
														<input type="checkbox" name="OtherFacility[]" value="駐車場" <?php if(in_array('駐車場', $otherFacility)) echo 'checked'?> data-labelauty="駐車場|駐車場" class="other_facilities custom-checkbox">
													</span>
													<span class="field-checkbox">
														<input type="checkbox" name="OtherFacility[]" value="エレベーター" <?php if(in_array('エレベーター', $otherFacility)) echo 'checked'?> data-labelauty="エレベーター|エレベーター" class="other_facilities custom-checkbox">
													</span>
												</div>
											</div>
											<!--/form-field-->
										</div>
										<!--/form-container-->
									</div>
									<!--/space-setting-content-->
								</section>
							</div>
						</form>
						<!--/feed-->
						<!--footer-->
						@include('pages.dashboard_user1_footer')
						<!--/footer-->
					</div>
					<!--/page-wrapper-->
				</div>
				<!--/right_side-->
			</div>
		</div>
		<!--/main-container-->
	</div>
	<!--/viewport-->
	<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script> -->
	<script src="<?php echo SITE_URL?>js/chosen/chosen.jquery.min.js" type="text/javascript"></script>
	<script src="<?php echo SITE_URL?>js/chosen/chosen.proto.min.js" type="text/javascript"></script>
	<script src="<?php echo SITE_URL?>js/chosen/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?php echo SITE_URL?>js/address_select.js" type="text/javascript"></script>
	<script type="text/javascript">
/*var config = {
      '.chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }*/

    
  </script>
	<script>
jQuery.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
    }
});
jQuery(function(){
    
	function updateCountReview (){
	var len = jQuery("#comment-field-id").val().length;
	if(len < 10){
		jQuery(".help-inline").show();
	}else{
		jQuery(".help-inline").hide();
	}
	jQuery("#text-counter span").text(1500-len );
	}

	jQuery("#comment-field-id").keyup(function () {
        updateCountReview();
    });
    jQuery("#comment-field-id").keypress(function () {
        updateCountReview();
    });
    jQuery("#comment-field-id").keydown(function () {
        updateCountReview();
    });
	
    // 全ての駅名を非表示にする
    // 路線のプルダウンが変更されたら
    jQuery("#choose_budget_per").change(function(){
        // 全ての駅名を非表示にする
        jQuery(".budget-price1").addClass('hide');
        // 選択された路線に連動した駅名プルダウンを表示する
        jQuery('.' + jQuery("#choose_budget_per option:selected").val()).removeClass("hide");
    });
	jQuery("#btnSave").click(function(){
		jQuery("#btnSave").hide();
		var pref=jQuery('#DesireLocationPrefecture option:selected').text();
		var dist=jQuery('#DesireLocationDistricts option:selected').map(function() {return this.value;}).get().join(',');
		var town=jQuery("#DesireLocationTown option:selected").map(function() {return this.value;}).get().join(',');		
		var timeslot=jQuery('#choose_timeslot').val();
		var numpeople = jQuery('#choose_numpeople').val();
		var spaceArea = jQuery('#choose_spacearea').val();
		var businessType = jQuery('#BusinessType_workplace').val();	
		var budgetType = jQuery('#choose_budget_per').val();
		var budgetId = jQuery('#choose_budget_per_').val();
		var spacetype1 = jQuery('.SpaceType:checked').map(function() {return this.value;}).get().join(',');
	var numDesk = jQuery('input[name="num_desk"]').val();
		var numChair = jQuery('input[name="num_chair"]').val();
		var numBorad = jQuery('input[name="num_board"]').val();
		var numLargeDesk = jQuery('input[name="num_largedesk"]').val();
		var otFacility = jQuery('.other_facilities').map(function() { if(jQuery(this).is(':checked'))return this.value; else return;}).get().join(',')
		jQuery.ajax({
            type: "POST",
            url : '/RentUser/Dashboard/MyProfile/Edit',
            data : { SpaceType:spacetype1,DesireLocationPrefecture:pref,DesireLocationDistricts:dist,DesireLocationTown:town,
					BudgetType:budgetType,BudgetID:budgetId,TimeSlot:timeslot,SpaceArea:spaceArea,NumberOfPeople:numpeople,
					numOfDesk:numDesk,NumOfChair:numChair,BusinessType:businessType,NumOfBoard:numBorad,NumOfLargeDesk:numLargeDesk,OtherFacility:otFacility},
           success: function(data){ 
					location.href='/RentUser/Dashboard/MyProfile';
		   }
		   });
		   jQuery("#show")
	});
	LoadDetail();
})
jQuery(".input-container.iconbutton").click(function(){
  jQuery(this).toggleClass("checked");
  var checkBoxes =  jQuery("#"+jQuery(this).data("id"));
  checkBoxes.prop("checked", !checkBoxes.prop("checked"));
});
function LoadDetail()
{
	var spaceType = '<?php echo $space->SpaceType ?>'.split(',');
		jQuery(spaceType).each(function(index,value){
			jQuery('#'+value.toLowerCase()).attr('checked','checked');
			jQuery('.icon'+value.toLowerCase()).addClass('checked');
		});
		jQuery('#DesireLocationPrefecture').change(function(){
			setTimeout(function(){
				var district = '<?php echo $space->DesireLocationDistricts ?>';
				jQuery('#DesireLocationDistricts').val(district.split(',')).trigger('change');
				jQuery('#DesireLocationDistricts').trigger('chosen:updated');
			}, 1500);
		});

}
</script>
</body>
</html>
