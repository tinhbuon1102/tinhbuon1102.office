
<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header.php'); ?>
 @include('pages.header')

<link rel="stylesheet" href="<?php echo SITE_URL?>js/chosen/chosen.min.css">
<link rel="stylesheet" type='text/css' href="<?php echo SITE_URL?>css/select2.min.css">
<!--/head-->
<body class="mypage">
<div class="viewport">
<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header_nav_rentuser.php'); ?>
 @include('pages.header_nav_rentuser')

<div class="main-container">
<div id="main" class="container">
<section class="steps-banner">
<h3 class="steps-banner-title"> Your 3 Steps to Success</h3>
<p class="steps-banner-explanation">A big warm welcome to Offispo! Here's how it works in 3 easy steps:</p>
<ul class="steps-banner-list">
              <li class="steps-banner-item">
                  <span class="steps-banner-item-image"></span>
                  <span class="steps-banner-item-text">
                      Search for office space
                  </span>
              </li>
              <li class="steps-banner-item">
                  <span class="steps-banner-item-image step-2"></span>
                  <span class="steps-banner-item-text">
                      Book the space
                  </span>
              </li>
              <li class="steps-banner-item">
                  <span class="steps-banner-item-image  step-3"></span>
                  <span class="steps-banner-item-text">
                      Get Accept and Start to use the space
                  </span>
              </li>
          </ul>
          <p class="steps-banner-explanation">
              まずはオフィススペースを探しましょう。<br/>
                また、あなたのプロフィールを完成させることで、シェアユーザーからの信頼もあがります。<br/>
                <a href="#">今すぐプロフィールページの編集をする</a>
          </p>
</section>
<div id="myideal_page" class="margin-t10">
<h1 id="subTitle" style="display:inline-block">Space Matching My Ideal Condition</h1>
<span style="float: right"><a href="/u/kyoooko1121989.html?page=edit_skills">Edit my ideal condition</a></span>
<div id="intertwined-table" class="featured_space_table">
<section class="SpaceFilters">
<!--search by type of space-->
<div class="SpaceFilters-section form-container" id="SpaceTypeDiv">
<form class="fl-form SpaceFilters-row">
<label class="SpaceFilters-rowLabel">Space Type<!--スペースタイプ--></label>
<div class="SpaceFilters-item">
<div class="input-icon">
<div class="form-field col4_wrapper">
<div class="space-type-section-content clearfix">
<div class="input-container input-col4 iconbutton">
<div class="iconbutton-icon workspace-type-icon-Desk"></div>
<div class="iconbutton-name">Desk</div>
</div><!--/icon-button-->
<div class="input-container input-col4 iconbutton">
<div class="iconbutton-icon workspace-type-icon-Meeting"></div>
<div class="iconbutton-name">Meeting Space</div>
</div><!--/icon-button-->
<div class="input-container input-col4 iconbutton">
<div class="iconbutton-icon workspace-type-icon-Office"></div>
<div class="iconbutton-name">Private Office</div>
</div><!--/icon-button-->
<div class="input-container input-col4 iconbutton">
<div class="iconbutton-icon workspace-type-icon-Training"></div>
<div class="iconbutton-name">Semiar Space</div>
</div><!--/icon-button-->
</div><!--/space-type-section-content-->
</div><!--/form-field-->
</div>
<div class="form-error"></div>
</div>
</form>
</div>
<!--search by location-->
<div class="SpaceFilters-section form-container" id="locationDiv">
<form class="fl-form SpaceFilters-row">
<label class="SpaceFilters-rowLabel">Desired Location</label>
<div class="SpaceFilters-item">
<div class="input-icon">
<div class="form-field col3_wrapper">
<div class="input-container input-col3">
<select data-label="都道府県を選択"></select><!--select prefecture-->
</div>
<div class="input-container input-col3">
<select data-label="市区町村を選択" id="state-select" multiple></select><!--select districts-->
</div>
<div class="input-container input-col3 last">

