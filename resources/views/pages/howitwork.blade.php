
<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header_beforelogin.php');
 ?>
 @include('pages.header_beforelogin')
<!--/head-->
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
<h1 class="hero-article-title"><strong>ご利用ガイド</strong></h1>
</div>
<div class="parallax-container"></div>
</div>

<div class="home-top">
<section id="howitwork" class="white">
<div class="container">
<div class="layout-story-header ng-scope">
<h3 class="story-title text-center">Offispoのご利用方法</h3>
<div class="hiwn-hiwp-copy">各種カテゴリーからご利用方法をご参照ください。</div>
</div>
<div class="hiw-media-block">
<div class="row">
  <div class="col-md-4 spaces-media-cell">
  <a href="/how-it-works/find-space" class="media-bg-cover media-bg-hiw-findspace">
<div aria-hidden="true" class="media-bg-cover-title hide">Cover - Find a space</div>
  </a>
  <div class="text-center gutter">
  <h6>スペースを探す/利用する</h6>
<div class="mini-block">
<a class="text-link text-positive" href="/how-it-works/find-space">
スペース探しからご利用まで<i aria-hidden="true" class="icon icon-right-open align-middle"></i>
</a>
</div>
 </div>
  </div>
  <div class="col-md-4 spaces-media-cell">
  <a href="/how-it-works/list-space" class="media-bg-cover media-bg-hiw-listspace">
<div aria-hidden="true" class="media-bg-cover-title hide">Cover - List a space</div>
  </a>
  <div class="text-center gutter">
  <h6>スペースを掲載する</h6>
<div class="mini-block">
<a class="text-link text-positive" href="/how-it-works/list-space">
スペース掲載方法の手順<i aria-hidden="true" class="icon icon-right-open align-middle"></i>
</a>
</div>
 </div>
  </div>
  <div class="col-md-4 spaces-media-cell">
  <a href="/how-it-works/manage-booking" class="media-bg-cover media-bg-hiw-manage">
<div aria-hidden="true" class="media-bg-cover-title hide">Cover - Manage a space</div>
  </a>
  <div class="text-center gutter">
  <h6>スペースを管理する</h6>
<div class="mini-block">
<a class="text-link text-positive" href="/how-it-works/manage-booking">
スペースの予約受け付け、管理方法など<i aria-hidden="true" class="icon icon-right-open align-middle"></i>
</a>
</div>
 </div>
  </div>
</div>
</div>
</div><!--/container-->
</section>
<section id="hiw-feature" class="gray">
<div class="container">
<div class="layout-story-header ng-scope">
<h3 class="story-title text-center">Offispoの利用メリット</h3>
</div>
<div class="ofsp-benefit">
<div class="row">
  <div class="col-md-6 hiwn-benefit">
  <div class="hiwn-benefit-icon hiwn-benefit-icon-connect"><span class="icon-offispo-icon-07"></span></div>
  <div class="hiwn-benefit-content">
<div class="hiwn-benefit-header h4">月、週、日毎に利用できるオフィス</div>
<div class="hiwn-benefit-copy">一日毎、一月だけ使いたい！貸したい！などの希望もOffispoなら可能。時間単位、日単位、週単位、月単位での利用、提供ができます。</div>
</div>
  </div>
  <div class="col-md-6 hiwn-benefit">
  <div class="hiwn-benefit-icon hiwn-benefit-icon-connect"><span class="icon-offispo-icon-06"></span></div>
  <div class="hiwn-benefit-content">
<div class="hiwn-benefit-header h4">直接やりとりができる</div>
<div class="hiwn-benefit-copy">スペースに関する詳細や利用についての聞きたいことを、シェアユーザー(スペース提供者)とレントユーザー（スペース利用者）間で直接やりとりができるダイレクトメール機能がついています。</div>
</div>
  </div>
</div>
<div class="row">
  <div class="col-md-6 hiwn-benefit">
  <div class="hiwn-benefit-icon hiwn-benefit-icon-connect"><span class="icon-icon-network"></span></div>
  <div class="hiwn-benefit-content">
<div class="hiwn-benefit-header h4">業種に特化したネットワーク</div>
<div class="hiwn-benefit-copy">双方のユーザープロフィールに業界や事業内容が記載されているので、気になる業種のオフィスで働くことも可能。シェアユーザーは気になる人材との出会いにも繋がります。</div>
</div>
  </div>
  <div class="col-md-6 hiwn-benefit">
  <div class="hiwn-benefit-icon hiwn-benefit-icon-connect"><span class="icon-offispo-icon-05"></span></div>
  <div class="hiwn-benefit-content">
<div class="hiwn-benefit-header h4">クレジットカードにて簡単・安心決済</div>
<div class="hiwn-benefit-copy">決済方法はクレジットカード引き落としなので、 支払い忘れ、未払いの心配も無く、簡単に安心決済ができます。</div>
</div>
  </div>
</div>
<div class="row">
  <div class="col-md-6 hiwn-benefit">
  <div class="hiwn-benefit-icon hiwn-benefit-icon-connect"><i class="icon-icon-user"></i></div>
  <div class="hiwn-benefit-content">
<div class="hiwn-benefit-header h4">利用・提供ユーザーの信頼性</div>
<div class="hiwn-benefit-copy">双方のユーザー登録基準は個人証明書や会社証明書などの提出のもと、会員権限を与えていますので、トラブルなどが起こりにくい厳選されたユーザー同士でご利用頂けます。</div>
</div>
  </div>
  <div class="col-md-6 hiwn-benefit">
  <div class="hiwn-benefit-icon hiwn-benefit-icon-connect"><span class="icon-offispo-icon-08"></span></div>
  <div class="hiwn-benefit-content">
<div class="hiwn-benefit-header h4">安心かんたん利用規約</div>
<div class="hiwn-benefit-copy">煩わしい契約書は無く、Offispoで用意した利用規約を用意しております。双方ユーザーはその<a href="#">利用規約</a>のもと、利用、提供を行うので安心です。</div>
</div>
  </div>
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
</body>
</html>
