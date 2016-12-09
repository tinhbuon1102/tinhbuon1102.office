<?php 
?>

@include('pages.header')
<link rel="stylesheet" href="{{ URL::asset('js/chosen/chosen.css') }}">

<!--/head-->
<body class="mypage shareuser">
	<div class="viewport fixed-page-wrapper">
		
		@include('pages.header_nav_shareuser')

		<div class="main-container">
			<div id="main" class="container fixed-container">
				<div id="left-box">
							@include('user1.dashboard.left_nav')
					<!--/right-content-->
				</div>
				<!--/leftbox-->
				<div class="right_side" id="samewidth">
                <div class="module-status-wrapper" id="samewidthby">
                <div class="module-status-cube">
                <div class="module module-status">
                <div class="module-status-left">
                <div class="btn-group">
                <button class="status-button publish-button active">Publish</button>
                <button class="status-button unpublish-button">Unpublish</button>
                </div>
                </div><!--status-left-->
                <div class="module-status-right">
                <div data-bind="visible: autosave() &amp;&amp; venueData.Status() != Enum.VenueStatus.Launched" style="display: none;">
                  <span class="blinker">Autosaving ...</span>
               </div>
               <div>
                  <span data-bind="text: lastModifiedDate">Saved on Aug 4, 5:13 PM</span>
               </div>
               <div>
                  <a target="_blank" href="#">Preview</a>
               </div>
               <div data-bind="visible: venueData.Status() == Enum.VenueStatus.New" style="display: none;">
                  <button class="ocean-button ui-button-disabled ui-state-disabled ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" data-bind="jqButton: { disabled: venueData.Status() != Enum.VenueStatus.New }, click: submitForReview" disabled="" role="button" aria-disabled="true"><span class="ui-button-text">Submit for Review</span></button>
               </div>
               <div data-bind="visible: venueData.Status() != Enum.VenueStatus.New" style="">
                  <button class="btn yellow-button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" data-bind="jqButton: { disabled: !isDirty() }, click: save" role="button" aria-disabled="false"><span class="ui-button-text">Save</span></button>
               </div>
                </div><!--status-right-->
                </div><!--/module-status-->
                </div>
                </div>
             
					<div id="feed">
						<section id="basic" class="feed-basic-info feed-box">
							<div class="dashboard-section-heading-container">
								<!--<h3 class="dashboard-section-heading">Spaces<!--登録済みスペース-->
								<!--</h3>-->
								<h3 class="dashboard-section-heading">
									Basic Info
									<!--基本情報-->
								</h3>
							</div>
							<div class="space-setting-content">
								<div class="form-container">
									<form id="basicinfo">
										<div class="form-field">
											<label for="SpaceTitle"> <span class="require-mark">*</span> Space title <!--タイトル--> <span class="help">*Name of the space you are listing.</span>
											</label>
											<div class="input-container">
												<input name="Title"  id="SpaceTitle" value="{{$space->Title}}" required="" ng-model="setting.space_title" type="text" class="ng-invalid" aria-invalid="true" placeholder="コンフェレンスルーム渋谷区神南">
											</div>
										</div>
										<div class="form-field">
<label for="require-place"> <span class="require-mark">*</span> Shared Office Location <!--地域--> <span class="help">*if address is diffrence form your registered company one,choose again.</span></label>
<!--<div class="copy-address-wrapper">
<label class="checkbox">
<input type="checkbox" data-toggle="checkbox" value="Yes" name="SameAddress" class="custom-checkbox" >
<span class="icons"><span class="icon-unchecked"></span><span class="icon-checked"></span></span>
Is this space same address as your company?
</label>
</div>-->

                                            <div class="form-field two-inputs nopd no-btm-border">
