<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>先行シェア会員登録- Offispo | オフィスポ</title>
<link rel="apple-touch-icon" sizes="57x57" href="{{url('/')}}/lpnew/images/favicon/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="{{url('/')}}/lpnew/images/favicon/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="{{url('/')}}/lpnew/images/favicon/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="{{url('/')}}/lpnew/images/favicon/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="{{url('/')}}/lpnew/images/favicon/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="{{url('/')}}/lpnew/images/favicon/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="{{url('/')}}/lpnew/images/favicon/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="{{url('/')}}/lpnew/images/favicon/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="{{url('/')}}/lpnew/images/favicon/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="{{url('/')}}/lpnew/images/favicon/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="{{url('/')}}/lpnew/images/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="{{url('/')}}/lpnew/images/favicon/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="{{url('/')}}/lpnew/images/favicon/favicon-16x16.png">
<link rel="manifest" href="/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="{{url('/')}}/lpnew/images/favicon/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">
<link rel="stylesheet" href="{{ URL::asset('lpnew/style.css') }}">
<link rel="stylesheet" href="{{ URL::asset('lpnew/signup/style.css') }}">
<link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="//fonts.googleapis.com/earlyaccess/notosansjapanese.css">
<link href="{{ URL::asset('lpnew/dist/css/vendor/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('lpnew/dist/css/flat-ui.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('lpnew/assets/css/docs.css') }}" rel="stylesheet">
<script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>

<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
<!--[if lt IE 9]>
<script src="../js/vendor/html5shiv.js"></script>
<script src="../js/vendor/respond.min.js"></script>
<![endif]-->
<style>
		.signup-view .form-container .error{
			color:red !important;
		}
	</style>
</head>

<body class="signup-page">
<div id="page-wrapper">
<div ui-view="" class="ng-scope">
<div class="signup-view ng-scope" ng-show="$root.pageLoaded" aria-hidden="false">
<div class="form-container no-logo">
<form class="m-t ng-pristine ng-invalid ng-invalid-required" role="form" name="signupForm" method="post" action="{{ url('Register-ShareUser/Confirm') }}" id="frm">
					{{ csrf_field() }}

<div ng-show="loginError" aria-hidden="true" class="ng-hide"><span class="label label-warning ng-binding"></span></div>
<div class="welcome-legend" ng-hide="loginError" aria-hidden="false"><span class="label large">会社情報</span></div>
<div ng-init="signup.step=1"></div><div ng-init="signup.nextstep=2"></div>
<div class="input-container">
<label for="NameOfCompany">会社名</label>
<input name="NameOfCompany" value="<?=Session::get('NameOfCompany')?>" id="NameOfCompany" required="" ng-model="signup.company_name" type="text" class="ng-pristine ng-invalid ng-invalid-required ng-touched" aria-invalid="true">
</div>
<div class="input-container web">
<label for="PostalCode">会社サイトURL</label>
<input name="WebUrl" value="<?=Session::get('WebUrl')?>" id="WebUrl" required="" ng-model="signup.WebUrl" type="web"  class="ng-pristine ng-invalid ng-invalid-required ng-untouched" aria-invalid="true">
</div>
<div class="add" style="display:none">
<div class="input-container">
<label for="PostalCode">郵便番号</label>
<input name="PostalCode" value="<?=Session::get('PostalCode')?>" id="PostalCode" required="" ng-model="signup.company_postcode" type="text" size="10" maxlength="8" onKeyUp="AjaxZip3.zip2addr(this,'','Address','Address');" class="ng-pristine ng-invalid ng-invalid-required ng-untouched" aria-invalid="true">
</div>
<div class="input-container">
<label for="Address">住所</label>
<input name="Address" value="<?=Session::get('Address')?>" id="Address" required="" ng-model="signup.company_address" type="text" size="60" class="ng-pristine ng-invalid ng-invalid-required ng-untouched" aria-invalid="true">
</div>
<div class="input-container">
<label for="Tel">電話番号</label>
<input name="Tel" id="Tel" value="<?=Session::get('Tel')?>" required="" ng-model="signup.company_tel" type="tel" class="ng-pristine ng-invalid ng-invalid-required ng-untouched" aria-invalid="true">
</div>
</div>
<div class="input-container">
<label class="checkbox">
<input type="checkbox" data-toggle="checkbox" value="Yes" name="isweb" id='isweb'>サイト無し
</label>
</div>

<div class="input-container">
<label class="checkbox">
<input type="checkbox" data-toggle="checkbox" checked="checked" value="Yes" name="Newsletter">メールマガジンを希望する
</label>
</div>
<button class="md-raised md-primary md-button md-ink-ripple" type="submit"  aria-label="Next"><span class="ng-scope">登録内容を確認</span></button>
</form>
</div>
</div>
</div>
</div>
<script src="{{ URL::asset('lpnew/dist/js/vendor/jquery.min.js') }}"></script>
<script src="{{ URL::asset('lpnew/docs/assets/js/application.js') }}"></script>
<script src="{{ URL::asset('lpnew/dist/js/vendor/video.js') }}"></script>
<script src="{{ URL::asset('lpnew/dist/js/flat-ui.min.js') }}"></script>
    <script src="{{ URL::asset('js/jquery.validate.js?v=1') }}"></script>

<script>

	jQuery('#isweb').change(function() {

        if(jQuery(this).is(":checked")) {
			jQuery('.add').show();
			jQuery('.web').hide();
		}
		else
		{
		jQuery('.web').show();
			jQuery('.add').hide();
		}
		});
</script>
<script>
			$("#frm").validate({
  rules: {
    WebUrl: {
      required: true,
      url: true
    }
  }
});
		</script>
</body>
</html>
