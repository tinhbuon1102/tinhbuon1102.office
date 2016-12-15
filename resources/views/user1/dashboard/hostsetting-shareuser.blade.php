
<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header.php'); ?>
@include('pages.header')
<!--/head-->
<body class="mypage shareuser">
	<div class="viewport">
		<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header_nav_shareuser.php'); ?>
		@include('pages.header_nav_shareuser')
		<div class="main-container">
			<div id="main" class="container fixed-container">
				<div id="left-box">@include('user1.dashboard.left_nav')</div>
				<!--/leftbox-->
				<div class="right_side" id="samewidth">
					<div id="page-wrapper" class="has_fixed_title">
						
						<div id="SettingPage" class="container-fluid">
                   <?php 
$user = Auth::guard('user1')->user(); 
 if (!\App\User1::isProfileFullFill($user)){?>
                        <div class="dashboard-warn-text">
                        <div class="dashboard-must-validation">
                        <i class="icon-warning-sign fa awesome"></i>
                        <div class="warning-heading">必須のアカウント情報が設定されていません。</div>
                        </div>
                        </div>
                        <?php }?>
                        @if( empty($bank['BankName']) )
                        <div class="dashboard-warn-text">
                        <div class="dashboard-must-validation">
                        <i class="icon-warning-sign fa awesome"></i>
                        <div class="warning-heading">支払受取情報が設定されていません。</div>
                        </div>
                        </div>
                        @endif
                        
                        <?php if ($user->IsAdminApproved == 'No') {?>
								<div id="feed">
									<section class="feed-first-row feed-box" id="certificate">
										<div class="dashboard-section-heading-container">
											<h3 class="dashboard-section-heading">
												本人確認書類
												<!--Company Certificate-->
											</h3>
										</div>
										<div class="space-setting-content">
											<div class="form-container">
                                            @if( empty($bank['BankName']) OR !\App\User1::isProfileFullFill($user) )
                                            <div class="alert-identity-message">本人確認書類提出の前に、以下の設定を完了させてください。
                                            <ul class="list-disc">
                                            @if( !\App\User1::isProfileFullFill($user) )
                                            <li>必須のアカウント情報を設定</li>
                                            @endif
                                            @if( empty($bank['BankName']) )
                                            <li>支払受取情報を設定</li>
                                            @endif
                                            </ul>
                                            </div>
                                            <a href="#" class="btn ocean-btn disable">確認書類を提出</a>
                                            @else
												<?php if(!$user->SentToAdmin) {?>
												<!--show this alert after doc is not send yet-->
												<div class="alert-identity-message">本人確認書類が提出されていません。本人証明が完了後、アカウントの制限は解除されます。</div>
												<div class="btn-group">
													<a href="{{url('/')}}/ShareUser/Dashboard/HostSetting/Certificate" class="btn ocean-btn">確認書類を提出</a>
												</div>
												<!--/show this alert doc is not send yet-->
												<?php } else {?>
												<!--show this alert after doc is send-->
												<div class="alert-identity-message">書類が提出され、只今審査中です。本人確認が終わり次第、アカウントの制限は解除されます。</div>
												<div class="btn-group">
													<a href="{{url('/')}}/ShareUser/Dashboard/HostSetting/Certificate" class="btn ocean-btn">確認書類を再提出</a>
												</div>
												<!--/show this alert after doc is send-->
												<?php }?>
                                                @endif
											</div>
											<!--/form-container-->
										</div>
										<!--/space-setting-content-->
									</section>
								</div>
								<!--/feed-->
								<?php }?>
							<div id="feed">
								<section class="feed-first-row feed-box" id="basic">
									<div class="dashboard-section-heading-container">
										<h3 class="dashboard-section-heading">アカウント情報</h3>
									</div>
									<div class="space-setting-content">
										<div class="form-container">
											<div class="form-field two-inputs">
												<div class="input-container input-half">
													<label for="userName">ユーザー名</label>
													<input name="UserName" value="{{$user->UserName}}" type="text" data-target="signup-username" readonly disabled>
												</div>
												<div class="input-container input-half">
													<form method="post" id="chgemail" action="/ShareUser/Dashboard/ChangeEmail">
														<label for="Email">
															メールアドレス&nbsp;
															<a href="#!" class="label-link" id="changeEmail">[変更]</a>
														</label>
														<input name="Email" value="{{$user->Email}}" type="email" id="Email" data-target="signup-email" required readonly disabled>
														<button type="submit" class="btn btn-info changeEmailBtn" style="display: none;">メールアドレスを変更</button>
													</form>
													<!--if email is not verified yet-->
													<?php if($user->IsEmailVerified=="No"){ ?>
													<div class="no-verify-alert">
														<span class="not-verify-yet">あなたのメールアドレスは認証されてません。</span>
														<a href="#" class="verify-now btn btn-info" id="verifyEmail">メールアドレスを認証</a>
													</div>
													<?php } ?>
													<!--/if email is not verified yet-->
												</div>
											</div>
											<!--/form-field-->
										</div>
									</div>
								</section>
							</div>
							<div id="feed">
								<section class="feed-first-row feed-box" id="basic">
									<div class="dashboard-section-heading-container">
										<h3 class="dashboard-section-heading">パスワード</h3>
									</div>
									<div class="space-setting-content">
										<div class="form-container">
											<form method='post' class="fl-form" id='changepassword' action="/ShareUser/Dashboard/ChangePassword">
												<div class="form-field two-inputs">
													<div class="input-container input-half">
														<label for="CurrentPass">現在のパスワード</label>
														<input id="oldPasswd" name="oldpassword" type="password">
													</div>
												</div>
												<!--/form-field-->
												<div class="form-field two-inputs">
													<div class="input-container input-half">
														<label for="NewPass">新しいパスワード</label>
														<input id="newPasswd1" name="password" type="password">
													</div>
												</div>
												<!--/form-field-->
												<div class="form-field two-inputs">
													<div class="input-container input-half">
														<label for="ConfirmPass">新しいパスワード(確認)</label>
														<input id="newPasswd2" name="password_confirmation" type="password">
													</div>
												</div>
												<!--/form-field-->
												<div class="set-btn">
													<button id="passwordSettingsSubmitBtn" class="btn btn-info submitSettingsBtn" type="submit">パスワードを変更</button>
												</div>
											</form>
										</div>
									</div>
								</section>
							</div>
							<form enctype='multipart/form-data' method="post" action="{{ url('ShareUser/Dashboard/HostSetting') }}">
								{{ csrf_field() }}
								<div class="page-header header-fixed">
									<div class="container-fluid">
										<div class="row">
											<div class="col-xs-6 col-md-6 col-sm-8 clearfix">
												<h1 class="pull-left">
													<i class="fa fa-cogs" aria-hidden="true"></i>
													設定
												</h1>
											</div>
											<div class="col-xs-6 col-md-6 col-sm-4 clearfix pb15 text-right">
												<button id="saveSettingInfo" type="submit" class="btn btn-default mt15 dblk-button" data-bind="jqButton: { disabled: !isDirty() }, click: save" role="button">
													<i class="fa fa-floppy-o"></i>
													<span class=""> 保存</span>
												</button>
											</div>
											<!--/col-xs-6-->
										</div>
									</div>
								</div>
								<!--/page-header header-fixed-->
								
								<div id="feed">
									<section class="feed-event recent-follow feed-box" id="profile">
										<div class="dashboard-section-heading-container">
											<h3 class="dashboard-section-heading">
												会社情報
												<!--Company Profile-->
											</h3>
										</div>
										<div class="space-setting-content">
											<div class="form-container">
												<div class="form-field">
													<label for="SpaceTitle">
														<span class="require-mark">*</span>
														会社名
														<!--5%-->
														<!--Company Name-->
													</label>
													<div class="input-container">
														<input name="NameOfCompany" id="NameOfCompany" value="{{$user->NameOfCompany}}" required="" ng-model="setting.space_title" type="text" class="ng-invalid" aria-invalid="true" placeholder="株式会社オフィスポ">
													</div>
												</div>
												<div class="form-field address-wrapper">
													<div class="form-field two-inputs">
														<div class="input-container input-half">
															<label for="zip">
																<span class="require-mark">*</span>
																郵便番号
																<!--Postal code-->
															</label>
															<input name="PostalCode" id="zip" type="text" value="{{$user->PostalCode}}" 　class="ng-pristine ng-untouched ng-invalid-required" aria-required="true">
														</div>
													</div>
													<!--/form-field-->
													<div class="form-field two-inputs">
														<div class="input-container input-half">
															<label for="zip">
																<span class="require-mark">*</span>
																都道府県
																<!--Prefecture-->
															</label>
															<select id="Prefecture" name="Prefecture" class="confidential">
																<option value=""></option>
																<option value="北海道">北海道</option>
																<option value="青森県">青森県</option>
																<option value="岩手県">岩手県</option>
																<option value="宮城県">宮城県</option>
																<option value="秋田県">秋田県</option>
																<option value="山形県">山形県</option>
																<option value="福島県">福島県</option>
																<option value="茨城県">茨城県</option>
																<option value="栃木県">栃木県</option>
																<option value="群馬県">群馬県</option>
																<option value="埼玉県">埼玉県</option>
																<option value="千葉県">千葉県</option>
																<option value="東京都">東京都</option>
																<option value="神奈川県">神奈川県</option>
																<option value="新潟県">新潟県</option>
																<option value="富山県">富山県</option>
																<option value="石川県">石川県</option>
																<option value="福井県">福井県</option>
																<option value="山梨県">山梨県</option>
																<option value="長野県">長野県</option>
																<option value="岐阜県">岐阜県</option>
																<option value="静岡県">静岡県</option>
																<option value="愛知県">愛知県</option>
																<option value="三重県">三重県</option>
																<option value="滋賀県">滋賀県</option>
																<option value="京都府">京都府</option>
																<option value="大阪府">大阪府</option>
																<option value="兵庫県">兵庫県</option>
																<option value="奈良県">奈良県</option>
																<option value="和歌山県">和歌山県</option>
																<option value="鳥取県">鳥取県</option>
																<option value="島根県">島根県</option>
																<option value="岡山県">岡山県</option>
																<option value="広島県">広島県</option>
																<option value="山口県">山口県</option>
																<option value="徳島県">徳島県</option>
																<option value="香川県">香川県</option>
																<option value="愛媛県">愛媛県</option>
																<option value="高知県">高知県</option>
																<option value="福岡県">福岡県</option>
																<option value="佐賀県">佐賀県</option>
																<option value="長崎県">長崎県</option>
																<option value="熊本県">熊本県</option>
																<option value="大分県">大分県</option>
																<option value="宮崎県">宮崎県</option>
																<option value="鹿児島県">鹿児島県</option>
																<option value="沖縄県">沖縄県</option>
															</select>
														</div>
														<div class="input-container input-half">
															<label for="zip">
																<span class="require-mark">*</span>
																市区町村
																<!--District-->
															</label>
															<input name="District" id="district" value="{{$user->District}}" type="text" class="ng-pristine ng-untouched ng-invalid-required" aria-required="true" placeholder="横浜市緑区">
														</div>
													</div>
													<!--/form-field-->
													<div class="form-field two-inputs">
														<div class="input-container input-half">
															<label for="addr">
																<span class="require-mark">*</span>
																番地
																<!--Street number-->
															</label>
															<input name="Address1" id="Addr" value="{{$user->Address1}}" required="" ng-model="signup.addr" type="text" class="ng-pristine ng-untouched ng-invalid-required" aria-required="true" placeholder="六本木1-1-1">
														</div>
														<div class="input-container input-half">
															<label for="addr">
																建物名・階・部屋番号
																<!--Buidling name,room number-->
															</label>
															<input name="Address2" id="Addr2" value="{{$user->Address2}}" ng-model="signup.addr2" type="text" class="ng-pristine ng-untouched" placeholder="オフィスポビル1024">
														</div>
													</div>
													<!--/form-field-->
												</div>
												<!--/form-field-->
												
												<div></div>
												<!--/if you click edit link,show this-->
												<div class="form-field two-inputs">
													<div class="input-container input-half">
														<label for="phoneNumber">
															<span class="require-mark">*</span>
															電話番号
															<!--5%-->
															<!--Phone number-->
														</label>
														<input name="Tel" id="phone-number" value="{{$user->Tel}}" type="text" 　class="ng-pristine ng-untouched ng-invalid-required" aria-required="true">
													</div>
												</div>
												<div class="form-field two-inputs">
													<div class="input-container input-half">
														<label for="categoryBusiness">
															<span class="require-mark">*</span>
															事業のタイプ
															<!--5%-->
															<!--Category of business-->
														</label>
														<select id="BusinessCat" name="BussinessCategory" class="old_ui_selector">
															<option value="カテゴリを選択" selected="">Choose business category</option>
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
														<label for="desire_number_people_inoffice">
															職場人数
															<!--5%-->
															<!--Number of employees-->
														</label>
														<select id="desire_numpeople_inoffice" name="NumberOfEmployee" data-label="人数を選択">
															<option value="" selected="">人数を選択</option>
															<option value="5人以下">5人以下</option>
															<option value="5人~10人">5人~10人</option>
															<option value="10人~20人">10人~20人</option>
															<option value="20人~30人">20人~30人</option>
															<option value="30人~40人">30人~40人</option>
															<option value="40人~50人">40人~50人</option>
															<option value="50人以上">50人以上</option>
														</select>
													</div>
												</div>
											</div>
											<!--/form-container-->
										</div>
										<!--/space-setting-content-->
									</section>
								</div>
								<!--/feed-->
								<div id="feed">
									<section class="feed-event recent-follow feed-box" id="rperson">
										<div class="dashboard-section-heading-container">
											<h3 class="dashboard-section-heading">
												アカウント責任者
												<!--Responsible person for this account-->
											</h3>
										</div>
										<div class="space-setting-content">
											<div class="form-container">
												<div class="form-field responsive-person-name-wrapper">
													<div class="form-field two-inputs">
														<div class="input-container input-half">
															<label for="last_name">
																<span class="require-mark">*</span>
																姓
																<!--Last name-->
															</label>
															<input name="LastName" id="LastName" value="{{$user->LastName}}" required="" ng-model="signup.last_name" type="text" class="ng-pristine ng-untouched ng-invalid ng-invalid-required" aria-invalid="true" aria-required="true" placeholder="佐藤">
														</div>
														<div class="input-container input-half">
															<label for="last_name">
																<span class="require-mark">*</span>
																名
																<!--First name-->
															</label>
															<input name="FirstName" id="FirstName" value="{{$user->FirstName}}" required="" ng-model="signup.first_name" type="text" class="ng-pristine ng-invalid ng-invalid-required ng-untouched" aria-invalid="true" aria-required="true" placeholder="太郎">
														</div>
													</div>
													<!--/form-field-->
													<div class="form-field two-inputs">
														<div class="input-container input-half">
															<label for="last_name">
																<span class="require-mark">*</span>
																姓(ふりがな)
																<!--Last name kana-->
															</label>
															<input name="LastNameKana" id="LastNameKana" value="{{$user->LastNameKana}}" required="" ng-model="signup.last_name_kana" type="text" class="ng-pristine ng-untouched ng-invalid ng-invalid-required" aria-invalid="true" aria-required="true" placeholder="さとう">
														</div>
														<div class="input-container input-half">
															<label for="last_name">
																<span class="require-mark">*</span>
																名(ふりがな)
																<!--First name kana-->
															</label>
															<input name="FirstNameKana" id="FirstNameKana" value="{{$user->FirstNameKana}}" required="" ng-model="signup.first_name_kana" type="text" class="ng-pristine ng-invalid ng-invalid-required ng-untouched" aria-invalid="true" aria-required="true" placeholder="たろう">
														</div>
													</div>
													<!--/form-field-->
												</div>
												<!--/form-field-->
												
												<div class="form-field two-inputs">
													<div class="input-container input-half">
														<label for="business_title">
															役職
															<!--5%-->
															<!--Business title-->
														</label>
														<input name="BusinessTitle" id="BusinessTitle" value="{{$user->BusinessTitle}}" type="text" class="" placeholder="代表取締役">
													</div>
													<div class="input-container input-half">
														<label for="department">
															部署
															<!--5%-->
															<!--Department-->
														</label>
														<input name="Department" id="Department" value="{{$user->Department}}" ng-model="signup.department" type="text" class="">
													</div>
												</div>
												<!--/form-field-->
												<div class="form-field two-inputs">
													<div class="input-container input-half">
														<label for="cellphone_number">
															携帯番号
															<!--5%-->
															<!--Cellphone-->
														</label>
														<input name="CellPhoneNum" id="CellphoneNum" value="{{$user->CellPhoneNum}}" ng-model="signup.cellphone_num" type="text" class="" aria-invalid="true" placeholder="090-1234-5678">
													</div>
												</div>
											</div>
											<!--/form-container-->
										</div>
										<!--/space-setting-content-->
									</section>
								</div>
								<!--/feed-->
								<div id="feed">
									<section class="feed-event recent-follow feed-box" id="set-logo">
										<div class="dashboard-section-heading-container">
											<h3 class="dashboard-section-heading">
												ロゴ設定
												<!--Profile picture-->
											</h3>
										</div>
										<div class="space-setting-content">
											<div class="form-container">
												<div class="form-field two-inputs">
													<div class="input-container input-half logo-upload-wrapper">
														<label for="SpaceMainPhoto">
															ロゴ
															<!--10%-->
															<!--Logo-->
														</label>
														<div class="edit-logo-wrapper">
															<div class="edit-logo-thumbnails edit-main-picture edit-logo-thumbnails-placeholder">
																<div class="edit-logo-thumbnail-wrapper" id="background-Logo" data-bind="click: add" style=<?php if(!empty($user->Logo)) echo 'background-image:url("'.($user->Logo).'")'?>></div>
																<input type="hidden" name="Logo" id="Logo">
															</div>
														</div>
														<div class="edit-logo-buttons" data-toggle="modal" data-target="#popover_content_wrapper" image-type="Logo">
															<?php if(empty($user->Logo)) { ?>
															<button class="upload-button btn ui-button-text-only yellow-button" data-bind="click: add, jqButton: { disabled: false }" role="button" aria-disabled="false">
																<span class="ui-button-text">アップロード</span>
															</button>
															<? } else { ?>
															<button class="upload-button btn ui-button-text-only yellow-button" data-bind="click: add, jqButton: { disabled: false }" role="button" aria-disabled="false">
																<span class="ui-button-text">変更</span>
															</button>
															<? } ?>
														</div>
													</div>
													<!--/input-container-->
												</div>
												<!--/form-field-->
											</div>
											<!--/form-container-->
										</div>
										<!--/space-setting-content-->
									</section>
								</div>
								<!--/feed-->
							</form>
                            <a id="BankLink"></a>
							<?/*
<div id="feed">
<section class="feed-event booking-window feed-box">
<div class="dashboard-section-heading-container">
<h3 class="dashboard-section-heading">
予約受付設定
<!--Booking Window-->
</h3>
</div>
<div class="space-setting-content">
<div class="form-container">
<p class="exp">Set up a booking window to prevent members from booking with too little notice or too far into the future.</p>
<a href="javascript:void(0)" bind-toggle="#EditBookingWindow, .add-booking" class="toggle_button add-booking btn yellow-button">Add a Booking Window</a>
<!--show this after click Add a Booking Window-->
<form id="EditBookingWindow" style="display: none;">
<div class="notice-container clearfix">
<div class="form-field">
<span class="notice-label">Min notice:</span>
<input class="text-box" data-val="true" data-val-number="The field Min notice must be a number." id="txtAdvanceNotice" name="MinNotice" type="text" value="2">
<select updatedmarkforplaces="LSCommon.ShowUpdatedMarkForPlaces" id="cboAdvanceNoticeType" name="MinNoticeType" style="width: 75px">
<option selected="selected" value="Hours">Hours</option>
<option value="Days">Days</option>
</select>
<span class="field-validation-valid display-block" data-valmsg-for="AdvanceNotice" data-valmsg-replace="true"></span>
</div>
<div class="form-field">
<span class="notice-label">Max notice:</span>
<input class="text-box" data-val="true" data-val-number="The field Max notice must be a number." id="txtUnavailableAfter" name="MaxNotice" type="text" value="0">
<label>Days</label>
<span class="field-validation-valid display-block" data-valmsg-for="UnavailableAfter" data-valmsg-replace="true"></span>
</div>
<div class="form-field target-space">
<span class="notice-label">Share Space</span>
<select id="select-share-space-target" name="ShareSpace">
<option selected="selected" value="全てのシェアスペース">All Share Spaces</option>
</select>
<div class="btn-wrapper">
<button class="upload-button btn ui-button-text-only yellow-button" role="button">
<span class="ui-button-text">Save</span>
</button>
<button class="toggle_button cancel-button btn ui-button-text-only yellow-button" role="button" bind-toggle="#EditBookingWindow, .add-booking">
<span class="ui-button-text">Cancel</span>
</button>
</div>
</div>

</div>
</form>
<!--show this after click Add a Booking Window-->
<div class="saved-table-wrapper">
<table class="saved-booking-window">
<thead>
<tr>
<th>Min notice</th>
<th>Max notice</th>
<th>Share Space</th>
<th class="edit-th"></th>
</tr>
</thead>
<tbody>
<tr>
<td>2 Hours</td>
<td>1 Day</td>
<td>All share spaces</td>
<td class="edit-td">
<i class="fa fa-pencil" aria-hidden="true"></i>
</td>
</tr>
</tbody>
</table>
</div>
<!--/saved-table-wrapper-->
</div>
<!--/form-container-->
</div>
<!--/space-setting-content-->

</section>
</div>
<!--/feed-->
*/ ?>
							<div id="feed">
								<section class="feed-event recent-follow feed-box" id="payinfo">
									<div class="dashboard-section-heading-container">
										<h3 class="dashboard-section-heading">
											支払受取情報
											<!--15%-->
											<!--Payment Info-->
										</h3>
										<a class="toggle_button edit" bind-toggle=".bank-account-edit-container, .saved-bank-account" href="#"><i class="fa fa-pencil" aria-hidden="true"></i>編集</a>
									</div>
									<form id="BankAccount" class="fl-form" method="post" action="{{url('ShareUser/Dashboard/HostSetting/BankInfo')}}">
										<div class="space-setting-content">
											<div class="saved-bank-account">
												<div class="saved-value">
													<label>
														口座の種類
														<!--Account Type-->
														:
													</label>
													<span id="spanAccountType">{{$bank->AccountType}}</span>
												</div>
												<div class="saved-value">
													<label>
														名義
														<!--Account Name-->
														:
													</label>
													<span id="spanAccountName">{{$bank->AccountName}}</span>
												</div>
												<div class="saved-value">
													<label>
														銀行名
														<!--Bank Name-->
														:
													</label>
													<span id="spanBankName">{{$bank->BankName}}</span>
												</div>
												<div class="saved-value">
													<label>
														支店名
														<!--Branch location name-->
														:
													</label>
													<span id="spanBranchLocationName">{{$bank->BranchLocationName}}</span>
												</div>
												<div class="saved-value">
													<label>
														口座番号
														<!--Account Number-->
														:
													</label>
													<span id="spanAccountNumber">{{$bank->AccountNumber}}</span>
												</div>
											</div>
											<!--/saved-bank-account-->
											<!--show here if you click edit-->
											<div class="bank-account-edit-container" style="display: none;">
												<div class="form-container">
													<div class="form-field">
														<div class="input-container input-half">
															<label for="AccountType">
																<span class="require-mark">*</span>
																口座の種類
																<!--Account Type-->
															</label>
															<div class="radio inline">
																<input type="radio" name="AccountType" id="checking" value="当座預金" aria-hidden="true" <? if($bank->AccountType=="当座預金"){ ?> checked <? } ?>>
																<label for="checking">当座預金</label>
															</div>
															<!--/radio inline-->
															<div class="radio inline">
																<input type="radio" name="AccountType" id="savings" value="普通預金" aria-hidden="true" @if($bank->
																AccountType=="普通預金") checked @endif>
																<label for="savings">普通預金</label>
															</div>
															<!--/radio inline-->
														</div>
													</div>
													<!--/form-field-->
													<div class="form-field">
														<div class="input-container input-half">
															<label for="AccountName">
																<span class="require-mark">*</span>
																名義
																<!--Account Name-->
															</label>
															<input id="nativeName" name="AccountName" type="text" class="hasHelp js_needsValidation validate" required="required" aria-required="true" value="{{$bank->AccountName}}" placeholder="銀行口座の名義" autocomplete="off">
															<!-- pattern="[\u30A0-\u30FF \s]*" aria-invalid="false" -->
														</div>
														<div class="input-container input-half">
															<label for="BankName">
																<span class="require-mark">*</span>
																銀行名
																<!--Bank Name-->
															</label>
															<input id="bankName" name="BankName" type="text" class="hasHelp  validate" required="required" aria-required="true" value="{{$bank->BankName}}" placeholder="銀行名" autocomplete="off" maxlength="64">
														</div>
													</div>
													<!--/form-field-->
													<div class="form-field">
														<div class="input-container input-half">
															<label for="BankName">
																<span class="require-mark">*</span>
																支店名
																<!--Branch location name-->
															</label>
															<input id="branchLocationName" name="BranchLocationName" type="text" class="hasHelp js_needsValidation validate" required="required" aria-required="true" value="{{$bank->BranchLocationName}}" placeholder="支店名" autocomplete="off" maxlength="32" aria-invalid="false">
															<!--pattern=".*"-->
														</div>
														<div class="input-container input-half">
															<label for="BankName">
																<span class="require-mark">*</span>
																支店コード
																<!--支店コード-->
															</label>
															<input id="branchCode" name="BranchCode" type="text" class="hasHelp js_needsValidation validate" required="required" aria-required="true" value="{{$bank->BranchCode}}" placeholder="支店コード" autocomplete="off" maxlength="3">
															<!--pattern="[0-9]{3}" -->
														</div>
													</div>
													<!--/form-field-->
													<div class="form-field">
														<div class="input-container input-half">
															<label for="accountNumber">
																<span class="require-mark">*</span>
																口座番号
																<!--Account Number-->
															</label>
															<input id="accountNumber" name="AccountNumber" type="text" class="hasHelp js_needsValidation validate cobrowse_mask" required="required" aria-required="true" value="{{$bank->AccountNumber}}" placeholder="口座番号" autocomplete="off" maxlength="7">
															<!--pattern="[0-9]{7}"-->
														</div>
													</div>
													<!--/form-field-->
													<div class="btn-wrapper">
														{{ csrf_field() }}
														<button type="submit" class="upload-button btn ui-button-text-only yellow-button" role="button">
															<span class="ui-button-text">保存</span>
														</button>
														<button class="toggle_button cancel-button btn ui-button-text-only" role="button" bind-toggle=".bank-account-edit-container, .saved-bank-account">
															<span class="ui-button-text cancel">キャンセル</span>
														</button>
													</div>
												</div>
												<!--/form-container-->
											</div>
											<!--/bank-account-edit-container-->
											<!--/show here if you click edit-->
										</div>
										<!--/space-setting-content-->
									</form>
								</section>
							</div>
							<!--/feed-->
							<div id="feed">
								<section class="feed-event window-managers feed-box" id="host-member">
									<div class="dashboard-section-heading-container">
										<h3 class="dashboard-section-heading">
											窓口担当者
											<!--Host members-->
										</h3>
									</div>
									<p class="exp">窓口担当者として追加されたメールアドレスに、予約受付時にお知らせが送信されます。</p>
									<div class="space-setting-content">
										<div class="form-container">
											<div class="input-wrapper">
												<div id="hostMember">
													@foreach($hosts as $host)
													<div class="admin-wrapper">
														<div class="aw-image-wrapper">
															<img id="img{{$host->HashID}}" src="<?php echo getHostMemberPhoto($host)?>" class="admin-image" data-bind="attr: { alt: MemberName, src: PictureUrl }" alt="{{$host->HostLastName}} {{$host->HostFirstName}} ">
														</div>
														<div id="name{{$host->HashID}}" class="aw-name" data-bind="text: MemberFirstName">{{$host->HostLastName}} {{$host->HostFirstName}}</div>
														<div id="email{{$host->HashID}}" class="aw-email" data-bind="text: Email">{{$host->HostEmail}}</div>
														<div class="aw-link">
                                                        <span>
															<a id="lnk{{$host->HashID}}" href="javascript:void(0)" onclick="EditDetail(this);" data-Image="{{$host->HostPhoto}}" data-Id="{{$host->HashID}}" data-FirstName="{{$host->HostFirstName}}" data-LastName="{{$host->HostLastName}}" data-Email="{{$host->HostEmail}}" data-Phone="{{$host->HostMobilePhone}}" data-bind="click: edit">詳細</a></span>
                                                            <span>
															<a id="lnk{{$host->HashID}}" href="javascript:void(0)" onclick="removeHostMember(this);" data-Image="{{$host->HostPhoto}}" data-Id="{{$host->HashID}}" data-FirstName="{{$host->HostFirstName}}" data-LastName="{{$host->HostLastName}}" data-Email="{{$host->HostEmail}}" data-Phone="{{$host->HostMobilePhone}}" data-bind="click: remove">削除</a></span>
														</div>
													</div>
													@endforeach
												</div>
												<!--/input-wrapper-->
												<div class="add-manager-wrapper">
													<a class="input-label toggle_button btn btn-info" bind-toggle=".edit-newhost-sec" href="javascript:void(0)" id="addNewAdminBtn" data-bind="click: add">+ 担当者追加</a>
												</div>
											</div>
											<!--show here if you click Add a Host member-->
											<form id="editHostAdminForm" class='fl-form' method="post" action="{{url('ShareUser/Dashboard/HostSetting/HostInfo')}}">
												<div class="input-wrapper edit-newhost-sec" style="display: none;">
													<div class="input-container">
														<label class="add-newhost">新規担当者プロフィール</label>
														<div class="admin-details-wrapper clearfix">
															<div class="validation-summary-valid" data-valmsg-summary="true">
																<ul>
																	<li style="display: none"></li>
																</ul>
															</div>
															<div class="my-admin-picture-wrapper">
																<!-- ko stopBinding: true -->
																<div style="width: 120px; height: 120px; background-size: 100% 100%;" class="tab-image-widget noImage" id="background-HostPhoto" data-bind="css: { noImage: noImage }">
																	<img id="HostImage" data-bind="attr: { src: PictureUrl }" height="120" width="120" src="/images/HostPhoto.png">
																	<!-- id="editMemberImageView"  -->
																	<span class="delete-image-icon" style="display: none;" data-bind="visible: showDelete, click: deleteFunc"></span>
																	<div class="image-empty-text" style="" data-bind="visible: noImage">No image</div>
																	<div class="image-button-wrapper" id="" data-toggle="modal" data-target="#popover_content_wrapper" image-type="HostPhoto">
																		<span data-bind="text: buttonText">アップロード</span>
																	</div>
																	<input type="hidden" name="HostPhoto" id="HostPhoto" value="">
																	<div class="cropControls cropControlsUpload"></div>
																</div>
																<!-- /ko -->
															</div>
															<div class="admin-details">
																<input type="hidden" id="hdnHostId" name="HashID">
																<input id="MemberLastName" name="HostLastName" placeholder="姓" type="text" required value="">
																<input required id="MemberFirstName" name="HostFirstName" placeholder="名" type="text" value="">
																<input required id="MemberEmail" name="HostEmail" placeholder="メールアドレス" type="text" value="">
																<input id="MemberPhone" name="HostMobilePhone" placeholder="電話番号" type="text" value="">
															</div>
														</div>
													</div>
													<!--/input-container-->
													<button class="btn ui-button-text-only yellow-button save-host" role="button" type="submit">
														<span class="ui-button-text">保存</span>
													</button>
													<button class="toggle_button cancel-button btn ui-button-text-only" role="button" bind-toggle=".edit-newhost-sec">
														<span class="ui-button-text cancel">キャンセル</span>
													</button>
												</div>
											</form>
											<!--/input-wrapper-->
											<!--/show here if you click Add a Host member-->
										</div>
										<!--/form-container-->
									</div>
									<!--/space-setting-content-->
								</section>
							</div>
							<!--/feed-->
							<div id="feed">
								<section class="feed-event recent-follow feed-box">
									<div class="dashboard-section-heading-container">
										<h3 class="dashboard-section-heading">
											利用規約
											<!--Terms-->
										</h3>
									</div>
									<div class="space-setting-content">
										<p class="exp">Offispoの利用規約となります。</p>
										<div class="view_terms_use">
											<a href="http://www.office-spot.com/TermCondition/ShareUser" class="color-link" target="_blank"><i class="fa fa-external-link" aria-hidden="true"></i>貸主利用規約を見る</a>
										</div>
										<form id="TermsUse">
											<div class="form-container">
												<div class="form-field">
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
						<!--footer-->
						@include('pages.dashboard_user1_footer')
						<!--/footer-->
					</div>
					<!--/#page-wrapper-->
				</div>
				<!--/right_side-->
			</div>
		</div>
		<!--/main-container-->
		<!--footer-->
		<!--/footer-->
	</div>
	<!--/viewport-->
	@include('pages.footer_js')
	<script>
