@include('pages.header')

<!-- Base MasterSlider style sheet -->
<link rel="stylesheet" href="<?php echo SITE_URL?>js/swipe-slider/quick-start/masterslider/style/masterslider.css" />
<!-- MasterSlider default skin -->
<link rel="stylesheet" href="<?php echo SITE_URL?>js/swipe-slider/quick-start/masterslider/skins/default/style.css" />

<!-- MasterSlider Template Style -->
<link href='<?php echo SITE_URL?>js/swipe-slider/slider-templates/lightbox/style/ms-lightbox.css' rel='stylesheet' type='text/css'>
<script class="rs-file" src="<?php echo SITE_URL?>js/assets/royalslider/jquery.easing-1.3.js"></script>
<!-- MasterSlider main JS file -->
<script src="<?php echo SITE_URL?>js/swipe-slider/quick-start/masterslider/masterslider.min.js"></script>

<script src="<?php echo SITE_URL?>js/perfect-scrollbar/js/perfect-scrollbar.js"></script>

<script src="<?php echo SITE_URL?>js/swipe-slider/slider-templates/lightbox/js/jquery.prettyPhoto.js"></script>
 
<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL?>assets/css/main.css">      
  <!-- <script type="text/javascript" src="<?php echo SITE_URL?>assets/js/jquery.min.js"></script> -->
<script type="text/javascript" src="<?php echo SITE_URL?>assets/js/jquery-ui.min.js"></script> 
<script src="<?php echo SITE_URL?>js/datepicker-ja.js"></script>  
<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL?>assets/css/tab.css">
<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL?>assets/css/folio.css">
   <!-- <script type="text/javascript" src="<?php echo SITE_URL?>assets/js/CommonJs.js"></script>  -->
<script src="{{ URL::asset('js/responsive-tabs/easyResponsiveTabs.js') }}"></script>
<link href="{{ URL::asset('js/responsive-tabs/easy-responsive-tabs.css') }}" rel='stylesheet' />
<link href="{{ URL::asset('js/calendar/calendar.css') }}" rel='stylesheet' />
<link href="{{ URL::asset('js/calendar/datepicker/css/bootstrap-datepicker.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('js/calendar/datepicker/css/timepicker.css') }}" rel="stylesheet" />
<script src="{{ URL::asset('js/calendar/lib/moment.min.js') }}"></script>
<script src="{{ URL::asset('js/calendar/calendar.js') }}"></script>
<script src="{{ URL::asset('js/calendar/lang-all.js') }}"></script>
<script src="{{ URL::asset('js/calendar/datepicker/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('js/calendar/datepicker/locales/bootstrap-datepicker.ja.min.js') }}"></script>
<script src="{{ URL::asset('js/calendar/datepicker/js/timepicker.min.js') }}"></script>
<script src="{{ URL::asset('js/calendar/datepicker/js/datepair.js') }}"></script>
<script src="{{ URL::asset('js/calendar/validator.js') }}"></script>
<script src="{{ URL::asset('js/calendar/loadingoverlay.js') }}"></script>
<script src="{{ URL::asset('js/calendar/calendar-custom1.js') }}"></script>
<!--/head-->
<body class="booking-process common">
<div class="viewport">
		<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header_nav_shareuser.php'); ?>
		@if(Auth::check())
			@include('pages.header_nav_shareuser')
		@elseif(Auth::guard('user2')->check())
			@include('pages.header_nav_rentuser')
		@endif
		<section id="page">
		<div id="main">
        <header class="page-header">
        <div class="container">
        <div class="row">
        <div class="col-sm-7">
        
        </div><!--/col-sm-7-->
        <div class="col-sm-5 hidden-xs">
        
        </div><!--/col-sm-5-->
        
        </div><!--/row-->
        </div><!--/container-->
        </header>
        <div id="content" class="pt30 pb30">
				<div class="flash-message">
					@foreach (['danger', 'warning', 'success', 'info'] as $msg)
					  @if(Session::has('alert-' . $msg))
					  <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
					  @endif
					@endforeach
					paypal success page
				  </div> <!-- end .flash-message -->
		</div>
        </div><!--/#main-->
        </section>
        
        </div>
		@include('pages.common_footer')
	<!--/viewport-->
    <script type="text/javascript" src="<?php echo SITE_URL?>assets/js/fromJS.js"></script>
  <script type="text/javascript" src="<?php echo SITE_URL?>assets/js/pageCommon.js"></script>
  </body>
</html>