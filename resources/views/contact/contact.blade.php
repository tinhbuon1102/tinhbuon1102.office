<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contact Us- hOur Office | アワーオフィス</title>
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

<meta property="og:url" content="{{url('/')}}/lp/public/contact" />
<meta property="og:type" content="website" />
<meta property="og:title" content="Contact Us- hOur Office | アワーオフィス" />
<meta property="og:image" content="{{url('/')}}/lpnew/images/fb-thum.jpg" />
<meta property="og:description" content="offispoについてご相談、ご質問がある方は以下のフォームからお問い合わせ下さい。" />

<style>
.signup-view .form-container .error {
	color: red !important;
}
</style>
</head>

<body class="signup-page contact-page">
	<div id="page-wrapper">
		<div ui-view="" class="ng-scope">
			<img src="{{url('/')}}/lpnew/images/fb-thum.jpg" style="display:none"/>
			<div class="signup-view ng-scope" ng-show="$root.pageLoaded" aria-hidden="false">
            <div class="con-form-container">
            <div class="logo-container"><a href="@if(str_contains(URL::previous(),'RentUser'))
			{{action('User2Controller@landing')}}
			@else
			{{url('/')}}/lp/public/
			@endif"><img src="{{url('/')}}/lpnew/images/logo.png" /></a></div>
            <h2>CONTACT US</h2>
            <p class="disc ja">offispoについてご相談、ご質問がある方は以下のフォームからお問い合わせ下さい。</p>
				<div class="form-container">
					<form id="frm" class="m-t ng-pristine ng-invalid ng-invalid-required" role="form" name="ContactForm" method="post" action="contact/send">
						{{ csrf_field() }} @if(session()->has('suc'))
						<div class="alert alert-success" role="alert" style="color: green;">{{ session()->get('suc') }}</div>
						@endif

						<div ng-show="loginError" aria-hidden="true" class="">
							<span class="label label-warning ng-binding" style="text-align: left;"> @if(count($errors)) @foreach($errors->all() as $error) {{ $error }} <br />
								@endforeach @endif
							</span>
						</div>
						<div class="half-form first">
							<div class="input-container">
								<input name="company_name" placeholder="会社名" id="company_name" value="<?=Session::get('company_name')?>" required="true"
									type="text" class="ng-pristine ng-untouched ng-invalid ng-invalid-required" aria-invalid="true">
							</div>
							<div class="input-container">
								<input name="name" placeholder="名前" id="name" value="<?=Session::get('name')?>" required="true"
									type="text" class="ng-pristine ng-invalid ng-invalid-required ng-untouched" aria-invalid="true">
							</div>
					
						<div class="input-container">
							<input id="tel" placeholder="電話番号" name="tel" required="true" value="<?=Session::get('tel')?>"
								type="tel" class="ng-pristine ng-untouched ng-invalid ng-invalid-required" aria-invalid="true">
							<div ng-show="telError" aria-hidden="true" class="ng-hide">
								<span class="label label-warning ng-binding">false</span>
							</div>
						</div>
						<div class="input-container">
						<input id="email" placeholder="メールアドレス" name="email" required="true" value="<?=Session::get('email')?>"
								type="email" class="ng-pristine ng-untouched ng-invalid ng-invalid-required" aria-invalid="true">
							<div ng-show="emailError" aria-hidden="true" class="ng-hide">
								<span class="label label-warning ng-binding">false</span>
							</div>
						</div>
                        </div><!--/half-->
                        <div class="half-form last">
						<div class="input-container">
							<textarea name="message" placeholder="お問い合わせ内容" id="message" required  class="ng-pristine ng-untouched ng-invalid ng-invalid-required" aria-invalid="true"><?=Session::get('message')?></textarea>
						</div>
                        </div><!--/half-->
						<button class="md-raised md-primary md-button md-ink-ripple" type="submit" aria-label="Send">
							<span class="ng-scope ja">送信</span>
						</button>
					</form>
				</div>
                </div>
			</div>
		</div>
	</div>


	<script src="{{ URL::asset('lpnew/dist/js/vendor/jquery.min.js') }} "></script>
	<script src="{{ URL::asset('js/jquery.validate.js?v=1') }}"></script>

	<script>
			$("#frm").validate({
				rules: {
					company_name: {
						required: true,
					},
					name: {
						required: true,
					},
					tel: {
						required: true,
					},
					email: {
						required: true,
						email: true
					},
					message: {
						required: true,
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
