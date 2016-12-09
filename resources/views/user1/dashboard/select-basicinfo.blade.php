
@include('pages.header_beforelogin')
<!--/head-->
<script>
	jQuery( document ).ready(function() {
	jQuery('#prefecture').val("@if(Auth::check() && Auth::user()->Prefecture){{Auth::user()->Prefecture}}@endif");
	jQuery('#BusinessCat').val("@if(Auth::check() && Auth::user()->BussinessCategory){{Auth::user()->BussinessCategory}}@endif");
	jQuery('#BusinessType').val("@if(Auth::check() && Auth::user()->BusinessType){{Auth::user()->BusinessType}}@endif");
	jQuery('#desire_numpeople_inoffice').val("@if(Auth::check() && Auth::user()->NumberOfEmployee){{Auth::user()->NumberOfEmployee}}@endif");
			<?php if(empty(Auth::user()->Prefecture)){
		?>
		
		zipcode="<?=Auth::user()->PostalCode?>";
			$.ajax({
            type: "post",
            url: SITE_URL + "dataAddress/api.php",
            data: JSON.stringify(zipcode),
            crossDomain: false,
            dataType : "jsonp",
            scriptCharset: 'utf-8'
        }).done(function(data){
            if(data[0] == ""){
            } else {
            	$('#prefecture').val(data[0]);
                $('#district').val(data[1] + data[2]);
            }
        }).fail(function(XMLHttpRequest, textStatus, errorThrown){
        });
		<?php
	} ?>
	});
	</script>

<body class="selectPage">
	<div class="viewport">
		<div class="header_wrapper primary-navigation-section">
			<header id="header">
				<div class="header_container dark">
					<div class="logo_container">
						<a class="logo" href="index.html">Offispo</a>
					</div>
				</div>
			</header>
		</div>
		<div class="main-container">
			<div id="main" class="container">
				<h1 class="page-title">基本情報を入力</h1>
				<p class="sub-title">アカウント作成のための基本情報を入力して下さい。</p>
				<div class="form-container">
<form id="basicinfo" name="BasicInfo" method="post" action="{{ url('ShareUser/BasicInfo') }}" class="fl-form ">

