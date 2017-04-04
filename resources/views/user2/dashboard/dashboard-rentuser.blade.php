
@include('pages.header')
<!--/head-->
<script src="{{ URL::asset('js/jquery.infinitescroll.min.js') }}"></script>
<?php 
$userPercent = calculateUserProfilePercent($user, 2);
$rentBooking = new \App\Rentbookingsave();
?>
<body class="dashboard">
	<div class="viewport">
		@include('pages.header_nav_rentuser')
		<div class="main-container">
			<div id="main" class="container">
			<?php echo renderErrorSuccessHtml(@$errors);?>
            <div class="row flex-wrapper">
				<div id="feed" class="col-xs-8">
				<?php if (!\App\User2::isProfileFullFill($user) ||  !$user->Logo || !$user->BusinessSummary) {?>
                	<section class="messenger-null-state-message feed-box">
						<h3 class="steps-banner-title">セットアップを完了させましょう</h3>
						<p class="steps-banner-explanation">
							<span data-bind="text: CompanyName">
								{{getUserName($user)}}
							</span>
							様、hOur Officeへようこそ。
							<br />
							以下の3ステップでオフィススペースの利用を始めましょう。
						</p>
						<ul class="steps-banner-list">
							<li class="steps-banner-item">
								<span class="steps-banner-item-image"></span>
								<span class="steps-banner-item-text">
									<a href="{{url('ShareUser/Dashboard/HostSetting')}}">アカウントをセットアップ</a>
								</span>
							</li>
							<li class="steps-banner-item">
								<span class="steps-banner-item-image step-2"></span>
								<span class="steps-banner-item-text">
									<a href="{{url('ShareUser/Dashboard/MySpace/List1')}}">プロフィールページ作成</a>
								</span>
							</li>
							<li class="steps-banner-item">
								<span class="steps-banner-item-image  step-3"></span>
								<span class="steps-banner-item-text">
									<a href="{{url('ShareUser/Dashboard/MySpace/Calendar')}}">オフィススペースを探す</a>
								</span>
							</li>
						</ul>
					</section>
					<?php }?>
					<?php if (count($user1Space)) {?>
					<section class="recent-matched-space feed-box">
						<div class="dashboard-section-heading-container">
							<h3 class="dashboard-section-heading">
								<a href="#">あなたにオススメのオフィス</a>
							</h3>
							<!--<a href="#" class="recommend-office-cta-link">全て見る</a>-->
						</div>
						<!--show recommend office which are matched with user requirement condition-->
						<div class="reccomend-list space-list clearfix">
							<?php 
							$countSpace = 0;
							foreach ($user1Space as $space) {
								$countSpace ++;
								if ($countSpace > 2) break;
								$space->spaceImage = $space->spaceImage[0];
								if (isset($space->spaceImage) && isset($space->spaceImage['ThumbPath']) && file_exists(public_path() . $space->spaceImage['ThumbPath'])) 
									$spacethumb = $space->spaceImage['ThumbPath'];
								else $spacethumb = '';
?>
								<div class="list-item">
									<div class="sp01" <?php if ($spacethumb) echo 'style="background: url('. $spacethumb .');background-size: cover;background-position: center bottom;"' ?>>
										<a href="<?php echo getSpaceUrl($space['HashID']) ;?>" class="link_space">
											<span class="space-label">
												<span class="area-left">
													{{ str_limit($space['Title'], 30, '...') }}
													<!--district name-->
												</span>
												<span class="price-right">
													¥
													<strong class="price-label">
														<?php echo getPrice($space);?>
														<!--price-->
													</strong>
													<!--per day or week or month-->
												</span>
											</span>
										</a>
									</div>
								</div>
							<?php }?>
						</div>
					</section>
					<?php }?>
					<section class="feed-event recent-follow feed-box">
						<div class="dashboard-section-heading-container">
							<h3 class="dashboard-section-heading">
								<a href="#">あなたへのお知らせ</a>
							</h3>
						</div>
						<ul id="news-feed-list" class="transitions-enabled infinite-scroll">
                        
                      @if( empty($user->card_name) && empty($paypalStatus) || !count($user->certificates)) 
                                <li class="feed">
	<div class="news-feed-wrapper">
		<div class="first-notice">
        <h2><i class="fa fa-wrench" aria-hidden="true"></i>アカウントをセットアップしましょう</h2>
        <p class="intro p-md">あなたのアカウント制限を外すには、以下の設定が必要です。</p>
        <ol class="feed-steps">
       
