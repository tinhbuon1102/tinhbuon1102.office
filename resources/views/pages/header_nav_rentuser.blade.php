<!-- Pushy Menu -->
        <nav class="pushy pushy-left">
        <ul>
@include('user2.dashboard.left_nav_links')
</ul>
        </nav>
        <!-- Site Overlay -->
        <div class="site-overlay"></div>
<div id="containers">
<div class="header_wrapper primary-navigation-section ru_header">
	<header id="header">
		<div class="header_container dark">
			<div class="logo_container">
				<a class="logo" href="{{url('/')}}">hOur Office</a>
			</div>
			<!--nav-->
            <div class="nvOpn menu-btn"><span></span> <span></span> <span></span></div>

			<nav class="primary-navigation">
				<ul>
					<li class="menu-find-space">
						<a href="{{url('RentUser/Dashboard/SearchSpaces')}}">スペースを探す</a>
					</li>
					<li class="menu-booked-list">
						<a href="{{url('RentUser/Dashboard/Reservation')}}">予約リスト</a>
					</li>
					<li class="menu-myprofile">
						<a href="{{url('RentUser/Dashboard/MyPage')}}">マイページ</a>
					</li>
					<li class="menu-help">
						<a href="{{url('help/rentuser')}}">ヘルプ</a>
					</li>
                    
				</ul>
			</nav>
			<!--/nav-->
			<div class="header-notifications-wrapper">
				<ul class="header-notifications">
					<li class="popover-trigger header-notification-message">
					<?php if (Auth::guard('user2')->user()) {?>
					<?php $cnt=readCountNoti(Auth::guard('user2')->user()->HashCode,'User2ID'); ?>
						@if($cnt>0)<span id="notification_count">{{$cnt}}</span>@endif
					<?php }?>
												<a href="#" id="realtime-icon" class="header-notification">
							<span class="icon">
								<i class="fa fa-comment" aria-hidden="true"></i>
							</span>
						</a>
						<div id="message-notification" class="popover bottom message-notifications-popover">
							<div class="arrow"></div>
							<!--popover-content-->
							<div id="message-notifications-popover-content" class="popover-content">
								<header class="popover-head">
									<span class="popover-head-title">メッセージ</span>
								</header>
								<div class="slimScrollDiv">
									<ol class="notification-popover-thread chat-notification">
										<? 
									$chatNotifications = Cache::get('chatNotification-'.Auth::guard('user2')->user()->HashCode);
									if(Auth::guard('user2')->user() && Auth::guard('user2')->check() && count($chatNotifications)) 
									{
										foreach(Cache::get('chatNotification-'.Auth::guard('user2')->user()->HashCode) as $ch) 
										{
											echo getUser2ChatNotification($ch); 
										}
									}
									else {
										echo '<li class="item-nomore first"><p class="description no-item"> メッセージはまだありません。</p></li>';
									}

								?>
									</ol>
								</div>
								<!--/slimScrollDiv-->
							</div>
						</div>
						<!--popover-content-->
					</li>
					<li class="popover-trigger header-notification-update">
						<span id="notification_count" style="display: none">0</span>
						<a href="#" id="realtime-icon" class="header-notification">
							<span class="icon">
								<i class="fa fa-bell" aria-hidden="true"></i>
							</span>
						</a>
						<div id="realtime-notification" class="popover bottom user-notifications-popover">
							<div class="arrow"></div>
							<!--popover-content-->
							<div id="user-notifications-popover-content" class="popover-content">
								<header class="popover-head">
									<span class="popover-head-title">あなたへのお知らせ</span>
								</header>
								<div class="slimScrollDiv">
									<ul class="notification-popover-thread ">
									</ul>
								</div>
								<!--/slimScrollDiv-->
							</div>
						</div>
						<!--/popover-content-->
					</li>
				</ul>
				<button id="user-trigger" class="header-user-trigger user-trigger header-user" data-section="DaVinciNavigation">
					<figure id="profile-figure" class="ImageThumbnail ImageThumbnail--small ImageThumbnail--clickable">
						<img class="ImageThumbnail-image" src="{{getUser2Photo(Auth::guard('user2')->user()->HashCode)}}" alt="Profile Picture">
					</figure>
				</button>
			</div>
			<!--/notifications-wrapper-->
            <button style="z-index: 99999;" class="navbar-toggle pull-right mmnv user-trigger" data-section="DaVinciNavigation">
				<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
</button>
		</div>
	</header>
