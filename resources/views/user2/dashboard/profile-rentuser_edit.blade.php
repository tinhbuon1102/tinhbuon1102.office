
<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header.php'); ?>
 @include('pages.header')
<link rel="stylesheet" href="<?php echo SITE_URL?>js/chosen/chosen.min.css">
<style>
.editting-skills .select2-container {
	display: none !important;
}
</style>
<?php
$breaks = array(
	"<br />",
	"<br>",
	"<br/>"
);
?>
<!--/head-->
<body class="profilepage rentuser-profile">
	<div class="viewport">
		<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header_nav_rentuser.php'); ?>
				  @if(Auth::check())
			@include('pages.header_nav_shareuser')
		@elseif(Auth::guard('user2')->check())
			@include('pages.header_nav_rentuser')
		@endif
		
		 @if(Auth::check())
										<?php renderOfferPopup($user1);?>
@endif
		<div id="main" class="container">
			<form id="form_cover_image" method="post" enctype="multipart/form-data" action='/upload-image.php' name="photo">
				<div class="profile-cover-wrapper ng-isolate-scope" style="<?php if(!empty($user->Cover)){ ?>background:url('{{$user->Cover}}')<? } ?> center center / cover no-repeat">
					<div class="profile-cover-mask">
						<div class="section-inner">
							<button style="display: none;" type="button" class="cover-image-upload-trigger" title="カバー写真を編集">
								<i class="fa fa-camera" aria-hidden="true"></i>
								<span class="cover-image-upload-trigger-text" i18n-id="4d23e067684e28a583becd976fe474ee" i18n-msg="カバー写真を変更">カバー写真を変更</span>
							</button>
							<input type="file" name="imagefile" id="cover_image" style="display: none">
							<span class="upload_cover_message_error upload_message_error" style="display: none;"></span>
							<div class="cover-image-upload-confirmation" style="display: none;">
								<button id="submit_cover_image" class="btn btn-small btn-info cover_image_save" bind-toggle=".cover-image-upload-confirmation">アップロード</button>
								<input type="hidden" name="submitbtn" value="Upload" />
								<input type="hidden" name="upload_type" value="cover" />
								<button class="btn btn-small cover_image_cancel toggle_button" bind-toggle=".cover-image-upload-confirmation">キャンセル</button>
							</div>
						</div>
					</div>
					<!--/mask-->
				</div>
			</form>
			<!--/profile-cover-wrapper-->
			<section class="profile-info">
				<div class="section-inner">
					<div class="profile-info-row">
						<div class="profile-info-inner" id="sticky-start">
							<div class="profile-info-card">
								<section class="profile-avatar mb-none">
									<figure class="profile-image">
										<a  id="thumbviewimage" class="ImageThumbnail crop_preview_box_small background-Logo" href="javascript:void(0);" style="background-size:100% !important;<?php if(!empty($user->Logo)){ ?>background:url('{{$user->Logo}}')<? } ?>" > </a>
										<a style="display: none;" image-type="Logo" data-toggle="modal" data-target="#popover_content_wrapper" class="picture-upload-trigger ng-hide" id="profileImageUploader" editbtn-valign="top" ng-class="{'btn-small': editbtnSize == 'small'}" ng-style="editBtnStyle" ng-show="profile.mode === 'edit'" title="プロフィール写真を編集">
											<span class="picture-upload-trigger-inner">
												<svg version="1.1" id="Layer_1" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="10 0 24 24" enable-background="new 10 0 24 24" xml:space="preserve" class="flicon-camera">
											<g id="Page-2" sketch:type="MSPage">
											    <g id="Photography" transform="translate(1.000000, 1.000000)" sketch:type="MSLayerGroup">
											        <path id="Stroke-1" sketch:type="MSShapeGroup" fill="none" d="M11.9,6.6l0-1c0-0.5,0.4-1,0.9-1h0.9c0.5,0,1,0.5,1,1v1"></path>
											        <path id="Stroke-3" sketch:type="MSShapeGroup" fill="none" d="M28.1,6.6l-1-1.9c-0.3-0.5-0.8-1-1.4-1H21c-0.6,0-1.1,0.5-1.4,1
											            l-1.4,1.9h-6.2c-1.4,0-1.9,0.6-1.9,1.6v9.9c0,1,0.5,1.8,2,1.8h18c1.5,0,2-0.8,2-1.8V8.2c0-1-0.5-1.6-2-1.6H28.1L28.1,6.6z"></path>
											        <path id="Stroke-5" sketch:type="MSShapeGroup" fill="none" d="M28.6,12.8c0,2.9-2.4,5.3-5.3,5.3c-2.9,0-5.3-2.4-5.3-5.3
											            s2.4-5.3,5.3-5.3C26.3,7.5,28.6,9.9,28.6,12.8L28.6,12.8z"></path>
											        <path id="Stroke-7" sketch:type="MSShapeGroup" fill="none" d="M26.2,12.8c0,1.6-1.3,2.9-2.9,2.9c-1.6,0-2.9-1.3-2.9-2.9
											            s1.3-2.9,2.9-2.9C25,9.9,26.2,11.2,26.2,12.8L26.2,12.8z"></path>
											        <path id="Stroke-9" sketch:type="MSShapeGroup" fill="none" d="M14.8,9.9c0,0.8-0.6,1.4-1.4,1.4c-0.8,0-1.4-0.6-1.4-1.4
											            c0-0.8,0.6-1.4,1.4-1.4C14.1,8.5,14.8,9.1,14.8,9.9L14.8,9.9z"></path>
											    </g>
											</g>
											</svg>
												<span class="picture-upload-trigger-text" style="display: none;">プロフィール写真を編集</span>
											</span>
											<input type="hidden" name="Logo" id="Logo" value="">
										</a>
									</figure>
									<div class="basic-user-info-wrapper">
										<ul class="basic-user-info">
											<li class="locate">
												<span class="fa fa-map-marker awesome-icon">{{$user->Prefecture}}{{$user->City}}</span>
											</li>
											<li class="sex">
												<!--if male-->
												<span class="fa {{$user->Sex == "男性" ? 'fa-mars' : 'fa-venus'}} awesome-icon">{{$user->Sex}}</span>
												<!--if female--<span class="fa fa-female awesome-icon">女性</span>-->
											</li>
											<li class="age">
												<span class="fa fa-user awesome-icon">{{getUserAage($user)}}歳</span>
											</li>
										</ul>
									</div>
									<div class="profile-verified">
										<ul class="verified-list">
											<li class="<?php echo $isPaymentSetup ? 'is-verified' : ''?> verified-item verified-payment">
												<span class="Icon">
													<i class="fa fa-credit-card" aria-hidden="true"></i>
												</span>
											</li>
											<li class="<?php echo $isProfileFullFilled ? 'is-verified' : ''?> verified-item verified-indentify">
												<span class="Icon">
													<i class="fa fa fa-user" aria-hidden="true"></i>
												</span>
											</li>
											<li class="<?php echo $user->Tel ? 'is-verified' : ''?> verified-item verified-phone">
												<span class="Icon">
													<i class="fa fa fa-phone" aria-hidden="true"></i>
												</span>
											</li>
											<li class="<?php echo $user->IsEmailVerified == 'Yes' ? 'is-verified' : ''?> verified-item verified-email">
												<span class="Icon">
													<i class="fa fa fa-envelope" aria-hidden="true"></i>
												</span>
											</li>
										</ul>
									</div>
								</section>
								<section class="profile-about mb-none">
									<div class="profile-intro-username edit-widget is-editable ng-isolate-scope">
										<div ng-hide="isActive">{{getUserName($user)}}</div>
										<!--name-->
										@if( empty($user->NameOfCompany) )
										<span class="kana-name">{{$user->LastNameKana}}&nbsp;{{$user->FirstNameKana}}</span>
										@endif
										<!--kana name-->
									</div>
									<div data-qtsb-section="about">
										<div id="profile-about-description-wrapper" class="profile-about-description-wrapper">
											<div class="editable-block-wraper">
												<div class="job profile-title-block editable-block">
													<span class="edit-content">
														<!--label-->
														<span class="job-label">職種：</span>
														<!--/label-->
														<span class="job-title">{{$user->BusinessType}}</span>
													</span>
												</div>
												<!--
												<div class="editable-block editting-block editting-job-title" style="display: none">
													<span>職種：{{$user->BusinessType}}</span>
													<div class="btn-wrapper">
														<button class="btnSaveSubTitle toggle_button save-button btn ui-button-text-only yellow-button" role="button" bind-toggle=".editting-job-title, .profile-title-block">
															<span class="ui-button-text">Save</span>
														</button>
														<button class="toggle_button cancel-button btn ui-button-text-only yellow-button" role="button" bind-toggle=".editting-job-title, .profile-title-block">
															<span class="ui-button-text">Cancel</span>
														</button>
													</div>
												</div>
											</div>
                    -->
												<!--job-->
												<div class="editable-block-wraper">
													<div class="profile-about-description editable-block">
														<span class="edit-content"> {{$user->BusinessSummary ? $user->BusinessSummary : '紹介文を記入してください'}} </span>
														<a style="display: none" class="profile-job-btn job-desc-edit-btn" href="javascript:void(0);">
															<span class="profile-job-btn-wraper">
																<span class="fa fa-pencil awesome-icon"></span>
															</span>
														</a>
													</div>
													<!--job-->
													<div class="editable-block editting-block editting-description" style="display: none">
														<textarea name="job-description" placeholder="自己紹介文を記入しましょう。" class="profile-textarea profiles-description"><?php echo trim(str_ireplace($breaks, "\r\n", $user->BusinessSummary))?></textarea>
														<div class="btn-wrapper">
															<button class="btnSaveBSummary toggle_button save-button btn ui-button-text-only yellow-button" role="button" bind-toggle=".profile-about-description, .editting-description">
																<span class="ui-button-text">保存</span>
															</button>
															<button class="toggle_button cancel-button btn ui-button-text-only" role="button" bind-toggle=".profile-about-description, .editting-description">
																<span class="ui-button-text">キャンセル</span>
															</button>
														</div>
													</div>
												</div>
												<!--/edit-widget-->
												<div class="editable-block-wraper">
													<div class="profile-skills editable-block">
														<p class="skill-label" style="<?php echo !trim($user->Skills) ? 'display: none;' : ''?>">スキル：</p>
														<ul class="skill-list withstar" id="SkillList">
														</ul>
														<span style="<?php echo trim($user->Skills) ? 'display: none;' : ''?>" class="no-content-text">スキルを選択してください</span>
														<a style="display: none" class="profile-job-btn job-skill-edit-btn" href="javascript:void(0);">
															<span class="profile-job-btn-wraper" style="display: inline-block;">
																<span class="fa fa-pencil awesome-icon"></span>
															</span>
														</a>
													</div>
													<div class="editable-block editting-block editting-skills" style="display: none;">
														<select data-placeholder="スキルを選択" class="chosen-select profile-skills-select" id="profile-skills" multiple="multiple" aria-hidden="true" tabindex="-1">
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
														<div class="btn-wrapper">
															<button id="SaveSkills" class="btnSaveSkills toggle_button save-button btn ui-button-text-only yellow-button" role="button" bind-toggle=".profile-skills, .editting-skills">
																<span class="ui-button-text">保存</span>
															</button>
															<button id="CancelSkills" class="toggle_button cancel-button btn ui-button-text-only" role="button" bind-toggle=".profile-skills, .editting-skills">
																<span class="ui-button-text">キャンセル</span>
															</button>
														</div>
													</div>
												</div>
												<!--/skills-->
											</div>
										</div>
								
								</section>
								<!--end of about-->
								<section class="profile-statistics mb-none">
									<div class="top-pad-inner">
										<?php if (!isset($isPublicUser) || !$isPublicUser) {?>
										<div class="profile-btn">
											<div class="offer-btn">
												<a class="btn btn-large profile-btn edit-profile-btn">
													<span class="fa fa-pencil awesome-icon">プロフィール編集</span>
												</a>
												<a class="btn btn-large profile-btn view-profile-btn" style="display: none;">
													<span class="fa fa-empty awesome-icon">プロフィール表示</span>
												</a>
											</div>
										</div>
										<?php }?>
										<!--/profile-btn-->
										<?php showStarReview($reviews);?>
									</div>
									<!--<ul class="item-stats" ng-show="profile.user.role === 'freelancer'">
										<li class="is-good">
											<span class="item-stats-name">使用清潔度</span>
											<span class="item-stats-value">{{$reviews['CleaninessAvg']}}%</span>
										</li>
										<li class="is-good">
											<span class="item-stats-name">礼儀正しさ</span>
											<span class="item-stats-value">{{$reviews['PoliteAvg']}}%</span>
										</li>
										<li class="is-good">
											<span class="item-stats-name">ルール遵守</span>
											<span class="item-stats-value">{{$reviews['KindnessAvg']}}%</span>
										</li>
										<li class="is-good">
											<span class="item-stats-name">再利用希望</span>
											<span class="item-stats-value">{{$reviews['RepeatAvg']}}%</span>
										</li>
									</ul>-->
                                    
									<?php if(Auth::guard('user1')->check()) {?>
                                    <ul class="item-stats">
                                    <!--<li class="offer-btn-wrap"><a class="btn button dblk-button"><i class="fa fa-paper-plane-o" aria-hidden="true"></i> オファーをする</a></li>
                                    -->
									<li class="offer-btn-wrap offer-lists" data-id="{{$user->id}}"><a class="btn button dblk-button offer_btn"><i class="fa fa-paper-plane-o" aria-hidden="true"></i> オファーをする</a></li>
                                    </ul>
                                    <div class="send-msg">
										<a href="/ShareUser/Dashboard/Message/{{$user->HashCode}}">
											<button class="btn button msg-button yellow-button" data-bind="click: SendMessageViewModel.showDialog" role="button" aria-disabled="false">
												<span class="ui-button-text">
													<i class="icon-offispo-icon-06 awesome-icon"></i>
													メッセージを送る
												</span>
											</button>
										</a>
									</div>
                                    <?php }?>
								</section>
								<!--end of profile-statics-->
								<!--mobile view-->
								<section class="profiles-user user-profile pc-none">
									<div class="user-profile-avatar">
										<figure class="profile-image">
											<a  id="thumbviewimage" class="ImageThumbnail crop_preview_box_small background-Logo" href="javascript:void(0);" style="background-size:cover !important;<?php if(!empty($user->Logo)){ ?>background:url('{{$user->Logo}}')<? } ?>" > </a>
											<a style="display: none;" image-type="Logo" data-toggle="modal" data-target="#popover_content_wrapper" class="picture-upload-trigger ng-hide" id="profileImageUploader" editbtn-valign="top" ng-class="{'btn-small': editbtnSize == 'small'}" ng-style="editBtnStyle" ng-show="profile.mode === 'edit'" title="プロフィール写真を編集">
												<span class="picture-upload-trigger-inner">
													<svg version="1.1" id="Layer_1" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="10 0 24 24" enable-background="new 10 0 24 24" xml:space="preserve" class="flicon-camera">
											<g id="Page-2" sketch:type="MSPage">
											    <g id="Photography" transform="translate(1.000000, 1.000000)" sketch:type="MSLayerGroup">
											        <path id="Stroke-1" sketch:type="MSShapeGroup" fill="none" d="M11.9,6.6l0-1c0-0.5,0.4-1,0.9-1h0.9c0.5,0,1,0.5,1,1v1"></path>
											        <path id="Stroke-3" sketch:type="MSShapeGroup" fill="none" d="M28.1,6.6l-1-1.9c-0.3-0.5-0.8-1-1.4-1H21c-0.6,0-1.1,0.5-1.4,1
											            l-1.4,1.9h-6.2c-1.4,0-1.9,0.6-1.9,1.6v9.9c0,1,0.5,1.8,2,1.8h18c1.5,0,2-0.8,2-1.8V8.2c0-1-0.5-1.6-2-1.6H28.1L28.1,6.6z"></path>
											        <path id="Stroke-5" sketch:type="MSShapeGroup" fill="none" d="M28.6,12.8c0,2.9-2.4,5.3-5.3,5.3c-2.9,0-5.3-2.4-5.3-5.3
											            s2.4-5.3,5.3-5.3C26.3,7.5,28.6,9.9,28.6,12.8L28.6,12.8z"></path>
											        <path id="Stroke-7" sketch:type="MSShapeGroup" fill="none" d="M26.2,12.8c0,1.6-1.3,2.9-2.9,2.9c-1.6,0-2.9-1.3-2.9-2.9
											            s1.3-2.9,2.9-2.9C25,9.9,26.2,11.2,26.2,12.8L26.2,12.8z"></path>
											        <path id="Stroke-9" sketch:type="MSShapeGroup" fill="none" d="M14.8,9.9c0,0.8-0.6,1.4-1.4,1.4c-0.8,0-1.4-0.6-1.4-1.4
											            c0-0.8,0.6-1.4,1.4-1.4C14.1,8.5,14.8,9.1,14.8,9.9L14.8,9.9z"></path>
											    </g>
											</g>
											</svg>
												</span>
											</a>
										</figure>
									</div>
									<div class="profiles-user-details user-profile-details">
										<div class="profile-intro-username edit-widget is-editable ng-isolate-scope">
											<div ng-hide="isActive">{{getUserName($user)}}</div>
											<!--name-->
											@if( empty($user->NameOfCompany) )
											<span class="kana-name">{{$user->LastNameKana}}&nbsp;{{$user->FirstNameKana}}</span>
											@endif
											<!--kana name-->
										</div>
										<div class="job profile-title-block editable-block mb-small">
											<span class="edit-content">
												<!--label-->
												<span class="job-label">職種：</span>
												<!--/label-->
												<span class="job-title">{{$user->BusinessType}}</span>
											</span>
										</div>
										<div class="user-profile-rating user-rating">
                                    <?php showStarReview($reviews);?>
                                    </div>
										<div class="user-profile-location mb-small">
											<span class="fa fa-map-marker awesome-icon">{{$user->Prefecture}}{{$user->City}}</span>
										</div>
									</div>
									<?php if(Auth::guard('user1')->check()) {?>
                                    <ul class="item-stats">
                                    <li class="offer-btn-wrap offer-lists" data-id="{{$user->id}}"><a class="btn button dblk-button offer_btn"><i class="fa fa-paper-plane-o" aria-hidden="true"></i> オファーをする</a></li>
                                    
                                    <li class="send-msg">
										<a href="/ShareUser/Dashboard/Message/{{$user->HashCode}}" class="button">
											<button class="btn button msg-button yellow-button" data-bind="click: SendMessageViewModel.showDialog" role="button" aria-disabled="false">
												<span class="ui-button-text">
													<i class="icon-offispo-icon-06 awesome-icon"></i>
													メッセージを送る
												</span>
											</button>
										</a>
									</li>
                                   </ul>
                                    <?php }?>
								</section>
								<!--<section class="profiles-user-statistics pc-none">
									<div class="profiles-user-statistics-item ng-binding">
										<span class="profiles-user-statistics-title">使用清潔度</span>
										@if( empty($reviews['CleaninessAvg']) ) ---% @else {{$reviews['CleaninessAvg']}}% @endif
									</div>
									<div class="profiles-user-statistics-item ng-binding">
										<span class="profiles-user-statistics-title">ルール遵守</span>
										@if( empty($reviews['KindnessAvg']) ) ---% @else {{$reviews['KindnessAvg']}}% @endif
									</div>
									<div class="profiles-user-statistics-item ng-binding">
										<span class="profiles-user-statistics-title">再利用希望</span>
										@if( empty($reviews['RepeatAvg']) ) ---% @else {{$reviews['RepeatAvg']}}% @endif
									</div>
								</section>-->
								<!--/mobile view-->
							</div>
						</div>
					</div>
				</div>
			</section>
			<!--end of profile section-->
			<!--mobile tab-->
			<div class="PageNav pc-none">
				<ul class="PageNav-list tab-nav">
					<li class="PageNav-item select">
						<a href="#" class="PageNav-link">プロフィール</a>
					</li>
					
                <?php if (count($userPortfolios) || (!isset($isPublicUser) || !$isPublicUser)) {?>
					<li class="PageNav-item">
						<a href="#" class="PageNav-link">実績</a>
					</li>
					<?php }?>
					<li class="PageNav-item">
						<a href="#" class="PageNav-link">レビュー</a>
					</li>
				</ul>
			</div>
			<!--/mobile tab-->
			<div class="tab-con pc-none">
				<ul class="content">
					<li class="tabli details-con">
						<section class="profile-user-requirement">
							<div class="section-inner">
								<div class="row">
                    <?php if (!isset($isPublicUser) || !$isPublicUser) {?>
                    <div class="profile-edit-btn-wrap col-md-9">
										<div class="profile-btn">
											<div class="offer-btn">
												<a class="btn btn-large profile-btn edit-profile-btn wdfull">
													<span class="fa fa-pencil awesome-icon">プロフィール編集</span>
												</a>
												<a class="btn btn-large profile-btn view-profile-btn wdfull" style="display: none;">
													<span class="fa fa-empty awesome-icon">プロフィール表示</span>
												</a>
											</div>
										</div>
									</div>
										<?php }?>
										<!--/profile-btn-->
									<div class="profile-require-main col-md-9">
										<div class="profile-require-basic js-matchHeight feed-box" id="basic-requirement">
											<h2 class="section-title">自己紹介文</h2>
											<div class="require-table-box editable-block-wraper">
												<div class="profile-about-description editable-block">
													<a style="display: none" class="profile-job-btn job-desc-edit-btn mb-editbtn" href="javascript:void(0);">
														<span class="profile-job-btn-wraper">
															<span class="fa fa-pencil awesome-icon"></span>
														</span>
													</a>
													<span class="edit-content"> {{$user->BusinessSummary}} </span>
												</div>
												<!--job-->
												<div class="editable-block editting-block editting-description" style="display: none">
													<textarea name="job-description" placeholder="自己紹介文を記入しましょう。" class="profile-textarea profiles-description"><?php echo trim(str_ireplace($breaks, "\r\n", $user->BusinessSummary))?></textarea>
													<div class="btn-wrapper">
														<button class="btnSaveBSummary toggle_button save-button btn ui-button-text-only yellow-button" role="button" bind-toggle=".profile-about-description, .editting-description">
															<span class="ui-button-text">保存</span>
														</button>
														<button class="toggle_button cancel-button btn ui-button-text-only" role="button" bind-toggle=".profile-about-description, .editting-description">
															<span class="ui-button-text">キャンセル</span>
														</button>
													</div>
												</div>
											</div>
										</div>
										<!--/profile-require-basic-->
									</div>
									<!--/profile-require-main-->
									<!--hide if skill is not setted-->
									<?php if (!trim($user->Skills) || (!isset($isPublicUser) || !$isPublicUser)) {?>
									<div class="profile-require-main col-md-9">
										<div class="profile-require-basic js-matchHeight feed-box" id="basic-requirement">
											<h2 class="section-title">スキル</h2>
											<div class="require-table-box editable-block-wraper">
												<div class="profile-skills editable-block">
													<a style="display: none" class="profile-job-btn job-skill-edit-btn mb-editbtn" href="javascript:void(0);">
														<span class="profile-job-btn-wraper" style="display: inline-block;">
															<span class="fa fa-pencil awesome-icon"></span>
														</span>
													</a>
													<ul class="skill-list withstar" id="SkillList">
													</ul>
													<span style="<?php echo trim($user->Skills) ? 'display: none;' : ''?>" class="no-content-text">スキルを選択してください</span>
												</div>
												<div class="editable-block editting-block editting-skills" style="display: none;">
													<select data-placeholder="スキルを選択" class="chosen-select profile-skills-select" id="profile-skills-mobile" multiple="multiple" aria-hidden="true" tabindex="-1">
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
													<div class="btn-wrapper">
														<button id="SaveSkills" class="btnSaveSkills toggle_button save-button btn ui-button-text-only yellow-button" role="button" bind-toggle=".profile-skills, .editting-skills">
															<span class="ui-button-text">保存</span>
														</button>
														<button id="CancelSkills" class="toggle_button cancel-button btn ui-button-text-only" role="button" bind-toggle=".profile-skills, .editting-skills">
															<span class="ui-button-text">キャンセル</span>
														</button>
													</div>
												</div>
											</div>
										</div>
										<!--/profile-require-basic-->
									</div>
									<?php }?>
									<!--/profile-require-main-->
									<div class="profile-require-main col-md-9">
										<div class="profile-require-basic js-matchHeight feed-box" id="basic-requirement">
											<h2 class="section-title">
												利用希望ワークスペース
												<span class="edit-workspace">
													<a href="{{url('RentUser/Dashboard/EditMySpace')}}" class="profile-job-btn mb-editbtn" style="display: none;" target="_blank">
														<span class="fa fa-pencil awesome-icon"></span>
													</a>
												</span>
											</h2>
											<div class="require-table-box editable-block-wraper">
												<span style="display: none;" class="profile-job-btn-wraper">
													<a style="display: none" class="profile-job-btn job-requirement-basic-btn" href="javascript:void(0);" onclick="LoadDetail()">
														<span class="fa fa-pencil awesome-icon"></span>
													</a>
												</span>
												<div class="require-table-box-row">
													<div class="col_half left">
														<table class="require-list style_basic">
															<tbody>
																<tr>
																	<th>スペースタイプ</th>
																	<td>
																		<div class="editable-block-wraper">
																			<div class="editable-block private-office-content">
																				<span> {{$space->SpaceType}} </span>
																			</div>
																		</div>
																	</td>
																</tr>
																<th>希望地域</th>
																<td>
																	<div class="editable-block-wraper">
																		<div class="editable-block location-content">
																			<span>{{$space->DesireLocationPrefecture}},&nbsp;{{$space->DesireLocationDistricts}},&nbsp;{{$space->DesireLocationTown}}</span>
																		</div>
																	</div>
																</td>
																</tr>
																<tr>
																	<th>希望利用料</th>
																	<td>
																		<div class="editable-block-wraper">
																			<div class="editable-block location-budget">
																				<span>{{@$budgets[$space->BudgetID]}}</span>
																			</div>
																		</div>
																	</td>
																</tr>
															</tbody>
														</table>
													</div>
													<!--/half-->
													<div class="col_half right">
														<table class="require-list style_basic">
															<tbody>
																<tr>
																	<th>利用時間帯</th>
																	<td>
																		<div class="editable-block-wraper">
																			<div class="editable-block location-time">
																				<span>{{@$timeslots[$space->TimeSlot]}}</span>
																			</div>
																		</div>
																	</td>
																</tr>
																<tr>
																	<th>利用人数</th>
																	<td>
																		<div class="editable-block-wraper">
																			<div class="editable-block location-numpeople">
																				<span>{{$space->NumberOfPeople}}</span>
																			</div>
																		</div>
																	</td>
																</tr>
																<tr>
																	<th>スペース面積</th>
																	<td>
																		<div class="editable-block-wraper">
																			<div class="editable-block location-budget">
																				<span>{{@$areas[$space->SpaceArea]}}</span>
																			</div>
																		</div>
																	</td>
																</tr>
															</tbody>
														</table>
													</div>
													<!--/half-->
												</div>
												<!--/table-box-->
												<div class="require-note clearfix">
													<table class="require-list style_basic fl-col-table">
														<tbody>
															<tr>
																<th>希望職場事業</th>
																<td>
																	<div class="editable-block-wraper">{{$space->BusinessType}}</div>
																</td>
															</tr>
															@if( !empty($space->notes_ideals) )
															<tr>
																<th>備考</th>
																<td>
																	<div class="editable-block-wraper">{{$space->notes_ideals}}</div>
																</td>
															</tr>
															@endif
														</tbody>
													</table>
												</div>
												<!--require-note-->
												<div class="editable-block editting-block editting-private-office" style="display: none">
													<button id="btnSave" class="toggle_button save-button btn ui-button-text-only yellow-button" role="button">
														<span class="ui-button-text">保存</span>
													</button>
													<button id="btnCancel" class="toggle_button cancel-button btn ui-button-text-only" role="button">
														<span class="ui-button-text">キャンセル</span>
													</button>
												</div>
											</div>
										</div>
										<!--/profile-require-basic-->
									</div>
									<!--/profile-require-main-->
									<div class="profile-requirement-side col-md-3">
										<div class="profile-side-requirement js-matchHeight feed-box editable-block-wraper form-container">
											<h2 class="section-title">希望設備</h2>
											<div class="require-table-box facility-require">
												<span class="profile-job-btn-wraper" style="display: none;">
													<a style="display: none" class="profile-job-btn job-requirement-basic-btn" href="javascript:void(0);">
														<span class="fa fa-pencil awesome-icon"></span>
													</a>
												</span>
												<table class="require-list facility-require-list style_basic">
													<tbody>
														<tr>
															<th>デスク</th>
															<td>
																<div class="editable-block-wraper">
																	<div class="editable-block location-num-desk">
																		<strong>
																			<span>{{$space->NumOfDesk}}</span>
																		</strong>
																		台
																	</div>
																</div>
															</td>
														</tr>
														<tr>
															<th>イス</th>
															<td>
																<div class="editable-block-wraper">
																	<div class="editable-block location-num-chair">
																		<strong>
																			<span>{{$space->NumOfChair}}</span>
																		</strong>
																		台
																	</div>
																</div>
															</td>
														</tr>
														<tr>
															<th>ボード</th>
															<td>
																<div class="editable-block-wraper">
																	<div class="editable-block location-num-board">
																		<strong>
																			<span>{{$space->NumOfBoard}}</span>
																		</strong>
																		台
																	</div>
																</div>
															</td>
														</tr>
														<tr>
															<th>複数人用デスク&amp;イス</th>
															<td>
																<div class="editable-block-wraper">
																	<div class="editable-block location-num_largedesk">
																		<strong>
																			<span>{{$space->NumOfLargeDesk}}</span>
																		</strong>
																		台
																	</div>
																</div>
															</td>
														</tr>
														<tr class="other-facilities">
															<th colspan="2">その他設備</th>
														</tr>
														<tr class="other-facilities">
															<td colspan="2">
																<div class="editable-block-wraper">
																	<div class="editable-block location-facility">
																		<span>{{$space->OtherFacility}}</span>
																	</div>
																</div>
															</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
									<div class="profile-components-side col-md-3">
										<section class="profile-side-verifications feed-box">
											<h2 class="section-title">認証</h2>
											<ul class="VerificationsList">
												<li class="VerificationsList-item <?php echo $isPaymentSetup ? 'is-VerificationsList-verified' : ''?>">
													<span class="VerificationsList-label">
														<span class="VerificationsList-label-icon Icon">
															<i class="fa fa-credit-card" aria-hidden="true"></i>
														</span>
														決済方法認証
													</span>
										<?php if ($isPaymentSetup) {?>
										<span class="VerificationsList-verifiedIcon Icon">
														<i class="fa fa-check" aria-hidden="true"></i>
													</span>
										<?php }else {?>
											<div>
														<a href="{{url('/RentUser/Dashboard/BasicInfo/Edit')}}" class="btn btn-mini">認証する</a>
													</div>
										<?php }?>
									</li>
												<li class="VerificationsList-item <?php echo $user->Tel ? 'is-VerificationsList-verified' : ''?>">
													<span class="VerificationsList-label">
														<span class="VerificationsList-label-icon Icon">
															<i class="fa fa-phone" aria-hidden="true"></i>
														</span>
														電話番号認証
													</span>
										<?php if ($user->Tel) {?>
										<span class="VerificationsList-verifiedIcon Icon">
														<i class="fa fa-check" aria-hidden="true"></i>
													</span>
										<?php }else {?>
											<div>
														<a href="{{url('/RentUser/Dashboard/BasicInfo/Edit')}}" class="btn btn-mini">認証する</a>
													</div>
										<?php }?>
									</li>
												<li class="VerificationsList-item <?php echo $user->IsEmailVerified = 'Yes' ? 'is-VerificationsList-verified' : ''?>">
													<span class="VerificationsList-label">
														<span class="VerificationsList-label-icon Icon">
															<i class="fa fa-envelope" aria-hidden="true"></i>
														</span>
														メールアドレス認証
													</span>
										<?php if ($user->IsEmailVerified = 'Yes') {?>
										<span class="VerificationsList-verifiedIcon Icon">
														<i class="fa fa-check" aria-hidden="true"></i>
													</span>
										<?php }else {?>
											<div>
														<a href="{{url('/RentUser/Dashboard/BasicInfo/Edit')}}" class="btn btn-mini">認証する</a>
													</div>
										<?php }?>
									</li>
												<li class="VerificationsList-item <?php echo $isProfileFullFilled ? 'is-VerificationsList-verified' : ''?>">
													<span class="VerificationsList-label">
														<span class="VerificationsList-label-icon Icon">
															<i class="fa fa-user" aria-hidden="true"></i>
														</span>
														個人証明認証
													</span>
										<?php if ($isProfileFullFilled ) {?>
										<span class="VerificationsList-verifiedIcon Icon">
														<i class="fa fa-check" aria-hidden="true"></i>
													</span>
										<?php }else {?>
											<div>
														<a href="{{url('/RentUser/Dashboard/BasicInfo/Edit')}}" class="btn btn-mini">認証する</a>
													</div>
										<?php }?>
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
					</li>
					<?php if (count($userPortfolios) || (!isset($isPublicUser) || !$isPublicUser)) {?>
					<li class="tabli work-con hideli">
						<section class="profile-portfolio-section" id="profile-portfolio">
							<div class="section-inner">
                <?php if (!isset($isPublicUser) || !$isPublicUser) {?>
                <div class="portfolio-add-item-wraper2">
									<a href="/RentUser/Dashboard/MyPortfolio?action=add" class="ajax-popup-link portfolio-add-item-btn non-feature btn btn-info btn-large wdfull">
										<span>+ 実績を追加</span>
									</a>
								</div>
                <?php }?>
                <?php if (count($userPortfolios)) {?>
					<div class="profile-portfolio-wrapper">
									<h2 class="port-title-h2">
										Our Works
										<span class="ja">実績一覧</span>
									</h2>
									<ul class="profile-portfolio-items" id="profile-portfolio-items">
							<?php foreach ($userPortfolios as $userPortfolio) {?>
								<?php
																		$viewUrl = '/RentUser/Dashboard/MyPortfolio?action=view&id=' . $userPortfolio['id'];
																		$editUrl = '/RentUser/Dashboard/MyPortfolio?action=edit&id=' . $userPortfolio['id'];
																		$deleteUrl = '/RentUser/Dashboard/MyProfile?action=delete_portfolio&portfolio_id=' . $userPortfolio['id'];
																		?>
								<li class="signup-modal-trigger profile-portfolio-item" data-id="<?php echo $userPortfolio['id']?>">
											<div class="portfolio-header" style="display: none">
												<a href="<?php echo $editUrl?>" class="ajax-popup-link portfolio-edit-button">編集</a>
												<a href="<?php echo $deleteUrl?>" class="portfolio-delete-button">削除</a>
											</div>
											<div class="profile-portfolio-item-inner">
												<div class="mosaic-block fade">
													<a class="mosaic-overlay ajax-popup-link" href="<?php echo $viewUrl?>">
														<h6 class="profile-portfolio-hover-title"><?php echo $userPortfolio['Title']?></h6>
													</a> 
											<?php if ($userPortfolio['Photo']) {?>
											<a class="mosaic-backdrop profile-portfolio-thumb" href="#" style="background-image: url(<?php echo $userPortfolio['Photo']?>)"></a>
											<?php }?>
										</div>
											</div>
										</li>
							<?php }?>
						</ul>
								</div>
                    <?php }?>
				</div>
						</section>
					</li>
					<?php }?>
					<li class="tabli review-con hideli">
						<section class="profile-components" id="resume">
							<div class="section-inner">
								<div class="row">
									<div class="profile-components-main col-md-9">
										<div class="profile-reviews feed-box" id="profile-reviews">
											<h2 class="section-title">
												最新レビュー
												<!--<button style="<?php //if (count($allReviews) < LIMIT_REVIEWS ) echo 'display: none;'?>" class="signup-modal-trigger profile-reviews-btn-top" ng-click="profile.openReviewsModal()" data-qtsb-label="view_more">
													<span ng-if="profile.user.reviews[profile.user.role].length > 0" class="ng-scope">レビューを全て見る</span>
												</button>-->
											</h2>
											<ul class="user-reviews ng-scope">
												<!--loop review-->
									<?php if (count($allReviews) == 0) {?>
									<li>まだレビューはありません。</li>
									<?php }?>
									<?php
									
