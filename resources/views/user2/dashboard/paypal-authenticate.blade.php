				
				<div class="paypal-message"></div>
				@if(isset($paypalStatus) && !empty($paypalStatus))	
					<li class="PaymentMethods-item form-step">
							<div class="PaymentMethods-details">
								<div class="PaymentMethods-vendor">
									<span class="PaymentMethods-icon payment-icon-paypal"></span>
								</div>
								<div class="PaymentMethods-summary">
									<div class="PaymentMethods-id">
										#<?php echo $paypalStatus["billingId"];?>
									</div>
									<?php if ($user->billings) {?>
										<div class="PaymentMethods-email">{{$user->billings->emailId}}</div>
									<?php }?>
									<!---
									<div class="PrimaryMethod-supplementary">
										#B-05W014323Y430284J
									</div>
									--->
									<div class="form-error"></div>
									<div class="form-success"></div>
								</div>
							</div>
							<div class="PaymentMethods-controls">
								<div class="PaymentMethods-verify">
									<span class="PaymentMethods-verified">
									最終検証
										<i class="fa fa-check-circle" aria-hidden="true"></i>
										<?php echo $paypalStatus["updated_at"];?>
									</span>
								</div>
								<div class="PaymentMethods-remove cancelBillingAgreement" data-agreementid="<?php echo $paypalStatus["billingId"];?>" data-method="gatewayPP" title="Cancel">×</div>
							</div>	
						</li>		

<script type="text/javascript">
jQuery(document).on("click", ".PaymentMethods-remove", function(){
		jQuery.ajax({
				type:"post",
				url:"<?php echo  action('PaypalController@paypalUnauthorize' , array($user->id));?>",
				data:{
					user_id:"{{$user->id}}",
					timestamp:"<?php echo time();?>",
					userEmail:"{{$user->Email}}",
					billingId:"<?php echo $paypalStatus["billingId"];?>",
				},
				beforeSend:function(){
						console.log("loading...");
				},
				success:function(response){
						var data = jQuery.parseJSON(response);
						jQuery(".PaymentMethods-item").hide();
						jQuery(".profile-requirement-row").show();
						jQuery(".paypal-message").html(data.msg);
						if(data.status == "success"){
							jQuery(".paypal-message").addClass("green");
						}
						else{
							jQuery(".paypal-message").addClass("red");
						}
						//alert("payment method removed");
				},
			})
		});
</script>

					@endif
					
					<div class="profile-requirement-row" style="
					@if($paypalStatus)	
						display:none;
					@endif
					">
						<div class="profile-require-main">
							<div class="profile-require-basic js-matchHeight feed-box" id="basic-requirement">
								
								
									<span class="profile-job-btn-wraper">
									<a style="display: none" class="profile-job-btn job-requirement-basic-btn" href="javascript:void(0);" onclick="LoadDetail()">
										<span class="fa fa-pencil awesome-icon"></span>
									</a>
									</span>
									<div class="paypal-button-cover-row">
															
																<?php if(isset($return["status"]) && $return["status"] == "Success"):?>
                                                                <div class="span3 well align-c paypal">
																		Aggrement created
                                                                        </div>
																<?php else: ?>
																<?php endif;?>
                                                                
																<?php // print $return["status"];//var_dump();?>
																<br/>
																<?php //print $return["BILLINGAGREEMENTID"];//var_dump();?>
                                                                
															
									</div>
									<!--require-note-->
								
							</div>
							<!--/profile-require-basic-->
						</div>
						<!--/profile-require-main-->
					</div>
					
				
	<!-- Magnific Popup core JS file -->


<script type="text/javascript">	
		jQuery.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
			}
		});
		jQuery(document).on("click", "#ppAdd", function(){
				jQuery.ajax({
						type:"post",
						url:"<?php echo  action('PaypalController@paypalVerifyStep1');?>",
						data:{
							user_id:"{{$user->id}}",
							timestamp:<?php echo time();?>,
							userEmail:"{{$user->Email}}",
						},
						beforeSend:function(){
								jQuery("#ppAdd").hide();
								jQuery("#ppLoader").show();

						},
						success:function(response){
								//jQuery("#ppLoader").hide();
								var returnData = jQuery.parseJSON(response);
								if(returnData.status == "success"){
									var url = returnData.url;
									window.location.replace(url);
								}
								else{
									alert(returnData.message);
								}
						},
					})
		});
</script>