<div class="input-container input-half withrightlabel">
<label class="post-mark inline">〒</label><input name="PostalCode" id="zip" type="text" value="{{$space->PostalCode}}"　class="ng-pristine ng-untouched ng-invalid-required" aria-required="true">
</div>
</div><!--/form-field-->
<div class="form-field two-inputs nopd no-btm-border">
                           
							<div class="input-container input-half">
								<select  id="prefecture" name="Prefecture" data-label="都道府県を選択">
                                <option value="北海道">北海道</option><option value="青森県">青森県</option><option value="岩手県">岩手県</option><option value="宮城県">宮城県</option><option value="秋田県">秋田県</option><option value="山形県">山形県</option><option value="福島県">福島県</option><option value="茨城県">茨城県</option><option value="栃木県">栃木県</option><option value="群馬県">群馬県</option><option value="埼玉県">埼玉県</option><option value="千葉県">千葉県</option><option value="東京都">東京都</option><option value="神奈川県">神奈川県</option><option value="新潟県">新潟県</option><option value="富山県">富山県</option><option value="石川県">石川県</option><option value="福井県">福井県</option><option value="山梨県">山梨県</option><option value="長野県">長野県</option><option value="岐阜県">岐阜県</option><option value="静岡県">静岡県</option><option value="愛知県">愛知県</option><option value="三重県">三重県</option><option value="滋賀県">滋賀県</option><option value="京都府">京都府</option><option value="大阪府">大阪府</option><option value="兵庫県">兵庫県</option><option value="奈良県">奈良県</option><option value="和歌山県">和歌山県</option><option value="鳥取県">鳥取県</option><option value="島根県">島根県</option><option value="岡山県">岡山県</option><option value="広島県">広島県</option><option value="山口県">山口県</option><option value="徳島県">徳島県</option><option value="香川県">香川県</option><option value="愛媛県">愛媛県</option><option value="高知県">高知県</option><option value="福岡県">福岡県</option><option value="佐賀県">佐賀県</option><option value="長崎県">長崎県</option><option value="熊本県">熊本県</option><option value="大分県">大分県</option><option value="宮崎県">宮崎県</option><option value="鹿児島県">鹿児島県</option><option value="沖縄県">沖縄県</option>
                                </select>
								<!--select prefecture-->
							</div>
							<div class="input-container input-half">
								<input name="District"   id="district" type="text" value="{{$space->District}}" class="ng-pristine ng-untouched ng-invalid-required" aria-required="true" placeholder="市区町村">
								<!--select districts-->
							</div>
                            </div>
						<!--/form-field-->
                            <div class="form-field two-inputs nopd no-btm-border">
							<div class="input-container input-half">
								<input name="Address1" id="SpaceAddr" value="{{$space->Address1}}" required="" ng-model="signup.addr" type="text" class="ng-pristine ng-untouched ng-invalid-required" aria-required="true" placeholder="番地">
								<!--select towns-->
							</div>
                            <div class="input-container input-half">
                            <input name="Address2" id="SpaceAddr2" value="{{$space->Address2}}"  ng-model="signup.addr2" type="text" class="ng-pristine ng-untouched" placeholder="建物名・階・部屋番号">
                            </div>
						</div>
						<!--/form-field-->
											
										</div>
										<!--/form-field-->
										<div class="form-field col3_wrapper no-btm-border">
											<label for="SpaceTitle"> <span class="require-mark">*</span> Type of space and capacity <!--スペースタイプと利用可能人数-->
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
													<input type="number" name="Capacity"  min="1" max="100" id="ty3" value="{{$space->Capacity}}" > 人
												</div>
											</div>
										</div>
										<!--/form-field-->
										<div class="form-field two-inputs space-area-wraper type-group-sub" data-group="type-group-b">
											<div class="input-container input-half">
												<label for="space_area" >Space area<!--スペース面積--></label>
												<div class="input_withunit">
													<input type="number" name="Area" min="1" max="100" id="ty3" value="{{$space->Area}}" >m&sup2;
												</div>
											</div>

										</div>
										<!--/form-field-->
										<div class="form-field">
											<label for="SpaceDesc"> <span class="require-mark">*</span> Describe the space <!--スペース説明-->
											</label>
										    <textarea cols="20"  text="{{$space->Details}}" name="Details" id="WorkspaceData_ShortDescription" rows="5" class="space-desc-textarea ng-pristine ng-untouched ng-invalid ng-invalid-required" aria-invalid="true" aria-required="true"></textarea>
											<div class="text-length-counter">
												<span>0</span> <span>/4000</span>
											</div>
										</div>
										<!--/form-field-->
										<div class="form-field two-inputs room-group-sub" data-room-group="room-group-a">
											<div class="input-container input-half">
												<label for="last_name">Rentuser can use meeting room?<!--会議室利用-->
												</label> <span class="radio_field"><input type="radio" name="yes_meetingroom" value="Yes" /><label class="label_radio">Yes</label> </span><span class="radio_field"><input type="radio" name="no_meetingroom" value="No" /><label class="label_radio">No</label> </span>
											</div>
											<div class="input-container input-half"></div>
										</div>
										<!--/form-field-->
									</form>
								</div>
								<!--/form-container-->
							</div>
							<!--/space-setting-content-->
						</section>

					</div>
					<!--/feed-->
					<div id="feed">
						<section id="photos" class="feed-box">
							<div class="dashboard-section-heading-container">
								<h3 class="dashboard-section-heading">
									Photos
									<!--写真-->
								</h3>
							</div>
							<div class="space-setting-content">
								<div class="form-container">
									<form id="PhotoSpace">
										<div class="form-field two-inputs">
											<div class="input-container input-half">
												<label for="SpaceMainPhoto"> <span class="require-mark">*</span> Main Photo <!--メイン写真-->
												</label>
												<div class="edit-gallery-wrapper">
													<div class="edit-gallery-thumbnails edit-main-picture edit-gallery-thumbnails-placeholder">
														<div class="edit-gallery-thumbnail-wrapper" data-toggle="modal" data-target="#popover_content_wrapper" style=<?php //if($_SESSION['space_image']) echo 'background-image:url("'. ($_SESSION['space_image']) .'?t='. time() .'")'?>>
														</div>
													</div>
												</div>
												<div class="edit-gallery-buttons" data-toggle="modal" data-target="#popover_content_wrapper">
													<button class="upload-button btn ui-button-text-only yellow-button" role="button" aria-disabled="false">
														<span class="ui-button-text">Upload</span>
													</button>
													<button class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false" style="display: none;">
														<span class="ui-button-text">Edit selected</span>
													</button>
												</div>
											</div>
											<!--/input-container-->

											<label for="SpacePhotos"> Other Photo <!--メイン写真-->
											</label>
											<div class="input-container input-half">
												<div class="edit-gallery-wrapper">
													<div class="edit-gallery-thumbnails edit-gallery-thumbnails-placeholder">
														<div class="edit-gallery-thumbnail-wrapper" data-toggle="modal" data-target="#popover_content_wrapper"></div>
														<div class="edit-gallery-thumbnail-wrapper" data-toggle="modal" data-target="#popover_content_wrapper"></div>
														<div class="edit-gallery-thumbnail-wrapper" data-toggle="modal" data-target="#popover_content_wrapper"></div>
														<div class="edit-gallery-thumbnail-wrapper" data-toggle="modal" data-target="#popover_content_wrapper"></div>
														<div class="edit-gallery-thumbnail-wrapper" data-toggle="modal" data-target="#popover_content_wrapper"></div>
													</div>
												</div>
												<div class="edit-gallery-buttons" data-toggle="modal" data-target="#popover_content_wrapper">
													<button class="upload-button btn ui-button-text-only yellow-button" role="button" aria-disabled="false">
														<span class="ui-button-text">Upload</span>
													</button>
													<button class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false" style="display: none;">
														<span class="ui-button-text">Edit selected</span>
													</button>
												</div>
											</div>
											<!--/input-container-->
										</div>
										<!--/form-field-->
									</form>
								</div>
								<!--/form-container-->
							</div>
							<!--/space-setting-content-->
						</section>
					</div>
					<!--/feed-->
					<div id="feed">
						<section id="price-term" class="feed-box">
							<div class="dashboard-section-heading-container">
								<h3 class="dashboard-section-heading">
									Price and Terms
									<!--料金と期間-->
								</h3>
							</div>
							<div class="space-setting-content">
								<!--show this field if user select meeting space or seminar space-->
								<!--<p class="exp">Set the hourly price and minimum term for this space. You may also add incentive pricing below to encourage longer-term bookings.</p>-->
								<!--/show this field if user select meeting space or seminar space-->
								<!--hide this field if user select meeting space or seminar space-->
								<p class="exp">Set daily/weekly/monthly price and minimum term for this space. You may also add incentive pricing below to encourage longer-term bookings.</p>
								<!--/hide this field if user select meeting space or seminar space-->
								<div class="form-container">
									<form id="SpacePrice">
										<div class="form-field two-inputs fee-group-sub" data-fee-group="fee-group-a">
											<div class="input-container input-half">
												<div class="field_col withleft-label label_3_7">
													<div class="input_withunit space_price_term" id="choose_fee_per">
														<label class="label_left label_30">Hourly Price<!--1時間あたり-->
														</label> <input name="HourFee" value="{{$space->HourFee}}" id="FeePerHour" required="" ng-model="signup.fee_price_per_hour" type="text" class="ng-invalid" aria-invalid="true" placeholder="">円
													</div>
												</div>
												<!--/field_col-->
											</div>
											<!--/input-half-->
											<div class="input-container input-half">
												<div class="field_col withleft-label label_3_7">
                                                <label for="MinTermHourly" class="label_left">
													Minimum Term
													<!--最低期間-->
												</label>
													<select data-bind="value: MinimumBookingLength" data-val="true" data-val-number="The field MinimumBookingLength must be a number." data-val-required="The MinimumBookingLength field is required." id="HourMinTerm" name="HourMinTerm"><option selected="selected" value="1時間">1 hour</option>
														<option value="2">2時間</option>
														<option value="3">3時間</option>
														<option value="4">4時間</option>
													</select>
												</div>
												<!--/field_col-->
											</div>
											<!--/input-half-->
										</div>
										<!--/form-field-->

										<!--Daily-->
										<div class="form-field two-inputs fee-group-sub" data-fee-group="fee-group-b">
											<div class="input-container input-half">
												<div class="field_col withleft-label label_3_7">
													<div class="input_withunit space_price_term" id="choose_fee_per_day">
														<label class="label_left">Daily Price</label><input name="DayFee" id="FeePerDay" value="{{$space->DayFee}}" required="" ng-model="signup.fee_price_per_day" type="text" class="ng-invalid" aria-invalid="true" placeholder="">円
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
												<div class="field_col withleft-label label_3_7">
													<div class="input_withunit space_price_term" id="choose_fee_per_week">
														<label class="label_left">Weekly Price</label><input name="WeekFee" id="FeePerWeek" value="{{$space->WeekFee}}" required="" ng-model="signup.fee_price_per_week" type="text" class="ng-invalid" aria-invalid="true" placeholder="">円
													</div>
												</div>
												<!--/field_col-->
											</div>
											<!--/input-half-->
											<div class="input-container input-half">
												<div class="field_col withleft-label label_3_7">
                                                <label for="MinTermHourly" class="label_left">
													Minimum Term
													<!--最低期間-->
												</label>
													<select data-bind="value: MinimumBookingLength" data-val="true" data-val-number="The field MinimumBookingLength must be a number." data-val-required="The MinimumBookingLength field is required." id="WeekMinTerm" name="WeekMinTerm"><option selected="selected" value="1週間">1 week</option>
														<option value="2">2週間</option>
													</select>
												</div>
												<!--/field_col-->
											</div>
											<!--/input-half-->
										</div>
										<!--/form-field-->

										<!--Monthly-->
										<div class="form-field two-inputs no-btm-border fee-group-sub" data-fee-group="fee-group-d">
											<div class="input-container input-half">
												<div class="field_col withleft-label label_3_7">
													<div class="input_withunit space_price_term" id="choose_fee_per_month">
														<label class="label_left">Monthly Price</label><input name="MonthFee" id="FeePerMonth" value="{{$space->MonthFee}}" required="" ng-model="signup.fee_price_per_month" type="text" class="ng-invalid" aria-invalid="true" placeholder="">円
													</div>
												</div>
												<!--/field_col-->
											</div>
											<!--/input-half-->
											<div class="input-container input-half">
												<div class="field_col withleft-label label_3_7">
                                                <label for="MinTermHourly" class="label_left">
													Minimum Term
													<!--最低期間-->
												</label>
													<select data-bind="value: MinimumBookingLength" data-val="true" data-val-number="The field MinimumBookingLength must be a number." data-val-required="The MinimumBookingLength field is required." id="MonthMinTerm" name="MonthMinTerm"><option selected="selected" value="1ヶ月">1 months</option>
														<option value="3">3ヶ月</option>
														<option value="6">6ヶ月</option>
														<option value="12">12ヶ月</option>
													</select>
												</div>
												<!--/field_col-->
											</div>
											<!--/input-half-->
										</div>
										<!--/form-field-->
									</form>
								</div>
								<!--/form-container-->
							</div>
							<!--/space-setting-content-->
							<div class="should-know-caption">Other things you should know:</div>
							<ul class="list-know">
								<li>1-month deposit collected upon booking this space.</li>
								<li>Cancellation Policy: <a href="/Terms/Monthly-Space-License-Agreement" target="_blank">Guest (30 Days)</a> , <a href="/Terms/Monthly-Space-License-Agreement" target="_blank">Host (60 Days)</a>
								</li>
								<li>Fees - Offispo will collect payments and send directly to you. We charge a flat 10% fee on bookings.</li>
							</ul>
						</section>
					</div>
					<!--/feed-->

					<div id="feed">
						<section id="time-use" class="feed-box">
							<div class="dashboard-section-heading-container">
								<h3 class="dashboard-section-heading">
									Time to use
									<!--利用可能時間帯-->
								</h3>
							</div>
							<div class="space-setting-content">
								<div class="form-container">
									<form id="TimeSlot">
										<div class="form-field">
											<table class="time-slot-table">
												<thead>
													<tr>
														<th>Day</th>
														<th colspan="3">Hours</th>
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
																<div class="display hour-column">{{$space->$col1}}-{{$space->$col2}}</div>
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
									</form>
								</div>
								<!--/form-container-->
							</div>
							<!--/space-setting-content-->
						</section>
					</div>
					<!--/feed-->

					<div id="feed">
						<section id="fac" class="feed-box">
							<div class="dashboard-section-heading-container">
								<h3 class="dashboard-section-heading">
									Facilities
									<!--設備-->
								</h3>
							</div>
							<div class="space-setting-content">
								<div class="form-container">
									<form id="FacilitiesSpace">
										<div class="form-field quater-inputs">
											<label for="SpaceFacilities" class="mgn-btm10"> Facilities available with space <!--スペースに含まれる設備-->
											</label>
											<div class="input-container input-quater">
												<label for="num-desk" class="font-normal"> Desk <!--デスク-->
												</label> <span class="field-number-input-withunit"> <input type="number" name="NumOfDesk" value="{{$space->NumOfDesk}}" min="1" max="50"> 台
												</span>
											</div>
											<div class="input-container input-quater">
												<label for="num-chair" class="font-normal"> Chair <!--イス-->
												</label> <span class="field-number-input-withunit"> <input type="number" name="NumOfChair" value="{{$space->NumOfChair}}" min="1" max="50"> 脚
												</span>
											</div>
											<div class="input-container input-quater">
												<label for="num-board" class="font-normal"> Board <!--ボード-->
												</label> <span class="field-number-input-withunit"> <input type="number" name="NumOfBoard" value="{{$space->NumOfBoard}}" min="1" max="50"> 台
												</span>
											</div>
											<div class="input-container input-quater">
												<label for="num-largedesk" class="font-normal"> Table for some people <!--複数人用デスク&amp;イス-->
												</label> <span class="field-number-input-withunit"> <input type="number" name="NumOfTable" value="{{$space->NumOfTable}}" min="1" max="50"> 台
												</span>
											</div>
										</div>
										<!--/form-field-->
										<div class="form-field no-btm-border">
											<div class="input-container">
												<label for="OtherFac"> Other facilities <!--その他設備-->
												</label>
                                                <span class="field-checkbox">
                                                <label class="checkbox">
