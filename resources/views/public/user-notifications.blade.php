<?php if (!empty($notifySpaces)) {
foreach ($notifySpaces as $result) {
	$isContinue = true;
	$userSpace = $result['user1Space'];
	$aUserSend = $result[$userSend];
	
	$sptype='';
	switch($result['Type']) {
		case NOTIFICATION_SPACE :
			$description = ' sent you ' .$result['CountBulk'] . ' offers';
			$sptype='fav';
			$spid=$result['user1Space']['HashID'];
			break;
		case NOTIFICATION_FAVORITE_SPACE :
			if (!$userSpace) 
			{
				$isContinue = false;
				break;
			}
			$description = '['. $userSpace['Title'] .']がお気に入りに追加されました';
			$sptype='fav';
			$spid=$result['user1FavSpace']['SpaceId'];
			break;
		case NOTIFICATION_REVIEW_BOOKING :
			$description = 'があなたへのレビューを投稿しました。予約番号#' .$result['TypeID'];
			break;
	}
	if (!$isContinue) continue;
	
?>
<li class="notification-popover-item" data-time="<? echo $result['Time'] ?>">
	<figure id="profile-figure" class="profile-img">
		<img src="<?php echo getUser1Photo($aUserSend)?>" />
	</figure>
	@if($sptype=='fav')
		  <a href="<?php echo getSpaceUrl($spid)?>">
		 @endif 
	<div class="notification-item-content">
		<p class="notification-item-text">
		
			<strong><?php echo ($aUserSend['NameOfCompany'] ? $aUserSend['NameOfCompany'] : ($aUserSend['LastName'] . $aUserSend['LastName']))?></strong>
			<span class="description"><?php echo $description?></span>
			<span class="notification-time">
				- <?php echo renderHumanTime($result['Time'])?>
			</span>
		
		</p>
	</div>
	@if($sptype=='fav')	
			</a>	
		@endif 	
</li>
<?php }}?>