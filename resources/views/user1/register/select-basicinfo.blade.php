
<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header_beforelogin.php'); ?>
 @include('pages.header_beforelogin')
<!--/head-->
<body class="selectPage">
<div class="viewport">
<div class="header_wrapper primary-navigation-section">
<header id="header">
<div class="header_container dark">
<div class="logo_container"><a class="logo" href="{{url('/')}}">hOur Office</a></div>
</div>
</header>
</div>
<div id="stepArea">
<ol class="cd-breadcrumb triangle custom-icons">
<li>
<span><span class="round-number">&#9312;</span>メールアドレス登録</span>
</li>
<li class="current">
<span><span class="round-number">&#9313;</span>基本情報入力</span>
</li>
<li>
<span><span class="round-number">&#9314;</span>仮登録完了</span>
</li>
</ol>
</div>
<div class="main-container">
<div id="main" class="container">
<h1 class="page-title">基本情報を入力</h1>
<p class="sub-title">アカウント作成のための基本情報を入力して下さい。</p>
<div class="form-container">
<form id="basicinfo" name="BasicInfo" method="post" action="{{ url('ShareUser/BasicInfo') }}" class="fl-form ">
{{ csrf_field() }} 

<fieldset>
<div class="Signup-sectionHeader"><legend class="signup-sectionTitle">会社情報</legend></div>
<div class="form-field two-inputs">
<label for="typeBusiness"><span class="require-mark">*</span>事業のタイプ<span class="help">事業タイプを選択してください。事業タイプは、登記簿謄(抄)本に記載された事業の形態と一致している必要があります。</span></label>
<div class="input-container input-half">
<select id="BusinessType" name="BusinessType" class="old_ui_selector validate[required]">
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
</div><!--/form-field-->
<div class="form-field two-inputs">
<div class="input-container input-half">
<label for="last_name"><span class="require-mark">*</span>社名・組織名等<span class="help">法務局に登記されている会社名または事業体の正式名称。</span></label>
<input name="NameOfCompany" id="NameOfCompany" value="" ng-model="signup.company_name" type="text" class="validate[required]" aria-invalid="true"  placeholder="株式会社hOur Office">
@if($errors->first('NameOfCompany'))
									<div ng-show="FirstNameError" class="input-error"><span class="label label-warning ng-binding">{{ $errors->first('NameOfCompany') }}</span></div>
								@endif
</div>
</div><!--/form-field-->
<div class="form-field two-inputs">
<div class="input-container input-half">
<label for="zip"><span class="require-mark">*</span>郵便番号<span class="help">郵便番号はハイフンを抜いて入力してください。</span></label>
<input name="PostalCode" id="zip" type="text" class="validate[required,custom[zip]]" >
</div>
</div><!--/form-field-->
<div class="form-field two-inputs">
<div class="input-container input-half">
<label for="zip"><span class="require-mark">*</span>都道府県</label>
<select id="Prefecture" name="Prefecture" class="confidential validate[required]"><option value=""></option><option value="北海道">北海道</option><option value="青森県">青森県</option><option value="岩手県">岩手県</option><option value="宮城県">宮城県</option><option value="秋田県">秋田県</option><option value="山形県">山形県</option><option value="福島県">福島県</option><option value="茨城県">茨城県</option><option value="栃木県">栃木県</option><option value="群馬県">群馬県</option><option value="埼玉県">埼玉県</option><option value="千葉県">千葉県</option><option value="東京都">東京都</option><option value="神奈川県">神奈川県</option><option value="新潟県">新潟県</option><option value="富山県">富山県</option><option value="石川県">石川県</option><option value="福井県">福井県</option><option value="山梨県">山梨県</option><option value="長野県">長野県</option><option value="岐阜県">岐阜県</option><option value="静岡県">静岡県</option><option value="愛知県">愛知県</option><option value="三重県">三重県</option><option value="滋賀県">滋賀県</option><option value="京都府">京都府</option><option value="大阪府">大阪府</option><option value="兵庫県">兵庫県</option><option value="奈良県">奈良県</option><option value="和歌山県">和歌山県</option><option value="鳥取県">鳥取県</option><option value="島根県">島根県</option><option value="岡山県">岡山県</option><option value="広島県">広島県</option><option value="山口県">山口県</option><option value="徳島県">徳島県</option><option value="香川県">香川県</option><option value="愛媛県">愛媛県</option><option value="高知県">高知県</option><option value="福岡県">福岡県</option><option value="佐賀県">佐賀県</option><option value="長崎県">長崎県</option><option value="熊本県">熊本県</option><option value="大分県">大分県</option><option value="宮崎県">宮崎県</option><option value="鹿児島県">鹿児島県</option><option value="沖縄県">沖縄県</option></select>
</div>
<div class="input-container input-half">
<label for="zip"><span class="require-mark">*</span>市区町村</label>
<input name="District" id="District" type="text" class="validate[required]" placeholder="横浜市緑区">
</div>
</div><!--/form-field-->
<div class="form-field two-inputs">
<div class="input-container input-half">
<label for="addr"><span class="require-mark">*</span>番地</label>
<input name="Address1" id="StreetNumber"  value="" ng-model="signup.addr" type="text" class="validate[required]" placeholder="六本木1-1-1">
</div>
<div class="input-container input-half">
<label for="addr">建物名・階・部屋番号</label>
<input name="Address2" id="BuildingNumber" value=""  ng-model="signup.addr2" type="text" class="ng-pristine ng-untouched" placeholder="アワーオフィスビル1024">
</div>
</div><!--/form-field-->
<div class="form-field two-inputs">
<div class="input-container input-half">
<label for="phoneNumber"><span class="require-mark">*</span>電話番号</label>
<input name="Tel" id="Tel" type="text" class="validate[required,custom[phone]]" >
</div>
</div><!--/form-field-->
<div class="form-field two-inputs">
<div class="input-container input-half">
<label for="categoryBusiness"><span class="require-mark">*</span>事業内容</label>
<select id="BussinessCategory" name="BussinessCategory" class="old_ui_selector validate[required]">
      <option value="" selected="">事業内容を選択</option>
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
<label for="desire_number_people_inoffice">職場人数</label>
<select id="NumberOfEmployee" name="NumberOfEmployee" data-label="人数を選択">
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
</div><!--/form-field-->
</fieldset>
<div class="hr"></div>
<fieldset>
<div class="Signup-sectionHeader"><legend class="signup-sectionTitle">アカウント取引責任者<!----></legend></div>
<div class="form-field two-inputs">
<div class="input-container input-half">
<label for="last_name"><span class="require-mark">*</span>姓</label>
<input name="LastName" id="LastName" value="" ng-model="signup.last_name" type="text" class="validate[required]" aria-invalid="true"  placeholder="佐藤">
@if($errors->first('LastName'))
									<div ng-show="LastNameError" class="input-error"><span class="label label-warning ng-binding">{{ $errors->first('LastName') }}</span></div>
								@endif