<input type="checkbox" data-toggle="checkbox" name="OtherFacilities[]" value="wi-fi" class="custom-checkbox" <?php if (strpos($space->OtherFacilities, 'wi-fi') !== false) { echo 'checked';}  ?> >
<span class="icons"><span class="icon-unchecked"></span><span class="icon-checked"></span></span>
wi-fi
</label></span>

<span class="field-checkbox">
<label class="checkbox">
<input type="checkbox" data-toggle="checkbox" name="OtherFacilities[]" value="プリンター" class="custom-checkbox" <?php if (strpos($space->OtherFacilities, 'プリンター') !== false) { echo 'checked';}  ?> >
<span class="icons"><span class="icon-unchecked"></span><span class="icon-checked"></span></span>
プリンター
</label></span>

<span class="field-checkbox">
<label class="checkbox">
<input type="checkbox" data-toggle="checkbox" name="OtherFacilities[]" value="プロジェクター" class="custom-checkbox" <?php if (strpos($space->OtherFacilities, 'プロジェクター') !== false) { echo 'checked';}  ?> >
<span class="icons"><span class="icon-unchecked"></span><span class="icon-checked"></span></span>
プロジェクター
</label></span>

<span class="field-checkbox">
<label class="checkbox">
<input type="checkbox" data-toggle="checkbox" name="OtherFacilities[]" value="自動販売機" class="custom-checkbox" <?php if (strpos($space->OtherFacilities, '自動販売機') !== false) { echo 'checked';}  ?> >
<span class="icons"><span class="icon-unchecked"></span><span class="icon-checked"></span></span>
自動販売機
</label></span>

