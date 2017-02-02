@include('pages.header')
<!-- Base MasterSlider style sheet -->
<link rel="stylesheet" href="<?php echo SITE_URL?>js/swipe-slider/quick-start/masterslider/style/masterslider.css" />
<!-- MasterSlider default skin -->
<link rel="stylesheet" href="<?php echo SITE_URL?>js/swipe-slider/quick-start/masterslider/skins/default/style.css" />
<!-- MasterSlider Template Style -->
<link href='<?php echo SITE_URL?>js/swipe-slider/slider-templates/lightbox/style/ms-lightbox.css' rel='stylesheet' type='text/css'>
<script class="rs-file" src="<?php echo SITE_URL?>js/assets/royalslider/jquery.easing-1.3.js"></script>
<!-- MasterSlider main JS file -->
<script src="<?php echo SITE_URL?>js/swipe-slider/quick-start/masterslider/masterslider.min.js"></script>
<script src="<?php echo SITE_URL?>js/perfect-scrollbar/js/perfect-scrollbar.js"></script>
<script src="<?php echo SITE_URL?>js/swipe-slider/slider-templates/lightbox/js/jquery.prettyPhoto.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL?>assets/css/main.css">
<!--<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>-->
<script type="text/javascript" src="<?php echo SITE_URL?>assets/js/jquery-ui.min.js"></script>
<script src="<?php echo SITE_URL?>js/datepicker-ja.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL?>assets/css/tab.css">
<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL?>assets/css/folio.css">
<!-- <script type="text/javascript" src="<?php echo SITE_URL?>assets/js/CommonJs.js"></script>  -->
<script src="{{ URL::asset('js/responsive-tabs/easyResponsiveTabs.js') }}"></script>
<link href="{{ URL::asset('js/responsive-tabs/easy-responsive-tabs.css') }}" rel='stylesheet' />
<link href="{{ URL::asset('js/calendar/calendar.css') }}" rel='stylesheet' />
<link href="{{ URL::asset('js/calendar/datepicker/css/bootstrap-datepicker.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('js/calendar/datepicker/css/timepicker.css') }}" rel="stylesheet" />
<script src="{{ URL::asset('js/calendar/lib/moment.min.js') }}"></script>
<script src="{{ URL::asset('js/calendar/calendar.js') }}"></script>
<script src="{{ URL::asset('js/calendar/lang-all.js') }}"></script>
<script src="https://uxsolutions.github.io/bootstrap-datepicker/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="{{ URL::asset('js/calendar/datepicker/locales/bootstrap-datepicker.ja.min.js') }}"></script>
<script src="{{ URL::asset('js/calendar/datepicker/js/timepicker.min.js') }}"></script>
<script src="{{ URL::asset('js/calendar/datepicker/js/datepair.js') }}"></script>
<script src="{{ URL::asset('js/calendar/validator.js') }}"></script>
<script src="{{ URL::asset('js/calendar/loadingoverlay.js') }}"></script>
<!--<script src="{{ URL::asset('js/calendar/datepicker/js/bootstrap-datepicker.js') }}"></script>-->
<style>
.space-calendar-content {
	min-height: auto !important;
}

.event a {
	background-color: #42B373 !important;
	background-image: none !important;
	color: #ffffff !important;
}
</style>
<script src="{{ URL::asset('js/assets/holiday.js') }}"></script>
<script src="{{ URL::asset('js/calendar/calendar-booking.js') }}"></script>
<script src="{{ URL::asset('js/assets/booking.js') }}"></script>
<script type="text/javascript">
	var calendarURL = SITE_URL + 'getSpaceCalendar?spaceID='+"{{$space->HashID}}";
	var getHourURL = "{{URL::to('/user2/getajaxhour/')}}";
	var globalSpaceID = '{{$space->id}}';
	var globalSpaceHashID = '{{$space->HashID}}';
	var globalSpaceType = '<?php echo getSpaceSlotType($space);?>';
	var globalMinTerm = <?php echo (int)renderSpaceTypeTerm($space, false)?>;
	var globalStep = 1;
	var active_dates = <?php echo json_encode(array_keys($aAvailableDate))?>;
	var scheduleAvailableText = '<?php echo trans('common.Schedule Available')?>';
	var scheduleBookedText = '<?php echo trans('common.Schedule Booked')?>';
	var scheduleSelectedText = '<?php echo trans('common.Schedule Selected')?>';
	var scheduleSelectedText = '<?php echo trans('common.Schedule Selected')?>';
	var errorUser1BookingMessage = '<?php echo trans('common.You must login as Rent User to make a booking, Redirect to Rent user login page ?')?>';
	var errorUser1SendMessage = '<?php echo trans('common.You must login as Rent User to send message, Redirect to Rent user login page ?')?>';
	var consecutive_error = '<?php echo $space->FeeType == SPACE_FEE_TYPE_MONTHLY ? trans('common.consecutive_month_error') : trans('common.consecutive_week_error')?>';
	var messageMintemError = '<?php echo getSpaceMinTermAlert($space)?>';
	var aSelectedSlots = [];
	var aSelectedSlotIds = [];
	var aSelectedSlotDates = [];
