@include('pages.config')
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="robots" content="noindex">
<title>offispo | オフィスポ</title>
<link rel="stylesheet" href="<?php echo SITE_URL?>css/font-awesome/css/font-awesome.min.css">

<link rel="stylesheet" href="<?php echo SITE_URL?>css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">

<script type="text/javascript">
	var SITE_URL = '<?php echo SITE_URL?>';
</script>

<script class="rs-file" src="{{ URL::asset('js/assets/royalslider/jquery-1.8.3.min.js') }}"></script>
<script src="{{ URL::asset('js/bootstrap.min.js') }}" ></script>
<link href="{{ URL::asset('js/assets/preview-assets/css/reset.css') }}" rel="stylesheet">
<link href="{{ URL::asset('js/assets/preview-assets/css/smoothness/jquery-ui-1.8.22.custom.css') }}" rel="stylesheet">
<link href="{{ URL::asset('js/assets/preview-assets/css/github.css') }}" rel="stylesheet">

<link rel="stylesheet" href="{{ URL::asset('css/form-style.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
<style>
	.signup-view .form-container .error
	{
		color:red !important;
	}
</style>
</head>
<body class="selectPage">
<div id="page-wrapper">
<div ui-view="" class="ng-scope">
<div class="signup-view ng-scope" ng-show="$root.pageLoaded" aria-hidden="false">
<div id="signup-form" class="form-container">
					<label class="error">
						@foreach($errors->all() as $error)
							{{ $error }} <br/>
						@endforeach
						@if(session()->has('err'))
							Invalid Credential
						@endif
					</label>
<form class="m-t ng-pristine ng-invalid ng-invalid-required HomepageAuth-form fl-form large-form" id="frm" method="post" action="/FBLogin">
{{ csrf_field() }}
<div class="welcome-legend" ng-hide="loginError" aria-hidden="false"><span class="label">アカウント情報を入力してください。</span></div>
<div ng-init="signup.step=1"></div><div ng-init="signup.nextstep=2"></div>
<ol data-target="signup-fields">
<li class="form-step control-group signup-field">
<div class="HomepageAuth-form-tooltipWrapper">
<span class="fa fa-user input-icon">
<input name="UserName" type="text"  required="" placeholder="ユーザー名">
</span>
</div>
</li>


<li class="form-step control-group signup-field">
<div class="HomepageAuth-form-tooltipWrapper">
<span class="fa fa-lock input-icon">
<input name="password" id="password" required ng-model="signup.password" type="password" class="ng-pristine ng-untouched ng-invalid ng-invalid-required" aria-invalid="true" aria-required="true" placeholder="パスワード">
</span>
</div>
</li>

<li class="form-step control-group signup-field">
<div class="HomepageAuth-form-tooltipWrapper">
<span class="fa fa-lock input-icon">
<input name="password_confirmation" id="cpassword" required ng-model="signup.password" type="password" class="ng-pristine ng-untouched ng-invalid ng-invalid-required" aria-invalid="true" aria-required="true" placeholder="パスワード (確認)">
</span>
</div>
</li>
<li class="HomepageAuth-userType form-step control-group btn-group signup-user-type">
<p class="HomepageAuth-userType-title">オフィススペースを</p>
<span class="HomepageAuth-radioGroup button-group">
						<label class="HomepageAuth-radioGroup-button btn gry-btn">
                                <input type="radio" name="looking_for" id="looking_to_share" value="ShareUser" data-role="none" class="required">
                                提供する
                            </label><label class="HomepageAuth-radioGroup-button btn gry-btn">
                                <input type="radio" name="looking_for" id="looking_for_rent" value="RentUser" data-role="none">
                                利用する
                            </label>
                            </span>
</li>
</ol>
<button class="md-raised md-primary md-button md-ink-ripple" type="submit"><span class="ng-scope">アカウント作成</span></button>
</form>
</div>
</div>
</div>
    </div>
	<script src="{{ URL::asset('js/jquery.validate.js?v=1') }}"></script>
	
	<script>
			$("#frm").validate(
			
			rules: {
			   
				password : {
                    minlength : 5
                },
                password_confirmation : {
                    minlength : 5,
                    equalTo : "#password"
                }
			  },);
		</script>
</body>
</html>
