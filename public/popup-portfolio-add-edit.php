<?php 
$userId = $_GET['user_id'];
$action = $_GET['action'];
$upload_path_portfolio_tmp = 'images/portfolio/tmp/';
$upload_path_portfolio = 'images/portfolio/';
if(isset($_POST['portfolio_pic_name']))
{
	if ($_POST['portfolio_pic_name'])
	{
		$filename_tmp = $upload_path_portfolio_tmp . $_POST['portfolio_pic_name'];
		$filename_real = $upload_path_portfolio . $_POST['portfolio_pic_name'];
		if(file_exists($filename_tmp))
		{
			copy($filename_tmp, $filename_real);
		}
	}
	exit('Your portfolio is updated !');
}

if ($action == 'edit')
{
	$title = 'Here is title';
	$description = 'Here is Description';
	$img = 'images/rentuser/portfolio/01.jpg';
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
	max-width: 800px;
	margin: 20px auto;
	background: #FFF;
	padding: 0;
	line-height: 0;
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
	padding: 20px;
}

h4.port_about {
	font-size: 14px;
	margin-bottom: 12px
}

.port_disc p {
	font-size: 12px;
}

h1.port-title {
	padding-bottom: 16px;
	margin-bottom: 20px;
	font-size: 22px;
	line-height: 1;
	border-bottom: 1px solid #DEDEDE;
}

@media all and (max-width:30em) {
	.ajcol {
		width: 100%;
		float: none;
	}
}
</style>
	
	<div class="port-pop-wrapper">
		<h1 class="port-title">Portfolio Title<a type="button" id="portfolio-close" class="ajax-popup-link-close close">×</a></h1>
		
		<div class="upload_portfolio_success" style="display: none;"></div>
		<form id="portfolio-form" class="portfolio-form" method="post" enctype="multipart/form-data" action='popup-portfolio-add-edit.php' name="photo">
			<div class="portfolio-title-wraper port-field-row">
				<div class="port-label">Title</div>
				<div class="port-field"><input name="portfolio-title" value="<?php echo $title?>" type="text"/></div>
			</div>
			
			<div class="portfolio-desc-wraper port-field-row">
				<div class="port-label">Description</div>
				<div class="port-field"><textarea name="portfolio-desc" rows="5" cols="10"><?php echo $description?></textarea></div>
			</div>
			
			<input type="hidden" value="" name="portfolio_pic_name" id="portfolio_pic_name"/>
			
		</form>
		<form id="portfolio-form-pic" class="portfolio-form" method="post" enctype="multipart/form-data" action='popup-portfolio-add-edit.php' name="photo">
			<div class="portfolio-file-wraper port-field-row">
				<div class="port-label">Picture</div>
				<div class="upload_portfolio_message_error upload_message_error" style="display:none"></div>
				<?php if ($img) {?>
				<div class="exiting_image">
					<img src="images/rentuser/portfolio/01.jpg"/>
				</div>
				<?php }?>
				<input type="hidden" value="Upload" class="upload_button" name="submitbtn" />
				<input type="hidden" value="portfolio" class="upload_button" name="upload_type" />
				<div class="port-field"><input type="file" name="imagefile" id="portfolio-pic"/></div>
			</div>
		</form>
		
		<div class="portfolio-submit-wraper port-field-row">
			<button type="button" id="portfolio-submit-button" class="btn btn-image-save">Submit</button>
		</div>
	</div>
</div>
<script type="text/javascript">
	jQuery(function($){
		function showResponsePortfolio(responseText, statusText, xhr, $form)
		{
			if (!responseText) return ;
			
			if(responseText.indexOf('.')>0){
	    		$('.exiting_image img').attr('src', "<?php echo $upload_path_portfolio_tmp?>" + responseText + "?t="+ (new Date().getTime()));
	    		$('#portfolio_pic_name').val(responseText);
			}
			else{
				$('.upload_portfolio_message_error').html(responseText);
				$('.upload_portfolio_message_error').show();
			}
		}

		function showResponseSubmit(responseText, statusText, xhr, $form)
		{
			if (responseText)
			{
				$('.upload_portfolio_success').text(responseText);
				$('.upload_portfolio_success').fadeIn('slow', function(){
					setTimeout(function(){
						jQuery('.ajax-popup-link').magnificPopup('close');
					}, 500)
				});
			}
			
		}

    	$('body').on('click', '#portfolio-submit-button', function(e){
    		$("#portfolio-form").ajaxForm({
            	url: 'popup-portfolio-add-edit.php',
                success:    showResponseSubmit 
            }).submit();
    	});

    	$('body').on('change', '#portfolio-pic', function(e){
    		$("#portfolio-form-pic").ajaxForm({
            	url: 'upload-image.php',
                success:    showResponsePortfolio 
            }).submit();
    	});
	})
</script>