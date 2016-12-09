
<!--sign up form-->
<div id="header-signup-modal" class="remodal" data-remodal-id="modal" data-remodal-options="hashTracking:false">
	<button data-remodal-action="close" class="remodal-close"><img src="/images/cross-icons.png" /></button>
    <div class="HomepageAuth-inner">
    <div class="modal-header">
    <div id="fl-logo" class="modal-header-logo"><img src="/images/logo.png" class="of-icon" /></div>
	<h3 class="modal-title">今すぐ無料登録</h3>
    </div>
    <div class="modal-body">
    <div class="HomepageAuth-facebookWrapper">
    
			<a href='/FBLoginRedirect'><button class="btn-facebook gaf-fb-connected-button btn btn-large" data-track_click="true" data-category="pinterest_button" data-action="signUp-facebook" data-qts="FacebookSignup" type="button">
                <span><i class="fa fa-facebook-official" aria-hidden="true"></i>Facebookで登録</span>
            </button></a>
        </div>
        <div class="hr">
            <div class="inner">or</div>
        </div>
	<form id="signup-form" method="post" class="HomepageAuth-form fl-form large-form" action="{{ url('Register-User') }}" novalidate>
			<? /* csrf_field() */ ?>  
		<fieldset>
				 <span class="help-inline form-error commanerror"></span>
                <ol data-target="signup-fields">
                    <li class="form-step control-group signup-field" data-target="signup-field">
                        <label class="is-hidden">メールアドレス</label>
                        <div class="HomepageAuth-form-tooltipWrapper" >
                            <span class="fa fa-envelope-o input-icon">
                                <input name="Email" type="email"  placeholder="メールアドレス" required="">
                            </span>
                        </div>
                        <span class="help-inline form-error" id="Email_error"></span>
                    </li>
                    <li class="form-step control-group signup-field" data-target="signup-field">
                        <label class="is-hidden">ユーザー名</label>
                        <div class="HomepageAuth-form-tooltipWrapper" >
                            <span class="fa fa-user input-icon">
                                <input name="UserName" type="text"  required="" placeholder="ユーザー名">
                            </span>
                        </div>
                        <span class="help-inline form-error" id="UserName_error"></span>
                    </li>
                    <li class="form-step control-group signup-field" >
                        <label for="signup-password" class="is-hidden">パスワード</label>
                        <div class="HomepageAuth-form-tooltipWrapper">
                            <span class="fa fa-lock input-icon">
                                <input id="signup-password" class="password" name="password" type="password" required="" placeholder="パスワード" >
                            </span>
                        </div>
                        <div class="password-meter" data-strength="" data-target="password-meter">
                            <div class="password-meter-bg">
                                <div class="password-meter-bar"></div>
                            </div>
                            <div class="password-meter-message" data-weak="パスワード強度：弱い" data-normal="パスワード強度：普通" data-strong="パスワード強度：強い">
                            </div>
                        </div>
                        <span class="help-inline form-error" id="password_error"></span>
                    </li>
                    <li class="form-step control-group signup-field">
                        <label class="is-hidden">パスワード(確認)</label>
                            <div class="HomepageAuth-form-tooltipWrapper">
                                <span class="fa fa-lock input-icon">
                                    <input name="password_confirmation" type="password"  required="" placeholder="パスワード(確認)" data-role="none">
                                </span>
                            </div>
                            <span class="help-inline form-error" id="password_confirmation_error"></span>
                        
                    </li>
                    <li class="HomepageAuth-userType form-step control-group btn-group signup-user-type" data-toggle=""><!--buttons-radio-->
                        <p class="HomepageAuth-userType-title">オフィススペースを</p>
                        <span class="HomepageAuth-radioGroup button-group">
                            <label class="HomepageAuth-radioGroup-button btn gry-btn">
                                <input type="radio" name="looking_for" id="looking_to_share" value="ShareUser" data-role="none" class="required">
                                提供する
                            </label><label class="HomepageAuth-radioGroup-button btn gry-btn">
                                <input type="radio" name="looking_for" id="looking_for_rent" value="RentUser" data-role="none">
                                 利用する
                            </label>
                        </span>
                        <label for="looking_for" class="help-inline error" id="looking_for_error"></label>
                    </li>
                    
                </ol>
                <input type="hidden" name="signup_skip_captcha" id="signup_skip_captcha" value="RPBwOX1mAYFrOAGv">
                <div class="HomepageAuth-submit">
                    <button type="submit" class="btn btn-large signup-btn btn-primary">
                        アカウント作成
                    </button>
					<img src="/ajax-loader.gif" class="loader-img" style="display:none;">
                </div>
            </fieldset>
            <p class="HomepageAuth-footer">
                登録前に<a href="{{url('/TermCondition/')}}" target="_blank">利用規約</a>と<a href="{{url('/PrivacyPolicy/')}}" target="_blank">プライバシーポリシー</a>をお読み下さい。
                本サイトのユーザーはこの内容を理解し、同意したものと見なします。
            </p>
        </form>
        </div><!--/modal-body-->
        </div>
