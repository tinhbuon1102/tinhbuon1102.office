<?php
// define('SITE_URL', 'http://office-spot.com/design/')
?>

<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header.php'); ?>
@include('pages.header')
<!--/head-->
<link rel="stylesheet" href="http://office-spot.com/design/js/chosen/chosen.min.css">
<script src="{{ URL::asset('js/assets/custom_edit_form.js') }}" type="text/javascript"></script>
<body class="mypage">
	<div class="viewport">
		<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header_nav_shareuser.php'); ?>
		@include('pages.header_nav_rentuser')

		<div class="main-container">
			<div id="main" class="container fixed-container">

				<?php $error = Session::get('error'); ?>
				<?php $message = Session::get('success'); ?>
				<?php $senttoadmin = Session::get('senttoadmin'); ?>

				@if( isset($error) )
				<div class="alert alert-danger">{!! $error !!}</div>
				@endif @if( isset($message) )
				<div class="alert alert-success">{!! $message !!}</div>
				@endif
				<div id="left-box" class="col_3_5">@include('user2.dashboard.left_nav')</div>
				<!--/leftbox-->
				<div id="samewidth" class="right_side">
					<div id="page-wrapper" class="has_fixed_title">
						<div class="page-header header-fixed">
                        <div class="container-fixed">
							<div class="container-fluid">
								<div class="row">
									<div class="col-xs-6 col-md-6 col-sm-8 clearfix">
										<h1 class="pull-left">
											<i class="fa fa-cogs" aria-hidden="true"></i>
											設定
										</h1>
									</div>
									<div class="col-xs-6 col-md-6 col-sm-4 clearfix pb15 text-right">
										<button id="SubmitBtn" type="submit" class="btn btn-default mt15 dblk-button" data-bind="jqButton: { disabled: !isDirty() }, click: save" role="button">
											<i class="fa fa-floppy-o"></i>
											<span class=""> 更新</span>
										</button>
									</div>
									<!--/col-xs-6-->
								</div>
							</div>
                            </div>
						</div>
						<!--/page-header header-fixed-->
						<div id="feed">
                       
							<section class="feed-event recent-follow feed-box">
                            <?php 