</div>
</div><!--/form-field-->
</div>
<div class="form-error"></div>
</div>

  <script src="../js/chosen/chosen.jquery.js" type="text/javascript"></script>
  <script src="../js/chosen/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
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
</form>
</div>
<!--search by number of people-->
<div class="SpaceFilters-section form-container" id="peopleuseDiv">
<form class="fl-form SpaceFilters-row">
<label class="SpaceFilters-rowLabel">number of people to use</label>
<div class="SpaceFilters-item">
<div class="input-icon">
<div class="form-field">
<div class="input-container">
<select id="choose_numpeople" data-label="人数を選択">
<option value="" selected="">select number of people</option>
<option value="1人">1 people</option>
<option value="2人">2 people</option>
<option value="3人">3 people</option>
<option value="4人~6人">4 people-6people</option>
<option value="6人以上">more than 6people</option>
</select>
</div>
</div>
</div>
<div class="form-error"></div>
</div>
</form>
</div>
<!--search by price-->
<div class="SpaceFilters-section form-container filter-to-hide hide" id="BudgetDiv">
<form class="fl-form SpaceFilters-row">
<label class="SpaceFilters-rowLabel">Budget<!--希望利用料金--></label>
<div class="SpaceFilters-item">
<div class="form-field">
<div class="input-container">
<div class="field_col2_wrapper clearfix">
<div class="field_col2">
<select id="choose_budget_per">
<option value="">select day,week or month<!--日、週、月あたりから選択--></option>
<option value="1日あたり" class="choose_budget_per_day">Per 1day</option>
<option value="1週間あたり" class="choose_budget_per_week">Per 1week</option>
<option value="1ヶ月あたり" class="choose_budget_per_month">Per 1 month</option>
</select>
</div>
<div class="field_col2">
<select id="choose_budget_per_day" class="budget-price" data-label="予算を選択">
<option value="" selected="">select budget</option>
<option value="2000円以下">less than &yen;2,000</option>
<option value="2,000円~4,000円">&yen;2,000~&yen;4,000</option>
<option value="4,000円以上">more than &yen;4,000</option>
</select>
<select id="choose_budget_per_week" class="budget-price" data-label="予算を選択">
<option value="" selected="">select budget</option>
<option value="5,000円以下">less than &yen;5,000</option>
<option value="5,000円~10,000円">&yen;5,000~&yen;10,000</option>
<option value="10,000円~20,000円">&yen;10,000~&yen;20,000</option>
<option value="20,000円以上">more than &yen;20,000</option>
</select>
<select id="choose_budget_per_month" class="budget-price" data-label="予算を選択">
<option value="" selected="">select budget</option>
<option value="30,000円以下">less than &yen;30,000</option>
<option value="30,000円~50,000円">&yen;30,000~&yen;50,000</option>
<option value="50,000円以上">more than &yen;50,000</option>
</select>
</div>
</div><!--/clearfix-->
</div>
</div><!--/form-field-->
<div class="form-error"></div>
</div>
</form>
</div>

<!--search by price-->
<div class="SpaceFilters-section form-container filter-to-hide hide" id="TimeSlotDiv">
<form class="fl-form SpaceFilters-row">
<label class="SpaceFilters-rowLabel">Time slot to use<!--利用時間帯--></label>
<div class="SpaceFilters-item">
<div class="form-field">
<div class="input-container">
<span class="field-checkbox"><input type="checkbox" name="select-timeslot" value="9:00~17:00"><label class="nextcheckbox">9:00~17:00</label></span>
<span class="field-checkbox"><input type="checkbox" name="select-timeslot" value="9:00~18:00"><label class="nextcheckbox">9:00~18:00</label></span>
<span class="field-checkbox"><input type="checkbox" name="select-timeslot" value="9:00~20:00"><label class="nextcheckbox">9:00~20:00</label></span>
<span class="field-checkbox"><input type="checkbox" name="select-timeslot" value="9:00~深夜まで"><label class="nextcheckbox">9:00~深夜まで</label></span>
</div><!--/input-container-->
</div>
<div class="form-error"></div>
</div><!--/SpaceFilters-item-->
</form>
</div>

