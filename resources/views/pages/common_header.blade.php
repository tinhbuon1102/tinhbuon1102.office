<script src="{{ URL::asset('js/calendar/loadingoverlay.js') }}"></script>
<script src="{{ URL::asset('js/jquery.ui.touch.js') }}"></script>
<script type="text/javascript" src="{{url('/')}}/livechat/php/app.php?widget-init.js"></script>
<?php 
if (Auth::guard('user1')->check() || Auth::guard('user2')->check())
{
	// Detect User Type
	if (Auth::guard('user1')->check())
	{
		$userType = 1;
		$user=\App\User1::find(Auth::guard('user1')->user()->id);
		$userId = $user->id;
		$urlLogin = url('/User1/Validate');
	}
	elseif (Auth::guard('user2')->check())
	{
		$userType = 2;
		$user=\App\User2::find(Auth::guard('user2')->user()->id);
		$userId = $user->id;
		$urlLogin = url('/User2/Validate');
	}
	if (isset($user) && $user->id) {
		?>
<script type="text/javascript">
		var globalIsLogged = true;
		var globalUserType = <?php echo $userType == 1 ? 1 : 2 ?>;
		var SPACE_FIELD_CORE_WORKING = '{{SPACE_FIELD_CORE_WORKING}}';
		var SPACE_FIELD_OPEN_DESK = '{{SPACE_FIELD_OPEN_DESK}}';
		var SPACE_FIELD_SHARE_DESK = '{{SPACE_FIELD_SHARE_DESK}}';
		var SPACE_FIELD_PRIVATE_OFFICE = '{{SPACE_FIELD_PRIVATE_OFFICE}}';
		var SPACE_FIELD_PRIVATE_OFFICE_OLD = '{{SPACE_FIELD_PRIVATE_OFFICE_OLD}}';
		var SPACE_FIELD_TEAM_OFFICE = '{{SPACE_FIELD_TEAM_OFFICE}}';
		var SPACE_FIELD_OFFICE = '{{SPACE_FIELD_OFFICE}}';
		var SPACE_FIELD_METTING = '{{SPACE_FIELD_METTING}}';
		var SPACE_FIELD_SEMINAR_SPACE = '{{SPACE_FIELD_SEMINAR_SPACE}}';
				
	</script>
<div data-usertype="{{$userType}}" data-userid="{{$userId}}" class="modal fade" id="login_expired_content_wrapper" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
	<div class="vertical-alignment-helper">
		<div id="expired_content" class="modal-dialog modal-lg vertical-align-center modal_style2">
			<div class="modal-content">
				<div class="modal-header">
					<div class="modal-icon">
						<i class="fa fa-hourglass-end" aria-hidden="true"></i>
					</div>
					<h4 class="modal-title">Session Expired</h4>
					<p>
						セッションがタイムアウトしました。
						<br />
						パスワードを入力し、再度ログインしてください。
					</p>
				</div>
				<div class="modal-body">
					<form method="post" action="{{$urlLogin}}">
						<input type="hidden" name="_token" id="expire_token" value="{{csrf_token()}}">
						<div class="form-group" style="display: none">
							<label for="expire_email">Email</label>
							<input name="Email" class="form-control" value="{{$user->Email}}" id="expire_email" type="email" required="required">
						</div>
						<div class="form-group">
							<input name="password" class="form-control" value="" id="expire_password" type="password" required="required" placeholder="パスワード">
						</div>
						<input name="backUrl" type="hidden" class="form-control" value="{{URL::current()}}">
						<input name="userType" type="hidden" class="form-control" value="{{$userType}}">
						<input name="userId" type="hidden" class="form-control" value="{{$userId}}">
						<div class="form-group">
							<button type="submit" class="btn btn-primary">ログイン</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php }?>
<?php } else {

	$urlLogin = url('/User2/Validate');

	?>
<script type="text/javascript">
	var globalIsLogged = false;
</script>
<!-- Show Login form -->
<div class="modal fade" id="login_form_content_wrapper" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
	<div class="vertical-alignment-helper">
		<div class="modal-dialog modal-lg vertical-align-center login_need">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
					<h4 class="modal-title">予約をするにはログインが必要です</h4>
				</div>
				<div class="modal-body">
					<div class="HomepageAuth-facebookWrapper">
						<a href='/FBLoginRedirect'>
							<button class="btn-facebook gaf-fb-connected-button btn btn-large" data-track_click="true" data-category="pinterest_button" data-action="login-facebook" type="button">
								<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="256" height="448" viewBox="0 0 256 448" class="flicon-facebook">
                    <path d="M239.75 3v66h-39.25q-21.5 0-29 9t-7.5 27v47.25h73.25l-9.75 74h-63.5v189.75h-76.5v-189.75h-63.75v-74h63.75v-54.5q0-46.5 26-72.125t69.25-25.625q36.75 0 57 3z"></path>
                </svg>
								<span>Facebookログイン</span>
							</button>
						</a>
					</div>
					<div class="hr">
						<div class="inner">or</div>
					</div>
					<form method="post" action="{{$urlLogin}}" class="HomepageAuth-form fl-form large-form">
						<input type="hidden" name="_token" value="{{csrf_token()}}">
						<ol>
							<li class="control-group returning-user form-step">
								<input name="Email" class="form-control" id="login_email" type="email" required="required" placeholder="ユーザー名またはメールアドレス">
							</li>
							<li class="control-group returning-user form-step">
								<input name="password" class="form-control" value="" id="login_password" type="password" required="required" placeholder="パスワード">
							</li>
							<li id="login-bt" class="HomepageAuth-loginControls form-step">
								<input name="backUrl" type="hidden" class="form-control" value="{{URL::current()}}">
								<input name="userType" type="hidden" class="form-control" value="2">
								<input name="expired" type="hidden" class="form-control" value="1">
								<button type="submit" class="HomepageAuth-loginControls-button btn btn-primary btn-large">ログイン</button>
							</li>
							<li class="form-step">
								<label class="remember-me">
									<input id="savelogin" type="checkbox" name="savelogin">
									ブラウザに記憶
								</label>
								<a href="#modal3" class="forgot-password-toggle" id="forgot-password-toggle">パスワードをお忘れですか?</a>
							</li>
						</ol>
					</form>
					<span class="login-form-signup-link">
						まだアカウントをお持ちでないですか?
						<a href="#modal" data-section-toggle="signup" data-robots="LoginSignupLink" data-qtsb-section="HomePage" data-qtsb-subsection="LoginForm" data-qtsb-label="GoToSignup"> アカウントを作成 </a>
					</span>
				</div>
			</div>
		</div>
	</div>
</div>
<?php }?>
<div data-usertype="{{@$userType}}" data-userid="{{@$userId}}" class="modal fade" id="common_dialog_wraper" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
	<div class="vertical-alignment-helper">
		<div id="common_dialog_content" class="modal-dialog modal-md vertical-align-center ">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
					<h4 class="modal-title"></h4>
				</div>
				<div class="modal-body">
				</div>
				<div class="modal-footer">
					<div class="pull-right">
						<button type="button" class="btn btn-success">
							保存
						</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal">
							閉じる
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
