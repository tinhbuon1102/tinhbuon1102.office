@include('pages.footer_js')
<script>
//contact list
</script>
<footer class="footer">
	<div class="container">
		<div class="footer-inner">
			<div class="footer-site-links">
				<nav class="footer-site-nav clearfix">
					<div class="col_4">
						<h3>About</h3>
						<ul class="ft-nav">
							<!--<li>
								<a href="#">hOur Officeとは？</a>
							</li>-->
							<li>
								<a href="{{url('how-it-works')}}">ご利用ガイド</a>
							</li>
							<li>
								<a href="{{url('help/guest/price')}}">ご利用料金について</a>
							</li>
                            
						</ul>
					</div>
					
					<div class="col_4">
						<h3>Support</h3>
						<ul class="ft-nav">
							<!--<li>
								<a href="#">FAQ</a>
							</li>-->
							<li>
								<a href="{{url('help')}}">ヘルプ</a>
							</li>
							<li>
								<a href="{{url('/support-center/')}}">サポートセンター</a>
							</li>
						</ul>
					</div>
					<!--/col_4-->
                    <!--/col_4-->
					<div class="col_4">
						<h3>Terms of Service</h3>
						<ul class="ft-nav">
							<li>
								<a href="{{url('/TermCondition/')}}">利用規約</a>
							</li>
							<li>
								<a href="{{url('/PrivacyPolicy/')}}">プライバシーポリシー</a>
							</li>
							<li>
								<a href="{{url('/cancel-policy/')}}">キャンセルポリシー</a>
							</li>
                            
						</ul>
					</div>
					<!--/col_4-->
					<div class="col_4">
						<h3>Get in touch</h3>
						<ul class="ft-nav">
							<li>
								<a href="{{url('/contact-us/')}}">お問い合わせ</a>
							</li>
							<li>
								<a href="{{url('/company-info/')}}">会社概要</a>
							</li>
						</ul>
					</div>
					<!--/col_4-->
				</nav>
			</div>
		</div>
	</div>
</footer>

		@include('pages.index-forms')
		
<script src="<?php echo SITE_URL?>js/remodal/remodal.min.js"></script>
    <script>
	jQuery('[data-remodal-id=modal]').remodal();
	jQuery('[data-remodal-id=modal2]').remodal();
    jQuery('[data-remodal-id=modal3]').remodal();
	</script>
	<script src="{{ URL::asset('js/jquery.validate.js?v=1') }}"></script>
		

<script>

jQuery.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
    }
});

jQuery("#login-form").validate({
			errorPlacement: function(label, element) { 
				label.addClass('form-error');
				label.insertAfter(element);
			},
            submitHandler: function(label){
                login();
            }
		});

        jQuery("#forget-password-form").validate({
            errorPlacement: function(label, element) { 
                label.addClass('form-error');
                label.insertAfter(element);
            },
            submitHandler: function(label){
                forgetPassword();
            }
        });


			
			jQuery("#signup-form").validate({
				  	errorPlacement: function(label, element) { 
						label.addClass('form-error');
						label.insertAfter(element);
			},
			rules: {
			    Email: {
			      required: true,
			      email: true
			    },
				password : {
                    minlength : 5
                },
                password_confirmation : {
                    minlength : 5,
                    equalTo : "#signup-password"
                }
			  },
        submitHandler: function(label){
                             submitForm();
        }

			});
			
function submitForm()
{	 
	 jQuery(".signup-btn").hide();
	 jQuery(".loader-img").show();
	 jQuery(".form-error").hide();
      var jQueryform = jQuery('#signup-form'),
        data1 = jQueryform.serialize(),
        url = jQueryform.attr( "action" );
	  
	   jQuery.ajax({
            type: "POST",
            url : url,
            data : { formData:data1 },
           success: function(data){ // What to do if we succeed
		 if(data.fail) {
			jQuery(".signup-btn").show();
			jQuery(".loader-img").hide();
         jQuery.each(data.errors, function( index, value ) {
			
            var errorDiv = '#'+index+'_error';
          jQuery(errorDiv).show();
            jQuery(errorDiv).empty().append(value); 
			/*console.log(errorDiv);
			jQuery(".commanerror").html(value);
			jQuery(".commanerror").show();*/
          });
          //jQuery('#successMessage').empty();       
        } 
		 if(data.success) {
			
          window.location.href= data.next;
		 //console.log(data.id);
       
		 } //success
    },
    error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
		jQuery(".signup-btn").show();
		jQuery(".loader-img").hide();
        console.log(JSON.stringify(jqXHR));
        console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
    }
          

        },"json");
	}	


