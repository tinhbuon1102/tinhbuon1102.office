<?php 
$upload_path_portfolio = '/images/rentuser/portfolio/';

if ($action == 'edit' || $action == 'view')
{
	$title = $userPortfolio['Title'];
	$description = $userPortfolio['Description'];
	$img = $userPortfolio['Photo'];
}
else {
	$title = '';
	$description = '';
	$img = '';
}
?>
<div class="ajax-text-and-image white-popup-block">
	<style>
.ajax-text-and-image {
	max-width: 1120px;
	margin: 20px auto;
	background: #FFF;
	padding: 0;
}

.ajcol {
	width: 50%;
	float: left;
}

.ajcol img {
	width: 100%;
	height: auto;
}

.port-pop-wrapper {
	padding: 0px;
}

h4.port_about {
	font-size: 14px;
	margin-bottom: 12px
}

.port_disc p {
	font-size: 12px;
}

h1.port-title {
	padding: 15px 20px;
	margin-bottom: 20px;
	font-size: 22px;
	line-height: 1;
	border-bottom: 1px solid #DEDEDE;
}
.fl-modal-body .fl-modal-main.is-image {
    width: 75%;
    min-height: calc(100vh - 188px);
	padding: 20px;
}
.fl-modal-body .fl-modal-side {
    min-width: 300px;
    padding: 25px 20px;
    width: 25%;
    border-left: 1px solid #DEDEDE;
    vertical-align: top;
}
.fl-modal-body {
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    height: auto;
    min-height: calc(100vh - 188px);
}

@media all and (max-width:30em) {
	.ajcol {
		width: 100%;
		float: none;
	}
}
</style>
	
	<?php if ($action == 'edit' || $action == 'add') {?>
	<div class="port-pop-wrapper">
		<h1 class="port-title">実績を追加<a type="button" id="portfolio-close" class="ajax-popup-link-close close">×</a></h1>
		
		<div class="upload_portfolio_success" style="display: none;"></div>
		
        <div class="fl-modal-body">
		<div class="fl-modal-main is-image">
		<form id="portfolio-form-pic" class="portfolio-form" method="post" enctype="multipart/form-data" action='/RentUser/Dashboard/MyPortfolioSave?action=save'>
			<div class="portfolio-file-wraper port-field-row">
				<div class="port-label">写真</div>
				<div class="upload_portfolio_message_error upload_message_error" style="display:none"></div>
				<div class="exiting_image">
					<img src="<?php echo $img?>" <?php echo !$img ? 'style="display:none; max-width: 100%"' : 'style=" max-width: 100%"';?>/>
				</div>
				<input type="hidden" value="Upload" class="upload_button" name="submitbtn" />
				<input type="hidden" value="portfolio" class="upload_button" name="upload_type" />
				<div class="port-field"><input type="file" name="imagefile" required id="portfolio-pic"/></div>
			</div>
		</form>
        </div>
        <div class="fl-modal-side">
        <form id="portfolio-form" class="portfolio-form" method="post" enctype="multipart/form-data" action='/RentUser/Dashboard/MyPortfolioSave?action=save' >
			<div class="portfolio-title-wraper port-field-row">
				<div class="port-label">タイトル</div>
				<div class="port-field"><input name="Title" value="<?php echo $title?>" type="text"  required /></div>
			</div>
			
			<div class="portfolio-desc-wraper port-field-row">
				<div class="port-label">説明</div>
				<div class="port-field"><textarea name="Description" required rows="5" cols="10"><?php echo $description?></textarea></div>
			</div>
			
			<input type="hidden" value="<?php echo $userPortfolio['Photo']?>" name="Photo" id="portfolio_pic_name"/>
			<input type="hidden" value="<?php echo $userPortfolio['id']?>" name="id" id="portfolio_id"/>
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			
		</form>
        </div>
        </div>
		
		<div class="portfolio-submit-wraper port-field-row">
			<button type="button" id="portfolio-submit-button" class="btn btn-image-save btn-info">実績を追加</button>
		</div>
	</div>
	<script type="text/javascript">
	jQuery(function($){
		function showResponsePortfolio(responseText, statusText, xhr, $form)
		{
			if (!responseText) return ;
			if(responseText.indexOf('.')>0){
	    		$('.exiting_image img').attr('src', "<?php echo $upload_path_portfolio?>" + responseText + "?t="+ (new Date().getTime()));
	    		$('.exiting_image img').show();
	    		$('#portfolio_pic_name').val('<?php echo $upload_path_portfolio?>' + responseText);
			}
			else{
				$('.upload_portfolio_message_error').html(responseText);
				$('.upload_portfolio_message_error').show();
			}
		}

		function showResponseSubmit(response, statusText, xhr, $form)
		{
			$('.upload_portfolio_success').text(response.message);
			if (response.success)
			{
				$('.upload_portfolio_success').fadeIn('slow', function(){
					setTimeout(function(){
						jQuery('.ajax-popup-link').magnificPopup('close');
						location.reload();
					}, 500)
				});
			}
			else {
				$('#portfolio-submit-button').show();
			}
		}

    	$('body').on('click', '#portfolio-submit-button', function(e){
			if($("#portfolio-form").valid() 	<?php if ($action == 'add') { ?> && $("#portfolio-form-pic").valid() <?php } ?> )
			{
        	$('#portfolio-submit-button').hide();
    		$("#portfolio-form").ajaxForm({
            	url: '/RentUser/Dashboard/MyPortfolioSave?action=save',
            	dataType: 'json',
                success:    showResponseSubmit 
            }).submit();
			}
    	});

    	$('body').on('change', '#portfolio-pic', function(e){
    		$("#portfolio-form-pic").ajaxForm({
            	url: '/upload-image.php',
            	data: {'image-id': '<?php echo $userPortfolio['User2Id'] . time();?>'},
                success:    showResponsePortfolio,
                error: function(e){
                    console.log(e);
                } 
            }).submit();
    	});
	})
</script>
<script>
$("#portfolio-form").validate({
   rules: {
     Title: "required",
     Description: "required"
	 }
});
$("#portfolio-form-pic").validate({
   rules: {
     imagefile: "required"
	 }
});
</script>
	<?php } else {?>
		<div class="port-pop-wrapper">
		<h1 class="port-title"><?php echo $title?><a type="button" id="portfolio-close" class="ajax-popup-link-close close">×</a></h1>
		<div class="fl-modal-body">
		<div class="fl-modal-main is-image">
			<img src="<?php echo $img?>" <?php echo !$img ? 'style="display:none; max-width: 100%"' : 'style=" max-width: 100%"';?>/>
		</div>
		<div class="fl-modal-side">
        <span class="portfolio-modal-about-title">実績について</span>
			<p><?php echo $description?></p>
            
		</div>
        </div>
		
		
			
	</div>
	<?php }?>
</div>