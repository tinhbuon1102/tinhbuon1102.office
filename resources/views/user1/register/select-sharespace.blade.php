
@include('pages.header_beforelogin')
<link rel="stylesheet" href="{{ URL::asset('js/chosen/chosen.css') }}">
<script>
	jQuery( document ).ready(function() {
	
	@if($IsEdit=='True' || $IsDuplicate=='True')
		$('#prefecture').val("{{$space->Prefecture}}");
 $('#choose_per_type').val("{{$space->FeeType}}");
 $('#choose_type_of_office').val("{{$space->Type}}");
 $('#HourMinTerm').val("{{$space->HourMinTerm}}")
 $('#WeekMinTerm').val("{{$space->WeekMinTerm}}")
 $('#MonthMinTerm').val("{{$space->MonthMinTerm}}")  		
	var i;
	for(i=1;i<8;i++)
	{			
		switch(i)
		{
			 case 1:
					if("{{$space->isClosedMonday}}" == "Yes")
					{
						$('input[name="isClosedMonday"]').attr('checked','checked');
						$('input[name="isClosedMonday"]').click();
					}
					if("{{$space->isOpen24Monday}}" == "Yes")
					{
						$('input[name="isOpen24Monday"]').attr('checked','checked');
						$('input[name="isOpen24Monday"]').click();
					}
				break;
			case 2:
					if("{{$space->isClosedTuesday}}" == "Yes")
					{
						$('input[name="isClosedTuesday"]').attr('checked','checked');
						$('input[name="isClosedTuesday"]').click();
					}
					if("{{$space->isOpen24Tuesday}}" == "Yes")
					{
						$('input[name="isOpen24Tuesday"]').attr('checked','checked');
						$('input[name="isOpen24Tuesday"]').click();
					}
				break;
			case 3:
					if("{{$space->isClosedWednesday}}" == "Yes")
					{
						$('input[name="isClosedWednesday"]').attr('checked','checked');
						$('input[name="isClosedWednesday"]').click();
					}
					if("{{$space->isOpen24Wednesday}}" == "Yes")
					{
						$('input[name="isOpen24Wednesday"]').attr('checked','checked');
						$('input[name="isOpen24Wednesday"]').click();
					}
				break;
			case 4:				
					if("{{$space->isClosedThursday}}" == "Yes")
					{
						$('input[name="isClosedThursday"]').attr('checked','checked');
						$('input[name="isClosedThursday"]').click();
					}
					if("{{$space->isOpen24Thursday}}" == "Yes")
					{
						$('input[name="isOpen24Thursday"]').attr('checked','checked');
						$('input[name="isOpen24Thursday"]').click();
					}
				break;
			case 5:
					if("{{$space->isClosedFriday}}" == "Yes")
					{
						$('input[name="isClosedFriday"]').attr('checked','checked');
						$('input[name="isClosedFriday"]').click();
					}
					if("{{$space->isOpen24Friday}}" == "Yes")
					{
						$('input[name="isOpen24Friday"]').attr('checked','checked');
						$('input[name="isOpen24Friday"]').click();
					}
				break;
			case 6:
					if("{{$space->isClosedSaturday}}" == "Yes")
					{
						$('input[name="isClosedSaturday"]').attr('checked','checked');
						$('input[name="isClosedSaturday"]').click();
					}
					if("{{$space->isOpen24Saturday}}" == "Yes")
					{
						$('input[name="isOpen24Saturday"]').attr('checked','checked');
						$('input[name="isOpen24Saturday"]').click();
					}
				break;
			case 7:
					if("{{$space->isClosedSunday}}" == "Yes")
					{
						$('input[name="isClosedSunday"]').attr('checked','checked');
						$('input[name="isClosedSunday"]').click();
					}
					if("{{$space->isOpen24Sunday}}" == "Yes")
					{
						$('input[name="isOpen24Sunday"]').attr('checked','checked');
						$('input[name="isOpen24Sunday"]').click();
					}
				break; 
		}
	}
	@endif
	@if(Auth::check() && Auth::user()->Prefecture && $IsEdit=='False')
		jQuery('#prefecture').val("{{Auth::user()->Prefecture}}");
	@endif
	});
	</script>
<!--/head-->
<body class="selectPage rentuser sharepage">
	<div class="viewport">
		<div class="header_wrapper primary-navigation-section">
			<header id="header">
				<div class="header_container dark">
					<div class="logo_container">
						<a class="logo" href="index.html">hOur Office</a>
					</div>
				</div>
			</header>
		</div>
		<div class="main-container">
			<div id="main" class="container">
				<h1 class="page-title">
					提供するオフィススペースについて
				</h1>
				<p class="sub-title">
					提供するオフィススペース情報を入力して下さい。
				</p>
				
				<p class="sub-title not-verified">
				<?php if (!IsEmailVerified($user)) {
					//echo 'Please verify account in your email to continue';
					//die;
				}?>
				</p>
				
				<div class="form-container">
					@if($IsEdit=='True')
					<form id="shareinfo" name="ShareInfo" method="post" action="{{ url('ShareUser/ShareInfo/'.$space->HashID) }}" class="fl-form ">
					@else
					<form id="shareinfo" name="ShareInfo" method="post" action="{{ url('ShareUser/ShareInfo') }}" class="fl-form ">
					@endif
					@if (count($errors) > 0)
