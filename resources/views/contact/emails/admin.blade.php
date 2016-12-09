<!DOCTYPE html>
<html lang="en-US">
<head>
<meta charset="utf-8">
</head>
<body>
<p>※本メールは、「offispo」のお問い合わせフォームからきた問い合わせ内容です。</p>
<p>お問い合わせ内容は以下となります。</p>
<br/>

<p><b>[会社名]</b></p>
<p>{{ $company_name }}</p>
<p style="margin-top: 10px">&nbsp;</p>

<p><b>[お名前]</b></p>
<p>{{ $name }}</p>
<p style="margin-top: 10px">&nbsp;</p>

<p><b>[電話番号]</b></p>
<p>{{ $tel }}</p>
<p style="margin-top: 10px">&nbsp;</p>

<p><b>[メールアドレス]</b></p>
<p>{{ $email }}</p>
<p style="margin-top: 10px">&nbsp;</p>

<p><b>[お問い合わせ内容]</b></p>
<p>{!! nl2br(e($contact_message)) !!}</p>
<p style="margin-top: 10px">&nbsp;</p>
</body>
</html>