{{ csrf_field() }} 
					<fieldset>
						<div class="Signup-sectionHeader">
							<legend class="signup-sectionTitle">
								会社・個人事業主情報
							</legend>
						</div>
						<div class="form-field two-inputs">
							<label for="typeBusiness">
								<span class="require-mark">*</span>
								事業のタイプ
								<span class="help">事業タイプを選択してください。事業タイプは、登記簿謄(抄)本に記載された事業の形態と一致している必要があります。</span>
							</label>
							<div class="input-container input-half">
								<select id="BusinessType" name="BusinessType" class="old_ui_selector" required>
									<option value="" selected="">-- 1つ選択 --</option>
									<option value="個人事業主">個人事業主</option>
									<option value="共同経営">共同経営</option>
									<option value="会社">会社</option>
									<option value="その他の会社組織">その他の会社組織</option>
									<option value="国・地方公共団体">国・地方公共団体</option>
								</select>
							</div>
							@if($errors->first('BusinessType'))
									<div ng-show="FirstNameError" class="input-error"><span class="label label-warning ng-binding">{{ $errors->first('BusinessType') }}</span></div>
								@endif
						</div>
						<!--/form-field-->
						<div class="form-field two-inputs">
							<div class="input-container input-half">
								<label for="last_name">
									<span class="require-mark">*</span>
									社名・組織名等
									<span class="help">法務局に登記されている会社名または事業体の正式名称。</span>
								</label>
								<input name="NameOfCompany"  id="CompanyName" value="{{ $user->NameOfCompany }}" required="" ng-model="signup.company_name" type="text" class="ng-pristine ng-untouched ng-invalid ng-invalid-required" aria-invalid="true" aria-required="true" placeholder="株式会社Offispo">
								@if($errors->first('NameOfCompany'))
									<div ng-show="FirstNameError" class="input-error"><span class="label label-warning ng-binding">{{ $errors->first('NameOfCompany') }}</span></div>
								@endif
							</div>
						</div>
						<!--/form-field-->
						<div class="form-field two-inputs">
							<div class="input-container input-half">
								<label for="zip">
									<span class="require-mark">*</span>
									郵便番号
								</label>
								<input name="PostalCode" required="" id="zip" type="text" value="{{ $user->PostalCode }}" 　class="ng-pristine ng-untouched ng-invalid-required" aria-required="true">
							</div>
						</div>
						<!--/form-field-->
						<div class="form-field two-inputs">
							<div class="input-container input-half">
								<label for="business_state">
									<span class="require-mark">*</span>
									都道府県
								</label>
								<select id="prefecture" required name="Prefecture" class="confidential">
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
								<label for="prefecture">
									<span class="require-mark">*</span>
									市区町村
								</label>
								<input name="District" required="" id="district" value="{{ $user->District }}" type="text" class="ng-pristine ng-untouched ng-invalid-required" aria-required="true" placeholder="横浜市緑区">
							</div>
						</div>
						<!--/form-field-->
						<div class="form-field two-inputs">
							<div class="input-container input-half">
								<label for="addr">
									<span class="require-mark">*</span>
									番地
								</label>
								<input name="Address1" id="Addr" value="{{ $user->Address1 }}" required="" ng-model="signup.addr" type="text" class="ng-pristine ng-untouched ng-invalid-required" aria-required="true" placeholder="六本木1-1-1">
							</div>
							<div class="input-container input-half">
								<label for="addr">
									建物名・階・部屋番号
								</label>
								<input name="Address2"  id="Addr2" value="{{ $user->Address2 }}"  ng-model="signup.addr2" type="text" class="ng-pristine ng-untouched" placeholder="オフィスポビル1024">
							</div>
						</div>
						<!--/form-field-->
						<div class="form-field two-inputs">
							<div class="input-container input-half">
								<label for="phoneNumber">
									<span class="require-mark">*</span>
									電話番号
								</label>
								<input name="Tel" value="{{ $user->Tel }}" required="" id="phone-number" type="text" 　class="ng-pristine ng-untouched ng-invalid-required" aria-required="true">
							</div>
						</div>
						<!--/form-field-->
						<div class="form-field two-inputs">
							<div class="input-container input-half">
								<label for="categoryBusiness">
									<span class="require-mark">*</span>
									事業のタイプ
								</label>
								<select id="BusinessCat" name="BussinessCategory" required class="old_ui_selector">
									<option value="" selected="">Choose business category</option>
									<option value="インターネット・ソフトウェア">企画・事務・管理</option>
									<option value="小売・消費者商品">小売・消費者商品</option>
									<option value="インターネット・ソフトウェア">インターネット・ソフトウェア</option>
									<option value="コンサルティング・ビジネスサービス">コンサルティング・ビジネスサービス</option>
									<option value="コンピュータ・テクノロジー">コンピュータ・テクノロジー</option>
									<option value="メディア/ニュース/出版">メディア/ニュース/出版</option>
									<option value="クリエイティブ">クリエイティブ</option>
									<option value="金融機関">金融機関</option>
									<option value="不動産">不動産</option>
									<option value="化学">化学</option>
									<option value="教育">教育</option>
									<option value="健康・医療・製薬">健康・医療・製薬</option>
									<option value="健康・美容">健康・美容</option>
									<option value="工学・建設">工学・建設</option>
									<option value="工業">工業</option>
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
									<option value="園芸・農業">園芸・農業</option>
									<option value="その他">その他</option>
								</select>
							</div>
							<div class="input-container input-half">
								<label for="desire_number_people_inoffice">
									従業員数
								</label>
								<select id="desire_numpeople_inoffice" name="NumberOfEmployee" data-label="人数を選択">
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
						<!--/form-field-->
					</fieldset>
					<div class="hr"></div>
					<fieldset>
						<div class="Signup-sectionHeader">
							<legend class="signup-sectionTitle">
								アカウント取引責任者
							</legend>
						</div>
						<div class="form-field two-inputs">
							<div class="input-container input-half">
								<label for="last_name">
									<span class="require-mark">*</span>
									姓
								</label>
								<input name="LastName" id="LastName" value="{{ $user->LastName }}" required="" ng-model="signup.last_name" type="text" class="ng-pristine ng-untouched ng-invalid ng-invalid-required" aria-invalid="true" aria-required="true" placeholder="佐藤">
								@if($errors->first('LastName'))
									<div ng-show="LastNameError" class="input-error"><span class="label label-warning ng-binding">{{ $errors->first('LastName') }}</span></div>
								@endif
							</div>
							<div class="input-container input-half">
								<label for="last_name">
									<span class="require-mark">*</span>
									名
								</label>
								<input name="FirstName" id="FirstName" value="{{ $user->FirstName }}" required="" ng-model="signup.first_name" type="text" class="ng-pristine ng-invalid ng-invalid-required ng-untouched" aria-invalid="true" aria-required="true" placeholder="太郎">
								@if($errors->first('FirstName'))
									<div ng-show="FirstNameError" class="input-error"><span class="label label-warning ng-binding">{{ $errors->first('FirstName') }}</span></div>
								@endif
							</div>
						</div>
						<!--/form-field-->
						<div class="form-field two-inputs">
							<div class="input-container input-half">
								<label for="last_name">
									<span class="require-mark">*</span>
									姓(ふりがな)
								</label>
								<input name="LastNameKana" id="LastNameKana" value="{{ $user->LastNameKana }}" required="" ng-model="signup.last_name_kana" type="text" class="ng-pristine ng-untouched ng-invalid ng-invalid-required" aria-invalid="true" aria-required="true" placeholder="さとう">
								@if($errors->first('LastNameKana'))
									<div ng-show="LastNameError" class="input-error"><span class="label label-warning ng-binding">{{ $errors->first('LastName') }}</span></div>
								@endif
							</div>
							<div class="input-container input-half">
								<label for="last_name">
									<span class="require-mark">*</span>
									名(ふりがな)
								</label>
								<input name="FirstNameKana" id="FirstNameKana" value="{{ $user->FirstNameKana }}" required="" ng-model="signup.first_name_kana" type="text" class="ng-pristine ng-invalid ng-invalid-required ng-untouched" aria-invalid="true" aria-required="true" placeholder="たろう">
						@if($errors->first('FirstNameKana'))
									<div ng-show="FirstNameError" class="input-error"><span class="label label-warning ng-binding">{{ $errors->first('FirstNameKana') }}</span></div>
								@endif
						</div>
						</div>
						<!--/form-field-->
						<div class="form-field two-inputs">
							<div class="input-container input-half">
								<label for="business_title">
									役職
								</label>
								<input name="BusinessTitle" id="BusinessTitle" value="{{ $user->BusinessTitle }}"  ng-model="signup.business_title" type="text" aria-invalid="true" aria-required="true" placeholder="代表取締役">
							</div>
							<div class="input-container input-half">
								<label for="department">
									部署
								</label>
								<input name="Department" id="Department" value="{{ $user->Department }}"  ng-model="signup.department" type="text" class="">
							</div>
						</div>
						<!--/form-field-->
						<div class="form-field two-inputs">
							<div class="input-container input-half">
								<label for="cellphone_number">
									携帯番号
								</label>
								<input name="CellPhoneNum" id="CellphoneNum" value="{{ $user->CellPhoneNum }}"  ng-model="signup.cellphone_num" type="text" class="" aria-invalid="true" placeholder="090-1234-5678">
							</div>
						</div>
						<!--/form-field-->
					</fieldset>
					<div class="hr"></div>

					<div class="btn-next-step">
						<button id="saveBasicInfo" class="btn yellow-button input-basicinfo-button">次へ</button>
					</div>
					</form>
				
				</div>
			</div>
		</div>
		<!--footer-->
		@include('pages.common_instant_footer')
		<script src="<?php echo SITE_URL?>js/chosen/chosen.jquery.js" type="text/javascript"></script>
		<script src="<?php echo SITE_URL?>js/assets/custom_edit_form.js" type="text/javascript"></script>
		<!--/footer-->
		
		
<script src="{{ URL::asset('js/jquery.validate.js?v=1') }}"></script>
		<script>
		$("#basicinfo").validate({
				  	errorPlacement: function(label, element) { 
						label.addClass('form-error');
						label.insertAfter(element);
			},
			rules: {
			    
			  }
			});
			
			
			 
		</script>
		
		
	</div>
	<!--/viewport-->
</body>
</html>
