
<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header_beforelogin.php'); ?>
 @include('pages.header_beforelogin')
 
	
<link rel="stylesheet" href="<?php echo SITE_URL?>js/chosen/chosen.min.css">
<!--/head-->
<body class="selectPage">
  <div class="viewport">
    <div class="header_wrapper primary-navigation-section">
      <header id="header">
        <div class="header_container dark">
          <div class="logo_container"><a class="logo" href="index.html">Offispo</a></div>
        </div>
      </header>
    </div>
    <div class="main-container">
      <div id="main" class="container">
        <h1 class="page-title">Select desired office space<!--希望オフィススペースを選択--></h1>
        <p class="sub-title">To provide matched office space with your ideal condition,enter your desired info.<!--マッチングの為の希望オフィススペース情報を入力して下さい。--></p>
        <div class="form-container">
        <form id="basicinfo" method="post">
		{{ csrf_field() }} 

            <fieldset>
              <div class="Signup-sectionHeader">
                <legend class="signup-sectionTitle">Ideal conditions for office space<!--利用希望オフィススペース--></legend>
              </div>
              <div class="form-field col4_wrapper">
                <label for="require-place">Space Type<!--スペースタイプ--></label>
                <div class="space-type-section-content clearfix" >
                  <div class="input-container input-col4 iconbutton" data-id="desk">
                    <div class="iconbutton-icon workspace-type-icon-Desk"></div>
                    <div class="iconbutton-name">Desk</div>
					<input type="checkbox" value="Desk" name="SpaceType[]" id="desk" style="display:none">
                  </div><!--/icon-button-->
                  <div class="input-container input-col4 iconbutton" data-id="meetingspace">
                    <div class="iconbutton-icon workspace-type-icon-Meeting"></div>
                      <div class="iconbutton-name">Meeting Space</div>
					<input type="checkbox" value="MeetingSpace" name="SpaceType[]" id="meetingspace" style="display:none">
                  </div><!--/icon-button-->
                  <div class="input-container input-col4 iconbutton" data-id="privateoffice">
                    <div class="iconbutton-icon workspace-type-icon-Office"></div>
                    <div class="iconbutton-name">Private Office</div>
					<input type="checkbox" value="PrivateOffice" name="SpaceType[]" id="privateoffice" style="display:none">
                  </div><!--/icon-button-->
                  <div class="input-container input-col4 iconbutton" data-id="seminarspace">
                    <div class="iconbutton-icon workspace-type-icon-Training"></div>
                    <div class="iconbutton-name">Seminar Space</div>
					<input type="checkbox" value="SeminarSpace" name="SpaceType[]" id="seminarspace" style="display:none">
                  </div><!--/icon-button-->
                </div><!--/space-type-section-content-->
              </div><!--/form-field-->
              <div class="form-field col3_wrapper">
                <label for="require-place">Desired Location<!--希望地域--></label>
                <div class="input-container input-col3">
                  <select data-label="都道府県を選択" name="DesireLocationPrefecture"></select><!--select prefecture-->
                </div>
                <div class="input-container input-col3">
                  <select data-label="市区町村を選択" name="DesireLocationDistricts"></select><!--select districts-->
                </div>
                <div class="input-container input-col3 last">
                  <select data-label="町域を選択" class="chosen-select" multiple tabindex="16" name="DesireLocationTown[]"></select><!--select towns-->
                </div>
              </div><!--/form-field-->
              <div class="form-field two-inputs">
                <div class="input-container input-half">
                  <div class="field_col2_wrapper clearfix">
                    <label for="your_budget">Your budget<!--希望利用料金--></label>
                    <div class="field_col2">
                      <select id="choose_budget_per" name="BudgetType">
                        <option value="">select day,week or month<!--日、週、月あたりから選択--></option>
                        <option value="day" class="choose_budget_per_day" data-type="day">{{ Config::get('lp.budget.day') }}</option>
                        <option value="week" class="choose_budget_per_week" data-type="week">{{ Config::get('lp.budget.week') }}</option>
                        <option value="month" class="choose_budget_per_month" data-type="month">{{ Config::get('lp.budget.month') }}</option>
                      </select>
                    </div>
                    <div class="field_col2">
                      <!--<select id="choose_budget_per_day" class="budget-price" data-label="予算を選択" name="BudgetPerDay">
                        <option value="" selected="">select budget</option>
                        <option value="2000円以下">less than &yen;2,000</option>
                        <option value="2,000円~4,000円">&yen;2,000~&yen;4,000</option>
                        <option value="4,000円以上">more than &yen;4,000</option>
                      </select>
                      <select id="choose_budget_per_week" class="budget-price" data-label="予算を選択" name="BudgetPerWeek">
                        <option value="" selected="">select budget</option>
                        <option value="5,000円以下">less than &yen;5,000</option>
                        <option value="5,000円~10,000円">&yen;5,000~&yen;10,000</option>
                        <option value="10,000円~20,000円">&yen;10,000~&yen;20,000</option>
                        <option value="20,000円以上">more than &yen;20,000</option>
                      </select>
                      <select id="choose_budget_per_month" class="budget-price" data-label="予算を選択" name="BudgetPerMonth">
                        <option value="" selected="">select budget</option>
                        <option value="30,000円以下">less than &yen;30,000</option>
                        <option value="30,000円~50,000円">&yen;30,000~&yen;50,000</option>
                        <option value="50,000円以上">more than &yen;50,000</option>
                      </select>-->
					  
					  <select id="choose_budget_per_" class="" data-label="予算を選択" name="BudgetID">
                        <option value="" selected="">select budget</option>
						 @foreach($budgets as $budget)
								<option value="{{ $budget->id }}" class="{{ $budget->Type }} budget-price1">{{ $budget->Display }}</option>
						@endforeach	
                        
                      </select>
                    </div>
                  </div><!--/clearfix-->
                </div>
                <div class="input-container input-half">
                  <label for="time_slot">Time slot to use<!--利用時間帯--></label>
                  <select id="choose_timeslot" data-label="時間帯を選択" name="TimeSlot">
                    <option value="" selected="">select time slot</option>
					 @foreach($timeslots as $timeslot)
								<option value="{{ $timeslot->id }}" >{{ $timeslot->Display }}</option>
						@endforeach
                   <!-- <option value="9:00~17:00">9:00~17:00</option>
                    <option value="9:00~18:00">9:00~18:00</option>
                    <option value="9:00~20:00">9:00~20:00</option>
                    <option value="9:00~深夜まで">9:00~深夜まで</option>-->
                  </select>
                </div>
              </div><!--/form-field-->
              <div class="form-field two-inputs">
                <div class="input-container input-half">
                  <label for="space_area">Space area<!--スペース面積--></label>
                    <select id="choose_spacearea" data-label="面積を選択" name="SpaceArea">
                     <option value="" selected="">select size of area</option>
                     <!--  <option value="10">less than 10m&sup2;</option>
                      <option value="20">less than 20&sup2;</option>
                      <option value="30">more than 30&sup2;</option>
                      <option value="特になし">any size of area</option>
					  -->
					  @foreach(Config::get('lp.spaceArea') as $area => $ar ) 
						        <option value="{{ $ar['id'] }}">{{ $ar['display'] }}</option>

    @endforeach   
                    </select>
                </div>
                <div class="input-container input-half">
                  <label for="number_people">Number of people to use<!--利用人数--></label>
                  <select id="choose_numpeople" data-label="人数を選択" name="NumberOfPeople">
                    <option value="" selected="">select number of people</option>
                    <option value="1人">1 people</option>
                    <option value="2人">2 people</option>
                    <option value="3人">3 people</option>
                    <option value="4人~6人">4 people-6people</option>
                    <option value="6人以上">more than 6people</option>
                  </select>
                </div>
              </div><!--/form-field-->
              <div class="form-field two-inputs">
                <div class="input-container input-half">
                  <label for="last_name">want to use meeting room?<!--会議室利用--></label>
                  <span class="radio_field">
                    <input type="radio" name="MeetingRoom" value="Yes" />
                    <label class="label_radio">Yes</label>
                  </span>
                  <span class="radio_field">
                    <input type="radio" name="MeetingRoom" value="No" />
                    <label class="label_radio">No</label>
                  </span>
                </div>
                <div class="input-container input-half">
                  <label for="usage_frequency">Usage frequency<!--利用頻度--></label>
                  <select id="choose_frequency" data-label="利用頻度を選択" name="UsageFrequency">
                    <option value="" selected="">choose frequency</option>
                    <option value="1週間に2日">2days per a week</option>
                    <option value="1週間に5日">5days per a week</option>
                    <option value="毎日">everyday</option>
                    <option value="1ヶ月に数日">few days per a month</option>
                    <option value="1年に数日">few days per a year</option>
                    <option value="未定">undecided</option>
                  </select>
                </div>
              </div><!--/form-field-->
              <div class="form-field two-inputs">
                <div class="input-container input-half">
                  <label for="desire_business_workplace">Desired business of work place<!--希望職場事業--></label>
                  <select id="BusinessType_workplace" name="BusinessType" class="old_ui_selector">
                    <option value="" selected="">Choose business type</option>
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
                  </select>
                </div>
                <div class="input-container input-half">
                  <label for="desire_number_people_inoffice">Desired number of people in work place<!--希望職場人数--></label>
                  <select id="desire_numpeople_inoffice" data-label="人数を選択" name="WorkPlaceNumberOfPeople">
                    <option value="" selected="">select number of people</option>
                    <option value="5人以下">less than 5 people</option>
                    <option value="10人以下">less than 10 people</option>
                    <option value="10人以上">more than 10 people</option>
                    <option value="特に希望無し">any number of people</option>
                  </select>
                </div>
              </div><!--/form-field-->
              <div class="form-field two-inputs">
                <div class="input-container input-half">
                  <label for="have_lunch">Will you have lunch on desk?</label>
                  <span class="radio_field">
                    <input type="radio" name="LunchOnDesk" value="希望" />
                    <label class="label_radio">Yes</label>
                  </span>
                  <span class="radio_field">
                    <input type="radio" name="LunchOnDesk" value="希望しない" />
                    <label class="label_radio">No</label>
                  </span>
                  <span class="radio_field">
                    <input type="radio" name="LunchOnDesk" value="できれば希望" />
                    <label class="label_radio">Wish I could do</label>
                  </span>
                </div>
              </div><!--/form-field-->
              <div class="form-field">
                <div class="input-container">
                  <label for="last_name">Notes<!--備考--></label>
                  <textarea name="Notes" rows="4" cols="40"></textarea>
                </div>
              </div><!--/form-field-->
            </fieldset>
            <div class="hr"></div>
          <fieldset>
            <div class="Signup-sectionHeader">
              <legend class="signup-sectionTitle">Other desired facilities<!--その他希望設備--></legend>
            </div>
            <div class="form-field quater-inputs">
              <div class="input-container input-quater">
                <label for="num-desk">Desk<!--デスク--></label>
                <span class="field-number-input-withunit"><input type="number" name="NumOfDesk" min="1" max="50">台</span>
              </div>
              <div class="input-container input-quater">
                <label for="num-chair">Chair<!--イス--></label>
                <span class="field-number-input-withunit"><input type="number" name="NumOfChair" min="1" max="50">脚</span>
              </div>
              <div class="input-container input-quater">
                <label for="num-board">Board<!--ボード--></label>
                <span class="field-number-input-withunit"><input type="number" name="NumOfBoard" min="1" max="50">台</span>
              </div>
              <div class="input-container input-quater">
                <label for="num-largedesk">Desk&amp;Chair for many people<!--複数人用デスク&amp;イス--></label>
                <span class="field-number-input-withunit"><input type="number" name="NumOfLargeDesk" min="1" max="50">台</span>
              </div>
            </div><!--/form-field-->
            <div class="form-field">
              <div class="input-container">
                <label for="last_name">Other facilities<!--その他設備--></label>
                <span class="field-checkbox"><input type="checkbox" name="OtherFacility[]" value="wi-fi"><label class="nextcheckbox">wi-fi</label></span>
                <span class="field-checkbox"><input type="checkbox" name="OtherFacility[]" value="プリンター"><label class="nextcheckbox">printer</label></span>
                <span class="field-checkbox"><input type="checkbox" name="OtherFacility[]" value="プロジェクター"><label class="nextcheckbox">projecor</label></span>
                <span class="field-checkbox"><input type="checkbox" name="OtherFacility[]" value="自動販売機"><label class="nextcheckbox">drink-vending machine</label></span>
                <span class="field-checkbox"><input type="checkbox" name="OtherFacility[]" value="男女別トイレ"><label class="nextcheckbox">toilet by gender</label></span>
                <span class="field-checkbox"><input type="checkbox" name="OtherFacility[]" value="喫煙所"><label class="nextcheckbox">smoking area</label></span>
              </div>
            </div>
			 <div class="form-field no-btm-border no-btm-pad">
											<div class="input-container">
												<label for="OtherFac">
													Building facilities
													<!--ビル設備-->
												</label>
												<span class="field-checkbox">
													<input type="checkbox" name="OtherFacility[]" value="駐車場">
													<label class="nextcheckbox">parking</label>
												</span>
												<span class="field-checkbox">
													<input type="checkbox" name="OtherFacility[]" value="エレベーター">
													<label class="nextcheckbox">elevetor</label>
												</span>
											</div>
										</div>
			<!--/form-field-->
          </fieldset>
          <div class="hr"></div>
          <div class="btn-next-step">
            <button id="saveBasicInfo" class="btn btn-info input-basicinfo-button" type="submit">Next</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!--footer-->
    <?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/common_footer.php'); ?>
			@include('pages.common_footer')
  <!--/footer-->
