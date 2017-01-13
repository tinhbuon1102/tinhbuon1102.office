
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
														<a href="<?php echo getUser1ProfileUrl($notifications[0]['user1Send'])?>">
															<img src="<?php echo $notifications[0]['user1Send']['Logo'] ? $notifications[0]['user1Send']['Logo'] : '';?>" class="profile-pic" />
														</a>
													</span>
												</div>
												<h2>
													<a class="font-bold" href="<?php echo getUser1ProfileUrl($notifications[0]['user1Send'])?>">
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
																<?php 
																$favorites = $notification->user1Space->favorites;
																$favUsers = array();
																if (count($favorites))
																{	
																	foreach ($favorites as $favorite)
																	{
																		$favUsers[] = $favorite['User2Id'];
																	}
																}
																?>
																<?php if (in_array($notification['user2Receive']['id'], $favUsers)) {?>
																<div class="rfloat fav-button">
																	<a data-favorited="Favorited" data-favorite="Favorite" data-favspaceid="<?php echo $notification['user1Space']['HashID']?>" data-tooltip="お気に入り取り消し" href="#" class="gry-btn added_fav button-favorite" id="fav-btn" onclick="return false;">
																		<i class="fa fa-star" aria-hidden="true"></i>
																		お気に入り追加済
																	</a>
																</div>
																<?php }?>
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
	
	<!-- BO YMS -->
					<script type="text/javascript">
	jQuery(document).ready(function($){
		
	$(".added_fav").webuiPopover({
		placement: 'auto-bottom',
		trigger:'hover',
		content:function() {
			var spaceID = $(this).data('favspaceid');     
            return '<a href="javascript:void(0);" data-favspaceid="'+ spaceID +'" data-toggle="modal" data-target="#modalConfirmDelete">お気に入り取り消し</a>';
        }
	});
	
		$(".confirm_yms_remove_fav").click(function(){
			$('.confirm_yms_remove_fav').prop('disabled',true);
			//var favspaceid = $(this).data('favspaceid');
			var favspaceid = $('#favspaceid').val();
			$.ajax({
                type: "GET",
                url: "<?php URL::to('/') ?>/RentUser/AddFavoriteSpace/"+favspaceid+"?action=remove",
               // data: {response:rrf},
                success: function(data) { 
                	  
                	data = $.parseJSON(data)
                	console.log('data: ',data);
                	if(data.success==true){
                		$('#modalConfirmDelete #yms_message').html('<div class="alert alert-success"><?=trans("common.delete_success")?></div>');
                		setTimeout(function(){ 
	                       location.reload();
	                    }, 1200);
                	}else {
                		$('#modalConfirmDelete #yms_message').html('<div class="alert alert-danger"><?=trans("common.delete_error")?></div>');
                		$('.confirm_yms_remove_fav').prop('disabled',false);
                	}
                    setTimeout(function(){ 
                        $('.yms_message').html('');
                    }, 1200);
                },
                error: function() {                                       
                    alert('An error occurred. Please try again!');
                    $('.confirm_yms_remove_fav').prop('disabled',false);
                }
            });
		});
		$('#modalConfirmDelete').on('show.bs.modal', function (event) {
		  var button = $(event.relatedTarget) 
		  var favspaceid = button.data('favspaceid') 
		  console.log('favspaceid: ',favspaceid);
		  $('#favspaceid').val(favspaceid);
		})
	});

	
</script>
					<!-- Modal confirm delete -->
					<div id="modalConfirmDelete" class="modal fade" tabindex="-1" role="dialog">
						<div class="modal-dialog">
							<!--  modal-sm -->
							<div class="modal-content fav-list-modal">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
									<h4 class="modal-title">{{Lang::get('common.title_confirm_delete_fav')}}</h4>
								</div>
								<div class="modal-body">
									<div id="yms_message"></div>
									<!-- <p>{{Lang::get('common.text_confirm_delete_fav',array('spacetitle'=>'ttttt'))}}</p>           -->
									<p>{{Lang::get('common.text_confirm_delete_fav')}}</p>
								</div>
								<div class="modal-footer">
									<input type="hidden" id="favspaceid" value="">
									<button type="button" class="btn btn-default" data-dismiss="modal">{{Lang::get('common.cancel')}}</button>
									<button type="button" class="confirm_yms_remove_fav btn btn-primary">{{Lang::get('common.remove_fav')}}</button>
								</div>
							</div>
							<!-- /.modal-content -->
						</div>
						<!-- /.modal-dialog -->
					</div>
					<!-- /.modal -->
					<!-- EO YMS -->
					
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
