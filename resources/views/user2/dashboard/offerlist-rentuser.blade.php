
<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header.php'); ?>
@include('pages.header')
<!--/head-->
<body class="mypage rentuser offer">
	<div class="viewport">
		<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header_nav_shareuser.php'); ?>
		@include('pages.header_nav_rentuser')
		<div class="main-container">
			<div id="main" class="container fixed-container">
				<div id="left-box" class="col_3_5">@include('user2.dashboard.left_nav')</div>
				<div id="samewidth" class="right_side">
					<div id="page-wrapper" class="nofix">
						<div class="page-header header-fixed">
							<div class="container-fluid">
								<div class="row">
									<div class="col-xs-6 col-md-6 col-sm-8 clearfix">
										<h1 class="pull-left">
											<i class="fa fa-paper-plane-o" aria-hidden="true"></i>
											オファーリスト
										</h1>
									</div>
								</div>
							</div>
						</div>
						<!--/page-header header-fixed-->
						<div id="feed">
							<section class="feed-event recent-follow feed-box">
								<ul id="news-feed-list" class="offered-list">
									<!--loop give allow to rent-->
									<?php if (isset($user->notifications) && count($user->notifications)) {
										foreach ($user->notifications as $timeCreated => $notifications) {
								?>
									<li>
										<div class="news-feed-wrapper">
											<div class="news-feed-inner">
												<div class="profile-pic-wrapper">
													<span class="profile-pic">
														<a href="#">
															<img src="<?php echo $notifications[0]['user1Send']['Logo'] ? $notifications[0]['user1Send']['Logo'] : '';?>" class="profile-pic" />
														</a>
													</span>
												</div>
												<h2>
													<a class="font-bold" href="#">
														<?php echo $notifications[0]['user1Send']['NameOfCompany'];?>
													</a>
													から
													<?php echo count($notifications);?>
													件オファーがありました。
													<span class="thedate">
														<?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($timeCreated))->diffForHumans()?>
													</span>
												</h2>
												<?php $defineNumHide = 3;?>
												<div class="multiple-offer">
													<?php foreach ($notifications as $notiIndex => $notification) {?>
													<div class="gry-border-box noti-number-<?php echo ($notiIndex >= $defineNumHide) ? 'hide' : 'show';?>" <?php if ($notiIndex >= $defineNumHide) echo 'style="display:none"'?>>
														<div class="office-catch-info clearfix">
															<div class="office-feature-img">
																<a href="#">
																	<img src="<?php echo @$notification['user1Space']['spaceImage'][0]['ThumbPath']?>" />
																</a>
															</div>
															<div class="office-catch-summary">
																<div class="rfloat fav-button">
																	<a href="#" class="gry-btn added_fav" id="fav-btn" onclick="return false;">
																		<i class="fa fa-star" aria-hidden="true"></i>
																		お気に入り追加済
																	</a>
																	<!--if already followed--<a href="#" class="gry-btn" id="follow-btn"><i class="fa fa-check" aria-hidden="true"></i>フォロー済み</a>--/if already followed-->
																</div>
																<h3>
																	<a href="<?php echo getSpaceUrl($notification['user1Space']['HashID'])?>">
																		<?php echo $notification['user1Space']['Title']?>
																	</a>
																</h3>
																<p class="sp-price">
																	<?php echo getPrice($notification['user1Space'])?>
																</p>
																<p class="space-cat">
																	<?php echo $notification['user1Space']['Type']?>
																	<span class="capacity">
																		<?php echo (int)$notification['user1Space']['Capacity']?>
																		人
																	</span>
																</p>
																<p class="space-addr">
																	<?php echo $notification['user1Space']['Prefecture'] . $notification['user1Space']['District']?>
																</p>
															</div>
															<!--/summary-->
														</div>
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
							}else {?>
                            <div class="panel panel-default">
                            <div class="panel-body">
									<div class="no-space-show no-offer-yet">
                            <i class="fa fa-paper-plane-o" aria-hidden="true"></i>
                            <h1>まだオファーはありません</h1>
                            
                            </div>
                            </div>
                            </div>
									<?php }?>
									<!--/space-setting-content-->
							
							</section>
						</div>
						<!--/feed-->
						<!--footer-->
						@include('pages.dashboard_user1_footer')
						<!--/footer-->
					</div>
					<!--/#page-wrapper-->
				</div>
				<!--/right_side-->
			</div>
		</div>
		<!--/main-container-->
	</div>
	<!--/viewport-->
	<script>
jQuery(".input-container.iconbutton").click(function(){
  jQuery(this).toggleClass("checked");
});
</script>
	<script>
      jQuery(function($){
      		$('body').on('click', '.multiple-offer .btn.show-hide', function(e){
          		e.preventDefault();
          		$currentText = $(this).text();
          		$(this).text($(this).attr('data-showHide'));
          		$(this).attr('data-showHide', $currentText);
          		$(this).closest('.multiple-offer').find('.noti-number-hide').toggle();
          	})
      });
    </script>
</body>
</html>
