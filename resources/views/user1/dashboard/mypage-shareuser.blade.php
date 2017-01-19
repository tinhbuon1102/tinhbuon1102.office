 @include('pages.header')
<!--/head-->
<body class="mypage shareuser">
	<div class="viewport">
		<?php
		foreach($groupedReviews as $indexReview => $reviews){
	$rev[] = count($reviews);
}
?>
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
											マイページ
										</h1>
									</div>
								</div>
							</div>
						</div>
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
													<i class="fa fa-clock-o"></i>
													<small>{!!lastBookingdate(Auth::guard('user1')->user()->id)!!}</small>
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
										<a href="{{url('ShareUser/Dashboard/BookList')}}">
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
														{{readCountTotal(Auth::guard('user1')->user()->HashCode,'User1ID')}}
													</div>
												</div>
												<!--/col-xs-9-->
											</div>
											<!--/row-->
										</div>
										<!--/panel-heading-->
										<div class="panel-footer data-summary">
											<div class="pane-data msg-count unread">
												<span class="pull-left">未読</span>
												<span class="pull-right count-big">{{readCountNoti(Auth::guard('user1')->user()->HashCode,'User1ID')}}</span>
												<div class="clearfix"></div>
											</div>
											<div class="pane-data msg-count read">
												<span class="pull-left">既読</span>
												<span class="pull-right count-big">{{readCountYes(Auth::guard('user1')->user()->HashCode,'User1ID')}}</span>
												<div class="clearfix"></div>
											</div>
										</div>
										<a href="{{url('ShareUser/Dashboard/Message')}}">
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
								<!--Space count-->
								<div id="bt-s5" class="col-lg-3 col-md-4 col-sm-6">
									<div class="panel panel-primary">
										<div class="panel-heading">
											<div class="row">
												<div class="col-xs-6">
													<h3>スペース</h3>
												</div>
												<!--/col-xs-3-->
												<div class="col-xs-6 text-right">
													<div class="huge">
														<i class="fa fa-building" aria-hidden="true"></i>
														{{$total_spaces}}
													</div>
													<small>&nbsp;</small>
												</div>
												<!--/col-xs-9-->
											</div>
											<!--/row-->
										</div>
										<!--/panel-heading-->
										<div class="panel-footer data-summary">
											<div class="pane-data sts-space sts-publish">
												<span class="pull-left">公開済み</span>
												<span class="pull-right count-big">
													<!--publish count-->
													{{$public_spaces}}
												</span>
												<div class="clearfix"></div>
											</div>
											<div class="pane-data sts-space sts-private">
												<span class="pull-left">非公開</span>
												<span class="pull-right count-big">
													<!--private count-->
													{{$private_spaces}}
												</span>
												<div class="clearfix"></div>
											</div>
											<div class="pane-data sts-space sts-draft">
												<span class="pull-left">下書き</span>
												<span class="pull-right count-big">
													<!--draft count-->
													{{$draft_spaces}}
												</span>
												<div class="clearfix"></div>
											</div>
										</div>
										<a href="{{url('ShareUser/Dashboard/MySpace/List1')}}">
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
								<!--Favourite count-->
								<div id="bt-s6" class="col-lg-3 col-md-4 col-sm-6">
									<div class="panel panel-primary">
										<div class="panel-heading">
											<div class="row">
												<div class="col-xs-6">
													<h3>お気に入り</h3>
												</div>
												<!--/col-xs-3-->
												<div class="col-xs-6 text-right">
													<div class="huge">
														<i class="fa fa-star" aria-hidden="true"></i>
														{{$fav_cnt}}
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
												<span class="pull-right count-big">{{$newFav}}</span>
												<div class="clearfix"></div>
											</div>
										</div>
										<a href="#" class="disablelink">
											<div class="panel-footer">
												
												<div class="clearfix"></div>
											</div>
										</a>
									</div>
									<!--/panel panel-primary-->
								</div>
								<!--/col-lg-3-->
								<!--Review count-->
								<div id="bt-s7" class="col-lg-3 col-md-4 col-sm-6">
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
														<?php if(isset($rev[0])) echo $rev[0]; else echo "0"; ?>
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
													<?php if(isset($rev[1])) echo $rev[1]; else echo "0"; ?>
												</span>
												<div class="clearfix"></div>
											</div>
											<div class="pane-data msg-count read">
												<span class="pull-left">レビュー済み</span>
												<span class="pull-right count-big">
													<?php if(isset($rev[2])) echo $rev[2]; else echo "0"; ?>
												</span>
												<div class="clearfix"></div>
											</div>
										</div>
										<a href="{{url('ShareUser/Dashboard/Review')}}">
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
						<!--/container-fluid-->
					</div>
					<!--/#page-wrapper-->
					<!--footer-->
					@include('pages.dashboard_user1_footer')
					<!--/footer-->
				</div>
			</div>
		</div>
		<!--/main-container-->
		</div><!--/#containers-->
	</div>
	<!--/viewport-->
	<script>
	jQuery(function() {
    	jQuery( "#tabs" ).tabs();
		
		/*jQuery(".nvOpn").click( function(){
			jQuery(this).toggleClass("actv");
			jQuery(".primary-navigation").toggle();
			jQuery("nav").toggle();
			jQuery("body, #left-box").toggleClass("navon");
			jQuery(".header_wrapper").toggleClass("navonh");
		});
		
		jQuery(".navonin").click( function(){
			jQuery("nav").hide();
			jQuery(".nvOpn").click();
			jQuery("body, #left-box").removeClass("navon");
			jQuery(".header_wrapper").removeClass("navonh");
		});*/
		
		
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
		    template: "<div class='popover tour'>" + 
	        "<div class='arrow'></div>" +
	        "<h3 class='popover-title'></h3>" +
	        "<div class='popover-content'></div>" +
	        "<div class='popover-navigation'> " +
		        "<div class='btn-group'> " +
			        "<button class='btn btn-sm btn-default disabled' data-role='prev' disabled='' tabindex='-1'>« 前へ</button>" + 
			        "<button class='btn btn-sm btn-default' data-role='next'>次へ »</button>  " +
		        "</div> " +
		        "<button class='btn btn-sm btn-default' data-role='end'>ガイドを終了</button>" + 
	        "</div>",
		});

		tour.addStep({
				element: "#bt-s2",
				placement: "auto right",
				smartPlacement: true,
				title: "予約状況",
				content: "確認待ち、予約済み、完了、キャンセルなど、あなたのスペースへの予約状況の数を確認できます。"
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
				title: "お気に入り",
				content: "現在あなたの全てのスペースにされているお気に入り数を確認できます。"
		});
		
		tour.addStep({
				element: "#bt-s5",
				placement: "auto right",
				smartPlacement: true,
				title: "スペース",
				content: "現在あなたが登録しているスペースの数を確認できます。"
		});
		
		tour.addStep({
				element: "#bt-s6",
				placement: "auto right",
				smartPlacement: true,
				title: "お気に入り",
				content: "現在あなたの全てのスペースにされているお気に入り数を確認できます。"
		});
		
		tour.addStep({
				element: "#bt-s7",
				placement: "auto left",
				smartPlacement: true,
				title: "レビュー数",
				content: "レビュー待ち、あなたに対して書かれたレビューの数を確認できます。"
		});
		
		tour.addStep({
				element: "#bt-ms1",
				placement: "auto right",
				smartPlacement: true,
				title: "Title of my step 1",
				content: "Content of my step 1"
		});

		tour.addStep({
				element: "#bt-ms2",
				placement: "auto right",
				smartPlacement: true,
				title: "Title of my step 2",
				content: "Content of my step 2"
		});
		
		tour.addStep({
				element: "#bt-ms3",
				placement: "auto right",
				smartPlacement: true,
				title: "Title of my step 3",
				content: "Content of my step 3"
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