<!--search by price-->
<div class="SpaceFilters-section form-container filter-to-hide hide" id="OtherFacDiv">
<form class="fl-form SpaceFilters-row">
<label class="SpaceFilters-rowLabel">Other facilities<!--その他設備--></label>
<div class="SpaceFilters-item">
<div class="input-icon">
<div class="form-field col4_wrapper">
<div class="space-type-section-content clearfix">
<div class="input-container input-col4 iconbutton">
<div class="iconbutton-icon amenity-icon-wifi"></div>
<div class="iconbutton-name">WiFi</div>
</div><!--/icon-button-->
<div class="input-container input-col4 iconbutton">
<div class="iconbutton-icon amenity-icon-printscancopy"></div>
<div class="iconbutton-name">Print/Scan/Copy</div>
</div><!--/icon-button-->
<div class="input-container input-col4 iconbutton">
<div class="iconbutton-icon amenity-icon-projector"></div>
<div class="iconbutton-name">Projector</div>
</div><!--/icon-button-->
<div class="input-container input-col4 iconbutton">
<div class="iconbutton-icon workspace-type-icon-Training"></div>
<div class="iconbutton-name">Drink-vending machine</div>
</div><!--/icon-button-->
<div class="input-container input-col4 iconbutton">
<div class="iconbutton-icon workspace-type-icon-Training"></div>
<div class="iconbutton-name">Toilet by gender</div>
</div><!--/icon-button-->
<div class="input-container input-col4 iconbutton">
<div class="iconbutton-icon workspace-type-icon-Training"></div>
<div class="iconbutton-name">Smoking area</div>
</div><!--/icon-button-->
<div class="input-container input-col4 iconbutton">
<div class="iconbutton-icon workspace-type-icon-Training"></div>
<div class="iconbutton-name">elevetor</div>
</div><!--/icon-button-->
</div><!--/space-type-section-content-->
</div><!--/form-field-->
</div>
<div class="form-error"></div>
</div><!--/SpaceFilters-item-->
</form>
</div>


<div class="SpaceFilters-section" id="filterDiv">
<div class="SpaceFilters-row">
<div class="SpaceFilters-primaryControls">

                <button class="SpaceFilters-optionsToggle btn" id="toggle-filter-btn" data-option-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="flicon-settings-alt">
                      <path fill="#4a5362" d="M3 3h1v17H3V3z"></path>
                      <path fill="#4a5362" d="M2 5h3v3H2V5zM9 3h1v17H9V3z"></path>
                      <path fill="#4a5362" d="M8 11h3v3H8v-3zM15 3h1v17h-1V3z"></path>
                      <path fill="#4a5362" d="M14 9h3v3h-3V9zM21 3h1v17h-1V3z"></path>
                      <path fill="#4a5362" d="M20 9h3v3h-3V9z"></path>
                    </svg>

                    <span class="option-more">
                    More Options
                    </span>
                </button>
                <button id="clear-btn" class="ProjectFilters-clearButton btn">Clear Filters</button>

            </div>
       