</script>
<!--/head-->
<body class="profilepage common">
	<div class="viewport">
		<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header_nav_shareuser.php'); ?>
		@if(Auth::check()) @include('pages.header_nav_shareuser') @elseif(Auth::guard('user2')->check()) @include('pages.header_nav_rentuser') @else @include('pages.before_login_nav') @endif
		<div id="main" class="container">
			<?php renderSocialScript();?>
			<input type="hidden" id="datahdn">
			<section class="space-info workspace-details">
				<div class="section-inner">
					<div class="space-info-row workspace-details-row profile-components-row">
						<div class="grid">
							<div class="grid-sizer"></div>
							<div class="tp-left grid-item grid-item--width2">
								<div class="space-main-info">
									@if (count($errors) > 0)
									<div class="alert alert-danger">
										<ul>
											@foreach ($errors->all() as $error)
											<li>{{ $error }}</li>
											@endforeach
										</ul>
									</div>
									@endif
									<?php $message = Session::get('success'); ?>
									@if( isset($message) )
									<div class="alert alert-success">{!! $message !!}</div>
									@endif @if( Session::has('error'))
									<div class="alert alert-danger">{!! Session::get('error') !!}</div>
									@endif
									<!-- template -->
									<div class="ms-lightbox-template space-gallery">
										<!-- masterslider -->
										<div class="master-slider ms-skin-default" id="masterslider">
											<?
											$spaceImg= $space->spaceImage->all();
											foreach($spaceImg as $im)
											{
												?>
											<div class="ms-slide">
												<img src="{{$im->ThumbPath}}" data-src="{{$im->ThumbPath}}" alt="" />
												<?php if (count($spaceImg) > 1 ){?>
												<img class="ms-thumb" src="{{$im->SThumbPath}}" alt="thumb" />
												<?php }?>
												<!-- <a href="/js/swipe-slider/slider-templates/lightbox/img/1.jpg" class="ms-lightbox" rel="prettyPhoto[gallery1]" title="lorem ipsum dolor sit"> lightbox </a> -->
											</div>
											<?
											}

											?>
										</div>
										<!-- end of masterslider -->
									</div>
									<!-- end of template -->
								</div>
								<!--/space-main-info-->
								<div class="space-main-info">
									<div class="space-info-box feed-box">
										<div class="space-intro">
											<div class="row summary-component">
												<div class="col-sm-10 col-md-9">
													<div class="space-title">{{$space->Title}}</div>
													<!--/space-title-->
													
													<div class="space-addinfo">{{$space->Prefecture . $space->District . $space->Town}}</div>
													<div class="hide-md hide-lg">
													<!--show price-->
													<div class="price-block" id="space-price">
														<div class="price">
															<?php echo @$aBookingTimeInfoSelected['aPrice'][0]['price'];?>
														</div>
														<div class="price-min">
															<span class="price-min-text">
																<?php echo renderSpaceTypeTermText($space);?>
															</span>
															:
															<span class="price-min-value">
																<?php echo renderSpaceTypeTerm($space, true)?>
															</span>
														</div>
													</div>
													<!--/end price-->
												</div>
											
													<div class="rate-info">
														<!--start rating-->
														<?php showStarReview($reviews);?>
														<!--/end rating-->
													</div>
													<!--start favourite count-->
													<div class="fav-counter">
														<i class="fa fa-heart" aria-hidden="true"></i>
														&nbsp;
														<span>{{(int)$space->favorites->count()}}</span>
													</div>
													<!--/end favourite count-->
												</div>
												<div class="col-md-3 text-center hide-sm">
													<div class="host-profile-md-lg">
														<div class="media-photo-badge">
															<a href="{{getUser1ProfileUrl($space->shareUser)}}" class="media-photo media-round">
																<img alt="User Profile Image" height="75" width="75" data-pin-nopin="true" src="{{getUser1Photo($space->shareUser)}}" title="NaNa" data-reactid=".1sewlnpy1a8.0.0.1.0.0.0.0">
															</a>
														</div>
													</div>
													<div class="host-name">
														<p>
															<a href="{{getUser1ProfileUrl($space->shareUser)}}">{{getUserName($space->shareUser)}}</a>
														</p>
													</div>
												</div>
												<div class="hide-md hide-lg">
													<div class="host-profile-position-sm">
														<div class="media-photo-badge">
															<a href="{{getUser1ProfileUrl($space->shareUser)}}" class="media-photo media-round">
																<img alt="User Profile Image" height="48" width="48" data-pin-nopin="true" src="{{getUser1Photo($space->shareUser)}}" title="NaNa" data-reactid=".1sewlnpy1a8.0.0.1.0.0.0.0">
															</a>
														</div>
													</div>
												</div>
											</div>
											<!--/summary-component-->
											<hr>
											<div class="row text-muted text-center">
												<div class="col-sm-12 col3_info">
													<div class="hide-sm icon--large-margin">
														<!--meeting room-->
														<?php 
														echo getSpaceTypeIconHtml($space);
														?>
														<br />
														<span>{{$space->Type}}</span>
													</div>
													<div class="hide-sm icon--large-margin">
														<i class="icon-space-icon-guest icon-size-2"></i>
														<br />
														<span>〜{{$space->Capacity}}人</span>
													</div>
												</div>
											</div>
											<hr>
											<div class="space-disc">
												<? echo nl2br($space->Details) ?>
											</div>
											<!--/space-disc-->
										</div>
										<!--/space-intro-->
									</div>
									<!--/feed-box-->
								</div>
								<!--/space-main-info-->
							</div>
							<div class="tp-right grid-item">
								<div class="space-side-info">
									<div class="space-side-detail feed-box">
										<div class="top-pad-inner">
											<div class="clander-block clearfix">
												<div class="wlp-general-gray-box-inner hide-sm">
													<!--show price-->
													<div class="price-block" id="space-price">
														<div class="price">
															<?php echo @$aBookingTimeInfoSelected['aPrice'][0]['price'];?>
														</div>
														<div class="price-min">
															<span class="price-min-text">
																<?php echo renderSpaceTypeTermText($space);?>
															</span>
															:
															<span class="price-min-value">
																<?php echo renderSpaceTypeTerm($space, true)?>
															</span>
														</div>
													</div>
													<!--/end price-->
												</div>
												<div class="mobile-bookit-btn-container js-bookit-btn-container panel-btn-sm panel-btn-fixed-sm hide-md hide-lg">
													<button class="btn btn-block btn-large js-book-it-sm-trigger yellow-button">予約する</button>
												</div>
												<div >
													<div class="wlp-general-gray-box-inner" id="booking_form_wraper">
														<form action="/transaction/card-transaction" id="editReservationForm" method="post">
															<input type='hidden' id="spaceID" name='spaceID' value="{!!$space->id!!}" />
															<input type='hidden' id="spaceslots_id" name='spaceslots_id' value="<?php echo isset($aBookingTimeInfoSelected['bookedIDs']) ? implode(';', @$aBookingTimeInfoSelected['bookedIDs']) : ''?>" />
															<input type="hidden" name="booked_date" value="<?php echo isset($aBookingTimeInfoSelected['bookedDate']) ? implode(';', @$aBookingTimeInfoSelected['bookedDate']) : ''?>" id="booked_date" />
															<input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />
															<?php echo renderSpaceUsageDateText($space)?>
															
															<div class="wlp-start-date wlp-picker-wrapper">
																@if($space['FeeType'] != 1)
																<input readonly="readonly" type="text" class="customdate dailydate_popup" id="calendar_picker" value='<?php echo @$aBookingTimeInfoSelected['timeDefaultSelected']['StartDateConverted']?>'>
																@else
																<input readonly type="text" name="datepicker" class="customdate" readonly id="datepicker" value="<?php echo @$aBookingTimeInfoSelected['timeDefaultSelected']['StartDateConverted']?>">
																<input type='hidden' name='startTime' value='<?php echo @$aBookingTimeInfoSelected['timeDefaultSelected']['StartTime']?>' class='startTime' />
																<input type='hidden' name='endTime' value='<?php echo @$aBookingTimeInfoSelected['timeDefaultSelected']['EndTime']?>' class='endTime' />
																<div class='ajaxhourdata'>
																	<div id="maintime" class="wlp-start-time-and-duration-display wlp-picker-display">
																		時間帯:
																		<span id="tfromtime"><?php echo @$aBookingTimeInfoSelected['timeDefaultSelected']['StartTimeConverted']?></span>
																		-
																		<span id="toendtime"><?php echo @$aBookingTimeInfoSelected['timeDefaultSelected']['EndTimeConverted']?></span>
																	</div>
																	<div id="timewrap" class="wlp-start-time-and-duration-pickers wlp-picker" style="display: none">
																		<div class="wlp-picker-wrapper">
																			<div id="fromtimed" class="wlp-picker-display">開始時間: 
																				<span class="fromtimed-value"><?php echo @$aBookingTimeInfoSelected['timeDefaultSelected']['StartTimeConverted']?></span>
																			</div>
																			<div id="fromtime" class="wlp-picker wlp-time-picker" style="display:none;">
																				<?php 
																				if (isset($aBookingTimeInfoSelected['aAvailableTimeFromList'])) {
																				foreach (@$aBookingTimeInfoSelected['aAvailableTimeFromList'] as $availableTimeFromList) {
																					$time = date('H:00:00', strtotime($availableTimeFromList .':00:00'));
																					$timeConvert = getTimeFormat($availableTimeFromList .':00:00');
																				?>
																				
																					<div class="wlp-time-picker-item fromtimer selectable " data-value="<?php echo $time ?>"><?php echo $timeConvert?></div>
																				<?php }}?>
																			</div>
																		</div>
																		<div class="wlp-picker-wrapper">
																			<div id="endtimed" class="wlp-picker-display">終了時間: 
																				<span class="endtimed-value"><?php echo @$aBookingTimeInfoSelected['timeDefaultSelected']['EndTimeConverted']?></span>
																			</div>
																			<div id="endtime" class="wlp-picker wlp-time-picker" style="display: none">
																				<?php 
																				if (isset($aBookingTimeInfoSelected['aAvailableTimeToList'])) {
																				foreach (@$aBookingTimeInfoSelected['aAvailableTimeToList'] as $availableTimeFromList) {
																					$time = date('H:00:00', strtotime($availableTimeFromList .':00:00'));
																					$timeConvert = getTimeFormat($availableTimeFromList .':00:00');;
																				?>
																				
																					<div class="wlp-time-picker-item totimer selectable " data-value="<?php echo $time ?>"><?php echo $timeConvert?></div>
																				<?php }}?>
																			</div>
																		</div>
																	</div>
																</div>
																@endif
															</div>
															<div class="display-duration">
																<span class="display-duration-text">選択時間:</span>
																<span class="select-result display-duration-value">
																	<?php echo renderSpaceTypeTerm($space, false, @$aBookingTimeInfoSelected['duration'])?>
																</span>
															</div>
															<div class="display-subtotal">
																<span class="display-subtotal-text">小計:</span>
																<span class="display-subtotal-value"><?php echo @$aBookingTimeInfoSelected['totalPrice']?></span>
															</div>
															<button id="booking_button" class="inline-popup-link btn btn-large yellow-button" role="button" aria-disabled="false">
																<input type='submit' style='background: none' class='ui-button-text' value='予約する' id='' />
															</button>
													
													</form>
													</div>
													<div class="wlp-general-gray-box-inner">
														<a href="/RentUser/Dashboard/Message/{{$space->shareUser->HashCode}}" id="send_message_button">
															<button class="btn ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false">
																<span class="ui-button-text">
																	<i class="icon-offispo-icon-06 awesome-icon"></i>
																	メッセージを送る
																</span>
															</button>
														</a>
														<div class="space-action-btn clearfix">
															<div class="favourite-btn icon-button half-btn">
																<div class="btn-inner">
																	<? $uid=0;
																	if(Auth::guard('user2')->check())
																	{
																		$uid=Auth::guard('user2')->user()->id;
																	}
																	$isFavorited = isFavorited($uid,$space->HashID);

																	?>
																	<a data-spaceid="{{$space->HashID}}" data-favorited="お気に入り" data-favorite="お気に入り" data-tooltip="お気に入り取り消し" class="btn button-favorite <?php echo $isFavorited ? 'favorited' : ''?>" href="<?php echo SITE_URL . "RentUser/AddFavoriteSpace/". $space->HashID . '?action=' . ($isFavorited ? 'remove' : 'add'); ?>">
																		<i class="icon-icon-heart awesome-icon"></i>
																		<span class="favorite-text">
																			<?php echo $isFavorited ? 'お気に入り' : 'お気に入り'?>
																		</span>
																	</a>
																</div>
															</div>
															<div class="share-btn icon-button half-btn">
																<div class="btn-inner">
																	<a class="btn">
																		<i class="fa fa-share-alt" aria-hidden="true"></i>
																		シェア
																	</a>
																</div>
															</div>
														</div>
														<!--/space-action-btn-->
													</div>
												</div>
											</div>
											<!--/clander-block-->
										</div>
										<!--/top-pad-inner-->
										<div class="basic-detail-table">
											<table class="basic-detail-list style_basic">
												<tbody>
													<tr>
														<th>住所</th>
														<td>{{$space->Prefecture . $space->District . $space->Town . $space->Address1 . $space->Address2}}</td>
													</tr>
													<tr>
														<th>アクセス</th>
														<td>
															<?php echo renderNearestStations($space);?>
														</td>
													</tr>
													@if($space->LevelFloorValue)
													<tr>
														<th>階数</th>
														<td>{{$space->LevelFloor . $space->LevelFloorValue}}階</td>
													</tr>
													@endif
												</tbody>
											</table>
										</div>
										<!--/basic-detail-table-->
									</div>
									<!--/space-side-detail-->
								</div>
							</div>
							<!--/tp-right-->
							<div class="tp-left grid-item grid-item--width2" style="">
								<div class="workspace-details-main space-page-common-table">
									<div class="workspace-details-basic feed-box" id="basic-requirement">
										<h2 class="section-title">ワークスペース詳細</h2>
										<div class="workspace-details-table-box">
											<div class="workspace-details-table-box-row">
												<table class="workspace-details-list style_gywt">
													<tbody>
														<tr>
															<th>スペースタイプ</th>
															<td colspan="3">{{$space->Type}}</td>
														</tr>
														<?php if (!isCoreWorkingOrOpenDesk($space)) {?>
														<tr>
															<?php if ($space->Type != SPACE_FIELD_SHARE_DESK) {?>
															<th>面積</th>
															<td>{{$space->Area}}m2</td>
															<?php }else {?>
															<th>
																デスクサイズ
																<br class="sp-none">
																(幅x奥行き)
															</th>
															<td>{{$space->DeskSizeW}} x {{$space->DeskSizeH}} (mm)</td>
															<?php }?>
															<th>使用可能人数</th>
															<td>{{$space->Capacity}}名</td>
														</tr>
														<tr>
															<?php }?>
															<th>喫煙</th>
															<td>{{$space->Smoking}}</td>
															<th>スペースでの食事</th>
															<td>{{$space->EatIn}}</td>
														</tr>
														<?php 
														$space->original_point = explode(",", $space->original_point);
														?>
														@if( !empty($space->original_point[0]) )
														<tr>
															<th>特徴</th>
															<td colspan="3">
																<ul class="orgn-point">
																	@if( !empty($space->original_point[0]) ) @foreach($space->original_point as $key => $val)
																	<li>{{$val}}</li>
																	@endforeach @endif
																</ul>
															</td>
														</tr>
														@endif
														<tr>
															<th class="subt-th">ワークスペース設備</th>
															<td class="no_pad wk-fac" colspan="3">
																<table class="work-fac">
																	<tbody>
																		@if( !empty($space->NumOfDesk) || !empty($space->NumOfChair) )
																		<tr>
																			<th>デスク</th>
																			<td>
																				<strong>{{$space->NumOfDesk}}</strong>
																				<!--unit-->
																				台
																				<!--/unit-->
																			</td>
																			<th>イス</th>
																			<td>
																				<strong>{{$space->NumOfChair}}</strong>
																				<!--unit-->
																				台
																				<!--/unit-->
																			</td>
																		</tr>
																		@endif @if( !empty($space->NumOfBoard) || !empty($space->NumOfTable) )
																		<tr>
																			<th>ボード</th>
																			<td>
																				<strong>{{$space->NumOfBoard}}</strong>
																				<!--unit-->
																				台
																				<!--/unit-->
																			</td>
																			<th>複数人用デスク</th>
																			<td>
																				<strong>{{$space->NumOfTable}}</strong>
																				<!--unit-->
																				台
																				<!--/unit-->
																			</td>
																		</tr>
																		@endif
																		<tr class="other-facilities">
																			<th>その他設備</th>
																			<td colspan="4">
																				<ul class="other-fac-list">
																					@foreach (explode(',', $space->OtherFacilities) as $oth) @if($oth!='駐車場' && $oth!='エレベーター')
																					<li>{{ $oth }}</li>
																					@endif @endforeach
																					<!--<li>wifi設備</li>
														<li>ウォーターサーバー</li>
														<li>プロジェクター</li>
														<li>プリンター(¥)</li>
														<li>電話(¥)</li>
														<li>FAX(¥)</li>-->
																				</ul>
																			</td>
																		</tr>
																	</tbody>
																</table>
															</td>
														</tr>
													</tbody>
												</table>
											</div>
											<!--/table-box-->
										</div>
									</div>
									<!--/workspace-details-basic-->
								</div>
								<!--/workspace-details-main-->
							</div>
							<div class="tp-left grid-item grid-item--width2 ">
								<!--start facility for bld-->
								<div class="workspace-building-facility-main space-page-common-table">
									<div class="workspace-building-facility feed-box" id="basic-requirement">
										<h2 class="section-title">建物設備</h2>
										<div class="workspace-building-facility-table-box">
											<div class="workspace-building-facility-table-box-row">
												<table class="workspace-building-facility-list style_gywt">
													<tbody>
														<tr>
															<th>駐車場</th>
															<td>
																<?php if (strpos($space->OtherFacilities, '駐車場') !== false) { 
																	echo '有り';
																}else{ echo '無し';
}  ?>
															</td>
															<th>エレベーター</th>
															<td>
																<?php if (strpos($space->OtherFacilities, 'エレベーター') !== false) { 
																	echo '有り';
																}else{ echo '無し';
}  ?>
															</td>
														</tr>
													</tbody>
												</table>
											</div>
											<!--/table-box-->
										</div>
									</div>
									<!--/workspace-building-facility-basic-->
								</div>
								<!--/workspace-building-facility-main-->
								<!--start use time for space-->
								<div class="workspace-usetime-main space-page-common-table">
									<div class="workspace-usetime feed-box" id="basic-requirement">
										<h2 class="section-title">利用時間帯</h2>
										<div class="workspace-usetime-table-box">
											<div class="workspace-usetime-table-box-row box-row">
												<div class="col_half left">
													<table class="workspace-usetime-list style_gywt">
														<tbody>
															<tr>
																<th>月曜</th>
																<td>@if("$space->isClosedMonday" == "Yes") 終日利用不可 @elseif("$space->isOpen24Monday" == "Yes") 24時間利用可能 @else {{$space->MondayStartTime}}-{{$space->MondayEndTime}} @endif</td>
															</tr>
															<tr>
																<th>火曜</th>
																<td>@if("$space->isClosedTuesday" == "Yes") 終日利用不可 @elseif("$space->isOpen24Tuesday" == "Yes") 24時間利用可能 @else {{$space->TuesdayStartTime}}-{{$space->TuesdayEndTime}} @endif</td>
															</tr>
															<tr>
																<th>水曜</th>
																<td>@if("$space->isClosedWednesday" == "Yes") 終日利用不可 @elseif("$space->isOpen24Wednesday" == "Yes") 24時間利用可能 @else {{$space->WednesdayStartTime}}-{{$space->WednesdayEndTime}} @endif</td>
															</tr>
															<tr>
																<th>木曜</th>
																<td>@if("$space->isClosedThursday" == "Yes") 終日利用不可 @elseif("$space->isOpen24Thursday" == "Yes") 24時間利用可能 @else {{$space->ThursdayStartTime}}-{{$space->ThursdayEndTime}} @endif</td>
															</tr>
														</tbody>
													</table>
												</div>
												<!--/col-half-->
												<div class="col_half right">
													<table class="workspace-usetime-list style_gywt">
														<tbody>
															<tr>
																<th>金曜</th>
																<td>@if("$space->isClosedFriday" == "Yes") 終日利用不可 @elseif("$space->isOpen24Friday" == "Yes") 24時間利用可能 @else {{$space->FridayStartTime}}-{{$space->FridayEndTime}} @endif</td>
															</tr>
															<tr>
																<th>土曜</th>
																<td>@if("$space->isClosedSaturday" == "Yes") 終日利用不可 @elseif("$space->isOpen24Saturday" == "Yes") 24時間利用可能 @else {{$space->SaturdayStartTime}}-{{$space->SaturdayEndTime}} @endif</td>
															</tr>
															<tr>
																<th>日曜</th>
																<td>@if("$space->isClosedSunday" == "Yes") 終日利用不可 @elseif("$space->isOpen24Sunday" == "Yes") 24時間利用可能 @else {{$space->SundayStartTime}}-{{$space->SundayEndTime}} @endif</td>
															</tr>
															<tr class="sp-none">
																<th>&nbsp;</th>
																<td>&nbsp;</td>
															</tr>
														</tbody>
													</table>
												</div>
												<!--/col-half-->
											</div>
											<!--/table-box-->
										</div>
									</div>
									<!--/workspace-usetime-basic-->
								</div>
								<!--/workspace-usetime-main-->
							</div>
							<div class="tp-right grid-item">
								<div class="space-side-info">
									<div class="workspace-map-side">
										<div class="workspace-side-map feed-box">
											<h2 class="section-title">マップ</h2>
											<div class="map-box">
												<div id="map" style="width: 100%; height: 300px;"></div>
											</div>
											<!--/map-box-->
										</div>
										<!--/feedbox-->
									</div>
									<!--/workspace-map-side-->
								</div>
							</div>
							<!--/tp-right-->
							<div class="tp-left grid-item grid-item--width2">
								<div class="profile-components-main">
									<div class="profile-reviews feed-box" id="profile-reviews">
										<h2 class="section-title">
											最新レビュー
											<button style="<?php if (count($allReviews) < LIMIT_REVIEWS ) echo 'display: none;'?>" class="signup-modal-trigger profile-reviews-btn-top" ng-click="profile.openReviewsModal()" data-qtsb-label="view_more">
												<span ng-if="profile.user.reviews[profile.user.role].length > 0" class="ng-scope">View More Reviews</span>
											</button>
										</h2>
										<ul class="user-reviews ng-scope">
											<!--loop review-->
											<?php if (count($allReviews) == 0) {?>
											<li>まだレビューはありません。</li>
											<?php }?>
											<?php foreach ($allReviews as $review) {
												?>
											<li class="user-review ng-scope" itemprop="reviewRating" itemscope="">
												<img class="user-review-avatar" alt="" src="<?php echo getUser2Photo($review['user2'])?>">
												<a class="user-review-title ng-binding" href="<?php echo getSpaceUrl($space['HashID'])?>">
													<?php echo $space['Title']?>
												</a>
												<span class="Rating Rating--labeled" data-star_rating="<?php echo number_format($review['AverageRating'], 1)?>">
													<span class="Rating-total">
														<span class="Rating-progress" style="width:<?php echo showWidthRatingProgress($review['AverageRating'])?>%"></span>
													</span>
												</span>
												<?php if ($review['Comment']) {?>
												<p itemprop="description">
													“
													<span ng-bind="review.get().description" class="ng-binding">
														<?php echo $review['Comment']?>
													</span>
													”
												</p>
												<?php }?>
												<span class="user-review-details ng-binding">
													<a href="<?php echo getUser2ProfileUrl($review['user2'])?>">
														<span class="user-review-name ng-binding">{{getUserName($review['user2'])}}</span>
													</a>
													<span class="thedate">
														<?php echo renderHumanTime($review['created_at']) ?>
													</span>
												</span>
												<ul class="user-rating-info">
													<li class="place ng-scope">
														<span class="user-rating-info-item ng-binding">
															<i class="fa fa-map-marker" aria-hidden="true"></i>
															<?php echo $space['Prefecture'].$space['District'].$space['Address1']?>
														</span>
													</li>
													<!-- end place that rating user has office at -->
													<li class="space-type ng-scope">
														<span class="user-rating-info-item ng-binding">
															<i class="fa fa-building" aria-hidden="true"></i>
															<?php echo $space['Type']?>
														</span>
													</li>
													<!-- end space type -->
													<li class="space-price ng-scope">
														<span class="user-rating-info-item ng-binding">
															<i class="fa fa-jpy" aria-hidden="true"></i>
															<?php echo priceConvert($review['booking']['amount'])?>
														</span>
													</li>
													<!-- end space price type -->
												</ul>
											</li>
											<?php }?>
											<!--/loop review-->
										</ul>
										<button style="<?php if (count($allReviews) < LIMIT_REVIEWS ) echo 'display: none;'?>" class="profile-widget-expand signup-modal-trigger ng-scope" data-qtsb-label="view_more">View More Reviews</button>
									</div>
									<!--/#profile-reviews-->
								</div>
								<!--/profile-components-main-->
							</div>
							<!--/left-->
							<div class="tp-right grid-item">
								<div class="space-side-info">
									<?php if (count($space->tags)) {?>
									<div class="recommend-tip">
										<div class="recommend-tip-detail feed-box">
											<h4>スペースタグ</h4>
											<div class="rec-tag-list">
												<?php foreach ($space->tags as $tag) {?>
												<a href="{{url('RentUser/Dashboard/SearchSpaces')}}?tag={{$tag->Name}}" class="tag-label" title="<?php echo $tag->Name?>">
													<?php echo $tag->Name?>
												</a>
												<?php }?>
											</div>
										</div>
									</div>
									<!--/recommend tip-->
									<?php }?>
								</div>
							</div>
						</div>
						<!--/grid-->
					</div>
				</div>
				<!--/section-inner-->
			</section>
		</div>
		<!-- tab section -->
		<?php 
		$feeTypeArray = array(
			1 => '時間毎',
			2 => '日毎',
			3 => '週毎',
			4 => '月毎',
			5 => '日毎',
			6 => '週毎',
			7 => '月毎'
	);
	?>
		<div class="xwrapper xpp-buttons-wrapper-out-of-screen" id="xwrapper">
			<div class="xsection">
				<div class="xpp-spaces-tab-handlers">
					<?php foreach($groupedSpaces as $spaceType => $groupedSpace) { ?>
					<a data-tbs="tab-{{$spaceType}}" href="javascript:void(0)" class="tbs xpp-spaces-tab-handler"> {{$feeTypeArray[$spaceType]}} </a>
					<?php }?>
				</div>
				<?php foreach($groupedSpaces as $spaceType => $groupedSpace) { ?>
				<div id="tab-{{$spaceType}}" class="xsection-content" style="display: none;">
					<div class="xpp-spaces-wrapper xpp-spaces-mode-list">
						<div class="xpp-spaces-header">
							<div class="xpp-spaces-header-left">
								<h4>{{count($groupedSpace)}} {{$feeTypeArray[$spaceType]}}</h4>
							</div>
							<div class="xpp-spaces-header-right">
								<a href="javascript:void(0)" alt="List View" class="xpp-spaces-mode-switcher xpp-spaces-mode-switcher-list xpp-spaces-mode-switcher-selected"></a>
								<a href="javascript:void(0)" alt="Grid View" class="xpp-spaces-mode-switcher xpp-spaces-mode-switcher-tile"></a>
							</div>
							<div class="clear"></div>
						</div>
						<div class="space-list">
							<?php  foreach($groupedSpace as $indexSpace => $spaceGroup) { ?>
							<div class="xpp-space-wrapper h5 xpp-spaces-table ">
								<div class="xpp-space-image">
									<a href="{{getSpaceUrl($spaceGroup->HashID)}}">
										<img class="" src="{{getSpacePhoto($spaceGroup)}}" alt="Private Office in Midtown">
									</a>
								</div>
								<div class="xpp-space-content">
									<div class="xpp-space-content-row h3">
										<div class="xpp-space-name">{{$spaceGroup->Title}}</div>
										<div class="xpp-space-price">
											<?php echo getPrice($spaceGroup, true)?>
										</div>
										<div class="xpp-space-view-actions">
											<button class="ocean-inverted-button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false">
												<a href="{{getSpaceUrl($spaceGroup->HashID)}}">
													<span class="ui-button-text">Book Now</span>
												</a>
											</button>
										</div>
										<div class="clear"></div>
									</div>
									<div class="xpp-space-content-row h5">
										<div class="xpp-space-type-and-term">
											<div class="xpp-space-type">{{$spaceGroup->Type}}</div>
											<div class="xpp-space-term">{{renderSpaceTypeTerm($spaceGroup)}} min. term</div>
										</div>
										<div class="clear"></div>
									</div>
									<div class="xpp-space-content-row">
										<div class="xpp-space-description">
											<span class="xpp-space-description-content h5"> {{ str_limit($spaceGroup['Details'], 300, '...') }} </span>
											<a href="{{getSpaceUrl($spaceGroup->HashID)}}">View Details</a>
										</div>
										<div class="clear"></div>
									</div>
								</div>
								<div class="clear"></div>
							</div>
							<div class="list-item xpp-spaces-tiles">
								<div class="sp01" style="background: url({{getSpacePhoto($spaceGroup)}})"> 
									<a href="#" class="link_space">
										<span class="area">
											{{$spaceGroup->District}}
											<!--district name-->
										</span>
										<span class="space-label">
											<div class="clearfix">
												<span class="type" style="display: block;">{{$spaceGroup->Title}}</span>
												<div class="label-left" style="width: 30%;">
													<span class="capacity" style="padding-top: 3px;">~{{$spaceGroup->Capacity}}名</span>
												</div>
												<div class="label-right" style="width: 70%;">
													<span class="price">
														<?php echo getPrice($spaceGroup, true)?>
														<!--price-->
														<!--per day or week or month-->
													</span>
												</div>
											</div>
										</span>
									</a>
								</div>
							</div>
							<!--/list-item-->
							<?php }?>
							<div class="clear"></div>
						</div>
						<div class="xpp-spaces-footer">
							<button class="ocean-inverted-button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" data-bind="click: function(){monthlySpacesCollapsed(false);}, visible: monthlySpacesCollapsed" role="button" aria-disabled="false" style="display: none;">
								<span class="ui-button-text">See All Spaces</span>
							</button>
						</div>
					</div>
				</div>
				<?php }?>
			</div>
			<!-- x-section -->
		</div>
		<!-- xwrapper -->
		<div id="myModal" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">@if($space['FeeType']==2) 利用日を選択 @elseif($space['FeeType']==3) 利用週を選択 @elseif($space['FeeType']==4) 利用月を選択 @else @endif</h4>
					</div>
					<div class="modal-body">
						<div id="space_calendar_content_wraper">
							<?php echo '<div class="space-calendar-content" id="space_calendar" data-spaceID="'.$space->id . '"></div>'; ?>
						</div>
						<div class="space-calendar"></div>
						<br />
						<div class='monthly_booking' style='text-align: center'></div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
					</div>
				</div>
			</div>
		</div>
		<input type="hidden" id="hidCls" value="0">
		<!-- End of Tab Section -->
		<!--footer-->
		@include('pages.common_footer')
		<!--/footer-->
	</div>
	<!--/viewport-->
	<script type="text/javascript">
        jQuery(function ($) {
            var slider = new MasterSlider();

            slider.control('arrows');
            slider.control('lightbox');
            if ($('#masterslider .ms-thumb').length) {
            	slider.control('thumblist' , {autohide:false ,dir:'h',align:'bottom', width:130, height:85, margin:1, space:1 , hideUnder:400});
            }

            slider.setup('masterslider' , {
                width:1000,
                height:500,
                space:1,
                loop:true,
                view:'fade'
            });
            jQuery(document).ready(function($){
                $("a[rel^='prettyPhoto']").prettyPhoto();
			  $(".tbs").click( function(){
					$(this).siblings().removeClass("xpp-spaces-tab-handler-selected");
					$(this).addClass("xpp-spaces-tab-handler-selected");

					var id = $(this).attr("data-tbs");

					$(".xsection-content").hide();
					$("#" + id).fadeIn();

			  });

			  $(".tbs:eq(0)").click();
			  
			  $(".xpp-spaces-mode-switcher").click( function(){

					$(this).siblings().removeClass("xpp-spaces-mode-switcher-selected");
					$(this).addClass("xpp-spaces-mode-switcher-selected");

					var parent = $(this).parent().parent().parent().parent();
					parent.show();
				  if( $(this).hasClass("xpp-spaces-mode-switcher-list") ){
					$(".xpp-spaces-table").show();
					$(".xpp-spaces-tiles").hide();
				  }else if( $(this).hasClass("xpp-spaces-mode-switcher-tile") ){
					$(".xpp-spaces-table").hide();
					$(".xpp-spaces-tiles").show();
				  }


			  });

            });

        });

    </script>
	<!-- syntax highlighter -->
	<script> hljs.initHighlightingOnLoad();</script>
	<script type="text/javascript" src="<?php echo SITE_URL?>assets/js/fromJS.js"></script>
	<script type="text/javascript" src="<?php echo SITE_URL?>assets/js/pageCommon.js"></script>