<span class="field-checkbox">
<label class="checkbox">
<input type="checkbox" data-toggle="checkbox" name="OtherFacilities[]" value="男女別トイレ" class="custom-checkbox" <?php if (strpos($space->OtherFacilities, '男女別トイレ') !== false) { echo 'checked';}  ?> >
<span class="icons"><span class="icon-unchecked"></span><span class="icon-checked"></span></span>
男女別トイレ
</label></span>

<span class="field-checkbox">
<label class="checkbox">
<input type="checkbox" data-toggle="checkbox" name="OtherFacilities[]" value="喫煙所" class="custom-checkbox" <?php if (strpos($space->OtherFacilities, '喫煙所') !== false) { echo 'checked';}  ?> >
<span class="icons"><span class="icon-unchecked"></span><span class="icon-checked"></span></span>
喫煙所
</label></span>
                                                
                                                
                                               
											</div>
										</div>
										<!--/form-field-->
										<div class="form-field no-btm-border no-btm-pad">
											<div class="input-container">
												<label for="OtherFac"> Building facilities <!--ビル設備-->
												</label>
                                                
                                                <span class="field-checkbox">
<label class="checkbox">
<input type="checkbox" data-toggle="checkbox" name="OtherFacilities[]" value="駐車場" class="custom-checkbox" <?php if (strpos($space->OtherFacilities, '駐車場') !== false) { echo 'checked';}  ?>>
<span class="icons"><span class="icon-unchecked"></span><span class="icon-checked"></span></span>
駐車場
</label></span>

 <span class="field-checkbox">
