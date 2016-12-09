<?php 
$user = Auth::guard('user2')->user();
$profilePercent = calculateUserProfilePercent($user, 2);
?>
<div class="newsfeed-left-content">
	<div class="user-details-wrap">
		<div class="user-details feed-box mypage-leftbox">
			<div class="left-pad-box">
				<!--<figure class="ImageThumbnail ImageThumbnail--xlarge PageDashboard-avatar online">
					<a class="ImageThumbnail-link" href="/users/changeuserinfo.php" title="View Profile">
						<img class="ImageThumbnail-image" src="{{Auth::guard('user2')->user()->Logo}}" alt="Profile Picture">
					</a>
				</figure>-->
				<div class="welcome-note">
					<h4 class="user-details-title">
						あなたのアカウント
						<br>
						<em>
							<a class="user-details-username" href="#">{{getUserName($user)}}</a>
						</em>
						<!--<span class="publish-status unpublish">未公開</span>-->
						<!--if published<span class="publish-status published">公開中</span>-->
					</h4>
					<!--<a href="{{url('RentUser/Dashboard/MyProfile/Edit')}}" class="btn btn-profile btn-small user-details-edit-btn">Edit</a>--編集する-->
					
					<div class="user-profile-account-progress">
						<h5>プロフィール完成度<span class="align-right">{{$profilePercent}}%</span></h5>
						<div class="progress progress-info user-profile-account-progress-bar">
							<div class="bar" style="width: {{$profilePercent}}%;">
								
								<!--<span class="access <?php //echo $profilePercent < 100 ? 'not-completed' : ''?>">complete</span>-->
							</div>
						</div>
						<!--<p class="caution">
							*Your profile is not published,because of not enough profile.
							<!--※設定項目を満たしていない為、現在未公開です。
						</p>-->
					</div>
				</div>
			</div>
			<nav id="shareuser-setting-nav">
				<ul>
					@include('user2.dashboard.left_nav_links')
				</ul>
			</nav>
		</div>
		<!--/feed-nbox-->
	</div>
	<!--/user-details-wrap-->

</div>
