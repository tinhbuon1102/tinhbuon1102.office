<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
</head>
<body>
<p>この度は、hOur Office掲載代行サービスにお申し込みいただき、誠にありがとうございます。</p>
<p>お申込み内容 : </p>
<ul>
<?php foreach ($applicationFormMapper as $keyMapper => $translate) {?>
	<?php if(isset($applicationForm->{$keyMapper}) && $applicationForm->{$keyMapper}) {?>
		<li><?php echo $translate?>: <?php echo $applicationForm->{$keyMapper}?></li>
	<?php }?>
<?php }?>
</ul>
<p>本メールはhOur Officeサイトより、お申込みの手続きをされた方にお送りしております。<br/>
心当たりのない方は、以下のお問い合わせ先までご連絡ください。</p>
@include('pages.emails.footer_common')

</body>
</html>