function login()
{	 
	 jQuery(".login-bt").hide();
	 jQuery(".loader-img1").show();
	 jQuery(".form-error").hide();
	 jQuery("#login-error").hide();
	 
      var jQueryform = jQuery('#login-form'),
        data1 = jQueryform.serialize(),
        url = jQueryform.attr( "action" );
      
	  
	   jQuery.ajax({
            type: "POST",
            url : url,
            data : { formData:data1 },
           success: function(data){ // What to do if we succeed
		 if(data.fail) {
			jQuery(".login-bt").show();
			jQuery(".loader-img1").hide();
         jQuery.each(data.errors, function( index, value ) {
			
            /*var errorDiv = '#'+index+'_error';
          jQuery(errorDiv).show();
            jQuery(errorDiv).empty().append(value); */
			//console.log(errorDiv);
			/*jQuery(".commanerror").html(value);
			jQuery(".commanerror").show();*/
          });
          //jQuery('#successMessage').empty();       
        } 
		 if(data.success) {
			jQuery(".login-bt").show();
			jQuery(".loader-img1").hide();
			jQuery("#login-error").hide();
			window.location.href= data.next;
		 //console.log(data.id);
       
		 } //success
		 if(data.error)
		 {
		jQuery(".login-bt").show();
		jQuery(".loader-img1").hide();
		jQuery("#login-error").text(data.msg);
		jQuery("#login-error").show();

		 }
		 
    },
    error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
		jQuery(".signup-btn").show();
		jQuery(".loader-img").hide();
        console.log(JSON.stringify(jqXHR));
        console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
    }
          

        },"json");
	}


function forgetPassword()
{    
    //    data : { email:jQueryform.find('input[name=email]').val() },
    jQuery(".login-bt2").hide();
    jQuery(".loader-img2").show();
    jQuery(".form-error").hide();
    jQuery("#login-error2").hide();
    var jQueryform = jQuery('#forget-password-form'),
    data1 = jQueryform.serialize(),
    url = jQueryform.attr("action");
    jQuery.ajax({
        type: "POST",
        url : url,
            data : { formData:data1 },
        success: function(data){ // What to do if we succeed
            if(data.fail) {
                jQuery(".login-bt2").show();
                jQuery(".loader-img2").hide();
                
                //jQuery('#successMessage').empty();       
            } 
            if(data.success) {
                jQuery(".login-bt2").show();
                jQuery(".loader-img2").hide();
                jQuery("#login-error2").hide();
                jQuery("#login-success2").show();
                

            } //success
            if(data.error)
            {
                jQuery(".login-bt2").show();
                jQuery(".loader-img2").hide();
                jQuery("#login-error2").show();
                jQuery("#login-error2").html('');
                jQuery.each(data.errors, function( index, value ) {
                	jQuery("#login-error2").append('<p>'+ value +'</p>');
                });
            }
        },
        error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
            jQuery(".login-bt2").show();
            jQuery(".loader-img2").hide();
            console.log(JSON.stringify(jqXHR));
            console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
        }
    },"json");
}   	
jQuery(window).load(function() {
//画面高さ取得
h = jQuery(window).height();
jQuery(".viewport").css("min-height", h + "px");
});
jQuery(window).resize(function() {
//画面リサイズ時の高さ取得
h = jQuery(window).height();
jQuery(".viewport").css("min-height", h + "px");
});
</script>
</div>
<script src="{{ URL::asset('js/pushy-master/js/pushy.min.js') }}"></script>