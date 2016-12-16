<div id="footerArea" class="loginform_footer">
<p id="copyright"><a href="http://aventures.jp/" target="_blank"><img src="{{url('/')}}/images/logo-blk.png" alt="Offispo" width="90" height="auto"></a>Copyright © Aventures, Inc. All Rights Reserved.</p>
</div>
</div>
	<script src="{{ URL::asset('js/jquery.validate.js?v=1') }}"></script>
	
	<script>
			$("#frm").validate();
		</script>
                <script>
jQuery(window).load(function() {
//画面高さ取得
h = jQuery(window).height();
jQuery("#NoEnoughHeight").css("min-height", h + "px");
});
jQuery(window).resize(function() {
//画面リサイズ時の高さ取得
h = jQuery(window).height();
jQuery("#NoEnoughHeight").css("min-height", h + "px");
});
</script>