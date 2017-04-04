<?php 
$user = Auth::guard('user1')->user();
$profilePercent = calculateUserProfilePercent($user, 1);
?>
<div class="newsfeed-left-content">
	<div class="user-details-wrap">
		<div class="user-details feed-box mypage-leftbox">
			<div class="left-pad-box">
				<div class="pro-pic-box">
					<h4 class="user-details-title">
						あなたのアカウント
						<br>
						<em>
							<a class="user-details-username" href="{{url('ShareUser/Dashboard/HostSetting')}}">{{getUserName($user)}}</a>
						</em>
						<!--<span class="publish-status unpublish">未公開</span>-->
						<!--if published<span class="publish-status published">公開中</span>-->
					</h4>
				</div>
				<div class="welcome-note">
					<div class="user-profile-account-progress">
						<h5>プロフィール完成度<span class="align-right">{{$profilePercent}}%</span></h5>
						<div class="progress progress-info user-profile-account-progress-bar">
							<div class="bar" style="width: {{$profilePercent}}%;">
								
								<!--<span class="access <?php //echo $profilePercent < 100 ? 'not-completed' : ''?>">complete</span>-->
							</div>
						</div>
						<?php if ($profilePercent < 60) {?>
						<p class="notify-msg">スペースを掲載まで残り <?php echo 60 - $profilePercent?>%</p>
						<?php }?>
					</div>
				</div>
			</div>
			<nav id="shareuser-setting-nav">
				<ul>@include('user1.dashboard.left_nav_link')
				</ul>
			</nav>
		</div>
		<!--/feed-nbox-->
	</div>
	<!--/user-details-wrap-->
</div>
