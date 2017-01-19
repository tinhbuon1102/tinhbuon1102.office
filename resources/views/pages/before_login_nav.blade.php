<!-- Pushy Menu -->
        <nav class="pushy pushy-left">
        @include('pages.nav_links_beforelogin')
        </nav>
        <!-- Site Overlay -->
        <div class="site-overlay"></div>
<div id="containers">
<div class="header_wrapper primary-navigation-section transparent_header beforelogin_head">
	<header id="header">
		<div class="header_container">
			<div class="logo_container">
				<a class="logo" href="{{url('/')}}">hOur Office</a>
			</div>
			<!--nav-->
			<div class="nvOpn menu-btn">
				<span></span>
				<span></span>
				<span></span>
			</div>

			<nav class="primary-navigation">
				@include('pages.nav_links_beforelogin')
			</nav>
			<!--/nav-->
		</div>
	</header>
</div>
<!--/header_wrapper-->