<div style="width:650px;">
<table style="width:500px;">
	<tr>
		<td>お名前</td>
		<td>{{getUserName($user)}}</td>
	</tr>
	<tr>
		<td>メールアドレス</td>
		<td>{{$user->Email}}</td>
	</tr>
	<tr>
		<td>事業主種別</td>
		<td>{{ $user->UserType }}</td>
	</tr>
	<tr>
		<td>事業タイプ</td>
		<td>{{ $user->BusinessType }}</td>
	</tr>
</table>

<br />
<p>以下の管理画面で確認し、承認を行ってください。<a href="{{ url('/') }}/MyAdmin/Login">ここをクリック</a></p>

</div>