$user = Auth::guard('user2')->user(); 
 if (!\App\User2::isProfileFullFill($user)){?>
                        <div class="dashboard-warn-text">
									<div class="dashboard-must-validation">
										<i class="icon-warning-sign fa awesome"></i>
										<div class="warning-heading">
                                        <ul class="list-disc">
                                        @if( empty($user['BirthYear']) )
                                        <li>生年月日が設定されていません</li>
                                        @endif
                                        @if( empty($user['Sex']) )
                                        <li>性別が設定されていません</li>
                                        @endif
                                        @if( empty($user['Tel']) )
                                        <li>電話番号が登録されていません</li>
                                        @endif
                                        @if( empty($user['PostalCode']) )
                                        <li>郵便番号が登録されていません</li>
                                        @endif
                                        @if( empty($user['Prefecture']) )
                                        <li>都道府県が登録されていません</li>
                                        @endif
                                        @if( empty($user['City']) )
                                        <li>市区町村が登録されていません</li>
                                        @endif
                                        @if( empty($user['Address1']) )
                                        <li>番地等が登録されていません</li>
                                        @endif
                                        </ul>
                                        </div>
										</div>
								</div>
                        <?php }?>
                        @if(empty($user->card_name) || $paypalStatus == false )
                        <div class="dashboard-warn-text">
									<div class="dashboard-must-validation">
										<i class="icon-warning-sign fa awesome"></i>
										<div class="warning-heading">
                                       支払方法が追加されていません
                                        </div>
										</div>
								</div>
                                @endif
								<div class="space-setting-content">
									@if($errors->all())
									<div class="alert alert-danger fade in">
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
										@foreach($errors->all() as $error) {{$error}} @endforeach
									</div>
									@endif
									<div class="form-container">
										@if( isset($senttoadmin) )
										<div class="alert alert-success">{!! $senttoadmin !!}</div>
										@endif
										<div class="user-setting">
											<!--if confirmation of identity is not proceed yet-->
                                                <?php if ($user->IsAdminApproved == 'No') {?>
												<fieldset>
												<div class="Signup-sectionHeader">
													<legend class="signup-sectionTitle">
														本人確認情報
														<!--5%-->
													</legend>
												</div>
                                                    <?php if(!$user->SentToAdmin) {?>
                                                    <div class="alert-identity-message">本人確認書類が提出されていません。本人証明が完了後、アカウントの制限は解除されます。</div>
												<div class="btn-group">
													<a href="{{url('/')}}/RentUser/Dashboard/Identify/Upload" class="btn ocean-btn">確認書類を提出する</a>
												</div>
                                                    <?php } else {?>
                                                    <div class="alert-identity-message">只今本人確認中です。本人確認が終わり次第、アカウントの制限は解除されます。</div>
												<div class="btn-group">
													<a href="{{url('/')}}/RentUser/Dashboard/Identify/Upload" class="btn ocean-btn">確認書類を再送する</a>
												</div>
                                                    <?php }?>
												</fieldset>
											<div class="hr"></div>
                                                 <?php }?>
												<!--/if confirmation of identity is not proceed yet-->
											<fieldset>
												<div class="Signup-sectionHeader">
													<legend class="signup-sectionTitle">
														アカウント情報
														<!--5%-->
													</legend>
												</div>
												<div class="form-field two-inputs">
													<div class="input-container input-half">
														<label for="userName">ユーザー名</label>
														<input name="UserName" value="{{$user->UserName}}" type="text" data-target="signup-username" readonly disabled>
													</div>
													<div class="input-container input-half">
														<form method="post" id="chgemail" action="/RentUser/Dashboard/ChangeEmail">
															<label for="Email">
																メールアドレス&nbsp;
																<a href="#!" class="label-link" id="changeEmail">[変更]</a>
															</label>
															<input name="Email" value="{{$user->Email}}" type="email" id="Email" data-target="signup-email" required readonly disabled>
															<button type="submit" class="btn btn-info changeEmailBtn" style="display: none;">メールアドレスを変更</button>
														</form>
														<!--if email is not verified yet-->
                                                             <?php if($user->IsEmailVerified=="No"){ ?><div class="no-verify-alert">
															<span class="not-verify-yet">あなたのメールアドレスは認証されてません。</span>
															<a href="#" class="verify-now btn btn-info" id="verifyEmail">メールアドレスを認証</a>
														</div><?php } ?>
                                                            <!--/if email is not verified yet-->
													</div>
												</div>
												<!--/form-field-->
											</fieldset>
											<div class="hr"></div>
											<fieldset>
												<form method='post' class="fl-form" id='changepassword' action="/RentUser/Dashboard/ChangePassword">
													<div class="Signup-sectionHeader">
														<legend class="signup-sectionTitle">パスワード</legend>
													</div>
													<div class="form-field two-inputs">
														<div class="input-container input-half">
															<label for="CurrentPass">現在のパスワード</label>
															<input id="oldPasswd" name="oldpassword" type="password">
														</div>
													</div>
													<!--/form-field-->
													<div class="form-field two-inputs">
														<div class="input-container input-half">
															<label for="NewPass">新しいパスワード</label>
															<input id="newPasswd1" name="password" type="password">
														</div>
													</div>
													<!--/form-field-->
													<div class="form-field two-inputs">
														<div class="input-container input-half">
															<label for="ConfirmPass">新しいパスワード(確認)</label>
															<input id="newPasswd2" name="password_confirmation" type="password">
														</div>
													</div>
													<!--/form-field-->
													<div class="set-btn">
														<button id="passwordSettingsSubmitBtn" class="btn btn-info submitSettingsBtn" type="submit">パスワードを変更</button>
													</div>
												</form>
											</fieldset>
											<div class="hr"></div>
											<form id="basicinfo" class="fl-form" action="{{ url('RentUser/Dashboard/BasicInfo/EditData') }}" method="post">
												{{ csrf_field() }}
												<fieldset>
													<div class="Signup-sectionHeader">
														<legend class="signup-sectionTitle">
															お名前
															<!--5%-->
														</legend>
													</div>
													<div class="form-field two-inputs">
														<div class="input-container input-half">
															<label for="last_name">
																<span class="require-mark">*</span>
																姓
															</label>
															<input name="LastName" value="{{$user->LastName}}" id="LastName" value="" required="" ng-model="signup.last_name" type="text" class="ng-pristine ng-untouched ng-invalid ng-invalid-required" aria-invalid="true" aria-required="true" placeholder="佐藤">
														</div>
														<div class="input-container input-half">
															<label for="last_name">
																<span class="require-mark">*</span>
																名
															</label>
															<input name="FirstName" value="{{$user->FirstName}}" id="FirstName" value="" required="" ng-model="signup.first_name" type="text" class="ng-pristine ng-invalid ng-invalid-required ng-untouched" aria-invalid="true" aria-required="true" placeholder="太郎">
														</div>
													</div>
													<!--/form-field-->
													<div class="form-field two-inputs">
														<div class="input-container input-half">
															<label for="last_name">
																<span class="require-mark">*</span>
																姓(ふりがな)
															</label>
															<input name="LastNameKana" value="{{$user->LastNameKana}}" id="LastNameKana" value="" required="" ng-model="signup.last_name_kana" type="text" class="ng-pristine ng-untouched ng-invalid ng-invalid-required" aria-invalid="true" aria-required="true" placeholder="さとう">
														</div>
														<div class="input-container input-half">
															<label for="last_name">
																<span class="require-mark">*</span>
																名(ふりがな)
															</label>
															<input name="FirstNameKana" value="{{$user->FirstNameKana}}" id="FirstNameKana" value="" required="" ng-model="signup.first_name_kana" type="text" class="ng-pristine ng-invalid ng-invalid-required ng-untouched" aria-invalid="true" aria-required="true" placeholder="たろう">
														</div>
													</div>
													<!--/form-field-->
												</fieldset>
												<div class="hr"></div>
												<fieldset>
													<div class="Signup-sectionHeader">
														<legend class="signup-sectionTitle">生年月日・性別</legend>
													</div>
													<div class="form-field two-inputs">
														<div class="input-container input-half">
															<label for="last_name">
																<span class="require-mark">*</span>
																生年月日
																<!--5%-->
															</label>
															<select required name="BirthYear" id="BirthYear" class="wd-auto">
																<?php
																$now = date("Y");
																for ( $i = 1950; $i <= $now; $i ++ )
																:
																	?>
																<option value="<?php echo $i;?>">
																	<?php echo $i;?>
																</option>
																<?php endfor;?>
															</select>
															年
															<select name="BirthMonth" id="BirthMonth" class="wd-auto">
																<?php
																for ( $i = 1; $i <= 12; $i ++ )
																:
																	?>
																<option value="<?php echo $i;?>">
																	<?php echo $i;?>
																</option>
																<?php endfor;?>
															</select>
															月
															<select name="BirthDay" id="BirthDay" class="wd-auto">
																<?php
																for ( $i = 1; $i <= 31; $i ++ )
																:
																	?>
																<option value="<?php echo $i;?>">
																	<?php echo $i;?>
																</option>
																<?php endfor;?>
															</select>
															日
														</div>
														<div class="input-container input-half">
															<label for="sex">
																<span class="require-mark">*</span>
																性別
																<!--5%-->
															</label>
															<select required name="Sex" id="Sex" class="wd-80">
																<option value="男性" selected>男性</option>
																<option value="女性">女性</option>
															</select>
														</div>
													</div>
													<!--/form-field-->
												</fieldset>
												<div class="hr"></div>
												<fieldset>
													<div class="Signup-sectionHeader">
														<legend class="signup-sectionTitle">電話番号</legend>
													</div>
													<div class="form-field two-inputs">
														<div class="input-container input-half">
															<label for="phoneNumber">
																<span class="require-mark">*</span>
																電話番号
																<!--5%-->
															</label>
															<input required name="Tel" value="{{$user->Tel}}" id="phone-number" type="text" 　class="ng-pristine ng-untouched ng-invalid-required" aria-required="true">
														</div>
													</div>
													<!--/form-field-->
												</fieldset>
												<div class="hr"></div>
												<fieldset>
													<div class="Signup-sectionHeader">
														<legend class="signup-sectionTitle">
															住所
															<!--10%-->
														</legend>
													</div>
													<div class="form-field two-inputs">
														<div class="input-container input-half">
															<label for="zip">
																<span class="require-mark">*</span>
																郵便番号
															</label>
															<input required name="PostalCode" value="{{$user->PostalCode}}" id="zip" type="text" 　class="ng-pristine ng-untouched ng-invalid-required" aria-required="true">
														</div>
													</div>
													<!--/form-field-->
													<div class="form-field two-inputs">
														<div class="input-container input-half">
															<label for="prefecture">
																<span class="require-mark">*</span>
																都道府県
															</label>
															<?php
															
