<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header_beforelogin.php'); ?>
 @include('pages.header_beforelogin')
<!--/head-->
<body class="selectPage success-pre">
<div class="viewport" id="NoEnoughHeight">
<div class="header_wrapper primary-navigation-section">
<header id="header">
<div class="header_container dark">
<div class="logo_container"><a class="logo" href="{{url('/')}}">Offispo</a></div>
</div>
</header>
</div>
<div id="stepArea">
<ol class="cd-breadcrumb triangle custom-icons">
<li>
<span><span class="round-number">&#9312;</span>メールアドレス登録</span>
</li>
<li>
<span><span class="round-number">&#9313;</span>基本情報入力</span>
</li>
<li class="current">
<span><span class="round-number">&#9314;</span>仮登録完了</span>
</li>
</ol>
</div>
<div id="page-wrapper" class="thanks-page">
<div ui-view="" class="ng-scope">
<div class="signup-view ng-scope" ng-show="$root.pageLoaded" aria-hidden="false">
<div class="main-container">
<div id="main" class="container">

				<div class="msg-success" role="alert">
                <div class="center_big_icon"><i class="fa fa-check-circle" aria-hidden="true"></i></div>
                <h2 class="ja">仮登録が完了しました。</h2>
				<p class="ja">
				ご登録ありがとうございます。Offispo会員仮登録が完了しました。<br/>
                ご登録頂いたメールアドレス宛に、仮登録完了メールをお送りしました。<br/>
                メールをご確認頂き、メール認証を完了させてください。
				</p>
                <p class="ja notice">※メール受信設定によっては、オフィスポからのメールが届かない場合があります。受信設定をご確認のうえ、「迷惑メール」フォルダーに振り分けられていないかもご確認ください。</p>
				</div>
               
	@if(count($errors))				
<div ng-show="loginError" aria-hidden="true" class="" ><span class="label label-warning ng-binding" style="text-align:left;">
	
						@foreach($errors->all() as $error)
							{{ $error }} <br/>
						@endforeach
				
</span></div>@endif
</div>
</div>
</div>
</div>
</div>
<!--footer-->
		@include('pages.signup_footer')
		<!--/footer-->
</div>

<script src="{{ URL::asset('lp/dist/js/vendor/jquery.min.js') }}"></script>
<script>
jQuery(window).load(function() {
//画面高さ取得
h = jQuery(window).height();
jQuery("#NoEnoughHeight").css("min-height", h + "px");
});
jQuery(window).resize(function() {
//画面リサイズ時の高さ取得
h = jQuery(window).height();
jQuery("#NoEnoughHeight").css("min-height", h + "px");
});
</script>

</body>
</html>