</div><!--/row-->
</div><!--/form-container-->
</section>
<div class="result-list space-list clearfix">
<div class="list-item">
<div class="sp01"><a href="#" class="link_space">
<span class="space-label">
<span class="area-left">渋谷区<!--district name--></span>
<span class="price-right">¥<strong class="price-label">12,000<!--price--></strong>/day<!--per day or week or month--></span>
</span>
</a>
</div>
</div>
<div class="list-item">
<div class="sp01"><a href="#" class="link_space">
<span class="space-label">
<span class="area-left">渋谷区<!--district name--></span>
<span class="price-right">¥<strong class="price-label">12,000<!--price--></strong>/day<!--per day or week or month--></span>
</span>
</a>
</div>
</div>
<div class="list-item">
<div class="sp01"><a href="#" class="link_space">
<span class="space-label">
<span class="area-left">渋谷区<!--district name--></span>
<span class="price-right">¥<strong class="price-label">12,000<!--price--></strong>/day<!--per day or week or month--></span>
</span>
</a>
</div>
</div>
<div class="list-item">
<div class="sp01"><a href="#" class="link_space">
<span class="space-label">
<span class="area-left">渋谷区<!--district name--></span>
<span class="price-right">¥<strong class="price-label">12,000<!--price--></strong>/day<!--per day or week or month--></span>
</span>
</a>
</div>
</div>
<div class="list-item">
<div class="sp01"><a href="#" class="link_space">
<span class="space-label">
<span class="area-left">渋谷区<!--district name--></span>
<span class="price-right">¥<strong class="price-label">12,000<!--price--></strong>/day<!--per day or week or month--></span>
</span>
</a>
</div>
</div>
<div class="list-item">
<div class="sp01"><a href="#" class="link_space">
<span class="space-label">
<span class="area-left">渋谷区<!--district name--></span>
<span class="price-right">¥<strong class="price-label">12,000<!--price--></strong>/day<!--per day or week or month--></span>
</span>
</a>
</div>
</div>
<div class="list-item">
<div class="sp01"><a href="#" class="link_space">
<span class="space-label">
<span class="area-left">渋谷区<!--district name--></span>
<span class="price-right">¥<strong class="price-label">12,000<!--price--></strong>/day<!--per day or week or month--></span>
</span>
</a>
</div>
</div>
<div class="list-item">
<div class="sp01"><a href="#" class="link_space">
<span class="space-label">
<span class="area-left">渋谷区<!--district name--></span>
<span class="price-right">¥<strong class="price-label">12,000<!--price--></strong>/day<!--per day or week or month--></span>
</span>
</a>
</div>
</div>
</div><!--/result-list-->
<div class="SpaceFilters-section viewmore-wrapper">
<button id="viewmore-btn" class="ProjectFilters-clearButton btn">View More</button>
</div>
</div><!--/intertwined-table-->
</div><!--/myideal_page-->
</div><!--/main-container-->
<!--footer-->
<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/common_footer.php'); ?>
 @include('pages.common_footer')

<!--/footer-->
</div><!--/viewport-->
<script src="../js/address_select.js" type="text/javascript"></script>
<script src="../js/select2.full.min.js" type="text/javascript"></script>

<script>
      var $ = document.querySelector.bind(document);
      window.onload = function () {
        //Ps.initialize($('.slimScrollDiv'));
      };
    </script>

<script>
function getObjectKeyIndex(obj, keyToFind) {
    var i = 0, key;

    for (key in obj) {
        if (key == keyToFind) {
            return i;
        }

        i++;
    }

    return null;
}

jQuery(document).ready(function(){
   jQuery('#state-select').select2({
                    multiple:true
    });
  jQuery('.chosen-select').on('change', function(evt, params) {

      var returnObject = getObjectKeyIndex(params,'selected');
        if(returnObject == 0)
        {
          selectedArray.push(params.selected);
        }
        else
        {
          selectedArray.splice(selectedArray.indexOf(params.deselect),1);
        }
        
  });

    jQuery(".budget-price").addClass('hide');

    jQuery("#choose_budget_per").change(function(){

        jQuery(".budget-price").addClass('hide');
        var selected_opt_class = jQuery('option:selected', '#choose_budget_per').attr('class');

        jQuery('#'+selected_opt_class).removeClass("hide");
    });
    jQuery(".input-container.iconbutton").click(function(){
  jQuery(this).toggleClass("checked");
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
})

</script>
</body>
</html>
