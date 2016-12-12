@include('pages.footer_js')
<script>
//contact list
jQuery( function($){
	var wndow_wd = $( window ).width();
	var wndow_ht = $( window ).height();	
	if(wndow_wd<650) {
		$('nav').css("min-height",wndow_ht);
	}
	$( "body" ).on('click', '.nvOpn', function() {
	  $( this ).toggleClass("actv");
	  $( "nav" ).toggle("fast");
	});
		
});
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
								<a href="#">Offispoとは？</a>
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
								<a href="{{url('help/rentuser')}}">HELP</a>
							</li>
							<li>
								<a href="#">サポートセンター</a>
							</li>
						</ul>
					</div>
					<!--/col_4-->
                    <!--/col_4-->
					<div class="col_4">
						<h3>Terms of Service</h3>
						<ul class="ft-nav">
							<li>
								<a href="{{url('/TermCondition/')}}">ご利用規約</a>
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
								<a href="#">お問い合わせ</a>
							</li>
							<li>
								<a href="#">会社概要</a>
							</li>
						</ul>
					</div>
					<!--/col_4-->
				</nav>
			</div>
		</div>
		
	</div>
</footer>
