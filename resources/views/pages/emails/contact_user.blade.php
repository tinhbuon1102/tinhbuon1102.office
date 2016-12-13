<!DOCTYPE html>
<html lang="en-US">
<head>
<meta charset="utf-8">
</head>
<body>
<p>お名前:{{$applicationForm->LastName}} {{$applicationForm->FirstName}} ({{$applicationForm->LastNameKana}} {{$applicationForm->FirstNameKana}})</p>
<p>この度はお問い合わせいただき、誠にありがとうございます。</p>
<p>改めて、担当者よりご連絡させて頂きます。</p>
<p>お問い合わせ内容-------------------------------</p>

<ul>
<?php foreach ($applicationFormMapper as $keyMapper => $translate) {?>
	<?php if(isset($applicationForm->{$keyMapper}) && $applicationForm->{$keyMapper}) {?>
		<li><?php echo $translate?>: <?php echo $applicationForm->{$keyMapper}?></li>
	<?php }?>
<?php }?>
</ul>

@include('pages.emails.footer_common')

</body>
</html>