echo Form::select('Prefecture', getPrefectures(), $user->Prefecture, [
																	'id' => 'Prefecture',
																	'class' => 'ng-pristine ng-untouched ng-invalid-required',
																	'required' => 'required'
															]);
															?>
														</div>
														<div class="input-container input-half">
															<label for="city">
																<span class="require-mark">*</span>
																市区町村
															</label>
															<input name="City" required value="{{$user->City}}" id="District" type="text" class="ng-pristine ng-untouched ng-invalid-required" aria-required="true" placeholder="市区町村">
														</div>
													</div>
													<!--/form-field-->
													<div class="form-field">
														<div class="input-container">
															<label for="Addr">
																<span class="require-mark">*</span>
																番地等
															</label>
															<input name="Address1" required value="{{$user->Address1}}" id="Addr" value="" required="" ng-model="signup.addr" type="text" class="ng-pristine ng-untouched ng-invalid-required" aria-required="true" placeholder="番地等">
														</div>
													</div>
													<!--/form-field-->
												</fieldset>
												<div class="hr"></div>
												<fieldset>
													<div class="Signup-sectionHeader">
														<legend class="signup-sectionTitle">個人事業・法人情報</legend>
													</div>
													<div class="form-field two-inputs">
														<div class="input-container input-half">
															<label for="typeOrg">
																<span class="require-mark">*</span>
																事業主種類
																<!--5%-->
															</label>
															<select id="UserType" name="UserType" required class="old_ui_selector">
																<option value="個人事業主" selected="">個人事業主
																	<!--5%--></option>
																<option value="法人">法人</option>
															</select>
														</div>
														<div class="input-container input-half">
															<label for="typeBusiness">
																<span class="require-mark">*</span>
																事業のタイプ
																<!--5%-->
															</label>
															<select required id="BusinessType" name="BusinessType" class="old_ui_selector">
																<option value="カテゴリを選択" selected="">Choose business category</option>
																<option value="インターネット・ソフトウェア">インターネット・ソフトウェア</option>
																<option value="コンサルティング・ビジネスサービス">コンサルティング・ビジネスサービス</option>
																<option value="コンピュータ・テクノロジー">コンピュータ・テクノロジー</option>
																<option value="メディア/ニュース/出版">メディア/ニュース/出版</option>
																<option value="園芸・農業">園芸・農業</option>
																<option value="化学">化学</option>
																<option value="教育">教育</option>
																<option value="金融機関">金融機関</option>
																<option value="健康・医療・製薬">健康・医療・製薬</option>
																<option value="健康・美容">健康・美容</option>
																<option value="工学・建設">工学・建設</option>
																<option value="工業">工業</option>
																<option value="小売・消費者商品">小売・消費者商品</option>
																<option value="食品・飲料">食品・飲料</option>
																<option value="政治団体">政治団体</option>
																<option value="地域団体">地域団体</option>
																<option value="電気通信">電気通信</option>
																<option value="保険会社">保険会社</option>
																<option value="法律">法律</option>
																<option value="輸送・運輸">輸送・運輸</option>
																<option value="旅行・レジャー">旅行・レジャー</option>
																<option value="デザイン">デザイン</option>
																<option value="写真">写真</option>
																<option value="映像">映像</option>
																<option value="その他">その他</option>
															</select>
														</div>
													</div>
													<!--/form-field-->
													<div class="form-field" id="company_wraper" style="display: none;">
														<div class="input-container">
															<label for="NameOfCompany">
																<span class="require-mark">*</span>
																会社名
															</label>
															<input name="NameOfCompany" required="" value="{{$user->NameOfCompany}}" id="NameOfCompany" type="text" aria-required="true" placeholder="Company Name">
														</div>
													</div>
												</fieldset>
												<!--<div class="hr"></div>-->
												<fieldset>
													<div class="Signup-sectionHeader">
														<div class="row">
															<div class="col-xs-6 col-md-6 col-sm-8">
																<legend class="signup-sectionTitle"><?=trans("common.My Payment Method")?>
																	<!--支払情報-->
																</legend>
															</div>
															@if(empty($user->card_name) || $paypalStatus == false )
															<div class="col-xs-6 col-md-6 col-sm-4 clearfix pb15 text-right">
																<a href="#modal5" class="btn btn-default mt15 dblk-button mgt-0">
																	<i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                 <?=trans("common.Add New Payment Method")?></a>
															</div>
															@endif
														</div>
													</div>
													<div class="Settings-row">
														<div class="Settings-item">
															<ul class="PaymentMethods">
																@if(empty($user->card_name) and $paypalStatus == false )
																<li class="PaymentMethods-item form-step">
																	<div class="no-paymentmethod">
																		<i class="fa fa-exclamation-circle" aria-hidden="true"></i>
																		支払方法はまだ追加されてません。
																	</div>
																</li>
																@endif @if( empty($user->card_name) ) @else
																<li class="PaymentMethods-item form-step">
																	<div class="PaymentMethods-details">
																		<div class="PaymentMethods-vendor">
																			<span class="PaymentMethods-icon payment-icon-creditcard type-visa"></span>
																		</div>
																		<div class="PaymentMethods-summary">
																			<div class="PaymentMethods-id">{{$user->modified_card_number}}</div>
																			<div class="form-error"></div>
																			<div class="form-success"></div>
																		</div>
																	</div>
																	<div class="PaymentMethods-controls">
																		<div class="PaymentMethods-verify">
																			<span class="PaymentMethods-edit">
																				<a href="#modal6">編集</a>
																				|
																				<a href="{{Url('/')}}/RentUser/Dashboard/BasicInfo/remove">削除</a>
																			</span>
																		</div>
																	</div>
																</li>
																@endif @include('user2.dashboard.paypal-authenticate')
															</ul>
														</div>
													</div>
												</fieldset>
										
										</div>
										</form>
									</div>
									<!--/form-container-->
								</div>
								<!--/space-setting-content-->
							</section>
						</div>
						<!--/feed-->
						<!--footer-->
						@include('pages.dashboard_user2_footer')
						<!--/footer-->
						<div id="header-payment-modal" class="remodal" data-remodal-id="modal5" data-remodal-options="hashTracking:false">
							<div class="HomepageAuth-inner">
								<div class="modal-header dialog-title-bar">
									<div class="modal-header-payment">支払い方法を追加</div>
									<button data-remodal-action="close" class="remodal-close">
										<img src="/images/cross-icons.png" />
									</button>
								</div>
								<div class="modal-body">
									<form id="basicinfo1" class="fl-form" action="{{ url('RentUser/Dashboard/BasicInfo/Edit') }}" method="post">
										<input type="hidden" name="_token" id="" value="{{ csrf_token() }}">
										<div id="SelectPayment">
											<div class="space-setting-content">
												<div class="form-container">
													<ul class="payment_methods methods">
														@if( empty($user->card_name) )
														<li class="payment_method_cc">
															<span class="radio-wrap clearfix">
																<input id="payment_method_cc" type="radio" class="input-radio" name="payment_method" value="cc" onclick="entryChange1();" checked="checked">
																<label for="payment_method_cc"><?=trans("common.Credit Card")?></label>
															</span>
															<div id="ccbox" class="payment_box payment_method_cc">
																<p>クレジットカード情報を入力し、クレジットカード決済を設定しましょう。</p>
																<div class="mgb-20">
																	<div class="form-field">
																		<div class="input-container">
																			<label for="typeOrg"> カード名義 </label>
																			<input name="card_name" value="" id="card_name" value="" ng-model="signup.card_name" type="text" class="ng-pristine ng-untouched ng-invalid-required" required aria-required="true" placeholder="TARO SATO">
																		</div>
																	</div>
																	<div class="form-field">
																		<div class="input-container">
																			<label for="typeOrg"> カード番号 </label>
																			<input name="card_number" value="" id="card_number" value="" ng-model="signup.card" type="text" class="ng-pristine ng-untouched ng-invalid-required" aria-required="true" required placeholder="">
																		</div>
																	</div>
																	<div class="form-field two-inputs card_form">
																		<label for="typeBusiness"> カード有効期限 </label>
																		<div class="input-container input_with_unit">
																			<span class="min_selector">
																				<select id="exp_month" name="exp_month" class="old_ui_selector">
                                                                                    <option value="">-</option>
																					<option value="1" @if($user->exp_month==1) @endif>1</option>
																					<option value="2" @if($user->exp_month==2) @endif>2</option>
																					<option value="3" @if($user->exp_month==3) @endif>3</option>
																					<option value="4" @if($user->exp_month==4) @endif>4</option>
																					<option value="5" @if($user->exp_month==5) @endif>5</option>
																					<option value="6" @if($user->exp_month==6) @endif>6</option>
																					<option value="7" @if($user->exp_month==7) Selected='selected' @endif>7</option>
																					<option value="8" @if($user->exp_month==8) @endif>8</option>
																					<option value="9" @if($user->exp_month==9) @endif>9</option>
																					<option value="10" @if($user->exp_month==10) @endif>10</option>
																					<option value="11" @if($user->exp_month==11) @endif>11</option>
																					<option value="12" @if($user->exp_month==12) @endif>12</option>
																				</select>
																				月
																			</span>
																			<span class="min_selector">
																				<select id="exp_year" name="exp_year" class="old_ui_selector">
                                                                                <option value="">-</option>
																<?php for($date=date('Y');$date<date('Y')+10;$date++): ?>
																<option value="<?php echo $date;?>" @if($user->
																	exp_year==$date)  @endif>
																	<?php echo $date;?>
																</option>
																<?php endfor; ?>
															</select>
																				年
																			</span>
																		</div>
																	</div>
																	<div class="form-field two-inputs">
																		<div class="input-container input-half">
																			<label for="typeOrg"> セキュリティコード </label>
																			<input name="security_code" value="{{$user->security_code}}" id="security_code" value="" ng-model="signup.card" type="text" class="ng-pristine ng-untouched ng-invalid-required" required aria-required="true" placeholder="">
																		</div>
																	</div>
																</div>
																<button class="btn btn-default mt15 paypal-btn mgt-0">
																	<i class="fa fa-credit-card-alt" aria-hidden="true"></i>
																	クレジットカードを追加
																</button>
															</div>
														</li>
														@endif @if($paypalStatus == false )
														<li class="payment_method_paypal">
															<span class="radio-wrap clearfix">
																<input id="payment_method_paypal" type="radio" class="input-radio" name="payment_method" value="paypal" onclick="entryChange1();">
																<label for="payment_method_paypal">Paypal</label>
															</span>
															<div id="ppbox" class="payment_box payment_method_paypal">
																<p class="mgb-20">下のボタンをクリックすると、Paypalサイトに推移します。Paypalアカウントをまだお持ちでない方は登録、お持ちの方はログインをし、Paypalにての決済設定をしましょう。</p>
																<span class="payment-options paypal-big"></span>
																<a href="#" onclick="return false;" id="ppAdd" class="btn mt15 paypal-btn mgt-0">
																	<i class="fa fa-paypal" aria-hidden="true"></i>
																	Paypal
																</a>
																<img style="display: none;" id="ppLoader" alt="paypal Loading..." src="https://cdn3.f-cdn.com/img/ajax-loader.gif?v=62d3d0c60d4c33ef23dcefb9bc63e3a2&amp;m=6">
															</div>
														</li>
														@endif
													</ul>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
						<!--edit card info-->
						<div id="header-payment-modal" class="remodal" data-remodal-id="modal6" data-remodal-options="hashTracking:false">
							<div class="HomepageAuth-inner">
								<div class="modal-header dialog-title-bar">
									<div class="modal-header-payment">カード情報を編集</div>
									<button data-remodal-action="close" class="remodal-close">
										<img src="/images/cross-icons.png" />
									</button>
								</div>
								<div class="modal-body">
									<form id="basicinfo2" class="fl-form" action="{{ url('RentUser/Dashboard/BasicInfo/Edit') }}" method="post">
										<input type="hidden" name="_token" id="" value="{{ csrf_token() }}">
										<div id="SelectPayment">
											<div class="space-setting-content">
												<div class="form-container">
													<ul class="payment_methods methods">
														<li class="payment_method_cc">
															<span class="radio-wrap clearfix">
																<label for="payment_method_cc">クレジットカード編集</label>
															</span>
															<div class="payment_box payment_method_cc">
																<div class="mgb-20">
																	<div class="form-field">
																		<div class="input-container">
																			<label for="typeOrg"> カード名義 </label>
																			<input name="card_name" value="{{$user->card_name}}" id="card_name" value="" ng-model="signup.card_name" type="text" class="ng-pristine ng-untouched ng-invalid-required" aria-required="true" placeholder="TARO SATO">
																		</div>
																	</div>
																	<div class="form-field">
																		<div class="input-container">
																			<label for="typeOrg"> カード番号 </label>
																			<input name="card_number" value="{{$user->modified_card_number}}" id="card_number" value="" ng-model="signup.card" type="text" class="ng-pristine ng-untouched ng-invalid-required" aria-required="true" placeholder="">
																		</div>
																	</div>
																	<div class="form-field two-inputs card_form">
																		<label for="typeBusiness"> カード有効期限 </label>
																		<div class="input-container input_with_unit">
																			<span class="min_selector">
																				<select id="exp_month" name="exp_month" class="old_ui_selector">
																					<option value="1" @if($user->exp_month==1) Selected='selected' @endif>1</option>
																					<option value="2" @if($user->exp_month==2) Selected='selected' @endif>2</option>
																					<option value="3" @if($user->exp_month==3) Selected='selected' @endif>3</option>
																					<option value="4" @if($user->exp_month==4) Selected='selected' @endif>4</option>
																					<option value="5" @if($user->exp_month==5) Selected='selected' @endif>5</option>
																					<option value="6" @if($user->exp_month==6) Selected='selected' @endif>6</option>
																					<option value="7" @if($user->exp_month==7) Selected='selected' @endif>7</option>
																					<option value="8" @if($user->exp_month==8) Selected='selected' @endif>8</option>
																					<option value="9" @if($user->exp_month==9) Selected='selected' @endif>9</option>
																					<option value="10" @if($user->exp_month==10) Selected='selected' @endif>10</option>
																					<option value="11" @if($user->exp_month==11) Selected='selected' @endif>11</option>
																					<option value="12" @if($user->exp_month==12) Selected='selected' @endif>12</option>
																				</select>
																				月
																			</span>
																			<span class="min_selector">
																				<select id="exp_year" name="exp_year" class="old_ui_selector">
																<?php for($date=date('Y');$date<date('Y')+10;$date++): ?>
																<option value="<?php echo $date;?>" @if($user->
																	exp_year==$date) Selected='selected' @endif>
																	<?php echo $date;?>
																</option>
																<?php endfor; ?>
															</select>
																				年
																			</span>
																		</div>
																	</div>
																	<div class="form-field two-inputs">
																		<div class="input-container input-half">
																			<label for="typeOrg"> セキュリティコード </label>
																			<input name="security_code" value="{{$user->security_code}}" id="security_code" value="" ng-model="signup.card" type="text" class="ng-pristine ng-untouched ng-invalid-required" aria-required="true" placeholder="">
																		</div>
																	</div>
																</div>
																<button class="btn btn-default mt15 paypal-btn mgt-0">更新</button>
															</div>
														</li>
													</ul>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
						<!--/edit card info-->
					</div>
					<!--/page-wrapper-->
				</div>
				<!--/right_side-->
			</div>
		</div>
		<!--/main-container-->
	</div>
	<!--/viewport-->
	<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script> -->
	<script src="<?php echo SITE_URL?>js/chosen/chosen.jquery.min.js" type="text/javascript"></script>
	<script src="<?php echo SITE_URL?>js/chosen/chosen.proto.min.js" type="text/javascript"></script>
	<script src="<?php echo SITE_URL?>js/chosen/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?php echo SITE_URL?>js/remodal/remodal.min.js"></script>
	<script>
	jQuery('[data-remodal-id=modal5]').remodal();
	jQuery('[data-remodal-id=modal6]').remodal();
	</script>
	<script type="text/javascript">
	function entryChange1(){
		radio = document.getElementsByName('payment_method') 
		if(radio[0].checked) {
			//フォーム
			document.getElementById('ccbox').style.display = "";
			document.getElementById('ppbox').style.display = "none";
		}else if(radio[1].checked) {
			//フォーム
			document.getElementById('ccbox').style.display = "none";
			document.getElementById('ppbox').style.display = "";
		}
	}
	
	//オンロードさせ、リロード時に選択を保持
	window.onload = entryChange1;
