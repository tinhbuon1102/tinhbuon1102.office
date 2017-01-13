@include('pages.header_beforelogin')
<body class="home not-found">
	<div class="viewport">
					<!--nav-->
					<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header_nav_shareuser.php'); ?>
					@if(Auth::check()) @include('pages.header_nav_shareuser') @elseif(Auth::guard('user2')->check())
					<?php $check_user=1; ?>
					@include('pages.header_nav_rentuser') @else @include('pages.before_login_nav') @endif
					<!--/nav-->
				
        <div class="main-container">
		<div class="hero-article hero-hiw-page ng-scope">
			<div class="hero-article-content">
				<h1 class="hero-article-title">
					<strong>404 File Not Found</strong>
				</h1>
			</div>
			<div class="parallax-container"></div>
		</div>
		<!--/hometop-->
        <div class="error-404">
        <div class="error-404-message">
        <h1>お探しのページが見つかりません。</h1>
        <p>お探しのページは一時的にアクセスできない状況にあるか、<br class="mb-none">移動、もうしくは削除された可能性があります。<br/>
        お手数ですが、アワーオフィスのトップページ、または各コンテンツからお探し下さい。</p>
        </div>
        <div class="links">
        <a href="{{url('/')}}"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i>トップページに戻る</a>
        </div>
        </div>
        </div>
		<!--footer-->
		<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/common_footer.php'); ?>
		@include('pages.common_footer')
		<!--/footer-->
	</div>
	<!--/viewport-->
	<script>
$(document).ready(function(){
    $('.tree-click').click(function(){
        $(this).next('.sub-tree').stop(true, true).slideToggle();
		$(".tree-target").toggleClass("active");
    });
});
</script>
</body>
</html>