<?php if (!\App\User2::isProfileFullFill($user)){?>
        <li><strong>アカウント情報の設定</strong><br/><span>必須のアカウント情報の項目が未設定です。</span><a href="{{url('RentUser/Dashboard/BasicInfo/Edit')}}" class="btn-info btn">アカウント情報設定</a></li><?php }?>
	@if(empty($user->card_name) && empty($paypalStatus) )
		<li><strong>支払い方法の登録</strong><br/><span>予約時の決済に使用する支払い方法を登録してください。</span><a href="{{url('RentUser/Dashboard/BasicInfo/Edit')}}" class="btn-info btn">支払方法登録</a></li>@endif
	@if( !count($user->certificates) || !$user->SentToAdmin)
		<li><strong>本人確認書類の提出</strong><br/><span>サービス利用の不正を防ぐため、組織・個人証明書の提出が必須です。提出後、2~3営業日にて審査が完了します。</span><a href="{{url('RentUser/Dashboard/Identify/Upload')}}" class="btn-info btn">証明書の提出</a></li>
	@endif
    </ol>
    <div class="dashboard-warn-text">
    <p class="mgb-10"><strong>現在制限されている機能</strong></p>
        <!--あなたのアカウント制限を外すには、以下の設定が必要です。アカウントが制限されている間は、スペース予約、プロフィールページの公開、チャット機能、お気に入り保存機能が使えません。今すぐセットアップを完了させましょう！-->
        <ol class="list-style-normal">
        <li><i class="fa fa-minus-circle" aria-hidden="true"></i>スペース予約</li>
        <li><i class="fa fa-minus-circle" aria-hidden="true"></i>プロフィールページの公開</li>
        <li><i class="fa fa-minus-circle" aria-hidden="true"></i>チャット機能</li>
        </ol>
        </div>
    </div>
        </div>
        </li>
        @else
        <?php if (!count($bookingHistories)) {?>
                        <li class="feed no-border">
                        <div class="news-feed-wrapper">
                        <div class="first-notice no_book_notice">
                        <div class="text-center">
                        <h2>スペースを探しましょう</h2>
                        <i class="icon-offispo-icon-07 icon--xl block icon--light"></i>
                        <p class="intro">あなたのオフィススペースを探しましょう。</p>
                        <p><a href="{{url('RentUser/Dashboard/SearchSpaces')}}" class="btn-info btn">スペースを探す</a></p>
                        <hr>
                        <p class="mb0"><a href="{{url('help/rentuser')}}" class="color-link">hOur Officeについてもっと学ぶ</a></p>
                        </div>
                        </div>
                        </div>
                        </li>
                        <?php }?>
