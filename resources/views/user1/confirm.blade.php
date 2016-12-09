<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>先行シェア会員登録- Offispo | オフィスポ</title>
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
<link rel="stylesheet" href="{{ URL::asset('lpnew/style.css') }}">
<link rel="stylesheet" href="{{ URL::asset('lpnew/signup/style.css') }}">
<link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="//fonts.googleapis.com/earlyaccess/notosansjapanese.css">
</head>

<body class="signup-page">
<div id="page-wrapper" class="confirm-page">
<div ui-view="" class="ng-scope">
<div class="signup-view ng-scope" ng-show="$root.pageLoaded" aria-hidden="false">
<form class="m-t ng-pristine ng-invalid ng-invalid-required" role="form" name="signupForm" method="post" action="{{ url('Register-ShareUser/SaveUser') }}" id="frm">
					{{ csrf_field() }}

<div class="form-container no-logo">
<div class="welcome-legend" ng-hide="loginError" aria-hidden="false"><span class="label large">登録内容ご確認</span></div>
<div class="confirm-wrapper clearfix">
<div class="input-container">
<label for="NameOfCompany">会社名</label>
<?=Session::get('NameOfCompany')?>
</div>
<div class="two-inputs">
<div class="input-container input-half">
<label for="LastName">ご担当者名(姓)</label>
<?=Session::get('LastName')?>
</div>
<div class="input-container input-half">
<label for="FirstName">(名)</label>
<?=Session::get('FirstName')?>
</div>
</div>
<div class="input-container">
<label for="Email">メールアドレス</label>
<?=Session::get('Email')?>
</div>

<div class="input-container web <?php if(Session::get('isweb')=="Yes"){ ?> style="display:none" <?php } ?>">
<label for="PostalCode">会社サイトURL</label>
<?=Session::get('WebUrl')?>
</div>
<div class="add"    <?php if(Session::get('isweb')==""){ ?> style="display:none" <?php } ?>>
<div class="input-container">
<label for="PostalCode">郵便番号</label>
<?=Session::get('PostalCode')?>
</div>
<div class="input-container">
<label for="Address">住所</label>
<?=Session::get('Address')?>
</div>
<div class="input-container">
<label for="Tel">電話番号</label>
<?=Session::get('Tel')?>
</div>
</div>


<div class="input-container">
<label class="checkbox">
<input type="checkbox" data-toggle="checkbox" <?php if(Session::get('Newsletter')=="Yes"){ echo "checked"; } ?>  disabled="disable" value="Yes" name="Newsletter">メールマガジンを希望する
</label>
</div>
</div><!--/confirm-wrapper-->
<button class="md-raised md-primary md-button md-ink-ripple" type="submit"   aria-label="Next"><span class="ng-scope">この内容で登録</span></button>
<button class="md-raised md-primary md-button md-ink-ripple" type="button" onclick="location.href = '{{ url('Register-ShareUser') }}';"  aria-label="Next"><span class="ng-scope">編集する</span></button>


</div>
</form>
</div>
</div>
</div>


<script src="{{ URL::asset('lp/dist/js/vendor/jquery.min.js') }}"></script>


</body>
</html>