<!--call google map API--> 
<script type='text/javascript' src='<?php echo SITE_URL?>js/dist/masonry.pkgd.min.js'></script>
<script>
jQuery(function() {
    setTimeout(
	function(){
		jQuery('.grid').masonry({
			percentPosition: true,
			columnWidth: '.grid-sizer',
			itemSelector: '.grid-item'
		});
	}, 3000);
});
</script> 
	<script type='text/javascript' src='http://maps.googleapis.com/maps/api/js?key=AIzaSyC0zkZJ3sHFHJgzUsAteOnObvf3ouAbc68&language=ja&region=JP'></script>
	<script type='text/javascript' src='<?php echo SITE_URL?>js/map.js'></script>
	<script type='text/javascript' src='<?php echo SITE_URL?>js/markerwithlabel.js'></script>
	<?php 
	$result1 = array('name' => $space->Title, 'address' => $space->Prefecture.$space->District.$space->Address1, 'description' =>  $space->Details);
	$results = array($result1);
	?>
	<script>
	var gmap;
	jQuery(document).ready(function(){
	    gmap = initMap();
		    /* You put your dynamic json data replace the one below */
		    json_data = <?php echo json_encode($results, JSON_UNESCAPED_UNICODE)?>;
		    gmap.startRender(json_data);
		});
    
		jQuery(document).ready(function ($) {
			 $('#pop a').magnificPopup({
				  type: 'ajax',
				  closeOnContentClick: false,
				  closeBtnInside: true
			 });
			 $('body').on("click","#continueBtn", function(){
				 console.log("aaa");
				 $('body').find("#pop-bone").hide();
				 $('body').find("#pop-btwo").show();
			 });
			 $('body').on("click","#backBtn", function(){
				 console.log("aaa");
				 $('body').find("#pop-bone").show();
				 $('body').find("#pop-btwo").hide();
			 });

			$(document).on('click', '.pop-cl', function (e) {
				e.preventDefault();
				$.magnificPopup.close();
			});

			$(document).on('click', '.dk_container', function () {
				$(this).toggleClass("dk_open");
			});
		});
    </script>
</body>
</html>
