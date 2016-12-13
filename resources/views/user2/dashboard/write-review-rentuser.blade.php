@include('pages.header')

<!--/head-->
<link rel="stylesheet" href="{{ URL::asset('js/chosen/chosen.min.css') }}">
<link rel="stylesheet" type='text/css' href="<?php echo SITE_URL?>css/select2.min.css">
<body class="mypage review">
	<div class="viewport">
		@include('pages.header_nav_rentuser')
		<div class="main-container">
			<div id="main" class="container">
			@if ($error)
			    <div class="alert alert-danger">{{ $error }}</div>
			@elseif (Session::has('success'))
				<div class="alert alert-success">{{ Session::get('success') }}</div>
			@else
				@if (Session::has('submitFailed'))
					<div class="alert alert-danger">{{ Session::get('submitFailed') }}</div>
				@endif
				
				<div id="feed">
					<section class="review-content feed-box">
						<div class="heading-review">
							<h1 class="rate-feedback-heading">
								レビューを投稿
							</h1>
							<p class="leave-feedback-subheader">
								あなたが利用した
								<a target="_blank" href="<?php echo getSpaceUrl($space->HashID)?>">
									<strong><?php echo $space->Title?></strong>
								</a>
								に関してレビューをしてください。
							</p>
						</div>
						<form id="rate-form-id" method="post">
							{{ csrf_field() }}
							<div class="reputation">
								<div id="rating" class="row span7">
									<div id="star-rating-range" class="row-fluid">
										<div class="offset1">
											<span class="rate_header_descr">
												<span class="first_header">悪い</span>
												良い
											</span>
										</div>
									</div>
                                    <div class="tb-wpp">
									<div class="row-fluid">
										<label class="span3">
											清潔さ
										</label>
										<div class="span4">
											<div class="radio_option">
												<span class="star-rating-control">

													<div class="star-rating rater-0 star star-rating-applied star-rating-live" title="全然きれいではなかった">
														<input type="radio" name="Cleaniness" class="star star-rating-applied" value="1" data-title="全然きれいではなかった" style="display: none;">
														<a title="1">1</a>
													</div>

													<div class="star-rating rater-0 star star-rating-applied star-rating-live" title="あまりきれいではなかった">
														<input type="radio" name="Cleaniness" class="star star-rating-applied" value="2" data-title="あまりきれいではなかった" style="display: none;">
														<a title="2">2</a>
													</div>

													<div class="star-rating rater-0 star star-rating-applied star-rating-live" title="まぁまぁきれいだった">
														<input type="radio" name="Cleaniness" class="star star-rating-applied" value="3" data-title="まぁまぁきれいだった" style="display: none;">
														<a title="3">3</a>
													</div>

													<div class="star-rating rater-0 star star-rating-applied star-rating-live" title="きれいだった">
														<input type="radio" name="Cleaniness" class="star star-rating-applied" value="4" data-title="きれいだった" style="display: none;">
														<a title="4">4</a>
													</div>

													<div class="star-rating rater-0 star star-rating-applied star-rating-live" title="とてもきれいだった">
														<input type="radio" name="Cleaniness" class="star star-rating-applied" value="5" data-title="とてもきれいだった" style="display: none;">
														<a title="5">5</a>
													</div>
												</span>
												<span class="sh-txt"></span>

											</div>
										</div>
									</div>

									<div class="row-fluid">
										<label class="span3">
											親切度
										</label>
										<div class="span4">
											<div class="radio_option">
												<span class="star-rating-control">

													<div class="star-rating rater-0 star star-rating-applied star-rating-live" title="まったく親切でなかった">
														<input type="radio" name="Kindness" class="star star-rating-applied" value="1" data-title="まったく親切でなかった" style="display: none;">
														<a title="1">1</a>
													</div>

													<div class="star-rating rater-0 star star-rating-applied star-rating-live" title="あまり親切でなかった">
														<input type="radio" name="Kindness" class="star star-rating-applied" value="2" data-title="あまり親切でなかった" style="display: none;">
														<a title="2">2</a>
													</div>

													<div class="star-rating rater-0 star star-rating-applied star-rating-live" title="まぁまぁ親切だった">
														<input type="radio" name="Kindness" class="star star-rating-applied" value="3" data-title="まぁまぁ親切だった" style="display: none;">
														<a title="3">3</a>
													</div>

													<div class="star-rating rater-0 star star-rating-applied star-rating-live" title="親切だった">
														<input type="radio" name="Kindness" class="star star-rating-applied" value="4" data-title="とても親切だった" style="display: none;">
														<a title="4">4</a>
													</div>

													<div class="star-rating rater-0 star star-rating-applied star-rating-live" title="とても親切だった">
														<input type="radio" name="Kindness" class="star star-rating-applied" value="5" data-title="とても親切だった" style="display: none;">
														<a title="5">5</a>
													</div>
												</span>
												<span class="sh-txt"></span>
											</div>
										</div>
									</div>
									
									<div class="row-fluid">
										<label class="span3">
											オフィス環境
										</label>
										<div class="span4">
											<div class="radio_option">
												<span class="star-rating-control">

													<div class="star-rating rater-0 star star-rating-applied star-rating-live" title="まったく良くなかった">
														<input type="radio" name="Polite" class="star star-rating-applied" value="1" data-title="まったく良くなかった" style="display: none;">
														<a title="1">1</a>
													</div>

													<div class="star-rating rater-0 star star-rating-applied star-rating-live" title="あまりいい環境でなかった">
														<input type="radio" name="Polite" class="star star-rating-applied" value="2" data-title="あまりいい環境でなかった" style="display: none;">
														<a title="2">2</a>
													</div>

													<div class="star-rating rater-0 star star-rating-applied star-rating-live" title="まぁまぁ良いオフィス環境だった">
														<input type="radio" name="Polite" class="star star-rating-applied" value="3" data-title="まぁまぁ良いオフィス環境だった" style="display: none;">
														<a title="3">3</a>
													</div>

													<div class="star-rating rater-0 star star-rating-applied star-rating-live" title="良いオフィス環境だった">
														<input type="radio" name="Polite" class="star star-rating-applied" value="4" data-title="良いオフィス環境だった" style="display: none;">
														<a title="4">4</a>
													</div>

													<div class="star-rating rater-0 star star-rating-applied star-rating-live" title="とても良いオフィス環境だった">
														<input type="radio" name="Polite" class="star star-rating-applied" value="5" data-title="とても良いオフィス環境だった" style="display: none;">
														<a title="5">5</a>
													</div>
												</span>
												<span class="sh-txt"></span>
											</div>
										</div>
									</div>

									<div class="row-fluid">
										<label class="span3">
										金額設定
										</label>
										<div class="span4">
											<div class="radio_option">
												<span class="star-rating-control">

													<div class="star-rating rater-0 star star-rating-applied star-rating-live" title="結構高かった">
														<input type="radio" name="Budget" class="star star-rating-applied" value="1" data-title="結構高かった" style="display: none;">
														<a title="1">1</a>
													</div>

													<div class="star-rating rater-0 star star-rating-applied star-rating-live" title="高かった">
														<input type="radio" name="Budget" class="star star-rating-applied" value="2" data-title="高かった" style="display: none;">
														<a title="2">2</a>
													</div>

													<div class="star-rating rater-0 star star-rating-applied star-rating-live" title="普通">
														<input type="radio" name="Budget" class="star star-rating-applied" value="3" data-title="普通" style="display: none;">
														<a title="3">3</a>
													</div>

													<div class="star-rating rater-0 star star-rating-applied star-rating-live" title="いい金額設定だった">
														<input type="radio" name="Budget" class="star star-rating-applied" value="4" data-title="いい金額設定だった" style="display: none;">
														<a title="4">4</a>
													</div>

													<div class="star-rating rater-0 star star-rating-applied star-rating-live" title="とてもいい金額設定だった">
														<input type="radio" name="Budget" class="star star-rating-applied" value="5" data-title="とてもいい金額設定だった" style="display: none;">
														<a title="5">5</a>
													</div>
												</span>
												<span class="sh-txt"></span>
											</div>
										</div>
									</div>

									<div class="row-fluid">
										<label class="span3">
											再利用率
										</label>
										<div class="span4">
											<div class="radio_option">
												<span class="star-rating-control">

													<div class="star-rating rater-0 star star-rating-applied star-rating-live" title="もう二度と利用しない">
														<input type="radio" name="Repeat" class="star star-rating-applied" value="1" data-title="もう二度と使わない" style="display: none;">
														<a title="1">1</a>
													</div>

													<div class="star-rating rater-0 star star-rating-applied star-rating-live" title="あまり利用したくない">
														<input type="radio" name="Repeat" class="star star-rating-applied" value="2" data-title="あまり利用したくない" style="display: none;">
														<a title="2">2</a>
													</div>

													<div class="star-rating rater-0 star star-rating-applied star-rating-live" title="再度利用してもいい">
														<input type="radio" name="Repeat" class="star star-rating-applied" value="3" data-title="再度利用してもいい" style="display: none;">
														<a title="3">3</a>
													</div>

													<div class="star-rating rater-0 star star-rating-applied star-rating-live" title="再度利用する">
														<input type="radio" name="Repeat" class="star star-rating-applied" value="4" data-title="もう一度利用する" style="display: none;">
														<a title="4">4</a>
													</div>

													<div class="star-rating rater-0 star star-rating-applied star-rating-live" title="是非再度利用したい">
														<input type="radio" name="Repeat" class="star star-rating-applied" value="5" data-title="是非再度利用したい" style="display: none;">
														<a title="5">5</a>
													</div>
												</span>
												<span class="sh-txt"></span>
											</div>
										</div>
									</div>
                                    </div>


									<label class="exceptional-project-inquiry">
										<span class="textarea-title">このスペースは良かったですか?</span>
									</label>
									<small>
										<p>
											あなたの評価がこのスペースを利用するレントユーザー(利用者)の参考となります。
											<br />
											このスペースがが良かった場合は、そのように評価してあげましょう。
										</p>
									</small>
									<div class="field control-group">
										<label for="comment-field-id">
											<span class="textarea-title">コメント:</span>
											<small class="muted note"> (最高1500文字。この評価はサイトに公開されます。) </small>
										</label>
										<textarea rows="4" name="Comment" id="comment-field-id" class="comment-field" cols="90" required></textarea>
										<small id="text-counter" class="muted note right">残り<span>1500</span>文字</small>
										<small style="display: none;" class="help-inline">
											<span for="comment-field-id" generated="true" class="error">10文字以下での投稿はできません。</span>
										</small>
									</div>
									<button id="rate-space-button-id" type="submit" value="Rate User" class="btn btn-info btn-mini rate-space-button">レビューを投稿</button>
								</div>

							</div>
						</form>
					</section>
				</div>
				<!--/feed-->
			@endif
			</div>
		</div>
		<!--/main-container-->
		<!--footer-->
		<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/common_footer.php'); ?>
		@include('pages.common_footer')
		<!--/footer-->
	</div>
	<!--/viewport-->
	<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script> -->

	<script src="<?php echo SITE_URL?>js/chosen/chosen.jquery.min.js" type="text/javascript"></script>
	<script src="<?php echo SITE_URL?>js/chosen/chosen.proto.min.js" type="text/javascript"></script>
	<script src="<?php echo SITE_URL?>js/chosen/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?php echo SITE_URL?>js/address_select.js" type="text/javascript"></script>

	<script src="<?php echo SITE_URL?>js/select2.full.min.js"></script>

	<script type="text/javascript">
