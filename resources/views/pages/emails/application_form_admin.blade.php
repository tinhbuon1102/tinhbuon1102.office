<!DOCTYPE html>
<html lang="en-US">
<head>
<meta charset="utf-8">
</head>
<body>
<p>One user have send you a application form</p>
<p>Details : </p>
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