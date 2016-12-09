<div style="width:650px;">
このたびは、offispoの会員にご登録いただきまして、誠にありがとうございます。 <br/>
お客様のご登録が完了いたしましたのでご連絡申し上げます。<br/><br/>

以下のURLをクリックし、メールアドレス認証を行ってください。<br/>
<a href="{{url('/')}}/	/VerifyEmail/{{ $user->EmailVerificationText }}">{{url('/')}}/Register-RentUser/VerifyEmail/{{ $user->EmailVerificationText }}</a> 
<br/><br/>

<table style="width:500px;">
	
	<tr>
		<td>お名前</td>
		<td>{{getUserName($user)}}</td>
	</tr>
	<tr>
		<td>ふりがな</td>
		<td>{{ $user->LastNameKana }} {{ $user->FirstNameKana }}</td>
	</tr>
	<tr>
		<td>メールアドレス</td>
		<td>{{ $user->Email }}</td>
	</tr>
	
	<tr>
		<td>郵便番号</td>
		<td>{{ $user->PostalCode }}</td>
	</tr>
	<tr>
		<td>住所</td>
		<td>{{ getUserAddress($user) }}</td>
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

<br/>
<br/>
本サイト公開は2016年8月初旬を予定しております。<br/>
サイト公開時、担当者から連絡させて頂きますので、今しばらくお待ち下さい。<br/>
何かご不明な点がありましたら、お気軽に下記連絡先までお問い合わせください。<br/><br/>

==========================================<br/>
offispo / 株式会社aventures<br/>
〒106-0032 東京都港区六本木5-9-20 六本木イグノポール5階<br/>
受付時間　AM9:00〜PM18:00 （平日）<br/>
TEL：03-3470-2770<br/>
MAIL: <a href="mail:info@aventures.jp">info@aventures.jp</a>
<br/><br/>

http://aventures.jp/<br/>
==========================================<br/>
</div>