</div><!--/viewport-->

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script> -->

  <script src="<?php echo SITE_URL?>/js/chosen/chosen.jquery.min.js" type="text/javascript"></script>
  <script src="<?php echo SITE_URL?>/js/chosen/chosen.proto.min.js" type="text/javascript"></script>
  <script src="<?php echo SITE_URL?>/js/chosen/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
  <script src="<?php echo SITE_URL?>/js/address_select.js" type="text/javascript"></script>
  


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
jQuery(function(){
    
    // 全ての駅名を非表示にする
    jQuery(".budget-price1").addClass('hide');
    // 路線のプルダウンが変更されたら
    jQuery("#choose_budget_per").change(function(){
        // 全ての駅名を非表示にする
        jQuery(".budget-price1").addClass('hide');
        // 選択された路線に連動した駅名プルダウンを表示する
        //jQuery('#' + $("#choose_budget_per option:selected").attr("class")).removeClass("hide");
        jQuery('.' + $("#choose_budget_per option:selected").attr("data-type")).removeClass("hide");
    });
})
jQuery(".input-container.iconbutton").click(function(){
  jQuery(this).toggleClass("checked");
          var checkBoxes =  jQuery("#"+jQuery(this).data("id"));
  checkBoxes.prop("checked", !checkBoxes.prop("checked"));
});
</script>
</body>
</html>
