
<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header.php'); ?>
 @include('pages.header')
<!--/head-->
<body class="mypage">
	<div class="viewport">
		<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header_nav_shareuser.php'); ?>
		 @include('pages.header_nav_shareuser')
		<div class="main-container">
			<div id="main" class="container">
				<div id="left-box" class="col_3_5">
					<div class="newsfeed-left-content">
						<div class="user-details-wrap">
							<div class="user-details feed-box mypage-leftbox">
								<div class="left-pad-box">
									<figure class="ImageThumbnail ImageThumbnail--xlarge PageDashboard-avatar online">
										<a class="ImageThumbnail-link" href="/users/changeuserinfo.php" title="View Profile">
											<img class="ImageThumbnail-image" src="https://www.freelancer.com/img/unknown.png" alt="Profile Picture">
										</a>
									</figure>
									<div class="welcome-note">
										<h4 class="user-details-title">
											あなたのアカウント
											<br>
											<em>
												<a class="user-details-username" href="#">xxx company</a>
											</em>
											<span class="publish-status unpublish">未公開</span>
											<!--if published<span class="publish-status published">公開中</span>-->
										</h4>
										<a href="#" class="btn btn-profile btn-small user-details-edit-btn">編集する</a>
										<!--show if minimum profile is not completed-->
										<div class="clear dashboard-must-validation">
											<h5 class="dashboard-warn-text">
												<a href="#" class="dashboard-must-text-link">プロフィールページ</a>
												が完成していません。
												<br />
												<a href="#" class="dashboard-must-text-link underline">プロフィールページを編集する</a>
											</h5>
										</div>
										<!--/show if minimum profile is not completed-->
										<div class="user-profile-account-progress">
											<h5>Profile Strength</h5>
											<div class="progress progress-info user-profile-account-progress-bar">
												<div class="bar" style="width: 20%;">
													20%
													<span class="access">complete</span>
												</div>
											</div>
											<p class="notify-msg">List your available spaces to get to 60%</p>
											<p class="caution">
												*Your space is not published,because of not enough profile.
												<!--※設定項目を満たしていない為、現在未公開です。-->
											</p>
										</div>
									</div>
								</div>
								<nav id="shareuser-setting-nav">
									<ul>
										<li>
											<a href="#" class="content-navigation">
												<i class="fa fa-user" aria-hidden="true"></i>
												My Page
												<!--マイページ-->
											</a>
										</li>
										<li>
											<a href="#" class="content-navigation">
												<i class="fa fa-building" aria-hidden="true"></i>
												Space Profile
												<!--シェアスペース-->
											</a>
										</li>
										<li>
											<a href="#" class="content-navigation">
												<i class="fa fa-calendar-check-o" aria-hidden="true"></i>
												Reservation
												<!--予約-->
											</a>
										</li>
										<li>
											<a href="#" class="content-navigation">
												<i class="fa fa-star" aria-hidden="true"></i>
												Offer list
												<!--オファーリスト-->
											</a>
										</li>
										<li>
											<a href="#" class="content-navigation selected">
												<i class="fa fa-cogs" aria-hidden="true"></i>
												Setting
												<!--設定-->
											</a>
										</li>
									</ul>
								</nav>
							</div>
							<!--/feed-nbox-->
						</div>
						<!--/user-details-wrap-->

					</div>
					<!--/right-content-->
				</div>
				<!--/leftbox-->
				<div class="col_6_5 right_side">
                <div id="feed">
						<section class="feed-event recent-follow feed-box">
							<div class="dashboard-section-heading-container">
								<h3 class="dashboard-section-heading">
									Company Certificate
									<!--会社証明-->
								</h3>
							</div>
							<div class="space-setting-content">
								<div class="form-container">
									<form id="company-validation" action="upload-company-valid.php" method="post">
                                    <div class="form-field">
											<label for="SpaceTitle">
												<span class="require-mark">*</span>
												Company document
												<!--会社定款-->
											</label>
											<div class="input-container">
												
        <div class="form-group">
        <input type="file" class="filestyle" data-icon="false" name="Certificate" id="Certificate">
   
