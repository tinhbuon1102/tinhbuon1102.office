<!DOCTYPE html>
<html lang="en-US">
<head>
<meta charset="utf-8">
</head>
<body>
<p>レントユーザー<a href="{{getUser2ProfileUrl($user2)}}">{{getUser2Name($user2)}}</a>から審査証明書が提出されました。確認の上、ユーザー承認を行ってください。 </p>
<p>&nbsp;</p>
<p><a href="{{url('/MyAdmin/RentUser/' . $user2->HashCode)}}#tab-4">証明書を確認する</a></p>
</body>
</html>