</div>
<div class="input-container input-half">
<label for="last_name"><span class="require-mark">*</span>名</label>
<input name="FirstName" id="FirstName" value="" ng-model="signup.first_name" type="text" class="validate[required]" aria-invalid="true"  placeholder="太郎">
@if($errors->first('FirstName'))
									<div ng-show="FirstNameError" class="input-error"><span class="label label-warning ng-binding">{{ $errors->first('FirstName') }}</span></div>
								@endif
</div>
</div><!--/form-field-->
<div class="form-field two-inputs">
<div class="input-container input-half">
<label for="last_name"><span class="require-mark">*</span>姓(ふりがな)</label>
<input name="LastNameKana" id="LastNameKana" value="" ng-model="signup.last_name_kana" type="text" class="validate[required]" aria-invalid="true"  placeholder="さとう">
@if($errors->first('LastNameKana'))
									<div ng-show="LastNameError" class="input-error"><span class="label label-warning ng-binding">{{ $errors->first('LastName') }}</span></div>
								@endif
</div>
<div class="input-container input-half">
<label for="last_name"><span class="require-mark">*</span>名(ふりがな)</label>
<input name="FirstNameKana" id="FirstNameKana" value="" ng-model="signup.first_name_kana" type="text" class="validate[required]" aria-invalid="true"  placeholder="たろう">
@if($errors->first('FirstNameKana'))
									<div ng-show="FirstNameError" class="input-error"><span class="label label-warning ng-binding">{{ $errors->first('FirstNameKana') }}</span></div>
								@endif
</div>
</div><!--/form-field-->
<div class="form-field two-inputs">
<div class="input-container input-half">
<label for="business_title">役職</label>
<input name="BusinessTitle" id="BusinessTitle" value="" ng-model="signup.business_title" type="text" aria-invalid="true"  placeholder="代表取締役">
</div>
<div class="input-container input-half">
<label for="department">部署</label>
<input name="Department" id="Department" value="" ng-model="signup.department" type="text" class="">
</div>
</div><!--/form-field-->
<div class="form-field two-inputs">
<div class="input-container input-half">
<label for="cellphone_number">携帯番号</label>
<input name="CellPhoneNum" id="CellPhoneNum" value="" ng-model="signup.cellphone_num" type="text" class="" aria-invalid="true" placeholder="090-1234-5678">
</div>
</div><!--/form-field-->
</fieldset>
<div class="hr"></div>

<div class="btn-next-step"><button id="saveBasicInfo" class="btn btn-info input-basicinfo-button" type="submit">登録する</button></div>
</form>
</div>
</div>
</div>
<!--footer-->
		@include('pages.signup_footer')
		<!--/footer-->
</div><!--/viewport-->
<script src="{{ URL::asset('js/jquery.validationEngine.js') }}"></script>
<script src="{{ URL::asset('js/jquery.validationEngine-ja.js') }}"></script>
<link rel="stylesheet" href="{{ URL::asset('css/validationEngine.jquery.css') }}">
<!--<script src="{{ URL::asset('js/jquery.validate.js?v=1') }}"></script>-->
<script src="{{ URL::asset('js/jquery.autoKana.js') }}"></script>
<script src="{{ URL::asset('js/chosen/chosen.jquery.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('js/assets/custom_edit_form.js') }}" type="text/javascript"></script>
<script>
  jQuery(function(){
    jQuery("#basicinfo").validationEngine();
  });
</script>
</body>
</html>
