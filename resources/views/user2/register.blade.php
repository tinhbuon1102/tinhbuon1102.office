@extends('user2Layout')

@section('head')
<link rel="stylesheet" href="{{ URL::asset('lpnew/rentuser/signup/style.css') }}">
@stop

@section('title')
	先行シェア会員登録- Offispo | オフィスポ
@stop
@section('content')

<body class="signup-page">
<div id="page-wrapper">
<div ui-view="" class="ng-scope">
<div class="signup-view ng-scope" ng-show="$root.pageLoaded" aria-hidden="false">
<div class="form-container">
<form class="m-t ng-pristine ng-invalid ng-invalid-required" id="frm" role="form" name="signupForm" method="post" action="Register-RentUser/Step2">
{{ csrf_field() }} 
@if(session()->has('suc'))
						<div class="alert alert-success" role="alert" style="color: green;">{{ session()->get('suc') }}</div>
						@endif
<div class="welcome-legend" ng-hide="loginError" aria-hidden="false"><span class="label">先行情報配信をご希望の方は<br/>こちらより会員登録をお願いいたします。</span></div>
<div ng-init="signup.step=1"></div><div ng-init="signup.nextstep=2"></div>
<div class="two-inputs">
<div class="input-container input-half">
<label for="last_name">姓</label>
<input name="LastName" id="LastName" value="<?=Session::get('LastName')?>" required="" ng-model="signup.last_name" type="text" class="ng-pristine ng-untouched ng-invalid ng-invalid-required" aria-invalid="true">
@if($errors->first('LastName'))
									<div ng-show="LastNameError" class="input-error"><span class="label label-warning ng-binding">{{ $errors->first('LastName') }}</span></div>
								@endif
</div>
<div class="input-container input-half">
<label for="first_name">名</label>
<input name="FirstName" id="FirstName" value="<?=Session::get('FirstName')?>"  required="" ng-model="signup.first_name" type="text" class="ng-pristine ng-invalid ng-invalid-required ng-untouched" aria-invalid="true">
@if($errors->first('FirstName'))
									<div ng-show="FirstNameError" class="input-error"><span class="label label-warning ng-binding">{{ $errors->first('FirstName') }}</span></div>
								@endif
</div>
</div>
<div class="two-inputs">
<div class="input-container input-half">
<label for="last_name_kana">姓(ふりがな)</label>
<input name="LastNameKana" id="LastNameKana" value="<?=Session::get('LastNameKana')?>" required="" ng-model="signup.last_name_kana" type="text" class="ng-pristine ng-untouched ng-invalid ng-invalid-required" aria-invalid="true">
@if($errors->first('LastNameKana'))
									<div ng-show="LastNameError" class="input-error"><span class="label label-warning ng-binding">{{ $errors->first('LastName') }}</span></div>
								@endif
</div>
<div class="input-container input-half">
<label for="first_name_kana">名(ふりがな)</label>
<input name="FirstNameKana" id="FirstNameKana" value="<?=Session::get('FirstNameKana')?>"  required="" ng-model="signup.first_name_kana" type="text" class="ng-pristine ng-invalid ng-invalid-required ng-untouched" aria-invalid="true">
@if($errors->first('FirstNameKana'))
									<div ng-show="FirstNameError" class="input-error"><span class="label label-warning ng-binding">{{ $errors->first('FirstNameKana') }}</span></div>
								@endif
</div>
</div>
<div class="input-container">
<label for="email">メールアドレス</label>
<input id="Email" name="Email" required="" ng-model="signup.email" value="<?=Session::get('Email')?>" type="Email" class="ng-pristine ng-untouched ng-invalid ng-invalid-required" aria-invalid="true">
@if($errors->first('Email'))
								<div ng-show="emailError" class="input-error">
									<span class="label label-warning ng-binding">{{ $errors->first('Email') }}</span>
								</div>
							@endif

</div><div class="input-container">
<label for="password">パスワード</label><input name="password" id="password" required="" ng-model="signup.password" type="password" class="ng-pristine ng-untouched ng-invalid ng-invalid-required" aria-invalid="true">
</div>
<button class="md-raised md-primary md-button md-ink-ripple" type="submit" ><span class="ng-scope">次へ</span></button>
</form>
</div>
</div>
</div>
</div>


<script src="{{ URL::asset('lpnew/dist/js/vendor/jquery.min.js') }}"></script>
	<script src="{{ URL::asset('js/jquery.validate.js?v=1') }}"></script>
	<script src="{{ URL::asset('js/KanaMaker.js') }}"></script>
	<script src="{{ URL::asset('js/kana.js') }}"></script>

	<script>
			$('button[type="submit"]').click(function(){
				$('.input-error .label').hide();
			});
			$("#frm").validate({
				  rules: {
			    Email: {
			      required: true,
			      email: true
			    }
			  }

			});
			
		</script>
		<script>
			$(function(){    
    var convertor = null;
    $("#LastName").click(function(e){
        convertor = new KanaMaker();
    });
    
    $("#LastName").keyup(function(e){
        if(convertor != null){
            convertor.eval(e);
            $("#LastNameKana").val(convertor.Kana());
          
            
        }else if($("#LastName").val() == ""){
            convertor = new KanaMaker(); //reset
        }
    });
	
	var convertor1 = null;
    $("#FirstName").click(function(e){
        convertor1 = new KanaMaker();
    });
    
    $("#FirstName").keyup(function(e){
        if(convertor1 != null){
            convertor1.eval(e);
            $("#FirstNameKana").val(convertor1.Kana());
          
            
        }else if($("#FirstName").val() == ""){
            convertor1 = new KanaMaker(); //reset
        }
    });
});
		</script>
		
</body>		
@stop
		