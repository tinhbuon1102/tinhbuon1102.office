@include('pages.header_beforelogin')
<body class="home">
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
<h1 class="hero-article-title"><strong>ヘルプ</strong></h1>
</div>
<div class="parallax-container"></div>
</div>

<div class="home-top">
<section id="howitwork" class="white">
<div class="container">
<div class="row">
<div class="col-md-12 help-content">
<div class="row tile-inner no-btm-border">
<div class="col-md-4">
<a href="{{url('help/guest')}}">
<i class="help-icons-size icon-add-helps-icons_searchp"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
<span>登録前ガイド</span>
</a>
</div>
<div class="col-md-4">
<a href="{{url('help/rentuser')}}">
<i class="help-icons-size icon-add-helps-icons_ruser"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
<span>レントユーザー(利用者)ガイド</span>
</a>
</div>
<div class="col-md-4">
<a href="{{url('help/shareuser')}}">
<i class="help-icons-size icon-add-helps-icons_suser"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span></i>
<span>シェアユーザー(提供者)ガイド</span>
</a>
</div>
</div>
</div>
</div><!--/row-->
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
