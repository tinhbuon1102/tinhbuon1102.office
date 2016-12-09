
<?php 
// include( $_SERVER['DOCUMENT_ROOT'] . '/design/header_beforelogin.php');
?>
 @include('pages.header_beforelogin')
<!--/head-->
<body class="home">
	<div class="viewport">
		<div class="header_wrapper">
			<header id="header">
				<div class="header_container">
					<div class="logo_container">
						<a class="logo" href="{{url('/')}}">Offispo</a>
					</div>
					<!--nav-->

            <?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header_nav_shareuser.php'); ?>
  @if(Auth::check())
  @include('pages.header_nav_shareuser')
  @elseif(Auth::guard('user2')->check())
  <?php $check_user=1; ?>
  @include('pages.header_nav_rentuser')
  @else
  @include('pages.before_login_nav')
  @endif

<!--/nav-->
				</div>
			</header>
		</div>
		<div class="hero-article hero-hiw-page ng-scope">
			<div class="hero-article-content">
				<h1 class="hero-article-title">
					<strong>掲載代行サービス申し込み</strong>
				</h1>
			</div>
			<div class="parallax-container"></div>
		</div>
		<div class="home-top">
			<section id="howitwork" class="white">
				<div class="container">
					<?php renderErrorSuccessHtml($errors);?>
					
					<div class="layout-story-header ng-scope">
						<h3 class="story-title text-center">掲載代行サービスとは？</h3>
						<div class="hiwn-hiwp-copy">
							掲載代行サービスとは、Offispo運営会社があなたに代わり、
							<br class="sp-none">
							セットアップからスペースの掲載まで代行で行うサービスです。
						</div>
					</div>
					<div class="ofsp-benefit">
						<div class="row">
							<div class="col-md-6 hiwn-benefit">
								<div class="hiwn-benefit-icon hiwn-benefit-icon-connect">
									<span class="icon-add-service-icons-setup"></span>
								</div>
								<div class="hiwn-benefit-content">
									<div class="hiwn-benefit-header h4">アカウントのセットアップ</div>
									<div class="hiwn-benefit-copy">直接、審査書類、支払先口座をお送り頂き、アカウントのセットアップを行わせて頂きます。</div>
								</div>
							</div>
							<div class="col-md-6 hiwn-benefit">
								<div class="hiwn-benefit-icon hiwn-benefit-icon-connect">
									<span class="icon-add-service-icons-camera"></span>
								</div>
								<div class="hiwn-benefit-content">
									<div class="hiwn-benefit-header h4">写真撮影</div>
									<div class="hiwn-benefit-copy">よりあなたのオフィスを魅力的に掲載するため、スペースの撮影を行います。</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 hiwn-benefit">
								<div class="hiwn-benefit-icon hiwn-benefit-icon-connect">
									<span class="icon-add-service-icons-building"></span>
								</div>
								<div class="hiwn-benefit-content">
									<div class="hiwn-benefit-header h4">スペース掲載ページ作成</div>
									<div class="hiwn-benefit-copy">提供スペースの内容をお送り頂き、スペース掲載ページを編集行います。</div>
								</div>
							</div>
							<div class="col-md-6 hiwn-benefit">
								<div class="hiwn-benefit-icon hiwn-benefit-icon-connect">
									<span class="icon-add-service-icons-clock"></span>
								</div>
								<div class="hiwn-benefit-content">
									<div class="hiwn-benefit-header h4">スケジュール設定</div>
									<div class="hiwn-benefit-copy">スペース掲載のため、スケジュール設定を行います。</div>
								</div>
							</div>
						</div>
					</div>
					<a id="daiko-form"></a>
				</div>
				<!--/container-->
			</section>
			<section id="hiw-feature" class="gray">
				<div class="container">
					<div class="layout-story-header ng-scope">
						<h3 class="story-title text-center">掲載代行サービスお申込みフォーム</h3>
					</div>
					<div class="service-form">
						<form id="daikobasicinfo" name="DaikoBasicInfo" method="post" action="" class="HomepageAuth-form fl-form large-form">
							<ol>
								<li class="control-group returning-user form-step">
									<div class="row">
										<div class="col-md-3">
											<label for="last_name">
												<span class="require-mark">*</span>
												お名前
											</label>
										</div>
										<div class="col-md-9">
											<div class="input-container input-half">
												<input name="LastName" id="LastName" value="{{old('LastName')}}" ng-model="signup.last_name" type="text" class="validate[required]" aria-invalid="true" placeholder="姓">
											</div>
											<div class="input-container input-half">
												<input name="FirstName" id="FirstName" value="{{old('FirstName')}}" ng-model="signup.first_name" type="text" class="validate[required]" aria-invalid="true" placeholder="名">
											</div>
										</div>
									</div>
									<!--/row-->
								</li>
								<li class="control-group returning-user form-step">
									<div class="row">
										<div class="col-md-3">
											<label for="last_name">
												<span class="require-mark">*</span>
												お名前(ふりがな)
											</label>
										</div>
										<div class="col-md-9">
											<div class="input-container input-half">
												<input name="LastNameKana" id="LastNameKana" value="{{old('LastNameKana')}}" ng-model="signup.last_name" type="text" class="validate[required]" aria-invalid="true" placeholder="姓(ふりがな)">
											</div>
											<div class="input-container input-half">
												<input name="FirstNameKana" id="FirstNameKana" value="{{old('FirstNameKana')}}" ng-model="signup.first_name" type="text" class="validate[required]" aria-invalid="true" placeholder="名(ふりがな)">
											</div>
										</div>
									</div>
									<!--/row-->
								</li>
								<li class="control-group returning-user form-step">
									<div class="row">
										<div class="col-md-3">
											<label for="last_name">
												<span class="require-mark">*</span>
												事業のタイプ
											</label>
										</div>
										<div class="col-md-9">
											<span class="fl-icon-user input-icon">
												<?php echo Form::select('BusinessType',
													getUserBusinessTypes(), old('BusinessType'), ['id' => 'BusinessType', 'class' => 'large-input valid validate[required]', 'required' => 'required', 'placeholder' => '-- 1つ選択 --']);?>
											</span>
										</div>
									</div>
									<!--/row-->
								</li>
								<li class="control-group returning-user form-step">
									<div class="row">
										<div class="col-md-3">
											<label for="last_name">会社名</label>
										</div>
										<div class="col-md-9">
											<span class="fl-icon-user input-icon">
												<input id="NameOfCompany" class="large-input valid" value="{{old('NameOfCompany')}}" type="text" name="NameOfCompany" placeholder="">
											</span>
										</div>
									</div>
									<!--/row-->
								</li>
								<li class="control-group returning-user form-step">
									<div class="row">
										<div class="col-md-3">
											<label for="last_name">部署</label>
										</div>
										<div class="col-md-9">
											<span class="fl-icon-user input-icon">
												<input id="Department" class="large-input valid" value="{{old('Department')}}" type="text" name="Department" placeholder="">
											</span>
										</div>
									</div>
									<!--/row-->
								</li>
								<li class="control-group returning-user form-step">
									<div class="row">
										<div class="col-md-3">
											<label for="last_name">
												<span class="require-mark">*</span>
												メールアドレス
											</label>
										</div>
										<div class="col-md-9">
											<span class="fl-icon-user input-icon">
												<input id="Email" class="large-input validate[required,custom[email]]" value="{{old('Email')}}" type="email" name="Email" placeholder="">
											</span>
										</div>
									</div>
									<!--/row-->
								</li>
								<li class="control-group returning-user form-step">
									<div class="row">
										<div class="col-md-3">
											<label for="last_name">
												<span class="require-mark">*</span>
												電話番号
											</label>
										</div>
										<div class="col-md-9">
											<span class="fl-icon-user input-icon">
												<input id="Tel" class="large-input validate[required,custom[phone]]" value="{{old('Tel')}}" type="text" name="Tel" placeholder="">
												<span class="help">ハイフンなしで入力してください。</span>
											</span>
										</div>
									</div>
									<!--/row-->
								</li>
							</ol>
							<div class="HomepageAuth-submit">
								<button type="submit" class="btn btn-large signup-btn btn-primary">申し込む</button>
								<img src="/ajax-loader.gif" class="loader-img" style="display: none;">
							</div>
							{{ csrf_field() }}
						</form>
					</div>
				</div>
				<!--/container-->
			</section>
		</div>
		<!--/hometop-->
		<!--footer-->
