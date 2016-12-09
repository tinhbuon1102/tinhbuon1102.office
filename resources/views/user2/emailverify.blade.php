<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header_beforelogin.php'); ?>
 @include('pages.header_beforelogin')
<!--/head-->
<body class="selectPage signup-page">
<div class="viewport" id="NoEnoughHeight">
<div class="header_wrapper primary-navigation-section">
<header id="header">
<div class="header_container dark">
<div class="logo_container"><a class="logo" href="{{url('/')}}">Offispo</a></div>
</div>
</header>
</div>
<div id="page-wrapper" class="thanks-page">
<div ui-view="" class="ng-scope">
<div class="signup-view ng-scope" ng-show="$root.pageLoaded" aria-hidden="false">
<div class="main-container">
<div id="main" class="container">

				<div class="msg-success" role="alert">
                <div class="center_big_icon"><i class="fa fa-check-circle" aria-hidden="true"></i></div>
	                <h2 class="ja">メール認証完了</h2>
					<p class="ja">
						メールが認証されました。<br/>
	                    ありがとうございます。
					</p>
                    <div class="login-btn"><a href="/RentUser/Dashboard" class="btn btn-primary btn-large">ログイン</a></div>
				</div>
                
@if(count($errors))					
<div ng-show="loginError" aria-hidden="true" class="" ><span class="label label-warning ng-binding">
	
						@foreach($errors->all() as $error)
							{{ $error }} <br/>
						@endforeach
				
</span></div>
@endif
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

		