@endif
                        
							@include('user2.dashboard.dashboard-rentuser-feed')
						</ul>
						<div class="dashboard-pagination" id="dashboard-pagination">
							<div class="ns_pagination">{{  $user->paginator->links() }}</div>
                    	</div>
					</section>
				</div>
				<!--/feed-->
				<div id="right-box" class="col-xs-4">
					<div class="newsfeed-right-content">
						<div class="user-details-wrap">
							<div class="user-details feed-box">
								<figure class="ImageThumbnail ImageThumbnail--xlarge PageDashboard-avatar online">
									<a class="ImageThumbnail-link" href="{{url('RentUser/Dashboard/MyProfile')}}" title="View Profile">
										<img class="ImageThumbnail-image" src="{{getUser2Photo($user)}}" alt="Profile Picture">
									</a>
								</figure>
								<div class="welcome-note">
									<h4 class="user-details-title">
										あなたのアカウント
										<br>
										<em>
											<a class="user-details-username" href="{{getUser2ProfileUrl($user)}}">{{getUserName($user)}}</a>
										</em>
									</h4>
									<a href="{{url('/RentUser/Dashboard/BasicInfo/Edit')}}" class="btn btn-profile btn-small user-details-edit-btn gry-btn">編集する</a>
									<!--show if identification procedure is not done-->
									<?php if (!$user->SentToAdmin) {?>
									<!--<div class="clear dashboard-must-validation">
										<h5 class="dashboard-warn-text">
											本人確認手続きが完了していません。
											<br />
											<a href="{{url('/RentUser/Dashboard/Identify/Upload')}}" class="dashboard-must-text-link underline">本人確認手続きを行う</a>
										</h5>
									</div>-->
									<?php }?>
									<!--/if identification procedure is not done-->
                                    
									<div class="user-profile-account-progress">
										<h5>プロフィール完成度</h5>
                                        <span class="current_profile_percent">
                                        完成度：{{$userPercent}}%
												<!--<span class="access <?php //echo $userPercent < 100 ? 'not-completed' : ''?>">complete</span>-->
                                        </span>
										<div class="progress progress-info user-profile-account-progress-bar">
											<div class="bar" style="width: {{$userPercent}}%;">
												
											</div>
										</div>
                                        <?php if($user->SentToAdmin && !IsAdminApprovedUser($user) ) {?>
                                         <p class="caution"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                            <span>審査中の為、現在アカウントは制限されています。</span>
                                            </p>
                                            <?php }?>
										<?php if (!\App\User2::isProfileFullFill($user) || !count($user->certificates) || !$user->SentToAdmin || empty($user->card_name) && empty($paypalStatus)) {?>
											<p class="caution"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                            <span>以下の項目を設定していない為、現在アカウントは制限されています。</span>
                                            </p>
											<?php }?>
                                            <?php if (!\App\User2::isProfileFullFill($user)){?>
                                            <p class="user-profile-progress-suggestion must-alert">
											<a href="{{url('RentUser/Dashboard/BasicInfo/Edit')}}"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>アカウント情報の設定</a>
										</p>
                                            <?php }?>
                                       @if (!$user->BusinessType)
                                      <p class="user-profile-progress-suggestion">
											<a href="{{url('RentUser/Dashboard/BasicInfo/Edit')}}"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>事業のタイプを設定</a>
										</p>
										@endif
                                        <!--show if email validation is not done-->
										@if( !$user['IsEmailVerified'] )
										<p class="user-profile-progress-suggestion">
											<a href="{{url('RentUser/Dashboard/BasicInfo/Edit')}}">メールアドレス認証</a>
										</p>
										@endif
										
                                        <!--show if document is not send-->
										@if( !count($user->certificates) || !$user->SentToAdmin)
										<p class="user-profile-progress-suggestion must-alert">
											<a href="{{url('RentUser/Dashboard/Identify/Upload')}}"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>本人確認書類の提出</a>
										</p>
										@endif
                                        <!--/show if document is not send-->
										
                                        <!--show if payment method is not added-->
                                        @if(empty($user->card_name) && empty($paypalStatus) )
										<p class="user-profile-progress-suggestion must-alert">
											<a href="{{url('RentUser/Dashboard/BasicInfo/Edit')}}"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>支払い方法の追加</a>
										</p>
										@endif
                                        <!--/show if payment method is not added-->
                                        @if( empty($user['Logo']) || empty($user['Cover']) || empty($user['Cover']) || empty($user['BusinessSummary']) )
										<p class="mgt20"><a href="{{url('RentUser/Dashboard/MyProfile')}}" class="btn-info btn wdfull">プロフィールを完成させる</a></p>
                                        @endif
										<!--show if profile picture is not added-->
										@if( empty($user['Logo']) )
										<p class="user-profile-progress-suggestion">
											<a href="{{url('RentUser/Dashboard/MyProfile')}}"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>プロフィール写真を追加</a>
										</p>
										@endif
                                        <!--/show if profile picture is not added-->
										
										<!--show if cover picture is not added-->
										@if( empty($user['Cover']) )
										<p class="user-profile-progress-suggestion">
											<a href="{{url('RentUser/Dashboard/MyProfile')}}"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>カバー写真を追加</a>
										</p>
										@endif
                                        <!--/show if cover picture is not added-->
										
                                        <!--show if description is not added-->
										@if( empty($user['BusinessSummary']) )
										<p class="user-profile-progress-suggestion">
											<a href="{{url('RentUser/Dashboard/MyProfile')}}"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>自己紹介分を書く</a>
										</p>
										@endif
                                       @if( empty($user['Skills']) )
										<p class="user-profile-progress-suggestion">
											<a href="{{url('RentUser/Dashboard/MyProfile')}}"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>スキルを選択</a>
										</p>
										@endif
                                        <!--/show if description is not added-->
										
										<!--show if desired space condition is not set yet-->
										@if( empty($user2Space['SpaceType']) || empty($user2Space['BudgetType']) || empty($user2Space['TimeSlot']) || empty($user2Space['SpaceArea']) || empty($user2Space['TimeSlot']) || empty($user2Space['NumberOfPeople']) )
										<p class="mgt20"><a href="{{url('RentUser/Dashboard/MyProfile')}}" class="btn-info btn wdfull">スペース希望条件を設定する</a></p>
                                        @endif
										@if( empty($user2Space['SpaceType']) )
										<p class="user-profile-progress-suggestion">
											<a href="{{url('RentUser/Dashboard/EditMySpace')}}"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>スペースタイプを設定</a>
										</p>
										@endif
                                      @if( empty($user2Space['BudgetType']) )
                                      <p class="user-profile-progress-suggestion">
											<a href="{{url('RentUser/Dashboard/EditMySpace')}}"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>希望利用料金を設定</a>
										</p>
										@endif
                                     @if( empty($user2Space['SpaceArea']) )
                                      <p class="user-profile-progress-suggestion">
											<a href="{{url('RentUser/Dashboard/EditMySpace')}}"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>スペース面積を設定</a>
										</p>
										@endif
                                     @if( empty($user2Space['TimeSlot']) )
                                      <p class="user-profile-progress-suggestion">
											<a href="{{url('RentUser/Dashboard/EditMySpace')}}"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>利用時間帯を設定</a>
										</p>
										@endif
                                      @if( empty($user2Space['NumberOfPeople']) )
                                      <p class="user-profile-progress-suggestion">
											<a href="{{url('RentUser/Dashboard/EditMySpace')}}"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>利用人数を設定</a>
										</p>
										@endif
                                      @if( empty($user2Space['NumOfDesk']) )
                                      <p class="user-profile-progress-suggestion">
											<a href="{{url('RentUser/Dashboard/EditMySpace')}}"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>スペースに含まれる設備(デスク数)を設定</a>
										</p>
										@endif
                                     @if( empty($user2Space['NumOfChair']) )
                                      <p class="user-profile-progress-suggestion">
											<a href="{{url('RentUser/Dashboard/EditMySpace')}}"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>スペースに含まれる設備(イス数)を設定</a>
										</p>
										@endif
                                      
                                       
                                        <!--/show if desired space condition is not set yet-->
										
                                        
									</div>
								</div>
							</div>
							<!--/feed-nbox-->
						</div>
						<!--/user-details-wrap-->
						<?php if (count($bookingHistories)) {?>
						<div class="user-history-wrap">
							<div class="user-rent-history feed-box">
								<h3>利用履歴<!--Latest Booking History--></h3>
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
												<a href="{{getRentBookingDetailUrl($bookingHistory->id)}}">予約番号: #{{$bookingHistory->id}} - {{$bookingHistory->bookedSpace->Title}}</a>
												<!--name of office space-->
											</p>
											<p>
												<!--will rent label-->
												<span class="status {{$historyClass}} label">{{getBookingStatus($bookingHistory)}}<!--利用予定--></span>
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
										</li><!--end if booking is reserved-->
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
                </div><!--/row-->
			</div>
		</div>
		<!--/main-container-->
		<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/common_footer.php'); ?>
		<!--footer-->
						@include('pages.dashboard_user2_footer')
						<!--/footer-->

		<!--/footer-->
	</div>
	<!--/viewport-->
	<script>
      jQuery(function($){

      		$('body').on('click', '.multiple-offer .btn.show-hide', function(e){
          		e.preventDefault();
          		$currentText = $(this).text();
          		$(this).text($(this).attr('data-showHide'));
          		$(this).attr('data-showHide', $currentText);
          		$(this).closest('.multiple-offer').find('.noti-number-hide').toggle();
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
