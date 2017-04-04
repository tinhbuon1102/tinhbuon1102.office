 @include('pages.header')
<script src="{{ URL::asset('js/jquery.infinitescroll.min.js') }}"></script>
<!--/head-->
<?php
$userPercent = calculateUserProfilePercent($user, 1);
$rentBooking = new \App\Rentbookingsave();
?>
<body class="dashboard">
	<div class="viewport">
		@include('pages.header_nav_shareuser')
		<div class="main-container">
			<div id="main" class="container">
				<?php echo renderErrorSuccessHtml(@$errors);?>
				<div class="row flex-wrapper">
					<div id="feed" class="col-xs-8">
						<?php if (!\App\User1::isProfileFullFill($user) ||  !count($user->spaces)) {?>
						<section class="messenger-null-state-message feed-box">
							<h3 class="steps-banner-title">セットアップを完了させましょう</h3>
							<p class="steps-banner-explanation">
								<span data-bind="text: CompanyName">
									<?php echo $user['NameOfCompany']?>
								</span>
								様、hOur Officeへようこそ。
								<br />
								以下の3ステップでスペースシェアを始めましょう。
							</p>
							<ul class="steps-banner-list">
								<li class="steps-banner-item">
									<span class="steps-banner-item-image"></span>
									<span class="steps-banner-item-text">
										<a href="{{url('ShareUser/Dashboard/HostSetting')}}"><i class="fa fa-wrench" aria-hidden="true"></i>アカウントをセットアップ</a>
									</span>
								</li>
								<li class="steps-banner-item">
									<span class="steps-banner-item-image step-2"></span>
									<span class="steps-banner-item-text">
										<a href="{{url('ShareUser/Dashboard/MySpace/List1')}}"><i class="fa fa-building" aria-hidden="true"></i>スペースを登録</a>
									</span>
								</li>
								<li class="steps-banner-item">
									<span class="steps-banner-item-image  step-3"></span>
									<span class="steps-banner-item-text">
										<a href="{{url('ShareUser/Dashboard/MySpace/Calendar')}}"><i class="fa fa-calendar-plus-o" aria-hidden="true"></i>スケジュールを設定</a>
									</span>
								</li>
							</ul>
						</section>
						<?php }?>
						<?php if (count($user2s)) {?>
						<section class="recent-matched-space feed-box">
							<div class="dashboard-section-heading-container">
								<h3 class="dashboard-section-heading">
									<a href="javascript:void(0);">
										あなたにオススメのユーザー
										<!--Recommended User for you-->
									</a>
								</h3>
								<a href="{{url('ShareUser/Dashboard/RecommendUser')}}" class="recommend-office-cta-link">全て見る</a>
							</div>
							<!--show recommend office which are matched with user requirement condition-->
							<ul class="reccomend-list user-list clearfix offer-lists">
								<?php foreach ($user2s as $user2) {?>
								<li class="list-item" data-id="{{$user2->id}}">
									<div class="user-list-wrapper">
										<div class="user-info user-list-inner">
											<div class="profile-pic-wrapper">
												<span class="profile-pic">
													<a href="{{getUser2ProfileUrl($user2)}}" class="link_user">
														<img src="{{getUser2Photo($user2)}}" />
													</a>
												</span>
											</div>
											<?php 
											$notification = \App\Notification::isOfferedSpace($user, $user2);

											$offered = false;
											$offeredClass = '';
											if ($notification)
											{
												$offered = true;
												$offeredClass = 'offered';
											}?>
											<div class="offer-btn-container rfloat follow-button">
												<a href="#" class="btn offer_btn {{$offeredClass}} dyw-button">
													<i class="fa fa-paper-plane-o" aria-hidden="true"></i>
													<span class="offer-btn-text">
														<?php echo $offered ? 'オファー済み' : 'オファーする'?>
													</span>
												</a>
											</div>
											<h3 class="user-name">
												<a href="{{getUser2ProfileUrl($user2)}}" class="link_user">{{getUser2Name($user2)}}</a>
											</h3>
											<?php echo showStarReview($user2->reviews);?>
											<div id="profile-about-description-wrapper" class="user-about-description-wrapper">
												<div class="job">
													<!--label-->
													<span class="job-label">職種：</span>
													<!--/label-->
													{{$user2->BusinessType}}
												</div>
												<!--job-->
                                                <div class="skill">
													<!--label-->
													<span class="job-label">スキル：</span>
													<!--/label-->
													{{$user2->Skills}}
												</div>
												<!--job-->
												<?php if ($user2->BusinessSummary) {?>
												<p ng-hide="isActive" class="profile-about-description excerpt ng-binding ng-scope">
													<span class="full_text read_more_text" style="display: none;">
														<?php echo nl2br($user2->BusinessSummary); ?>
													</span>
													<span class="short_text read_more_text">
														<?php echo nl2br(str_limit($user2->BusinessSummary, 150, '...')); ?>
													</span>
													<a href="javascript:void(0);" class="read_more read_more_button">もっと読む</a>
													<a href="javascript:void(0);" class="read_less read_more_button" style="display: none;">閉じる</a>
												</p>
												<?php }?>
											</div>
											<!--/profile-about-description-wrapper-->
										</div>
										<!--/user-info-->
									</div>
									<!--/user-list-wrapper-->
								</li>
								<?php }?>
							</ul>
						</section>
						<?php }?>
						<section class="feed-event recent-follow feed-box">
							<div class="dashboard-section-heading-container">
								<h3 class="dashboard-section-heading">
									<a href="#">あなたへのお知らせ</a>
								</h3>
							</div>
							<ul id="news-feed-list" class="transitions-enabled infinite-scroll">
								<!--loop when payment is pre-sale alert-->
								@if( empty($bank['BankName']) OR !count($user->certificates) OR !\App\User1::isProfileFullFill($user)) 
                                <li class="feed">
	<div class="news-feed-wrapper">
		<div class="first-notice">
        <h2><i class="fa fa-wrench" aria-hidden="true"></i>アカウントをセットアップしましょう</h2>
        <p class="intro">あなたのアカウント制限を外すには、以下の設定が必要です。アカウントが制限されている間は、スペース掲載、チャット機能、オファー機能が使えません。今すぐセットアップを完了させましょう！</p>
        <ol class="feed-steps">
        <?php if (!\App\User1::isProfileFullFill($user)){?>
        <li><strong>アカウント情報設定</strong><br/><span>必須のアカウント情報がまだ設定されていません。</span><a href="{{url('ShareUser/Dashboard/HostSetting')}}" class="btn-info btn">アカウント設定</a></li>
        <?php }?>
	@if( empty($bank['BankName']) ) 
		<li><strong>振込先情報の登録</strong><br/><span>売上の受取先となる口座情報を登録してください。</span><a href="{{url('ShareUser/Dashboard/HostSetting#BankLink')}}" class="btn-info btn">口座情報登録</a></li>@endif
	@if( !count($user->certificates) )
		<li><strong>組織・個人証明書の提出</strong><br/><span>アカウント、掲載の不正を防ぐため、組織・個人証明書の提出が必須です。提出後、2~3営業日にて審査が完了します。</span><a href="{{url('ShareUser/Dashboard/HostSetting/Certificate')}}" class="btn-info btn">証明書の提出</a></li>
	@endif
    </ol>
    </div>
        </div>
        </li>
