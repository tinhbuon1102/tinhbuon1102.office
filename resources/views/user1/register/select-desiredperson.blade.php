
<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header_beforelogin.php'); ?>
@include('pages.header_beforelogin')
<link rel="stylesheet" href="<?php echo SITE_URL?>js/chosen/chosen.css">

<!--/head-->
<body class="selectPage rentuser sharepage">
	<div class="viewport">
		<div class="header_wrapper primary-navigation-section">
			<header id="header">
				<div class="header_container dark">
					<div class="logo_container">
						<a class="logo" href="index.html">Offispo</a>
					</div>
				</div>
			</header>
		</div>
		<div class="main-container">
			<div id="main" class="container">
				<h1 class="page-title">
					About Desired Person for your office
					<!--出会いたい人材について-->
				</h1>
				<p class="sub-title">
					To provide matched office space to rentuser,tell me your desired person.
					<!--マッチングの為の出会いたい人材情報を入力して下さい。-->
				</p>
				<div class="form-container">
					<form id="DesiredPerson" method="post">
					{{ csrf_field() }} 					
					<fieldset>
						<div class="Signup-sectionHeader">
							<legend class="signup-sectionTitle">
								Desired person
								<!--スペースシェアに含まれる設備-->
							</legend>
						</div>
						<div class="form-field two-inputs no-btm-border no-btm-pad">
							<div class="input-container input-half">
								<label for="welcome_business_kind">What kind of business person welcome?<!--どんな職種が好ましいか-->
								</label> <select id="BusinessKind_welcome" name="BusinessKindWelcome" class="old_ui_selector chosen-select">
									<option value="" selected="">Choose business type</option>
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
									<option value="特に無し">特に無し</option>
								</select>
							</div>
							<div class="input-container input-half">
								<label for="welcome_business_kind">Skills</label> <select data-placeholder="Choose business type" style="width: 350px;" class="chosen-select" id="skill" name="Skills[]" multiple>
									<option value=""></option>
									<optgroup label="制作用ツール、DTPソフト">
										<option value="Photoshop">Photoshop</option>
										<option value="Illustrator">Illustrator</option>
										<option value="Dreamweaver">Dreamweaver</option>
										<option value="Wordpress">Wordpress</option>
										<option value="Flash">Flash</option>
									</optgroup>
									<optgroup label="デザイン技術">
										<option value="Webデザイン">Webデザイン</option>
										<option value="グラフィックデザイン">グラフィックデザイン</option>
										<option value="3Dデザイン">3Dデザイン</option>
									</optgroup>
									<optgroup label="開発技術">
										<option value="IT・Web系技術">IT・Web系技術</option>
										<option value="アプリケーション開発技術">アプリケーション開発技術</option>
									</optgroup>
									<optgroup label="基本事務ソフト">
										<option value="Excel">Excel</option>
										<option value="Power Point">Power Point</option>
										<option value="Words">Words</option>
									</optgroup>
									<optgroup label="ビジネススキル">
										<option value="事務スキル">事務スキル</option>
										<option value="事務スキル">事務スキル</option>
										<option value="営業スキル">営業スキル</option>
										<option value="コンサルティング">コンサルティングスキル</option>
										<option value="経営スキル">経営スキル</option>
										<option value="企画力">企画力</option>
										<option value="交渉力">交渉力</option>
										<option value="マーケティング">マーケティング力</option>
										<option value="プレゼンテーション">プレゼンテーション力</option>
										<option value="プロジェクト・マネージメント">プロジェクト・マネージメント</option>
										<option value="情報収集力">情報収集力</option>

									</optgroup>
									<optgroup label="語学">
										<option value="英語">英語</option>
										<option value="中国語">中国語</option>
										<option value="韓国語">韓国語</option>
										<option value="フランス語">フランス語</option>
										<option value="フランス語">イタリア語</option>
										<option value="スペイン語">スペイン語</option>
									</optgroup>
								</select>
							</div>
						</div>
						<!--/form-field-->
					</fieldset>
					<div class="hr"></div>
					<div class="btn-next-step">
						<button id="saveBasicInfo" class="btn btn-info input-basicinfo-button">Next</button>
					</div>
					<div class="row next-step">
						<div class="span12 align-r">
							<a href="#">Skip this step</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!--footer-->
	<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/common_footer.php'); ?>
	@include('pages.common_footer')
	<!--/footer-->
</div>
<!--/viewport-->

	<!-- Typehead -->
	<script src="http://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.10.4/typeahead.bundle.min.js"></script>
	<script src="<?php echo SITE_URL?>js/typeahead.tagging.js"></script>
	<script src="<?php echo SITE_URL?>js/chosen/chosen.jquery.js" type="text/javascript"></script>
	
	<script src="<?php echo SITE_URL?>js/assets/custom_edit_form.js" type="text/javascript"></script>
	<script>
        // The source of the tags for autocompletion
        var tagsource = [
        ]
        // Turn the input into the tagging input
        jQuery('#input_skills').tagging(tagsource);
    </script>

	</body>
</html>
