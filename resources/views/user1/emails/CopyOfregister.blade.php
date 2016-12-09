<!DOCTYPE html>
<html lang="en-US">
<head>
<meta charset="utf-8">
</head>
<body>
<p>このたびは、offispoの会員にご登録いただきまして、誠にありがとうございます。 </p>
<p>お客様のご登録が完了いたしましたのでご連絡申し上げます。</p>
<br/>
<p>以下のURLをクリックし、メールアドレス認証を行ってください。</p>
<p><a href="{{url('/')}}/Register-ShareUser/VerifyEmail/{{ $EmailVerificationText }}">{{url('/')}}/Register-ShareUser/VerifyEmail/{{ $EmailVerificationText }}</a></p>
<br />
<table style="width:500px;">
	
	<tr>
		<td>会社名</td><td>{{ $NameOfCompany }}</td>
        </tr>
	<tr><td>担当者名</td><td>{{ $LastName }}{{ $FirstName }} </td></tr>
	<tr><td>メールアドレス</td><td>{{ $Email }} </td></tr>

@if (!$isweb)
	@if ($WebUrl != 'http://')
		<tr><td>URL</td><td>{{ $WebUrl }}</td></tr>
	@endif
@else
	@if ($Address || $PostalCode)
		<tr><td>住所:</td>
	@endif
	
	@if ($Address)
		<td>{{ $Address }}, 
	@endif
	
	@if ($PostalCode)
		{{ $PostalCode }}</td>
	@endif
	
	@if ($Address || $PostalCode)
		</tr>
	@endif
	
	<tr><td>電話番号</td><td>{{ $Telephone }}</td></tr>
@endif
</table>
<br />
本サイト公開は2016年8月初旬を予定しております。<br/>
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
</body>
</html>