<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/common_footer.php'); ?>
		@include('pages.common_footer')

<!--/footer-->
	</div>
	<!--/viewport-->
	<script src="{{ URL::asset('js/jquery.validationEngine.js') }}"></script>
	<script src="{{ URL::asset('js/jquery.validationEngine-ja.js') }}"></script>
	<link rel="stylesheet" href="{{ URL::asset('css/validationEngine.jquery.css') }}">
	<!--<script src="{{ URL::asset('js/jquery.validate.js?v=1') }}"></script>-->
	<script src="{{ URL::asset('js/KanaMaker.js') }}"></script>
	<script src="{{ URL::asset('js/kana.js') }}"></script>
	<!--<script src="{{ URL::asset('js/assets/custom_edit_form.js') }}" type="text/javascript"></script>-->
	<script>
  jQuery(function(){
	    jQuery("#daikobasicinfo").validationEngine();
  });
</script>
	<!--<script>
		$("#basicinfo").validate({
				  	errorPlacement: function(label, element) { 
						label.addClass('form-error');
						label.insertAfter(element);
			},
			rules: {
			    
			  }
			});
			
			
			 
		</script>-->
	<script>
			$(function(){    
    var convertor = null;
    $("#LastName").click(function(e){
        convertor = new KanaMaker();
    });
    
    $("#LastName").keyup(function(e){
        if(convertor != null){
            convertor.eval(e);
            $("#LastNameKana").val(convertor.Hira());
          
            
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
            $("#FirstNameKana").val(convertor1.Hira());
          
            
        }else if($("#FirstName").val() == ""){
            convertor1 = new KanaMaker(); //reset
        }
    });
});
		</script>
</body>
</html>
