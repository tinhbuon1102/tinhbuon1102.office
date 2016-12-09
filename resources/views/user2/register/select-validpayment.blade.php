
<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header_beforelogin.php'); ?>
 @include('pages.header_beforelogin')
<!--/head-->
<body class="selectPage">
<div class="viewport">
<div class="header_wrapper primary-navigation-section">
<header id="header">
<div class="header_container dark">
<div class="logo_container"><a class="logo" href="index.html">Offispo</a></div>
</div>
</header>
</div>
<div class="main-container">
<div id="main" class="container gaf-container">
<div class="add-payment-verified funnel" id="verifyContainer">
<h1 class="page-title">決済情報を入力</h1>
<p class="sub-title small">オフィススペースを予約する際、必要となります。事前に登録しておきましょう。<br/>さらに、事前に登録しておくことで、シェアユーザーからの信頼性があがります。</p>
<div id="paymentMethods" class="row">
<div class="span12 payment-methods-div">
<div class="span4 well align-c credit-card">
<div class="pad">
<img src="../images/form/credit-card.png">
<div class="clearfix"></div>
<a href="#" onclick="return false;" id="ccAdd" class="btn  btn-success">Add Credit Card<!--クレジットカードを追加--></a>
</div><!--/pad-->
</div><!--/span4-->
</div><!--span12-->
<div class="span12 payment-methods-div">
<div class="span4 well align-c paypal">

<div class="pad">
<span class="payment-options paypal-big"></span>
<div class="clearfix"></div>

@if(isset($paypalStatus) && $paypalStatus)	
	<span id="ppButtons">Account Verified</span>
@else
	
	<span id="ppButtons"><a href="#" onclick="return false;" id="ppAdd" class="btn btn-success">Add PayPal Account</a></span>
	<script type="text/javascript">	
		jQuery.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
			}
		});
		<?php if(isset($user)):?>
		jQuery(document).on("click", "#ppAdd", function(){
				jQuery.ajax({
						type:"post",
						url:"<?php echo  action('PaypalController@paypalVerifyStep1');?>",
						data:{
							user_id:"{{$user->id}}",
							timestamp:<?php echo time();?>,
							userEmail:"{{$user->Email}}",
							'returnUrl':"<?php echo  action('PaypalController@signupValidateSuccess');?>",
							'cancelUrl':"<?php echo  action('PaypalController@signupValidateCancel');?>",
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
		<?php endif;?>
</script>
@endif
</div><!--/pad-->


</div><!--/span4-->
</div><!--span12-->
</div><!--/row-->
<div class="row next-step">
<div class="span12 align-r">
<a href="/RentUser/Dashboard/Success">Skip this step</a>
</div>
</div>
</div><!--/add-payment-verified-->
</div><!--/#main-->
</div><!--/main-container-->
<!--footer-->
<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/common_footer.php'); ?>

 @include('pages.common_footer')
<!--/footer-->
</div><!--/viewport-->
</body>
</html>