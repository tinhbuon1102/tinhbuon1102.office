
<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header.php'); ?>
@include('pages.header')
<!--/head-->
<body class="private-draft common">
<div class="viewport">
		@if(Auth::check())
			@include('pages.header_nav_shareuser')
		@elseif(Auth::guard('user2')->check())
			@include('pages.header_nav_rentuser')
		@else
			@include('pages.before_login_nav')			
		@endif
		<section id="page">
		<div id="main">
        <div id="content" class="not-found">
        <div class="error-404-message">
       <h1>このスペースは公開されていません。</h1>
        <p>このスペースは一時的に非公開されているため、<br class="mb-none">現在閲覧はできません。</p>
        <a href="{{url('/')}}" class="goback-home"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i>トップページに戻る</a>
        </div><!--/error-404-message-->
   
        </div><!--/#content-->
        </div><!--/#main-->
        </section>
        @include('pages.common_footer')
        </div>
	<!--/viewport-->
    <script type="text/javascript" src="<?php echo SITE_URL?>assets/js/fromJS.js"></script>
  <script type="text/javascript" src="<?php echo SITE_URL?>assets/js/pageCommon.js"></script>
  </body>
</html>