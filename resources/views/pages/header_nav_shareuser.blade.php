<div class="header_wrapper primary-navigation-section">
	<header id="header">
		<div class="header_container dark">
			<div class="logo_container">
				<a class="logo" href="{{url('/')}}">Offispo</a>
			</div>
			<!--nav-->
            <div class="nvOpn"><span></span> <span></span> <span></span></div>
			<nav class="primary-navigation">
				<ul>
                
                <!--<li class="menu-dash">
						<a href="{{url('ShareUser/Dashboard')}}">ダッシュボード</a>
					</li>-->
                
                
					<li class="menu-find-rentuser">
						<a href="{{url('RentUser/list')}}">利用者を探す</a>
					</li>
                  
					<li class="menu-share-space">
						<a href="{{url('ShareUser/Dashboard/BookList')}}">予約リスト</a>
					</li>
					<li class="menu-current-offer-space">
						<a href="{{url('ShareUser/Dashboard/MySpace/List1')}}">提供中スペース</a>
					</li>
					<li class="menu-help">
						<a href="{{url('help/shareuser')}}">ヘルプ</a>
					</li>
				</ul>
			</nav>
			<!--/nav-->
			<div class="header-notifications-wrapper">
				<ul class="header-notifications">
					<li class="popover-trigger header-notification-message">
					<?php $cnt=readCountNoti(Auth::user()->HashCode,'User1ID'); ?>
						@if($cnt>0)<span id="notification_count">{{$cnt}}</span>@endif
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
									$chatNotifications = Cache::get('chatNotification-'.Auth::user()->HashCode);
									if(Auth::check() && count($chatNotifications)) { 
										foreach(Cache::get('chatNotification-'.Auth::user()->HashCode) as $ch) 
										{
											echo getUser1ChatNotification($ch);
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
									<ul class="notification-popover-thread">
									</ul>
								</div>
								<!--/slimScrollDiv-->
							</div>
						</div>
						<!--/popover-content-->
					</li>
				</ul>
				<button id="user-trigger" class="header-user-trigger header-user user-trigger" data-section="DaVinciNavigation">
					<figure id="profile-figure" class="ImageThumbnail ImageThumbnail--small ImageThumbnail--clickable">
						<img class="ImageThumbnail-image" src="{{getUser1Photo(Auth::guard('user1')->user()->HashCode)}}" alt="Profile Picture">
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
					<a href="{{url('ShareUser/Dashboard')}}">ダッシュボード</a>
				</li>
				<li class="menu-mypage">
					<a href="{{url('ShareUser/Dashboard/MyPage')}}">マイページ</a>
				</li>
				<li class="menu-message">
					<a href="{{url('ShareUser/Dashboard/Message')}}">メッセージ</a>
				</li>
				<li class="menu-signup">
					<a href="{{url('ShareUser/Dashboard/Review')}}">レビュー</a>
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

				<a class="ImageThumbnail-link" href="/me/" title="View Profile">
					<img class="ImageThumbnail-image" src="{{getUser1Photo(Auth::guard('user1')->user()->HashCode)}}" alt="Profile Picture">
				</a>

			</figure>
			<div class="user-sidebar-name">
				<a href="/ShareUser/HostProfile/View/<?php echo Auth::user()->HashCode?>" class="user-sidebar-name">{{Auth::guard('user1')->user()->UserName}}</a>
			</div>

			<div class="user-sidebar-status">
				<p class="user-sidebar-status">シェアユーザー会員</p>
			</div>


		</div>
		<nav class="sidebar-nav">
			<a class="sidebar-link" fl-analytics="Profile" href="/ShareUser/HostProfile/View/<?php echo Auth::user()->HashCode?>">
				<span class="Icon Icon--light">
					<i class="fa fa-user" aria-hidden="true"></i>
				</span>
				プロフィール
			</a>
			<a class="sidebar-link" fl-analytics="Settings" href="{{url('ShareUser/Dashboard/HostSetting')}}">
				<span class="Icon Icon--light">
					<i class="fa fa-cogs" aria-hidden="true"></i>
				</span>
				{{ trans('navigation.setting') }}<!--設定-->
			</a>
			<a class="sidebar-link" fl-analytics="Help" href="{{url('help')}}">
				<span class="Icon Icon--light">
					<i class="fa fa-question-circle" aria-hidden="true"></i>
				</span>
				ヘルプ
			</a>
			<!--<a class="sidebar-link" fl-analytics="InviteFriends" href="/invite/">
				<span class="Icon Icon--light">
					<i class="fa fa-user-plus" aria-hidden="true"></i>
				</span>
				Invite Friends
			</a>-->
			<a class="sidebar-link" fl-analytics="Logout"  href="/User1/Logout">
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


<nav class="mm">
<div class="flex-column fill-height">
<div class="flex-cell side-panel-top-row">
<ul>
@include('user1.dashboard.left_nav_link')
</ul>
</div>
<div class="flex-cell-auto side-panel-bottom-row">

</div>
</div>
</nav>

@if(getAuth())
<script>
	itemActionChannel.bind( "App\\Events\\NewChatNotificaion", function( data ) {
			jQuery( ".chat-notification" ).prepend('<li class="notification-popover-item"><a href="/ShareUser/Dashboard/Message/'+data.uid+'"><figure id="profile-figure" class="profile-img"><img src="'+ data.photo +'"></figure><div class="notification-item-content"><h4 class="notification-item-title">'+ data.name + '<span class="online-status online" data-size="medium"></span></h4><p class="notification-item-text">'+ data.message +'</p><div class="notification-item-status"><time class="timestamp">'+ data.created +'</time></div></div></a></li>');
				PlaySound();
			} );
	jQuery(function() {
		
		 jQuery(".nvOpn").click( function(e){
			e.preventDefault();
			e.stopPropagation();
			jQuery(this).toggleClass("actv");
			jQuery(".primary-navigation").toggle();
			jQuery("nav").toggle();
			jQuery("body, #left-box").toggleClass("navon");
			jQuery(".header_wrapper").toggleClass("navonh");
		});
		
		jQuery(".navonin").click( function(){
			jQuery("nav").hide();
			jQuery(".nvOpn").click();
			jQuery("body, #left-box").removeClass("navon");
			jQuery(".header_wrapper").removeClass("navonh");
		}); 
		
		/*jQuery(".nvOpn").click( function(e){
			e.preventDefault();
			e.stopPropagation();
			jQuery(this).toggleClass("actv");
			jQuery(".mm").toggle();
			jQuery("body, #left-box, .page-header").toggleClass("navon");
		});
		
		jQuery(".navonin").click( function(){
			jQuery(".nvOpn").click();
			jQuery("body, #left-box").removeClass("navon");
		});*/
		
		jQuery(".switcher").change(function() {
				window.location.href = "/lang/" + jQuery(this).val();
});

	});
		
</script >
@endif

@if (Auth::user()->IsAdminApproved == 'Yes')
		@include('chat.instant-chat')
@endif
