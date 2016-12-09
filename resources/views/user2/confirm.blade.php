@extends('user2Layout')
@section('title')
	Confirm Page
@stop
@section('head')
<link rel="stylesheet" href="{{ URL::asset('lpnew/rentuser/signup/style.css') }}">
@stop
@section('footer')
<script src="{{ URL::asset('lpnew/rentuser/dist/js/vendor/jquery.min.js') }}"></script>

@stop

@section('content')
<body class="signup-page">
<div id="page-wrapper">
<div ui-view="" class="ng-scope">
<div class="signup-view ng-scope" ng-show="$root.pageLoaded" aria-hidden="false">
<div class="form-container no-logo">
<form class="m-t ng-pristine ng-invalid ng-invalid-required" role="form" name="signupForm" method="post" action="{{ url('Register-RentUser/SaveUser') }}" id="frm">
					{{ csrf_field() }}


	 <!--<div class="form-container no-logo">-->
<div class="welcome-legend" ng-hide="loginError" aria-hidden="false"><span class="label large">登録内容ご確認</span></div>
<div class="confirm-wrapper clearfix">

<div class="two-inputs">
<div class="input-container input-half">
<label for="LastName">姓</label>
<?=Session::get('LastName')?>
</div>
<div class="input-container input-half">
<label for="FirstName">名</label>
<?=Session::get('FirstName')?>
</div>
</div>
<div class="two-inputs">
<div class="input-container input-half">
<label for="LastName">姓(ふりがな)</label>
<?=Session::get('LastNameKana')?>
</div>
<div class="input-container input-half">
<label for="FirstName">名(ふりがな)</label>
<?=Session::get('FirstNameKana')?>
</div>
</div>
<div class="input-container">
<label for="Email">メールアドレス</label>
<?=Session::get('Email')?>
</div>


<div class="add">
<div class="input-container">
<label for="PostalCode">郵便番号</label>
<?=Session::get('PostalCode')?>
</div>
<div class="input-container">
<label for="Address">住所</label>
<?=Session::get('Address')?>
</div>
<div class="input-container">
<label for="UserType">事業主種類</label>
<?=Session::get('UserType')?>
</div>
<div class="input-container">
<label for="UserType">事業のタイプ</label>
<?=Session::get('BusinessType')?>
</div>
</div>


<div class="input-container">
<label class="checkbox">
<input type="checkbox" data-toggle="checkbox" <?php if(Session::get('Newsletter')=="Yes"){ echo "checked"; } ?>  disabled="disable" value="Yes" name="Newsletter">メールマガジンを希望する
</label>
</div>
</div><!--/confirm-wrapper-->
<button class="md-raised md-primary md-button md-ink-ripple" type="submit"   aria-label="Next"><span class="ng-scope">この内容で登録</span></button>
<button class="md-raised md-primary md-button md-ink-ripple" type="button" onclick="location.href = '{{ url('Register-RentUser') }}';"  aria-label="Next"><span class="ng-scope">編集する</span></button>


<!--</div>-->
				
	</form>
</div>
</div>
</div>
</div>
</body>
@stop