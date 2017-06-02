@include('pages.config')
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Script-Type" content="text/javascript; charset=UTF-8">
<meta http-equiv="content-language" content="ja">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<meta name="robots" content="noindex">
<meta name="csrf-token" content="{{ csrf_token() }}" />
<?php if (isset($space)) {?>
<title>{{getSpaceTitle($space)}} | hOur Office | アワーオフィス</title>
<meta name="description" content="{{getSpaceDescription($space, 160)}}"/>
<meta property="og:url" content="{{getSpaceUrl($space->HashID)}}"/>
<meta property="og:type" content="website"/>
<meta property="og:title" content="{{getSpaceTitle($space)}}"/>
<meta property="og:description" content="{{getSpaceDescription($space)}}"/>
<meta property="og:image" content="{{url(getSpacePhoto($space))}}"/>
<meta property="og:image:width" content="450"/>
<meta property="og:image:height" content="298"/>
<meta property="fb:app_id" content="315767042137325">
<?php }else {?>
<title>hOur Office | アワーオフィス</title>
<meta name="description" content="hOur Office | アワーオフィス"/>
<meta property="og:url" content="{{url(Route::getCurrentRoute()->getPath())}}"/>
<meta property="og:type" content="website"/>
<meta property="og:title" content="hOur Office | アワーオフィス"/>
<meta property="og:description" content="offispoであなたのオフィススペースを収益化しませんか？好きな時間、価格で、フリーデスク、会議室から個室まで、様々な種類のオフィスが掲載できるマッチングサイト。"/>
<meta property="og:image" content="{{url('images/fb-thum.jpg')}}"/>
<meta property="og:image:width" content="450"/>
<meta property="og:image:height" content="298"/>
<meta property="fb:app_id" content="315767042137325">
<?php	}?>
<link rel="apple-touch-icon" sizes="57x57" href="{{url('/')}}/lpnew/images/favicon/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="{{url('/')}}/lpnew/images/favicon/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="{{url('/')}}/lpnew/images/favicon/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="{{url('/')}}/lpnew/images/favicon/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="{{url('/')}}/lpnew/images/favicon/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="{{url('/')}}/lpnew/images/favicon/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="{{url('/')}}/lpnew/images/favicon/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="{{url('/')}}/lpnew/images/favicon/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="{{url('/')}}/lpnew/images/favicon/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="{{url('/')}}/lpnew/images/favicon/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="{{url('/')}}/lpnew/images/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="{{url('/')}}/lpnew/images/favicon/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="{{url('/')}}/lpnew/images/favicon/favicon-16x16.png">
<link rel="manifest" href="/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="{{url('/')}}/lpnew/images/favicon/ms-icon-144x144.png">
<!-- <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'> -->
<!-- <link rel="stylesheet" href="//fonts.googleapis.com/earlyaccess/notosansjapanese.css') }}"> -->
<link rel="stylesheet" href="{{ URL::asset('css/font-awesome/css/font-awesome.min.css') }}">
<? /*<link rel="stylesheet" href="{{ URL::asset('lpnew/dist/css/flat-ui.min.css') }}">
*/ ?>
<link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/tipso.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/jquery.webui-popover.css') }}">
<link rel="stylesheet" href="{{ URL::asset('js/pushy-master/css/pushy.css') }}">



<!-- Typeahead-->
<link rel="stylesheet" type='text/css' href="{{ URL::asset('css/typeahead.tagging.css') }}">
<!-- slider JS files -->
<link rel="stylesheet" type='text/css' href="{{ URL::asset('js/labeluty/jquery-labelauty.css') }}">

<script type="text/javascript">
	var SITE_URL = "{{ url('/') }}/";
</script>

<script src="{{ URL::asset('js/jquery.js') }}"></script>
<script src="{{ URL::asset('js/bootstrap.min.js') }}" ></script>
<script src="{{ URL::asset('js/tipso.min.js') }}" ></script>
<script src="{{ URL::asset('js/addel.jquery.min.js') }}" ></script>
<script src="{{ URL::asset('js/flexibility.js') }}" ></script>
<script src="{{ URL::asset('js/jquery.webui-popover.js') }}" ></script>

<script class="rs-file" src="{{ URL::asset('js/assets/royalslider/jquery.royalslider.min.js') }}"></script>
<link class="rs-file" href="{{ URL::asset('js/assets/royalslider/royalslider.css') }}" rel="stylesheet">
<script class="rs-file" src="{{ URL::asset('js/assets/royalslider/jquery.easing-1.3.js') }}"></script>
<?/* <script src="{{ URL::asset('lpnew/dist/js/flat-ui.min.js') }}"></script>
*/?><script src="{{ URL::asset('js/application.js') }}"></script>
<script src="{{ URL::asset('js/labeluty/jquery-labelauty.js') }}"></script>
<!-- syntax highlighter -->
<script src="{{ URL::asset('js/assets/preview-assets/js/highlight.pack.js') }}"></script>
<script src="{{ URL::asset('js/assets/preview-assets/js/jquery-ui-1.8.22.custom.min.js') }}"></script>
<script src="{{ URL::asset('js/assets/custom.js') }}"></script>
<script> hljs.initHighlightingOnLoad();</script>
<!-- preview-related stylesheets -->
<link href="{{ URL::asset('js/assets/preview-assets/css/reset.css') }}" rel="stylesheet">
<link href="{{ URL::asset('js/assets/preview-assets/css/smoothness/jquery-ui-1.8.22.custom.css') }}" rel="stylesheet">
<link href="{{ URL::asset('js/assets/preview-assets/css/github.css') }}" rel="stylesheet">

