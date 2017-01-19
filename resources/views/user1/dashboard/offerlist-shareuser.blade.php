 @include('pages.header')
<!--/head-->
<body class="mypage shareuser">
	<div class="viewport">
		@include('pages.header_nav_shareuser')
		<div class="main-container">
			<div id="main" class="container fixed-container">
				<div id="left-box">@include('user1.dashboard.left_nav')</div>
				<!--/leftbox-->
				<div class="right_side" id="samewidth">
					<div id="page-wrapper" class="nofix">
						<div class="page-header header-fixed">
							<div class="container-fluid">
								<div class="row">
									<div class="col-xs-6 col-md-6 col-sm-8 clearfix">
										<h1 class="pull-left">
											<i class="fa fa-paper-plane-o" aria-hidden="true"></i>
											オファー済一覧
										</h1>
									</div>
								</div>
							</div>
						</div>
						<!--/page-headre-->
                        <div class="container-fluid">
						<div class="panel panel-default">
							<div class="panel-body">
								<?php if (count($notifications)) {?>
								<ul class="offer-lists clearfix">
									<?php 
									foreach ($notifications as $notification)
									{
										$logo = $notification['user2Receive']['Logo'];
										$logo = ($logo && file_exists(public_path() . $logo)) ? url('/') . $logo : url('/') . '/images/man-avatar.png';

										$name = getUserName($notification['user2Receive']);
										$businesstype = $notification['user2Receive']['BusinessType'];
										$skills = $notification['user2Receive']['Skills'];
										$hash = $notification['user2Receive']['HashCode'];
										$userId = $notification['user2Receive']['id'];
										?>
									<li class="list-item ns_result" data-id="<?php echo $userId?>">
										<a href="/RentUser/Profile/<?php echo $hash?>/<?php echo $name?>" class="mgr10 lfloat">
											<div class="scale-picture-container scaled-picture-thum">
												<img class="scaledImageFitWidth img" src="<?php echo $logo?>" alt="" width="75" height="75" itemprop="image">
											</div>
										</a>
										<div class="ofspg">
											<div class="offer-btn-container rfloat">
												<a href="#" class="btn offered offer_btn">
													<i class="fa fa-paper-plane-o" aria-hidden="true"></i>
													<span class="offer-btn-text"> オファー済み </span>
												</a>
											</div>
											<div class="ofsp-usr-info">
												<div class="name">
													<a href="/RentUser/Profile/<?php echo $hash?>/<?php echo $name?>">
														<?php  echo $name?>
													</a>
												</div>
												<div class="job">
													<?php echo $businesstype?>
												</div>
                                                <div class="skill">
													<?php echo $skills?>
												</div>
												<?php echo showStarReview($notification['user2Receive']->reviews, true)?>
											</div>
											<!--/ofsp-usr-info-->
										</div>
										<!--/ofspg-->
									</li>
									<?php
									}
									?>
								</ul>
								<?php } else {
									?>
								<div class="no-space-show">
									<i class="fa fa-paper-plane-o" aria-hidden="true"></i>
									<h1>まだ誰にもオファーはしていません</h1>
									<a href="{{url('RentUser/list')}}" class="yellow-button btn add-space-btn">
										<i class="fa fa-search-plus" aria-hidden="true"></i>
										ユーザーを検索
									</a>
								</div>
								<?php }?>
								<div class="pagenation-inner">
									<div class="dataTables_info">表示結果: {{$notifications->total()}} 件</div>
									<div class="dataTables_paginate paging_simple_numbers">{{ $notifications->links() }}</div>
								</div>
							</div>
						</div>
                        </div>
					</div>
					<!--/#page-wrapper-->
					<!--footer-->
					@include('pages.dashboard_user1_footer')
					<!--/footer-->
				</div>
				<!--/right_side-->
			</div>
		</div>
		<!--/main-container-->
        </div><!--/#containers-->
	</div>
	<?php renderOfferPopup($user1);?>
	<!--/viewport-->
	<script>
	jQuery(function($){
		jQuery(".input-container.iconbutton").click(function(){
			  jQuery(this).toggleClass("checked");
			});
	})

</script>
</body>
</html>
