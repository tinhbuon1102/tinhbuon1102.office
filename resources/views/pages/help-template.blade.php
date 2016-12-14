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
						<div class="col-md-8 help-content">
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
    var target = $(".scroll-leftbar");//ここに追尾したい要素名を記載
    var footer = $("footer")//フッターでストップさせる
    var targetHeight = target.outerHeight(true);
    var targetTop = target.offset().top;
 
    $(window).scroll(function(){
        var scrollTop = $(this).scrollTop();
        if(scrollTop > targetTop){
            // 動的にコンテンツが追加されてもいいように、常に計算する
            var footerTop = footer.offset().top;
             
            if(scrollTop + targetHeight > footerTop){
                customTopPosition = footerTop - (scrollTop + targetHeight)
                target.css({position: "fixed", top:  customTopPosition + "px"});
            }else{
                target.css({position: "fixed", top: "75px", width: "20%"});
            }
        }else{
            target.css({position: "static", top: "auto", width: "100%"});
        }
    });
});
</script>
</body>
</html>
