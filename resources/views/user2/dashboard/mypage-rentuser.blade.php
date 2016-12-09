
<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header.php'); ?>
@include('pages.header')
<!--/head-->
<body class="mypage">
	<div class="viewport">
		<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header_nav_rentuser.php'); ?>
		@include('pages.header_nav_rentuser')
		<div class="main-container">
			<div id="main" class="container fixed-container">
				<div id="left-box" class="col_3_5">@include('user2.dashboard.left_nav')</div>
				<!--/leftbox-->
				<div id="samewidth" class="right_side">
					<div id="page-wrapper" class="nofix">
						<div class="page-header header-fixed">
							<div class="container-fluid">
								<div class="row">
									<div class="col-xs-6 col-md-6 col-sm-8 clearfix">
										<h1 class="pull-left" id="bt-s1">
											<i class="fa fa-user" aria-hidden="true"></i>
											マイページ
										</h1>
									</div>
								</div>
							</div>
						</div>
						<!--/page-header header-fixed-->
						<div id="MyPageBoard" class="container-fluid">
							<?php if (count($userErrors)) {?>
							<div class="alert-container">
								<?php foreach ($userErrors as $userError) {?>
								<div class="dashboard-warn-text">
									<div class="dashboard-must-validation">
										<i class="icon-warning-sign fa awesome"></i>
										<div class="warning-heading">{{$userError['message']}}</div>
										@if (isset($userError['url']) && $userError['url'])
										<div class="warning-msg">
											<a target="_blank" href="{{$userError['url']}}" class="dashboard-must-text-link underline">{{$userError['button']}}</a>
										</div>
										@endif
									</div>
								</div>
								<?php }?>
							</div>
							<?php }?>
							<div class="row">
								<!--booking count-->
								<div id="bt-s2" class="col-lg-3 col-md-4 col-sm-6">
									<div class="panel panel-primary">
										<div class="panel-heading">
											<div class="row">
												<div class="col-xs-3">
													<h3>予約</h3>
												</div>
												<!--/col-xs-3-->
												<div class="col-xs-9 text-right">
													<div class="huge">
														<i class="fa fa-list-alt" aria-hidden="true"></i>
														<?php echo (int)$totalCountStatus?>
													</div>
													<small>&nbsp;</small>
												</div>
												<!--/col-xs-9-->
											</div>
											<!--/row-->
										</div>
										<!--/panel-heading-->
										<div class="panel-footer data-summary">
											<div class="pane-data sts-pending">
												<span class="pull-left">処理中</span>
												<span class="pull-right count-big">
													<?php echo (int)@$aDataStatus[BOOKING_STATUS_PENDING]?>
												</span>
												<div class="clearfix"></div>
											</div>
											<div class="pane-data sts-reserved">
												<span class="pull-left">予約済み</span>
												<span class="pull-right count-big">
													<?php echo (int)@$aDataStatus[BOOKING_STATUS_RESERVED]?>
												</span>
												<div class="clearfix"></div>
											</div>
											<div class="pane-data sts-inuse">
												<span class="pull-left">利用中</span>
												<span class="pull-right count-big">
													<?php echo (int)@$aDataStatus[BOOKING_STATUS_INUSE]?>
												</span>
												<div class="clearfix"></div>
											</div>
											<div class="pane-data sts-completed">
												<span class="pull-left">完了</span>
												<span class="pull-right count-big">
													<?php echo (int)@$aDataStatus[BOOKING_STATUS_COMPLETED]?>
												</span>
												<div class="clearfix"></div>
											</div>
											<div class="pane-data sts-cacncelled">
												<span class="pull-left">キャンセル</span>
												<span class="pull-right count-big">
													<?php echo (int)@$aDataStatus[BOOKING_STATUS_REFUNDED]?>
												</span>
												<div class="clearfix"></div>
											</div>
										</div>
										<a href="/RentUser/Dashboard/Reservation">
											<div class="panel-footer">
												<span class="pull-left">詳細</span>
												<span class="pull-right">
													<i class="fa fa-chevron-circle-right"></i>
												</span>
												<div class="clearfix"></div>
											</div>
										</a>
									</div>
									<!--/panel panel-primary-->
								</div>
								<!--/col-lg-3-->
								<!--Message count-->
								<div id="bt-s3" class="col-lg-3 col-md-4 col-sm-6">
									<div class="panel panel-primary">
										<div class="panel-heading">
											<div class="row">
												<div class="col-xs-6">
													<h3>メッセージ</h3>
												</div>
												<!--/col-xs-3-->
												<div class="col-xs-6 text-right">
													<div class="huge">
														<i class="fa fa-envelope"></i>
														{{readCountTotal(Auth::guard('user2')->user()->HashCode,'User2ID')}}
													</div>
													<i class="fa fa-clock-o"></i>
													<small>2016-09-25 3:19pm</small>
												</div>
												<!--/col-xs-9-->
											</div>
											<!--/row-->
										</div>
										<!--/panel-heading-->
										<div class="panel-footer data-summary">
											<div class="pane-data msg-count unread">
												<span class="pull-left">未読</span>
												<span class="pull-right count-big">{{readCountNoti(Auth::guard('user2')->user()->HashCode,'User2ID')}}</span>
												<div class="clearfix"></div>
											</div>
											<div class="pane-data msg-count read">
												<span class="pull-left">既読</span>
												<span class="pull-right count-big">{{readCountYes(Auth::guard('user2')->user()->HashCode,'User2ID')}}</span>
												<div class="clearfix"></div>
											</div>
										</div>
										<a href="#">
											<div class="panel-footer">
												<span class="pull-left">詳細</span>
												<span class="pull-right">
													<i class="fa fa-chevron-circle-right"></i>
												</span>
												<div class="clearfix"></div>
											</div>
										</a>
									</div>
									<!--/panel panel-primary-->
								</div>
								<!--/col-lg-3-->
								<!--Offer count-->
								<div id="bt-s4" class="col-lg-3 col-md-4 col-sm-6">
									<div class="panel panel-primary">
										<div class="panel-heading">
											<div class="row">
												<div class="col-xs-6">
													<h3>オファー</h3>
												</div>
												<!--/col-xs-3-->
												<div class="col-xs-6 text-right">
													<div class="huge">
														<i class="fa fa-paper-plane-o" aria-hidden="true"></i>
														{{$oCountTotalOffer->total}}
													</div>
													<small>&nbsp;</small>
												</div>
												<!--/col-xs-9-->
											</div>
											<!--/row-->
										</div>
										<!--/panel-heading-->
										<div class="panel-footer data-summary">
											<div class="pane-data msg-count unread">
												<span class="pull-left">New</span>
												<span class="pull-right count-big">{{$oCountNewOffer->total_new}}</span>
												<div class="clearfix"></div>
											</div>
										</div>
										<a href="{{url('RentUser/Dashboard/OfferList')}}">
											<div class="panel-footer">
												<span class="pull-left">詳細</span>
												<span class="pull-right">
													<i class="fa fa-chevron-circle-right"></i>
												</span>
												<div class="clearfix"></div>
											</div>
										</a>
									</div>
									<!--/panel panel-primary-->
								</div>
								<!--/col-lg-3-->
								<!--Review count-->
								<div id="bt-s5" class="col-lg-3 col-md-4 col-sm-6">
									<div class="panel panel-primary">
										<div class="panel-heading">
											<div class="row">
												<div class="col-xs-6">
													<h3>レビュー</h3>
												</div>
												<!--/col-xs-3-->
												<div class="col-xs-6 text-right">
													<div class="huge">
														<i class="fa fa-comment-o" aria-hidden="true"></i>
														{{isset($reviews[-1]) ? count($reviews[-1]) : 0}}
													</div>
													<small>&nbsp;</small>
												</div>
												<!--/col-xs-9-->
											</div>
											<!--/row-->
										</div>
										<!--/panel-heading-->
										<div class="panel-footer data-summary">
											<div class="pane-data msg-count unread">
												<span class="pull-left">レビュー待ち</span>
												<span class="pull-right count-big">
													<!--show waiting review count-->
													<?php if (count($reviews) && isset($reviews[REVIEW_STATUS_AWAITING])) {?>
													{{count($reviews[REVIEW_STATUS_AWAITING])}}
													<?php }else {?>
													0
													<?php }?>
												</span>
												<div class="clearfix"></div>
											</div>
											<div class="pane-data msg-count read">
												<span class="pull-left">レビュー済み</span>
												<span class="pull-right count-big">
													<!--show reviewd count-->
													<?php if (count($reviews) && isset($reviews[REVIEW_STATUS_COMPLETE])) {?>
													{{count($reviews[REVIEW_STATUS_COMPLETE])}}
													<?php }else {?>
													0
													<?php }?>
												</span>
												<div class="clearfix"></div>
											</div>
										</div>
										<a href="/RentUser/Dashboard/Review">
											<div class="panel-footer">
												<span class="pull-left">詳細</span>
												<span class="pull-right">
													<i class="fa fa-chevron-circle-right"></i>
												</span>
												<div class="clearfix"></div>
											</div>
										</a>
									</div>
									<!--/panel panel-primary-->
								</div>
								<!--/col-lg-3-->
							</div>
							<!--/row-->
						</div>
						<!--/MyPageBoard-->
						<!--footer-->
						@include('pages.dashboard_user1_footer')
						<!--/footer-->
					</div>
					<!--/page-wrapper-->
				</div>
				<!--/right_side-->
			</div>
		</div>
		<!--/main-container-->
	</div>
	<!--/viewport-->
	<script>

	jQuery(function() {
		var tour = new Tour({
			  steps: [
			  {
				element: "#bt-s1",
				title: "マイページについて",
				content: "このページでは、予約状況や、新着メッセージの数など様々な現在の状況を確認することができます。"
			  }
			],
		    container: "body",
		    smartPlacement: true,
		
		});

		tour.addStep({
				element: "#bt-s2",
				placement: "auto right",
				smartPlacement: true,
				title: "予約状況",
				content: "確認待ち、予約済み、完了、キャンセルなど、現在の予約状況の数を確認できます。"
		});
		
		tour.addStep({
				element: "#bt-s3",
				placement: "auto right",
				smartPlacement: true,
				title: "メッセージ",
				content: "あなたに届いている現在のメッセージで未読数、既読数を確認できます。"
		});
		
		tour.addStep({
				element: "#bt-s4",
				placement: "auto left",
				smartPlacement: true,
				title: "オファー数",
				content: "現在あなたにオファーがきている数を確認できます。"
		});
		
		tour.addStep({
				element: "#bt-s5",
				placement: "auto right",
				smartPlacement: true,
				title: "レビュー数",
				content: "レビュー待ち、あなたに対して書かれたレビューの数を確認できます。"
		});
		
		tour.addStep({
				element: "#bt-ms1",
				placement: "auto right",
				smartPlacement: true,
				title: "マイページ",
				content: "現在のページへのリンクです。"
		});

		tour.addStep({
				element: "#bt-ms2",
				placement: "auto right",
				smartPlacement: true,
				title: "希望スペース設定",
				content: "あなたが希望するスペースを設定できるページです。設定することによって、あなたの希望するスペースのマッチングが行えます。"
		});
		
		tour.addStep({
				element: "#bt-ms3",
				placement: "auto right",
				smartPlacement: true,
				title: "予約リスト",
				content: "予約したスペースの予約詳細が確認できるページです。"
		});
		
		tour.addStep({
				element: "#bt-ms4",
				placement: "auto right",
				smartPlacement: true,
				title: "Title of my step 4",
				content: "Content of my step 4"
		});
		
		tour.addStep({
				element: "#bt-ms5",
				placement: "auto right",
				smartPlacement: true,
				title: "Title of my step 5",
				content: "Content of my step 5"
		});
		
		tour.addStep({
				element: "#bt-ms6",
				placement: "auto right",
				smartPlacement: true,
				title: "Title of my step 5",
				content: "Content of my step 5"
		});
		
		// Initialize the tour
		tour.init();
		
		// Start the tour
		tour.start();
		
  	});
</script>
</body>
</html>
