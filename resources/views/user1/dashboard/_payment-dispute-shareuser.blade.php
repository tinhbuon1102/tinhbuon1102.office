<?php 
//define('SITE_URL', '{{url('/')}}/design/')
?>@include('pages.header')

<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header.php'); ?>
<!--/head-->
<link rel="stylesheet" href="{{url('/')}}/design/js/chosen/chosen.min.css">
<link rel="stylesheet" type='text/css' href="<?php echo SITE_URL?>css/select2.min.css">
<body class="mypage">
	<div class="viewport">
		<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header_nav_rentuser.php'); ?>
		@include('pages.header_nav_shareuser')
		<div class="main-container">
			<div id="main" class="container">
				
				
					<div id="feed">
						<section class="review-content feed-box">
<div class="heading-review">
<h1 class="rate-feedback-heading">Write Review<!--レビューを書く--></h1>
<p class="leave-feedback-subheader">Please leave feedback and rate <a href="#"><strong>Taro Sato</strong></a> for offered space</p>
</div>
<form id="rate-form-id" method="post" >
{{ csrf_field() }} 
<div class="reputation">
<div class="field">
<label><strong>Was he/she visit on time?</strong></label>
<span class="radio radio_yesno"><input type="radio" name="IsVisitedOnTIme" value="Yes" required>Yes</span>
<span class="radio radio_yesno"><input type="radio" name="IsVisitedOnTIme" value="No" >No</span>
</div>
<div id="rating" class="row span7">
<label class="exceptional-project-inquiry">
<span class="textarea-title">Was the rentuser good?</span>
</label>
<small>
            <p>
                あなたの評価がこのユーザに提供するシェアユーザーの参考となります。<br/>
                このユーザーの利用態度が良かった場合は、そのように評価してあげましょう。
            </p>
        </small>
<div class="field control-group">
<label for="comment-field-id">
<span class="textarea-title">Comment:</span>
<small class="muted note"> (Maximum 1500 characters. This will be public) </small>
</label>
        <textarea required rows="4" name="Comment" id="comment-field-id" class="comment-field" cols="90"></textarea>
        <small id="text-counter" class="muted note right">1500 characters left</small>
        <small style="display:none;" class="help-inline"><span for="comment-field-id" generated="true" class="error">Comment can not be less than 10 characters.</span></small>
    </div>
<button id="rate-user-button-id" type="submit" value="Rate User" class="btn btn-info btn-mini rate-user-button">Rate User</button>
</div>


</div>
</form>
</section>
</div>
					<!--/feed-->

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
	jQuery( "#rate-form-id" ).validate({
  rules: {
    field: {
      required: true
    }
  }
});

jQuery("#comment-field-id").keyup( function(){
	var len = jQuery(this).val().length;
	if(len < 10){
		jQuery(".help-inline").show();
	}else{
		jQuery(".help-inline").hide();
	}
	jQuery("#text-counter").text(1500-len +"characters left");
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