<label class="checkbox">
<input type="checkbox" data-toggle="checkbox" name="OtherFacilities[]" value="エレベーター" class="custom-checkbox" <?php if (strpos($space->OtherFacilities, 'エレベーター') !== false) { echo 'checked';}  ?>>
<span class="icons"><span class="icon-unchecked"></span><span class="icon-checked"></span></span>
エレベーター
</label></span>
                                                
                                                
											</div>
										</div>
										<!--/form-field-->
									</form>
								</div>
								<!--/form-container-->
							</div>
							<!--/space-setting-content-->
						</section>
					</div>
					<!--/feed-->
					<div id="feed">
						<section id="term-use-space" class="feed-box">
							<div class="dashboard-section-heading-container">
								<h3 class="dashboard-section-heading">
									Terms of use
									<!--利用規約-->
								</h3>
							</div>
							<div class="space-setting-content">
								<p class="exp">Here's your Terms of use based on the details you provided.</p>
								<div class="view_terms_use">
									<a href="#" target="_blank">View Terms of use</a>
								</div>
								<form id="TermsUse">
									<div class="form-container">
										<div class="form-field">
											<div class="input-container">
												<label for="AddTerm"> Are there any special House Rules or conditions that you'd like to add to the Terms of use? <!--追加利用規約-->
												</label> 
                                                <div class="array-radio">
                                                <label class="radio">
                                                <input type="radio" id="optionsRadios2" name="select_addterm" value="いいえ" data-toggle="radio" checked="" class="custom-radio">
                                                <span class="icons"><span class="icon-unchecked"></span><span class="icon-checked"></span></span>No
                                                </label>
                                                
                                                <label class="radio">
                                                <input type="radio" id="optionsRadios2" name="select_addterm" value="はい" data-toggle="radio" class="custom-radio">
                                                <span class="icons"><span class="icon-unchecked"></span><span class="icon-checked"></span></span>Yes
                                                </label>
                                                </div>
                                                
                                                
                                                
                                                <div class="additional-term">
                                                <textarea rows="4" cols="50"></textarea>
                                                </div>
											</div>
											<!--show editor here if Yes is checked-->
											<!--/show editor here if Yes is checked-->
										</div>
										<!--/form-field-->
									</div>
									<!--/form-container-->
								</form>
							</div>
							<!--/space-setting-content-->
						</section>
					</div>
					<!--/feed-->


				</div>
				<!--/right_side-->
			</div>
		</div>
		<!--/main-container-->
		<!--footer-->
		
		<!--/footer-->
	</div>
	<!--/viewport-->
	<script src="<?php echo SITE_URL?>js/chosen/chosen.jquery.js" type="text/javascript"></script>
	<script src="<?php echo SITE_URL?>js/address_select.js" type="text/javascript"></script>
	<script src="<?php echo SITE_URL?>js/assets/custom_edit_form.js" type="text/javascript"></script>
	<script>
	jQuery(function($){
		$(".input-container.iconbutton").click(function(){
			$(this).toggleClass("checked");
		});
	});

	</script>

	<script type="text/javascript">
    jQuery(document).ready(function($) {

        $('#thumbviewimage, #profileImageUploader').click(function(e){
            e.preventDefault();
        });
        
        $('#profileImageUploader').on('shown.bs.popover', function () {
	   		 $('.popover-title').append('<a type="button" id="popover-close" class="close">×</a>');
	   		// Init avatar image 
	     	<?php if (isset($_SESSION['space_image_image'])) :?>
	     		showResponse('<?php echo $_SESSION['space_image_image']?>');
	     		$('.popover #filename').val('<?php echo $_SESSION['space_image_image']?>');
	 		<?php endif?>

   		})
   		
    	$('body').on('click', '.modal.in #save_thumb', function() {
    		var x1 = $('.modal.in #x1').val();
    		var y1 = $('.modal.in #y1').val();
    		var x2 = $('.modal.in #x2').val();
    		var y2 = $('.modal.in #y2').val();
    		var w = $('.modal.in #w').val();
    		var h = $('.modal.in #h').val();
    		if(x1=="" || y1=="" || x2=="" || y2=="" || w=="" || h==""){
    			alert("Please Make a Selection First");
    			return false;
    		}else{
    			return true;
    		}
    	});

    	function updateCoords(c)
    	{
    		jQuery('#x1').val(c.x);
    		jQuery('#x2').val(c.x);
    		jQuery('#y1').val(c.y);
    		jQuery('#y2').val(c.y);
    		jQuery('#w').val(c.w);
    		jQuery('#h').val(c.h);
    	};
    	
    	function showResponse(responseText, statusText, xhr, $form){

    		image_src = responseText;
    		wraperClass = '';
    		if (xhr) {
        		var image_src = "<?php echo $upload_path_tmp=''; ?>" + responseText;
        		var wraperClass = '.modal.in ';
        	}
    	    if(responseText.indexOf('.')>0){
    			$(wraperClass + ' #thumbviewimage').html('<img src="'+image_src+'"   style="position: relative;" alt="Thumbnail Preview" />');
    	    	$(wraperClass + ' #viewimage').html('<img class="preview" alt="" src="'+image_src+'"   id="thumbnail" />');
    	    	$(wraperClass + ' #filename').val(responseText); 

		 		$(wraperClass + ' #thumbnail').Jcrop({
		 			  aspectRatio: 750/500,
		 		      boxWidth: 400,   //Maximum width you want for your bigger images
		 		      boxHeight: 300,  //Maximum Height for your bigger images
		 			  setSelect: [ 175, 100, 400, 300 ],
		 			  onSelect: updateCoords,
		 			},function(){
		 			  var jcrop_api = this;
		 			  thumbnail = this.initComponent('Thumbnailer', { width: 130, height: 130 });
		 			});

    			var img = new Image();
    			img.onload = function() {
    				var img = document.getElementById("thumbnail");
    				selection = {x1: 48, y1: 0, x2: 240, y2: 192, width: 192, height: 192};
    				<?php if (isset($_SESSION['imagearea'])) {?>
    					if (!xhr)
    						selection = image_selection;
        	 		<?php }?>
        			//preview(img, selection, true);
        		}
    			img.src = image_src;

    			
    			
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
            $(".modal.in #viewimage").html('<img src="images/loading.gif" />');
            $(".modal.in .uploadform").ajaxForm({
            	url: 'upload-image.php',
                success:    showResponse 
            }).submit();
        });

      	
    });
</script>
<script>
jQuery('#samewidthby').css('width', '');
w = jQuery('#samewidth').width();
jQuery('#samewidthby').width(w);
</script>
<script type="text/javascript" src="//code.jquery.com/jquery-1.8.3.js"></script>
<script>
$(document).ready(function() {
	
$('#left-box') .css({'height': (($(window).height()) - 100)+'px'});
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
});
$(window).scroll(function() {    
    var scroll = $(window).scrollTop();
     
     //>=, not <=
    if (scroll >= 1) {
        //clearHeader, not clearheader - caps H
        $("#samewidthby").addClass("scroll");
		 $("#left-box").addClass("scroll");
    } else {
		$("#samewidthby").removeClass("scroll");
        $("#left-box").removeClass("scroll");
    }
}); //missing );

</script>
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

</body>
</html>