@endif
@if( $spaces->count() < 1 )
<li class="feed">
	<div class="news-feed-wrapper">
		<div class="first-notice">
        <h2><i class="fa fa-building" aria-hidden="true"></i>スペースを追加しましょう</h2>
        <p class="intro">スペースがまだ登録されていません。スペースを登録して、今すぐスペースを掲載しましょう！</p>
    <div class="alert alert-no-space">
    <div class="no-space-show">
                            <div class="side-icon"><i class="fa fa-building" aria-hidden="true"></i></div>
                            <div class="left-disc">
                            <h1><i class="fa fa-exclamation-circle" aria-hidden="true"></i>まだスペースが登録されてません</h1>
                            <a href="{{url('ShareUser/Dashboard/ShareInfo')}}" class="yellow-button btn add-space-btn">スペースを追加</a>
                            </div>
                            </div>
                            </div>
        </div>
        </div>
        </li>
        @endif
        <!--/loop  when payment is pre-sale alert-->
								@include('user1.dashboard.dashboard-shareuser-feed')
							</ul>
							<div class="dashboard-pagination" id="dashboard-pagination">
								<div class="ns_pagination">{{ $user->paginator->links() }}</div>
							</div>
						</section>
					</div>
					<!--/feed-->
					<div id="right-box" class="col-xs-4">
						<div class="newsfeed-right-content">
							<div class="user-details-wrap">
								<div class="user-details feed-box">
									<figure class="ImageThumbnail ImageThumbnail--xlarge PageDashboard-avatar company-logo-thumbnail online">
										<a class="ImageThumbnail-link" target="_blank" href="{{getUser1ProfileUrl($user)}}" title="View Profile">
											<img class="ImageThumbnail-image" src="{{getUser1Photo($user)}}" alt="Profile Picture">
										</a>
									</figure>
									<div class="welcome-note">
										<h4 class="user-details-title">
											あなたのアカウント
											<br>
											<em>
												<a class="user-details-username" target="_blank" href="/ShareUser/HostProfile/View/<?php echo $user['HashCode']?>">
													<?php echo $user['NameOfCompany']?>
												</a>
											</em>
											<!--<span class="publish-status unpublish">未公開</span>-->
											<!--if published<span class="publish-status published">公開中</span>-->
										</h4>
										<a href="{{url('ShareUser/Dashboard/HostSetting')}}" class="btn btn-profile btn-small user-details-edit-btn gry-btn">編集する</a>
										<div class="user-profile-account-progress">
											<h5>プロフィール完成度</h5>
											<span class="current_profile_percent">
												完成度：{{$userPercent}}%
												<!--<span class="access <?php //echo $userPercent < 100 ? 'not-completed' : ''?>">complete</span>-->
											</span>
											<div class="progress progress-info user-profile-account-progress-bar">
												<div class="bar" style="width: {{$userPercent}}%;"></div>
											</div>
											<?php if (!IsAdminApprovedUser($user)) {?>
											<p class="caution"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                            @if( !count($user->certificates) OR empty($bank['BankName']) OR !\App\User1::isProfileFullFill($user) )
                                            <span>以下の項目を設定していない為、現在アカウントは制限されています。</span>
                                            @endif
                                            <?php if($user->SentToAdmin) {?>
                                            <span>審査中の為、現在アカウントは制限されています。</span>
                                            <?php }?>
                                            </p>
											<?php }?>
											<!--start alert for some setting-->
											<!--show if email validation is not done-->
                                            
											@if( !IsEmailVerified($user))
											<p class="user-profile-progress-suggestion">
												<a href="{{url('ShareUser/Dashboard/HostSetting')}}">メールアドレス認証</a>
											</p>
											@endif
                                            <?php if (!\App\User1::isProfileFullFill($user)){?>
                                            <p class="user-profile-progress-suggestion must-alert">
											<a href="{{url('ShareUser/Dashboard/HostSetting')}}"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>アカウント情報設定</a>
											</p>
                                            <?php }?>
											<!--show if bank account is not set-->
											@if( empty($bank['BankName']) )
											<p class="user-profile-progress-suggestion must-alert">
												<a href="{{url('ShareUser/Dashboard/HostSetting#BankLink')}}"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>振込先情報登録</a>
											</p>
											@endif
											<!--show if space is not added-->
											@if( $spaces->count() < 1 )
											<p class="user-profile-progress-suggestion must-alert">
												<a href="{{url('ShareUser/Dashboard/ShareInfo')}}"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>スペース登録</a>
											</p>
											@endif
                                            <!--show if document is not send-->
											@if( !count($user->certificates) )
											<p class="user-profile-progress-suggestion must-alert">
												<a href="{{url('ShareUser/Dashboard/HostSetting/Certificate')}}"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>組織・個人証明書の提出</a>
											</p>
											@endif
											@if( $user->BusinessTitle == “” )
											<p class="user-profile-progress-suggestion">
												<a href="{{url('ShareUser/Dashboard/HostSetting')}}"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>アカウント責任者の役職情報</a>
											</p>
											@endif
											<!--end alert for some setting-->
										</div>
									</div>
								</div>
								<!--/feed-nbox-->
							</div>
							<!--/user-details-wrap-->
							<?php if (count($bookingHistories)) {?>
							<div class="user-history-wrap">
								<div class="user-rent-history feed-box">
									<h3>
										予約履歴
										<!--Latest Booking History-->
									</h3>
									<!--show history of rent space-->
									<div class="slimScrollDiv">
										<ul id="rent-history" class="small-rent-history">
											<!--loop rent history-->
											<?php foreach ($bookingHistories as $bookingHistory) {
												$slots = $rentBooking->getBookedSlots($bookingHistory);
												if (!count($slots)) continue;
													
												$startEndBooking = $rentBooking->getStartEndBooking($slots);
													
												$historyClass = '';
												switch ($bookingHistory->status) {
													case BOOKING_STATUS_PENDING :
														$dateUse = $startEndBooking['StartDate'];
														if ($dateUse < date('Y-m-d H:i:s')){
														$historyClass = 'willuse';
														$dateText = '利用予定';
													}
													else {
														$historyClass = 'in-use';
														$dateText = '処理中';
													}

													break;
													case BOOKING_STATUS_RESERVED :
														$historyClass = 'willuse';
														$dateUse = $startEndBooking['StartDate'];
														$dateText = '利用予定';
														break;
													case BOOKING_STATUS_REFUNDED :
														$historyClass = 'cancelled';
														$dateUse = $bookingHistory->updated_at;
														$dateText = 'キャンセル';
														break;
													case BOOKING_STATUS_CALCELLED :
														$historyClass = 'cancelled';
														$dateUse = $bookingHistory->updated_at;
														$dateText = 'キャンセル';
														break;
													case BOOKING_STATUS_COMPLETED :
														$historyClass = 'used';
														$dateUse = $startEndBooking['EndDate'];
														$dateText = '完了';
														break;
													case BOOKING_STATUS_NON_REFUNDABLE :
														$historyClass = '';
														$dateUse = $startEndBooking['EndDate'];
														$dateText = 'None Refundable';
														break;
													default:
														$historyClass = '';
														$dateUse = '';
														$dateText = '';
														break;
											}
											?>
											<!--start if booking is reserved-->
											<li>
												<p class="trunc">
													<a href="{{getSharedBookingDetailUrl($bookingHistory->id)}}">予約番号: #{{$bookingHistory->id}} - {{$bookingHistory->bookedSpace->Title}}</a>
													<!--name of office space-->
												</p>
												<p>
													<!--will rent label-->
													<span class="status {{$historyClass}} label">
														{{getBookingStatus($bookingHistory)}}
														<!--利用予定-->
													</span>
													<!--/will rent label-->
													<span class="thedate">
														<!--start date-->
														{{renderHumanTime($dateUse)}}
														<!--/start date-->
														&nbsp;
														<!--will rent text-->
														{{$dateText}}
														<!--/will rent text-->
													</span>
												</p>
											</li>
											<!--end if booking is reserved-->
											<?php }?>
											<!--/loop rent history-->
										</ul>
									</div>
									<!--/slimScrollDiv-->
									<a href="{{getRentBookingListUrl()}}" class="btn btn-info btn-mini">全て見る</a>
								</div>
								<!--/feed-nbox-->
							</div>
							<?php }?>
							<!--/user-history-wrap-->
						</div>
						<!--/right-content-->
					</div>
					<!--/rightbox-->
				</div>
				<!--/row-->
			</div>
		</div>
		<!--/main-container-->
		<!--footer-->
		@include('pages.common_footer')
		<!--/footer-->
	</div>
	<!--/viewport-->
	<?php renderOfferPopup($user);?>
	<script>
      jQuery(function($){

      		$('body').on('click', '.multiple-offer .btn.show-hide', function(e){
          		e.preventDefault();
          		$currentText = $(this).text();
          		$(this).text($(this).attr('data-showHide'));
          		$(this).attr('data-showHide', $currentText);
          		$(this).closest('.multiple-offer').find('.noti-number-hide').toggle();
          	})

          	$('body').on('click', '.profile-about-description .read_more_button', function(e){
          		e.preventDefault();
          		$(this).closest('.profile-about-description').find('.read_more_text').toggle();
          		$(this).closest('.profile-about-description').find('.read_more_button').toggle();
          		
          	})

          	$('#news-feed-list').infinitescroll({
                navSelector  : '#dashboard-pagination .pagination',    // selector for the paged navigation 
                nextSelector : '#dashboard-pagination .pagination a',  // selector for the NEXT link (to page 2)
                itemSelector : 'li.feed',     // selector for all items you'll retrieve
                extraScrollPx: 250,  
                loading: {
                	finishedMsg: '負荷がかかりません。',
                    msgText: '<em>もっと読み込んでいます。</em>',
                    img: '{{url("images/loading.gif")}}'
                  }
                },
                // trigger Masonry as a callback
                function( newElements ) {
                }
              );
      });
    </script>
</body>
</html>
