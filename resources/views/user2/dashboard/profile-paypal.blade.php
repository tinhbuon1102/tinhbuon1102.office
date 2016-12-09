
 @include('pages.header')
<?php
$description = 'イラストレーターを主に都内で活動をおこなっています。 飲食店のメニュー制作から雑誌の差し込みイラストなどを手がけています。 渋谷区での営業先が多いので、そのあたりで探しており、特にデザイン会社様で、 シェアスペースをさせて頂けるとありがたいです。';
$breaks = array("<br />","<br>","<br/>");
$description_area = trim(str_ireplace($breaks, "\r\n", $description));
?><!--/head-->
<body class="profilepage rentuser-profile">
	<div class="viewport">
		@if(Auth::check())
			@include('pages.header_nav_shareuser')
		@elseif(Auth::guard('user2')->check())
			@include('pages.header_nav_rentuser')
		@endif
		<div id="main" class="container">
			<!--/profile-cover-wrapper-->
			
			<section class="profile-user-requirement">
				<div class="section-inner">
					<div class="profile-requirement-row">
						<div class="profile-require-main">
							<div class="profile-require-basic js-matchHeight feed-box" id="basic-requirement">
								<h2 class="section-title">Payment methods</h2>
								<div class="require-table-box editable-block-wraper">
									<span class="profile-job-btn-wraper">
									<a style="display: none" class="profile-job-btn job-requirement-basic-btn" href="javascript:void(0);" onclick="LoadDetail()">
										<span class="fa fa-pencil awesome-icon"></span>
									</a>
									</span>
									<div class="require-table-box-row">
										<div class="col_half left">
											<table class="require-list style_basic">
												<tbody>
													<tr>
														<th>Paypal</th>
														<td>
															<div class="span3 well align-c paypal">
															
																<?php if(isset($return["status"]) && $return["status"] == "Success"):?>
																		Aggrement created
																<?php else: ?>
																<div class="pad">
																  <span class="payment-options paypal-big"></span>
																  <span id="ppButtons">
																	<a href="#" onclick="return false;" id="ppAdd" class="btn btn-success">
																		Add PayPal Account
																	</a>
																  </span>
																	<img  style="display:none;" id="ppLoader" alt="paypal Loading..." src="https://cdn3.f-cdn.com/img/ajax-loader.gif?v=62d3d0c60d4c33ef23dcefb9bc63e3a2&amp;m=6">
																</div>
																<?php endif;?>
																<?php print $return["status"];//var_dump();?>
																<br/>
																<?php print $return["BILLINGAGREEMENTID"];//var_dump();?>
															</div>
		
		
														</td>
													</tr>
												</tbody>
											</table>
										</div>
										<!--/half-->
										
										<!--/half-->
									</div>
									<!--/table-box-->
									<div class="require-note clearfix">
										<table class="require-list style_basic">
											<tbody>
												<tr>
													<th>備考</th>
													<td>
														<div class="editable-block-wraper">
															<div class="editable-block location-note"><span id="spannotes"></span></div>
															<div class="editable-block editting-block editting-note" style="display: none">
																<textarea name="notes_ideals" id='textnotes' rows="4" cols="40">{{$space->Notes}}</textarea>
															</div>
														</div>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
									<!--require-note-->
									<div class="editable-block editting-block editting-private-office" style="display: none">
										<button id="btnSave" class="toggle_button save-button btn ui-button-text-only yellow-button" role="button" >
											<span class="ui-button-text">Save</span>
										</button>
										<button id="btnCancel" class="toggle_button cancel-button btn ui-button-text-only yellow-button" role="button" >
											<span class="ui-button-text">Cancel</span>
										</button>
									</div>
								</div>
							</div>
							<!--/profile-require-basic-->
						</div>
						<!--/profile-require-main-->
						
					</div>
					<!--/row-->
				</div>
				<!--/section-inner-->
			</section>
			
		</div>
		<!--footer-->
		<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/common_footer.php'); ?>
		@include('pages.common_footer')
		<!--/footer-->
	</div>
	<!--/viewport-->
	<!-- Magnific Popup core JS file -->
	<script src="/js/magnific-popup/dist/jquery.magnific-popup.js"></script>

	<script src="<?php echo SITE_URL?>js/chosen/chosen.jquery.min.js" type="text/javascript"></script>
	<script src="<?php echo SITE_URL?>js/chosen/chosen.proto.min.js" type="text/javascript"></script>
	<script src="<?php echo SITE_URL?>js/chosen/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?php echo SITE_URL?>js/address_select.js" type="text/javascript"></script>

	<script type="text/javascript" src="<?php echo SITE_URL?>js/cropimage/js/jquery.form.js"></script>

	<script type="text/javascript">
   
</script>

<script>


    

</script>

<script type="text/javascript">
jQuery.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
    }
});
	
		jQuery(document).on("click" ,  "#ppAdd", function(){
				jQuery.ajax({
						type:"post",
						url:"<?php echo  action('PaypalController@paypalVerifyStep1' , array("577ba8c8db017" , "依田-嘉幸"));?>",
						data:{
							user_id:"577ba8c8db017",
							slug:"依田-嘉幸",
							timestamp:<?php echo time();?>,
						},
						beforeSend:function(){
								jQuery("#ppAdd").hide();
								jQuery("#ppLoader").show();
						},
						success:function(response){
							jQuery("#ppLoader").hide();
								var returnData = jQuery.parseJSON(response);
								if(returnData.status == "success"){
									var url = returnData.url;
									window.location.replace(url);
								}else{
									alert(returnData.message);
									
								}
						},
					})
		});
</script>


</body>
</html>
