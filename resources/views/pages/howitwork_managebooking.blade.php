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
<h3 class="story-title text-center">オフィススペース管理方法</h3>
<div class="hiwn-hiwp-copy">オフィススペースの予約受付、管理方法について</div>
</div>
<div class="hiw-list-block">
<div class="hiwp-option">
  <div class="col-left-120"><div class="hiwp-option-icon hiwp-option-icon-1"><i class="fa fa-check-square-o" aria-hidden="true"></i></div></div>
  <div class="col-right-disc">
  <div class="hiwp-option-header h4">予約申込みの確認と<br class="show-sp">支払いの承認</div>
  <div class="hiwp-option-copy">
  提供オフィススペースの予約は予約一覧ページにて確認できます。
  もちろん、予約が申し込まれた時点で、登録されたメールアドレス宛にお知らせメールも送信されます。
  まずは、利用日を再度確認し、支払いを承認しましょう。
  <strong>支払いを承認した時点で、予約申込みの受付は完了となります。</strong>
<br/><a href="{{url('help/shareuser/check-booking')}}" class="link-to"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> 詳しくはこちら</a>
               </div>
  </div>
</div>
<div class="hiwp-option">
  <div class="col-left-120"><div class="hiwp-option-icon hiwp-option-icon-2"><i class="fa fa-ban" aria-hidden="true"></i></div></div>
  <div class="col-right-disc">
  <div class="hiwp-option-header h4">予約のキャンセル・返金</div>
  <div class="hiwp-option-copy">
<a href="#">キャンセルポリシー</a>に基づき、キャンセル期間内での返金、キャンセルができます。<br/>
予約が申し込まれた時点では、支払いは仮支払いとなり、  <strong>実際の決済処理はされていない状態</strong>となっています。
もしも、なんらかの事情で予約日にオフィススペースが提供できない場合は、支払いの受取拒否を行えば、  <strong>支払いは行われず、キャンセルが可能</strong>です。
<br/><a href="{{url('help/shareuser/cancel-booking')}}" class="link-to"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> 詳しくはこちら</a>
</div>
  </div>
</div>
<div class="hiwp-option">
  <div class="col-left-120"><div class="hiwp-option-icon hiwp-option-icon-3"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></div></div>
  <div class="col-right-disc">
  <div class="hiwp-option-header h4">オフィススペースの変更・更新</div>
  <div class="hiwp-option-copy">
オフィススペースの変更・更新は追加後も編集が可能です。
写真をや文言を追加・更新をすることで、常に最新のオフィススペースの状況が提供できます。
<br/><a href="{{url('help/shareuser/editspace')}}" class="link-to"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> 詳しくはこちら</a>
               </div>
  </div>
</div>
<div class="hiwp-option">
  <div class="col-left-120"><div class="hiwp-option-icon hiwp-option-icon-4"><i class="fa fa-calendar-plus-o" aria-hidden="true"></i></div></div>
  <div class="col-right-disc">
  <div class="hiwp-option-header h4">スケジュールの追加・削除</div>
  <div class="hiwp-option-copy">
リアルタイムでのスケジュール設定は予約がまだ受け付けられていない日程、時間に限り、追加・削除ができます。
いつでもあなたの提供できる日程や時間を管理できます。<br/><a href="{{url('help/shareuser/add-schedule')}}" class="link-to"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> 詳しくはこちら</a>
                 
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
