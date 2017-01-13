<?php if (!empty($notifySpaces)) {
foreach ($notifySpaces as $result) {
	$isContinue = true;
	$userSpace = $result['user1Space'];
	$aUserSend = $result[$userSend];
	
	switch($result['Type']) {
		case NOTIFICATION_SPACE :
			$description = 'オファーが' .$result['CountBulk'] . '件きています ';
			$spid=$result['user1Space']['HashID'];
			break;
		case NOTIFICATION_FAVORITE_SPACE :
			if (!$userSpace) 
			{
				$isContinue = false;
				break;
			}
			$description = '['. $userSpace['Title'] .']がお気に入りに追加されました';
			$spid=$result['user1FavSpace']['SpaceId'];
			break;
		case NOTIFICATION_REVIEW_BOOKING :
			$description = 'があなたへのレビューを投稿しました。予約番号#' .$result['TypeID'];
			break;
		case NOTIFICATION_BOOKING_PLACED :
			$spid = $result['user1Space']['HashID'];
			$description = 'から' .$result['user1Space']['Title'] . 'の予約(#'.$result['TypeID'].')が入りました。';
			break;
	}
	if (!$isContinue) continue;
	
?>
<li class="notification-popover-item" data-time="<? echo $result['Time'] ?>">
	<figure id="profile-figure" class="profile-img">
		<img src="<?php echo getUser1Photo($aUserSend)?>" />
	</figure>
	@if(in_array($result['Type'], array(NOTIFICATION_SPACE, NOTIFICATION_FAVORITE_SPACE)))
		  <a href="<?php echo getSpaceUrl($spid)?>">
	@elseif(in_array($result['Type'], array(NOTIFICATION_REVIEW_BOOKING, NOTIFICATION_BOOKING_PLACED)))
		@if ($result['UserReceiveType'] == 1)
		  <a href="<?php echo getSharedBookingDetailUrl($result['TypeID'])?>">
		@else
			<a href="<?php echo getRentBookingDetailUrl($result['TypeID'])?>">
		@endif
	@endif 
	<div class="notification-item-content">
		<p class="notification-item-text">
		
			<strong><?php echo getUserName($aUserSend)?></strong>
			<span class="description"><?php echo $description?></span>
			<span class="notification-time">
				- <?php echo renderHumanTime($result['Time'])?>
			</span>
		
		</p>
	</div>
	@if(in_array($result['Type'], array(NOTIFICATION_SPACE, NOTIFICATION_FAVORITE_SPACE, NOTIFICATION_REVIEW_BOOKING, NOTIFICATION_BOOKING_PLACED)))
		</a>	
	@endif 	
</li>
<?php }}?>