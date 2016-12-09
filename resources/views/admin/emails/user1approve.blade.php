<div style="width:650px;">
このたびは、offispoの会員にご登録いただきまして、誠にありがとうございます。 <br/>
お客様のご登録が完了いたしましたのでご連絡申し上げます。<br/><br/>

以下のURLをクリックし、メールアドレス認証を行ってください。<br/>
<a href="http://office-spot.com/Register-ShareUser/VerifyEmail/{{ $user->EmailVerificationText }}">http://office-spot.com/Register-ShareUser/VerifyEmail/{{ $user->EmailVerificationText }}</a> 
<br/><br/>

<table style="width:500px;">
	<tr>
		<td style="width:200px;">会社名</td>
		<td>{{ $user->NameOfCompany }}</td>
	</tr>
	<tr>
		<td>ご担当者名</td>
		<td>{{ $user->LastName }} {{ $user->FirstName }}</td>
	</tr>
	<tr>
		<td>メールアドレス</td>
		<td>{{ $user->Email }}</td>
	</tr>
	@if($user->WebUrl != "http://")
	<tr>
		<td>会社サイトURL</td>
		<td>{{ $user->WebUrl }}</td>
	</tr>
	@else
	<tr>
		<td>郵便番号</td>
		<td>{{ $user->PostalCode }}</td>
	</tr>
	<tr>
		<td>住所</td>
		<td>{{ $user->Address }}</td>
	</tr>
	<tr>
		<td>電話番号</td>
		<td>{{ $user->Tel }}</td>
	</tr>
	@endif
</table>

<br/>
<br/>
offispoサイト公開は2016年7月下旬を予定しております。<br/>
サイト公開時、担当者から連絡させて頂きますので、今しばらくお待ち下さい。<br/>
何かご不明な点がありましたら、お気軽に下記連絡先までお問い合わせください。<br/><br/>

==========================================<br/>
offispo / 株式会社aventures<br/>
〒106-0032 東京都港区六本木5-9-20 六本木イグノポール5階<br/>
受付時間　AM9:00〜PM18:00 （平日）<br/>
TEL：03-3470-2770<br/>
MAIL: info@aventures.jp<br/><br/>

http://aventures.jp/<br/>
==========================================<br/>
</div>