jQuery(".input-container.iconbutton").click(function(){
  jQuery(this).toggleClass("checked");
});
</script>
	<script>
jQuery('#samewidthby').css('width', '');
w = jQuery('#samewidth').width();
jQuery('#samewidthby').width(w);
</script>
	<script>
$ = jQuery.noConflict();
$(document).ready(function() {
	$('#left-box') .css({'height': (($(window).height()) - 100)+'px'});
	$('#BusinessCat').val("{{$user->BussinessCategory}}");
	$('#desire_numpeople_inoffice').val("{{$user->NumberOfEmployee}}");
	$('#Prefecture').val("{{$user->Prefecture}}");
		$('#BusinessKind_welcome').val("{{$user->BusinessKindWelcome}}");

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
			$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

			function paymentInfo()
			{
				 var $form = $('#BankAccount'),
        data1 = $form.serialize(),
        url = $form.attr( "action" );


	   $.ajax({
            type: "POST",
            url : url,
            data : { formData:data1 },
           success: function(data){ // What to do if we succeed
		 if(data.success) {
			jQuery("#spanAccountType").text(jQuery('input[name="AccountType"]').val());
			jQuery("#spanAccountName").text(jQuery('input[name="AccountName"]').val());
			jQuery("#spanBankName").text(jQuery('input[name="BankName"]').val());
			jQuery("#spanBranchLocationName").text(jQuery('input[name="BranchLocationName"]').val());
			jQuery("#spanBranchCode").text(jQuery('input[name="BranchCode"]').val());
			jQuery("#spanAccountNumber").text(jQuery('input[name="AccountNumber"]').val());
			jQuery(".bank-account-edit-container").toggle();
			jQuery(".saved-bank-account").toggle();
          //window.location.href= data.next;


		 } //success
    },
    error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
		alert(JSON.stringify(jqXHR));
        alert("AJAX error: " + textStatus + ' : ' + errorThrown);
    }


        },"json");

		}

			function hostInfo()
			{
				 var $form = $('#editHostAdminForm'),
        data1 = $form.serialize(),
        url = $form.attr( "action" );


	   $.ajax({
            type: "POST",
            url : url,
            data : { formData:data1 },
           success: function(data){ // What to do if we succeed
		 if(data.success) {
			var imgPath =jQuery('input[name="HostPhoto"]').val();
			var imgAlt = jQuery('input[name="HostLastName"]').val() + ' ' + jQuery('input[name="HostFirstName"]').val();
			var Name = jQuery('input[name="HostLastName"]').val() + ' ' + jQuery('input[name="HostFirstName"]').val();
			var Email = jQuery('input[name="HostEmail"]').val();
			var Phone = jQuery('input[name="HostMobilePhone"]').val();
			if($("#hdnHostId").val() == "")
			{
				jQuery('#hostMember').append('<div class="admin-wrapper"><div class="aw-image-wrapper"><img src="'+imgPath+'" class="admin-image" data-bind="attr: { alt: MemberName, src: PictureUrl }" alt="'+imgAlt+'"></div><div class="aw-name" data-bind="text: MemberFirstName">'+Name+'</div><div class="aw-email" data-bind="text: Email">'+Email+'</div><div class="aw-link"><a href="javascript:void(0)" data-bind="click: edit">Details</a></div></div>');
			}
			else
			{
				jQuery("#img"+$("#hdnHostId").val()).attr("src",imgPath).attr("alt",imgAlt);
				jQuery("#name"+$("#hdnHostId").val()).text(Name);
				jQuery("#email"+$("#hdnHostId").val()).text(Email);
				jQuery("#lnk"+$("#hdnHostId").val()).attr('data-image',imgPath).attr('data-firstname',jQuery('input[name="HostFirstName"]').val()).attr('data-lastname',jQuery('input[name="HostLastName"]').val()).attr('data-email',Email).attr('data-phone',Phone)
			}
			jQuery(".edit-newhost-sec").toggle();
			$('#editHostAdminForm').trigger("reset");
			$('#background-HostPhoto').css("background-image: none");
          //window.location.href= data.next;


		 } //success
    },
    error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
		alert(JSON.stringify(jqXHR));
        alert("AJAX error: " + textStatus + ' : ' + errorThrown);
    }


        },"json");

		}
		
		function changePwd()
		{
			var $form = $('#changepassword'),
    data1 = $form.serialize(),
    url = $form.attr("action");
    $.ajax({
        type: "POST",
        url : url,
            data : { formData:data1 },
        success: function(data){ // What to do if we succeed
           
            if(data.success) {
				alert("パスワードが変更されました。");

            }
            else if(!data.matched)
            {
              alert("現在のパスワードが合っていません。");
            }
			else{
				alert(data);
			}
        },
        error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
           
            console.log(JSON.stringify(jqXHR));
            console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
        }
    },"json");
		}

		
		function changemail()
		{
			var $form = $('#chgemail'),
    data1 = $form.serialize(),
    url = $form.attr("action");
    $.ajax({
        type: "POST",
        url : url,
            data : $form.serialize(),
        success: function(data){ // What to do if we succeed
           
            if(data.success) {
				alert("メールアドレスの変更が完了しました。変更先のメールアドレスにメールが送信されましたので、ご確認頂き、メール認証を完了させて下さい。");

            }
           
        },
        error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
             if( jqXHR.status === 422 ) {
             var errors = jqXHR.responseJSON; //this will get the errors response data.
             errorsHtml = '';
             $.each( errors, function( key, value ) {
                 errorsHtml += value[0] + '\n'; //showing only the first error.
             });
             alert( errorsHtml );
             } else {
            	 alert( 'エラーが起こりました。再度お試しください。' );
             }
        }
    },"json");
		}
		
		</script>
	<link rel="stylesheet" href="{{ URL::asset('js/chosen/chosen.css') }}">
	<script src="{{ URL::asset('js/jquery.validate.js?v=1') }}"></script>
	<script src="{{ URL::asset('js/chosen/chosen.jquery.js') }}" type="text/javascript"></script>
	<script src="{{ URL::asset('js/assets/custom_edit_form.js') }}"></script>
	<script>
		$("#BankAccount").validate({
				  	errorPlacement: function(label, element) {
						label.addClass('form-error');
						label.insertAfter(element);
			},

        submitHandler: function(label){
                             paymentInfo();
        }

			});
		$("#editHostAdminForm").validate({
				  	errorPlacement: function(label, element) {
						label.addClass('form-error');
						label.insertAfter(element);
			},

        submitHandler: function(label){
                             hostInfo();
        }

			});


			$("#changepassword").validate({
				  	errorPlacement: function(label, element) { 
						label.addClass('form-error');
						label.insertAfter(element);
			},
			rules: {
			    
				oldpassword : {
					required : true
                },
				password : {
                    minlength : 5,
					required : true
                },
                password_confirmation : {
                    minlength : 5,
                    equalTo : "#newPasswd1",
 					required : true
               }
			  },
        submitHandler: function(label){
                             changePwd();
        }

			});
		

