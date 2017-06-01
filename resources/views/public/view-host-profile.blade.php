
<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header.php'); ?>
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
<style>
	.slimScrollDiv ol{
		padding:0px !important;
	}
</style>
<!-- <script type="text/javascript" src="<?php echo SITE_URL?>assets/js/jquery.min.js"></script> -->
<script type="text/javascript" src="<?php echo SITE_URL?>assets/js/jquery-ui.min.js"></script>
<script src="<?php echo SITE_URL?>js/datepicker-ja.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL?>assets/css/tab.css">
<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL?>assets/css/folio.css">
<!-- <script type="text/javascript" src="<?php echo SITE_URL?>assets/js/CommonJs.js"></script>  -->

<script src="{{ URL::asset('js/jquery.responsiveTabs.js') }}"></script>
<!--/head-->
<body class="profilepage host-profile common">
	<div class="viewport">
		<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header_nav_shareuser.php'); ?>
		@if(Auth::check()) @include('pages.header_nav_shareuser') @elseif(Auth::guard('user2')->check()) @include('pages.header_nav_rentuser') @else @include('pages.before_login_nav') @endif
		<div id="main" class="container">
			<section class="space-info workspace-details">
				<div class="section-inner">
					<div class="space-info-row workspace-details-row profile-components-row">
						<div class="container-fluid">
							<div class="fl-flex">
								<div class="row">
									<div class="col-md-8">
										<div class="space-main-info">
											<!--/space-title-->
											<!-- template -->
											<div class="ms-lightbox-template space-gallery">
												<!-- masterslider -->
												<div class="master-slider ms-skin-default" id="masterslider">
													<? /*echo "<pre>"; print_r(getAllSpaceImages($user->id));
echo "test";
										die;*/ ?>
													<?

													//$spaceImg= $spaces->spaceImage->all();
													$spaceImg=getAllAvailSpaceImages($user->id);
													foreach($spaceImg as $im)
													{
														?>
													<div class="ms-slide">
														<img src="{{$im->ThumbPath}}" data-src="{{$im->ThumbPath}}" alt="" />
														<img class="ms-thumb" src="{{$im->SThumbPath}}" alt="thumb" />
														<!-- <a href="/js/swipe-slider/slider-templates/lightbox/img/1.jpg" class="ms-lightbox" rel="prettyPhoto[gallery1]" title="lorem ipsum dolor sit"> lightbox </a> -->
													</div>
													<?
													}

													?>
												</div>
												<!-- end of masterslider -->
											</div>
											<!-- end of template -->
											<!--/feed-box-->
										</div>
										<!--/space-main-info-->
										<div class="container-grid">
											<div class="row">
												<div class="col-sm-6 col-lg-3">
													<div class="text-center">
														<div class="circle-outer">
															<div class="circle-grid">
																<i class="fa fa-building" aria-hidden="true"></i>
															</div>
														</div>
														<h2 class="lead">{{$spaces->count()}}</h2>
														<h5>スペース</h5>
													</div>
												</div>
												<!--.col-sm-6-->
												<div class="col-sm-6 col-lg-3">
													<div class="text-center">
														<div class="circle-outer">
															<div class="circle-grid">
																<i class="fa fa-star" aria-hidden="true"></i>
															</div>
														</div>
														<h2 class="lead">{{$fav_cnt}}</h2>
														<h5>お気に入り</h5>
													</div>
												</div>
												<!--.col-sm-6-->
												<div class="col-sm-6 col-lg-3">
													<div class="text-center">
														<div class="circle-outer">
															<div class="circle-grid">
																<i class="fa fa-comment" aria-hidden="true"></i>
															</div>
														</div>
														<h2 class="lead">{{count($allReviews)}}</h2>
														<h5>レビュー</h5>
													</div>
												</div>
												<!--.col-sm-6-->
												<div class="col-sm-6 col-lg-3">
													<div class="text-center">
														<div class="circle-outer">
															<div class="circle-grid">
																<i class="fa fa-user" aria-hidden="true"></i>
															</div>
														</div>
														<h2 class="lead">{{calculateUserProfilePercent($user, 1)}}%</h2>
														<h5>プロフィール</h5>
													</div>
												</div>
												<!--.col-sm-6-->
											</div>
										</div>
									</div>
									<div class="col-md-4">
										<div class="space-side-info">
											<div class="space-side-detail feed-box">
												<div class="top-pad-inner">
													<div class="clander-block clearfix">
														<div class="wlp-general-gray-box-inner">
															<div class="user1-pic">
																<img src="{{getUser1Photo($user)}}" class="img-responsive img-circle animated zoomIn">
															</div>
															<!--show company name-->
															<div class="host-name">{{$user->NameOfCompany}}</div>
															<!--/end company name-->
															<div class="host-addr">{{$user->Prefecture}},{{$user->District}},{{$user->PostalCode}},{{$user->Address1}},{{$user->Address2}}</div>
															<!--start rating-->
															<?php 
									echo showStarReview($user->reviews, true);?>
															<!--/end rating-->
														</div>
														<?php if (!Auth::guard('user1')->check()) {?>
														<div class="">
															<div class="wlp-general-gray-box-inner">
																<button id="chat-btn" onclick="location.href='/RentUser/Dashboard/Message/{{$user->HashCode}}'" class="btn ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" data-bind="click: SendMessageViewModel.showDialog" role="button" aria-disabled="false">
																	<span class="ui-button-text">
																		<i class="icon-offispo-icon-06 awesome-icon"></i>
																		メッセージを送る
																	</span>
																</button>
																<!--/space-action-btn-->
															</div>
														</div>
														<?php }?>
													</div>
													<!--/clander-block-->
												</div>
												<!--/top-pad-inner-->
												<div class="basic-detail-table">
													<table class="basic-detail-list style_basic">
														<tbody>
															<tr>
																<th>事業内容</th>
																<td>{{$user->BussinessCategory}}</td>
															</tr>
															<tr>
																<th>従業員数</th>
																<td>@if( !empty($user->NumberOfEmployee) ) {{$user->NumberOfEmployee}} @else - @endif</td>
															</tr>
                                                            <tr>
																<th colspan="2" class="col2">出会いたい人材</th>
															</tr>
                                                            <tr class="need_person">
																<th>性別</th>
																<td><!--show sex--></td>
															</tr>
                                                            <tr class="need_person">
																<th>年齢</th>
																<td><!--show age--></td>
															</tr>
															<tr class="need_person">
																<th>事業タイプ</th>
																<td>{{$user->BusinessKindWelcome}}</td>
															</tr>
															<tr class="need_person">
																<th>スキル</th>
																<td>{{$user->Skills}}</td>
															</tr>
														</tbody>
													</table>
												</div>
												<!--/basic-detail-table-->
											</div>
											<!--/space-side-detail-->
										</div>
										<!--/space-side-info-->
									</div>
								</div>
							</div>
						</div>
						<!--/container-fluid-->
					</div>
					<!--/space-info-row-->
				</div>
				<!--/section-inner-->
				<div class="bg-wht">
					<div class="section-inner">
						<div class="space-info-row workspace-details-row profile-components-row">
							<div class="column-spacelist space-list clearfix">
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
						<?php if(!empty($groupedSpaces)){ ?>
								<div id="spacetabs_wraper" class="tab_style2" style="opacity: 0">
									<ul id="spacetabs_horizontal">
										@foreach($groupedSpaces as $spaceType => $groupedSpace)
										<li>
											<a href="#tab-{{$spaceType}}">{{$feeTypeArray[$spaceType]}}</a>
										</li>
										@endforeach
									</ul>
									@foreach ($groupedSpaces as $spaceType => $groupedSpace)
									<div id="tab-{{$spaceType}}" class="spacehorizontal_wraper">
										@foreach ($groupedSpace as $index => $space)
										<div class="list-item">
											<div class="sp01" style="background-image:url({{getSpacePhoto($space)}})">
												<a target="_blank" href="{{getSpaceUrl($space->HashID)}}" class="link_space">
													<span class="area">
														{{$space->District}}
														<!--district name-->
													</span>
													<span class="space-label befhov">
														<div class="clearfix">
															<div class="label-left">
																<span class="type">{{ str_limit($space->Title, 26, '...') }}</span>
																<span class="capacity">~{{$space->Capacity}}名</span>
															</div>
															<div class="label-right">
																<span class="price">
																	<?php echo getPrice($space, true)?>
																</span>
															</div>
														</div>
													</span>
													<span class="space-label onhov">
														<div class="clearfix">
															<h3 class="sp-title">{{ str_limit($space->Title, 26, '...') }}</h3>
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
									@endforeach
								</div>
								<? } ?>
							</div>
						</div>
						<!--/space-info-row-->
					</div>
					<!--/section-inner-->
				</div>
				<div class="section-inner">
					<div class="space-info-row workspace-details-row profile-components-row">
						<div class="profile-components-main full-width-components">
							<div class="profile-reviews feed-box" id="profile-reviews">
								<h2 class="section-title">
									最新レビュー
								</h2>
								<ul class="user-reviews ng-scope">
									<!--loop review-->
									<?php if (count($allReviews) == 0) {?>
										<li>まだレビューはありません。</li>
									<?php }?>
									
									@foreach ($allReviews as $reviewIndex => $review)
									<li class="user-review ng-scope <?php if ($reviewIndex >= LIMIT_REVIEWS) echo 'hide'?>" itemprop="reviewRating" itemscope="">
										<img ng-src="{{getUser2Photo($review->user2->HashCode)}}" class="user-review-avatar" alt="User Photo" src="{{getUser2Photo($review->user2->HashCode)}}">
										<div class="review-contents">
											<a class="user-review-title ng-binding" href="#">{{$review->space->Title}}</a>
											<?php echo showStarReview($review, true)?>
											<?php if ($review->Comment) {?>
											<p itemprop="description">
												“
												<span ng-bind="review.get().description" class="ng-binding">{{$review->Comment}}</span>
												”
											</p>
											<?php }?>
											<span class="user-review-details ng-binding">
												<a href="{{getUser2ProfileUrl($review->user2)}}">
													<span class="user-review-name ng-binding">{{getUserName($review->user2)}}</span>
												</a>
												<?php \Carbon\Carbon::setLocale('ja'); ?>
												<span class="thedate">{{$review->created_at->diffForHumans()}}</span>
											</span>
											<ul class="user-rating-info">
												<li class="place ng-scope">
													<a href="#">
														<span class="user-rating-info-item ng-binding">
															<i class="fa fa-map-marker" aria-hidden="true"></i>
															{{$review->space->Prefecture}} {{$review->space->District}}
														</span>
													</a>
												</li>
												<!-- end place that rating user has office at -->
												<li class="space-type ng-scope">
													<a href="#">
														<span class="user-rating-info-item ng-binding">
															<i class="fa fa-building" aria-hidden="true"></i>
															{{$review->space->Type}}
														</span>
													</a>
												</li>
												<!-- end space type -->
												<li class="space-price ng-scope">
													<a href="#">
														<span class="user-rating-info-item ng-binding">
															<i class="fa fa-jpy" aria-hidden="true"></i>
															<?php echo priceConvert($review['booking']['amount'])?>
														</span>
													</a>
												</li>
												<!-- end space price type -->
											</ul>
										</div>
									</li>
									@endforeach
									<!--/loop review-->
								</ul>
								<button id="view_more_reviews_btn" style="<?php if (count($allReviews) < LIMIT_REVIEWS ) echo 'display: none;'?>" class="profile-widget-expand signup-modal-trigger ng-scope" data-qtsb-label="view_more">レビューを全て見る</button>
							</div>
							<!--/#profile-reviews-->
						</div>
						<!--/profile-components-main-->
					</div>
					<!--/row-->
				</div>
				<!--/section-inner-->
			</section>
		</div>
		<!--footer-->
		<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/common_footer.php'); ?>
		@include('pages.common_footer')
		<!--/footer-->
	</div>
	<!--/viewport-->
	<script type="text/javascript">    
        jQuery(function () {    
        
            var slider = new MasterSlider();

            slider.control('arrows');   
            slider.control('lightbox'); 
            slider.control('thumblist' , {autohide:false ,dir:'h',align:'bottom', width:130, height:85, margin:1, space:1 , hideUnder:400});

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
					/*$(".tbs").each( function(){
						$(this).removeClass("xpp-spaces-tab-handler-selected");
					});*/
					$(this).siblings().removeClass("xpp-spaces-tab-handler-selected");
					$(this).addClass("xpp-spaces-tab-handler-selected");
					
					var id = $(this).attr("data-tbs");
					
					$(".xsection-content").fadeOut();
					$("#" + id).fadeIn();
					
			  });
			  
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
	<!--end master slider-->
	<!--<script class="rs-file" src="js/assets/royalslider/jquery-1.8.3.min.js"></script>-->
	<!-- <script>
        jQuery(function () {
            jQuery('.fade').mosaic({
                animation : 'fade'
            });
        });
    </script> -->
	<!-- syntax highlighter -->
	<script> hljs.initHighlightingOnLoad();</script>
	<!--start master slider-->
	<!-- bootstrap style sheet -->
	<!-- <script>
        jQuery(function () {
            jQuery('.ajax-popup-link').magnificPopup({
                type: 'ajax'
            });
        });
    </script> -->
	<!-- bootstrap style sheet -->
	<script>
		jQuery(document).ready(function ($) {
			 $('#pop a').magnificPopup({
				  type: 'ajax',
				  closeOnContentClick: false,
				  closeBtnInside: true
			 });
			 $('body').on("click","#continueBtn", function(){
				 $('body').find("#pop-bone").hide();
				 $('body').find("#pop-btwo").show();
			 });
			 $('body').on("click","#backBtn", function(){
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
	<!-- <script type="text/javascript" src="<?php echo SITE_URL?>assets/js/GlobalScripts.js"></script>
   <script type="text/javascript" src="<?php echo SITE_URL?>assets/js/ConditionalValidator.js"></script> -->
	<script type="text/javascript" src="<?php echo SITE_URL?>assets/js/fromJS.js"></script>
	<script type="text/javascript" src="<?php echo SITE_URL?>assets/js/pageCommon.js"></script>
	<script type="text/javascript">
   jQuery(document).ready(function ($) {
      /*wlpViewModel = new WLP.ViewModel({
         VenueId: "9504f64f-db18-4806-a278-dd3c3a0b52b3",
         VenueFormat: 1,
         UserIsFollowing: false,
         SendMessageViewModel: {"FullName":null,"Email":null,"PhoneNumber":null,"Message":null,"VenueId":"9504f64f-db18-4806-a278-dd3c3a0b52b3","Password":null,"DefaultMessage":"I would like to find out more about New York Technology Company - Midtown NYC","WorkspaceId":"8feeb889-6059-4946-870d-a56521631ce9"},
         Workspaces: [{"Id":"7165c00c-ddf0-4f32-844a-f5e7e6d1a7c5","BookItButtonState":"visible","ReservationMethod":0,"WorkspaceSlugUrl":"#"},{"Id":"9d674049-69e4-4592-b499-2a61b50c8440","BookItButtonState":"visible","ReservationMethod":2,"WorkspaceSlugUrl":"#"}],

         Workspace: {"IsFloorSpaceVisible":true,"FloorSpace":300.0,"NRatings":0,"AverageRating":0.0,"IsEnterpriseInternalVenue":false,"Name":"Bullpen Monthly Space","LikeItCount":0,"VenueName":null,"VenueAddress":"265 West 37th Street, Floor 12A, New York, NY, 10018","WorkspaceSlugUrl":"/US/NY/new-york/new-york-technology/nytech-team-office-monthly","WorkspaceSlugUrlWithHost":"https://liquidspace.com/US/NY/new-york/new-york-technology/nytech-team-office-monthly","LaunchedReservationTypeStatus":1,"VisaImageUrl":null,"VisaImageStringStatus":"","BookItButtonState":"visible","Booked":false,"IsLazyLoadImages":true,"DisplayApprovedMessage":false,"NeedToDoRequest":true,"IsInquiryOnly":true,"IsEventSpace":false,"WorkspacePrice":"$2000/month","Longitude":-73.99175,"Latitude":40.75419,"ShowReviewsLink":false,"VenueStatus":5,"EarliestAvailableTime":null,"ImageUrl":"https://lsprodpicture.azureedge.net/Index/a323cf50-69a2-4fa3-bf70-074d8eeab935?emptyImageUrl=https:%2f%2flsprodcontent.azureedge.net%2fImages%2fworkspace-photo-not-available.png%3fv%3d1108530169&etag=jAcGuH1tngxV0k6ZpkI0UQ==&maxWidth=320&maxHeight=200&crop=true","ImageId":"a323cf50-69a2-4fa3-bf70-074d8eeab935","Order":0,"ShortDescription":"Tech entrepreneurs and small teams alike love this space! Ideal for the techie consultant or a small team of 2, the LaunchPad is bright, spacious & tricked out with videoconferencing/tech gadgets. Small teams and/or individual workers will have a dedicated desk. Feel free to move the furniture (included) around to best stimulate your creativity!","FormattedShortDescription":"Tech entrepreneurs and small teams alike love this space! Ideal for the techie consultant or a small team of 2, the LaunchPad is bright, spacious & tricked out with videoconferencing/tech gadgets. Small teams and/or individual workers will have a dedicated desk. Feel free to move the furniture (included) around to best stimulate your creativity!","Days":[],"AvailabilityWormClassList":["closed-closed","closed-closed","closed-closed","closed-closed","closed-closed","closed-closed","closed-closed","closed-closed","closed-closed","closed-closed","closed-closed","closed-closed","closed-closed","closed-closed","closed-closed","closed-closed","closed-closed","closed-closed","closed-closed","closed-closed","closed-closed","closed-closed","closed-closed","closed-closed"],"NextAvailabilityWormClassList":{"2016-08-09T00:00:00":["available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available"],"2016-08-10T00:00:00":["available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available"],"2016-08-11T00:00:00":["available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available"],"2016-08-12T00:00:00":["available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available","available-available"]},"WorkspaceScenarios":[{"Id":"14c2572b-aa1a-4fbc-b0e8-364180f8b34d","DisplayName":"Team Office","Description":"Team Office","LongDescription":"Team Office","OnByDefault":true,"AttendeeCountConstant":null,"WorkspaceType":true,"SortOrder":7,"SearchDisplayType":50}],"ParkingInfo":null,"NextAvailableReservationTime":null,"MinimumBookingWindow":0,"MinimumBookingLength":43200,"MaximumBookingWindow":0,"UnavailableAfterDays":0,"RenewalWindow":0,"VenueTimeZoneId":"Eastern Standard Time","ReservationMethod":2,"Resources":[{"Id":"97e1242e-a305-4792-a759-02618c9dbbd0","ResourceId":"75469df5-b1e1-472e-911b-36f2642c79bb","Name":"Catering","Description":"Arrangement's need to be made 24-48 hours in advance.  ","Instructions":"There are many options/restaurants in the neighborhood that provide catering.  For recommendations please email info@nytechco.com","NameSuffix":" ($)","Requestable":true,"Included":false,"IsSelected":false,"IsEnabled":true,"ImageId":"4bff15d0-537f-42b4-97ba-62958cd0ef0e"},{"Id":"cf503efd-4e6c-434c-bb4f-3b2a83e066a7","ResourceId":"6d63013d-a967-4793-a7ce-81b44558e9ec","Name":"Filtered Water","Description":null,"Instructions":null,"NameSuffix":"","Requestable":false,"Included":true,"IsSelected":false,"IsEnabled":true,"ImageId":"4484a475-c3ce-45c6-a6e2-c9d627819742"},{"Id":"61895977-ef08-4321-89e1-09682d805c5b","ResourceId":"6fa8d14a-1362-4142-a190-ebe1310979af","Name":"Phone","Description":null,"Instructions":null,"NameSuffix":"","Requestable":false,"Included":true,"IsSelected":false,"IsEnabled":true,"ImageId":"04263807-cb48-4ae2-b754-860f0359ed04"},{"Id":"29f299ff-b415-4339-8349-1d6a90d0f138","ResourceId":"ab04a7db-1129-40bf-a350-c5a50760c395","Name":"TV/Monitor","Description":null,"Instructions":null,"NameSuffix":"","Requestable":false,"Included":true,"IsSelected":false,"IsEnabled":true,"ImageId":"32012080-b48b-4dfb-b0a8-219eacbe4e49"},{"Id":"95a0ee12-9b7b-49f5-bf90-de4e5263e7ed","ResourceId":"bc1a689b-a9b9-4eb3-bbc9-6836d777fa81","Name":"Video Conference","Description":null,"Instructions":null,"NameSuffix":"","Requestable":false,"Included":true,"IsSelected":false,"IsEnabled":true,"ImageId":"7a97d2a6-0ede-41ee-a7e8-50e0a37855de"},{"Id":"8c4c8175-632e-457b-9a2d-d523df301b20","ResourceId":"db4610d1-16d0-4f79-b00f-a4afeeed15c8","Name":"WiFi","Description":"WiFi","Instructions":null,"NameSuffix":"","Requestable":false,"Included":true,"IsSelected":false,"IsEnabled":true,"ImageId":"703eec45-624d-483f-bd99-4f6b46c99fc9"},{"Id":"b634fc12-4ba3-4282-bef6-53e69e81616d","ResourceId":"2ad5ad6e-5626-438b-820c-e5c5fd7122d9","Name":"Wired Internet","Description":null,"Instructions":null,"NameSuffix":"","Requestable":true,"Included":false,"IsSelected":false,"IsEnabled":true,"ImageId":"c9514000-8fe6-468f-9941-ef51b5aed74d"}],"ResourcesStr":"<span class='amenity-item amenities-other' title='WiFi'>WiFi,</span><span class='amenity-item ' title=''>Wired Internet,</span><span class='amenity-item amenities-other' title='Arrangement&apos;s need to be made 24-48 hours in advance.  '>Catering ($),</span><span class='amenity-item ' title=''>Phone,</span><span class='amenity-item ' title=''>TV/Monitor,</span><span class='amenity-item ' title=''>Video Conference,</span><span class='amenity-item ' title=''>Filtered Water</span>","Capacity":6,"ImageAlt":"New York Technology Company - Midtown NYC - Bullpen Monthly Space","ShowDetailedLegend":false,"HideLegend":false,"Index":0,"ShowNewFlag":false,"VenueId":"9504f64f-db18-4806-a278-dd3c3a0b52b3","Id":"8feeb889-6059-4946-870d-a56521631ce9","HidePrices":false,"PriceAsText":null,"Prices":{"Month":{"DurationType":43200,"Amount":2000.00,"AmountStr":"$2,000/month","AmountStrPriceAdditionalDescription":"1 month term","AmountFormatted":"$2,000","CurrencySuffix":"","CurrencyPrefix":"$","Description":"/month","DurationMinutes":43200,"IsFullDay":false,"Hidden":false}},"AdditionalPrices":[],"DefinedPrices":[{"Id":"941a76be-89f7-4590-b9f4-d13dcc838e82","_Old_Amount":0.0,"QuantityOfMinutes":43200,"Description":"/month","Deleted":false,"WorkspaceId":"8feeb889-6059-4946-870d-a56521631ce9","CultureId":null,"IsFullDay":false,"Amount":2000.0000000000000000000000002,"IsPeriodPrice":true,"ChangeDate":null,"ValidFrom":null,"ValidTo":null}],"HideAdditionalPrices":false,"ShowRatedPriceInfoFlag":true,"HideAdditionalPricesComma":false,"ShowRatedPriceInfo":false,"ShowAllPrices":false,"PriceAmount":"$2,000","PriceDescription":"/month","PricesString":"$2,000/month","Favorited":false},
         Images: [{"NavigationUrl":null,"ImageUrl":"https://lsprodpicture.azureedge.net/Index/a323cf50-69a2-4fa3-bf70-074d8eeab935?emptyImageUrl=https:%2f%2flsprodcontent.azureedge.net%2fImages%2fliquid-holder.jpg%3fv%3d-73115844&etag=jAcGuH1tngxV0k6ZpkI0UQ==","Description":null,"Name":null,"ImageId":"a323cf50-69a2-4fa3-bf70-074d8eeab935","Title":null,"Caption":null,"Etag":null,"Tag":null,"ImageOriginalUrl":"https://lsprodpicture.azureedge.net/Index/f4bd7e19-ee5b-46a3-be20-fb58cb78a39d?emptyImageUrl=https:%2f%2flsprodcontent.azureedge.net%2fImages%2fliquid-holder.jpg%3fv%3d-73115844&etag=jAcGuH1tngxV0k6ZpkI0UQ=="},{"NavigationUrl":null,"ImageUrl":"https://lsprodpicture.azureedge.net/Index/d452dfcf-0565-4bed-8b28-b00728f7d9b2?emptyImageUrl=https:%2f%2flsprodcontent.azureedge.net%2fImages%2fliquid-holder.jpg%3fv%3d-73115844&etag=UQq3/F7rCQMQykzimN2r9w==","Description":null,"Name":null,"ImageId":"d452dfcf-0565-4bed-8b28-b00728f7d9b2","Title":null,"Caption":"","Etag":null,"Tag":null,"ImageOriginalUrl":"https://lsprodpicture.azureedge.net/Index/1ba49025-a2f5-42bb-8492-ccd96c106c91?emptyImageUrl=https:%2f%2flsprodcontent.azureedge.net%2fImages%2fliquid-holder.jpg%3fv%3d-73115844&etag=UQq3/F7rCQMQykzimN2r9w=="},{"NavigationUrl":null,"ImageUrl":"https://lsprodpicture.azureedge.net/Index/b25c436e-5a65-40b4-8402-5de03a76e2c3?emptyImageUrl=https:%2f%2flsprodcontent.azureedge.net%2fImages%2fliquid-holder.jpg%3fv%3d-73115844&etag=x+34wRZ57XM0J/A3LNCC1Q==","Description":null,"Name":null,"ImageId":"b25c436e-5a65-40b4-8402-5de03a76e2c3","Title":null,"Caption":"Entrance ","Etag":null,"Tag":null,"ImageOriginalUrl":"https://lsprodpicture.azureedge.net/Index/fe4087ae-b18a-4cd9-ae2e-3cbbc6a8d482?emptyImageUrl=https:%2f%2flsprodcontent.azureedge.net%2fImages%2fliquid-holder.jpg%3fv%3d-73115844&etag=x+34wRZ57XM0J/A3LNCC1Q=="},{"NavigationUrl":null,"ImageUrl":"https://lsprodpicture.azureedge.net/Index/3d956bca-9789-47b6-90b0-a0ac6fdf1469?emptyImageUrl=https:%2f%2flsprodcontent.azureedge.net%2fImages%2fliquid-holder.jpg%3fv%3d-73115844&etag=w5i9POhTlzKGHIe/c5zpbw==","Description":null,"Name":null,"ImageId":"3d956bca-9789-47b6-90b0-a0ac6fdf1469","Title":null,"Caption":"Lobby","Etag":null,"Tag":null,"ImageOriginalUrl":"https://lsprodpicture.azureedge.net/Index/2addbdb9-d849-47d9-bb55-082777bf7c39?emptyImageUrl=https:%2f%2flsprodcontent.azureedge.net%2fImages%2fliquid-holder.jpg%3fv%3d-73115844&etag=w5i9POhTlzKGHIe/c5zpbw=="},{"NavigationUrl":null,"ImageUrl":"https://lsprodpicture.azureedge.net/Index/f8c18b3d-9c2f-4bc5-bb68-fb98687301f7?emptyImageUrl=https:%2f%2flsprodcontent.azureedge.net%2fImages%2fliquid-holder.jpg%3fv%3d-73115844&etag=2mclfYPFitf8hI6pTS0M2w==","Description":null,"Name":null,"ImageId":"f8c18b3d-9c2f-4bc5-bb68-fb98687301f7","Title":null,"Caption":"","Etag":null,"Tag":null,"ImageOriginalUrl":"https://lsprodpicture.azureedge.net/Index/1b3f8584-2d06-4d25-9733-df4f168d98f4?emptyImageUrl=https:%2f%2flsprodcontent.azureedge.net%2fImages%2fliquid-holder.jpg%3fv%3d-73115844&etag=2mclfYPFitf8hI6pTS0M2w=="},{"NavigationUrl":null,"ImageUrl":"https://lsprodpicture.azureedge.net/Index/716f7289-4397-444c-a2d9-89fe4e46ad9a?emptyImageUrl=https:%2f%2flsprodcontent.azureedge.net%2fImages%2fliquid-holder.jpg%3fv%3d-73115844&etag=bfL5F76h6xD7O7+9Y/y4yQ==","Description":null,"Name":null,"ImageId":"716f7289-4397-444c-a2d9-89fe4e46ad9a","Title":null,"Caption":"Reception Area","Etag":null,"Tag":null,"ImageOriginalUrl":"https://lsprodpicture.azureedge.net/Index/28961145-00e6-4a64-b172-d5493921ad69?emptyImageUrl=https:%2f%2flsprodcontent.azureedge.net%2fImages%2fliquid-holder.jpg%3fv%3d-73115844&etag=bfL5F76h6xD7O7+9Y/y4yQ=="}],
         SearchFilter: {"ReservationLengthMinutes":43200,"StartTime":"2016-08-09T00:00:00","ReservationStart":null,"Amenities":null,"WorkspaceCapacity":null},
         VenueNowDate: "2016-08-08T00:00:00",
         NextBusinessDay: "2016-08-09T00:00:00",
         VisaState: null,
         WorkspaceBookedByMember: false,
         OtherFavoritesCount: 11
      });
      ko.applyBindings(wlpViewModel, document.getElementById('xwrapper'));

      var $xwrapper = $('.xwrapper');
      var timeoutHandler = null;
      $(document).on('ready scroll resize', function() {
         clearTimeout(timeoutHandler);
         timeoutHandler = setTimeout(function() {
            var $xppButtonsWrapper = $('.wlp-general-gray-box');
            if ($xppButtonsWrapper.offset().top + $xppButtonsWrapper.height() > $(document).scrollTop()) {
               $xwrapper.removeClass('xpp-buttons-wrapper-out-of-screen');
            } else {
               $xwrapper.addClass('xpp-buttons-wrapper-out-of-screen');
            }
         }, 100);
      });
 
      $('img.lazy-load').each(function (index, value) {
         var $elem = $(value);
         $elem.attr("src", $elem.data("src"));
         $elem.removeClass('lazy-load');
      });

      var calcImage = function() {
         var $wrapper = $('.wlp-big-image');
         var $scroller = $('.wlp-big-image-scroller');
         var $image = $('.main-image');

         //offset calculation magic
         var top = ($wrapper.height() - $scroller.height()) / 2;
         var left = $scroller.offset().left - $image.position().left - ($image.width() - $(window).width()) / 2;
         $scroller.css('margin-top', top + 'px');
         $scroller.css('margin-left', left + 'px');
         $('.wlp-image-blocker').css('top', - top + 'px');
      };
      $('.wlp-big-image-scroller').imagesLoaded( function() {
         calcImage();
      });
      $('.wlp-big-image-scroller').css('visibility', 'visible');
      $(window).resize(calcImage);
      wlpViewModel.selectedImageIndex.subscribe(function(){
         calcImage();
      });
*/
      $("body").click(function(){
         $(".prices-popup").hide();
      });

      $(".prices-popup").click(function(e){
         e.stopPropagation();
      });

      $(".see-rates").click(function(e){
         e.stopPropagation();
         $('.prices-popup').toggle();
      });

	  $('body').on('click', '#view_more_reviews_btn', function(){
		  $('li.user-review').removeClass('hide');
		  $(this).hide();
	  })
   });
   </script>
</body>
</html>
