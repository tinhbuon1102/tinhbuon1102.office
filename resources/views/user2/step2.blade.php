@extends('user2Layout')
@section('title')
	先行シェア会員登録- hOur Office | アワーオフィス
@stop
@section('head')
<link rel="stylesheet" href="{{ URL::asset('lpnew/rentuser/signup/style.css') }}">
<link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
<link href="{{ URL::asset('lpnew/rentuser/dist/css/vendor/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('lpnew/rentuser/dist/css/flat-ui.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('lpnew/rentuser/assets/css/docs.css') }}" rel="stylesheet">
@stop


@section('content')
<body class="signup-page">
<div id="page-wrapper">
<div ui-view="" class="ng-scope">
<div class="signup-view ng-scope" ng-show="$root.pageLoaded" aria-hidden="false">
<div class="form-container no-logo">
<form class="m-t ng-pristine ng-invalid ng-invalid-required" role="form" name="signupForm" method="post" action="{{ url('Register-RentUser/Confirm') }}" id="frm">
					{{ csrf_field() }}

<div ng-show="loginError" aria-hidden="true" class="ng-hide"><span class="label label-warning ng-binding"></span></div>
<div class="welcome-legend" ng-hide="loginError" aria-hidden="false"><span class="label large">詳細情報</span></div>
<div ng-init="signup.step=1"></div><div ng-init="signup.nextstep=2"></div>
<div class="input-container">
<label for="company_postcode">郵便番号</label>
<input name="PostalCode" value="<?=Session::get('PostalCode')?>" id="PostalCode"  required="" ng-model="signup.company_postcode" type="text" size="10" maxlength="8" onKeyUp="AjaxZip3.zip2addr(this,'','Address','Address');" class="ng-pristine ng-invalid ng-invalid-required ng-untouched" aria-invalid="true">
</div>
<div class="input-container">
<label for="company_address">住所(郵便番号から自動入力されます)</label>
<input name="Address" value="<?=Session::get('Address')?>" id="Address" required="" ng-model="signup.company_address" type="text" size="60" class="ng-pristine ng-invalid ng-invalid-required ng-untouched" aria-invalid="true">
</div>
<div class="input-container">
    <label for="company_address">事業主種類</label> 
    <select id="UserType" name="UserType" class="old_ui_selector">
      <option value="個人事業主" selected>個人事業主</option>
      <option value="法人">法人</option>
    </select></div>
    <div class="input-container">
    <label for="company_address">事業のタイプ</label> 
    <select id="BusinessType" name="BusinessType" class="old_ui_selector">
      <option value="カテゴリを選択" selected>カテゴリを選択</option>
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
    </select></div>
<div class="input-container">
<label class="checkbox">
<input type="checkbox" data-toggle="checkbox" checked="checked" value="Yes" name="Newsletter">メールマガジンを希望する
</label>
</div>
<button class="md-raised md-primary md-button md-ink-ripple" type="submit" aria-label="Next" ><span class="ng-scope">登録情報を確認する</span></button>
</form>
</div>
</div>
</div>
</div>
<script src="{{ URL::asset('lpnew/rentuser/dist/js/vendor/jquery.min.js') }}"></script>
<script src="{{ URL::asset('lpnew/rentuser/docs/assets/js/application.js') }}"></script>
<script src="{{ URL::asset('lpnew/rentuser/dist/js/vendor/video.js') }}"></script>
<script src="{{ URL::asset('lpnew/rentuser/dist/js/flat-ui.min.js') }}"></script>
	<script src="{{ URL::asset('js/ajaxzip3.js') }}"></script>

</body>
@stop