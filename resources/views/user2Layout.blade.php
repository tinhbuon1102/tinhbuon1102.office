<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title')</title>
<meta name="description" content="好きな場所であなたのオフィスを見つけよう。スタートアップオフィスをお探しの企業やワークスペースをお探しの個人事業の方へ。オフィススペース探しのマッチングサイト。"/>
<meta name="keywords" content="オフィス,オフィススペース,事務所,短期,スタートアップ,個人事業,レンタルオフィス,マッチングサイト,会議室,プライベートオフィス,デスクシェア,敷金無し,礼金無し,シェアオフィス"/>
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
<meta name="theme-color" content="#ffffff">
<link rel="stylesheet" href="{{ URL::asset('lpnew/rentuser/style.css') }}">
@yield('head')
<script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
<!--[if lt IE 9]>
<script src="../js/vendor/html5shiv.js"></script>
<script src="../js/vendor/respond.min.js"></script>
<![endif]-->
<style>
.signup-view .form-container .error {
	color: red !important;
}
</style>
</head>

@yield('content')

@yield('footer')
</html>