</script>
	<script src="{{ URL::asset('js/jquery.validate.js?v=1') }}"></script>
	<script src="{{ URL::asset('js/jquery.validate.js?v=1') }}"></script>
	<script src="{{ URL::asset('js/KanaMaker.js') }}"></script>
	<script src="{{ URL::asset('js/kana.js') }}"></script>
	{{--
	<script type="text/javascript" src="https://js.webpay.jp/v1/"></script>
	<script>
		var webpayResponseHandler = function(status, response) {
			var form = $(".payment_box");
			if (response.error) {
				// 必要に応じてエラー処理を入れてください
				form.find("button").prop("disabled", false);
			} else {
				// 伝送させたくない情報をフォームから削除する
				$("#card_name").removeAttr("name");
				$("#card_number").removeAttr("name");
				$("#exp_month").removeAttr("name");
				$("#exp_year").removeAttr("name");
				$("#security_code").removeAttr("name");

				var token = response.id;
				var input = document.createElement("input");
				input.type = "hidden";
				input.name = "token";
				input.value = token;
				$(input).appendTo(form);

				form.get(0).submit();
			}
		};
	</script>
	--}}
	<script>
	$=jQuery.noConflict();

	jQuery.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
    }
});

		function changePwd()
		{
			var $form = jQuery('#changepassword'),
    data1 = $form.serialize(),
    url = $form.attr("action");
    jQuery.ajax({
        type: "POST",
        url : url,
            data : { formData:data1 },
        success: function(data){ // What to do if we succeed
           
            if(data.success) {
				alert("パスワードが変更されました。");

            }
            else if(!data.matched)
            {
              alert("現在のパスワードが合っていません。");
            }
			else{
				alert(JSON.stringify(data));
			}
        },
        error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
           
            alert(JSON.stringify(jqXHR));
            console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
        }
    },"json");
		}


			function changemail()
		{
			var $form = $('#chgemail'),
    data1 = $form.serialize(),
    url = $form.attr("action");
    $.ajax({
        type: "POST",
        url : url,
            data : { formData:data1 },
        success: function(data){ // What to do if we succeed
           
            if(data.success) {
				alert("メールアドレスの変更が完了しました。変更先のメールアドレスにメールが送信されましたので、ご確認頂き、メール認証を完了させて下さい。");

            }
           
        },
        error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
           
            alert(JSON.stringify(jqXHR));
            console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
        }
    },"json");
		}
	
		
	</script>
	<script>
	jQuery(function($){    

		$("#basicinfo").validate({
		  	errorPlacement: function(label, element) { 
				label.addClass('form-error');
				label.insertAfter(element);
		},
		rules: {
		    
		  }
		});
		
		$("#basicinfo1").validate({
		  	errorPlacement: function(label, element) { 
				label.addClass('form-error');
				label.insertAfter(element);
		},
		rules: {
		    
		  }
		});
		$("#basicinfo2").validate({
		  	errorPlacement: function(label, element) { 
				label.addClass('form-error');
				label.insertAfter(element);
		},
		rules: {
		    
		  }
		});
		
		$("#changepassword").validate({
				  	errorPlacement: function(label, element) { 
						label.addClass('form-error');
						label.insertAfter(element);
			},
			rules: {
			    
				oldpassword : {
					required : true
                },
				password : {
                    minlength : 5,
					required : true
                },
                password_confirmation : {
                    minlength : 5,
                    equalTo : "#newPasswd1",
 					required : true
               }
			  },
        submitHandler: function(label){
                             changePwd();
        }

			});
		
			$("#chgemail").validate({
				  	errorPlacement: function(label, element) { 
						label.addClass('form-error');
						label.insertAfter(element);
			},
			
        submitHandler: function(label){
                             changemail();
        }

			});
			
    var convertor = null;
    $("#LastName").click(function(e){
        convertor = new KanaMaker();
    });
    
    $("#LastName").keyup(function(e){
        if(convertor != null){
            convertor.eval(e);
            $("#LastNameKana").val(convertor.Kana());
          
            
        }else if($("#LastName").val() == ""){
            convertor = new KanaMaker(); //reset
        }
    });
	
	var convertor1 = null;
    $("#FirstName").click(function(e){
        convertor1 = new KanaMaker();
    });
    
    $("#FirstName").keyup(function(e){
        if(convertor1 != null){
            convertor1.eval(e);
            $("#FirstNameKana").val(convertor1.Kana());
          
            
        }else if($("#FirstName").val() == ""){
            convertor1 = new KanaMaker(); //reset
        }
    });
});
		</script>
	<script>
				jQuery("#changeEmail").click(function()
		{
			jQuery('.changeEmailBtn').show();
			jQuery('#Email').removeAttr( "readonly" );
			jQuery('#Email').removeAttr( "disabled" );
		});
		jQuery("#verifyEmail").click(function()
		{
			jQuery.ajax({
        type: "get",
        url : "/RentUser/Dashboard/SendVerifyEmail",
        success: function(data){ // What to do if we succeed
           
            if(data.success) {
				alert("メールアドレス認証確認メールが送信されました。");

            }
           
        },
        error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
           
            console.log(JSON.stringify(jqXHR));
            console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
        }
    },"json");
		});
		</script>
	<script>
		jQuery(document).ready(function($) {
	$('body').on('click', '#SubmitBtn', function(){
		$('form#basicinfo').submit();
	});
	$('#BirthDay').val("{{$user->BirthDay}}");
	$('#BirthMonth').val("{{$user->BirthMonth}}");
	$('#BirthYear').val("{{$user->BirthYear}}");
	$('#Sex').val("{{$user->Sex}}");
	$('#BusinessType').val("{{$user->BusinessType}}");
	$('#UserType').val("{{$user->UserType}}");

	function showHideNameOfCompany(){
		if ($('#UserType').val() == '法人')
		{
			$('#company_wraper').show();
		}
		else {
			$('#NameOfCompany').val('');
			$('#company_wraper').hide();
		}
	}
	$('body').on('change', '#UserType', function(){
		showHideNameOfCompany();
	});

	showHideNameOfCompany();
	
});
	</script>
</body>
</html>
