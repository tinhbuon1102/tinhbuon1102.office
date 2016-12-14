
<?php
// include( $_SERVER['DOCUMENT_ROOT'] . '/design/header_beforelogin.php');
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
				<h1 class="hero-article-title">
					<strong>会社概要</strong>
				</h1>
			</div>
			<div class="parallax-container"></div>
		</div>
		<div class="home-top">
			<section id="howitwork" class="white">
				<div class="container">
					
					<div class="layout-story-header ng-scope">
						<h3 class="story-title text-center">会社概要</h3>
					</div>
                    <div class="mx_620">
                    <table class="block_a overview_table">
                    <tbody>
                    <tr>
                    <th class="left_title"><span class="space">社名(商号)</span></th>
                    <td class="right_detail"><span class="space big">株式会社アベンチャーズ</span></td>
                    </tr>
                    <tr>
                    <th class="left_title"><span class="space">設立</span></th>
                    <td class="right_detail"><span class="space">2014年5月1日</span></td>
                    </tr>
                    <tr>
                    <th class="left_title"><span class="space">資本金</span></th>
                    <td class="right_detail"><span class="space">3,000,000円</span></td>
                    </tr>
                    <tr>
                    <th class="left_title"><span class="space">代表取締役</span></th>
                    <td class="right_detail"><span class="space">高 将司</span></td>
                    </tr>
                    <tr>
                    <th class="left_title"><span class="space">事業内容</span></th>
                    <td class="right_detail"><span class="space">不動産事業</span></td>
                    </tr>
                    <tr>
                    <th class="left_title"><span class="space">所在地</span></th>
                    <td class="right_detail"><span class="space">〒106-0032<br/>東京都港区六本木5-9-20六本木イグノポール5階</span></td>
                    </tr>
                    <tr>
                    <th class="left_title"><span class="space">電話番号</span></th>
                    <td class="right_detail"><span class="space">03-3470-2770</span></td>
                    </tr>
                    </tbody>
                    </table>
                    </div>
					
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
</body>
</html>
