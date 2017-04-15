
<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header_beforelogin.php');
 ?>
 @include('pages.header_beforelogin')
<!--/head-->
<body class="home">
<div class="viewport">
<!--<div class="header_wrapper">
<header id="header">
<div class="header_container">
<div class="logo_container"><a class="logo" href="{{url('/')}}">hOur Office</a></div>
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
<!--</div>
</header>
</div>-->
<section id="slider-fullwidth" class="slider">
<div class="hero-animation">
<div id="slider-with-blocks-1" class="royalSlider rsMinW">
  <div class="rsContent slide1">
    <div class="bContainer">
      <h1 class="rsABlock txtCent blockHeadline">FIND YOUR OFFICE SPACE</h1>
      <span class="rsABlock txtCent" data-move-effect="none">さぁ、オフィススペースを探そう</span>
    </div>
  </div>
  <div class="rsContent slide2">
    <div class="bContainer">
    <h1 class="rsABlock txtCent blockHeadline">FIND YOUR OFFICE SPACE</h1>
      <span class="rsABlock txtCent" data-move-effect="none">さぁ、オフィススペースを探そう</span>
     <!-- <strong class="rsABlock txtCent blockSubHeadline" data-move-effect="none">Transition Types</strong>
      <span class="rsABlock txtCent" data-move-effect="top">from top  ↓</span>
      <span class="rsABlock txtCent" data-move-effect="bottom">from bottom ↑</span>
      <span class="rsABlock txtCent" data-move-effect="left">from left →</span>
      <span class="rsABlock txtCent" data-move-effect="right">from right ←</span>
      <span class="rsABlock txtCent" data-move-effect="none">just fade</span>-->
    </div>
  </div>
  <div class="rsContent slide3">
    <div class="bContainer">
    <h1 class="rsABlock txtCent blockHeadline">FIND YOUR OFFICE SPACE</h1>
      <span class="rsABlock txtCent" data-move-effect="none">さぁ、オフィススペースを探そう</span>
     <!-- <strong class="rsABlock txtCent blockSubHeadline" data-move-effect="none" data-delay="0">Customizable Animation</strong>
      <span class="rsABlock txtCent" data-move-effect="left" data-delay="1000" data-move-offset="500" data-easing="easeOutBack" data-fade-effect="none">easing</span>
      <span class="rsABlock txtCent" data-move-effect="left" data-delay="1500" data-move-offset="500" data-fade-effect="none">delay</span>
      <span class="rsABlock txtCent" data-move-effect="left" data-delay="2000" data-move-offset="500" data-speed="1000" data-fade-effect="none">speed</span>
      <span class="rsABlock txtCent" data-move-effect="left" data-delay="2500" data-move-offset="50" data-fade-effect="true">move offset</span>-->
    </div>
  </div>
</div>
</div><!--/hero-animation-->
</section>
<div class="home-top clearfix">
<section id="intro" class="white">
<div class="container">
<div class="col_half col_left">
<h2 class="sec-title left-align"><span class="gray">What's</span> <span class="transcase">hOur Office</span>?</h2>
<p class="sec-subtitle left-align">アワーオフィスとは？</p>
<p class="disc">
期間にとらわれず低コストでオフィスを利用したい。<br/>
そんなスタートアップオフィスをお探しの企業やワークスペースをお探しの個人事業の方へ。<br/>
アワーオフィスはあなたにぴったりのワークスペース探しをお手伝い致します。
フリーデスクから会議室、プライベートオフィスまで、様々な種類のオフィスが見つかります。
もちろん、敷金、礼金、年単位での契約期間も無く、ワンクリックで、すぐにあなたのワークスペースが見つかります。
</p>
<h4>あなたはどのオフィスで働く？</h4>
<ul class="intro-point">
<li>あなたの希望条件に合わせてオフィススペース情報をGET</li>
<li>1日~1月単位で自由な期間のオフィススペースが利用可能</li>
<li>スペース提供側の職種や事業内容も見れるので、あなたの働きたいオフィスで働ける</li>
</ul>
</div>
<div class="col_half col_right">
<div class="intro-anime"><img src="images/intro-anime.gif" /></div>
</div>
</div><!--/container-->
</section>
<section id="find-list" class="gray">
<div class="container">
<h2 class="sec-title">Find <span class="thin gray">your</span> work space</h2>
<p class="sec-subtitle">ワークスペースを探そう</p>
<!--show here latest space list-->
<?php if (count($spaces)) {?>
<div class="space-list clearfix mgt-25">
<div class="row">
	<?php foreach ($spaces as $space) { ?>
	<div class="col-md-4 space-item">
    <div class="list-item">
		<div class="sp01" style="background-image: url('<?php echo getSpacePhoto($space)?>')">
			<a href="{{getSpaceUrl($space->HashID)}}" class="link_space">
            <span class="area">
						{!! $space->District !!}
						<!--district name-->
					</span>
				<span class="space-label befhov">
                <div class="clearfix">
					<span class="type" style="display: block;">{{getSpaceTitle($space, 24)}}</span>
                    <div class="label-left" style="width: 30%;"> <span class="capacity" style="padding-top: 3px;">~{!! $space->Capacity !!}名</span> </div>
					<div class="label-right" style="width: 70%;"><span class="price">
						<?php echo getPrice($space, true, '', false, true)?>
					</span></div>
                    </div>
				</span>
							
				
				<span class="space-label onhov">
					<div class="clearfix">
					<h3 class="sp-title">{{getSpaceTitle($space, 24)}}</h3>
					<span class="price">
								<?php echo getPrice($space, true, '', false, true)?>
							</span>
						<span class="type" style="display: block;">{{ str_limit($space->Details, 320, '...') }}</span>
					</div>
				</span>
				
				
			</a>
		</div>
        </div>
	</div>
	<?php }?>
</div>
</div>
<?php }?>