</div>
<!--/signup form-->
<!--login form-->
<div id="header-login-modal" class="remodal" data-remodal-id="modal2" data-remodal-options="hashTracking:false">
	<button data-remodal-action="close" class="remodal-close"><img src="/images/cross-icons.png" /></button>
    <div class="HomepageAuth-inner">
    <div class="modal-header">
    <div id="fl-logo" class="modal-header-logo"><img src="/images/logo.png" class="of-icon" /></div>
    </div>
    <div class="modal-body">
        <div class="HomepageAuth-facebookWrapper">
		<a href='/FBLoginRedirect'>
            <button class="btn-facebook gaf-fb-connected-button btn btn-large" data-track_click="true" data-category="pinterest_button" data-action="login-facebook" type="button">
                <span><i class="fa fa-facebook-official" aria-hidden="true"></i>Facebookログイン</span>
            </button>
		</a>	
        </div>
        <div class="hr">
            <div class="inner">or</div>
        </div>

        <form id="login-form" class="HomepageAuth-form fl-form large-form" method="post"  action="{{ url('Login') }}" novalidate>
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="fromHttps">
            <input type="hidden" name="submitted" value="true">
            <p class="form-error error">ユーザーネーム・メールアドレスかパスワードが認識できません。</p>
            <ol>
                <li>
                    <div id="login-success" class="alert alert-success" style="display:none;">
                        <strong>ログインに成功しました。</strong>
                    </div>
                </li>
                <li>
                    <div id="login-error" class="alert alert-danger" style="display:none ;">
                      ログイン情報が間違っています。
                    </div>
                </li>
                <li>
                    <div id="login-alert" class="alert alert-warning" style="display:none;">
                    </div>
                </li>
                <li class="control-group returning-user form-step" data-target="returning-user">
                    <label for="login-username" aria-hidden="hidden" class="is-accessibly-hidden">ユーザー名またはメールアドレス</label>
                    <span class="fl-icon-user input-icon">
                        <input id="login-username" class="large-input" type="text" name="username" placeholder="ユーザー名またはメールアドレス" data-msg-required="ユーザー名またはメールアドレスを入力してください。" required="" data-role="none">
                    </span>
                    <span class="help-inline form-error"></span>
                </li>
                <li class="control-group returning-user form-step" data-target="returning-user">
                    <label for="login-password" aria-hidden="hidden" class="is-accessibly-hidden">パスワード</label>
                    <span class="fl-icon-lock input-icon">
                        <input id="login-password" class="large-input" type="password" name="password" placeholder="パスワード" required>
                    </span>
                    <span class="help-inline form-error"></span>
                </li>
				<li class="HomepageAuth-userType form-step control-group btn-group signup-user-type" data-toggle="">
                        <p class="HomepageAuth-userType-title">オフィススペースを</p>
                        <span class="HomepageAuth-radioGroup button-group">
                            <label class="HomepageAuth-radioGroup-button btn gry-btn">
                                <input type="radio" name="looking_for" id="looking_to_share1" value="ShareUser" class="required">
                                提供する
                            </label><label class="HomepageAuth-radioGroup-button btn gry-btn">
                                <input type="radio" name="looking_for" id="looking_for_rent1" value="RentUser" >
                                利用する
                            </label>
                        </span>
                        <label for="looking_for" class="help-inline error" id="looking_for_error"></label>
                    </li>
                <li id="login-ajax-spinner-div" style="">
                    <div class="Loader Loader--full"></div>
					<img src="/ajax-loader.gif" class="loader-img1" style="display:none;">

                </li>
                <li id="login-bt" class="HomepageAuth-loginControls form-step">
                    <button class="HomepageAuth-loginControls-button btn btn-primary btn-large" data-track_click="true" data-category="pinterest_button" data-action="login" id="login-bt1">ログイン</button>
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

        <form id="forgot-password" class="HomepageAuth-form fl-form large-form" method="POST" novalidate style="display: none;">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
            <fieldset class="HomepageAuth-form-forgetPassword">
                <ol>
                    <li class="form-step control-group">
                        <label for="signup-email">メールアドレスを入力</label>
                        <span class="HomepageAuth-form-tooltipWrapper" data-tooltip="Please enter the email address registered to your offispo account.">
                            <span class="fl-icon-envelope input-icon">
                                <input type="text" name="email" id="inputEmail" placeholder="メールアドレスを入力" data-msg-required="有効なメールアドレスを入力してください。" data-msg-email="有効なメールアドレスを入力してください。">
                            </span>
                        </span>
                        <span class="help-inline form-error"></span>
                        <span id="forgot-password-error" class="help-block error" style="display: none;"></span>
                        <div id="forgot-password-server-error" class="error" style="display: none;">
                            サーバーにエラーが起こりました。運営会社にお問い合わせください。
                        </div>
                    </li>
                    <li class="form-step">
                        <button id="forgot-password-submit" type="button" class="btn btn-info btn-large btn-block">
                            パスワードを再設定する
                        </button>
                    </li>
                </ol>
            </fieldset>
            <img id="ajax-spinner" alt="offispo Loading..." src="https://cdn2.f-cdn.com/img/ajax-loader.gif?v=62d3d0c60d4c33ef23dcefb9bc63e3a2&amp;%3Bm=6" style="display: none;">
            <div id="pwd_sent" class="alert alert-success" style="display: none;">
                <strong>メールが送信されました</strong>
                もしあなたのメールアドレスが登録されている場合は、パスワード再設定の手順案内メールが送られます。
            </div>
        </form>
        
        <span class="login-form-signup-link">
            まだアカウントをお持ちでないですか?
            <a href="#modal" class="link-blue" data-section-toggle="signup" data-robots="LoginSignupLink" data-qtsb-section="HomePage" data-qtsb-subsection="LoginForm" data-qtsb-label="GoToSignup">
                <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>アカウントを作成
            </a>
        </span>
        </div><!--/modal-body-->
    </div>