<div class="form-error">
  <ul>
   @foreach($errors as $error)
      <li> {{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif
				{{ csrf_field() }} 
					<fieldset>
						<div class="Signup-sectionHeader">
							<legend class="signup-sectionTitle">
								基本情報
							</legend>
						</div>


<div class="form-field">
											<label for="SpaceTitle">
												<span class="require-mark">*</span>
												タイトル
												<span class="help">*サイトの掲載されるスペースの名前をご入力ください。</span>
											</label>
											<div class="input-container">
												<input name="Title" id="SpaceTitle" value="{{$space->Title}}" required="" ng-model="setting.space_title" type="text" class="ng-invalid" aria-invalid="true" placeholder="4人~6人用オープンデスク">
											</div>
										</div>
                                        
						<div class="form-field share-locate">
							<label for="require-place"><span class="require-mark">*</span>住所<span class="help">*提供するスペースが会社の住所と異なる場合のみご変更ください。</span> </label>
                            
                           <div class="form-field two-inputs nopd no-btm-border">
<div class="input-container input-half withrightlabel">
<? if(Auth::check() && Auth::user()->PostalCode && $IsEdit=='False'){
 $PostalCode=Auth::user()->PostalCode;
 $District=Auth::user()->District;
 $Address1=Auth::user()->Address1;
 $Address2=Auth::user()->Address2;
 }
 else {
$PostalCode= $space->PostalCode;
 $District=$space->District;
 $Address1=$space->Address1;
 $Address2=$space->Address2;
 } ?>
<label class="post-mark inline">〒</label><input name="PostalCode" value="{{$PostalCode}}" required="" id="zip" type="text" 　class="ng-pristine ng-untouched ng-invalid-required" aria-required="true">
</div>
</div><!--/form-field-->
<div class="form-field two-inputs nopd no-btm-border">
                           
							<div class="input-container input-half">
								<select  id="prefecture" required name="Prefecture" data-label="都道府県を選択">
                                <option value="北海道">北海道</option><option value="青森県">青森県</option><option value="岩手県">岩手県</option><option value="宮城県">宮城県</option><option value="秋田県">秋田県</option><option value="山形県">山形県</option><option value="福島県">福島県</option><option value="茨城県">茨城県</option><option value="栃木県">栃木県</option><option value="群馬県">群馬県</option><option value="埼玉県">埼玉県</option><option value="千葉県">千葉県</option><option value="東京都">東京都</option><option value="神奈川県">神奈川県</option><option value="新潟県">新潟県</option><option value="富山県">富山県</option><option value="石川県">石川県</option><option value="福井県">福井県</option><option value="山梨県">山梨県</option><option value="長野県">長野県</option><option value="岐阜県">岐阜県</option><option value="静岡県">静岡県</option><option value="愛知県">愛知県</option><option value="三重県">三重県</option><option value="滋賀県">滋賀県</option><option value="京都府">京都府</option><option value="大阪府">大阪府</option><option value="兵庫県">兵庫県</option><option value="奈良県">奈良県</option><option value="和歌山県">和歌山県</option><option value="鳥取県">鳥取県</option><option value="島根県">島根県</option><option value="岡山県">岡山県</option><option value="広島県">広島県</option><option value="山口県">山口県</option><option value="徳島県">徳島県</option><option value="香川県">香川県</option><option value="愛媛県">愛媛県</option><option value="高知県">高知県</option><option value="福岡県">福岡県</option><option value="佐賀県">佐賀県</option><option value="長崎県">長崎県</option><option value="熊本県">熊本県</option><option value="大分県">大分県</option><option value="宮崎県">宮崎県</option><option value="鹿児島県">鹿児島県</option><option value="沖縄県">沖縄県</option>
                                </select>
								<!--select prefecture-->
							</div>
							<div class="input-container input-half">
								<input name="District" required="" value="{{$District}}"   id="district" type="text" class="ng-pristine ng-untouched ng-invalid-required" aria-required="true" placeholder="市区町村">
								<!--select districts-->
							</div>
                            </div>
						<!--/form-field-->
                            <div class="form-field two-inputs nopd no-btm-border">
							<div class="input-container input-half">
								<input name="Address1" required="" id="SpaceAddr" value="{{$Address1}}" required="" ng-model="signup.addr" type="text" class="ng-pristine ng-untouched ng-invalid-required" aria-required="true" placeholder="番地">
								<!--select towns-->
							</div>
                            <div class="input-container input-half">
                            <input name="Address2" id="SpaceAddr2" value="{{$Address2}}"  ng-model="signup.addr2" type="text" class="ng-pristine ng-untouched" placeholder="建物名・階・部屋番号">
                            </div>
						</div>
						<!--/form-field-->
                        </div><!--/form-field-->
						<div class="form-field col3_wrapper">
							<label for="SpaceTitle"> <span class="require-mark">*</span>スペースタイプと利用可能人数
							</label>
							<div class="input-container input-col3">
								<select id="choose_per_type" name="FeeType" required>
									@foreach(Config::get('lp.budgetType') as $bud => $ar ) 
										<option data-group="{{ $ar['type'] }}" data-fee-group="{{ $ar['fee'] }}" value="{{ $ar['id'] }}">{{ $ar['display'] }}</option>
									@endforeach  
									<!--<option data-group="type-group-c" data-fee-group="fee-group-a" value="時間毎">時間毎</option>
									<option data-group="type-group-a" data-fee-group="fee-group-b" value="日毎">日毎</option>
									<option data-group="type-group-b" data-fee-group="fee-group-c" value="週毎">週毎</option>
									<option data-group="type-group-b" data-fee-group="fee-group-d" value="月毎">月毎</option>
									<option data-group="type-group-a" data-fee-group="fee-group-a,fee-group-b" value="時間+日毎">時間+日毎</option>
									<option data-group="type-group-a" data-fee-group="fee-group-b,fee-group-c" value="日毎+週毎">日毎+週毎</option>
									<option data-group="type-group-b" data-fee-group="fee-group-c,fee-group-d" value="週毎+月毎">週毎+月毎</option>
									-->
								</select>
							</div>
							<div class="input-container input-col3">
								<select id="choose_type_of_office" required name="Type" data-label="スペースタイプを選択">
									<option value="" selected="">スペースタイプを選択</option>
									<option value="{{SPACE_FIELD_CORE_WORKING}}">{{SPACE_FIELD_CORE_WORKING}}</option>
									<option data-room-group="room-group-a" value="{{SPACE_FIELD_OPEN_DESK}}" >{{SPACE_FIELD_OPEN_DESK}}</option>
									<option data-room-group="room-group-a" value="{{SPACE_FIELD_SHARE_DESK}}">{{SPACE_FIELD_SHARE_DESK}}</option>
									<!--Monthly-->
									<!--Weekly-->
									<option data-group="type-group-b" data-room-group="room-group-a" value="{{SPACE_FIELD_PRIVATE_OFFICE}}">{{SPACE_FIELD_PRIVATE_OFFICE}}</option>
									<option data-group="type-group-b" data-room-group="room-group-a" value={{SPACE_FIELD_TEAM_OFFICE}}>{{SPACE_FIELD_TEAM_OFFICE}}</option>
									<option data-group="type-group-b" value="{{SPACE_FIELD_OFFICE}}">{{SPACE_FIELD_OFFICE}}</option>
									<!--Hourly-->
									<option data-group="type-group-c" value="{{SPACE_FIELD_METTING}}">{{SPACE_FIELD_METTING}}</option>
									<option data-group="type-group-c" value="{{SPACE_FIELD_SEMINAR_SPACE}}">{{SPACE_FIELD_SEMINAR_SPACE}}</option>
								</select>
							</div>
							<div class="input-container input-col3" id="capacity_people_wraper">
								<div class="input_withunit">
									<input type="number" required="" value="{{$space->Capacity}}" name="Capacity" min="1" max="100" id="ty3"> 人
								</div>
							</div>
						</div>

						<div class="form-field two-inputs space-area-wraper type-group-sub" data-group="type-group-b">
							<div class="input-container input-half">
								<label for="space_area">スペース面積
								</label>
								<div class="input_withunit">
									<input type="number" required="" value="{{$space->Area}}" name="Area" min="1" max="100" id="ty3">m&sup2;
								</div>
							</div>

						</div>
						<!--/form-field-->
                        <div class="form-field nopd no-btm-border">
											<label for="SpaceDesc">
												<span class="require-mark">*</span>
												スペース説明文
											</label>
											<textarea required cols="20" name="Details" id="WorkspaceData_ShortDescription" rows="5" class="space-desc-textarea ng-pristine ng-untouched ng-invalid ng-invalid-required">{{$space->Details}}</textarea>
											<div class="text-length-counter">
												<span>0</span>
												<span>/4000</span>
											</div>
										</div>
					</fieldset>
					<div class="hr"></div>
					
					<fieldset>
                    <div class="Signup-sectionHeader">
							<legend class="signup-sectionTitle">
								写真
							</legend>
						</div>
					<section class="space-photo-upload">
							
							<div class="space-setting-content">
								<div class="form-container">
										<div class="form-field two-inputs nopd no-btm-border">
											<div class="input-container input-half">
												<label for="SpaceMainPhoto"> <span class="require-mark">*</span>メイン写真
												</label>
												<div class="edit-gallery-wrapper">
													<div class="edit-gallery-thumbnails edit-main-picture edit-gallery-thumbnails-placeholder">
														<?php 
														$main="";
														$main_id="";
														$thumb_1="";
														$thumb_1_id="";
														$thumb_2="";
														$thumb_2_id="";
														$thumb_3="";
														$thumb_3_id="";
														$thumb_4="";
														$thumb_4_id="";
														$thumb_5="";
														$thumb_5_id="";
														$k=1;
														if($IsEdit=="True")
															{
																$spaceImg= $space->spaceImage->all();
																;
																foreach($spaceImg as $im)
																{
																	if($im->Main==1)
																	{
																		$main=$im->ThumbPath;
																		$main_id=$im->id;
																	}
																	else{
																		${"thumb_".$k} = $im->SThumbPath;
																		${"thumb_".$k."_id"}=$im->id;
																		$k++;
																	}
																}
															} 
															
															?>
														<div class="edit-gallery-thumbnail-wrapper" image-type="main" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#popover_content_wrapper" style=<?php if(Session::get('space_image')) echo 'background-image:url("'. (Session::get('space_image')) .'?t='. time() .'")'?> <?php if(!empty($main)) echo 'background-image:url("'.($main).'")'?>>
															<input type="hidden" name="dataimage[main]" id="image_main" value="" />
																<?php if($IsEdit=="True"){ ?>
																	<input type="hidden" name="dataimage[main_id]" value="<?=$main_id?>" />
																<?php } ?>
														</div>
													</div>
												</div>
												<div class="edit-gallery-buttons" data-toggle="modal"  image-type="main" data-target="#popover_content_wrapper">
													<button class="upload-button btn ui-button-text-only yellow-button" role="button" aria-disabled="false">
														<span class="ui-button-text">アップロード</span>
													</button>
													<button class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false" style="display: none;">
														<span class="ui-button-text">Edit selected</span>
													</button>
												</div>
											</div>
											<!--/input-container-->

											<label for="SpacePhotos">メイン写真
											</label>
											<div class="input-container input-half">
												<div class="edit-gallery-wrapper">
													<div class="edit-gallery-thumbnails edit-gallery-thumbnails-placeholder">
														<?php for($i=1; $i<6; $i++) {?>
																<?php $timg=${"thumb_".$i}; ?>
															<div class="edit-gallery-thumbnail-wrapper" image-type="thumb_<?php echo $i?>" data-toggle="modal" data-backdrop="static" data-keyboard="false"  data-target="#popover_content_wrapper" style=<?php if(!empty($timg)) echo 'background-image:url("'.($timg).'")'?>>
																<input type="hidden" name="dataimage[thumb_<?php echo $i?>]" value="" id="image_thumb_<?php echo $i?>"   />
																<?php if($IsEdit=="True"){ ?>
																<input type="hidden" name="dataimage[thumb_<?php echo $i?>_id]" value="<?=${"thumb_".$i."_id"}?>"    />
																<?php } ?>
															</div>
														<?php }?>
													</div>
												</div>
												<div class="edit-gallery-buttons" data-toggle="modal" image-type="thumb_<?=$k?>" isbutton="yes" data-target="#popover_content_wrapper">
													<button class="upload-button btn ui-button-text-only yellow-button" role="button" aria-disabled="false">
														<span class="ui-button-text">アップロード</span>
													</button>
													<button class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false" style="display: none;">
														<span class="ui-button-text">Edit selected</span>
													</button>
												</div>
											</div>
											<!--/input-container-->
										</div>
								</div>
								<!--/form-container-->
							</div>
							<!--/space-setting-content-->
						</section>
					</fieldset>
                    <div class="hr"></div>
					
					<fieldset>
						<div class="Signup-sectionHeader">
							<legend class="signup-sectionTitle">
								金額と期間
							</legend>
						</div>


						<!--Hourly-->
						<div class="form-field two-inputs fee-group-sub nopd no-btm-border" data-fee-group="fee-group-a">
							<div class="input-container input-half">
								<div class="field_col">
									<div class="input_withunit space_price_term" id="choose_fee_per">
										<label class="label_left">1時間あたり
										</label> <input required="" value="{{$space->HourFee}}" name="HourFee" id="FeePerHour"  required="" ng-model="signup.fee_price_per_hour" type="text" class="ng-invalid" aria-invalid="true" placeholder="">円
									</div>
								</div>
								<!--/field_col-->
							</div>
							<!--/input-half-->
							<div class="input-container input-half">
								<div class="field_col">
                                <div class="input_withunit space_min_term">
                                 <label class="label_left">最低利用時間</label> 
									<select required data-bind="value: MinimumBookingLength" data-val="true" data-val-number="The field MinimumBookingLength must be a number." data-val-required="The MinimumBookingLength field is required." id="HourMinTerm" name="HourMinTerm"><option selected="selected" value="1">1時間</option>
										<option value="2">2時間</option>
										<option value="3">3時間</option>
										<option value="4">4時間</option>
									</select>
                                    </div>
								</div>
								<!--/field_col-->
							</div>
							<!--/input-half-->
						</div>
						<!--/form-field-->

						<!--Daily-->
						<div class="form-field two-inputs fee-group-sub" data-fee-group="fee-group-b">
							<div class="input-container input-half">
								<div class="field_col">
									<div class="input_withunit space_price_term" id="choose_fee_per_day">
										<label class="label_left">1日あたり</label><input required="" name="DayFee" id="FeePerDay" value="{{$space->DayFee}}" required="" ng-model="signup.fee_price_per_day" type="text" class="ng-invalid" aria-invalid="true" placeholder="">円
									</div>
								</div>
								<!--/field_col-->
							</div>
							<!--/input-half-->
							<div class="input-container input-half">
								<div class="field_col"></div>
								<!--/field_col-->
							</div>
							<!--/input-half-->
						</div>
						<!--/form-field-->


						<!--Weekly-->
						<div class="form-field two-inputs fee-group-sub" data-fee-group="fee-group-c">
							<div class="input-container input-half">
								<div class="field_col">
									<div class="input_withunit space_price_term" id="choose_fee_per_week">
										<label class="label_left">1週間あたり</label><input required="" name="WeekFee" id="FeePerWeek" value="{{$space->WeekFee}}" required="" ng-model="signup.fee_price_per_week" type="text" class="ng-invalid" aria-invalid="true" placeholder="">円
									</div>
								</div>
								<!--/field_col-->
							</div>
							<!--/input-half-->
							<div class="input-container input-half">
								<div class="field_col">
                                <div class="input_withunit space_min_term">
                                 <label class="label_left">最低利用期間</label>
									<select data-bind="value: MinimumBookingLength" required data-val="true" data-val-number="The field MinimumBookingLength must be a number." data-val-required="The MinimumBookingLength field is required." id="WeekMinTerm" name="WeekMinTerm"><option selected="selected" value="1">1週間</option>
										<option value="2">2週間</option>
									</select>
                                    </div>
								</div>
								<!--/field_col-->
							</div>
							<!--/input-half-->
						</div>
						<!--/form-field-->

						<!--Monthly-->
						<div class="form-field two-inputs no-btm-border fee-group-sub" data-fee-group="fee-group-d">
							<div class="input-container input-half">
								<div class="field_col">
									<div class="input_withunit space_price_term" id="choose_fee_per_month">
										<label class="label_left">1ヶ月あたり</label><input required="" name="MonthFee" id="FeePerMonth" value="{{$space->MonthFee}}" required="" ng-model="signup.fee_price_per_month" type="text" class="ng-invalid" aria-invalid="true" placeholder="">円
									</div>
								</div>
								<!--/field_col-->
							</div>
							<!--/input-half-->
							<div class="input-container input-half">
								<div class="field_col">
                                <div class="input_withunit space_min_term">
                                 <label class="label_left">最低利用期間</label>
									<select required data-bind="value: MinimumBookingLength" data-val="true" data-val-number="The field MinimumBookingLength must be a number." data-val-required="The MinimumBookingLength field is required." id="MonthMinTerm" name="MonthMinTerm"><option selected="selected" value="1">1ヶ月</option>
										<option value="3">3ヶ月</option>
										<option value="6">6ヶ月</option>
										<option value="12">12ヶ月</option>
									</select>
                                    </div>
								</div>
								<!--/field_col-->
							</div>
							<!--/input-half-->
						</div>
						<!--/form-field-->

					</fieldset>
					<div class="hr"></div>

					<fieldset>
						<div class="Signup-sectionHeader">
							<legend class="signup-sectionTitle">
								利用可能時間帯
							</legend>
						</div>
						<div class="form-field time-to-use-signup no-btm-border">
							<div class="input-container">
								<div class="space-setting-content">
									<div class="form-container">
											<div class="form-field nopd">
												<table class="time-slot-table">
													<thead>
														<tr>
															<th>曜日</th>
															<th colspan="3">時間帯</th>
														</tr>
													</thead>
													<tbody>
														<?php 
														for($i = 1; $i <= 7; $i++)
														{ 
															$date = strftime('%A', strtotime("Sunday + $i Days"));
															$day_name = date('l', strtotime("Sunday + $i Days"));
															?>
														<tr data-date="<?php echo ($day_name)?>" class="date-row">
															<td class="daystring">{{Config::get("lp.daystring.$date")}}
															</td>
															<td class="inplaceedit">
																<?php $col1=$date."StartTime";
																	$col2=$date."EndTime"; ?>
																<div class="display hour-column">@if($IsEdit=="True") {{$space->$col1}}-{{$space->$col2}} @else 9:00 AM - 5:00 PM @endif</div>
																<div class="edit">
																	<span class="edit-hour-block" style="display: none;"> </span> <span class="edit-closed-text" style="display: none;"> 終日利用不可 </span> <span class="edit-open-text" style="display: none;"> 24時間利用可能 </span>
																</div>
															</td>
															<td class="checkbutton-cell edit-closed">終日利用不可 <span class="checkmark"></span>
																<input type="checkbox" value="Yes" name="isClosed<?php echo $day_name?>" style="display:none"/>
															</td>
															<td class="checkbutton-cell edit-open">24時間利用可能 <span class="checkmark"></span>
																<input type="checkbox" value="Yes" name="isOpen24<?php echo $day_name?>" style="display:none"/>
															</td>
														</tr>
														<?php
														}
														?>


													</tbody>
												</table>
											</div>
											<!--/form-field-->
									</div>
									<!--/form-container-->
								</div>
								<!--/space-setting-content-->
							</div>
							<!--/input-container-->
						</div>
						<!--/form-field-->
					</fieldset>
					<div class="hr"></div>
					<fieldset>
						<div class="Signup-sectionHeader">
							<legend class="signup-sectionTitle">
								スペースシェアに含まれる設備
							</legend>
						</div>
						<div class="form-field quater-inputs space-fac">
							<div class="input-container input-quater">
								<label for="num-desk">デスク
								</label> <span class="field-number-input-withunit"><input type="number" value="{{$space->NumOfDesk==0 ? '':$space->NumOfDesk}}" name="NumOfDesk" min="1" max="50">台</span>
							</div>
							<div class="input-container input-quater">
								<label for="num-chair">イス
								</label> <span class="field-number-input-withunit"><input type="number" name="NumOfChair" value="{{$space->NumOfChair==0 ? '':$space->NumOfChair}}" min="1" max="50">脚</span>
							</div>
							<div class="input-container input-quater">
								<label for="num-board">ボード
								</label> <span class="field-number-input-withunit"><input type="number" name="NumOfBoard" value="{{$space->NumOfBoard==0 ? '':$space->NumOfBoard}}" min="1" max="50">台</span>
							</div>
							<div class="input-container input-quater">
								<label for="num-largedesk">複数人用デスク
								</label> <span class="field-number-input-withunit"><input type="number" name="NumOfTable" value="{{$space->NumOfTable==0 ? '':$space->NumOfTable}}" min="1" max="50">台</span>
							</div>
						</div>
						<!--/form-field-->
						<div class="form-field no-btm-border no-btm-pad space-other-fac">
							<div class="input-container">
								<label for="OtherFac">その他設備<span class="help">*スペースシェアに含まれる設備をご選択ください。</span>
								</label>
                                <div class="checkbox-array">
                                <span class="checkbox"><input type="checkbox" name="OtherFacilities[]" class="custom-checkbox" value="wi-fi" <?php if (strpos($space->OtherFacilities, 'wi-fi') !== false) { echo 'checked';}  ?> data-labelauty="Wifi|Wifi"></span>
								<span class="checkbox"><input type="checkbox" class="custom-checkbox" <?php if (strpos($space->OtherFacilities, 'プリンター') !== false) { echo 'checked';}  ?> name="OtherFacilities[]" value="プリンター" data-labelauty="プリンター|プリンター"></span> 
								<span class="checkbox"><input type="checkbox" class="custom-checkbox" <?php if (strpos($space->OtherFacilities, 'プロジェクター') !== false) { echo 'checked';}  ?> name="OtherFacilities[]" value="プロジェクター" data-labelauty="プロジェクター|プロジェクター"></span>
								<span class="checkbox"><input type="checkbox" class="custom-checkbox" <?php if (strpos($space->OtherFacilities, '自動販売機') !== false) { echo 'checked';}  ?> name="OtherFacilities[]" value="自動販売機" data-labelauty="自動販売機|自動販売機"></span>
								<span class="checkbox"><input type="checkbox" class="custom-checkbox" <?php if (strpos($space->OtherFacilities, '男女別トイレ') !== false) { echo 'checked';}  ?> name="OtherFacilities[]" value="男女別トイレ" data-labelauty="男女別トイレ|男女別トイレ"></span>
								<span class="checkbox"><input type="checkbox" class="custom-checkbox" <?php if (strpos($space->OtherFacilities, '喫煙所') !== false) { echo 'checked';}  ?> name="OtherFacilities[]" value="喫煙所" data-labelauty="喫煙所|喫煙所"></span>
                                </div><!--/checkbox-array-->
							</div>
						</div>
						<!--/form-field-->
						<div class="form-field no-btm-border no-btm-pad space-bld-fac">
							<div class="input-container">
								<label for="OtherBldFac">ビル設備<span class="help">*駐車場は利用可能な場合のみご選択ください。</span>
								</label>
                                <div class="checkbox-array">
                                 <span class="checkbox"> <input type="checkbox" class="custom-checkbox" name="OtherFacilities[]" value="駐車場" <?php if (strpos($space->OtherFacilities, '駐車場') !== false) { echo 'checked';}  ?> data-labelauty="駐車場|駐車場">
								</span> <span class="checkbox"> <input type="checkbox" class="custom-checkbox" name="OtherFacilities[]" value="エレベーター" <?php if (strpos($space->OtherFacilities, 'エレベーター') !== false) { echo 'checked';}  ?> data-labelauty="エレベーター|エレベーター">
								</span>
                                </div>
							</div>
						</div>
						<!--/form-field-->
					</fieldset>
					<div class="hr"></div>
				<? /*	<fieldset>
						<div class="Signup-sectionHeader">
							<legend class="signup-sectionTitle">
								希望利用者<span class="help">*マッチングの際に、必要となる条件となります。</span>
							</legend>
						</div>
						<div class="form-field two-inputs no-btm-border no-btm-pad" id="welcom-person">
							<div class="input-container input-half">
								<label for="welcome_business_kind"><span class="require-mark">*</span>どんな職種が好ましいですか？<span class="help">*ご希望の利用者の職種をご選択ください。</span>
								</label> <select required id="BusinessKind_welcome" name="BusinessKindWelcome" class="old_ui_selector chosen-select">
									<option value="" selected="">業種を選択してください</option>
									<option value="インターネット・ソフトウェア">インターネット・ソフトウェア</option>
									<option value="コンサルティング・ビジネスサービス">コンサルティング・ビジネスサービス</option>
									<option value="コンピュータ・テクノロジー">コンピュータ・テクノロジー</option>
									<option value="メディア/ニュース/出版">メディア/ニュース/出版</option>
									<option value="園芸・農業">園芸・農業</option>
									<option value="化学">化学</option>
									<option value="教育">教育</option>
									<option value="金融機関">金融機関</option>
									<option value="健康・医療・製薬">健康・医療・製薬</option>
									<option value="健康・美容">健康・美容</option>
									<option value="工学・建設">工学・建設</option>
									<option value="工業">工業</option>
									<option value="小売・消費者商品">小売・消費者商品</option>
									<option value="食品・飲料">食品・飲料</option>
									<option value="政治団体">政治団体</option>
									<option value="地域団体">地域団体</option>
									<option value="電気通信">電気通信</option>
									<option value="保険会社">保険会社</option>
									<option value="法律">法律</option>
									<option value="輸送・運輸">輸送・運輸</option>
									<option value="旅行・レジャー">旅行・レジャー</option>
									<option value="デザイン">デザイン</option>
									<option value="写真">写真</option>
									<option value="映像">映像</option>
									<option value="その他">その他</option>
									<option value="特に無し">特に無し</option>
								</select>
							</div>
							<div class="input-container input-half">
								<label for="welcome_business_kind"><span class="require-mark">*</span>スキル<span class="help">*最低1つはご選択ください。</span></label>
                                <select required data-placeholder="Choose business type" style="width: 350px;" class="chosen-select" name="Skills[]" id="skill" multiple>
									<option value=""></option>
									<optgroup label="制作用ツール、DTPソフト">
										<option value="Photoshop">Photoshop</option>
										<option value="Illustrator">Illustrator</option>
										<option value="Dreamweaver">Dreamweaver</option>
										<option value="Wordpress">Wordpress</option>
										<option value="Flash">Flash</option>
									</optgroup>
									<optgroup label="デザイン技術">
										<option value="Webデザイン">Webデザイン</option>
										<option value="グラフィックデザイン">グラフィックデザイン</option>
										<option value="3Dデザイン">3Dデザイン</option>
									</optgroup>
									<optgroup label="開発技術">
										<option value="IT・Web系技術">IT・Web系技術</option>
										<option value="アプリケーション開発技術">アプリケーション開発技術</option>
									</optgroup>
									<optgroup label="基本事務ソフト">
										<option value="Excel">Excel</option>
										<option value="Power Point">Power Point</option>
										<option value="Words">Words</option>
									</optgroup>
									<optgroup label="ビジネススキル">
										<option value="事務スキル">事務スキル</option>
										<option value="事務スキル">事務スキル</option>
										<option value="営業スキル">営業スキル</option>
										<option value="コンサルティング">コンサルティングスキル</option>
										<option value="経営スキル">経営スキル</option>
										<option value="企画力">企画力</option>
										<option value="交渉力">交渉力</option>
										<option value="マーケティング">マーケティング力</option>
										<option value="プレゼンテーション">プレゼンテーション力</option>
										<option value="プロジェクト・マネージメント">プロジェクト・マネージメント</option>
										<option value="情報収集力">情報収集力</option>

									</optgroup>
									<optgroup label="語学">
										<option value="英語">英語</option>
										<option value="中国語">中国語</option>
										<option value="韓国語">韓国語</option>
										<option value="フランス語">フランス語</option>
										<option value="フランス語">イタリア語</option>
										<option value="スペイン語">スペイン語</option>
									</optgroup>
								</select>
							</div>

						</div>
						<!--/form-field-->
					</fieldset>
					<div class="hr"></div> */ ?>
					<div class="btn-next-step">
						<button id="saveBasicInfo" type="submit" class="btn yellow-button input-basicinfo-button">保存する</button>
					</div>
					<div class="row next-step">
						<div class="span12 align-r">
							<a href="<?php echo url('/ShareUser/RegisterSuccess')?>">Skip this step</a>
						</div>
					</div>
					</form>
				
				</div>
			</div>
		</div>
		<!--footer-->
		@include('pages.common_instant_footer')
		<!--/footer-->
	</div>
	<!--/viewport-->

	<!-- Typehead -->
    
	<script src="http://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.10.4/typeahead.bundle.min.js"></script>
	<script src="{{ URL::asset('js/typeahead.tagging.js') }}"></script>
	<script src="{{ URL::asset('js/chosen/chosen.jquery.js') }}" type="text/javascript"></script>
	
	<script src="{{ URL::asset('js/assets/custom_edit_form.js') }}" type="text/javascript"></script>
	<script>
        // The source of the tags for autocompletion
        var tagsource = [
        ]
        // Turn the input into the tagging input
        jQuery('#input_skills').tagging(tagsource);
		</script>

	<script src="{{ URL::asset('js/jquery.validate.js?v=1') }}"></script>
		<script>
		$("#shareinfo").validate({
				  	errorPlacement: function(label, element) { 
						label.addClass('form-error');
						label.insertAfter(element);
			},
			rules: {
			    
			  }
			});
			
			
			 
		</script>
		
	
	<script>
jQuery(function($){
    
    // 全ての駅名を非表示にする
    jQuery(".budget-price").addClass('hide');
    // 路線のプルダウンが変更されたら
    jQuery("#choose_budget_per").change(function(){
        // 全ての駅名を非表示にする
        jQuery(".budget-price").addClass('hide');
        // 選択された路線に連動した駅名プルダウンを表示する
        jQuery('#' + $("#choose_budget_per option:selected").attr("class")).removeClass("hide");
    });
})

</script>
	
	<script type="text/javascript">
    jQuery(document).ready(function($) {

	
        $('#thumbviewimage, #profileImageUploader').click(function(e){
            e.preventDefault();
        });
        
        $('#popover_content_wrapper').on('shown.bs.modal', function (e) {
       	$('#popover_content_wrapper form[name="thumbnail"] #image-type').val($(e.relatedTarget).attr('image-type'));
        	$('#popover_content_wrapper form.uploadform .image-id').val($(e.relatedTarget).attr('image-type'));
        	if($(e.relatedTarget).attr('isbutton')=="yes")
			{
				for(i=1;i<5;i++)
				{
					if($(e.relatedTarget).attr('image-type')=="thumb_"+i)
					{
						j=i+1;
						$(e.relatedTarget).attr('image-type','thumb_'+j);
						break;
					}
				}
			}
			var imageData = $(e.relatedTarget).find('input').val();
        	if(imageData){
        		imageData = $.parseJSON(imageData);
        		showResponse(imageData);
            }
            
	   		// Init avatar image 
	     	<?php if (isset($_SESSION['space_image_image'])) :?>
	     		showResponse('<?php echo $_SESSION['space_image_image']?>');
	     		$('.popover #filename').val('<?php echo $_SESSION['space_image_image']?>');
	 		<?php endif?>

   		});

		$('.upload-button').click(function(){
		});
        $('#popover_content_wrapper').on('hidden.bs.modal', function (e) {
            // Remove the old uploaded image in popup
            $('.crop_preview_box_big').html('');
   		});

        function showResponseSubmit(response, statusText, xhr, $form){
            response = jQuery.parseJSON(response);
            if (typeof response == 'object' && response.file_thumb)
            {
	    		// Store data to hidden field
	    		var imageData = $('form[name="thumbnail"]').serialize();
	    		imageData = $.parseParams(imageData);
	    		//delete unset data
	    		delete imageData['_token'];
	    		delete imageData['backurl'];
	    		delete imageData['upload_thumbnail'];
	    		
	    		var image_type = $('form[name="thumbnail"] #image-type').val();
	    		$('#image_' + image_type).val(JSON.stringify(imageData));
	    		// Display image preview
	    		$('.edit-gallery-thumbnail-wrapper[image-type="'+image_type+'"]').css('background-image', 'url("'+ (response.file_thumb) +'?t='+ (new Date().getTime()) +'")')
	    	
	            // Close modal
	            jQuery('.modal').modal('toggle');
            }
            else {
                alert('Error Occured!');
            }
        }
   /* 	$('body').on('click', '.modal.in #save_thumb', function(e) { */
    	$('body').on('click', '#save_thumb', function(e) {
        	e.preventDefault();
    		var x1 = $('.modal.in #x1').val();
    		var y1 = $('.modal.in #y1').val();
    		var x2 = $('.modal.in #x2').val();
    		var y2 = $('.modal.in #y2').val();
    		var w = $('.modal.in #w').val();
    		var h = $('.modal.in #h').val();
			
			
    		if(x1=="" || y1=="" || x2=="" || y2=="" || w=="" || h==""){
    			alert("Please Make a Selection First");
    		}
			else{

    		// Ajax Upload and Crop
    		$('.modal.in form[name="thumbnail"]').ajaxForm({
            	url: $(this).attr('action'),
                success:    showResponseSubmit 
            }).submit();
			}
    	});

    	function updateCoords(c)
    	{
    		jQuery('#x1').val(Math.ceil(c.x));
    		jQuery('#x2').val(Math.ceil(c.x));
    		jQuery('#y1').val(Math.ceil(c.y));
    		jQuery('#y2').val(Math.ceil(c.y));
    		jQuery('#w').val(Math.ceil(c.w));
    		jQuery('#h').val(Math.ceil(c.h));
    	};
    	
    	function showResponse(response, statusText, xhr, $form){

    		if (typeof response == 'string')
    		{
    			var responseText = response;
    			var imageArea = [ 175, 100, 800, 600 ];
    		}
    		else
    		{
    			var responseText = response.filename;
    			var imageArea = [Math.ceil(response.x1), Math.ceil(response.y1), Math.ceil(response.w), Math.ceil(response.h)];
    			
    		}
    		
    		var wraperClass = '.modal.in ';
    		var image_src = "<?php echo UPLOAD_PATH_SPACE_TMP_URL; ?>" + responseText;
    		
    	    if(responseText.indexOf('.')>0){
    			$(wraperClass + ' #thumbviewimage').html('<img src="'+image_src+'"   style="position: relative;" alt="Thumbnail Preview" />');
    	    	$(wraperClass + ' #viewimage').html('<img class="preview" alt="" src="'+image_src+'?t='+ (new Date().getTime()) +'"   id="thumbnail" />');
    	    	$(wraperClass + ' #filename').val(responseText); 

		 		$(wraperClass + ' #thumbnail').Jcrop({
		 			  aspectRatio: 750/500,
		 		      boxWidth: 400,   //Maximum width you want for your bigger images
		 		      boxHeight: 300,  //Maximum Height for your bigger images
		 			  setSelect: imageArea,
		 			  onSelect: updateCoords,
		 			},function(){
		 			  var jcrop_api = this;
		 			  thumbnail = this.initComponent('Thumbnailer', { width: 200, height: 133 });
		 			});
    		}else{
    			$(wraperClass + ' #thumbviewimage').html(responseText);
    	    	$(wraperClass + ' #viewimage').html(responseText);
    		}
        }

    	$('body').on('click', '.crop_box button', function(e){
        	e.preventDefault();
    	});
    	
    	$('body').on('click', '.modal.in #btn-image-save', function(){
        	$('.modal.in #imagefile').val('');
    		$('.modal.in #imagefile').click();
    	});

        $('body').on('change', '.modal.in #imagefile', function() {
        	$(".modal.in .uploadform").append('<input type="hidden" name="upload_type" value="space" />')
        	
        	$(".modal.in #viewimage").html('');
            $(".modal.in #viewimage").html('<img src="'+ SITE_URL +'images/loading.gif" />');
            $(".modal.in .uploadform").ajaxForm({
            	url: SITE_URL + 'upload-image.php',
                success:    showResponse 
            }).submit();
        });

      	
    });
</script>
</body>
</html>
