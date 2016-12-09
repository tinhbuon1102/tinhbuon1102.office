
<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header.php'); ?>
 @include('pages.header')
<!--/head-->
<body class="profilepage rentuser-profile">
	<div class="viewport">
		<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header_nav_rentuser.php'); ?>
				 @if(Auth::check())
			@include('pages.header_nav_shareuser')
		@elseif(Auth::guard('user2')->check())
			@include('pages.header_nav_rentuser')
		@endif
		<div id="main" class="container">
			<div class="profile-cover-wrapper ng-isolate-scope">
				<div class="profile-cover-mask"></div>
				<!--/mask-->
			</div>
			<!--/profile-cover-wrapper-->
			<section class="profile-info">
				<div class="section-inner">
					<div class="profile-info-row">
						<div class="profile-info-inner" id="sticky-start">
							<div class="profile-info-card">
								<section class="profile-avatar">
									<figure class="profile-image">
										<div id="profile-pic-div" class="ImageUploader" data-target="profile-image-uploader">
											<div class="ImageThumbnail ImageUploader-previousImageWrapper">
												<div id="previous-image" class="ImageThumbnail-image ImageUploader-image" style="background-size:100% !important;<?php if(!empty($user->Logo)){ ?>background:url('{{$user->Logo}}')<? }else{ ?>background: url(images/man-avatar.png) no-repeat center  center/cover;<? } ?>" alt=""></div>
											</div>
											<div class="ImageUploader-newImageWrapper">
												<div class="ImageThumbnail-image ImageUploader-image">
													<div id="profile_img_cnter_id">
														<img id="profile_img_id" class="hide">
													</div>
												</div>
											</div>
										</div>
									</figure>
									<div class="basic-user-info-wrapper">
										<ul class="basic-user-info">
											<li class="locate">
												<span class="fa fa-map-marker awesome-icon">{{$user->Prefecture}},&nbsp;{{$user->City}}</span>
											</li>
											<li class="sex">
												<!--if male-->
												<span class="fa fa-mars awesome-icon">{{$user->Sex}}</span>
												<!--if female--<span class="fa fa-female awesome-icon">女性</span>-->
											</li>
											<li class="age">
												<span class="fa fa-user awesome-icon">
												<?php
												  $age = (date("md", date("U", mktime(0, 0, 0, $user->BirthMonth, $user->BirthDay, $user->BirthYear))) > date("md")
													? ((date("Y") - $user->BirthYear) - 1)
													: (date("Y") - $user->BirthYear));
												  echo $age;
												?>
												歳</span>
											</li>
										</ul>
									</div>
									<div class="profile-verified">
										<ul class="verified-list">
											<li class="is-verified verified-item verified-payment">
												<span class="Icon">
													<i class="fa fa-credit-card" aria-hidden="true"></i>
												</span>
											</li>
											<li class="verified-item verified-indentify">
												<span class="Icon">
													<i class="fa fa fa-user" aria-hidden="true"></i>
												</span>
											</li>
											<li class="is-verified verified-item verified-phone">
												<span class="Icon">
													<i class="fa fa fa-phone" aria-hidden="true"></i>
												</span>
											</li>
											<li class="is-verified verified-item verified-email">
												<span class="Icon">
													<i class="fa fa fa-envelope" aria-hidden="true"></i>
												</span>
											</li>
										</ul>
									</div>
								</section>
								<section class="profile-about">
									<div class="profile-intro-username edit-widget is-editable ng-isolate-scope">
										<div ng-hide="isActive">{{$user->LastName}}&nbsp;{{$user->FirstName}}</div>
										<!--name-->
										<span class="kana-name">{{$user->LastNameKana}}&nbsp;{{$user->FirstNameKana}}</span>
										<!--kana name-->
									</div>
									<div data-qtsb-section="about">
										<div id="profile-about-description-wrapper" class="profile-about-description-wrapper">
											<div class="job">
												<!--label-->
												<span class="job-label">職種：</span>
												<!--/label-->
												イラストレーター、グラフィックデザイナー
											</div>
											<!--job-->
											<div class="edit-widget is-editable ng-isolate-scope is-invalid">
												<p ng-hide="isActive" class="profile-about-description ng-binding ng-scope">
													{{$user->BusinessSummary}}
												</p>
											</div>
											<!--/edit-widget-->
											<div class="skills">
												<p class="skill-label">スキル：</p>
												<ul class="skill-list withstar" id="SkillList">
												</ul>
											</div>
											<!--/skills-->
										</div>
									</div>
								</section>
								<!--end of about-->
								<section class="profile-statistics">
									<div class="top-pad-inner">
									@if($me=="False")
										<div class="profile-btn">
											<div class="offer-btn">
												<a class="btn btn-large">
													<span class="fa fa-paper-plane-o awesome-icon">オファーする</span>
												</a>
											</div>
											<div class="chat-btn">
												<a class="btn btn-large is_allowed" href="/ShareUser/Dashboard/Message/{{$user->HashCode}}">
													<span class="icon-offispo-icon-06 awesome-icon">チャットする</span>
												</a>
												<!--if not allowed chat--<span class="btn btn-large is_not_allowed"><span class="icon-offispo-icon-06 awesome-icon">チャットする</span></span>-->
											</div>
										</div>
									@endif	
										<!--/profile-btn-->
										<div class="Rating Rating--labeled profile-user-rating" data-star_rating="5.0">
											<span class="Rating-total">
												<span class="Rating-progress"></span>
											</span>
											<span class="Rating-review">40 reviews</span>
										</div>
									</div>
									<ul class="item-stats" ng-show="profile.user.role === 'freelancer'">
										<li class="is-good">
											<span class="item-stats-name">清潔さ</span>
											<span class="item-stats-value">100%</span>
										</li>
										<li class="is-good">
											<span class="item-stats-name">礼儀正しさ</span>
											<span class="item-stats-value">100%</span>
										</li>
										<li class="is-good">
											<span class="item-stats-name">時間通り</span>
											<span class="item-stats-value">100%</span>
										</li>
										<li class="is-good">
											<span class="item-stats-name">再利用率</span>
											<span class="item-stats-value">43%</span>
										</li>
									</ul>
								</section>
								<!--end of profile-statics-->
							</div>
						</div>
					</div>
				</div>
			</section>
			<!--end of profile section-->
			<section class="profile-user-requirement">
				<div class="section-inner">
					<div class="profile-requirement-row">
						<div class="profile-require-main">
							<div class="profile-require-basic js-matchHeight feed-box" id="basic-requirement">
								<h2 class="section-title">利用希望ワークスペース</h2>
								<div class="require-table-box">
									<div class="require-table-box-row">
										<div class="col_half left">
											<table class="require-list style_basic">
												<tbody>
                                                <tr>
														<th>スペースタイプ</th>
														<td>{{$space->SpaceType}}</td>
													</tr>
													<tr>
														<th>希望地域</th>
														<td>{{$space->DesireLocationPrefecture}},&nbsp;{{$space->DesireLocationDistrict}},&nbsp;{{$space->DesireLocationTown}}</td>
													</tr>
													<tr>
														<th>希望利用料</th>
														<td>{{$space->BudgetType}}</td>
													</tr>
													<tr>
														<th>利用時間帯</th>
														<td>{{$space->TimeSlot}}</td>
													</tr>
													
													<tr>
														<th>利用人数</th>
														<td>{{$space->NumberOfPeople}}人</td>
													</tr>
                                                    
												</tbody>
											</table>
										</div>
										<!--/half-->
										<div class="col_half right">
											<table class="require-list style_basic">
												<tbody>
                                                <tr>
														<th>スペース面積</th>
														<td>{{$space->SpaceArea}}</td>
													</tr>
													<tr>
														<th>会議室利用</th>
														<td>{{$space->MeetingRoom}}</td>
													</tr>
													<tr>
														<th>利用頻度</th>
														<td>{{$space->UsageFrequency}}</td>
													</tr>
													<tr>
														<th>希望職場事業</th>
														<td>{{$space->BusinessType}}</td>
													</tr>
													<tr>
														<th>希望職場人数</th>
														<td>{{$space->WorkPlaceNumberOfPeople}}</td>
													</tr>
													
												</tbody>
											</table>
										</div>
										<!--/half-->
									</div>
									<!--/table-box-->
									<div class="require-note clearfix">
										<table class="require-list style_basic">
											<tbody>
												<tr>
													<th>備考</th>
													<td>{{$space->Notes}}</td>
												</tr>
											</tbody>
										</table>
									</div>
									<!--require-note-->
								</div>
							</div>
							<!--/profile-require-basic-->
						</div>
						<!--/profile-require-main-->
						<div class="profile-requirement-side">
							<div class="profile-side-requirement js-matchHeight feed-box">
								<h2 class="section-title">その他希望設備</h2>
								<div class="require-table-box facility-require">
									<table class="require-list facility-require-list style_basic">
										<tbody>
											<tr>
												<th>デスク</th>
												<td>
													<strong>{{$space->NumOfDesk}}</strong>
													<!--unit-->
													台
													<!--/unit-->
												</td>
											</tr>
											<tr>
												<th>イス</th>
												<td>
													<strong>{{$space->NumOfChair}}</strong>
													<!--unit-->
													台
													<!--/unit-->
												</td>
											</tr>
											<tr>
												<th>ボード</th>
												<td>
													<strong>{{$space->NumOfBoard}}</strong>
													<!--unit-->
													台
													<!--/unit-->
												</td>
											</tr>
											<tr>
												<th>複数人用デスク&amp;イス</th>
												<td>
													<strong>{{$space->NumOfLargeDesk}}</strong>
													<!--unit-->
													台
													<!--/unit-->
												</td>
											</tr>
											<tr class="other-facilities">
												<th colspan="2">その他設備</th>
											</tr>
											<tr class="other-facilities">
												<td colspan="2">{{$space->OtherFacility}}</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<!--/row-->
				</div>
				<!--/section-inner-->
			</section>
			<section class="profile-portfolio-section" id="profile-portfolio">
				<div class="section-inner">
					<div class="profile-portfolio-wrapper">
						<h2>
							Taro
							<!--first name-->
							's Work
							<span class="ja">実績一覧</span>
						</h2>
						<ul class="profile-portfolio-items" id="profile-portfolio-items">
							<!--portfolio loop-->
							<li class="signup-modal-trigger profile-portfolio-item">
								<div class="profile-portfolio-item-inner">
									<div class="mosaic-block fade">
										<a class="mosaic-overlay ajax-popup-link" href="popup-portfolio.php">
											<h6 class="profile-portfolio-hover-title">Portfolio Title</h6>
										</a>
										<a class="mosaic-backdrop profile-portfolio-thumb" href="#" style="background-image: url(images/rentuser/portfolio/01.jpg)"></a>
									</div>
								</div>
							</li>
							<!--/portfolio loop-->
							<!--portfolio loop-->
							<li class="signup-modal-trigger profile-portfolio-item">
								<div class="profile-portfolio-item-inner">
									<div class="mosaic-block fade">
										<a class="mosaic-overlay ajax-popup-link" href="popup-portfolio.php">
											<h6 class="profile-portfolio-hover-title">Portfolio Title</h6>
										</a>
										<a class="mosaic-backdrop profile-portfolio-thumb" href="#" style="background-image: url(images/rentuser/portfolio/01.jpg)"></a>
									</div>
								</div>
							</li>
							<!--/portfolio loop-->
							<!--portfolio loop-->
							<li class="signup-modal-trigger profile-portfolio-item">
								<div class="profile-portfolio-item-inner">
									<div class="mosaic-block fade">
										<a class="mosaic-overlay ajax-popup-link" href="popup-portfolio.php">
											<h6 class="profile-portfolio-hover-title">Portfolio Title</h6>
										</a>
										<a class="mosaic-backdrop profile-portfolio-thumb" href="#" style="background-image: url(images/rentuser/portfolio/01.jpg)"></a>
									</div>
								</div>
							</li>
							<!--/portfolio loop-->
							<!--portfolio loop-->
							<li class="signup-modal-trigger profile-portfolio-item">
								<div class="profile-portfolio-item-inner">
									<div class="mosaic-block fade">
										<a class="mosaic-overlay ajax-popup-link" href="popup-portfolio.php">
											<h6 class="profile-portfolio-hover-title">Portfolio Title</h6>
										</a>
										<a class="mosaic-backdrop profile-portfolio-thumb" href="#" style="background-image: url(images/rentuser/portfolio/01.jpg)"></a>
									</div>
								</div>
							</li>
							<!--/portfolio loop-->
						</ul>
					</div>
				</div>
			</section>
			<section class="profile-components" id="resume">
				<div class="section-inner">
					<div class="profile-components-row">
						<div class="profile-components-main">
							<div class="profile-reviews feed-box" id="profile-reviews">
								<h2 class="section-title">
									最新レビュー
									<button class="signup-modal-trigger profile-reviews-btn-top" ng-click="profile.openReviewsModal()" data-qtsb-label="view_more">
										<span ng-if="profile.user.reviews[profile.user.role].length > 0" class="ng-scope">View More Reviews</span>
									</button>
								</h2>
								<ul class="user-reviews ng-scope">
									<!--loop review-->
									<li class="user-review ng-scope" itemprop="reviewRating" itemscope="">
										<img ng-src="//cdn3.f-cdn.com/ppic/11552138/logo/3337010/profile_logo_3337010.jpg" class="user-review-avatar" alt="" src="//cdn3.f-cdn.com/ppic/11552138/logo/3337010/profile_logo_3337010.jpg">
										<a class="user-review-title ng-binding" href="#">渋谷区神宮前コンフェレンスルーム</a>
										<span class="Rating Rating--labeled" data-star_rating="5.0">
											<meta itemprop="worstRating" content="0">
											<meta itemprop="bestRating" content="5">
											<meta itemprop="ratingValue" content="5.0">
											<span class="Rating-total">
												<span class="Rating-progress"></span>
											</span>
										</span>
										<p itemprop="description">
											“
											<span ng-bind="review.get().description" class="ng-binding">Highly recommended user AAA+</span>
											”
										</p>
										<span class="user-review-details ng-binding">
											<a href="#">
												<span class="user-review-name ng-binding">XXX company</span>
											</a>
											<span class="thedate">1ヶ月前</span>
										</span>
										<ul class="user-rating-info">
											<li class="place ng-scope">
												<a href="#">
													<span class="user-rating-info-item ng-binding">
														<i class="fa fa-map-marker" aria-hidden="true"></i>
														東京都渋谷区
													</span>
												</a>
											</li>
											<!-- end place that rating user has office at -->
											<li class="space-type ng-scope">
												<a href="#">
													<span class="user-rating-info-item ng-binding">
														<i class="fa fa-building" aria-hidden="true"></i>
														meeting room
													</span>
												</a>
											</li>
											<!-- end space type -->
											<li class="space-price ng-scope">
												<a href="#">
													<span class="user-rating-info-item ng-binding">
														<i class="fa fa-jpy" aria-hidden="true"></i>
														¥3,000~
													</span>
												</a>
											</li>
											<!-- end space price type -->
										</ul>
									</li>
									<!--/loop review-->
									<!--loop review-->
									<li class="user-review ng-scope" itemprop="reviewRating" itemscope="">
										<img ng-src="//cdn3.f-cdn.com/ppic/11552138/logo/3337010/profile_logo_3337010.jpg" class="user-review-avatar" alt="" src="//cdn3.f-cdn.com/ppic/11552138/logo/3337010/profile_logo_3337010.jpg">
										<a class="user-review-title ng-binding" href="#">渋谷区神宮前コンフェレンスルーム</a>
										<span class="Rating Rating--labeled" data-star_rating="5.0">
											<meta itemprop="worstRating" content="0">
											<meta itemprop="bestRating" content="5">
											<meta itemprop="ratingValue" content="5.0">
											<span class="Rating-total">
												<span class="Rating-progress"></span>
											</span>
										</span>
										<p itemprop="description">
											“
											<span ng-bind="review.get().description" class="ng-binding">Highly recommended user AAA+</span>
											”
										</p>
										<span class="user-review-details ng-binding">
											<a href="#">
												<span class="user-review-name ng-binding">XXX company</span>
											</a>
											<span class="thedate">1ヶ月前</span>
										</span>
										<ul class="user-rating-info">
											<li class="place ng-scope">
												<a href="#">
													<span class="user-rating-info-item ng-binding">
														<i class="fa fa-map-marker" aria-hidden="true"></i>
														東京都渋谷区
													</span>
												</a>
											</li>
											<!-- end place that rating user has office at -->
											<li class="space-type ng-scope">
												<a href="#">
													<span class="user-rating-info-item ng-binding">
														<i class="fa fa-building" aria-hidden="true"></i>
														meeting room
													</span>
												</a>
											</li>
											<!-- end space type -->
											<li class="space-price ng-scope">
												<a href="#">
													<span class="user-rating-info-item ng-binding">
														<i class="fa fa-jpy" aria-hidden="true"></i>
														¥3,000~
													</span>
												</a>
											</li>
											<!-- end space price type -->
										</ul>
									</li>
									<!--/loop review-->
								</ul>
								<button class="profile-widget-expand signup-modal-trigger ng-scope" data-qtsb-label="view_more">View More Reviews</button>
							</div>
							<!--/#profile-reviews-->
						</div>
						<!--/profile-components-main-->
						<div class="profile-components-side">
							<section class="profile-side-verifications feed-box">
								<h2 class="section-title">Verifications</h2>
								<ul class="VerificationsList">
									<li class="VerificationsList-item">
										<span class="VerificationsList-label">
											<span class="VerificationsList-label-icon Icon">
												<i class="fa fa-facebook-square" aria-hidden="true"></i>
											</span>
											Facebook Connected
										</span>
										<div>
											<a href="#" class="btn btn-mini btn-facebook">
												<span class="fa fl-icon-facebook"></span>
												Connect
											</a>
										</div>
									</li>
									<li class="VerificationsList-item is-VerificationsList-verified">
										<span class="VerificationsList-label">
											<span class="VerificationsList-label-icon Icon">
												<i class="fa fa-credit-card" aria-hidden="true"></i>
											</span>
											Payment Verified
										</span>
										<span class="VerificationsList-verifiedIcon Icon">
											<i class="fa fa-check" aria-hidden="true"></i>
										</span>
									</li>
									<li class="VerificationsList-item is-VerificationsList-verified">
										<span class="VerificationsList-label">
											<span class="VerificationsList-label-icon Icon">
												<i class="fa fa-phone" aria-hidden="true"></i>
											</span>
											Phone Verified
										</span>
										<span class="VerificationsList-verifiedIcon Icon">
											<i class="fa fa-check" aria-hidden="true"></i>
										</span>
									</li>
									<li class="VerificationsList-item is-VerificationsList-verified">
										<span class="VerificationsList-label">
											<span class="VerificationsList-label-icon Icon">
												<i class="fa fa-envelope" aria-hidden="true"></i>
											</span>
											Phone Verified
										</span>
										<span class="VerificationsList-verifiedIcon Icon">
											<i class="fa fa-check" aria-hidden="true"></i>
										</span>
									</li>
									<li class="VerificationsList-item">
										<span class="VerificationsList-label">
											<span class="VerificationsList-label-icon Icon">
												<i class="fa fa-user" aria-hidden="true"></i>
											</span>
											Identity Verified
										</span>
										<div>
											<a href="#" class="btn btn-mini">Verify</a>
										</div>
									</li>
								</ul>
							</section>
							<!--/feed-nbox-->

						</div>
						<!--/rightbox-->
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
	<!-- Magnific Popup core JS file -->
	<script src="js/magnific-popup/dist/jquery.magnific-popup.js"></script>
	<script>
jQuery(function () {
	var sklList = ('<?php echo $user->Skills ?>').split(',');
	var items = [];
	jQuery.each(sklList, function(i, item) {
	  items.push('<li>' + item + '</li>');
	});  
	jQuery('#SkillList').append(items.join(''));
	jQuery('.ajax-popup-link').magnificPopup({
	  type: 'ajax'
	});
	jQuery('.fade').mosaic();
});
</script>
</body>
</html>