foreach ( $allReviews as $reviewIndex => $review )
									{
										?>
									<li class="user-review ng-scope <?php if ($reviewIndex >= LIMIT_REVIEWS) echo 'hide'?>" itemprop="reviewRating" itemscope="">
													<img class="user-review-avatar" alt="" src="<?php echo getUser1Photo($review['user1'])?>">
													<a class="user-review-title ng-binding" href="<?php echo getSpaceUrl($review['space']['HashID'])?>"><?php echo $review['space']['Title']?></a>
													<span class="Rating Rating--labeled" data-star_rating="<?php echo number_format($review['AverageRating'], 1)?>">
														<span class="Rating-total">
															<span class="Rating-progress" style="width:<?php echo showWidthRatingProgress($review['AverageRating'])?>%"></span>
														</span>
													</span>
													<?php if ($review['Comment']) {?>
													<p itemprop="description">
														“
														<span ng-bind="review.get().description" class="ng-binding"><?php echo $review['Comment']?></span>
														”
													</p>
													<?php }?>
													<span class="user-review-details ng-binding">
														<a href="<?php echo getUser1ProfileUrl($review['user1'])?>">
															<span class="user-review-name ng-binding"><?php echo $review['user1']['NameOfCompany']?></span>
														</a>
														<span class="thedate"><?php echo renderHumanTime($review['created_at']) ?></span>
													</span>
													<ul class="user-rating-info">
														<li class="place ng-scope">
															<span class="user-rating-info-item ng-binding">
																<i class="fa fa-map-marker" aria-hidden="true"></i>
													<?php echo $review['space']['Prefecture'].$review['space']['District'].$review['space']['Address1']?>
												</span>
														</li>
														<!-- end place that rating user has office at -->
														<li class="space-type ng-scope">
															<span class="user-rating-info-item ng-binding">
																<i class="fa fa-building" aria-hidden="true"></i>
													<?php echo $review['space']['Type']?>
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
					</li>
				</ul>
				<div style="display: none;"></div>
			</div>
			<div class="mb-none">
				<section class="profile-user-requirement">
					<div class="section-inner">
						<div class="row">
							<div class="profile-require-main col-md-9">
								<div class="profile-require-basic js-matchHeight feed-box" id="basic-requirement">
									<h2 class="section-title">
										利用希望ワークスペース
										<span class="edit-workspace">
											<a href="{{url('RentUser/Dashboard/EditMySpace')}}" class="profile-job-btn" style="display: none;" target="_blank">
												<span class="fa fa-pencil awesome-icon"></span>
											</a>
										</span>
									</h2>
									<div class="require-table-box editable-block-wraper">
										<span style="display: none;" class="profile-job-btn-wraper">
											<a style="display: none" class="profile-job-btn job-requirement-basic-btn" href="javascript:void(0);" onclick="LoadDetail()">
												<span class="fa fa-pencil awesome-icon"></span>
											</a>
										</span>
										<div class="require-table-box-row">
											<div class="col_half left">
												<table class="require-list style_basic">
													<tbody>
														<tr>
															<th>スペースタイプ</th>
															<td>
																<div class="editable-block-wraper">
																	<div class="editable-block private-office-content">
																		<span> {{$space->SpaceType}} </span>
																	</div>
																</div>
															</td>
														</tr>
														<th>希望地域</th>
														<td>
															<div class="editable-block-wraper">
																<div class="editable-block location-content">
																	<span>{{$space->DesireLocationPrefecture}},&nbsp;{{$space->DesireLocationDistricts}},&nbsp;{{$space->DesireLocationTown}}</span>
																</div>
															</div>
														</td>
														</tr>
														<tr>
															<th>希望利用料</th>
															<td>
																<div class="editable-block-wraper">
																	<div class="editable-block location-budget">
																		<span>{{@$budgets[$space->BudgetID]}}</span>
																	</div>
																</div>
															</td>
														</tr>
													</tbody>
												</table>
											</div>
											<!--/half-->
											<div class="col_half right">
												<table class="require-list style_basic">
													<tbody>
														<tr>
															<th>利用時間帯</th>
															<td>
																<div class="editable-block-wraper">
																	<div class="editable-block location-time">
																		<span>{{@$timeslots[$space->TimeSlot]}}</span>
																	</div>
																</div>
															</td>
														</tr>
														<tr>
															<th>利用人数</th>
															<td>
																<div class="editable-block-wraper">
																	<div class="editable-block location-numpeople">
																		<span>{{$space->NumberOfPeople}}</span>
																	</div>
																</div>
															</td>
														</tr>
														<tr>
															<th>スペース面積</th>
															<td>
																<div class="editable-block-wraper">
																	<div class="editable-block location-budget">
																		<span>{{@$areas[$space->SpaceArea]}}</span>
																	</div>
																</div>
															</td>
														</tr>
													</tbody>
												</table>
											</div>
											<!--/half-->
										</div>
										<!--/table-box-->
										<div class="require-note clearfix">
											<table class="require-list style_basic fl-col-table">
												<tbody>
													<tr>
														<th>希望職場事業</th>
														<td>
															<div class="editable-block-wraper">{{$space->BusinessType}}</div>
														</td>
													</tr>
													@if( !empty($space->notes_ideals) )
													<tr>
														<th>備考</th>
														<td>
															<div class="editable-block-wraper">{{$space->notes_ideals}}</div>
														</td>
													</tr>
													@endif
												</tbody>
											</table>
										</div>
										<!--require-note-->
									</div>
								</div>
								<!--/profile-require-basic-->
							</div>
							<!--/profile-require-main-->
							<div class="profile-requirement-side col-md-3">
								<div class="profile-side-requirement js-matchHeight feed-box editable-block-wraper form-container">
									<h2 class="section-title">希望設備</h2>
									<div class="require-table-box facility-require">
										<span class="profile-job-btn-wraper" style="display: none;">
											<a style="display: none" class="profile-job-btn job-requirement-basic-btn" href="javascript:void(0);">
												<span class="fa fa-pencil awesome-icon"></span>
											</a>
										</span>
										<table class="require-list facility-require-list style_basic">
											<tbody>
												<tr>
													<th>デスク</th>
													<td>
														<div class="editable-block-wraper">
															<div class="editable-block location-num-desk">
																<strong>
																	<span>{{$space->NumOfDesk}}</span>
																</strong>
																台
															</div>
														</div>
													</td>
												</tr>
												<tr>
													<th>イス</th>
													<td>
														<div class="editable-block-wraper">
															<div class="editable-block location-num-chair">
																<strong>
																	<span>{{$space->NumOfChair}}</span>
																</strong>
																台
															</div>
														</div>
													</td>
												</tr>
												<tr>
													<th>ボード</th>
													<td>
														<div class="editable-block-wraper">
															<div class="editable-block location-num-board">
																<strong>
																	<span>{{$space->NumOfBoard}}</span>
																</strong>
																台
															</div>
														</div>
													</td>
												</tr>
												<tr>
													<th>複数人用デスク&amp;イス</th>
													<td>
														<div class="editable-block-wraper">
															<div class="editable-block location-num_largedesk">
																<strong>
																	<span>{{$space->NumOfLargeDesk}}</span>
																</strong>
																台
															</div>
														</div>
													</td>
												</tr>
												<tr class="other-facilities">
													<th colspan="2">その他設備</th>
												</tr>
												<tr class="other-facilities">
													<td colspan="2">
														<div class="editable-block-wraper">
															<div class="editable-block location-facility">
																<span>{{$space->OtherFacility}}</span>
															</div>
														</div>
													</td>
												</tr>
											</tbody>
										</table>
										<div class="editable-block editting-block editting-num-desk" style="display: none">
											<button id="btnSaveEqp" class="toggle_button save-button btn ui-button-text-only yellow-button" role="button">
												<span class="ui-button-text">保存</span>
											</button>
											<button id="btnCancelEqp" class="toggle_button cancel-button btn ui-button-text-only" role="button">
												<span class="ui-button-text">キャンセル</span>
											</button>
										</div>
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
                <?php if (!isset($isPublicUser) || !$isPublicUser) {?>
                <div class="portfolio-add-item-wraper" style="display: none">
							<a href="/RentUser/Dashboard/MyPortfolio?action=add" class="ajax-popup-link portfolio-add-item-btn non-feature btn btn-info btn-large">
								<span>+ 実績を追加</span>
							</a>
						</div>
                <?php }?>
                <?php if (count($userPortfolios)) {?>
					<div class="profile-portfolio-wrapper">
							<h2 class="port-title-h2">
								Our Works
								<span class="ja">実績一覧</span>
							</h2>
							<ul class="profile-portfolio-items" id="profile-portfolio-items">
							<?php foreach ($userPortfolios as $userPortfolio) {?>
								<?php
																		$viewUrl = '/RentUser/Dashboard/MyPortfolio?action=view&id=' . $userPortfolio['id'];
																		$editUrl = '/RentUser/Dashboard/MyPortfolio?action=edit&id=' . $userPortfolio['id'];
																		$deleteUrl = '/RentUser/Dashboard/MyProfile?action=delete_portfolio&portfolio_id=' . $userPortfolio['id'];
																		?>
								<li class="signup-modal-trigger profile-portfolio-item" data-id="<?php echo $userPortfolio['id']?>">
									<div class="portfolio-header" style="display: none">
										<a href="<?php echo $editUrl?>" class="ajax-popup-link portfolio-edit-button">編集</a>
										<a href="<?php echo $deleteUrl?>" class="portfolio-delete-button">削除</a>
									</div>
									<div class="profile-portfolio-item-inner">
										<div class="mosaic-block fade">
											<a class="mosaic-overlay ajax-popup-link" href="<?php echo $viewUrl?>">
												<h6 class="profile-portfolio-hover-title"><?php echo $userPortfolio['Title']?></h6>
											</a> 
											<?php if ($userPortfolio['Photo']) {?>
											<a class="mosaic-backdrop profile-portfolio-thumb" href="#" style="background-image: url(<?php echo $userPortfolio['Photo']?>)"></a>
											<?php }?>
										</div>
									</div>
								</li>
							<?php }?>
						</ul>
						</div>
                    <?php }?>
				</div>
				</section>
				<section class="profile-components" id="resume">
					<div class="section-inner">
						<div class="row">
							<div class="profile-components-main col-md-9">
								<div class="profile-reviews feed-box" id="profile-reviews">
									<h2 class="section-title">
										最新レビュー
										<button style="<?php if (count($allReviews) < LIMIT_REVIEWS ) echo 'display: none;'?>" class="signup-modal-trigger profile-reviews-btn-top" ng-click="profile.openReviewsModal()" data-qtsb-label="view_more">
											<span ng-if="profile.user.reviews[profile.user.role].length > 0" class="ng-scope">レビューを全て見る</span>
										</button>
									</h2>
									<ul class="user-reviews ng-scope">
										<!--loop review-->
									<?php if (count($allReviews) == 0) {?>
									<li>まだレビューはありません。</li>
									<?php }?>
									<?php
									
foreach ( $allReviews as $reviewIndex => $review )
									{
										?>
									<li class="user-review ng-scope <?php if ($reviewIndex >= LIMIT_REVIEWS) echo 'hide'?>" itemprop="reviewRating" itemscope="">
											<img class="user-review-avatar" alt="" src="<?php echo getUser1Photo($review['user1'])?>">
											<a class="user-review-title ng-binding" href="<?php echo getSpaceUrl($review['space']['HashID'])?>"><?php echo $review['space']['Title']?></a>
											<span class="Rating Rating--labeled" data-star_rating="<?php echo number_format($review['AverageRating'], 1)?>">
												<span class="Rating-total">
													<span class="Rating-progress" style="width:<?php echo showWidthRatingProgress($review['AverageRating'])?>%"></span>
												</span>
											</span>
											<?php if ($review['Comment']) {?>
											<p itemprop="description">
												“
												<span ng-bind="review.get().description" class="ng-binding"><?php echo $review['Comment']?></span>
												”
											</p>
											<?php }?>
											<span class="user-review-details ng-binding">
												<a href="<?php echo getUser1ProfileUrl($review['user1'])?>">
													<span class="user-review-name ng-binding"><?php echo $review['user1']['NameOfCompany']?></span>
												</a>
												<span class="thedate"><?php echo renderHumanTime($review['created_at']) ?></span>
											</span>
											<ul class="user-rating-info">
												<li class="place ng-scope">
													<span class="user-rating-info-item ng-binding">
														<i class="fa fa-map-marker" aria-hidden="true"></i>
													<?php echo $review['space']['Prefecture'].$review['space']['District'].$review['space']['Address1']?>
												</span>
												</li>
												<!-- end place that rating user has office at -->
												<li class="space-type ng-scope">
													<span class="user-rating-info-item ng-binding">
														<i class="fa fa-building" aria-hidden="true"></i>
													<?php echo $review['space']['Type']?>
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
									<button id="view_more_reviews_btn" style="<?php if (count($allReviews) < LIMIT_REVIEWS ) echo 'display: none;'?>" class="profile-widget-expand signup-modal-trigger ng-scope" data-qtsb-label="view_more">レビューを全て見る</button>
								</div>
								<!--/#profile-reviews-->
							</div>
							<!--/profile-components-main-->
							<div class="profile-components-side col-md-3">
								<section class="profile-side-verifications feed-box">
									<h2 class="section-title">認証</h2>
									<ul class="VerificationsList">
										<li class="VerificationsList-item <?php echo $isPaymentSetup ? 'is-VerificationsList-verified' : ''?>">
											<span class="VerificationsList-label">
												<span class="VerificationsList-label-icon Icon">
													<i class="fa fa-credit-card" aria-hidden="true"></i>
												</span>
												決済方法認証
											</span>
										<?php if ($isPaymentSetup) {?>
										<span class="VerificationsList-verifiedIcon Icon">
												<i class="fa fa-check" aria-hidden="true"></i>
											</span>
										<?php }else {?>
											<div>
												<a href="{{url('/RentUser/Dashboard/BasicInfo/Edit')}}" class="btn btn-mini">認証する</a>
											</div>
										<?php }?>
									</li>
										<li class="VerificationsList-item <?php echo $user->Tel ? 'is-VerificationsList-verified' : ''?>">
											<span class="VerificationsList-label">
												<span class="VerificationsList-label-icon Icon">
													<i class="fa fa-phone" aria-hidden="true"></i>
												</span>
												電話番号認証
											</span>
										<?php if ($user->Tel) {?>
										<span class="VerificationsList-verifiedIcon Icon">
												<i class="fa fa-check" aria-hidden="true"></i>
											</span>
										<?php }else {?>
											<div>
												<a href="{{url('/RentUser/Dashboard/BasicInfo/Edit')}}" class="btn btn-mini">認証する</a>
											</div>
										<?php }?>
									</li>
										<li class="VerificationsList-item <?php echo $user->IsEmailVerified = 'Yes' ? 'is-VerificationsList-verified' : ''?>">
											<span class="VerificationsList-label">
												<span class="VerificationsList-label-icon Icon">
													<i class="fa fa-envelope" aria-hidden="true"></i>
												</span>
												メールアドレス認証
											</span>
										<?php if ($user->IsEmailVerified = 'Yes') {?>
										<span class="VerificationsList-verifiedIcon Icon">
												<i class="fa fa-check" aria-hidden="true"></i>
											</span>
										<?php }else {?>
											<div>
												<a href="{{url('/RentUser/Dashboard/BasicInfo/Edit')}}" class="btn btn-mini">認証する</a>
											</div>
										<?php }?>
									</li>
										<li class="VerificationsList-item <?php echo $isProfileFullFilled ? 'is-VerificationsList-verified' : ''?>">
											<span class="VerificationsList-label">
												<span class="VerificationsList-label-icon Icon">
													<i class="fa fa-user" aria-hidden="true"></i>
												</span>
												個人証明認証
											</span>
										<?php if ($isProfileFullFilled ) {?>
										<span class="VerificationsList-verifiedIcon Icon">
												<i class="fa fa-check" aria-hidden="true"></i>
											</span>
										<?php }else {?>
											<div>
												<a href="{{url('/RentUser/Dashboard/BasicInfo/Edit')}}" class="btn btn-mini">認証する</a>
											</div>
										<?php }?>
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
		</div>
		<!--footer-->
		<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/common_footer.php'); ?>
		@include('pages.common_footer')
		<!--/footer-->
	</div>
	<!--/viewport-->
	<!-- Magnific Popup core JS file -->
	<script src="/js/magnific-popup/dist/jquery.magnific-popup.js"></script>
	<script src="<?php echo SITE_URL?>js/chosen/chosen.jquery.min.js" type="text/javascript"></script>
	<script src="<?php echo SITE_URL?>js/chosen/chosen.proto.min.js" type="text/javascript"></script>
	<script src="<?php echo SITE_URL?>js/chosen/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?php echo SITE_URL?>js/address_select.js" type="text/javascript"></script>
	<script type="text/javascript" src="<?php echo SITE_URL?>js/cropimage/js/jquery.form.js"></script>
	<script>
jQuery(document).ready(function($) {
	//クリックしたときのファンクションをまとめて指定
	$('.tab-nav li').click(function() {

		//.index()を使いクリックされたタブが何番目かを調べ、
		//indexという変数に代入します。
		var index = $('.tab-nav li').index(this);

		//コンテンツを一度すべて非表示にし、
		$('.tab-con .content li.tabli').css('display','none');

		//クリックされたタブと同じ順番のコンテンツを表示します。
		$('.tab-con .content li.tabli').eq(index).css('display','block');

		//一度タブについているクラスselectを消し、
		$('.tab-nav li').removeClass('select');

		//クリックされたタブのみにクラスselectをつけます。
		$(this).addClass('select')
	});
});
</script>
	<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('#thumbviewimage, #profileImageUploader').click(function(e){
            e.preventDefault();
        });

        $('#popover_content_wrapper').on('show.bs.modal', function (e) {
	   		$('#popover_content_wrapper form[name="thumbnail"] #image-type').val($(e.relatedTarget).attr('image-type'));
        	$('#popover_content_wrapper form.uploadform .image-id').val($(e.relatedTarget).attr('image-type'));

			/*var imageData = $(e.relatedTarget).find('input').val();
        	if(imageData){
        		imageData = $.parseJSON(imageData);
        		showResponse(imageData);
            }*/

			// Init avatar image
	     	<?php 
/*
	       * if (isset($_SESSION['avatar_image'])) :?>
	       * showResponse('<?php echo $_SESSION['avatar_image']?>');
	       * $('.modal.in #filename').val('<?php echo
	       * $_SESSION['avatar_image']?>');
	       * <?php endif
	       */
							?>
   		})

    	$('body').on('click', '.modal.in #save_thumb', function() {
    		var x1 = $('.modal.in #x1').val();
    		var y1 = $('.modal.in #y1').val();
    		var x2 = $('.modal.in #x2').val();
    		var y2 = $('.modal.in #y2').val();
    		var w = $('.modal.in #w').val();
    		var h = $('.modal.in #h').val();
    		if(x1=="" || y1=="" || x2=="" || y2=="" || w=="" || h==""){
    			alert("<?php echo trans('common.Please make a selection first')?>");
    			return false;
    		}else{
    			// Ajax Upload and Crop
    		$('.modal.in form[name="thumbnail"]').ajaxForm({
            	url: $(this).attr('action'),
                success:    showResponseSubmit
            }).submit();
    		}
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
				console.log(response);
	    		//alert(response);

				var image_type = $('form[name="thumbnail"] #image-type').val();
	    		$('#'+image_type).val(response.file_thumb_path);
	    		// Display image preview
	    		//$('.edit-logo-thumbnail-wrapper').css('background-image', 'url("'+ (response.file_thumb) +'?t='+ (new Date().getTime()) +'")')
	    		$('.background-'+image_type).css('background-image', 'url("'+ (response.file_thumb_path) +'?t='+ (new Date().getTime()) +'")')
	    	    		//	$('.background-'+image_type).html('<img src="'+response.file_thumb_path+'"   style="position: relative;" alt="Thumbnail Preview" />');

	            // Close modal
	            jQuery('.modal').modal('hide');
            }
            else {
                alert('Error Occured!');
            }
        }
        function updateCoords(c)
    	{
    		jQuery('#x1').val(c.x);
    		jQuery('#x2').val(c.x);
    		jQuery('#y1').val(c.y);
    		jQuery('#y2').val(c.y);
    		jQuery('#w').val(c.w);
    		jQuery('#h').val(c.h);
    	};

    	function showResponse(response, statusText, xhr, $form){
    		response = $.parseJSON(response);
    		var responseText = response.name;
    		var imageSize = response.size;
    		image_src = responseText;

    		// Get smallest between width vs height	
    		var aspectSmaller = imageSize[0] >= imageSize[1] ? imageSize[1] : imageSize[0];
    		var aspectBigger = imageSize[0] >= imageSize[1] ? imageSize[0] : imageSize[1];
    		wraperClass = '';
    		if (xhr) {
}
        		var image_src = "<?php echo UPLOAD_PATH_AVATAR_URL; ?>" + responseText;
        		var wraperClass = '.modal.in ';

    	    if(responseText.indexOf('.')>0){
    			//$(wraperClass + ' #thumbviewimage').html('<img src="'+image_src+'"   style="position: relative;" alt="Thumbnail Preview" />');
    	    	$(wraperClass + ' #viewimage').html('<img class="preview" alt="" src="'+image_src+'"   id="thumbnail" />');
    	    	$(wraperClass + ' #filename').val(responseText);

    	    	$(wraperClass + ' #thumbnail').Jcrop({
		 			  aspectRatio: 1,
		 		      boxWidth: 400,   //Maximum width you want for your bigger images
		 		      boxHeight: 300,  //Maximum Height for your bigger images
		 			  setSelect: [ 0, 0, aspectBigger, aspectBigger ],
		 			  onSelect: updateCoords,
		 			  onChange: updateCoords,
		 			},function(){
		 			  var jcrop_api = this;
		 			  thumbnail = this.initComponent('Thumbnailer', { width: 130, height: 130 });
		 			});


    			var img = new Image();
    			img.onload = function() {
    				var img = document.getElementById("thumbnail");
    				selection = {x1: 48, y1: 0, x2: 240, y2: 192, width: 192, height: 192};

        		}
    			img.src = image_src;



    		}else{
    			//$(wraperClass + ' #thumbviewimage').html(responseText);
    	    	$(wraperClass + ' #viewimage').html(responseText);
    		}
        }

    	function showResponseCover(responseText, statusText, xhr, $form)
    	{

    		if(responseText.indexOf('.')>0){
        		$('.profile-cover-wrapper').css('background-image', "url('<?php echo url('/images/covers') . '/' ?>" + responseText + "?t="+ (new Date().getTime()) +"')");
        		$('.cover-image-upload-confirmation').hide();
        		$('.upload_cover_message_error').hide();
				var img='/images/covers/'+ responseText;
				jQuery.ajax({
            type: "POST",
            url : '/RentUser/Dashboard/MyProfile/CoverUpload',
            data : { Cover:img},
			success: function(data){
			   }
			});
    		}
    		else{
    			$('.upload_cover_message_error').html(responseText);
    			$('.upload_cover_message_error').show();
    		}
        }

    	$('body').on('click', '.modal.in #btn-image-save', function(){
        	$('.modal.in #imagefile').val('');
    		$('.modal.in #imagefile').click();
    	});

    	$('body').on('click', '.cover-image-upload-trigger', function(){
        	$('#cover_image').val('');
    		$('#cover_image').click();
    	});

    	$('body').on('click', '#submit_cover_image', function(e){
    		$("#form_cover_image").ajaxForm({
            	url: '/upload-image.php',
                success:    showResponseCover
            }).submit();
    	});

    	$('body').on('click', '.cover_image_cancel', function(){
    		$('.upload_cover_message_error').hide();
    	});

    	$('body').on('change', '#cover_image', function(){
        	//$('.cover-image-upload-confirmation').show();
        	$('#submit_cover_image').click();
    	});

        $('body').on('change', '.modal.in #imagefile', function() {
        	$(".modal.in #viewimage").html('');
            $(".modal.in #viewimage").html('<img src="/images/loading.gif" />');
            $(".modal.in .uploadform").ajaxForm({
            	url: '/upload-image.php',
                success:    showResponse
            }).submit();
        });

    });