</div>
<!--/header_wrapper-->
<div class="second-nav">
	<div class="header_container">
		<!--nav-->
		<nav>
			<ul>
				<li class="menu-dashboard">
					<a href="{{url('RentUser/Dashboard')}}">ダッシュボード</a>
				</li>
				<li class="menu-mypage">
					<a href="{{url('RentUser/Dashboard/MyPage')}}">マイページ</a>
				</li>
				<li class="menu-message">
                <?php $user = Auth::guard('user2')->user(); 
				if (IsAdminApprovedUser($user)) { ?>
					<a href="{{url('RentUser/Dashboard/Message')}}">メッセージ</a>
                <?php } else {  ?>
                <a href="#" class="disable">メッセージ</a>
				<?php } ?>
				</li>
				<li class="menu-signup">
					<a href="{{url('RentUser/Dashboard/Review')}}">レビュー</a>
				</li>
                <li class="lang_nav"><div class="lang">
        <select class="switcher">
<option value="ja">Japanese</option>
<option value="en" @if(\Session::get('locale')=='en') selected @endif>English</option>
</select>
        </div></li>
			</ul>
		</nav>
		<!--/nav-->
	</div>
</div>
<!--/second nav-->
<!--user sidebar-->
<div class="user-sidebar-container" fl-analytics-section="DaVinciNavigation">
	<div class="sidebar user-sidebar">
		<div class="user-sidebar-info">
			<figure class="ImageThumbnail ImageThumbnail--xlarge">

				<a class="ImageThumbnail-link" href="{{url('RentUser/Dashboard/MyProfile')}}" title="View Profile">
					<img class="ImageThumbnail-image" src="{{getUser2Photo(Auth::guard('user2')->user()->HashCode)}}" alt="Profile Picture">
				</a>

			</figure>
			<div class="user-sidebar-name">
				<a href="/me/" class="user-sidebar-name">{{Auth::guard('user2')->user()->UserName}}</a>
			</div>

			<div class="user-sidebar-status">
				<p class="user-sidebar-status">レント会員</p>
			</div>


		</div>
		<nav class="sidebar-nav">
			<a class="sidebar-link" fl-analytics="Profile" href="{{url('RentUser/Dashboard/MyProfile')}}">
				<span class="Icon Icon--light">
					<i class="fa fa-user" aria-hidden="true"></i>
				</span>
				プロフィール
			</a>
			<a class="sidebar-link" fl-analytics="Settings" href="{{url('RentUser/Dashboard/BasicInfo/Edit')}}">
				<span class="Icon Icon--light">
					<i class="fa fa-cogs" aria-hidden="true"></i>
				</span>
				{{ trans('navigation.setting') }}
			</a>
			<a class="sidebar-link" fl-analytics="Help" href="{{url('help')}}">
				<span class="Icon Icon--light">
					<i class="fa fa-question-circle" aria-hidden="true"></i>
				</span>
				ヘルプ
			</a>
			
			<a class="sidebar-link" fl-analytics="Logout"  href="/User2/Logout">
				<span class="Icon Icon--light">
					<i class="fa fa-sign-out" aria-hidden="true"></i>
				</span>
				ログアウト
			</a>
		</nav>
		<span class="sidebar-close-alt">
			<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 12 12" enable-background="new 0 0 12 12" xml:space="preserve" class="flicon-close">
<g>
				<line fill="none" x1="11.75" y1="0.25" x2="0.25" y2="11.75"></line>
				<line fill="none" x1="11.75" y1="11.75" x2="0.25" y2="0.25"></line></g>
</svg>
		</span>
	</div>
</div>
<!--/user sidebar-->

@if(getAuth())
<script>
	itemActionChannel.bind( "App\\Events\\NewChatNotificaion", function( data ) {
			jQuery( ".chat-notification" ).prepend('<li class="notification-popover-item"><a href="/RentUser/Dashboard/Message/'+data.uid+'"><figure id="profile-figure" class="profile-img"><img src="'+ data.photo +'"></figure><div class="notification-item-content"><h4 class="notification-item-title">'+ data.name + '<span class="online-status online" data-size="medium"></span></h4><p class="notification-item-text">'+ data.message +'</p><div class="notification-item-status"><time class="timestamp">'+ data.created +'</time></div></div></a></li>');
				PlaySound();
			} );
		jQuery(function() {
		
		jQuery(".switcher").change(function() {
				window.location.href = "/lang/" + jQuery(this).val();
});

	});
</script >
@endif
@if (Auth::guard('user2')->user()->IsAdminApproved == 'Yes')
	@include('chat.instant-chat')
@endif
