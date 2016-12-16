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
</head>

<body class="signup-page thankpage">
<div id="page-wrapper" class="thanks-page">
<div ui-view="" class="ng-scope">
<div class="signup-view ng-scope" ng-show="$root.pageLoaded" aria-hidden="false">
<div class="form-container">

				<div class="alert alert-success" role="alert">
                <h2 class="ja">お問い合わせありがとうございます</h2>
				<p class="ja">
					ご入力頂いたメールアドレスに、<br/>お問い合わせ内容のご確認メールを送信しました。<br/>
                    2営業日以内に担当者から返信させて頂きますので、<br/>しばらくお待ち下さい。
                </p>
				</div>
                <div class="close-btn"><a href="{{url('/')}}/lp/public/">サイトに戻る</a></div>
					
<div ng-show="loginError" aria-hidden="true" class="" ><span class="label label-warning ng-binding" style="text-align:left;">
	@if(count($errors))
						@foreach($errors->all() as $error)
							{{ $error }} <br/>
						@endforeach
				@endif
</span></div>

</div>
</div>
</div>
</div>


<script src="{{ URL::asset('lp/dist/js/vendor/jquery.min.js') }}"></script>


</body>
</html>