<script src="{{ URL::asset('js/perfect-scrollbar/js/jquery.mousewheel.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('js/perfect-scrollbar/js/perfect-scrollbar.js') }}" type="text/javascript"></script>
<!-- slider stylesheets -->
<script src="{{ URL::asset('js/colorbox-master/jquery.colorbox-min.js') }}" type="text/javascript"></script>
<link class="rs-file" href="{{ URL::asset('js/assets/royalslider/skins/minimal-white/rs-minimal-white.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ URL::asset('js/colorbox-master/colorbox.css') }}">
<link href="{{ URL::asset('js/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ URL::asset('css/font-icon.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/form-style.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/slider.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/page-profile.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/static-page.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/responsive.css?20170124-2255') }}">

@if(getAuth())
<script src="//js.pusher.com/2.2/pusher.min.js"></script>
<script>
	var j=0;
   @if(Auth::check())
		var url="/chat/auth";
		j=1;
	@elseif(Auth::guard('user2')->check())
		var url="/chat/auth1";
		j=1;
	@endif
	
	var pusher = new Pusher("{{getenv('PUSHER_KEY')}}", {
    authEndpoint: url,
    auth: {
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    }
	
});

@if(Auth::check())
	var itemActionChannel = pusher.subscribe("private-chat-{{Auth::user()->HashCode}}");
@elseif(Auth::guard('user2')->check())
	var itemActionChannel = pusher.subscribe("private-chat-{{Auth::guard('user2')->user()->HashCode}}");
@endif
</script>
@endif

<script>
$(document).ready(function(){
    //画面の高さを取得して、変数wHに代入
    var wH = $(window).height(); 
    //div#exampleの高さを取得を取得して、変数divHに代入
    var divH = $('div.royalSlider').innerHeight();
    // ボックス要素より画面サイズが大きければ実行
    if(wH > divH){
    	// div#examplに高さを加える
    	$('div.royalSlider').css('height',wH+'px'); 
    }
});
</script>

<script>
        jQuery(function() {
               jQuery(".user-trigger, #user-trigger").click(function () {
              jQuery(".user-sidebar").addClass("has-open-user-sidebar");
           });
           jQuery(".sidebar-close-alt").click(function () {
              jQuery(".user-sidebar").removeClass("has-open-user-sidebar");
           });
        });
        var yahooAddress = <?php echo getYahooAddressApi(); ?>;
    </script>

<!--<script>
$(function(){
 var header = $('.header_wrapper')
 header_offset = header.offset();
 header_height = header.height();
  $(window).scroll(function () {
   if($(window).scrollTop() > header_offset.top + header_height) {
    header.addClass('scroll');
   }else {
    header.removeClass('scroll');
   }
  });
});
</script>-->

<link rel="stylesheet" href="{{ URL::asset('js/remodal/remodal.css') }}">
<link rel="stylesheet" href="{{ URL::asset('js/remodal/remodal-default-theme.css') }}">
<style>
.remodal-close {
	z-index: 500;
}

.mm {
	display: none;
}

.nvOpn {
	display: none;
	width: 46px;
	height: auto;
	position: relative;
	float: left;
	padding: 20px 12px;
}

.nvOpn span {
	display: inline-block;
	height: 3px;
	background: #000;
	width: 100%;
	margin: 0 0 4px 0;
	transition: ALL ease-in-out 0.4s;
}

.nvOpn.actv span:nth-child(1) {
	-ms-transform: rotate(135deg);
	-webkit-transform: rotate(135deg);
	transform: rotate(135deg);
	position: absolute;
	top: 25px;
	left: 10px;
}

.nvOpn.actv span:nth-child(2) {
	-ms-transform: rotate(45deg);
	-webkit-transform: rotate(45deg);
	transform: rotate(45deg);
	top: 25px;
	left: 10px;
	position: absolute;
}

.nvOpn.actv span:nth-child(3) {
	opacity: 0;
}

.nvOpn.actv span {
	width: 30px;
}

@media screen and (max-width:768px) {
	.mm {
		display: none;
	}
	nav:not (.footer-site-nav ):not (.sidebar-nav ) {
		display: none;
		background: rgba(44, 50, 53, 0.96);
		width: 250px;
		left: 0;
		position: fixed;
		bottom: 0;
		top: 60px;
		min-height: 360px;
		z-index: 8997;
	}
	.header_wrapper .nvOpn {
		display: block;
	}
	header nav>ul>li a:before {
		margin: 0 14px 0 0;
	}
	header nav>ul>li {
		width: 100%;
	}
}

header nav>ul>li {
	float: left !important;
}

body.navon .nvOpn {
	display: none;
}

body.navon .nvOpn.actv {
	display: block;
}
</style>
</head>


@include('pages.common_header')