$("#chgemail").validate({
				  	errorPlacement: function(label, element) { 
						label.addClass('form-error');
						label.insertAfter(element);
			},
			
        submitHandler: function(label){
                             changemail();
        }

			});
				
		</script>
	<script type="text/javascript">
    jQuery(document).ready(function($) {
		$("#addNewAdminBtn").click(function()
		{
			ClearForm();
		});
		
		
		$("#changeEmail").click(function()
		{
			$('.changeEmailBtn').show();
			$('#Email').removeAttr( "readonly" );
			$('#Email').removeAttr( "disabled" );
		});
		$("#verifyEmail").click(function()
		{
			$.ajax({
        type: "get",
        url : "/ShareUser/Dashboard/SendVerifyEmail",
        success: function(data){ // What to do if we succeed
           
            if(data.success) {
				alert("メールアドレス認証確認メールが送信されました。");

            }
           
        },
        error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
           
            console.log(JSON.stringify(jqXHR));
            console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
        }
    },"json");
		});

        $('#thumbviewimage, #profileImageUploader').click(function(e){
            e.preventDefault();
        });

        $('#popover_content_wrapper').on('shown.bs.modal', function (e) {

			$('#popover_content_wrapper form[name="thumbnail"] #image-type').val($(e.relatedTarget).attr('image-type'));
        	$('#popover_content_wrapper form.uploadform .image-id').val($(e.relatedTarget).attr('image-type'));


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
	    		/*delete imageData['_token'];
	    		delete imageData['backurl'];
	    		delete imageData['upload_thumbnail'];*/
				console.log(response);
	    		//alert(response);

				var image_type = $('form[name="thumbnail"] #image-type').val();
	    		$('#'+image_type).val(response.file_thumb_path);
	    		// Display image preview
	    		//$('.edit-logo-thumbnail-wrapper').css('background-image', 'url("'+ (response.file_thumb) +'?t='+ (new Date().getTime()) +'")')
	    		$('#background-'+image_type).css('background-image', 'url("'+ (response.file_thumb) +'?t='+ (new Date().getTime()) +'")')

	            // Close modal
	            jQuery('.modal').modal('hide');
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
    		var image_src = "<?php echo UPLOAD_PATH_LOGO_URL; ?>" + responseText;

    	    if(responseText.indexOf('.')>0){
    			$(wraperClass + ' #thumbviewimage').html('<img src="'+image_src+'"   style="position: relative;" alt="Thumbnail Preview" />');
    	    	$(wraperClass + ' #viewimage').html('<img class="preview" alt="" src="'+image_src+'?t='+ (new Date().getTime()) +'"   id="thumbnail" />');
    	    	$(wraperClass + ' #filename').val(responseText);

		 		$(wraperClass + ' #thumbnail').Jcrop({
		 			  aspectRatio: 300/300,
		 		      boxWidth: 400,   //Maximum width you want for your bigger images
		 		      boxHeight: 300,  //Maximum Height for your bigger images
		 			  setSelect: imageArea,
		 			  onSelect: updateCoords,
		 			},function(){
		 			  var jcrop_api = this;
		 			  thumbnail = this.initComponent('Thumbnailer', { width: 200, height: 200 });
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
        	$(".modal.in .uploadform").append('<input type="hidden" name="upload_type" value="logo" />')

        	$(".modal.in #viewimage").html('');
            $(".modal.in #viewimage").html('<img src="'+ SITE_URL +'images/loading.gif" />');
            $(".modal.in .uploadform").ajaxForm({
            	url: SITE_URL + 'upload-image.php',
                success:    showResponse
            }).submit();
        });


    });

	function ClearForm()
	{
		$("#hdnHostId, #HostPhoto, #MemberFirstName, #MemberLastName, #MemberEmail, #MemberPhone").val("");
		$("#HostImage").attr("src","/images/HostPhoto.png");
	}
	function EditDetail(obj)
	{
		if($('.edit-newhost-sec').css('display') == 'none')
			$("#addNewAdminBtn").click();
		$("#hdnHostId").val($(obj).attr('data-Id'));
		$("#HostPhoto").val($(obj).attr('data-image'));
		$("#HostImage").attr("src",$(obj).attr('data-image'));
		$("#MemberFirstName").val($(obj).attr('data-firstname'));
		$("#MemberLastName").val($(obj).attr('data-lastname'));
		$("#MemberEmail").val($(obj).attr('data-email'));
		$("#MemberPhone").val($(obj).attr('data-phone'));
	}


	function removeHostMember(obj)
	{
		element = $(obj);
		if (!confirm('このメンバーを削除しますか？')) {
			return false;
		}
		
		if($('.edit-newhost-sec').css('display') == 'none')
		$("#hdnHostId").val($(obj).attr('data-Id'));
		$("#HostPhoto").val($(obj).attr('data-image'));
		$("#HostImage").attr("src",$(obj).attr('data-image'));
		$("#MemberFirstName").val($(obj).attr('data-firstname'));
		$("#MemberLastName").val($(obj).attr('data-lastname'));
		$("#MemberEmail").val($(obj).attr('data-email'));
		$("#MemberPhone").val($(obj).attr('data-phone'));
		
		var $form = $('#editHostAdminForm'),
		data1 = $form.serialize(),
		url = $form.attr( "action" );
		
		
		$.ajax({
		    type: "POST",
		    url : url,
		    data : { formData:data1, action: 'remove' },
		   success: function(data){ // What to do if we succeed
		 		if(data.success) {
		 			element.closest('.admin-wrapper').fadeOut();
				} 
			},
			error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
				alert(JSON.stringify(jqXHR));
				alert("AJAX error: " + textStatus + ' : ' + errorThrown);
				}
			},"json");
		}
</script>
</body>
</html>
