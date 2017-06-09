jQuery(document).ready(function($) {
	$('#tabs_wraper').responsiveTabs({
		startCollapsed : 'accordion',
		collapsible : true,
		rotate : false,
		fluidHeight: true,
		click: function(event, tab){
			
		},
		activate: function(event, tab){
			if (tab.selector == '#tab-2' && !$('#tab-2').html())
			{
				$.get(
					SITE_URL + 'admin/partial_tab_2.php',
					function(data) {
						$('#tab-2').html(data);
					}
					
				)
			}
			
			$('#tab2_wraper').show();
			$('#partial_tab_2_form_wraper').hide();
		}
	});
	
	$('body').on('click', '#cancelBasicInfo', function(){
		$('#tab2_wraper').show();
		$('#partial_tab_2_form_wraper').hide();
		$('html,body').animate({
	        scrollTop: $("#tab_button_2").offset().top},
	        'fast');
	})
	
});