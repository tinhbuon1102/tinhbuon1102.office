
<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header.php'); ?>
@include('pages.header')
<?php 

$businessCategories = array(
		'インターネット・ソフトウェア',
		'コンサルティング・ビジネスサービス',
		'コンピュータ・テクノロジー',
		'メディア/ニュース/出版',
		'園芸・農業',
		'化学',
		'教育',
		'金融機関',
		'健康・医療・製薬',
		'健康・美容',
		'工学・建設',
		'工業',
		'小売・消費者商品',
		'食品・飲料',
		'政治団体',
		'地域団体',
		'電気通信',
		'保険会社',
		'法律',
		'輸送・運輸',
		'旅行・レジャー',
		'デザイン',
		'写真',
		'映像',
		'その他',
);
?>
<link rel="stylesheet" href="<?php echo SITE_URL?>js/chosen/chosen.css">
<link rel="stylesheet" href="<?php echo SITE_URL?>css/select2.min.css">
<!--/head-->
<body class="mypage searchpage">
	<div class="viewport">
		@include('pages.header_nav_shareuser')
		<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header_nav_shareuser.php'); ?>
		<div class="main-container">
			@if($error)
			<div class="alert alert-danger alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				{{ $error }}
			</div>
			@else
			<div id="main" class="container fixed-container">
				<div id="mb_toggle" class="left-bar">
					<form>
						<div class="skills-filter">
							<div id="mbshowfd">
								<div class="panel-header modal-header needsclick">
									<div id="mbshowcl" class="modal-close">×</div>
									<?=trans("common.Rent User Search")?>
								</div>
							</div>
							<div id="mbshow" class="input-container input-col3 last">
								<button type="button" class="search-btn-location">
									<i class="fa fa-search" aria-hidden="true"></i>
									<?=trans("common.Rent User Search")?>
								</button>
							</div>
							<div id="mbshowsec">
								<h1 class="skills-filter-heading hide-sm" id="directory_title">
									<?=trans("common.Rent User Search")?>
								</h1>
								<div class="selected-criteria">
									<?php 
									$params = Request::except(['City']);
									$avaiParams = array();
									foreach ($params as $keyParam => $paramVal)
									{
										if ($paramVal)
										{
											$avaiParams[$keyParam] = $paramVal;
										}
									}

									$aMapper = array(
									'filter_name' => trans("common.Search By Name"),
									'BusinessType' => trans("common.Business Category"),
									'Skills' => trans("common.Skills"),
									'Prefecture' => trans("common.Location"),
									'star_rating' => trans("common.Rating"),
									'Online' => trans("common.Online users"),
								);
								?>
									<ul id="online_only_div">
										<?php foreach ($avaiParams as $keyParam => $avaiParam) {
											$removedParams = $avaiParams;
											unset($removedParams[$keyParam]);
											?>
										<li class="directory-bubbles button-group">
											<a class="Tags-item-control btn btn-mini selected_skill" href="<?php echo getFullUrl($removedParams)?>">
												<i class="fa fa-times" aria-hidden="true"></i>
											</a>
											<span class="btn btn-mini">
												<?php echo $aMapper[$keyParam]?>
											</span>
										</li>
										<?php }?>
									</ul>
								</div>
								<div class="clear border-bottom first"></div>
								<div class="form-group">
									<h4>
										<?=trans("common.Search By Name")?>
										:
									</h4>
									<input type="text" class="form-control" name="filter_name" id="filter_name" value="<?php echo $request->filter_name?>">
								</div>
                                
								<div id="skill_selector_div">
									<h4>
										<?=trans("common.Business Category")?>
									</h4>
									<div class="clear"></div>
									<div>
										<select id="BusinessType" name="BusinessType" class="old_ui_selector">
											<option value="">
												<?=trans("common.Choose business category")?>
											</option>
											<?php foreach ($businessCategories as $businessCategory) {?>
											<option value="<?php echo $businessCategory?>" <?php echo $request->BusinessType == $businessCategory ? 'selected="selected"' : '';?>>
												<?php echo $businessCategory?>
											</option>
											<?php }?>
										</select>
									</div>
									
									<div class="clear"></div>
									<div class="form-field two-inputs no-btm-border no-btm-pad">
										<div class="input-container input-half">
											<h4>
												<?=trans("common.Skills")?>
											</h4>
											<select data-placeholder="<?=trans("common.Choose skills")?>" class="chosen-select" id="skill" name="Skills[]" multiple>
												<option value=""></option>
												<optgroup label="制作用ツール、DTPソフト">
													<option <?php echo in_array('Photoshop', $request->Skills) ? 'selected="selected"' : '';?> value="Photoshop">Photoshop</option>
													<option <?php echo in_array('Illustrator', $request->Skills) ? 'selected="selected"' : '';?> value="Illustrator">Illustrator</option>
													<option <?php echo in_array('Dreamweaver', $request->Skills) ? 'selected="selected"' : '';?> value="Dreamweaver">Dreamweaver</option>
													<option <?php echo in_array('Wordpress', $request->Skills) ? 'selected="selected"' : '';?> value="Wordpress">Wordpress</option>
													<option <?php echo in_array('Flash', $request->Skills) ? 'selected="selected"' : '';?> value="Flash">Flash</option>
												</optgroup>
												<optgroup label="デザイン技術">
													<option <?php echo in_array('Webデザイン', $request->Skills) ? 'selected="selected"' : '';?> value="Webデザイン">Webデザイン</option>
													<option <?php echo in_array('グラフィックデザイン', $request->Skills) ? 'selected="selected"' : '';?> value="グラフィックデザイン">グラフィックデザイン</option>
													<option <?php echo in_array('3Dデザイン', $request->Skills) ? 'selected="selected"' : '';?> value="3Dデザイン">3Dデザイン</option>
												</optgroup>
												<optgroup label="開発技術">
													<option <?php echo in_array('IT・Web系技術', $request->Skills) ? 'selected="selected"' : '';?> value="IT・Web系技術">IT・Web系技術</option>
													<option <?php echo in_array('アプリケーション開発技術', $request->Skills) ? 'selected="selected"' : '';?> value="アプリケーション開発技術">アプリケーション開発技術</option>
												</optgroup>
												<optgroup label="基本事務ソフト">
													<option <?php echo in_array('Excel', $request->Skills) ? 'selected="selected"' : '';?> value="Excel">Excel</option>
													<option <?php echo in_array('Power Point', $request->Skills) ? 'selected="selected"' : '';?> value="Power Point">Power Point</option>
													<option <?php echo in_array('Words', $request->Skills) ? 'selected="selected"' : '';?> value="Words">Words</option>
												</optgroup>
												<optgroup label="ビジネススキル">
													<option <?php echo in_array('事務スキル', $request->Skills) ? 'selected="selected"' : '';?> value="事務スキル">事務スキル</option>
													<option <?php echo in_array('営業スキル', $request->Skills) ? 'selected="selected"' : '';?> value="営業スキル">営業スキル</option>
													<option <?php echo in_array('"コンサルティング"', $request->Skills) ? 'selected="selected"' : '';?> value="コンサルティング">コンサルティングスキル</option>
													<option <?php echo in_array('経営スキル', $request->Skills) ? 'selected="selected"' : '';?> value="経営スキル">経営スキル</option>
													<option <?php echo in_array('企画力', $request->Skills) ? 'selected="selected"' : '';?> value="企画力">企画力</option>
													<option <?php echo in_array('交渉力', $request->Skills) ? 'selected="selected"' : '';?> value="交渉力">交渉力</option>
													<option <?php echo in_array('マーケティング', $request->Skills) ? 'selected="selected"' : '';?> value="マーケティング">マーケティング力</option>
													<option <?php echo in_array('プレゼンテーション', $request->Skills) ? 'selected="selected"' : '';?> value="プレゼンテーション">プレゼンテーション力</option>
													<option <?php echo in_array('プロジェクト・マネージメント', $request->Skills) ? 'selected="selected"' : '';?> value="プロジェクト・マネージメント">プロジェクト・マネージメント</option>
													<option <?php echo in_array('情報収集力', $request->Skills) ? 'selected="selected"' : '';?> value="情報収集力">情報収集力</option>
												</optgroup>
												<optgroup label="語学">
													<option <?php echo in_array('英語', $request->Skills) ? 'selected="selected"' : '';?> value="英語">英語</option>
													<option <?php echo in_array('中国語', $request->Skills) ? 'selected="selected"' : '';?> value="中国語">中国語</option>
													<option <?php echo in_array('韓国語', $request->Skills) ? 'selected="selected"' : '';?> value="韓国語">韓国語</option>
													<option <?php echo in_array('フランス語', $request->Skills) ? 'selected="selected"' : '';?> value="フランス語">フランス語</option>
													<option <?php echo in_array('スペイン語', $request->Skills) ? 'selected="selected"' : '';?> value="スペイン語">スペイン語</option>
												</optgroup>
											</select>
										</div>
									</div>
									<div class="clear"></div>
									<h4>
										<?=trans("common.Location")?>
									</h4>
									<div class="clear"></div>
									<div>
										<select data-label="都道府県を選択" name="Prefecture" id="Prefecture">
											<option value="">都道府県を選択</option>
											@foreach($Prefectures as $pref) @if(trim($pref->Prefecture) != '')
											<option <?php echo $request->Prefecture == $pref->Prefecture ? 'selected="selected"' : '';?> value="{{$pref->Prefecture}}">{{$pref->Prefecture}}</option>
											@endif @endforeach
										</select>
										<!--select prefecture-->
									</div>
									<div>
										<select data-label="市区町村を選択" id="state-select" multiple name=City[]>
											@foreach($Districts as $district) @if(trim($district->City) != '')
											<option <?php echo $request->City && in_array($district->City, $request->City) ? 'selected="selected"' : '';?> value="{{$district->City}}">{{$district->City}}</option>
											@endif @endforeach
										</select>
										<!--select districts-->
									</div>
									<div class="clear border-bottom"></div>
									<h4>
										<?=trans("common.Rating")?>
									</h4>
									<div class="clear"></div>
									<div id="rating-star-div" class="radio_option">
										<span class="star-rating-control">
											<div class="star-rating rater-0 star star-rating-applied star-rating-live <?php echo $request->star_rating >= 1 ? 'star-fill' : ''?>" title="">
												<input type="radio" name="star_rating" class="star star-rating-applied" <?php echo $request->star_rating == 1 ? 'checked' : ''?> value="1" data-title="" style="display: none;">
												<a title="1">1</a>
											</div>
											<div class="star-rating rater-0 star star-rating-applied star-rating-live <?php echo $request->star_rating >= 2 ? 'star-fill' : ''?>" title="">
												<input type="radio" name="star_rating" class="star star-rating-applied" <?php echo $request->star_rating == 2 ? 'checked' : ''?> value="2" data-title="" style="display: none;">
												<a title="2">2</a>
											</div>
											<div class="star-rating rater-0 star star-rating-applied star-rating-live <?php echo $request->star_rating >= 3 ? 'star-fill' : ''?>" title="">
												<input type="radio" name="star_rating" class="star star-rating-applied" <?php echo $request->star_rating == 3 ? 'checked' : ''?> value="3" data-title="" style="display: none;">
												<a title="3">3</a>
											</div>
											<div class="star-rating rater-0 star star-rating-applied star-rating-live <?php echo $request->star_rating >= 4 ? 'star-fill' : ''?>" title="">
												<input type="radio" name="star_rating" class="star star-rating-applied" <?php echo $request->star_rating == 4 ? 'checked' : ''?> value="4" data-title="" style="display: none;">
												<a title="4">4</a>
											</div>
											<div class="star-rating rater-0 star star-rating-applied star-rating-live <?php echo $request->star_rating >= 5 ? 'star-fill' : ''?>" title="">
												<input type="radio" name="star_rating" class="star star-rating-applied" <?php echo $request->star_rating == 5 ? 'checked' : ''?> value="5" data-title="" style="display: none;">
												<a title="5">5</a>
											</div>
										</span>
										<input name="star-rating" type="radio" class="star-rating star-rating-applied" value="1" style="display: none;">
										<input name="star-rating" type="radio" class="star-rating star-rating-applied" value="2" style="display: none;">
										<input name="star-rating" type="radio" class="star-rating star-rating-applied" value="3" style="display: none;">
										<input name="star-rating" type="radio" class="star-rating star-rating-applied" value="4" style="display: none;">
										<input name="star-rating" type="radio" class="star-rating star-rating-applied" value="5" style="display: none;">
									</div>
									<div class="clear border-bottom" style="padding-top: 18px"></div>
									<h4>
										<?=trans("common.Online")?>
									</h4>
									<div class="clear"></div>
									<label class="checkbox">
										<input id="online_only" type="checkbox" autocomplete="off" name="Online" <?php echo $request->Online ? 'checked="checked"' : ''?> value="Yes">
										<?=trans("common.Online user only")?>
										<br>
										(
										<?=trans("common.for instant chat")?>
										)
									</label>
									<div class="filter_search_btn">
										<button class="btn btn-info">
											<?=trans("common.Search")?>
										</button>
									</div>
								</div>
								<!--/skill_selector_div-->
							</div>
							<!--/#mbshowsec-->
						</div>
						<!--/skill-filter-->
					</form>
				</div>
				<!--/leftbox-->
				<div class="right_side" id="samewidth">
					<div id="page-wrapper">
						<div class="list-inner">
							<?php if (count($users)) {?>
							<div id="rentuser-content">
								<div class="pagenation-container top-pg clearfix">
									<div class="ns_pagination">{{ $users->links() }}</div>
									<span class="result-amount">表示結果: {{$users->total()}} 件</span>
								</div>
								<?php renderOfferPopup($user1);?>
								<ul id="rentuser_list" class="ns_rentuser-list">
									<!--loop users-->
									@foreach($users as $user)
									<?php $offered = false;?>
									<li class="ns_result  big-thumb" data-id="{{$user->id}}">
										<div class="media-left">
											<div class="inn-simi">
												<a href="{{getUser2ProfileUrl($user)}}" class="rentuser-profile-media" target="_blank">
													<img class="rentuser-profile-image" src="@if(!empty($user->Logo)){{$user->Logo}}@elseif($user->Sex=='女性'){{'/images/woman-avatar.png'}}@else{{'/images/man-avatar.png'}}@endif" alt="">
												</a>
											</div>
										</div>
										<div class="media-body">
											<h3>
												<span class="<?php echo isUserOnline($user) ? 'online' : 'offline'?> online-status" data-is_online="1" data-idx="3" style="display: inline-block !important;"></span>
												<a href="{{getUser2ProfileUrl($user)}}" class="find-rentuser-username" target="_blank"> {{getUserName($user)}} </a>
											</h3>
											<div class="clear"></div>
											<div class="rentuser-card-stats">
												<?php echo showStarReview($user->reviews, true)?>
											</div>
                                            <p class="bussiness-type"><span class="thin-weight">職種 :</span> {{$user->BusinessType}}</p>
											<p class="top-skills hide-sm">
												<?=trans("common.Skills")?>
												:
												<?php $i=1; $skill =  explode(',', $user->Skills);

												foreach ($skill as $item) {
	if($i!=1)
	 echo ",";
	echo "<a href='#'>$item</a>";
	$i++;
}
?>
											</p>
											<p class="bio truncProfile hide-sm">
												<span class="profile_text">{{$user->BusinessSummary}}</span>
											</p>
											<div class="offerme-w">
												<?php 
												$notification = \App\Notification::isOfferedSpace($user1, $user);
												$offered = false;
												$offeredClass = '';
												if ($notification)
												{
													$offered = true;
													$offeredClass = 'offered';
												}
												?>
												<a class="btn btn-mini fl-bt-skin offer_btn <?php echo isset($offeredClass) ? $offeredClass : ''?> hide-sm" title="Offer Spaces">
													<i class="fa fa-paper-plane-o" aria-hidden="true"></i>
													<span class="offer-btn-text">
														<?php echo $offered ? 'オファー済み' : 'オファーする'?>
													</span>
												</a>
                                                <a class="btn btn-mini fl-bt-skin hide-md hide-lg view_profile" href="Profile/{{$user->HashCode}}/{{$user->LastName}}-{{$user->FirstName}}">プロフィールを見る</a>
											</div>
										</div>
									</li>
									@endforeach
									<!--/loop users-->
								</ul>
								<div class="pagenation-container clearfix">
									<div class="ns_pagination">{{ $users->links() }}</div>
									<span class="result-amount">検索結果 {{$users->total()}}件</span>
								</div>
							</div>
							<?php } else{?>
							<div id="rentuser-content" class="no_hit">
								<div class="no-results alert">
									<h4>
										<?=trans("common.No User is not hit")?>
									</h4>
									<?=trans("common.sorry_you_can_search_other_conditions")?>
								</div>
							</div>
							<?php }?>
						</div>
					</div>
				</div>
			</div>
			@endif
		</div>
		<!--/main-container-->
		<!--footer-->
		<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/common_footer.php'); ?>
		@include('pages.common_footer')
		<!--/footer-->
	</div>
	<!--/viewport-->
	<script src="http://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.10.4/typeahead.bundle.min.js"></script>
	<script src="<?php echo SITE_URL?>js/typeahead.tagging.js"></script>
	<script src="<?php echo SITE_URL?>js/chosen/chosen.jquery.js" type="text/javascript"></script>
	<script src="<?php echo SITE_URL?>js/assets/custom_edit_form.js" type="text/javascript"></script>
	<script src="<?php echo SITE_URL?>js/select2.full.min.js" type="text/javascript"></script>
	<script type="text/javascript">
        	jQuery( function() {
				
				jQuery( '#mbshow' ).click( function(){
					jQuery( '#mbshowfd' ).toggle();
					jQuery( '#mbshowsec' ).toggle();
					jQuery( '#mbshow' ).toggle();
					jQuery('#mb_toggle').toggleClass('mb_modal');
					
				});
				
				jQuery( '#mbshowcl' ).click( function(){
					jQuery( '#mbshow' ).click();
				});

				if (jQuery(window ).width() <= 768)
				{
					<?php if (!empty($avaiParams)) echo 'jQuery("#mbshow").trigger("click");'; ?>
				}
        		
        	});
        </script>
	<script>
        // The source of the tags for autocompletion
        var tagsource = [
        ]
        // Turn the input into the tagging input
        jQuery('#input_skills').tagging(tagsource);

        function loadDistrict(){
        	var Prefecture = jQuery('#Prefecture').val();
        	if (Prefecture) {
	    		jQuery.ajax({
	    			url : '<?php echo URL::to("RentUser/district")?>/'+Prefecture,
	    			success : function(resp){
	    				var data = JSON.parse(resp);
	    				var districts = '';
	    				jQuery.each(data, function(key, name){
	    					districts += '<option value="'+name.City+'">'+name.City+'</option>';
	    				});
	    				jQuery('#state-select').html(districts);
	    				
	    			}
	    		});
        	}
        }
        jQuery(document).ready(function($){
        	jQuery('#Prefecture').change(function(){
        		loadDistrict();
        	});

        	<?php if (!count($Districts)) {?>
        		loadDistrict();
        	<?php }?>
        	
        	jQuery('#state-select').select2({
            	multiple:true
    		});

        });
    </script>
</body>
</html>
