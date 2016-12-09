<!DOCTYPE html>
<html lang="en-US">
<head>
<meta charset="utf-8">
</head>
<body>
<p>Thank you to complete Application form, We will back to you soon</p>
<p>Your Details : </p>
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