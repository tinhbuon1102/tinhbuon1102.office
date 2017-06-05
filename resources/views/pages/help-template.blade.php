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
				<h1 class="hero-article-title">
					<strong>ヘルプ</strong>
				</h1>
			</div>
			<div class="parallax-container"></div>
		</div>
		<div class="home-top">
			<?php 
			$currentUrl = Request::url();
			$currentUrl = str_replace(url('/') . '/', '', $currentUrl);
			$aUrl = explode('/', $currentUrl);
			switch (count($aUrl))
			{
				case 1:
					
					break;
				case 2:
					$categoryName = $aUrl[1];
					$categoryFileName = base_path() . '/resources/views/pages/'. $categoryName .'/' . ($aUrl[0] . '-' . $aUrl[1]) . '.blade.php';
					$CategoryTitle = getH1OfFile($categoryFileName);
					echo Breadcrumbs::render('category', ['title' => $CategoryTitle, 'url' => Request::url()]);
					break;
					
					break;
				case 3:
					$categoryName = $aUrl[1];
					$categoryFileName = base_path() . '/resources/views/pages/'. $categoryName .'/' . ($aUrl[0] . '-' . $aUrl[1]) . '.blade.php';
					$CategoryTitle = getH1OfFile($categoryFileName);
					
					$fileName = base_path() . '/resources/views/pages/'. $categoryName .'/' . str_replace('/', '-', $currentUrl) . '.blade.php';
					$pageTitle = getH1OfFile($fileName);
					echo Breadcrumbs::render('page', ['category' => ['title' => $CategoryTitle, 'url' => getNestedParentUrl()], 'title' => $pageTitle, 'url' => Request::url()]);
					break;
			}
			
			?>
			
			<section id="howitwork" class="white">
				<div class="container">
					<div class="row flex-wrapper">
						<div class="col-md-3 left-menu">
							<div class="scroll-leftbar">@if(Request::is('help/shareuser') || Request::is('help/shareuser/*')) @include('pages.shareuser.help-shareuser-leftbar') @elseif(Request::is('help/rentuser') || Request::is('help/rentuser/*')) @include('pages.rentuser.help-rentuser-leftbar') @elseif(Request::is('help/guest') || Request::is('help/guest/*')) @include('pages.guest.help-guest-leftbar') @endif</div>
						</div>
						<div class="col-md-9 help-content">
							<!--main content here-->
<?php echo isset($subView) ? $subView : ''?>
</div>
					</div>
					<!--/row-->
				</div>
				<!--/container-->
			</section>
		</div>
		<!--/hometop-->
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
	<script>
  jQuery('a.cboxElement').colorbox({
    inline:true,
    maxWidth:"642px",
	maxHeight:"90%",
    opacity: 0.7,
	onComplete : function() { 
$(this).colorbox.resize(); 
}  
  });
    $(function(){
        $("h5#acMenu").on("click", function() {
            $(this).next().slideToggle();
			$(this).toggleClass("active"); 
        });
    });
	/*current open*/
	$(function(){
	$('ul.navtree-list li a').each(function(){
		var $href = $(this).attr('href');
		if(location.href.match($href)) {
		$(this).addClass('active');
		} else {
		$(this).removeClass('active');
		}
	});
});
	/*moving sidebar*/
	$(function(){
		var wd = $(window);
		var windowW = wd.width();
		var windowH = wd.height();
		var minBreak = 480;
		var footer = $("footer");//フッターでストップさせる
		var header = $(".header_wrapper");
		var maincon = $(".help-content");
		var sidebar = $(".scroll-leftbar");
		var sideH = sidebar.height();
		var sidebarTop = sidebar.offset().top;
		var headerH = header.height();
		var conH = maincon.height();
		console.log('ヘッダー：' + headerH + 'px');
		console.log('サイドバー：' + sideH + 'px');
		console.log('メインコン：' + conH + 'px');
	$(window).on('load resize', function() {
		if (windowW > minBreak && sideH < conH) {
			$(".left-menu").css('height', conH + 'px');
			//サイドバーがウィンドウよりいくらはみ出してるか
			var sideOver = windowH - sideH;
			//固定を開始する位置 = サイドバーの座標＋はみ出す距離
			var starPoint = sidebar.offset().top + (-sideOver);
			//固定を解除する位置 = メインコンテンツの終点
			var breakPoint = sidebar.offset().top + conH;
			wd.scroll(function() { //スクロール中の処理
                   
                  if(windowH < sideH){ //サイドメニューが画面より大きい場合
                        if(starPoint < wd.scrollTop() && wd.scrollTop() + wd.height() < breakPoint){ //固定範囲内
                              sidebar.css({"position": "fixed", "bottom": "20px"}); 
       
                        }else if(wd.scrollTop() + windowH >= breakPoint){ //固定解除位置を超えた時
                              sidebar.css({"position": "absolute", "bottom": "0"});
       
                        } else { //その他、上に戻った時
                              sidebar.css("position", "static");
       
                        }
       
                  }else{ //サイドメニューが画面より小さい場合
                   
                        var sideBtm = wd.scrollTop() + sideH; //サイドメニューの終点
                         
                        if(maincon.offset().top < wd.scrollTop() && sideBtm < breakPoint){ //固定範囲内
                              sidebar.css({"position": "fixed", "top": (headerH + 20) + "px"});
                               
                        }else if(sideBtm >= breakPoint){ //固定解除位置を超えた時
                         
                              //サイドバー固定場所（bottom指定すると不具合が出るのでtopからの固定位置を算出する）
                              var fixedSide = conH - sideH;
                               
                              sidebar.css({"position": "absolute", "top": fixedSide});
                               
                        } else {
                              sidebar.css("position", "static");
                        }
                  }
                         
             
            });
			
		} else {
			$(".left-menu").css('height', 'auto');
		}
		
	});
});
</script>
</body>
</html>
