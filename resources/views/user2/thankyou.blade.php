@extends('user2Layout')

@section('head')
<link rel="stylesheet" href="{{ URL::asset('lpnew/rentuser/signup/style.css') }}">
@stop

@section('title')
	先行シェア会員登録- Offispo | オフィスポ
@stop
@section('content')

<body class="signup-page">
<div id="page-wrapper" class="thanks-page">
<div ui-view="" class="ng-scope">
<div class="signup-view ng-scope" ng-show="$root.pageLoaded" aria-hidden="false">
<div class="form-container">

				<div class="alert alert-success" role="alert">
                <h2 class="ja">お申し込みありがとうございます</h2>
				<p class="ja">先行シェア会員の登録申し込みを承りました。<br/>
                申込内容ご確認メールが送信されますので、<br/>そちらからメール認証のリンクをクリックし、<br/>申し込み完了のお手続きを行って下さい。</p>
				</div>
                <div class="close-btn"><a href="/RentUser/Dashboard">サイトに戻る</a></div>
					
<div ng-show="loginError" aria-hidden="true" class="" ><span class="label label-warning ng-binding" style="text-align:left;">
	@if(count($errors))
						@foreach($errors->all() as $error)
							{{ $error }} <br/>
						@endforeach
				@endif
</span></div>

</div>
</div>
</div>
</div>
</body>
@stop

		