<div class="user-view edit-view">
	<form id="basicinfo" action="" method="post">
{{ csrf_field() }} 
<div id="feed"><section class="feed-first-row feed-box">
<div class="dashboard-section-heading-container">
				<h3 class="dashboard-section-heading">
					アカウント情報
				</h3>
			</div>
<div class="form-container">
<div class="form-field two-inputs">
<div class="input-container input-half">
<label for="userName">ユーザー名</label>
<input name="UserName" value="{{$user->UserName}}" type="text" data-target="signup-username" readonly disabled>
</div>
<div class="input-container input-half">
<label for="Email">メールアドレス</label>
<input name="Email" value="{{$user->Email}}" type="email" data-target="signup-email"  >
</div>
</div><!--/form-field-->
</div>
</section></div>
<div class="hr"></div>
<div id="feed"><section class="feed-first-row feed-box">
<div class="dashboard-section-heading-container">
				<h3 class="dashboard-section-heading">
					ユーザープロフィール
				</h3>
			</div>
<div class="form-container">
<div class="form-field two-inputs">
<div class="input-container input-half">
<label for="typeOrg"><span class="require-mark">*</span>事業主種類<!--Type of organization--></label>
<select id="UserType" name="UserType" class="old_ui_selector">
      <option value="個人事業主" selected="">個人事業主</option>
      <option value="法人">法人</option>
    </select>
</div>
<div class="input-container input-half">
<label for="typeBusiness"><span class="require-mark">*</span>事業のタイプ<!--Type of business--></label>
<select id="BusinessType" name="BusinessType" class="old_ui_selector">
      <option value="カテゴリを選択" selected="">事業タイプを選択</option>
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
</div><!--/form-field-->
</div>
<div class="form-container">
<div class="form-field two-inputs">
<div class="input-container input-half">
<label for="last_name"><span class="require-mark">*</span>姓</label>
<input name="LastName" value="{{$user->LastName}}" id="LastName" value="" required="" ng-model="signup.last_name" type="text" class="ng-pristine ng-untouched ng-invalid ng-invalid-required" aria-invalid="true" aria-required="true" placeholder="佐藤">
</div>
<div class="input-container input-half">
<label for="last_name"><span class="require-mark">*</span>名</label>
<input name="FirstName" value="{{$user->FirstName}}" id="FirstName" value="" required="" ng-model="signup.first_name" type="text" class="ng-pristine ng-invalid ng-invalid-required ng-untouched" aria-invalid="true" aria-required="true" placeholder="太郎">
</div>
</div><!--/form-field-->
<div class="form-field two-inputs">
<div class="input-container input-half">
<label for="last_name"><span class="require-mark">*</span>姓(ふりがな)</label>
<input name="LastNameKana" value="{{$user->LastNameKana}}" id="LastNameKana" value="" required="" ng-model="signup.last_name_kana" type="text" class="ng-pristine ng-untouched ng-invalid ng-invalid-required" aria-invalid="true" aria-required="true" placeholder="さとう">
</div>
<div class="input-container input-half">
<label for="last_name"><span class="require-mark">*</span>名(ふりがな)</label>
<input name="FirstNameKana" value="{{$user->FirstNameKana}}" id="FirstNameKana" value="" required="" ng-model="signup.first_name_kana" type="text" class="ng-pristine ng-invalid ng-invalid-required ng-untouched" aria-invalid="true" aria-required="true" placeholder="たろう">
</div>
</div><!--/form-field-->
</div>
<div class="form-container">
<div class="form-field two-inputs">
<div class="input-container input-half">
<label for="last_name"><span class="require-mark">*</span>生年月日</label>
<select name="BirthYear" id="BirthYear" class="wd-auto">
<?php
$now = date("Y");
for($i = 1950; $i<= $now; $i++):?>
<option value="<?php echo $i;?>"><?php echo $i;?></option>
<?php endfor;?>
</select>
年
<select name="BirthMonth" id="BirthMonth" class="wd-auto">
<?php
for($i = 1; $i<=12; $i++):?>
<option value="<?php echo $i;?>"><?php echo $i;?></option>
<?php endfor;?>
</select>
月
<select name="BirthDay" id="BirthDay" class="wd-auto">
<?php 
for($i = 1; $i<=31; $i++):?>
<option value="<?php echo $i;?>"><?php echo $i;?></option>
<?php endfor;?>
</select>
        日
</div>
<div class="input-container input-half">
<label for="sex"><span class="require-mark">*</span>性別</label>
<select name="Sex" id="Sex"  class="wd-80">
<option value="男性" selected>男性</option>
<option value="女性">女性</option>
</select>
</div>
</div><!--/form-field-->
</div>

<div class="form-container">
<div class="form-field address-wrapper">
							<label for="require-place">
								<span class="require-mark">*</span>
								Address
								<!--住所-->
							</label>
							<div class="input-container">
								<div class="address-display-wrapper" data-bind="visible: !addressEdit()">
									<a href="javascript:void(0)" class="toggle_button" bind-toggle=".address-edit-wrapper, .address-wrapper" data-bind="click: toggleAddressEdit">Edit</a>
									<input type="text" value="{{$user->PostalCode}} {{$user->Prefecture}} {{$user->City}} {{$user->Address1}}" data-bind="textInput: fullAddress, disable: !addressEdit()" disabled="">
								</div>
							</div>
						</div>
<!--if you click edit link,show this-->
<div class="address-edit-wrapper" data-bind="visible: addressEdit" style="display: none;">
<div class="form-field two-inputs">
<div class="input-container input-half">
<label for="zip"><span class="require-mark">*</span>郵便番号</label>
<input name="PostalCode" value="{{$user->PostalCode}}" id="zip" type="text"　class="ng-pristine ng-untouched ng-invalid-required" aria-required="true">
</div>
</div><!--/form-field-->
<div class="form-field two-inputs">
<div class="input-container input-half">
<label for="zip"><span class="require-mark">*</span>都道府県</label>
<input name="Prefecture" value="{{$user->Prefecture}}" id="prefecture" type="text" class="ng-pristine ng-untouched ng-invalid-required" aria-required="true" placeholder="都道府県">
</div>
<div class="input-container input-half">
<label for="zip"><span class="require-mark">*</span>市区町村</label>
<input name="City" value="{{$user->City}}" id="city" type="text" class="ng-pristine ng-untouched ng-invalid-required" aria-required="true" placeholder="市区町村">
</div>
</div><!--/form-field-->
<div class="form-field">
<div class="input-container">
<label for="addr"><span class="require-mark">*</span>番地等</label>
<input name="Address1" value="{{$user->Address1}}" id="Addr" value="" required="" ng-model="signup.addr" type="text" class="ng-pristine ng-untouched ng-invalid-required" aria-required="true" placeholder="番地等">
</div>
</div><!--/form-field-->
<a href="javascript:void(0)" class="toggle_button" bind-toggle=".address-edit-wrapper, .address-wrapper">Cancel to Edit</a>
</div><!--/address-edit-wrapper-->
<!--/if you click edit link,show this-->

</div><!--/form-container-->

<div class="form-container">
<div class="form-field two-inputs">
<div class="input-container input-half">
<label for="phoneNumber"><span class="require-mark">*</span>電話番号</label>
<input name="Tel" value="{{$user->Tel}}" id="phone-number" type="text"　class="ng-pristine ng-untouched ng-invalid-required" aria-required="true">
</div>
</div><!--/form-field-->
</div>


</section></div>
<div class="set-btn"><button id="SubmitBtn" class="btn btn-info submitSettingsBtn" type="submit">更新</button></div>

</form>
</div>

<!-- /.row -->
