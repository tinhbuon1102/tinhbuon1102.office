
<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header.php'); ?>
@include('pages.header')

<!--/head-->
<link rel="stylesheet" href="{{url('/')}}/js/chosen/chosen.min.css">
<link rel="stylesheet" type='text/css' href="<?php echo SITE_URL?>css/select2.min.css">
<script src="{{ URL::asset('js/jquery.responsiveTabs.js') }}"></script>
<body class="mypage">
	<div class="viewport">
		<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header_nav_shareuser.php'); ?>
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
<h1 class="pull-left" id="bt-s1"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> レビュー</h1>
</div>
</div>
</div>
</div>
				<div id="feed">
					<?php echo renderErrorSuccessHtml($errors);?>
					<section class="review-content feed-box">
						<?php if (count($groupedReviews)) {?>
						<div id="reviews_tabs_wraper" style="opacity: 0;">
							<ul class="clearfix">
								<?php $countGroup = 0;?>
								@foreach($groupedReviews as $indexReview => $reviews)
								<li>
									<a href="#tab-{{$countGroup}}">
										{{getReviewTabName($indexReview)}}
										<span class="count">({{count($reviews)}})</span>
									</a>
								</li>
								<?php $countGroup++?>
								@endforeach
							</ul>


							<?php $countGroup = 0;?>
							@foreach($groupedReviews as $reviews)
							<div id="tab-{{$countGroup}}" class="review_horizontal_wraper">
								<ul class="user-reviews ng-scope">
									@foreach($reviews as $review)
									<?php if ($review instanceof App\Userreview) {
										$space = $review->space;
										$booking = $review->booking;
										$user2 = $review->user2;
									}elseif ($review instanceof App\Rentbookingsave) {
										$space = $review->spaceID;
										$booking = $review;
										$user2 = $review->rentUser;
									}
									?>
									
									<li class="user-review ng-scope">
                                    <div class="tb-wp">
										<div class="col-sm-2">
											<a href="{{getUser2ProfileUrl($user2)}}">
												<img src="{{getUser2Photo($user2)}}" class="user-review-space-img" />
											</a>
										</div>
										
										<div class="col-sm-8">
											<a href="{{getUser2ProfileUrl($user2)}}" target="_blank" class="user-review-link-title">{{getUserName($user2)}}</a>
											<div class="booking-id">
												<span class="booking-id-text">{{trans('reviews.review_booking_id')}}</span>
												<span class="booking-id-value">{{$booking->id}}</span>
											</div>
											@if($review instanceof App\Userreview)
												{{showStarReview($review, false)}}
											@endif
											<span class="user-review-price ng-binding">
												<span class="paid-amount">¥{{priceConvert($booking->amount)}}</span>
											</span>
											<span class="user-review-duration ng-binding">
												<span class="duration-amount">{{$booking->DurationText}}</span>
											</span>
											<div class="space-name">
												<a target="_blank" href="{{getSpaceUrl($space->HashID)}}">
													{{$space->Title}}
												</a>
											</div>
											<?php if ($review instanceof App\Userreview) {?>
											<p class="review-comment">
												@if($review->Status == 0 && $review->ReviewedBy == 'User2')
													<a href="{{getUser2ProfileUrl($user2)}}"><span class="no-review">{{getUserName($user2)}}があなたにレビューを投稿しました。</span></a>
												@endif
												@if($review->Comment)
													<span style="display:block" class=" <?php echo ($review->ReviewedBy == 'User2' ? 'partner-comment' : 'owner-comment')?>">{{$review->Comment}}</span>
												@endif
											</p>
											<?php }?>
										</div>
                                        </div>
										
										<div class="col-sm-2">
											@if(($review->Status == 0 && $review->ReviewedBy == 'User2') || $review instanceof App\Rentbookingsave)
											<a href="<?php echo url('/ShareUser/Dashboard/Review/Write/' . $booking['id'])?>" class="btn yellow-button review-btn">
												<i class="fa fa-pencil" aria-hidden="true"></i>
												レビューを書く
											</a>
											@endif
										</div>
									</li>
									@endforeach
								</ul>
							</div>
							<?php $countGroup++?>
							@endforeach
						</div>
						<?php } else{?>
						<div class="no-result">データはありません</div>
						<?php }?>
					</section>
				</div>
				<!--/feed-->
</div>
<!--footer-->
		<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/common_footer.php'); ?>
		@include('pages.common_footer')

		<!--/footer-->
</div>
			</div>
		</div>
		<!--/main-container-->
		
	</div>
	<!--/viewport-->
	<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script> -->

	<script src="<?php echo SITE_URL?>js/chosen/chosen.jquery.min.js" type="text/javascript"></script>
	<script src="<?php echo SITE_URL?>js/chosen/chosen.proto.min.js" type="text/javascript"></script>
	<script src="<?php echo SITE_URL?>js/chosen/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?php echo SITE_URL?>js/address_select.js" type="text/javascript"></script>

	<script src="<?php echo SITE_URL?>js/select2.full.min.js"></script>

	<script type="text/javascript">
/*var config = {
      '.chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }*/

    
  </script>

	<script>
jQuery(function(){
    jQuery('#state-select').select2({
                    multiple:true
    });
    // 全ての駅名を非表示にする
    jQuery(".budget-price").addClass('hide');
    // 路線のプルダウンが変更されたら
    jQuery("#choose_budget_per").change(function(){
        // 全ての駅名を非表示にする
        jQuery(".budget-price").addClass('hide');
        // 選択された路線に連動した駅名プルダウンを表示する
        jQuery('#' + $("#choose_budget_per option:selected").attr("class")).removeClass("hide");
    });
})
jQuery(".input-container.iconbutton").click(function(){
  jQuery(this).toggleClass("checked");
});
</script>
</body>
</html>
