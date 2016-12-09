@extends('commonLayout')
@section('head')
    <title>Company</title>
    <link rel="apple-touch-icon" sizes="57x57" href="http://office-spot.com/lpnew/images/favicon/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="http://office-spot.com/lpnew/images/favicon/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="http://office-spot.com/lpnew/images/favicon/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="http://office-spot.com/lpnew/images/favicon/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="http://office-spot.com/lpnew/images/favicon/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="http://office-spot.com/lpnew/images/favicon/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="http://office-spot.com/lpnew/images/favicon/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="http://office-spot.com/lpnew/images/favicon/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="http://office-spot.com/lpnew/images/favicon/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="http://office-spot.com/lpnew/images/favicon/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="http://office-spot.com/lpnew/images/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="http://office-spot.com/lpnew/images/favicon/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="http://office-spot.com/lpnew/images/favicon/favicon-16x16.png">
<link rel="manifest" href="/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="http://office-spot.com/lpnew/images/favicon/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">
<link rel="stylesheet" href="//fonts.googleapis.com/earlyaccess/notosansjapanese.css">
@stop

@section('content')
<div class="company-container">
<div class="logo-container"><a href="@if(str_contains(URL::previous(),'RentUser'))
			{{action('User2Controller@landing')}}
			@else
			http://office-spot.com/lp/public/
			@endif"><img src="http://office-spot.com/lpnew/images/logo.png"></a></div>
<h2>COMPNAY</h2>
<div class="form-container">
<div class="company-info ja">
<div class="list">
<div class="left-list">運営会社</div>
<div class="right-list">株式会社アベンチャーズ</div>
</div><!--/list-->
<div class="list">
<div class="left-list">資本金</div>
<div class="right-list">3,000,000円</div>
</div><!--/list-->
<div class="list">
<div class="left-list">代表取締役</div>
<div class="right-list">古源 哲太</div>
</div><!--/list-->
<div class="list">
<div class="left-list">住所</div>
<div class="right-list">〒106-0032<br/>
東京都港区六本木5-9-20<br/>
六本木イグノポール5階</div>
</div><!--/list-->
<div class="list">
<div class="left-list">電話番号</div>
<div class="right-list">03-3470-2770</div>
</div><!--/list-->
<div class="list">
<div class="left-list">メールアドレス</div>
<div class="right-list"><a href="mailto:info@aventures.jp">info@aventures.jp</a></div>
</div><!--/list-->
<div class="list">
<div class="left-list">URL</div>
<div class="right-list"><a href="http://aventures.jp/" target="_blank">http://aventures.jp/</a></div>
</div><!--/list-->
</div><!--/company-info-->
</div>
</div>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-78838677-1', 'auto');
  ga('send', 'pageview');

</script>
@stop

@section('footer')
@stop