</div>
											</div>
										</div>
                                    </form>
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
									Company Profile
									<!--会社情報-->
								</h3>
							</div>
							<div class="space-setting-content">
								<div class="form-container">
									<form id="companyinfo">
										<div class="form-field">
											<label for="SpaceTitle">
												<span class="require-mark">*</span>
												Company Name
												<!--会社名-->
											</label>
											<div class="input-container">
												<input name="NameOfCompany" id="NameOfCompany" value="" required="" ng-model="setting.space_title" type="text" class="ng-invalid" aria-invalid="true" placeholder="株式会社オフィスポ">
											</div>
										</div>

										<div class="form-field address-wrapper">
											<label for="require-place">
												<span class="require-mark">*</span>
												Address
												<!--住所-->
											</label>
											<div class="input-container">
												<div class="address-display-wrapper" data-bind="visible: !addressEdit()">
													<a href="javascript:void(0)" class="toggle_button" bind-toggle=".address-edit-wrapper, .address-wrapper" data-bind="click: toggleAddressEdit">Edit</a>
													<input type="text" name="Address" id="Address" value data-bind="textInput: fullAddress, disable: !addressEdit()" disabled>
												</div>
											</div>
										</div>
										<!--/form-field-->
										<!--if you click edit link,show this-->
										<div class="address-edit-wrapper" data-bind="visible: addressEdit" style="display: none;">
											<div class="form-field two-inputs">
												<div class="input-container input-half">
													<label for="zip">
														<span class="require-mark">*</span>
														Postal code
														<!--郵便番号-->
													</label>
													<input name="PostalCode" id="PostalCode" type="text" 　class="ng-pristine ng-untouched ng-invalid-required" aria-required="true">
												</div>
											</div>
											<!--/form-field-->
											<div class="form-field two-inputs">
												<div class="input-container input-half">
													<label for="zip">
														<span class="require-mark">*</span>
														Prefecture
														<!--都道府県-->
													</label>
													<select id="Perfecture" name="Perfecture" class="confidential">
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
														District
														<!--市区町村-->
													</label>
													<input name="District" id="District" type="text" class="ng-pristine ng-untouched ng-invalid-required" aria-required="true" placeholder="横浜市緑区">
												</div>
											</div>
											<!--/form-field-->
											<div class="form-field two-inputs">
												<div class="input-container input-half">
													<label for="addr">
														<span class="require-mark">*</span>
														Street number
														<!--番地-->
													</label>
													<input name="StreetNumber" id="StreetNumber" value="" required="" ng-model="signup.addr" type="text" class="ng-pristine ng-untouched ng-invalid-required" aria-required="true" placeholder="六本木1-1-1">
												</div>
												<div class="input-container input-half">
													<label for="addr">
														Buidling name,room number
														<!--建物名・階・部屋番号-->
													</label>
													<input name="BuildingNumber" id="BuildingNumber" value="" required="" ng-model="signup.addr2" type="text" class="ng-pristine ng-untouched" placeholder="オフィスポビル1024">
												</div>
											</div>
											<!--/form-field-->
											<a href="javascript:void(0)" class="toggle_button" bind-toggle=".address-edit-wrapper, .address-wrapper">Cancel to Edit</a>
										</div>
										<!--/address-edit-wrapper-->
										<div></div>
										<!--/if you click edit link,show this-->

										<div class="form-field two-inputs">
											<div class="input-container input-half">
												<label for="phoneNumber">
													<span class="require-mark">*</span>
													Phone number
													<!--電話番号-->
												</label>
												<input name="Tel" id="Tel" type="text" 　class="ng-pristine ng-untouched ng-invalid-required" aria-required="true">
											</div>
										</div>

										<div class="form-field two-inputs">
											<div class="input-container input-half">
												<label for="categoryBusiness">
													<span class="require-mark">*</span>
													Category of business
													<!--事業のタイプ-->
												</label>
												<select id="BusinessCategory" name="BusinessCategory" class="old_ui_selector">
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
													Number of employees
													<!--職場人数-->
												</label>
												<select id="NumberOfEmployee" name="NumberOfEmployee" data-label="人数を選択">
													<option value="" selected="">select number of people</option>
													<option value="5人以下">less than 5 people</option>
													<option value="5人~10人">5 people~10 people</option>
													<option value="10人~20人">10 people~20 people</option>
													<option value="20人~30人">20 people~30 people</option>
													<option value="30人~40人">30 people~40 people</option>
													<option value="40人~50人">40 people~50 people</option>
													<option value="50人以上">more than 50 people</option>
												</select>
											</div>
										</div>
										<script src="js/chosen/chosen.jquery.js" type="text/javascript"></script>
										<script src="js/chosen/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
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
									Responsible person for this account
									<!--アカウント責任者-->
								</h3>
							</div>
							<div class="space-setting-content">
								<div class="form-container">
									<form id="ResponsivePersoninfo">
										<div class="form-field responsive-person-name-wrapper">
											<label for="fullname-person">
												<span class="require-mark">*</span>
												Name Responsible person
												<!--担当者氏名-->
											</label>
											<div class="input-container">
												<div class="responsive-person-name-display-wrapper" data-bind="visible: !nameEdit()">
													<a href="javascript:void(0)" class="toggle_button toggle_button_address_responsive" bind-toggle=".responsive-person-name-wrapper, .responsive-person-name-edit-wrapper" data-bind="click: toggleAddressEdit">Edit</a>
													<input type="text" value data-bind="textInput: fullName, disable: !nameEdit()" disabled>
												</div>
											</div>
										</div>
										<!--/form-field-->
										<!--if you click edit link,show this-->
										<div class="responsive-person-name-edit-wrapper" data-bind="visible: addressEdit" style="display: none;">
											<div class="form-field two-inputs">
												<div class="input-container input-half">
													<label for="last_name">
														<span class="require-mark">*</span>
														Last name
														<!--姓-->
													</label>
													<input name="LastName" id="LastName" value="" required="" ng-model="signup.last_name" type="text" class="ng-pristine ng-untouched ng-invalid ng-invalid-required" aria-invalid="true" aria-required="true" placeholder="佐藤">
												</div>
												<div class="input-container input-half">
													<label for="last_name">
														<span class="require-mark">*</span>
														First name
														<!--名-->
													</label>
													<input name="FirstName" id="FirstName" value="" required="" ng-model="signup.first_name" type="text" class="ng-pristine ng-invalid ng-invalid-required ng-untouched" aria-invalid="true" aria-required="true" placeholder="太郎">
												</div>
											</div>
											<!--/form-field-->
											<div class="form-field two-inputs">
												<div class="input-container input-half">
													<label for="last_name">
														<span class="require-mark">*</span>
														Last name kana
														<!--姓(ふりがな)-->
													</label>
													<input name="LastNameKana" id="LastNameKana" value="" required="" ng-model="signup.last_name_kana" type="text" class="ng-pristine ng-untouched ng-invalid ng-invalid-required" aria-invalid="true" aria-required="true" placeholder="さとう">
												</div>
												<div class="input-container input-half">
													<label for="last_name">
														<span class="require-mark">*</span>
														First name kana
														<!--名(ふりがな)-->
													</label>
													<input name="FirstNameKana" id="FirstNameKana" value="" required="" ng-model="signup.first_name_kana" type="text" class="ng-pristine ng-invalid ng-invalid-required ng-untouched" aria-invalid="true" aria-required="true" placeholder="たろう">
												</div>
											</div>
											<!--/form-field-->
											<a href="javascript:void(0)" class="toggle_button" bind-toggle=".responsive-person-name-wrapper, .responsive-person-name-edit-wrapper">Cancel to Edit</a>
										</div>
										<!--/if you click edit link,show this-->
										<div class="form-field two-inputs">
											<div class="input-container input-half">
												<label for="business_title">
													Business title
													<!--役職-->
												</label>
												<input name="BusinessTitle" id="BusinessTitle" value="" required="" ng-model="signup.business_title" type="text" class="" placeholder="代表取締役">
											</div>
											<div class="input-container input-half">
												<label for="department">
													Department
													<!--部署-->
												</label>
												<input name="Department" id="Department" value="" required="" ng-model="signup.department" type="text" class="">
											</div>
										</div>
										<!--/form-field-->
										<div class="form-field two-inputs">
											<div class="input-container input-half">
												<label for="cellphone_number">
													Cellphone
													<!--携帯番号-->
												</label>
												<input name="CellPhoneNum" id="CellPhoneNum" value="" required="" ng-model="signup.cellphone_num" type="text" class="" aria-invalid="true" placeholder="090-1234-5678">
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
						<section class="feed-event recent-follow feed-box">
							<div class="dashboard-section-heading-container">
								<h3 class="dashboard-section-heading">
									Profile picture
									<!--プロフィール写真-->
								</h3>
							</div>
							<div class="space-setting-content">
								<div class="form-container">
									<form id="PhotoProfile">
										<div class="form-field two-inputs">
											<div class="input-container input-half logo-upload-wrapper">
												<label for="SpaceMainPhoto">
													Logo
													<!--ロゴ-->
												</label>
												<div class="edit-logo-wrapper">
													<div class="edit-logo-thumbnails edit-main-picture edit-logo-thumbnails-placeholder">
														<div class="edit-logo-thumbnail-wrapper" data-bind="click: add"></div>
													</div>
												</div>
												<div class="edit-logo-buttons">
													<button class="upload-button btn ui-button-text-only yellow-button" data-bind="click: add, jqButton: { disabled: false }" role="button" aria-disabled="false">
														<span class="ui-button-text">Upload</span>
													</button>
													<button data-bind="click: edit, visible: images().length, jqButton: { disabled: false }" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false" style="display: none;">
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
						<section class="feed-event booking-window feed-box">
							<div class="dashboard-section-heading-container">
								<h3 class="dashboard-section-heading">
									Booking Window
									<!--予約受付設定-->
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
												<input class="text-box" data-val="true" data-val-number="The field Min notice must be a number." id="txtAdvanceNotice" name="AdvanceNotice" type="text" value="2">
												<select updatedmarkforplaces="LSCommon.ShowUpdatedMarkForPlaces" id="cboAdvanceNoticeType" name="AdvanceNoticeTypeSelected" style="width: 75px">
													<option selected="selected" value="Hours">Hours</option>
													<option value="Days">Days</option>
												</select>
												<span class="field-validation-valid display-block" data-valmsg-for="AdvanceNotice" data-valmsg-replace="true"></span>
											</div>
											<div class="form-field">
												<span class="notice-label">Max notice:</span>
												<input class="text-box" data-val="true" data-val-number="The field Max notice must be a number." id="txtUnavailableAfter" name="UnavailableAfter" type="text" value="0">
												<label>Days</label>
												<span class="field-validation-valid display-block" data-valmsg-for="UnavailableAfter" data-valmsg-replace="true"></span>
											</div>
											<div class="form-field target-space">
												<span class="notice-label">Share Space</span>
												<select id="select-share-space-target">
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

					<div id="feed">
						<section class="feed-event recent-follow feed-box">
							<div class="dashboard-section-heading-container">
								<h3 class="dashboard-section-heading">
									Payment Info
									<!--支払受取情報-->
								</h3>
								<a class="toggle_button edit" bind-toggle=".bank-account-edit-container, .saved-bank-account" href="#">Edit</a>
							</div>
							<form id="BankAccount">
								<div class="space-setting-content">
									<div class="saved-bank-account">
										<div class="saved-value">
											<label>
												Account Type
												<!--口座の種類-->
												:
											</label>
											普通預金
										</div>
										<div class="saved-value">
											<label>
												Account Name
												<!--銀行口座の名義-->
												:
											</label>
											カ)オフィスポ
										</div>
										<div class="saved-value">
											<label>
												Bank Name
												<!--銀行名-->
												:
											</label>
											東京三菱UFJ銀行
										</div>
										<div class="saved-value">
											<label>
												Branch location name
												<!--支店名-->
												:
											</label>
											渋谷支店(201)
										</div>
										<div class="saved-value">
											<label>
												Account Number
												<!--口座番号-->
												:
											</label>
											1234567
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
														Account Type
														<!--口座の種類-->
													</label>
													<div class="radio inline">
														<input type="radio" name="AccountType" id="AccountType" value="checking" aria-hidden="true">
														<label for="checking">当座預金</label>
													</div>
													<!--/radio inline-->
													<div class="radio inline">
														<input type="radio" name="AccountType" id="AccountType" value="savings" aria-hidden="true" checked>
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
														Account Name
														<!--銀行口座の名義-->
													</label>
													<input id="AccountName" name="AccountName" type="text" class="hasHelp js_needsValidation validate" required="required" aria-required="true" value="" placeholder="銀行口座の名義" autocomplete="off" pattern="[\u30A0-\u30FF \s]*" aria-invalid="false">
												</div>
												<div class="input-container input-half">
													<label for="BankName">
														<span class="require-mark">*</span>
														Bank Name
														<!--銀行名-->
													</label>
													<input id="BankName" name="BankName" type="text" class="hasHelp  validate" required="required" aria-required="true" value="" placeholder="銀行名" autocomplete="off" maxlength="64">
												</div>
											</div>
											<!--/form-field-->

											<div class="form-field">
												<div class="input-container input-half">
													<label for="BankName">
														<span class="require-mark">*</span>
														Branch location name
														<!--支店名-->
													</label>
													<input id="BranchLocationName" name="BranchLocationName" type="text" class="hasHelp js_needsValidation validate" required="required" aria-required="true" value="" placeholder="支店名" autocomplete="off" pattern=".*" maxlength="32" aria-invalid="false">
												</div>
												<div class="input-container input-half">
													<label for="BankName">
														<span class="require-mark">*</span>
														Branch Code
														<!--支店コード-->
													</label>
													<input id="BranchCode" name="BranchCode" type="text" class="hasHelp js_needsValidation validate" required="required" aria-required="true" value="" placeholder="支店コード" autocomplete="off" pattern="[0-9]{3}" maxlength="3">
												</div>
											</div>
											<!--/form-field-->

											<div class="form-field">
												<div class="input-container input-half">
													<label for="accountNumber">
														<span class="require-mark">*</span>
														Account Number
														<!--口座番号-->
													</label>
													<input id="AccountNumber" name="AccountNumber" type="text" class="hasHelp js_needsValidation validate cobrowse_mask" required="required" aria-required="true" value="" placeholder="口座番号" autocomplete="off" pattern="[0-9]{7}" maxlength="7">
												</div>
											</div>
											<!--/form-field-->
											<div class="btn-wrapper">
												<button class="upload-button btn ui-button-text-only yellow-button" role="button">
													<span class="ui-button-text">Save</span>
												</button>
												<button class="toggle_button cancel-button btn ui-button-text-only yellow-button" role="button" bind-toggle=".bank-account-edit-container, .saved-bank-account">
													<span class="ui-button-text">Cancel</span>
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
						<section class="feed-event window-managers feed-box">
							<div class="dashboard-section-heading-container">
								<h3 class="dashboard-section-heading">
									Host members
									<!--窓口担当者-->
								</h3>
							</div>
							<p class="exp">
								As a Host, you'll interact with your venue guests.
								<br />
								Please provide your contact info so that reservation notification could be sent to you.
							</p>
							<div class="space-setting-content">
								<div class="form-container">
									<div class="input-wrapper">
										<div data-bind="template: {data: current, name: 'adminTemplate'}">
											<div class="admin-wrapper">
												<div class="aw-image-wrapper">
													<img src="images/HostPhoto.png" class="admin-image" data-bind="attr: { alt: MemberName, src: PictureUrl }" alt="Kyoko Furuya">
												</div>
												<div class="aw-name" data-bind="text: MemberFirstName">Kyoko</div>
												<div class="aw-email" data-bind="text: Email">kyoooko1122@gmail.com</div>
												<div class="aw-link">
													<a href="javascript:void(0)" data-bind="click: edit">Details</a>
												</div>
											</div>
										</div>
										<!--/input-wrapper-->
										<div class="add-manager-wrapper">
											<a class="input-label toggle_button" bind-toggle=".edit-newhost-sec" href="javascript:void(0)" id="addNewAdminBtn" data-bind="click: add">+ Add a Host Member</a>
										</div>
									</div>
									<!--show here if you click Add a Host member-->
									<div class="input-wrapper edit-newhost-sec" style="display: none;">
										<div class="input-container">
											<label class="add-newhost">New Host Profile</label>
											<form id="editHostAdminForm">
												<div class="admin-details-wrapper clearfix">
													<div class="validation-summary-valid" data-valmsg-summary="true">
														<ul>
															<li style="display: none"></li>
														</ul>
													</div>
													<div class="my-admin-picture-wrapper">
														<!-- ko stopBinding: true -->
														<div id="" style="width: 120px; height: 120px;" class="tab-image-widget noImage" data-bind="css: { noImage: noImage }">
															<img data-bind="attr: { src: PictureUrl }" height="120" id="editMemberImageView" src="images/HostPhoto.png" width="120">
															<span class="delete-image-icon" style="display: none;" data-bind="visible: showDelete, click: deleteFunc"></span>
															<div class="image-empty-text" style="" data-bind="visible: noImage">No image</div>
															<div class="image-button-wrapper" id="">
																<span data-bind="text: buttonText">Upload</span>
															</div>
															<input type="hidden" name="PregeneratedPictureId" data-bind="value: pregeneratedPictureId" value="00000000-0000-0000-0000-000000000000">
															<div class="cropControls cropControlsUpload"></div>
														</div>
														<!-- /ko -->
													</div>

													<div class="admin-details">
														<input data-val="true" data-val-namewithcharacters="Last Name should contain characters." data-val-required="The Last Name field is required." id="MemberLastName" name="MemberLastName" placeholder="Last Name" type="text" value="">
														<input data-val="true" data-val-namewithcharacters="First Name should contain characters." data-val-required="The First Name field is required." id="MemberFirstName" name="MemberFirstName" placeholder="First Name" type="text" value="">
														<input data-val="true" data-val-email="Email is not valid" data-val-email-regexpattern="^(([^<>()[\]\\.,;:\s@\&quot;]+(\.[^<>()[\]\\.,;:\s@\&quot;]+)*)|(\&quot;.+\&quot;))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$" data-val-required=" The Email Address field is required." id="Email" name="Email" placeholder="Email Address" type="text" value="">
														<input data-val="true" data-val-phonenumber="Phone is not valid" id="Phone" name="Phone" placeholder="Mobile Phone" type="text" value="">

													</div>
												</div>
											</form>
										</div>
										<!--/input-container-->
										<button class="toggle_button cancel-button btn ui-button-text-only yellow-button" role="button" bind-toggle=".edit-newhost-sec">
											<span class="ui-button-text">Cancel</span>
										</button>
									</div>
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
									Terms
									<!--利用規約-->
								</h3>
							</div>
							<div class="space-setting-content">
								<p class="exp">Here's Terms for using Offispo.</p>
								<div class="view_terms_use">
									<a href="#" target="_blank">View Terms of use</a>
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
				<!--/right_side-->
			</div>
		</div>
		<!--/main-container-->
		<!--footer-->
		<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/common_footer.php'); ?>
						@include('pages.common_footer')

		<!--/footer-->
	</div>
	<!--/viewport-->
	<script>
jQuery(".input-container.iconbutton").click(function(){
  jQuery(this).toggleClass("checked");
});
</script>
</body>
</html>
