
<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header.php'); ?>
@include('pages.header')
<!--/head-->
<body class="booking-process common">
<div class="viewport">
		@if(Auth::check())
			@include('pages.header_nav_shareuser')
		@elseif(Auth::guard('user2')->check())
			@include('pages.header_nav_rentuser')
		@else
			@include('pages.header_nav_beforelogin')			
		@endif
		<section id="page">
		<div id="main">
        <header class="page-header">
        <div class="container">
        <div class="row">
        <div class="col-sm-7">
        <h1 itemprop="name">Private / Draft Space</h1>
        </div><!--/col-sm-7-->
        <div class="col-sm-5 hidden-xs">
        
        </div><!--/col-sm-5-->
        
        </div><!--/row-->
        </div><!--/container-->
        </header>
        <div id="content" class="pt30 pb30">
			Following space is Either Private or Draft Space.
        </div>
        </div><!--/#main-->
        </section>
        
        </div>
	<!--/viewport-->
    <script type="text/javascript" src="<?php echo SITE_URL?>assets/js/fromJS.js"></script>
  <script type="text/javascript" src="<?php echo SITE_URL?>assets/js/pageCommon.js"></script>
  </body>
</html>