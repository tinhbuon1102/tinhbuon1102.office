<!DOCTYPE html>
<html lang="en-US">
<head>
<meta charset="utf-8">
</head>
<body>
<p>問い合わせ内容は以下です。</p>
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