<?php
// define('SITE_URL', '{{url('/')}}/design/')
?>
@include('pages.header')

<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header.php'); ?>
<!--/head-->
<link rel="stylesheet" href="{{url('/')}}/js/chosen/chosen.min.css">
<link rel="stylesheet" type='text/css' href="<?php echo SITE_URL?>css/select2.min.css">
<body class="mypage review">
	<div class="viewport">
		<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header_nav_rentuser.php'); ?>
		@include('pages.header_nav_shareuser')
		<div class="main-container">
			<div id="main" class="container">
				@if ($error)
				<div class="alert alert-danger">{{ $error }}</div>
				@else @if (Session::has('submitFailed'))
				<div class="alert alert-danger">{{ Session::get('submitFailed') }}</div>
				@endif
				<div id="feed">
					<section class="review-content feed-box">
						<div class="heading-review">
							<h1 class="rate-feedback-heading">レビューを投稿</h1>
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
								<div id="rating" class="row span7">
									<div class="tb-wpp">
										<div class="row-fluid">
											<label class="span3"> 評価 </label>
											<div class="span4">
												<div class="radio_option">
													<span class="star-rating-control">
														<div class="star-rating rater-0 star star-rating-applied star-rating-live" title="">
															<input type="radio" name="Cleaniness" class="star star-rating-applied" value="1" data-title="" style="display: none;">
															<a title="1">1</a>
														</div>
														<div class="star-rating rater-0 star star-rating-applied star-rating-live" title="">
															<input type="radio" name="Cleaniness" class="star star-rating-applied" value="2" data-title="" style="display: none;">
															<a title="2">2</a>
														</div>
														<div class="star-rating rater-0 star star-rating-applied star-rating-live" title="">
															<input type="radio" name="Cleaniness" class="star star-rating-applied" value="3" data-title="" style="display: none;">
															<a title="3">3</a>
														</div>
														<div class="star-rating rater-0 star star-rating-applied star-rating-live" title="">
															<input type="radio" name="Cleaniness" class="star star-rating-applied" value="4" data-title="" style="display: none;">
															<a title="4">4</a>
														</div>
														<div class="star-rating rater-0 star star-rating-applied star-rating-live" title="">
															<input type="radio" name="Cleaniness" class="star star-rating-applied" value="5" data-title="" style="display: none;">
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
										<small id="text-counter" class="muted note right">
											残り
											<span>1500</span>
											文字
										</small>
										<!--<small style="display: none;" class="help-inline">
											<span for="comment-field-id" generated="true" class="error">10文字以内での投稿はできません。</span>
										</small>-->
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
jQuery(function($){

	$('body').on('click', '#rate-user-button-id', function(e){
		e.preventDefault();
		if (!$('input[name="Cleaniness"]:checked').length)
		{
			alert ('星の評価は必須です');
			return false;
		}
		else {
			$('#rate-form-id').submit();
		}
	});

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