/*var config = {
      '.chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }*/

    
  </script>

	<script>
jQuery(function(){
	/* jQuery( "#rate-form-id" ).validate({
  rules: {
    field: {
      required: true
    }
  }
}); */


	function updateCountReview ()
    {
	var len = jQuery("#comment-field-id").val().length;
	if(len < 10){
		jQuery(".help-inline").show();
	}else{
		jQuery(".help-inline").hide();
	}
	//jQuery("#text-counter").text(1500-len +"characters left");
	jQuery("#text-counter span").text(1500-len );
	}

	jQuery("#comment-field-id").keyup(function () {
        updateCountReview();
    });
    jQuery("#comment-field-id").keypress(function () {
        updateCountReview();
    });
    jQuery("#comment-field-id").keydown(function () {
        updateCountReview();
    });

    jQuery('#state-select').select2({
                    multiple:true
    });
    // 全ての駅名を非表示にする
    jQuery(".budget-price").addClass('hide');
    // 路線のプルダウンが変更されたら
    jQuery("#choose_budget_per").change(function(){
        // 全ての駅名を非表示にする
        jQuery(".budget-price").addClass('hide');
        // 選択された路線に連動した駅名プルダウンを表示する
        jQuery('#' + $("#choose_budget_per option:selected").attr("class")).removeClass("hide");
    });
})
jQuery(".input-container.iconbutton").click(function(){
  jQuery(this).toggleClass("checked");
});
</script>
</body>
</html>