</script>
	<script>
jQuery(function($){

    // 全ての駅名を非表示にする
    jQuery(".budget-price1").addClass('hide');
    // 路線のプルダウンが変更されたら
    jQuery("#choose_budget_per").change(function(event){
		event.preventDefault();
        chooseBudget();
    });

    $(".input-container.iconbutton").click(function(){
    	$(this).toggleClass("checked");
		var checkBoxes =  jQuery("#"+jQuery(this).data("id"));
  checkBoxes.prop("checked", !checkBoxes.prop("checked"));
    	if($('.iconbutton-metting').hasClass('checked') || $('.iconbutton-semiar-space').hasClass('checked'))
    	{
        	 $('#choose_budget_per_hour').show();
        	 $('#choose_budget-price-hour').show();
        }
    	else {
    		 $('#choose_budget_per_hour').hide();
        	 $('#choose_budget-price-hour').hide();
    	}
    });
})
function chooseBudget()
{
	   // 全ての駅名を非表示にする
        jQuery(".budget-price1").addClass('hide');
        // 選択された路線に連動した駅名プルダウンを表示する
        jQuery('.' + jQuery("#choose_budget_per option:selected").val()).removeClass("hide");
}

</script>
	<script type="text/javascript">
jQuery.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
    }
});
	jQuery(document).ready(function($){
		$('.portfolio-delete-button').click(function(e){
			if (confirm('本当に実績を削除しますか?'))
			{
				return true;
			}
			return false;
		});
		jQuery('.btnSaveSkills').click(function(e){
			e.preventDefault();
			var wraper = $(this).closest('.editable-block');
			var Skills = wraper.find(".profile-skills-select option:selected").map(function() {return this.value;}).get().join(',');
			jQuery.ajax({
            type: "POST",
            url : '/RentUser/Dashboard/MyProfile/Edit2',
            data : { Skills:Skills},
			   success: function(data){
					var sklList = Skills.split(',');
					var items = [];
					jQuery('.skill-list').empty();
                   if(sklList != ''){
					   jQuery.each(sklList, function(i, item) {
					       items.push('<li>' + item + '</li>');
					   });
					   $('.skill-label').show();
					   $('.no-content-text').hide();
                   }
                   else {
                	   $('.skill-label').hide();
                	   $('.no-content-text').show();
                   }
					jQuery('.skill-list').append(items.join(''));
					jQuery('#profile-skills').val(sklList).trigger('chosen:updated');
					jQuery('#profile-skills-mobile').val(sklList).trigger('chosen:updated');
			   }
			});
			jQuery('#CloseSkills').click();
			jQuery('#profile-skills').val(Skills.split(',')).trigger('chosen:updated');
			jQuery('#profile-skills-mobile').val(Skills.split(',')).trigger('chosen:updated');
		});

		jQuery('.btnSaveBSummary').click(function(){
			var wraper = $(this).closest('.editable-block-wraper');
			var bSummary = wraper.find('.profiles-description').val();
			jQuery.ajax({
	            type: "POST",
	            url : '/RentUser/Dashboard/MyProfile/Edit2',
	            data : { BusinessSummary:bSummary},
				success: function(data){
					bSummary = bSummary ? bSummary : '紹介文を記入してください';
					//bSummary = bSummary.replace(/(?:\r\n|\r|\n)/g, '<br />');
					$('.profile-about-description .edit-content').html(bSummary);
					$('.profiles-description').val(bSummary);
				}
			});
		});

		jQuery('.btnSaveSubTitle').click(function(){
			var SubTitle = jQuery('.profiles-title').val();
			jQuery.ajax({
            type: "POST",
            url : '/RentUser/Dashboard/MyProfile/Edit2',
            data : { SubTitle:SubTitle},
			success: function(data){
			   }
			});
		});

		LoadSelectedOptions();
	});

	function LoadSelectedOptions()
	{
		var sklList = ('<?php echo $user->Skills ?>').split(',');
		var items = [];
		jQuery('.skill-list').empty();
        if(sklList != ''){
            jQuery.each(sklList, function(i, item) {
              items.push('<li>' + item + '</li>');
            });
        }
		jQuery('.skill-list').append(items.join(''));
		jQuery('#profile-skills').val(sklList).trigger('chosen:updated');
		jQuery('#profile-skills-mobile').val(sklList).trigger('chosen:updated');

	}
	function LoadDetail()
	{

	}

	jQuery('body').on('click', '#view_more_reviews_btn', function(){
		jQuery('li.user-review').removeClass('hide');
		jQuery(this).hide();
  })
</script>
</body>
</html>
