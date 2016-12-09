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
<h3 class="story-title text-center">スペース検索・ご利用方法</h3>
<div class="hiwn-hiwp-copy">あなたの探しているオフィスをOffispoでスマート検索。</div>
</div>
<div class="hiw-list-block">
<div class="hiwp-option">
  <div class="col-left-120"><div class="hiwp-option-icon hiwp-option-icon-1"><i class="fa fa-search" aria-hidden="true"></i></div></div>
  <div class="col-right-disc">
  <div class="hiwp-option-header h4">スマート検索</div>
  <div class="hiwp-option-copy">
  3時間から1年間まで、あなたの探しているオフィススペースの規模や、利用人数、設備など細かいあなたのニーズに合わせて検索が可能。<br/>
  あなたにとってベストのオフィススペースがOffispoの検索機能で見つかります。
<br/><a href="{{url('RentUser/Dashboard/SearchSpaces')}}" class="link-to"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> 今すぐ検索</a>
               </div>
  </div>
</div>
<div class="hiwp-option">
  <div class="col-left-120"><div class="hiwp-option-icon hiwp-option-icon-2"><i class="fa fa-calendar-check-o" aria-hidden="true"></i></div></div>
  <div class="col-right-disc">
  <div class="hiwp-option-header h4">利用したい時にすぐに探せる</div>
  <div class="hiwp-option-copy">
 Offispoではリアルタイムでの予約可能時間が検索可能。
 会議室を明日に利用したい、オフィスが決まるまでの1週間だけワークスペースが欲しい、来月から月ごとでオフィススペースを借りたいなど、急なオフィス探しにも困りません。
<br/><a href="{{url('help/guest/searchspace')}}" class="link-to"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> 検索方法はこちら</a>
               </div>
  </div>
</div>
<div class="hiwp-option">
  <div class="col-left-120"><div class="hiwp-option-icon hiwp-option-icon-3"><i class="fa fa-star" aria-hidden="true"></i></div></div>
  <div class="col-right-disc">
  <div class="hiwp-option-header h4">気になったオフィススペースはお気に入り保存</div>
  <div class="hiwp-option-copy">
 Offispoでは気になるオフィスをお気に入り機能で保存可能。
 ゆっくり見る時間がない時や、気になるオフィススペースがたくさんある場合は、お気に入り追加をして、あとでゆっくり見ることができます。
 <br/><a href="{{url('help/rentuser/favourite')}}" class="link-to"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> 操作方法はこちら</a>              
               </div>
  </div>
</div>
<div class="hiwp-option">
  <div class="col-left-120"><div class="hiwp-option-icon hiwp-option-icon-4"><i class="fa fa-floppy-o" aria-hidden="true"></i></div></div>
  <div class="col-right-disc">
  <div class="hiwp-option-header h4">検索条件が保存可能</div>
  <div class="hiwp-option-copy">
 Offispoではあなたの希望するオフィスの条件が保存可能。
 また一から検索をしなおす必要もなく、少しの時間ですぐにあなたの希望オフィスが閲覧可能です。
 <br/><a href="{{url('help/rentuser/edit-myspace')}}" class="link-to"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> 操作方法はこちら</a>          
               </div>
  </div>
</div>
<div class="hiwp-option">
  <div class="col-left-120"><div class="hiwp-option-icon hiwp-option-icon-4"><i class="fa fa-laptop" aria-hidden="true"></i></div></div>
  <div class="col-right-disc">
  <div class="hiwp-option-header h4">簡単予約</div>
  <div class="hiwp-option-copy">
オフィススペースを利用できる準備はできましたか？<br/>
Offispoでの予約は利用したい日にちや時間を選択し、"予約する"をクリック。
その後は、予約の詳細、料金を確認し、あなたの登録済みの決済方法にて決済するだけ。<br/>
<a href="{{url('/cancel-policy/')}}" class="link-to">キャンセルポリシー</a>に基づき、キャンセル可能な期間内なら、キャンセルもワンクリックで完了できます。
<br/><a href="{{url('help/rentuser/booking')}}" class="link-to"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> 操作方法はこちら</a> 
                 
               </div>
  </div>
</div>
</div>
</div><!--/container-->
</section>
<section id="hiw-feature" class="gray">
<div class="container">
<div class="layout-story-header ng-scope">
<h3 class="story-title text-center">Offispoの利用方法</h3>
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

</div><!--/viewport-->
</body>
</html>
