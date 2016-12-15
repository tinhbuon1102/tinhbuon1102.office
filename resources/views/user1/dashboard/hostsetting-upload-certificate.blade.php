<?php
$user = isset($user) ? $user : Auth::guard('user1')->user();
?>
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
												<i class="fa fa-cogs" aria-hidden="true"></i>
												本人確認手続き
											</h1>
										</div>
									</div>
								</div>
							</div>
							<!--/page-header header-fixed-->
                    <?php $error = Session::get('error'); ?>
						<?php $message = Session::get('success'); ?>
						
				        @if( isset($error) )
				        <div class="alert alert-danger">{!! $error !!}</div>
						@endif @if( isset($message) )
						<div class="alert alert-success">{!! $message !!}</div>
						@endif
						<form id="Certificate" enctype='multipart/form-data' method="post" action="{{ url('ShareUser/Dashboard/HostSetting/Certificate') }}">
							{{ csrf_field() }}
							
							<div id="SettingPage" class="container-fluid">
								<div id="feed">
									<section class="feed-first-row feed-box" id="certificate">
										<div class="space-setting-content">
                                        
											@if( !@$user->bank['BankName'] || !\App\User1::isProfileFullFill($user) )
											<div class="dashboard-warn-text">
												<div class="dashboard-must-validation">
													<i class="icon-warning-sign fa awesome"></i>
													<div class="warning-heading">
														本人確認書類提出の前に、以下の設定を完了させてください。
														<ul class="list-disc">
															@if( !\App\User1::isProfileFullFill($user) )
															<li>必須のアカウント情報を設定</li>
															@endif @if( !@$user->bank['BankName'] )
															<li>支払受取情報を設定</li>
															@endif
														</ul>
													</div>
												</div>
											</div>
											@endif
											<div class="form-container">
												<fieldset>
													<div class="identity-explain">
														<p>
															アカウントを有効にするには、本人確認書類の提出が必要です。
															<br />
															お客様の本人手続きが完了するまで、スペースの予約受付、スペース予約ページの公開ができません。
														</p>
														<p>以下の手順に従って、本人確認手続きを行って下さい。お手続きが完了するまで1~2日間程度かかる場合がありますので、予めご了承ください。また、お送り頂いた書類に不備があった場合は、3~4日間程度かかることがありますので、ご注意ください。</p>
														<p>本人確認手続きを提出される前に以下をご確認ください。</p>
														<ul>
															<li>
																<a href="{{url('help/shareuser/certificate')}}" target="_blank">提出に必要な書類を確認する</a>
															</li>
															<li>アカウントに登録された情報を確認。変更がある場合には登録する。</li>
															<li>提出された本人確認書類の情報が正確であること、アカウントに登録されている氏名、生年月日、住所が本人確認書類と一致していることを確認する。</li>
														</ul>
														<p>以下のファイルアップローダーから、必要書類をアップロードし本人確認手続きをおこなってください。</p>
													</div>
													<div class="hr"></div>
													<div class="form-field @if( empty(@$user->bank['BankName']) || !\App\User1::isProfileFullFill($user) )no-allow @endif">
														<div class="input-container2">
															<label>ファイル</label>
															
                                                            <div class="col-inlineb">
<div class="input-group">
<label class="input-group-btn">
<span class="btn btn-default btn-file"><i class="fa fa-file" aria-hidden="true"></i>参照<input name="certificate[]" class="validate[required]" type="file" multiple /></span>
</label>
<input type="text" class="form-control" readonly>
</div>
</div>
														</div>
														<div class="input-container2">
															<label>書類種類</label>
															<select name="doctype" class="validate[required]">
																<option value="">選択してください</option>
																<option value="登記簿謄本">登記簿謄本</option>
																<option value="運転免許証">運転免許証</option>
																<option value="パスポート">パスポート</option>
																<option value="住民基本台帳カード">住民基本台帳カード</option>
																<option value="健康保険証">健康保険証</option>
																<option value="各種年金手帳">各種年金手帳</option>
																<option value="各種福祉手帳">各種福祉手帳</option>
																<option value="補完書類">補完書類</option>
															</select>
														</div>
														<div class="input-container2">
															<label>備考</label>
															<textarea rows="4" cols="50" name="Description">
</textarea>
														</div>
														<div class="input-container2 pdl20">
															<input type="submit" value="アップロード" class="btn ocean-btn" />
														</div>
														<div class="table-responsive">
															<table class="table table-wht table-bordered dataTable no-footer">
																<thead>
																	<tr>
																		<th>書類種類</th>
																		<th>ファイル名</th>
																		<th class="fl-note">備考</th>
																		<th class="dl-fl">アクション</th>
																	</tr>
																</thead>
																<tbody>
																	@if($user->certificates->count()>0) @foreach($user->certificates as $certificate)
																	<tr>
																		<td>{{$certificate->FileType}}</td>
																		<td>
																			<a target="_blank" href="{{url(" /")}}{{$certificate->Path}}">{{basename($certificate->Path)}}</a>
																		</td>
																		<td>{{$certificate->Description}}</td>
																		<td>
																			<a href='{{url("/")}}/ShareUser/Dashboard/HostSetting/Certificate?removeID={{$certificate->id}}' class="btn remove_btn">
																				<i class="fa fa-minus-circle" aria-hidden="true"></i>
																				削除
																			</a>
																		</td>
																	</tr>
																	@endforeach @else
																	<tr>
																		<td colspan="4">
																			<p class="doc_no_yet">まだ提出された書類はありません</p>
																		</td>
																	</tr>
																	@endif
																</tbody>
															</table>
													<?php if ($user->IsAdminApproved == 'Yes') {?>
													<!--<div class="certificate-approve">
														Certificated are approved
													</div>-->
														
													<?php }else {?>
													<!--<div class="certificate-note-approve">
														Certificated are not approved
													</div>-->
													
													<?php }?>
													<div class="btn-groups">
																<a href='{{url("/")}}/ShareUser/Dashboard/HostSetting/Certificate?sendAdmin=1'>
																	<button class="button btn ocean-btn" type='button'>
																		<i class="fa fa-file-text" aria-hidden="true"></i>
																		書類を提出
																	</button>
																</a>
																<button class="button btn">キャンセル</button>
															</div>
														</div>
													</div>
												</fieldset>
											</div>
										</div>
									</section>
								</div>
								<!--/feed-->
							</div>
						</form>
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
		<!--footer-->
		<!--/footer-->
	</div>
	<script src="{{ URL::asset('js/jquery.validationEngine.js') }}"></script>
	<script src="{{ URL::asset('js/jquery.validationEngine-ja.js') }}"></script>
	<link rel="stylesheet" href="{{ URL::asset('css/validationEngine.jquery.css') }}">
	<script>
  jQuery(function(){
    jQuery("#Certificate").validationEngine();
  });
  $ = jQuery.noConflict();
  $(function() {

  // We can attach the `fileselect` event to all file inputs on the page
  $(document).on('change', ':file', function() {
    var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label]);
  });

  // We can watch for our custom `fileselect` event like this
  $(document).ready( function() {
      $(':file').on('fileselect', function(event, numFiles, label) {

          var input = $(this).parents('.input-group').find(':text'),
              log = numFiles > 1 ? numFiles + ' files selected' : label;

          if( input.length ) {
              input.val(log);
          } else {
              if( log ) alert(log);
          }

      });
  });
  
});
</script>
</body>
</html>