<!--/show here latest space list-->
<div class="center"><a href="{{url('RentUser/Dashboard/SearchSpaces')}}" class="button yellow-button">もっと見る</a></div>
</div><!--/container-->
</section>
<section id="three-point" class="white">
<div class="title-head"><h2 class="sec-title"><span class="transcase">hOur Office</span> offers</h2>
<p class="sec-subtitle">アワーオフィスのサービスについて</p></div>
<div class="container center">
<div class="offer-grid grd3-flex-row grd3-flex-lg">
<div class="grd3-flex-cell"><div class="icon_wrapper"><span class="icon-offispo-icon-07"></span></div><h4>オンライン予約・決済</h4><p>オフィス、ワークスペースをサイトにて予約・決済して、いつでも利用が可能です。</p></div>
<div class="grd3-flex-cell"><div class="icon_wrapper"><span class="icon-add-secureuser"></span></div><h4>厳選されたユーザー</h4><p>全てのユーザーは利用者、提供者としての審査を受けた人です。安全性の高いサービスが提供、利用可能です。</p></div>
<div class="grd3-flex-cell"><div class="icon_wrapper"><span class="icon-icon-network"></span></div><h4>業種に特化したネットワーク</h4><p>業界や事業内容が記載されているので
<br>気になる業種のオフィスで働けます。</p></div>
</div>
</div>
</section>
<section id="howitworks" class="blk-txt">
<div class="container center">
<h2 class="sec-title">How it works?</h2>
<p class="sec-subtitle">アワーオフィスの使い方</p>
<div class="intro-txt">
アワーオフィスはあなたにぴったりのワークスペース探しをお手伝い致します。<br/>
今すぐアワーオフィスでオフィススペースを見つけましょう。
</div>
<div class="center"><a href="{{url('how-it-works')}}" class="button blk-border-button">アワーオフィスについて学ぶ</a></div>
</div><!--/container-->
</section>
<section id="haveshare" class="gray">
<div class="container">
<div class="share-ad-content">
<h2 class="sec-title ja left-align mgb-30">シェアスペースをお持ちですか？</h2>
<p class="sec-subtitle left-align">余っているスペースを、臨時収入と新しい出会いに変えましょう<br/><span class="highlight">今ならオープン記念キャンペーンにて代行登録無料！</span></p>
<a class="button yellow-button btn-size-lg" href="{{url('list-service')}}">シェアスペース提供をご検討の方はコチラ</a>
</div>
</div><!--/container-->
</section>
</div><!--/hometop-->
<!--footer-->
<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/common_footer.php'); ?>
		@include('pages.common_footer')

<!--/footer-->

</div><!--/viewport-->
<script id="addJS">jQuery(document).ready(function($) {
	
	/* $(".nvOpn").click( function(){
		$("body").toggleClass("navon");
	});
	
	$(".navonin").click( function(){
		$(".nvOpn").click();
	}); */
	
  jQuery.rsCSS3Easing.easeOutBack = 'cubic-bezier(0.175, 0.885, 0.320, 1.275)';
  $('#slider-with-blocks-1').royalSlider({
    arrowsNav: true,
    arrowsNavAutoHide: false,
    fadeinLoadedSlide: false,
    controlNavigationSpacing: 0,
    controlNavigation: 'bullets',
    imageScaleMode: 'none',
    imageAlignCenter:false,
    blockLoop: true,
    loop: true,
    numImagesToPreload: 6,
    transitionType: 'fade',
    keyboardNavEnabled: true,
    block: {
      delay: 400
    }
  });
});
</script>
	
</body>
</html>
