<?php 
$feeType = request()->get('fee_type') ? request()->get('fee_type') : 1;
$tag = request()->get('tag') ? request()->get('tag') : '';
?>
@include('pages.header')
<link rel="stylesheet" href="{!! SITE_URL !!}js/chosen/chosen.min.css">
<link rel="stylesheet" href="{!! SITE_URL !!}css/multiple-select.css">
<!-- Typehead-->
<link rel="stylesheet" type='text/css' href="{!! SITE_URL !!}css/select2.min.css">

<link href="{{ URL::asset('js/calendar/datepicker/css/bootstrap-datepicker.css') }}" rel="stylesheet" />
<script src="{{ URL::asset('js/calendar/lib/moment.min.js') }}"></script>
<script src="{{ URL::asset('js/calendar/datepicker/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('js/calendar/datepicker/locales/bootstrap-datepicker.ja.min.js') }}"></script>

<!--/head-->
<style>
.datepicker td, .datepicker th{ padding: inherit!important;}
.reset_calendar:hover{color:inherit;}
</style>
<body class="mypage searchpage">
    <div class="viewport">
		@if(Auth::check())
			@include('pages.header_nav_shareuser')
		@elseif(Auth::guard('user2')->check())
			@include('pages.header_nav_rentuser')
		@else
			@include('pages.before_login_nav')
			<!--<div class="second-nav"></div>-->
		@endif
        <div class="main-container" style="background: rgb(248,248,248);">
            <div id="fullwidth" class="container main-content">
                <div class="find-list">
                    <div class="findlist-inner-wrapper">
                        <div class="searchbar-row">
                            <div class="searchbar">
                                <div class="search-bar-common-wrapper">
                                    <form class="search-form" id="searchWorkspacesForm" method="post">
                                        <div id="searchBarWrapper" class="search-bar-horizontal">
											
												<div id="mbshowfd">
                                                <div class="panel-header modal-header needsclick">
													<div id="mbshowcl" class="modal-close">×</div>
                                                    <?=trans("common.Search")?>
												</div>
                                                </div>
                                                <div id="mbshow" class="input-container input-col3 last">
                                                    <button type="button" class="search-btn-location"><i class="fa fa-search" aria-hidden="true"></i>
                                                    <span class="search-placeholder--sm">
                                                    	@foreach ($prefectures as $prefecture)
	                                                    	@if ($prefecture->selected) {{ $prefecture->Prefecture }} @endif 
                                                    	@endforeach
                                                    </span></button>
                                                </div>
                                            <div id="mbshowsec" class="filter-input-wrapper address">
                                                <div class="input-container input-col3">
                                                    <select name="filter_prefecture" id="filter_prefecture" data-label="都道府県を選択">
                                                    	<option value="">都道府県を選択</option>
                                                    	@foreach ($prefectures as $prefecture)
	                                                    	<option @if ($prefecture->selected) selected="selected" @endif value="{{ $prefecture->Prefecture }}">{{ $prefecture->Prefecture }}</option>
                                                    	@endforeach
                                                    </select><!--select prefecture-->
                                                </div>
                                                <div class="input-container input-col3 last">
                                                	<select name="filter_district" id="filter_district" data-label="市区町村を選択" data-placeholder="市区町村を選択(複数選択可)" multiple>
                                                    	@foreach ($districts as $district)
	                                                    	<option @if ( request()->has('district') && in_array($district->District, request()->get('district')) ) selected="selected" @endif value="{{ $district->District }}">{{ $district->District }}</option>
                                                    	@endforeach
                                                    </select>
                                                </div>
                                                <div class="input-container input-col3 last">
                                                    <button type="button" id="apply_districts" class="yellow-button-small"> 検索</button>
                                                </div>
                                            </div>
											
                                            <div class="right-area">
                                            <div class="filter-input-wrapper reservation-method">
                                            	<!--<select id="cd-dropdown"  class="cd-select">
                                            		<option value="hourly" selected>Hourly</option>
                                            		<option value="daily">Daily</option>
                                            		<option value="weekly">Weekly</option>
                                            		<option value="monthly">Monthly</option>
                                            	</select>-->
                                                <?php  //BO YMS
                                                $default_has_space='';
                                                if(Auth::guard('user2')->check()){
                                                    $space= \App\User2requirespace::firstOrNew(array('User2ID' => Auth::guard('user2')->user()->id));
                                                    //echo "<pre>space: "; var_dump($space); echo "</pre>";                                                    
                                                    switch ($space->BudgetType) {
                                                        case 'hour':
                                                            $default_has_space=1;
                                                            break;
                                                        case 'day':
                                                            $default_has_space=2;
                                                            break;
                                                        case 'week':
                                                            $default_has_space=3;
                                                            break;
                                                        case 'month':
                                                            $default_has_space=4;
                                                            break;
                                                    }
                                                }//EO YMS
                                                 ?>
                          										<select id="cd-dropdown"   class="cd-select" name="FeeType" required>
                          												@foreach(Config::get('lp.budgetType') as $bud => $ar )
                                                    @if(request()->get('fee_type'))
                                                      <option data-group="{{ $ar['type'] }}" data-fee-group="{{ $ar['fee'] }}" value="{{ $ar['id'] }}" {!! request()->has('fee_type') && request()->get('fee_type') == $ar['id'] ? 'selected="selected"' : '' !!}>{{ $ar['display'] }}</option>
                                                    @else
                                                      @if($ar['id'] == 1 || $default_has_space==$ar['id'])<!-- YMS -->
                                                        <option data-group="{{ $ar['type'] }}" data-fee-group="{{ $ar['fee'] }}" value="{{ $ar['id'] }}" selected="selected" >{{ $ar['display'] }}</option>
                                                      @else
                                                        <option data-group="{{ $ar['type'] }}" data-fee-group="{{ $ar['fee'] }}" value="{{ $ar['id'] }}" >{{ $ar['display'] }}</option>
                                                      @endif
                                                    @endif
                          												@endforeach
                          										</select>
                                            </div>
                                            {{-- <div class="filter-input-wrapper time-block">
                                               <div class="time-block-display" data-bind="click: timeFilters.timeBlockPopupToggleVisibility">
                                                  <span data-bind="text: timeFilters.displayText">This week, for 1 hour</span>

                                               </div>
                                            </div> --}}
                                            @include('user2/dashboard/parts/search-space-filter-datepeacker')
                                        </div>
                                        </div>
                                    </form>
                                </div><!--/search-bar-common-wrapper-->
                                <a  id="filters-button" href="javascript:void(0)" class="yellow-inverted-button-link filters-button" data-bind="click: function(){ filtersShown(!filtersShown()); }">
                                    <i class="fa fa-sliders" aria-hidden="true"></i>詳細検索
                                    <span data-bind="visible: appliedFiltersCount() > 0, text: '('+appliedFiltersCount()+')'" style="display: none;">(0)</span>
                                </a>
                                <div class="clear"></div>
                            </div><!--/searchbar-->
                        </div><!--/searchbar-row-->
                       
                                 <div class="find-list-inner-row find-list-inner-row-results">
                                	<form class="fl-form SpaceFilters-row" id="form_filter" method="get">
                                	    <input type="hidden" name="prefecture" id="prefecture" value="{!! request()->has('prefecture') ? request()->get('prefecture') : ''  !!}"/>
                                        @if(request()->has('district'))
                                            @foreach(request()->get('district') as $key => $district)
                                                <input type="hidden" name="district[{!! $key !!}]" class="form_filter_district" value="{!! $district !!}" />
                                            @endforeach
                                        @endif

                                        <input type="hidden" name="fee_type" id="fee_type" value="{!! request()->has('fee_type') ? request()->get('fee_type') : 1  !!}"/>

                                        <input type="hidden" name="start_from" id="start_from" value="{!! request()->has('start_from') ? request()->get('start_from') : ''  !!}">


                                        {{--@if(request()->has('end_at'))
                                          <input type="hidden" name="end_at" value="{!! request()->get('end_at')  !!}">

                                         @elseif(request()->has('start_at') && request()->get('start_at') != '0')
                                          <input type="hidden" name="end_at" value="{!! '30' !!}">
                                        @endif --}}
                                        @if(request()->has('fee_type') && request()->get('fee_type') != '1' && request()->get('fee_type') != '2' )
                                            <input type="hidden" name="start_at" value="{!! request()->has('start_at') ? request()->get('start_at') : ''  !!}">
                                            <input type="hidden" name="duration" value="{!! request()->has('duration') ? request()->get('duration') : ''  !!}">

                                        @else
                                            <input type="hidden" name="start_at" value="{!! request()->has('start_at') ? request()->get('start_at') : '0'  !!}">
                                            <input type="hidden" name="duration" value="{!! request()->has('duration') ? request()->get('duration') : '1'  !!}">
                                        @endif
                                        
                                        
                            <!--<div id="intertwined-table" class="featured_space_table">-->
                                <section class="SpaceFilters" id="SpaceFilters" style="display:none">
                                <div class="filters-wrapper-row">
                                <div class="filters-wrapper-cell">

                                        <div class="filters-wrapper">
                                        <div class="filters-inner-wrapper">
                                        <!--search by type of space-->
                                        
                                        <div class="SpaceFilters-section form-container" id="SpaceTypeDiv">
                                            <label class="SpaceFilters-rowLabel">スペースタイプ<!--Space Type--></label>
                                            <div class="SpaceFilters-item">
                                                <div class="input-icon">
                                                    <div class="form-field col4_wrapper">
                                                        <div class="space-type-section-content clearfix" >
                                                            <div class="input-container input-col4 iconbutton {!! request()->has('SpaceType') && in_array('Desk', request()->get('SpaceType')) ? 'checked' : '' !!}" data-id="desk">
                                                                <div class="iconbutton-icon workspace-type-icon-Desk"></div>
                                                                <div class="iconbutton-name">デスク</div>
                                                                <input type="checkbox" value="Desk" name="SpaceType[]" id="desk"  style="display:none" {!! request()->has('SpaceType') && in_array('Desk', request()->get('SpaceType')) ? 'checked="checked"' : '' !!}>
                                                            </div><!--/icon-button-->
                                                            <?php if (!in_array($request->fee_type, array(SPACE_FEE_TYPE_WEEKLY, SPACE_FEE_TYPE_MONTHLY))) {?>
                                                            <div class="input-container input-col4 iconbutton {!! request()->has('SpaceType') && in_array('MeetingSpace', request()->get('SpaceType')) ? 'checked' : '' !!}" data-id="meetingspace">
                                                                <div class="iconbutton-icon workspace-type-icon-Meeting"></div>
                                                                <div class="iconbutton-name">会議室</div>
                                    					        <input type="checkbox" value="MeetingSpace" name="SpaceType[]" id="meetingspace" style="display:none" {!! request()->has('SpaceType') && in_array('MeetingSpace', request()->get('SpaceType')) ? 'checked="checked"' : '' !!}>
                                                            </div><!--/icon-button-->
                                                            <?php }?>
                                                            <div class="input-container input-col4 iconbutton {!! request()->has('SpaceType') && in_array('PrivateOffice', request()->get('SpaceType')) ? 'checked' : '' !!}" data-id="privateoffice">
                                                                <div class="iconbutton-icon workspace-type-icon-Office"></div>
                                                                <div class="iconbutton-name">オフィス</div>
                                        					    <input type="checkbox" value="PrivateOffice" name="SpaceType[]" id="privateoffice" style="display:none" {!! request()->has('SpaceType') && in_array('PrivateOffice', request()->get('SpaceType')) ? 'checked="checked"' : '' !!}>
                                                            </div><!--/icon-button-->
                                                            <?php if (!in_array($request->fee_type, array(SPACE_FEE_TYPE_WEEKLY, SPACE_FEE_TYPE_MONTHLY))) {?>
                                                            <div class="input-container input-col4 iconbutton {!! request()->has('SpaceType') && in_array('SeminarSpace', request()->get('SpaceType')) ? 'checked' : '' !!}" data-id="seminarspace">
                                                                <div class="iconbutton-icon workspace-type-icon-Training"></div>
                                                                <div class="iconbutton-name">セミナースペース</div>
                                        					   <input type="checkbox" value="SeminarSpace" name="SpaceType[]" id="seminarspace" style="display:none" {!! request()->has('SpaceType') && in_array('SeminarSpace', request()->get('SpaceType')) ? 'checked="checked"' : '' !!}>
                                                            </div><!--/icon-button-->
                                                            <?php }?>
                                                        </div><!--/space-type-section-content-->
                                                    </div><!--/form-field-->
                                                </div>
                                                <div class="form-error"></div>
                                            </div>
                                        </div>
                                        <!--search by number of people-->
                                        <div class="SpaceFilters-section form-container" id="peopleuseDiv">
                                            <label class="SpaceFilters-rowLabel">利用人数<!--number of people to use--></label>
                                            <div class="SpaceFilters-item">
                                                <div class="input-icon">
                                                    <div class="form-field">
                                                        <div class="input-container">
                                                            <select id="choose_numpeople" name="Capacity" data-label="人数を選択">
                                                                <option value="">人数を選択</option>
                                                                <option value="1" {!! request()->has('Capacity') && request()->get('Capacity') == '1' ? 'selected="selected"' : '' !!}>1人</option>
                                                                <option value="2" {!! request()->has('Capacity') && request()->get('Capacity') == '2' ? 'selected="selected"' : '' !!}>2人</option>
                                                                <option value="3" {!! request()->has('Capacity') && request()->get('Capacity') == '3' ? 'selected="selected"' : '' !!}>3人</option>
                                                                <option value="4-6" {!! request()->has('Capacity') && request()->get('Capacity') == '4-6' ? 'selected="selected"' : '' !!}>4人〜6人</option>
                                                                <option value="7-9" {!! request()->has('Capacity') && request()->get('Capacity') == '7-9' ? 'selected="selected"' : '' !!}>7人〜9人</option>
                                                                <option value="10>" {!! request()->has('Capacity') && request()->get('Capacity') == '10>' ? 'selected="selected"' : '' !!}>10人以上</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-error"></div>
                                            </div>
                                        </div>
                                        <!--search by price-->
                                        <div class="SpaceFilters-section form-container" id="BudgetDiv">
                                            <label class="SpaceFilters-rowLabel">希望利用料金<!--Budget--></label>
                                            <div class="SpaceFilters-item">
                                                <div class="form-field">
                                                    <div class="input-container">
                                                        <div class="clearfix">
															<div  class="">
                                                                @foreach($budgets as $budget)
                                                                   <? /* @if(request()->has('fee_type') && request()->get('fee_type') == '2' && $budget->Type == 'day')
																	   <span class="field-checkbox budget budget-{{$budget->id}} {{ $budget->Type }} budget-price1"><input class="custom-checkbox" type="checkbox" data-labelauty="{{ $budget->Display }}|{{ $budget->Display }}" name="budget[]" id="budget{{ $budget->id }}" value="{{ $budget->id }}" {!! request()->has('budget') && in_array($budget->id, request()->get('budget')) ? 'checked' : '' !!}><span class="icons"><span class="icon-unchecked"></span><span class="icon-checked"></span></span><!--<label class="nextcheckbox" for="budget{{ $budget->id }}">{{ $budget->Display }}</label>--></span>
                                                                    @elseif(request()->has('fee_type') && request()->get('fee_type') == '3' && $budget->Type == 'week')
                                                                       <span class="field-checkbox budget budget-{{$budget->id}} {{ $budget->Type }} budget-price1"><input class="custom-checkbox" type="checkbox" data-labelauty="{{ $budget->Display }}|{{ $budget->Display }}" name="budget[]" id="budget{{ $budget->id }}" value="{{ $budget->id }}" {!! request()->has('budget') && in_array($budget->id, request()->get('budget')) ? 'checked' : '' !!}><!--<label class="nextcheckbox" for="budget{{ $budget->id }}">{{ $budget->Display }}</label>--></span>
                                                                    @elseif(request()->has('fee_type') && request()->get('fee_type') == '4' && $budget->Type == 'month')
                                                                       <span class="field-checkbox budget budget-{{$budget->id}} {{ $budget->Type }} budget-price1"><input class="custom-checkbox" type="checkbox" data-labelauty="{{ $budget->Display }}|{{ $budget->Display }}" name="budget[]" id="budget{{ $budget->id }}" value="{{ $budget->id }}" {!! request()->has('budget') && in_array($budget->id, request()->get('budget')) ? 'checked' : '' !!}><!--<label class="nextcheckbox" for="budget{{ $budget->id }}">{{ $budget->Display }}</label>--></span>
                                                                    @elseif(!request()->has('fee_type') || (request()->has('fee_type') && request()->get('fee_type') == '1' && $budget->Type == 'hour'))
                                                                       <span class="field-checkbox budget budget-{{$budget->id}} {{ $budget->Type }} budget-price1"><input class="custom-checkbox" type="checkbox" data-labelauty="{{ $budget->Display }}|{{ $budget->Display }}" name="budget[]" id="budget{{ $budget->id }}" value="{{ $budget->id }}" {!! request()->has('budget') && in_array($budget->id, request()->get('budget')) ? 'checked' : '' !!}><!--<label class="nextcheckbox" for="budget{{ $budget->id }}">{{ $budget->Display }}</label>--></span>
                                                                    @endif */ ?>
																	@if($feeType1 == '2' && $budget->Type == 'day')
																	   <span class="field-checkbox budget budget-{{$budget->id}} {{ $budget->Type }} budget-price1"><input class="custom-checkbox" type="checkbox" data-labelauty="{{ $budget->Display }}|{{ $budget->Display }}" name="budget[]" id="budget{{ $budget->id }}" value="{{ $budget->id }}" {!! request()->has('budget') && in_array($budget->id, request()->get('budget')) ? 'checked' : '' !!}><span class="icons"><span class="icon-unchecked"></span><span class="icon-checked"></span></span><!--<label class="nextcheckbox" for="budget{{ $budget->id }}">{{ $budget->Display }}</label>--></span>
                                                                    @elseif($feeType1 == '3' && $budget->Type == 'week')
                                                                       <span class="field-checkbox budget budget-{{$budget->id}} {{ $budget->Type }} budget-price1"><input class="custom-checkbox" type="checkbox" data-labelauty="{{ $budget->Display }}|{{ $budget->Display }}" name="budget[]" id="budget{{ $budget->id }}" value="{{ $budget->id }}" {!! request()->has('budget') && in_array($budget->id, request()->get('budget')) ? 'checked' : '' !!}><!--<label class="nextcheckbox" for="budget{{ $budget->id }}">{{ $budget->Display }}</label>--></span>
                                                                    @elseif($feeType1 == '4' && $budget->Type == 'month')
                                                                       <span class="field-checkbox budget budget-{{$budget->id}} {{ $budget->Type }} budget-price1"><input class="custom-checkbox" type="checkbox" data-labelauty="{{ $budget->Display }}|{{ $budget->Display }}" name="budget[]" id="budget{{ $budget->id }}" value="{{ $budget->id }}" {!! request()->has('budget') && in_array($budget->id, request()->get('budget')) ? 'checked' : '' !!}><!--<label class="nextcheckbox" for="budget{{ $budget->id }}">{{ $budget->Display }}</label>--></span>
                                                                    @elseif($feeType1 == '1' && $budget->Type == 'hour')
                                                                       <span class="field-checkbox budget budget-{{$budget->id}} {{ $budget->Type }} budget-price1"><input class="custom-checkbox" type="checkbox" data-labelauty="{{ $budget->Display }}|{{ $budget->Display }}" name="budget[]" id="budget{{ $budget->id }}" value="{{ $budget->id }}" {!! request()->has('budget') && in_array($budget->id, request()->get('budget')) ? 'checked' : '' !!}><!--<label class="nextcheckbox" for="budget{{ $budget->id }}">{{ $budget->Display }}</label>--></span>
                                                                    @endif
																@endforeach

															</div>
                                                            {{-- <div id="hourly" class="budget">
                                                                <!--per an hour-->
                                                                <span class="field-checkbox"><input class="custom-checkbox" data-labelauty="2,000円以下|2,000円以下" type="checkbox" name="select-budget" value="2,000円以下"></span>
                                                                <span class="field-checkbox"><input class="custom-checkbox" data-labelauty="2,00円1~5,000円|2,001円~5,000円" type="checkbox" name="select-budget" value="2,001円~5,000円"><</span>
                                                                <span class="field-checkbox"><input class="custom-checkbox" data-labelauty="5,001円~10,000円|5,001円~10,000円" type="checkbox" name="select-budget" value="5,001円~10,000円"></span>
                                                                <span class="field-checkbox"><input class="custom-checkbox" data-labelauty="10,000円以上|10,000円以上" type="checkbox" name="select-budget" value="10,000円以上"></span>
                                                            </div>
                                                            <div id="daily" style="display:none" class="budget">
                                                                <!--per a day-->
                                                                <span class="field-checkbox"><input class="custom-checkbox" data-labelauty="3,000円以下|3,000円以下" type="checkbox" name="select-budget" value="3,000円以下"></span>
                                                                <span class="field-checkbox"><input class="custom-checkbox" data-labelauty="3,001円~5,000円|3,001円~5,000円" type="checkbox" name="select-budget" value="3,001円~5,000円"></span>
                                                                <span class="field-checkbox"><input class="custom-checkbox" data-labelauty="5,001円~10,000円|5,001円~10,000円" type="checkbox" name="select-budget" value="5,001円~10,000円"></span>
                                                                <span class="field-checkbox"><input class="custom-checkbox" data-labelauty="10,000円以上|10,000円以上" type="checkbox" name="select-budget" value="10,000円以上"></span>
                                                            </div>
                                                            <!--per a week-->
                                                            <div id="weekly" style="display:none" class="budget">
                                                                <span class="field-checkbox"><input class="custom-checkbox" data-labelauty="5,000円以下|5,000円以下" type="checkbox" name="select-budget" value="5,000円以下"></span>
                                                                <span class="field-checkbox"><input class="custom-checkbox" data-labelauty="5,001円~10,000円|5,001円~10,000円" type="checkbox" name="select-budget" value="5,001円~10,000円"></span>
                                                                <span class="field-checkbox"><input class="custom-checkbox" data-labelauty="10,001円~20,000円|10,001円~20,000円" type="checkbox" name="select-budget" value="10,001円~20,000円"></span>
                                                                <span class="field-checkbox"><input class="custom-checkbox" data-labelauty="20,001円~30,000円|20,001円~30,000円" type="checkbox" name="select-budget" value="20,001円~30,000円"></span>
                                                                <span class="field-checkbox"><input class="custom-checkbox" data-labelauty="30,000円以上|30,000円以上" type="checkbox" name="select-budget" value="30,000円以上"></span>
                                                            </div>
                                                            <div id="monthly" style="display:none" class="budget">
                                                                <!--per a month-->
                                                                <span class="field-checkbox"><input class="custom-checkbox" data-labelauty="30,000円以下|30,000円以下" type="checkbox" name="select-budget" value="30,000円以下"></span>
                                                                <span class="field-checkbox"><input class="custom-checkbox" data-labelauty="30,001円~40,000円|30,001円~40,000円" type="checkbox" name="select-budget" value="30,001円~40,000円"></span>
                                                                <span class="field-checkbox"><input class="custom-checkbox" data-labelauty="40,001円~50,000円|40,001円~50,000円" type="checkbox" name="select-budget" value="40,001円~40,000円"></span>
                                                                <span class="field-checkbox"><input class="custom-checkbox" data-labelauty="50,001円~60,000円|50,001円~60,000円" type="checkbox" name="select-budget" value="50,001円~60,000円"></span>
                                                                <span class="field-checkbox"><input class="custom-checkbox" data-labelauty="60,000円以上|60,000円以上" type="checkbox" name="select-budget" value="60,000円以上"></span>
                                                            </div>  --}}
                                                        </div><!--/clearfix-->
                                                    </div>
                                                </div><!--/form-field-->
                                                <div class="form-error"></div>
                                            </div>
                                        </div>

                                        <!--search by time-->
                                        <div class="SpaceFilters-section form-container" id="TimeSlotDiv">
                                            <label class="SpaceFilters-rowLabel">利用時間帯<!--Time slot to use--></label>
                                            <div class="SpaceFilters-item">
                                                <div class="form-field">
                                                    <div class="input-container">
    													@foreach($timeslots as $timeslot)
                                                            <span class="field-checkbox"><input class="custom-checkbox" type="checkbox" data-labelauty="{!! $timeslot->Display !!}|{!! $timeslot->Display !!}" name="TimeSlot[]" id="TimeSlot{!! $timeslot->id !!}" value="{!! $timeslot->id !!}" {!! request()->has('TimeSlot') && in_array($timeslot->id, request()->get('TimeSlot')) ? 'checked="checked"' : '' !!} ><!--<label class="nextcheckbox" for="TimeSlot{!! $timeslot->id !!}" >{!! $timeslot->Display !!}</label>--></span>
    						                            @endforeach

                                                        {{-- <span class="field-checkbox"><input class="custom-checkbox" type="checkbox" name="select-timeslot" value="9:00~17:00" data-labelauty="9:00~17:00|9:00~17:00"></span>
                                                        <span class="field-checkbox"><input class="custom-checkbox" type="checkbox" name="select-timeslot" value="9:00~18:00" data-labelauty="9:00~18:00|9:00~18:00"></span>
                                                        <span class="field-checkbox"><input class="custom-checkbox" type="checkbox" name="select-timeslot" value="9:00~20:00" data-labelauty="9:00~20:00|9:00~20:00"></span>
                                                        <span class="field-checkbox"><input class="custom-checkbox" type="checkbox" name="select-timeslot" value="9:00~深夜まで" data-labelauty="9:00~深夜まで|9:00~深夜まで"></span>  --}}

                                                    </div><!--/input-container-->
                                                </div>
                                                <div class="form-error"></div>
                                            </div><!--/SpaceFilters-item-->
                                        </div>
                                        <!--search by faclilities-->
                                        <div class="SpaceFilters-section form-container" id="OtherFacDiv">
                                            <label class="SpaceFilters-rowLabel">その他設備<!--Other facilities--></label>
                                            <div class="SpaceFilters-item">
                                                <div class="input-icon">
                                                    <div class="form-field col4_wrapper">
                                                        <div class="space-type-section-content clearfix">
                                                            <div class="{!! request()->has('OtherFacilities') && in_array('wi-fi', request()->get('OtherFacilities')) ? 'checked' : '' !!} input-container input-col4 iconbutton" data-id="wi-fi" >
                                                                <div class="iconbutton-icon amenity-icon-wifi"></div>
                                                                <div class="iconbutton-name">WiFi</div>
                                                                <input type="checkbox" value="wi-fi" name="OtherFacilities[]" id="wi-fi"  style="display:none" {!! request()->has('OtherFacilities') && in_array('wi-fi', request()->get('OtherFacilities')) ? 'checked="checked"' : '' !!}>

                                                            </div><!--/icon-button-->
                                                            <div class="{!! request()->has('OtherFacilities') && in_array('プリンター', request()->get('OtherFacilities')) ? 'checked' : '' !!} input-container input-col4 iconbutton" data-id="プリンター" >
                                                                <div class="iconbutton-icon amenity-icon-printscancopy"></div>
                                                                <div class="iconbutton-name">プリンター</div>
                                                                <input type="checkbox" value="プリンター" name="OtherFacilities[]" id="プリンター"  style="display:none" {!! request()->has('OtherFacilities') && in_array('プリンター', request()->get('OtherFacilities')) ? 'checked="checked"' : '' !!}>

                                                            </div><!--/icon-button-->
                                                            <div class="{!! request()->has('OtherFacilities') && in_array('プロジェクター', request()->get('OtherFacilities')) ? 'checked' : '' !!} input-container input-col4 iconbutton" data-id="プロジェクター" >
                                                                <div class="iconbutton-icon amenity-icon-projector"></div>
                                                                <div class="iconbutton-name">プロジェクター</div>
                                                                <input type="checkbox" value="プロジェクター" name="OtherFacilities[]" id="プロジェクター"  style="display:none" {!! request()->has('OtherFacilities') && in_array('プロジェクター', request()->get('OtherFacilities')) ? 'checked="checked"' : '' !!}>

                                                            </div><!--/icon-button-->
                                                            <div class="{!! request()->has('OtherFacilities') && in_array('自動販売機', request()->get('OtherFacilities')) ? 'checked' : '' !!} input-container input-col4 iconbutton" data-id="自動販売機" >
                                                                <div class="iconbutton-icon workspace-type-icon-drink"></div>
                                                                <div class="iconbutton-name">自動販売機</div>
                                                                <input type="checkbox" value="自動販売機" name="OtherFacilities[]" id="自動販売機"  style="display:none" {!! request()->has('OtherFacilities') && in_array('自動販売機', request()->get('OtherFacilities')) ? 'checked="checked"' : '' !!}>

                                                            </div><!--/icon-button-->
                                                            <div class="{!! request()->has('OtherFacilities') && in_array('男女別トイレ', request()->get('OtherFacilities')) ? 'checked' : '' !!} input-container input-col4 iconbutton" data-id="男女別トイレ" >
                                                                <div class="iconbutton-icon workspace-type-icon-toilet"></div>
                                                                <div class="iconbutton-name">男女別トイレ</div>
                                                                <input type="checkbox" value="男女別トイレ" name="OtherFacilities[]" id="男女別トイレ"  style="display:none" {!! request()->has('OtherFacilities') && in_array('男女別トイレ', request()->get('OtherFacilities')) ? 'checked="checked"' : '' !!}>

                                                            </div><!--/icon-button-->
                                                            <div class="{!! request()->has('OtherFacilities') && in_array('喫煙所', request()->get('OtherFacilities')) ? 'checked' : '' !!} input-container input-col4 iconbutton" data-id="喫煙所" >
                                                                <div class="iconbutton-icon workspace-type-icon-smoking"></div>
                                                                <div class="iconbutton-name">喫煙所</div>
                                                                <input type="checkbox" value="喫煙所" name="OtherFacilities[]" id="喫煙所"  style="display:none" {!! request()->has('OtherFacilities') && in_array('喫煙所', request()->get('OtherFacilities')) ? 'checked="checked"' : '' !!}>

                                                            </div><!--/icon-button-->
                                                            <div class="{!! request()->has('OtherFacilities') && in_array('エレベーター', request()->get('OtherFacilities')) ? 'checked' : '' !!} input-container input-col4 iconbutton" data-id="エレベーター" >
                                                                <div class="iconbutton-icon workspace-type-icon-elevetor"></div>
                                                                <div class="iconbutton-name">エレベーター</div>
                                                                <input type="checkbox" value="エレベーター" name="OtherFacilities[]" id="エレベーター"  style="display:none" {!! request()->has('OtherFacilities') && in_array('エレベーター', request()->get('OtherFacilities')) ? 'checked="checked"' : '' !!}>

                                                            </div><!--/icon-button-->
                                                            <div class="{!! request()->has('OtherFacilities') && in_array('駐車場', request()->get('OtherFacilities')) ? 'checked' : '' !!} input-container input-col4 iconbutton" data-id="駐車場" >
                                                                <div class="iconbutton-icon workspace-type-icon-parking"></div>
                                                                <div class="iconbutton-name">駐車場</div>
                                                                <input type="checkbox" value="駐車場" name="OtherFacilities[]" id="駐車場"  style="display:none" {!! request()->has('OtherFacilities') && in_array('駐車場', request()->get('OtherFacilities')) ? 'checked="checked"' : '' !!}>

                                                            </div><!--/icon-button-->
                                                        </div><!--/space-type-section-content-->
                                                    </div><!--/form-field-->
                                                </div>
                                                <div class="form-error"></div>
												
												
                                            </div><!--/SpaceFilters-item-->
											
												
                                        </div>
										
										
                                        </div>
                                        
                                      
                                                <div class="filters-buttons-wrapper">
                                                    <button id="apply-btn" class="SpaceFilters-applyButton btn yellow-button-small" data-option-hidden="true">この検索条件で絞り込む</button>
                                                    <a href="{!! url('/RentUser/Dashboard/SearchSpaces') !!}" id="clear-btn" class="SpaceFilters-clearButton btn" style="background:#ddd; color:#333">検索条件をクリア</a>
												</div> 
                                               
                                        </div>
                                        
                                        </div>
                                        </div>
                                </section>

                            <!--</div><!--/intertwined-table-->
                             
                                    </form>
                                    </div>
                                    
                                    
                            <div>
                                <div class="reccomend-list space-list clearfix">
        							@foreach($spaces as $space)
            							<div class="list-item">
            								<?php  $spaceImg= $space->spaceImage;
            									$img="";
            										foreach($spaceImg as $im)
            										{
            											if ($im->Main)
            											{
            												$img = $im->ThumbPath;
            												break;
            											}
            										}
            								?>
                                            {{-- {!! dd($space) !!} --}}
            								<div class="sp01" style='background:url("{{$img}}") !important; background-size: cover!important;background-position: center center!important;'>
            									<a href="{!! url('ShareUser/ShareInfo/View',['id' => $space->HashID]) !!}" class="link_space" target="_blank">
                                                    <span class="area">
                                                        {!! $space->District !!}
                                                        <!--district name-->
                                                    </span>
													
            										<span class="space-label befhov">
                                                        <div class="clearfix">
                                                                <span class="type" style="display: block;">{{ str_limit($space->Title, 30, '...') }}</span>
                                                            <div class="label-left" style="width: 30%;">
                                                                <span class="capacity" style="padding-top: 3px;">~{!! $space->Capacity !!}名</span>
                                                            </div>
                                                            <div class="label-right" style="width: 70%;">
                                                                <span class="price">
                                                                    <?php echo getPrice($space, true)?>
                                                                </span>
                                                            </div>
                                                        </div>
            										</span>
													
            										<span class="space-label onhov">
                                                        <div class="clearfix">
                                                        <h3 class="sp-title">{{ str_limit($space->Title, 30, '...') }}</h3>
                                                        <span class="price">
                                                                    <?php echo getPrice($space, true)?>
                                                                </span>
                                                            <span class="type" style="display: block;">{{ str_limit($space->Details, 300, '...') }}</span>
                                                        </div>
            										</span>
            									</a>
            								</div>
            							</div>
        							@endforeach
                                </div>
                            </div>

							<div class="pagenation-inner">
								@if (count($spaces) > 0)
									<div class="ns_pagination">{{ $spaces->links() }}</div>
								@else
									<div class="no-result"><h1>NO RESULT</h1><p>該当するスペースはありませんでした。<br/>検索条件を変えてお探し下さい。</p></div>
								@endif
                    		</div>
                        </div><!--/find-list-inner-row -->
                    </div>
                </div><!--#fixed_col-->
            </div><!--/main-container-->
            <!--footer-->
		@include('pages.common_footer')
		<!--/footer-->
            
        </div><!--/viewport-->
    </div>
        <link rel="stylesheet" href="/js/dropdown/style5.css" />
        <script src="/js/dropdown/modernizr.custom.63321.js"></script>
        <script type="text/javascript" src="/js/dropdown/jquery.dropdown.js"></script>

        <script type="text/javascript">
        	jQuery( function() {
				
				jQuery( '#mbshow' ).click( function(){
					jQuery( '#mbshowfd' ).toggle();
					jQuery( '#mbshowsec' ).toggle();
					jQuery( '#mbshow' ).toggle();
					
				});
				
				jQuery( '#mbshowcl' ).click( function(){
					jQuery( '#mbshow' ).click();
				});
        		jQuery( '#cd-dropdown' ).dropdown( {
        			gutter : 5,
        			stack : false,
        			slidingIn : false,
        			 onOptionSelect: function(opt) {
                         console.log(opt);
        				var selected_val = opt.data('value');
        				jQuery('.budget').hide();
        				jQuery('.budget-'+selected_val).show();
                        jQuery('#fee_type').val(selected_val);
                        jQuery.each(jQuery('input[name="budget[]"]'), function(val){
                            console.log(jQuery(val).attr('checked', false));
                        })
                        jQuery('input[name="duration"]').val('');
                        jQuery('input[name="start_from"]').val('');
                        jQuery('input[name="start_at"]').val('');

                        // if(selected_val == 4 || selected_val == '4' || selected_val == '3' || selected_val == 3 ){
                        // }
        				jQuery('#form_filter').submit();
        			}
        		} );
        	});
        </script>
        <script src="{!! SITE_URL !!}js/chosen/chosen.jquery.js" type="text/javascript"></script>
        <script src="/js/address_select.js" type="text/javascript"></script>
        <script src="{!! SITE_URL !!}js/select2.full.min.js"></script>

        <script type="text/javascript">
            var config = {
                '.chosen-select'           : {},
                '.chosen-select-deselect'  : {allow_single_deselect:true},
                '.chosen-select-no-single' : {disable_search_threshold:10},
                '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                '.chosen-select-width'     : {width:"95%"}
            }
            for (var selector in config) {
                jQuery(selector).chosen(config[selector]);
            }
        </script>
        <!-- <script type="text/javascript" src="{!! SITE_URL !!}js/multiple-select.js"></script> -->
        <script>
            jQuery(function() {
                /*jQuery('#ms').change(function() {
                    console.log(jQuery(this).val());
                    jQuery(this).hide();
                }).multipleSelect({
                    width: '100%'
                });*/

                jQuery('#filter_district').select2({
                    multiple:true
                });
            });

        </script>
        <script>
            var $ = document.querySelector.bind(document);
            window.onload = function () {
                //Ps.initialize($('.slimScrollDiv'));
            };
        </script>

        <script>
            jQuery(document).ready(function($){

                $('.top-display').on('click', function(){
                    $('.time-block-popup').toggle();
                    jQuery( '.cd-dropdown span' ).trigger('hide.dropdown');
                });

                $('.cd-dropdown').on('click', function(){
                    $('.time-block-popup').slideUp();
                });
                

                $('.duration').on('click', function(){
                    if($('.duration').hasClass('active')){
                        $('.duration').removeClass('active');
                    }else{
                        $('.duration').addClass('active');

                        if($('.start_at').hasClass('active')){
                            $('.start_at').removeClass('active')
                            $('.start_at-main-block').toggle();
                        }
                        if($('.end_at').hasClass('active')){
                            $('.start_at').removeClass('active')
                            $('.end_at-main-block').toggle();
                        }
                        if($('.date_picker').hasClass('active')){
                            $('.date_picker').removeClass('active')
                            $('.datepicker_container').toggle();
                        }

                    }
                    $('.duration-main-block').toggle();
                });

                $('.start_at').on('click', function(){

                    if($('.start_at').hasClass('active')){
                        $('.start_at').removeClass('active');
                    }else{
                        $('.start_at').addClass('active');

                        if($('.duration').hasClass('active')){
                            $('.duration').removeClass('active')
                            $('.duration-main-block').toggle();
                        }
                        if($('.end_at').hasClass('active')){
                            $('.end_at').removeClass('active')
                            $('.end_at-main-block').toggle();
                        }
                        if($('.date_picker').hasClass('active')){
                            $('.date_picker').removeClass('active')
                            $('.datepicker_container').toggle();
                        }

                    }
                    $('.start_at-main-block').toggle();

                });

                $('.end_at').on('click', function(){
                    if($('.end_at').hasClass('active')){
                        $('.end_at').removeClass('active');
                    }else{
                        $('.end_at').addClass('active');

                        if($('.start_at').hasClass('active')){
                            $('.start_at').removeClass('active')
                            $('.start_at-main-block').toggle();
                        }
                        if($('.duration').hasClass('active')){
                            $('.duration').removeClass('active')
                            $('.duration-main-block').toggle();
                        }
                        if($('.date_picker').hasClass('active')){
                            $('.date_picker').removeClass('active')
                            $('.datepicker_container').toggle();
                        }

                    }
                  $('.end_at-main-block').toggle();
                });

                $('.date_picker').on('click', function(){
                    if($('.date_picker').hasClass('active')){
                        $('.date_picker').removeClass('active');
                    }else{
                        $('.date_picker').addClass('active');

                        if($('.start_at').hasClass('active')){
                            $('.start_at').removeClass('active')
                            $('.start_at-main-block').toggle();
                        }
                        if($('.end_at').hasClass('active')){
                            $('.start_at').removeClass('active')
                            $('.end_at-main-block').toggle();
                        }
                        if($('.end_at').hasClass('active')){
                            $('.end_at').removeClass('active')
                            $('.end_at-main-block').toggle();
                        }
                    }
                  $('.datepicker_container').toggle();
                });


                $('.duration-main-block-option').on('click', function(){
                    var duration = $(this).val();
                    $('input[name="duration"]').val(duration);
                    $('#form_filter').submit();
                });

                $('.start_at_option').on('click', function(){
                    var start_at = $(this).val();
                    var start_at_html = $(this).html();
                    $('input[name="start_at"]').val(start_at);
                    if(start_at == 0 || start_at == '0'){
                        $('input[name="duration"]').val(1);
                    }
                    // else{
                    //     $('input[name="duration"]').val('');
                    // }
                    $('#form_filter').submit();
                });

                $('.end_at_option').on('click', function(){
                  var duration = $(this).val()
                  $('input[name="duration"]').val(duration);
                  $('#form_filter').submit();
                });

                $('.reset_calendar').on('click', function(){
                    $('#start_from').val('');
                    $('#form_filter').submit();

                });
                // $('.start_from_option').on('click', function(){
                //     var start_at = $(this).val();
                //     $('input[name="start_from"]').val(start_at);
                // });

                var feeType = '<?php echo $feeType?>';
        		var japanMonthFormat = 'YYYY-MM-DD';
                var japanDateFormat = 'YYYY-MM-DD';
                
                function CreatedatePicker() {
					var nowDate = new Date();
					var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
			
					if (feeType == 4)
					{
						var startMonth = moment().startOf('month');
						$('#datepicker').datepicker({
							format: japanMonthFormat.toLowerCase(),
							minViewMode: 1,
							todayHighlight: true,
							language: "ja",
							autoclose: true,
							startDate: startMonth.format('YYYY-MM-DD'),
						}).on('changeDate', function(e) {
							$('#start_from').val(e.format('yyyy-mm-dd'));
	                        $('#form_filter').submit();
						});
					}
					else if (feeType == 3)
					{
						var startWeek = moment().startOf('isoweek');
						$('#datepicker').datepicker({
							format: japanDateFormat.toLowerCase(),
						    weekStart: 1,
						    language: "ja",
						    todayHighlight: true,
						    calendarWeeks: false,
						    autoclose: true,
						    startDate: startWeek.format('YYYY-MM-DD'),
						    daysOfWeekDisabled: "0,2,3,4,5,6",
						    daysOfWeekHighlighted: "1"
						}).on('changeDate', function(e) {
							$('#start_from').val(e.format('yyyy-mm-dd'));
	                        $('#form_filter').submit();
						});
			
					}
					else {
						$('#datepicker').datepicker({
							format: japanDateFormat.toLowerCase(),
							language: "ja",
							weekStart: 1,
							todayHighlight: true,
							startDate: new Date(),
							todayBtn: true,
							autoclose: true,
						}).on('changeDate', function(e) {
							$('#start_from').val(e.format('yyyy-mm-dd'));
	                        $('#form_filter').submit();
						});
					}
				}
                CreatedatePicker();
                // start_at

                jQuery("#choose_budget_per").change(function(){

                    jQuery(".budget-price1").addClass('hide');
                    var selected_opt_class = jQuery('option:selected', '#choose_budget_per').attr('class');

                    jQuery('#'+selected_opt_class).removeClass("hide");
                });
                jQuery(".input-container.iconbutton").click(function(){
              jQuery(this).toggleClass("checked");
			   var checkBoxes =  jQuery("#"+jQuery(this).data("id"));
				checkBoxes.prop("checked", !checkBoxes.prop("checked"));
            });
            jQuery(".SpaceFilters-optionsToggle").click(function(){
              //jQuery(".SpaceFilters-optionsToggle").toggleClass("filter-to-hide hide");
             jQuery('.SpaceFilters-section').each(function(){
              if(jQuery(this).attr('id') != 'SpaceTypeDiv' && jQuery(this).attr('id') != 'locationDiv' && jQuery(this).attr('id') != 'peopleuseDiv' && jQuery(this).attr('id') != 'filterDiv'){

                if(jQuery('.option-more').hasClass('showing-more-option')){
                   jQuery('.option-more').removeClass('showing-more-option');
                   jQuery('.option-more').text('More Options');

                }
                else{
                   jQuery('.option-more').addClass('showing-more-option');
                   jQuery('.option-more').text('Less Options');
                }
                if(jQuery(this).hasClass('filter-to-hide')){
                   jQuery(this).removeClass('filter-to-hide');
                }
                else{
                   jQuery(this).addClass('filter-to-hide');
                }
                if(jQuery(this).hasClass('hide')){
                   jQuery(this).removeClass('hide');
                }
                else{
                   jQuery(this).addClass('hide');
                }
             }
             });

            });
            });




        </script>
        {{-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script> --}}
        {{-- <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.24/jquery-ui.min.js"></script> --}}

        {{-- <script src="https://lsprodresources.azureedge.net/liquidspace.common.js/True_842317020"></script> --}}

    </body>
</html>
