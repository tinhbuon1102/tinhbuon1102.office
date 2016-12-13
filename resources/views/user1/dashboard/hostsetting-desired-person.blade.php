
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
						<form enctype='multipart/form-data' method="post" action="{{ url('ShareUser/Dashboard/HostSetting') }}">
							<input type="hidden" name="returnURL" value="{{ url('ShareUser/Dashboard/DesiredPerson') }}"/>
							{{ csrf_field() }}
							<div class="page-header header-fixed">
								<div class="container-fluid">
									<div class="row">
										<div class="col-xs-6 col-md-6 col-sm-8 clearfix">
											<h1 class="pull-left">
												<i class="fa fa-heart" aria-hidden="true"></i>
												出会いたい人材
											</h1>
										</div>
										<div class="col-xs-6 col-md-6 col-sm-4 clearfix pb15 text-right">
											<button id="saveSettingInfo" type="submit" class="btn btn-default mt15 dblk-button" data-bind="jqButton: { disabled: !isDirty() }, click: save" role="button">
												<i class="fa fa-floppy-o"></i>
												<span class=""> 保存</span>
											</button>
										</div>
										<!--/col-xs-6-->
									</div>
								</div>
							</div>
							<!--/page-header header-fixed-->

							<div id="SettingPage" class="container-fluid">
								<div id="feed">
									<section class="feed-first-row feed-box" id="desiredperson">
										<div class="dashboard-section-heading-container">
											<h3 class="dashboard-section-heading">
												出会いたい人材
											</h3>
										</div>
										<div class="space-setting-content">
											<div class="form-container">
                                            <!--start add new field-- -->
                                            <div class="form-field">
													<label for="age">
														 性別
													</label>
													<div class="input-container">
														<?php echo Form::select('DisiredSex',
																getUserSexMapper(), 
																$user->DisiredSex, 
																['id' => 'DisiredSex', 'placeholder' => '性別を選択', 'class' => 'old_ui_selector chosen-select']);
														?>
													</div>
												</div>
                                            <div class="form-field">
													<label for="age">
														 年齢
													</label>
													<div class="input-container">
														<?php echo Form::select('DisiredAge',
																getUserAgeMapper(), 
																$user->DisiredAge, 
																['id' => 'DisiredAge', 'placeholder' => '年代を選択', 'class' => 'old_ui_selector chosen-select']);
														?>
													</div>
												</div>
                                               <!-- --end add new field-->
												<div class="form-field">
													<label for="UserType">
														職種<!--10%-->
														
													</label>
													<div class="input-container">
													<?php echo Form::select('BusinessKindWelcome',
															getBusinessTypes(), 
															$user->BusinessKindWelcome, 
															['id' => 'BusinessKind_welcome', 'placeholder' => '職種を選択', 'class' => 'old_ui_selector chosen-select']);
													?>
													</div>
												</div>
												<div class="form-field">
													<label for="Skills">
														
														スキル <!--10%-->
													</label>
													<div class="input-container">
														<?php 
														echo Form::select('Skills[]', 
																getSkills(), 
																$user->Skills,
																['id' => 'skills', 'class' => 'chosen-select', 'multiple' => true]
																);
														?>
													</div>
												</div>

											</div>
											<!--/form-container-->
										</div>
										<!--/space-setting-content-->
									</section>

								</div>
								<!--/feed-->
							</div>
						</form>
					</div>
					<!--/#page-wrapper-->
				</div>
				<!--/right_side-->
			</div>
		</div>
		<!--/main-container-->
		<!--footer-->
		<!--/footer-->
	</div>
	<!--/viewport-->
	<script type="text/javascript">
		jQuery(function($){
			$("#skills").select2();
		})
	</script>
</body>
</html>
