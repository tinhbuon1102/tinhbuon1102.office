<?php 
//define('SITE_URL', '{{url('/')}}/design/')
?>
@include('pages.header')

<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header.php'); ?>
<!--/head-->
<link rel="stylesheet" href="{{url('/')}}/design/js/chosen/chosen.min.css">
<link rel="stylesheet" type='text/css' href="<?php echo SITE_URL?>css/select2.min.css">
<body class="mypage review">
	<div class="viewport">
		<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header_nav_rentuser.php'); ?>
		@include('pages.header_nav_shareuser')
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
								あなたがスペースを提供した
								<a href="#">
									<strong>{{getUserName($rentUser)}}</strong>
								</a>
								に対してレビューしてください。
							</p>
						</div>
						<form id="rate-form-id" method="post">
							{{ csrf_field() }}
							<div class="reputation">
								<div class="field">
									<label>
										<strong>時間通りにきましたか？</strong>
									</label>
									<span class="radio radio_yesno">
										<input type="radio" name="IsVisitedOnTIme" value="Yes" required>
										はい
									</span>
									<span class="radio radio_yesno">
										<input type="radio" name="IsVisitedOnTIme" value="No">
										いいえ
									</span>
								</div>
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
											使用清潔度
										</label>
										<div class="span4">
											<div class="radio_option">
												<span class="star-rating-control">

													<div class="star-rating rater-0 star star-rating-applied star-rating-live" title="全くきれいに使用できていなかった">
														<input type="radio" name="Cleaniness" class="star star-rating-applied" value="1" data-title="Awful cleaniness. Didn't clean at all." style="display: none;">
														<a title="1">1</a>
													</div>

													<div class="star-rating rater-0 star star-rating-applied star-rating-live" title="あまりきれいに使用できていなかった">
														<input type="radio" name="Cleaniness" class="star star-rating-applied" value="2" data-title="Poor cleaniness. Didn't clean well." style="display: none;">
														<a title="2">2</a>
													</div>

													<div class="star-rating rater-0 star star-rating-applied star-rating-live" title="きれいに使用できていた">
														<input type="radio" name="Cleaniness" class="star star-rating-applied" value="3" data-title="Good cleaniness. Good enough for cleaning." style="display: none;">
														<a title="3">3</a>
													</div>

													<div class="star-rating rater-0 star star-rating-applied star-rating-live" title="とてもきれいに使用できていた">
														<input type="radio" name="Cleaniness" class="star star-rating-applied" value="4" data-title="Great cleaniness. Excellent cleaning, very satisfied." style="display: none;">
														<a title="4">4</a>
													</div>

													<div class="star-rating rater-0 star star-rating-applied star-rating-live" title="とても素晴らしくきれいに使用できていた">
														<input type="radio" name="Cleaniness" class="star star-rating-applied" value="5" data-title="Excellent cleaniness. Perfection. Couldn't have wished for better!" style="display: none;">
														<a title="5">5</a>
													</div>
												</span>
												<span class="sh-txt"></span>

											</div>
										</div>
									</div>

									<div class="row-fluid">
										<label class="span3">
											ルール遵守度
										</label>
										<div class="span4">
											<div class="radio_option">
												<span class="star-rating-control">

													<div class="star-rating rater-0 star star-rating-applied star-rating-live" title="全然ルールが守れていなかった">
														<input type="radio" name="Kindness" class="star star-rating-applied" value="1" data-title="Awful cleaniness. Didn't clean at all." style="display: none;">
														<a title="1">1</a>
													</div>

													<div class="star-rating rater-0 star star-rating-applied star-rating-live" title="あまりルールが守れていなかった">
														<input type="radio" name="Kindness" class="star star-rating-applied" value="2" data-title="Poor cleaniness. Didn't clean well." style="display: none;">
														<a title="2">2</a>
													</div>

													<div class="star-rating rater-0 star star-rating-applied star-rating-live" title="ルールが守れていた">
														<input type="radio" name="Kindness" class="star star-rating-applied" value="3" data-title="Good cleaniness. Good enough for cleaning." style="display: none;">
														<a title="3">3</a>
													</div>

													<div class="star-rating rater-0 star star-rating-applied star-rating-live" title="十分ルールが守れていた">
														<input type="radio" name="Kindness" class="star star-rating-applied" value="4" data-title="Great cleaniness. Excellent cleaning, very satisfied." style="display: none;">
														<a title="4">4</a>
													</div>

													<div class="star-rating rater-0 star star-rating-applied star-rating-live" title="素晴らしくルールが守れていた">
														<input type="radio" name="Kindness" class="star star-rating-applied" value="5" data-title="Excellent cleaniness. Perfection. Couldn't have wished for better!" style="display: none;">
														<a title="5">5</a>
													</div>
												</span>
												<span class="sh-txt"></span>
											</div>
										</div>
									</div>
									
									<div class="row-fluid">
										<label class="span3">
											礼儀正しさ
										</label>
										<div class="span4">
											<div class="radio_option">
												<span class="star-rating-control">

													<div class="star-rating rater-0 star star-rating-applied star-rating-live" title="まったく礼儀がなってなかった">
														<input type="radio" name="Polite" class="star star-rating-applied" value="1" data-title="Awful cleaniness. Didn't clean at all." style="display: none;">
														<a title="1">1</a>
													</div>

													<div class="star-rating rater-0 star star-rating-applied star-rating-live" title="礼儀が乏しかった">
														<input type="radio" name="Polite" class="star star-rating-applied" value="2" data-title="Poor cleaniness. Didn't clean well." style="display: none;">
														<a title="2">2</a>
													</div>

													<div class="star-rating rater-0 star star-rating-applied star-rating-live" title="礼儀がちゃんとしていた">
														<input type="radio" name="Polite" class="star star-rating-applied" value="3" data-title="Good cleaniness. Good enough for cleaning." style="display: none;">
														<a title="3">3</a>
													</div>

													<div class="star-rating rater-0 star star-rating-applied star-rating-live" title="十分礼儀が良かった">
														<input type="radio" name="Polite" class="star star-rating-applied" value="4" data-title="Great cleaniness. Excellent cleaning, very satisfied." style="display: none;">
														<a title="4">4</a>
													</div>

													<div class="star-rating rater-0 star star-rating-applied star-rating-live" title="とても礼儀が素晴らしかった">
														<input type="radio" name="Polite" class="star star-rating-applied" value="5" data-title="Excellent cleaniness. Perfection. Couldn't have wished for better!" style="display: none;">
														<a title="5">5</a>
													</div>
												</span>
												<span class="sh-txt"></span>
											</div>
										</div>
									</div>

									
									
									<div class="row-fluid">
										<label class="span3">
											再利用希望
										</label>
										<div class="span4">
											<div class="radio_option">
												<span class="star-rating-control">

													<div class="star-rating rater-0 star star-rating-applied star-rating-live" title="もう利用してほしくない">
														<input type="radio" name="Repeat" class="star star-rating-applied" value="1" data-title="Awful cleaniness. Didn't clean at all." style="display: none;">
														<a title="1">1</a>
													</div>

													<div class="star-rating rater-0 star star-rating-applied star-rating-live" title="あまり利用してほしくない">
														<input type="radio" name="Repeat" class="star star-rating-applied" value="2" data-title="Poor cleaniness. Didn't clean well." style="display: none;">
														<a title="2">2</a>
													</div>

													<div class="star-rating rater-0 star star-rating-applied star-rating-live" title="また利用してもいい">
														<input type="radio" name="Repeat" class="star star-rating-applied" value="3" data-title="Good cleaniness. Good enough for cleaning." style="display: none;">
														<a title="3">3</a>
													</div>

													<div class="star-rating rater-0 star star-rating-applied star-rating-live" title="また利用して欲しい">
														<input type="radio" name="Repeat" class="star star-rating-applied" value="4" data-title="Great cleaniness. Excellent cleaning, very satisfied." style="display: none;">
														<a title="4">4</a>
													</div>

													<div class="star-rating rater-0 star star-rating-applied star-rating-live" title="是非また利用して欲しい">
														<input type="radio" name="Repeat" class="star star-rating-applied" value="5" data-title="Excellent cleaniness. Perfection. Couldn't have wished for better!" style="display: none;">
														<a title="5">5</a>
													</div>
												</span>
												<span class="sh-txt"></span>
											</div>
										</div>
									</div>
                                    </div>

									<label class="exceptional-project-inquiry">
										<span class="textarea-title">このユーザーは良かったですか？</span>
									</label>
									<small>
										<p>
											あなたの評価がこのユーザに提供するシェアユーザーの参考となります。
											<br />
											このユーザーの利用態度が良かった場合は、そのように評価してあげましょう。
										</p>
									</small>
									<div class="field control-group">
										<label for="comment-field-id">
											<span class="textarea-title">コメント:</span>
											<small class="muted note"> (最大1500文字。このレビューはサイトに表示されます。) </small>
										</label>
										<textarea required rows="4" name="Comment" id="comment-field-id" class="comment-field" cols="90"></textarea>
										<small id="text-counter" class="muted note right">残り<span>1500</span>文字</small>
										<small style="display: none;" class="help-inline">
											<span for="comment-field-id" generated="true" class="error">10文字以内での投稿はできません。</span>
										</small>
									</div>
									<button id="rate-user-button-id" type="submit" value="Rate User" class="btn btn-info btn-mini rate-user-button">レビューを投稿</button>
								</div>


							</div>
						</form>
					</section>
				</div>
				<!--/feed-->
				@endif
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
