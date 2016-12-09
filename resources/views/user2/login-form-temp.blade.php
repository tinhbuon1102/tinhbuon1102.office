<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header_beforelogin.php'); ?>
@include('pages.header_beforelogin')
<!--/head-->
<body class="selectPage loginpage">
	<div class="viewport" id="NoEnoughHeight">
		<div id="page-wrapper">
			<div ui-view="" class="ng-scope">
				<div class="signup-view ng-scope" ng-show="$root.pageLoaded" aria-hidden="false">
					<div class="form-container">
						<label class="error">
							@foreach($errors->all() as $error) {{ $error }}
							<br />
							@endforeach @if(session()->has('err')) {{session()->get('err')}} @endif
						</label>
						<form class="m-t ng-pristine ng-invalid ng-invalid-required" id="frm" method="post" action="/User2/Validate">
							{{ csrf_field() }}
							<div class="welcome-legend" ng-hide="loginError" aria-hidden="false">
								<span class="label">レント会員ログインフォーム</span>
							</div>
							<div class="HomepageAuth-facebookWrapper">
								<a href="/FBLoginRedirect?looking_for=RentUser">
									<button class="btn-facebook gaf-fb-connected-button btn btn-large" data-track_click="true" data-category="pinterest_button" data-action="signUp-facebook" data-qts="FacebookSignup" type="button">
										<span>
											<i class="fa fa-facebook-official" aria-hidden="true"></i>
											Facebookでログイン
										</span>
									</button>
								</a>
							</div>
							<div class="hr">
								<div class="inner">or</div>
							</div>
							<div ng-init="signup.step=1"></div>
							<div ng-init="signup.nextstep=2"></div>
							<div class="input-container">
								<label for="email">メールアドレス</label>
								<input id="Email" name="Email" required="" ng-model="signup.email" value="" type="Email" class="ng-pristine ng-untouched ng-invalid ng-invalid-required">
							</div>
							<div class="input-container">
								<label for="password">パスワード</label>
								<input name="password" id="password" required="" ng-model="signup.password" type="password" class="ng-pristine ng-untouched ng-invalid ng-invalid-required" aria-invalid="true" aria-required="true">
							</div>
							<button class="md-raised md-primary md-button md-ink-ripple" type="submit">
								<span class="ng-scope">ログイン</span>
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!--footer-->
		@include('pages.loginform_footer')
		<!--/footer-->

</body>
</html>
