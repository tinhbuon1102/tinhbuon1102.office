<!DOCTYPE html>
<html lang="en-US">
<head>
<meta charset="utf-8">
</head>
<body>
<p><a href="{{ url('/') }}">{{ url('/') }}</a>でシェアユーザーの先行登録がされました。</p>
<p>申し込み情報は以下です。</p>
<br/>

<p><b>会社名: </b>{{ $NameOfCompany }}</p>
<p><b>担当者名:{{ $LastName }}{{ $FirstName }} </b></p>
<p><b>メールアドレス:{{ $Email }} </b></p>

@if (!$isweb)
	@if ($WebUrl != 'http://')
		<p><b>URL: </b>{{ $WebUrl }}</p>
	@endif
@else
	@if ($Address || $PostalCode)
		<p><b>住所: </b>
	@endif
	
	@if ($Address)
		{{ $Address }}, 
	@endif
	
	@if ($PostalCode)
		{{ $PostalCode }}
	@endif
	
	@if ($Address || $PostalCode)
		</p>
	@endif
	
	<p><b>電話番号:{{ $Telephone }}  </b></p>
@endif

<br />
<p>以下の管理画面で確認し、承認を行ってください。<a href="{{ url('/') }}/MyAdmin/Login">ここをクリック</a></p>
</body>
</html>