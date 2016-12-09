
@include('pages.header')
<!--/head-->
<body class="mypage shareuser">
	<div class="viewport">
		@include('pages.header_nav_shareuser')
		<div class="main-container">
			<div id="main" class="container fixed-container">
				<div id="left-box">
					@include('user1.dashboard.left_nav')
					<!--/right-content-->
				</div>
				<!--/leftbox-->
				<div class="right_side" id="samewidth">
					<div id="page-wrapper" class="nofix">
						<div class="page-header header-fixed">
							<div class="container-fluid">
								<div class="row">
									<div class="col-xs-6 col-md-6 col-sm-8 clearfix">
										<h1 class="pull-left" id="bt-s1">
											<i class="fa fa-user" aria-hidden="true"></i>
											あなたにおすすめのユーザー
										</h1>
									</div>
								</div>
							</div>
						</div>
						<div class="container-fluid">
							<div class="panel panel-default">
								<div class="panel-body">
									<div id="rentuser-content">
										<div class="pagenation-container top-pg clearfix">
											<div class="ns_pagination">{{ $user2s->links() }}</div>
			                        		<span class="result-amount">Showing {{$user2s->total()}} Results</span>
										</div>
										<ul id="rentuser_list" class="ns_rentuser-list">
											<?php foreach ($user2s as $user2) {?>
											<li class="ns_result  big-thumb" data-id="<?php echo $user2->id?>">
												<div class="media-left">
													<div class="inn-simi">
														<a href="{{getUser2ProfileUrl($user2)}}" class="rentuser-profile-media" target="_blank">
															<img class="rentuser-profile-image" src="{{getUser2Photo($user2)}}" alt="">
														</a>
													</div>
												</div>
												<div class="media-body">
													<h3>
														<span class="online-status" data-is_online="1" data-idx="3" style="display: inline-block !important;"></span>
														<a href="{{getUser2ProfileUrl($user2)}}" class="find-rentuser-username" target="_blank">{{getUser2Name($user2)}}</a>
													</h3>
													<div class="clear"></div>
													<div class="rentuser-card-stats">
														<?php echo showStarReview($user2->reviews, true);?>
													</div>
													<p class="top-skills">
														Skills: <?php echo $user2->Skills?>
													</p>
													<?php if ($user2->BusinessSummary) {?>
													<p ng-hide="isActive" class="profile-about-description excerpt ng-binding ng-scope">
														<span class="full_text read_more_text" style="display:none;"><?php echo nl2br($user2->BusinessSummary); ?></span>
														<span class="short_text read_more_text"><?php echo nl2br(str_limit($user2->BusinessSummary, 150, '...')); ?></span>
														<a href="javascript:void(0);" class="read_more read_more_button">もっと読む</a>
														<a href="javascript:void(0);" class="read_less read_more_button" style="display: none;">Less</a>
													</p>
													<?php }?>
													<?php 
													$notification = \App\Notification::isOfferedSpace($user, $user2);
													$offered = false;
													$offeredClass = '';
													if ($notification)
													{
														$offered = true;
														$offeredClass = 'offered';
													}?>
													<div class="offerme-w">
														<a class="btn btn-mini fl-bt-skin offer_btn {{$offeredClass}}" title="Offer Spaces">
															<i class="fa fa-paper-plane-o" aria-hidden="true"></i>
															<span class="offer-btn-text"> <?php echo $offered ? 'オファー済み' : 'オファーする'?> </span>
														</a>
													</div>

												</div>
											</li>
											<?php }?>
										</ul>
										
										<div class="rentuser-content-inner">
											<div class="ns_pagination">{{ $user2s->links() }}</div>
			                        		<span class="result-amount">Showing {{$user2s->total()}} Results</span>
			                    		</div>
									</div>
									<!--/#rentuser-content-->
								</div>
							</div>
						</div>


					</div>
					<!--/#page-wrapper-->
					<!--footer-->
					@include('pages.dashboard_user1_footer')

					<!--/footer-->
				</div>

			</div>
		</div>
		<!--/main-container-->
		<!--footer-->

		<!--/footer-->
	</div>
	<!--/viewport-->
	<?php renderOfferPopup($user);?>
	<script>
	jQuery(function($) {
		$('body').on('click', '.profile-about-description .read_more_button', function(e){
      		e.preventDefault();
      		$(this).closest('.profile-about-description').find('.read_more_text').toggle();
      		$(this).closest('.profile-about-description').find('.read_more_button').toggle();
      		
      	})
  	});
    </script>
</body>
</html>
