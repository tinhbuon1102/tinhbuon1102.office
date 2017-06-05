@include('pages.header')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
<script src="{{ URL::asset('js/jquery.responsiveTabs.js') }}"></script>
<!--/head-->
<body class="mypage shareuser list-space">
	<div class="viewport">
		@include('pages.header_nav_shareuser')
		<div class="main-container">
			<div id="main" class="container fixed-container">
				<div id="left-box">@include('user1.dashboard.left_nav')</div>
				<div class="right_side" id="samewidth">
					<div id="page-wrapper" class="has_fixed_title">
						<div class="page-header header-fixed">
							<div class="container-fluid">
								<div class="row">
									<div class="col-xs-6 col-md-6 col-sm-8 clearfix">
										<h1 class="pull-left">
											<i class="fa fa-building" aria-hidden="true"></i>
											{{ trans('user1list.space') }}<!--スペース-->
											<span class="space-count">({{$spaces->count()}}) 
										
										</h1>
									</div>
									<div class="col-xs-6 col-md-6 col-sm-4 clearfix pb15 text-right">
										<a href="{{url('ShareUser/Dashboard/ShareInfo')}}" class="yellow-button btn add-space-btn fright mt15">
											<i class="fa fa-plus-circle" aria-hidden="true"></i>
											<!--スペースを追加-->{{ trans('user1list.add_space') }}
										</a>
									</div>
									<!--/col-xs-6-->
								</div>
							</div>
						</div>
						<!--/page-header-->
						<div class="container-fluid">
							<div class="panel panel-default">
                            
							<!--if there is no added space-->
							@if( $spaces->count() < 1 )
                            <div class="no-space-show">
                            <i class="fa fa-building" aria-hidden="true"></i>
                            <h1>まだスペースが<br class="show-sp">登録されてません</h1>
                            <a href="{{url('ShareUser/Dashboard/ShareInfo')}}" class="yellow-button btn add-space-btn">{{ trans('user1list.add_space_now') }}</a>
                            </div>
							@endif
                            <!--/if there is no added space-->
							
								<div class="form-container">
									<form id="basicinfo">
										<fieldset id="space_tabs_horizontal_wraper" style="opacity: 0;">
											<ul id="space_tabs_horizontal">
												<?php foreach ($groupedSpaces as $spaceType => $spaces) {?>
												<li>
													<a href="#space-tab-{{$spaceType}}"><!--{{getSpaceTypeText($spaces[0])}}-->{{ trans('tab_content.'.getSpaceTypeText($spaceType)) }}</a>
												</li>
												<?php }?>
											</ul>
											<?php foreach ($groupedSpaces as $spaceType => $spaces) {?>
											<div class="space-table-wraper" id="space-tab-{{$spaceType}}">
												<?php if (isset($aNoScheduleSpace[$spaceType]) && $aNoScheduleSpace[$spaceType]) {?>	
												<div class="space-hint-noschedule"><i class="fa fa-exclamation-circle" aria-hidden="true"></i><?php echo trans('common.Space have not available schedule in Red color');?></div>
												<?php }?>
												<table class="table table-striped table-bordered table-hover space-table">
													<thead>
														<tr>
															<th class="img-th">{{ trans('user1list.space_image') }}<!--画像--></th>
															<th>{{ trans('user1list.space_type') }}<!--スペースタイプ / 利用人数--></th>
															<th class="mb-none">{{ trans('user1list.space_amount') }}<!--金額--></th>
															<th class="mb-none">{{ trans('user1list.space_status') }}<!--ステータス--></th>
															<th>{{ trans('user1list.space_config') }}<!--設定--></th>
														</tr>
													</thead>
													<tbody>
														<!--list of space-->
														@foreach($spaces as $space)
														<?php lowestFlexibleSpacePrice($space)?>
														<tr class="workspace-list-item h5 <?php echo !$space->isThisSpaceHasSlot ? 'no-schedule' : ''?>">
															<td class="table-cell">
																<div class="wl-image-wrapper">
																	<img class="wl-image" src="{{getSpacePhoto($space)}}">
																</div>
															</td>
															<td class="table-cell">
																<div class="wl-info-line">{{str_limit($space->Title, 50)}}</div>
																<div class="wl-info-line h7"><!--{{$space->Type}}-->{{ trans('user1list.'.($space->Type)) }}</div>
																<div class="wl-info-line h7">{{$space->Capacity}}{{ trans('user1list.people') }}<!--人--></div>
															</td>
															<td class="table-cell mb-none">
																	<?php echo getPrice($space, true, '', true, false)?> /{{ trans('user1list.'.getSpaceTypeText($space)) }}<!--{{getSpaceTypeText($space)}}-->
															</td>
															<td class="table-cell mb-none">
																<!-- ko if: $data.HasIncompleteFields() -->
																<!-- /ko -->
																<!-- ko if: !$data.HasIncompleteFields() -->
																<div class="workspace-actions-wrapper">
																	<!-- ko if: $data.Booked() -->
																	<!-- /ko -->
																	<!-- ko if: !$data.Booked() && WorkspaceStatus() == 1 -->
																	<!--<a href="javescript:void(0)">Available</a>
            <div class="workspace-actions-modal">
            <div class="workspace-actions-popup">
               <a href="javascript:void(0)" onclick="manageWorkspacesModel.viewModel.hideWorkspace(this)" data-bind="attr: { 'data-workspaceId': $data.Id() }" data-workspaceid="6a520238-42ae-4370-b1a9-13fceee5992e">Not Available</a>
               
            </div>
            </div>-->
			
																	{{ trans('user1list.'.getStatusName($space->status)) }}
																	<!--{{getStatusName($space->status)}}-->
																	<!-- /ko -->
																	<!-- ko if: !$data.Booked() && WorkspaceStatus() == 2 -->
																	<!-- /ko -->
																</div>
																<!-- /ko -->
															</td>
															<td class="table-cell">
																<div class="workspace-actions-wrapper">
																	<a class="action-tooltip text-link">編集・その他</a>
																	<div class="workspace-actions-modal">
																		<div class="workspace-actions-popup">
																			<a target="_blank" class="content-navigation" href="{{ url('ShareUser/Dashboard/editspace/'.$space->HashID) }}">{{ trans('user1list.edit') }}<!--編集--></a>
																			<a target="_blank" href="{{ url('ShareUser/ShareInfo/View/'.$space->HashID) }}">{{ trans('user1list.preview') }}<!--プレビュー--></a>
																			<a target="_blank" href="{{ url('ShareUser/Dashboard/ShareInfo/Duplicate/'.$space->HashID) }}">{{ trans('user1list.duplicate') }}<!--複製--></a>
																			<a target="_blank" href="javascript:void(0)" onclick="deleteSpace('{{$space->HashID}}')">{{ trans('user1list.delete') }}<!--削除--></a>
																		</div>
																	</div>
																</div>
															</td>
														</tr>
														@endforeach
														<!--/list of space-->
													</tbody>
												</table>
											</div>
											<!--/wrapper-->
											<?php }?>
										</fieldset>
									</form>
								</div>
							</div>
						</div>
					</div>
					<!--footer-->
					@include('pages.dashboard_user1_footer')
					<!--/footer-->
				</div>
				<script>
		function deleteSpace(id)
		{
			var result = confirm("本当に削除しますか");
			if (result) {
			window.location.href = "{{url('ShareUser/Dashboard/ShareInfo/Delete')}}/"+id;
			}
		}

		
		jQuery(function($){
			$('#space_tabs_horizontal_wraper').responsiveTabs({
		        rotate: false,
		        startCollapsed: 'accordion',
		        collapsible: 'accordion',
		        setHash: true,
		        activate: function(e, tab) {
		        	$("html, body").animate({ scrollTop: 0 }, "fast");
			        $('#space_tabs_horizontal_wraper').css('opacity', 1);
			        $('table.space-table:visible').each (function(){
			        	var table = $(this).DataTable();
			        	table.destroy();
						$(this).DataTable({
							responsive: true,
							"columnDefs": [
								{ "width": "10%", "targets": 0 },
								{ "type": "formatted-num", "targets": 2 },
							],
							"pageLength": 50,
							<?php echo getDataTableTranslate();?>
			       		 });
					})
		        }
			});
		})
	</script>
			</div>
			<!--/#main-->
		</div>
		<!--/main-container-->
        </div><!--/#containers-->
	</div>
	<!--/viewport-->
	<!-- Typehead -->
</body>
</html>
