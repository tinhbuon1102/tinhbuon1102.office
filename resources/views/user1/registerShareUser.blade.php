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
<style>
.signup-view .form-container .error {
	color: red !important;
}
</style>
</head>

<body class="signup-page">
	<div id="page-wrapper">
		<div ui-view="" class="ng-scope">
			<div class="signup-view ng-scope" ng-show="$root.pageLoaded" aria-hidden="false">
				<div class="form-container">
					<form id="frm" class="m-t ng-pristine ng-invalid ng-invalid-required" role="form" name="signupForm" method="post"
						action="Register-ShareUser/Step2">
						{{ csrf_field() }} @if(session()->has('suc'))
						<div class="alert alert-success" role="alert" style="color: green;">{{ session()->get('suc') }}</div>
						@endif

						<div class="welcome-legend" ng-hide="loginError" aria-hidden="false">
							<span class="label">先行情報配信をご希望の方は<br />こちらより会員登録をお願いいたします。
							</span>
						</div>
						<div ng-init="signup.step=1"></div>
						<div ng-init="signup.nextstep=2"></div>
						<!--<div class="input-container">
<label for="NameOfCompany">会社名</label>
<input name="NameOfCompany" value="<?=Session::get('NameOfCompany')?>" id="NameOfCompany" required="" ng-model="signup.company_name" type="text" class="ng-pristine ng-invalid ng-invalid-required ng-touched" aria-invalid="true">
</div>-->
						<div class="two-inputs">
							<div class="input-container input-half">
								<label for="LastName">ご担当者名(姓)</label> 
								<input name="LastName" id="LastName" value="<?=Session::get('LastName')?>" required=""
									ng-model="signup.last_name" type="text" class="ng-pristine ng-untouched ng-invalid ng-invalid-required" aria-invalid="true">
								@if($errors->first('LastName'))
									<div ng-show="LastNameError" class="input-error"><span class="label label-warning ng-binding">{{ $errors->first('LastName') }}</span></div>
								@endif
							</div>
							<div class="input-container input-half">
								<label for="FirstName">(名)</label> 
								<input name="FirstName" id="FirstName" value="<?=Session::get('FirstName')?>" required=""
									ng-model="signup.first_name" type="text" class="ng-pristine ng-invalid ng-invalid-required ng-untouched" aria-invalid="true">
								@if($errors->first('FirstName'))
									<div ng-show="FirstNameError" class="input-error"><span class="label label-warning ng-binding">{{ $errors->first('FirstName') }}</span></div>
								@endif
							</div>
						</div>
						<div class="input-container">
							<label for="Email">メールアドレス</label> 
							<input id="Email" name="Email" required="" ng-model="signup.email" value="<?=Session::get('Email')?>"
								type="Email" class="ng-pristine ng-untouched ng-invalid ng-invalid-required" aria-invalid="true"> 
							@if($errors->first('Email'))
								<div ng-show="emailError" class="input-error">
									<span class="label label-warning ng-binding">{{ $errors->first('Email') }}</span>
								</div>
							@endif
						</div>

						<div class="input-container">
							<label for="password">パスワード(ログインの際に使用されます)</label><input name="password" id="password" required="" ng-model="signup.password" type="password"
								class="ng-pristine ng-untouched ng-invalid ng-invalid-required" aria-invalid="true">
						</div>
						<button class="md-raised md-primary md-button md-ink-ripple" type="submit" aria-label="Next">
							<span class="ng-scope">次へ</span>
						</button>
					</form>
				</div>
			</div>
		</div>
	</div>


	<script src="{{ URL::asset('lpnew/dist/js/vendor/jquery.min.js') }} "></script>
	<script src="{{ URL::asset('js/jquery.validate.js?v=1') }}"></script>

	<script>
			$('button[type="submit"]').click(function(){
				$('.input-error .label').hide();
			})
			$("#frm").validate({
				  rules: {
			    Email: {
			      required: true,
			      email: true
			    }
			  }

			});
		</script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-78838677-1', 'auto');
  ga('send', 'pageview');

</script>
</body>
</html>
