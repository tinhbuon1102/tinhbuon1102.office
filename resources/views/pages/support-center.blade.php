@include('pages.header_beforelogin')
<body class="home support">
<div class="viewport">
<!--nav-->

            <?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header_nav_shareuser.php'); ?>
  @if(Auth::check())
  @include('pages.header_nav_shareuser')
  @elseif(Auth::guard('user2')->check())
  <?php $check_user=1; ?>
  @include('pages.header_nav_rentuser')
  @else
  @include('pages.before_login_nav')
  @endif

<!--/nav-->

<div class="hero-article hero-hiw-page ng-scope">
<div class="hero-article-content">
<h1 class="hero-article-title"><strong>サポートセンター</strong></h1>
</div>
<div class="parallax-container"></div>
</div>

<div class="home-top">
<section id="howitwork" class="white">
<div class="container">
<div class="flex-row flex-gutter-lg flex-stack flex-stack-gutter">
<div class="flex-cell">
<h6>トピックス</h6>
<hr>
<div id="desk_content_topics" class="flex-row flex-gutter-md flex-stack flex-stack-gutter">
<div class="flex-cell-w6">
<a href="{{url('help/guest')}}" class="text-link text-smoky block">
<div class="flex-row flex-gutter">
<div class="flex-cell-auto flex-align--middle">
<i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
</div>
<div class="flex-cell flex-align--middle">
<p class="text-line-base p-lg mb0">登録前ガイド</p>
</div>
</div>
</a>
</div>

<div class="flex-cell-w6">
<a href="{{url('help/rentuser')}}" class="text-link text-smoky block">
<div class="flex-row flex-gutter">
<div class="flex-cell-auto flex-align--middle">
<i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
</div>
<div class="flex-cell flex-align--middle">
<p class="text-line-base p-lg mb0">レントユーザー(利用者)ガイド</p>
</div>
</div>
</a>
</div>

<div class="flex-cell-w6">
<a href="{{url('help/shareuser')}}" class="text-link text-smoky block">
<div class="flex-row flex-gutter">
<div class="flex-cell-auto flex-align--middle">
<i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
</div>
<div class="flex-cell flex-align--middle">
<p class="text-line-base p-lg mb0">シェアユーザー(提供者)ガイド</p>
</div>
</div>
</a>
</div>

<div class="flex-cell-w6">
<a href="{{url('cancel-policy')}}" class="text-link text-smoky block">
<div class="flex-row flex-gutter">
<div class="flex-cell-auto flex-align--middle">
<i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
</div>
<div class="flex-cell flex-align--middle">
<p class="text-line-base p-lg mb0">キャンセルポリシー</p>
</div>
</div>
</a>
</div>

</div>
</div>
<div class="flex-cell-w4">
<h6>よくある質問</h6>
<hr>
<ul class="desk-content-faq">
<li class="faq-list-item"><a href="{{url('help/rentuser/howregister')}}" class="text-link text-positive">会員登録の方法</a></li>
<li class="faq-list-item"><a href="{{url('help/guest/aboutrentuser')}}" class="text-link text-positive">レント(利用者)会員について</a></li>
<li class="faq-list-item"><a href="{{url('help/guest/aboutshareuser')}}" class="text-link text-positive">シェア(提供者)会員について</a></li>
<li class="faq-list-item"><a href="{{url('help/guest/price')}}" class="text-link text-positive">利用料金について</a></li>
</ul>
<br/><br/>
<h6>他にもご質問はありますか？</h6>
<hr>
<a class="btn btn--positive btn-primary btn-large" href="{{url('contact-us')}}">お問い合わせ</a>
</div>
</div>
</div><!--/container-->
</section>
</div><!--/hometop-->
<!--footer-->
<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/common_footer.php'); ?>
		@include('pages.common_footer')

<!--/footer-->

</div><!--/viewport-->
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
