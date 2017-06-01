@include('pages.config')
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="ja" class="is-responsive">
<head>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="content-language" content="ja">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<meta name="robots" content="noindex">
<meta name="csrf-token" content="{{ csrf_token() }}" />

<?php if (isset($space)) {?>
<title>{{getSpaceTitle($space)}} | hOur Office | アワーオフィス</title>
<meta name="description" content="{{getSpaceDescription($space, 160)}}"/>
<meta property="og:url" content="{{getSpaceUrl($space->HashID)}}"/>
<meta property="og:type" content="company"/>
<meta property="og:title" content="{{getSpaceTitle($space)}}"/>
<meta property="og:description" content="{{getSpaceDescription($space)}}"/>
<meta property="og:image" content="{{url(getSpacePhoto($space))}}"/>
<meta property="og:image:width" content="450"/>
<meta property="og:image:height" content="298"/>
<meta property="fb:app_id" content="315767042137325">
<?php }else {?>
<title>hOur Office | アワーオフィス</title>
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
<link rel="stylesheet" href="{{ URL::asset('css/font-icon.css') }}">
<link rel="stylesheet" href="{{ URL::asset('js/swipe-slider/slider-templates/assets/css/bootstrap.min.css') }}" />
<link href="{{ URL::asset('js/mosaic/css/mosaic.css') }}" type="text/css" rel="stylesheet">
<!-- slider JS files -->
<link rel="stylesheet" type='text/css' href="{{ URL::asset('js/labeluty/jquery-labelauty.css') }}">

<!-- Base MasterSlider style sheet -->
<link rel="stylesheet" href="{{ URL::asset('js/swipe-slider/quick-start/masterslider/style/masterslider.css') }}" />

<!-- MasterSlider default skin -->
<link rel="stylesheet" href="{{ URL::asset('js/swipe-slider/quick-start/masterslider/skins/default/style.css') }}" />

<!-- MasterSlider Template Style -->
<link href="{{ URL::asset('js/swipe-slider/slider-templates/lightbox/style/ms-lightbox.css') }}" rel='stylesheet' type='text/css'>

<!-- preview-related stylesheets -->
<link href="{{ URL::asset('js/assets/preview-assets/css/reset.css') }}" rel="stylesheet">
<link href="{{ URL::asset('js/assets/preview-assets/css/smoothness/jquery-ui-1.8.22.custom.css') }}" rel="stylesheet">
<link href="{{ URL::asset('js/assets/preview-assets/css/github.css') }}" rel="stylesheet">
<link href="{{ URL::asset('js/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet">

<!--<link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">-->

<link rel="stylesheet" href="<?php echo SITE_URL?>css/font-icon.css">

<link rel="stylesheet" href="{{ URL::asset('css/style.css?20170124-1652') }}">
<link rel="stylesheet" href="{{ URL::asset('css/user-review.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/page-profile.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/user-validation.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/searchpage.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/bootstrap-tour.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/tipso.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/jquery.webui-popover.css') }}">
<link rel="stylesheet" href="<?php echo SITE_URL?>css/static-page.css">
<link rel="stylesheet" href="{{ URL::asset('js/pushy-master/css/pushy.css') }}">

<link rel="stylesheet" href="<?php echo SITE_URL?>js/remodal/remodal.css">
<link rel="stylesheet" href="<?php echo SITE_URL?>js/remodal/remodal-default-theme.css">
<!-- Prettyphoto Lightbox jQuery Plugin -->
<link href="{{ URL::asset('js/swipe-slider/slider-templates/lightbox/css/prettyPhoto.css') }}" rel='stylesheet' type='text/css' />

<!-- syntaxHilighter style sheet -->
<link rel="stylesheet" type="text/css" href="{{ URL::asset('js/swipe-slider/slider-templates/assets/syntax-highlighter/styles/shCore.css') }}" media="all">

<link rel="stylesheet" type="text/css" href="{{ URL::asset('js/swipe-slider/slider-templates/assets/syntax-highlighter/styles/shThemeDefault.css') }}" media="all">

<!-- Magnific Popup core CSS file -->
<link rel="stylesheet" href="{{ URL::asset('js/magnific-popup/dist/magnific-popup.css') }}">
<!-- Select2 CSS file -->
<link rel="stylesheet" href="{{ URL::asset('css/select2.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/responsive.css?20170202-1729') }}">

<script type="text/javascript">
	var SITE_URL = "{{ url('/') }}/";
</script>
<script src="{{ URL::asset('js/jquery.js') }}"></script>
<script src="{{ URL::asset('js/bootstrap.min.js') }}" ></script>
<script src="{{ URL::asset('js/bootstrap-tour.min.js') }}" ></script>
<script src="{{ URL::asset('js/tipso.min.js') }}" ></script>
<script src="{{ URL::asset('js/addel.jquery.min.js') }}" ></script>
<script src="{{ URL::asset('js/jquery.webui-popover.js') }}" ></script>
<script src="{{ URL::asset('js/flexibility.js') }}" ></script>
<script type="text/javascript" src="{{ URL::asset('js/bootstrap-filestyle.min.js') }}"></script>
	
	<script src="{{ URL::asset('js/labeluty/jquery-labelauty.js') }}"></script>
	<script src="{{ URL::asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('js/mosaic/js/mosaic.1.0.1.min.js') }}" type="text/javascript"></script>

<script src="{{ URL::asset('js/jquery.matchHeight.js') }}" type="text/javascript"></script>
<!-- Magnific Popup core JS file -->
<!-- <script src="js/magnific-popup/dist/jquery.magnific-popup.js') }}"></script> -->
<script src="{{ URL::asset('js/magnific-popup/dist/jquery.magnific-popup.js') }}"></script>

<!-- Select2 JS file -->
<script src="{{ URL::asset('js/select2.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('js/perfect-scrollbar/js/jquery.mousewheel.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('js/perfect-scrollbar/js/perfect-scrollbar.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('js/assets/preview-assets/js/highlight.pack.js') }}"></script>
<script src="{{ URL::asset('js/assets/preview-assets/js/jquery-ui-1.8.22.custom.min.js') }}"></script>
<script src="{{ URL::asset('js/assets/custom.js?t=1') }}"></script>

<script src="<?php echo SITE_URL?>js/remodal/remodal.min.js"></script>

<script>
        jQuery(function(){
            if (jQuery('.js-matchHeight').length)
            {
                jQuery('.js-matchHeight').matchHeight();
            }
        });
    </script>
<!-- slider JS files -->
<script>
        jQuery(function() {
               jQuery(".user-trigger, #user-trigger").click(function () {
              jQuery(".user-sidebar").addClass("has-open-user-sidebar");
           });
           jQuery(".sidebar-close-alt").click(function () {
              jQuery(".user-sidebar").removeClass("has-open-user-sidebar");
           });
        });
    </script>
	<script type="text/javascript" >
jQuery(document).ready(function()
{

jQuery(".current-avilable").click(function()
{
var X=jQuery(this).attr('id');
if(X==1)
{
jQuery(".workspace-actions-popup").hide();
jQuery(this).attr('id', '0');
}
else
{
jQuery(".workspace-actions-popup").show();
jQuery(this).attr('id', '1');
}

});

//Mouse click on sub menu
jQuery(".workspace-actions-popup").mouseup(function()
{
return false
});

//Mouse click on my account link
jQuery(".current-avilable").mouseup(function()
{
return false
});


//Document Click
jQuery(document).mouseup(function()
{
jQuery(".workspace-actions-popup").hide();
jQuery(".current-avilable").attr('id', '');
});

jQuery(window).scroll(function (event) {
    var scroll = jQuery(window).scrollTop();
    if(scroll > 110){
		var w = jQuery("#feed").width();
		//jQuery("#samewidthby").css({"position":"fixed","min-width": "85%"});
		jQuery("#samewidthby").css({"position":"fixed"}).width(w);

	}else{
		jQuery("#samewidthby").removeAttr("style");
	}
});

});
</script>
<script>
        jQuery.noConflict();
            //キャプションフェードイン
    </script>
	<script>
jQuery(function() {
    var count = 90;
    jQuery('.profile_text').each(function() {
        var thisText = jQuery(this).text();
        var textLength = thisText.length;
        if (textLength > count) {
            var showText = thisText.substring(0, count);
            var hideText = thisText.substring(count, textLength);
            var insertText = showText;
            insertText += '<span class="hide-txt">' + hideText + '</span>';
            insertText += '<span class="omit">…</span>';
            insertText += '<span class="more">続きを読む</span>';
            jQuery(this).html(insertText);
        }
    });
    jQuery('.profile_text .hide-txt').hide();
    jQuery('.profile_text .more').click(function() {
            jQuery(this).hide();
            jQuery(this).parent().find('.omit').hide();
            jQuery(this).parent().find('.hide-txt').fadeIn();
			jQuery(this).parent().append('<span class="hd">隠す</span>');
    });

    jQuery('.profile_text').on("click",".hd", function() {
            jQuery(this).parent().find('.omit').show();
            jQuery(this).parent().find('.more').show();
            jQuery(this).parent().find('.hide-txt').fadeOut();
            jQuery(this).remove();

    });

	jQuery(".radio_option .star-rating").click( function(e){
		e.stopPropagation();
		jQuery(this).siblings().removeClass("star-fill");
		jQuery(this).addClass("star-fill").prevAll().toggleClass("star-fill");
		jQuery(this).find("input").prop("checked", !jQuery(this).find("input").prop("checked"));
	});

	jQuery(".radio_option .star-rating").hover( function(){
		var txt = jQuery(this).attr("title");
		jQuery(this).parent().parent().find(".sh-txt").empty().text(txt);
		jQuery(this).siblings().removeClass("star-fill");
		jQuery(this).addClass("star-fill").prevAll().addClass("star-fill");

	},function(){
		var ck;
		jQuery(this).parent().parent().find(".sh-txt").empty();
		jQuery(this).parent().find(".star-rating").each( function(){
			ck = jQuery(this).find("input").prop("checked");
			if( ck ){
				jQuery(this).siblings().removeClass("star-fill");
				jQuery(this).addClass("star-fill").prevAll().addClass("star-fill");
				return false;
			}
		});
		if( !ck ){
			jQuery(this).removeClass("star-fill").prevAll().removeClass("star-fill");
		}


	} );
});
</script>
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
	-ms-transform: rotate(135deg); /* IE 9 */
	-webkit-transform: rotate(135deg); /* Chrome, Safari, Opera */
	transform: rotate(135deg);
	position: absolute;
	top: 25px;
	left: 10px;
}

.nvOpn.actv span:nth-child(2) {
	-ms-transform: rotate(45deg); /* IE 9 */
	-webkit-transform: rotate(45deg); /* Chrome, Safari, Opera */
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

@media screen and (max-width:768px) { /* 640 px */
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

<audio id="audio" src="http://www.soundjay.com/button/button-09.wav" autostart="false" ></audio>
<script>
    function PlaySound() {
          var sound = document.getElementById("audio");
          sound.play()
      }
    </script>
</head>
@include('pages.common_header')