</div>
<!--/login form-->
<!-- forget password form -->
<div id="header-login-modal" class="remodal" data-remodal-id="modal3" data-remodal-options="hashTracking:false">
    <button data-remodal-action="close" class="remodal-close"><img src="/images/cross-icons.png" /></button>
    <div class="HomepageAuth-inner">
    <div class="modal-header">
    <div id="fl-logo" class="modal-header-logo"><img src="/images/logo.png" class="of-icon" /></div>
    <h2 class="modal-title">パスワードをリセット</h2>
    </div>
    <div class="modal-body">
       

        <form id="forget-password-form" class="HomepageAuth-form fl-form large-form" method="post"  action="{{ url('Forgetpassword') }}" novalidate>
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="fromHttps">
            <input type="hidden" name="submitted" value="true">
            <p class="form-error error"></p>
            <ol>
                <li>
                    <div id="login-success2" class="alert alert-success" style="display:none;">
                        <strong>メールが送信されました</strong><br>パスワード再設定用メールが送信されました。
                    </div>
                </li>
                <li>
                    <div id="login-error2" class="alert alert-danger" style="display:none ;">
                        エラー
                </li>
                <li>
                    <div id="login-alert" class="alert alert-warning" style="display:none;">
                    </div>
                </li>
                <li class="control-group returning-user form-step" data-target="returning-user">
                    <label for="login-username" aria-hidden="hidden" class="is-accessibly-hidden">メールアドレス</label>
                    <span class="fl-icon-user input-icon">
                        <input id="login-email" class="large-input" type="text" name="email" placeholder="メールアドレス" data-msg-required="メールアドレスを入力してください" required="" data-role="none">
                    </span>
                    <span class="help-inline form-error"></span>
                </li>
             <li class="HomepageAuth-userType form-step control-group btn-group signup-user-type" data-toggle="">
                        <p class="HomepageAuth-userType-title">オフィススペースを</p>
                        <span class="HomepageAuth-radioGroup button-group">
                            <label class="HomepageAuth-radioGroup-button btn gry-btn">
                                <input type="radio" name="looking_for" id="looking_to_share1" value="ShareUser" class="required">
                                提供する
                            </label><label class="HomepageAuth-radioGroup-button btn gry-btn">
                                <input type="radio" name="looking_for" id="looking_for_rent1" value="RentUser" >
                                利用する
                            </label>
                        </span>
                        <label for="looking_for" class="help-inline error" id="looking_for_error"></label>
                    </li>
                <li id="login-ajax-spinner-div" style="">
                    <div class="Loader Loader--full"></div>
                    <img src="/ajax-loader.gif" class="loader-img2" style="display:none;">

                </li>
                <li id="login-bt" class="HomepageAuth-loginControls form-step login-bt2">
                    <button class="HomepageAuth-loginControls-button btn btn-primary btn-large login-bt2 reset_button" data-track_click="true" data-category="pinterest_button" data-action="login" id="login-bt1">パスワード再設定用メール送信</button>
               </li>
            </ol>
        </form>

        <form id="forgot-password" class="HomepageAuth-form fl-form large-form" method="POST" novalidate style="display: none;">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
            <fieldset class="HomepageAuth-form-forgetPassword">
                <ol>
                    <li class="form-step control-group">
                        <label for="signup-email">メールアドレスを入力</label>
                        <span class="HomepageAuth-form-tooltipWrapper" data-tooltip="Please enter the email address registered to your offispo account.">
                            <span class="fl-icon-envelope input-icon">
                                <input type="text" name="email" id="inputEmail" placeholder="Enter your email" data-msg-required="有効なメールアドレスを入力してください。" data-msg-email="有効なメールアドレスを入力してください。">
                            </span>
                        </span>
                        <span class="help-inline form-error"></span>
                        <span id="forgot-password-error" class="help-block error" style="display: none;"></span>
                        <div id="forgot-password-server-error" class="error" style="display: none;">
                            サーバーにエラーが起こりました。運営会社にお問い合わせください。
                        </div>
                    </li>
                    <li class="form-step">
                        <button id="forgot-password-submit" type="button" class="btn btn-info btn-large btn-block">
                            パスワードを再設定
                        </button>
                    </li>
                </ol>
            </fieldset>
            <img id="ajax-spinner" alt="offispo Loading..." src="https://cdn2.f-cdn.com/img/ajax-loader.gif?v=62d3d0c60d4c33ef23dcefb9bc63e3a2&amp;%3Bm=6" style="display: none;">
            <div id="pwd_sent" class="alert alert-success" style="display: none;">
                <strong>メールが送信されました</strong>
                もしあなたのメールアドレスが登録されている場合は、パスワード再設定の手順案内メールが送られます。
            </div>
        </form>
        
        <span class="login-form-signup-link">
            まだアカウントをお持ちでないですか? 
            <a href="#modal" data-section-toggle="signup" data-robots="LoginSignupLink" data-qtsb-section="HomePage" data-qtsb-subsection="LoginForm" data-qtsb-label="GoToSignup">
               アカウントを作成
            </a>
        </span>
        </div><!--/modal-body-->
    </div>
</div>
<!-- /forget password form -->