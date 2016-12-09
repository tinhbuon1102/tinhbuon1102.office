<!DOCTYPE html>
<html lang="en-US">
<head>
<meta charset="utf-8">
</head>
<body>
<p>シェアユーザー<a href="{{getUser1ProfileUrl($user1)}}">{{getUser1Name($user1)}}</a>から審査証明書が提出されました。確認の上、ユーザー承認を行ってください </p>
<p>&nbsp;</p>
<p><a href="{{url('/MyAdmin/ShareUser/' . $user1->HashCode)}}#tab-5">証明書を確認する</a></p>
</body>
</html>