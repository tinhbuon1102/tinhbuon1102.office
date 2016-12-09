<!--loop give allow to rent-->
<?php if (isset($user->notifications) && count($user->notifications)) {
	foreach ($user->notifications as $timeCreated => $notifications) {
		$aUserSend = $notifications[0]['User2Send'];


		switch($notifications[0]['Type']) {
			case NOTIFICATION_FAVORITE_SPACE :
				$notifTitle = 'があなたをお気に入りに追加しました。';
				break;
			case NOTIFICATION_REVIEW_BOOKING :
				$notifTitle = ($notifications[0]['Status'] == 0) ? 'が以下のスペース利用を終了しました。レビューを投稿しましょう。予約番号 #' .$notifications[0]['TypeID'] : 'があなたのレビューをしました regarding booking #' .$notifications[0]['TypeID'];
				break;
			case NOTIFICATION_BOOKING_PLACED :
				$notifTitle = 'からスペースを予約を受付ました。予約番号: #' . $notifications[0]['TypeID'];
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
					<a href="<?php echo getUser2ProfileUrl($aUserSend)?>">
						<img src="{{getUser2Photo($aUserSend)}}" class="profile-pic" />
					</a>
				</span>
			</div>
			<h2>
				<a class="font-bold" href="<?php echo getUser2ProfileUrl($aUserSend)?>">{{getUserName($aUserSend)}}</a>
				<?php echo $notifTitle?>
				<span class="thedate">
					<?php echo renderHumanTime($timeCreated) ;?>
				</span>
			</h2>
			<?php $defineNumHide = 3;?>
			<div class="multiple-offer">
				<?php 
												foreach ($notifications as $notiIndex => $notification) {?>
				<div class="gry-border-box noti-number-<?php echo ($notiIndex >= $defineNumHide) ? 'hide' : 'show';?>" <?php if ($notiIndex >= $defineNumHide) echo 'style="display:none"'?>>
					<?php if ($notification['Type'] == NOTIFICATION_SPACE) {?>
					<div class="office-catch-info clearfix">
						<div class="office-feature-img">
							<a href="<?php echo getSpaceUrl($notification['user1Space']['HashID'])?>">
								<img src="{{getSpacePhoto(@$notification['user1Space'])}}" />
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
										予約番号 #
										<?php echo $notification['booking']['id']?>
										<a href="<?php echo getSpaceUrl($notification['booking']['bookedSpace']['HashID'])?>">
											<span class="sp-clear">{{$notification['booking']['bookedSpace']['Title']}}</span>
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
										<span class="used-date">
											<?php echo $notification->booking->UsedDate?>
										</span>
									</li>
									<li>
										<span class="label">期間</span>
										{{$notification->booking->DurationText}}
									</li>
								</ul>
							</div>
							<div class="form-btn-wrapper clearfix">
								<a href="<?php echo url('/RentUser/Dashboard/Review/Write/' . $notification['booking']['id'])?>" class="btn btn-info btn-mini">レビュー投稿する</a>
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
									if ($review['ReviewedBy'] == 'User2')
									{
										echo $review['Comment'];
									}
																	}?>
							</p>
							<span class="Rating Rating--labeled" data-star_rating="<?php echo number_format(@$review['AverageRating'], 1)?>">
								<span class="Rating-total">
									<span class="Rating-progress" style="width:<?php echo showWidthRatingProgress(@$review['AverageRating'])?>%"></span>
								</span>
							</span>
						</div>
						<!--/summary-->
					</div>
					<?php }?>
					<?php }?>
					<?php if ($notification['Type'] == NOTIFICATION_FAVORITE_SPACE) {?>
					<div class="shareuser-follower office-catch-infoclearfix">
						<div class="list-item">
							<div class="user-list-wrapper">
								<div class="user-info user-list-inner">
									<div class="profile-pic-wrapper">
										<span class="profile-pic">
											<a class="link_user" href="<?php echo getUser2ProfileUrl($aUserSend)?>">
												<img src="{{getUser2Photo($aUserSend)}}" class="profile-pic" />
											</a>
										</span>
									</div>
                                    <div class="right-table-disc">
									<h3 class="user-name">
										<a class="link_user" href="<?php echo getUser2ProfileUrl($aUserSend)?>">{{getUserName($aUserSend)}}</a>
									</h3>
									<?php  $reviews=\App\Userreview::getUser2Reviews($aUserSend->id);
									showStarReview($reviews);
									?>
									<div id="profile-about-description-wrapper" class="user-about-description-wrapper">
										<div class="job">
											<!--label-->
											<span class="job-label">職種：</span>
											<!--/label-->
											<!--show bussiness cat of the user2-->
											<?php echo $aUserSend->BusinessType; ?>
										</div>
										<!--job-->
										<p ng-hide="isActive" class="profile-about-description excerpt ng-binding ng-scope">
											<!--show description of the user2-->
											<?php echo nl2br(str_limit($aUserSend->BusinessSummary, 150, '...')); ?>
											<a href="<?php echo getUser2ProfileUrl($aUserSend)?>" class="read_more">もっと読む</a>
										</p>
									</div>
									<!--/profile-about-description-wrapper-->
                                    </div>
								</div>
								<!--/user-info-->
							</div>
							<!--/user-list-wrapper-->
						</div>
					</div>
					<?php }?>
					<?php if ($notification['Type'] == NOTIFICATION_BOOKING_PLACED) {?>
					<div class="new-require-review-info book-notice-feed clearfix">
						<div class="book-feed-form clearfix">
							<div class="thum-space">
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
											<span class="sp-clear">{{$notification['booking']['bookedSpace']['Title']}}</span>
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
								</ul>
                                <ul class="dash-sp-dt second">
									<li>
										<span class="label">利用日</span>
										<span class="used-date">
											<?php echo $notification->booking->UsedDate?>
										</span>
									</li>
									<li>
										<span class="label">期間</span>
										{{$notification->booking->DurationText}}
									</li>
								</ul>
							</div>
							
						</div>
						<!--/oay-submit-form-->
                        <div class="form-btn-wrapper clearfix">
								<a href="/ShareUser/Dashboard/EditBook/{{$notification['booking']['id']}}" class="btn btn-info btn-mini">予約詳細</a>
							</div>
							<!--/form-btn-wrapper-->
					</div>
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
	<div class="news-feed-wrapper" style="display: none">
		<div class="no-feed-inner">
			<p class="no-feed">あなたへのお知らせはまだありません。</p>
		</div>
	</div>
</li>
<!--end if no feed yet-->
<?php }?>
<!--/loop give allow to rent-->
