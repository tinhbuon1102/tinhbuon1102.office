
<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header.php'); ?>
@include('pages.header_beforelogin')
<!--/head-->
<body class="mypage shareuser">
	<div class="viewport">
		<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header_nav_shareuser.php'); ?>
		@include('pages.header_nav_shareuser')
		<div class="main-container">
			<div id="main" class="container fixed-container">
				<div id="left-box">
					<div class="newsfeed-left-content">
						<div class="user-details-wrap">
							<div class="user-details feed-box mypage-leftbox">
								<div class="left-pad-box">
									<figure class="ImageThumbnail ImageThumbnail--xlarge PageDashboard-avatar company-logo-thumbnail online">
										<a class="ImageThumbnail-link" href="/users/changeuserinfo.php" title="View Profile">
											<img class="ImageThumbnail-image" src="images/unknown-logo.png" alt="Profile Picture">
										</a>
									</figure>
									<div class="welcome-note">
										<h4 class="user-details-title">
											あなたのアカウント
											<br>
											<em>
												<a class="user-details-username" href="#">xxx company</a>
											</em>
											<span class="publish-status unpublish">未公開</span>
											<!--if published<span class="publish-status published">公開</span>-->
										</h4>
										
										
										<div class="user-profile-account-progress">
											<h5>Profile Strength</h5>
											<div class="progress progress-info user-profile-account-progress-bar">
												<div class="bar" style="width: 20%;">
													20%
													<span class="access">complete</span>
												</div>
											</div>
											<p class="notify-msg">List your available spaces to get to 60%</p>
											
										</div>
									</div>
								</div>
								<nav id="shareuser-setting-nav">
									<ul>
										<li>
											<a href="#" class="content-navigation">
												<i class="fa fa-user" aria-hidden="true"></i>
												My Page
												<!--マイページ-->
											</a>
										</li>
										<li>
											<a href="#" class="content-navigation">
												<i class="fa fa-building" aria-hidden="true"></i>
												Space Profile
												<!--シェアスペース-->
											</a>
										</li>
										<li>
											<a href="#" class="content-navigation">
												<i class="fa fa-calendar-check-o" aria-hidden="true"></i>
												Reservation
												<!--予約-->
											</a>
										</li>
                                        <li>
											<a href="#" class="content-navigation selected">
                                            <i class="fa fa-commenting" aria-hidden="true"></i>
												Message
												<!--メッセージ-->
                                                
											</a>
										</li>
										<li>
											<a href="#" class="content-navigation">
                                            <i class="fa fa-paper-plane-o" aria-hidden="true"></i>
												Offer list
												<!--オファーーリスト-->
                                                
											</a>
										</li>
                                        <li>
											<a href="#" class="content-navigation">
												<i class="fa fa-star" aria-hidden="true"></i>
												Favourite Count
												<!--お気に入り数-->
                                                <span class="star-counts">21</span>
											</a>
										</li>
										<li>
											<a href="#" class="content-navigation">
												<i class="fa fa-cogs" aria-hidden="true"></i>
												Setting
												<!--設定-->
											</a>
										</li>
									</ul>
								</nav>
							</div>
							<!--/feed-nbox-->
						</div>
						<!--/user-details-wrap-->

					</div>
					<!--/right-content-->
				</div>
				<!--/leftbox-->
				<div class="right_side" id="samewidth">
				
				
					<section class="feed-event recent-follow feed-box">
						<div class="dashboard-section-heading-container">
							<h3 class="dashboard-section-heading">
								<a href="#">
									Notification for you
									<!--?????????-->
								</a>
							</h3>
						</div>
						<div class="chat-left">
							<div class="head">
								<span>Chat</span>
								<button>New</button>
								<div style="clear: both;"></div> 
							</div><hr>
							
							<ul class="chat-list">
								<li>
									<img src="images/man-avatar.png" class="chat-pic" /><div class="chat-count" >7</div>
									<h2>Faraz Abbas</h2><div class="chat-st"></div>
									<p>This is my msg kindly appreciate it...</p><div class="chat-time">7 min</div>
								</li>
								<li>
									<img src="images/man-avatar.png" class="chat-pic" /><div class="chat-count" >7</div>
									<h2>Faraz Abbas</h2><div class="chat-st active"></div>
									<p>This is my msg kindly appreciate it...</p><div class="chat-time">2 min</div>
								</li>
								<li class="active">
									<img src="images/man-avatar.png" class="chat-pic" /><div class="chat-count" >7</div>
									<h2>Faraz Abbas</h2><div class="chat-st active"></div>
									<p>This is my msg kindly appreciate it...</p><div class="chat-time">12 min</div>
								</li>
								<li>
									<img src="images/man-avatar.png" class="chat-pic" /><div class="chat-count" >7</div>
									<h2>Faraz Abbas</h2><div class="chat-st"></div>
									<p>This is my msg kindly appreciate it...</p><div class="chat-time">12 min</div>
								</li>
								<li>
									<img src="images/man-avatar.png" class="chat-pic" /><div class="chat-count" >7</div>
									<h2>Faraz Abbas</h2><div class="chat-st active"></div>
									<p>This is my msg kindly appreciate it...</p><div class="chat-time">12 min</div>
								</li>
								<li>
									<img src="images/man-avatar.png" class="chat-pic" /><div class="chat-count" >7</div>
									<h2>Faraz Abbas</h2><div class="chat-st"></div>
									<p>This is my msg kindly appreciate it...</p><div class="chat-time">12 min</div>
								</li>
								<li>
									<img src="images/man-avatar.png" class="chat-pic" /><div class="chat-count" >7</div>
									<h2>Faraz Abbas</h2><div class="chat-st active"></div>
									<p>This is my msg kindly appreciate it...</p><div class="chat-time">12 min</div>
								</li>
								<li>
									<img src="images/man-avatar.png" class="chat-pic" /><div class="chat-count" >7</div>
									<h2>Faraz Abbas</h2><div class="chat-st"></div>
									<p>This is my msg kindly appreciate it...</p><div class="chat-time">12 min</div>
								</li>
								<li>
									<img src="images/man-avatar.png" class="chat-pic" /><div class="chat-count" >7</div>
									<h2>Faraz Abbas</h2><div class="chat-st active"></div>
									<p>This is my msg kindly appreciate it...</p><div class="chat-time">12 min</div>
								</li>
							</ul>
						</div>
						<!--/chat left end-->
						
						<div class="chat-right">
							<div class="head">
								<h2>Faraz Abbas</h2>
								<div class="chat-st active"></div>
								
								<div class="chat-icons">
								
								</div>
								<div style="clear: both;"></div> 
							</div><hr>
							
							<ul class="chat-list">
								<li class="me">
									<img src="images/man-avatar.png" class="chat-pic" />
									<div class="txt">This is my msg kindly appreciate it</div>
								</li>
								<li class="you">
									<img src="images/man-avatar.png" class="chat-pic" />
									<div class="txt">This is my msg kindly appreciate it This is my msg kindly appreciate it This is my msg kindly appreciate it</div>
								</li>
								<li class="me">
									<img src="images/man-avatar.png" class="chat-pic" />
									<div class="txt">This is my msg kindly appreciate it</div>
								</li>
								<li class="you">
									<img src="images/man-avatar.png" class="chat-pic" />
									<div class="txt">This is my msg kindly appreciate it This is my msg kindly appreciate it </div>
								</li>
							</ul>
							<div class="chat-send">
								<input type="text" class="chat-box" placeholder="Type your message" />
								<div class="attach"><i class="fa fa-paperclip" aria-hidden="true"></i></div>
								<button class="chat-send-btn"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
							</div>
						</div>
						<!--/chat right end-->
						
						<div style="clear: both;"></div> 
					</section>
					
					
					

				</div>
				<!--/feed-->

			</div>
		</div>
		<!--/main-container-->
		<!--footer-->
		<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/common_footer.php'); ?>
		@include('pages.common_footer')
		<!--/footer-->
	</div>
	<!--/viewport-->
	<script type="javascript/text">
      var $ = document.querySelector.bind(document);
      window.onload = function () {
        /*Ps.initialize($('.slimScrollDiv'));*/
      };
	  
    // var bodyheight = parseInt($(window).height()) - 100 +'px';
    // $("#left-box").height(bodyheight);
	//$('#left-box') .css({'height': (($(window).height()) - 100)+'px'});

$(window).scroll(function() {    
    var scroll = $(window).scrollTop();
     
     //>=, not <=
    if (scroll >= 1) {
        //clearHeader, not clearheader - caps H
        $("#samewidthby").addClass("scroll");
		 $("#left-box").addClass("scroll");
    } else {
		$("#samewidthby").removeClass("scroll");
        $("#left-box").removeClass("scroll");
    }
}); //missing );
</script>
</body>
</html>
