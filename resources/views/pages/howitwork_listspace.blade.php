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
<h1 class="hero-article-title"><strong>ご利用ガイド</strong></h1>
</div>
<div class="parallax-container"></div>
</div>

<div class="home-top">
<section id="howitwork" class="white">
<div class="container">
<div class="layout-story-header ng-scope">
<h3 class="story-title text-center">スペース掲載の流れ</h3>
<div class="hiwn-hiwp-copy">以下の手順で魅力的なスペース掲載をしましょう。</div>
</div>
<div class="hiw-list-block">
<div class="hiwp-option">
  <div class="col-left-120"><div class="hiwp-option-icon"><i class="fa fa-building" aria-hidden="true"></i></div></div>
  <div class="col-right-disc">
  <div class="hiwp-option-header h4">オフィススペースを追加</div>
  <div class="hiwp-option-copy">
  オフィススペースを追加するのに5分もかかりません。<br/>
  オフィススペースの名称、写真の追加、料金設定など、自由にあなたのスペース紹介ページを作成しましょう。
  利用者にとって魅力的なオフィススペースを伝えるために、きれいな写真とスペースの紹介文をきちんと書くことはとても重要です。
  <br/><a href="{{url('help/shareuser/listspace')}}" class="link-to"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> 詳しくはこちら</a>

               </div>
  </div>
</div>
<div class="hiwp-option">
  <div class="col-left-120"><div class="hiwp-option-icon hiwp-option-icon-2"><i class="fa fa-calendar-check-o" aria-hidden="true"></i></div></div>
  <div class="col-right-disc">
  <div class="hiwp-option-header h4">スケジュールの設定</div>
  <div class="hiwp-option-copy">
リアルタイムでの予約可能時間を提供するため、オフィススペースの予約可能時間、日程をカレンダーにて設定しましょう。
あなたの提供したい日や時間を選ぶことで、リアルタイムでのスペース予約受付が可能です。
<br/><a href="{{url('help/shareuser/add-schedule')}}" class="link-to"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> 詳しくはこちら</a>
</div>
  </div>
</div>
<div class="hiwp-option">
  <div class="col-left-120"><div class="hiwp-option-icon hiwp-option-icon-3"><i class="fa fa-check-square-o" aria-hidden="true"></i></div></div>
  <div class="col-right-disc">
  <div class="hiwp-option-header h4">予約の受付と確認</div>
  <div class="hiwp-option-copy">
 利用者からの予約を確認し、受付を完了させましょう。空き情報や予約情報はカレンダーにてすぐに確認できます。
 あなたが予約受け付けを完了した時点で、利用者の予約は完了となり、支払も完了となります。
 予約が入ったときは、メールやダッシュボードのタイムラインにて、予約状況がすぐに確認できます。
 <br/><a href="{{url('help/shareuser/check-booking')}}" class="link-to"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> 詳しくはこちら</a>
               </div>
  </div>
</div>
<div class="hiwp-option">
  <div class="col-left-120"><div class="hiwp-option-icon hiwp-option-icon-4"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></div></div>
  <div class="col-right-disc">
  <div class="hiwp-option-header h4">オフィススペース提供開始・終了</div>
  <div class="hiwp-option-copy">
予約受付どおり、あなたのオフィススペースを提供しましょう。
利用期間が終了しましたら、双方レビューを投稿しましょう。
利用者からのレビューはあなたのスペースの評価を高めます。
 <br/><a href="{{url('help/shareuser/review')}}" class="link-to"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> 詳しくはこちら</a>
               </div>
  </div>
</div>
</div>
</div>
</section>
<section id="hiw-feature" class="gray">
<div class="container">
<div class="layout-story-header ng-scope">
<h3 class="story-title text-center">hOur Officeの利用方法</h3>
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
</div><!--/hometop-->
<!--footer-->
<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/common_footer.php'); ?>
		@include('pages.common_footer')

<!--/footer-->
<!-- /forget password form -->
</div><!--/viewport-->
</body>
</html>
