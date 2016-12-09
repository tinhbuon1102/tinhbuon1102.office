<div class="loader"></div>
<style type="text/css">
	.loader {
	  z-index:1000;
	  top:50%;
	  left:50%;
	  position:fixed;
	  display:none;		
	  border: 16px solid #f3f3f3;
	  border-radius: 50%;
	  border-top: 16px solid #3498db;
	  width: 120px;
	  height: 120px;
	  -webkit-animation: spin 2s linear infinite;
	  animation: spin 2s linear infinite;
	}
</style>	
<?php 
$setupAmount = (isset($recuData['api_txn_Response']['PAYMENTSTATUS']))?$recuData['api_txn_Response']['AMT']:false;	
?>

<script type="text/javascript">
	 jQuery(document).ready(function () {
		// paypal-action-button-script
			//alert("ns_btn ns_actions ns_align-center btn btn-mini btn-info dropdown-toggle");
			
			jQuery.ajaxSetup({
				headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"}
			});	
					
			
			jQuery(".paypal-refund").click(function (e){
					
					
					var transid = jQuery(this).attr("transid");
					var t_id = jQuery("#refd-t_id-"+transid).val();
					var id = jQuery("#refd-id-"+transid).val();
					
					jQuery.ajax({
							type:"post",
							url:"<?php echo action('PaypalController@refundRequest');?>",
							data:{
								"id":id,
								"t_id":t_id ,
								"action":"refund",
								"amount":"<?php echo $setupAmount; ?>",
							},
						success:function( response ){
							data = jQuery.parseJSON(response);
							jQuery(".loader").hide();
							alert(data.message);
							window.location.reload(false); 
						},
						beforeSend:function(){
								jQuery(".loader").show();
						},
						error: function(){
							jQuery(".loader").hide();
							alert("Server error try some time later");
						}
					});
					return false;
			});
			
			
			jQuery(".paypal-reject").click(function (){
					var transid = jQuery(this).attr("transid");
					var t_id = jQuery("#t_id-"+transid).val();
					var id = jQuery("#id-"+transid).val();
					
					
				jQuery.ajax({
					type:"post",
					url:"<?php echo action('PaypalController@rejectRequest');?>",
					data:{
						"id":id,
						"t_id":t_id ,
						"action":"reject",
						"amount":"<?php echo $setupAmount; ?>",
					},//"type":type,"payer_id":payer_id
					success:function( response ){
						data = jQuery.parseJSON(response);
						jQuery(".loader").hide();
						alert(data.message);
						window.location.reload(false); 
						//console.log("success send");
					},
					beforeSend:function(){
							jQuery(".loader").show();
					},
					error: function (request, status, error) {
						jQuery(".loader").hide();
						alert("Server error try some time later");
					}
				});
				return false;
			});
			
			jQuery(".paypal-accept").click(function (){
			
					var transid = jQuery(this).attr("transid");
					var t_id = jQuery("#t_id-"+transid).val();
					var id = jQuery("#id-"+transid).val();
					
				jQuery.ajax({
					type:"post",
					url:"<?php echo action('PaypalController@acceptPaymentRequest');?>",
					data:{
						"id":id,
						"t_id":t_id , 
						"action":"accept",
						"amount":"<?php echo $setupAmount; ?>",
					},//"type":type,"payer_id":payer_id
					success:function( response ){
						data = jQuery.parseJSON(response);
						jQuery(".loader").hide();
						alert(data.message);
						window.location.reload(false); 
					},
					beforeSend:function(){
							jQuery(".loader").show();
							console.log("before send");
					},
					error: function (request, status, error) {
						jQuery(".loader").hide();
						alert("Server error try some time later");
					}
				});
				return false;
			});
				
           
        });
           
</script>