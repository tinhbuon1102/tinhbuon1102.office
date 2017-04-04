<!--loop give allow to rent-->
<?php if (isset($user->notifications) && count($user->notifications)) {
	foreach ($user->notifications as $timeCreated => $notifications) {
		$aUserSend = $notifications[0]['User1Send'];
		switch($notifications[0]['Type']) {
			case NOTIFICATION_SPACE :
				$notifTitle = 'から'. count($notifications) .'件オファーがきています。';
				break;
			case NOTIFICATION_FAVORITE_SPACE :
				$notifTitle = '';
				break;
			case NOTIFICATION_REVIEW_BOOKING :
				$notifTitle = ($notifications[0]['Status'] == 0) ? 'があなたにレビューを投稿しました。予約番号#' .$notifications[0]['TypeID'] : 'があなたのレビューをしました。予約番号#' .$notifications[0]['TypeID'];
				break;
			case NOTIFICATION_BOOKING_PLACED :
				$notifTitle = '以下の予約の申込みが完了しました。<span class="red">予約申込みはまだ承認されていません。</span><br/><a class="font-bold" href="'. getUser1ProfileUrl($aUserSend) .'">'. getUserName($aUserSend) .'</a>からの承認をお待ち下さい。';
				break;
			case NOTIFICATION_BOOKING_CHANGE_STATUS :
				if ($notifications[0]['booking']['status'] == BOOKING_STATUS_RESERVED)
				{
					$notifTitle = 'から以下の予約が承認され、予約ステータスが<span class="purple bold">予約済み</span>になりました。';
				}
				else {
					$notifTitle = 'が予約(#'.$notifications[0]['TypeID'].')のステータスを変更し、'. getBookingStatus($notifications[0]['booking'], false) .'となりました。';
				}
				break;
			case NOTIFICATION_BOOKING_REFUND_NO_CHARGE :
				$notifTitle = 'が以下のの予約(#'.$notifications[0]['TypeID'].')をキャンセルし、支払額は返金されました。キャンセル規約に基づき、キャンセル料はかかりません。';
				break;
			case NOTIFICATION_BOOKING_REFUND_50 :
				$notifTitle = 'が以下のの予約(#'.$notifications[0]['TypeID'].')をキャンセルしました。キャンセル規約に基づき、キャンセル料は支払額の50%です。';
				break;
			case NOTIFICATION_BOOKING_REFUND_100 :
				$notifTitle = 'が以下のの予約(#'.$notifications[0]['TypeID'].')をキャンセルしました。キャンセル規約に基づき、支払額の返金はされません。';
				break;
			default:
				$notifTitle = '';
				break;
		}
		?>
<li class="feed">
	<div class="news-feed-wrapper">
		<div class="news-feed-inner">
			<div class="profile-pic-wrapper">
				<span class="profile-pic">
					<a href="<?php echo getUser1ProfileUrl($aUserSend)?>">
						<img src="{{getUser1Photo($aUserSend)}}" class="profile-pic" />
					</a>
				</span>
			</div>
			<h2>
				<?php if (!in_array($notifications[0]['Type'], array(NOTIFICATION_BOOKING_PLACED))) {?>
				<a class="font-bold" href="<?php echo getUser1ProfileUrl($aUserSend)?>">
					<?php echo $aUserSend['NameOfCompany'];?>
				</a>
				<?php }?>
				<?php echo $notifTitle?>
				<span class="thedate">
					<?php echo renderHumanTime($timeCreated) ;?>
				</span>
			</h2>
			<div class="multiple-offer">
				<?php 
				$defineNumHide = 3;
				foreach ($notifications as $notiIndex => $notification) {?>
				<div class="gry-border-box noti-number-<?php echo ($notiIndex >= $defineNumHide) ? 'hide' : 'show';?>" <?php if ($notiIndex >= $defineNumHide) echo 'style="display:none"'?>>
					<?php if ($notification['Type'] == NOTIFICATION_SPACE) {?>
					<div class="office-catch-info clearfix">
						<div class="office-feature-img">
							<a href="<?php echo getSpaceUrl($notification['user1Space']['HashID'])?>">
								<img src="<?php echo @$notification['user1Space']['spaceImage'][0]['ThumbPath']?>" />
							</a>
						</div>
						<div class="office-catch-summary">
							<h3>
								<a href="<?php echo getSpaceUrl($notification['user1Space']['HashID'])?>">
									<?php echo $notification['user1Space']['Title']?>
								</a>
							</h3>
							<p class="excerpt">
								<?php echo $notification['user1Space']['Details']?>
								<!--if letters are over 164-->
								<!--...-->
								<!--/if letters are over 164-->
							</p>
						</div>
						<!--/summary-->
					</div>
					<?php }?>
					<?php if ($notification['Type'] == NOTIFICATION_REVIEW_BOOKING) {?>
					<?php if ($notification['Status'] == 0) {?>
					<div class="new-require-review-info clearfix">
						<div class="review-feed-form clearfix">
							<div class="fleft thum-review">
								<a href="<?php echo getSpaceUrl($notification['booking']['bookedSpace']['HashID'])?>">
									<img src="<?php echo getSpacePhoto($notification['booking']['bookedSpace'])?>">
								</a>
							</div>
							<div class="detail-block">
								<p>
									<strong>
										予約番号#
										<?php echo $notification['booking']['id']?>
										<a href="<?php echo getSpaceUrl($notification['booking']['bookedSpace']['HashID'])?>">
											<span class="sp-clear"><?php getSpaceTitle($notification['booking']['bookedSpace'], 160)?></span>
										</a>
									</strong>
								</p>
								<ul class="dash-sp-dt">
									<li>
										<span class="span-icon sp-type">
											<?php echo $notification['booking']['bookedSpace']['Type']?>
										</span>
										<span class="span-icon sp-price">
											<?php echo getPrice($notification['booking']['bookedSpace'], true)?>
										</span>
									</li>
									<li>
										<span class="label">利用日</span>
										{{$notification->booking->UsedDate}}
									</li>
									<li>
										<span class="label">期間</span>
										{{$notification->booking->DurationText}}
									</li>
								</ul>
							</div>
							<div class="form-btn-wrapper clearfix">
								<a href="<?php echo url('/RentUser/Dashboard/Review/Write/' . $notification['booking']['id'])?>" class="btn btn-info btn-mini">レビューを投稿する</a>
							</div>
							<!--/form-btn-wrapper-->
						</div>
						<!--/oay-submit-form-->
					</div>
					<?php }elseif ($notification['Status'] == 1) {?>
					<div class="new-review-info clearfix">
						<div class="review-summary">
							<p class="review-comment">
								<i class="fa fa-quote-left" aria-hidden="true"></i>
								<?php foreach ($notification['booking']['review'] as $review) {
									if ($review['ReviewedBy'] == 'User1')
									{
										echo $review['Comment'];
									}
																	}?>
							</p>
							<span class="Rating Rating--labeled" data-star_rating="<?php echo number_format($review['AverageRating'], 1)?>">
								<span class="Rating-total">
									<span class="Rating-progress" style="width:<?php echo showWidthRatingProgress($review['AverageRating'])?>%"></span>
								</span>
							</span>
						</div>
						<!--/summary-->
					</div>
					<?php }?>
					<?php }?>
					<?php if (in_array($notification['Type'], array(NOTIFICATION_BOOKING_PLACED, NOTIFICATION_BOOKING_CHANGE_STATUS, NOTIFICATION_BOOKING_REFUND_50, NOTIFICATION_BOOKING_REFUND_100, NOTIFICATION_BOOKING_REFUND_NO_CHARGE))) {?>
					<div class="alert alert-info">
						<?php if (in_array($notification['Type'], array(NOTIFICATION_BOOKING_REFUND_50))) {?>
						<strong>キャンセル料: </strong>
						{{priceConvert($notification['booking']['refund_amount'], true)}} (支払合計金額 {{priceConvert($notification['booking']['amount'], true)}}の50%)
						<?php }elseif (in_array($notification['Type'], array(NOTIFICATION_BOOKING_REFUND_100))) {?>
						<strong>キャンセル料: </strong>
						{{priceConvert($notification['booking']['amount'], true)}}
						<?php } elseif (in_array($notification['Type'], array(NOTIFICATION_BOOKING_REFUND_NO_CHARGE))) {?>
						<strong>キャンセル料: </strong>
						{{priceConvert($notification['booking']['refund_amount'], true)}}
						<?php } else {
							?>
						<strong>予約状況: </strong>
						{{getBookingStatus($notification['booking'])}}
						<?php
														}?>
					</div>
					<div class="gry-border-box">
						<div class="row">
							<div class="col-md-4">
								<a href="<?php echo getSpaceUrl($notification['booking']['bookedSpace']['HashID'])?>">
									<img src="<?php echo getSpacePhoto($notification['booking']['bookedSpace'])?>">
								</a>
							</div>
							<div class="col-md-8">
								<div class="new-oayment-info clearfix">
									<div class="pay-submit-form">
										<p>
											<strong>予約番号 #{{$notification['booking']['id']}}</strong>
										</p>
										<ul class="dash-sp-dt">
											<li class="sp-name">
												<a href="<?php echo getSpaceUrl($notification['user1Space']['HashID'])?>">
													<?php echo $notification['user1Space']['Title']?>
												</a>
											</li>
											<li>
												<span class="label">利用開始日</span>
												{{renderJapaneseDate($notification['booking']['charge_start_date'], false)}}
											</li>
											<li>
												<span class="label">利用期間</span>
												{{$notification['booking']['DurationText']}}
											</li>
											<?php if (in_array($notification['Type'], array(NOTIFICATION_BOOKING_REFUND_50, NOTIFICATION_BOOKING_REFUND_100))) {?>
											<li>
												<span class="label">予約状況</span>
												{{getBookingStatus($notification['booking'])}}
											</li>
											<?php }?>
										</ul>
										<div class="form-btn-wrapper">
											<a href="/RentUser/Dashboard/Reservation/View/{{$notification['booking']['id']}}" class="btn btn-info btn-mini">詳細</a>
										</div>
										<!--/form-btn-wrapper-->
									</div>
									<!--/oay-submit-form-->
								</div>
							</div>
						</div>
						<!--/row-->
					</div>
					<!--/gry-border-box-->
					<?php }?>
				</div>
				<?php }?>
				<a style="<?php if ($notiIndex < $defineNumHide) echo 'display:none'?>" href="#" data-showHide="Show Less" class="btn show-hide gry-btn btn-fullwidth">Show all</a>
			</div>
		</div>
		<!--/innner-->
	</div>
</li>
<?php
	}
							} else {?>
<!--start if no feed yet-->
<li class="feed">
	<div class="news-feed-wrapper" style="display: none;">
		<div class="no-feed-inner">
			<p class="no-feed">あなたへのお知らせはまだありません。</p>
		</div>
	</div>
</li>
<!--end if no feed yet-->
<?php }?>